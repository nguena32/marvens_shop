# CSS ARCHITECTURE — Architecture CSS et Intégration Technique
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `06_DESIGN_SYSTEM/CSS_ARCHITECTURE.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Référence méthodologique active `[PROPOSITION NORMATIVE DU FRAMEWORK]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [DESIGN_TOKENS.md](DESIGN_TOKENS.md) · [COMPONENT_LIBRARY.md](COMPONENT_LIBRARY.md) · [SPACING_SYSTEM.md](SPACING_SYSTEM.md)

---

## 1. Principes et Contraintes Techniques Réelles

### 1.1. Philosophie de l'Architecture CSS Marvens
L'architecture CSS de Marvens Group est guidée par l'exigence de **simplicité robuste, de performance d'exécution et de maintenabilité pérenne**. Elle privilégie des standards web pérennes plutôt que des couches d'outillage éphémères.

### 1.2. Alignement avec la Stack Technique Validée
Conformément aux directives d'ingénierie du projet, l'architecture CSS doit être nativement compatible avec :
* **Environnement d'exécution :** PHP 8.3+ Vanilla MVC strict, MySQL 8, PDO, HTML5, CSS3 standard, JavaScript Vanilla.
* **Framework CSS Tiers :** Coexistence harmonieuse avec **Bootstrap 5** lorsque celui-ci est présent dans le projet.
* **Hébergement cible :** Serveurs cPanel / hébergement mutualisé standard.
* **Restrictions Formelles :** **Zéro dépendance obligatoire envers Node.js en production, zéro bundler complexe (Webpack, Vite), pas de Sass compilé imposé et pas de Tailwind.**

> [!IMPORTANT]
> L'architecture CSS utilise le **CSS3 natif moderne** (Variables CSS, CSS Grid, Flexbox, sélecteurs `@media` standards). Elle fonctionne immédiatement sans compilation et sans processeur externe.

---

## 2. Organisation Modulaire des Feuilles de Style

Les styles sont organisés selon une hiérarchie en couches inspirée d'ITCSS (*Inverted Triangle CSS*), garantissant une gestion naturelle et sans heurts de la cascade :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. SETTINGS & TOKENS (`01-tokens.css`)                                      │
│ Définition des variables :root { --mrv-* } (couleurs, polices, rayons)      │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 2. RESET & BASE (`02-base.css`)                                             │
│ Normalisation des balises natives, typographie par défaut, box-sizing       │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 3. LAYOUT & GRILLES (`03-layout.css`)                                       │
│ Grille structurelle, conteneurs, barres latérales, en-têtes fixes           │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 4. COMPOSANTS (`04-components.css`)                                         │
│ Classes des composants réutilisables (.mrv-btn, .mrv-card, .mrv-input)       │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 5. UTILITAIRES & SURCHARGES (`05-utilities.css`)                            │
│ Classes d'espacement d'appoint, alignements, gestion a11y (.mrv-u-sr-only)  │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 3. Convention de Nommage et Maîtrise de la Spécificité

### 3.1. Règle du Préfixe et BEM Allégé
Pour éviter toute collision avec Bootstrap 5 ou des bibliothèques de tiers, toutes les classes propriétaires Marvens portent le préfixe de namespace `.mrv-` :

* **Bloc :** `.mrv-btn`, `.mrv-card`, `.mrv-table`
* **Élément :** `.mrv-card__header`, `.mrv-card__body`, `.mrv-btn__icon`
* **Modificateur / État :** `.mrv-btn--primary`, `.mrv-btn--lg`, `.is-active`, `.is-loading`, `.is-disabled`

### 3.2. Règle de Basse Spécificité
* Privilégier des sélecteurs à une seule classe (ex. `.mrv-card`).
* Interdiction des sélecteurs d'ID (`#header`) dans les feuilles de style.
* Interdiction absolue de l'opérateur `!important`, sauf pour les classes utilitaires d'accessibilité strictes (ex. masquage pour synthèse vocale).

---

## 4. Stratégie de Coexistence et Surcharge de Bootstrap 5

