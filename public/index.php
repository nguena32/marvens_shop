<?php
declare(strict_types=1);

/**
 * Point d'entrée unique de l'application (Front Controller)
 */

// 1. Initialisation du bootstrap (autoloader, env, config)
require_once dirname(__DIR__) . '/bootstrap/app.php';

use App\Core\Request;
use App\Core\Router;
use App\Core\Session;

// 2. Démarrage de session sécurisée
Session::start();

// 3. Initialisation du routeur
$router = new Router();
require_once dirname(__DIR__) . '/routes/web.php';

// 4. Traitement de la requête HTTP entrante
$request = Request::createFromGlobals();
$response = $router->dispatch($request);

// 5. Envoi de la réponse au client
$response->send();
