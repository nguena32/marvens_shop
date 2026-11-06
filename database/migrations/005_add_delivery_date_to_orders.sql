-- ============================================================================
-- Migration 005 : Ajout de la date de livraison souhaitée (delivery_date)
-- ============================================================================

ALTER TABLE orders ADD COLUMN delivery_date DATE NULL AFTER delivery_address;
