# RESPONSIVE DESIGN — Conception et Adaptation Multi-Terminaux
## MARVENS CREATIVE BRIEF V1.0 · PHASE 05_UI_DESIGN

> **Document :** Référentiel de conception multi-écrans, mobile-first et adaptations contextuelles  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Documents associés :** [UI_GUIDELINES.md](UI_GUIDELINES.md) · [LAYOUT_SYSTEM.md](LAYOUT_SYSTEM.md) · [COMPONENT_DESIGN.md](COMPONENT_DESIGN.md) · [ACCESSIBILITY.md](../04_UX_DESIGN/ACCESSIBILITY.md)

---

## Sommaire

1. [Philosophie responsive et contextualisation mobile-first](#1-philosophie-responsive-et-contextualisation-mobile-first)
2. [Typologie des approches : Responsive, Adaptatif et Fluide](#2-typologie-des-approches--responsive-adaptatif-et-fluide)
3. [Seuils de rupture (Breakpoints) et catégories d'appareils](#3-seuils-de-rupture-breakpoints-et-catégories-dappareils)
4. [Stratégie de réorganisation des grilles et conteneurs](#4-stratégie-de-réorganisation-des-grilles-et-conteneurs)
5. [Adaptation de la navigation et menus](#5-adaptation-de-la-navigation-et-menus)
6. [Adaptation dynamique de la typographie et des espacements](#6-adaptation-dynamique-de-la-typographie-et-des-espacements)
7. [Adaptation des composants critiques](#7-adaptation-des-composants-critiques)
8. [Gestion prioritaire des contenus : Hiérarchisation et masquage](#8-gestion-prioritaire-des-contenus--hiérarchisation-et-masquage)
9. [Ergonomie tactile et dimensionnement des zones d'interaction](#9-ergonomie-tactile-et-dimensionnement-des-zones-dinteraction)
10. [Comportement lors des changements d'orientation et rotation](#10-comportement-lors-des-changements-dorientation-et-rotation)
11. [Performance sur réseaux mobiles dégradés (CEMAC)](#11-performance-sur-réseaux-mobiles-dégradés-cemac)
12. [Matrice de tests et stratégie d'assurance qualité responsive](#12-matrice-de-tests-et-stratégie-dassurance-qualité-responsive)
13. [Checklist responsive globale](#13-checklist-responsive-globale)

---

## 1. Philosophie responsive et contextualisation mobile-first

Dans le cadre de **MARVENS CREATIVE BRIEF V1.0**, la conception *Mobile-First* ne consiste pas simplement à concevoir un écran réduit puis à l'étirer pour un grand écran. Elle impose une **discipline de priorisation absolue** :
- Sur un écran mobile de smartphone (utilisé par les gérants de boutique, commerciaux de terrain ou livreurs à Yaoundé ou Douala), chaque pixel compte. Seule l'information indispensable à l'action immédiate doit être mise en exergue.
- La version desktop enrichit l'expérience en déployant une vision globale, des raccourcis experts et une densité de comparaison supérieure, sans jamais contredire la logique de travail initiée sur mobile.

> **Règle absolue :** Ne jamais livrer une version mobile qui soit une simple réduction passive d'une maquette pour ordinateur de bureau avec des textes illisibles et des ascenseurs horizontaux incontrôlés.

---

## 2. Typologie des approches : Responsive, Adaptatif et Fluide

Le framework combine avec discernement ces trois approches selon les composants :
- **Fluid Layout (Pourcentages / Fr / Flexbox) :** Utilisé pour la largeur des cartes et des conteneurs de contenu, s'étirant naturellement entre deux seuils de rupture.
- **Adaptive Breakpoints (Points de rupture CSS stricts) :** Utilisé pour reconfigurer la disposition structurelle (passer de 1 à 2 ou 4 colonnes, transformer une barre latérale en tiroir ouvrant).
- **Responsive Logic :** Utilisé pour changer la nature même du composant selon le contexte matériel (ex. un tableau de 8 colonnes sur ordinateur devient une liste de cartes empilées sur mobile tactile).

---

## 3. Seuils de rupture (Breakpoints) et catégories d'appareils

Les points de rupture sont calibrés pour couvrir le parc réel de terminaux constatés en Afrique centrale (smartphones Android d'entrée/milieu de gamme, ordinateurs portables 1366x768 reconditionnés et moniteurs bureautiques standard) tout en s'alignant sur les standards de Bootstrap 5 :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       ÉCHELLE DES POINTS DE RUPTURE                         │
├───────┬────────────┬─────────────────────────────┬──────────────────────────┤
│ TOKEN │ LARGEUR    │ TYPE DE TERMINAL VISÉ       │ COMPORTEMENT DE GRILLE   │
├───────┼────────────┼─────────────────────────────┼──────────────────────────┤
│ `xs`  │ < 576px    │ Smartphones portrait        │ 4 colonnes, marge 16px   │
│ `sm`  │ 576px+     │ Grands mobiles / Phablets   │ 4 ou 6 colonnes, marge 16│
│ `md`  │ 768px+     │ Tablettes portrait / iPads  │ 8 colonnes, marge 24px   │
│ `lg`  │ 992px+     │ Tablettes pays./Petits PC   │ 12 colonnes, sidebar vis.│
│ `xl`  │ 1200px+    │ PC bureautique standard     │ 12 colonnes, max-width   │
│ `xxl` │ 1400px+    │ Grands écrans / Moniteurs HD│ 12 colonnes, centré      │
└───────┴────────────┴─────────────────────────────┴──────────────────────────┘
```

```css
/* Media Queries standardisées (Approche Mobile-First Min-Width) */
@media (min-width: 576px)  { /* Breakpoint SM : Phablets et petits terminaux */ }
@media (min-width: 768px)  { /* Breakpoint MD : Tablettes portrait */ }
@media (min-width: 992px)  { /* Breakpoint LG : Desktop standard / Ordinateurs portables */ }
@media (min-width: 1200px) { /* Breakpoint XL : Moniteurs 1080p et plus */ }
```

---

## 4. Stratégie de réorganisation des grilles et conteneurs

Le passage d'un grand écran à un écran mobile suit trois règles de transformation :

```
Desktop (12 Colonnes)             Tablette (8 Colonnes)           Mobile (4 Colonnes)
┌──────────────┬──────────────┐   ┌──────────────┬──────────────┐ ┌───────────────────────────┐
│  Colonne A   │  Colonne B   │   │  Colonne A   │  Colonne B   │ │  Colonne A (100% large)   │
│   (6 cols)   │   (6 cols)   │   │   (4 cols)   │   (4 cols)   │ ├───────────────────────────┤
└──────────────┴──────────────┘   └──────────────┴──────────────┘ │  Colonne B (100% large)   │
                                                                  └───────────────────────────┘
```

1. **Empilement vertical ordonné (*Column Stacking*) :** Les blocs multi-colonnes basculent automatiquement à 100 % de la largeur utile sur écran mobile.
2. **Ordre de lecture sémantique préservé :** L'ordre DOM naturel doit placer le contenu principal avant les barres d'outils secondaires. Utiliser si nécessaire les utilitaires d'ordonnancement Flexbox (`order-1`, `order-2`) sans altérer la cohérence d'accessibilité.
3. **Suppression des marges superflues :** Sur mobile (`xs`), les conteneurs passent en pleine largeur avec une marge interne uniforme de 16px (`px-3` sous Bootstrap) pour maximiser l'espace utile de saisie.

---

## 5. Adaptation de la navigation et menus

L'ergonomie de navigation se reconfigure selon la surface d'affichage :

### 5.1 Sur Desktop ($\ge$ 992px)
- **Panneau latéral persistant (Sidebar) :** Visible en continu à gauche de l'écran (largeur : 260px). Déploiement des sous-menus sous forme d'accordéons ou de survols contrôlés.
- **Header haut :** Recherche globale, sélecteur d'entité, notifications et menu profil complet.

### 5.2 Sur Mobile et Tablette (< 992px)
- **Barre supérieure condensée :** Bouton hamburger d'accès au menu à gauche, nom du produit ou logo compact au centre, raccourci d'action rapide ou avatar à droite.
- **Tiroir latéral fluide (Offcanvas / Drawer) :** Le menu s'ouvre par glissement depuis la gauche, couvrant 85 % de la largeur de l'écran avec un masque d'arrière-plan semi-transparent occultant.
- **Barre d'action basse (Mobile Bottom Navigation si pertinent) :** Pour les applications de terrain et POS nomade, une barre d'accès rapide fixe en bas d'écran (4 à 5 icônes d'action récurrentes : Accueil, Ventes, Clients, Panier) permet une navigation à un seul pouce.

---

## 6. Adaptation dynamique de la typographie et des espacements

Pour éviter les coupures de mots disgracieuses et conserver un équilibre visuel, les tailles de titre et les paddings diminuent proportionnellement sur mobile :

| Élément typographique | Taille Desktop ($\ge$ 992px) | Taille Mobile (< 576px) | Hauteur de ligne mobile |
|---|---|---|---|
| **H1 (Titre de page)** | 28px - 32px | 22px - 24px | 1.25 |
| **H2 (Titre de section)**| 22px - 24px | 18px - 20px | 1.3 |
| **H3 (Titre de carte)**  | 18px - 20px | 16px | 1.35 |
| **Texte courant (Body)** | 15px - 16px | 14px - 15px (min. 14px)| 1.45 |
| **Microcopie / Badges**  | 13px | 12px (min. absolu) | 1.4 |

```css
/* Adaptation fluide des espacements de section */
.section-wrapper {
  padding-top: var(--space-5);    /* 16px sur mobile */
  padding-bottom: var(--space-5);
}

@media (min-width: 992px) {
  .section-wrapper {
    padding-top: var(--space-7);  /* 32px sur desktop */
    padding-bottom: var(--space-7);
  }
}
```

---

## 7. Adaptation des composants critiques

### 7.1 Tableaux de données
- **Desktop :** Tableau complet avec toutes les colonnes, tri, sélection multiple et pagination en ligne.
- **Mobile :** Deux comportements autorisés :
  1. *Comportement préférentiel (Cards View) :* Chaque ligne du tableau se transforme en une carte autonome résumant l'identifiant, le statut, le montant clé et un bouton chevron dépliant les détails.
  2. *Défilement horizontal contenu :* Si la structure tabulaire stricte est indispensable (ex. bilan comptable), encapsuler la table dans un conteneur `overflow-x: auto` avec un indicateur visuel discret d'ombrage latéral signalant le défilement possible.

### 7.2 Modales et dialogues
- **Desktop :** Boîte modale centrée à largeur fixe (500px à 700px), élévation supérieure.
- **Mobile :** La modale se transforme en panneau bas déployable (*Bottom Sheet*), ancré au bas de l'écran, occupant jusqu'à 90 % de la hauteur, avec fermeture intuitive par glissement vers le bas ou bouton `Fermer` pleine largeur.

### 7.3 Formulaires complexes
- Les formulaires multi-colonnes (ex. `Nom` et `Prénom` côte à côte) basculent obligatoirement en une colonne unique séquentielle sur mobile, évitant le rétrécissement des champs de saisie.

---

## 8. Gestion prioritaire des contenus : Hiérarchisation et masquage

Sur écran restreint, masquer un contenu est une décision lourde qui doit répondre à des critères stricts :

- **Éléments prioritaires (Toujours visibles) :** Statut d'une commande, montant total, référence client, bouton d'action principale (ex. `Encaisser`).
- **Éléments secondaires (Accessibles sur demande) :** Historique des modifications, horodatage technique, notes internes détaillées (déplacés dans un accordéon ou un volet secondaire).
- **Éléments interdits au masquage :** Les messages d'erreur, les alertes de sécurité, les mentions légales de transaction et les boutons de confirmation d'action.

---

## 9. Ergonomie tactile et dimensionnement des zones d'interaction

Les interactions tactiles diffèrent fondamentalement du clic de souris : l'imprécision du doigt humain impose des règles géométriques rigoureuses :

```
             ┌─────────────────────────┐
             │       MINIMUM 44px      │
             │   Surface tactile utile │
             │      [ BOUTON CTA ]     │
             └─────────────────────────┘
                   ▲             ▲
                   │ Espacement  │
                   │ minimum 8px │
                   ▼             ▼
             ┌─────────────────────────┐
             │       MINIMUM 44px      │
             └─────────────────────────┘
```

- **Dimension minimale :** Aucune cible interactive ne peut être inférieure à **44 × 44 pixels** réels.
- **Zone de confort du pouce (*Thumb Zone*) :** Sur mobile, les actions critiques doivent se situer dans le tiers inférieur de l'écran, zone naturellement accessible sans contorsion de la main tenant l'appareil.

---

## 10. Comportement lors des changements d'orientation et rotation

- **Passage Portrait $\rightarrow$ Paysage :** L'interface doit s'adapter instantanément sans recharger la page ni perdre l'état des formulaires en cours de saisie.
- Les barres fixes hautes et basses doivent réduire leur hauteur (ex. passer de 60px à 48px) pour préserver un champ de vision vertical suffisant sur smartphone en mode paysage.

---

## 11. Performance sur réseaux mobiles dégradés (CEMAC)

Dans le contexte d'utilisation réel (zones 3G fluctuantes, forfaits mobiles limités au Cameroun) :
- **Optimisation des ressources :** Poids total initial de la page inférieur à **800 Ko** (HTML, CSS, icônes vectorielles SVG inline, JS Vanilla).
- **Zéro dépendance lourde :** Aucune librairie de police d'icônes démesurée. Uniquement les symboles SVG nécessaires.
- **Images adaptatives :** Utilisation des balises `<picture>` et de l'attribut `loading="lazy"` pour les visuels d'articles ou pièces jointes.

---

## 12. Matrice de tests et stratégie d'assurance qualité responsive

Chaque vue doit être formellement auditée sur les cinq configurations de référence :

| Configuration | Résolution de test | Navigateurs prioritaires | Type d'interaction |
|---|---|---|---|
| **Mobile d'entrée de gamme** | 360 × 640 px | Chrome Android, Opera Mini | Tactile pur, connexion 3G bridée |
| **Smartphone standard** | 390 × 844 px (iPhone/Samsung) | Safari Mobile, Chrome Mobile | Tactile pur, connexion 4G |
| **Tablette tactile** | 768 × 1024 px (iPad) | Safari, Chrome | Tactile & Clavier externe |
| **PC portable bureautique** | 1366 × 768 px | Chrome, Firefox, Edge | Souris, touchpad & Clavier |
| **Poste de travail HD** | 1920 × 1080 px | Chrome, Firefox, Edge | Souris & Clavier |

---

## 13. Checklist responsive globale

Avant validation définitive d'un écran :

| # | Question de contrôle responsive | Critère requis | Statut |
|---|---|---|---|
| **01** | Absence d'overflow | Aucun défilement horizontal involontaire à 360px de large | [ ] |
| **02** | Cibles tactiles | Tous les boutons et liens mobiles mesurent au minimum 44x44px | [ ] |
| **03** | Lisibilité typographique | La taille minimale de police est de 14px (12px pour micro-labels) | [ ] |
| **04** | Tableaux lisibles | Les tableaux se transforment en cartes ou restent scrollables proprement | [ ] |
| **05** | Formulaires simples | Les formulaires complexes s'empilent en une colonne unique fluide | [ ] |
| **06** | Accès à la navigation | Le menu tiroir mobile s'ouvre, se ferme et réagit sans latence | [ ] |
| **07** | Intégrité des données | Aucune donnée financière critique n'est masquée sans alternative d'accès | [ ] |

---

> **Validation du livrable :** Document établi conformément aux exigences de la Phase 05 du framework MARVENS CREATIVE BRIEF V1.0. Prêt pour exploitation transversale.


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
