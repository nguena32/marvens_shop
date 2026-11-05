<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Config;
use App\Core\Database;
use Exception;

/**
 * Contrôleur de santé technique pour les tests automatisés et sondes de supervision
 */
class HealthController extends Controller
{
    public function check(Request $request): Response
    {
        $dbStatus = 'disconnected';
        $dbError = null;

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->query('SELECT 1');
            if ($stmt !== false) {
                $dbStatus = 'connected';
            }
        } catch (Exception $e) {
            $dbError = Config::get('app.debug') ? $e->getMessage() : 'Erreur de connexion base de données';
        }

        return $this->json([
            'status' => $dbStatus === 'connected' ? 'ok' : 'degraded',
            'app' => Config::get('app.name'),
            'env' => Config::get('app.env'),
            'php_version' => PHP_VERSION,
            'database' => [
                'status' => $dbStatus,
                'error' => $dbError,
            ],
            'timestamp' => date('c'),
        ]);
    }
}
