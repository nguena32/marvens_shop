# ELEVATION AND SHADOWS — Élévation, Ombres et Profondeur Spatiale
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `06_DESIGN_SYSTEM/ELEVATION_AND_SHADOWS.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Référence méthodologique active `[PROPOSITION NORMATIVE DU FRAMEWORK]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [DESIGN_TOKENS.md](DESIGN_TOKENS.md) · [CSS_ARCHITECTURE.md](CSS_ARCHITECTURE.md) · [UI_GUIDELINES.md](../05_UI_DESIGN/UI_GUIDELINES.md)

---

## 1. Rôle et Philosophie de la Profondeur Visuelle

Dans le cadre du framework **MARVENS CREATIVE BRIEF V1.0**, la profondeur spatiale n'est pas un ornement cosmétique destiné à « faire joli ». Elle est **un indicateur sémantique d'importance et de positionnement dans l'espace tridimensionnel virtuel de l'interface**.

### Principes Directeurs de l'Élévation :
1. **La Sobriété Radicale :** Les ombres lourdes, sales ou trop sombres dégradent la lisibilité et vieillissent prématurément le produit. Marvens privilégie des ombres douces, diffuses et d'une grande subtilité.
2. **La Hiérarchie Fonctionnelle :** Plus un élément s'élève au-dessus du plan de travail (z-index élevé), plus son ombre devient diffuse et étendue, signalant à l'utilisateur qu'il flotte au-dessus du flux normal.
3. **L'Alternative des Bordures Minérales :** Dans de nombreux contextes professionnels (terminaux financiers, écrans sous fort ensoleillement, thèmes sombres), une bordure contrastée de 1px est infiniment plus lisible et élégante qu'une ombre floue.

---

## 2. Anatomie et Construction Mathématique d'une Ombre Premium

Une ombre professionnelle selon les standards Marvens Group se compose généralement de **deux couches lumineuses superposées** pour imiter le comportement physique de la lumière naturelle :
* **Couche 1 (Ombre de contact) :** Tranche très fine, peu étalée, ancrant l'objet au ras du sol.
* **Couche 2 (Ombre d'ambiance) :** Flou plus large et très transparent, traduisant la lumière diffuse environnante.

```css
/* Exemple d'anatomie d'une ombre Marvens */
box-shadow: 
  0 1px 2px 0 rgba(15, 23, 42, 0.05),  /* Contact */
  0 4px 6px -1px rgba(15, 23, 42, 0.08); /* Ambiance */
```

---

## 3. L'Échelle Normative des Niveaux d'Élévation

Le système Marvens normalise cinq niveaux d'élévation fondamentaux :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 5 NIVEAUX D'ÉLÉVATION SPATIALE                       │
├──────────────┬──────────────┬───────────────────────────────────────────────┤
│ Niveau       │ Token Ombre  │ Cas d'Usage Typique                           │
├──────────────┼──────────────┼───────────────────────────────────────────────┤
│ 0. Surface   │ `none`       │ Fond de page, arrière-plans plats, conteneurs │
│    Plat      │              │ délimités par une bordure discrète.           │
├──────────────┼──────────────┼───────────────────────────────────────────────┤
│ 1. Basse     │ `--mrv-     │ Cartes au repos, boutons secondaires,         │
│    Élévation │ shadow-sm`   │ petits panneaux d'information intégrés.       │
├──────────────┼──────────────┼───────────────────────────────────────────────┤
│ 2. Moyenne   │ `--mrv-     │ Cartes au survol (hover), sélecteurs déroulés,│
│    Élévation │ shadow-md`   │ barres d'outils flottantes.                   │
├──────────────┼──────────────┼───────────────────────────────────────────────┤
│ 3. Haute     │ `--mrv-     │ Menus déroulants (Dropdowns), volets latéraux │
│    Élévation │ shadow-lg`   │ (Drawers), popovers contextuels.              │
├──────────────┼──────────────┼───────────────────────────────────────────────┤
│ 4. Sommet    │ `--mrv-     │ Fenêtres modales de confirmation (Dialogs),   │
│    (Overlay) │ shadow-xl`   │ notifications Toast, alertes critiques.       │
└──────────────┴──────────────┴───────────────────────────────────────────────┘
```

---

## 4. Spécification Technique des Tokens d'Ombre

| Token de Profondeur | Définition CSS Standard | Rendu Optique |
| :--- | :--- | :--- |
| `--mrv-shadow-none` | `none` | Planéité totale |
| `--mrv-shadow-sm` | `0 1px 3px 0 rgba(15, 23, 42, 0.06), 0 1px 2px -1px rgba(15, 23, 42, 0.04)` | Micro-relief discret |
| `--mrv-shadow-md` | `0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.06)` | Décollement net |
| `--mrv-shadow-lg` | `0 10px 15px -3px rgba(15, 23, 42, 0.10), 0 4px 6px -4px rgba(15, 23, 42, 0.05)`| Flottement marqué |
| `--mrv-shadow-xl` | `0 20px 25px -5px rgba(15, 23, 42, 0.12), 0 8px 10px -6px rgba(15, 23, 42, 0.06)`| Élévation modale |

---

## 5. Gestion des Couches Spatiales et Hiérarchie des `z-index`

Les conflits d'empilement (éléments passant sous d'autres de manière imprévue) constituent un défaut d'ingénierie inacceptable. Marvens élimine ce risque grâce à une échelle centralisée de `z-index` :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    ÉCHELLE NORMÉE DES Z-INDEX MARVENS                       │
├──────────────────────────┬──────────┬───────────────────────────────────────┤
│ Token Sémantique         │ Valeur   │ Composants Autorisés                  │
├──────────────────────────┼──────────┼───────────────────────────────────────┤
│ `--mrv-zindex-base`      │ `1`      │ Éléments positionnés standards        │
│ `--mrv-zindex-sticky`    │ `100`    │ En-têtes de tableaux défilants        │
│ `--mrv-zindex-header`    │ `500`    │ Barre de navigation fixe (Top Nav)    │
│ `--mrv-zindex-dropdown`  │ `1000`   │ Menus déroulants, autocomplétion      │
│ `--mrv-zindex-drawer`    │ `1100`   │ Panneaux latéraux dépliants           │
│ `--mrv-zindex-backdrop`  │ `1200`   │ Voile noir sous modale (50% opacité)  │
│ `--mrv-zindex-modal`     │ `1250`   │ Boîte de dialogue modale              │
│ `--mrv-zindex-toast`     │ `1500`   │ Notifications éphémères Toast         │
│ `--mrv-zindex-tooltip`   │ `1600`   │ Infobulles d'aide immédiate           │
└──────────────────────────┴──────────┴───────────────────────────────────────┘
```

