<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use Exception;

/**
 * Gestionnaire Singleton de connexion PDO
 */
class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::createConnection();
        }

        return self::$instance;
    }

    public static function setConnection(?PDO $pdo): void
    {
        self::$instance = $pdo;
    }

    private static function createConnection(): PDO
    {
        $default = Config::get('database.default', 'mysql');
        $config = Config::get("database.connections.{$default}");

        if (!$config) {
            throw new Exception("Configuration de base de données introuvable pour la connexion : {$default}");
        }

        if ($default === 'sqlite') {
            $dsn = "sqlite:" . $config['database'];
            return new PDO($dsn, null, null, $config['options'] ?? []);
        }

        // MySQL standard
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset'] ?? 'utf8mb4'
        );

        return new PDO(
            $dsn,
            $config['username'],
            $config['password'],
            $config['options'] ?? [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }
}
