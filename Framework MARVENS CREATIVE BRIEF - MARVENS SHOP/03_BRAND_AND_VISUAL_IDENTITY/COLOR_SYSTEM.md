# COLOR SYSTEM — Système de couleurs
## MARVENS CREATIVE BRIEF V1.0 · PHASE 03_BRAND_AND_VISUAL_IDENTITY

> **Document :** Spécification doctrinale, méthodologie et architecture colorimétrique  
> **Statut :** Référence méthodologique et opérationnelle active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## Sommaire
1. [Introduction et objectifs](#1-introduction-et-objectifs)
2. [Articulation des 3 niveaux du framework](#2-articulation-des-3-niveaux-du-framework)
3. [Méthode de construction d'une palette contextualisée](#3-méthode-de-construction-dune-palette-contextualisée)
4. [Architecture des rôles de couleur](#4-architecture-des-rôles-de-couleur)
5. [Échelles, nuances et contrastes WCAG AA](#5-échelles-nuances-et-contrastes-wcag-aa)
6. [Couleurs fonctionnelles et états systèmes](#6-couleurs-fonctionnelles-et-états-systèmes)
7. [Stratégie thématique (Light & Dark Mode)](#7-stratégie-thématique-light--dark-mode)
8. [Système de tokens sémantiques et nomenclature](#8-système-de-tokens-sémantiques-et-nomenclature)
9. [Gabarit de spécification pour un produit](#9-gabarit-de-spécification-pour-un-produit)
10. [Exemple illustratif contextualisé : Suite B2B Marvens](#10-exemple-illustratif-contextualisé--suite-b2b-marvens)
11. [Anti-patterns et erreurs à proscrire](#11-anti-patterns-et-erreurs-à-proscrire)
12. [Checklist de validation colorimétrique](#12-checklist-de-validation-colorimétrique)

---

## 1. Introduction et objectifs

La couleur est le premier vecteur d'émotion, de hiérarchie visuelle et de reconnaissance identitaire d'un produit numérique. Dans le cadre de **MARVENS CREATIVE BRIEF V1.0**, la couleur ne saurait résulter d'une simple intuition décorative ou de l'imitation aveugle d'une tendance graphique éphémère.

### Objectifs fondamentaux
* **Distinguer l'identité de marque des couleurs fonctionnelles :** Séparer nettement les teintes d'évocation émotionnelle (marque/produit) des codes chromatiques régissant l'utilisabilité, la rétroaction (feedback) et la navigation.
* **Garantir une accessibilité optique irréprochable :** Assurer la lisibilité des textes et l'intelligibilité des interfaces quelles que soient les conditions lumineuses réelles (écrans modestes, extérieur sous forte luminosité, basse connectivité).
* **Industrialiser la cohérence via les Design Tokens :** Définir une nomenclature sémantique claire permettant une passerelle fluide entre le design et le code frontend.

---

## 2. Articulation des 3 niveaux du framework

* **Niveau A — Principes permanents du Framework :**  
  Toute palette de couleurs doit respecter les ratios de contraste légaux WCAG AA (minimum 4.5:1 pour le texte courant, 3:1 pour les grands titres et éléments d'interface actifs). Une couleur ne doit jamais être le vecteur unique d'une information d'état.
* **Niveau B — Méthode de décision :**  
  L'agent IA ou le designer suit un protocole pas-à-pas : analyse sectorielle $\rightarrow$ étude de la concurrence $\rightarrow$ définition des dominantes $\rightarrow$ calcul des contrastes $\rightarrow$ proposition de 2 options au minimum $\rightarrow$ validation humaine formelle.
* **Niveau C — Paramètres propres au produit :**  
  Les valeurs chromatiques concrètes (codes HEX, RGB, HSL) sont définies spécifiquement pour chaque produit à partir de son brief validé.

---

## 3. Méthode de construction d'une palette contextualisée

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    MÉTHODE DE CRÉATION D'UNE PALETTE CONTEXTUELLE           │
│                                                                             │
│  [1. Ancrage Métier & Émotion]                                              │
│      Analyse du secteur (fintech, logistique, santé, commerce de détail),   │
│      des attributs émotionnels visés (sobriété, dynamisme, confiance).      │
│                     │                                                       │
│                     ▼                                                       │
│  [2. Prise en compte de l'Environnement Terrain]                             │
│      Sensibilité à l'éclairage ambiant (plein soleil en mobilité / pénombre)│
│      et à la qualité d'affichage des dalles d'écrans du marché cible.       │
│                     │                                                       │
│                     ▼                                                       │
│  [3. Sélection de la Teinte Primaire & Accord Harmonique]                   │
│      Choix d'une couleur d'ancrage singulière, complétée d'une teinte       │
│      secondaire et d'une teinte d'accentuation fonctionnelle.               │
│                     │                                                       │
│                     ▼                                                       │
│  [4. Génération de l'Échelle Neutre (Surfaces & Typo)]                      │
│      Création d'une gamme de gris teintés (Cool Grey, Warm Grey ou Slate)   │
│      offrant une profondeur optique supérieure au gris neutre pur.          │
│                     │                                                       │
│                     ▼                                                       │
│  [5. Calibration Sémantique & Tests de Contraste]                           │
│      Vérification mathématique des ratios de contraste et compatibilité.     │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Architecture des rôles de couleur

Le système structure les couleurs selon onze rôles fonctionnels unifiés :

| Rôle Sémantique | Description fonctionnelle | Usage principal |
| :--- | :--- | :--- |
| `primary` | Couleur signature de marque du produit. | Éléments d'action primaires, en-têtes majeurs, marqueurs clés. |
| `secondary` | Teinte d'accompagnement et de soutien. | Filtres secondaires, badges d'information neutre, arrière-plans doux. |
| `accent` | Teinte de contraste à haute visibilité. | Puces de notification, marqueurs promotionnels, badges d'alerte forte. |
| `neutral` | Échelle de gris teintés (de 50 à 950). | Textes, bordures, séparateurs, arrière-plans de structure. |
| `background` | Teinte de fond générale de l'application. | Fond de page (toile de fond globale). |
| `surface` | Teinte des conteneurs et cartes flottantes. | Cartes, fenêtres modales, barres de navigation, panneaux latéraux. |
| `text` | Niveaux de contraste typographique. | Texte principal (High-contrast), secondaire (Muted), désactivé. |
| `border` | Lignes de délimitation géométrique. | Séparateurs, contours de champs de saisie, contours de cartes. |
| `interactive` | États dynamiques au survol et au clic. | Hover, Active, Focus ring. |
| `feedback` | Système d'états d'alerte universels. | Success (Vert), Warning (Ambre/Orange), Error (Rouge), Info (Bleu). |
| `disabled` | Éléments non manipulables. | Boutons inactifs, champs verrouillés (faible contraste volontaire). |

---

## 5. Échelles, nuances et contrastes WCAG AA

### 5.1. Construction modulaire par paliers (50 à 950)
Chaque teinte majeure doit être déclinée en 10 échelons perceptuels réguliers :
* **50 - 100 :** Arrière-plans d'alerte, surbrillances très douces, hover subtils.
* **200 - 300 :** Bordures douces, arrière-plans d'éléments inactifs.
* **400 - 500 :** Teintes de référence pour les icônes d'illustration ou le mode sombre.
* **600 :** Teinte pivot de référence (*Default Brand / Action*).
* **700 - 800 :** États de survol (*Hover*) et d'enfoncement (*Active*), texte sur fond clair.
* **900 - 950 :** Textes à fort contraste, arrière-plans d'en-têtes foncés.

### 5.2. Règle d'accessibilité WCAG 2.1 (Niveau AA obligatoire)
* **Texte normal (< 18pt ou < 14pt gras) :** Ratio de contraste $\ge$ **4.5:1** avec son arrière-plan direct.
* **Texte large ($\ge$ 18pt ou $\ge$ 14pt gras) :** Ratio de contraste $\ge$ **3.0:1**.
* **Composants d'interface & graphiques fonctionnels :** Ratio de contraste $\ge$ **3.0:1** face aux surfaces adjacentes.
* **Information redondante obligatoire :** Un message d'erreur ou de succès doit toujours associer une icône explicite et un texte d'explication à la couleur.

---

## 6. Couleurs fonctionnelles et états systèmes

Tout élément interactif (bouton, champ de saisie, onglet) doit disposer de sa grille de déclinaison d'état prédictible :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    MATRICE DES ÉTATS D'UN ÉLÉMENT INTERACTIF                │
├──────────────┬────────────────────────────────┬─────────────────────────────┤
│ ÉTAT SYSTÈME │ COMPORTEMENT VISUEL RECOMMANDÉ │ CONTRÔLE D'ACCESSIBILITÉ    │
├──────────────┼────────────────────────────────┼─────────────────────────────┤
│ Default      │ Teinte de base nominale        │ Contraste AA garanti        │
│ Hover        │ Assombrissement optique (+10%) │ Lisibilité du libellé       │
│ Active       │ Assombrissement optique (+20%) │ Feedback de pression tactile│
│ Focus        │ Anneau de focus (Focus Ring 2px│ Visible sans souris (A11y)  │
│ Disabled     │ Désaturation & opacité (40-50%)│ Non cliquable / Curseur not │
└──────────────┴────────────────────────────────┴─────────────────────────────┘
```

---

## 7. Stratégie thématique (Light & Dark Mode)

Le framework n'impose pas le mode sombre à tous les produits par dogmatisme. L'opportunité d'un thème sombre est arbitrée par l'usage :
* **Pertinent pour :** Outils d'encaissement de nuit, régies de sécurité, dashboards de surveillance continue, applications de mobilité nocturne.
* **Non prioritaire pour :** Outils de facturation administrative de jour, formulaires comptables denses, sites éditoriaux de PME.

Lorsqu'un double thème est retenu :
* **Inversion sémantique :** Les tokens de rôle restent identiques (`--surface-primary`, `--text-primary`), seules les valeurs associées basculent.
* Le fond sombre ne doit jamais être un noir pur `#000000` (générateur de halo et de fatigue oculaire), mais un gris très sombre et profond (ex: `#0F172A` ou `#121212`).

---

## 8. Système de tokens sémantiques et nomenclature

Les tokens sont organisés selon une cascade à deux niveaux pour garantir la maintenabilité :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    STRUCTURE EN CASCADE DES DESIGN TOKENS                   │
│                                                                             │
│  NIVEAU 1 : TOKENS GLOBAUX / BRUTS (Primitive Tokens)                       │
│  --color-blue-600: #2563EB;                                                 │
│  --color-slate-900: #0F172A;                                                │
│  --color-emerald-500: #10B981;                                              │
│                     │                                                       │
│                     ▼  MAPPÉS VERS                                          │
│                                                                             │
│  NIVEAU 2 : TOKENS SÉMANTIQUES D'USAGE (Semantic Tokens)                    │
│  --color-action-primary: var(--color-blue-600);                             │
│  --color-text-primary: var(--color-slate-900);                              │
│  --color-feedback-success: var(--color-emerald-500);                        │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 9. Gabarit de spécification pour un produit

Pour chaque produit numérique Marvens, la fiche suivante doit être obligatoirement renseignée lors de la phase de DA :

```markdown
### Palette Officielle — [Nom du Produit]
* **Teinte Primaire (Brand) :** Nom / HEX / Contraste sur blanc
* **Teinte Secondaire :** Nom / HEX / Rôle
* **Teinte d'Accent :** Nom / HEX / Usage
* **Nuancier Neutre de Surface :** Gamme de gris retenue (Cool/Warm/Slate)
* **Système Sémantique :** Succès / Alerte / Erreur / Info
* **Résultat du test WCAG AA :** [Validé le AAAA-MM-JJ par Nom]
* **Statut :** [ ] Hypothèse IA  [ ] Recommandation  [ ] Validé par le Responsable
```

---

## 10. Exemple illustratif contextualisé : Suite B2B Marvens

*(Exemple donné à titre de référence méthodologique pour la suite de gestion B2B en Afrique centrale)* :

* **Primaire (Bleu Saphir Majestueux) :** `#1E3A8A` (Blue-900) — Évoque la solidité institutionnelle, la stabilité financière et le sérieux. Contraste de 9.5:1 sur fond blanc.
* **Accent (Ambre Énergique) :** `#D97706` (Amber-600) — Évoque l'action commerciale et la vitalité sans agressivité.
* **Surfaces Neutres (Slate) :** `#F8FAFC` (Fond de page), `#FFFFFF` (Surfaces de cartes), `#0F172A` (Typographie principale).
* **Feedback Succès (Émeraude MoMo) :** `#059669` (Green-600) — Validation immédiate des encaissements réussis.

---

## 11. Anti-patterns et erreurs à proscrire

1. **La dispersion chromatique :** Employer plus de 3 teintes de marque distinctes sur un même écran, créant une cacophonie visuelle.
2. **Le texte gris délavé sur fond blanc :** Utiliser des gris clairs (`#9CA3AF`) pour du texte courant, illisible sur des écrans sous luminosité naturelle.
3. **L'alerte par la couleur seule :** Afficher un simple rond rouge pour indiquer une erreur sans libellé explicite (« Solde insuffisant »).
4. **Le copier-coller de palettes SaaS génériques :** Utiliser aveuglément les couleurs par défaut de templates sans ancrage avec l'identité du produit.

---

## 12. Checklist de validation colorimétrique

- [ ] La palette repose sur une intention justifiée par le contexte et le brief produit.
- [ ] Chaque rôle de couleur (primaire, surfaces, textes, états) est identifié sans ambiguïté.
- [ ] Tous les couples texte/fond ont été mesurés et atteignent un ratio $\ge$ 4.5:1 (WCAG AA).
- [ ] Les états systèmes (*Hover*, *Active*, *Focus*, *Disabled*) sont documentés.
- [ ] Les tokens sémantiques sont nommés selon la nomenclature standard Marvens.
- [ ] La proposition est soumise au responsable de projet sans proclamation d'adoption unilatérale par l'IA.


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Directives artistiques et identité de marque
- **Personnalité visuelle :** DIR_01_SWISS_EDITORIAL
- **Préférences chromatiques et style :** [À DÉFINIR / À CONFIRMER]
- **Inspirations de design déclarées :** [À DÉFINIR / À CONFIRMER]
<!-- MARVENS_PROJECT_CONTEXT:END -->
