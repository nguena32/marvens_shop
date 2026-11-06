<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Repositories\OrderRepository;
use App\Application\Services\CartService;
use App\Core\Config;
use RuntimeException;

/**
 * Service orchestrateur de checkout et persistance de commande
 * Règles MS-BIZ-04 (Persistance avant WhatsApp) & MS-BIZ-05 (Indépendance WhatsApp)
 */
class CheckoutService
{
    private OrderRepository $orderRepo;
    private CartService $cartService;

    public function __construct(OrderRepository $orderRepo, CartService $cartService)
    {
        $this->orderRepo = $orderRepo;
        $this->cartService = $cartService;
    }

    public function processCheckout(array $customerData): array
    {
        $calc = $this->cartService->getCartCalculation();
        if (empty($calc['items'])) {
            throw new RuntimeException("Votre panier est vide. Impossible de valider la commande.");
        }

        // Calcul des frais de livraison selon la configuration dynamique (Section 5.3)
        $deliveryMode = $customerData['delivery_mode'] ?? 'delivery';
        $settingsService = new \App\Application\Services\SettingsService();
        if ($deliveryMode === 'pickup') {
            $deliveryCost = 0;
        } else {
            $district = $customerData['delivery_district'] ?? null;
            $deliveryCost = $settingsService->calculateDeliveryFee($district, $calc['subtotal']);
        }
        $totalAmount = $calc['subtotal'] + $deliveryCost;

        // Génération d'une référence unique immuable : #CMD-YYYYMMDD-XXXX
        $orderNumber = sprintf('CMD-%s-%04d', date('Ymd'), random_int(1000, 9999));

        $orderData = [
            'order_number' => $orderNumber,
            'customer_name' => trim($customerData['customer_name']),
            'customer_whatsapp' => trim($customerData['customer_whatsapp']),
            'delivery_mode' => $deliveryMode,
            'delivery_city' => $customerData['delivery_city'] ?? 'Douala',
            'delivery_district' => $customerData['delivery_district'] ?? null,
            'delivery_address' => $customerData['delivery_address'] ?? null,
            'delivery_date' => !empty($customerData['delivery_date']) ? trim($customerData['delivery_date']) : null,
            'delivery_cost' => $deliveryCost,
            'total_amount' => $totalAmount,
            'order_status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_mode' => $customerData['payment_mode'] ?? 'cash_on_delivery',
            'customer_notes' => $customerData['customer_notes'] ?? null,
        ];

        // Formatage des lignes d'articles
        $items = [];
        foreach ($calc['items'] as $item) {
            $items[] = [
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'variant_info' => $item['variant_info'] ?? null,
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
            ];
        }

        // Persistance atomique dans la base de données
        $orderId = $this->orderRepo->createWithItems($orderData, $items);

        // Enregistrement / mise à jour du profil client (Module 8.4)
        try {
            $customerRepo = new \App\Repositories\CustomerRepository(\App\Core\Database::getConnection());
            $customerRepo->recordCustomerFromOrder($orderData);
        } catch (\Throwable $e) {
            // Tolérance si table non migrée ou indisponible
        }

        // Vider le panier après succès
        $this->cartService->clear();

        // Construction du message WhatsApp encodé
        $whatsappUrl = $this->generateWhatsAppLink($orderData, $items);

        return [
            'order_id' => $orderId,
            'order_number' => $orderNumber,
            'total_amount' => $totalAmount,
            'whatsapp_url' => $whatsappUrl,
        ];
    }

    public function generateWhatsAppLink(array $orderData, array $items): string
    {
        $settingsService = new \App\Application\Services\SettingsService();
        $shopInfo = $settingsService->getShopInfo();
        $shopPhone = !empty($shopInfo['whatsapp_number']) ? $shopInfo['whatsapp_number'] : Config::get('app.whatsapp_number', '237699000000');
        // Nettoyage du numéro de téléphone (uniquement chiffres)
        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$shopPhone);

        $lines = [];
        $lines[] = "👋 Bonjour, je viens de passer une commande sur votre boutique en ligne !";
        $lines[] = "";
        $lines[] = "📋 Référence : *" . $orderData['order_number'] . "*";
        $lines[] = "👤 Client : " . $orderData['customer_name'];
        $lines[] = "📱 WhatsApp : " . $orderData['customer_whatsapp'];
        
        $deliveryDetails = ($orderData['delivery_mode'] === 'pickup') 
            ? 'Retrait en boutique' 
            : 'Livraison à domicile';
        if (!empty($orderData['delivery_city']) || !empty($orderData['delivery_district'])) {
            $locationParts = array_filter([$orderData['delivery_district'] ?? null, $orderData['delivery_city'] ?? null]);
            $deliveryDetails .= ' (' . implode(', ', $locationParts) . ')';
        }
        $lines[] = "🚚 Réception : " . $deliveryDetails;

        if (!empty($orderData['delivery_address']) && $orderData['delivery_mode'] !== 'pickup') {
            $lines[] = "📍 Adresse/Repère : " . $orderData['delivery_address'];
        }
        if (!empty($orderData['delivery_date'])) {
            $formattedDate = date('d/m/Y', strtotime($orderData['delivery_date']));
            $labelDate = ($orderData['delivery_mode'] === 'pickup') ? "📅 Date de retrait souhaitée : " : "📅 Date de livraison souhaitée : ";
            $lines[] = $labelDate . "*" . $formattedDate . "*";
        }
        if (!empty($orderData['payment_mode'])) {
            $paymentModeLabel = match($orderData['payment_mode']) {
                'cash_on_delivery' => 'Paiement à la livraison',
                'orange_money' => 'Orange Money',
                'mtn_momo' => 'MTN Mobile Money',
                default => $orderData['payment_mode']
            };
            $lines[] = "💳 Mode de règlement : " . $paymentModeLabel;
        }
        if (!empty($orderData['customer_notes'])) {
            $lines[] = "📝 Instructions : " . $orderData['customer_notes'];
        }

        $lines[] = "";
        $lines[] = "🛒 Articles commandés :";

        foreach ($items as $it) {
            $var = !empty($it['variant_info']) ? " (" . $it['variant_info'] . ")" : "";
            $lines[] = "- " . $it['quantity'] . "x " . $it['product_name'] . $var . " : " . number_format($it['unit_price'] * $it['quantity'], 0, ',', ' ') . " FCFA";
        }

        $lines[] = "";
        if (!empty($orderData['delivery_cost'])) {
            $lines[] = "Frais de livraison : " . number_format($orderData['delivery_cost'], 0, ',', ' ') . " FCFA";
        }
        $lines[] = "💰 *TOTAL À PAYER : " . number_format($orderData['total_amount'], 0, ',', ' ') . " FCFA*";
        $lines[] = "";
        $lines[] = "Merci de me confirmer la disponibilité et le créneau de livraison !";

        $message = implode("\n", $lines);
        return "https://wa.me/" . $cleanPhone . "?text=" . rawurlencode($message);
    }
}
