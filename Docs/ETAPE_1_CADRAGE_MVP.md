# ETAPE_1_CADRAGE_MVP.md
# Cadrage fonctionnel, technique et matrice de traçabilité — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 1 — Cadrage, audit du dépôt et validation du périmètre  
**Agent :** Agent principal de réalisation technique (Google Antigravity)  
**Sources de référence :** `Marvens_Shop_Document_Complet_MVP.docx`, `FONCTIONNALITÉS.docx`, `Paramètres.docx`, `ARCHITECTURE_TECHNIQUE_PROJET.md`, `CAHIER_DES_CHARGES_FONCTIONNEL_TECHNIQUE.md`, `AGENTS.md`.

---

## 1. Vision, positionnement et objectifs du MVP

### 1.1 Proposition de valeur
Marvens Shop est une solution e-commerce clé en main destinée aux commerçants et PME (prioritairement au Cameroun et en Afrique francophone). Elle transforme l'activité informelle ou dispersée sur les réseaux sociaux (WhatsApp, Facebook, Instagram, TikTok) en une boutique en ligne professionnelle et structurée.

Le parcours fondamental est :  
**Catalogue web public → Panier client → Commande persistée en base (numéro unique) → Transmission structurée sur WhatsApp → Traitement et suivi dans le tableau de bord commerçant.**

### 1.2 Modèle d'exploitation (MVP non-SaaS)
- **Installation indépendante par client :** Chaque commerçant dispose de son propre domaine/sous-domaine, de sa propre base de données MySQL et de son instance applicative déployée sur hébergement cPanel.
- **Accompagnement Marvens :** Marvens assure l'installation technique, la configuration initiale, la formation et la maintenance.
- **Exclusion formelle du SaaS au MVP :** Pas d'inscription en libre-service, pas d'architecture multi-tenant mutualisée, pas de `tenant_id` universel, pas de facturation d'abonnements automatisée en ligne.

---

## 2. Utilisateurs et rôles confirmés

| Rôle applicatif | Périmètre et droits d'accès | Statut MVP |
|---|---|---|
| **Visiteur / Acheteur invité** | Consultation catalogue/fiches, ajout panier, validation commande (avec saisie nom/quartier/WhatsApp), ouverture WhatsApp. Aucun compte client préalable requis. | **Confirmé (MVP)** |
| **Commerçant Administrateur (`merchant_admin`)** | Accès sécurisé complet à l'instance : gestion produits/catégories, consultation/mise à jour du statut des commandes, paramétrage de la boutique, choix du thème, déclenchement des imports. | **Confirmé (MVP)** |
| **Opérateur / Vendeur (`staff`)** | Traitement opérationnel des commandes sans accès aux paramètres sensibles ou aux imports. | **Reporté / Hors MVP initial** (activable ultérieurement si exprimé par le premier commerçant). |
| **Support Marvens (`marvens_support`)** | Intervention technique ponctuelle. | Géré au niveau serveur/hébergement cPanel, sans super-rôle applicatif universel dans la DB. |

---

## 3. Périmètre fonctionnel détaillé (MoSCoW)

### A. MUST HAVE (Cœur critique obligatoire du MVP)
1. **Mini-site public & Catalogue :**
   - Page d'accueil avec présentation boutique, bannières, produits mis en avant.
   - Catalogue avec navigation par catégories, recherche textuelle, tri/filtres basiques (prix, nouveautés, promotions).
   - Fiche produit détaillée : galerie photos, titre, description, prix normal et prix promo, référence/SKU, disponibilité, sélection de variantes (tailles, couleurs).
   - Pages d'informations statiques/légales : Livraison, Retraits, Conditions de vente, Contact.
2. **Panier & Checkout sécurisé :**
   - Gestion du panier en session côté serveur (ajout, modification quantité, suppression, vidage).
   - Formulaire de commande : Nom, Numéro WhatsApp, Ville/Quartier, Mode de livraison (domicile / retrait boutique), Instructions.
   - **Règle d'or MS-BIZ-03 :** Calcul et validation stricte des prix, quantités et totaux côté serveur (rejet des manipulations POST/JS).
