<?php
declare(strict_types=1);

/**
 * Suite de tests de validation finale — Étape 5 (Import CSV, Connecteur Meta, Sécurité & Recette)
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Application\Services\CsvImportService;
use App\Infrastructure\MetaCatalogConnector;

class Etape5ValidationTestSuite
{
    private int $passed = 0;
    private int $failed = 0;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Database::setConnection($this->pdo);

        $this->pdo->exec("
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
        echo "   BANC DE RECETTE FINALE & INTÉGRATIONS — ÉTAPE 5     \n";
        echo "========================================================\n\n";

        $productRepo = new ProductRepository($this->pdo);
        $categoryRepo = new CategoryRepository($this->pdo);
        $csvService = new CsvImportService($productRepo, $categoryRepo);

        // 1. Test Import CSV via flux de texte
        $csvContent = "name,price,sku,promotional_price\n";
        $csvContent .= "Chemise Lin Beige,14000,CHEM-01,12000\n";
        $csvContent .= "Pantalon Chino Kaki,16000,PANT-02,\n";
        $csvContent .= "Article Invalide,prix_non_numerique,ERR-01,\n"; // Ligne en anomalie

        $report = $csvService->importString($csvContent);

        $this->assert(
            "Import CSV : 2 produits créés et 1 ligne en anomalie détectée proprement",
            $report['created'] === 2 && count($report['errors']) === 1
        );

        $importedProducts = $productRepo->findAllActive();
        $this->assert(
            "Persistance effective des articles importés dans la base de données",
            count($importedProducts) === 2 && (int) $importedProducts[0]['price'] === 14000
        );

        // 2. Test Connecteur Meta en mode transparent (Règle d'isolation)
        $metaConnector = new MetaCatalogConnector();
        $status = $metaConnector->getStatus();

        $this->assert(
            "Le connecteur Meta retourne le statut 'BLOCKED_EXTERNAL' en l'absence de credentials sans planter",
            $status['status'] === 'BLOCKED_EXTERNAL' && $status['configured'] === false
        );

        // 3. Test Sécurité : Échappement et protection contre les injections XSS
        $xssInput = "<script>alert('xss')</script>";
        $escaped = \App\Core\View::escape($xssInput);
        $this->assert(
            "La couche de vue neutralise les balises scripts (XSS)",
            !str_contains($escaped, '<script>') && str_contains($escaped, '&lt;script&gt;')
        );

        echo "\n========================================================\n";
        echo "BILAN ÉTAPE 5 : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "========================================================\n";

        return $this->failed === 0 ? 0 : 1;
    }
}

$test = new Etape5ValidationTestSuite();
exit($test->runAll());
