# USER JOURNEYS — Parcours Utilisateurs et Scénarios d'Usage
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `04_UX_DESIGN/USER_JOURNEYS.md`  
> **Statut :** Référence méthodologique active  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [UX_PRINCIPLES.md](UX_PRINCIPLES.md) · [PRODUCT_BRIEF.md](../01_PRODUCT_DISCOVERY/PRODUCT_BRIEF.md) · [USER_PERSONAS.md](../01_PRODUCT_DISCOVERY/USER_PERSONAS.md)

---

## 1. Objectif et Typologie des Parcours

Le présent document définit la méthodologie standardisée pour modéliser, cartographier et analyser la dynamique séquentielle des actions de l'utilisateur au sein des produits Marvens.

### 1.1. Pourquoi documenter les parcours ?
La modélisation des parcours garantit que chaque fonctionnalité développée s'inscrit dans une chaîne logique de valeur. Elle permet de :
* **Détecter les ruptures d'expérience :** Repérer les points où l'utilisateur se retrouve bloqué, désorienté ou invité à saisir une information déjà fournie.
* **Éliminer les angles morts :** Anticiper systématiquement les parcours d'erreur, les abandons temporaires et les défaillances réseau.
* **Calibrer l'effort cognitif :** S'assurer que le nombre de décisions requises à chaque écran reste proportionné à la capacité d'attention de l'usager.

### 1.2. Niveaux de Granularité des Parcours
Pour éviter toute confusion conceptuelle, Marvens distingue formellement six échelles d'analyse :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 6 NIVEAUX DE PARCOURS UX                          │
├───────────────────────────────┬─────────────────────────────────────────────┤
│ 1. Parcours Global (End-to-End│ De la découverte initiale du besoin jusqu'à │
│    Customer Journey)          │ la recommandation ou récurrence post-usage. │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 2. Parcours Produit           │ Enchaînement des étapes vécues strictement  │
│    (In-App Experience)        │ à l'intérieur de l'application.             │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 3. Scénario d'Usage           │ Narration contextualisée d'une situation    │
│    (Contextual Scenario)      │ réelle avec contraintes de temps et d'espace│
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 4. Flux Fonctionnel (Task     │ Décomposition étape par étape pour mener une│
│    Flow)                      │ tâche précise (ex. Réinitialiser son code). │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 5. User Flow Détaillé         │ Diagramme intégrant chaque écran, chaque    │
│                               │ condition logique et chaque message d'état. │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 6. Parcours de Service        │ Articulation omnicanale intégrant les tiers │
│    (Service Blueprint)        │ (support client, livreur, validation banque)│
└───────────────────────────────┴─────────────────────────────────────────────┘
```

---

## 2. Préparation et Cadrage d'un Parcours

Avant de tracer la moindre étape, l'agent IA ou l'équipe UX doit obligatoirement réunir et consigner les données de cadrage suivantes :
1. **Profil ou Segment Réel :** Segment identifié dans le brief `01_PRODUCT_DISCOVERY/` (interdiction formelle d'inventer des profils sans fondement).
2. **Objectif Prioritaire :** Ce que l'utilisateur veut obtenir concrètement au terme de la session.
3. **Événement Déclencheur (*Trigger*) :** Ce qui provoque l'action (ex. réception d'une facture, alerte de rupture de stock, notification SMS).
4. **Point d'Entrée Initial :** Deep link, écran d'accueil, notification push, message de messagerie instantanée.
5. **Contraintes et Environnement :** Disponibilité réseau, niveau d'attention, environnement bruyant ou lumineux.
6. **Inconnues et Hypothèses Ouvertes :** Liste explicite des éléments non confirmés par la recherche utilisateur.

---

## 3. Structure Complète d'un Parcours Utilisateur

Chaque parcours utilisateur critique d'un produit Marvens doit être documenté selon la matrice des quatorze composantes obligatoires ci-dessous :

```markdown
1. Identifiant & Nom du Parcours :
   Ex. [JRN-01] Première souscription à une formule avec paiement Mobile Money.

2. Segment Cible :
   Profil utilisateur concerné et niveau de familiarité numérique présumé.

3. Objectif Utilisateur :
   Finalité claire et mesurable recherchée par l'usager.

4. Déclencheur & Contexte Réel :
   Pourquoi et où l'utilisateur démarre-t-il cette action ?

5. Point d'Entrée :
   Premier écran ou point de contact visualisé.

6. Séquence des Étapes (Phase par phase) :
   Découpage chronologique du parcours (Découverte -> Saisie -> Validation -> Clôture).

7. Actions Effectuées par l'Utilisateur :
   Ce que la personne fait physiquement (saisir, cliquer, scanner, attendre).

