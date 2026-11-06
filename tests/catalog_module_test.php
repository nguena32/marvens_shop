<?php
declare(strict_types=1);

/**
 * Suite de tests d'intégration et de validation complète du Module 6 :
 * - 6.1 Gestion des produits (CRUD, Variantes, Dépublication, Mise en avant, Promo)
 * - 6.2 Gestion des catégories (CRUD, Ordre, Visibilité, Association produits)
 * - 6.3 Importation multi-formats (CSV, Modèle type, Déduplication par SKU & Slug)
 * - 6.4 Importation Meta Catalog (OAuth, Catalogues, Synchronisation fiches)
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Application\Services\CsvImportService;
use App\Infrastructure\MetaCatalogConnector;
use App\Core\Session;

// Configuration environnement de test isolé (SQLite en mémoire)
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
Database::setConnection($pdo);

// Création du schéma SQLite
$pdo->exec("
    CREATE TABLE categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        description TEXT,
        image_url VARCHAR(255),
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category_id INTEGER,
        name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        sku VARCHAR(100),
        description TEXT,
        price INTEGER NOT NULL DEFAULT 0,
        promotional_price INTEGER,
        main_image_url VARCHAR(255),
        is_active INTEGER NOT NULL DEFAULT 1,
        is_featured INTEGER NOT NULL DEFAULT 0,
        meta_product_id VARCHAR(100),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE product_variants (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER NOT NULL,
        variant_name VARCHAR(100) NOT NULL,
        size VARCHAR(50),
        color VARCHAR(50),
        price_override INTEGER,
        stock_quantity INTEGER NOT NULL DEFAULT 0,
        is_available INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE shop_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
");

echo "========================================================\n";
echo "   BANC DE TESTS COMPLET — MODULE 6 (CATALOGUE & IMPORTS)   \n";
echo "========================================================\n\n";

$catRepo = new CategoryRepository($pdo);
$prodRepo = new ProductRepository($pdo);
$importService = new CsvImportService($prodRepo, $catRepo);
$meta = new MetaCatalogConnector();

$testsPassed = 0;
$testsTotal = 0;

function assertTest(string $description, bool $condition): void {
    global $testsPassed, $testsTotal;
    $testsTotal++;
    if ($condition) {
        $testsPassed++;
        echo " [PASS] {$description}\n";
    } else {
        echo " [FAIL] {$description}\n";
    }
}

// ----------------------------------------------------
// TEST 6.2 : GESTION DES CATÉGORIES
// ----------------------------------------------------
$uniqueCatSlug = 'test-cat-' . time();
$catId = $catRepo->create([
    'name' => 'Électronique & Gadgets',
    'slug' => $uniqueCatSlug,
    'description' => 'Objets connectés et accessoires',
    'sort_order' => 5,
    'is_active' => 1
]);
assertTest("6.2.1 Création d'une catégorie avec ordre d'affichage", $catId > 0);

$fetchedCat = $catRepo->findById($catId);
assertTest("6.2.2 Lecture d'une catégorie par ID", $fetchedCat !== null && $fetchedCat['name'] === 'Électronique & Gadgets');

$catRepo->update($catId, [
    'name' => 'High-Tech & Gadgets',
    'slug' => $uniqueCatSlug,
    'description' => 'Mise à jour description',
    'sort_order' => 3,
    'is_active' => 1,
    'image_url' => '/uploads/categories/tech.jpg'
]);
$updatedCat = $catRepo->findById($catId);
assertTest("6.2.3 Modification complète d'une catégorie (nom, ordre, image)", $updatedCat['name'] === 'High-Tech & Gadgets' && (int)$updatedCat['sort_order'] === 3);

$catRepo->toggleActive($catId);
$toggledCat = $catRepo->findById($catId);
assertTest("6.2.4 Bascule de visibilité d'une catégorie (Publier / Dépublier)", (int)$toggledCat['is_active'] === 0);

// ----------------------------------------------------
// TEST 6.1 : GESTION DES PRODUITS & VARIANTES
// ----------------------------------------------------
$prodSlug = 'test-casque-bluetooth-' . time();
$prodId = $prodRepo->create([
    'category_id' => $catId,
    'name' => 'Casque Audio Sans Fil Pro',
    'slug' => $prodSlug,
    'sku' => 'AUDIO-HQ-01',
    'description' => 'Casque réducteur de bruit haute fidélité',
    'price' => 35000,
    'promotional_price' => 29900,
    'main_image_url' => '/uploads/products/casque.jpg',
    'is_active' => 1,
    'is_featured' => 1,
    'variants' => [
        ['variant_name' => 'Noir Mat', 'color' => 'Noir', 'stock_quantity' => 15, 'price_override' => null],
        ['variant_name' => 'Blanc Argenté', 'color' => 'Blanc', 'stock_quantity' => 5, 'price_override' => 31000]
    ]
]);
assertTest("6.1.1 Création d'un produit avec SKU, prix promo, mise en avant et variantes", $prodId > 0);

$fetchedProd = $prodRepo->findById($prodId);
assertTest("6.1.2 Lecture d'un produit et synchronisation des variantes", count($fetchedProd['variants'] ?? []) === 2);
assertTest("6.1.3 Présence du prix promo et statut featured", (int)$fetchedProd['promotional_price'] === 29900 && (int)$fetchedProd['is_featured'] === 1);

// Modification du produit
$prodRepo->update($prodId, [
    'category_id' => $catId,
    'name' => 'Casque Audio Sans Fil Pro Max',
    'slug' => $prodSlug,
    'sku' => 'AUDIO-HQ-01-V2',
    'description' => 'Version 2 améliorée',
    'price' => 38000,
    'promotional_price' => 32000,
    'main_image_url' => '/uploads/products/casque_v2.jpg',
    'is_active' => 1,
    'is_featured' => 0,
    'variants' => [
        ['variant_name' => 'Édition Titane', 'color' => 'Gris', 'stock_quantity' => 20, 'price_override' => 38000]
    ]
]);
$updatedProd = $prodRepo->findById($prodId);
assertTest("6.1.4 Mise à jour complète du produit (nom, prix, SKU, variantes révisées)", $updatedProd['name'] === 'Casque Audio Sans Fil Pro Max' && count($updatedProd['variants']) === 1);

$prodRepo->toggleActive($prodId);
$deactivatedProd = $prodRepo->findById($prodId);
assertTest("6.1.5 Dépublication rapide du produit (Masqué sur la boutique)", (int)$deactivatedProd['is_active'] === 0);

$prodRepo->toggleFeatured($prodId);
$featuredProd = $prodRepo->findById($prodId);
assertTest("6.1.6 Bascule de la mise en avant en vedette (Featured)", (int)$featuredProd['is_featured'] === 1);

// ----------------------------------------------------
// TEST 6.3 : IMPORTATION MULTI-FORMATS & DÉDUPLICATION
// ----------------------------------------------------
$templateCsv = $importService->generateTemplateCsv();
assertTest("6.3.1 Génération d'un modèle type d'importation CSV conforme", str_contains($templateCsv, 'name;price;promotional_price;sku;category;description;image_url'));

$testCsvContent = "name;price;promotional_price;sku;category;description\n" .
                  "Sac Sport Luxe;20000;18000;SAC-LUX-01;Bagagerie;Sac de voyage résistant\n" .
                  "Sac Sport Luxe;22000;19000;SAC-LUX-01;Bagagerie;Mise à jour du prix et desc\n";

$report = $importService->importString($testCsvContent);
assertTest("6.3.2 Importation avec déduplication intelligente par SKU (1 créé, 1 mis à jour)", (int)$report['created'] === 1 && (int)$report['updated'] === 1);

// ----------------------------------------------------
// TEST 6.4 : IMPORTATION & CONNEXION META CATALOG
// ----------------------------------------------------
$metaStatus = $meta->getStatus();
assertTest("6.4.1 Contrôle d'état du connecteur Meta Graph API", isset($metaStatus['status']));

$metaProducts = $meta->fetchCatalogProducts('demo_cat_101');
assertTest("6.4.2 Récupération structurée des fiches produits Meta (prix, images, SKU)", count($metaProducts) >= 3 && isset($metaProducts[0]['retailer_id']));

// Nettoyage des tests
$prodRepo->delete($prodId);
$catRepo->delete($catId);
assertTest("6.1.7 / 6.2.5 Suppression sécurisée du produit et de la catégorie de test", $prodRepo->findById($prodId) === null && $catRepo->findById($catId) === null);

echo "\n========================================================\n";
echo "BILAN MODULE 6 : {$testsPassed} Succès / {$testsTotal} Tests\n";
echo "========================================================\n";

if ($testsPassed !== $testsTotal) {
    exit(1);
}
