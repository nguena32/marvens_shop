# BOOTSTRAP GUIDELINES — Directives d'Intégration et Personnalisation de Bootstrap 5
## MARVENS CREATIVE BRIEF V1.0 · PHASE 08_TECHNICAL_STANDARDS

> **Document :** Standards d'utilisation, de surcharge et d'intégration de Bootstrap 5.3 avec le Design System Marvens  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Version cible du framework :** Bootstrap v5.3.x (Production CSS Vanilla / JS Bundle sans Sass obligatoire)  
> **Documents associés :** [FRONTEND_STANDARDS.md](FRONTEND_STANDARDS.md) · [COMPONENT_DESIGN.md](../05_UI_DESIGN/COMPONENT_DESIGN.md) · [DESIGN_TOKENS.md](../06_DESIGN_SYSTEM/DESIGN_TOKENS.md) · [ACCESSIBILITY_IMPLEMENTATION.md](ACCESSIBILITY_IMPLEMENTATION.md)

---

## Sommaire

1. [Rôle de Bootstrap 5 et philosophie de coexistence](#1-rôle-de-bootstrap-5-et-philosophie-de-coexistence)
2. [Version officielle et modalité d'intégration (Zéro dépendance Node.js)](#2-version-officielle-et-modalité-dintégration-zéro-dépendance-nodejs)
3. [Stratégie de personnalisation via CSS Custom Properties](#3-stratégie-de-personnalisation-via-css-custom-properties)
4. [Usage rigoureux du système de grille et conteneurs](#4-usage-rigoureux-du-système-de-grille-et-conteneurs)
5. [Composants Bootstrap autorisés, adaptés et proscrits](#5-composants-bootstrap-autorisés-adaptés-et-proscrits)
6. [Intégration des formulaires et validation visuelle native](#6-intégration-des-formulaires-et-validation-visuelle-native)
7. [Gestion des composants dynamiques (Modales, Offcanvas, Dropdowns)](#7-gestion-des-composants-dynamiques-modales-offcanvas-dropdowns)
8. [Gestion de l'iconographie : Bootstrap Icons vs Marvens Icons](#8-gestion-de-liconographie--bootstrap-icons-vs-marvens-icons)
9. [Performance et élimination du surcoût de style (*CSS Bloat*)](#9-performance-et-élimination-du-surcoût-de-style-css-bloat)
10. [Anti-patterns d'utilisation de Bootstrap 5](#10-anti-patterns-dutilisation-de-bootstrap-5)
11. [Checklist d'intégration Bootstrap 5](#11-checklist-dintégration-bootstrap-5)
12. [Références officielles](#12-références-officielles)

---

## 1. Rôle de Bootstrap 5 et philosophie de coexistence

Dans l'écosystème de développement Marvens Group, **Bootstrap 5.3 n'est pas le Design System ; c'est un accélérateur d'infrastructure d'interface**. 

Son rôle est strictement délimité :
- Fournir une grille responsive éprouvée (12 colonnes, Flexbox).
- Assurer la gestion accessible des micro-interactions JavaScript complexes (comportement des fenêtres modales avec piège de focus, panneaux latéraux offcanvas, menus déroulants accessibles ARIA).
- Offrir une normalisation multi-navigateurs solide (*Reboot*).

> **Principe fondamental :** L'identité de marque, les couleurs sémantiques, les rayons de courbure et la typographie proviennent exclusivement du **MARVENS DESIGN SYSTEM** (`06_DESIGN_SYSTEM/`). Bootstrap 5 doit s'effacer sous les tokens du produit pour éviter l'aspect « gabarit générique Bootstrap » proscrit par la doctrine *Contextual Design · Premium Quality*.

---

## 2. Version officielle et modalité d'intégration (Zéro dépendance Node.js)

### 2.1 Version cible
La version de référence obligatoire est **Bootstrap v5.3.3** (ou version stable 5.3.x supérieure).

### 2.2 Modalité de chargement
Pour garantir la souveraineté technique et éliminer les points de rupture en cas de coupure de liaison internationale :
- **Hébergement local obligatoire :** Les fichiers `bootstrap.min.css` (environ 230 Ko brut / 30 Ko Brotli) et `bootstrap.bundle.min.js` (incluant Popper.js, environ 80 Ko minifié) sont directement déposés dans `public_html/assets/vendor/`.
- **Aucun CDN externe obligatoire en production :** Empêche le blocage du rendu si un CDN public est filtré ou ralenti.
- **Zéro obligation de Sass/Node.js :** La personnalisation s'effectue via les variables CSS natives (`:root`) et des classes d'écrasement ciblées, évitant d'imposer un compilateur Sass aux environnements cPanel simples.

---

## 3. Stratégie de personnalisation via CSS Custom Properties

Bootstrap 5.3 expose nativement des centaines de variables CSS. La personnalisation de la charte Marvens s'opère en surchargeant ces variables à la racine :

```css
/* public/assets/css/tokens.css */
:root {
  /* Surcharge des couleurs dominantes de Bootstrap */
  --bs-primary: #0F172A;              /* Bleu nuit Marvens Group */
  --bs-primary-rgb: 15, 23, 42;
  --bs-secondary: #64748B;            /* Ardoise neutre */
  --bs-success: #16A34A;              /* Validation / Succès */
  --bs-danger: #DC2626;               /* Erreur / Opération destructrice */
  --bs-warning: #CA8A04;              /* Avertissement */
  --bs-info: #0284C7;                 /* Information système */

  /* Surcharge des rayons de courbure */
  --bs-border-radius-sm: 4px;
  --bs-border-radius: 6px;            /* Rayon par défaut des inputs et boutons */
  --bs-border-radius-lg: 10px;        /* Rayon des cartes et modales */

  /* Typographie */
  --bs-body-font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
  --bs-body-font-size: 0.9375rem;     /* 15px */
  --bs-body-color: #1E293B;           /* Texte principal */
  --bs-body-bg: #F8FAFC;              /* Fond de page neutre clair */
}
```

---

## 4. Usage rigoureux du système de grille et conteneurs

### 4.1 Règles d'imbrication de la grille
Toute grille Bootstrap doit scrupuleusement respecter la hiérarchie :
`container` (ou `container-fluid`) $\rightarrow$ `row` $\rightarrow$ `col-*`.

```html
<!-- Exemple canonique d'agencement 12 colonnes responsive -->
<div class="container-fluid px-4">
  <div class="row g-4"> <!-- Gouttière calibrée à 24px (g-4) -->
    <!-- Bloc principal : 8 colonnes desktop, pleine largeur mobile -->
    <div class="col-12 col-lg-8">
      <div class="card h-100">
        <div class="card-body">
          <h2 class="card-title h5">Évolution des encaissements</h2>
          <!-- Graphique ou tableau -->
        </div>
      </div>
    </div>

    <!-- Bloc secondaire : 4 colonnes desktop, pleine largeur mobile -->
    <div class="col-12 col-lg-4">
      <div class="card h-100">
        <div class="card-body">
          <h2 class="card-title h5">Règles de caisse</h2>
          <!-- Détails -->
        </div>
      </div>
    </div>
  </div>
</div>
```

---

## 5. Composants Bootstrap autorisés, adaptés et proscrits

| Composant Bootstrap 5 | Statut Marvens | Directive d'utilisation |
|---|---|---|
| **Grid (`container`, `row`, `col`)** | **OBLIGATOIRE** | Base universelle de mise en page responsive. |
| **Modal (`modal`)** | **AUTORISÉ** | Idéal pour dialogues de confirmation et formulaires d'édition rapides. |
| **Offcanvas (`offcanvas`)** | **OBLIGATOIRE** | Base du menu mobile et des panneaux latéraux de filtres. |
| **Dropdown (`dropdown`)** | **AUTORISÉ** | Menus d'actions contextuelles et sélection de langue/profil. |
| **Alert (`alert`)** | **ADAPTÉ** | Doit être habillé avec les tokens de bordure et icônes Marvens. |
| **Card (`card`)** | **ADAPTÉ** | Utiliser avec les variables d'ombre et de rayon Marvens. |
| **Carousel (`carousel`)** | **INTERDIT** | Interdit dans les interfaces de gestion et SaaS B2B (nuisible à l'usabilité). |
| **Accordion (`accordion`)** | **AUTORISÉ** | Réservé aux FAQ et paramètres secondaires. Interdit pour les flux de saisie principaux. |

---

## 6. Intégration des formulaires et validation visuelle native

Bootstrap 5 fournit une gestion native des pseudo-classes de validation `:valid` et `:invalid`. Le système Marvens l'exploite via la classe `.was-validated` ou `.is-invalid` générée par le backend PHP :

```html
<form class="needs-validation" novalidate>
  <div class="mb-3">
    <label for="client_name" class="form-label">Nom du client ou raison sociale <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="client_name" name="client_name" required>
    <div class="invalid-feedback">
      Veuillez renseigner le nom du client avant de poursuivre.
    </div>
  </div>
</form>
```

---

## 7. Gestion des composants dynamiques (Modales, Offcanvas, Dropdowns)

### 7.1 Initialisation déclarative via les attributs Data (`data-bs-*`)
Privilégier la syntaxe déclarative HTML5 officielle de Bootstrap :
- Ouverture de modale : `<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">`.
- Fermeture accessible : `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>`.

### 7.2 Manipulation programmatique sécurisée en JavaScript Vanilla
```javascript
// Initialisation propre d'une modale Bootstrap via l'API JavaScript
const modalElement = document.getElementById('invoiceDetailModal');
if (modalElement) {
  const invoiceModal = new bootstrap.Modal(modalElement, {
    backdrop: 'static', // Empêche la fermeture accidentelle en cliquant dehors
    keyboard: true      // Fermeture par la touche Échap
  });

  // Déclenchement sur événement métier
  document.querySelector('.js-open-invoice').addEventListener('click', () => {
    invoiceModal.show();
  });
}
```

---

## 8. Gestion de l'iconographie : Bootstrap Icons vs Marvens Icons

- **Bootstrap Icons (SVG inline uniquement) :** L'usage de la police entière `bootstrap-icons.woff2` est déconseillé si seules 10 icônes sont utilisées dans l'écran.
- Privilégier l'injection des SVG vectoriels précis de la suite `03_BRAND_AND_VISUAL_IDENTITY/ICONOGRAPHY.md` pour garantir une empreinte réseau minimale et une cohérence géométrique totale.

---

## 9. Performance et élimination du surcoût de style (*CSS Bloat*)

- Si le fichier complet `bootstrap.min.css` est utilisé, s'assurer que la compression serveur Gzip/Brotli est active dans Apache (`.htaccess`), réduisant son empreinte sous les 32 Ko.
- Ne jamais charger deux versions concurrentes de Bootstrap (ex. v4 et v5 simultanément).

---

## 10. Anti-patterns d'utilisation de Bootstrap 5

- ❌ **Accumulation excessive de classes utilitaires dans le HTML (*Class Soup*) :** Écrire `<div class="d-flex flex-column justify-content-center align-items-start p-3 m-2 border rounded shadow-sm bg-white text-dark">` là où une classe BEM sémantique `.c-kpi-card` est 10 fois plus maintenable.
- ❌ **Surcharges agressives avec `!important` :** Déstabilise la cascade de styles et rend tout ajustement ultérieur complexe.
- ❌ **Omission des conteneurs de grille :** Poser des classes `.col-6` directement sous une balise sans balise `.row` parente génère des marges négatives incontrôlées et un défilement horizontal parasite.

---

## 11. Checklist d'intégration Bootstrap 5

| # | Règle Bootstrap 5 | Critère de validation | Statut |
|---|---|---|---|
| **01** | Version vérifiée | Utilisation de Bootstrap v5.3.x officiel minifié | [ ] |
| **02** | Autonomie locale | Fichiers CSS et JS hébergés localement sans dépendance CDN bloquante | [ ] |
| **03** | Remplacement des couleurs | `--bs-primary` et dérivés alignés sur les tokens de marque officiels | [ ] |
| **04** | Structure de grille saine | Toutes les balises `col-*` sont contenues dans un parent `row` | [ ] |
| **05** | Formulaires accessibles | Utilisation conjointe de `form-label` et `invalid-feedback` explicites | [ ] |
| **06** | Pas de jQuery | Zéro référence à jQuery ; utilisation stricte de Bootstrap 5 JS Vanilla | [ ] |
| **07** | Aucun carrousel | Aucun carrousel automatique présent sur les surfaces de gestion | [ ] |

---

## 12. Références officielles

- **Documentation officielle Bootstrap 5.3 :** <https://getbootstrap.com/docs/5.3/> *(Consulté le 31/10/2026)*.
- **Bootstrap 5 CSS Variables Guide :** <https://getbootstrap.com/docs/5.3/customize/css-variables/> *(Consulté le 31/10/2026)*.
- **Popper.js Documentation :** <https://popper.js.org/> *(Consulté le 31/10/2026)*.
