# UI GUIDELINES — Principes Généraux de Conception UI
## MARVENS CREATIVE BRIEF V1.0 · PHASE 05_UI_DESIGN

> **Document :** Référentiel des standards et règles générales de conception d'interface utilisateur  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents amont :** [FRAMEWORK_OVERVIEW.md](../00_FRAMEWORK_CORE/FRAMEWORK_OVERVIEW.md) · [DESIGN_PHILOSOPHY.md](../00_FRAMEWORK_CORE/DESIGN_PHILOSOPHY.md) · [COLOR_SYSTEM.md](../03_BRAND_AND_VISUAL_IDENTITY/COLOR_SYSTEM.md) · [TYPOGRAPHY_SYSTEM.md](../03_BRAND_AND_VISUAL_IDENTITY/TYPOGRAPHY_SYSTEM.md) · [UX_PRINCIPLES.md](../04_UX_DESIGN/UX_PRINCIPLES.md) · [ACCESSIBILITY.md](../04_UX_DESIGN/ACCESSIBILITY.md)  
> **Documents pairs :** [LAYOUT_SYSTEM.md](LAYOUT_SYSTEM.md) · [RESPONSIVE_DESIGN.md](RESPONSIVE_DESIGN.md) · [COMPONENT_DESIGN.md](COMPONENT_DESIGN.md) · [FORMS_AND_TABLES.md](FORMS_AND_TABLES.md) · [DASHBOARD_DESIGN.md](DASHBOARD_DESIGN.md)

---

## Sommaire

