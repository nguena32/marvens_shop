-- ============================================================================
-- Migration 002 : Tables pour le Menu Paramètres & Configuration Complète
-- Sections 5.1 à 5.8
-- Compatible MySQL 8 & SQLite (Tests)
-- ============================================================================

-- 1. Table des zones et tarifs de livraison par quartier/ville (Section 5.3)
CREATE TABLE IF NOT EXISTS delivery_zones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(100) NOT NULL DEFAULT 'Douala',
    district VARCHAR(100) NOT NULL,
    fee INT NOT NULL DEFAULT 1500, -- en FCFA
    estimated_time VARCHAR(100) NULL DEFAULT '24h - 48h',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Table des journaux d'activité et de sécurité des sessions (Section 5.7)
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    user_email VARCHAR(255) NULL,
    event_type VARCHAR(50) NOT NULL, -- login_success, login_failed, logout, settings_update, password_change, etc.
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    details TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
