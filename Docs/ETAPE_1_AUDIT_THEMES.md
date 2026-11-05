# ETAPE_1_AUDIT_THEMES.md
# Audit de conformité des thèmes Stitch — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 1 — Cadrage, audit du dépôt et validation du périmètre  
**Agent :** Agent principal de réalisation technique (Google Antigravity)  
**Emplacement des thèmes :** `themes/`

---

## 1. Inventaire physique et intégrité des archives

Toutes les archives présentes dans le dossier `themes/` ont été testées par extraction de flux binaire (module `zipfile`). Aucune archive n'est corrompue.

| Fichier archive | Rôle dans le projet | Taille | Intégrité | Fichiers internes |
|---|---|---|---|---|
| **`Theme fashion.zip`** | **Thème public par défaut (Boutique)** | 866 630 octets | **Valide** | `code.html` (42 Ko), `screen.png` (856 Ko), `DESIGN.md` (6,8 Ko) |
| **`Theme dashboard.zip`** | **Thème d'administration (Dashboard)** | 174 732 octets | **Valide** | `code.html` (23 Ko), `screen.png` (185 Ko), `DESIGN.md` (6,0 Ko) |
| `Theme bello.zip` | Thème boutique alternatif | 659 298 octets | Valide | `code.html`, `screen.png`, `DESIGN.md` |
| `Theme luxe.zip` | Thème boutique alternatif | 516 385 octets | Valide | `code.html`, `screen.png`, `DESIGN.md` |
| `Theme naya.zip` | Thème boutique alternatif | 675 187 octets | Valide | `code.html`, `screen.png`, `DESIGN.md` |
| `Theme shop.zip` | Thème boutique alternatif | 543 929 octets | Valide | `code.html`, `screen.png`, `DESIGN.md` |

---

## 2. Analyse détaillée du thème boutique par défaut : `Theme fashion.zip`