3. **Persistance commande & Intégration WhatsApp :**
   - **Règle d'or MS-BIZ-04 :** Transaction SQL et enregistrement immuable de la commande en statut initial « En attente » (`pending`) avec génération d'un numéro unique (`CMD-YYYYMMDD-XXXX`) **avant** toute redirection externe.
   - Génération de l'URL WhatsApp encodée contenant le récapitulatif complet et le numéro unique.
   - Écran de confirmation de commande côté client avec rappel des instructions.
4. **Dashboard d'administration :**
   - Authentification sécurisée par session (hachage Argon2id ou Bcrypt, protection brute-force, CSRF).
   - Tableau de bord avec indicateurs synthétiques (Total commandes, Commandes en attente, CA estimé sur commandes confirmées/payées).
   - Gestion des commandes : liste paginée, recherche/filtres par statut et date, consultation de la fiche commande complète.
   - Cycle de vie des statuts (transitions contrôlées côté serveur) : `En attente` → `Confirmée` → `Paiement en attente` → `Payée` → `En préparation` → `Expédiée` → `Livrée` (ou `Annulée`).
   - Gestion du catalogue : CRUD produits, upload sécurisé d'images (format webp/jpeg/png, dimensions limitées, nom aléatoire, stockage sécurisé), gestion des catégories.
5. **Gestion des thèmes & Paramètres :**
   - Sélection et activation d'un thème visuel parmi la bibliothèque disponible (`Theme fashion.zip` par défaut).
   - **Règle d'or MS-BIZ-07 :** Préservation intégrale des données commerciales lors du basculement de thème.
   - Configuration générale : Nom de la boutique, logo/favicon, contact commercial WhatsApp, devise (FCFA par défaut), options de livraison et frais par quartier.

### B. SHOULD HAVE (Important, selon faisabilité technique)
1. **Importation de catalogue par fichier CSV :**
   - Téléversement d'un fichier CSV formaté, validation du schéma côté serveur, rapport d'importation (succès, lignes ignorées, erreurs).
2. **Personnalisation visuelle légère :**
   - Saisie de la couleur principale et secondaire via le menu Apparence, injectée via variables CSS racines.

### C. COULD HAVE (Conditionnel aux validations d'API externes)
1. **Importation Catalogue Meta (Facebook/Instagram) :**
   - Conditionné à la création préalable d'une application Meta validée et à la configuration des identifiants API (App ID, Secret, Access Token OAuth).
   - Stockage chiffré des jetons et déduplication par `meta_product_id`.
2. **PWA / Service Worker :**
   - Fichier `manifest.json` pour installation sur écran d'accueil smartphone. Mise en cache limitée aux assets statiques (mise en cache des pages admin et du checkout strictement interdite).

