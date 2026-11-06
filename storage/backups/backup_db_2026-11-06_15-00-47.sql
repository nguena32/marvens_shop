-- MARVENS SHOP DATABASE BACKUP
-- Date: 2026-11-06 15:00:47

-- Table: users
CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'merchant_admin',
        name VARCHAR(255) NULL,
        is_active INTEGER NOT NULL DEFAULT 1
    );
INSERT INTO "users" ("id","username","email","password_hash","role","name","is_active") VALUES ('1','admin','admin@marvens.cm','$2y$12$dJgLFNs0HESEph5l8TzkjuZEB9N3dWBstgVS3.F515xsD4MCsOM.O','merchant_admin',NULL,'1');

-- Table: shop_settings
CREATE TABLE shop_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key VARCHAR(100) NOT NULL UNIQUE,
        setting_value TEXT NULL
    );

-- Table: activity_logs
CREATE TABLE activity_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NULL,
        user_email VARCHAR(255) NULL,
        event_type VARCHAR(50) NOT NULL,
        ip_address VARCHAR(45) NULL,
        user_agent TEXT NULL,
        details TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Table: login_attempts
CREATE TABLE login_attempts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ip_address VARCHAR(45) NOT NULL,
        username VARCHAR(100) NOT NULL,
        attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Table: system_backups
CREATE TABLE system_backups (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        backup_type VARCHAR(20) NOT NULL,
        filename VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        size_bytes INTEGER NOT NULL DEFAULT 0,
        created_by INTEGER NULL,
        checksum VARCHAR(64) NULL,
        status VARCHAR(50) NOT NULL DEFAULT 'completed',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

