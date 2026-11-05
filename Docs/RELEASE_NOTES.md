# RELEASE_NOTES.md
# Notes de Version — Marvens Shop MVP v1.0.0

**Date de version :** 05 novembre 2026  
**Étape :** Clôture Étape 5 / Livraison finale du MVP  
**Modèle :** Instance e-commerce dédiée par commerçant (Script installé cPanel)

---

## 1. Fonctionnalités Livrées

- **Storefront Public (Thème Fashion par défaut) :**
  - Page d'accueil avec bannières, accroche commerciale et articles mis en avant.
  - Catalogue complet avec recherche en direct et filtres par catégories.
  - Fiche détaillée de produit avec galerie photos, variantes (tailles, couleurs), sélecteur de quantité et double CTA (Ajout panier / Commande WhatsApp directe).
- **Panier & Checkout Sécurisé :**
  - Gestion du panier en session avec recalcul autoritaire des prix côté serveur (`MS-BIZ-03`).
  - Prise de commande fluide en 1 page avec choix du mode de livraison ou retrait magasin.
  - Enregistrement immédiat de la commande avec numéro unique (`#CMD-YYYYMMDD-XXXX`) **avant** redirection vers WhatsApp (`MS-BIZ-04`).
  - Redirection WhatsApp avec message de commande prérempli et encodé.
- **Tableau de Bord Administrateur (Thème Swiss Editorial Commerce) :**
  - Authentification sécurisée anti-brute force et protection CSRF.
  - Métriques d'activité en temps réel (Commandes en attente, CA réalisé sur commandes payées).
  - Traitement complet des commandes avec historique des transitions et bouton direct pour contacter le client sur WhatsApp.
  - Gestion CRUD du catalogue et téléversement sécurisé d'images.
  - Galerie de thèmes (`Fashion`, `Bello`, `Luxe`) : changement d'apparence sans altération des données (`MS-BIZ-07`).
- **Intégrations & Imports :**
  - Importation de catalogue par fichier CSV avec validation ligne par ligne et rapport d'anomalies.
  - Connecteur Meta prêt pour activation OAuth / Graph API dès fourniture des identifiants API par le commerçant.

---

## 2. Décision de Livraison : GO

> **DÉCISION : GO — MVP PRÊT POUR DÉPLOIEMENT CONTRÔLÉ**  
> L'ensemble des 23 tests automatisés (fondations, sécurité, logique métier, intégrité des données, imports) sont à **100 % de succès**. L'application est prête à être installée chez le premier commerçant pilote conformément aux spécifications du plan de réalisation.
