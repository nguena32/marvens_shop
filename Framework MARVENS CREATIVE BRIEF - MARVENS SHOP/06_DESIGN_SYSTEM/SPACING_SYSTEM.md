# SPACING SYSTEM — Système d'Espacement et Rythme Visuel
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `06_DESIGN_SYSTEM/SPACING_SYSTEM.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Référence méthodologique active `[PROPOSITION NORMATIVE DU FRAMEWORK]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [DESIGN_TOKENS.md](DESIGN_TOKENS.md) · [CSS_ARCHITECTURE.md](CSS_ARCHITECTURE.md) · [UI_GUIDELINES.md](../05_UI_DESIGN/UI_GUIDELINES.md)

---

## 1. Rôle de l'Espacement dans l'Expérience Utilisateur

Dans le framework **MARVENS CREATIVE BRIEF V1.0**, l'espace vide n'est ni un déchet d'interface ni une surface perdue. Il est **un outil d'architecture optique et de hiérarchisation active** (*active white space*).

### Fonctions Primordiales de l'Espacement :
* **La Loi de Proximité (Gestalt) :** Les éléments visuellement proches sont perçus comme appartenant au même groupe logique. L'espacement dicte la compréhension sans nécessiter de lignes de séparation superflues.
* **Le Confort et la Respiration Cognitive :** Une interface aérée réduit le stress de l'usager, facilite le scan visuel et met en valeur les données maîtresses.
* **Le Calibrage de la Densité Métier :** Ajuster le ratio de vide en fonction de la tâche (densité forte pour l'analyste de données, densité confortable pour le grand public).

---

## 2. Unité de Base et Échelle Modulaire d'Espacement

### 2.1. La Règle du Pas de 4px / 8px
Le système d'espacement Marvens repose mathématiquement sur une **base modulaire de 4 pixels**, avec un pas préférentiel de **8 pixels** pour les structures majeures.

Cette grille mathématique garantit que tous les éléments (typographies, hauteurs de champs, largeurs de colonnes) s'alignent avec une précision chirurgicale sur tous les ratios d'écran standard.

### 2.2. L'Échelle Normative des Tokens d'Espacement

| Token d'Espacement | Valeur en Pixels | Valeur en Rem | Usage Recommandé |
| :--- | :---: | :---: | :--- |
| `--mrv-space-0-5` | `2px` | `0.125rem` | Micro-ajustements optiques, décalages fins |
| `--mrv-space-1` | `4px` | `0.25rem` | Espacement interne très serré, tags, icône/texte |
| `--mrv-space-2` | `8px` | `0.5rem` | Espacement standard entre éléments liés d'un groupe |
| `--mrv-space-3` | `12px` | `0.75rem` | Padding interne de petits boutons ou champs denses |
| `--mrv-space-4` | `16px` | `1.0rem` | **Unité centrale** : padding standard de carte, gap |
| `--mrv-space-5` | `20px` | `1.25rem` | Séparation intermédiaire de paragraphes |
| `--mrv-space-6` | `24px` | `1.5rem` | Espacement entre cartes d'une même grille |
| `--mrv-space-8` | `32px` | `2.0rem` | Marge entre blocs fonctionnels majeurs |
| `--mrv-space-10` | `40px` | `2.5rem` | Séparation de grands modules |
| `--mrv-space-12` | `48px` | `3.0rem` | Marge extérieure de page sur Desktop |
| `--mrv-space-16` | `64px` | `4.0rem` | Respiration entre sections de landing page |

---

## 3. Typologie des Espacements : Inset, Stack et Inline

Pour appliquer l'échelle avec constance, les designers et développeurs doivent distinguer trois types d'espacement géométrique :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 3 MODES D'ESPACEMENT MARVENS                      │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. INSET (Marge interne) │ Espace entre le bord d'un conteneur et son       │
│                          │ contenu (Padding). Ex. Intérieur d'une carte.    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. STACK (Pile verticale)│ Espace séparant des éléments empilés             │
│                          │ verticalement. Ex. Titre $\rightarrow$ Paragraphe.       │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. INLINE (Flux horizon.)│ Espace séparant des éléments disposés côte à     │
│                          │ côte. Ex. Icône $\rightarrow$ Libellé dans un bouton.   │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 4. Règles d'Application aux Composants Standards

* **Boutons :** Inset vertical `--mrv-space-2` (8px), Inset horizontal `--mrv-space-4` (16px), Gap icône/texte `--mrv-space-2` (8px).
* **Champs de Saisie (*Inputs*) :** Inset vertical `--mrv-space-2-5` (10px), Inset horizontal `--mrv-space-3` (12px), Marge label/champ `--mrv-space-1` (4px).
* **Cartes Modulaires (*Cards*) :** Inset global uniforme de `--mrv-space-4` (16px) sur mobile et `--mrv-space-6` (24px) sur desktop.
* **Formulaires :** Stack verticale de `--mrv-space-4` (16px) entre deux champs consécutifs ; `--mrv-space-8` (32px) entre deux groupes de champs thématiques.

---

## 5. Niveaux de Densité Contextuelle

Le Design System Marvens ne fige pas une densité universelle mais propose trois modes paramétrables selon le profil du produit (Niveau C) :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 3 NIVEAUX DE DENSITÉ D'INTERFACE                     │
├──────────────────┬──────────────────┬───────────────────────────────────────┤
│ Densité          │ Espacement Base  │ Cas d'Usage Métier Privilégié         │
├──────────────────┼──────────────────┼───────────────────────────────────────┤
│ 1. Compact       │ Base 12px        │ Tableaux de données, outils d'audit,  │
│                  │ (Tables denses)  │ progiciels d'experts comptables       │
├──────────────────┼──────────────────┼───────────────────────────────────────┤
│ 2. Confortable   │ Base 16px        │ Applications de gestion quotidiennes, │
│    (Standard)    │ (Équilibre type) │ portails d'entreprise, SaaS B2B      │
├──────────────────┼──────────────────┼───────────────────────────────────────┤
│ 3. Aérée         │ Base 24px        │ Espaces de lecture éditoriale, flux de│
│                  │ (Grandes marges) │ souscription grand public, onboarding │
└──────────────────┴──────────────────┴───────────────────────────────────────┘
```

---

## 6. Adaptations Responsives de l'Espacement

Sur les terminaux mobiles à petit écran, l'espace horizontal est une ressource critique :
* Les marges extérieures d'écran passent de **32px / 48px** sur Desktop à **16px** sur Smartphone.
* Les grilles à colonnes multiples se réduisent en une pile verticale unique avec un `gap` standard de **16px**.
* Les hauteurs de commandes interactives sont maintenues ou agrandies (minimum 44px) pour garantir le confort tactile, même lorsque les marges d'habillage sont réduites.

---

## 7. Anti-Patterns d'Espacement à Éliminer

1. **Les valeurs arbitraires impaires :** Utiliser des marges de `7px`, `13px` ou `21px` sans aucune justification géométrique.
2. **L'accumulation désordonnée de marges (*Margin Collapsing*) :** Poser à la fois un `margin-bottom` sur le bloc supérieur et un `margin-top` sur le bloc inférieur sans convention unifiée.
3. **L'absence d'air autour des CTA :** Étouffer un bouton d'action principal au ras d'un tableau sans marge de respiration.
4. **L'étalement vide injustifié :** Laisser d'immenses zones blanches non intentionnelles qui obligent l'usager à faire défiler l'écran pour trouver l'information.

---

## 8. Checklist de Validation de l'Espacement

```markdown
### Grille de Contrôle d'Espacement
- [ ] Tous les espacements utilisent exclusivement des multiples de 4px ou 8px (--mrv-space-*).
- [ ] La hiérarchie optique traduit directement la proximité logique des contenus.
- [ ] Le niveau de densité (compact, confortable, aéré) est adapté au profil utilisateur ciblé.
- [ ] Les marges de page s'adaptent harmonieusement entre Desktop (32-48px) et Mobile (16px).
- [ ] Aucune valeur brute en pixels n'est injectée directement dans les classes de composants.
```
