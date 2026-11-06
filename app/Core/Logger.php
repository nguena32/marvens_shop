<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Service de journalisation centralisée, robuste et sécurisée (cPanel / PHP 8.3+)
 * 
 * - Multi-canaux : app, php, database, security, integrations
 * - Format JSON Lines structuré conforme ISO 8601 avec fuseau explicite
 * - Correlation ID (request_id) unique par cycle de requête
 * - Redaction stricte des secrets (mots de passe, tokens, cookies, session_id, CVV...)
 * - Protection anti CRLF injection dans les messages et métadonnées
 * - Anti-boucle infinie et fallback silencieux
 * - Rotation automatique par date et par taille + purge de rétention
 * - Conforme aux exigences de sécurité OWASP, RGPD et hébergements cPanel
 */
class Logger
{
    private static ?string $correlationId = null;
    private static bool $isLogging = false;

    // Niveaux normalisés RFC 5424 / PSR-3
    public const DEBUG     = 'DEBUG';
    public const INFO      = 'INFO';
    public const NOTICE    = 'NOTICE';
    public const WARNING   = 'WARNING';
    public const ERROR     = 'ERROR';
    public const CRITICAL  = 'CRITICAL';
    public const ALERT     = 'ALERT';
    public const EMERGENCY = 'EMERGENCY';

    private const SEVERITY_LEVELS = [
        self::DEBUG     => 100,
        self::INFO      => 200,
        self::NOTICE    => 250,
        self::WARNING   => 300,
        self::ERROR     => 400,
        self::CRITICAL  => 500,
        self::ALERT     => 550,
        self::EMERGENCY => 600,
    ];

    /**
     * Récupère ou génère l'identifiant de corrélation de la requête courante (request_id)
     */
    public static function getCorrelationId(): string
    {
        if (self::$correlationId === null) {
            // Si transmis par un reverse-proxy / header HTTP
            if (!empty($_SERVER['HTTP_X_REQUEST_ID'])) {
                $candidate = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string)$_SERVER['HTTP_X_REQUEST_ID']);
                if (strlen($candidate) >= 8 && strlen($candidate) <= 64) {
                    self::$correlationId = $candidate;
                }
            }