Lorsque **Bootstrap 5** est intégré au produit, Marvens applique des règles de coexistence rigoureuses pour éviter les conflits de styles :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    PROTOCOLE DE COEXISTENCE AVEC BOOTSTRAP 5                │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Pont de Variables CSS │ Mapper les variables Bootstrap sur les tokens    │
│                          │ Marvens dans :root :                             │
│                          │ --bs-primary: var(--mrv-color-action-primary);   │
│                          │ --bs-body-bg: var(--mrv-color-surface-page);     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Séparation des Classes│ Utiliser la grille et les utilitaires Bootstrap  │
│                          │ (.row, .col-md-6, .d-flex) pour le squelette.    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Composants Propriét.  │ Utiliser les composants Marvens (.mrv-card) dès  │
│                          │ que l'identité exige un niveau Premium singulier.│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Zéro Surcharge Brutale│ Ne pas écraser les classes natives .btn sans     │
│                          │ précaution ; étendre via .mrv-btn pour isoler.   │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 5. Gestion des Variables CSS et Performance

### 5.1. Déclaration Centralisée et Scoping
Les tokens sont exposés sur la pseudo-classe `:root` pour garantir leur disponibilité universelle dans le DOM :

```css
:root {
  /* Espacements */
  --mrv-space-1: 4px;
  --mrv-space-2: 8px;
  --mrv-space-3: 12px;
  --mrv-space-4: 16px;
  --mrv-space-6: 24px;
  --mrv-space-8: 32px;

  /* Rayons */
  --mrv-radius-interactive: 6px;
  --mrv-radius-surface: 8px;

  /* Ombres */
  --mrv-shadow-card: 0 1px 3px rgba(15, 23, 42, 0.08);
}
```

### 5.2. Optimisation des Performances de Rendu
* Éviter les sélecteurs descendants profonds (ex. `div.content table tr td.active a` interdit).
* Utiliser les propriétés CSS accélérées matériellement pour les transitions (`transform`, `opacity`).
* Prévenir les recalculs de mise en page (*reflows*) en spécifiant les dimensions ou ratios des conteneurs d'images.

---

## 6. Accessibilité dans l'Architecture CSS

L'accessibilité est intégrée directement dans le socle CSS fondamental :

### 6.1. Anneau de Focus Universel
```css
/* Focus universel accessible pour tout élément interactif */
.mrv-btn:focus-visible,
.mrv-input:focus-visible,
a.mrv-link:focus-visible {
  outline: 2px solid var(--mrv-color-action-primary);
  outline-offset: 2px;
}
```

### 6.2. Respect du Mode Mouvement Réduit
```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
```

### 6.3. Classe Utilitaire pour Synthèse Vocale (*Screen Reader Only*)
```css
.mrv-u-sr-only {
  position: absolute !important;
  width: 1px !important;
  height: 1px !important;
  padding: 0 !important;
  margin: -1px !important;
  overflow: hidden !important;
  clip: rect(0, 0, 0, 0) !important;
  white-space: nowrap !important;
  border: 0 !important;
}
```

---

## 7. Anti-Patterns CSS à Proscrire

1. **L'usage d'outils de compilation node.js non approuvés :** Introduire un `package.json` ou un bundler npm sur un serveur mutualisé PHP sans validation humaine préalable.
2. **Le sélecteur universel de reset brutal :** Écrire `* { margin: 0; padding: 0; }` détruisant les comportements natifs de l'ensemble des éléments.
3. **Le CSS Inline en attribut HTML :** L'usage d'attributs `style="..."` sur les balises de templates PHP est strictement banni.
4. **Les unités physiques absolues (cm, in, pt) :** Seules les unités `px` (pour les bordures et rayons précis) et `rem` / `em` (pour la typographie et les espacements relatifs) sont autorisées.

---

## 8. Checklist de Revue d'Architecture CSS

```markdown
### Grille de Contrôle CSS
- [ ] Les styles fonctionnent sans aucun outil de compilation ou bundler externe.
- [ ] Toutes les variables de styles utilisent le préfixe de namespace --mrv-*.
- [ ] En présence de Bootstrap 5, la coexistence est gérée par mapping de variables sans conflit.
- [ ] Aucun !important n'est utilisé en dehors des utilitaires d'accessibilité stricts.
- [ ] L'anneau de focus (:focus-visible) est garanti sur tous les composants interactifs.
- [ ] La media query (prefers-reduced-motion) désactive les animations si demandée.
- [ ] Les fichiers CSS sont structurés selon l'arborescence normative à 5 niveaux.
```
