-- ============================================================================
-- Données de Démonstration / Test — Marvens Shop MVP
-- Catégories, 10 Produits avec images locales, Variantes, 5 Commandes Clients
-- Compatible MySQL 8 / MariaDB (utf8mb4)
-- ============================================================================

-- 1. Catégories de Produits
INSERT INTO categories (id, name, slug, description, image_url, sort_order, is_active) VALUES
(1, 'Vêtements Homme & Femme', 'vetements', 'Prêt-à-porter moderne, chemises, t-shirts et robes tendance.', '/uploads/products/chemise-oxford.jpg', 1, 1),
(2, 'Chaussures & Sneakers', 'chaussures', 'Sneakers urbaines, mocassins et chaussures habillées.', '/uploads/products/sneakers-cuir.jpg', 2, 1),
(3, 'Horlogerie & Montres', 'montres', 'Montres chronographes, élégantes et connectées.', '/uploads/products/montre-chronographe.jpg', 3, 1),
(4, 'Accessoires & Maroquinerie', 'accessoires', 'Sacs en cuir, ceintures, lunettes de soleil et portefeuilles.', '/uploads/products/sac-cognac.jpg', 4, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name), description=VALUES(description), image_url=VALUES(image_url);

-- 2. 10 Produits Variés (Images hébergées en local dans /uploads/products/)
INSERT INTO products (id, category_id, name, slug, sku, description, price, promotional_price, main_image_url, is_active, is_featured) VALUES
-- Vêtements
(1, 1, 'Chemise Oxford Slim Fit Blanche', 'chemise-oxford-slim-fit-blanche', 'VET-CHM-001', 'Chemise 100% coton égyptien, col boutonné classique, idéale pour le bureau et les sorties.', 18500, 15000, '/uploads/products/chemise-oxford.jpg', 1, 1),
(2, 1, 'Polo Piqué Noir Premium', 'polo-pique-noir-premium', 'VET-POL-002', 'Polo en maille piquée respirante avec finitions col côtelé et broderie subtile.', 12000, NULL, '/uploads/products/polo-pique.jpg', 1, 0),
(3, 1, 'Robe d\'Été Fleurie Fluide', 'robe-ete-fleurie-fluide', 'VET-ROB-003', 'Robe mi-longue en mousseline légère avec imprimé floral chic et ceinture assortie.', 22000, 19500, '/uploads/products/robe-fleurie.jpg', 1, 1),
(4, 1, 'Veste Blazer Tailleur Gris Anthracite', 'veste-blazer-tailleur-gris', 'VET-BLZ-004', 'Blazer ajusté avec doublure satinée, poches passepoilées et coupe contemporaine.', 35000, NULL, '/uploads/products/veste-blazer.jpg', 1, 1),

-- Chaussures
(5, 2, 'Sneakers Minimalistes Cuir Blanc', 'sneakers-minimalistes-cuir-blanc', 'CHS-SNK-001', 'Baskets basses en cuir véritable, semelle cousue en caoutchouc vulcanisé ultra confortable.', 28000, 24500, '/uploads/products/sneakers-cuir.jpg', 1, 1),
(6, 2, 'Mocassins en Cuir Brun Suédé', 'mocassins-cuir-brun-suede', 'CHS-MOC-002', 'Mocassins faits main, cuir suédé de première qualité avec détail mors doré.', 32000, NULL, '/uploads/products/mocassins-brun.jpg', 1, 0),
(7, 2, 'Sandales Tressées Bohème Dorées', 'sandales-tressees-boheme-dorees', 'CHS-SAN-003', 'Sandales plates avec brides tressées dorées et semelle anatomique en liège.', 16000, 13500, '/uploads/products/sandales-dorees.jpg', 1, 0),

-- Montres
(8, 3, 'Montre Chronographe Quartz Acier Noir', 'montre-chronographe-acier-noir', 'MNT-CHR-001', 'Boîtier en acier inoxydable noir mat 42mm, cadran chronomètre multifonction et étanchéité 5 ATM.', 45000, 39000, '/uploads/products/montre-chronographe.jpg', 1, 1),
(9, 3, 'Montre Classique Bracelet Cuir Camel', 'montre-classique-cuir-camel', 'MNT-CLS-002', 'Cadran épuré ultra fin argenté avec index minimalistes et bracelet en cuir véritable italien.', 38000, NULL, '/uploads/products/montre-camel.jpg', 1, 0),

-- Accessoires
(10, 4, 'Sac Cabas Cuir Grainé Cognac', 'sac-cabas-cuir-graine-cognac', 'ACC-CAB-001', 'Grand sac cabas zippé pour femme avec compartiment ordinateur 14 pouces et finitions dorées.', 29000, 26000, '/uploads/products/sac-cognac.jpg', 1, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name), price=VALUES(price), promotional_price=VALUES(promotional_price), main_image_url=VALUES(main_image_url);

