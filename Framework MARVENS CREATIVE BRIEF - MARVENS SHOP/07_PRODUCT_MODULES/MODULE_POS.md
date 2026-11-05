# MODULE_POS — Module Systèmes de Vente et Encaissement (Point of Sale)
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Systèmes de caisse enregistreuse, point de vente et encaissement tactile  
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



## 1. Contextes d'usage et impératifs opérationnels

Le module POS s'adresse aux environnements de vente physique : commerces de détail, superettes, pressings, restaurants, salons ou boutiques spécialisées. 

Dans ces contextes, l'opérateur (caissier ou vendeur) travaille sous pression constante, devant une file de clients en attente, souvent sur des tablettes tactiles ou des postes de caisse compacts. 

> **Règle absolue du POS :** Chaque seconde compte. L'interface doit être conçue pour un encaissement complet en **moins de 30 secondes**, sans hésitation ergonomique et avec une tolérance totale aux pannes de réseau.

---

## 2. Priorités fondamentales de conception

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 4 EXIGENCES VITALES DU DESIGN POS                 │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Ergonomie tactile     │ Cibles tactiles massives (minimum 48x48px à      │
│    (Touch-First)         │ 64x64px) évitant toute erreur de saisie au doigt.│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Vitesse d'encaissement│ Ticket de vente visible en permanence à droite,  │
│    (Rapid Checkout)      │ total calculé instantanément en gros caractères. │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Paiement Hybride      │ Bascule instantanée entre Espèces et Mobile      │
│    (Cash & Mobile Money) │ Money (Orange / MTN) en un tap tactile.          │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Résilience Hors-Ligne │ La caisse continue d'enregistrer et d'imprimer   │
│    (Offline Continuity)  │ même en cas de coupure internet complète.        │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Architecture spatiale de l'écran d'encaissement

L'écran opérationnel de caisse s'organise en deux zones complémentaires à 60/40 :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ [BARRE DE SESSION] Caisse N°1 | Caissier: Carine | Statut Réseau: En ligne │
├─────────────────────────────────────────┬───────────────────────────────────┤
│ [ZONE SÉLECTION PRODUITS (60%)]         │ [TICKET DE CAISSE EN COURS (40%)] │
│                                         │                                   │
│ [Barre de recherche / Scan Code-barre]  │ Client : Passager / Ibrahim       │
│                                         ├───────────────────────────────────┤
│ [Catégories : Tout | Vêtements | Soins] │ • 1x Pantalon Toile     12 500 F  │
│                                         │ • 2x Chemise Lin         8 000 F  │
│ ┌───────────┐ ┌───────────┐ ┌─────────┐ │ • Remise 10%            -1 250 F  │
│ │ Chemise   │ │ Pantalon  │ │ Veste   │ ├───────────────────────────────────┤
│ │  4 000 F  │ │ 12 500 F  │ │ 25 000 F│ │ SOUS-TOTAL :           19 250 F  │
│ └───────────┘ └───────────┘ └─────────┘ │ TAXES :                    0 F  │
│ ┌───────────┐ ┌───────────┐ ┌─────────┐ ├───────────────────────────────────┤
│ │ Polo      │ │ Ceinture  │ │ Robe    │ │ TOTAL NET À PAYER :               │
│ │  6 000 F  │ │  3 500 F  │ │ 18 000 F│ │    19 250 FCFA (En 32px Bold)     │
│ └───────────┘ └───────────┘ └─────────┘ ├───────────────────────────────────┤
│                                         │ [BOUTONS DE PAIEMENT TACTILES]    │
│                                         │ [ ESPÈCES ] [ MOBILE MONEY ]      │
│                                         │ [ VALIDER L'ENCAISSEMENT & TICKET]│
└─────────────────────────────────────────┴───────────────────────────────────┘
```

---

## 4. Parcours d'encaissement et calcul de monnaie

1. **Ajout d'article :** Un simple tap sur une tuile produit ou un scan code-barre ajoute immédiatement l'article au ticket avec quantité 1. Un deuxième tap incrémente la quantité.
2. **Encaissement en espèces avec calcul automatique du rendu :**
   * Affichage d'un pavé de coupures rapides pré-calculées (ex: pour 19 250 FCFA, boutons d'un tap : `20 000 F`, `25 000 F`, `50 000 F`).
   * Calcul géant et lisible du montant à rendre à la cliente (`Rendre : 750 FCFA` en vert très contrasté).
3. **Encaissement Mobile Money :**
   * Saisie du numéro de téléphone de l'acheteur $\rightarrow$ Déclenchement de la requête push USSD $\rightarrow$ Témoin visuel d'attente animé $\rightarrow$ Confirmation sonore et visuelle dès validation du telco.

---

## 5. Matériel de caisse et compatibilité opérationnelle

L'interface doit s'interfacer avec l'écosystème matériel standard des commerces :
* **Imprimantes thermiques de reçus (58mm et 80mm) :** Mise en page optimisée du ticket de caisse en texte monochrome contrasté sans images lourdes.
* **Tiroir-caisse automatique :** Envoi du signal d'ouverture dès validation du paiement en espèces.
* **Douchette / Lecteur code-barre USB ou Bluetooth :** Écoute globale des événements de saisie sans exiger que le curseur soit obligatoirement dans le champ de recherche.

---

## 6. Clôture de session et prévention des fraudes

* **Ouverture de caisse :** Saisie du fond de caisse initial au démarrage de la journée.
* **Clôture de caisse à l'aveugle (Blind Close) :** Le caissier compte et déclare le montant réel en espèces présent dans son tiroir avant que le système ne dévoile le chiffre théorique calculé, éliminant toute tentation de dissimulation des écarts.
* **Rapport X et Z :** Impression du rapport intermédiaire (X) et du rapport définitif de clôture journalière (Z) récapitulant les totaux espèces, MoMo et annulations.

---

## 7. Livrables types pour un module POS

1. **Spécification de l'écran tactile principal et ergonomie des tuiles.**
2. **Flux d'encaissement hybride (Espèces, Orange Money, MTN MoMo).**
3. **Maquette du ticket de caisse thermique (format 58mm/80mm).**
4. **Protocole de fonctionnement en mode déconnecté (IndexedDB/Local).**
5. **Processus d'ouverture, d'ajustement et de clôture de caisse.**
