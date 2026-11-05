# MODULE_PWA — Module Applications Web Progressives (PWA)
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Applications web installables et résilientes hors-ligne (Progressive Web Apps)  
> **Statut :** Spécification de référence active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

<!-- MARVENS_PROJECT_CONTEXT:START -->
> [!IMPORTANT]
> **STATUT PROJET DE CE MODULE :** `APPLICABLE`  
> **Projet :** MARVENS SHOP  
> **Évaluation :** ✅ APPLICABLE AU PROJET

### Cadrage contextuel associé
- **Fonctionnalités MVP déclarées :** Gestion du catalogue, Tableau de bord et gestion des commandes, Gestion commerciale et indicateurs, Panier et commande, Tableau de bord et gestion des commandes, Connexion OAuth Meta, Importer depuis Meta
- **Parcours clés :** Parcours acheteur
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
- **Terminaux prioritaires :** desktop, tablet, mobile
---
<!-- MARVENS_PROJECT_CONTEXT:END -->



## 1. Définition, rôle stratégique et distinction clé

Une Progressive Web App (PWA) est une application web conçue pour offrir les avantages d'une application mobile (icône sur l'écran d'accueil, affichage en plein écran sans barre d'adresse, notifications, fonctionnement hors ligne) **sans les lourdeurs de téléchargement sur les stores d'applications (Google Play / App Store)** ni les commissions prohibitives de ces derniers.

### Pertinence majeure pour les marchés africains :
* **Zéro barrière d'espace de stockage :** Pèse quelques mégaoctets là où une application native équivalente exige 50 à 100 Mo d'espace sur des smartphones d'entrée de gamme saturés.
* **Économie de data :** Mise en cache locale agressive (*Service Worker* et *IndexedDB*) réduisant drastiquement la consommation de forfait internet lors des visites récurrentes.
* **Déploiement universel instantané :** Un seul code source maintenu, mis à jour immédiatement sans attendre la validation des stores.

---

## 2. Priorités fondamentales de conception UX d'une PWA

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 4 EXIGENCES VITALES DU DESIGN PWA                 │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Installation fluide   │ Bannière d'installation opportune expliquant la  │
│    (Contextual Install)  │ valeur (ex: "Accédez à votre caisse en 1 clic"). │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Mode Déconnecté Actif │ L'application s'ouvre et fonctionne sans réseau; │
│    (Offline Continuity)  │ les données saisies sont stockées localement.    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Synchronisation Douce │ Témoin visuel rassurant indiquant la reprise de  │
│    (Silent Sync)         │ connexion et l'envoi des opérations en attente.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Navigation App-Like   │ Suppression des comportements web parasites      │
│    (Native Sensation)    │ (zoom accidentel au double-tap, pull-to-refresh).│
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Moment et protocole de proposition d'installation

Ne jamais afficher le pop-up d'installation dès la première seconde d'arrivée sur le site (pratique intrusive rejetée à 90%).

### Protocole recommandé :
1. **Laisser l'usager explorer :** Proposer l'installation uniquement après une première action réussie (ex: après avoir consulté 3 articles, ou lors de la 2e session).
2. **Explication claire de l'avantage :**  
   *Texte type :* *« Installez l'application Marvens sur votre téléphone : 0 Mo consommé, accès direct sans internet. »*
3. **Instructions spécifiques par OS :**  
   * *Sur Android (Chrome) :* Bouton direct déclenchant l'invite native `beforeinstallprompt`.  
   * *Sur iOS (Safari) :* Guide pas-à-pas illustré montrant l'icône « Partager » $\rightarrow$ « Sur l'écran d'accueil ».

---

## 4. Gestion des états réseau et stratégie Offline-First

L'application doit communiquer son état de connectivité avec discrétion :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    GESTION DES ÉTATS DE CONNECTIVITÉ                        │
├──────────────────────┬──────────────────────────────────────────────────────┤
│ ÉTAT CONSTATÉ        │ COMPORTEMENT VISUEL ET EXPÉRIENTIEL                  │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ 1. En ligne (Normal) │ Témoin vert discret ou aucun message (neutralité).   │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ 2. Coupure réseau    │ Bandeau d'information ambre doux en haut d'écran :   │
│                      │ "Mode hors ligne actif. Vos ventes sont enregistrées │
│                      │ en mémoire locale et seront synchronisées au retour."│
├──────────────────────┼──────────────────────────────────────────────────────┤
│ 3. Rétablissement    │ Notification verte éphémère (3 sec) :                │
│                      │ "Connexion rétablie : 4 opérations synchronisées."   │
└──────────────────────┴──────────────────────────────────────────────────────┘
```

---

## 5. Spécifications du Manifest et des icônes d'application

* **Fichier `manifest.json` standardisé :**
  * `display: "standalone"` (masque la barre de navigation du navigateur).
  * `orientation: "any"` ou `"portrait"` selon le produit (ex: `"landscape"` pour un POS sur tablette de comptoir).
  * `theme_color`: Couleur primaire officielle de marque du produit.
  * `background_color`: Couleur de fond du splash-screen au démarrage.
* **Icônes adaptatives (Maskable Icons) :**  
  Fournir les déclinaisons 192x192px et 512x512px avec marge interne de 10% pour s'adapter à la découpe automatique des constructeurs Android (Samsung, Xiaomi, etc.).

---

## 6. Livrables types pour un module PWA

1. **Spécification du manifest applicatif (couleurs, orientations, icônes).**
2. **Flux et déclencheurs d'invitation à l'installation (Android / iOS).**
3. **Matrice des écrans disponibles hors ligne vs écrans exigeant une connexion.**
4. **Protocole de résolution des conflits de synchronisation de données.**
5. **Comportement visuel du bandeau d'état de connectivité.**
