<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerRepository;
use App\Domain\Entities\Order;
use App\Http\Middleware\AuthMiddleware;
use App\Infrastructure\Storage\FileStorageService;
use App\Infrastructure\MetaCatalogConnector;
use App\Application\Services\CsvImportService;
use App\Application\Services\Theme\ThemeService;
use App\Core\Validator;
use App\Core\Session;
use PDO;

/**
 * Contrôleur d'Administration étendu (Imports, Sécurité, Paramètres)
 */
class AdminController extends Controller
{
    private OrderRepository $orderRepo;
    private ProductRepository $productRepo;
    private CategoryRepository $categoryRepo;
    private CustomerRepository $customerRepo;
    private FileStorageService $storage;
    private CsvImportService $csvImport;
    private MetaCatalogConnector $metaConnector;
    private ThemeService $themeService;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->orderRepo = new OrderRepository($pdo);
        $this->productRepo = new ProductRepository($pdo);
        $this->categoryRepo = new CategoryRepository($pdo);
        $this->customerRepo = new CustomerRepository($pdo);
        $this->storage = new FileStorageService(dirname(__DIR__, 3) . '/storage');
        $this->csvImport = new CsvImportService($this->productRepo, $this->categoryRepo);
        $this->metaConnector = new MetaCatalogConnector();
        $this->themeService = new ThemeService($pdo);
    }

    private function requireAuth(): ?Response
    {
        return AuthMiddleware::check();
    }

    public function dashboard(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $pdo = Database::getConnection();

        // 8.1 Statistiques précises par statut
        $statusCounts = $this->orderRepo->getDashboardCounts();
        
        // 8.5 Définition certifiée du CA : commandes payées OU livrées (MS-BIZ-08 / T-026)
        $commercialStats = $this->orderRepo->getCommercialStats();
        $totalRevenue = $commercialStats['revenue_certified'];

        $totalOrders = $statusCounts['total'];
        $pendingOrders = $statusCounts[Order::STATUS_PENDING] ?? 0;
        $confirmedOrders = $statusCounts[Order::STATUS_CONFIRMED] ?? 0;
        $paymentPendingOrders = $statusCounts[Order::STATUS_PAYMENT_PENDING] ?? 0;
        $paidOrders = $statusCounts[Order::STATUS_PAID] ?? 0;
        $preparingOrders = $statusCounts[Order::STATUS_PREPARING] ?? 0;
        $shippedOrders = $statusCounts[Order::STATUS_SHIPPED] ?? 0;
        $deliveredOrders = $statusCounts[Order::STATUS_DELIVERED] ?? 0;
        $cancelledOrders = $statusCounts[Order::STATUS_CANCELLED] ?? 0;

        $totalProducts = (int) $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();
        $totalCustomers = (int) $this->customerRepo->count();

        // Récupération des articles en stock faible ou critique
        $lowStockStmt = $pdo->query("
            SELECT pv.id, pv.variant_name, pv.stock_quantity, p.name as product_name, p.main_image_url
            FROM product_variants pv
            JOIN products p ON pv.product_id = p.id
            WHERE pv.is_available = 1 AND pv.stock_quantity <= 5
            ORDER BY pv.stock_quantity ASC
            LIMIT 3
        ");
        $lowStockItems = $lowStockStmt ? $lowStockStmt->fetchAll(PDO::FETCH_ASSOC) : [];

        // Filtre de statut optionnel pour le tableau interactif
        $statusFilter = $request->query('status');
        $statusFilter = is_string($statusFilter) && trim($statusFilter) !== '' ? trim($statusFilter) : null;

        $recentOrders = $this->orderRepo->findAllPaginated(10, 0, $statusFilter);

        return $this->render('admin.pages.dashboard', [
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'confirmed_orders' => $confirmedOrders,
            'payment_pending_orders' => $paymentPendingOrders,
            'paid_orders' => $paidOrders,
            'preparing_orders' => $preparingOrders,
            'shipped_orders' => $shippedOrders,
            'delivered_orders' => $deliveredOrders,
            'cancelled_orders' => $cancelledOrders,
            'status_counts' => $statusCounts,
            'total_revenue' => $totalRevenue,
            'revenue_potential' => $commercialStats['revenue_potential'],
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
            'recent_orders' => $recentOrders,
            'low_stock_items' => $lowStockItems,
            'top_products' => $commercialStats['top_products'],
            'current_filter' => $statusFilter,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function orders(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $status = $request->query('status');
        $status = is_string($status) && trim($status) !== '' ? trim($status) : null;
        
        $search = $request->query('search');
        $search = is_string($search) && trim($search) !== '' ? trim($search) : null;

        $paymentStatus = $request->query('payment_status');
        $paymentStatus = is_string($paymentStatus) && trim($paymentStatus) !== '' ? trim($paymentStatus) : null;

        $deliveryMode = $request->query('delivery_mode');
        $deliveryMode = is_string($deliveryMode) && trim($deliveryMode) !== '' ? trim($deliveryMode) : null;

        $dateFrom = $request->query('date_from');
        $dateFrom = is_string($dateFrom) && trim($dateFrom) !== '' ? trim($dateFrom) : null;

        $dateTo = $request->query('date_to');
        $dateTo = is_string($dateTo) && trim($dateTo) !== '' ? trim($dateTo) : null;

        $page = max(1, (int) $request->query('page', 1));
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $orders = $this->orderRepo->findAllAdvanced(
            $limit, 
            $offset, 
            $status, 
            $search, 
            $paymentStatus, 
            $deliveryMode, 
            $dateFrom, 
            $dateTo
        );

        $totalCount = $this->orderRepo->countAdvanced(
            $status, 
            $search, 
            $paymentStatus, 
            $deliveryMode, 
            $dateFrom, 
            $dateTo
        );

        $totalPages = max(1, (int) ceil($totalCount / $limit));

        $statusCounts = $this->orderRepo->getDashboardCounts();

        return $this->render('admin.pages.orders_list', [
            'orders' => $orders,
            'current_status' => $status,
            'current_search' => $search,
            'current_payment_status' => $paymentStatus,
            'current_delivery_mode' => $deliveryMode,
            'current_date_from' => $dateFrom,
            'current_date_to' => $dateTo,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_count' => $totalCount,
            'status_counts' => $statusCounts,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function orderDetail(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $id = (int) ($params['id'] ?? 0);
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return Response::html("<h1>404 — Commande introuvable</h1>", 404);
        }

        $items = $order['items'] ?? [];
        $history = $this->orderRepo->getStatusHistory($id);

        // Récupération de l'historique d'autres commandes de ce client (Module 8.4)
        $previousOrders = $this->customerRepo->getOrdersByCustomer((string)$order['customer_whatsapp']);
        // Filtrer la commande courante
        $previousOrders = array_filter($previousOrders, fn($o) => (int)$o['id'] !== $id);

        $feedback = Session::get('order_feedback');
        Session::remove('order_feedback');

        return $this->render('admin.pages.order_detail', [
            'order' => $order,
            'items' => $items,
            'history' => $history,
            'previous_orders' => $previousOrders,
            'feedback' => $feedback,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function updateOrderStatus(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int) ($params['id'] ?? 0);
        $newStatus = (string) $request->input('order_status');
        $comment = $request->input('comment') ? trim((string) $request->input('comment')) : null;

        $success = $this->orderRepo->updateStatus($id, $newStatus, $comment);
        if ($success) {
            Session::set('order_feedback', [
                'type' => 'success',
                'message' => "Le statut de la commande a été changé avec succès vers : " . Order::getStatusLabel($newStatus)
            ]);
        } else {
            Session::set('order_feedback', [
                'type' => 'error',
                'message' => "Transition de statut interdite par les règles de gestion (MS-BIZ-06)."
            ]);
        }

        return $this->redirect('/admin/commandes/' . $id);
    }

    public function updateOrderPayment(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int) ($params['id'] ?? 0);
        $paymentStatus = (string) $request->input('payment_status');
        $comment = $request->input('payment_note') ? trim((string) $request->input('payment_note')) : null;

        $success = $this->orderRepo->updatePaymentStatus($id, $paymentStatus, $comment);
        if ($success) {
            Session::set('order_feedback', [
                'type' => 'success',
                'message' => "Statut de paiement mis à jour : " . strtoupper($paymentStatus)
            ]);
        } else {
            Session::set('order_feedback', [
                'type' => 'error',
                'message' => "Échec de mise à jour du statut de paiement."
            ]);
        }

        return $this->redirect('/admin/commandes/' . $id);
    }

    /**
     * Module 8.4 : Gestion des clients
     */
    public function customers(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $search = $request->query('search');
        $search = is_string($search) && trim($search) !== '' ? trim($search) : null;

        $page = max(1, (int) $request->query('page', 1));
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $customers = $this->customerRepo->findAll($search, $limit, $offset);
        $totalCount = $this->customerRepo->count($search);
        $totalPages = max(1, (int) ceil($totalCount / $limit));

        return $this->render('admin.pages.customers_list', [
            'customers' => $customers,
            'current_search' => $search,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_count' => $totalCount,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    /**
     * Module 8.4 : Fiche détaillée d'un client et historique des commandes
     */
    public function customerDetail(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $id = (int) ($params['id'] ?? 0);
        $customer = $this->customerRepo->findById($id);

        if (!$customer) {
            return Response::html("<h1>404 — Client introuvable</h1>", 404);
        }

        $orders = $this->customerRepo->getOrdersByCustomer((string)$customer['whatsapp']);

        return $this->render('admin.pages.customer_detail', [
            'customer' => $customer,
            'orders' => $orders,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    /**
     * Module 8.5 : Tableau de bord des Statistiques Commerciales Complètes
     */
    public function statistics(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $period = $request->query('period', 'all');
        $stats = $this->orderRepo->getCommercialStats($period);
        $statusCounts = $this->orderRepo->getDashboardCounts();
        $totalCustomers = $this->customerRepo->count();

        // Produits en promotion active
        $pdo = Database::getConnection();
        $promoStmt = $pdo->query("
            SELECT id, name, price, promotional_price, main_image_url 
            FROM products 
            WHERE promotional_price IS NOT NULL AND promotional_price > 0 AND is_active = 1
            ORDER BY id DESC
        ");
        $activePromos = $promoStmt ? $promoStmt->fetchAll(PDO::FETCH_ASSOC) : [];

        return $this->render('admin.pages.statistics', [
            'stats' => $stats,
            'status_counts' => $statusCounts,
            'total_customers' => $totalCustomers,
            'active_promos' => $activePromos,
            'period' => $period,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function products(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $categoryId = $request->query('category_id') ? (int)$request->query('category_id') : null;
        $search = $request->query('search') ? (string)$request->query('search') : null;
        $status = $request->query('status') ? (string)$request->query('status') : null;

        $products = $this->productRepo->findAllAdmin($categoryId, $search, $status);
        $categories = $this->categoryRepo->findAll();

        $feedback = Session::get('product_feedback');
        Session::remove('product_feedback');

        return $this->render('admin.pages.products_list', [
            'products' => $products,
            'categories' => $categories,
            'current_category' => $categoryId,
            'current_search' => $search,
            'current_status' => $status,
            'feedback' => $feedback,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function createProduct(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $errors = [];
        if ($request->isMethod('POST')) {
            $this->validateCsrf($request);
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|min:2',
                'price' => 'required|numeric',
            ]);

            if ($validator->validate()) {
                $imageFile = $request->file('image');
                $imageUrl = null;
                if ($imageFile && !empty($imageFile['tmp_name'])) {
                    try {
                        $imageUrl = $this->storage->storePublicUpload($imageFile, 'products');
                    } catch (\Exception $e) {
                        // Tolérance
                    }
                }

                $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name']), '-')) . '-' . random_int(100, 999);
                $data['main_image_url'] = $imageUrl;
                $this->productRepo->create($data);

                Session::set('product_feedback', [
                    'type' => 'success',
                    'message' => "Le produit '{$data['name']}' a été créé avec succès."
                ]);

                return $this->redirect('/admin/produits');
            } else {
                $errors = $validator->errors();
            }
        }

        $categories = $this->categoryRepo->findAllActive();
        return $this->render('admin.pages.product_form', [
            'categories' => $categories,
            'product' => [],
            'errors' => $errors,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function editProduct(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $id = (int)($params['id'] ?? 0);
        $product = $this->productRepo->findById($id);
        if (!$product) {
            return Response::html("<h1>404 — Produit introuvable</h1>", 404);
        }

        $categories = $this->categoryRepo->findAllActive();
        return $this->render('admin.pages.product_form', [
            'product' => $product,
            'categories' => $categories,
            'errors' => [],
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function updateProduct(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $product = $this->productRepo->findById($id);
        if (!$product) {
            return Response::html("<h1>404 — Produit introuvable</h1>", 404);
        }

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|min:2',
            'price' => 'required|numeric',
        ]);

        if (!$validator->validate()) {
            $categories = $this->categoryRepo->findAllActive();
            return $this->render('admin.pages.product_form', [
                'product' => array_merge($product, $data),
                'categories' => $categories,
                'errors' => $validator->errors(),
                'csrf_token' => Session::getCsrfToken(),
            ]);
        }

        $imageFile = $request->file('image');
        $imageUrl = $product['main_image_url'];
        if ($imageFile && !empty($imageFile['tmp_name'])) {
            try {
                $imageUrl = $this->storage->storePublicUpload($imageFile, 'products');
            } catch (\Exception $e) {
                // Tolérance
            }
        }

        $slug = !empty($data['slug']) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['slug']), '-')) : $product['slug'];
        if ($slug === '') {
            $slug = $product['slug'];
        }

        $data['slug'] = $slug;
        $data['main_image_url'] = $imageUrl;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;

        $this->productRepo->update($id, $data);

        Session::set('product_feedback', [
            'type' => 'success',
            'message' => "Le produit '{$data['name']}' a été mis à jour avec succès."
        ]);

        return $this->redirect('/admin/produits');
    }

    public function toggleProductStatus(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $this->productRepo->toggleActive($id);

        Session::set('product_feedback', [
            'type' => 'success',
            'message' => "Statut de publication mis à jour avec succès."
        ]);

        return $this->redirect('/admin/produits');
    }

    public function toggleProductFeatured(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $this->productRepo->toggleFeatured($id);

        return $this->redirect('/admin/produits');
    }

    public function deleteProduct(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $this->productRepo->delete($id);

        Session::set('product_feedback', [
            'type' => 'success',
            'message' => "Le produit a été supprimé du catalogue."
        ]);

        return $this->redirect('/admin/produits');
    }

    // ==========================================
    // 6.2 GESTION DES CATÉGORIES
    // ==========================================

    public function categories(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $categories = $this->categoryRepo->findAll();
        $feedback = Session::get('category_feedback');
        Session::remove('category_feedback');

        return $this->render('admin.pages.categories_list', [
            'categories' => $categories,
            'feedback' => $feedback,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function createCategory(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $errors = [];
        if ($request->isMethod('POST')) {
            $this->validateCsrf($request);
            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required|min:2',
            ]);

            if ($validator->validate()) {
                $imageFile = $request->file('image');
                $imageUrl = null;
                if ($imageFile && !empty($imageFile['tmp_name'])) {
                    try {
                        $imageUrl = $this->storage->storePublicUpload($imageFile, 'categories');
                    } catch (\Exception $e) {
                        // Tolérance
                    }
                }

                $slug = !empty($data['slug']) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['slug']), '-')) : '';
                if ($slug === '') {
                    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['name']), '-')) . '-' . random_int(100, 999);
                }

                $data['slug'] = $slug;
                $data['image_url'] = $imageUrl;
                $data['is_active'] = isset($data['is_active']) ? 1 : 0;
                $data['sort_order'] = (int)($data['sort_order'] ?? 0);

                $this->categoryRepo->create($data);

                Session::set('category_feedback', [
                    'type' => 'success',
                    'message' => "La catégorie '{$data['name']}' a été créée avec succès."
                ]);

                return $this->redirect('/admin/categories');
            } else {
                $errors = $validator->errors();
            }
        }

        return $this->render('admin.pages.category_form', [
            'category' => [],
            'errors' => $errors,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function editCategory(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $id = (int)($params['id'] ?? 0);
        $category = $this->categoryRepo->findById($id);
        if (!$category) {
            return Response::html("<h1>404 — Catégorie introuvable</h1>", 404);
        }

        return $this->render('admin.pages.category_form', [
            'category' => $category,
            'errors' => [],
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function updateCategory(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $category = $this->categoryRepo->findById($id);
        if (!$category) {
            return Response::html("<h1>404 — Catégorie introuvable</h1>", 404);
        }

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|min:2',
        ]);

        if (!$validator->validate()) {
            return $this->render('admin.pages.category_form', [
                'category' => array_merge($category, $data),
                'errors' => $validator->errors(),
                'csrf_token' => Session::getCsrfToken(),
            ]);
        }

        $imageFile = $request->file('image');
        $imageUrl = $category['image_url'];
        if ($imageFile && !empty($imageFile['tmp_name'])) {
            try {
                $imageUrl = $this->storage->storePublicUpload($imageFile, 'categories');
            } catch (\Exception $e) {
                // Tolérance
            }
        }

        $slug = !empty($data['slug']) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['slug']), '-')) : $category['slug'];
        if ($slug === '') {
            $slug = $category['slug'];
        }

        $data['slug'] = $slug;
        $data['image_url'] = $imageUrl;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        $this->categoryRepo->update($id, $data);

        Session::set('category_feedback', [
            'type' => 'success',
            'message' => "La catégorie '{$data['name']}' a été mise à jour avec succès."
        ]);

        return $this->redirect('/admin/categories');
    }

    public function toggleCategoryStatus(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $this->categoryRepo->toggleActive($id);

        Session::set('category_feedback', [
            'type' => 'success',
            'message' => "Statut de visibilité de la catégorie mis à jour."
        ]);

        return $this->redirect('/admin/categories');
    }

    public function deleteCategory(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int)($params['id'] ?? 0);
        $this->categoryRepo->delete($id);

        Session::set('category_feedback', [
            'type' => 'success',
            'message' => "La catégorie a été supprimée. Les articles liés sont désormais sans catégorie."
        ]);

        return $this->redirect('/admin/categories');
    }

    public function themes(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $availableThemes = $this->themeService->getAvailableThemes();
        $activeThemeId = $this->themeService->getActiveThemeId();
        $previousThemeId = $this->themeService->getPreviousThemeId();

        $feedback = Session::get('theme_feedback');
        Session::remove('theme_feedback');

        return $this->render('admin.pages.themes_gallery', [
            'themes' => $availableThemes,
            'active_theme' => $activeThemeId,
            'previous_theme' => $previousThemeId,
            'feedback' => $feedback,
        ]);
    }

    public function switchTheme(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $themeId = (string) $request->input('theme');

        try {
            $this->themeService->activateTheme($themeId);
            Session::set('theme_feedback', [
                'type' => 'success',
                'message' => "Le thème a été activé avec succès. Toutes vos données commerciales sont intactes."
            ]);
        } catch (\Exception $e) {
            Session::set('theme_feedback', [
                'type' => 'error',
                'message' => "Erreur lors du changement de thème : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/themes');
    }

    public function rollbackTheme(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        try {
            $this->themeService->rollbackToPreviousTheme();
            Session::set('theme_feedback', [
                'type' => 'success',
                'message' => "Retour au thème précédent effectué avec succès."
            ]);
        } catch (\Exception $e) {
            Session::set('theme_feedback', [
                'type' => 'error',
                'message' => "Impossible de revenir au thème précédent : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/themes');
    }

    public function resetTheme(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        try {
            $this->themeService->resetToDefaultTheme();
            Session::set('theme_feedback', [
                'type' => 'success',
                'message' => "Le thème par défaut (Fashion) a été rétabli avec succès."
            ]);
        } catch (\Exception $e) {
            Session::set('theme_feedback', [
                'type' => 'error',
                'message' => "Erreur lors de la réinitialisation : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/themes');
    }

    /**
     * Module 3 : Affichage du formulaire Paramètres → Apparence et identité visuelle (Personnalisation des Couleurs)
     */
    public function appearanceSettings(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $activeThemeId = $this->themeService->getActiveThemeId();
        $targetThemeId = $request->query('theme') ? (string) $request->query('theme') : $activeThemeId;
        if (!in_array($targetThemeId, ThemeService::ALLOWED_THEMES, true)) {
            $targetThemeId = $activeThemeId;
        }

        $targetTheme = $this->themeService->getTheme($targetThemeId);
        $customization = $this->themeService->getThemeCustomization($targetThemeId);
        $defaultCustomization = $this->themeService->getDefaultCustomization($targetThemeId);

        $feedback = Session::get('appearance_feedback');
        Session::remove('appearance_feedback');

        return $this->render('admin.pages.appearance_settings', [
            'active_tab' => 'appearance',
            'active_theme_id' => $activeThemeId,
            'target_theme' => $targetTheme,
            'target_theme_id' => $targetThemeId,
            'all_themes' => $this->themeService->getAvailableThemes(),
            'customization' => $customization,
            'default_customization' => $defaultCustomization,
            'feedback' => $feedback,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    /**
     * Module 3 : Enregistrement de la personnalisation des couleurs et composants
     */
    public function saveAppearanceSettings(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $themeId = (string) $request->input('theme_id', $this->themeService->getActiveThemeId());
        $postData = $request->all();

        try {
            $this->themeService->saveThemeCustomization($themeId, $postData);
            Session::set('appearance_feedback', [
                'type' => 'success',
                'message' => "Les couleurs et le style d'apparence pour le thème '{$themeId}' ont été enregistrés avec succès. Les modifications s'appliquent immédiatement à la boutique."
            ]);
        } catch (\Exception $e) {
            Session::set('appearance_feedback', [
                'type' => 'error',
                'message' => "Erreur lors de l'enregistrement de l'apparence : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/parametres/apparence?theme=' . urlencode($themeId));
    }

    /**
     * Module 3 : Réinitialisation des couleurs d'un thème à sa palette d'origine
     */
    public function resetAppearanceSettings(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $themeId = (string) $request->input('theme_id', $this->themeService->getActiveThemeId());

        try {
            $this->themeService->resetThemeCustomization($themeId);
            Session::set('appearance_feedback', [
                'type' => 'success',
                'message' => "La palette et le style du thème '{$themeId}' ont été réinitialisés aux valeurs par défaut d'origine."
            ]);
        } catch (\Exception $e) {
            Session::set('appearance_feedback', [
                'type' => 'error',
                'message' => "Erreur lors de la réinitialisation : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/parametres/apparence?theme=' . urlencode($themeId));
    }

    /**
     * Module 4 : Affichage de l'interface de personnalisation des polices d'écriture
     */
    public function typographySettings(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $targetThemeId = (string) $request->query('theme', $this->themeService->getActiveThemeId());
        if (!in_array($targetThemeId, ThemeService::ALLOWED_THEMES, true)) {
            $targetThemeId = $this->themeService->getActiveThemeId();
        }

        $activeThemeId = $this->themeService->getActiveThemeId();
        $targetTheme = $this->themeService->getTheme($targetThemeId);

        $typography = $this->themeService->getThemeTypography($targetThemeId);
        $defaultTypography = $this->themeService->getDefaultTypography($targetThemeId);
        $fontLibrary = $this->themeService->getFontLibrary();

        $feedback = Session::get('typography_feedback');
        Session::remove('typography_feedback');

        return $this->render('admin.pages.typography_settings', [
            'active_tab' => 'typography',
            'active_theme_id' => $activeThemeId,
            'target_theme' => $targetTheme,
            'target_theme_id' => $targetThemeId,
            'all_themes' => $this->themeService->getAvailableThemes(),
            'typography' => $typography,
            'default_typography' => $defaultTypography,
            'font_library' => $fontLibrary,
            'feedback' => $feedback,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    /**
     * Module 4 : Enregistrement de la personnalisation des polices d'écriture
     */
    public function saveTypographySettings(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $themeId = (string) $request->input('theme_id', $this->themeService->getActiveThemeId());
        $postData = $request->all();

        try {
            $this->themeService->saveThemeTypography($themeId, $postData);
            Session::set('typography_feedback', [
                'type' => 'success',
                'message' => "Les polices d'écriture et styles typographiques pour le thème '{$themeId}' ont été enregistrés avec succès. Ils s'appliquent immédiatement à la boutique."
            ]);
        } catch (\Exception $e) {
            Session::set('typography_feedback', [
                'type' => 'error',
                'message' => "Erreur lors de l'enregistrement de la typographie : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/parametres/typographie?theme=' . urlencode($themeId));
    }

    /**
     * Module 4 : Réinitialisation des polices d'écriture d'un thème aux valeurs par défaut
     */
    public function resetTypographySettings(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $themeId = (string) $request->input('theme_id', $this->themeService->getActiveThemeId());

        try {
            $this->themeService->resetThemeTypography($themeId);
            Session::set('typography_feedback', [
                'type' => 'success',
                'message' => "Les polices et styles typographiques du thème '{$themeId}' ont été réinitialisés aux valeurs par défaut d'origine."
            ]);
        } catch (\Exception $e) {
            Session::set('typography_feedback', [
                'type' => 'error',
                'message' => "Erreur lors de la réinitialisation : " . $e->getMessage()
            ]);
        }

        return $this->redirect('/admin/parametres/typographie?theme=' . urlencode($themeId));
    }

    public function showImport(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $report = Session::get('import_report');
        Session::remove('import_report');

        $metaCatalogs = [];
        $metaStatus = $this->metaConnector->getStatus();
        if (!empty($metaStatus['connected'])) {
            $metaCatalogs = $this->metaConnector->getCatalogs();
        }

        $previewProducts = Session::get('meta_preview_products');
        Session::remove('meta_preview_products');

        return $this->render('admin.pages.import', [
            'report' => $report,
            'meta_status' => $metaStatus,
            'meta_catalogs' => $metaCatalogs,
            'meta_preview_products' => $previewProducts,
            'csrf_token' => Session::getCsrfToken(),
        ]);
    }

    public function downloadImportTemplate(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $csv = $this->csvImport->generateTemplateCsv();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="modele_import_produits_marvens.csv"');
        echo $csv;
        exit;
    }

    public function processCsvImport(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $file = $request->file('import_file') ?: $request->file('csv_file');
        if (!$file || empty($file['tmp_name'])) {
            Session::set('import_report', ['errors' => ['Veuillez sélectionner un fichier CSV ou Excel (.xlsx) valide.']]);
            return $this->redirect('/admin/import');
        }

        try {
            $report = $this->csvImport->import($file['tmp_name']);
            Session::set('import_report', $report);
        } catch (\Exception $e) {
            Session::set('import_report', ['errors' => [$e->getMessage()]]);
        }

        return $this->redirect('/admin/import');
    }

    // ==========================================
    // 6.4 IMPORT & SYNCHRONISATION META CATALOG
    // ==========================================

    public function metaConnect(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        if (!$this->metaConnector->isConfigured()) {
            // Mode simulation avec token local pour tester le parcours même sans app Meta validée
            Session::set('meta_access_token', 'EAAB_MOCK_TOKEN_' . bin2hex(random_bytes(8)));
            Session::set('import_report', [
                'created' => 0,
                'updated' => 0,
                'errors' => ["Connexion de démonstration activée avec succès pour le test du catalogue Meta."]
            ]);
            return $this->redirect('/admin/import');
        }

        try {
            $authUrl = $this->metaConnector->getAuthorizationUrl();
            return Response::redirect($authUrl);
        } catch (\Exception $e) {
            Session::set('import_report', ['errors' => [$e->getMessage()]]);
            return $this->redirect('/admin/import');
        }
    }

    public function metaCallback(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $code = (string)$request->query('code');
        $state = (string)$request->query('state');

        try {
            $this->metaConnector->handleOAuthCallback($code, $state);
            Session::set('import_report', [
                'created' => 0,
                'updated' => 0,
                'errors' => ["Authentification Meta réussie. Vos catalogues sont désormais accessibles."]
            ]);
        } catch (\Exception $e) {
            Session::set('import_report', ['errors' => ["Erreur OAuth Meta : " . $e->getMessage()]]);
        }

        return $this->redirect('/admin/import');
    }

    public function metaPreview(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $catalogId = (string)$request->query('catalog_id');
        $products = $this->metaConnector->fetchCatalogProducts($catalogId);
        Session::set('meta_preview_products', $products);

        return $this->redirect('/admin/import');
    }

    public function metaSync(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $catalogId = (string)$request->input('catalog_id');
        $products = $this->metaConnector->fetchCatalogProducts($catalogId);

        $created = 0;
        $updated = 0;
        $errors = [];

        // Cache des catégories
        $categories = $this->categoryRepo->findAll();
        $catMap = [];
        foreach ($categories as $cat) {
            $catMap[strtolower($cat['name'])] = (int)$cat['id'];
        }

        foreach ($products as $mp) {
            $name = trim((string)$mp['name']);
            $retailerId = trim((string)($mp['retailer_id'] ?? ''));
            $price = (int)$mp['price'];
            $promoPrice = !empty($mp['sale_price']) ? (int)$mp['sale_price'] : null;

            // Catégorie
            $catId = null;
            if (!empty($mp['category'])) {
                $cLower = strtolower($mp['category']);
                if (isset($catMap[$cLower])) {
                    $catId = $catMap[$cLower];
                } else {
                    $catId = $this->categoryRepo->create([
                        'name' => $mp['category'],
                        'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $mp['category']), '-')),
                        'sort_order' => 10,
                        'is_active' => 1,
                    ]);
                    $catMap[$cLower] = $catId;
                }
            }

            // Recherche par meta_product_id ou SKU
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM products WHERE meta_product_id = :mid OR sku = :sku LIMIT 1");
            $stmt->execute(['mid' => $retailerId, 'sku' => $retailerId]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                $this->productRepo->update((int)$existing['id'], [
                    'category_id' => $catId ?: $existing['category_id'],
                    'name' => $name,
                    'slug' => $existing['slug'],
                    'sku' => $retailerId ?: $existing['sku'],
                    'description' => $mp['description'] ?? $existing['description'],
                    'price' => $price,
                    'promotional_price' => $promoPrice,
                    'main_image_url' => $mp['image_url'] ?? $existing['main_image_url'],
                    'is_active' => $existing['is_active'],
                    'is_featured' => $existing['is_featured'],
                ]);
                $updated++;
            } else {
                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-')) . '-' . random_int(100, 999);
                $this->productRepo->create([
                    'category_id' => $catId,
                    'name' => $name,
                    'slug' => $slug,
                    'sku' => $retailerId,
                    'description' => $mp['description'] ?? null,
                    'price' => $price,
                    'promotional_price' => $promoPrice,
                    'main_image_url' => $mp['image_url'] ?? null,
                    'is_active' => 1,
                    'is_featured' => 0,
                    'meta_product_id' => $retailerId,
                ]);
                $created++;
            }
        }

        Session::set('import_report', [
            'created' => $created,
            'updated' => $updated,
            'errors' => $errors,
        ]);

        return $this->redirect('/admin/import');
    }

    public function metaDisconnect(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $this->metaConnector->disconnect();
        Session::set('import_report', [
            'created' => 0,
            'updated' => 0,
            'errors' => ["Compte Meta déconnecté avec succès."]
        ]);

        return $this->redirect('/admin/import');
    }
}
