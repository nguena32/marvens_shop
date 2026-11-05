<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Gestionnaire centralisé de la configuration applicative
 */
class Config
{
    private static array $config = [];

    public static function load(string $configDir): void
    {
        if (!is_dir($configDir)) {
            return;
        }

        foreach (glob($configDir . '/*.php') as $file) {
            $key = basename($file, '.php');
            $data = require $file;
            if (is_array($data)) {
                self::$config[$key] = $data;
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $data = self::$config;

        foreach ($segments as $segment) {
            if (!is_array($data) || !array_key_exists($segment, $data)) {
                return $default;
            }
            $data = $data[$segment];
        }

        return $data;
    }

    public static function set(string $key, mixed $value): void
    {
        $segments = explode('.', $key);
        $data = &self::$config;

        foreach ($segments as $segment) {
            if (!isset($data[$segment]) || !is_array($data[$segment])) {
                $data[$segment] = [];
            }
            $data = &$data[$segment];
        }

        $data = $value;
    }
}
