# MODULE_ECOMMERCE — Module Boutiques et Plateformes E-commerce
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Boutiques en ligne, catalogues marchands et marketplaces B2B/B2C  
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



## 1. Typologies et modèles de commerce en ligne

Le module E-commerce régit la conception des plateformes de vente de produits physiques, de biens numériques ou de services marchands à distance.

### Typologies couvertes
* **Boutique mono-vendeur B2C :** Vente directe d'une marque ou d'un commerce local (mode, électronique, alimentation).
* **Catalogue marchand avec commande WhatsApp :** Modèle très performant en Afrique subsaharienne combinant panier web et finalisation directe par messagerie.
* **Marketplace multi-vendeurs :** Place de marché avec gestion des boutiques partenaires et commissionnement.
* **Boutique de produits numériques :** Vente d'ebooks, formations ou logiciels téléchargeables instantanément.

---

## 2. Priorités fondamentales d'expérience utilisateur (UX)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 4 RÈGLES D'OR DE L'E-COMMERCE MARVENS                │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Transparence totale   │ Affichage du prix net en FCFA dès la vignette.   │
│    (Zero Hidden Fees)    │ Frais de livraison annoncés avant le panier.     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Découverte fluide     │ Moteur de recherche tolérant aux fautes d'ortho- │
│    (Frictionless Search) │ graphe et filtres instantanés par tranche de prix│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Checkout sans friction│ Possibilité d'acheter en mode invité (sans mot de│
│    (Guest Checkout)      │ passe préalable) en saisissant son numéro MoMo.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Réassurance locale    │ Preuve sociale locale, garantie de conformité    │
│    (Trust Architecture)  │ et option de paiement à la livraison sécurisée.  │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Parcours d'achat complet (Funnel de conversion)

```text
[1. Découverte] ──► Page d'accueil / Grille catalogue / Recherche ciblée.
       │
[2. Évaluation] ──► Fiche Produit : Photos nettes, stock disponible, prix clair.
       │
[3. Panier] ──────► Tiroir latéral (Cart Drawer) : Récapitulatif, quantité, total.
       │
[4. Commande] ────► Formulaire épuré (Nom + Ville/Quartier + Téléphone WhatsApp).
       │
[5. Paiement] ────► Sélection Orange Money / MTN MoMo ou Cash à la livraison.
       │
[6. Confirmation] ─► Écran de succès rassurant + Envoi automatique du reçu WhatsApp.
```

---

## 4. Anatomie d'une Fiche Produit d'excellence

* **Visuels prioritaires :** Galerie photo avec zoom haute définition, affichage prioritaire de la première image sans ralentir la page.
* **Sélection des variantes :** Boutons tactiles larges pour la taille, la couleur ou le volume (éviter les listes déroulantes minuscules).
* **Disponibilité en temps réel :** Indicateur de stock sincère (*« En stock à Douala - Expédié sous 24h »*). Bannir les faux comptes à rebours d'urgence non éthiques.
* **Bouton d'action principal (Sticky CTA) :** Sur mobile, le bouton « Ajouter au panier » reste fixé en bas de l'écran lors du défilement.
* **Option alternative « Commander directement par WhatsApp » :** Bouton secondaire permettant au client hésitant de discuter directement avec un conseiller commercial.

---

## 5. Tunnel de commande et paiements adaptés au marché

1. **Suppression du compte obligatoire préalable :**  
   Forcer la création d'un mot de passe complexe avant l'achat fait chuter le taux de conversion de plus de 30%. Demander simplement le numéro de téléphone et créer le compte automatiquement en arrière-plan.
2. **Paiements locaux intégrés :**  
   * **Mobile Money direct :** Push USSD déclenché instantanément sur le téléphone de l'acheteur.
   * **Paiement à la livraison (Cash on Delivery) :** Très populaire pour vaincre la méfiance lors du premier achat.
3. **Précision des adresses en contexte urbain africain :**  
   Les systèmes d'adresses postales occidentales (numéro et nom de rue) étant inopérants dans la majorité des villes de la région, le formulaire de livraison doit proposer :  
   * *Ville* (Douala, Yaoundé, etc.).  
   * *Quartier / Repère connu* (ex: « Akwa, face ancienne direction... »).  
   * *Numéro WhatsApp actif pour le livreur*.

---

## 6. Service après-vente et fidélisation

* **Notification WhatsApp de suivi :** Envoi d'un message automatique à chaque étape clé (*« Votre commande #1234 a été confiée au livreur »*).
* **Téléchargement immédiat pour les produits numériques :** Accès direct au lien de téléchargement sur la page de confirmation et par email sans délai d'attente.

---

## 7. Livrables types pour un module E-commerce

1. **Maquettes de la grille catalogue et des filtres de recherche.**
2. **Spécification de la Fiche Produit Desktop et Mobile.**
3. **Tunnel de panier et checkout invité en 2 étapes.**
4. **Flux d'intégration des passerelles Mobile Money et scénarios d'échec.**
5. **Gabarit de confirmation de commande et message de suivi WhatsApp.**