8. Réponses et Rétroactions du Système :
   Ce que l'écran affiche en réponse immédiate à chaque geste.

9. Informations Requises à Chaque Étape :
   Données nécessaires à la progression de l'action.

10. Embranchements et Points de Décision :
    Choix offerts à l'usager modifiant la suite du flux.

11. Zones de Friction et Risques d'Abandon :
    Étapes critiques où la confusion ou la lenteur peuvent provoquer un départ.

12. Traitement des Erreurs et Exceptions :
    Réaction prévue en cas de saisie invalide ou d'incident technique.

13. Résultat Final et État Post-Parcours :
    Ce qui est confirmé à l'utilisateur et archivé dans le système.

14. Métriques de Réussite (KPIs) :
    Taux de conversion, temps médian de complétion, taux de sollicitation du support.
```

---

## 4. Documentation des Parcours Nominaux et Alternatifs

Un design UX professionnel ne se limite jamais au « scénario idéal ». Les parcours doivent systématiquement cartographier les variations et incidents opérationnels :

```
                               ┌──────────────────────────┐
                               │   DÉCLENCHEUR INITIAL    │
                               └────────────┬─────────────┘
                                            │
                                            ▼
                               ┌──────────────────────────┐
                               │   PARCOURS NOMINAL (A)   │
                               │  Flux direct sans accroc │
                               └────────────┬─────────────┘
                                            │
         ┌──────────────────────────────────┼──────────────────────────────────┐
         ▼                                  ▼                                  ▼
┌─────────────────┐                ┌─────────────────┐                ┌─────────────────┐
│  VARIANTE B     │                │  CAS D'ERREUR C │                │ INTERRUPTION D  │
│ Profil dégradé, │                │ Saisie invalide,│                │ Coupure réseau, │
│ absence de doc  │                │ rejet bancaire  │                │ appel entrant   │
└────────┬────────┘                └────────┬────────┘                └────────┬────────┘
         │                                  │                                  │
         ▼                                  ▼                                  ▼
[ Parcours guidé ]                 [ Aide & Reprise ]                 [ Sauvegarde auto ]
```

### 4.1. Parcours Nominaux (*Happy Path*)
Le chemin le plus court, direct et logique permettant à l'usager d'atteindre son objectif dans des conditions nominales de fonctionnement.

### 4.2. Parcours Alternatifs et Contextuels
* **Variantes de profils :** Utilisateur déjà authentifié vs nouvel arrivant ; compte individuel vs gestionnaire de flotte.
* **Variantes de connectivité :** Bascule automatique en mode allégé ou différé en cas de réseau instable.

### 4.3. Parcours d'Échec et de Récupération
* Échec de paiement ou de provisionnement.
* Document d'identification illisible lors d'une vérification KYC.
* Détection d'incohérence dans les données soumises.

### 4.4. Gestion des Interruptions et Reprise
Lorsqu'un parcours comprend plus de trois étapes :
* Sauvegarde automatique locale (*auto-save*) à chaque champ complété.
* Envoi d'un lien de reprise sécurisé par SMS ou email si la session expire.
* Réouverture sur la dernière étape valide lors de la reconnexion sans perte de contexte.

---

## 5. Méthode d'Audit et d'Optimisation des Parcours

Pour assainir un parcours existant ou valider un nouveau concept, l'agent IA applique la grille de traque des frictions en 10 points :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                      GRILLE D'ÉLIMINATION DES FRICTIONS                     │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Demandes Prématurées  │ Bannir la création de compte obligatoire avant   │
│                          │ d'avoir démontré la valeur concrète du service.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Saisies Redondantes   │ Ne jamais redemander une information déjà connue │
│                          │ du système ou présente dans la session.          │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Ruptures de Contexte  │ Éviter de renvoyer l'usager vers un autre outil  │
│                          │ sans assurer son retour automatique et limpide.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Choix Paralysants     │ Limiter le nombre d'options simultanées à 3 ou 4 │
│                          │ selon la loi de Hick pour accélérer la décision. │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 5. Invisibilité d'Avance │ Dans un processus séquentiel, afficher toujours  │
│                          │ le nombre d'étapes restantes (ex. Étape 2 sur 4).│
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 6. Modèles Opérationnels Réutilisables

### 6.1. Modèle de Fiche de Parcours Utilisateur
```markdown
# FICHE DE PARCOURS UTILISATEUR — [Identifiant et Nom du Parcours]

* **Projet :** [Nom du Produit]
* **Date de Révision :** AAAA-MM-JJ
* **Auteur / Analyste :** [Agent IA / Nom du Designer]
* **Segment Visé :** [Profil spécifique du Persona]