> [!WARNING]
> Il est formellement interdit d'écrire des valeurs arbitraires comme `z-index: 9999` ou `z-index: 99999` dans le code d'un projet Marvens. Toute élévation doit consommer un token officiel de la table.

---

## 6. Comportement en Mode Sombre (*Dark Mode*)

Sur surface sombre, les ombres noires deviennent optiquement invisibles. Le Design System Marvens adapte sa stratégie :
* **Remplacement par des Bordures Subtiles :** Utiliser des bordures de 1px avec une nuance légèrement plus claire que le fond (`--mrv-color-border-subtle`).
* **Légère Élévation par la Couleur de Surface :** Plus un composant est élevé, plus son fond gris s'éclaircit subtilement (ex. Surface fond `#0B0F17` $\rightarrow$ Carte `#151D2A` $\rightarrow$ Modale `#1E293B`).

---

## 7. Anti-Patterns d'Élévation à Proscrire

1. **L'ombre noire saturée :** Utiliser `rgba(0, 0, 0, 0.4)` qui crée une tache sale et agressive sur l'écran.
2. **L'ombre sur chaque élément :** Enfermer chaque statistique, chaque bouton et chaque texte dans une carte avec ombre portée, produisant un désordre visuel étouffant.
3. **Le décalage vertical excessif sans flou :** Créer des ombres dures non diffuses donnant un aspect d'affiche rétro inadapté au logiciel moderne.
4. **Le z-index comme rustine :** Augmenter arbitrairement un chiffre de z-index pour masquer un bug d'imbrication HTML au lieu de corriger le contexte d'empilement (*stacking context*).

---

## 8. Checklist de Contrôle d'Élévation

```markdown
### Grille de Validation d'Élévation
- [ ] Les ombres sont légères, diffuses et composées d'une double couche subtile.
- [ ] Aucun z-index brut en dur n'est présent (utilisation des tokens --mrv-zindex-*).
- [ ] L'élévation d'un élément traduit une priorité fonctionnelle réelle.
- [ ] En mode sombre, l'élévation est soutenue par des bordures ou des nuances de surface claires.
- [ ] Le nombre de cartes surélevées par vue reste mesuré pour éviter la surcharge visuelle.
```
