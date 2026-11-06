-- ============================================================================
-- Migration 004 : Tables pour la Sécurité avancée et la Maintenance
-- Module 9 : 9.2 Sécurité (Rate Limiting, Blocages) & 9.3 Maintenance (Backups, Tâches)
-- Compatible MySQL 8 & SQLite (Tests)
-- ============================================================================

-- 1. Table de suivi des tentatives de connexion pour le Rate Limiting (Brute force protection)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    username VARCHAR(100) NOT NULL,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ip_attempt (ip_address, attempted_at),
    INDEX idx_user_attempt (username, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table d'audit des sauvegardes et restaurations (Maintenance)
CREATE TABLE IF NOT EXISTS system_backups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    backup_type VARCHAR(20) NOT NULL, -- 'db', 'files', 'full'
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    size_bytes BIGINT NOT NULL DEFAULT 0,
    created_by INT NULL,
    checksum VARCHAR(64) NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
