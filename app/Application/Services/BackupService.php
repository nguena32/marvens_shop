<?php
declare(strict_types=1);

namespace App\Application\Services;

use PDO;
use ZipArchive;
use App\Core\Database;
use App\Core\Logger;
use App\Core\Config;

/**
 * Service de sauvegarde et de restauration du système
 * Module 9.3 Déploiement et Maintenance
 */
class BackupService
{
    private PDO $pdo;
    private string $storageRoot;
    private string $backupDir;

    public function __construct(?PDO $pdo = null, ?string $storageRoot = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
        $this->storageRoot = $storageRoot ?? dirname(__DIR__, 2) . '/storage';
        $this->backupDir = $this->storageRoot . '/backups';

        if (!is_dir($this->backupDir)) {
            @mkdir($this->backupDir, 0755, true);
        }
    }

    /**
     * Sauvegarde de la base de données SQL
     */
    public function backupDatabase(?int $userId = null): array
    {
        $timestamp = date('Y-m-d_H-i-s');
        $filename = "backup_db_{$timestamp}.sql";
        $filePath = $this->backupDir . '/' . $filename;

        $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        $sqlDump = "-- MARVENS SHOP DATABASE BACKUP\n-- Date: " . date('Y-m-d H:i:s') . "\n\n";

        if ($driver === 'sqlite') {
            $tablesStmt = $this->pdo->query("SELECT name, sql FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $tables = $tablesStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tables as $t) {
                $tableName = $t['name'];
                $sqlDump .= "-- Table: {$tableName}\n";
                $sqlDump .= "DROP TABLE IF EXISTS \"{$tableName}\";\n";
                $sqlDump .= $t['sql'] . ";\n";

                $rowsStmt = $this->pdo->query("SELECT * FROM \"{$tableName}\"");
                while ($row = $rowsStmt->fetch(PDO::FETCH_ASSOC)) {
                    $cols = array_map(fn($c) => '"' . str_replace('"', '""', $c) . '"', array_keys($row));
                    $vals = array_map(function ($v) {
                        return $v === null ? 'NULL' : $this->pdo->quote((string)$v);
                    }, array_values($row));
                    $sqlDump .= "INSERT INTO \"{$tableName}\" (" . implode(',', $cols) . ") VALUES (" . implode(',', $vals) . ");\n";
                }
                $sqlDump .= "\n";
            }
        } else {
            // MySQL Dump
            $tablesStmt = $this->pdo->query("SHOW TABLES");
            $tables = $tablesStmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($tables as $tableName) {
                $sqlDump .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $createStmt = $this->pdo->query("SHOW CREATE TABLE `{$tableName}`");
                $createRow = $createStmt->fetch(PDO::FETCH_ASSOC);
                $sqlDump .= $createRow['Create Table'] . ";\n\n";

                $rowsStmt = $this->pdo->query("SELECT * FROM `{$tableName}`");
                while ($row = $rowsStmt->fetch(PDO::FETCH_ASSOC)) {
                    $cols = array_map(fn($c) => "`{$c}`", array_keys($row));
                    $vals = array_map(function ($v) {
                        return $v === null ? 'NULL' : $this->pdo->quote((string)$v);
                    }, array_values($row));
                    $sqlDump .= "INSERT INTO `{$tableName}` (" . implode(',', $cols) . ") VALUES (" . implode(',', $vals) . ");\n";
                }
                $sqlDump .= "\n";
            }
        }

        file_put_contents($filePath, $sqlDump);
        $sizeBytes = filesize($filePath);
        $checksum = hash_file('sha256', $filePath);

        $this->recordBackup('db', $filename, $filePath, $sizeBytes, $userId, $checksum);
        Logger::info("Sauvegarde base de données effectuée", ['file' => $filename, 'size' => $sizeBytes]);

        return [
            'success' => true,
            'filename' => $filename,
            'size' => $sizeBytes,
            'checksum' => $checksum,
            'path' => $filePath,
        ];
    }

    /**
     * Sauvegarde compressée des fichiers médias / téléversements
     */
    public function backupUploads(?int $userId = null): array
    {
        $timestamp = date('Y-m-d_H-i-s');
        $filename = "backup_files_{$timestamp}.zip";
        $filePath = $this->backupDir . '/' . $filename;

        $zip = new ZipArchive();
        if ($zip->open($filePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException("Impossible de créer l'archive zip.");
        }

        $uploadsDir = dirname(__DIR__, 2) . '/public/uploads';
        $addedFiles = 0;
        if (is_dir($uploadsDir)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($uploadsDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $realPath = $file->getRealPath();
                    $relativePath = substr($realPath, strlen($uploadsDir) + 1);
                    $zip->addFile($realPath, 'uploads/' . str_replace('\\', '/', $relativePath));
                    $addedFiles++;
                }
            }
        }

        // Si aucun fichier upload n'existe encore, insérer un fichier manifeste
        if ($addedFiles === 0) {
            $zip->addFromString('uploads/README.txt', 'Archive de sauvegarde des médias Marvens Shop créée le ' . date('Y-m-d H:i:s'));
        }

        $zip->close();
        $sizeBytes = file_exists($filePath) ? (int)filesize($filePath) : 0;
        $checksum = file_exists($filePath) ? (string)hash_file('sha256', $filePath) : '';

        $this->recordBackup('files', $filename, $filePath, $sizeBytes, $userId, $checksum);
        Logger::info("Sauvegarde fichiers médias effectuée", ['file' => $filename, 'size' => $sizeBytes]);

        return [
            'success' => true,
            'filename' => $filename,
            'size' => $sizeBytes,
            'checksum' => $checksum,
            'path' => $filePath,
        ];
    }

    /**
     * Liste des sauvegardes enregistrées
     */
    public function getBackupsList(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM system_backups ORDER BY id DESC LIMIT 50");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Restauration d'une sauvegarde SQL
     */
    public function restoreDatabase(string $filename): bool
    {
        // Protection Path Traversal
        $basename = basename($filename);
        $filePath = $this->backupDir . '/' . $basename;

        if (!file_exists($filePath)) {
            throw new \RuntimeException("Fichier de sauvegarde introuvable : {$basename}");
        }

        $sql = file_get_contents($filePath);
        if ($sql === false || trim($sql) === '') {
            throw new \RuntimeException("Contenu SQL vide ou illisible.");
        }

        $this->pdo->beginTransaction();
        try {
            // Exécution des requêtes SQL
            $this->pdo->exec($sql);
            $this->pdo->commit();
            Logger::info("Restauration de la base de données réussie", ['file' => $basename]);
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            Logger::error("Échec de la restauration base de données", ['file' => $basename, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function recordBackup(string $type, string $filename, string $filePath, int $size, ?int $userId, string $checksum): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO system_backups (backup_type, filename, file_path, size_bytes, created_by, checksum, status)
                VALUES (:type, :fname, :fpath, :size, :uid, :chk, 'completed')
            ");
            $stmt->execute([
                'type' => $type,
                'fname' => $filename,
                'fpath' => $filePath,
                'size' => $size,
                'uid' => $userId,
                'chk' => $checksum,
            ]);
        } catch (\Exception $e) {
            // Ignorer si table non encore migrée
        }
    }
}
