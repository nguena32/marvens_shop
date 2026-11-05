<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;
use Exception;

/**
 * Repository PDO pour les commandes et leurs lignes d'articles
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
                'order_status' => $orderData['order_status'] ?? 'pending',
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
                'new_status' => $orderData['order_status'] ?? 'pending',
            ]);

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
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
        $order['items'] = $iStmt->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }

    public function findAllPaginated(int $limit = 20, int $offset = 0, ?string $status = null): array
    {
        $sql = "SELECT * FROM orders";
        $params = [];

        if ($status !== null && $status !== '') {
            $sql .= " WHERE order_status = :status";
            $params['status'] = $status;
        }

        $sql .= " ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus(int $orderId, string $newStatus, ?string $comment = null): bool
    {
        $stmt = $this->pdo->prepare("SELECT order_status FROM orders WHERE id = :id");
        $stmt->execute(['id' => $orderId]);
        $curr = $stmt->fetchColumn();

        if ($curr === false) {
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
                'comment' => $comment,
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}
