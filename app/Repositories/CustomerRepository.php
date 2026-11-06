<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;
use Exception;

/**
 * Repository PDO pour la gestion des clients (Module 8.4)
 */
class CustomerRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Normalise un numéro WhatsApp (uniquement chiffres)
     */
    public static function normalizePhone(string $phone): string
    {
        return preg_replace('/[^0-9]/', '', $phone) ?? '';
    }

    /**
     * Enregistre ou met à jour les informations d'un client lors d'une commande
     */
    public function recordCustomerFromOrder(array $orderData): int
    {
        $rawPhone = $orderData['customer_whatsapp'] ?? '';
        $phone = self::normalizePhone($rawPhone);
        if ($phone === '') {
            $phone = $rawPhone;
        }

        $name = trim($orderData['customer_name'] ?? '');
        $city = $orderData['delivery_city'] ?? null;
        $district = $orderData['delivery_district'] ?? null;
        $address = $orderData['delivery_address'] ?? null;
        $amount = (int) ($orderData['total_amount'] ?? 0);

        // Recherche du client par son numéro WhatsApp normalisé
        $stmt = $this->pdo->prepare("SELECT id, orders_count, total_spent FROM customers WHERE whatsapp = :phone LIMIT 1");
        $stmt->execute(['phone' => $phone]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $customerId = (int) $existing['id'];
            $newCount = (int) $existing['orders_count'] + 1;
            $newTotal = (int) $existing['total_spent'] + $amount;

            $updateStmt = $this->pdo->prepare("
                UPDATE customers 
                SET name = :name,
                    city = COALESCE(:city, city),
                    district = COALESCE(:district, district),
                    address = COALESCE(:address, address),
                    orders_count = :count,
                    total_spent = :spent,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :id
            ");
            $updateStmt->execute([
                'name' => $name,
                'city' => $city,
                'district' => $district,
                'address' => $address,
                'count' => $newCount,
                'spent' => $newTotal,
                'id' => $customerId,
            ]);
            return $customerId;
        }

        // Création d'un nouveau client
        $insertStmt = $this->pdo->prepare("
            INSERT INTO customers (name, whatsapp, city, district, address, orders_count, total_spent)
            VALUES (:name, :phone, :city, :district, :address, 1, :spent)
        ");
        $insertStmt->execute([
            'name' => $name,
            'phone' => $phone,
            'city' => $city,
            'district' => $district,
            'address' => $address,
            'spent' => $amount,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Recherche et liste paginée des clients avec filtres
     */
    public function findAll(?string $search = null, int $limit = 50, int $offset = 0): array
    {
        $sql = "SELECT * FROM customers";
        $params = [];

        if ($search !== null && trim($search) !== '') {
            $cleanSearch = trim($search);
            $cleanNumeric = self::normalizePhone($cleanSearch);
            $sql .= " WHERE name LIKE :search OR whatsapp LIKE :searchExact";
            $params['search'] = "%{$cleanSearch}%";
            $params['searchExact'] = "%{$cleanNumeric}%";
        }

        $sql .= " ORDER BY updated_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Compte total des clients (avec filtre optionnel)
     */
    public function count(?string $search = null): int
    {
        $sql = "SELECT COUNT(*) FROM customers";
        $params = [];

        if ($search !== null && trim($search) !== '') {
            $cleanSearch = trim($search);
            $cleanNumeric = self::normalizePhone($cleanSearch);
            $sql .= " WHERE name LIKE :search OR whatsapp LIKE :searchExact";
            $params['search'] = "%{$cleanSearch}%";
            $params['searchExact'] = "%{$cleanNumeric}%";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Récupère un client par son ID
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM customers WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $cust = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cust ?: null;
    }

    /**
     * Récupère l'historique complet des commandes d'un client par son numéro WhatsApp
     */
    public function getOrdersByCustomer(string $whatsapp): array
    {
        $phone = self::normalizePhone($whatsapp);
        $stmt = $this->pdo->prepare("
            SELECT * FROM orders 
            WHERE customer_whatsapp = :raw OR customer_whatsapp = :norm OR customer_whatsapp LIKE :likeNorm
            ORDER BY created_at DESC
        ");
        $stmt->execute([
            'raw' => $whatsapp,
            'norm' => $phone,
            'likeNorm' => "%{$phone}%",
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
