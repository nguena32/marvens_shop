<?php
declare(strict_types=1);

/**
 * Suite de tests de validation, d'audit et de qualification complète du :
 * MODULE 4 : PERSONNALISATION DES POLICES D'ÉCRITURE
 *
 * Exigences couvertes :
 * 4.1 Typographie globale :
 *    - Police des titres, sous-titres, corps de texte, boutons, éléments d'accentuation
 *    - Taille des titres, sous-titres, texte (compact, normal, large)
 *    - Épaisseur des textes et des titres (normal, medium, semibold, bold, black)
 *    - Style normal ou gras / majuscules / italique
 * 4.2 Bibliothèque de polices :
 *    - Affichage des polices disponibles (Inter, Space Grotesk, Plus Jakarta Sans, Outfit, Poppins, Playfair Display, Cinzel, DM Sans, Montserrat, Lora)
 *    - Présentation d'un aperçu de chaque police (famille, catégorie, texte d'exemple)
 *    - Sélection d'une police et application aux éléments concernés
 *    - Prévisualisation sur mobile et ordinateur
 *    - Enregistrement des préférences
 *    - Réinitialisation des polices du thème aux valeurs d'origine
 * 4.3 Adaptation des polices aux éléments configurés :
 *    - Titres, sous-titres, descriptions, textes de navigation, boutons, prix, fiches produits, pages complémentaires, formulaires
 *    - Lisibilité mobile et compatibilité caractères
 * Sécurité & Intégrité (Whitelisting strict, XSS, CSRF, isolation des données MS-BIZ-07)
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

class TypographyModuleTestSuite
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

        $this->pdo->exec("INSERT INTO categories (name, slug) VALUES ('Robes', 'robes')");
        $this->pdo->exec("INSERT INTO products (category_id, name, slug, sku, price, promotional_price, is_active, is_featured) 
                          VALUES (1, 'Robe Soirée Satin', 'robe-soiree-satin', 'ROB-99', 25000, 20000, 1, 1)");
        $this->pdo->exec("INSERT INTO orders (order_number, customer_name, customer_whatsapp, total_amount, order_status, payment_status)
                          VALUES ('CMD-TEST-001', 'Marie Claire', '237699112233', 20000, 'confirmed', 'paid')");
    }

    private function assert(bool $condition, string $testName, string $details = ''): void
    {
        if ($condition) {
            $this->passed++;
            echo " \033[32m[PASS]\033[0m " . $testName . "\n";
        } else {
            $this->failed++;
            echo " \033[31m[FAIL]\033[0m " . $testName . ($details ? " -> {$details}" : '') . "\n";
        }
    }

    public function runAll(): void
    {
        echo "========================================================\n";
        echo "   BANC DE VALIDATION — MODULE 4 (POLICES D'ÉCRITURE)   \n";
        echo "========================================================\n\n";

        $this->testSection41DefaultTypographyAndStructure();
        $this->testSection42FontLibrary();
        $this->testSection42SaveAndPersistTypography();
        $this->testSection42ResetTypography();
        $this->testSection41And43CssVariableGeneration();
        $this->testSection43ElementsAdaptation();
        $this->testSecurityAndWhitelisting();
        $this->testStorefrontAndAdminIntegration();
        $this->testDataIntegrityRuleMSBIZ07();

        echo "\n========================================================\n";
        echo sprintf("BILAN AUDIT MODULE 4 : %d Succès, %d Échecs\n", $this->passed, $this->failed);
        echo "========================================================\n";

        if ($this->failed > 0) {
            exit(1);
        }
    }

    /**
     * Test 4.1 : Présence et complétude de la typographie par défaut pour chaque thème
     */
    private function testSection41DefaultTypographyAndStructure(): void
    {
        $themes = ThemeService::ALLOWED_THEMES;
        $allValid = true;

        foreach ($themes as $t) {
            $def = $this->themeService->getDefaultTypography($t);
            $requiredKeys = [
                'font_titles', 'font_subtitles', 'font_body', 'font_buttons', 'font_accents',
                'size_titles', 'size_subtitles', 'size_body',
                'weight_titles', 'weight_body', 'style_titles'
            ];

            foreach ($requiredKeys as $k) {
                if (!isset($def[$k]) || $def[$k] === '') {
                    $allValid = false;
                    break 2;
                }
            }
        }

        $this->assert($allValid, "4.1 - Tous les thèmes (fashion, bello, luxe, naya, shop) ont une configuration typographique exhaustive (5 polices + 3 échelles + 2 graisses + 1 style)");
    }

    /**
     * Test 4.2 : Bibliothèque de polices
     */
    private function testSection42FontLibrary(): void
    {
        $lib = $this->themeService->getFontLibrary();
        $expectedFonts = ['Inter', 'Space Grotesk', 'Plus Jakarta Sans', 'Outfit', 'Poppins', 'Playfair Display', 'Cinzel', 'DM Sans', 'Montserrat', 'Lora'];

        $countMatch = (count($lib) >= 10);
        $keysPresent = true;
        foreach ($expectedFonts as $f) {
            if (!isset($lib[$f])) {
                $keysPresent = false;
                break;
            }
            if (empty($lib[$f]['name']) || empty($lib[$f]['family']) || empty($lib[$f]['preview_text']) || empty($lib[$f]['category'])) {
                $keysPresent = false;
                break;
            }
        }

        $this->assert($countMatch && $keysPresent, "4.2 - Bibliothèque de polices : 10 polices web intégrées avec aperçu, catégorie, famille et texte d'exemple");
    }

    /**
     * Test 4.2 : Sauvegarde et persistance des choix du commerçant
     */
    private function testSection42SaveAndPersistTypography(): void
    {
        $customData = [
            'font_titles' => 'Playfair Display',
            'font_subtitles' => 'Lora',
            'font_body' => 'Plus Jakarta Sans',
            'font_buttons' => 'Poppins',
            'font_accents' => 'Cinzel',
            'size_titles' => 'scale-large',
            'size_subtitles' => 'scale-compact',
            'size_body' => 'scale-normal',
            'weight_titles' => 'font-black',
            'weight_body' => 'font-semibold',
            'style_titles' => 'uppercase',
        ];

        $saved = $this->themeService->saveThemeTypography('fashion', $customData);
        $this->assert($saved, "4.2 - Enregistrement des préférences typographiques pour le thème 'fashion'");

        $loaded = $this->themeService->getThemeTypography('fashion');
        $this->assert($loaded['font_titles'] === 'Playfair Display', "4.1 & 4.2 - Police des titres personnalisée 'Playfair Display' correctement persistée");
        $this->assert($loaded['font_buttons'] === 'Poppins', "4.1 & 4.2 - Police des boutons 'Poppins' correctement persistée");
        $this->assert($loaded['font_accents'] === 'Cinzel', "4.1 & 4.2 - Police des accents 'Cinzel' correctement persistée");
        $this->assert($loaded['size_titles'] === 'scale-large', "4.1 - Taille des titres 'scale-large' correctement persistée");
        $this->assert($loaded['weight_titles'] === 'font-black', "4.1 - Épaisseur des titres 'font-black' correctement persistée");
        $this->assert($loaded['style_titles'] === 'uppercase', "4.1 - Style 'uppercase' des titres correctement persisté");
    }

    /**
     * Test 4.2 : Réinitialisation des polices du thème
     */
    private function testSection42ResetTypography(): void
    {
        $this->themeService->resetThemeTypography('fashion');
        $afterReset = $this->themeService->getThemeTypography('fashion');
        $defaultFashion = $this->themeService->getDefaultTypography('fashion');

        $this->assert(
            $afterReset['font_titles'] === $defaultFashion['font_titles'] &&
            $afterReset['weight_titles'] === $defaultFashion['weight_titles'] &&
            $afterReset['style_titles'] === $defaultFashion['style_titles'],
            "4.2 - Réinitialisation : les polices et styles du thème Fashion sont revenus aux valeurs d'origine"
        );
    }

    /**
     * Test 4.1 & 4.3 : Génération des variables CSS et des styles
     */
    private function testSection41And43CssVariableGeneration(): void
    {
        $customCust = $this->themeService->getDefaultCustomization('fashion');
        $customTypo = [
            'font_titles' => 'Playfair Display',
            'font_subtitles' => 'Lora',
            'font_body' => 'Inter',
            'font_buttons' => 'Poppins',
            'font_accents' => 'Cinzel',
            'size_titles' => 'scale-large',
            'size_subtitles' => 'scale-compact',
            'size_body' => 'scale-normal',
            'weight_titles' => 'font-black',
            'weight_body' => 'font-normal',
            'style_titles' => 'uppercase',
        ];

        $css = $this->themeService->generateCssVariables($customCust, $customTypo);

        $hasTitleFont = str_contains($css, "--font-titles: 'Playfair Display', Georgia, serif;");
        $hasBtnFont = str_contains($css, "--font-buttons: 'Poppins', system-ui, sans-serif;");
        $hasAccentsFont = str_contains($css, "--font-accents: 'Cinzel', Georgia, serif;");
        $hasWeight = str_contains($css, "--weight-titles: 900;");
        $hasTransform = str_contains($css, "--transform-titles: uppercase;");
        $hasScaleTitles = str_contains($css, "--scale-titles: 1.15;");

        $this->assert(
            $hasTitleFont && $hasBtnFont && $hasAccentsFont && $hasWeight && $hasTransform && $hasScaleTitles,
            "4.1 & 4.3 - Génération CSS : Variables --font-titles, --font-buttons, --font-accents, échelles et graisses correctement calculées"
        );

        // Test Google Fonts URL generator
        $gfUrl = $this->themeService->getGoogleFontsUrl($customTypo);
        $hasGfPlayfair = str_contains($gfUrl, 'Playfair+Display');
        $hasGfPoppins = str_contains($gfUrl, 'Poppins');
        $hasGfCinzel = str_contains($gfUrl, 'Cinzel');

        $this->assert(
            $hasGfPlayfair && $hasGfPoppins && $hasGfCinzel,
            "4.2 - Google Fonts : URL d'importation dynamique générée pour toutes les polices sélectionnées"
        );
    }

    /**
     * Test 4.3 : Adaptation des polices aux éléments configurés
     */
    private function testSection43ElementsAdaptation(): void
    {
        $customCust = $this->themeService->getDefaultCustomization('fashion');
        $customTypo = $this->themeService->getDefaultTypography('fashion');
        $css = $this->themeService->generateCssVariables($customCust, $customTypo);

        // Vérification de la liaison des sélecteurs exigés par 4.3 :
        // Titres, sous-titres, descriptions, textes de navigation, boutons, prix, fiches produits, formulaires
        $hasH1Titles = str_contains($css, "h1, h2, .font-headline");
        $hasSubtitles = str_contains($css, "h3, h4, h5, h6, .font-subheadline");
        $hasDescriptions = str_contains($css, "p, .font-body, .prose, .description-text");
        $hasButtons = str_contains($css, ".btn-theme, button[type='submit'].btn-theme, a.btn-theme, .btn-secondary-theme");
        $hasPrices = str_contains($css, ".price-theme");
        $hasBadges = str_contains($css, ".badge-theme, .accent-theme");
        $hasNavigation = str_contains($css, "header.bg-surface\/90, .nav-theme, nav a");
        $hasForms = str_contains($css, "input, select, textarea");

        $allCovered = $hasH1Titles && $hasSubtitles && $hasDescriptions && $hasButtons &&
                      $hasPrices && $hasBadges && $hasNavigation && $hasForms;

        $this->assert($allCovered, "4.3 - Adaptation : Titres, sous-titres, descriptions, navigation, boutons, prix, badges et formulaires ciblés par la typographie");
    }

    /**
     * Test Sécurité : Whitelisting strict des polices, tailles et styles (Immunité injection CSS et XSS)
     */
    private function testSecurityAndWhitelisting(): void
    {
        $maliciousPayload = [
            'font_titles' => '<script>alert("xss")</script>',
            'font_subtitles' => 'Comic Sans MS; } body { display:none; }',
            'font_body' => '../../etc/passwd',
            'font_buttons' => "' onmouseover='alert(1)'",
            'font_accents' => 'NonExistentFont',
            'size_titles' => 'scale-malicious; color:red;',
            'weight_titles' => 'bold; font-size: 9999px;',
            'style_titles' => '<img src=x onerror=alert(1)>',
        ];

        $this->themeService->saveThemeTypography('fashion', $maliciousPayload);
        $loaded = $this->themeService->getThemeTypography('fashion');
        $default = $this->themeService->getDefaultTypography('fashion');

        $sanitized = (
            $loaded['font_titles'] === $default['font_titles'] &&
            $loaded['font_subtitles'] === $default['font_subtitles'] &&
            $loaded['font_body'] === $default['font_body'] &&
            $loaded['size_titles'] === $default['size_titles'] &&
            $loaded['weight_titles'] === $default['weight_titles'] &&
            $loaded['style_titles'] === $default['style_titles']
        );

        $this->assert($sanitized, "Sécurité - Whitelisting strict : Les polices, échelles, graisses et styles non autorisés sont rejetés avec repli sur les valeurs saines");
    }

    /**
     * Test Intégration Storefront et Admin
     */
    private function testStorefrontAndAdminIntegration(): void
    {
        // 1. Protection admin
        $_SESSION = [];
        $adminCtrl = new AdminController();
        $respAuth = $adminCtrl->typographySettings(new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/parametres/typographie']));
        $this->assert($respAuth->getStatusCode() === 302, "Sécurité - La route /admin/parametres/typographie exige une session marchand active (302)");

        // 2. Écran d'administration typographie
        Session::set('admin_user_id', 1);
        Session::set('admin_user_role', 'merchant_admin');
        Session::set('admin_user_name', 'Admin Marvens');

        $adminResp = $adminCtrl->typographySettings(new Request(['theme' => 'fashion'], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/parametres/typographie']));
        $this->assert($adminResp->getStatusCode() === 200, "Admin - L'écran de personnalisation des polices répond HTTP 200 pour le commerçant");

        $adminHtml = $adminResp->getContent();
        $hasGlobalSection = str_contains($adminHtml, '4.1 Typographie Globale');
        $hasLibrarySection = str_contains($adminHtml, '4.2 Bibliothèque de Polices');
        $hasLivePreview = str_contains($adminHtml, 'device-preview-container');
        $hasMobilePreview = str_contains($adminHtml, 'setPreviewDevice');

        $this->assert(
            $hasGlobalSection && $hasLibrarySection && $hasLivePreview && $hasMobilePreview,
            "Admin - L'interface comprend la typographie globale, la bibliothèque de polices et la prévisualisation live mobile / ordinateur"
        );

        // 3. Storefront avec typographie injectée
        $storefrontCtrl = new StorefrontController();
        $storeResp = $storefrontCtrl->home(new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']));
        $this->assert($storeResp->getStatusCode() === 200, "Storefront - La boutique publique répond HTTP 200");

        $storeHtml = $storeResp->getContent();
        $hasCssTypoVars = str_contains($storeHtml, '--font-titles') && str_contains($storeHtml, '--scale-titles');
        $hasGoogleFontsTag = str_contains($storeHtml, 'fonts.googleapis.com/css2?');

        $this->assert(
            $hasCssTypoVars && $hasGoogleFontsTag,
            "Storefront - Le HTML public charge la balise Google Fonts dynamique et les variables CSS typographiques personnalisées"
        );
    }

    /**
     * Test Règle Invariance Métier MS-BIZ-07
     */
    private function testDataIntegrityRuleMSBIZ07(): void
    {
        $prodCount = (int) $this->pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $catCount = (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $orderCount = (int) $this->pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

        $this->assert(
            $prodCount === 1 && $catCount === 1 && $orderCount === 1,
            "Règle MS-BIZ-07 - Invariance absolue : Produits, catégories et commandes restent 100% intacts après les personnalisations typographiques"
        );
    }
}

$suite = new TypographyModuleTestSuite();
$suite->runAll();
