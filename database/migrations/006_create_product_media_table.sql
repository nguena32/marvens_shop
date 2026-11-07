-- ============================================================================
-- Migration 006 : Table des Médias Produits (Images et Vidéos secondaires)
-- ============================================================================

CREATE TABLE IF NOT EXISTS product_media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    media_type ENUM('image', 'video') NOT NULL DEFAULT 'image',
    media_url VARCHAR(255) NOT NULL,
    thumbnail_url VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_media_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_media_order (product_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
