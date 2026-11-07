<?php
declare(strict_types=1);

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Logger;
use App\Core\ErrorHandler;
use App\Core\Config;

class LoggerTestSuite
{
    private int $passed = 0;
    private int $failed = 0;

    public function assert(string $desc, bool $condition): void
    {
        if ($condition) {
            echo " [PASS] {$desc}\n";
            $this->passed++;
        } else {
            echo " [FAIL] {$desc}\n";
            $this->failed++;
        }
    }

    public function summary(): void
    {
        echo "\n========================================================\n";
        echo "BILAN TESTS SYSTÈME DE LOGS : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "========================================================\n";
        if ($this->failed > 0) {
            exit(1);
        }
    }
}

$suite = new LoggerTestSuite();
echo "========================================================\n";
echo "   BANC DE VALIDATION DU SYSTÈME CENTRALISÉ DE LOGS     \n";
echo "========================================================\n\n";

$logDir = dirname(__DIR__) . '/storage/logs';
$today = date('Y-m-d');

// 1. Test correlation_id / request_id
$reqId = Logger::getCorrelationId();
$suite->assert("1. Génération et persistance d'un request_id unique", !empty($reqId) && strlen($reqId) >= 16);

// 2. Test Redaction / Sécurité OWASP
$sensitiveData = [
    'password' => 'secret_pass_123',
    'token' => 'bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9',
    '_csrf_token' => 'csrf_token_value_abc',
    'cookie' => 'PHPSESSID=abcdef123456',
    'app_secret' => 'top_secret',
    'card_number' => '4000123456789010',
    'cvv' => '123',
    'normal_field' => 'valeur_normale',
    'nested' => [
        'private_key' => 'super_private',
        'email' => 'client@test.cm'
    ]
];
$cleaned = Logger::sanitize($sensitiveData);
$suite->assert("2.1 Redaction des mots de passe", $cleaned['password'] === '***REDACTED***');
$suite->assert("2.2 Redaction des jetons (token / bearer)", $cleaned['token'] === '***REDACTED***');
$suite->assert("2.3 Redaction des jetons CSRF", $cleaned['_csrf_token'] === '***REDACTED***');
$suite->assert("2.4 Redaction des cookies et session ID", $cleaned['cookie'] === '***REDACTED***');
$suite->assert("2.5 Redaction des secrets d'applications", $cleaned['app_secret'] === '***REDACTED***');
$suite->assert("2.6 Redaction des données de carte (numéro + cvv)", $cleaned['card_number'] === '***REDACTED***' && $cleaned['cvv'] === '***REDACTED***');
$suite->assert("2.7 Redaction récursive imbriquée", $cleaned['nested']['private_key'] === '***REDACTED***');
$suite->assert("2.8 Préservation des données non sensibles", $cleaned['normal_field'] === 'valeur_normale' && $cleaned['nested']['email'] === 'client@test.cm');

// 3. Test Écriture et structuration JSON Lines dans app-YYYY-MM-DD.log
$testMsgApp = "Test unitaire journal applicatif " . uniqid();
Logger::info($testMsgApp, ['action' => 'unit_test', 'status' => 'ok']);
$appLogFile = "{$logDir}/app-{$today}.log";
$suite->assert("3.1 Présence du fichier app-{$today}.log", file_exists($appLogFile));

$content = file_get_contents($appLogFile);
$suite->assert("3.2 Message correctement inscrit dans app-{$today}.log", str_contains($content, $testMsgApp));

