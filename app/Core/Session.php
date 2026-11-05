<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Gestionnaire de session sécurisé (Règles OWASP / cPanel)
 */
class Session
{
    private static bool $started = false;

    public static function start(): void
    {
        if (self::$started || session_status() === PHP_SESSION_ACTIVE) {
            self::$started = true;
            if (!isset($_SESSION['_csrf_token'])) {
                $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
            }
            return;
        }

        if (!headers_sent()) {
            $isSecure = (bool) Config::get('app.session_secure_cookie', false);
            $sameSite = (string) Config::get('app.session_same_site', 'Lax');
            $lifetime = (int) Config::get('app.session_lifetime', 7200);

            session_set_cookie_params([
                'lifetime' => $lifetime,
                'path' => '/',
                'domain' => '',
                'secure' => $isSecure,
                'httponly' => true,
                'samesite' => $sameSite,
            ]);

            ini_set('session.use_strict_mode', '1');
            ini_set('session.use_only_cookies', '1');

            session_start();
        } else {
            // Environnement CLI / Tests unitaires où les en-têtes sont déjà envoyés
            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }
        }

        self::$started = true;

        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function regenerate(bool $deleteOldSession = true): void
    {
        self::start();
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id($deleteOldSession);
        }
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies') && !headers_sent()) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            @session_destroy();
        }
        self::$started = false;
    }

    public static function getCsrfToken(): string
    {
        self::start();
        return $_SESSION['_csrf_token'] ?? '';
    }

    public static function validateCsrfToken(?string $token): bool
    {
        self::start();
        if ($token === null || $token === '') {
            return false;
        }
        $sessionToken = $_SESSION['_csrf_token'] ?? '';
        return hash_equals($sessionToken, $token);
    }
}
