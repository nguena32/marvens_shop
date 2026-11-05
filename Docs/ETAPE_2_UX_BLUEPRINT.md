# ETAPE_2_UX_BLUEPRINT.md
# Architecture de l'Information, Navigation et Parcours Utilisateurs — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 2 — Conception UX/UI et validation des thèmes  
**Agent :** Agent UX/UI & Design System (Google Antigravity)  
**Références :** `PLAN_REALISATION_APPLICATION.md`, `ETAPE_1_CADRAGE_MVP.md`, Framework Creative Brief (`04_UX_DESIGN/`).

---

## 1. Principes Directeurs d'Expérience Utilisateur (UX Principles)

1. **Mobile-First Radical & Économie de Données :**
   - 80%+ des visiteurs accèdent au mini-site via un lien partagé sur WhatsApp, Instagram ou Facebook sur smartphone avec connexion mobile (3G/4G).
   - Navigation fluide, boutons d'action d'une hauteur minimale de 44px (cibles tactiles confortables), formulaires simplifiés sans friction.
2. **Clarté de la Promesse & Transparence WhatsApp :**
   - L'acheteur sait exactement ce qui se passe lorsqu'il valide son panier : sa commande est enregistrée dans le système avec un numéro de référence unique (`#CMD-XXXX`), puis WhatsApp s'ouvre avec le récapitulatif prérempli.
   - L'interface ne prétend jamais qu'un message WhatsApp a été envoyé ni qu'un paiement a été perçu.
3. **Zéro Perte de Contexte lors des Changements de Thèmes :**
   - L'expérience d'achat reste rigoureusement identique quel que soit le thème actif (`Fashion`, `Bello`, etc.). Seuls les codes graphiques (typographie, couleurs, rayons, mises en page) s'adaptent.
4. **Administration Pragmatique et Lisible :**
   - Le tableau de bord du commerçant est conçu selon la rigueur du design suisse (*Swiss Editorial Commerce*) : contraste élevé, typographie lisible (*Inter*), gestion visuelle claire des statuts de commande (pastilles colorées).

---

## 2. Architecture de l'Information et Arborescence

### A. Storefront Public (Acheteur invité)

```
[Boutique Publique]
├── Accueil (/)
│   ├── En-tête : Logo, Nom boutique, Bouton Contact WhatsApp, Accès Panier (Badge)
│   ├── Bannière Hero : Proposition de valeur & Bouton d'accès direct Catalogue
│   ├── Grille Produits Mis en Avant (Highlights)
│   ├── Nouveautés & Promotions
│   ├── Réassurance : Commande directe WhatsApp, Livraison rapide, Retrait magasin
│   └── Pied de page : Coordonnées, Horaires, Liens légaux/pratiques, WhatsApp
│
├── Catalogue (/catalogue)
│   ├── Barre de recherche textuelle & Filtres rapides (Catégories, Prix, En stock)
│   ├── Grille des cartes produits (responsive 2 cols mobile / 4 cols desktop)
│   └── Pagination ou bouton de chargement progressif
│
├── Catégorie (/categorie/{slug})
│   ├── Titre et description de la catégorie
│   └── Grille filtrée des produits rattachés
│
├── Fiche Produit (/produit/{slug})
│   ├── Galerie photos avec sélecteur de miniature
│   ├── Informations produit : Titre, Référence/SKU, Badge stock, Prix & Promo
│   ├── Sélecteur de Variantes (Tailles, Couleurs)
│   ├── Sélecteur de Quantité (- 1 +)
│   ├── Bouton Primaire « Ajouter au panier »
│   ├── Bouton Secondaire « Commander directement sur WhatsApp »
│   ├── Onglets/Blocs déroulants : Description détaillée, Livraison & Retours
│   └── Carrousel de Produits Similaires
│
├── Panier (/panier)
│   ├── Liste des articles : Photo, Nom, Variante choisie, Prix unitaire, Quantité modifiable, Supprimer
│   ├── Résumé des coûts : Sous-total produits, Frais de livraison estimés
│   ├── Bouton « Procéder à la commande »
│   └── État panier vide : Illustration + Bouton « Découvrir le catalogue »
│
├── Prise de commande / Checkout (/checkout)
│   ├── Étape 1 : Coordonnées (Nom complet, Numéro WhatsApp obligatoire)
│   ├── Étape 2 : Mode de réception (Livraison à domicile / Retrait boutique)
│   │   └── Si livraison : Ville, Quartier, Adresse ou repère, Frais associés
│   ├── Étape 3 : Mode de règlement prévu (Paiement à la livraison / Virement / En boutique)
│   ├── Notes / Instructions particulières pour le commerçant
│   ├── Récapitulatif final du total (calculé côté serveur)
│   └── Bouton d'action sécurisé « Confirmer la commande »
│
└── Confirmation de commande (/commande/confirmation/{order_number})
    ├── Badge de succès « Commande enregistrée avec succès »
    ├── Numéro de commande mis en évidence (#CMD-YYYYMMDD-XXXX)
    ├── Encadré d'action prioritaire : Bouton « Ouvrir WhatsApp pour finaliser »
    ├── Texte explicatif transparent (« Cliquez pour transmettre votre commande à la boutique »)
    └── Récapitulatif complet imprimable/consultable
```

