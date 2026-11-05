# ETAPE_2_CONTRAT_THEMES.md
# Contrat d'Intégration et Spécification des Thèmes — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 2 — Conception UX/UI et validation des thèmes  
**Agent :** Agent UX/UI & Design System (Google Antigravity)  
**Règle absolue :** Règle métier `MS-BIZ-07` — *Changer de thème modifie uniquement la couche de présentation et préserve intégralement les données commerciales.*

---

## 1. Principe Fondamental du Contrat de Thème

Le système de thèmes de Marvens Shop repose sur une séparation architecturale stricte entre la **logique applicative/données (MVC)** et la **couche de présentation**.

```
┌────────────────────────────────────────────────────────────────────────┐
│ DONNÉES MÉTIER IMMUABLES (Base de données MySQL)                       │
│ Produits, Variantes, Catégories, Commandes, Clients, Numéro WhatsApp   │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ Injectées sans altération
┌───────────────────────────────────▼────────────────────────────────────┐
│ COUCHE DE PRÉSENTATION PLUGGABLE (Vues PHP + CSS Tokens)               │
│ [Thème Fashion]  ou  [Thème Bello]  ou  [Thème Luxe]  ou  [Thème Naya]  │
└────────────────────────────────────────────────────────────────────────┘
```

Lorsqu'un commerçant bascule de thème dans son administration :
1. Aucun enregistrement en base de données n'est modifié, supprimé ou dupliqué.
2. Seul l'identifiant du thème actif est mis à jour dans la configuration de la boutique (`active_theme = 'bello'`).
3. L'application charge le dossier de vues et la feuille de style correspondants.

---

## 2. Structure Normalisée d'un Thème Marvens

Chaque thème homologué dans Marvens Shop doit respecter la structure d'arborescence suivante (localisée sous `app/Views/themes/{theme_id}/`) :

```
app/Views/themes/{theme_id}/
├── layout.php                  # Squelette HTML global (Head, Tokens, Body, Footer)
├── assets/
│   ├── css/
│   │   ├── tokens.css          # Variables CSS racines spécifiques au thème (:root)
│   │   └── theme.css           # Surcharges et mise en page visuelle
│   └── images/
│       └── preview.png         # Miniature pour la galerie d'administration
├── partials/
│   ├── header.php              # Barre supérieure, navigation, recherche, panier
│   ├── footer.php              # Coordonnées, liens légaux, mentions
│   └── product_card.php        # Composant carte produit normalisé
└── pages/
    ├── home.php                # Page d'accueil (Hero, Mis en avant, Promotions)
    ├── catalog.php             # Liste catalogue et résultats de recherche
    ├── category.php            # Liste produits filtrée par catégorie
    ├── product.php             # Fiche détaillée produit et sélection variantes
    ├── cart.php                # Vue panier et calculs intermédiaires
    ├── checkout.php            # Formulaire de commande et sélection livraison
    └── order_confirmation.php  # Page de succès avec bouton d'action WhatsApp
```

---

## 3. Définition des Slots et Variables Obligatoires

Chaque vue partielle ou page d'un thème reçoit un contrat de données typé transmis par le contrôleur PHP. Le thème a l'obligation de traiter ces variables sans présumer de leur modification :

### A. Données de la Boutique (`$shop`)
- `$shop['name']` : Nom commercial affiché.
- `$shop['logo_url']` : URL du logo (avec fallback texte si vide).
- `$shop['favicon_url']` : URL du favicon.
- `$shop['whatsapp_number']` : Numéro format international pour le contact.
- `$shop['currency']` : Symbole monétaire (`FCFA`).

### B. Données d'un Produit (`$product`)
- `$product['id']`, `$product['name']`, `$product['slug']`.
- `$product['price']` (entier/décimal en FCFA), `$product['promotional_price']` (optionnel).
- `$product['main_image_url']`, `$product['gallery_images']` (tableau d'URLs).
- `$product['is_available']` (booléen), `$product['variants']` (tailles/couleurs disponibles).
- `$product['sku']` (référence produit).

### C. Données d'une Commande (`$order`)
- `$order['order_number']` : Numéro unique immuable (`#CMD-YYYYMMDD-XXXX`).
- `$order['total_amount']` : Montant total calculé côté serveur.
- `$order['whatsapp_url']` : Lien encodé prêt à l'ouverture `https://wa.me/{num}?text=...`.

---

## 4. Mécanisme de Fallback et Sécurité

1. **Fallback de Vue :**  
   Si un thème alternatif ne fournit pas une vue spécifique (par exemple `pages/category.php`), le système de rendu bascule automatiquement et de manière transparente sur la vue correspondante du thème par défaut (`themes/fashion/pages/category.php`). La boutique ne plante jamais.
2. **Neutralisation de Code Malveillant :**  
   - Aucun script PHP arbitraire téléversé par un zip externe n'est exécuté sans contrôle.
   - Les thèmes activables au MVP sont uniquement ceux audités et préinstallés dans `themes/` (`fashion`, `bello`, `luxe`, `naya`, `shop`).
3. **Réinitialisation en 1 Clic (Reset) :**  
   Depuis le tableau de bord, le commerçant dispose d'un bouton « Réinitialiser aux valeurs par défaut du thème » qui remet les variables de couleurs personnalisées à leur valeur d'origine définie dans le `DESIGN.md` du thème.
4. **Rollback Immédiat :**  
   Possibilité de revenir au thème précédent en un clic si le rendu ne convient pas au commerçant.
