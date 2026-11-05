<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

/**
 * Repository PDO pour les produits et variantes
 */
class ProductRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllActive(?int $categoryId = null, ?string $search = null): array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_active = 1";
        $params = [];

        if ($categoryId !== null) {
            $sql .= " AND p.category_id = :cat_id";
            $params['cat_id'] = $categoryId;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= " AND (p.name LIKE :search OR p.description LIKE :search OR p.sku LIKE :search)";
            $params['search'] = '%' . trim($search) . '%';
        }

        $sql .= " ORDER BY p.is_featured DESC, p.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare("SELECT p.*, c.name as category_name 
                                      FROM products p 
                                      LEFT JOIN categories c ON p.category_id = c.id 
                                      WHERE p.slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null;
        }

        // Récupérer les variantes associées
        $vStmt = $this->pdo->prepare("SELECT * FROM product_variants WHERE product_id = :p_id AND is_available = 1");
        $vStmt->execute(['p_id' => $product['id']]);
        $product['variants'] = $vStmt->fetchAll(PDO::FETCH_ASSOC);

        return $product;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO products (category_id, name, slug, sku, description, price, promotional_price, main_image_url, is_active, is_featured, meta_product_id)
                VALUES (:category_id, :name, :slug, :sku, :description, :price, :promotional_price, :main_image_url, :is_active, :is_featured, :meta_product_id)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => (int) $data['price'],
            'promotional_price' => !empty($data['promotional_price']) ? (int) $data['promotional_price'] : null,
            'main_image_url' => $data['main_image_url'] ?? null,
            'is_active' => isset($data['is_active']) ? (int) $data['is_active'] : 1,
            'is_featured' => isset($data['is_featured']) ? (int) $data['is_featured'] : 0,
            'meta_product_id' => $data['meta_product_id'] ?? null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE products SET 
                    category_id = :category_id,
                    name = :name,
                    slug = :slug,
                    sku = :sku,
                    description = :description,
                    price = :price,
                    promotional_price = :promotional_price,
                    main_image_url = :main_image_url,
                    is_active = :is_active,
                    is_featured = :is_featured
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => (int) $data['price'],
            'promotional_price' => !empty($data['promotional_price']) ? (int) $data['promotional_price'] : null,
            'main_image_url' => $data['main_image_url'] ?? null,
            'is_active' => isset($data['is_active']) ? (int) $data['is_active'] : 1,
            'is_featured' => isset($data['is_featured']) ? (int) $data['is_featured'] : 0,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
