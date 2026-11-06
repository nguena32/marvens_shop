<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/app.php';

use App\Core\Request;
use App\Core\Router;
use App\Core\Session;

$pdo = new PDO('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
\App\Core\Database::setConnection($pdo);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS shop_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key VARCHAR(100) UNIQUE,
        setting_value TEXT,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS delivery_zones (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        city VARCHAR(100) NOT NULL,
        district VARCHAR(100) NOT NULL,
        fee INTEGER NOT NULL,
        estimated_time VARCHAR(100),
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS activity_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        user_email VARCHAR(255),
        event_type VARCHAR(50),
        ip_address VARCHAR(45),
        user_agent TEXT,
        details TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(100) UNIQUE,
        email VARCHAR(255) UNIQUE,
        password_hash VARCHAR(255),
        role VARCHAR(50) DEFAULT 'merchant_admin',
        name VARCHAR(255),
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_status VARCHAR(50) DEFAULT 'pending'
    );
");

Session::set('user_id', 1);
Session::set('user_email', 'admin@marvens-shop.cm');

$router = new Router();
require_once dirname(__DIR__) . '/routes/web.php';

$routesToTest = [
    '/admin/parametres/boutique',
    '/admin/themes',
    '/admin/parametres/apparence',
    '/admin/parametres/typographie',
    '/admin/parametres/livraison',
    '/admin/parametres/utilisateurs',
    '/admin/parametres/notifications',
    '/admin/parametres/integrations',
    '/admin/parametres/securite',
    '/admin/parametres/analytics'
];

foreach ($routesToTest as $uri) {
    try {
        $req = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => $uri]);
        $res = $router->dispatch($req);
        echo "[STATUS " . $res->getStatusCode() . "] " . $uri . "\n";
    } catch (\Throwable $e) {
        echo "[ERROR 500] " . $uri . " -> " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
}
