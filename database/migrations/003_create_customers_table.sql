-- ============================================================================
-- Migration 003 : Table des Clients et Optimisations des Commandes
-- Module 8 : 8.4 Gestion des clients & 8.5 Statistiques
-- Compatible MySQL 8 & SQLite (Tests)
-- ============================================================================

-- 1. Table Clients (Module 8.4)
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    whatsapp VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NULL,
    city VARCHAR(100) NULL,
    district VARCHAR(100) NULL,
    address TEXT NULL,
    notes TEXT NULL,
    orders_count INT NOT NULL DEFAULT 0,
    total_spent INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Index de recherche rapide
CREATE INDEX IF NOT EXISTS idx_customers_whatsapp ON customers(whatsapp);
CREATE INDEX IF NOT EXISTS idx_customers_name ON customers(name);