            if (self::$correlationId === null) {
                try {
                    self::$correlationId = bin2hex(random_bytes(8));
                } catch (\Throwable) {
                    self::$correlationId = uniqid('req_', true);
                }
            }
        }

        return self::$correlationId;
    }

    /**
     * Définit manuellement l'identifiant de corrélation
     */
    public static function setCorrelationId(string $id): void
    {
        self::$correlationId = preg_replace('/[^a-zA-Z0-9_\-]/', '', $id);
    }

    public static function debug(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::DEBUG, $message, $context, $channel);
    }

    public static function info(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::INFO, $message, $context, $channel);
    }

    public static function notice(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::NOTICE, $message, $context, $channel);
    }

    public static function warning(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::WARNING, $message, $context, $channel);
    }

    public static function error(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::ERROR, $message, $context, $channel);
    }

    public static function critical(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::CRITICAL, $message, $context, $channel);
    }

    public static function alert(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::ALERT, $message, $context, $channel);
    }

    public static function emergency(string $message, array $context = [], string $channel = 'app'): void
    {
        self::log(self::EMERGENCY, $message, $context, $channel);
    }

    /**
     * Canal dédié Sécurité (authentification, rate limit, CSRF, accès non autorisés)
     */
    public static function security(string $message, array $context = []): void
    {
        self::log(self::WARNING, $message, $context, 'security');
    }

    /**
     * Canal dédié Database / PDO
     */
    public static function database(string $message, array $context = [], string $level = self::ERROR): void
    {
        self::log($level, $message, $context, 'database');
    }

    /**
     * Canal dédié Intégrations externes (WhatsApp, Meta Graph API, Webhooks)
     */
    public static function integration(string $message, array $context = [], string $level = self::ERROR): void
    {
        self::log($level, $message, $context, 'integrations');
    }

    /**
     * Méthode centrale d'enregistrement
     */
    public static function log(string $level, string $message, array $context = [], string $channel = 'app'): void
    {
        // Protection stricte anti-récursion
        if (self::$isLogging) {
            return;
        }

        $level = strtoupper($level);
        if (!isset(self::SEVERITY_LEVELS[$level])) {
            $level = self::INFO;
        }

        // Filtrage selon le niveau minimal configuré
        $configuredLevel = strtoupper(Config::get('logging.level', 'INFO'));
        $minSeverity = self::SEVERITY_LEVELS[$configuredLevel] ?? self::SEVERITY_LEVELS[self::INFO];
        if (self::SEVERITY_LEVELS[$level] < $minSeverity) {
            return;
        }

        self::$isLogging = true;

        try {
            $logDir = Config::get('logging.path', dirname(__DIR__, 2) . '/storage/logs');
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0755, true);
                if (!file_exists($logDir . '/.htaccess')) {
                    @file_put_contents($logDir . '/.htaccess', "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order deny,allow\n    Deny from all\n</IfModule>\n");
                }
            }

            // Normalisation du canal
            $allowedChannels = ['app', 'php', 'database', 'security', 'integrations'];
            $channel = strtolower($channel);
            if (!in_array($channel, $allowedChannels, true)) {
                $channel = 'app';
            }

            $dateSuffix = date('Y-m-d');
            $filePath = self::resolveLogFilePath($logDir, $channel, $dateSuffix);

            // Neutralisation CRLF du message pour prévenir toute injection de fausses lignes
            $cleanMessage = str_replace(["\r\n", "\r", "\n"], " ", $message);

            // Extraction exceptionnelle si passée dans le contexte
            $exceptionData = null;
            if (isset($context['exception']) && $context['exception'] instanceof \Throwable) {
                $e = $context['exception'];
                $exceptionData = [
                    'class' => get_class($e),
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => self::formatTrace($e),
                ];
                unset($context['exception']);
            }

            // Contexte de requête HTTP sécurisé et nettoyé
            $httpContext = self::buildHttpContext();

            // Masquage et assainissement des données du contexte
            $sanitizedContext = self::sanitize($context);

            $record = [
                'timestamp' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
                'channel' => $channel,
                'level' => $level,
                'request_id' => self::getCorrelationId(),
                'message' => $cleanMessage,
                'http' => $httpContext,
                'context' => $sanitizedContext,
            ];

            if ($exceptionData !== null) {
                $record['exception'] = $exceptionData;
            }

            // Utilisateur connecté si disponible dans la session
            if (isset($_SESSION['user_id'])) {
                $record['user_id'] = (int)$_SESSION['user_id'];
            }

            $logLine = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;

            // Écriture sécurisée avec verrou exclusif
            @file_put_contents($filePath, $logLine, FILE_APPEND | LOCK_EX);

        } catch (\Throwable) {
            // En cas d'échec critique du logger, ne jamais faire planter l'application
            // Possibilité d'utiliser error_log système de secours PHP
            @error_log("[MarvensLogger Fallback] [{$level}] {$message}");
        } finally {
            self::$isLogging = false;
        }
    }

    /**
     * Construit le contexte HTTP nettoyé (méthode, chemin sans query sensible, IP)
     */
    private static function buildHttpContext(): array
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
        $rawUri = $_SERVER['REQUEST_URI'] ?? '';
        $cleanUri = 'CLI';

        if ($rawUri !== '') {
            $parsedPath = parse_url($rawUri, PHP_URL_PATH) ?? '/';
            $parsedQuery = parse_url($rawUri, PHP_URL_QUERY);

            if (!empty($parsedQuery)) {
                parse_str($parsedQuery, $queryParams);
                $sanitizedQuery = self::sanitize($queryParams);
                $cleanUri = $parsedPath . '?' . http_build_query($sanitizedQuery);
            } else {
                $cleanUri = $parsedPath;
            }
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($parts[0]);
        }

        return [
            'method' => strtoupper($method),
            'uri' => $cleanUri,
            'ip' => $ip,
        ];
    }

    /**
     * Résout le chemin du fichier journal avec gestion de rotation par taille maximale
     */
    private static function resolveLogFilePath(string $logDir, string $channel, string $dateSuffix): string
    {
        $baseName = "{$channel}-{$dateSuffix}";
        $filePath = "{$logDir}/{$baseName}.log";

        $maxBytes = (int)Config::get('logging.max_file_size_mb', 10) * 1024 * 1024;
        if ($maxBytes > 0 && file_exists($filePath) && filesize($filePath) >= $maxBytes) {
            $part = 1;
            while (file_exists("{$logDir}/{$baseName}.{$part}.log") && filesize("{$logDir}/{$baseName}.{$part}.log") >= $maxBytes) {
                $part++;
            }
            $filePath = "{$logDir}/{$baseName}.{$part}.log";
        }

        return $filePath;
    }

    /**
     * Formate une trace d'exception compacte et sans fuite de secrets
     */
    private static function formatTrace(\Throwable $e): array
    {
        $trace = [];
        $items = $e->getTrace();
        $limit = 10; // 10 premiers appels suffisants pour isoler la cause
        $count = 0;

        foreach ($items as $item) {
            if ($count++ >= $limit) {
                break;
            }
            $trace[] = [
                'file' => $item['file'] ?? '[internal]',
                'line' => $item['line'] ?? 0,
                'call' => ($item['class'] ?? '') . ($item['type'] ?? '') . ($item['function'] ?? ''),
            ];
        }

        return $trace;
    }

    /**
     * Masque les secrets et données sensibles pour garantir la conformité OWASP et RGPD
     */
    public static function sanitize(array $data): array
    {
        $redactedKeys = [
            'password', 'password_hash', 'confirm_password', 'new_password',
            '_csrf_token', 'token', 'meta_access_token', 'secret', 'app_secret',
            'cookie', 'session_id', 'card_number', 'cvv', 'authorization', 'bearer',
            'api_key', 'access_token', 'refresh_token', 'private_key'
        ];

        $sanitized = [];
        foreach ($data as $key => $value) {
            $lowerKey = strtolower((string)$key);
            if (in_array($lowerKey, $redactedKeys, true)) {
                $sanitized[$key] = '***REDACTED***';
            } elseif (is_array($value)) {
                $sanitized[$key] = self::sanitize($value);
            } elseif (is_string($value)) {
                // Remplacement si la clé ou la valeur contient un token sensible évident
                if (preg_match('/^(bearer\s+|e[a-zA-Z0-9_\-\.]{30,})/i', $value)) {
                    $sanitized[$key] = '***REDACTED***';
                } else {
                    $sanitized[$key] = $value;
                }
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Purge les anciens fichiers de journaux dépassant la durée de rétention
     */
    public static function pruneOldLogs(): int
    {
        $logDir = Config::get('logging.path', dirname(__DIR__, 2) . '/storage/logs');
        $retentionDays = (int)Config::get('logging.retention_days', 30);
        if ($retentionDays <= 0 || !is_dir($logDir)) {
            return 0;
        }

        $now = time();
        $maxLifetimeSeconds = $retentionDays * 86400;
        $deletedCount = 0;

        $files = glob("{$logDir}/*.log");
        if ($files === false) {
            return 0;
        }

        foreach ($files as $file) {
            if (is_file($file)) {
                $mtime = filemtime($file);
                if ($mtime !== false && ($now - $mtime) > $maxLifetimeSeconds) {
                    if (@unlink($file)) {
                        $deletedCount++;
                    }
                }
            }
        }

        return $deletedCount;
    }
}
