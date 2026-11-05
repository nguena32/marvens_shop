# ACCESSIBILITY IMPLEMENTATION — Standards d'Implémentation Technique de l'Accessibilité
## MARVENS CREATIVE BRIEF V1.0 · PHASE 08_TECHNICAL_STANDARDS

> **Document :** Standards d'implémentation technique de l'accessibilité numérique, balisage HTML5, ARIA 1.2 et WCAG 2.1/2.2 AA  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Cadre normatif :** Web Content Accessibility Guidelines (WCAG) 2.1 / 2.2 Niveau AA, WAI-ARIA 1.2  
> **Documents associés :** [FRONTEND_STANDARDS.md](FRONTEND_STANDARDS.md) · [COMPONENT_DESIGN.md](../05_UI_DESIGN/COMPONENT_DESIGN.md) · [ACCESSIBILITY.md](../04_UX_DESIGN/ACCESSIBILITY.md)

---

## Sommaire

1. [Principes d'ingénierie et cadre normatif WCAG AA](#1-principes-dingénierie-et-cadre-normatif-wcag-aa)
2. [Structure HTML5 et navigation au clavier](#2-structure-html5-et-navigation-au-clavier)
3. [Lien d'évitement rapide (*Skip to Content*)](#3-lien-dévitement-rapide-skip-to-content)
4. [Gestion irréprochable du focus visuel (*Focus Management*)](#4-gestion-irréprochable-du-focus-visuel-focus-management)
5. [Formulaires accessibles : Association rigoureuse des contrôles](#5-formulaires-accessibles--association-rigoureuse-des-contrôles)
6. [Utilisation raisonnée des attributs et rôles WAI-ARIA](#6-utilisation-raisonnée-des-attributs-et-rôles-wai-aria)
7. [Implémentation des composants complexes (Modales, Onglets, Alertes)](#7-implémentation-des-composants-complexes-modales-onglets-alertes)
8. [Images, icônes vectorielles et alternatives textuelles](#8-images-icônes-vectorielles-et-alternatives-textuelles)
9. [Respect des préférences utilisateur (Mouvement réduit, Thèmes)](#9-respect-des-préférences-utilisateur-mouvement-réduit-thèmes)
10. [Protocole d'audit et tests manuels d'accessibilité](#10-protocole-daudit-et-tests-manuels-daccessibilité)
11. [Anti-patterns d'accessibilité dans le code](#11-anti-patterns-daccessibilité-dans-le-code)
12. [Checklist d'implémentation accessibilité](#12-checklist-dimplémentation-accessibilité)
13. [Références officielles](#13-références-officielles)

---

## 1. Principes d'ingénierie et cadre normatif WCAG AA

Dans le framework **MARVENS CREATIVE BRIEF V1.0**, l'accessibilité numérique n'est ni une surcouche de fin de projet, ni une contrainte cosmétique : **c'est un pilier de la qualité logicielle**.

Le respect des directives **WCAG 2.1 et 2.2 niveau AA** repose sur les 4 principes universels (POUR) :
- **Perceptible :** L'information et les composants d'interface doivent être présentés sous une forme que tout usager peut percevoir (visuellement ou vocalement).
- **Utilisable :** Tous les contrôles doivent pouvoir être actionnés au clavier, à la souris ou par contact tactile.
- **Compréhensible :** Le langage, les parcours et les messages d'erreur doivent être dépourvus d'ambiguïté.
- **Robuste :** Le balisage doit pouvoir être interprété de manière fiable par une grande diversité d'agents utilisateurs, y compris les technologies d'assistance (lecteurs d'écran NVDA, JAWS, VoiceOver, TalkBack).

---

## 2. Structure HTML5 et navigation au clavier

### 2.1 Hiérarchie stricte des titres (`<h1>` à `<h6>`)
- Chaque page comporte **un seul et unique `<h1>`** représentant le sujet principal de la vue.
- Aucun saut de niveau hiérarchique n'est toléré (ne jamais passer d'un `<h2>` directement à un `<h4>`).
- Ne jamais utiliser de balise de titre uniquement pour un effet de taille visuelle (utiliser les classes CSS utilitaires `.h2`, `.h3` si nécessaire).

### 2.2 Ordre séquentiel naturel de tabulation
- Le flux de navigation au clavier (`Tab` et `Shift + Tab`) doit correspondre rigoureusement à l'ordre logique de lecture visuelle.
- **Interdiction formelle des attributs `tabindex` positifs (`tabindex="1"`)** qui brisent l'ordre naturel du navigateur.
- L'attribut `tabindex="0"` est réservé aux éléments non natifs devant intégrer le flux de tabulation.
- L'attribut `tabindex="-1"` est utilisé pour permettre à JavaScript de déplacer le focus sur une zone ciblée sans l'ajouter à la navigation séquentielle.

---

## 3. Lien d'évitement rapide (*Skip to Content*)

Pour permettre aux personnes naviguant au clavier ou à l'aide d'un lecteur d'écran d'éviter de reparcourir l'ensemble de la barre de navigation à chaque chargement de page, un lien d'évitement est obligatoire au tout début du `<body>` :

```html
<!-- Première balise interactive du <body> -->
<a href="#main-content" class="c-skip-link">Passer directement au contenu principal</a>

<main id="main-content" tabindex="-1">
  <!-- Contenu de la page -->
</main>
```

```css
/* Style du lien d'évitement (masqué visuellement hors focus) */
.c-skip-link {
  position: absolute;
  top: -100px;
  left: 1rem;
  background: var(--color-primary, #0F172A);
  color: #FFFFFF;
  padding: 0.75rem 1.25rem;
  z-index: 9999;
  border-radius: var(--radius-md, 6px);
  text-decoration: none;
  font-weight: 600;
  transition: top 0.2s ease;
}

.c-skip-link:focus {
  top: 1rem;
  outline: 3px solid var(--color-focus, #0284C7);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}
```

---

## 4. Gestion irréprochable du focus visuel (*Focus Management*)

L'indicateur de focus visuel est le seul repère spatial d'un utilisateur sans souris. Sa neutralisation est un manquement grave.

```css
/* Indicateur de focus universel hautement visible */
:focus-visible {
  outline: 2px solid var(--color-focus, #0284C7) !important;
  outline-offset: 2px !important;
}

/* Règle d'or : Interdiction absolue */
*:focus {
  /* outline: none !important; <= FORMELLEMENT PROSCRIT */
}
```

---

## 5. Formulaires accessibles : Association rigoureuse des contrôles

Chaque contrôle de formulaire doit être relié explicitement à son libellé et à son message d'aide ou d'erreur :

```html
<div class="form-group mb-3">
  <!-- 1. Association explicite label <-> input via l'attribut for / id -->
  <label for="user_email" class="form-label">
    Adresse email professionnelle <span class="text-danger" aria-hidden="true">*</span>
    <span class="visually-hidden">(champ obligatoire)</span>
  </label>

  <input 
    type="email" 
    id="user_email" 
    name="email" 
    class="form-control" 
    required 
    aria-required="true"
    aria-describedby="email_help email_error"
  >

  <!-- 2. Texte d'aide associé -->
  <div id="email_help" class="form-text">
    Utilisée pour la transmission des états financiers et avis de virement.
  </div>

  <!-- 3. Message d'erreur associé en cas d'anomalie -->
  <div id="email_error" class="invalid-feedback" role="alert">
    Veuillez saisir une adresse email valide au format nom@domaine.cm.
  </div>
</div>
```

---

## 6. Utilisation raisonnée des attributs et rôles WAI-ARIA

> **Première règle d'ARIA (W3C) :** Si un élément HTML natif possède déjà la sémantique requise (`<button>`, `<dialog>`, `<nav>`, `<main>`), ne jamais le remplacer par un `<div>` surchargé d'attributs ARIA.

Attributs ARIA autorisés et requis :
- `aria-expanded="true/false"` : Pour les boutons déclencheurs de menus déroulants ou accordéons.
- `aria-hidden="true"` : Pour masquer les icônes purement décoratives aux lecteurs d'écran.
- `aria-live="polite"` : Pour annoncer vocalement les mises à jour asynchrones (ex. montant mis à jour dans le panier sans rechargement de page).
- `aria-label` : Pour doter d'un nom accessible explicite les boutons ne comportant qu'une icône (ex. `<button aria-label="Fermer la fenêtre">`).

---

## 7. Implémentation des composants complexes (Modales, Onglets, Alertes)

### 7.1 Fenêtre modale accessible (*Accessible Dialog*)
Une fenêtre modale conforme doit respecter 3 exigences techniques strictes :
1. **Rôles ARIA :** `role="dialog" aria-modal="true" aria-labelledby="modal-title-id"`.
2. **Piège de focus (*Focus Trap*) :** Lorsque la modale est active, la touche `Tab` boucle indéfiniment à l'intérieur de la fenêtre et ne peut pas atteindre les éléments d'arrière-plan.
3. **Restitution du focus :** À la fermeture de la modale (via clic, bouton croix ou touche `Échap`), le focus est restitué au bouton déclencheur initial.

### 7.2 Système d'onglets (*Tablist Pattern*)
- Le conteneur d'onglets porte `role="tablist"`.
- Chaque onglet porte `role="tab"` et `aria-selected="true/false"`.
- Chaque panneau de contenu porte `role="tabpanel"` et `aria-labelledby="tab-id"`.
- La navigation entre onglets s'effectue au moyen des flèches directionnelles du clavier (`←` et `→`).

---

## 8. Images, icônes vectorielles et alternatives textuelles

- **Images porteuses d'information :** Doivent impérativement comporter un attribut `alt` décrivant l'information véhiculée de manière concise.
- **Images purement décoratives :** Doivent comporter un attribut `alt=""` vide pour être ignorées par les lecteurs d'écran. L'omission pure et simple de l'attribut `alt` est une erreur de validation HTML5.
- **Icônes SVG inline :** Si l'icône est décorative à côté d'un texte clair, ajouter `aria-hidden="true"`. Si l'icône est interactive sans texte, lui associer une balise `<title>` interne ou un `aria-label` sur le bouton conteneur.

---

## 9. Respect des préférences utilisateur (Mouvement réduit, Thèmes)

Prise en compte obligatoire de la requête média CSS `@media (prefers-reduced-motion: reduce)` :

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

---

## 10. Protocole d'audit et tests manuels d'accessibilité

Tout écran avant livraison doit faire l'objet de 4 tests de conformité :

1. **Test clavier pur (Sans souris) :** Parcourir la totalité de l'écran avec `Tab`, `Shift+Tab`, `Entrée`, `Espace` et `Échap`. Chaque élément interactif doit être atteignable, activable et doté d'un focus distinct.
2. **Test au lecteur d'écran :** Vérification avec NVDA (Windows) ou VoiceOver (macOS/iOS) pour s'assurer que chaque bouton et champ possède un nom accessible compréhensible.
3. **Test d'agrandissement textuel :** Zoom de 200 % dans le navigateur : l'interface ne doit présenter aucun chevauchement de texte ni coupure de données financières.
4. **Test de contraste colorimétrique :** Validation avec l'outil Colour Contrast Analyser : ratio minimal de **4.5:1** pour le texte courant et **3.0:1** pour les contrôles d'interface.

---

## 11. Anti-patterns d'accessibilité dans le code

- ❌ **Suppression du focus au clavier (`outline: 0`) :** Rend l'application inutilisable sans souris.
- ❌ **Bouton d'icône sans libellé accessible (`<button><i class="icon-trash"></i></button>`) :** Les technologies d'assistance annoncent simplement « bouton », laissant l'usager dans l'ignorance totale de son action.
- ❌ **Information transmise uniquement par la couleur :** Indiquer une facture en retard uniquement par une pastille rouge sans texte explicatif associé.
- ❌ **Faux boutons balisés en `<div>` ou `<span>` :** Nécessitent des dizaines de lignes de code pour reproduire maladroitement ce que `<button>` accomplit nativement.

---

## 12. Checklist d'implémentation accessibilité

| # | Règle d'implémentation accessibilité | Spécification technique | Statut |
|---|---|---|---|
| **01** | Lien d'évitement | Présence du lien d'accès direct au contenu principal | [ ] |
| **02** | Hiérarchie des titres | Un seul `<h1>` par page, structure logique séquentielle | [ ] |
| **03** | Focus visible préservé | Aucun `outline: none` sans style de focus de remplacement | [ ] |
| **04** | Labels de formulaires | Chaque champ possède un `<label for="...">` associé | [ ] |
| **05** | Boutons d'icônes étiquetés | `aria-label` présent sur tous les boutons sans texte visuel | [ ] |
| **06** | Alternatives d'images | Attribut `alt` présent sur 100 % des balises `<img>` | [ ] |
| **07** | Ratios de contraste | Contrastes conformes aux exigences WCAG AA ($\ge 4.5:1$) | [ ] |
| **08** | Support `reduced-motion` | Prise en charge des préférences de réduction d'animation | [ ] |

---

## 13. Références officielles

- **W3C Web Content Accessibility Guidelines (WCAG) 2.2 :** <https://www.w3.org/TR/WCAG22/> *(Consulté le 31/10/2026)*.
- **W3C WAI-ARIA Authoring Practices Guide (APG) :** <https://www.w3.org/WAI/ARIA/apg/> *(Consulté le 31/10/2026)*.
- **MDN Accessibility Guidelines :** <https://developer.mozilla.org/fr/docs/Web/Accessibility> *(Consulté le 31/10/2026)*.
