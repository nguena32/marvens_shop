# FRONTEND STANDARDS — Conventions et Normes d'Ingénierie Frontend
## MARVENS CREATIVE BRIEF V1.0 · PHASE 08_TECHNICAL_STANDARDS

> **Document :** Standards d'implémentation HTML5, CSS3, JavaScript Vanilla et intégration UI  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Périmètre technique :** HTML5 sémantique, CSS3 moderne (Variables, Flexbox, Grid), JavaScript ECMAScript 2022+ Vanilla, Bootstrap 5.3  
> **Documents amont associés :** [UI_GUIDELINES.md](../05_UI_DESIGN/UI_GUIDELINES.md) · [COMPONENT_DESIGN.md](../05_UI_DESIGN/COMPONENT_DESIGN.md) · [CSS_ARCHITECTURE.md](../06_DESIGN_SYSTEM/CSS_ARCHITECTURE.md) · [DESIGN_TOKENS.md](../06_DESIGN_SYSTEM/DESIGN_TOKENS.md)  
> **Documents pairs :** [PHP_MVC_STANDARDS.md](PHP_MVC_STANDARDS.md) · [BOOTSTRAP_GUIDELINES.md](BOOTSTRAP_GUIDELINES.md) · [PERFORMANCE.md](PERFORMANCE.md) · [SECURITY.md](SECURITY.md) · [ACCESSIBILITY_IMPLEMENTATION.md](ACCESSIBILITY_IMPLEMENTATION.md)

---

## Sommaire

