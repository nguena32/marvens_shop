<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Gestionnaire d'erreurs, d'exceptions et de shutdown pour Marvens Shop
 * Enregistre au niveau système les handlers PHP et génère des réponses utilisateurs sécurisées
 */
class ErrorHandler
{
    private static bool $registered = false;

    /**
     * Enregistre les gestionnaires d'erreurs une seule fois
     */
    public static function register(): void
    {
        if (self::$registered) {
            return;
        }

        // Configuration PHP d'affichage selon l'environnement
        $isDebug = (bool)Config::get('app.debug', false);
        if ($isDebug) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        }

        // 1. Error Handler PHP
        set_error_handler([self::class, 'handleError']);

        // 2. Exception Handler PHP
        set_exception_handler([self::class, 'handleException']);

        // 3. Shutdown Handler PHP (erreurs fatales non interceptées : E_ERROR, E_PARSE, E_CORE_ERROR...)
        register_shutdown_function([self::class, 'handleShutdown']);

        self::$registered = true;
    }

    /**
     * Gestionnaire des erreurs PHP natives convertibles ou avertissements
     */
    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        // Si l'erreur a été supprimée avec l'opérateur @
        if (!(error_reporting() & $severity)) {
            return false;
        }

        $level = match ($severity) {
            E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR => Logger::ERROR,
            E_WARNING, E_CORE_WARNING, E_COMPILE_WARNING, E_USER_WARNING => Logger::WARNING,
            E_NOTICE, E_USER_NOTICE => Logger::NOTICE,
            default => Logger::WARNING,
        };

        // Journalisation dans le canal PHP dédié
        Logger::log($level, $message, [
            'file' => $file,
            'line' => $line,
            'code' => $severity,
        ], 'php');

        // Pour les erreurs fatales en environnement standard, on peut lever une ErrorException
        if ($severity === E_USER_ERROR || $severity === E_RECOVERABLE_ERROR) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        }

        return true;
    }

    /**
     * Gestionnaire des exceptions non capturées
     */
    public static function handleException(\Throwable $exception): void
    {
        $requestId = Logger::getCorrelationId();

        // Détection canal : base de données ou applicatif/php
        $channel = 'app';
        if ($exception instanceof \PDOException) {
            $channel = 'database';
        }

        // Journalisation complète avec stack trace
        Logger::log(Logger::CRITICAL, "Exception non interceptée : " . $exception->getMessage(), [
            'exception' => $exception,
        ], $channel);

        // Rendu de la réponse d'erreur sécurisée pour l'utilisateur
        self::renderErrorResponse($exception, $requestId);
    }

    /**
     * Gestionnaire de fin d'exécution pour capturer les erreurs fatales (shutdown)
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING], true)) {
            $requestId = Logger::getCorrelationId();

            Logger::log(Logger::EMERGENCY, "Erreur fatale PHP capturée au shutdown : {$error['message']}", [
                'file' => $error['file'],
                'line' => $error['line'],
                'code' => $error['type'],
            ], 'php');

            // Si aucune réponse n'a été envoyée
            if (!headers_sent()) {
                self::renderFatalResponse($error['message'], $requestId);
            }
        }
    }

    /**
     * Rendu de la réponse HTTP utilisateur sécurisée
     */
    public static function renderErrorResponse(\Throwable $exception, string $requestId): void
    {
        $isDebug = (bool)Config::get('app.debug', false);
        $isJson = (!empty($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) ||
                  (!empty($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json'));

        if (!headers_sent()) {
            http_response_code(500);
            header('X-Request-Id: ' . $requestId);
            if ($isJson) {
                header('Content-Type: application/json; charset=UTF-8');
            } else {
                header('Content-Type: text/html; charset=UTF-8');
            }
        }

        if ($isJson) {
            $payload = [
                'success' => false,
                'error' => 'Une erreur interne est survenue sur le serveur.',
                'request_id' => $requestId,
            ];

            if ($isDebug) {
                $payload['debug'] = [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'class' => get_class($exception),
                ];
            }

            echo json_encode($payload, JSON_UNESCAPED_UNICODE);
            return;
        }

        // Rendu HTML
        if ($isDebug) {
            $title = "Erreur Développeur (Mode Debug Actif)";
            $msg = htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8');
            $file = htmlspecialchars($exception->getFile(), ENT_QUOTES, 'UTF-8');
            $line = $exception->getLine();
            $trace = htmlspecialchars($exception->getTraceAsString(), ENT_QUOTES, 'UTF-8');

            echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur 500 — Marvens Shop Debug</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #f8fafc; padding: 2rem; }
        .box { background: #1e293b; border-radius: 8px; padding: 2rem; max-width: 900px; margin: auto; border: 1px solid #334155; }
        h1 { color: #f43f5e; margin-top: 0; }
        .meta { color: #94a3b8; font-family: monospace; margin-bottom: 1.5rem; }
        pre { background: #0f172a; padding: 1rem; border-radius: 6px; overflow-x: auto; color: #38bdf8; font-size: 0.9rem; }
        .badge { background: #3b82f6; color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <h1>{$title}</h1>
        <div class="meta">Réf Requête : <span class="badge">{$requestId}</span></div>
        <p><strong>Message :</strong> {$msg}</p>
        <p><strong>Emplacement :</strong> {$file}:{$line}</p>
        <h3>Stack Trace :</h3>
        <pre>{$trace}</pre>
    </div>
</body>
</html>
HTML;
        } else {
            echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Une erreur est survenue — Marvens Shop</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #1e293b; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 1rem; }
        .card { background: white; border-radius: 12px; padding: 2.5rem; max-width: 520px; width: 100%; box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; border: 1px solid #e2e8f0; }
        .icon { width: 56px; height: 56px; margin: 0 auto 1.5rem; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        h1 { font-size: 1.5rem; margin-bottom: 0.75rem; color: #0f172a; }
        p { color: #64748b; line-height: 1.5; margin-bottom: 1.5rem; }
        .ref-box { background: #f1f5f9; padding: 0.75rem; border-radius: 6px; font-family: monospace; font-size: 0.9rem; color: #475569; margin-bottom: 1.5rem; word-break: break-all; }
        .btn { display: inline-block; background: #0f172a; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; }
        .btn:hover { background: #1e293b; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">⚠️</div>
        <h1>Une erreur inattendue est survenue</h1>
        <p>Notre équipe a été notifiée de cet incident technique. Vous pouvez réessayer dans quelques instants ou contacter notre support si le problème persiste.</p>
        <div class="ref-box">Référence d'incident : <strong>{$requestId}</strong></div>
        <a href="/" class="btn">Retour à la boutique</a>
    </div>
</body>
</html>
HTML;
        }
    }

    /**
     * Rendu de secours en cas d'erreur fatale au shutdown
     */
    private static function renderFatalResponse(string $message, string $requestId): void
    {
        http_response_code(500);
        header('X-Request-Id: ' . $requestId);
        header('Content-Type: text/html; charset=UTF-8');

        $isDebug = (bool)Config::get('app.debug', false);
        if ($isDebug) {
            echo "<h1>Erreur Fatale</h1><p>Message: " . htmlspecialchars($message) . "</p><p>Request ID: {$requestId}</p>";
        } else {
            echo "<!DOCTYPE html><html><body><h1>Une erreur critique est survenue</h1><p>Référence: {$requestId}</p><a href='/'>Accueil</a></body></html>";
        }
    }
}
