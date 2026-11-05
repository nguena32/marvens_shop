# FORMS AND TABLES — Formulaires de Saisie et Tableaux de Gestion
## MARVENS CREATIVE BRIEF V1.0 · PHASE 05_UI_DESIGN

> **Document :** Référentiel de conception ergonomique des formulaires, contrôles de saisie, tableaux de données et actions de masse  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [UI_GUIDELINES.md](UI_GUIDELINES.md) · [LAYOUT_SYSTEM.md](LAYOUT_SYSTEM.md) · [COMPONENT_DESIGN.md](COMPONENT_DESIGN.md) · [ACCESSIBILITY.md](../04_UX_DESIGN/ACCESSIBILITY.md)

---

## Sommaire

1. [Rôle critique des formulaires et tableaux dans les outils B2B](#1-rôle-critique-des-formulaires-et-tableaux-dans-les-outils-b2b)
2. [Conception des formulaires de saisie](#2-conception-des-formulaires-de-saisie)
   - 2.1 Principes d'organisation cognitive et séquençage
   - 2.2 Anatomie d'un champ : Labels, placeholders, aides contextuelles
   - 2.3 Distinction obligatoire : Champs requis vs facultatifs
   - 2.4 Typologie des contrôles de saisie selon la nature de la donnée
   - 2.5 Masques de saisie et formats locaux CEMAC (Téléphone, Monnaie, Dates)
   - 2.6 Stratégie de validation (Au fil de l'eau, Perte de focus, Soumission)
   - 2.7 Messages d'erreur opérants et aides à la résolution
   - 2.8 Gestion des formulaires longs et assistants multi-étapes (Wizards)
   - 2.9 Téléversement de fichiers et pièces jointes (Justificatifs, reçus)
   - 2.10 Sécurité de la saisie et masquage des données sensibles
3. [Conception des tableaux de données (Data Tables)](#3-conception-des-tableaux-de-données-data-tables)
   - 3.1 Choix de restitution : Tableau, liste ou cartes
   - 3.2 Structure anatomique et composition d'un tableau de gestion
   - 3.3 Règles rigoureuses d'alignement des colonnes
   - 3.4 Recherche, filtrage multicritères et facettes
   - 3.5 Tri mono et multi-colonnes
   - 3.6 Pagination, défilement infini et sélecteur de volume
   - 3.7 Sélection de lignes et actions groupées (Bulk Actions)
   - 3.8 Colonnes fixes (Sticky Columns) et défilement horizontal maîtrisé
   - 3.9 Gestion de la densité visuelle d'affichage
   - 3.10 Matrice des états d'un tableau (Vide, Chargement, Erreur, Partiel)
   - 3.11 Adaptation responsive des tableaux sur écrans mobiles
4. [Opérations de gestion avancées (Export, Impression, Traçabilité)](#4-opérations-de-gestion-avancées-export-impression-traçabilité)
5. [Checklist de conformité formulaires et tableaux](#5-checklist-de-conformité-formulaires-et-tableaux)

---

## 1. Rôle critique des formulaires et tableaux dans les outils B2B

Dans les progiciels de gestion d'entreprise, les logiciels de caisse (POS), les CRM et les plateformes SaaS de Marvens Group, **les formulaires et les tableaux constituent le cœur de la valeur d'usage**. C'est là que les opérateurs passent 80 % de leur journée de travail à saisir des commandes, contrôler des stocks, valider des encaissements Mobile Money et éditer des états comptables.

Une erreur d'ergonomie sur un formulaire engendre des pertes de temps considérables et des erreurs financières ; un tableau mal pensé paralyse la prise de décision. Le standard **Contextual Design · Premium Quality** exige une rigueur mathématique dans leur agencement.

---

## 2. Conception des formulaires de saisie

### 2.1 Principes d'organisation cognitive et séquençage
- **Flux vertical linéaire :** Privilégier une disposition en une seule colonne. Les études oculométriques démontrent qu'un formulaire sur une seule colonne permet une vitesse de lecture et de complétion 40 % plus rapide qu'une grille multi-colonnes complexe.
- **Exceptions autorisées aux multi-colonnes :** Uniquement pour les couples de données indissociables (ex. `Prénom` et `Nom`, `Code postal` et `Ville`, `Date de début` et `Date de fin`).
- **Regroupement logique (Fieldsets / Cartes) :** Segmenter les formulaires de plus de 6 champs en sections thématiques clairement titrées (ex. `Informations générales`, `Coordonnées de facturation`, `Modalités de règlement`).

### 2.2 Anatomie d'un champ : Labels, placeholders, aides contextuelles

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. LIBELLÉ DU CHAMP (Label permanent)                 [Obligatoire *]       │
│ ┌─────────────────────────────────────────────────────────────────────────┐ │
│ │ 2. ZONE DE SAISIE (Input)             [3. Icône de statut / Aide]       │ │
│ └─────────────────────────────────────────────────────────────────────────┘ │
│ 4. MESSAGE D'AIDE OU D'ERREUR (Help / Error text)                           │
└─────────────────────────────────────────────────────────────────────────────┘
```

1. **Label permanent supérieur :** Toujours positionné au-dessus du champ. L'étiquette ne doit jamais être remplacée par un texte fantôme (*placeholder*).
2. **Texte de substitution (*Placeholder*) :** Doit fournir un exemple de format valide (ex. `ex. 690 12 34 56`), jamais une instruction indispensable qui disparaît dès le premier caractère saisi.
3. **Texte d'aide (*Helper text*) :** Situé sous le champ, il précise les contraintes avant la saisie (ex. `Format attendu : 9 chiffres sans indicatif`).
4. **Message d'erreur (*Validation error*) :** Remplace le texte d'aide en rouge dès qu'une anomalie est constatée, en explicitant comment la corriger.

### 2.3 Distinction obligatoire : Champs requis vs facultatifs
- Les champs obligatoires comportent un astérisque rouge contrasté `*` accolé au label, avec une mention explicite en en-tête de formulaire : `Les champs marqués d'un * sont obligatoires`.
- Si la grande majorité des champs est obligatoire, préférer la mention discrète `(facultatif)` sur les rares champs optionnels afin d'alléger la charge visuelle.

### 2.4 Typologie des contrôles de saisie selon la nature de la donnée
- **Moins de 4 options mutuellement exclusives :** Utiliser des boutons radio (`Radio Buttons`) ou un composant de pilules segmentées (*Segmented Control*), permettant de voir toutes les options d'un coup d'œil.
- **De 5 à 15 options :** Utiliser une liste déroulante native (`<select>`).
- **Plus de 15 options ou liste dynamique (Clients, Articles) :** Utiliser un champ de recherche avec autocomplétion (*Combobox / Autocomplete*).
- **Choix binaire isolé :** Utiliser une case à cocher unique (`Checkbox`) pour un consentement (ex. `J'accepte les conditions`), ou un `Switch` pour un réglage de configuration à effet immédiat.

### 2.5 Masques de saisie et formats locaux CEMAC (Téléphone, Monnaie, Dates)
Le système contextualise automatiquement la saisie pour l'Afrique francophone :
- **Numéros de téléphone :** Pré-remplissage de l'indicatif international avec détection automatique (+237 pour le Cameroun, +241 pour le Gabon, etc.) et formatage automatique des espaces pendant la frappe : `670 00 00 00`.
- **Montants en Francs CFA (XAF) :** Séparateurs automatiques de milliers à la saisie, alignement numérique à droite, symbole FCFA fixe en suffixe non modifiable.
- **Dates :** Sélecteur de date calendrier respectant le premier jour de semaine au lundi et format d'affichage standardisé `JJ/MM/AAAA`.

### 2.6 Stratégie de validation
1. **Validation immédiate (au fil de l'eau) :** Réservée aux indicateurs de format progressif (ex. force du mot de passe, compteur de caractères restants). Ne pas marquer un champ en rouge avant que l'utilisateur n'ait terminé sa saisie.
2. **Validation à la perte de focus (*On Blur*) :** C'est le moment idéal pour contrôler la syntaxe (email valide, numéro de téléphone complet) et afficher immédiatement une coche verte de succès ou le message d'erreur.
3. **Validation à la soumission (*On Submit*) :** Contrôle d'intégrité global. En cas d'erreurs multiples, afficher un bandeau récapitulatif en haut du formulaire et déplacer automatiquement le focus clavier sur le premier champ invalide (*Auto-focus on first error*).

### 2.7 Messages d'erreur opérants et aides à la résolution
Un message d'erreur doit impérativement respecter la règle des trois éléments : **Localisation + Constat du problème + Voie de résolution**.

- ❌ *À proscrire :* `Donnée invalide`, `Erreur système`, `Format incorrect`.
- Recommandé : `Le numéro Orange Money doit comporter 9 chiffres. Exemple : 690 12 34 56.`

### 2.8 Gestion des formulaires longs et assistants multi-étapes (Wizards)
Lorsque le processus métier requiert plus de 10 champs (ex. immatriculation d'une nouvelle entreprise ou souscription complexe) :
- Découper en 3 à 5 étapes séquentielles cohérentes.
- Intégrer un fil d'ariane d'étapes (*Stepper*) visualisant : Étapes terminées (coche verte), Étape en cours (numéro en gras surligné), Étapes à venir (grisées).
- Persistance automatique : Sauvegarde automatique de l'état en session ou localement pour éviter toute perte de données en cas de coupure de réseau.

### 2.9 Téléversement de fichiers et pièces jointes (Justificatifs, reçus)
- Présenter une zone de glisser-déposer (*Dropzone*) claire avec bouton de secours `Parcourir les fichiers`.
- Préciser immédiatement les formats admis et le poids maximal : `Formats acceptés : PDF, JPG, PNG (Max 5 Mo)`.
- Prévisualisation immédiate du fichier téléversé avec vignette, nom complet, taille en Ko, et bouton de suppression direct (`Poubelle`).

### 2.10 Sécurité de la saisie et masquage des données sensibles
- Les champs de mot de passe intègrent un bouton d'affichage contextuel (icône œil) pour basculer temporairement entre caractères masqués (`••••••`) et texte en clair.
- Pour les codes PIN d'autorisation ou validation Mobile Money, n'afficher que des tirets sécurisés et neutraliser l'enregistrement automatique du navigateur si la machine est partagée.

---

## 3. Conception des tableaux de données (Data Tables)

### 3.1 Choix de restitution : Tableau, liste ou cartes
- **Tableau tabulaire complet :** Recommandé pour comparer plusieurs attributs sur de nombreuses lignes (comptabilité, logs, inventaires de stock).
- **Cartes empilées (*Grid Cards*) :** Recommandé pour des contenus visuels ou hétérogènes (fiches collaborateurs avec photos, catalogue de produits e-commerce).
- **Liste simple :** Recommandé pour les flux chronologiques courts ou les historiques mobiles.

### 3.2 Structure anatomique et composition d'un tableau de gestion

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. BARRE D'OUTILS TABLEAU (Recherche, Filtres rapides, Bouton Export)        │
├───────┬──────────────────┬──────────────┬──────────────┬──────────┬─────────┤
│ [ ]   │ 2. RÉFÉRENCE     │ CLIENT       │ DATE         │ MONTANT  │ STATUT  │
├───────┼──────────────────┼──────────────┼──────────────┼──────────┼─────────┤
│ [ ]   │ FAC-2026-0012    │ Bocom S.A.   │ 30/10/2026   │ 450 000  │ [Payé]  │
│ [ ]   │ FAC-2026-0013    │ Camlait S.A. │ 31/10/2026   │ 125 000  │ [Att.]  │
├───────┴──────────────────┴──────────────┴──────────────┴──────────┴─────────┤
│ 3. PIED DE TABLEAU (Pagination : 1-10 sur 148 | Lignes par page: [25]       │
└─────────────────────────────────────────────────────────────────────────────┘
```

### 3.3 Règles rigoureuses d'alignement des colonnes

| Type de donnée | Alignement typographique | Justification ergonomique |
|---|---|---|
| **Texte alphabétique (Noms, Titres, Réf.)** | **Aligné à gauche** | Sens naturel de lecture occidentale de gauche à droite. |
| **Nombres, Quantités et Montants FCFA** | **Aligné à droite** | Permet l'alignement vertical des unités, dizaines et centaines. |
| **Dates et Horodatages** | **Aligné à gauche ou centré** | Longueur de chaîne constante permettant un calage propre. |
| **Statuts, Badges et Pastilles** | **Centré ou aligné à gauche** | Visibilité immédiate du code couleur. |
| **Actions de ligne (Éditer, Supprimer)** | **Aligné à droite** | Ancrage fixe en fin de ligne, évitant de masquer les données. |

### 3.4 Recherche, filtrage multicritères et facettes
- **Champ de recherche rapide en direct :** Positionné en haut à gauche du tableau, filtrant instantanément les lignes visibles avec mise en surbrillance (*highlight*) des termes trouvés.
- **Filtres par pilules actives (*Filter Chips*) :** Les filtres sélectionnés (ex. `Statut : Payé`, `Période : Ce mois`) s'affichent sous forme de tags amovibles au-dessus du tableau avec une commande générale `Réinitialiser les filtres`.

### 3.5 Tri mono et multi-colonnes
- Les colonnes triables comportent une double flèche discrète dans l'en-tête (`↕`).
- Lors du clic, l'en-tête s'active en affichant une flèche unique contrastée (`↑` croissant ou `↓` décroissant) et l'ensemble de la colonne triée reçoit un léger voile de fond pour souligner le critère d'ordonnancement.

### 3.6 Pagination, défilement infini et sélecteur de volume
- **Privilégier la pagination classique dans les outils de gestion :** Le défilement infini (*infinite scroll*) est proscrit pour les tableaux comptables car il empêche d'atteindre le pied de page et égare l'opérateur.
- La pagination doit toujours afficher :
  - L'intervalle courant et le volume total : `Affichage de 1 à 25 sur 248 éléments`.
  - Le sélecteur de taille de lot : `Afficher par : 10 | 25 | 50 | 100`.
  - Les contrôles de saut : Boutons `Précédent`, numéros de pages directes, bouton `Suivant`.

### 3.7 Sélection de lignes et actions groupées (Bulk Actions)
- Case à cocher en en-tête de première colonne permettant de sélectionner l'ensemble des éléments de la page en cours.
- Dès qu'au moins une ligne est cochée, une **barre d'actions flottante contextuelle** apparaît au bas ou au sommet du tableau : `3 factures sélectionnées | [Télécharger PDF] [Relancer par SMS] [Supprimer]`.

### 3.8 Colonnes fixes (Sticky Columns) et défilement horizontal maîtrisé
- Pour les tableaux volumineux excédant la largeur de l'écran :
  - L'en-tête de tableau reste fixe lors du défilement vertical (`position: sticky; top: 0`).
  - La première colonne (Identifiant ou Nom) et la dernière colonne (Actions) restent figées latéralement tandis que les colonnes centrales défilent horizontalement.
  - Une ombre portée subtile signale la frontière entre les colonnes figées et les colonnes mobiles.

### 3.9 Gestion de la densité visuelle d'affichage
Offrir si pertinent un commutateur de densité :
- **Vue Confortable :** Hauteur de ligne de 52px (recommandée sur écrans tactiles).
- **Vue Standard :** Hauteur de ligne de 42px (équilibre parfait pour le reporting quotidien).
- **Vue Compacte :** Hauteur de ligne de 32px (idéale pour les comptables et auditeurs examinant des centaines de lignes).

### 3.10 Matrice des états d'un tableau
- **État Initial / Données chargées :** Tableau complet prêt à la consultation.
- **État Loading :** Lignes squelettes grisées animées simulant la hauteur et la largeur des colonnes.
- **État Vide initial (*No Data*) :** Composant d'état vide centré avec invitation à créer la première entrée.
- **État Aucun résultat (*No Search Results*) :** Message explicite : `Aucun résultat ne correspond à votre recherche "xyz" | [Effacer les filtres]`.
- **État Erreur de chargement :** Message d'alerte avec bouton `Réessayer` sans recharger l'ensemble de la page.

### 3.11 Adaptation responsive des tableaux sur écrans mobiles
Sur un écran de smartphone (< 768px), le tableau se transforme automatiquement :
```
┌─────────────────────────────────────────────────────────────────────────────┐
│ CARTE MOBILE (Transformation d'une ligne de tableau)                        │
├─────────────────────────────────────────────────────────────────────────────┤
│ Facture #FAC-2026-0012                                  [Badge : Payé]      │
│ Client : Bocom Petroleum S.A.                           Date : 30/10/2026   │
│ MONTANT TOTAL : 450 000 FCFA                                                │
├─────────────────────────────────────────────────────────────────────────────┤
│ [Télécharger Reçu PDF]                                 [Détails / Éditer]   │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Opérations de gestion avancées (Export, Impression, Traçabilité)

- **Bouton d'exportation standardisé :** Menu déroulant proposant systématiquement les deux formats pivots : `Exporter en Excel (.xlsx / .csv)` et `Imprimer / Générer PDF`.
- **Règles pour les feuilles de style d'impression (`@media print`) :**
  - Masquage automatique de la sidebar, des headers, des boutons d'action et de la pagination.
  - Fond forcé en blanc pur (`#FFFFFF`), textes en noir absolu (`#000000`) pour économiser l'encre et garantir la lisibilité physique.
  - Ajout automatique de la mention de traçabilité en bas de page imprimée : `Document édité le 31/10/2026 à 17:00 par [Nom Utilisateur] via Marvens ERP`.

---

## 5. Checklist de conformité formulaires et tableaux

| # | Règle d'ingénierie fonctionnelle | Vérification effectuée | Statut |
|---|---|---|---|
| **01** | Labels permanents | Aucun champ ne repose uniquement sur un placeholder | [ ] |
| **02** | Alignement tabulaire | Nombres et devises alignés à droite, textes à gauche | [ ] |
| **03** | Formatage monétaire | Montants formatés avec espaces de milliers et mention FCFA/XAF | [ ] |
| **04** | Erreurs localisées | Les messages d'erreurs indiquent précisément la solution | [ ] |
| **05** | Support mobile | Les tableaux complexes basculent en cartes lisibles sur smartphone | [ ] |
| **06** | Actions de masse | Les actions groupées affichent un décompte clair et confirmation | [ ] |
| **07** | États de tableau | Les états zéro donnée et aucun résultat sont clairement illustrés | [ ] |
| **08** | Navigation clavier | La touche Tab permet de parcourir les cellules et champs séquentiellement | [ ] |

---

> **Validation du livrable :** Document établi conformément aux exigences de la Phase 05 du framework MARVENS CREATIVE BRIEF V1.0. Prêt pour exploitation transversale.
