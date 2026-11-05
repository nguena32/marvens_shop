# DESIGN TOKENS — Architecture des Design Tokens
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `06_DESIGN_SYSTEM/DESIGN_TOKENS.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Référence méthodologique active `[PROPOSITION NORMATIVE DU FRAMEWORK]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [UI_GUIDELINES.md](../05_UI_DESIGN/UI_GUIDELINES.md) · [ART_DIRECTION_GUIDELINES.md](../02_ART_DIRECTION/ART_DIRECTION_GUIDELINES.md) · [ACCESSIBILITY.md](../04_UX_DESIGN/ACCESSIBILITY.md)

---

## 1. Introduction et Raison d'Être

### 1.1. Définition d'un Design Token
Un **Design Token** est la plus petite unité décisionnelle indivisible de conception visuelle et fonctionnelle, enregistrée sous la forme d'une variable sémantique nommée et indépendante de la plateforme d'exécution. Les tokens capturent des choix tels que des couleurs, des espacements, des graisses typographiques, des rayons ou des niveaux d'élévation.

### 1.2. Rôle dans l'Écosystème Marvens
Dans le cadre de **MARVENS CREATIVE BRIEF V1.0**, les design tokens constituent le **pont contractuel unique reliant la direction artistique, les spécifications UX/UI et le code applicatif**. Ils permettent de :
* Éliminer les valeurs brutes arbitraires en dur (*hardcoded values*) dans le CSS ou les templates.
* Garantir la cohérence systémique globale à travers l'ensemble des modules d'un produit.
* Accélérer la maintenance, le renommage ou le thématage (ex. bascule clair/sombre) sans impacter la structure HTML ou JavaScript.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       FLUX DE PROPAGATION D'UN TOKEN                        │
└─────────────────────────────────────────────────────────────────────────────┘
                                       │
                                       ▼
                     [ 1. DIRECTION ARTISTIQUE & UI ]
                     Décision visuelle & rôle sémantique
                                       │
                                       ▼
                      [ 2. CATALOGUE DES TOKENS ]
                     Spécification formelle (Niveau A/B/C)
                                       │
                                       ▼
                      [ 3. IMPLÉMENTATION CSS3 ]
                     Variables natives (:root { --mrv-... })
                                       │
                                       ▼
                     [ 4. COMPOSANTS & INTERFACES ]
                     Consommation sans valeur brute
```

---

## 2. Architecture Hiérarchique des Tokens en Trois Couches

Pour conjuguer souplesse contextuelle et rigueur systémique, Marvens structure ses tokens en trois strates distinctes :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ NIVEAU 1 : TOKENS GLOBAUX / PRIMITIFS (Primitives)                          │
│ Valeurs brutes du dictionnaire formel (ex. palette brute, échelle numérique)│
│ Exemple : --mrv-color-blue-600: #1d4ed8;  --mrv-space-4: 16px;              │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Référencé par
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ NIVEAU 2 : TOKENS SÉMANTIQUES (Alias / Contextuels)                         │
│ Intention d'usage et fonction dans l'interface                              │
│ Exemple : --mrv-color-action-primary: var(--mrv-color-blue-600);            │
│           --mrv-surface-page: var(--mrv-color-neutral-50);                  │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Consommé par
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ NIVEAU 3 : TOKENS DE COMPOSANTS (Component Tokens)                          │
│ Spécifiques à un composant et ses états d'interface                         │
│ Exemple : --mrv-button-primary-bg: var(--mrv-color-action-primary);         │
│           --mrv-button-padding-x: var(--mrv-space-4);                       │
└─────────────────────────────────────────────────────────────────────────────┘
```

> [!IMPORTANT]
> Les composants d'interface ne doivent **JAMAIS** consommer directement des tokens primitifs. Ils doivent impérativement s'adosser à des tokens sémantiques ou à des tokens de composants dédiés.

---

