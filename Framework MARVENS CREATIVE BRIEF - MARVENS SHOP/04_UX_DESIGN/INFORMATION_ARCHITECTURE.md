# INFORMATION ARCHITECTURE — Architecture de l'Information
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `04_UX_DESIGN/INFORMATION_ARCHITECTURE.md`  
> **Statut :** Référence méthodologique active  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [UX_PRINCIPLES.md](UX_PRINCIPLES.md) · [USER_JOURNEYS.md](USER_JOURNEYS.md) · [PRODUCT_BRIEF.md](../01_PRODUCT_DISCOVERY/PRODUCT_BRIEF.md)

---

## 1. Définition et Objectifs Stratégiques

L'Architecture de l'Information (AI) est la discipline qui consiste à **organiser, étiqueter, catégoriser et hiérarchiser les contenus et fonctionnalités d'un produit numérique** afin d'en rendre la structure immédiatement compréhensible et les éléments faciles à trouver.

### Les 6 Objectifs Clés de l'Architecture de l'Information
1. **Minimiser la Charge Cognitive :** Permettre à l'usager de se concentrer sur sa tâche sans devoir deviner où se cache une fonction.
2. **Garantir la Découvrabilité (*Findability*) :** Rendre l'information accessible par plusieurs chemins convergents (navigation descendante, recherche, filtres transversaux).
3. **Clarifier le Modèle Mental :** Aligner la structure de l'application sur la façon dont les utilisateurs perçoivent leur métier et leurs besoins, et non sur la structure de la base de données technique.
4. **Faciliter l'Orientation Spatiale :** Répondre en permanence aux trois questions fondamentales de l'usager : *« Où suis-je ? »*, *« Qu'est-ce qui est disponible ici ? »* et *« Où puis-je aller ? »*.
5. **Permettre la Scalabilité Future :** Concevoir une arborescence capable d'accueillir de nouveaux modules ou services sans écrouler la cohérence globale.
6. **Optimiser l'Affichage Mobile :** Structurer l'information de manière à ce qu'elle puisse se condenser harmonieusement sur petit écran sans perte de sens.

---

## 2. Principes Fondamentaux d'Organisation

L'organisation des contenus au sein de Marvens Group repose sur sept règles immuables :

### 2.1. Organisation par Objectifs Utilisateurs
Les rubriques principales doivent refléter les verbes d'action ou les intentions majeures de la cible (ex. *« Gérer ma trésorerie »*, *« Suivre mes commandes »*, *« Demander une attestation »*) plutôt que des découpages administratifs internes à l'entreprise.

### 2.2. Cohérence et Mutuelle Exclusivité des Catégories
Les catégories d'un même niveau doivent être fondées sur un critère logique unique (par thème, par type d'entité, par action). Deux catégories ne doivent pas se chevaucher de manière ambiguë.

### 2.3. Équilibre Profondeur vs Largeur
* **Largeur excessive (trop de rubriques de premier niveau) :** Provoque une surcharge visuelle et une paralysie du choix.
* **Profondeur excessive (trop de sous-niveaux emboîtés) :** Provoque la désorientation et décourage l'usager.
* **Le compromis Marvens :** Privilégier une largeur modérée (4 à 7 catégories principales au niveau 1) et une profondeur n'excédant pas 3 clics pour les fonctionnalités courantes.

### 2.4. Distinction Contenu / Action / Métadonnée
Ne jamais mélanger au même niveau hiérarchique une entité d'information (ex. *« Factures »*), une action transversale (ex. *« Exporter »*) et un filtre d'état (ex. *« En attente »*).

---

## 3. Méthode Opérationnelle de Construction en 8 Étapes

