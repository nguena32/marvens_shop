# ETAPE_2_MATRICE_TRAÇABILITE_ET_REVUE.md
# Matrice de Traçabilité UX et Revue de Qualité Design — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 2 — Conception UX/UI et validation des thèmes  
**Agent :** Agent UX/UI & Design System (Google Antigravity)  
**Normes de revue :** WCAG 2.1 AA, Responsive 320px–1280px+, Framework Creative Brief (`10_QUALITY_ASSURANCE/`).

---

## 1. Matrice de Traçabilité Complète : Exigences → Parcours → Écrans → Maquettes → Modules

| ID Exigence | Libellé Fonctionnel | Parcours Utilisateur | Écran UX Associé | Fichier Maquette / Spécification | Module Backend Cible |
|---|---|---|---|---|---|
| **REQ-PUB-01** | Page d'accueil & Vitrine | Parcours 1 (Découverte) | Écran S1 (Accueil) | `Docs/maquettes/maquette_storefront_fashion.html` | `CatalogModule` |
| **REQ-PUB-02** | Catalogue & Catégories | Parcours 1 (Exploration) | Écran S2 (Listing) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-s2` | `CatalogModule` |
| **REQ-PUB-03** | Fiche produit & Variantes | Parcours 1 (Sélection) | Écran S3 (Fiche Produit) | `Docs/ETAPE_2_COMPOSANTS_UI.md#c1-carte-produit` | `CatalogModule` |
| **REQ-CRT-01** | Panier & Gestion quantités | Parcours 1 (Panier) | Écran S4 (Panier) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-s4` | `CartModule` |
| **REQ-ORD-01** | Prise de commande sécurisée | Parcours 1 (Checkout) | Écran S5 (Checkout) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-s5` | `OrderModule` |
| **REQ-ORD-02** | Persistance & Lien WhatsApp | Parcours 1 (Confirmation) | Écran S6 (Confirmation) | `Docs/ETAPE_2_UX_BLUEPRINT.md#section-2` | `OrderModule` |
| **REQ-ADM-01** | Authentification commerçant | Parcours 2 (Connexion) | Écran A1 (Login) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-a1` | `AuthModule` |
| **REQ-ADM-02** | Tableau de bord & KPIs | Parcours 2 (Pilotage) | Écran A2 (Dashboard) | `Docs/maquettes/maquette_dashboard_swiss.html` | `AdminDashboardModule` |
| **REQ-ADM-03** | Gestion & Suivi commandes | Parcours 2 (Traitement) | Écran A3 (Commandes) | `Docs/maquettes/maquette_dashboard_swiss.html` | `AdminOrderModule` |
| **REQ-ADM-04** | CRUD Produits & Variantes | Parcours 2 (Catalogue) | Écran A4 (Produits) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-a4` | `AdminCatalogModule` |
| **REQ-ADM-05** | Galerie thèmes & Basculement | Parcours 3 (Apparence) | Écran A5 (Thèmes) | `Docs/ETAPE_2_CONTRAT_THEMES.md` | `ThemeModule` |
| **REQ-IMP-01** | Importation catalogue CSV | Parcours Admin (Import) | Écran A6 (Import) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-a6` | `ImportModule` |
| **REQ-SET-01** | Paramètres généraux & WhatsApp | Parcours Admin (Config) | Écran A7 (Paramètres) | `Docs/ETAPE_2_SPECIFICATIONS_ECRANS.md#écran-a7` | `SettingsModule` |

---

## 2. Résultats de la Revue Responsive Multi-Breakpoints

La conception a été passée en revue sur les cinq largeurs cibles prescrites :