1. [Introduction et périmètre opérationnel](#1-introduction-et-périmètre-opérationnel)
2. [Articulation des trois niveaux du framework](#2-articulation-des-trois-niveaux-du-framework)
3. [Principes fondamentaux de l'interface](#3-principes-fondamentaux-de-linterface)
4. [Hiérarchie visuelle et rythme cognitif](#4-hiérarchie-visuelle-et-rythme-cognitif)
5. [Structure canonique d'un écran](#5-structure-canonique-dun-écran)
6. [Navigation et repères spatiaux](#6-navigation-et-repères-spatiaux)
7. [Règles de contenu et microcopie d'interface](#7-règles-de-contenu-et-microcopie-dinterface)
8. [Matrice universelle des états d'interface](#8-matrice-universelle-des-états-dinterface)
9. [Rétroaction visuelle et boucle d'interaction](#9-rétroaction-visuelle-et-boucle-dinteraction)
10. [Accessibilité numérique intégrée (WCAG 2.1 AA)](#10-accessibilité-numérique-intégrée-wcag-21-aa)
11. [Cohérence visuelle et application des tokens de marque](#11-cohérence-visuelle-et-application-des-tokens-de-marque)
12. [Anti-patterns et écueils formellement proscrits](#12-anti-patterns-et-écueils-formellement-proscrits)
13. [Checklist d'évaluation et de validation UI](#13-checklist-dévaluation-et-de-validation-ui)

---

## 1. Introduction et périmètre opérationnel

### 1.1 Objectif du guide
Le présent document formalise les normes de conception des interfaces utilisateur (UI) pour l'ensemble des produits de l'écosystème Marvens Group. L'interface utilisateur n'est pas un vernis cosmétique apposé en fin de chaîne ; elle constitue l'incarnation visuelle, sensible et interactive de la stratégie produit, de l'identité de marque et de l'architecture d'expérience utilisateur (UX).

Ce guide a pour vocation de :
- Convertir les fondements UX (`04_UX_DESIGN`) et l'identité de marque (`03_BRAND_AND_VISUAL_IDENTITY`) en spécifications d'ingénierie visuelle exécutables.
- Fournir aux designers d'interface, aux agents IA et aux développeurs frontend un langage commun évitant les interprétations subjectives.
- Garantir le standard **Contextual Design · Premium Quality** : des interfaces épurées, hautement crédibles, performantes et immédiatement lisibles, adaptées aux réalités terrain (connexion fluctuante, terminaux hétérogènes, luminosité tropicale).

### 1.2 Périmètre et relations transversales
```
┌─────────────────────────────────────────────────────────────────────────────┐
│                      FLUX DE DÉPENDANCE DOCUMENTAIRE                        │
├─────────────────────────────────────────────────────────────────────────────┤
│ 01_PRODUCT_DISCOVERY            Contexte métier, contraintes économiques    │
│       │                         et profils d'usagers réels                  │
│       ▼                                                                     │
│ 03_BRAND_AND_VISUAL_IDENTITY    Tokens de marque, couleurs sémantiques,     │
│       │                         typographies, iconographie et rayon de courbure
│       ▼                                                                     │
│ 04_UX_DESIGN                    Flux de tâches, architecture de l'info,    │
│       │                         zones de friction, navigation et parcours   │
│       ▼                                                                     │
│ 05_UI_DESIGN (Ce document)      RÈGLES D'INGÉNIERIE VISUELLE, COMPOSITION,  │
│       │                         ÉTATS SYSTÈMES ET FEEDBACKS OPÉRATIONNELS   │
│       ▼                                                                     │
│ 06_PROTOTYPING & CODE           Implémentation CSS3 / HTML5 / JS Vanilla /  │
│                                 Bootstrap 5 / PHP 8.3 MVC strict            │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Articulation des trois niveaux du framework

Pour préserver la pérennité du framework tout en garantissant une totale adaptabilité contextuelle, les règles sont scindées en trois niveaux stricts :

- **Niveau A — Principes permanents du Framework :**  
  Règles universelles et immuables appliquées à tout projet Marvens : lisibilité absolue, contraste minimum WCAG AA (4.5:1), absence de piège au clavier, rétroaction systématique aux actions utilisateur, sobriété graphique, résilience face aux états d'erreur.
- **Niveau B — Méthodes et règles de composition :**  
  Arbres de décision, grilles de hiérarchie visuelle, heuristiques de groupement selon la loi de proximité, matrice standardisée des huit états d'interface, conventions d'espacement modulaire.
- **Niveau C — Paramètres spécifiques au produit :**  
  Valeurs numériques et variables concrètes adaptées au produit (gamme exacte de polices, breakpoints choisis, tokens HEX/CSS, niveaux de padding, densité de données). Pour la suite de gestion B2B Marvens, ces éléments sont identifiés avec la mention `[SPÉCIFIQUE PRODUIT - B2B MARVENS]` ou signalés `[À DÉFINIR]` lorsqu'un arbitrage humain reste requis.

---

## 3. Principes fondamentaux de l'interface

Toute interface conçue sous le framework MARVENS CREATIVE BRIEF V1.0 doit satisfaire dix principes cardinaux :

1. **Clarté optique (*Visual Clarity*) :** Chaque élément d'interface doit avoir une fonction évidente. Les éléments décoratifs superflus sans rôle d'orientation ou de compréhension sont formellement bannis.
2. **Hiérarchie sans ambiguïté :** La structure visuelle guide le regard du contenu le plus critique vers les détails secondaires de façon fluide et naturelle.
3. **Cohérence systémique :** Un comportement ou un symbole visuel similaire doit produire le même résultat à travers l'ensemble des modules d'une application.
4. **Prévisibilité :** L'utilisateur doit pouvoir anticiper le résultat d'une interaction avant même de cliquer ou de toucher un contrôle.
5. **Rétroaction immédiate (*Immediate Feedback*) :** Chaque action de l'utilisateur (clic, saisie, glissement) déclenche une réponse visuelle en moins de 100 ms.
6. **Simplicité fonctionnelle :** Privilégier les patterns d'interface standards du web plutôt que des innovations gestuelles ou visuelles déroutantes.
7. **Efficacité opératoire :** Réduire les étapes, les clics et les mouvements d'yeux nécessaires pour exécuter les tâches métiers récurrentes.
8. **Accessibilité universelle :** La conformité WCAG 2.1 niveau AA est un prérequis non négociable dès le premier jet de conception.
9. **Confiance et robustesse :** L'interface doit projeter l'autorité, la sécurité et la sérénité requises pour la gestion financière et administrative.
10. **Contextualisation matérielle et réseau :** Conception allégée, lisible sous forte lumière ambiante, fonctionnelle sur écrans modestes et résiliente aux lenteurs de connexion.

---

## 4. Hiérarchie visuelle et rythme cognitif

### 4.1 Poids typographique et niveaux de lecture
La hiérarchie typographique s'appuie sur le système de jetons défini dans `03_BRAND_AND_VISUAL_IDENTITY/TYPOGRAPHY_SYSTEM.md`. Trois niveaux de lecture simultanés au maximum sont autorisés par zone d'attention visuelle :

| Niveau | Rôle fonctionnel | Spécification type (Desktop) | Usage exclusif |
|---|---|---|---|
| **Niveau 1 (Dominant)** | Titre de page / Montant clé | Font Display/Primary Bold, 24px - 32px | Objet central de la page ou valeur pivot |
| **Niveau 2 (Secondaire)** | Titres de cartes / En-têtes de tableau | Font Primary Semi-Bold, 16px - 18px | Découpage des zones de travail et sous-sections |
| **Niveau 3 (Courant)** | Libellés, valeurs, métadonnées | Font Primary Regular/Medium, 14px - 15px | Données opérationnelles, descriptions |
| **Niveau 4 (Micro)** | Notes de bas de champ, horodatage | Font Primary Regular, 12px (min. légal) | Contextualisation secondaire, aide discrète |

### 4.2 Lois de proximité et regroupement (Gestalt)
- **Règle de proximité :** L'espace séparant deux éléments sémantiquement liés (ex. un label et son champ de saisie) doit représenter au maximum le tiers de l'espace séparant ce groupe du groupe suivant.
- **Règle de clôture :** Privilégier le regroupement par le vide (*whitespace*) plutôt que par la multiplication de bordures lourdes et d'encadrements superposés.
- **Rythme vertical régulier :** Les espacements verticaux doivent systématiquement respecter un pas modulaire multiple de 4px ou 8px (ex. 8px, 16px, 24px, 32px, 48px).

### 4.3 Priorité des actions (Actions primaires, secondaires, tertiaires)
Chaque écran ou vue de détail ne doit comporter qu'**une seule action primaire dominante** par contexte visuel :
- **Action Primaire (Solid High-Contrast) :** L'objectif cardinal de l'écran (ex. `Encaisser la facture`, `Créer l'utilisateur`). Bouton plein utilisant le token de marque primaire.
- **Action Secondaire (Outline / Ghost tonique) :** Actions alternatives courantes (ex. `Exporter en PDF`, `Filtrer`). Bouton contour avec texte contrasté.
- **Action Tertiaire (Text Link) :** Actions neutres ou de contournement (ex. `Annuler`, `En savoir plus`).
- **Action Destructrice (Danger Solid / Ghost) :** Réservée aux opérations irréversibles (ex. `Supprimer définitivement`). Utilise le token `danger` et requiert une confirmation contextuelle.

---

## 5. Structure canonique d'un écran

Pour toute application de l'écosystème Marvens (Web App de gestion, portail SaaS, interface d'administration), la disposition canonique comprend cinq zones fonctionnelles :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. BARRE SUPÉRIEURE (Top Bar / Header) : Marque, Recherche, Rôle, Profil    │
├──────────────┬──────────────────────────────────────────────────────────────┤
│ 2. PANNEAU   │ 3. EN-TÊTE DE VUE (Page Header) : Titre, Ariane, Actions CTAs│
│    LATÉRAL   ├──────────────────────────────────────────────────────────────┤
│ (Sidebar /   │ 4. ZONE PRINCIPALE DE TRAVAIL (Main Workspace)               │
│  Navigation  │    - Synthèse ou KPIs                                        │
│  Principale) │    - Filtres et Tableaux de données                          │
│              │    - Formulaires métier                                      │
│              ├──────────────────────────────────────────────────────────────┤
│              │ 5. BARRE D'ÉTAT OU ACTIONS FIXES (Sticky Bottom si pertinent)│
└──────────────┴──────────────────────────────────────────────────────────────┘
```

### 5.1 Rôles des cinq zones
1. **Header applicatif global (Hauteur fixe : 56px à 64px) :** Présence de la marque/produit, champ de recherche globale rapide, commutateur de contexte/succursale, notifications système et avatar utilisateur avec rôle explicite.
2. **Navigation principale (Sidebar fixe ou rétractable : 240px à 280px sur desktop) :** Hiérarchie par modules fonctionnels clairement ordonnée. Sur mobile, se rétracte en menu tiroir (*drawer* accessible par touch/swipe).
3. **En-tête de vue contextuelle (Page Header) :** Fil d'Ariane (*breadcrumb*) orientant l'utilisateur, titre explicite de l'opération en cours, et regroupement à droite des boutons d'action (CTAs).
4. **Zone de travail centrale :** Conteneur principal fluide ou à largeur contrainte accueillant les données vivantes et les interactions de saisie.
5. **Barre de commande basse (Footer d'action) :** Utilisée principalement lors de formulaires longs ou sur terminal mobile pour maintenir accessibles les actions de validation sans défilement fastidieux.

---

## 6. Navigation et repères spatiaux

L'utilisateur ne doit à aucun instant se poser la question : *"Où suis-je et comment revenir en arrière sans perdre mon travail ?"*

### 6.1 Principes d'orientation
- **Indicateur de localisation active :** L'élément de navigation correspondant à la section active doit présenter un triple marquage distinctif : changement de couleur d'arrière-plan, barre latérale accentuée (3px) et texte en graisse semi-bold.
- **Fil d'Ariane sémantique :** Obligatoire dès que la profondeur de l'arborescence dépasse deux niveaux (ex. `Ventes > Facturation > Facture #2026-0894`). Le dernier élément indique la page courante et n'est pas cliquable.
- **Titre d'onglet de navigateur dynamique :** Format strict : `[Nom de l'écran] · [Nom du Produit] · Marvens Group`.

### 6.2 Chemins de retour et d'annulation
- Chaque formulaire ou panneau modal doit proposer une voie de sortie non destructive explicite (`Annuler` ou croix de fermeture haute-droite).
- En cas de modification en cours non enregistrée, l'activation d'un lien de sortie déclenche une alerte de dialogue préventive : *"Des modifications n'ont pas été enregistrées. Souhaitez-vous quitter la page ?"*.

---

## 7. Règles de contenu et microcopie d'interface

### 7.1 Ton d'expression et clarté lexicale
- **Français professionnel, direct et respectueux :** Utiliser la forme polie standard (« vous »), bannir le jargon technique obscur et les abréviations énigmatiques.
- **Orientation action (*Action-Oriented*) :** Les libellés d'actions doivent utiliser des verbes d'action précis plutôt que des termes génériques :
  - *À proscrire :* `OK`, `Valider`, `Soumettre`, `Cliquer ici`.
  - *Recommandé :* `Enregistrer les modifications`, `Télécharger le reçu PDF`, `Confirmer le virement`.

### 7.2 Formats standardisés d'affichage (Zone CEMAC / Francophone)
- **Devises :** Le symbole ou code monétaire suit le montant avec une espace insécable : `150 000 FCFA` (ou `XAF`), jamais `FCFA 150000`.
- **Nombres :** Séparateur de milliers par espace fine ou insécable, séparateur décimal par une virgule : `1 250,50`.
- **Dates :** Format légal standard `JJ/MM/AAAA` (ex. `31/10/2026`). Pour les historiques lisibles, privilégier la date narrative : `31 oct. 2026 à 14:32`.
- **Numéros de téléphone (Format local Cameroun / CEMAC) :** Affichage groupé facilitant la numérotation : `+237 6XX XX XX XX` ou `6XX XX XX XX`.

---

## 8. Matrice universelle des états d'interface

Aucun composant ni écran ne peut être considéré comme prêt pour le développement s'il ne documente pas rigoureusement ses huit états canoniques :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     LES 8 ÉTATS D'INTERFACE CANONIQUES                      │
├─────────────────┬───────────────────────────────────────────────────────────┤
│ 1. INITIAL      │ Vue par défaut prête à l'interaction, données chargées.   │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 2. LOADING      │ Squelettes (skeletons) ou indicateurs de progression.     │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 3. SUCCESS      │ Confirmation visuelle explicite avec persistance adéquate.│
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 4. EMPTY        │ Zéro donnée : message explicatif et bouton d'action CTA.  │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 5. ERROR        │ Erreur explicite, localisée, avec solution de résolution. │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 6. DISABLED     │ Désactivation justifiée avec infobulle expliquant pourquoi│
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 7. OFFLINE      │ Connexion perdue : bannière d'alerte et sauvegarde locale.│
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 8. PERMISSION   │ Accès refusé (403) : explicitation du rôle manquant.      │
└─────────────────┴───────────────────────────────────────────────────────────┘
```

### Spécifications détaillées des états critiques
- **État Empty (Vide) :** Ne jamais laisser une zone blanche sans explication. Présenter une illustration sobre de la suite d'icônes, un titre direct (`Aucun client enregistré pour l'instant`), un texte court expliquant le bénéfice et un CTA primaire (`+ Ajouter un premier client`).
- **État Loading (Chargement) :** Pour les chargements structurés (tableaux, fiches), employer des *skeletons* reproduisant la silhouette du contenu attendu plutôt que des spinners isolés au centre de l'écran.
- **État Offline (Déconnecté / Dégradé) :** Une pastille jaune/orange s'affiche dans le header signalant le fonctionnement sur cache local, avec neutralisation gracieuse des actions dépendantes du réseau temps réel.

---

## 9. Rétroaction visuelle et boucle d'interaction

### 9.1 Temps de réponse et perception
- **< 100 ms :** Réponse visuelle instantanée (enfoncement du bouton, focus visuel).
- **100 ms à 1 000 ms :** Affichage d'un micro-indicateur de chargement intégré au bouton d'action cliqué pour empêcher le double-clic involontaire.
- **> 1 000 ms :** Affichage d'une barre de progression ou d'un écran squelette complet.

### 9.2 Notifications toast et alertes contextuelles
- **Toasts de succès :** Apparaissent en haut à droite (ou bas centré sur mobile), auto-disparaissent après 4 secondes, comportent une croix de fermeture manuelle.
- **Alertes bloquantes / d'erreur :** Ne disparaissent jamais automatiquement. Elles restent ancrées en haut du formulaire ou de la page jusqu'à correction par l'usager.
- **Action de réversibilité (*Undo*) :** Pour les actions fréquentes mais non critiques (ex. archiver un message), privilégier un toast avec bouton `Annuler` temporisé à 6 secondes plutôt qu'une boîte de dialogue modale intrusive.

---

## 10. Accessibilité numérique intégrée (WCAG 2.1 AA)

La conformité légale et éthique s'articule autour des exigences suivantes :

1. **Ratios de contraste colorimétrique stricts :**
   - Texte normal (< 18pt ou < 14pt gras) : contraste minimum de **4.5:1** contre son fond.
   - Grand texte ($\ge$ 18pt ou $\ge$ 14pt gras) et composants UI interactifs : contraste minimum de **3.0:1**.
2. **Indépendance visuelle de la couleur :**
   - Une information d'état ne doit jamais reposer uniquement sur la teinte. Un message d'erreur rouge doit obligatoirement être accompagné d'une icône explicite (`warning`/`alert`) et d'un texte clair.
3. **Navigation intégrale au clavier et focus visible :**
   - L'indicateur de focus clavier ne doit jamais être supprimé (`outline: none` interdit sans alternative). Utiliser un anneau de focus contrasté (`2px solid` ou `ring 3px`) nettement visible.
   - Ordre de tabulation logique suivant le flux visuel naturel de gauche à droite et de haut en bas.
4. **Dimensions tactiles minimales :**
   - Toute surface interactive sur écran tactile doit mesurer au minimum **44 × 44 pixels** réels avec une marge de dégagement d'au moins 8px entre cibles contiguës.
5. **Respect des préférences utilisateur :**
   - Prise en charge de la directive CSS `@media (prefers-reduced-motion: reduce)` : désactivation des transitions superflues pour les utilisateurs sensibles au mal des transports visuel.

---

## 11. Cohérence visuelle et application des tokens de marque

Les règles d'interface doivent rigoureusement appliquer les tokens arrêtés dans `03_BRAND_AND_VISUAL_IDENTITY/` :

```css
/* Tokens fondamentaux de référence UI */
:root {
  /* Rayons de courbure (Border Radius) */
  --radius-sm: 4px;   /* Badges, tags, cases à cocher */
  --radius-md: 6px;   /* Boutons, champs de saisie, selects */
  --radius-lg: 10px;  /* Cartes, modales, conteneurs de section */
  --radius-full: 9999px; /* Avatars ronds, pilules d'état */

  /* Ombres et élévations fonctionnelles */
  --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.05);
  --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08), 0 1px 2px rgba(15, 23, 42, 0.04);
  --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.1), 0 2px 4px -2px rgba(15, 23, 42, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(15, 23, 42, 0.1), 0 4px 6px -4px rgba(15, 23, 42, 0.05);

  /* Épaisseurs de bordure */
  --border-width-default: 1px;
  --border-width-focus: 2px;
}
```

---

## 12. Anti-patterns et écueils formellement proscrits

Les pratiques ci-dessous constituent des violations méthodologiques :

- ❌ **Suppression du focus visible (`outline: 0`) :** Rend l'application inexploitable pour les usagers naviguant au clavier.
- ❌ **Multiplication anarchique des boutons primaires :** Afficher 3 ou 4 boutons colorés de même poids sur un même écran crée une surcharge cognitive paralysante.
- ❌ **Placeholders utilisés en guise de labels :** Les indications disparaissent dès la saisie, désorientant l'usager et provoquant des erreurs.
- ❌ **Modales en cascade :** Ouvrir une modale par-dessus une modale existante est formellement interdit. Utiliser des vues dédiées ou des tiroirs latéraux.
- ❌ **Textes tronqués arbitrairement sans infobulle :** Couper des données comptables ou des identifiants critiques sans moyen d'accès à la chaîne complète.
- ❌ **Effets cosmétiques nuisibles :** Ombres démesurées (*skeuomorphisme sale*), flous d'arrière-plan (*glassmorphism*) abusifs altérant la lisibilité sur écrans modestes.

---

## 13. Checklist d'évaluation et de validation UI

Avant de soumettre une maquette ou un composant à la validation, l'auditeur ou l'agent IA doit vérifier chaque critère :

| # | Critère de contrôle | Règle vérifiée | Statut (V / X) |
|---|---|---|---|
| **01** | Hiérarchie | Une seule action primaire dominante visible par vue | [ ] |
| **02** | Contraste | Ratios $\ge 4.5:1$ (texte) et $\ge 3.0:1$ (UI) validés sur maquette | [ ] |
| **03** | Focus clavier | État focus distinct et visible sans souris | [ ] |
| **04** | Cibles tactiles | Taille minimum de 44x44px pour toute zone cliquable sur mobile | [ ] |
| **05** | États systèmes | Présence formalisée des états : normal, hover, loading, error, empty | [ ] |
| **06** | Clarté microcopy | Verbes d'action explicites, aucun terme ambigu type "OK" | [ ] |
| **07** | Règles de monnaie | Montants formatés avec espace fine et symbole FCFA/XAF à droite | [ ] |
| **08** | Résilience réseau | Comportement documenté en cas de coupure de connexion | [ ] |
| **09** | Cohérence tokens | Utilisation stricte des variables de rayon, ombre et couleur officielles | [ ] |
| **10** | Simplicité visuelle | Absence de décorations superflues dégradant la rapidité de lecture | [ ] |

---

> **Validation du livrable :** Document établi conformément aux exigences de la Phase 05 du framework MARVENS CREATIVE BRIEF V1.0. Prêt pour exploitation transversale.
