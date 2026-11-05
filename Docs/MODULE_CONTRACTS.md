# MODULE_CONTRACTS.md
# Contrats des Modules Applicatifs MVP — Marvens Shop

**Date :** 05 novembre 2026  
**Étape :** Étape 3 — Fondations techniques et contrats de modules  
**Agent :** Architecte Logiciel Senior / Lead Developer PHP (Google Antigravity)  
**Usage :** Spécification technique destinée à cadrer rigoureusement les développements de l'Étape 4.

---

## 1. Module Storefront & Catalogue

- **Responsabilités :**
  - Affichage de la page d'accueil avec les produits vedettes (`is_featured = 1`) et nouveautés.
  - Consultation du catalogue avec filtrage par catégorie et recherche textuelle.
  - Fiche détaillée du produit avec affichage des variantes (tailles, couleurs, prix).
- **Contrôleur :** `App\Http\Controllers\CatalogController`
- **Services / Cas d'usage :** `GetStorefrontProductsUseCase`, `GetProductDetailUseCase`
- **Repositories :** `ProductRepositoryInterface`, `CategoryRepositoryInterface`
- **Tables sollicitées :** `products`, `categories`, `product_variants`, `shop_settings`
- **Règles métier :**
  - Seuls les produits avec `is_active = 1` sont retournés au public (`MS-BIZ-02`).
  - Échappement systématique de toutes les données textuelles à l'affichage (`XSS`).

---

## 2. Module Panier & Checkout (Commande Sécurisée)

- **Responsabilités :**
  - Gestion du panier stocké en session côté serveur (`$_SESSION['cart']`).
  - Validation du formulaire de prise de commande (coordonnées, quartier, mode de réception).
  - Recalcul autoritaire du sous-total, des frais de livraison et du montant net à payer (`MS-BIZ-03`).
  - Persistance atomique de la commande sous transaction SQL avant redirection WhatsApp (`MS-BIZ-04`).
  - Génération de l'URL WhatsApp encodée (`https://wa.me/{num}?text=...`).
- **Contrôleurs :** `App\Http\Controllers\CartController`, `App\Http\Controllers\OrderController`
- **Services / Cas d'usage :** `CartService`, `CreateOrderUseCase`
- **Repositories :** `OrderRepositoryInterface`
- **Tables sollicitées :** `orders`, `order_items`, `order_status_history`, `products`
- **Règles métier :**
  - Le client ne fournit jamais le prix unitaire autoritaire : il est extrait de la table `products`.
  - Transaction SQL obligatoire : insertion dans `orders`, puis `order_items`, puis `order_status_history` avec commit/rollback strict.
  - La commande est créée en statut initial `order_status = 'pending'`, `payment_status = 'unpaid'`.

---

## 3. Module Dashboard & Gestion des Commandes

- **Responsabilités :**
  - Authentification sécurisée de l'administrateur commerçant (`merchant_admin`).
  - Présentation des indicateurs clés (KPIs) : Total commandes, Commandes en attente, CA réalisé sur commandes payées.
  - Consultation, recherche et filtrage de l'historique des commandes.
  - Mise à jour du statut de commande selon la machine à états autorisée (`MS-BIZ-06`).
  - Enregistrement manuel de l'état de règlement (`payment_status`).
- **Contrôleurs :** `App\Http\Controllers\Admin\DashboardController`, `App\Http\Controllers\Admin\OrderAdminController`
- **Services / Cas d'usage :** `GetDashboardMetricsUseCase`, `UpdateOrderStatusUseCase`
- **Repositories :** `OrderRepositoryInterface`
- **Règles métier :**
  - Protection CSRF obligatoire sur chaque changement de statut.
  - Traçabilité : chaque changement de statut enregistre une ligne dans `order_status_history`.

---

## 4. Module Catalogue Admin & Médias

- **Responsabilités :**
  - Gestion CRUD des catégories et des produits.
  - Gestion des variantes simples (tailles / couleurs / surcoûts).
  - Téléversement sécurisé des visuels produits via `FileStorageService` (contrôle MIME, renommage cryptographique).
- **Contrôleurs :** `App\Http\Controllers\Admin\ProductAdminController`, `App\Http\Controllers\Admin\CategoryAdminController`
- **Services / Cas d'usage :** `SaveProductUseCase`, `UploadProductImageUseCase`
- **Repositories :** `ProductRepositoryInterface`, `CategoryRepositoryInterface`

---

## 5. Module Thèmes & Personnalisation

- **Responsabilités :**
  - Présentation de la galerie des thèmes homologués (`Fashion`, `Bello`, `Luxe`, `Naya`, `Shop`).
  - Basculement du thème actif dans la table `shop_settings` (`active_theme`).
  - Personnalisation des couleurs principales via injection de variables CSS.
- **Règle absolue (`MS-BIZ-07`) :**
  - Changer de thème ne modifie, ne déplace et ne supprime aucune donnée des tables `products`, `categories`, `orders`, `users`.

---

## 6. Module Importation de Données

- **Responsabilités :**
  - Téléversement et validation d'un fichier CSV de produits.
  - Détection des doublons par SKU ou slug.
  - Génération d'un rapport de synthèse (Nombre de produits créés, mis à jour ou ignorés).
- **Contrôleur :** `App\Http\Controllers\Admin\ImportAdminController`
- **Services :** `CsvImportService`