### B. Dashboard d'Administration (`merchant_admin`)

```
[Dashboard Privé] (/admin)
├── Authentification (/admin/login)
│   └── Formulaire : Nom d'utilisateur / Email, Mot de passe, CSRF token, Alerte brute-force
│
├── Tableau de bord principal (/admin/dashboard)
│   ├── Baromètre d'activité : CA estimé, Commandes en attente, Commandes du jour, Total produits
│   ├── Tableau des dernières commandes avec pastilles de statuts
│   └── Raccourcis rapides : Ajouter un produit, Changer de thème, Paramètres WhatsApp
│
├── Gestion des Commandes (/admin/commandes)
│   ├── Liste paginée avec recherche par numéro/nom et filtres par statut
│   └── Détail de commande (/admin/commandes/{id}) :
│       ├── Fiche client et coordonnées (avec bouton direct pour contacter sur WhatsApp)
│       ├── Lignes de commande (produits, variantes, prix, total)
│       ├── Historique et sélecteur de changement de statut (Pending -> Confirmed -> etc.)
│       └── Statut du paiement manuel (Non payé / Payé)
│
├── Gestion du Catalogue
│   ├── Liste des Produits (/admin/produits) : Filtre catégorie, statut actif/inactif, prix, stock
│   ├── Ajout/Édition Produit (/admin/produits/nouveau, /admin/produits/editer/{id}) :
│   │   ├── Nom, slug, référence SKU, catégorie, description
│   │   ├── Prix de base, prix promotionnel
│   │   ├── Gestion des variantes (tailles, couleurs, stock par variante)
│   │   ├── Upload sécurisé de photos (image principale + galerie)
│   │   └── Interrupteur « Publié sur la boutique »
│   └── Gestion des Catégories (/admin/categories) : Nom, slug, image, ordre
│
├── Bibliothèque de Thèmes & Apparence (/admin/themes)
│   ├── Galerie des thèmes disponibles (cartes avec preview `screen.png`)
│   ├── Bouton « Activer ce thème » avec modal de confirmation
│   └── Personnalisation visuelle : Saisie des couleurs clés (Primaire, Secondaire)
│
├── Importation de Données (/admin/import)
│   ├── Import CSV : Téléchargement gabarit type, téléversement de fichier, rapport de résultat
│   └── Connecteur Meta Catalogue : Interface de configuration / statut de connexion API
│
└── Paramètres de la boutique (/admin/parametres)
    ├── Informations générales : Nom commercial, Logo, Favicon, Devise (FCFA)
    ├── Numéro WhatsApp de réception des commandes (avec indicatif international)
    ├── Livraison : Forfaits par quartier / ville, Retrait en boutique
    └── Sécurité & Profil : Modification du mot de passe administrateur
```

