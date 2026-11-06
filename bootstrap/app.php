<?php
declare(strict_types=1);

/**
 * Autoloader PSR-4 sans dépendance Composer pour PHP 8.3+ Vanilla
 */
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Initialisation de l'environnement et de la configuration
use App\Core\Env;
use App\Core\Config;
use App\Core\View;
use App\Core\ErrorHandler;

$rootDir = dirname(__DIR__);
Env::load($rootDir . '/.env');
Config::load($rootDir . '/config');
View::init($rootDir . '/app/Views');

// Enregistrement des gestionnaires d'erreurs et exceptions système
ErrorHandler::register();
