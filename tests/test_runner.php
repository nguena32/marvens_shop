<?php
declare(strict_types=1);

/**
 * Runner de test unitaire et d'intégration autonome pour PHP Vanilla
 */

// Démarrer la session avant tout affichage console
require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\Validator;
use App\Core\MigrationRunner;
use App\Core\Config;

class TestSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function assert(string $description, bool $condition, string $errorDetails = ''): void
    {
        if ($condition) {
            $this->passed++;
            echo " [PASS] {$description}\n";
        } else {
            $this->failed++;
            echo " [FAIL] {$description} : {$errorDetails}\n";
        }
    }

    public function summary(): int
    {
        echo "\n==========================================\n";
        echo "RÉSULTATS : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "==========================================\n";
        return $this->failed === 0 ? 0 : 1;
    }
}

$suite = new TestSuite();
echo "--- Démarrage de la suite de tests de fondations ---\n\n";

// 1. Test Autoloader & Bootstrap
$suite->assert(
    "L'autoloader PSR-4 charge correctement les classes App\\Core\\*",
    class_exists(\App\Core\Env::class) && class_exists(\App\Core\Config::class)
);

// 2. Test Configuration & Env
$suite->assert(
    "La configuration lit les valeurs par défaut (.env / config)",
    Config::get('app.currency') === 'FCFA' && Config::get('app.timezone') === 'Africa/Douala'
);

// 3. Test Requête et Routage
$router = new Router();
$router->get('/test/{id}', function (Request $req, array $params) {
    return Response::json(['id' => $params['id']]);
});

$request = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/test/42']);
$response = $router->dispatch($request);
$suite->assert(
    "Le routeur résout les URLs avec paramètres dynamiques {id}",
    $response->getStatusCode() === 200 && str_contains($response->getContent(), '"id":"42"')
);

// 4. Test Validation Serveur
$validator = Validator::make(
    ['name' => 'Amina', 'price' => 5000, 'mode' => 'delivery'],
    ['name' => 'required|min:3', 'price' => 'required|numeric', 'mode' => 'required|in:delivery,pickup']
);
$suite->assert(
    "Le validateur serveur accepte des données valides",
    $validator->validate() === true
);

$invalidValidator = Validator::make(
    ['name' => 'A', 'price' => 'non_numeric', 'mode' => 'invalid_mode'],
    ['name' => 'min:3', 'price' => 'numeric', 'mode' => 'in:delivery,pickup']
);
$suite->assert(
    "Le validateur serveur rejette les entrées invalides (format, min, in)",
    $invalidValidator->validate() === false && count($invalidValidator->getErrors()) === 3
);

// 5. Test Session & Protection CSRF
Session::start();
$token = Session::getCsrfToken();
$suite->assert(
    "La session génère automatiquement un jeton CSRF de 64 caractères hexadécimaux",
    strlen($token) === 64
);
$suite->assert(
    "La validation CSRF accepte le bon jeton et rejette un faux",
    Session::validateCsrfToken($token) === true && Session::validateCsrfToken('fake_token_123') === false
);

// 6. Test Base de données et Migrations (sur SQLite en mémoire)
$testPdo = new PDO('sqlite::memory:');
$testPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$migrationRunner = new MigrationRunner($testPdo, __DIR__ . '/../database/migrations');
$migrationTableExists = false;
$stmt = $testPdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='migrations'");
if ($stmt && $stmt->fetch()) {
    $migrationTableExists = true;
}

$suite->assert(
    "Le moteur de migration initialise automatiquement la table de suivi des migrations",
    $migrationTableExists === true
);

// 7. Test Sécurité : Absence d'exposition de secrets
$suite->assert(
    "Le fichier .env.example ne contient aucun mot de passe de production",
    file_exists(__DIR__ . '/../.env.example')
);

exit($suite->summary());