// Vérification de la structure JSON Lines
$lines = array_values(array_filter(explode(PHP_EOL, trim($content))));
$lastLine = end($lines);
$record = json_decode((string)$lastLine, true);
$suite->assert("3.3 Entrée conforme JSON valide", is_array($record));
$suite->assert("3.4 Horodatage ISO 8601 (ATOM) présent", isset($record['timestamp']) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $record['timestamp']) === 1);
$suite->assert("3.5 Request ID présent dans l'entrée", isset($record['request_id']) && $record['request_id'] === $reqId);
$suite->assert("3.6 Canal 'app' et niveau 'INFO' conformes", isset($record['channel']) && $record['channel'] === 'app' && isset($record['level']) && $record['level'] === 'INFO');
$suite->assert("3.7 Contexte HTTP structuré", isset($record['http']['method']) && isset($record['http']['uri']));

// 4. Test Canal PHP
$testMsgPhp = "Test journalisation canal PHP " . uniqid();
Logger::log(Logger::WARNING, $testMsgPhp, ['code' => E_USER_WARNING], 'php');
$phpLogFile = "{$logDir}/php-{$today}.log";
$suite->assert("4.1 Présence et écriture dans php-{$today}.log", file_exists($phpLogFile) && str_contains(file_get_contents($phpLogFile), $testMsgPhp));

// 5. Test Canal Database
$testMsgDb = "Test journalisation canal Database " . uniqid();
Logger::database($testMsgDb, ['query_type' => 'SELECT', 'table' => 'orders']);
$dbLogFile = "{$logDir}/database-{$today}.log";
$suite->assert("5.1 Présence et écriture dans database-{$today}.log", file_exists($dbLogFile) && str_contains(file_get_contents($dbLogFile), $testMsgDb));

// 6. Test Canal Security
$testMsgSec = "Test alerte intrusion " . uniqid();
Logger::security($testMsgSec, ['ip' => '10.0.0.1', 'target' => 'admin_login']);
$secLogFile = "{$logDir}/security-{$today}.log";
$suite->assert("6.1 Présence et écriture dans security-{$today}.log", file_exists($secLogFile) && str_contains(file_get_contents($secLogFile), $testMsgSec));

// 7. Test Canal Integrations
$testMsgInt = "Test timeout WhatsApp API " . uniqid();
Logger::integration($testMsgInt, ['service' => 'whatsapp_gateway', 'http_code' => 504]);
$intLogFile = "{$logDir}/integrations-{$today}.log";
$suite->assert("7.1 Présence et écriture dans integrations-{$today}.log", file_exists($intLogFile) && str_contains(file_get_contents($intLogFile), $testMsgInt));

// 8. Test Protection Injection CRLF
$crlfPayload = "Ligne 1\r\nInjectée Ligne 2\nInjectée Ligne 3";
Logger::info($crlfPayload, ['meta' => 'test']);
$freshContent = file_get_contents($appLogFile);
$suite->assert("8. Neutralisation des retours à la ligne CRLF pour empêcher l'injection de fausses lignes de log", !str_contains($freshContent, "Injectée Ligne 2\n") && str_contains($freshContent, "Ligne 1 Injectée Ligne 2 Injectée Ligne 3"));

// 9. Test Protection du répertoire contre accès HTTP direct (.htaccess)
$htaccessStorage = dirname(__DIR__) . '/storage/.htaccess';
$htaccessLogs = "{$logDir}/.htaccess";
$suite->assert("9.1 Présence du fichier .htaccess protecteur dans storage/", file_exists($htaccessStorage) && str_contains(file_get_contents($htaccessStorage), 'Require all denied'));
$suite->assert("9.2 Présence du fichier .htaccess protecteur dans storage/logs/", file_exists($htaccessLogs) && str_contains(file_get_contents($htaccessLogs), 'Require all denied'));

// 10. Test Purge et Rétention
$fakeOldFile = "{$logDir}/app-2025-01-01.log";
file_put_contents($fakeOldFile, "Log ancien de test");
touch($fakeOldFile, time() - (40 * 86400)); // 40 jours dans le passé
$pruned = Logger::pruneOldLogs();
$suite->assert("10. Rotation & Purge : Les logs dépassant la rétention sont supprimés", $pruned >= 1 && !file_exists($fakeOldFile));

$suite->summary();
