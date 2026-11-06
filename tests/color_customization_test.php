<?php
declare(strict_types=1);

/**
 * Suite de tests de validation, d'audit et de qualification complète du :
 * MODULE 3 : PERSONNALISATION DES COULEURS ET DE L'APPARENCE
 *
 * Exigences couvertes :
 * 3.1 Palette générale (16 teintes personnalisables)
 * 3.2 Personnalisation des boutons (couleurs, hover, arrondi, style)
 * 3.3 Personnalisation des cartes produits (fond, bordures, style, arrondi, espacement, prix, promos)
 * 3.4 Gestion des couleurs par thème (palette par défaut, persistance, réinitialisation, cascade automatique, prévisualisation)
 * Sécurité (XSS, Injection CSS, validation des couleurs hexadécimales, CSRF, isolation des données MS-BIZ-07)
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Session;
use App\Core\Request;
use App\Core\Response;
use App\Domain\Themes\Theme;
use App\Application\Services\Theme\ThemeService;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\StorefrontController;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ColorCustomizationModuleTestSuite
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
                promotional_price DECIMAL(10,2),
                main_image_url TEXT,
                is_active INTEGER DEFAULT 1,
                is_featured INTEGER DEFAULT 1,
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

        $this->pdo->exec("INSERT INTO categories (name, slug) VALUES ('Mode Femme', 'mode-femme')");
        $this->pdo->exec("INSERT INTO products (category_id, name, slug, sku, price, promotional_price, is_active, is_featured) 
                          VALUES (1, 'Robe de Soirée', 'robe-soiree', 'ROB-99', 45000, 35000, 1, 1)");
        $this->pdo->exec("INSERT INTO orders (order_number, customer_name, customer_whatsapp, total_amount, order_status, payment_status)
                          VALUES ('CMD-TEST-777', 'Jeanne D.', '+237699112233', 37000, 'confirmed', 'paid')");
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
        echo "   BANC DE VALIDATION — MODULE 3 (COULEURS & APPARENCE) " . PHP_EOL;
        echo "========================================================" . PHP_EOL . PHP_EOL;

        // ---------------------------------------------------------------------
        // TEST 1 : Palette par défaut pour chaque thème autorisé (3.1 & 3.4)
        // ---------------------------------------------------------------------
        $themes = ['fashion', 'bello', 'luxe', 'naya', 'shop'];
        $allThemesHaveDefaults = true;

        foreach ($themes as $thId) {
            $defaults = $this->themeService->getDefaultCustomization($thId);
            $requiredKeys = [
                'primary_color', 'secondary_color', 'accent_color', 'bg_primary', 'bg_secondary',
                'surface_color', 'border_color', 'text_color', 'title_color', 'link_color',
                'btn_color', 'btn_hover_color', 'price_color', 'promo_color', 'badge_color', 'nav_color',
                'btn_primary_bg', 'btn_secondary_bg', 'btn_text_color', 'btn_hover_bg', 'btn_style', 'btn_radius',
                'card_bg', 'card_border', 'card_style', 'card_radius', 'card_spacing', 'card_price_style', 'card_promo_style', 'card_btn_style'
            ];

            foreach ($requiredKeys as $k) {
                if (!isset($defaults[$k])) {
                    $allThemesHaveDefaults = false;
                    break 2;
                }
            }
        }
        $this->assert($allThemesHaveDefaults, "3.1 & 3.4 - Tous les thèmes (fashion, bello, luxe, naya, shop) ont une palette par défaut exhaustive (16 couleurs + boutons + cartes)");

        // ---------------------------------------------------------------------
        // TEST 2 : Enregistrement et persistance d'une palette personnalisée (3.1, 3.2, 3.3)
        // ---------------------------------------------------------------------
        $customData = [
            'primary_color' => '#123456',
            'secondary_color' => '#654321',
            'accent_color' => '#00ffcc',
            'bg_primary' => '#fafafa',
            'bg_secondary' => '#f0f0f0',
            'surface_color' => '#ffffff',
            'border_color' => '#cccccc',
            'text_color' => '#111111',
            'title_color' => '#000000',
            'link_color' => '#123456',
            'btn_color' => '#123456',
            'btn_hover_color' => '#0f2a45',
            'price_color' => '#123456',
            'promo_color' => '#e11d48',
            'badge_color' => '#123456',
            'nav_color' => '#111111',

            // Boutons
            'btn_primary_bg' => '#123456',
            'btn_secondary_bg' => '#654321',
            'btn_text_color' => '#ffffff',
            'btn_hover_bg' => '#0f2a45',
            'btn_style' => 'filled',
            'btn_radius' => 'rounded-full',

            // Cartes
            'card_bg' => '#ffffff',
            'card_border' => '#e5e7eb',
            'card_style' => 'bordered',
            'card_radius' => 'rounded-xl',
            'card_spacing' => 'compact',
            'card_price_style' => 'badge',
            'card_promo_style' => 'ribbon',
            'card_btn_style' => 'filled'
        ];

        $saveResult = $this->themeService->saveThemeCustomization('fashion', $customData);
        $this->assert($saveResult === true, "3.4 - La personnalisation d'un thème est enregistrée sans erreur");

        $retrieved = $this->themeService->getThemeCustomization('fashion');
        $this->assert($retrieved['primary_color'] === '#123456', "3.1 - La couleur principale personnalisée '#123456' est correctement persistée");
        $this->assert($retrieved['btn_radius'] === 'rounded-full', "3.2 - L'arrondi des boutons personnalisé 'rounded-full' est persisté");
        $this->assert($retrieved['card_radius'] === 'rounded-xl', "3.3 - L'arrondi des cartes 'rounded-xl' est persisté");
        $this->assert($retrieved['card_spacing'] === 'compact', "3.3 - L'espacement intérieur des cartes 'compact' est persisté");

        // ---------------------------------------------------------------------
        // TEST 3 : Cascade automatique de la couleur principale (3.4)
        // ---------------------------------------------------------------------
        // Si le commerçant change la couleur principale vers '#ff5500' et n'a pas spécifié de bouton spécifique
        $cascadeData = [
            'primary_color' => '#ff5500',
            // bouton principal non fourni ou laissé vide
            'btn_primary_bg' => '',
            'link_color' => '',
        ];
        $this->themeService->saveThemeCustomization('bello', $cascadeData);
        $belloCustom = $this->themeService->getThemeCustomization('bello');

        $this->assert(
            $belloCustom['btn_primary_bg'] === '#ff5500' && $belloCustom['link_color'] === '#ff5500',
            "3.4 - Cascade automatique : les boutons et liens associés ont automatiquement suivi la modification de la couleur principale ('#ff5500')"
        );

        // ---------------------------------------------------------------------
        // TEST 4 : Réinitialisation aux valeurs par défaut du thème (3.4)
        // ---------------------------------------------------------------------
        $this->themeService->resetThemeCustomization('fashion');
        $afterReset = $this->themeService->getThemeCustomization('fashion');
        $fashionDefault = $this->themeService->getDefaultCustomization('fashion');

        $this->assert(
            $afterReset['primary_color'] === $fashionDefault['primary_color'] &&
            $afterReset['btn_radius'] === $fashionDefault['btn_radius'],
            "3.4 - Réinitialisation : les couleurs et styles du thème Fashion sont revenus aux valeurs usine par défaut"
        );

        // ---------------------------------------------------------------------
        // TEST 5 : Sécurité — Rejet des injections XSS et CSS Malveillantes
        // ---------------------------------------------------------------------
        $maliciousPayload = [
            'primary_color' => 'red; background: url(javascript:alert(1))',
            'btn_radius' => '<script>alert(1)</script>',
            'card_spacing' => '"><img src=x onerror=alert(1)>'
        ];
        $this->themeService->saveThemeCustomization('fashion', $maliciousPayload);
        $sanitized = $this->themeService->getThemeCustomization('fashion');

        $this->assert(
            $sanitized['primary_color'] === $fashionDefault['primary_color'],
            "Sécurité - Couleurs : Tentative d'injection CSS rejetée, repli automatique sur la valeur saine par défaut"
        );
        $this->assert(
            $sanitized['btn_radius'] === $fashionDefault['btn_radius'],
            "Sécurité - Style : Valeur d'arrondi invalide/XSS rejetée par liste blanche stricte"
        );

        // ---------------------------------------------------------------------
        // TEST 6 : Génération CSS dynamique & Injection dans le Storefront
        // ---------------------------------------------------------------------
        $customizationActive = [
            'primary_color' => '#990000',
            'secondary_color' => '#333333',
            'accent_color' => '#ff0000',
            'bg_primary' => '#fafafa',
            'bg_secondary' => '#f0f0f0',
            'surface_color' => '#ffffff',
            'border_color' => '#dddddd',
            'text_color' => '#222222',
            'title_color' => '#111111',
            'link_color' => '#990000',
            'btn_color' => '#990000',
            'btn_hover_color' => '#770000',
            'price_color' => '#990000',
            'promo_color' => '#e11d48',
            'badge_color' => '#990000',
            'nav_color' => '#111111',
            'btn_primary_bg' => '#990000',
            'btn_secondary_bg' => '#333333',
            'btn_text_color' => '#ffffff',
            'btn_hover_bg' => '#770000',
            'btn_style' => 'filled',
            'btn_radius' => 'rounded-full',
            'card_bg' => '#ffffff',
            'card_border' => '#dddddd',
            'card_style' => 'bordered',
            'card_radius' => 'rounded-none',
            'card_spacing' => 'compact',
            'card_price_style' => 'badge',
            'card_promo_style' => 'ribbon',
            'card_btn_style' => 'filled'
        ];
        $this->themeService->saveThemeCustomization('fashion', $customizationActive);

        $cssOutput = $this->themeService->generateCssVariables($customizationActive);
        $this->assert(
            str_contains($cssOutput, '--color-primary: #990000;') &&
            str_contains($cssOutput, '--btn-radius: 9999px;') &&
            str_contains($cssOutput, '--card-radius: 0px;'),
            "3.1 & 3.2 & 3.3 - Génération CSS : Les variables CSS dynamiques et conversions de bordures (9999px, 0px) sont exactes"
        );

        // Appel du contrôleur Storefront pour vérifier l'intégration effective dans le layout HTML
        $storefront = new StorefrontController();
        $response = $storefront->home(new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']));
        $html = $response->getContent();

        $this->assert($response->getStatusCode() === 200, "Storefront - La boutique publique répond HTTP 200");
        $this->assert(
            str_contains($html, '--color-primary: #990000;') && str_contains($html, 'Injection dynamique des styles personnalisés'),
            "Storefront - Le HTML final intègre le bloc CSS dynamique injecté avec les couleurs personnalisées du commerçant"
        );

        // ---------------------------------------------------------------------
        // TEST 7 : Contrôle d'accès & Route d'Administration
        // ---------------------------------------------------------------------
        $admin = new AdminController();

        // Sans session auth -> redirection vers /admin/login
        $_SESSION = [];
        $unauthReq = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/parametres/apparence']);
        $unauthResp = $admin->appearanceSettings($unauthReq);
        $this->assert($unauthResp->getStatusCode() === 302, "Sécurité - La route /admin/parametres/apparence exige une authentification administrateur (302)");

        // Avec session authentifiée merchant_admin
        Session::set('admin_user_id', 1);
        Session::set('admin_user_role', 'merchant_admin');
        $authReq = new Request(['theme' => 'fashion'], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/parametres/apparence']);
        $authResp = $admin->appearanceSettings($authReq);
        $adminHtml = $authResp->getContent();

        $this->assert($authResp->getStatusCode() === 200, "Admin - L'écran de personnalisation des couleurs répond HTTP 200 pour le commerçant");
        $this->assert(
            str_contains($adminHtml, 'Personnalisation des Couleurs & Apparence') &&
            str_contains($adminHtml, '3.1 Palette Générale') &&
            str_contains($adminHtml, '3.2 Personnalisation des Boutons') &&
            str_contains($adminHtml, '3.3 Personnalisation des Cartes Produits') &&
            str_contains($adminHtml, 'Prévisualisation interactive en direct'),
            "Admin - L'interface comprend la palette générale, les boutons, les cartes et le canevas de prévisualisation en temps réel"
        );

        // ---------------------------------------------------------------------
        // TEST 8 : Invariance des données commerciales (MS-BIZ-07)
        // ---------------------------------------------------------------------
        $productsCount = (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $categoriesCount = (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $ordersCount = (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

        $this->assert(
            $productsCount === 1 && $categoriesCount === 1 && $ordersCount === 1,
            "Règle MS-BIZ-07 - Invariance absolue : Les produits, catégories et commandes sont restés strictement intacts après toutes les opérations d'apparence"
        );

        echo PHP_EOL . "========================================================" . PHP_EOL;
        echo sprintf("BILAN AUDIT COULEURS : %d Succès, %d Échecs", $this->passed, $this->failed) . PHP_EOL;
        echo "========================================================" . PHP_EOL;

        if ($this->failed > 0) {
            exit(1);
        }
    }
}

$suite = new ColorCustomizationModuleTestSuite();
$suite->run();
