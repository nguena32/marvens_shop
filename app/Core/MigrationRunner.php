<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use Exception;

/**
 * Moteur de migrations versionnées indépendant pour cPanel / CLI
 */
class MigrationRunner
{
    private PDO $pdo;
    private string $migrationsDir;

    public function __construct(PDO $pdo, string $migrationsDir)
    {
        $this->pdo = $pdo;
        $this->migrationsDir = rtrim($migrationsDir, '/\\');
        $this->ensureMigrationTable();
    }

    private function ensureMigrationTable(): void
    {
        $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        
        if ($driver === 'sqlite') {
            $sql = "CREATE TABLE IF NOT EXISTS migrations (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                migration VARCHAR(255) NOT NULL,
                applied_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
        } else {
            $sql = "CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        }

        $this->pdo->exec($sql);
    }

    public function getAppliedMigrations(): array
    {
        $stmt = $this->pdo->query("SELECT migration FROM migrations ORDER BY id ASC");
        return $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN) : [];
    }

    public function run(): array
    {
        $applied = $this->getAppliedMigrations();
        $files = glob($this->migrationsDir . '/*.sql');
        sort($files);

        $results = [];

        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $applied, true)) {
                continue;
            }

            $sql = file_get_contents($file);
            if ($sql === false || trim($sql) === '') {
                continue;
            }

            // Exécution sous transaction
            $this->pdo->beginTransaction();
            try {
                // Découpage par requêtes pour compatibilité PDO MySQL
                $queries = array_filter(array_map('trim', explode(';', $sql)));
                foreach ($queries as $query) {
                    if ($query !== '') {
                        $this->pdo->exec($query);
                    }
                }

                $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (:m)");
                $stmt->execute(['m' => $name]);

                $this->pdo->commit();
                $results[] = [
                    'migration' => $name,
                    'status' => 'success',
                ];
            } catch (Exception $e) {
                $this->pdo->rollBack();
                $results[] = [
                    'migration' => $name,
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                ];
                break;
            }
        }

        return $results;
    }
}
