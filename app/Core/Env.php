<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Chargeur d'environnement .env minimaliste et robuste sans dépendance externe
 */
class Env
{
    private static array $variables = [];
    private static bool $loaded = false;

    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);

                // Supprimer les guillemets englobants si présents
                if ((str_starts_with($val, '"') && str_ends_with($val, '"')) ||
                    (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
                    $val = substr($val, 1, -1);
                }

                self::$variables[$key] = $val;
                $_ENV[$key] = $val;
                putenv("{$key}={$val}");
            }
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$variables[$key])) {
            return self::castValue(self::$variables[$key]);
        }

        $envVal = getenv($key);
        if ($envVal !== false) {
            return self::castValue($envVal);
        }

        return $default;
    }

    private static function castValue(string $value): mixed
    {
        return match (strtolower($value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            'empty', '(empty)' => '',
            default => $value,
        };
    }
}
