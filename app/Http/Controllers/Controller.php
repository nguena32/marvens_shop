<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Core\Session;

/**
 * Contrôleur de base fournissant les utilitaires de rendu et de redirection
 */
abstract class Controller
{
    protected function render(string $view, array $data = []): Response
    {
        // Injecter systématiquement le token CSRF et les flash messages
        $data['csrf_token'] = Session::getCsrfToken();
        $html = View::render($view, $data);
        return Response::html($html);
    }

    protected function json(array $data, int $statusCode = 200): Response
    {
        return Response::json($data, $statusCode);
    }

    protected function redirect(string $url, int $statusCode = 302): Response
    {
        return Response::redirect($url, $statusCode);
    }

    protected function validateCsrf(Request $request): void
    {
        $token = $request->input('_csrf_token');
        if (!Session::validateCsrfToken($token)) {
            \App\Core\Logger::security("Échec de validation du jeton CSRF", [
                'uri' => $request->getPath(),
                'method' => $request->getMethod(),
            ]);
            http_response_code(403);
            throw new \RuntimeException("Session expirée ou jeton CSRF invalide (403 Forbidden).");
        }
    }
}
