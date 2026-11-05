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
use App\Domain\Entities\Order;
use App\Http\Middleware\AuthMiddleware;
use App\Infrastructure\Storage\FileStorageService;
use App\Infrastructure\MetaCatalogConnector;
use App\Application\Services\CsvImportService;
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
    private FileStorageService $storage;
    private CsvImportService $csvImport;
    private MetaCatalogConnector $metaConnector;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->orderRepo = new OrderRepository($pdo);
        $this->productRepo = new ProductRepository($pdo);
        $this->categoryRepo = new CategoryRepository($pdo);
        $this->storage = new FileStorageService(dirname(__DIR__, 3) . '/storage');
        $this->csvImport = new CsvImportService($this->productRepo, $this->categoryRepo);
        $this->metaConnector = new MetaCatalogConnector();
    }

    private function requireAuth(): ?Response
    {
        return AuthMiddleware::check();
    }

    public function dashboard(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $pdo = Database::getConnection();
        $totalOrders = (int) $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $pendingOrders = (int) $pdo->query("SELECT COUNT(*) FROM orders WHERE order_status = 'pending'")->fetchColumn();
        $totalRevenue = (int) $pdo->query("SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE payment_status = 'paid'")->fetchColumn();
        $totalProducts = (int) $pdo->query("SELECT COUNT(*) FROM products WHERE is_active = 1")->fetchColumn();

        $recentOrders = $this->orderRepo->findAllPaginated(5, 0);

        return $this->render('admin.pages.dashboard', [
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'total_revenue' => $totalRevenue,
            'total_products' => $totalProducts,
            'recent_orders' => $recentOrders,
        ]);
    }

    public function orders(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $status = $request->query('status');
        $orders = $this->orderRepo->findAllPaginated(50, 0, $status ? (string)$status : null);

        return $this->render('admin.pages.orders_list', [
            'orders' => $orders,
            'current_status' => $status,
        ]);
    }

    public function orderDetail(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $id = (int) ($params['id'] ?? 0);
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            return Response::html("<h1>404 — Commande introuvable</h1>", 404);
        }

        $iStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = :id");
        $iStmt->execute(['id' => $id]);
        $items = $iStmt->fetchAll(PDO::FETCH_ASSOC);

        $hStmt = $pdo->prepare("SELECT * FROM order_status_history WHERE order_id = :id ORDER BY changed_at DESC");
        $hStmt->execute(['id' => $id]);
        $history = $hStmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->render('admin.pages.order_detail', [
            'order' => $order,
            'items' => $items,
            'history' => $history,
        ]);
    }

    public function updateOrderStatus(Request $request, array $params): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $id = (int) ($params['id'] ?? 0);
        $newStatus = (string) $request->input('order_status');
        $comment = $request->input('comment') ? (string) $request->input('comment') : null;

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT order_status FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $curr = $stmt->fetchColumn();

        if ($curr && Order::canTransition($curr, $newStatus)) {
            $this->orderRepo->updateStatus($id, $newStatus, $comment);
        }

        return $this->redirect('/admin/commandes/' . $id);
    }

    public function products(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $products = $this->productRepo->findAllActive();

        return $this->render('admin.pages.products_list', [
            'products' => $products,
        ]);
    }

    public function createProduct(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

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

                return $this->redirect('/admin/produits');
            }
        }

        $categories = $this->categoryRepo->findAllActive();
        return $this->render('admin.pages.product_form', [
            'categories' => $categories,
        ]);
    }

    public function themes(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $pdo = Database::getConnection();
        $currTheme = 'fashion';
        $stmt = $pdo->query("SELECT setting_value FROM shop_settings WHERE setting_key = 'active_theme' LIMIT 1");
        if ($stmt && $val = $stmt->fetchColumn()) {
            $currTheme = $val;
        }

        return $this->render('admin.pages.themes_gallery', [
            'active_theme' => $currTheme,
        ]);
    }

    public function switchTheme(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $theme = (string) $request->input('theme');
        $allowed = ['fashion', 'bello', 'luxe', 'naya', 'shop'];

        if (in_array($theme, $allowed, true)) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO shop_settings (setting_key, setting_value) VALUES ('active_theme', :t)
                                    ON DUPLICATE KEY UPDATE setting_value = :t");
            try {
                $stmt->execute(['t' => $theme]);
            } catch (\Exception $e) {
                $pdo->exec("REPLACE INTO shop_settings (setting_key, setting_value) VALUES ('active_theme', '{$theme}')");
            }
        }

        return $this->redirect('/admin/themes');
    }

    public function showImport(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;

        $report = Session::get('import_report');
        Session::remove('import_report');

        return $this->render('admin.pages.import', [
            'report' => $report,
            'meta_status' => $this->metaConnector->getStatus(),
        ]);
    }

    public function processCsvImport(Request $request): Response
    {
        if ($res = $this->requireAuth()) return $res;
        $this->validateCsrf($request);

        $file = $request->file('csv_file');
        if (!$file || empty($file['tmp_name'])) {
            Session::set('import_report', ['errors' => ['Veuillez sélectionner un fichier CSV valide.']]);
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
}
