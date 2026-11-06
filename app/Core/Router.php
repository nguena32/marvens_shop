<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Routeur HTTP Vanilla sans framework
 */
class Router
{
    private array $routes = [];
    private array $namedRoutes = [];

    public function get(string $path, array|callable $handler, string $name = ''): void
    {
        $this->addRoute('GET', $path, $handler, $name);
    }

    public function post(string $path, array|callable $handler, string $name = ''): void
    {
        $this->addRoute('POST', $path, $handler, $name);
    }

    public function addRoute(string $method, string $path, array|callable $handler, string $name = ''): void
    {
        $path = '/' . trim($path, '/');
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        // Convertir {param} en regex (?P<param>[^/]+)
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'pattern' => $pattern,
            'handler' => $handler,
            'name' => $name,
        ];

        if ($name !== '') {
            $this->namedRoutes[$name] = $path;
        }
    }

    public function dispatch(Request $request): Response
    {
        $requestMethod = $request->getMethod();
        $requestPath = $request->getPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($route['pattern'], $requestPath, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return $this->executeHandler($route['handler'], $request, $params);
            }
        }

        // 404 Not Found
        Logger::notice("Route 404 introuvable", [
            'method' => $requestMethod,
            'path' => $requestPath,
        ]);

        return Response::html(
            '<h1>404 — Page non trouvée</h1><p>La ressource demandée n\'existe pas.</p>',
            404
        );
    }

    private function executeHandler(array|callable $handler, Request $request, array $params): Response
    {
        if (is_callable($handler)) {
            $result = call_user_func($handler, $request, $params);
            return $this->normalizeResponse($result);
        }

        if (is_array($handler) && count($handler) === 2) {
            [$class, $method] = $handler;
            if (!class_exists($class)) {
                throw new \RuntimeException("Contrôleur introuvable : {$class}");
            }
            $controller = new $class();
            if (!method_exists($controller, $method)) {
                throw new \RuntimeException("Méthode {$method} introuvable sur {$class}");
            }
            $result = call_user_func([$controller, $method], $request, $params);
            return $this->normalizeResponse($result);
        }

        throw new \InvalidArgumentException("Format de gestionnaire de route invalide");
    }

    private function normalizeResponse(mixed $result): Response
    {
        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result)) {
            return Response::html($result);
        }

        if (is_array($result)) {
            return Response::json($result);
        }

        return Response::html((string) $result);
    }
}
