<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Core\Validator;
use App\Core\View;
use App\Core\Config;
use App\Repositories\ProductRepository;
use App\Repositories\OrderRepository;
use App\Application\Services\CartService;
use App\Application\Services\CheckoutService;
use App\Application\Services\Theme\ThemeService;
use App\Core\Session;
use Exception;

/**
 * Contrôleur du Panier, de la validation de commande et de la confirmation
 * Intègre le système de thèmes actif
 */
class CartController extends Controller
{
    private ProductRepository $productRepo;
    private OrderRepository $orderRepo;
    private CartService $cartService;
    private CheckoutService $checkoutService;
    private ThemeService $themeService;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->productRepo = new ProductRepository($pdo);
        $this->orderRepo = new OrderRepository($pdo);
        $this->cartService = new CartService($this->productRepo);
        $this->checkoutService = new CheckoutService($this->orderRepo, $this->cartService);
        $this->themeService = new ThemeService($pdo);
    }

    private function renderStorefront(string $pageView, array $data): Response
    {
        $theme = $this->themeService->getActiveTheme();
        $cartCalc = $this->cartService->getCartCalculation();
        $themeId = $theme->getId();
        $customization = $this->themeService->getThemeCustomization($themeId);
        $typography = $this->themeService->getThemeTypography($themeId);
        $dynamicCss = $this->themeService->generateCssVariables($customization, $typography);
        $googleFontsUrl = $this->themeService->getGoogleFontsUrl($typography);

        $settingsService = new \App\Application\Services\SettingsService();
        $shopInfo = $settingsService->getShopInfo();
        $analytics = $settingsService->getAnalyticsSettings();

        $data['csrf_token'] = Session::getCsrfToken();
        $data['theme'] = $theme;
        $data['theme_customization'] = $customization;
        $data['theme_typography'] = $typography;
        $data['dynamic_css'] = $dynamicCss;
        $data['google_fonts_url'] = $googleFontsUrl;
        $data['cart_count'] = $cartCalc['count'];
        $data['shop_name'] = $shopInfo['shop_name'] ?? Config::get('app.name', 'Marvens Shop');
        $data['shop_info'] = $shopInfo;
        $data['analytics'] = $analytics;

        $content = View::render($pageView, $data);
        $data['content'] = $content;

        $html = View::render('storefront.partials.layout', $data);
        return Response::html($html);
    }

    public function index(Request $request): Response
    {
        $calc = $this->cartService->getCartCalculation();
        return $this->renderStorefront('storefront.pages.cart', [
            'title' => 'Panier d\'achats',
            'cart' => $calc,
        ]);
    }

    public function add(Request $request): Response
    {
        $this->validateCsrf($request);

        $productId = (int) $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));
        $variant = $request->input('variant');

        $this->cartService->addItem($productId, $quantity, $variant ? (string) $variant : null);

        // Si requête AJAX
        if ($request->isMethod('POST') && $request->input('ajax')) {
            $calc = $this->cartService->getCartCalculation();
            return $this->json(['success' => true, 'count' => $calc['count']]);
        }

        return $this->redirect('/panier');
    }

    public function update(Request $request): Response
    {
        $this->validateCsrf($request);
        $itemKey = (string) $request->input('item_key');
        $quantity = (int) $request->input('quantity', 1);

        $this->cartService->updateQuantity($itemKey, $quantity);
        return $this->redirect('/panier');
    }

    public function remove(Request $request): Response
    {
        $this->validateCsrf($request);
        $itemKey = (string) $request->input('item_key');
        $this->cartService->removeItem($itemKey);
        return $this->redirect('/panier');
    }

    public function showCheckout(Request $request): Response
    {
        $calc = $this->cartService->getCartCalculation();
        if (empty($calc['items'])) {
            return $this->redirect('/panier');
        }

        $errors = Session::get('checkout_errors', []);
        $oldInput = Session::get('checkout_old', []);
        Session::remove('checkout_errors');
        Session::remove('checkout_old');

        $settingsService = new \App\Application\Services\SettingsService();
        $deliverySettings = $settingsService->getDeliverySettings();

        return $this->renderStorefront('storefront.pages.checkout', [
            'title' => 'Validation de commande',
            'cart' => $calc,
            'errors' => $errors,
            'old' => $oldInput,
            'delivery_settings' => $deliverySettings,
        ]);
    }

    public function processCheckout(Request $request): Response
    {
        $token = $request->input('_csrf_token');
        if (!Session::validateCsrfToken($token)) {
            Session::set('checkout_errors', ['global' => ['Votre session a expiré ou le jeton de sécurité est invalide. Veuillez soumettre à nouveau votre commande.']]);
            Session::set('checkout_old', $request->all());
            return $this->redirect('/checkout');
        }

        $data = $request->all();
        $validator = Validator::make($data, [
            'customer_name' => 'required|min:2',
            'customer_whatsapp' => 'required|min:8',
            'delivery_mode' => 'required|in:delivery,pickup',
            'delivery_city' => 'required|min:2',
        ]);

        if ($validator->fails()) {
            Session::set('checkout_errors', $validator->getErrors());
            Session::set('checkout_old', $data);
            return $this->redirect('/checkout');
        }

        try {
            $result = $this->checkoutService->processCheckout($data);
            return $this->redirect('/commande/confirmation/' . $result['order_number']);
        } catch (Exception $e) {
            Session::set('checkout_errors', ['global' => [$e->getMessage()]]);
            Session::set('checkout_old', $data);
            return $this->redirect('/checkout');
        }
    }

    public function confirmation(Request $request, array $params): Response
    {
        $orderNumber = $params['order_number'] ?? '';
        $order = $this->orderRepo->findByOrderNumber($orderNumber);

        if (!$order) {
            return Response::html("<h1>404 — Commande introuvable</h1>", 404);
        }

        $items = $order['items'] ?? [];
        $whatsappUrl = $this->checkoutService->generateWhatsAppLink($order, $items);

        return $this->renderStorefront('storefront.pages.order_confirmation', [
            'title' => 'Confirmation de commande',
            'order' => $order,
            'items' => $items,
            'whatsapp_url' => $whatsappUrl,
        ]);
    }
}