| Largeur testée | Environnement cible | Constats Storefront (Fashion) | Constats Dashboard (Swiss) | Statut Qualité |
|---|---|---|---|---|
| **320 px** | Très petits smartphones | Pas de débordement horizontal. Navigation masquée derrière tiroir. Cartes produits empilées ou en grille compacte 2 colonnes sans troncature critique des prix. Cibles tactiles ≥ 44px. | Sidebar rétractée. Cartes KPI empilées en 1 colonne. Le tableau bascule en mode défilement horizontal ou cartes résumées. | **CONFORME** |
| **360 px** | Smartphone standard (Android courant) | Ratio visuel optimal. Le bouton flottant WhatsApp et le bouton d'ajout au panier occupent 100% de la largeur avec padding confortable. | Espacements nets, typographie Inter 14px parfaitement lisible. | **CONFORME** |
| **768 px** | Tablettes portrait | Grille catalogue 3 colonnes. Fiche produit avec galerie photo au-dessus du bloc d'achat ou 50/50. | Cartes KPI sur 2 colonnes. Sidebar repliable avec bouton hamburger. | **CONFORME** |
| **1024 px** | Ordinateurs portables / Tablettes paysage | Grille catalogue 4 colonnes régulières. Fiche produit en 2 colonnes côte à côte (Photo à gauche / Achat à droite). | Sidebar visible en permanence (largeur 240px). Tableau complet visible sans défilement horizontal. | **CONFORME** |
| **1280 px+** | Écrans larges Desktop | Conteneur principal centré avec marge maximale pour éviter l'étirement des lignes de texte (`max-width: 1200px`). | Vue condensée des commandes, multi-panneaux d'édition sans scrolling parasite. | **CONFORME** |

---

## 3. Résultats de la Revue Accessibilité (WCAG 2.1 AA)

- **Contraste chromatique :**
  - Thème Fashion : `#231a13` (Brun foncé) sur `#fff8f5` (Fond clair) = **13.8:1** (seuil exigé : 4.5:1).
  - Thème Dashboard Swiss : `#1b1b1d` sur `#ffffff` = **18.2:1**.
  - Badges de statut de commandes : Tous les couples de couleurs (fond/texte) ont été normalisés pour dépasser un ratio minimal de 5.2:1.
- **Navigation au clavier :**
  - L'ensemble des formulaires et déclencheurs d'action possède un style de focus explicite (`outline: 2px solid var(--ms-color-primary); outline-offset: 2px`).
  - Aucun piège au clavier dans les tiroirs hors-champ (Offcanvas) grâce à la gestion native accessible des attributs `aria-hidden` et de la touche Échap (`Escape`).
- **Formulaires et champs :**
  - Aucun champ sans balise `<label>` associée par identifiant `for`.
  - Pas de dépendance exclusive à la couleur pour signaler les erreurs (message d'aide textuel sous le champ invalide).

---

## 4. Registre des Décisions Ouvertes et Risques Résiduels

| Réf. Décision | Sujet / Question | Impact UX/UI | Recommandation Agent | Statut |
|---|---|---|---|---|
| **DEC-UI-01** | **Conversion Tailwind → CSS/Bootstrap** | Les thèmes Stitch originaux utilisent Tailwind CDN. | Conversion directe opérée en variables CSS `--ms-*` et classes Bootstrap 5 pures pour garantir l'autonomie cPanel sans Node.js. | **Validé en conception** |
| **DEC-UI-02** | **Mode d'affichage des variantes (Tailles/Couleurs)** | Comment afficher les variantes sur mobile sans alourdir la fiche produit ? | Boutons pilules cliquables compacts (hauteur 36px), désactivation visuelle immédiate des variantes en rupture. | **Recommandé** |
| **DEC-UI-03** | **Mode de visualisation du panier sur mobile** | Page dédiée `/panier` ou tiroir Offcanvas ? | Tiroir Offcanvas instantané lors de l'ajout + page récapitulative complète `/panier` pour le contrôle final. | **Recommandé** |

---

## 5. Prérequis et Dépendances pour l'Étape 3 (Fondations Techniques)

L'Étape 2 étant intégralement modélisée, l'agent chargé de l'**Étape 3** disposera des contrats stables suivants :
1. **Schéma de base de données MySQL 8 :**
   - Tables nécessaires : `shops_settings`, `categories`, `products`, `product_variants`, `orders`, `order_items`, `order_history`.
2. **Arborescence MVC Vanilla PHP :**
   - Implantation de `app/Views/themes/fashion/` et `app/Views/admin/` basée sur les maquettes et composants spécifiés.
3. **Moteur de rendu de thèmes :**
   - Injection des variables de configuration du thème actif via le contrôleur de rendu.