## 3. Catégories Couvertes par le Système de Tokens

Le système de tokens Marvens normalise onze catégories de décisions :

1. **Couleurs (*Colors*) :** Surfaces, encres (textes), bordures, accents de marque, états d'interaction et signalements sémantiques.
2. **Typographie (*Typography*) :** Familles de polices, échelles de taille, graisses (*weights*), hauteurs de ligne (*line-heights*) et interlettrage (*letter-spacing*).
3. **Espacements (*Spacing*) :** Marges intérieures (*insets/paddings*), espaces entre éléments (*stacks/inline gaps*) et gouttières.
4. **Tailles et Dimensions (*Sizing*) :** Hauteurs standards de commandes interactives (boutons, champs), conteneurs et largeurs max de lecture.
5. **Rayons de Courbure (*Border Radius*) :** Niveaux d'arrondi des composants, cartes et modales.
6. **Bordures et Filets (*Borders*) :** Épaisseurs, styles et contrastes de contours.
7. **Élévations et Ombres (*Elevation & Shadows*) :** Niveaux de profondeur et ombres portées douces.
8. **Opacités (*Opacities*) :** Niveaux de transparence pour états désactivés, voiles de fond (*backdrops*) et superpositions.
9. **Couches Spatiales (*Z-Index*) :** Hiérarchie ordonnée des plans pour prévenir les conflits d'affichage.
10. **Transitions et Durées (*Motion*) :** Durées étalonnées et courbes d'accélération pour animations fonctionnelles.
11. **Points de Rupture (*Breakpoints*) :** Seuils dimensionnels pour les adaptations responsives (mobiles, tablettes, moniteurs).

---

## 4. Convention de Nommage et Taxonomie

### 4.1. Structure du Nommage
Tous les tokens de l'écosystème Marvens respectent la syntaxe normalisée suivante en kebab-case :

`--mrv-[catégorie]-[concept]-[propriété]-[variante/état]`

* `mrv` : Préfixe de namespace réservé à Marvens pour prévenir toute collision avec des bibliothèques tierces (notamment Bootstrap 5 `--bs-*`).
* `[catégorie]` : `color`, `space`, `font`, `radius`, `shadow`, `size`, `zindex`, `motion`.
* `[concept]` : Rôle sémantique ou composant (`action`, `surface`, `text`, `border`, `button`, `input`).
* `[propriété]` : Attribut ciblé (`bg`, `fg`, `size`, `height`, `x`, `y`).
* `[variante/état]` : `primary`, `hover`, `active`, `disabled`, `sm`, `lg`, `success`, `danger`.

### 4.2. Exemples de Nommage Correct vs Incorrect

| Nommage Correct Marvens | Nommage Incorrect / Déviant | Motif du Refus |
| :--- | :--- | :--- |
| `--mrv-color-action-primary-bg` | `--mrv-blue-btn` | Lié à une couleur brute et non à son rôle |
| `--mrv-color-text-subtle` | `--mrv-grey-text-12px` | Contient une valeur codée en dur et non sémantique |
| `--mrv-space-inset-md` | `--mrv-padding-card-left` | Trop spécifique et non réutilisable |
| `--mrv-radius-interactive` | `--mrv-round-4` | Ne décrit pas à quoi sert le rayon |

---

## 5. Spécification Normative des Tokens du Framework (Niveaux A & B)

Les tableaux ci-dessous formalisent les tokens du framework. Les valeurs indiquées constituent la **recommandation de référence Marvens** et sont personnalisables selon le contexte spécifique du produit (Niveau C).

### 5.1. Tokens Sémantiques de Couleurs et Surfaces