---

### 1. Contexte et Hypothèses Préalables
* **Objectif Utilisateur :** [...]
* **Point d'Entrée & Déclencheur :** [...]
* **Hypothèses Clés :** [Hypothèse 1, Hypothèse 2]

---

### 2. Tableau Séquentiel du Flux

| Étape | Intention Usager | Action Utilisateur | Réponse Système | Risque de Friction | Stratégie d'Assistance |
| :---: | :--- | :--- | :--- | :--- | :--- |
| **01** | Découvrir l'offre | Clic sur le bouton d'action | Ouverture formulaire fluide | Doute sur le prix | Affichage immédiat du coût total |
| **02** | Renseigner données | Saisie du numéro | Vérification syntaxique live | Faute de frappe | Masque de saisie automatique |
| **03** | Valider paiement | Choix Mobile Money | Envoi push USSD sur téléphone | Attente sans retour | Compte à rebours + message explicatif |
| **04** | Obtenir le reçu | Clic sur télécharger | Génération PDF instantanée | Échec téléchargement | Envoi automatique de copie par SMS |

---

### 3. Gestion des Cas d'Exception
* **En cas d'échec à l'étape 03 :** Proposer une nouvelle tentative sans devoir ressaisir les données de l'étape 02.
* **En cas de déconnexion réseau :** Affichage d'un bandeau persistant : *« Données enregistrées. Reprise automatique dès le retour du réseau »*.
```

### 6.2. Modèle de Scénario d'Usage Contextualisé
```markdown
# SCÉNARIO D'USAGE NARRATIF — [Titre de la Situation]

* **Personnage / Rôle :** [Ex. Paul, commerçant de détail à Douala]
* **Contexte Physique :** Dans sa boutique, entre deux clients, éclairage direct du soleil, connexion 3G fluctuante.
* **Situation Déclenchante :** Il doit régler d'urgence une commande fournisseur avant 17h pour être livré le lendemain matin.
* **Déroulement de l'Action :** 
  Paul ouvre l'application. La page d'accueil affiche immédiatement l'état de son solde sans temps de chargement bloquant. Il sélectionne le fournisseur dans sa liste de favoris récents. Le montant s'affiche en grand corps de texte. Il valide son paiement par empreinte digitale. Un écran de confirmation vert vif apparaît avec une tonalité audio rassurante, accompagné de la référence unique de la transaction.
* **Points d'Attention Ergonomiques Observés :** Les contrastes doivent être maximaux pour rester lisibles en extérieur, et la transaction doit pouvoir être certifiée par SMS en cas de chute instantanée de la connexion data.
```

### 6.3. Checklist de Revue d'un Parcours
```markdown
- [ ] Le parcours dispose d'un point d'entrée et d'une issue claire.
- [ ] Chaque étape correspond à une valeur tangible pour l'usager.
- [ ] Le nombre de champs à remplir a été réduit au strict minimum légal ou technique.
- [ ] Tous les points d'abandon potentiel sont dotés d'une solution de secours.
- [ ] Les cas d'erreur réseau et de reprise après interruption sont formellement prévus.
- [ ] Les hypothèses d'expérience sont explicitement distinguées des faits confirmés.
```


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Exigences UX/UI et flux utilisateurs
- **Modules applicables retenus :** MODULE_ECOMMERCE, MODULE_PWA
- **Fonctionnalités prioritaires MVP :**
- Gestion du catalogue
- Tableau de bord et gestion des commandes
- Gestion commerciale et indicateurs
- Panier et commande
- Tableau de bord et gestion des commandes
- Connexion OAuth Meta
- Importer depuis Meta

- **Parcours utilisateurs clés :** Parcours acheteur
25.	Le client ouvre le mini-site depuis un lien partagé.
26.	Il recherche ou parcourt les produits.
27.	Il consulte une fiche, choisit quantité et variante.
28.	Il ajoute au panier.
29.	Il renseigne ses coordonnées et informations de livraison/paiement.
30.	Il valide ; la commande est enregistrée et un numéro est attribué.
31.	Le site ouvre WhatsApp avec un message prérempli.
32.	Le client envoie le message au commerçant.
33.	Le commerçant confirme la disponibilité, les frais et le paiement.
34.	Le commerçant met à jour le statut dans le tableau de bord.
- **Rôles utilisateurs :** Administrateur Marvens (support technique), Commerçant / administrateur client, Opérateur / vendeur client (si activé), Client acheteur
- **Terminaux prioritaires :** desktop, tablet, mobile
- **Langues et accessibilité :** Francais
<!-- MARVENS_PROJECT_CONTEXT:END -->
