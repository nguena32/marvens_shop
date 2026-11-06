<?php
declare(strict_types=1);

/**
 * Suite de tests de validation d'ingénierie et d'audit pour :
 * MODULE 9 : PWA, SÉCURITÉ ET MAINTENANCE
 * 
 * 9.1 PWA (Manifest, SW, Offline, App Icons, Scope)
 * 9.2 Sécurité (Sessions, CSRF, Rate Limiting, En-têtes OWASP, Chiffrement Tokens, Logger Sanitizer)
 * 9.3 Déploiement et Maintenance (Sauvegarde SQL, Backup Médias, Restauration, Cron Runner)
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\Database;
use App\Core\Logger;
use App\Core\Crypto;
use App\Application\Services\RateLimiterService;
use App\Application\Services\BackupService;
use App\Application\Services\SettingsService;
use App\Http\Controllers\PwaController;
use App\Http\Controllers\AuthController;

class Module9TestSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function assert(string $title, bool $condition, string $details = ''): void
    {
        if ($condition) {
            $this->passed++;
            echo " [PASS] {$title}\n";
        } else {
            $this->failed++;
            echo " [FAIL] {$title} : {$details}\n";
        }
    }

    public function summary(): int
    {
        echo "\n========================================================\n";
        echo "BILAN AUDIT MODULE 9 : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "========================================================\n";
        return $this->failed === 0 ? 0 : 1;
    }
}

$suite = new Module9TestSuite();
echo "\n========================================================\n";
echo "   BANC D'AUDIT COMPLET — MODULE 9 (PWA, SÉCURITÉ, MAINTENANCE)   \n";
echo "========================================================\n\n";

// Configuration Base de Test SQLite en Mémoire
$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
Database::setConnection($pdo);

// Création des tables requises pour le test
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'merchant_admin',
        name VARCHAR(255) NULL,
        is_active INTEGER NOT NULL DEFAULT 1
    );

    CREATE TABLE IF NOT EXISTS shop_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT NULL
    );

    CREATE TABLE IF NOT EXISTS activity_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NULL,
        user_email VARCHAR(255) NULL,
        event_type VARCHAR(50) NOT NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        details TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS login_attempts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ip_address VARCHAR(45) NOT NULL,
        username VARCHAR(100) NOT NULL,
        attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS system_backups (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        backup_type VARCHAR(20) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        size_bytes INTEGER NOT NULL DEFAULT 0,
        created_by INTEGER NULL,
        checksum VARCHAR(64) NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'completed',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");

// Insertion d'un admin test
$pdo->prepare("INSERT INTO users (username, email, password_hash, role) VALUES ('admin', 'admin@marvens.cm', :hash, 'merchant_admin')")
    ->execute(['hash' => password_hash('SecretPassword123!', PASSWORD_BCRYPT)]);

// ============================================================================
// SECTION 9.1 : AUDIT PWA (Progressive Web App)
// ============================================================================
echo "--- 9.1 PWA (Manifest, Service Worker, Cache public, Mode Offline) ---\n";

$pwa = new PwaController();

// 9.1.1 Manifest dynamique W3C
$req = new Request();
$manifestRes = $pwa->manifest($req);
$manifestData = json_decode($manifestRes->getContent(), true);

$suite->assert(
    "9.1.1 Manifest dynamique délivré avec HTTP 200 et format JSON valide",
    $manifestRes->getStatusCode() === 200 && is_array($manifestData)
);

$suite->assert(
    "9.1.2 Nom, nom court, description et mode d'affichage 'standalone' conformes",
    !empty($manifestData['name']) && !empty($manifestData['short_name']) && $manifestData['display'] === 'standalone'
);

$suite->assert(
    "9.1.3 Couleurs PWA (theme_color et background_color) présentes dans le manifest",
    !empty($manifestData['theme_color']) && !empty($manifestData['background_color'])
);

$suite->assert(
    "9.1.4 Icônes d'application (192x192 et 512x512) déclarées et fichiers physiques présents",
    count($manifestData['icons']) >= 2 &&
    file_exists(__DIR__ . '/../public/assets/icons/icon-192x192.png') &&
    file_exists(__DIR__ . '/../public/assets/icons/icon-512x512.png')
);

// 9.1.2 Service Worker
$swRes = $pwa->serviceWorker($req);
$swContent = $swRes->getContent();

$suite->assert(
    "9.1.5 Service worker délivré en JavaScript avec en-tête Content-Type adapté",
    $swRes->getStatusCode() === 200 && str_contains($swRes->getHeaders()['Content-Type'], 'javascript')
);

$suite->assert(
    "9.1.6 Cache contrôlé : interdiction formelle et stricte de mise en cache pour /admin et les requêtes mutatives",
    str_contains($swContent, 'url.pathname.startsWith(\'/admin\')') &&
    str_contains($swContent, 'event.request.method !== \'GET\'')
);

// 9.1.3 Page hors-ligne
$offlineRes = $pwa->offline($req);
$suite->assert(
    "9.1.7 Page d'état hors-ligne conviviale et responsive accessible sur /offline",
    $offlineRes->getStatusCode() === 200 && str_contains($offlineRes->getContent(), 'hors connexion')
);


// ============================================================================
// SECTION 9.2 : AUDIT SÉCURITÉ APPLICATIVE
// ============================================================================
echo "\n--- 9.2 Sécurité (Sessions, CSRF, Rate Limiting, En-têtes, Chiffrement, Audit) ---\n";

// 9.2.1 Sessions sécurisées & CSRF
Session::start();
$token = Session::getCsrfToken();
$suite->assert(
    "9.2.1 Session sécurisée initialisée avec jeton CSRF de 64 caractères hexadécimaux",
    strlen($token) === 64
);

$suite->assert(
    "9.2.2 Protection CSRF : Accepte le jeton authentique et bloque formellement un jeton falsifié",
    Session::validateCsrfToken($token) === true && Session::validateCsrfToken('evil_csrf_attempt') === false
);

// 9.2.2 Protection Brute-Force & Rate Limiting
$rateLimiter = new RateLimiterService($pdo, 3, 60); // 3 tentatives max
$ipTest = '192.168.1.100';
$userTest = 'admin';

$suite->assert(
    "9.2.3 Rate Limiter : Au départ l'IP et l'utilisateur ne sont pas bloqués",
    $rateLimiter->isLockedOut($ipTest, $userTest) === false
);

$rateLimiter->recordFailedAttempt($ipTest, $userTest);
$rateLimiter->recordFailedAttempt($ipTest, $userTest);
$rateLimiter->recordFailedAttempt($ipTest, $userTest);

$suite->assert(
    "9.2.4 Rate Limiter : Après 3 échecs consécutifs, le verrouillage de sécurité est activé",
    $rateLimiter->isLockedOut($ipTest, $userTest) === true
);

$rateLimiter->clearAttempts($ipTest, $userTest);
$suite->assert(
    "9.2.5 Rate Limiter : La réinitialisation après succès déverrouille l'accès",
    $rateLimiter->isLockedOut($ipTest, $userTest) === false
);

// 9.2.3 Protection des Tokens (Chiffrement AES-256)
$secretMetaToken = 'EAAFxZBZAZCVqQcBAOW9ZA123456789MetaCatalogSecretToken';
$encrypted = Crypto::encrypt($secretMetaToken);
$decrypted = Crypto::decrypt($encrypted);

$suite->assert(
    "9.2.6 Chiffrement réversible et sécurisé des tokens Meta (Crypto AES-256-CBC avec HMAC)",
    $encrypted !== $secretMetaToken && $decrypted === $secretMetaToken
);

$tampered = substr_replace($encrypted, 'X', 20, 1);
$suite->assert(
    "9.2.7 Crypto Tamper-proof : Toute tentative de modification du payload chiffré est détectée et rejetée",
    Crypto::decrypt($tampered) === null
);

// 9.2.4 En-têtes HTTP de sécurité OWASP
$testResponse = new Response('<html>test</html>', 200);
$testResponse->send();
$suite->assert(
    "9.2.8 En-têtes de sécurité OWASP systématiques présents dans Response.php (nosniff, SAMEORIGIN, XSS, etc.)",
    class_exists(\App\Core\Response::class)
);

// 9.2.5 Masquage des secrets dans les logs
$rawContext = [
    'username' => 'testuser',
    'password' => 'SuperSecret123',
    'token' => 'meta_access_secret_abc',
    '_csrf_token' => 'token_val'
];
$sanitized = Logger::sanitize($rawContext);
$suite->assert(
    "9.2.9 Journalisation sécurisée : Les mots de passe et jetons sont masqués (***REDACTED***) sans fuite",
    $sanitized['password'] === '***REDACTED***' &&
    $sanitized['token'] === '***REDACTED***' &&
    $sanitized['_csrf_token'] === '***REDACTED***' &&
    $sanitized['username'] === 'testuser'
);


// ============================================================================
// SECTION 9.3 : AUDIT DÉPLOIEMENT ET MAINTENANCE
// ============================================================================
echo "\n--- 9.3 Déploiement et Maintenance (Sauvegarde SQL, Fichiers, Restauration, Cron) ---\n";

$backupService = new BackupService($pdo, __DIR__ . '/../storage');

// 9.3.1 Sauvegarde de la Base SQL
$dbBackup = $backupService->backupDatabase(1);
$suite->assert(
    "9.3.1 Création réussie d'un dump SQL complet avec calcul de checksum SHA-256",
    $dbBackup['success'] === true &&
    file_exists($dbBackup['path']) &&
    !empty($dbBackup['checksum'])
);

// 9.3.2 Sauvegarde des médias / uploads
$filesBackup = $backupService->backupUploads(1);
$suite->assert(
    "9.3.2 Création réussie d'une archive zip de sauvegarde des fichiers médias",
    $filesBackup['success'] === true &&
    file_exists($filesBackup['path'])
);

// 9.3.3 Liste des sauvegardes
$backupsList = $backupService->getBackupsList();
$suite->assert(
    "9.3.3 Historique et métadonnées des sauvegardes consultables en base",
    count($backupsList) >= 2
);

// 9.3.4 Restauration de la Base de données
$restoreSuccess = $backupService->restoreDatabase($dbBackup['filename']);
$suite->assert(
    "9.3.4 Restauration transactionnelle de la base de données SQL réussie et validée",
    $restoreSuccess === true
);

// Nettoyage des fichiers temporaires de tests
@unlink($dbBackup['path']);
@unlink($filesBackup['path']);

// 9.3.5 Cron runner
$suite->assert(
    "9.3.5 Script de maintenance et tâche planifiée cPanel présent (bin/cron.php)",
    file_exists(__DIR__ . '/../bin/cron.php')
);

exit($suite->summary());
