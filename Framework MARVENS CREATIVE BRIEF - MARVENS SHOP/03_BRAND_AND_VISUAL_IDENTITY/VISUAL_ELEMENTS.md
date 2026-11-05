# VISUAL ELEMENTS — Éléments graphiques et langage visuel
## MARVENS CREATIVE BRIEF V1.0 · PHASE 03_BRAND_AND_VISUAL_IDENTITY

> **Document :** Spécification doctrinale, géométrie, élévation et grammaire de mise en page  
> **Statut :** Référence méthodologique et opérationnelle active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## Sommaire
1. [Rôle des éléments visuels et vision doctrinale](#1-rôle-des-éléments-visuels-et-vision-doctrinale)
2. [Articulation des 3 niveaux du framework](#2-articulation-des-3-niveaux-du-framework)
3. [Géométrie, angles et rayons de courbure (Border Radius)](#3-géométrie-angles-et-rayons-de-courbure-border-radius)
4. [Lignes, bordures et séparateurs structurels](#4-lignes-bordures-et-séparateurs-structurels)
5. [Profondeur, élévation et gestion de l'ombre portée](#5-profondeur-élévation-et-gestion-de-lombre-portée)
6. [Composition, rythme et espace négatif](#6-composition-rythme-et-espace-négatif)
7. [Éléments de signalisation et micro-surfaces (Badges & Tags)](#7-éléments-de-signalisation-et-micro-surfaces-badges--tags)
8. [Mouvement, transitions et respect de l'accessibilité](#8-mouvement-transitions-et-respect-de-laccessibilité)
9. [Harmonisation systémique globale](#9-harmonisation-systémique-globale)
10. [Gabarit de spécification pour un produit](#10-gabarit-de-spécification-pour-un-produit)
11. [Anti-patterns et dérives à proscrire](#11-anti-patterns-et-dérives-à-proscrire)
12. [Checklist de validation du langage visuel](#12-checklist-de-validation-du-langage-visuel)

---

## 1. Rôle des éléments visuels et vision doctrinale

Au-delà de la couleur, du logo et des polices de caractères, l'identité d'un produit numérique s'exprime à travers sa **grammaire spatiale et géométrique** : la douceur de ses angles, la discrétion de ses bordures, la profondeur mesurée de ses élévations et le rythme de ses respirations.

Dans le cadre de la **Premium Quality**, le langage visuel se distingue par sa **retenue**. L'excellence graphique ne consiste pas à multiplier les textures, les motifs complexes ou les ombres omniprésentes, mais à créer une architecture d'une clarté évidente où chaque élément remplit une fonction de guidage ou de hiérarchisation.

---

## 2. Articulation des 3 niveaux du framework

* **Niveau A — Principes permanents du Framework :**  
  Tout langage graphique doit reposer sur un système d'espacement modulaire (base 4px ou 8px), une cohérence stricte des arrondis (éviter la coexistence aléatoire de boutons carrés et de cartes hyper-arrondies) et une sobriété absolue des effets d'ombre.
* **Niveau B — Méthode de décision :**  
  Analyse du tempérament du produit (technique et dense vs chaleureux et grand public) $\rightarrow$ définition de l'échelle d'arrondis $\rightarrow$ calibration de l'élévation optique $\rightarrow$ test sur affichage mobile $\rightarrow$ validation humaine formelle.
* **Niveau C — Paramètres propres au produit :**  
  Les valeurs géométriques exactes (ex: `radius-md: 8px` ou `radius-md: 12px`, ombres personnalisées) sont consignées dans les spécifications propres à chaque produit.

---

## 3. Géométrie, angles et rayons de courbure (Border Radius)

Le rayon de courbure (*border-radius*) est un marqueur psychologique majeur :
* **Angles vifs (0px à 2px) :** Sensation de technicité pure, de rigueur financière, de compacité maximale.
* **Arrondis équilibrés (6px à 10px) — [Standard Recommandé Marvens B2B] :** Équilibre parfait entre modernité, sérieux professionnel et ergonomie rassurante.
* **Grands arrondis (16px à 24px) / Pill-shape (9999px) :** Réservés aux badges compacts, barres de recherche ou produits grand public.

### Échelle géométrique standardisée Marvens :

```css
--radius-none: 0px;
--radius-sm:   4px;    /* Cases à cocher, petits badges */
--radius-md:   8px;    /* Boutons, champs de saisie, menus déroulants */
--radius-lg:   12px;   /* Cartes de contenu, conteneurs principaux */
--radius-xl:   16px;   /* Fenêtres modales, panneaux flottants */
--radius-full: 9999px; /* Badges d'état, boutons ronds */
```

> **Règle de l'imbrication géométrique (Nested Radius) :**  
> Lorsqu'un élément enfant est placé dans un conteneur avec bordure arrondie, le rayon de l'enfant doit être calculé selon la formule :  
> `Rayon Enfant = Rayon Parent - Épaisseur de la Marge Interne (Padding)`.  
> Cela prévient l'effet disgracieux d'espace vide déformé dans les coins.

---

## 4. Lignes, bordures et séparateurs structurels

* **Épaisseur constante :** Les bordures structurelles doivent mesurer **1px** d'épaisseur nominale. L'épaisseur de 2px est réservée aux indicateurs d'état actif (*Focus ring*, sélection d'onglet).
* **Nuance et subtilité chromatique :** Les bordures ne doivent jamais être d'un noir franc ou d'un gris trop foncé. Utiliser des gris neutres très doux (ex: `--color-neutral-200` en mode clair, `--color-neutral-800` en mode sombre) pour délimiter les zones sans alourdir la page.
* **Priorité à l'espace négatif :** Chaque fois qu'une séparation peut être assurée par une marge blanche équilibrée ou un léger contraste de fond de surface, privilégier cette solution plutôt que de tracer une ligne de bordure supplémentaire.

---

## 5. Profondeur, élévation et gestion de l'ombre portée

Pour préserver la clarté et éviter l'effet « sale » ou lourd de certaines interfaces, le framework proscrit les ombres noires diffuses et lourdes au profit d'ombres multicouches très légères et teintées de la couleur de surface :

| Niveau d'élévation | Token | Caractéristiques optiques | Usage type |
| :--- | :--- | :--- | :--- |
| **Niveau 0 (À plat)** | `shadow-none` | Aucune ombre, bordure 1px subtile | Cartes intégrées dans la grille. |
| **Niveau 1 (Doux)** | `shadow-sm` | `0 1px 2px 0 rgba(0, 0, 0, 0.05)` | Boutons au repos, survols légers. |
| **Niveau 2 (Moyen)** | `shadow-md` | `0 4px 6px -1px rgba(0, 0, 0, 0.07)`| Menus déroulants, barres flottantes.|
| **Niveau 3 (Élevé)** | `shadow-lg` | `0 10px 15px -3px rgba(0, 0, 0, 0.1)`| Fenêtres modales, dialogues d'alerte.|

---

## 6. Composition, rythme et espace négatif

Le système de composition de Marvens repose sur la règle du **multiple de 8px** (avec demi-mesure de 4px pour les ajustements fins) :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          GRILLE D'ESPACEMENT MODULAIRE                      │
│                                                                             │
│   4px   : Espacement micro (entre icône et texte)                           │
│   8px   : Espacement compact (marge interne des boutons compacts)           │
│   16px  : Espacement standard (marge interne des cartes, gap de grille)     │
│   24px  : Espacement de respiration (écart entre blocs de section)          │
│   32px  : Espacement structurel majeur (marge de page sur desktop)          │
│   48px+ : Espacement de mise en scène (bannières, en-têtes d'impact)        │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 7. Éléments de signalisation et micro-surfaces (Badges & Tags)

* **Badges d'état (Status Badges) :**  
  Toujours constitués d'un fond teinté doux (opacité 10-15%), d'un texte à fort contraste dans la teinte de base et d'un point indicateur (*dot*) de 6px ou d'une icône explicite.
  * *Exemple Succès :* Fond `#ECFDF5`, Texte `#065F46`, Point `#10B981`.
  * *Exemple Erreur :* Fond `#FEF2F2`, Texte `#991B1B`, Point `#EF4444`.
* **Forme :** Hauteur compacte (20px à 24px) avec un rayon de courbure `radius-full` ou `radius-sm`.

---

## 8. Mouvement, transitions et respect de l'accessibilité

Le mouvement dans un produit Marvens doit être utilitaire, feutré et sobre :
* **Durée des transitions :** Entre **150ms et 250ms**. Au-delà de 300ms, l'utilisateur perçoit un ralentissement logiciel intolérable sur une interface de travail.
* **Courbe d'accélération :** Utiliser la fonction standard `cubic-bezier(0.4, 0, 0.2, 1)` (*ease-in-out* naturel).
* **Respect impératif de la directive `prefers-reduced-motion` :**
  ```css
  @media (prefers-reduced-motion: reduce) {
    *, ::before, ::after {
      animation-duration: 0.01ms !important;
      transition-duration: 0.01ms !important;
    }
  }
  ```
  Les usagers souffrant de troubles vestibulaires ou disposant de terminaux peu puissants doivent pouvoir utiliser le produit sans saccade d'animation.

---

## 9. Harmonisation systémique globale

Le langage de formes forme un tout indissociable avec les piliers de couleur et de typographie :
* Si la typographie de corps est très géométrique et ronde (ex: Outfit), les boutons adoptent des arrondis généreux (`8px` à `12px`).
* Si la typographie est compacte et technique (ex: Inter), les composants adoptent des rayons plus sobres (`6px` à `8px`) et des séparateurs discrets.

---

## 10. Gabarit de spécification pour un produit

```markdown
### Spécifications du Langage Visuel — [Nom du Produit]
* **Gamme d'arrondis dominante :** Modérée (Base 8px / Cartes 12px)
* **Système d'élévation :** Ombres douces multicouches (Niveau 1 à 3)
* **Style de bordure :** 1px solide `#E2E8F0`
* **Échelle d'espacement de référence :** Base 8px modulaire
* **Durée moyenne des transitions UI :** 200ms ease-out
* **Statut de validation :** [ ] Soumis à validation humaine [ ] Validé
```

---

## 11. Anti-patterns et dérives à proscrire

1. **L'accumulation d'ombres lourdes :** Superposer des ombres noires denses qui assombrissent la page et donnent un aspect sale à l'interface.
2. **L'anarchie des arrondis :** Mélanger sur un même écran des cartes carrées à 0px, des boutons à 16px et des champs de formulaires arrondis à 4px sans logique d'ensemble.
3. **L'animation gratuite et lente :** Faire glisser chaque tableau ou chaque carte pendant une seconde à chaque clic, exaspérant les opérateurs de caisse et de saisie.

---

## 12. Checklist de validation du langage visuel

- [ ] L'échelle d'arrondis suit une hiérarchie cohérente du plus petit au plus grand composant.
- [ ] Le calcul du rayon imbriqué (*nested radius*) est respecté sur les conteneurs complexes.
- [ ] Le système d'espacement modulaire (base 4/8px) est appliqué sur toutes les maquettes.
- [ ] Les ombres portées sont subtiles, légères et non agressives.
- [ ] La directive d'accessibilité `prefers-reduced-motion` est systématiquement intégrée dans le code CSS.
- [ ] Les règles graphiques ont été présentées au responsable de projet pour arbitrage.
