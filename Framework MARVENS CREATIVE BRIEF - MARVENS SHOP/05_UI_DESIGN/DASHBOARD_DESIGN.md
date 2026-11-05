# DASHBOARD DESIGN — Conception des Tableaux de Bord et Visualisation de Données
## MARVENS CREATIVE BRIEF V1.0 · PHASE 05_UI_DESIGN

> **Document :** Référentiel de conception ergonomique des tableaux de bord, indicateurs de pilotage (KPIs) et visualisation décisionnelle  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [UI_GUIDELINES.md](UI_GUIDELINES.md) · [LAYOUT_SYSTEM.md](LAYOUT_SYSTEM.md) · [FORMS_AND_TABLES.md](FORMS_AND_TABLES.md) · [COLOR_SYSTEM.md](../03_BRAND_AND_VISUAL_IDENTITY/COLOR_SYSTEM.md) · [INFORMATION_ARCHITECTURE.md](../04_UX_DESIGN/INFORMATION_ARCHITECTURE.md)

---

## Sommaire

1. [Rôle, finalité et typologie des tableaux de bord](#1-rôle-finalité-et-typologie-des-tableaux-de-bord)
2. [Cadrage des besoins métier et questions décisionnelles](#2-cadrage-des-besoins-métier-et-questions-décisionnelles)
3. [Architecture de l'information d'un tableau de bord](#3-architecture-de-linformation-dun-tableau-de-bord)
4. [Anatomie d'une carte d'indicateur clé (KPI Card)](#4-anatomie-dune-carte-dindicateur-clé-kpi-card)
5. [Visualisation de données : Choisir la représentation juste](#5-visualisation-de-données-choisir-la-représentation-juste)
6. [Système de filtrage temporel et périmètres d'analyse](#6-système-de-filtrage-temporel-et-périmètres-danalyse)
7. [Gestion des alertes opérationnelles et flux d'action immédiate](#7-gestion-des-alertes-opérationnelles-et-flux-daction-immédiate)
8. [Matrice des états d'un tableau de bord (Chargement, Données partielles, Absence de données)](#8-matrice-des-états-dun-tableau-de-bord-chargement-données-partielles-absence-de-données)
9. [Personnalisation raisonnée et gouvernance des rôles](#9-personnalisation-raisonnée-et-gouvernance-des-rôles)
10. [Adaptation responsive et lisibilité sur terminaux mobiles](#10-adaptation-responsive-et-lisibilité-sur-terminaux-mobiles)
11. [Performance d'affichage et fraîcheur des données](#11-performance-daffichage-et-fraîcheur-des-données)
12. [Accessibilité et honnêteté intellectuelle des graphiques](#12-accessibilité-et-honnêteté-intellectuelle-des-graphiques)
13. [Anti-patterns stricts de dashboard design](#13-anti-patterns-stricts-de-dashboard-design)
14. [Checklist de validation d'un dashboard](#14-checklist-de-validation-dun-dashboard)

---

## 1. Rôle, finalité et typologie des tableaux de bord

Dans la doctrine **MARVENS CREATIVE BRIEF V1.0**, un tableau de bord (*Dashboard*) n'est ni une vitrine décorative encombrée de graphiques futiles, ni un écran d'accueil générique. **C'est un instrument d'aide à la décision opérationnelle et stratégique.**

### Distinction fondamentale des surfaces :
- **Tableau de bord (*Dashboard*) :** Vue synthétique temps réel ou quasi-réel orientée décision immédiate : *"Où en sommes-nous aujourd'hui et quelles actions dois-je engager sans attendre ?"*
- **Rapport analytique (*Report*) :** Vue exhaustive rétrospective avec tableaux denses et historiques longs destinés à l'audit financier ou comptable.
- **Espace de travail opérationnel (*Workspace*) :** Écran centré sur la production continue (ex. terminal de saisie de caisse POS, liste des factures à traiter).

---

## 2. Cadrage des besoins métier et questions décisionnelles

Avant de disposer le moindre graphique, le concepteur UI doit impérativement identifier **les trois questions fondamentales** auxquelles l'écran doit répondre pour l'usager cible :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LE TRIPTYQUE DÉCISIONNEL DU DASHBOARD                 │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. ÉTAT DE SANTÉ         │ Est-ce que les activités tournent normalement ? │
│    (Status Quo)          │ Chiffre d'affaires, volume de ventes, marge.     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. DÉTECTION D'ANOMALIES │ Qu'est-ce qui nécessite mon attention urgente ?  │
│    (Alerts & Friction)   │ Factures impayées, ruptures de stock, retards.   │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. PASSAGE À L'ACTION    │ Quelle action concrète puis-je lancer d'ici ?    │
│    (Next Action)         │ Relancer un client, réapprovisionner, approuver. │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Architecture de l'information d'un tableau de bord

Le layout canonique d'un dashboard Marvens suit le principe de la **pyramide inversée** (du plus synthétique au plus granulaire) :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. BANDEAU DE COMMANDE : Titre, Sélecteur de période, Bouton Actualiser     │
├─────────────────────────────────────────────────────────────────────────────┤
│ 2. BANDEAU DES INDICATEURS CLÉS (KPI Cards - 3 à 4 cartes majeures)        │
│ [ Chiffre d'affaires ] [ Ventes du jour ] [ Créances en attente ] [ Alertes]│
├──────────────────────────────────────────┬──────────────────────────────────┤
│ 3. ANALYSE DES TENDANCES (Graphique 2/3) │ 4. RÉPARTITIONS (Graphique 1/3)  │
│ Évolution des encaissements sur 30 jours │ Modes de paiement (MoMo vs Cash) │
├──────────────────────────────────────────┴──────────────────────────────────┤
│ 5. ACTIVITÉS RÉCENTES & ACTIONS (Tableau ou liste d'opérations à valider)   │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Anatomie d'une carte d'indicateur clé (KPI Card)

Chaque indicateur doit fournir un contexte absolu pour éviter toute mauvaise interprétation :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ TITRE DE L'INDICATEUR (Ex. Chiffre d'affaires brut)         [Icône / Aide ℹ]│
│                                                                             │
│ 12 450 000 FCFA                                                             │
│                                                                             │
│ [↑ +14.2%] par rapport au mois précédent (vs 10 900 000 FCFA)               │
└─────────────────────────────────────────────────────────────────────────────┘
```

### Règles de composition d'un KPI :
1. **Nom sans équivoque :** Utiliser des termes précis (ex. `Chiffre d'affaires encaissé` plutôt que `Revenus`).
2. **Valeur brute dominante :** Typographie imposante (24px à 28px bold), avec unité monétaire ou symbole indissociable (`FCFA`).
3. **Indicateur de tendance contextuel :** Pourcentage d'évolution accompagné d'une flèche directionnelle (`↑` ou `↓`) et du rappel explicite de la base de comparaison temporelle (`par rapport au mois précédent`).
4. **Code couleur sémantique maîtrisé :** Une hausse n'est pas toujours verte (ex. une hausse des impayés ou des ruptures de stock doit être affichée en **rouge alerte**).

---

## 5. Visualisation de données : Choisir la représentation juste

Le choix du graphique ne dépend pas de l'esthétique, mais de la nature mathématique de la question posée :

| Type de question | Graphique recommandé | Graphique formellement proscrit | Justification ergonomique |
|---|---|---|---|
| **Évolution dans le temps** | Courbe continue (*Line Chart*) ou aires sobres | Graphique en radar ou bulles 3D | La ligne continue traduit immédiatement la dynamique temporelle. |
| **Comparaison discrète** | Barres horizontales ou verticales (*Bar Chart*) | Nuage de mots ou camembert éclaté | L'œil humain compare avec précision des longueurs, pas des angles. |
| **Part d'un ensemble** | Anneau sobre (*Donut Chart*, max 4 segments) | Camembert 3D à 10 tranches | Les parts trop petites deviennent illisibles et s'empilent. |
| **Détail opérationnel** | Tableau de données condensé | Multiples jauges circulaires | Le tableau permet de lire des chiffres exacts et d'agir immédiatement. |

### Directives graphiques :
- **Axes honnêtes :** Pour les diagrammes en barres comparatifs, l'axe vertical doit impérativement débuter à **zéro (0)** pour éviter de fausser visuellement l'ampleur des écarts.
- **Sobriété colorimétrique :** Utiliser une seule teinte maîtresse (ex. le bleu primaire de la marque) avec des modulations de saturation, plutôt qu'un feu d'artifice de 7 couleurs non coordonnées.

---

## 6. Système de filtrage temporel et périmètres d'analyse

Un chiffre sans période définie est une source d'erreur grave :
- **Sélecteur de période unifié :** Ancré en haut à droite du tableau de bord. Propose des filtres rapides prédéfinis (`Aujourd'hui`, `7 derniers jours`, `Ce mois-ci`, `Année en cours`) complétés d'un sélecteur personnalisé d'intervalle de dates.
- **Persistance et visibilité :** La période active doit être explicitement visible en permanence sous le titre de chaque carte (ex. `Données du 01 au 31 oct. 2026`).

---

## 7. Gestion des alertes opérationnelles et flux d'action immédiate

Le tableau de bord ne doit pas se limiter au constat ; il doit déclencher la résolution :
- **Encadré d'alertes prioritaires :** Positionné en partie supérieure lorsque des événements critiques surviennent (ex. `3 factures Orange Money en anomalie de rapprochement`).
- Chaque alerte comporte une étiquette de sévérité, une explication brève et un bouton d'action directe (`Rapprocher immédiatement`).

---

## 8. Matrice des états d'un tableau de bord

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ LES 5 ÉTATS D'UN TABLEAU DE BORD                                            │
├─────────────────┬───────────────────────────────────────────────────────────┤
│ 1. NORMAL       │ Tous les widgets sont alimentés avec données fraîches.    │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 2. CHARGEMENT   │ Cartes et graphiques affichent des silhouettes skeletons. │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 3. ZÉRO DONNÉE  │ Période sans activité : message neutre invitant à l'action│
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 4. PARTIEL      │ Connectivité réseau faible : données en cache signalées.  │
├─────────────────┼───────────────────────────────────────────────────────────┤
│ 5. ERREUR       │ Échec API/Base : bandeau d'alerte avec bouton "Actualiser"│
└─────────────────┴───────────────────────────────────────────────────────────┘
```

---

## 9. Personnalisation raisonnée et gouvernance des rôles

- **Affichage conditionné par le rôle (RBAC) :**
  - *Directeur Général / Gérant :* Vision financière macro (CA, marges, créances, trésorerie).
  - *Responsable Commercial :* Objectifs de vente, performance par vendeur, top clients.
  - *Caissier / Opérateur :* Encaissements du jour, écarts de caisse, nombre de tickets émis.
- Ne pas autoriser une personnalisation désordonnée de tous les widgets qui compliquerait la maintenance et l'assistance technique.

---

## 10. Adaptation responsive et lisibilité sur terminaux mobiles

Sur écran de smartphone (< 768px) :
- Les 4 cartes KPIs s'empilent en un carrousel horizontal tactile à défilement doux ou en 2 colonnes compactes.
- Les graphiques complexes simplifient leur affichage (masquage des grilles de fond secondaires, infobulles tactiles déclenchées au toucher).
- L'ordre visuel priorise les alertes et les KPIs clés avant tout graphique d'évolution.

---

## 11. Performance d'affichage et fraîcheur des données

Dans l'environnement technique visé (PHP 8.3 Vanilla MVC / MySQL 8 sur hébergement cPanel) :
- **Indicateur de fraîcheur :** Mention discrète en en-tête : `Mis à jour il y a 5 min · [Rafraîchir]`.
- **Agrégation optimisée :** Les requêtes SQL de calcul des KPIs doivent être pré-agrégées ou mises en cache temporaire afin de garantir un affichage du tableau de bord sous la barre des **500 ms**, y compris sur connexion internet 3G instable.

---

## 12. Accessibilité et honnêteté intellectuelle des graphiques

- **Alternative textuelle et tabulaire :** Chaque graphique complexe doit proposer un bouton d'accès direct à son équivalent en tableau de données textuel (`Voir les données en tableau`) pour les utilisateurs naviguant avec un lecteur d'écran ou déficients visuels.
- **Lisibilité sans la couleur :** Les courbes multiples doivent se distinguer à la fois par leur couleur et par des motifs de tirets distincts (`solide`, `pointillés`, `tirets`) ou des marqueurs de points (`cercles`, `carrés`).

---

## 13. Anti-patterns stricts de dashboard design

Pratiques formellement proscrites :
- ❌ **Accumulation boulimique d'indicateurs :** Plus de 6 KPIs majeurs sur un même écran crée une surcharge cognitive stérile.
- ❌ **Graphiques tridimensionnels (3D) :** Les effets de perspective déforment la réalité des proportions mathématiques.
- ❌ **Indicateurs orphelins sans repère comparatif :** Afficher un chiffre brut sans préciser s'il est satisfaisant, médiocre ou exceptionnel par rapport à un objectif ou une période passée.
- ❌ **Données fabriquées non contextualisées :** Inventer des faux graphiques sans logique métier.

---

## 14. Checklist de validation d'un dashboard

Avant validation de la maquette ou de l'écran :

| # | Question de contrôle de pilotage | Critère exigé | Statut |
|---|---|---|---|
| **01** | Réponse aux questions clés | L'écran permet de comprendre l'état de l'activité en moins de 10 secondes | [ ] |
| **02** | Contexte des KPIs | Chaque métrique comporte son unité, sa période et sa tendance comparée | [ ] |
| **03** | Honnêteté des axes | Les graphiques comparatifs débutent à zéro sans déformation trompeuse | [ ] |
| **04** | Alternative accessible | Un accès aux données sous forme de tableau est prévu pour les graphiques | [ ] |
| **05** | Gestion du responsive | Les métriques et alertes restent immédiatement lisibles sur mobile | [ ] |
| **06** | États limites prévus | Les états vide, chargement et erreur de flux sont documentés | [ ] |
| **07** | Fraîcheur temporelle | La date ou l'heure de dernière synchronisation est clairement affichée | [ ] |

---

> **Validation du livrable :** Document établi conformément aux exigences de la Phase 05 du framework MARVENS CREATIVE BRIEF V1.0. Prêt pour exploitation transversale.
