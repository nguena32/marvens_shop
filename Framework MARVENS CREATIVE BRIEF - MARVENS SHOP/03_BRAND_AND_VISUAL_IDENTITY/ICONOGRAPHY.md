# ICONOGRAPHY — Système d'iconographie
## MARVENS CREATIVE BRIEF V1.0 · PHASE 03_BRAND_AND_VISUAL_IDENTITY

> **Document :** Spécification doctrinale, sémantique et règles d'usage des icônes  
> **Statut :** Référence méthodologique et opérationnelle active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## Sommaire
1. [Rôle de l'iconographie et vision doctrinale](#1-rôle-de-liconographie-et-vision-doctrinale)
2. [Articulation des 3 niveaux du framework](#2-articulation-des-3-niveaux-du-framework)
3. [Typologie fonctionnelle des icônes](#3-typologie-fonctionnelle-des-icônes)
4. [Critères de sélection d'une famille d'icônes](#4-critères-de-sélection-dune-famille-dicônes)
5. [Grammaire stylistique et caractéristiques visuelles](#5-grammaire-stylistique-et-caractéristiques-visuelles)
6. [Grilles de dessin, tailles et alignements](#6-grilles-de-dessin-tailles-et-alignements)
7. [Règles d'usage contextuel et association au texte](#7-règles-dusage-contextuel-et-association-au-texte)
8. [Accessibilité numérique et technologies d'assistance](#8-accessibilité-numérique-et-technologies-dassistance)
9. [Format technique, optimisation et chargement SVG](#9-format-technique-optimisation-et-chargement-svg)
10. [Gabarit de spécification pour un produit](#10-gabarit-de-spécification-pour-un-produit)
11. [Anti-patterns et dérives à proscrire](#11-anti-patterns-et-dérives-à-proscrire)
12. [Checklist de validation iconographique](#12-checklist-de-validation-iconographique)

---

## 1. Rôle de l'iconographie et vision doctrinale

Dans le référentiel **MARVENS CREATIVE BRIEF V1.0**, l'icône est un outil d'orientation cognitive, de guidage visuel et de clarification fonctionnelle.

Une icône n'est jamais un bouche-trou décoratif. Elle existe pour :
* Accélérer la reconnaissance d'une action ou d'une section sur un écran dense.
* Faciliter la navigation des usagers sur mobile ou sur des interfaces de caisse rapide.
* Renforcer l'harmonie géométrique et la signature **Premium Quality** du produit.

---

## 2. Articulation des 3 niveaux du framework

* **Niveau A — Principes permanents du Framework :**  
  Toutes les icônes d'un même produit doivent appartenir à une seule et même famille visuelle cohérente (même épaisseur de trait, même rayon d'arrondi, même niveau de détail). Une icône fonctionnelle critique ne doit jamais être présentée seule sans étiquette textuelle ou infobulle accessible.
* **Niveau B — Méthode de décision :**  
  Audit des besoins fonctionnels du produit $\rightarrow$ sélection d'une bibliothèque open-source de standard mondial avec licence commerciale (ex: Lucide Icons, Tabler Icons, Phosphor Icons) $\rightarrow$ interdiction stricte de mélanger les bibliothèques $\rightarrow$ validation humaine formelle.
* **Niveau C — Paramètres propres au produit :**  
  La bibliothèque exacte, le style de trait (*Outline 1.5px / 2px* ou *Filled*) et la couleur d'accentuation sont arrêtés dans le brief du produit.

---

## 3. Typologie fonctionnelle des icônes

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       TYPOLOGIE DES ICÔNES DANS L'INTERFACE                 │
├───────────────────┬───────────────────────────────┬─────────────────────────┤
│ CATÉGORIE         │ RÔLE & FONCTIONNALITÉ         │ EXEMPLES D'USAGES       │
├───────────────────┼───────────────────────────────┼─────────────────────────┤
│ 1. Navigation     │ Structurer les menus et flux  │ Home, Menu, Flèche,     │
│                   │ de déplacement dans l'outil   │ Paramètres, Déconnexion │
├───────────────────┼───────────────────────────────┼─────────────────────────┤
│ 2. Action         │ Déclencher une mutation ou une│ Plus (Créer), Poubelle, │
│                   │ opération sur le système      │ Crayon (Éditer), Imprimer│
├───────────────────┼───────────────────────────────┼─────────────────────────┤
│ 3. État / Feedback│ Confirmer ou alerter sur la   │ Check (Succès), Croix,  │
│                   │ situation d'une opération     │ Warning, Sablier        │
├───────────────────┼───────────────────────────────┼─────────────────────────┤
│ 4. Métier B2B     │ Symboliser une notion d'usage │ Caisse enregistreuse,   │
│                   │ sectorielle ou commerciale    │ Camion livraison, MoMo  │
└───────────────────┴───────────────────────────────┴─────────────────────────┘
```

---

## 4. Critères de sélection d'une famille d'icônes

Toute bibliothèque retenue doit remplir les conditions suivantes :
1. **Unicité stylistique :** Les glyphes partagent le même ADN visuel (homogénéité stricte des angles et des courbes).
2. **Couverture fonctionnelle exhaustive :** Minimum 500 à 1 000 icônes disponibles pour couvrir l'ensemble des besoins futurs du SaaS sans devoir « emprunter » des icônes à d'autres packs.
3. **Format SVG natif léger :** Possibilité d'intégrer les icônes sous forme de symboles SVG en ligne (*inline SVG*), sans charger de polices d'icônes (*icon-fonts*) obsolètes et lourdes.
4. **Licence commerciale libre :** Licence MIT, Apache 2.0 ou CC0.

> **Recommandation officielle Marvens :** La bibliothèque **Lucide Icons** (ou **Tabler Icons**) est préconisée comme référence d'excellence pour les produits SaaS et web apps du Groupe pour son équilibre géométrique, sa légèreté et sa complétude.

---

## 5. Grammaire stylistique et caractéristiques visuelles

Pour maintenir l'exigence de clarté de la doctrine *Contextual Design* :
* **Style par défaut :** *Outline* (icônes linéaires non remplies) avec une épaisseur de trait (*stroke-width*) constante de **1.75px à 2px** sur une boîte de 24px.
* **Variante remplie (*Filled*) :** Réservée exclusivement aux états actifs de navigation (ex: onglet de menu sélectionné) pour signifier clairement l'ancrage sans alourdir l'interface.
* **Terminaisons de traits (*Stroke Caps*) :** Arrondies (*Round*) pour une sensation moderne, avenante et fluide.
* **Sobriété des détails :** Proscrire les micro-détails réalistes qui deviennent une tâche floue sur les petits écrans mobiles.

---

## 6. Grilles de dessin, tailles et alignements

Les icônes doivent s'inscrire dans une grille géométrique stricte basée sur un multiple de 4px :

| Format Sémantique | Boîte englobante | Zone optique interne | Usage type |
| :--- | :--- | :--- | :--- |
| `icon-xs` | 14x14 px | 12x12 px | Badges compacts, puces de tableaux denses. |
| `icon-sm` | 16x16 px | 14x14 px | En ligne dans le texte courant, boutons secondaires. |
| `icon-base` | **20x20 px** | **18x18 px** | **Boutons standards, champs de formulaires, onglets.** |
| `icon-md` | 24x24 px | 20x20 px | Menu de navigation principal, en-têtes de cartes. |
| `icon-lg` | 32x32 px | 28x28 px | Tuiles de sélection de modules, illustrations d'accueil.|
| `icon-xl` | 48x48 px | 40x40 px | Écrans vides (*Empty states*), bannières de succès.|

> **Règle d'alignement optique :** L'icône doit être centrée optiquement dans son conteneur interactif et disposer d'un espacement régulier avec son libellé textuel (généralement 8px d'écartement).

---

## 7. Règles d'usage contextuel et association au texte

1. **La règle de l'étiquette obligatoire :**  
   Une icône ne doit jamais être isolée si sa signification peut prêter à confusion. Les icônes solitaires ne sont tolérées que pour des métaphores universellement acquises :
   * La loupe $\rightarrow$ Rechercher.
   * La croix $\rightarrow$ Fermer une fenêtre modale.
   * L'engrenage $\rightarrow$ Paramètres.
   Pour tout le reste (clôture de caisse, export de rapport, transfert de fonds), le libellé textuel est **obligatoire**.
2. **Couleur contextuelle liée au rôle :**  
   L'icône hérite dynamiquement de la couleur de son texte adjacent via la propriété CSS `currentColor`, garantissant un contraste optique parfait en toute circonstance.

---

## 8. Accessibilité numérique et technologies d'assistance

* **Icônes purement décoratives (accompagnées de texte) :**  
  Doivent comporter l'attribut `aria-hidden="true"` afin de ne pas parasiter la lecture des usagers malvoyants utilisant un lecteur d'écran.
* **Icônes fonctionnelles autonomes (ex: bouton fermeture) :**  
  Doivent obligatoirement être encapsulées dans un conteneur interactif muni d'un attribut `aria-label="Fermer la boîte de dialogue"` et d'une infobulle native (*tooltip*).
* **Taille de cible tactile minimale :**  
  Sur mobile, même si l'icône mesure 20x20px, sa zone de clic interactive (*touch target*) doit mesurer au minimum **44x44px** pour éviter les erreurs de manipulation des opérateurs.

---

## 9. Format technique, optimisation et chargement SVG

* **SVG vectoriel pur :** Aucun format bitmap (PNG, JPEG, GIF) n'est admis pour les icônes fonctionnelles d'interface.
* **Optimisation du code :** Nettoyage des balises inutiles (suppression des métadonnées des logiciels de dessin via SVGO ou équivalent).
* **Interdiction des Icon-Fonts :** Les polices d'icônes génèrent des problèmes d'alignement vertical, de flou de rendu sous certains navigateurs et ne respectent pas les règles modernes d'accessibilité.

---

## 10. Gabarit de spécification pour un produit

```markdown
### Système Iconographique — [Nom du Produit]
* **Bibliothèque de référence :** [ex: Lucide Icons v0.3xx] | Licence : MIT
* **Style dominant :** Outline 1.75px / Remplissage sur état actif
* **Intégration technique :** Sprite SVG / Inline SVG
* **Taille de base retenue :** 20x20px (base) / 24x24px (nav)
* **Accessibilité :** Attributs aria-hidden et aria-label systématisés
* **Statut :** [ ] Proposition IA  [ ] Validé par le Responsable Humain
```

---

## 11. Anti-patterns et dérives à proscrire

1. **Le mélange de bibliothèques :** Avoir des icônes à angles vifs sur un écran et des icônes douces et arrondies sur le voisin.
2. **L'icône mystérieuse :** Utiliser des pictogrammes abstraits pour des actions critiques, forçant l'utilisateur à deviner leur fonction.
3. **Le sapin de Noël :** Colorer chaque icône d'une teinte vive différente sans logique de rétroaction d'état.

---

## 12. Checklist de validation iconographique

- [ ] Une seule famille d'icônes homogène est utilisée sur l'ensemble de l'application.
- [ ] La licence d'exploitation commerciale libre est formellement consignée.
- [ ] Toutes les icônes autonomes disposent d'un `aria-label` descriptif.
- [ ] Les icônes décoratives sont marquées `aria-hidden="true"`.
- [ ] La zone de clic tactile sur mobile respecte le minimum légal de 44x44px.
- [ ] L'agent IA a soumis le choix de la bibliothèque à validation humaine.
