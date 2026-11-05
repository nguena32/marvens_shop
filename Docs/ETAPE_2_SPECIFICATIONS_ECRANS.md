# ETAPE_2_SPECIFICATIONS_ECRANS.md
# Spécifications Détaillées des Écrans MVP — Marvens Shop

**Date :** 05 novembre 2026  
**Étape :** Étape 2 — Conception UX/UI et validation des thèmes  
**Agent :** Agent UX/UI & Design System (Google Antigravity)  
**Références :** `PLAN_REALISATION_APPLICATION.md`, `Docs/maquettes/`.

---

## 1. Écrans du Storefront Public (Boutique)

### Écran S1 : Page d'Accueil (`/`)
- **Rôle :** Vitrine commerciale et point d'entrée principal.
- **Zones :**
  - Header persistant (Logo, Liens catégories, Badge Panier avec compteur).
  - Bannière Hero d'impact (Slogan vendeur, bouton d'appel direct vers le catalogue).
  - Section « Produits Vedettes » (Grille de 4 à 8 cartes produits avec badges nouveauté/promo).
  - Bandeau de contact direct WhatsApp flottant ou ancré.
  - Footer de réassurance (Informations livraison, modes de règlement, mentions légales).
- **États traités :** Normal, Chargement des images (skeleton SVG), Aucune mise en avant configurée (masquage propre de la section).

### Écran S2 : Catalogue Général & Catégories (`/catalogue`, `/categorie/{slug}`)
- **Rôle :** Exploration et recherche de produits.
- **Zones :**
  - Barre d'outils supérieure : Champ de recherche avec filtre dynamique, menu déroulant de tri (Prix croissant, décroissant, Plus récents).
  - Filtres par catégorie sous forme de pilules cliquables horizontales à défilement tactile sur mobile.
  - Grille responsive : 2 colonnes sur smartphone, 3 sur tablette, 4 sur desktop.
- **États traités :** Liste normale, Aucun résultat de recherche (*« Aucun produit ne correspond à votre recherche »* avec bouton pour réinitialiser les filtres).

### Écran S3 : Fiche Produit Détaillée (`/produit/{slug}`)
- **Rôle :** Déclenchement de l'intention d'achat ou contact direct WhatsApp.
- **Zones :**
  - Galerie d'images : Grande photo principale avec navigation tactile (swipe) et miniatures en dessous.
  - Bloc Titre & Référence SKU.
  - Ligne de prix avec mention explicite du FCFA et badge de réduction si promotion.
  - Sélecteur de Variantes : Boutons pilules pour les tailles (S, M, L, XL) et pastilles chromatiques pour les couleurs.
  - Sélecteur de quantité numérique borné entre 1 et le stock disponible.
  - Double CTA : Bouton principal « Ajouter au panier » (ambre/noir) et Bouton secondaire « Commander directement sur WhatsApp » (vert officiel).
  - Accordéons repliables : « Description complète », « Frais & Délais de livraison ».
  - Carrousel de produits similaires en pied de page.
