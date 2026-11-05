<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Moteur de rendu de vues PHP échappées sans framework
 */
class View
{
    private static string $viewsPath;

    public static function init(string $viewsPath): void
    {
        self::$viewsPath = rtrim($viewsPath, '/\\');
    }

    public static function render(string $template, array $data = []): string
    {
        $filePath = self::$viewsPath . '/' . str_replace('.', '/', $template) . '.php';

        if (!file_exists($filePath)) {
            throw new \RuntimeException("Fichier de vue introuvable : {$filePath}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $filePath;
        return ob_get_clean() ?: '';
    }

    public static function escape(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
