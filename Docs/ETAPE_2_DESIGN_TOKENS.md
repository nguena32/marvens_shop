# ETAPE_2_DESIGN_TOKENS.md
# Système de Tokens de Design — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 2 — Conception UX/UI et validation des thèmes  
**Agent :** Agent UX/UI & Design System (Google Antigravity)  
**Sources de référence :** `themes/Theme fashion.zip` (`DESIGN.md`), `themes/Theme dashboard.zip` (`DESIGN.md`), Creative Brief (`06_DESIGN_SYSTEM/DESIGN_TOKENS.md`).

---

## 1. Philosophie des Tokens et Intégration Bootstrap 5

Les tokens de design définissent le contrat visuel de l'application. Conformément aux directives techniques du Creative Brief (`08_TECHNICAL_STANDARDS/BOOTSTRAP_GUIDELINES.md`) :
- Les tokens sont matérialisés par des **propriétés personnalisées CSS standard (`CSS Custom Properties` / variables `--ms-*`)**.
- Ces variables surchargent élégamment les variables natives de Bootstrap 5 (`--bs-*`) sans altérer son moteur de grille ni ses composants accessibles.
- Aucun processeur CSS lourd (Sass/SCSS) ou outil Node.js n'est imposé en production : le fichier CSS vanilla charge dynamiquement le jeu de variables du thème actif.

---

## 2. Tokens du Thème Boutique par Défaut (`Theme fashion`)

Issus directement de l'audit réel du fichier `themes/Theme fashion.zip` :

```css
:root[data-theme="fashion"] {
  /* ==========================================================================
     1. PALETTE CHROMATIQUE (Marvens Fashion - Ambre & Éditorial Chaud)
     ========================================================================== */
  --ms-color-primary: #8d4b00;              /* Couleur principale (Ambre/Caramel profond) */
  --ms-color-primary-hover: #b15f00;        /* Survol bouton principal */
  --ms-color-on-primary: #ffffff;           /* Texte sur couleur principale */
  --ms-color-primary-container: #ffdcc3;    /* Fond doux pour badges d'accentuation */
  --ms-color-on-primary-container: #2f1500;

  --ms-color-secondary: #565e74;            /* Gris bleuté d'appoint */
  --ms-color-on-secondary: #ffffff;
  
  --ms-color-surface: #fff8f5;              /* Fond général chaud et lumineux */
  --ms-color-surface-container: #ffffff;    /* Fond pur pour les cartes produits et modales */
  --ms-color-surface-subtle: #fdeade;       /* Arrière-plan des bandeaux et zones d'appel */
  
  --ms-color-text-main: #231a13;            /* Brun foncé encre pour titres et corps de texte */
  --ms-color-text-muted: #554336;           /* Texte secondaire et métadonnées */
  --ms-color-border: #dbc2b0;               /* Séparateurs et bordures douces */
  
  --ms-color-success: #1b873f;              /* Statuts validés, WhatsApp */
  --ms-color-whatsapp: #25D366;             /* Vert officiel WhatsApp */
  --ms-color-error: #ba1a1a;                /* Alertes, erreurs de validation */
  --ms-color-promo-badge: #ba1a1a;          /* Badge de réduction */

  /* ==========================================================================
     2. TYPOGRAPHIE ÉDITORIALE
     ========================================================================== */
  --ms-font-headline: 'Space Grotesk', system-ui, -apple-system, sans-serif;
  --ms-font-body: 'Inter', system-ui, -apple-system, sans-serif;

  --ms-font-size-h1: clamp(2rem, 4vw, 3rem);     /* 32px à 48px */
  --ms-font-size-h2: clamp(1.5rem, 3vw, 2.25rem); /* 24px à 36px */
  --ms-font-size-h3: 1.25rem;                     /* 20px */
  --ms-font-size-body: 1rem;                      /* 16px */
  --ms-font-size-sm: 0.875rem;                    /* 14px */
  --ms-font-size-xs: 0.75rem;                     /* 12px */

  --ms-line-height-tight: 1.2;
  --ms-line-height-normal: 1.5;

  /* ==========================================================================
     3. ESPACEMENTS & GRILLES (Facteur de base 4px/8px)
     ========================================================================== */
  --ms-space-xs: 0.25rem;   /* 4px */
  --ms-space-sm: 0.5rem;    /* 8px */
  --ms-space-md: 1rem;      /* 16px */
  --ms-space-lg: 1.5rem;    /* 24px */
  --ms-space-xl: 3rem;      /* 48px */

  /* ==========================================================================
     4. FORMES, BORDURES & ÉLÉVATION (Design épuré sans ombres lourdes)
     ========================================================================== */
  --ms-radius-sm: 4px;
  --ms-radius-md: 8px;
  --ms-radius-lg: 12px;
  --ms-radius-full: 9999px;

  --ms-border-width: 1px;
  --ms-shadow-card: 0 1px 3px rgba(35, 26, 19, 0.05);
  --ms-shadow-modal: 0 10px 25px -5px rgba(35, 26, 19, 0.15);

  /* Cibles tactiles mobiles */
  --ms-touch-target-min: 44px;
}
```

