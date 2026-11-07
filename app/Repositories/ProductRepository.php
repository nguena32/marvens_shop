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

    public function findAllActive(?int $categoryId = null, ?string $search = null, ?int $minPrice = null, ?int $maxPrice = null, ?string $filter = null): array
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

        if ($minPrice !== null && $minPrice > 0) {
            $sql .= " AND (CASE WHEN p.promotional_price IS NOT NULL AND p.promotional_price > 0 THEN p.promotional_price ELSE p.price END >= :min_price)";
            $params['min_price'] = (int)$minPrice;
        }

        if ($maxPrice !== null && $maxPrice > 0) {
            $sql .= " AND (CASE WHEN p.promotional_price IS NOT NULL AND p.promotional_price > 0 THEN p.promotional_price ELSE p.price END <= :max_price)";
            $params['max_price'] = (int)$maxPrice;
        }

        if ($filter === 'promotions') {
            $sql .= " AND p.promotional_price IS NOT NULL AND p.promotional_price < p.price";
        } elseif ($filter === 'populaires' || $filter === 'featured') {
            $sql .= " AND p.is_featured = 1";
        }

        if ($filter === 'nouveautes') {
            $sql .= " ORDER BY p.created_at DESC, p.id DESC";
        } elseif ($filter === 'price_asc') {
            $sql .= " ORDER BY (CASE WHEN p.promotional_price IS NOT NULL AND p.promotional_price > 0 THEN p.promotional_price ELSE p.price END) ASC";
        } elseif ($filter === 'price_desc') {
            $sql .= " ORDER BY (CASE WHEN p.promotional_price IS NOT NULL AND p.promotional_price > 0 THEN p.promotional_price ELSE p.price END) DESC";
        } else {
            $sql .= " ORDER BY p.is_featured DESC, p.created_at DESC";
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $paramKey => $paramVal) {
            $stmt->bindValue(':' . $paramKey, $paramVal, is_int($paramVal) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllAdmin(?int $categoryId = null, ?string $search = null, ?string $status = null): array
    {
        $sql = "SELECT p.*, c.name as category_name,
                       (SELECT COUNT(*) FROM product_variants pv WHERE pv.product_id = p.id) as variants_count,
                       (SELECT COALESCE(SUM(pv.stock_quantity), 0) FROM product_variants pv WHERE pv.product_id = p.id) as total_stock
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE 1=1";
        $params = [];

        if ($categoryId !== null && $categoryId > 0) {
            $sql .= " AND p.category_id = :cat_id";
            $params['cat_id'] = $categoryId;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= " AND (p.name LIKE :search OR p.description LIKE :search OR p.sku LIKE :search)";
            $params['search'] = '%' . trim($search) . '%';
        }

        if ($status === 'active') {
            $sql .= " AND p.is_active = 1";
        } elseif ($status === 'inactive') {
            $sql .= " AND p.is_active = 0";
        } elseif ($status === 'promo') {
            $sql .= " AND p.promotional_price IS NOT NULL AND p.promotional_price > 0";
        } elseif ($status === 'featured') {
            $sql .= " AND p.is_featured = 1";
        }

        $sql .= " ORDER BY p.created_at DESC, p.id DESC";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $paramKey => $paramVal) {
            $stmt->bindValue(':' . $paramKey, $paramVal, is_int($paramVal) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findSimilar(int $productId, ?int $categoryId, int $limit = 4): array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_active = 1 AND p.id != :p_id";
        $params = ['p_id' => $productId];

        if ($categoryId !== null) {
            $sql .= " AND p.category_id = :cat_id";
            $params['cat_id'] = $categoryId;
        }

        $sql .= " ORDER BY p.is_featured DESC, p.created_at DESC LIMIT " . (int)$limit;

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $paramKey => $paramVal) {
            $stmt->bindValue(':' . $paramKey, $paramVal, is_int($paramVal) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
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

        // Récupérer les médias associés (images et vidéos)
        $product['media'] = $this->getMedia((int)$product['id']);

        return $product;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT p.*, c.name as category_name 
                                      FROM products p 
                                      LEFT JOIN categories c ON p.category_id = c.id 
                                      WHERE p.id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            return null;
        }

        $product['variants'] = [];
        try {
            $vStmt = $this->pdo->prepare("SELECT * FROM product_variants WHERE product_id = :p_id ORDER BY id ASC");
            $vStmt->execute(['p_id' => $id]);
            $product['variants'] = $vStmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Tolérance si la table product_variants n'est pas encore initialisée
        }

        $product['media'] = $this->getMedia($id);

        return $product;
    }

    public function getMedia(int $productId): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM product_media WHERE product_id = :pid ORDER BY sort_order ASC, id ASC");
            $stmt->execute(['pid' => $productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function addMedia(int $productId, string $mediaType, string $mediaUrl, ?string $thumbnailUrl = null, int $sortOrder = 0): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO product_media (product_id, media_type, media_url, thumbnail_url, sort_order) 
                                      VALUES (:pid, :type, :url, :thumb, :sort)");
        $stmt->execute([
            'pid' => $productId,
            'type' => $mediaType,
            'url' => $mediaUrl,
            'thumb' => $thumbnailUrl,
            'sort' => $sortOrder,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function deleteMedia(int $mediaId, int $productId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM product_media WHERE id = :id AND product_id = :pid");
        return $stmt->execute(['id' => $mediaId, 'pid' => $productId]);
    }

    public function setMainImageFromMedia(int $productId, int $mediaId): bool
    {
        $stmt = $this->pdo->prepare("SELECT media_url FROM product_media WHERE id = :mid AND product_id = :pid LIMIT 1");
        $stmt->execute(['mid' => $mediaId, 'pid' => $productId]);
        $url = $stmt->fetchColumn();
        if ($url) {
            $uStmt = $this->pdo->prepare("UPDATE products SET main_image_url = :url WHERE id = :pid");
            return $uStmt->execute(['url' => $url, 'pid' => $productId]);
        }
        return false;
    }

    public function skuExists(string $sku, ?int $excludeProductId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM products WHERE sku = :sku";
        $params = ['sku' => $sku];
        if ($excludeProductId !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeProductId;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    public function generateUniqueSku(string $name, ?int $categoryId = null): string
    {
        $words = preg_split('/[\s\-_]+/', strtoupper(trim($name)));
        $prefix = '';
        foreach ($words as $w) {
            $wClean = preg_replace('/[^A-Z0-9]/', '', $w);
            if (!empty($wClean)) {
                $prefix .= substr($wClean, 0, 3);
            }
            if (strlen($prefix) >= 4) {
                break;
            }
        }
        if (strlen($prefix) < 3) {
            $prefix = 'PRD';
        }
        $prefix = substr($prefix, 0, 4);

        $attempts = 0;
        do {
            $randomNum = str_pad((string)random_int(100, 9999), 4, '0', STR_PAD_LEFT);
            $skuCandidate = $prefix . '-' . $randomNum;
            $attempts++;
        } while ($this->skuExists($skuCandidate) && $attempts < 50);

        if ($this->skuExists($skuCandidate)) {
            $skuCandidate = 'MS-' . date('ym') . '-' . random_int(1000, 9999);
        }

        return $skuCandidate;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO products (category_id, name, slug, sku, description, price, promotional_price, main_image_url, is_active, is_featured, meta_product_id)
                VALUES (:category_id, :name, :slug, :sku, :description, :price, :promotional_price, :main_image_url, :is_active, :is_featured, :meta_product_id)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'category_id' => !empty($data['category_id']) ? (int) $data['category_id'] : null,
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

        $productId = (int) $this->pdo->lastInsertId();

        if (!empty($data['variants']) && is_array($data['variants'])) {
            $this->syncVariants($productId, $data['variants']);
        }

        return $productId;
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
        $success = $stmt->execute([
            'id' => $id,
            'category_id' => !empty($data['category_id']) ? (int) $data['category_id'] : null,
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

        if (isset($data['variants']) && is_array($data['variants'])) {
            $this->syncVariants($id, $data['variants']);
        }

        return $success;
    }

    public function toggleActive(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE products SET is_active = CASE WHEN is_active = 1 THEN 0 ELSE 1 END WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function toggleFeatured(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE products SET is_featured = CASE WHEN is_featured = 1 THEN 0 ELSE 1 END WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        // Supprimer d'abord les variantes
        $vStmt = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = :id");
        $vStmt->execute(['id' => $id]);

        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function syncVariants(int $productId, array $variants): void
    {
        // Supprimer les anciennes variantes pour reconstruire
        $delStmt = $this->pdo->prepare("DELETE FROM product_variants WHERE product_id = :pid");
        $delStmt->execute(['pid' => $productId]);

        $insStmt = $this->pdo->prepare("INSERT INTO product_variants 
            (product_id, variant_name, size, color, price_override, stock_quantity, is_available)
            VALUES (:pid, :name, :size, :color, :price, :stock, :available)");

        foreach ($variants as $v) {
            $name = trim((string)($v['variant_name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $insStmt->execute([
                'pid' => $productId,
                'name' => $name,
                'size' => !empty($v['size']) ? trim((string)$v['size']) : null,
                'color' => !empty($v['color']) ? trim((string)$v['color']) : null,
                'price' => !empty($v['price_override']) ? (int)$v['price_override'] : null,
                'stock' => isset($v['stock_quantity']) ? (int)$v['stock_quantity'] : 0,
                'available' => isset($v['is_available']) ? (int)$v['is_available'] : 1,
            ]);
        }
    }
}
