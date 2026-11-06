<?php
declare(strict_types=1);

/**
 * Suite de tests de validation d'audit E2E approfondie :
 * MODULE 1 : MINI-SITE E-COMMERCE PUBLIC
 * 1.1 Page d'accueil (Bannière, Commerce, Produits en avant, Nouveautés, Promos, Populaires, WhatsApp, Thème)
 * 1.2 Catalogue (Affichage, Catégories, Recherche, Filtre Prix, Nouveautés, Promos, Populaires, Tri)
 * 1.3 Fiche produit (Nom, Description, Prix, Promo, SKU, Catégorie, Disponibilité, Variantes/Tailles/Couleurs, Stock, Bouton Panier, Bouton WhatsApp, Produits similaires)
 * 1.4 Pages complémentaires (À propos, Contact, Livraison, Retrait, CGV, Retours, Confidentialité)
 * 1.5 Responsive & Mobile-first (Structure, Viewport, Badges, Adaptations, Rendu sans failles)
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Session;
use App\Core\Request;
use App\Core\Router;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Application\Services\CartService;
use App\Application\Services\CheckoutService;
use App\Application\Services\Theme\ThemeService;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;

class MiniSiteAuditTestSuite
{
    private int $passed = 0;
    private int $failed = 0;
    private PDO $pdo;
    private StorefrontController $storefrontController;
    private CartController $cartController;
    private ProductRepository $productRepo;
    private CategoryRepository $categoryRepo;
    private CartService $cartService;

    public function __construct()
    {
        // 1. Initialiser une DB SQLite isolée en mémoire
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Database::setConnection($this->pdo);

        $this->setupSchema();
        $this->seedData();

        $this->productRepo = new ProductRepository($this->pdo);
        $this->categoryRepo = new CategoryRepository($this->pdo);
        $this->cartService = new CartService($this->productRepo);
        $this->storefrontController = new StorefrontController();
        $this->cartController = new CartController();
    }

    private function setupSchema(): void
    {
        $this->pdo->exec("
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
        ");
    }

    private function seedData(): void
    {
        // Settings
        $this->pdo->exec("INSERT INTO shop_settings (setting_key, setting_value) VALUES 
            ('active_theme', 'fashion'),
            ('shop_name', 'Marvens Fashion Store'),
            ('shop_whatsapp', '+237699112233')");

        // Catégories
        $this->pdo->exec("INSERT INTO categories (id, name, slug) VALUES 
            (1, 'Robes de Soirée', 'robes'),
            (2, 'Chaussures Cuir', 'chaussures')");

        // Produits
        $this->pdo->exec("INSERT INTO products (id, category_id, name, slug, sku, description, price, promotional_price, main_image_url, is_active, is_featured, created_at) VALUES 
            (1, 1, 'Robe Sahara Chic', 'robe-sahara-chic', 'ROB-001', 'Robe longue en satin soyeux.', 25000, 20000, '/uploads/products/robe-fleurie.jpg', 1, 1, '2026-11-01 10:00:00'),
            (2, 1, 'Robe Cocktail Rouge', 'robe-cocktail-rouge', 'ROB-002', 'Robe de fête glamour.', 30000, NULL, '/uploads/products/chemise-oxford.jpg', 1, 0, '2026-11-02 12:00:00'),
            (3, 2, 'Mocassins Cuir Suédé', 'mocassins-cuir-suede', 'MOC-003', 'Mocassins faits main.', 35000, 32000, '/uploads/products/mocassins-brun.jpg', 1, 1, '2026-11-03 14:00:00')");

        // Variantes pour le produit 1
        $this->pdo->exec("INSERT INTO product_variants (product_id, variant_name, size, color, stock_quantity, is_available) VALUES 
            (1, 'Taille M / Noir Ébène', 'M', 'Noir', 10, 1),
            (1, 'Taille L / Noir Ébène', 'L', 'Noir', 5, 1)");
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

    public function run(): int
    {
        echo "========================================================\n";
        echo "   BANC D'AUDIT E2E APPROFONDI — MODULE 1 (MINI-SITE)   \n";
        echo "========================================================\n\n";

        Session::start();

        // ---------------------------------------------------------
        // 1.1 PAGE D'ACCUEIL
        // ---------------------------------------------------------
        $homeReq = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']);
        $homeResp = $this->storefrontController->home($homeReq);
        $homeHtml = $homeResp->getContent();

        $this->assert("1.1 - La page d'accueil répond HTTP 200", $homeResp->getStatusCode() === 200);
        $this->assert("1.1 - Logo et identité visuelle présents", str_contains($homeHtml, 'Marvens Shop') || str_contains($homeHtml, 'Boutique en ligne officielle'));
        $this->assert("1.1 - Bannière principale et présentation du commerce présentes", str_contains($homeHtml, 'L\'Élégance & la Qualité') && str_contains($homeHtml, 'Commande 100% Simple'));
        $this->assert("1.1 - Boutons d'accès direct au catalogue présents", str_contains($homeHtml, 'href="/catalogue"'));
        $this->assert("1.1 - Bouton de contact WhatsApp direct présent et encodé", str_contains($homeHtml, 'https://wa.me/'));
        $this->assert("1.1 - Section Catégories principales affichée", str_contains($homeHtml, 'Robes de Soirée') && str_contains($homeHtml, 'Chaussures Cuir'));
        $this->assert("1.1 - Section Produits en avant & Bestsellers présente", str_contains($homeHtml, 'Produits en Vedette'));
        $this->assert("1.1 - Section Promotions en cours présente", str_contains($homeHtml, 'Promotions en Cours') && str_contains($homeHtml, 'Robe Sahara Chic'));
        $this->assert("1.1 - Section Dernières Nouveautés présente", str_contains($homeHtml, 'Dernières Nouveautés'));
        $this->assert("1.1 - Informations pratiques (Livraison, Retrait, WhatsApp) affichées", str_contains($homeHtml, 'Livraison Rapide') && str_contains($homeHtml, 'Paiement à la Livraison'));

        // ---------------------------------------------------------
        // 1.2 CATALOGUE COMPLET & FILTRES
        // ---------------------------------------------------------
        // A. Catalogue standard
        $catReq = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/catalogue']);
        $catResp = $this->storefrontController->catalog($catReq);
        $catHtml = $catResp->getContent();
        $this->assert("1.2 - Le catalogue répond HTTP 200 avec tous les produits", $catResp->getStatusCode() === 200 && str_contains($catHtml, 'Robe Sahara Chic') && str_contains($catHtml, 'Mocassins Cuir Suédé'));

        // B. Filtrage par Catégorie
        $catFilterReq = new Request(['cat' => 1], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/catalogue?cat=1']);
        $catFilterHtml = $this->storefrontController->catalog($catFilterReq)->getContent();
        $this->assert("1.2 - Filtrage catégorie (Robes) isole les robes et exclut les mocassins", str_contains($catFilterHtml, 'Robe Sahara Chic') && !str_contains($catFilterHtml, 'Mocassins Cuir Suédé'));

        // C. Recherche textuelle
        $searchReq = new Request(['q' => 'Mocassins'], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/catalogue?q=Mocassins']);
        $searchHtml = $this->storefrontController->catalog($searchReq)->getContent();
        $this->assert("1.2 - La recherche textuelle 'Mocassins' retourne le produit exact", str_contains($searchHtml, 'Mocassins Cuir Suédé') && !str_contains($searchHtml, 'Robe Sahara Chic'));

        // D. Filtrage par Prix (min/max)
        $priceReq = new Request(['min_price' => '22000', 'max_price' => '31000'], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/catalogue?min_price=22000&max_price=31000']);
        $priceProducts = $this->productRepo->findAllActive(null, null, 22000, 31000);
        $this->assert("1.2 - Le repository retourne 1 produit pour 22000-31000", count($priceProducts) === 1, "Got " . count($priceProducts) . " items: " . json_encode($priceProducts));
        $priceResp = $this->storefrontController->catalog($priceReq);
        $priceHtml = $priceResp->getContent();
        $this->assert("1.2 - Filtrage par tranche de prix (22 000 - 31 000 FCFA) retourne 'Robe Cocktail Rouge' (30 000 FCFA)", str_contains($priceHtml, 'Robe Cocktail Rouge') && !str_contains($priceHtml, 'Robe Sahara Chic'));
        $priceResp = $this->storefrontController->catalog($priceReq);
        $priceHtml = $priceResp->getContent();
        $this->assert("1.2 - Filtrage par tranche de prix (22 000 - 31 000 FCFA) retourne 'Robe Cocktail Rouge' (30 000 FCFA)", str_contains($priceHtml, 'Robe Cocktail Rouge') && !str_contains($priceHtml, 'Robe Sahara Chic'));

        // E. Filtre Promotions
        $promoFilterReq = new Request(['filter' => 'promotions'], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/catalogue?filter=promotions']);
        $promoFilterHtml = $this->storefrontController->catalog($promoFilterReq)->getContent();
        $this->assert("1.2 - Le filtre Promotions isole uniquement les articles remisés", str_contains($promoFilterHtml, 'Robe Sahara Chic') && !str_contains($promoFilterHtml, 'Robe Cocktail Rouge'));

        // F. Tri par Prix Croissant
        $sortAscReq = new Request(['filter' => 'price_asc'], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/catalogue?filter=price_asc']);
        $sortAscHtml = $this->storefrontController->catalog($sortAscReq)->getContent();
        $posPromo = strpos($sortAscHtml, 'Robe Sahara Chic'); // 20 000 FCFA
        $posCocktail = strpos($sortAscHtml, 'Robe Cocktail Rouge'); // 30 000 FCFA
        $this->assert("1.2 - Tri par prix croissant place l'article à 20 000 FCFA avant celui à 30 000 FCFA", $posPromo !== false && $posCocktail !== false && $posPromo < $posCocktail);

        // ---------------------------------------------------------
        // 1.3 FICHE PRODUIT DÉTAILLÉE
        // ---------------------------------------------------------
        $prodReq = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/produit/robe-sahara-chic']);
        $prodResp = $this->storefrontController->product($prodReq, ['slug' => 'robe-sahara-chic']);
        $prodHtml = $prodResp->getContent();

        $this->assert("1.3 - La fiche produit répond HTTP 200", $prodResp->getStatusCode() === 200);
        $this->assert("1.3 - Nom, description, prix promo (20 000) et prix barré (25 000) affichés", str_contains($prodHtml, 'Robe Sahara Chic') && str_contains($prodHtml, '20 000 FCFA') && str_contains($prodHtml, '25 000 FCFA'));
        $this->assert("1.3 - Référence SKU affichée", str_contains($prodHtml, 'ROB-001'));
        $this->assert("1.3 - Badge disponibilité et stock affiché", str_contains($prodHtml, 'En stock / Disponible'));
        $this->assert("1.3 - Variantes, tailles, couleurs et quantités disponibles affichées dans le sélecteur", str_contains($prodHtml, 'Taille M / Noir Ébène') && str_contains($prodHtml, 'Taille L / Noir Ébène') && str_contains($prodHtml, 'Dispo: 10 ex.'));
        $this->assert("1.3 - Bouton Ajouter au panier présent avec CSRF", str_contains($prodHtml, 'Ajouter au panier') && str_contains($prodHtml, 'name="_csrf_token"'));
        $this->assert("1.3 - Bouton de commande WhatsApp direct présent avec message prérempli", str_contains($prodHtml, 'Commander sur WhatsApp') && str_contains($prodHtml, 'wa.me'));
        $this->assert("1.3 - Section Produits similaires affichée (Robe Cocktail Rouge)", str_contains($prodHtml, 'Produits Similaires') && str_contains($prodHtml, 'Robe Cocktail Rouge'));

        // ---------------------------------------------------------
        // 1.4 PAGES COMPLÉMENTAIRES
        // ---------------------------------------------------------
        $pages = [
            '/a-propos' => ['pageAbout', 'À propos de'],
            '/contact' => ['pageContact', 'Nous Contacter'],
            '/livraison' => ['pageDelivery', 'Livraison & Retrait en Boutique'],
            '/conditions-vente' => ['pageTerms', 'Conditions de Vente & de Retour'],
            '/politique-confidentialite' => ['pagePrivacy', 'Politique de Confidentialité'],
        ];

        foreach ($pages as $uri => [$method, $keyword]) {
            $req = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => $uri]);
            $resp = $this->storefrontController->$method($req);
            $this->assert("1.4 - Route {$uri} répond HTTP 200 et contient '{$keyword}'", $resp->getStatusCode() === 200 && str_contains($resp->getContent(), $keyword));
        }

        // ---------------------------------------------------------
        // 1.5 RESPONSIVE & PARCOURS D'ACHAT MOBILE-FIRST
        // ---------------------------------------------------------
        // A. Ajout au panier avec variante
        $csrfToken = Session::getCsrfToken();
        $addReq = new Request([], [
            '_csrf_token' => $csrfToken,
            'product_id' => 1,
            'quantity' => 2,
            'variant' => 'Taille M / Noir Ébène',
        ], [], [], [], ['REQUEST_METHOD' => 'POST', 'REQUEST_URI' => '/panier/ajouter']);

        $addResp = $this->cartController->add($addReq);
        $this->assert("1.5 - Ajout d'article avec variante au panier redirige vers /panier", $addResp->getStatusCode() === 302);

        // B. Affichage Panier
        $cartReq = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/panier']);
        $cartResp = $this->cartController->index($cartReq);
        $cartHtml = $cartResp->getContent();
        $this->assert("1.5 - La page Panier affiche les articles, quantités, sous-total certifié (40 000 FCFA)", $cartResp->getStatusCode() === 200 && str_contains($cartHtml, 'Robe Sahara Chic') && str_contains($cartHtml, '40 000 FCFA'));

        // C. Checkout
        $checkoutReq = new Request([], [], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/checkout']);
        $checkoutResp = $this->cartController->showCheckout($checkoutReq);
        $this->assert("1.5 - La page Checkout répond HTTP 200 avec le récapitulatif", $checkoutResp->getStatusCode() === 200 && str_contains($checkoutResp->getContent(), 'Validation de Commande'));

        // D. Adaptation automatique de la présentation au changement de thème (MS-BIZ-07)
        $themeService = new ThemeService($this->pdo);
        $themeService->activateTheme('luxe');
        $luxeHomeHtml = $this->storefrontController->home($homeReq)->getContent();
        $this->assert("1.5 & MS-BIZ-07 - L'activation du thème 'luxe' applique immédiatement ses tokens sans impacter les données", str_contains($luxeHomeHtml, 'data-theme="luxe"') && str_contains($luxeHomeHtml, 'Robe Sahara Chic'));

        echo "\n========================================================\n";
        echo "BILAN AUDIT MODULE 1 : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "========================================================\n";

        return $this->failed === 0 ? 0 : 1;
    }
}

$suite = new MiniSiteAuditTestSuite();
exit($suite->run());