### A. Identité visuelle et Tokens (`DESIGN.md`)
- **Nom du thème :** Marvens Shop
- **Ambiance :** Mode, éditorial, chaleureux et premium.
- **Palette chromatique extraite :**
  - Surface : `#fff8f5` (fond coquille d'œuf chaud)
  - Surface-container-lowest : `#ffffff` (fond pur pour cartes et fiches)
  - Surface-container : `#fdeade` (surfaces de contraste doux)
  - On-surface (texte principal) : `#231a13` (brun foncé très lisible)
  - On-surface-variant (texte secondaire) : `#554336`
  - Primary (couleur d'accent / appel à l'action) : `#8d4b00` (caramel / ambre doré profond)
  - Primary-container : `#b15f00`
  - On-primary : `#ffffff`
  - Secondary : `#565e74` (gris bleuté d'appoint)
  - Error : `#ba1a1a`
- **Typographie et Iconographie :**
  - Police d'icônes : *Google Material Symbols Outlined*.
  - Typographie éditoriale moderne et épurée.

### B. Structure observée dans `code.html` (527 lignes)
- **Header & Navigation :**
  - Barre de contact supérieure discrète.
  - Logo de la marque + liens de navigation (Nouveautés, Vêtements, Accessoires, Promotions).
  - Barre d'action rapide : recherche, accès compte, compteur panier badgeé.
- **Section Hero :**
  - Grande bannière d'impact visuel avec accroche commerciale et bouton d'action principal.
- **Grille de Catalogue :**
  - Cartes produits riches : photo avec ratio soigné, badge promotion/nouveauté, titre du produit, catégorie, prix barré et prix promotionnel, bouton d'ajout au panier.
- **Blocs de réassurance :**
  - Livraison rapide, commande directe WhatsApp, assistance commerçant.
- **Footer :**
  - Coordonnées de la boutique, horaires, liens vers pages légales/pratiques (Livraison, Retours, CGV), bouton direct WhatsApp.

---

## 3. Analyse détaillée du thème administration : `Theme dashboard.zip`

### A. Identité visuelle et Tokens (`DESIGN.md`)
- **Nom du thème :** Swiss Editorial Commerce
- **Ambiance :** Style suisse, minimaliste, rigoureux, haute lisibilité des données, typographie suisse moderne.
- **Palette chromatique extraite :**
  - Surface : `#FFFFFF` (fond blanc épuré)
  - Surface-container-low : `#f6f3f5` (fond pour les barres d'outils et cartes KPI)
  - Surface-container : `#f0edef`
  - On-surface : `#1b1b1d` (noir charbon d'encre pour contraste maximal)
  - On-surface-variant : `#45464d` (gris neutre pour labels et métadonnées)
  - Primary : `#000000` (accent noir rigoureux)
  - Secondary : `#904d00` (ambre doré rappelant la marque)
  - Outline : `#76777d` / Outline-variant : `#c6c6cd` (séparateurs ultra fins)
- **Typographie et Iconographie :**
  - Police principale : *Inter* (Google Fonts, poids 100 à 900).
  - Icônes : *Material Symbols Outlined*.

### B. Structure observée dans `code.html` (284 lignes)
- **Sidebar de navigation principale :**
  - Logo Marvens Shop / Nom du commerçant.
  - Liens de rubriques structurées : Tableau de bord, Commandes (avec compteur d'alertes), Produits & Catalogue, Clients, Thèmes & Apparence, Paramètres, Déconnexion.
- **Barre supérieure :**
  - Fil d'Ariane, statut de la boutique en ligne, sélecteur rapide de période, profil administrateur.
- **Cartes d'indicateurs clés (KPIs) :**
  - Chiffre d'affaires consolidé, Nombre de commandes, Commandes en attente de traitement, Panier moyen.
- **Tableau de données des commandes récentes :**
  - Numéro de commande unique (`#CMD-XXXX`), Date/heure, Nom du client, Montant total en FCFA, Badge de statut de commande (En attente, Confirmée, Payée, Livrée, Annulée), Actions rapides (Voir détail, ouvrir WhatsApp).

---

## 4. Contraintes techniques d'intégration et points de fidélité

### A. Analyse de la dépendance Tailwind dans les fichiers sources Stitch
- **Constat :** Les deux fichiers `code.html` s'appuient sur `<script src="https://cdn.tailwindcss.com"></script>` et des classes utilitaires Tailwind (ex: `bg-surface`, `text-on-surface`, `flex`, `grid-cols-4`).
- **Exigence d'architecture :** La stack officielle imposée pour Marvens Shop est **Bootstrap 5 + CSS3 personnalisé** (aucun script Tailwind CDN en production, instable et dépendant du réseau externe).
- **Solution de conversion (pour les Étapes 2 & 3) :**
  - Conserver rigoureusement **les valeurs exactes de couleurs, espacements, rayons de bordure et typographies** définies dans `DESIGN.md`.
  - Intégrer les variables CSS racines (`:root`) contenant ces tokens pour chaque thème.
  - Mapper la structure HTML vers la grille Bootstrap 5 (`container`, `row`, `col-*`) ou une feuille de style modulaire CSS dédiée respectant fidèlement le rendu de `screen.png`.

### B. Séparation stricte Thème / Données métier (Règle `MS-BIZ-07`)
- Aucun template Stitch ne contient ni ne génère de données autoritaires.
- Les templates serviront de **vues partielles PHP échappées** (`views/themes/fashion/` et `views/admin/`).
- Le basculement vers les thèmes alternatifs (`bello`, `luxe`, `naya`, `shop`) se fera exclusivement par commutation de classe de mise en page et de feuille de style, sans toucher aux tables de la base de données (produits, commandes, clients restent immuables).

---

## 5. Conclusion sur les thèmes

1. Les deux thèmes requis sont **présents, complets, intègres et documentés**.
2. Les captures d'écran de référence (`screen.png`) et les spécifications de tokens (`DESIGN.md`) fournissent une référence visuelle indiscutable.
3. Aucune direction artistique n'a besoin d'être inventée : les standards visuels sont clairs et prêts pour la conception UX/UI de l'Étape 2.
