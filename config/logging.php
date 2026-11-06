<?php
declare(strict_types=1);

use App\Core\Env;

return [
    /**
     * Canal par défaut
     */
    'default' => Env::get('LOG_CHANNEL', 'app'),

    /**
     * Niveau minimal de journalisation : DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY
     */
    'level' => Env::get('LOG_LEVEL', 'INFO'),

    /**
     * Répertoire de stockage des logs
     */
    'path' => dirname(__DIR__) . '/storage/logs',

    /**
     * Durée de rétention des logs en jours
     */
    'retention_days' => (int) Env::get('LOG_RETENTION_DAYS', 30),

    /**
     * Taille maximale d'un fichier log avant rotation en mégaoctets (Mo)
     */
    'max_file_size_mb' => (int) Env::get('LOG_MAX_FILE_SIZE_MB', 10),

    /**
     * Canaux autorisés et leur fichier cible respectif
     */
    'channels' => [
        'app' => 'app',
        'php' => 'php',
        'database' => 'database',
        'security' => 'security',
        'integrations' => 'integrations',
    ],
];