---

## 3. Tokens du Thème Administration (`Theme dashboard` — Swiss Editorial)

Issus directement de l'audit réel du fichier `themes/Theme dashboard.zip` :

```css
:root[data-theme="admin-swiss"] {
  /* ==========================================================================
     1. PALETTE CHROMATIQUE (Swiss Editorial Commerce - Noir & Rigueur)
     ========================================================================== */
  --ms-admin-primary: #000000;            /* Noir pur suisse pour la structure */
  --ms-admin-primary-hover: #303032;
  --ms-admin-on-primary: #ffffff;
  
  --ms-admin-accent: #904d00;             /* Ambre discret pour rappels Marvens */
  
  --ms-admin-surface: #FFFFFF;            /* Blanc pur */
  --ms-admin-surface-subtle: #f6f3f5;     /* Gris perle très léger pour la sidebar */
  --ms-admin-surface-card: #ffffff;
  
  --ms-admin-text-main: #1b1b1d;          /* Noir charbon pour une lisibilité parfaite */
  --ms-admin-text-muted: #76777d;         /* Gris moyen pour libellés secondaires */
  --ms-admin-border: #e4e2e4;             /* Filets fins de séparation */

  /* Badges de statuts de commandes conformes au CDC */
  --ms-status-pending: #f59e0b;           /* En attente (Ambre) */
  --ms-status-confirmed: #3b82f6;         /* Confirmée (Bleu) */
  --ms-status-payment-pending: #8b5cf6;   /* Paiement en attente (Violet) */
  --ms-status-paid: #10b981;              /* Payée (Émeraude) */
  --ms-status-preparing: #06b6d4;         /* En préparation (Cyan) */
  --ms-status-shipped: #6366f1;           /* Expédiée (Indigo) */
  --ms-status-delivered: #059669;         /* Livrée (Vert foncé) */
  --ms-status-cancelled: #ef4444;         /* Annulée (Rouge) */

  /* ==========================================================================
     2. TYPOGRAPHIE ADMINISTRATIVE (100% Inter)
     ========================================================================== */
  --ms-admin-font: 'Inter', system-ui, -apple-system, sans-serif;
  --ms-admin-font-weight-regular: 400;
  --ms-admin-font-weight-medium: 500;
  --ms-admin-font-weight-semibold: 600;
  --ms-admin-font-weight-bold: 700;

  /* ==========================================================================
     3. FORMES & BORDURES SUISSES (Angles droits adoucis)
     ========================================================================== */
  --ms-admin-radius: 4px;                 /* Rigueur géométrique sans arrondis excessifs */
  --ms-admin-border-width: 1px;
}
```

---

## 4. Breakpoints et Comportement Multi-Écrans

Conformément aux normes du Creative Brief (`08_TECHNICAL_STANDARDS/FRONTEND_STANDARDS.md`), les points de rupture s'alignent sur Bootstrap 5 pour une robustesse multi-supports :

| Breakpoint | Largeur | Comportement Storefront (Public) | Comportement Dashboard (Admin) |
|---|---|---|---|
| **xs** | `< 576px` (320-360px) | Grille catalogue 2 colonnes compactes, navigation burger, bouton WhatsApp pleine largeur. | Sidebar masquée (menu tiroir Offcanvas), tableaux avec défilement horizontal fluide. |
| **sm** | `≥ 576px` | Grille catalogue 2 colonnes aérées, panier en dialogue adapté. | Tableaux de commandes complets. |
| **md** | `≥ 768px` | Grille 3 colonnes, fiche produit avec galerie à gauche et achat à droite. | Sidebar dépliée permanente possible, cartes KPI en 2 colonnes. |
| **lg** | `≥ 992px` | Grille 4 colonnes, navigation horizontale déroulante. | Sidebar fixe latérale 260px, cartes KPI en 4 colonnes. |
| **xl / xxl** | `≥ 1200px` | Conteneur centré max 1280px pour préserver la densité visuelle. | Vue tableau ultra détaillée, multi-fenêtrage de traitement. |
