# LAYOUT SYSTEM — Système de Mise en Page, Grilles et Espacements
## MARVENS CREATIVE BRIEF V1.0 · PHASE 05_UI_DESIGN

> **Document :** Spécification technique et spatiale des conteneurs, grilles, densités et alignements  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [UI_GUIDELINES.md](UI_GUIDELINES.md) · [RESPONSIVE_DESIGN.md](RESPONSIVE_DESIGN.md) · [TYPOGRAPHY_SYSTEM.md](../03_BRAND_AND_VISUAL_IDENTITY/TYPOGRAPHY_SYSTEM.md) · [INFORMATION_ARCHITECTURE.md](../04_UX_DESIGN/INFORMATION_ARCHITECTURE.md)

---

## Sommaire

1. [Rôle et principes directeurs du système de layout](#1-rôle-et-principes-directeurs-du-système-de-layout)
2. [Échelle modulaire d'espacement (Base 4px / 8px)](#2-échelle-modulaire-despacement-base-4px--8px)
3. [Système universel de grille modulaire (12 colonnes)](#3-système-universel-de-grille-modulaire-12-colonnes)
4. [Largeurs des conteneurs et limites de lecture](#4-largeurs-des-conteneurs-et-limites-de-lecture)
5. [Archétypes d'agencement de page (Layout Patterns)](#5-archétypes-dagencement-de-page-layout-patterns)
6. [Gestion contextualisée de la densité de données](#6-gestion-contextualisée-de-la-densité-de-données)
7. [Alignements, rythme vertical et repères d'élévation spatiale](#7-alignements-rythme-vertical-et-repères-délévation-spatiale)
8. [Règles de positionnement et calques de superposition (Z-Index)](#8-règles-de-positionnement-et-calques-de-superposition-z-index)
9. [Composition des cartes, conteneurs et sections](#9-composition-des-cartes-conteneurs-et-sections)
10. [Tokens d'espacement et compatibilité Bootstrap 5 / CSS Vanilla](#10-tokens-despacement-et-compatibilité-bootstrap-5--css-vanilla)
11. [Gabarits visuels et layouts types (ASCII Diagrams)](#11-gabarits-visuels-et-layouts-types-ascii-diagrams)
12. [Checklist de conformité layout](#12-checklist-de-conformité-layout)

---

## 1. Rôle et principes directeurs du système de layout

Le système de layout organise l'espace visuel d'une manière rationnelle, géométrique et prévisible. Dans l'esprit **Contextual Design · Premium Quality**, le layout ne cherche pas à remplir chaque interstice libre ; il structure les flux d'attention, fluidifie le repérage visuel et prévient la fatigue cognitive des opérateurs de gestion lors de longues sessions de travail.

### Principes directeurs :
- **Régularité mathématique :** Tout espacement interne (padding) ou externe (margin) découle d'un multiple strict de 4px ou 8px.
- **Respiration visuelle proportionnée :** L'espace vide (*whitespace*) est un composant de design à part entière, servant à détacher les blocs de données critiques.
- **Adaptabilité fluide :** Le layout absorbe les variations de résolution de manière ordonnée sans rupture brutale du champ visuel.
- **Réalisabilité technique :** Conçu pour s'aligner naturellement avec les mécanismes de grille standards (Bootstrap 5 Grid / Flexbox / CSS Grid Vanilla) et l'architecture PHP Vanilla MVC hébergée sur cPanel.

---

## 2. Échelle modulaire d'espacement (Base 4px / 8px)

Le système de dimensionnement utilise l'unité de base `8px` pour les espacements structurels, combinée à un pas fin de `4px` pour les micro-ajustements au sein des composants interactifs :

| Token CSS | Valeur en pixels | Valeur en rem | Usage recommandé |
|---|---|---|---|
| `--space-1` (3xs) | 2px | 0.125rem | Micro-bordures, décalages optiques fins |
| `--space-2` (2xs) | 4px | 0.25rem | Espacement icône-texte, padding interne de tag |
| `--space-3` (xs) | 8px | 0.5rem | Écartement entre champs contigus, padding de badge |
| `--space-4` (sm) | 12px | 0.75rem | Espacement interne de bouton standard, padding dense |
| `--space-5` (md) | 16px | 1.0rem | **Unité de référence courante** : gouttières, padding de carte |
| `--space-6` (lg) | 24px | 1.5rem | Marge entre cartes, séparation de sous-sections |
| `--space-7` (xl) | 32px | 2.0rem | Séparation de grands blocs métier, marge d'en-tête |
| `--space-8` (2xl)| 48px | 3.0rem | Espacement entre sections de page, marges de fin de document |
| `--space-9` (3xl)| 64px | 4.0rem | Dégagement des pages d'accueil, respiration des grands héros |

---

## 3. Système universel de grille modulaire (12 colonnes)

Le système de mise en page adopte une grille classique à 12 colonnes, offrant une divisibilité parfaite par 2, 3, 4 et 6 :

```
┌────┬────┬────┬────┬────┬────┬────┬────┬────┬────┬────┬────┐
│ 1  │ 2  │ 3  │ 4  │ 5  │ 6  │ 7  │ 8  │ 9  │ 10 │ 11 │ 12 │
└────┴────┴────┴────┴────┴────┴────┴────┴────┴────┴────┴────┘
│◄─── Gouttière (Gutter) ───►│◄────────── Colonne ──────────►│
```

### Spécifications de la grille par contexte d'affichage

| Contexte / Périphérique | Largeur typique | Nb Colonnes | Gouttière (Gutter) | Marge extérieure latérale |
|---|---|---|---|---|
| **Mobile compact** | 320px - 479px | 4 colonnes | 12px | 16px |
| **Mobile standard** | 480px - 767px | 4 ou 6 colonnes | 16px | 16px |
| **Tablette portrait** | 768px - 991px | 8 colonnes | 20px | 24px |
| **Desktop standard** | 992px - 1199px | 12 colonnes | 24px | 32px |
| **Grand Desktop** | $\ge$ 1200px | 12 colonnes | 24px ou 32px | Fluide ou centrée (max-width) |

---

## 4. Largeurs des conteneurs et limites de lecture

Afin de préserver le confort visuel et d'éviter les lignes de lecture trop étirées (qui augmentent le taux de fatigue oculaire), les conteneurs sont strictement calibrés :

```css
/* Limites et largeurs de conteneur */
:root {
  --container-sm: 640px;    /* Tunnels de commande, formulaires d'authentification */
  --container-md: 768px;    /* Pages d'articles, documentation, profil restreint */
  --container-lg: 1024px;   /* Vues de gestion d'équipe, paramètres système */
  --container-xl: 1280px;   /* Dashboards généraux, tableaux de bord de gestion */
  --container-fluid: 100%;  /* Tableaux denses étendus, éditeurs plein écran */

  /* Longueur optimale de lecture de texte */
  --content-reading-width: 65ch; /* 60 à 75 caractères maximum par ligne */
}
```

---

## 5. Archétypes d'agencement de page (Layout Patterns)

Quatre gabarits structurels majeurs couvrent 95 % des besoins de l'écosystème Marvens :

### 5.1 Pattern A : Application de gestion avec panneau latéral (Sidebar App Layout)
- **Cas d'usage :** ERP, POS d'encaissement, CRM, modules comptables et RH.
- **Structure :** Sidebar fixe à gauche (largeur fixe : 260px) + Header fixe haut (hauteur : 60px) + Zone centrale défilante (`overflow-y: auto`).
- **Comportement compact :** La sidebar s'efface complètement sous un menu hamburger pour laisser 100 % de l'écran à la zone opérationnelle.

### 5.2 Pattern B : Conteneur centré focalisé (Focused Form Layout)
- **Cas d'usage :** Connexion, réinitialisation de mot de passe, tunnel de paiement Mobile Money, assistants d'onboarding par étapes (*wizards*).
- **Structure :** Conteneur unique centré horizontalement et verticalement, largeur limitée à `--container-sm` (max 640px), fond neutre contrasté favorisant la concentration exclusive sur la tâche.

### 5.3 Pattern C : Tableau de bord multi-cartes (Bento / Dashboard Grid)
- **Cas d'usage :** Écrans de contrôle des ventes, synthèses financières, reporting d'inventaire.
- **Structure :** Grille CSS / Flexbox de cartes métriques et graphiques à colonnage variable (1 col sur mobile, 2 sur tablette, 4 sur desktop pour les indicateurs clés ; 8/4 ou 6/6 pour les panneaux de détail).

### 5.4 Pattern D : Vue Maître-Détail (Split-View / Master-Detail)
- **Cas d'usage :** Boîte de messagerie, historique des transactions, sélection de clients et prévisualisation de devis.
- **Structure :** Deux panneaux juxtaposés. Panneau gauche (liste filtrable, 35 % de la largeur ou 380px fixe) + Panneau droit (vue de détail active, 65 % de la largeur restante).

---

## 6. Gestion contextualisée de la densité de données

Le framework s'adapte à la nature de la tâche :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          NIVEAUX DE DENSITÉ D'INTERFACE                     │
├─────────────────┬───────────┬──────────────┬────────────────────────────────┤
│ NIVEAU          │ PADDING   │ HAUTEUR LIGNE│ CAS D'USAGE RECOMMANDÉ         │
├─────────────────┼───────────┼──────────────┼────────────────────────────────┤
│ 1. Confortable  │ 16px-24px │ 48px - 56px  │ Espaces publics, onboarding,   │
│    (Spacious)   │           │              │ écrans mobiles tactiles POS    │
├─────────────────┼───────────┼──────────────┼────────────────────────────────┤
│ 2. Standard     │ 12px-16px │ 40px - 44px  │ Dashboards SaaS, formulaires   │
│    (Default)    │           │              │ de création standard           │
├─────────────────┼───────────┼──────────────┼────────────────────────────────┤
│ 3. Compact      │ 6px-10px  │ 32px - 36px  │ Tableaux denses de comptabilité│
│    (Dense)      │           │              │ inventaires, audit de logs     │
└─────────────────┴───────────┴──────────────┴────────────────────────────────┘
```

> **Règle d'or :** Ne jamais imposer la densité compacte sur des écrans tactiles mobiles purs où la cible de contact doigt nécessite impérativement une hauteur minimale de 44px.

---

## 7. Alignements, rythme vertical et repères d'élévation spatiale

### 7.1 Règles d'alignement absolues
- **Alignement à gauche systématique :** Tous les textes en langue française et tous les contrôles de formulaire sont alignés sur le fer gauche. L'alignement centré est strictement banni pour les longs paragraphes ou les formulaires de gestion.
- **Alignement des données chiffrées :** Les colonnes de montants monétaires, de pourcentages et de quantités numériques sont **systématiquement alignées à droite**, facilitant la comparaison visuelle des ordres de grandeur.

### 7.2 Élévations et ombres hiérarchiques
Le relief visuel permet de distinguer la priorité des couches d'interaction :

```
Niveau 0 (Fond de page)      : Plat, couleur neutre d'arrière-plan (#F8FAFC)
       │
Niveau 1 (Cartes de contenu) : Fond blanc (#FFFFFF), bordure 1px subtile, ombre --shadow-xs
       │
Niveau 2 (Survol / Dropdown) : Élévation légère, ombre --shadow-md
       │
Niveau 3 (Tiroirs latéraux)  : Élévation marquée, ombre --shadow-lg, masque d'arrière-plan
       │
Niveau 4 (Modales & Toasts)  : Priorité visuelle maximale, ombre --shadow-xl, z-index élevé
```

---

## 8. Règles de positionnement et calques de superposition (Z-Index)

Afin d'éliminer les conflits de superposition CSS (*z-index wars*), l'échelle d'empilement suivante est rigoureusement standardisée :

```css
:root {
  --z-base: 0;           /* Flux de document standard */
  --z-raised: 10;        /* Éléments surélevés au survol */
  --z-sticky: 100;       /* En-têtes de tableau collants, barres d'action fixes */
  --z-header: 500;       /* Barre de navigation supérieure globale */
  --z-backdrop: 1000;    /* Masque sombre semi-transparent d'arrière-plan */
  --z-drawer: 1050;      /* Panneaux latéraux rétractables */
  --z-modal: 1100;       /* Boîtes de dialogue modales */
  --z-popover: 1200;     /* Menus contextuels déroulants, sélecteurs de date */
  --z-tooltip: 1300;     /* Infobulles au survol */
  --z-toast: 1400;       /* Notifications toast prioritaires */
}
```

---

## 9. Composition des cartes, conteneurs et sections

Chaque carte d'interface (*Card component*) respecte une structure tripartite harmonisée :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ CARTE STANDARD                                                              │
├─────────────────────────────────────────────────────────────────────────────┤
│ EN-TÊTE (Card Header) [Padding: 16px 20px - Border-bottom: 1px subtile]    │
│ [Icône] Titre de la section                   [Action contextuelle / Badge] │
├─────────────────────────────────────────────────────────────────────────────┤
│ CORPS (Card Body) [Padding: 20px]                                           │
│                                                                             │
│ Contenu principal, formulaire, tableau imbriqué ou série de données.       │
│                                                                             │
├─────────────────────────────────────────────────────────────────────────────┤
│ PIED (Card Footer) [Padding: 12px 20px - Border-top: 1px subtile]          │
│ Métadonnées informatives                      [Boutons d'action secondaires]│
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 10. Tokens d'espacement et compatibilité Bootstrap 5 / CSS Vanilla

Dans le cadre technique validé (PHP 8.3 Vanilla MVC avec Bootstrap 5), le mapping des utilitaires de layout garantit une conformité parfaite sans surcharger le DOM :

| Token Spacing Marvens | Classe utilitaire Bootstrap 5 | CSS Vanilla équivalent |
|---|---|---|
| `--space-2` (4px) | `p-1`, `m-1`, `gap-1` | `padding: 0.25rem;` |
| `--space-3` (8px) | `p-2`, `m-2`, `gap-2` | `padding: 0.5rem;` |
| `--space-5` (16px) | `p-3`, `m-3`, `gap-3` | `padding: 1.0rem;` |
| `--space-6` (24px) | `p-4`, `m-4`, `gap-4` | `padding: 1.5rem;` |
| `--space-8` (48px) | `p-5`, `m-5`, `gap-5` | `padding: 3.0rem;` |

---

## 11. Gabarits visuels et layouts types (ASCII Diagrams)

### Disposition Écran Gestion Complète (Desktop 12 Colonnes)

```
+-----------------------------------------------------------------------------+
| TOPBAR (60px) : Logo Marvens | Recherche rapide | Notifications | Profil    |
+--------------------+--------------------------------------------------------+
| SIDEBAR (260px)    | PAGE HEADER (70px)                                     |
| - Tableau de bord  | Ariane : Ventes > Factures                             |
| - Clients          | Titre : Facture #2026-0045        [Exporter] [Imprimer]|
| - Facturation      +--------------------------------------------------------+
| - Stocks           | MAIN CONTENT (Grid 12 cols, Gutter: 24px)              |
| - Rapports         | +----------------------------------+-----------------+ |
| - Paramètres       | | COL 8 : Détails de la facture    | COL 4 : Résumé  | |
|                    | | - Articles facturés              | - Total HT      | |
|                    | | - Tableau des lignes de calcul   | - TVA (19.25%)  | |
|                    | | - Historique des règlements      | - Total TTC     | |
|                    | |                                  | [Payer MoMo]    | |
|                    | +----------------------------------+-----------------+ |
+--------------------+--------------------------------------------------------+
```

---

## 12. Checklist de conformité layout

Avant validation d'une mise en page :

| # | Règle d'ingénierie spatiale | Contrôle effectué | Statut |
|---|---|---|---|
| **01** | Multiplicité modulaire | Tous les espacements appliqués sont des multiples stricts de 4 ou 8px | [ ] |
| **02** | Alignement des colonnes | Les blocs s'inscrivent rigoureusement dans la grille 12 colonnes | [ ] |
| **03** | Longueur de lecture | Les lignes de texte courant n'excèdent pas 75 caractères de large | [ ] |
| **04** | Hiérarchie d'élévation | Les calques respectent scrupuleusement la table des Z-Index | [ ] |
| **05** | Alignement numérique | Toutes les colonnes de chiffres et devises sont calées au fer droit | [ ] |
| **06** | Dégagement des cibles | Aucune zone cliquable n'est collée sans marge de respiration (>8px) | [ ] |
| **07** | Intégrité des conteneurs | Le layout ne produit aucun défilement horizontal involontaire à l'écran | [ ] |

---

> **Validation du livrable :** Document établi conformément aux exigences de la Phase 05 du framework MARVENS CREATIVE BRIEF V1.0. Prêt pour exploitation transversale.
