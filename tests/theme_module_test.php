<?php
declare(strict_types=1);

/**
 * Suite de tests unitaires, fonctionnels et de sécurité pour le Module 2 :
 * SYSTÈME DE CHOIX DES TEMPLATES / THÈMES
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Session;
use App\Core\Request;
use App\Core\Router;
use App\Domain\Themes\Theme;
use App\Application\Services\Theme\ThemeService;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StorefrontController;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ThemeModuleTestSuite
{
    private int $passed = 0;
    private int $failed = 0;
    private PDO $pdo;
    private ThemeService $themeService;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Database::setConnection($this->pdo);
        $this->setupSchema();
        $this->themeService = new ThemeService($this->pdo);
    }

    private function setupSchema(): void
    {
        $this->pdo->exec("
            CREATE TABLE shop_settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key VARCHAR(100) UNIQUE,
                setting_value TEXT,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                description TEXT,
                sort_order INTEGER DEFAULT 0,
                is_active INTEGER DEFAULT 1
            );
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                sku VARCHAR(100) UNIQUE,
                description TEXT,
                price DECIMAL(10,2),
                promo_price DECIMAL(10,2),
                main_image_url TEXT,
                is_active INTEGER DEFAULT 1,
                is_featured INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number VARCHAR(50) UNIQUE,
                customer_name VARCHAR(255),
                customer_whatsapp VARCHAR(50),
                total_amount DECIMAL(10,2),
                order_status VARCHAR(50),
                payment_status VARCHAR(50)
            );
        ");

        // Insérer données initiales
        $this->pdo->exec("INSERT INTO categories (name, slug) VALUES ('Mode Féminine', 'mode-feminine')");
        $this->pdo->exec("INSERT INTO products (category_id, name, slug, sku, price, promo_price, is_active) 
                          VALUES (1, 'Robe Fleurie', 'robe-fleurie-101', 'ROB-101', 25000, 20000, 1)");
        $this->pdo->exec("INSERT INTO orders (order_number, customer_name, customer_whatsapp, total_amount, order_status, payment_status)
                          VALUES ('CMD-TEST-001', 'Alice N.', '+237699112233', 21500, 'confirmed', 'pending')");
    }

    private function assert(bool $condition, string $description): void
    {
        if ($condition) {
            $this->passed++;
            echo " [PASS] " . $description . PHP_EOL;
        } else {
            $this->failed++;
            echo " [FAIL] " . $description . PHP_EOL;
        }
    }

    public function run(): void
    {
        echo "========================================================" . PHP_EOL;
        echo "   BANC D'AUDIT & QUALIFICATION — MODULE 2 (THÈMES)     " . PHP_EOL;
        echo "========================================================" . PHP_EOL . PHP_EOL;

        // 1. Exigence 2.1 & 2.2 : Bibliothèque complète de thèmes et métadonnées
        $themes = $this->themeService->getAvailableThemes();
        $this->assert(count($themes) === 5, "2.1 - La bibliothèque contient les 5 thèmes autorisés (fashion, bello, luxe, naya, shop)");

        $allKeysPresent = true;
        foreach ($themes as $id => $theme) {
            if (!$theme instanceof Theme) $allKeysPresent = false;
            if (empty($theme->getName()) || empty($theme->getDescription()) || empty($theme->getPreviewImage())) $allKeysPresent = false;
            if (empty($theme->getPrimaryColors()) || empty($theme->getFeatures())) $allKeysPresent = false;
            if (empty($theme->getCatalogStyle()) || empty($theme->getProductCardStyle())) $allKeysPresent = false;
            if (empty($theme->getNavigationStyle()) || empty($theme->getProductPageStyle())) $allKeysPresent = false;
            if (empty($theme->getCartStyle()) || empty($theme->getHomeStyle())) $allKeysPresent = false;
        }
        $this->assert($allKeysPresent, "2.1 & 2.2 - Chaque thème possède toutes les métadonnées requises (Nom, image, description, caractéristiques, couleurs, styles catalogue/cartes/navigation/fiche/panier/accueil)");

        // 2. Exigence 2.1 : Thème actif par défaut
        $activeTheme = $this->themeService->getActiveThemeId();
        $this->assert($activeTheme === 'fashion', "2.1 - Le thème actif par défaut est 'fashion'");

        // 3. Exigence 2.3 : Prévisualisation de la page d'accueil d'un thème sans modification
        $storefront = new StorefrontController();
        $reqPreview = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/theme/preview/luxe']);
        $previewResp = $storefront->previewTheme($reqPreview, ['theme' => 'luxe']);
        $this->assert($previewResp->getStatusCode() === 200, "2.3 - La route de prévisualisation retourne HTTP 200");
        $this->assert(str_contains($previewResp->getContent(), 'data-theme="luxe"'), "2.3 - La vue de prévisualisation intègre les styles du thème ciblé (Luxe)");
        $this->assert(str_contains($previewResp->getContent(), 'Mode Prévisualisation'), "2.3 - Le bandeau explicite de prévisualisation est présent");
        $this->assert($this->themeService->getActiveThemeId() === 'fashion', "2.3 - La prévisualisation n'a pas modifié le thème actif en base de données");

        // 4. Exigence 2.4 : Activation d'un thème
        $this->themeService->activateTheme('luxe');
        $this->assert($this->themeService->getActiveThemeId() === 'luxe', "2.4 - L'activation persiste le thème actif 'luxe' en base");
        $this->assert($this->themeService->getPreviousThemeId() === 'fashion', "2.4 - Le thème précédent 'fashion' est archivé pour rollback");

        // 5. Exigence 2.4 : Rendu de la boutique publique avec le nouveau thème
        $homeResp = $storefront->home(new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']));
        $this->assert($homeResp->getStatusCode() === 200, "2.4 - La boutique publique répond HTTP 200 après changement de thème");
        $this->assert(str_contains($homeResp->getContent(), 'data-theme="luxe"'), "2.4 - La boutique publique applique le thème 'luxe' actif");

        // 6. Exigence 2.4 : Revenir au thème précédent (Rollback)
        $this->themeService->rollbackToPreviousTheme();
        $this->assert($this->themeService->getActiveThemeId() === 'fashion', "2.4 - Le retour au thème précédent réactive 'fashion'");

        // 7. Exigence 2.4 : Réinitialiser au thème par défaut
        $this->themeService->activateTheme('naya');
        $this->assert($this->themeService->getActiveThemeId() === 'naya', "2.4 - Thème 'naya' activé");
        $this->themeService->resetToDefaultTheme();
        $this->assert($this->themeService->getActiveThemeId() === 'fashion', "2.4 - Réinitialisation réussie vers 'fashion'");

        // 8. Exigence 2.5 : Préservation intégrale et stricte des données commerciales (Règle MS-BIZ-07)
        $initialProducts = (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $initialCategories = (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $initialOrders = (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

        // Multiples bascules de thèmes
        foreach (['shop', 'bello', 'luxe', 'naya', 'fashion'] as $t) {
            $this->themeService->activateTheme($t);
        }

        $afterProducts = (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $afterCategories = (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $afterOrders = (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

        $this->assert(
            $initialProducts === $afterProducts &&
            $initialCategories === $afterCategories &&
            $initialOrders === $afterOrders,
            "2.5 - Critère d'acceptation non-négociable : Produits ($afterProducts), Catégories ($afterCategories) et Commandes ($afterOrders) restent strictement inchangés après toutes les mutations de thèmes"
        );

        // 9. Sécurité : Rejet d'un nom de thème malveillant ou non autorisé (Allowlist / Path Traversal)
        $securityPassed = false;
        try {
            $this->themeService->activateTheme('../../../etc/passwd');
        } catch (\InvalidArgumentException $e) {
            $securityPassed = true;
        }
        $this->assert($securityPassed, "Sécurité - Tentative d'injection ou Path Traversal ('../../../etc/passwd') rejetée par allowlist");

        echo PHP_EOL . "========================================================" . PHP_EOL;
        echo sprintf("BILAN AUDIT THÈMES : %d Succès, %d Échecs", $this->passed, $this->failed) . PHP_EOL;
        echo "========================================================" . PHP_EOL;

        if ($this->failed > 0) {
            exit(1);
        }
    }
}

$suite = new ThemeModuleTestSuite();
$suite->run();
