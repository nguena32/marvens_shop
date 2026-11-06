<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Service de journalisation sécurisée (OWASP / cPanel)
 * - Masquage automatique des secrets, mots de passe, tokens, cookies
 * - Correlation ID pour chaque requête
 * - Écriture dans storage/logs/ (hors Document Root)
 */
class Logger
{
    private static ?string $correlationId = null;

    public static function getCorrelationId(): string
    {
        if (self::$correlationId === null) {
            self::$correlationId = bin2hex(random_bytes(8));
        }
        return self::$correlationId;
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function security(string $message, array $context = []): void
    {
        self::log('SECURITY', $message, $context);
    }

    private static function log(string $level, string $message, array $context = []): void
    {
        $logDir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $filePath = $logDir . '/app-' . date('Y-m-d') . '.log';
        $sanitizedContext = self::sanitize($context);

        $record = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'correlation_id' => self::getCorrelationId(),
            'message' => $message,
            'context' => $sanitizedContext,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI',
        ];

        $logLine = json_encode($record, JSON_UNESCAPED_UNICODE) . PHP_EOL;
        @file_put_contents($filePath, $logLine, FILE_APPEND | LOCK_EX);
    }

    /**
     * Masque les secrets et données sensibles pour garantir la conformité OWASP et RGPD
     */
    public static function sanitize(array $data): array
    {
        $redactedKeys = [
            'password', 'password_hash', 'confirm_password', 'new_password',
            '_csrf_token', 'token', 'meta_access_token', 'secret', 'app_secret',
            'cookie', 'session_id', 'card_number', 'cvv'
        ];

        $sanitized = [];
        foreach ($data as $key => $value) {
            $lowerKey = strtolower((string)$key);
            if (in_array($lowerKey, $redactedKeys, true)) {
                $sanitized[$key] = '***REDACTED***';
            } elseif (is_array($value)) {
                $sanitized[$key] = self::sanitize($value);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }
}
