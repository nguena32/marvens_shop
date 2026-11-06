<?php
declare(strict_types=1);

/**
 * Runner de maintenance cPanel pour cron job automatisé
 * Exécute :
 * - Nettoyage des vieilles sessions
 * - Purge des tentatives de brute-force expirées
 * - Sauvegarde quotidienne automatique de la base de données
 * Usage cPanel cron : php /path/to/bin/cron.php
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Logger;
use App\Application\Services\RateLimiterService;
use App\Application\Services\BackupService;

echo "[" . date('Y-m-d H:i:s') . "] Démarrage de la maintenance cPanel...\n";

try {
    $pdo = Database::getConnection();

    // 1. Purge du Rate Limiting
    $rateLimiter = new RateLimiterService($pdo);
    $rateLimiter->cleanup();
    echo " [OK] Tentatives de connexion expirées nettoyées.\n";

    // 2. Nettoyage des sessions PHP privées expirées (> 7 jours)
    $sessionDir = dirname(__DIR__) . '/storage/sessions';
    if (is_dir($sessionDir)) {
        $files = glob($sessionDir . '/sess_*');
        $now = time();
        $deleted = 0;
        foreach ($files as $file) {
            if (is_file($file) && ($now - filemtime($file) > 604800)) {
                @unlink($file);
                $deleted++;
            }
        }
        echo " [OK] Sessions périmées nettoyées ({$deleted} fichiers supprimés).\n";
    }

    // 3. Sauvegarde automatique quotidienne de la base de données
    $backupService = new BackupService($pdo);
    $res = $backupService->backupDatabase(null);
    echo " [OK] Sauvegarde quotidienne de la base créée : {$res['filename']} ({$res['size']} octets).\n";

    // 4. Purge des anciens logs de journalisation selon la durée de rétention
    $prunedLogs = Logger::pruneOldLogs();
    echo " [OK] Purge des anciens fichiers de logs ({$prunedLogs} fichiers supprimés).\n";

    Logger::info("Maintenance cron cPanel exécutée avec succès.", ['pruned_logs' => $prunedLogs]);
    echo "Maintenance terminée avec succès.\n";
} catch (\Exception $e) {
    Logger::error("Erreur critique lors du cron de maintenance", ['error' => $e->getMessage()]);
    echo " [ERREUR] " . $e->getMessage() . "\n";
    exit(1);
}