- **États traités :** Produit en stock, Variante spécifique indisponible (désactivation du bouton d'ajout), Rupture totale de stock.

### Écran S4 : Panier (`/panier`)
- **Rôle :** Récapitulation et ajustement avant validation.
- **Zones :**
  - Tableau / Liste des articles : Photo miniature, Nom du produit, Variante sélectionnée, Prix unitaire, Contrôle de quantité `[-] [+]`, Bouton poubelle.
  - Encadré récapitulatif : Sous-total des produits, Mention des frais de livraison ajoutés à l'étape suivante.
  - Bouton d'action proéminent : « Valider la commande » (pleine largeur sur mobile).
- **États traités :** Panier avec articles, Panier vide (visuel convivial + bouton vers catalogue).

### Écran S5 : Prise de Commande / Checkout (`/checkout`)
- **Rôle :** Collecte des informations nécessaires à la livraison et enregistrement serveur.
- **Zones (Formulaire optimisé 1 page) :**
  - Section Coordonnées : Champ Nom & Prénom, Champ Téléphone WhatsApp (avec indicatif `+237` par défaut).
  - Section Réception : Choix radio entre « Livraison à domicile » et « Retrait gratuit en magasin ».
    - Si livraison : Liste déroulante des Villes / Quartiers configurés, champ texte pour repères ou adresse précise.
  - Section Règlement prévu : Mention transparente « Paiement à la livraison » ou « Règlement en magasin ».
  - Champ libre : Instructions ou remarques pour le livreur.
  - Bloc Total finalisé : Total produits + Frais de livraison = **TOTAL NET EN FCFA**.
  - Bouton de soumission : « Confirmer et enregistrer ma commande ».
- **États traités :** Validation côté client et validation stricte serveur (affichage des erreurs sous chaque champ en rouge sans perte des données déjà saisies).

### Écran S6 : Confirmation de Commande (`/commande/confirmation/{order_number}`)
- **Rôle :** Réassurance immédiate et bascule vers WhatsApp.
- **Zones :**
  - En-tête de célébration avec coche verte de succès.
  - Encadré mis en avant : Numéro de commande immuable (ex: `#CMD-20261105-0042`).
  - **Zone d'action WhatsApp prioritaire :** Grand bouton vert WhatsApp invitant le client à cliquer pour envoyer sa commande préremplie au commerçant.
  - Message de transparence : *« Votre commande est bien enregistrée dans notre système. Cliquez sur le bouton ci-dessus pour envoyer le récapitulatif au commerçant sur WhatsApp et convenir de la livraison. »*
  - Récapitulatif imprimable ou téléchargeable des détails de la commande.

---

## 2. Écrans du Dashboard d'Administration (Commerce)

### Écran A1 : Connexion Administrateur (`/admin/login`)
- **Rôle :** Accès sécurisé réservé au commerçant.
- **Zones :**
  - Carte centrée épurée sur fond blanc avec logo Marvens Shop.
  - Champs : Identifiant / Email, Mot de passe, Bouton afficher/masquer le mot de passe.
  - Jeton CSRF masqué et protection anti-brute force (temporisation après 5 échecs consécutifs).

### Écran A2 : Tableau de Bord Accueil (`/admin/dashboard`)
- **Rôle :** Vue hélicoptère des performances commerciales et alertes opérationnelles.
- **Zones :**
  - Grille de 4 cartes KPI : Chiffre d'affaires réalisé (commandes payées/livrées), Commandes en attente d'action, Total commandes de la semaine, Nombre d'articles actifs.
  - Tableau des 5 dernières commandes reçues avec pastille de statut et bouton d'action rapide.
  - Alerte de stock bas le cas échéant.

### Écran A3 : Gestion des Commandes (`/admin/commandes`, `/admin/commandes/{id}`)
- **Rôle :** Traitement complet du cycle de vie commercial.
- **Zones (Liste) :**
  - Filtres par onglets de statut : Toutes, En attente, Confirmées, En livraison, Livrées.
  - Barre de recherche par numéro de commande ou nom du client.
- **Zones (Détail d'une commande) :**
  - Fiche d'identité client : Nom, Numéro WhatsApp avec bouton direct `Cliquer pour discuter`, Adresse/Quartier de livraison.
  - Liste des articles commandés, variantes et quantités.
  - Sélecteur de transition de statut contrôlé par machine à états.
  - Bouton de confirmation manuelle du paiement (Bascule Non payé / Payé).
  - Journal d'historique de la commande (Date de création, transitions d'états enregistrées).

### Écran A4 : Gestion du Catalogue (`/admin/produits`, `/admin/produits/form`)
- **Rôle :** Création, mise à jour et organisation des articles.
- **Zones :**
  - Liste : Tableau avec vignette photo, Nom, SKU, Catégorie, Prix FCFA, Statut Publié (interrupteur on/off rapide).
  - Formulaire Produit :
    - Onglet Général : Nom, slug, catégorie parente, description riche simplifiée, référence SKU.
    - Onglet Tarification : Prix public, Prix promo (avec dates d'activation optionnelles).
    - Onglet Variantes : Générateur de combinaisons Tailles x Couleurs avec gestion de quantité propre.
    - Onglet Médias : Zone de glisser-déposer d'images avec prévisualisation et choix de la photo principale.

### Écran A5 : Galerie de Thèmes & Apparence (`/admin/themes`)
- **Rôle :** Sélection et personnalisation graphique de la boutique.
- **Zones :**
  - Galerie de cartes présentant chaque thème disponible (`Fashion`, `Bello`, `Luxe`, `Naya`, `Shop`) avec sa capture d'écran de prévisualisation, ses caractéristiques et un badge `ACTIF` sur le thème en cours.
  - Bouton « Activer ce thème » avec modale de confirmation garantissant l'intégrité des données commerciales.
  - Section personnalisation : Sélecteur de couleur principale et secondaire avec aperçu en direct.

### Écran A6 : Importation Catalogue (`/admin/import`)
- **Rôle :** Chargement rapide de données produits.
- **Zones :**
  - Bloc Import CSV : Bouton de téléchargement du modèle CSV standard, zone de téléversement de fichier `.csv`, bouton de lancement.
  - Rapport d'exécution immédiat : Nombre de produits créés, mis à jour, ignorés ou en erreur (avec détail de la ligne défaillante).
  - Bloc Connecteur Meta : Statut de l'intégration, bouton de reconnexion / configuration des jetons API.

### Écran A7 : Paramètres de la Boutique (`/admin/parametres`)
- **Rôle :** Configuration opérationnelle de l'instance.
- **Zones :**
  - Onglet Boutique : Nom commercial, Logo, Favicon, Devise par défaut (`FCFA`), Fuseau horaire (`Africa/Douala`).
  - Onglet WhatsApp : Numéro commercial destinataire des commandes préremplies avec test d'envoi.
  - Onglet Livraison : Configuration des modes (Retrait boutique, Livraison à domicile) et tableau d'édition des forfaits par quartier.
  - Onglet Sécurité : Changement de mot de passe administrateur et clôture des autres sessions actives.
