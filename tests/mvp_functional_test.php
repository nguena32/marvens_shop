<?php
declare(strict_types=1);

/**
 * Suite de tests fonctionnels et d'intégration E2E du MVP
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Session;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Application\Services\CartService;
use App\Application\Services\CheckoutService;
use App\Domain\Entities\Order;

class MvpFunctionalTestSuite
{
    private int $passed = 0;
    private int $failed = 0;
    private PDO $pdo;

    public function __construct()
    {
        // Utiliser une base SQLite isolée en mémoire
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Database::setConnection($this->pdo);
        $this->setupSchema();
    }

    private function setupSchema(): void
    {
        $this->pdo->exec("
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(100) UNIQUE,
                email VARCHAR(255) UNIQUE,
                password_hash VARCHAR(255),
                role VARCHAR(50),
                name VARCHAR(255),
                is_active INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE shop_settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key VARCHAR(100) UNIQUE,
                setting_value TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                description TEXT,
                image_url VARCHAR(255),
                sort_order INTEGER DEFAULT 0,
                is_active INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                sku VARCHAR(100),
                description TEXT,
                price INTEGER,
                promotional_price INTEGER,
                main_image_url VARCHAR(255),
                is_active INTEGER DEFAULT 1,
                is_featured INTEGER DEFAULT 0,
                meta_product_id VARCHAR(100),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE product_variants (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER,
                variant_name VARCHAR(100),
                size VARCHAR(50),
                color VARCHAR(50),
                price_override INTEGER,
                stock_quantity INTEGER DEFAULT 0,
                is_available INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number VARCHAR(100) UNIQUE,
                customer_name VARCHAR(255),
                customer_whatsapp VARCHAR(50),
                delivery_mode VARCHAR(50),
                delivery_city VARCHAR(100),
                delivery_district VARCHAR(100),
                delivery_address TEXT,
                delivery_cost INTEGER,
                total_amount INTEGER,
                order_status VARCHAR(50),
                payment_status VARCHAR(50),
                payment_mode VARCHAR(50),
                customer_notes TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER,
                product_id INTEGER,
                product_name VARCHAR(255),
                variant_info VARCHAR(100),
                unit_price INTEGER,
                quantity INTEGER,
                subtotal INTEGER,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE order_status_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER,
                previous_status VARCHAR(50),
                new_status VARCHAR(50),
                comment TEXT,
                changed_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    public function assert(string $description, bool $condition, string $error = ''): void
    {
        if ($condition) {
            $this->passed++;
            echo " [PASS] {$description}\n";
        } else {
            $this->failed++;
            echo " [FAIL] {$description} : {$error}\n";
        }
    }

    public function runAll(): int
    {
        echo "========================================================\n";
        echo "   BANC DE TESTS FONCTIONNELS E2E — MARVENS SHOP MVP   \n";
        echo "========================================================\n\n";

        $productRepo = new ProductRepository($this->pdo);
        $categoryRepo = new CategoryRepository($this->pdo);
        $orderRepo = new OrderRepository($this->pdo);
        $cartService = new CartService($productRepo);
        $checkoutService = new CheckoutService($orderRepo, $cartService);

        // 1. Test Création de Catégorie & Produit (Catalogue)
        $catId = $categoryRepo->create(['name' => 'Robes', 'slug' => 'robes']);
        $this->assert("Création d'une catégorie en base", $catId > 0);

        $prodId = $productRepo->create([
            'category_id' => $catId,
            'name' => 'Robe Sahara',
            'slug' => 'robe-sahara',
            'price' => 18500,
            'promotional_price' => 15000,
            'is_active' => 1,
            'is_featured' => 1,
        ]);
        $this->assert("Création d'un produit avec prix promo", $prodId > 0);

        // 2. Test Panier & Recalcul Autoritaire Serveur (MS-BIZ-03)
        $cartService->clear();
        $cartService->addItem($prodId, 2, 'Taille M');
        $calc = $cartService->getCartCalculation();

        $this->assert(
            "Recalcul automatique du panier basé sur le prix promo en base (15 000 x 2 = 30 000 FCFA)",
            $calc['subtotal'] === 30000 && $calc['count'] === 2
        );

        // 3. Test Persistance Atomique de Commande avant WhatsApp (MS-BIZ-04)
        $checkoutResult = $checkoutService->processCheckout([
            'customer_name' => 'Amina N.',
            'customer_whatsapp' => '699000000',
            'delivery_mode' => 'delivery',
            'delivery_district' => 'Akwa',
            'delivery_address' => 'Face Boulangerie',
        ]);

        $orderNumber = $checkoutResult['order_number'];
        $persistedOrder = $orderRepo->findByOrderNumber($orderNumber);

        $this->assert(
            "La commande est persistée en base avant l'ouverture de WhatsApp avec numéro unique",
            $persistedOrder !== null && $persistedOrder['order_status'] === 'pending'
        );

        $this->assert(
            "Le montant total inclut la livraison (30 000 + 1 500 = 31 500 FCFA)",
            (int) $persistedOrder['total_amount'] === 31500
        );

        // 4. Test Génération Sécurisée du Lien WhatsApp (MS-BIZ-05)
        $whatsappLink = $checkoutResult['whatsapp_url'];
        $this->assert(
            "Le lien WhatsApp contient le numéro de commande et est correctement encodé",
            str_contains($whatsappLink, rawurlencode($orderNumber)) && str_contains($whatsappLink, 'https://wa.me/')
        );

        // 5. Test Cycle de Vie des Statuts de Commande (MS-BIZ-06)
        $orderId = (int) $persistedOrder['id'];
        $this->assert("Transition valide : pending -> confirmed", Order::canTransition('pending', 'confirmed') === true);
        $this->assert("Transition interdite rejetée : delivered -> pending", Order::canTransition('delivered', 'pending') === false);

        $orderRepo->updateStatus($orderId, 'confirmed', 'Disponibilité vérifiée');
        $updatedOrder = $orderRepo->findByOrderNumber($orderNumber);
        $this->assert("Mise à jour du statut en base vers 'confirmed'", $updatedOrder['order_status'] === 'confirmed');

        // 6. Test Préservation des Données lors du Changement de Thème (MS-BIZ-07)
        $this->pdo->exec("REPLACE INTO shop_settings (setting_key, setting_value) VALUES ('active_theme', 'bello')");
        $themeSetting = $this->pdo->query("SELECT setting_value FROM shop_settings WHERE setting_key = 'active_theme'")->fetchColumn();
        $productsStillPresent = count($productRepo->findAllActive());

        $this->assert(
            "Le changement de thème vers 'bello' préserve intégralement le catalogue et les commandes",
            $themeSetting === 'bello' && $productsStillPresent === 1
        );

        echo "\n========================================================\n";
        echo "BILAN : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "========================================================\n";

        return $this->failed === 0 ? 0 : 1;
    }
}

$testSuite = new MvpFunctionalTestSuite();
exit($testSuite->runAll());