| Token Sémantique | Rôle Fonctionnel | Valeur Illustrative de Réf. | Contraste Min. Assuré |
| :--- | :--- | :--- | :---: |
| `--mrv-color-surface-page` | Fond général de l'écran | `#F8FAFC` (Slate 50) | Base |
| `--mrv-color-surface-card` | Fond de carte et panneau | `#FFFFFF` (Blanc pur) | Base |
| `--mrv-color-surface-subtle` | Surface d'arrière-plan discret | `#F1F5F9` (Slate 100) | 1.1:1 |
| `--mrv-color-text-primary` | Texte dominant et titrage | `#0F172A` (Slate 900) | > 12:1 (WCAG AAA) |
| `--mrv-color-text-secondary` | Corps de texte et descriptions | `#334155` (Slate 700) | > 7:1 (WCAG AAA) |
| `--mrv-color-text-muted` | Métadonnées et légendes | `#64748B` (Slate 500) | > 4.5:1 (WCAG AA) |
| `--mrv-color-border-subtle` | Séparateurs et filets calmes | `#E2E8F0` (Slate 200) | 1.2:1 |
| `--mrv-color-border-strong` | Contours de champs et cartes | `#CBD5E1` (Slate 300) | > 3.0:1 (UI AA) |
| `--mrv-color-action-primary` | Action principale (CTA) | `#0284C7` (Sky 600) | > 4.5:1 vs blanc |
| `--mrv-color-action-primary-hover`| Survol action principale | `#0369A1` (Sky 700) | > 5.5:1 vs blanc |
| `--mrv-color-feedback-success` | Succès et validations | `#15803D` (Green 700) | > 4.5:1 vs blanc |
| `--mrv-color-feedback-warning` | Avertissement et vigilance | `#B45309` (Amber 700) | > 4.5:1 vs blanc |
| `--mrv-color-feedback-danger` | Erreur, danger, suppression | `#B91C1C` (Red 700) | > 4.5:1 vs blanc |

### 5.2. Tokens de Typographie

| Token Sémantique | Propriété | Valeur de Référence | Usage |
| :--- | :--- | :--- | :--- |
| `--mrv-font-family-sans` | `font-family` | `system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif` | Interface & Données |
| `--mrv-font-size-xs` | `font-size` | `0.75rem` (12px) | Badges, micro-copies |
| `--mrv-font-size-sm` | `font-size` | `0.875rem` (14px) | Données denses, tables |
| `--mrv-font-size-base` | `font-size` | `1rem` (16px) | Corps de texte courant |
| `--mrv-font-size-lg` | `font-size` | `1.125rem` (18px) | Sous-titres, intro |
| `--mrv-font-size-xl` | `font-size` | `1.25rem` (20px) | Titres de cartes |
| `--mrv-font-size-2xl` | `font-size` | `1.5rem` (24px) | Titres de sections (H2) |
| `--mrv-font-size-3xl` | `font-size` | `1.875rem` (30px) | Titre principal (H1) |
| `--mrv-font-weight-regular` | `font-weight` | `400` | Corps courant |
| `--mrv-font-weight-medium` | `font-weight` | `500` | Labels, navigation |
| `--mrv-font-weight-semibold`| `font-weight` | `600` | Titrages, actions |
| `--mrv-font-weight-bold` | `font-weight` | `700` | Valeurs clés, chiffres |
| `--mrv-line-height-tight` | `line-height` | `1.25` | Titrages denses |
| `--mrv-line-height-base` | `line-height` | `1.5` | Lecture fluide corps |

### 5.3. Tokens de Rayons de Courbure (*Border Radius*)

| Token Sémantique | Valeur en Pixels | Rôle dans l'Interface |
| :--- | :--- | :--- |
| `--mrv-radius-none` | `0px` | Angles vifs stricts (tableaux, séparateurs) |
| `--mrv-radius-sm` | `4px` | Tags, petits badges, cases à cocher |
| `--mrv-radius-md` | `6px` | Boutons, champs de saisie, sélecteurs |
| `--mrv-radius-lg` | `8px` | Cartes, conteneurs, volets modulaires |
| `--mrv-radius-xl` | `12px` | Modales, dialogues, popovers majeurs |
| `--mrv-radius-full` | `9999px` | Avatars ronds, pilules de statut |