### D. OUT OF SCOPE (Explicitement exclu du MVP)
1. Inscription autonome de commerçants / architecture SaaS multi-tenant.
2. Passerelle de paiement en ligne automatisée (Stripe, PayPal, passerelles bancaires directes).
3. Gestion avancée multi-entrepôts et suivi logistique en temps réel via API transporteur.
4. Notifications SMS automatiques ou intégration WhatsApp Cloud API payante (le canal utilisé est l'URL wa.me côté client).
5. Architecture Node.js, microservices, Docker en production.

---

## 4. Règles métier non négociables (Synthèse d'intégrité)

| Règle ID | Énoncé de la règle | Implémentation technique obligatoire |
|---|---|---|
| **MS-BIZ-01** | Instance isolée par commerçant. | Configuration `.env` dédiée et base de données isolée par client. Aucun filtre `tenant_id` dynamique dans le code. |
| **MS-BIZ-02** | Contrôle de publication à l'achat. | Le checkout vérifie en base que chaque produit du panier est actif (`is_active = 1`) et disponible. |
| **MS-BIZ-03** | Total calculé exclusivement côté serveur. | Le panier recalculer `unit_price * quantity` à partir des données de la base. Aucun montant envoyé par le client n'est accepté. |
| **MS-BIZ-04** | Persistance préalable à WhatsApp. | Commit de la transaction SQL d'enregistrement de commande avant affichage ou génération du lien `https://wa.me/...`. |
| **MS-BIZ-05** | Déconnexion entre WhatsApp et statut commande. | Le clic sur le bouton WhatsApp ne modifie aucun statut. Seul le commerçant peut passer une commande à « Confirmée ». |
| **MS-BIZ-06** | Transitions de statuts autorisées et journalisées. | Machine à états finis côté serveur. Rejet des transitions incohérentes (ex: `Livrée` vers `En attente`). |
| **MS-BIZ-07** | Indépendance totale thème / données. | Les thèmes ne contiennent que des gabarits HTML/CSS. Les tables de données ne dépendent d'aucun thème. |
| **MS-BIZ-08** | Paiement en ligne exclu du MVP. | Les statuts de commande et statuts de paiement sont distincts. Enregistrement manuel des règlements par le commerçant. |

---

## 5. Matrice de traçabilité Exigences → Modules → Vues → Tests

| Exigence ID | Libellé exigence | Module applicatif | Vues / Templates | Fichiers de tests associés |
|---|---|---|---|---|
| **REQ-PUB-01** | Affichage vitrine et mise en avant | `CatalogModule` | `views/themes/fashion/home.php` | `tests/Feature/CatalogTest.php` |
| **REQ-PUB-02** | Navigation catégories et filtres | `CatalogModule` | `views/themes/fashion/category.php` | `tests/Feature/CatalogTest.php` |
| **REQ-PUB-03** | Fiche produit et variantes | `CatalogModule` | `views/themes/fashion/product.php` | `tests/Feature/ProductDetailTest.php` |
| **REQ-CRT-01** | Ajout / MAJ / Suppression panier | `CartModule` | `views/themes/fashion/cart.php` | `tests/Unit/CartServiceTest.php` |
| **REQ-ORD-01** | Validation checkout et calcul serveur | `OrderModule` | `views/themes/fashion/checkout.php` | `tests/Feature/CheckoutSecurityTest.php` |
| **REQ-ORD-02** | Persistance commande avant WhatsApp | `OrderModule` | `views/themes/fashion/order_confirmation.php` | `tests/Integration/OrderPersistenceTest.php` |
| **REQ-ADM-01** | Authentification commerçant & CSRF | `AuthModule` | `views/admin/login.php` | `tests/Feature/AdminAuthTest.php` |
| **REQ-ADM-02** | Suivi et changement statut commandes | `AdminOrderModule`| `views/admin/orders_list.php`, `order_detail.php` | `tests/Feature/OrderStatusTransitionTest.php` |
| **REQ-ADM-03** | CRUD Catalogue & Upload sécurisé | `AdminCatalogModule`| `views/admin/products_list.php`, `product_form.php`| `tests/Feature/ProductManagementTest.php` |
| **REQ-ADM-04** | Choix du thème actif sans perte | `ThemeModule` | `views/admin/themes_gallery.php` | `tests/Feature/ThemeSwitchTest.php` |
| **REQ-ADM-05** | Paramètres généraux et WhatsApp | `SettingsModule` | `views/admin/settings_general.php` | `tests/Feature/SettingsTest.php` |
| **REQ-IMP-01** | Import catalogue CSV | `ImportModule` | `views/admin/import_csv.php` | `tests/Integration/CsvImportTest.php` |

---

## 6. Contraintes techniques et déploiement cible

- **PHP :** Version 8.3 minimale, mode strict (`declare(strict_types=1);`).
- **Base de données :** MySQL 8.0, moteur InnoDB, encodage `utf8mb4_unicode_ci`.
- **Accès aux données :** PDO exclusif, requêtes préparées avec typage strict des paramètres liés.
- **Routage :** Front Controller unique (`public/index.php`) avec règles de réécriture Apache `.htaccess`.
- **Frontend :** HTML5 sémantique, CSS3 (variables de thèmes), JavaScript Vanilla ES6 (sans framework), Bootstrap 5.
- **Sécurité serveur :**
  - Sessions strictes : cookies `HttpOnly`, `SameSite=Lax`, `Secure` (en production HTTPS).
  - Protection CSRF synchronisée sur toutes les requêtes POST/PUT/DELETE.
  - Échappement systématique à l'affichage (`htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`).
  - Stockage des uploads hors du répertoire public d'exécution de scripts.