1. [Périmètre et principes fondamentaux](#1-périmètre-et-principes-fondamentaux)
2. [Organisation des répertoires et architecture des ressources](#2-organisation-des-répertoires-et-architecture-des-ressources)
3. [Standards HTML5 : Sémantique, structure et robustesse](#3-standards-html5--sémantique-structure-et-robustesse)
4. [Standards CSS3 : Tokens, méthodologie BEM et spécificité](#4-standards-css3--tokens-méthodologie-bem-et-spécificité)
5. [Standards JavaScript Vanilla : Modularité, événements et asynchronisme](#5-standards-javascript-vanilla--modularité-événements-et-asynchronisme)
6. [Contrat d'échange Frontend / Backend (JSON, CSRF, Erreurs)](#6-contrat-déchange-frontend--backend-json-csrf-erreurs)
7. [Gestion des médias, icônes SVG et typographies](#7-gestion-des-médias-icônes-svg-et-typographies)
8. [Résilience réseau et expérience hors-ligne dégradée](#8-résilience-réseau-et-expérience-hors-ligne-dégradée)
9. [Anti-patterns frontend formellement proscrits](#9-anti-patterns-frontend-formellement-proscrits)
10. [Checklist de conformité et critères d'acceptation](#10-checklist-de-conformité-et-critères-dacceptation)
11. [Références officielles](#11-références-officielles)

---

## 1. Périmètre et principes fondamentaux

Dans le cadre de **MARVENS CREATIVE BRIEF V1.0**, le frontend n'est pas une simple coquille graphique : c'est l'interface directe avec les opérateurs de gestion, les commerçants et les décideurs. L'ingénierie frontend doit garantir un fonctionnement irréprochable sur les terminaux réels d'Afrique subsaharienne (écrans modestes, PC reconditionnés, connexions fluctuantes 3G/4G) sans imposer de chaîne d'outillage Node.js lourde en production.

### Principes cardinaux :
- **Séparation stricte des responsabilités :** HTML5 porte le sens sémantique et la structure du document, CSS3 prend en charge la présentation et la mise en page, JavaScript orchestre les comportements interactifs et la synchronisation avec le serveur.
- **Amélioration progressive (*Progressive Enhancement*) :** Le contenu de base et les formulaires doivent demeurer exploitables même si le script client est retardé ou désactivé.
- **Zéro dépendance non justifiée :** Bannir les frameworks SPA démesurés (React, Vue, Angular) pour les applications de gestion classiques servies en PHP MVC. Le JavaScript Vanilla moderne (ES6+) couvre nativement tous les besoins d'interaction dynamique avec une légèreté et une rapidité incomparables.
- **Zéro logique métier côté client :** Le navigateur est un environnement non sécurisé sous le contrôle de l'utilisateur. Toute règle de calcul critique (prix, TVA CEMAC, droits d'accès) doit être validée de manière autoritaire par le backend PHP.

---

## 2. Organisation des répertoires et architecture des ressources

Dans l'environnement de référence (compatible hébergement mutualisé cPanel et dossier web racine `public/` ou `public_html/`), la structure des assets statiques est strictement hiérarchisée :

```text
public/assets/
├── css/
│   ├── vendor/
│   │   └── bootstrap.min.css         /* Version 5.3.x officielle minifiée */
│   ├── tokens.css                    /* Variables CSS issues de 06_DESIGN_SYSTEM */
│   ├── base.css                      /* Normalisation, styles typographiques fondamentaux */
│   ├── components.css                /* Composants spécifiques Marvens (BEM) */
│   └── main.css                      /* Fichier d'assemblage principal / layout */
├── js/
│   ├── vendor/
│   │   └── bootstrap.bundle.min.js   /* Bootstrap JS + Popper officiel */
│   ├── modules/
│   │   ├── api.js                    /* Wrapper Fetch, gestion CSRF et erreurs réseau */
│   │   ├── modal.js                  /* Contrôle accessible des dialogues modaux */
│   │   ├── toast.js                  /* Gestionnaire des notifications flottantes */
│   │   └── validation.js             /* Validation ergonomique des formulaires */
│   └── app.js                        /* Initialisation et routage des scripts par page */
├── fonts/                            /* Polices auto-hébergées format WOFF2 (zéro Google Fonts externe) */
├── icons/                            /* Symboles SVG optimisés Marvens Icons */
└── img/                              /* Logos, illustrations compressées WebP/SVG */
```

---

## 3. Standards HTML5 : Sémantique, structure et robustesse

### 3.1 Déclaration de document et métadonnées
- Déclaration stricte `<!DOCTYPE html>` en tout début de flux.
- Attribut de langue dynamique obligatoire sur la balise racine : `<html lang="fr">`.
- Métadonnée viewport impérative pour le rendu multi-terminaux :  
  `<meta name="viewport" content="width=device-width, initial-scale=1.0">`.
- Définition du jeu de caractères universel : `<meta charset="UTF-8">`.

### 3.2 Balisage sémantique et zones repères (*Landmarks*)
Interdiction d'utiliser une imbrication abusive de balises `<div>` anonymes (*divite*) là où des éléments sémantiques natifs fournissent un repérage immédiat aux technologies d'assistance :

```html
<!-- Architecture sémantique canonique d'une vue Marvens -->
<header class="app-header" role="banner">
  <a href="#main-content" class="skip-link">Aller au contenu principal</a>
  <div class="header-brand"><!-- Logo / Titre produit --></div>
  <nav class="header-nav" aria-label="Navigation supérieure"><!-- Menu utilisateur --></nav>
</header>

<div class="app-layout">
  <aside class="app-sidebar" aria-label="Navigation principale">
    <nav class="sidebar-nav"><!-- Liens des modules ERP/SaaS --></nav>
  </aside>

  <main id="main-content" class="app-main" tabindex="-1">
    <header class="page-header">
      <nav aria-label="Fil d'Ariane">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Tableau de bord</a></li>
          <li class="breadcrumb-item active" aria-current="page">Facturation</li>
        </ol>
      </nav>
      <h1 class="page-title">Gestion des Factures Clients</h1>
    </header>

    <section class="page-section" aria-labelledby="section-stats-title">
      <h2 id="section-stats-title" class="visually-hidden">Indicateurs clés</h2>
      <!-- Widgets de métriques -->
    </section>
  </main>
</div>

<footer class="app-footer" role="contentinfo">
  <p>&copy; 2026 Marvens Group. Tous droits réservés.</p>
</footer>
```

### 3.3 Règle d'or des éléments interactifs
- **`<button>` vs `<a>` :**
  - Un élément qui déclenche une action sur la page, ouvre une modale, ou soumet des données **doit impérativement être un `<button type="button">` ou `<button type="submit">`**.
  - Un élément qui modifie l'URL et navigue vers une nouvelle page ou ancre **doit impérativement être un `<a href="...">`**.
  - Règle absolue : Ne jamais écrire `<a href="javascript:void(0)" onclick="...">` ni `<div onclick="...">`.

---

## 4. Standards CSS3 : Tokens, méthodologie BEM et spécificité

### 4.1 Utilisation impérative des CSS Custom Properties (Tokens)
Aucune couleur codée en dur (`#0F172A`) ni dimension d'espacement arbitraire (`17px`) ne doit figurer dans les sélecteurs de style. Les règles doivent systématiquement consommer les tokens définis dans `06_DESIGN_SYSTEM/DESIGN_TOKENS.md` :

```css
/* Utilisation correcte des variables de tokens */
.c-card {
  background-color: var(--color-surface-raised, #FFFFFF);
  border: var(--border-width-default, 1px) solid var(--color-border-subtle, #E2E8F0);
  border-radius: var(--radius-lg, 10px);
  padding: var(--space-5, 1rem);
  box-shadow: var(--shadow-sm);
}
```

### 4.2 Convention de nommage BEM (Block Element Modifier)
Pour les composants propriétaires Marvens, adopter la méthodologie BEM préfixée :
- `c-` pour un composant (`.c-badge`, `.c-table`).
- `u-` pour un utilitaire ponctuel (`.u-text-right`, `.u-hidden-mobile`).
- `is-` ou `has-` pour un état système (`.is-active`, `.is-loading`, `.has-error`).

```css
/* Bloc */
.c-kpi-card { display: flex; flex-direction: column; }

/* Éléments */
.c-kpi-card__header { display: flex; justify-content: space-between; margin-bottom: var(--space-3); }
.c-kpi-card__title { font-size: var(--font-size-sm); color: var(--color-text-muted); }
.c-kpi-card__value { font-size: var(--font-size-2xl); font-weight: 700; }

/* Modificateurs */
.c-kpi-card--positive .c-kpi-card__trend { color: var(--color-success); }
.c-kpi-card--negative .c-kpi-card__trend { color: var(--color-danger); }
```

### 4.3 Maîtrise de la spécificité CSS
- Proscription absolue de `!important` dans les styles de composants (réservé exclusivement aux classes d'accessibilité utilitaires comme `.visually-hidden`).
- Éviter d'imbriquer les sélecteurs à plus de 2 niveaux de profondeur.

---

## 5. Standards JavaScript Vanilla : Modularité, événements et asynchronisme

### 5.1 Organisation modulaire et portée isolée
Tous les scripts sont encapsulés sous forme de modules JavaScript natifs (`ES Modules` avec `type="module"`) ou de fonctions auto-exécutées (IIFE) pour bannir rigoureusement la pollution de l'espace global `window`.

```javascript
/**
 * Module de gestion des requêtes API asynchrones
 * @module api
 */
export const ApiClient = (() => {
  'use strict';

  /**
   * Envoi d'une requête HTTP sécurisée avec token CSRF
   * @param {string} url 
   * @param {Object} options 
   * @returns {Promise<any>}
   */
  async function request(url, options = {}) {
    const defaultHeaders = {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    };

    // Injection automatique du jeton CSRF stocké dans la balise meta
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken && ['POST', 'PUT', 'DELETE', 'PATCH'].includes(options.method?.toUpperCase())) {
      defaultHeaders['X-CSRF-Token'] = csrfToken;
    }

    const config = {
      ...options,
      headers: {
        ...defaultHeaders,
        ...options.headers
      }
    };

    try {
      const response = await fetch(url, config);

      // Traitement des redirections d'authentification (session expirée)
      if (response.status === 401) {
        window.location.href = '/login?expired=1';
        return;
      }

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || `Erreur HTTP : ${response.status}`);
      }

      return data;
    } catch (error) {
      console.error('[ApiClient Error]:', error);
      throw error;
    }
  }

  return {
    get: (url) => request(url, { method: 'GET' }),
    post: (url, body) => request(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body)
    })
  };
})();
```

### 5.2 Prévention des soumissions doubles et états de chargement
Tout formulaire géré en JavaScript doit désactiver son bouton de validation immédiatement après le premier clic pour empêcher les doubles encaissements ou les créations en doublon :

```javascript
document.addEventListener('submit', (event) => {
  const form = event.target;
  if (!form.matches('.js-async-form')) return;

  const submitBtn = form.querySelector('[type="submit"]');
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.classList.add('is-loading');
    submitBtn.setAttribute('data-original-text', submitBtn.innerHTML);
    submitBtn.innerHTML = `
      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
      Traitement en cours...
    `;
  }
});
```

---

## 6. Contrat d'échange Frontend / Backend (JSON, CSRF, Erreurs)

Pour tout échange asynchrone (AJAX / Fetch), le format de payload JSON standardisé est obligatoire :

### 6.1 Format canonique de réponse JSON
```json
{
  "success": true,
  "data": {
    "invoice_id": 849,
    "amount_formatted": "250 000 FCFA",
    "status": "paid"
  },
  "message": "Paiement Mobile Money validé avec succès.",
  "errors": null
}
```

En cas d'erreur de validation (Code HTTP 422) :
```json
{
  "success": false,
  "data": null,
  "message": "Veuillez corriger les champs erronés.",
  "errors": {
    "phone_number": "Le numéro de téléphone Orange Money est invalide (9 chiffres requis).",
    "amount": "Le montant minimal de transaction est de 500 FCFA."
  }
}
```

---

## 7. Gestion des médias, icônes SVG et typographies

- **Icônes vectorielles SVG :** Privilégier les SVG injectés inline ou réunis dans un sprite SVG unique chargé localement. Proscription formelle de charger des packs de polices d'icônes tiers volumineux (> 1 Mo) qui bloquent le rendu initial.
- **Images optimisées :** Toutes les illustrations et photos doivent être servies au format moderne `WebP` avec alternative `JPG/PNG`, et pourvues des attributs explicites `width`, `height` et `loading="lazy"` pour éliminer les décalages de mise en page (*Cumulative Layout Shift*).
- **Polices auto-hébergées :** Les polices de la marque (Inter, Plus Jakarta Sans) sont hébergées sur le serveur cPanel au format `.woff2` avec la règle CSS `font-display: swap;`. Aucun appel à Google Fonts externe n'est autorisé en production afin de garantir la confidentialité et la vitesse hors-ligne.

---

## 8. Résilience réseau et expérience hors-ligne dégradée

Face aux coupures intermittentes de bande passante en Afrique centrale :
1. **Écoute de l'état réseau :** Les événements `window.addEventListener('online')` et `'offline'` déclenchent l'affichage d'un bandeau persistant en tête de vue : `Connexion Internet interrompue. Mode hors-ligne actif.`
2. **Sauvegarde locale des formulaires (*Local Cache*) :** Les saisies complexes dans les formulaires sont stockées au fil de l'eau dans `sessionStorage` ou `localStorage` pour être restituées sans perte si la session se déconnecte.

---

## 9. Anti-patterns frontend formellement proscrits

- ❌ **Suppression du contour de focus (`outline: none` ou `outline: 0`) :** Détruit la navigabilité au clavier pour les usagers en situation de handicap.
- ❌ **Variables JavaScript globales (`var user_id = 12`) :** Crée des conflits de nommage et expose des données sensibles dans la console.
- ❌ **Styles CSS inline dans le balisage (`<div style="...">`) :** Bloque la mise en cache, alourdit le DOM et empêche l'application des tokens sémantiques.
- ❌ **Injection directe de variables non nettoyées dans le DOM via `innerHTML` :** Crée une faille de sécurité XSS critique côté client.
- ❌ **Blocage de l'interaction sans retour :** Laisser l'utilisateur sans indicateur visuel de chargement lors d'un traitement supérieur à 300 ms.

---

## 10. Checklist de conformité et critères d'acceptation

| # | Règle frontend à valider | Contrôle d'ingénierie | Statut |
|---|---|---|---|
| **01** | Balisage sémantique | Utilisation correcte de `<header>`, `<nav>`, `<main>`, `<section>`, `<footer>` | [ ] |
| **02** | Éléments interactifs | `<button>` pour les actions, `<a>` exclusivement pour les liens de navigation | [ ] |
| **03** | Consommation des tokens | 100 % des couleurs et espacements issus des CSS Custom Properties officielles | [ ] |
| **04** | Protection CSRF | Présence de la balise `<meta name="csrf-token">` transmise dans les en-têtes Fetch | [ ] |
| **05** | Double clic neutralisé | Boutons de soumission désactivés avec affichage d'un spinner dès le clic | [ ] |
| **06** | Focus clavier intact | Anneau de focus visible et contrasté sur tous les éléments actifs | [ ] |
| **07** | Indépendance réseau | Polices et icônes auto-hébergées en local sans dépendance externe bloquante | [ ] |
| **08** | Console propre | Zéro avertissement ou erreur d'exécution dans la console de développement | [ ] |

---

## 11. Références officielles

- **W3C HTML5 Specification :** <https://html.spec.whatwg.org/> *(Consulté le 31/10/2026)*.
- **W3C CSS Custom Properties for Cascading Variables Module Level 1 :** <https://www.w3.org/TR/css-variables-1/> *(Consulté le 31/10/2026)*.
- **MDN Web Docs (Vanilla JavaScript ES6+) :** <https://developer.mozilla.org/fr/docs/Web/JavaScript> *(Consulté le 31/10/2026)*.
- **Fetch API Living Standard :** <https://fetch.spec.whatwg.org/> *(Consulté le 31/10/2026)*.