-- 3. Variantes de Produits (Tailles, Pointures, Couleurs)
INSERT INTO product_variants (product_id, variant_name, size, color, stock_quantity, is_available) VALUES
(1, 'Taille M / Blanc', 'M', 'Blanc', 15, 1),
(1, 'Taille L / Blanc', 'L', 'Blanc', 12, 1),
(1, 'Taille XL / Blanc', 'XL', 'Blanc', 8, 1),
(2, 'Taille M / Noir', 'M', 'Noir', 20, 1),
(2, 'Taille L / Noir', 'L', 'Noir', 18, 1),
(3, 'Taille S / Floral Rose', 'S', 'Floral Rose', 6, 1),
(3, 'Taille M / Floral Rose', 'M', 'Floral Rose', 10, 1),
(4, 'Taille 48 / Gris', '48', 'Gris', 5, 1),
(4, 'Taille 50 / Gris', '50', 'Gris', 7, 1),
(5, 'Pointure 41 / Blanc', '41', 'Blanc', 9, 1),
(5, 'Pointure 42 / Blanc', '42', 'Blanc', 14, 1),
(5, 'Pointure 43 / Blanc', '43', 'Blanc', 11, 1),
(6, 'Pointure 42 / Brun', '42', 'Brun', 8, 1),
(6, 'Pointure 43 / Brun', '43', 'Brun', 6, 1),
(7, 'Pointure 38 / Doré', '38', 'Doré', 10, 1),
(7, 'Pointure 39 / Doré', '39', 'Doré', 12, 1),
(8, 'Boîtier 42mm / Noir Mat', '42mm', 'Noir', 15, 1),
(9, 'Boîtier 40mm / Cuir Camel', '40mm', 'Camel', 10, 1),
(10, 'Taille Unique / Cognac', 'Standard', 'Cognac', 14, 1);

-- 4. 5 Commandes Clients Démonstration
INSERT INTO orders (id, order_number, customer_name, customer_whatsapp, delivery_mode, delivery_city, delivery_district, delivery_address, delivery_cost, total_amount, order_status, payment_status, payment_mode, customer_notes, created_at) VALUES
(1, 'CMD-20261105-0001', 'Samuel Eto\'o', '+237699123456', 'delivery', 'Douala', 'Bonapriso', 'Rue Tokoto, Immeuble Horizon apt 3B', 1500, 40500, 'confirmed', 'paid', 'cash_on_delivery', 'Appeler avant de livrer s\'il vous plaît.', '2026-11-05 09:15:00'),
(2, 'CMD-20261105-0002', 'Marie-Claire Mbarga', '+237677894512', 'delivery', 'Yaoundé', 'Bastos', 'Près de l\'ambassade, Villa verte', 2000, 48000, 'pending', 'unpaid', 'cash_on_delivery', 'Livraison en fin d\'après-midi de préférence.', '2026-11-05 10:30:00'),
(3, 'CMD-20261105-0003', 'Junior Tchakounte', '+237655341278', 'pickup', 'Douala', 'Akwa', 'Retrait direct en boutique', 0, 24500, 'preparing', 'paid', 'cash_on_delivery', 'Je passerai récupérer la commande vers 16h.', '2026-11-05 11:00:00'),
(4, 'CMD-20261105-0004', 'Sandrine Ngo Bell', '+237691556677', 'delivery', 'Douala', 'Bali', 'Face Pharmacie du Centre', 1000, 27000, 'delivered', 'paid', 'cash_on_delivery', 'Commande bien reçue, merci !', '2026-11-04 14:20:00'),
(5, 'CMD-20261105-0005', 'Christian Kamga', '+237680223344', 'delivery', 'Bafoussam', 'Djeleng', 'Carrefour Total', 3000, 38000, 'shipped', 'unpaid', 'cash_on_delivery', 'Expédition par agence de voyage.', '2026-11-05 08:45:00')
ON DUPLICATE KEY UPDATE order_status=VALUES(order_status), total_amount=VALUES(total_amount);

-- 5. Lignes des Commandes
INSERT INTO order_items (order_id, product_id, product_name, variant_info, unit_price, quantity, subtotal) VALUES
(1, 8, 'Montre Chronographe Quartz Acier Noir', 'Boîtier 42mm / Noir Mat', 39000, 1, 39000),
(2, 3, 'Robe d\'Été Fleurie Fluide', 'Taille M / Floral Rose', 19500, 1, 19500),
(2, 10, 'Sac Cabas Cuir Grainé Cognac', 'Taille Unique / Cognac', 26000, 1, 26000),
(3, 5, 'Sneakers Minimalistes Cuir Blanc', 'Pointure 42 / Blanc', 24500, 1, 24500),
(4, 10, 'Sac Cabas Cuir Grainé Cognac', 'Taille Unique / Cognac', 26000, 1, 26000),
(5, 4, 'Veste Blazer Tailleur Gris Anthracite', 'Taille 50 / Gris', 35000, 1, 35000);

-- 6. Historique des Statuts
INSERT INTO order_status_history (order_id, previous_status, new_status, comment, changed_at) VALUES
(1, 'pending', 'confirmed', 'Commande confirmée après échange WhatsApp avec le client.', '2026-11-05 09:30:00'),
(3, 'pending', 'confirmed', 'Paiement et confirmation validés.', '2026-11-05 11:05:00'),
(3, 'confirmed', 'preparing', 'Article mis de côté pour le retrait.', '2026-11-05 11:15:00'),
(4, 'pending', 'confirmed', 'Commande validée.', '2026-11-04 14:30:00'),
(4, 'confirmed', 'delivered', 'Colis livré en mains propres au client.', '2026-11-04 17:00:00'),
(5, 'pending', 'confirmed', 'Validation client reçue.', '2026-11-05 09:00:00'),
(5, 'confirmed', 'shipped', 'Colis déposé à l\'agence de transport.', '2026-11-05 10:00:00');
