<?php
declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Entité Métier Produit
 */
class Product
{
    private ?int $id;
    private ?int $categoryId;
    private string $name;
    private string $slug;
    private ?string $sku;
    private ?string $description;
    private int $price; // Montant entier en FCFA
    private ?int $promotionalPrice;
    private ?string $mainImageUrl;
    private bool $isActive;
    private bool $isFeatured;
    private ?string $metaProductId;

    public function __construct(
        string $name,
        string $slug,
        int $price,
        ?int $id = null,
        ?int $categoryId = null,
        ?string $sku = null,
        ?string $description = null,
        ?int $promotionalPrice = null,
        ?string $mainImageUrl = null,
        bool $isActive = true,
        bool $isFeatured = false,
        ?string $metaProductId = null
    ) {
        $this->id = $id;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->slug = $slug;
        $this->sku = $sku;
        $this->description = $description;
        $this->price = max(0, $price);
        $this->promotionalPrice = ($promotionalPrice !== null && $promotionalPrice > 0) ? $promotionalPrice : null;
        $this->mainImageUrl = $mainImageUrl;
        $this->isActive = $isActive;
        $this->isFeatured = $isFeatured;
        $this->metaProductId = $metaProductId;
    }

    public function getId(): ?int { return $this->id; }
    public function getCategoryId(): ?int { return $this->categoryId; }
    public function getName(): string { return $this->name; }
    public function getSlug(): string { return $this->slug; }
    public function getSku(): ?string { return $this->sku; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): int { return $this->price; }
    public function getPromotionalPrice(): ?int { return $this->promotionalPrice; }
    public function getMainImageUrl(): ?string { return $this->mainImageUrl; }
    public function isActive(): bool { return $this->isActive; }
    public function isFeatured(): bool { return $this->isFeatured; }
    public function getMetaProductId(): ?string { return $this->metaProductId; }

    public function getEffectivePrice(): int
    {
        return ($this->promotionalPrice !== null && $this->promotionalPrice < $this->price)
            ? $this->promotionalPrice
            : $this->price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'promotional_price' => $this->promotionalPrice,
            'effective_price' => $this->getEffectivePrice(),
            'main_image_url' => $this->mainImageUrl,
            'is_active' => $this->isActive ? 1 : 0,
            'is_featured' => $this->isFeatured ? 1 : 0,
            'meta_product_id' => $this->metaProductId,
        ];
    }
}
