<?php
declare(strict_types=1);

namespace App\Domain\Themes;

/**
 * Entité/Modèle de Domaine représentant la configuration et les métadonnées d'un Thème
 */
class Theme
{
    private string $id;
    private string $name;
    private string $description;
    private string $previewImage;
    private array $primaryColors;
    private array $features;
    private string $catalogStyle;
    private string $productCardStyle;
    private string $navigationStyle;
    private string $productPageStyle;
    private string $cartStyle;
    private string $homeStyle;
    private array $tailwindColors;
    private array $typography;
    private string $buttonStyle;
    private string $cardStyle;
    private string $layoutStyle;

    public function __construct(
        string $id,
        string $name,
        string $description,
        string $previewImage,
        array $primaryColors,
        array $features,
        string $catalogStyle,
        string $productCardStyle,
        string $navigationStyle,
        string $productPageStyle,
        string $cartStyle,
        string $homeStyle,
        array $tailwindColors = [],
        array $typography = [],
        string $buttonStyle = 'rounded-xl',
        string $cardStyle = 'rounded-2xl border',
        string $layoutStyle = 'modern-fluid'
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->previewImage = $previewImage;
        $this->primaryColors = $primaryColors;
        $this->features = $features;
        $this->catalogStyle = $catalogStyle;
        $this->productCardStyle = $productCardStyle;
        $this->navigationStyle = $navigationStyle;
        $this->productPageStyle = $productPageStyle;
        $this->cartStyle = $cartStyle;
        $this->homeStyle = $homeStyle;
        $this->tailwindColors = $tailwindColors;
        $this->typography = $typography;
        $this->buttonStyle = $buttonStyle;
        $this->cardStyle = $cardStyle;
        $this->layoutStyle = $layoutStyle;
    }

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPreviewImage(): string { return $this->previewImage; }
    public function getPrimaryColors(): array { return $this->primaryColors; }
    public function getFeatures(): array { return $this->features; }
    public function getCatalogStyle(): string { return $this->catalogStyle; }
    public function getProductCardStyle(): string { return $this->productCardStyle; }
    public function getNavigationStyle(): string { return $this->navigationStyle; }
    public function getProductPageStyle(): string { return $this->productPageStyle; }
    public function getCartStyle(): string { return $this->cartStyle; }
    public function getHomeStyle(): string { return $this->homeStyle; }
    public function getTailwindColors(): array { return $this->tailwindColors; }
    public function getTypography(): array { return $this->typography; }
    public function getButtonStyle(): string { return $this->buttonStyle; }
    public function getCardStyle(): string { return $this->cardStyle; }
    public function getLayoutStyle(): string { return $this->layoutStyle; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'preview_image' => $this->previewImage,
            'primary_colors' => $this->primaryColors,
            'features' => $this->features,
            'catalog_style' => $this->catalogStyle,
            'product_card_style' => $this->productCardStyle,
            'navigation_style' => $this->navigationStyle,
            'product_page_style' => $this->productPageStyle,
            'cart_style' => $this->cartStyle,
            'home_style' => $this->homeStyle,
            'tailwind_colors' => $this->tailwindColors,
            'typography' => $this->typography,
            'button_style' => $this->buttonStyle,
            'card_style' => $this->cardStyle,
            'layout_style' => $this->layoutStyle,
        ];
    }
}
