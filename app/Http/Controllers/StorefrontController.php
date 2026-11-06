<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Core\View;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Application\Services\CartService;
use App\Application\Services\Theme\ThemeService;
use App\Core\Config;

/**
 * Contrôleur du Storefront Public (Vitrine, Catalogue, Fiches)
 * Entièrement dynamique selon le thème sélectionné par le commerçant
 */
class StorefrontController extends Controller
{
    private ProductRepository $productRepo;
    private CategoryRepository $categoryRepo;
    private CartService $cartService;
    private ThemeService $themeService;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->productRepo = new ProductRepository($pdo);
        $this->categoryRepo = new CategoryRepository($pdo);
        $this->cartService = new CartService($this->productRepo);
        $this->themeService = new ThemeService($pdo);
    }

    /**
     * Rendu enveloppé dans le layout de storefront adaptatif
     */
    private function renderStorefront(string $pageView, array $data, ?string $overrideTheme = null, bool $previewMode = false): Response
    {
        $theme = $overrideTheme ? $this->themeService->getTheme($overrideTheme) : $this->themeService->getActiveTheme();
        if (!$theme) {
            $theme = $this->themeService->getActiveTheme();
        }

        $cartCalc = $this->cartService->getCartCalculation();
        $data['theme'] = $theme;
        $data['cart_count'] = $cartCalc['count'];
        $data['shop_name'] = Config::get('app.name', 'Marvens Shop');
        $data['preview_mode'] = $previewMode;

        // Rendu de la vue intérieure de la page
        $content = View::render($pageView, $data);
        $data['content'] = $content;

        // Rendu du layout global
        $html = View::render('storefront.partials.layout', $data);
        return Response::html($html);
    }

    public function home(Request $request): Response
    {
        $products = $this->productRepo->findAllActive();
        $categories = $this->categoryRepo->findAllActive();

        return $this->renderStorefront('storefront.pages.home', [
            'title' => 'Accueil',
            'active_tab' => 'home',
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function catalog(Request $request): Response
    {
        $search = $request->query('q');
        $catId = $request->query('cat') ? (int) $request->query('cat') : null;

        $products = $this->productRepo->findAllActive($catId, $search);
        $categories = $this->categoryRepo->findAllActive();

        return $this->renderStorefront('storefront.pages.catalog', [
            'title' => 'Catalogue complet',
            'active_tab' => 'catalog',
            'products' => $products,
            'categories' => $categories,
            'current_cat' => $catId,
            'search_query' => $search,
        ]);
    }

    public function product(Request $request, array $params): Response
    {
        $slug = $params['slug'] ?? '';
        $product = $this->productRepo->findBySlug($slug);

        if (!$product || empty($product['is_active'])) {
            return Response::html("<h1>404 — Produit introuvable</h1>", 404);
        }

        return $this->renderStorefront('storefront.pages.product', [
            'title' => $product['name'],
            'active_tab' => 'product',
            'product' => $product,
        ]);
    }

    /**
     * Prévisualisation dynamique d'un thème avant activation
     */
    public function previewTheme(Request $request, array $params): Response
    {
        $themeId = $params['theme'] ?? 'fashion';
        $products = $this->productRepo->findAllActive();
        $categories = $this->categoryRepo->findAllActive();

        return $this->renderStorefront('storefront.pages.home', [
            'title' => 'Prévisualisation Thème ' . ucfirst($themeId),
            'active_tab' => 'home',
            'products' => $products,
            'categories' => $categories,
        ], $themeId, true);
    }
}
