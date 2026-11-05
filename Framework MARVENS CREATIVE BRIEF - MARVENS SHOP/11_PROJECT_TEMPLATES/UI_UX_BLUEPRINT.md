# UI UX BLUEPRINT — Canevas de Conception Fonctionnelle et Architecturale UI/UX
## MARVENS CREATIVE BRIEF V1.0 · PHASE 11_PROJECT_TEMPLATES

> **Type de document :** Canevas de spécification fonctionnelle, d'architecture de l'information et d'expérience (Template opérationnel)  
> **Statut du document :** Modèle vierge prêt à l'emploi  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [MASTER_CREATIVE_BRIEF.md](MASTER_CREATIVE_BRIEF.md) · [ART_DIRECTION_SELECTION.md](ART_DIRECTION_SELECTION.md) · [UI_GUIDELINES.md](../05_UI_DESIGN/UI_GUIDELINES.md) · [COMPONENT_DESIGN.md](../05_UI_DESIGN/COMPONENT_DESIGN.md) · [DESIGN_APPROVAL.md](DESIGN_APPROVAL.md)  
> **Mode d'emploi :** Renseigner ce document pour traduire le brief validé et la direction artistique choisie en une cartographie exhaustive des parcours, des écrans, des états systèmes et des spécifications d'interaction avant tout développement.

---

## Sommaire

