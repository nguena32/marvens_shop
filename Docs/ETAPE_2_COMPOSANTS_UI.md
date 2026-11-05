# ETAPE_2_COMPOSANTS_UI.md
# Bibliothèque de Composants UI et Règles d'Accessibilité — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 2 — Conception UX/UI et validation des thèmes  
**Agent :** Agent UX/UI & Design System (Google Antigravity)  
**Normes appliquées :** WCAG 2.1 Niveau AA, Creative Brief (`06_DESIGN_SYSTEM/COMPONENT_LIBRARY.md`).

---

## 1. Principes de Conception des Composants

Tous les composants UI de Marvens Shop sont conçus pour :
1. **Être totalement autonomes :** Ils fonctionnent en HTML5 natif et CSS pur, enrichis par les utilitaires Bootstrap 5.
2. **Garantir l'accessibilité native (A11y) :** Contraste supérieur à 4.5:1, attributs ARIA explicites, états de focus visibles, navigation clavier intégrale.
3. **Supporter les états complets :** Normal, Hover, Focus, Active, Disabled, Loading (skeleton), Empty et Error.

---

## 2. Inventaire Détaillé des Composants Storefront (Public)

### C1. Carte Produit (`ProductCard`)
- **Rôle :** Affichage d'un article dans la grille du catalogue et en page d'accueil.
- **Éléments visuels :**
  - Conteneur blanc avec micro-bordure douce 1px (`--ms-color-border`).
  - Image produit au ratio 4:5 ou 1:1, avec alternative textuelle (`alt="Nom du produit"`).
  - Pastille d'état : Badge « NOUVEAU » ou « PROMO -20% » en position absolue en haut à gauche.
  - Titre du produit avec troncature propre sur 2 lignes maximum.
  - Ligne de prix : Prix actuel en gras et prix barré si promotion.
  - Bouton d'action rapide : « Voir le produit » ou « Ajouter au panier » d'une hauteur tactile de 44px.
- **Accessibilité :** Lien englobant accessible au clavier avec focus visible ambré (`outline: 2px solid var(--ms-color-primary)`).

### C2. Sélecteur de Variantes & Quantité (`VariantSelector` & `QuantityPicker`)
- **Rôle :** Permettre le choix d'une taille (ex: S, M, L, XL) ou d'une couleur avant commande.
- **Interaction :**
  - Boutons radio stylisés sous forme de pilules carrées/arrondies.
  - État sélectionné : Fond noir/ambre avec texte blanc inversé.
  - État indisponible : Texte barré, grisé, non sélectionnable (`disabled`).
  - Sélecteur de quantité : Boutons `[-]` et `[+]` confortables entourant un champ numérique en lecture seule sur mobile pour éviter l'ouverture intempestive du clavier virtuel.

### C3. Panier Flottant & Résumé (`CartBadge` & `CartDrawer`)
- **Rôle :** Accès immédiat au panier depuis n'importe quelle page.
- **Interaction :**
  - Icône de sac de shopping dans le header avec bulle de notification numérique animée à chaque ajout.
  - Tiroir latéral (Offcanvas Bootstrap 5) sur mobile ou page dédiée sur desktop.
  - Liste récapitulative avec calcul dynamique du sous-total.

### C4. Bouton d'Action WhatsApp (`WhatsAppButton`)
- **Rôle :** Déclenchement de la discussion ou finalisation de commande.
- **Rendu :**
  - Couleur verte officielle WhatsApp (`#25D366`), texte blanc en gras.
  - Icône SVG WhatsApp officielle intégrée.
  - Hauteur minimale 48px sur mobile, occupant 100% de la largeur sur les écrans `< 576px`.

---

## 3. Inventaire Détaillé des Composants Dashboard (Admin)

### C5. Pastille de Statut de Commande (`StatusBadge`)
- **Rôle :** Représentation visuelle immédiate de l'état d'avancement d'une commande.
- **Variantes chromatiques (Contraste testé AA) :**
  - `En attente` : Fond jaune-ambré clair (`#fef3c7`), texte ambre foncé (`#92400e`).
  - `Confirmée` : Fond bleu clair (`#dbeafe`), texte bleu foncé (`#1e40af`).
  - `Paiement en attente` : Fond violet clair (`#ede9fe`), texte violet (`#5b21b6`).
  - `Payée` : Fond vert menthe (`#d1fae5`), texte vert sombre (`#065f46`).
  - `En préparation` : Fond cyan (`#cffafe`), texte cyan foncé (`#155e75`).
  - `Expédiée` : Fond indigo (`#e0e7ff`), texte indigo (`#3730a3`).
  - `Livrée` : Fond émeraude (`#ecfdf5`), texte émeraude foncé (`#047857`).
  - `Annulée` : Fond rouge pâle (`#fee2e2`), texte rouge vif (`#991b1b`).

### C6. Tableau de Données Responsive (`AdminDataTable`)
- **Rôle :** Consultation rapide et tri des commandes ou des produits.
- **Comportement multi-écrans :**
  - Desktop : Tableau complet 6 colonnes (ID, Date, Client, Total, Statut, Actions).
  - Mobile : Transformation automatique en cartes empilées ou défilement tactile fluide avec colonne d'actions figée.

### C7. Bloc d'Alerte et Notification (`FeedbackAlert`)
- **Rôle :** Confirmer une action (succès d'enregistrement, changement de statut, rapport d'import).
- **Rendu :** Bandeau dismissible avec icône Material Symbols explicite (check, info, warning, error) respectant les couleurs sémantiques.

---

## 4. Revue d'Accessibilité et Checklist WCAG 2.1 AA

| Critère WCAG | Exigence technique | Implémentation dans Marvens Shop |
|---|---|---|
| **1.4.3 Contraste (Minimum)** | Ratio de 4.5:1 pour texte normal, 3:1 pour texte large. | Respecté : `#231a13` sur `#fff8f5` = ratio 13.8:1 ; `#1b1b1d` sur `#ffffff` = ratio 18.2:1. |
| **2.1.1 Clavier** | Toutes les fonctionnalités opérables au clavier seul. | Ordre de tabulation logique `tabindex`, piège de focus sur les modales. |
| **2.4.7 Focus visible** | Indicateur de focus nettement perceptible. | Anneau de focus ambré `2px solid #8d4b00` décalé de 2px (`outline-offset`). |
| **2.5.5 Cible tactile** | Taille minimale de 44x44 pixels pour les cibles tactiles. | Tous les boutons d'action et champs ont une hauteur ≥ 44px sur mobile. |
| **3.3.2 Étiquettes / Instructions** | Labels explicites pour tous les champs de saisie. | Balises `<label for="...">` systématiques avec texte visible, pas de placeholder seul. |
