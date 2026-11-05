<?php
declare(strict_types=1);

/**
 * Runner de migration en ligne de commande pour cPanel / Local
 * Usage : php bin/migrate.php
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\MigrationRunner;

echo "=== MARVENS SHOP — EXÉCUTION DES MIGRATIONS ===\n";

try {
    $pdo = Database::getConnection();
    $runner = new MigrationRunner($pdo, __DIR__ . '/../database/migrations');
    
    $results = $runner->run();
    if (empty($results)) {
        echo "Aucune nouvelle migration à appliquer. La base est à jour.\n";
    } else {
        foreach ($results as $res) {
            if ($res['status'] === 'success') {
                echo " [SUCCÈS] Migration appliquée : {$res['migration']}\n";
            } else {
                echo " [ÉCHEC] Erreur sur {$res['migration']} : {$res['error']}\n";
            }
        }
    }
} catch (Exception $e) {
    echo "Erreur fatale : " . $e->getMessage() . "\n";
    exit(1);
}