---

## 3. Parcours Utilisateurs Détaillés (User Journeys)

### Parcours 1 : L'acheteur découvre un produit et commande via WhatsApp
1. **Accès :** Le client clique sur un lien partagé (ex: `https://boutique.cm/produit/robe-sahara`).
2. **Consultation :** La fiche produit s'affiche instantanément. Il consulte les photos, sélectionne sa taille (ex: `M`), sa couleur (ex: `Caramel`).
3. **Action Panier :** Il clique sur « Ajouter au panier ». Un toast de confirmation apparaît et le badge panier s'incrémente (`1`).
4. **Validation Panier :** Il clique sur le panier, vérifie son article et clique sur « Commander ».
5. **Checkout :** Il saisit son nom (*Amina N.*), son numéro WhatsApp (*699000000*), choisit « Livraison à domicile », sélectionne son quartier (*Douala - Akwa*). Le montant total est recalculé en temps réel (Sous-total 15 000 FCFA + Livraison 1 500 FCFA = 16 500 FCFA).
6. **Soumission sécurisée :** Il clique sur « Confirmer la commande ».
7. **Traitement serveur :** Le serveur valide les prix en base, persiste la commande `#CMD-20261105-0042`, initialise le statut à `En attente`.
8. **Confirmation & Redirection :** La page de confirmation s'affiche avec le bouton WhatsApp vert. En cliquant dessus, l'application WhatsApp s'ouvre avec le message structuré prêt à l'envoi.

### Parcours 2 : Le commerçant traite la commande dans le dashboard
1. **Notification :** Le commerçant reçoit le message WhatsApp du client contenant `#CMD-20261105-0042`.
2. **Accès Dashboard :** Il ouvre `/admin/commandes`, recherche `0042`.
3. **Consultation :** Il vérifie la disponibilité effective de la robe en taille M.
4. **Mise à jour :** Il passe le statut de la commande de `En attente` à `Confirmée`.
5. **Échange :** Il répond au client sur WhatsApp pour convenir de l'heure exacte de livraison.
6. **Paiement & Clôture :** Une fois le client livré et le règlement en espèces perçu, le commerçant passe le statut à `Payée` puis `Livrée`.

### Parcours 3 : Le commerçant change de thème graphique
1. **Accès :** Le commerçant va sur `/admin/themes`.
2. **Exploration :** Il visualise le thème actuel (`Fashion`) et découvre `Theme bello.zip`.
3. **Sélection :** Il clique sur « Activer le thème Bello ». Une modale de réassurance lui rappelle : *« Vos produits, photos, commandes et paramètres restent 100% intacts »*.
4. **Validation :** Il confirme. La variable de session / paramètre est mise à jour.
5. **Résultat :** En retournant sur la boutique publique, le design a adopté les polices, couleurs et cartes de Bello. Aucune donnée commerciale n'a été altérée.

---

## 4. États de Navigation et Gestion des Erreurs

- **Panier vide :** Écran bienveillant présentant une icône de sac vide, un message chaleureux (*« Votre panier est encore vide »*) et un bouton direct vers le catalogue.
- **Produit en rupture de stock :** Badge gris/rouge `Rupture de stock`, bouton « Ajouter au panier » désactivé avec mention explicite, bouton WhatsApp maintenu avec message : *« Bonjour, ce produit est en rupture, prévoyez-vous un réapprovisionnement ? »*.
- **Erreur de validation checkout :** Messages d'erreur explicites sous chaque champ invalide (ex: *« Le numéro WhatsApp est obligatoire pour vous contacter »*), conservation des valeurs déjà saisies.
- **Échec technique ou 404 :** Page d'erreur personnalisée intégrée au thème avec bouton de retour à l'accueil.
