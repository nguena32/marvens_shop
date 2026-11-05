# MODULE_SAAS — Module Applications Logicielles (SaaS)
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Applications logicielles fournies sous forme de service (Software as a Service - B2B/B2C)  
> **Statut :** Spécification de référence active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

<!-- MARVENS_PROJECT_CONTEXT:START -->
> [!IMPORTANT]
> **STATUT PROJET DE CE MODULE :** `NON_APPLICABLE`  
> **Projet :** MARVENS SHOP  
> **Évaluation :** ⚪ NON APPLICABLE (Consulter pour référence méthodologique)

---
<!-- MARVENS_PROJECT_CONTEXT:END -->



## 1. Typologies et nature des applications SaaS

Ce module régit la conception des outils de travail numériques interactifs accessibles via le web. Contrairement à un site vitrine que l'on lit occasionnellement, un SaaS est un environnement dans lequel l'utilisateur passe plusieurs heures par jour pour accomplir des tâches productives.

### Typologies couvertes
* **SaaS B2B Métier :** Gestion d'opérations, facturation, suivi de personnel, gestion commerciale.
* **SaaS Multi-Tenant & Multi-Rôles :** Espaces cloisonnés par entreprise avec gestion fine des accès (Administrateur, Manager, Opérateur).
* **Outils d'analyse & Dashboards :** Centralisation d'indicateurs de performance et d'aide à la décision.

---

## 2. Priorités fondamentales d'expérience utilisateur (UX)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 4 PILIERS UX D'UN SAAS MARVENS                    │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Time-to-Value Rapide  │ L'usager doit obtenir son premier résultat utile │
│    (Activation immédiate)│ en moins de 3 minutes après son inscription.     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Réduction cognitive   │ Supprimer le superflu. Chaque tableau de données │
│    (Clarté fonctionnelle)│ met en avant les 4 colonnes clés par défaut.     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Robustesse d'état     │ Traitement exhaustif des 8 états d'interface     │
│    (Zéro écran mort)     │ (vide, erreur, chargement, succès, filtre vide). │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Prévisibilité totale  │ Toute action sensible (suppression, export) est  │
│    (Confiance usager)    │ explicitement nommée et protégée d'un accident.  │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Architecture structurelle d'une interface SaaS

L'architecture standardisée d'une application SaaS repose sur la disposition en **L inversé** :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ [TOPBAR] Sélecteur de boutique/espace | Recherche globale | Profil & Aide   │
├──────────────┬──────────────────────────────────────────────────────────────┤
│ [SIDEBAR]    │ [ZONE DE CONTENU ACTIVE]                                     │
│              │                                                              │
│ • Tableau de │ [En-tête de page : Titre de section + Bouton d'action CTA]   │
│   bord       ├──────────────────────────────────────────────────────────────┤
│ • Opérations │ [Filtres rapides : Recherche | Période | Statut | Export]    │
│ • Ventes     ├──────────────────────────────────────────────────────────────┤
│ • Contacts   │ [Tableau de Données Dynamique / Cartes opérationnelles]      │
│ • Rapports   │                                                              │
│              │                                                              │
│ • Paramètres │                                                              │
│ • Déconnexion│ [Pagination & Résumé : "Affichage de 1 à 20 sur 150 lignes"] │
└──────────────┴──────────────────────────────────────────────────────────────┘
```

---

## 4. Workflows essentiels et manipulation des données

### 4.1. Opérations CRUD (Create, Read, Update, Delete)
* **Création :** Privilégier les panneaux latéraux coulissants (*slide-over drawer*) ou les formulaires modulaires plutôt que de faire quitter à l'usager sa liste de travail.
* **Suppression sensible :** Double confirmation explicite avec saisie du nom de l'élément pour les données irréversibles.
* **États vides didactiques (Empty States) :** Lorsqu'une table ne contient aucune donnée (première connexion ou filtres infructueux), ne jamais laisser un carré blanc vide. Afficher une micro-illustration sobre, un message rassurant et un bouton d'action direct (« Créer votre première facture »).

### 4.2. Recherche, tri et filtres
* Champ de recherche instantané filtrant à la saisie (avec détection de délai / debounce 300ms).
* Filtres actifs visibles sous forme de pastilles amovibles d'un clic.
* Conservation des paramètres de filtres dans l'URL pour permettre le partage ou le retour navigateur fluide.

---

## 5. Gestion multi-rôles et séparation des espaces

* **Sélecteur de contexte clair :** L'utilisateur doit identifier en permanence dans quelle boutique, agence ou filiale il opère actuellement.
* **Gestion granulaire des permissions :** Masquer purement et simplement les boutons d'action non autorisés plutôt que de les afficher grisés sans explication.
* **Invitation collaborative :** Processus d'ajout d'un collaborateur simplifié en deux champs : *Adresse email / Téléphone* et *Rôle attribué*.

---

## 6. Modèle économique, facturation et renouvellement MoMo

Dans le cadre des abonnements B2B en Afrique centrale :
* **Barre d'état d'abonnement discrète :** Avertissement bienveillant 5 jours avant l'expiration du forfait mensuel.
* **Bouton de renouvellement en un clic :** Déclenchement d'un push USSD Mobile Money instantané (Orange Money / MTN MoMo) sans ressaisie lourde.
* **Zéro coupure brutale :** Période de grâce de 48 heures maintenant la consultation en lecture seule des données en cas d'échec momentané du paiement.

---

## 7. Livrables types pour un module SaaS

1. **User Flows & Arborescence applicative complète.**
2. **Spécification des tableaux de bord et indicateurs décisionnels.**
3. **Catalogue des formulaires et tiroirs de saisie.**
4. **Matrice exhaustive des 8 états par composant de données.**
5. **Spécification des flux d'onboarding et d'activation.**
