<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;
use Exception;
use App\Domain\Entities\Order;

/**
 * Repository PDO pour les commandes et leurs lignes d'articles
 * Module 8.1, 8.2, 8.3 & 8.5
 */
class OrderRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createWithItems(array $orderData, array $items): int
    {
        $this->pdo->beginTransaction();
        try {
            $sql = "INSERT INTO orders (
                        order_number, customer_name, customer_whatsapp, delivery_mode, 
                        delivery_city, delivery_district, delivery_address, delivery_cost, 
                        total_amount, order_status, payment_status, payment_mode, customer_notes
                    ) VALUES (
                        :order_number, :customer_name, :customer_whatsapp, :delivery_mode, 
                        :delivery_city, :delivery_district, :delivery_address, :delivery_cost, 
                        :total_amount, :order_status, :payment_status, :payment_mode, :customer_notes
                    )";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'order_number' => $orderData['order_number'],
                'customer_name' => $orderData['customer_name'],
                'customer_whatsapp' => $orderData['customer_whatsapp'],
                'delivery_mode' => $orderData['delivery_mode'] ?? 'delivery',
                'delivery_city' => $orderData['delivery_city'] ?? null,
                'delivery_district' => $orderData['delivery_district'] ?? null,
                'delivery_address' => $orderData['delivery_address'] ?? null,
                'delivery_cost' => (int) ($orderData['delivery_cost'] ?? 0),
                'total_amount' => (int) $orderData['total_amount'],
                'order_status' => $orderData['order_status'] ?? Order::STATUS_PENDING,
                'payment_status' => $orderData['payment_status'] ?? 'unpaid',
                'payment_mode' => $orderData['payment_mode'] ?? 'cash_on_delivery',
                'customer_notes' => $orderData['customer_notes'] ?? null,
            ]);

            $orderId = (int) $this->pdo->lastInsertId();

            // Insertion des lignes d'articles
            $itemSql = "INSERT INTO order_items (order_id, product_id, product_name, variant_info, unit_price, quantity, subtotal)
                        VALUES (:order_id, :product_id, :product_name, :variant_info, :unit_price, :quantity, :subtotal)";
            $itemStmt = $this->pdo->prepare($itemSql);

            foreach ($items as $item) {
                $itemStmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'variant_info' => $item['variant_info'] ?? null,
                    'unit_price' => (int) $item['unit_price'],
                    'quantity' => (int) $item['quantity'],
                    'subtotal' => (int) ($item['unit_price'] * $item['quantity']),
                ]);
            }

            // Historique initial
            $histSql = "INSERT INTO order_status_history (order_id, previous_status, new_status, comment)
                        VALUES (:order_id, NULL, :new_status, 'Création initiale de la commande')";
            $histStmt = $this->pdo->prepare($histSql);
            $histStmt->execute([
                'order_id' => $orderId,
                'new_status' => $orderData['order_status'] ?? Order::STATUS_PENDING,
            ]);

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return null;
        }

        $iStmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :id");
        $iStmt->execute(['id' => $order['id']]);
        $order['items'] = $iStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return $order;
    }

    public function findByOrderNumber(string $orderNumber): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE order_number = :num LIMIT 1");
        $stmt->execute(['num' => $orderNumber]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return null;
        }

        $iStmt = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = :id");
        $iStmt->execute(['id' => $order['id']]);
        $order['items'] = $iStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return $order;
    }

    /**
     * Recherche avancée, filtrage et pagination des commandes (Module 8.2)
     */
    public function findAllAdvanced(
        int $limit = 50, 
        int $offset = 0, 
        ?string $status = null, 
        ?string $search = null, 
        ?string $paymentStatus = null,
        ?string $deliveryMode = null,
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): array {
        $sql = "SELECT * FROM orders WHERE 1=1";
        $params = [];

        if ($status !== null && $status !== '') {
            $sql .= " AND order_status = :status";
            $params['status'] = $status;
        }

        if ($paymentStatus !== null && $paymentStatus !== '') {
            $sql .= " AND payment_status = :payment_status";
            $params['payment_status'] = $paymentStatus;
        }

        if ($deliveryMode !== null && $deliveryMode !== '') {
            $sql .= " AND delivery_mode = :delivery_mode";
            $params['delivery_mode'] = $deliveryMode;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= " AND (order_number LIKE :search OR customer_name LIKE :search OR customer_whatsapp LIKE :search)";
            $params['search'] = '%' . trim($search) . '%';
        }

        if ($dateFrom !== null && $dateFrom !== '') {
            $sql .= " AND created_at >= :date_from";
            $params['date_from'] = $dateFrom . ' 00:00:00';
        }

        if ($dateTo !== null && $dateTo !== '') {
            $sql .= " AND created_at <= :date_to";
            $params['date_to'] = $dateTo . ' 23:59:59';
        }

        $sql .= " ORDER BY created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function countAdvanced(
        ?string $status = null, 
        ?string $search = null, 
        ?string $paymentStatus = null,
        ?string $deliveryMode = null,
        ?string $dateFrom = null,
        ?string $dateTo = null
    ): int {
        $sql = "SELECT COUNT(*) FROM orders WHERE 1=1";
        $params = [];

        if ($status !== null && $status !== '') {
            $sql .= " AND order_status = :status";
            $params['status'] = $status;
        }

        if ($paymentStatus !== null && $paymentStatus !== '') {
            $sql .= " AND payment_status = :payment_status";
            $params['payment_status'] = $paymentStatus;
        }

        if ($deliveryMode !== null && $deliveryMode !== '') {
            $sql .= " AND delivery_mode = :delivery_mode";
            $params['delivery_mode'] = $deliveryMode;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= " AND (order_number LIKE :search OR customer_name LIKE :search OR customer_whatsapp LIKE :search)";
            $params['search'] = '%' . trim($search) . '%';
        }

        if ($dateFrom !== null && $dateFrom !== '') {
            $sql .= " AND created_at >= :date_from";
            $params['date_from'] = $dateFrom . ' 00:00:00';
        }

        if ($dateTo !== null && $dateTo !== '') {
            $sql .= " AND created_at <= :date_to";
            $params['date_to'] = $dateTo . ' 23:59:59';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findAllPaginated(int $limit = 20, int $offset = 0, ?string $status = null): array
    {
        return $this->findAllAdvanced($limit, $offset, $status);
    }

    /**
     * Mise à jour du statut de commande avec vérification de transition et journalisation
     */
    public function updateStatus(int $orderId, string $newStatus, ?string $comment = null): bool
    {
        $stmt = $this->pdo->prepare("SELECT order_status FROM orders WHERE id = :id");
        $stmt->execute(['id' => $orderId]);
        $curr = $stmt->fetchColumn();

        if ($curr === false) {
            return false;
        }

        if (!Order::canTransition((string)$curr, $newStatus)) {
            return false;
        }

        $this->pdo->beginTransaction();
        try {
            $uStmt = $this->pdo->prepare("UPDATE orders SET order_status = :status WHERE id = :id");
            $uStmt->execute(['status' => $newStatus, 'id' => $orderId]);

            $hStmt = $this->pdo->prepare("INSERT INTO order_status_history (order_id, previous_status, new_status, comment)
                                          VALUES (:id, :prev, :new, :comment)");
            $hStmt->execute([
                'id' => $orderId,
                'prev' => $curr,
                'new' => $newStatus,
                'comment' => $comment ?: "Changement de statut vers " . Order::getStatusLabel($newStatus),
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Mise à jour manuelle du statut de paiement (Module 8.2 & 7.9)
     */
    public function updatePaymentStatus(int $orderId, string $paymentStatus, ?string $paymentNote = null): bool
    {
        $allowed = [Order::PAYMENT_UNPAID, Order::PAYMENT_PENDING, Order::PAYMENT_PAID, Order::PAYMENT_REFUNDED];
        if (!in_array($paymentStatus, $allowed, true)) {
            return false;
        }

        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("UPDATE orders SET payment_status = :pstatus WHERE id = :id");
            $stmt->execute([
                'pstatus' => $paymentStatus,
                'id' => $orderId,
            ]);

            $hStmt = $this->pdo->prepare("INSERT INTO order_status_history (order_id, previous_status, new_status, comment)
                                          VALUES (:id, NULL, :new, :comment)");
            $hStmt->execute([
                'id' => $orderId,
                'new' => 'payment_' . $paymentStatus,
                'comment' => "Mise à jour du statut de paiement : {$paymentStatus}" . ($paymentNote ? " ({$paymentNote})" : ""),
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Récupère l'historique complet des statuts d'une commande
     */
    public function getStatusHistory(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_status_history WHERE order_id = :id ORDER BY changed_at DESC");
        $stmt->execute(['id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Statistiques du Dashboard (Module 8.1 & 8.5)
     */
    public function getDashboardCounts(): array
    {
        $counts = [
            'total' => 0,
            Order::STATUS_PENDING => 0,
            Order::STATUS_CONFIRMED => 0,
            Order::STATUS_PAYMENT_PENDING => 0,
            Order::STATUS_PAID => 0,
            Order::STATUS_PREPARING => 0,
            Order::STATUS_SHIPPED => 0,
            Order::STATUS_DELIVERED => 0,
            Order::STATUS_CANCELLED => 0,
        ];

        $stmt = $this->pdo->query("SELECT order_status, COUNT(*) as cnt FROM orders GROUP BY order_status");
        if ($stmt) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $st = (string) $row['order_status'];
                $c = (int) $row['cnt'];
                $counts[$st] = $c;
                $counts['total'] += $c;
            }
        }

        return $counts;
    }

    /**
     * Statistiques commerciales avancées (Module 8.5)
     * - CA par commandes payées ou livrées (Définition rigoureuse MS-BIZ-08 / T-026)
     * - Nombre de commandes par période
     * - Top produits commandés
     */
    public function getCommercialStats(?string $period = 'all'): array
    {
        // 1. Chiffre d'affaires certifié (commandes payées OU livrées, non annulées)
        $caStmt = $this->pdo->query("
            SELECT COALESCE(SUM(total_amount), 0) 
            FROM orders 
            WHERE (payment_status = 'paid' OR order_status = 'delivered') 
              AND order_status != 'cancelled'
        ");
        $revenueCertified = (int) ($caStmt ? $caStmt->fetchColumn() : 0);

        // Chiffre d'affaires potentiel (toutes commandes non annulées)
        $caPotStmt = $this->pdo->query("
            SELECT COALESCE(SUM(total_amount), 0) 
            FROM orders 
            WHERE order_status != 'cancelled'
        ");
        $revenuePotential = (int) ($caPotStmt ? $caPotStmt->fetchColumn() : 0);

        // 2. Produits les plus commandés (Top 10)
        $topStmt = $this->pdo->query("
            SELECT 
                oi.product_id,
                oi.product_name,
                oi.variant_info,
                SUM(oi.quantity) as total_quantity,
                SUM(oi.subtotal) as total_volume
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE o.order_status != 'cancelled'
            GROUP BY oi.product_name, oi.variant_info
            ORDER BY total_quantity DESC
            LIMIT 10
        ");
        $topProducts = $topStmt ? $topStmt->fetchAll(PDO::FETCH_ASSOC) : [];

        // 3. Suivi des paiements
        $payStmt = $this->pdo->query("
            SELECT 
                payment_status, 
                COUNT(*) as count_orders, 
                COALESCE(SUM(total_amount), 0) as sum_amount 
            FROM orders 
            GROUP BY payment_status
        ");
        $paymentTracking = $payStmt ? $payStmt->fetchAll(PDO::FETCH_ASSOC) : [];

        // 4. Suivi des livraisons
        $delivStmt = $this->pdo->query("
            SELECT 
                delivery_mode, 
                order_status, 
                COUNT(*) as count_orders 
            FROM orders 
            GROUP BY delivery_mode, order_status
        ");
        $deliveryTracking = $delivStmt ? $delivStmt->fetchAll(PDO::FETCH_ASSOC) : [];

        // 5. Évolution par période (derniers 30 jours ou par mois)
        $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        $dateCondition = ($driver === 'sqlite') 
            ? "created_at >= datetime('now', '-30 days')"
            : "created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";

        $trendsStmt = $this->pdo->query("
            SELECT 
                SUBSTR(created_at, 1, 10) as order_day, 
                COUNT(*) as total_orders, 
                SUM(CASE WHEN payment_status = 'paid' OR order_status = 'delivered' THEN total_amount ELSE 0 END) as day_revenue
            FROM orders
            WHERE {$dateCondition}
            GROUP BY SUBSTR(created_at, 1, 10)
            ORDER BY order_day DESC
            LIMIT 30
        ");
        $dailyTrends = [];
        if ($trendsStmt) {
            $dailyTrends = $trendsStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [
            'revenue_certified' => $revenueCertified,
            'revenue_potential' => $revenuePotential,
            'top_products' => $topProducts,
            'payment_tracking' => $paymentTracking,
            'delivery_tracking' => $deliveryTracking,
            'daily_trends' => $dailyTrends,
        ];
    }
}
