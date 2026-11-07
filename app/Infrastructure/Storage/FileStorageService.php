<?php
declare(strict_types=1);

namespace App\Infrastructure\Storage;

use RuntimeException;

/**
 * Service de stockage de fichiers sécurisé et compatible cPanel
 */
class FileStorageService
{
    private string $storageRoot;
    private int $maxSizeBytes;
    private array $allowedMimeTypes;

    /**
     * Détermine automatiquement le répertoire racine public web selon l'environnement (Local ou cPanel public_html)
     */
    public static function resolvePublicRoot(): string
    {
        // 1. Si la variable d'environnement ou config est explicitement définie
        $configuredPath = \App\Core\Config::get('app.public_path');
        if (!empty($configuredPath) && is_dir((string)$configuredPath)) {
            return rtrim((string)$configuredPath, '/\\');
        }

        // 2. Détection via DOCUMENT_ROOT serveur web (Apache / cPanel)
        if (!empty($_SERVER['DOCUMENT_ROOT']) && is_dir($_SERVER['DOCUMENT_ROOT'])) {
            return rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
        }

        $baseDir = dirname(__DIR__, 3);

        // 3. Cas cPanel hébergement mutualisé standard : /home/user/public_html
        $siblingPublicHtml = dirname($baseDir) . '/public_html';
        if (is_dir($siblingPublicHtml)) {
            return $siblingPublicHtml;
        }

        // 4. Dossier public_html enfant
        if (is_dir($baseDir . '/public_html')) {
            return $baseDir . '/public_html';
        }

        // 5. Dossier public standard
        return $baseDir . '/public';
    }

    public function __construct(
        ?string $storageRoot = null,
        int $maxSizeMb = 30,
        array $allowedMimeTypes = [
            'image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/svg+xml',
            'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime'
        ]
    ) {
        $root = $storageRoot ?? self::resolvePublicRoot();
        $this->storageRoot = rtrim($root, '/\\');
        $this->maxSizeBytes = $maxSizeMb * 1024 * 1024;
        $this->allowedMimeTypes = $allowedMimeTypes;
    }

    /**
     * Téléversement et sécurisation d'un fichier média (image ou vidéo)
     */
    public function storePublicUpload(array $file, string $subFolder = 'products'): string
    {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException("Aucun fichier téléversé ou upload invalide.");
        }

        if ($file['size'] > $this->maxSizeBytes) {
            throw new RuntimeException("Le fichier dépasse la taille maximale autorisée (" . ($this->maxSizeBytes / 1024 / 1024) . " Mo).");
        }

        // Vérification MIME réelle côté serveur (via finfo)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        // Cas particulier de compatibilité pour les favicons .ico
        $clientExt = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
        if ($clientExt === 'ico' && ($mime === 'image/x-icon' || $mime === 'image/vnd.microsoft.icon' || $mime === 'application/octet-stream')) {
            $mime = 'image/x-icon';
        }

        if (!in_array($mime, $this->allowedMimeTypes, true)) {
            throw new RuntimeException("Format de fichier non autorisé : {$mime}. Formats acceptés : JPEG, PNG, WEBP, GIF, MP4, WEBM.");
        }

        // Déterminer l'extension sûre
        $extension = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            'image/x-icon', 'image/vnd.microsoft.icon' => 'ico',
            'image/svg+xml' => 'svg',
            'video/mp4' => 'mp4',
            'video/webm' => 'webm',
            'video/ogg' => 'ogv',
            'video/quicktime' => 'mov',
            default => 'bin',
        };

        // Génération d'un nom cryptographique aléatoire (anti-écrasement / anti-path traversal)
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $targetDir = $this->storageRoot . '/uploads/' . trim($subFolder, '/');

        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
            throw new RuntimeException("Impossible de créer le dossier cible : {$targetDir}");
        }

        $destination = $targetDir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new RuntimeException("Échec du déplacement du fichier téléversé.");
        }

        return 'uploads/' . trim($subFolder, '/') . '/' . $filename;
    }

    public function getMediaType(string $filePath): string
    {
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (in_array($ext, ['mp4', 'webm', 'ogv', 'mov'], true)) {
            return 'video';
        }
        return 'image';
    }
}
