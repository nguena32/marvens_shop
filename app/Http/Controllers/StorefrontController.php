<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Application\Services\CartService;
use App\Core\Config;

/**
 * Contrôleur du Storefront Public (Vitrine, Catalogue, Fiches)
 */
class StorefrontController extends Controller
{
    private ProductRepository $productRepo;
    private CategoryRepository $categoryRepo;
    private CartService $cartService;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->productRepo = new ProductRepository($pdo);
        $this->categoryRepo = new CategoryRepository($pdo);
        $this->cartService = new CartService($this->productRepo);
    }

    public function home(Request $request): Response
    {
        $products = $this->productRepo->findAllActive();
        $categories = $this->categoryRepo->findAllActive();
        $cartCalc = $this->cartService->getCartCalculation();

        return $this->render('themes.fashion.pages.home', [
            'products' => $products,
            'categories' => $categories,
            'cart_count' => $cartCalc['count'],
            'shop_name' => Config::get('app.name', 'Marvens Shop'),
        ]);
    }

    public function catalog(Request $request): Response
    {
        $search = $request->query('q');
        $catId = $request->query('cat') ? (int) $request->query('cat') : null;

        $products = $this->productRepo->findAllActive($catId, $search);
        $categories = $this->categoryRepo->findAllActive();
        $cartCalc = $this->cartService->getCartCalculation();

        return $this->render('themes.fashion.pages.catalog', [
            'products' => $products,
            'categories' => $categories,
            'current_cat' => $catId,
            'search_query' => $search,
            'cart_count' => $cartCalc['count'],
        ]);
    }

    public function product(Request $request, array $params): Response
    {
        $slug = $params['slug'] ?? '';
        $product = $this->productRepo->findBySlug($slug);

        if (!$product || empty($product['is_active'])) {
            return Response::html("<h1>404 — Produit introuvable</h1>", 404);
        }

        $cartCalc = $this->cartService->getCartCalculation();

        return $this->render('themes.fashion.pages.product', [
            'product' => $product,
            'cart_count' => $cartCalc['count'],
        ]);
    }
}