### 5.4. Tokens d'Élévation et de Couches (*Z-Index*)

| Token Sémantique | Propriété | Valeur | Usage Typique |
| :--- | :--- | :--- | :--- |
| `--mrv-zindex-base` | `z-index` | `1` | Contenus standards du flux |
| `--mrv-zindex-sticky` | `z-index` | `100` | En-tête de tableau sticky, sous-navigation |
| `--mrv-zindex-header` | `z-index` | `500` | Barre de navigation principale fixe |
| `--mrv-zindex-dropdown` | `z-index` | `1000` | Menus déroulants, listes d'autocomplétion |
| `--mrv-zindex-drawer` | `z-index` | `1100` | Volets latéraux dépliants |
| `--mrv-zindex-modal-backdrop`| `z-index` | `1200` | Voile sombre sous dialogue modal |
| `--mrv-zindex-modal` | `z-index` | `1250` | Fenêtres modales de confirmation |
| `--mrv-zindex-toast` | `z-index` | `1500` | Notifications toast et alertes flottantes |
| `--mrv-zindex-tooltip` | `z-index` | `1600` | Infobulles contextuelles |

---

## 6. Stratégie de Thématage (Light / Dark)

Le système de tokens Marvens prend en charge le mode sombre sans démultiplier les sélecteurs CSS, grâce à la redéfinition des variables sémantiques :

```css
/* Mode Clair (Default) */
:root {
  --mrv-color-surface-page: #F8FAFC;
  --mrv-color-surface-card: #FFFFFF;
  --mrv-color-text-primary: #0F172A;
  --mrv-color-text-secondary: #334155;
  --mrv-color-border-subtle: #E2E8F0;
}

/* Mode Sombre (Activé par data-theme="dark" ou media query) */
[data-theme="dark"] {
  --mrv-color-surface-page: #0B0F17;
  --mrv-color-surface-card: #151D2A;
  --mrv-color-text-primary: #F8FAFC;
  --mrv-color-text-secondary: #94A3B8;
  --mrv-color-border-subtle: #263345;
}
```

> [!NOTE]
> Les composants ne connaissent que `--mrv-color-surface-card` ou `--mrv-color-text-primary`. La bascule de thème s'opère instantanément à la racine sans aucune règle CSS spécifique par composant.

---

## 7. Règles de Maintenance, Versionnement et Dépréciation

1. **Ajout d'un Token :** Tout nouveau token sémantique doit être justifié par au moins 3 cas d'usage réels et validé selon la gouvernance du framework.
2. **Interdiction de Supprimer Brutalement :** Un token ne peut pas disparaître d'une version mineure à l'autre.
3. **Protocole de Dépréciation :**
   * Étape 1 : Le token est marqué `[DÉPRÉCIÉ]` dans la documentation avec indication de son remplaçant.
   * Étape 2 : Le token conserve sa valeur sous forme d'alias pointant vers le nouveau token pendant 6 mois minimum.
   * Étape 3 : Suppression définitive actée uniquement lors d'une version majeure (ex. V2.0).

---

## 8. Checklist de Validation d'un Design Token

Avant d'inscrire un token dans la documentation officielle d'un produit, vérifier :
```markdown
- [ ] Le token respecte scrupuleusement la syntaxe kebab-case avec le namespace --mrv-.
- [ ] Le nom du token décrit son rôle fonctionnel et non son apparence ou sa couleur brute.
- [ ] Le token sémantique référence une primitive ou variable CSS valide.
- [ ] Pour un token de texte ou surface, le ratio de contraste WCAG AA (4.5:1) est formellement vérifié.
- [ ] Le comportement du token en mode sombre (Dark mode) est explicité.
- [ ] Le token est consigné dans la table de référence du produit avec son statut de validation.
```