La conception d'une architecture de l'information suit un protocole méthodique strict :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 LES 8 ÉTAPES DE CONSTRUCTION DE L'AI                        │
├──────────────────────────────────────┬──────────────────────────────────────┤
│ 1. Inventaire des Contenus (Audit)   │ Recensement exhaustif des données et │
│                                      │ fonctionnalités prévues au brief.    │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 2. Regroupement par Affinités        │ Regroupement logique des données     │
│                                      │ selon les tâches réelles usagers.    │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 3. Définition des Piliers Hiérarchiques Structure en niveaux (L1, L2, L3).  │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 4. Nomenclature & Normalisation      │ Choix des termes explicites, sans    │
│                                      │ jargon d'ingénieur ou d'administrateur│
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 5. Définition des Relations Croisées │ Cartographie des liens entre objets  │
│                                      │ (ex. Un client pointe vers factures).│
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 6. Établissement du Sitemap          │ Schématisation formelle de l'arbre.  │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 7. Test de Trouvabilité (Tree Test)  │ Vérification théorique ou pratique   │
│                                      │ des chemins de recherche de tâches.  │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ 8. Validation par Arbitrage Humain   │ Signature de la structure avant UI.  │
└──────────────────────────────────────┴──────────────────────────────────────┘
```

---

## 4. Outils et Représentations de l'Architecture de l'Information

L'équipe UX et les agents IA exploitent les artefacts méthodologiques suivants :

### 4.1. L'Inventaire de Contenu (*Content Inventory*)
Document tabulaire recensant chaque page, écran ou module avec son identifiant unique, son niveau hiérarchique, son intention et ses dépendances de données.

### 4.2. L'Arborescence Globale (*Sitemap*)
Schéma hiérarchique représentant l'ensemble des branches du produit, depuis le tableau de bord racine jusqu'aux vues de détail.

### 4.3. La Taxonomie et les Métadonnées
Système de balisage sémantique permettant d'indexer, de filtrer et de croiser les informations (ex. par date, statut, montant, zone géographique, criticité).

### 4.4. Le Tri par Cartes (*Card Sorting*) et Tree Testing
Lorsque des utilisateurs représentatifs sont accessibles, ces ateliers permettent de tester si la nomenclature retenue correspond intuitivement à leurs réflexes de classement.

---

## 5. Nomenclature, Terminologie et Micro-Contenus

Les mots utilisés dans l'architecture déterminent directement la fluidité d'usage :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                      RÈGLES DE NOMENCLATURE MARVENS                         │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Vocabulaire Métier    │ Utiliser les termes usuels du secteur cible      │
│    vs Jargon Technique   │ (ex. « Versements » au lieu de « TransactionLog»)│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Brièveté & Précision  │ Privilégier des labels de 1 à 3 mots percutants. │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Constance Absolue     │ Si un objet est nommé « Compte », ne jamais      │
│                          │ l'appeler « Profil » ou « Espace » ailleurs.     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Clarté Multilingue    │ Anticiper l'allongement textuel en traduction    │
│                          │ (+20% à +30% souvent constatés entre langues).   │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 6. Gestion des Cas Complexes et Scalabilité

Une architecture mature doit savoir gérer les situations de forte densité et de volumétrie variable :
* **Gestion des Droits et Rôles (RBAC) :** Les sections non autorisées à un profil d'usager ne doivent pas saturer sa navigation par des cadenas inutiles ; elles doivent être masquées ou regroupées dans un espace réservé.
* **États Vides (*Empty States*) Structurants :** Quand une section ne contient pas encore de données, l'écran doit expliquer ce qui viendra s'y loger et proposer l'action d'initialisation.
* **Archivage et Données Froides :** Isoler clairement les flux vivants d'activité courante des archives historiques pour éviter la pollution des vues opérationnelles.

---

## 7. Modèles Opérationnels Réutilisables

### 7.1. Modèle d'Inventaire de Contenu (Gabarit Tabulaire)

| Identifiant | Niveau | Libellé Section | Intention Métier / Tâche | Objets Affichés | Données d'Entrée | Statut Validation |
| :---: | :---: | :--- | :--- | :--- | :--- | :---: |
| **SEC-01** | L1 | Synthèse Trésorerie | Vue d'ensemble du solde et alertes | Soldes, KPI jour, alertes | APIs Bancaires | Validé |
| **SEC-02** | L2 | Détail des Mouvements | Recherche et filtrage des opérations | Liste de transactions | Filtres dates, types | Validé |
| **SEC-03** | L3 | Justificatif Transaction | Téléchargement du reçu horodaté | Fiche détaillée, PDF | ID Transaction | Proposition |

---

### 7.2. Exemple Générique d'Arborescence Structurée (Non Prescriptif)

```text
PRODUIT MARVENS (Racine)
│
├── 1.0 ACCUEIL & SYNTHÈSE
│   ├── 1.1 Indicateurs prioritaires (KPIs)
│   ├── 1.2 Actions rapides d'urgence
│   └── 1.3 Notifications actives
│
├── 2.0 ACTIVITÉ & GESTION OPÉRATIONNELLE
│   ├── 2.1 Liste des dossiers en cours
│   │   ├── 2.1.1 Fiche dossier détaillée
│   │   └── 2.1.2 Historique des interventions
│   └── 2.2 Saisie d'une nouvelle opération (Tunnel guidé)
│
├── 3.0 ANALYSES & RAPPORTS
│   ├── 3.1 Tableaux de bord comparatifs
│   └── 3.2 Centre d'export et justificatifs légaux
│
└── 4.0 CONFIGURATION & SÉCURITÉ
    ├── 4.1 Paramètres du compte et sécurité
    ├── 4.2 Gestion des utilisateurs et habilitations
    └── 4.3 Préférences régionales et d'affichage
```

---

### 7.3. Checklist de Validation de l'Architecture de l'Information
```markdown
- [ ] L'arborescence ne dépasse pas 7 catégories de niveau 1.
- [ ] Les tâches critiques sont accessibles en 3 clics ou moins depuis l'accueil.
- [ ] La nomenclature est dépourvue de tout jargon technique ou acronyme obscur.
- [ ] Les catégories de même niveau s'excluent mutuellement sans chevauchement.
- [ ] La structure a été pensée pour être lisible sur un terminal mobile à petit écran.
- [ ] Les emplacements des états vides et des archives historiques sont prévus.
- [ ] La proposition d'arborescence a été soumise au décisionnaire humain pour validation.
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
