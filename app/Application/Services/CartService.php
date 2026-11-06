<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Core\Session;
use App\Repositories\ProductRepository;

/**
 * Service de gestion du Panier côté serveur
 * Règle MS-BIZ-03 : Les prix et totaux sont TOUJOURS recalculés depuis la base de données.
 */
class CartService
{
    private ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getCartItems(): array
    {
        Session::start();
        return Session::get('cart', []);
    }

    public function addItem(int $productId, int $quantity = 1, ?string $variantInfo = null): bool
    {
        if ($quantity <= 0) {
            return false;
        }

        $product = $this->productRepo->findById($productId);
        if (!$product || empty($product['is_active'])) {
            return false;
        }

        Session::start();
        $cart = Session::get('cart', []);

        $itemKey = $productId . '_' . ($variantInfo ?? 'default');

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            $cart[$itemKey] = [
                'product_id' => $productId,
                'name' => $product['name'],
                'slug' => $product['slug'],
                'main_image_url' => $product['main_image_url'],
                'image' => $product['main_image_url'],
                'variant_info' => $variantInfo,
                'quantity' => $quantity,
            ];
        }

        Session::set('cart', $cart);
        return true;
    }

    public function updateQuantity(string $itemKey, int $quantity): void
    {
        Session::start();
        $cart = Session::get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$itemKey]);
        } elseif (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] = $quantity;
        }

        Session::set('cart', $cart);
    }

    public function removeItem(string $itemKey): void
    {
        Session::start();
        $cart = Session::get('cart', []);
        unset($cart[$itemKey]);
        Session::set('cart', $cart);
    }

    public function clear(): void
    {
        Session::start();
        Session::remove('cart');
    }

    /**
     * Recalcul certifié serveur de l'ensemble du panier
     */
    public function getCartCalculation(): array
    {
        $rawItems = $this->getCartItems();
        $validatedItems = [];
        $subtotal = 0;

        foreach ($rawItems as $key => $item) {
            $product = $this->productRepo->findById((int) $item['product_id']);
            if (!$product || empty($product['is_active'])) {
                // Le produit a été dépublié ou supprimé entre temps
                continue;
            }

            // Prix effectif en base (promo prioritaire si existante et inférieure)
            $unitPrice = (!empty($product['promotional_price']) && $product['promotional_price'] < $product['price'])
                ? (int) $product['promotional_price']
                : (int) $product['price'];

            $lineTotal = $unitPrice * (int) $item['quantity'];
            $subtotal += $lineTotal;

            $validatedItems[$key] = array_merge($item, [
                'key' => (string)$key,
                'unit_price' => $unitPrice,
                'price' => $unitPrice,
                'line_total' => $lineTotal,
                'total' => $lineTotal,
                'subtotal' => $lineTotal,
                'product_name' => $product['name'],
                'variant_name' => $item['variant_info'] ?? null,
                'name' => $product['name'],
                'image' => $item['main_image_url'] ?? $product['main_image_url'],
            ]);
        }

        return [
            'items' => $validatedItems,
            'count' => array_sum(array_column($validatedItems, 'quantity')),
            'subtotal' => $subtotal,
        ];
    }
}
