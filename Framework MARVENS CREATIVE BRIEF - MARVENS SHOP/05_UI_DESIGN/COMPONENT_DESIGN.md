# COMPONENT DESIGN — Conception et Spécification des Composants UI
## MARVENS CREATIVE BRIEF V1.0 · PHASE 05_UI_DESIGN

> **Document :** Spécification technique, anatomie, variantes, états et règles d'accessibilité des composants d'interface  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [UI_GUIDELINES.md](UI_GUIDELINES.md) · [LAYOUT_SYSTEM.md](LAYOUT_SYSTEM.md) · [COLOR_SYSTEM.md](../03_BRAND_AND_VISUAL_IDENTITY/COLOR_SYSTEM.md) · [ICONOGRAPHY.md](../03_BRAND_AND_VISUAL_IDENTITY/ICONOGRAPHY.md) · [ACCESSIBILITY.md](../04_UX_DESIGN/ACCESSIBILITY.md)

---

## Sommaire

1. [Rôle des composants et principes d'architecture](#1-rôle-des-composants-et-principes-darchitecture)
2. [Anatomie canonique d'un composant](#2-anatomie-canonique-dun-composant)
3. [Taxonomie et classification générale](#3-taxonomie-et-classification-générale)
4. [Spécifications détaillées des composants fondamentaux](#4-spécifications-détaillées-des-composants-fondamentaux)
   - 4.1 Actions : Boutons et Liens d'action
   - 4.2 Saisie et Contrôles : Champs texte, Selects, Checkboxes, Radios, Switches
   - 4.3 Affichage et Statut : Badges, Tags, Avatars, Cartes
   - 4.4 Feedback et Rétroaction : Alertes, Toasts, Skeletons, Indicateurs de progression
   - 4.5 Overlays et Modales : Dialogues, Tiroirs (Drawers), Menus déroulants (Dropdowns)
   - 4.6 Navigation et Pagination : Onglets (Tabs), Fil d'Ariane (Breadcrumbs), Pagination
   - 4.7 Vues spéciales : État vide (Empty State)
5. [Matrice des variantes : Tailles, priorités et densités](#5-matrice-des-variantes-tailles-priorités-et-densités)
6. [Gestion complète des 8 états par composant](#6-gestion-complète-des-8-états-par-composant)
7. [Règles d'accessibilité, sémantique HTML5 et support clavier (ARIA)](#7-règles-daccessibilité-sémantique-html5-et-support-clavier-aria)
8. [Gouvernance du catalogue de composants](#8-gouvernance-du-catalogue-de-composants)
9. [Checklist qualité composant](#9-checklist-qualité-composant)

---

## 1. Rôle des composants et principes d'architecture

Dans **MARVENS CREATIVE BRIEF V1.0**, un composant UI est une brique unitaire réutilisable combinant structure HTML sémantique, habillage visuel (CSS Tokens) et comportement interactif rigoureusement prévisible. Les composants constituent le vocabulaire opérationnel du produit.

### Principes cardinaux de conception des composants :
- **Responsabilité unique :** Un composant accomplit une tâche précise sans déborder sur le rôle d'un autre (ex. un bouton déclenche une action ; un lien effectue une navigation).
- **Composition modulaire :** Les composants complexes sont assemblés par composition de composants élémentaires plus simples.
- **Indépendance contextuelle :** Un composant ne doit pas présumer de son emplacement dans la page ; ses dimensions s'adaptent naturellement au conteneur parent qui l'accueille.
- **Résilience et accessibilité native :** Tout composant est pensé pour fonctionner au clavier, avec un lecteur d'écran et sur écran tactile dès sa conception initiale.

---

## 2. Anatomie canonique d'un composant

Chaque composant interactif du système se décompose selon le modèle anatomique standardisé suivant :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                            ANATOMIE D'UN COMPOSANT                          │
│                                                                             │
│   ┌─────────────────────────────────────────────────────────────────────┐   │
│   │ [1. Icône préfixe]  [2. Libellé / Texte]  [3. Badge / Icône suffixe]│   │
│   └─────────────────────────────────────────────────────────────────────┘   │
│   │◄───────────────────────── 4. Conteneur ────────────────────────────►│   │
│                                                                             │
│   1. Élément graphique contextuel (icône SVG 16x16 ou 20x20)                │
│   2. Libellé sémantique explicite (typographie standard, contrastée)        │
│   3. Métadonnée additionnelle (compteur, chevron déroulant, raccourci)      │
│   4. Zone réceptrice d'interaction (padding, bordure, rayon, fond, ombre)   │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 3. Taxonomie et classification générale

Les composants de l'écosystème Marvens sont ordonnés en sept familles fonctionnelles :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     FAMILLES DE COMPOSANTS D'INTERFACE                      │
├─────────────────┬───────────────────────────────────────────────────────────┤
│ 1. ACTIONS      │ Button, Button-Group, Split-Button, Action-Link           │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 2. SAISIE       │ Input Text, Textarea, Select, Checkbox, Radio, Switch     │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 3. AFFICHAGE    │ Card, Badge, Tag, Avatar, Stat-Widget, Tooltip            │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 4. FEEDBACK     │ Alert, Toast, Skeleton, Progress-Bar, Spinner             │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 5. OVERLAYS     │ Modal-Dialog, Offcanvas-Drawer, Dropdown-Menu, Popover    │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 6. NAVIGATION   │ Tabs, Breadcrumb, Pagination, Stepper, Sidebar-Item       │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 7. SYSTÈMES     │ Empty-State, Error-Boundary, Offline-Notice               │
└─────────────────┴───────────────────────────────────────────────────────────┘
```

---

## 4. Spécifications détaillées des composants fondamentaux

### 4.1 Actions : Le Bouton (`Button`)
Le bouton est le déclencheur d'action le plus critique. Il se décline en 4 niveaux de priorité hiérarchique :

```
[ Solid Primary ]    [ Secondary Outline ]    [ Ghost / Subtle ]    [ Danger Solid ]
┌───────────────┐    ┌───────────────────┐    ┌────────────────┐    ┌──────────────┐
│  Enregistrer  │    │     Exporter      │    │    Annuler     │    │  Supprimer   │
└───────────────┘    └───────────────────┘    └────────────────┘    └──────────────┘
```

- **Variantes de style :**
  - `Primary` : Fond bleu marine/institutionnel Marvens (`#0F172A` ou accent produit), texte blanc, ombre légère.
  - `Secondary` : Fond transparent ou blanc, bordure 1px neutre (`#CBD5E1`), texte foncé.
  - `Ghost` : Fond transparent, aucun contour au repos, apparition d'un fond subtil au survol.
  - `Danger` : Fond rouge alerte (`#DC2626`), texte blanc, réservé aux actions irréversibles.
- **Variantes de taille :**
  - `SM` (32px haut) : Pour tableaux denses et barres d'outils compactes.
  - `MD` (40px haut) : **Taille par défaut** pour les formulaires desktop.
  - `LG` (48px haut) : Pour les écrans mobiles et le bouton CTA principal d'une vue de vente.

### 4.2 Saisie et Contrôles
- **Champ texte (`Input Text`) :**
  - Hauteur standard : 40px (desktop), 44px (mobile).
  - Rayon : `var(--radius-md)` (6px).
  - Bordure par défaut : 1px solide `#CBD5E1`.
  - État focus : Anneau de focus 2px avec dégagement de 1px.
  - Structure : Label supérieur permanent (jamais de label qui s'efface), zone d'icône optionnelle, texte d'aide ou message d'erreur rouge immédiat sous le champ.
- **Sélecteur (`Select / Dropdown Select`) :**
  - Aspect cohérent avec l'input texte, intégrant un chevron SVG distinct à droite (16px).
- **Bouton à bascule (`Switch`) :**
  - Dimensions : Largeur 40px, Hauteur 22px, pastille blanche intérieure 18px.
  - Réservé aux réglages à effet immédiat sans obligation d'appuyer sur « Enregistrer » (ex. `Activer le mode hors-ligne`).

### 4.3 Affichage et Statut
- **Badges de statut (`Badge`) :**
  - Hauteur fixe : 22px à 24px.
  - Rayon : `var(--radius-full)` (forme pilule) ou `var(--radius-sm)` (4px).
  - Police : 12px semi-bold, majuscules discrètes ou casse standard.
  - Couleurs sémantiques strictes :
    - *Succès (Payé, Actif) :* Fond vert clair (`#DCFCE7`), texte vert foncé (`#166534`).
    - *Avertissement (En attente) :* Fond jaune clair (`#FEF9C3`), texte brun/orange (`#854D0E`).
    - *Danger (Échoué, Rejeté) :* Fond rouge clair (`#FEE2E2`), texte rouge foncé (`#991B1B`).
    - *Neutre (Brouillon) :* Fond ardoise clair (`#F1F5F9`), texte ardoise foncé (`#475569`).

### 4.4 Feedback et Rétroaction
- **Alertes en ligne (`Alert`) :**
  - Bandeau d'information contextuel avec icône thématique, titre court en gras, texte explicatif et bouton de fermeture facultatif.
- **Notifications Toast (`Toast`) :**
  - Carte flottante légère ancrée en haut à droite, fond blanc contrasté ou sombre, barre latérale colorée selon le statut, apparition animée et persistance calibrée (4s par défaut).
- **Squelettes de chargement (`Skeleton`) :**
  - Formes géométriques neutres (`#E2E8F0`) animées par une légère onde de pulsation lumineuse imitant la silhouette des données en attente.

### 4.5 Overlays et Modales
- **Boîte de dialogue modale (`Modal Dialog`) :**
  - Largeurs standardisées : `sm` (400px), `md` (540px), `lg` (720px), `xl` (900px).
  - Présente systématiquement un titre clair, une croix de fermeture `aria-label="Fermer"` et deux boutons en pied de modale (action principale à droite, annulation à gauche).
- **Tiroir latéral (`Offcanvas Drawer`) :**
  - Se déploie depuis le bord droit (pour afficher un panneau d'édition sans quitter la vue) ou gauche (menu mobile).

### 4.6 Navigation
- **Onglets (`Tabs`) :**
  - Deux styles autorisés : style *Underline* (ligne active de 2px sous le libellé) ou style *Segmented Control* (pilules encadrées).
- **Fil d'Ariane (`Breadcrumb`) :**
  - Séparateur par chevron SVG neutre (`/` ou `>`), texte discret pour les niveaux parents, texte foncé non cliquable pour l'écran courant.

### 4.7 Vues spéciales : État vide (`Empty State`)
- Composant composé de :
  1. Illustration SVG épurée ou icône stylisée en grand format (48px à 64px) dans un cercle teinté.
  2. Titre explicite décrivant l'état (`Aucune facture émise ce mois-ci`).
  3. Paragraphe explicatif de 2 lignes guidant l'utilisateur sur la démarche à suivre.
  4. Bouton CTA primaire pour déclencher l'action immédiate (`+ Créer une facture`).

---

## 5. Matrice des variantes : Tailles, priorités et densités

| Composant | Variante XS/SM | Variante MD (Défaut) | Variante LG |
|---|---|---|---|
| **Bouton** | H: 32px · Text: 13px · Pad: 8px 12px | H: 40px · Text: 14px · Pad: 10px 16px | H: 48px · Text: 16px · Pad: 12px 24px |
| **Input / Select** | H: 32px · Text: 13px · Pad: 6px 10px | H: 40px · Text: 14px · Pad: 8px 12px | H: 48px · Text: 16px · Pad: 12px 16px |
| **Badge** | H: 18px · Text: 11px | H: 22px · Text: 12px | H: 26px · Text: 13px |
| **Avatar** | 24 × 24 px | 36 × 36 px | 48 × 48 px (Profil: 64px+) |

---

## 6. Gestion complète des 8 états par composant

Pour chaque composant interactif (ex. bouton ou champ texte), les 8 états d'interaction doivent être explicitement pris en compte :

```css
/* Exemple d'implémentation robuste des états d'un composant de saisie */
.c-input {
  /* 1. État Initial / Défaut */
  background-color: #FFFFFF;
  border: 1px solid #CBD5E1;
  color: #0F172A;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

/* 2. État Survol (Hover) */
.c-input:hover:not(:disabled) {
  border-color: #94A3B8;
}

/* 3. État Focus (Focus-Visible) */
.c-input:focus-visible {
  outline: none;
  border-color: #0284C7;
  box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
}

/* 4. État Erreur (Invalid) */
.c-input.is-invalid {
  border-color: #DC2626;
  background-color: #FEF2F2;
}

/* 5. État Succès (Validé) */
.c-input.is-valid {
  border-color: #16A34A;
}

/* 6. État Désactivé (Disabled) */
.c-input:disabled {
  background-color: #F1F5F9;
  border-color: #E2E8F0;
  color: #94A3B8;
  cursor: not-allowed;
}

/* 7. État Chargement (Loading / Pending) */
.c-btn.is-loading {
  pointer-events: none;
  opacity: 0.8;
  position: relative;
  color: transparent !important; /* Masque le texte temporairement */
}
/* Le spinner SVG prend place au centre du bouton */
```

---

## 7. Règles d'accessibilité, sémantique HTML5 et support clavier (ARIA)

L'accessibilité n'est pas une option rapportée : elle est gravée dans le balisage des composants :

- **Balisage sémantique obligatoire :** Employer systématiquement `<button type="button">` ou `<button type="submit">` pour les boutons. L'usage de balises `<div>` ou `<span>` transformées en faux boutons par du JavaScript est formellement interdit.
- **Rôles et attributs ARIA indispensables :**
  - Bouton déroulant : `aria-haspopup="true" aria-expanded="false"`.
  - Onglets : `role="tablist"`, `role="tab"`, `aria-selected="true/false"`, `role="tabpanel"`.
  - Modale : `role="dialog" aria-modal="true" aria-labelledby="modal-title-id"`.
- **Gestion du focus au clavier :**
  - Lorsqu'une modale s'ouvre, le focus est immédiatement piégé à l'intérieur (*Focus Trap*). À la fermeture de la modale par la touche `Échap`, le focus est restitué au bouton déclencheur initial.

---

## 8. Gouvernance du catalogue de composants

Afin d'éviter la prolifération désordonnée de variantes orphelines dans le projet :
1. **Règle de réutilisation d'abord :** Tout nouveau besoin d'interface doit chercher en priorité à être résolu avec le catalogue existant.
2. **Création d'un nouveau composant :** Autorisée uniquement si le besoin métier se reproduit dans au moins trois cas d'usage distincts.
3. **Validation formelle :** Tout ajout de composant au catalogue nécessite une documentation de son anatomie, de ses variantes, de ses états et son approbation par le Product Designer référent.

---

## 9. Checklist qualité composant

| # | Point de vérification du composant | Spécification attendue | Statut |
|---|---|---|---|
| **01** | Balise HTML5 sémantique | Utilisation des balises natives standards (`button`, `input`, etc.) | [ ] |
| **02** | Contraste de couleur | Ratio minimal de 4.5:1 sur les textes et 3:1 sur les bordures actives | [ ] |
| **03** | Tous les états documentés | Normal, survol, focus, actif, désactivé, erreur, chargement décrits | [ ] |
| **04** | Support du clavier | Utilisable intégralement avec Tab, Espace, Entrée et Échap | [ ] |
| **05** | Focus visible distinct | Anneau de mise au point net et visible sans souris | [ ] |
| **06** | Cible tactile minimale | Hauteur $\ge$ 44px sur mobile ou zone de clic augmentée | [ ] |
| **07** | Indépendance visuelle | Ne véhicule pas d'information critique uniquement par la couleur | [ ] |

---

> **Validation du livrable :** Document établi conformément aux exigences de la Phase 05 du framework MARVENS CREATIVE BRIEF V1.0. Prêt pour exploitation transversale.
