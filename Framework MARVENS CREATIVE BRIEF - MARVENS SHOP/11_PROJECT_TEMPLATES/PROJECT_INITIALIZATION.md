# PROJECT INITIALIZATION — Guide Opérationnel et Fiche de Lancement
## MARVENS CREATIVE BRIEF V1.0 · PHASE 11_PROJECT_TEMPLATES

> **Type de document :** Guide méthodologique et fiche de lancement projet (Template opérationnel)  
> **Statut du document :** Modèle vierge prêt à l'emploi  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [MASTER_CREATIVE_BRIEF.md](MASTER_CREATIVE_BRIEF.md) · [GOVERNANCE.md](../00_FRAMEWORK_CORE/GOVERNANCE.md) · [ANTIGRAVITY_INSTRUCTIONS.md](../09_AI_AGENTS_AND_PROMPTS/ANTIGRAVITY_INSTRUCTIONS.md)  
> **Mode d'emploi :** Utiliser ce document lors de la phase initiale de cadrage pour configurer le dossier de travail du produit, collecter les éléments patrimoniaux et cadrer le périmètre des agents d'intelligence artificielle.

---

## Sommaire

1. [Objectif et finalité de l'initialisation](#1-objectif-et-finalité-de-linitialisation)
2. [Prérequis indispensables avant lancement](#2-prérequis-indispensables-avant-lancement)
3. [Checklist de collecte documentaire et patrimoniale](#3-checklist-de-collecte-documentaire-et-patrimoniale)
4. [Procédure d'initialisation pas à pas (Workflow 5 étapes)](#4-procédure-dinitialisation-pas-à-pas-workflow-5-étapes)
5. [Structure recommandée du dossier projet](#5-structure-recommandée-du-dossier-projet)
6. [Fiche d'identification et fiche de contact du projet](#6-fiche-didentification-et-fiche-de-contact-du-projet)
7. [Matrice des rôles et responsabilités (RACI opérationnel)](#7-matrice-des-rôles-et-responsabilités-raci-opérationnel)
8. [Registre des ressources et accès techniques transmis](#8-registre-des-ressources-et-accès-techniques-transmis)
9. [Cadrage du contexte d'intervention des agents IA (Antigravity)](#9-cadrage-du-contexte-dintervention-des-agents-ia-antigravity)
10. [Plan de travail initial et macro-jalons](#10-plan-de-travail-initial-et-macro-jalons)
11. [Checklist de clôture de l'initialisation](#11-checklist-de-clôture-de-linitialisation)
12. [Modèle de compte rendu de réunion de cadrage (Kick-off Memo)](#12-modèle-de-compte-rendu-de-réunion-de-cadrage-kick-off-memo)

---

## 1. Objectif et finalité de l'initialisation

L'initialisation d'un projet dans le framework **MARVENS CREATIVE BRIEF V1.0** vise à éliminer l'écueil du « faux départ » : commencer à concevoir des écrans ou coder sans avoir réuni les éléments patrimoniaux fondamentaux (charte, accès, contraintes légales, rôles).

Elle garantit que :
- Les parties prenantes (Direction, Métier, Design, Dev) partagent la même vision des objectifs.
- Les agents IA disposent d'un contexte de travail hermétique, borné et sans ambiguïté.
- Les critères de réussite et d'arbitrage sont formellement consignés avant toute dépense créative.

---

## 2. Prérequis indispensables avant lancement

Avant d'engager la moindre session d'idéation ou de conception :
- [ ] Un responsable de projet ou Product Owner humain a été formellement désigné.
- [ ] Une enveloppe d'objectifs commerciaux ou d'usage a été exprimée.
- [ ] La présente fiche est ouverte pour consigner les échanges de cadrage.

---

## 3. Checklist de collecte documentaire et patrimoniale

| Catégorie d'éléments | Éléments attendus | Statut de collecte | Responsable de fourniture |
|---|---|---|---|
| **Identité de marque** | Logo vectoriel (.svg / .ai), charte graphique existante | `[REÇU / EN ATTENTE / INEXISTANT]` | `[Nom]` |
| **Documents métier** | Spécifications fonctionnelles, grille tarifaire, règles de gestion | `[REÇU / EN ATTENTE / INEXISTANT]` | `[Nom]` |
| **Données & Formulaires** | Modèles de factures actuels, exports Excel réels | `[REÇU / EN ATTENTE / INEXISTANT]` | `[Nom]` |
| **Contraintes légales** | Déclarations CNIL locales, conformité bancaire COBAC | `[REÇU / EN ATTENTE / NON APPLICABLE]` | `[Nom]` |
| **Accès techniques** | Environnement de staging, documentation API Mobile Money | `[REÇU / EN ATTENTE / EN COURS]` | `[Nom]` |

---

## 4. Procédure d'initialisation pas à pas (Workflow 5 étapes)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 5 ÉTAPES DU LANCEMENT DE PROJET                      │
│                                                                             │
│  [Étape 1 : Collecte & Audit] ──► Rassembler les documents et identifier    │
│                                   les inconnues critiques.                  │
│            │                                                                │
│            ▼                                                                │
│  [Étape 2 : Master Brief]    ──► Renseigner MASTER_CREATIVE_BRIEF.md        │
│            │                                                                │
│            ▼                                                                │
│  [Étape 3 : Modules Produit] ──► Sélectionner les fiches 07_PRODUCT_MODULES │
│            │                                                                │
│            ▼                                                                │
│  [Étape 4 : Cadrage IA]      ──► Configurer les rôles et limites des agents │
│            │                                                                │
│            ▼                                                                │
│  [Étape 5 : Revue Kick-off]  ──► Signature du visa de lancement formel      │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 5. Structure recommandée du dossier projet

Dans le dépôt du projet ou du sous-produit, instancier l'arborescence standardisée :

```text
projects/MARVENS SHOP/
├── 00_BRIEF/
│   ├── MASTER_CREATIVE_BRIEF.md      /* Brief maître renseigné */
│   └── PROJECT_INITIALIZATION.md     /* Présente fiche complétée */
├── 01_ART_DIRECTION/
│   └── ART_DIRECTION_SELECTION.md    /* Comparatif des 3 pistes */
├── 02_UX_UI_DESIGN/
│   └── UI_UX_BLUEPRINT.md            /* Spécifications fonctionnelles complètes */
└── 03_APPROVALS/
    └── DESIGN_APPROVAL.md            /* Visas formels de validation */
```

---

## 6. Fiche d'identification et fiche de contact du projet

- **Nom officiel du projet :** `[À RENSEIGNER]`
- **Entité porteuse :** `Marvens Group and Services SARL`
- **Date de la réunion de lancement (Kick-off) :** `2026-11-04`
- **Interlocuteurs clés :**
  - *Sponsor / Décideur final :* `[Nom, Titre, Email, Téléphone]`
  - *Product Owner / Métier :* `[Nom, Titre, Email, Téléphone]`
  - *Lead Développeur :* `[Nom, Titre, Email, Téléphone]`

---

## 7. Matrice des rôles et responsabilités (RACI opérationnel)

- **R (Responsible) :** Celui qui réalise la tâche.
- **A (Accountable) :** Celui qui valide et endosse la responsabilité finale (**Le Décideur Humain**).
- **C (Consulted) :** Ceux dont l'avis est sollicité avant décision.
- **I (Informed) :** Ceux qui sont informés de l'avancement.

| Activité / Jalon | Sponsor Métier | Product Owner | Designer IA | Lead Dev |
|---|:---:|:---:|:---:|:---:|
| Cadrage du Master Creative Brief | **A** | **R** | C | C |
| Exploration des 3 Directions Artistiques | C | C | **R** | I |
| Choix final de la Direction Artistique | **A** | C | I | C |
| Élaboration du Blueprint UI/UX | I | C | **R** | C |
| Recette et Approbation finale de design | **A** | **R** | I | C |

---

## 8. Registre des ressources et accès techniques transmis

| Ressource | Emplacement / Référence | Confidentialité | Date d'attribution |
|---|---|---|---|
| Charte graphique d'origine | `[Chemin dossier partagé]` | Interne | `2026-11-04` |
| Documentation API Paiement | `[URL ou PDF sécurisé]` | Confidentiel | `2026-11-04` |
| Maquettes historiques / V0 | `[Lien Figma ou exports]` | Interne | `2026-11-04` |

---

## 9. Cadrage du contexte d'intervention des agents IA (Antigravity)

Pour préserver la rigueur méthodologique, les règles d'engagement de l'IA sur ce projet sont :
1. **Périmètre autorisé :** Analyse documentaire, rédaction des spécifications, exploration de pistes créatives argumentées, structuration de parcours UX et génération de snippets de code conformes.
2. **Interdictions formelles :**
   - Interdiction formelle de déclarer un livrable comme « Validé » ou « Approuvé » de sa propre initiative.
   - Interdiction de faire des promesses de conformité juridique ou d'accessibilité sans audit matériel.
   - Interdiction d'ajouter des dépendances logicielles non validées par le Lead Dev.

---

## 10. Plan de travail initial et macro-jalons

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    ÉCHÉANCIER PRÉVISIONNEL DES JALONS                       │
├────┬───────────────────────────────┬──────────────────┬─────────────────────┤
│ #  │ JALON MÉTHODOLOGIQUE          │ DATE CIBLE       │ LIVRABLE ASSOCIÉ    │
├────┼───────────────────────────────┼──────────────────┼─────────────────────┤
│ J1 │ Validation du Master Brief    │ [Date]           │ MASTER_BRIEF.md     │
│ J2 │ Sélection de la DA retenue    │ [Date]           │ ART_DIRECTION.md    │
│ J3 │ Validation du Blueprint UX/UI │ [Date]           │ UI_UX_BLUEPRINT.md  │
│ J4 │ Revue finale & Design Approval│ [Date]           │ DESIGN_APPROVAL.md  │
└────┴───────────────────────────────┴──────────────────┴─────────────────────┘
```

---

## 11. Checklist de clôture de l'initialisation

| # | Condition de clôture du lancement | Statut |
|---|---|---|
| **01** | Le sponsor et le Product Owner sont formellement identifiés | [ ] |
| **02** | Les documents patrimoniaux disponibles ont été collectés | [ ] |
| **03** | Les inconnues majeures ont été cartographiées dans le Master Brief | [ ] |
| **04** | Les modules métier pertinents ont été activés | [ ] |
| **05** | Le calendrier prévisionnel des jalons est partagé et accepté | [ ] |

---

## 12. Modèle de compte rendu de réunion de cadrage (Kick-off Memo)

```text
PROJET : [Nom du Produit]
DATE : 2026-11-04
PARTICIPANTS : [Liste des présents]

1. DÉCISIONS STRUCTURANTES DU LANCEMENT :
   - [Décision 1 : Ex. Cadrage strict sur le MVP facturation pour la V1]
   - [Décision 2 : Ex. Stack technique confirmée sur PHP 8.3 Vanilla MVC]

2. POINTS DE BLOCAGE ET ACTIONS IMMÉDIATES :
   - [Action 1] : Responsable [Nom] - Échéance [Date]
   - [Action 2] : Responsable [Nom] - Échéance [Date]

3. PROCHAINE ÉTAPE :
   - Démarrage de l'exploration des 3 directions artistiques.
```


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Synthèse de cadrage pour ce volet
- **Projet :** MARVENS SHOP
- **Modules :** MODULE_ECOMMERCE, MODULE_PWA
- **Terminaux prioritaires :** desktop, tablet, mobile
- **Contexte usagers :** 4G, ordinateur, mobile, tablette, Francais
- **Précisions complémentaires :** [À DÉFINIR / À CONFIRMER]
<!-- MARVENS_PROJECT_CONTEXT:END -->