1. [Fiche de synthèse et métadonnées du Blueprint](#1-fiche-de-synthèse-et-métadonnées-du-blueprint)
2. [Rappels stratégiques et ancrage des décisions validées](#2-rappels-stratégiques-et-ancrage-des-décisions-validées)
3. [Objectifs d'expérience utilisateur (Principes UX directeurs)](#3-objectifs-dexpérience-utilisateur-principes-ux-directeurs)
4. [Périmètre fonctionnel détaillé et hiérarchisation (P0/P1/P2)](#4-périmètre-fonctionnel-détaillé-et-hiérarchisation-p0p1p2)
5. [Matrice des rôles, profils et permissions d'accès](#5-matrice-des-rôles-profils-et-permissions-daccès)
6. [Cartographie des parcours utilisateurs majeurs (User Journeys)](#6-cartographie-des-parcours-utilisateurs-majeurs-user-journeys)
7. [Architecture de l'information et arborescence de navigation](#7-architecture-de-linformation-et-arborescence-de-navigation)
8. [Inventaire exhaustif des écrans du MVP](#8-inventaire-exhaustif-des-écrans-du-mvp)
9. [Spécifications détaillées par écran canonique](#9-spécifications-détaillées-par-écran-canonique)
10. [Spécification des états d'interface (Initial, Loading, Empty, Error, Offline)](#10-spécification-des-états-dinterface-initial-loading-empty-error-offline)
11. [Spécifications des formulaires et règles de validation](#11-spécifications-des-formulaires-et-règles-de-validation)
12. [Spécifications des tableaux de gestion et listes de données](#12-spécifications-des-tableaux-de-gestion-et-listes-de-données)
13. [Règles de comportement responsive et adaptation mobile](#13-règles-de-comportement-responsive-et-adaptation-mobile)
14. [Exigences d'accessibilité numérique (WCAG 2.1/2.2 AA)](#14-exigences-daccessibilité-numérique-wcag-2122-aa)
15. [Microcopie, terminologie métier et localisation CEMAC](#15-microcopie-terminologie-métier-et-localisation-cemac)
16. [Matrice de traçabilité (Besoin $\rightarrow$ Écran $\rightarrow$ Critère d'acceptation)](#16-matrice-de-traçabilité-besoin--écran--critère-dacceptation)
17. [Registre des risques, cas limites et questions ouvertes](#17-registre-des-risques-cas-limites-et-questions-ouvertes)
18. [Checklist de validation formelle du Blueprint](#18-checklist-de-validation-formelle-du-blueprint)

---

## 1. Fiche de synthèse et métadonnées du Blueprint

- **Nom du projet / produit :** `[À RENSEIGNER]`
- **Direction artistique de référence :** `[Ex. Direction 2 (Agilité SaaS) validée le AAAA-MM-JJ]`
- **Version du Blueprint :** `V1.0.0`
- **Date de mise à jour :** `2026-11-04`
- **Auteurs & Concepteurs :** `[Noms des UX/UI Designers / Agents IA]`
- **Statut :** `[EN CONCEPTION / EN REVUE / VALIDÉ]`

---

## 2. Rappels stratégiques et ancrage des décisions validées

- **Problème central résolu :** `[Rappel synthétique du brief]`
- **Cible prioritaire d'usage :** `[Profil majeur et terminal prédominant]`
- **Module(s) produit activé(s) :** `[Ex. MODULE_SAAS.md + MODULE_POS.md]`

---

## 3. Objectifs d'expérience utilisateur (Principes UX directeurs)

1. **Zéro temps d'apprentissage :** Prise en main immédiate des fonctions critiques de caisse/facturation.
2. **Indestructibilité opératoire :** Aucune action utilisateur ne doit provoquer un état d'impasse ou la perte silencieuse d'un formulaire.
3. **Visibilité d'état continue :** L'opérateur sait en permanence ce que le système traite (synchro en cours, attente réseau, validation paiement).

---

## 4. Périmètre fonctionnel détaillé et hiérarchisation (P0/P1/P2)

- **P0 (Vital pour le MVP) :**  
  - `[F01 : Authentification sécurisée et gestion des sessions]`  
  - `[F02 : Création, émission et calcul automatique de facture HT/TTC]`  
  - `[F03 : Encaissement Mobile Money Orange / MTN avec notification]`  
  - `[F04 : Suivi de stock en temps réel avec alerte rupture]`
- **P1 (Important pour la V1.1) :**  
  - `[F05 : Export automatique du journal des ventes en format comptable Excel]`  
  - `[F06 : Relances automatiques d'impayés par notification SMS]`
- **P2 (Évolutions futures V2) :**  
  - `[F07 : Passerelle bancaire internationale carte Visa / Mastercard]`

---

## 5. Matrice des rôles, profils et permissions d'accès

| Module fonctionnel | Administrateur Général | Gérant de Boutique | Caissier / Opérateur | Auditeur / Comptable |
|---|:---:|:---:|:---:|:---:|
| **Tableau de bord financier** | Lecture / Écriture | Lecture seule | Masqué | Lecture seule |
| **Création de facture / Vente** | Accès total | Accès total | Accès total | Lecture seule |
| **Annulation de transaction** | Autorisé | Autorisé | **Interdit** | Interdit |
| **Configuration du système** | Accès total | Masqué | Masqué | Masqué |

---

## 6. Cartographie des parcours utilisateurs majeurs (User Journeys)

```
PARCOURS MAJEUR : Encaissement Mobile Money en Caisse (Temps cible : < 45s)

[Déclencheur] ──► [Étape 1 : Saisie Panier] ──► [Étape 2 : Choix Paiement]
Client se        Sélection rapide articles      Sélection option "Mobile Money"
présente en      par scan ou recherche.         Saisie du numéro (+237 6XX...)
caisse.          Total calculé avec TVA.        
                       │                              │
                       ▼                              ▼
                 [Étape 3 : Push MoMo]   ──► [Étape 4 : Confirmation]
                 Notification USSD reçue        Écran vert de confirmation
                 sur le téléphone client.       Génération ticket PDF/Reçu SMS.
                 Polling sécurisé backend.      Mise à jour immédiate du stock.
```

---

## 7. Architecture de l'information et arborescence de navigation

```text
Application Racine
├── 1.0 Tableau de bord (Dashboard KPIs, alertes, activités récentes)
├── 2.0 Ventes & Encaissements
│   ├── 2.1 Nouvelle Vente (Terminal POS / Caisse)
│   ├── 2.2 Liste des Factures (Filtres par statut, client, date)
│   └── 2.3 Devis & Proformas
├── 3.0 Clients & Comptes
│   ├── 3.1 Répertoire Clients (Recherche, fiche de solde)
│   └── 3.2 Fiche Client Détail (Historique des règlements)
├── 4.0 Stocks & Produits
│   ├── 4.1 Inventaire (Articles, seuils critiques)
│   └── 4.2 Mouvements d'Entrée/Sortie
└── 5.0 Paramètres & Administration
    ├── 5.1 Gestion des Utilisateurs & Caisses
    └── 5.2 Paramètres de Facturation & Devises
```

---

## 8. Inventaire exhaustif des écrans du MVP

| ID Écran | Nom de l'écran | Accès Rôles | Objectif de l'écran | Complexité UI |
|---|---|---|---|:---:|
| **SCR-01** | `Connexion / Auth` | Public | Authentification sécurisée de l'opérateur | Faible |
| **SCR-02** | `Dashboard Général` | Admin, Gérant | Synthèse financière et alertes du jour | Moyenne |
| **SCR-03** | `Terminal Caisse / POS`| Tous | Saisie rapide des ventes et encaissement | Élevée |
| **SCR-04** | `Liste des Factures` | Tous | Recherche, filtrage et actions groupées | Moyenne |
| **SCR-05** | `Détail Facture` | Tous | Consultation, impression ticket, reçu | Moyenne |
| **SCR-06** | `Gestion des Stocks` | Admin, Gérant | Contrôle des seuils et réapprovisionnements | Moyenne |

---

## 9. Spécifications détaillées par écran canonique

### Spécification Écran `SCR-03 : Terminal Caisse / POS`
- **Objectif fonctionnel :** Permettre l'enregistrement d'une vente en moins de 30 secondes au clavier ou sur écran tactile.
- **Organisation spatiale :**
  - *Zone Gauche (60%) :* Grille des articles fréquents avec filtre par catégories et champ de recherche directe avec autocomplétion.
  - *Zone Droite (40%) :* Panneau de panier persistant listant les articles, quantités, sous-total HT, TVA CEMAC (19.25%) et gros bouton CTA `Valider l'encaissement`.
- **Règles d'interaction :**
  - L'appui sur la touche `F2` ou clic direct bascule sur la modale de paiement.
  - Les cibles de sélection des articles mesurent au minimum 60 × 60 px pour le contact tactile rapide.

---

## 10. Spécification des états d'interface (Initial, Loading, Empty, Error, Offline)

Pour chaque écran inventorié, les 5 états canoniques sont spécifiés :
- **État Initial :** Données à jour chargées.
- **État Loading :** Squelettes visuels animés simulant le positionnement des cartes et lignes.
- **État Empty :** Illustration discrète, message explicite (`Aucune vente enregistrée ce jour`) et bouton primaire d'action.
- **État Error :** Message d'alerte explicite en cas d'échec API avec bouton de réessai.
- **État Offline :** Bannière ambrée supérieure, fonctionnement sur mémoire locale `IndexedDB`/`localStorage`.

---

## 11. Spécifications des formulaires et règles de validation

- **Disposition :** Colonne unique verticale systématique.
- **Validation :** Au fil de l'eau pour les formats numériques, à la perte de focus (`blur`) pour la cohérence des numéros de téléphone CEMAC (Orange Money / MTN MoMo).
- **Format monétaire :** Formatage dynamique avec séparateur d'espace et symbole `FCFA` en suffixe fixe non modifiable.

---

## 12. Spécifications des tableaux de gestion et listes de données

- **Alignement strict :** Chiffres et montants à droite, textes à gauche, badges de statut centrés.
- **Pagination :** Pagination numérotée fixe (25 éléments par défaut). Pas d'infinite scroll pour les états comptables.
- **Conversion mobile :** Recomposition en cartes indépendantes sous 768px de largeur d'écran.

---

## 13. Règles de comportement responsive et adaptation mobile

- **Smartphones (< 576px) :** Sidebar transformée en panneau tiroir `Offcanvas`, barres d'action fixes au bas de l'écran pour accès facile au pouce.
- **Tablettes (768px - 991px) :** Disposition fluide 8 colonnes, navigation pliable.
- **Desktop ($\ge$ 992px) :** Disposition complète 12 colonnes avec sidebar fixe de 260px.

---

## 14. Exigences d'accessibilité numérique (WCAG 2.1/2.2 AA)

- **Contraste minimal :** 4.5:1 sur texte courant, 3.0:1 sur les boutons et indicateurs d'état.
- **Focus visible :** Anneau bleu contrasté de 2px présent sur tous les contrôles au clavier.
- **Cibles tactiles :** 44 × 44 px au minimum sur smartphone.

---

## 15. Microcopie, terminologie métier et localisation CEMAC

- **Terminologie financière officielle :** Utilisation stricte de `FCFA` (ou `XAF`), mention de la `TVA (19.25%)` conformément aux lois de finances locales.
- **Verbes d'action explicites :** `Encaisser la vente`, `Éditer le reçu`, `Clôturer la journée` (bannir les termes flous type `Valider` ou `OK`).

---

## 16. Matrice de traçabilité (Besoin $\rightarrow$ Écran $\rightarrow$ Critère d'acceptation)

| Besoin Métier / Utilisateur | Écran associé | Composant clé | Critère d'acceptation vérifiable |
|---|---|---|---|
| Encaisser par Mobile Money | `SCR-03 (POS)` | Modal Paiement MoMo | Notification push reçue et statut mis à jour en < 30s |
| Suivre les impayés du mois | `SCR-04 (Factures)`| Tableau filtré | Filtre par statut "En retard" affiche le solde cumulé |

---

## 17. Registre des risques, cas limites et questions ouvertes

| # | Cas limite identifié | Solution UX / UI spécifiée | Statut |
|---|---|---|---|
| **01** | Coupure Internet pendant un encaissement | Sauvegarde locale de la vente, pastille d'attente de synchro | Validé |
| **02** | Transaction MoMo rejetée pour solde client insuffisant | Message clair sans code d'erreur technique obscur avec bouton "Changer de mode" | Validé |

---

## 18. Checklist de validation formelle du Blueprint

| # | Exigence de complétude fonctionnelle | Vérifié |
|---|---|---|
| **01** | 100 % des écrans du MVP sont identifiés et décrits | [ ] |
| **02** | Les parcours critiques (vente, facturation) sont cartographiés | [ ] |
| **03** | Les 5 états systèmes sont décrits pour chaque vue | [ ] |
| **04** | Les règles d'adaptation mobile (tactile, cibles $\ge$ 44px) sont arrêtées | [ ] |
| **05** | Les exigences d'accessibilité WCAG AA sont intégrées aux composants | [ ] |


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
