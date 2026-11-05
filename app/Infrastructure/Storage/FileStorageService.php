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

    public function __construct(
        string $storageRoot,
        int $maxSizeMb = 5,
        array $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp']
    ) {
        $this->storageRoot = rtrim($storageRoot, '/\\');
        $this->maxSizeBytes = $maxSizeMb * 1024 * 1024;
        $this->allowedMimeTypes = $allowedMimeTypes;
    }

    /**
     * Téléversement et sécurisation d'un fichier image produit
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

        if (!in_array($mime, $this->allowedMimeTypes, true)) {
            throw new RuntimeException("Format de fichier non autorisé : {$mime}. Formats acceptés : JPEG, PNG, WEBP.");
        }

        // Déterminer l'extension sûre
        $extension = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
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
}
