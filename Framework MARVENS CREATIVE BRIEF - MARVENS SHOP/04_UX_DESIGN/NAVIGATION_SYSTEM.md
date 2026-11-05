# NAVIGATION SYSTEM — Système de Navigation
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `04_UX_DESIGN/NAVIGATION_SYSTEM.md`  
> **Statut :** Référence méthodologique active  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [UX_PRINCIPLES.md](UX_PRINCIPLES.md) · [INFORMATION_ARCHITECTURE.md](INFORMATION_ARCHITECTURE.md)

---

## 1. Rôle et Objectifs du Système de Navigation

Le système de navigation constitue **l'ensemble des mécanismes visuels, interactifs et spatiaux permettant à l'utilisateur de se repérer, de s'orienter et de circuler sans entrave** au sein d'un produit numérique Marvens.

### Objectifs Essentiels :
* **Rendre la structure immédiatement intelligible :** Dévoiler la topographie du service dès l'accès.
* **Minimiser le coût d'interaction (*Interaction Cost*) :** Réduire les étapes, les clics et les allers-retours nécessaires pour atteindre un contenu ou déclencher une fonction.
* **Garantir la clarté de positionnement :** Indiquer en permanence et sans ambiguïté la position exacte de l'utilisateur dans l'arborescence.
* **Éliminer les impasses :** Offrir systématiquement une issue de retour ou une échappatoire évidente lors de toute navigation contextuelle ou modale.

---

## 2. Principes Fondamentaux de Navigation

Les huit principes suivants régissent la conception de tout système de déplacement d'interface :

### Principe 1 : Prévisibilité absolue
Un clic sur un élément de navigation doit amener exactement à la destination suggérée par son libellé et son icône. Aucune surprise de routage ne doit survenir.

### Principe 2 : Évidence et clarté des statuts
L'élément actif doit être discernable instantanément (changement de contraste, filet de repère, graisse typographique marquée), sans nécessiter de survol pour être identifié.

### Principe 3 : Préservation du contexte et mémoire de navigation
Lorsqu'un utilisateur filtre une table de données, quitte la vue pour consulter un détail et revient en arrière, le système doit impérativement restaurer les filtres, la pagination et la position de défilement antérieurs.

### Principe 4 : Hiérarchie spatiale et visuelle nette
La navigation primaire (sections maîtresses) doit dominer visuellement les navigations secondaires (sous-onglets ou sous-menus) et tertiaires (actions locales).

### Principe 5 : Réversibilité sans douleur
Le retour à l'écran précédent doit être direct, accessible d'un geste élémentaire, sans jamais risquer d'effacer les données en cours de saisie ou de bloquer le navigateur.

### Principe 6 : Adaptation sans régression au terminal
La navigation mobile ne doit pas être un simple masquage brutal des menus de bureau sous une icône universelle sans réflexion sur la découvrabilité des fonctions prioritaires.

### Principe 7 : Élimination des niveaux d'arborescence excessifs
Bannir les cascades de menus déroulants volants à 3 ou 4 niveaux (*flyout menus* imbriqués), sources récurrentes de perte de pointage et de frustration motrice.

### Principe 8 : Accessibilité native au clavier et aux aides techniques
L'ensemble des ancres et contrôles de navigation doit être accessible via la touche `Tab`, disposer d'un indicateur de focus hautement visible et d'un lien d'évitement rapide (*skip to main content*).

---

## 3. Typologie des Modèles de Navigation et Critères de Sélection

Le choix d'un modèle de navigation dépend exclusivement du volume d'information, des flux de travail et du facteur de forme :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 LES 10 MODÈLES DE NAVIGATION DU FRAMEWORK                   │
├───────────────────────────────┬─────────────────────────────────────────────┤
│ 1. Barre Supérieure (Top Nav) │ Navigation horizontale classique (3 à 5     │
│                               │ sections clés). Idéale pour sites vitrines, │
│                               │ portails de contenu et SaaS légers.         │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 2. Volet Latéral (Sidebar)    │ Barre verticale fixe ou rétractable.        │
│                               │ Indispensable pour progiciels, consoles et  │
│                               │ outils de travail à forte densité.          │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 3. Barre Mobile (Bottom Nav)  │ 3 à 5 destinations prioritaires ancrées au  │
│                               │ bas de l'écran tactile du smartphone.       │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 4. Onglets (Tabs)             │ Alternance rapide entre vues parallèles de  │
│                               │ même niveau hiérarchique au sein d'un écran.│
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 5. Fil d'Ariane (Breadcrumbs) │ Rétro-repérage hiérarchique indispensable   │
│                               │ pour les arborescences profondes (dès L3).  │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 6. Tunnel / Wizard Séquentiel │ Guidage pas-à-pas bloquant pour les tâches  │
│                               │ linéaires critiques (onboarding, paiement). │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 7. Navigation Contextuelle    │ Actions surgissant lors de la sélection     │
│                               │ d'un élément (ex. Barre d'action sur table).│
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 8. Tiroir Déroulant (Drawer)  │ Panneau latéral ouvrant un sous-niveau sans │
│                               │ quitter l'écran parent.                     │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 9. Pagination & Défilement    │ Découpage des grands volumes de données     │
│    Maîtrisé                   │ (Pagination explicite pour le travail pro). │
├───────────────────────────────┼─────────────────────────────────────────────┤
│ 10. Recherche Directe         │ Palette de commande (Command Bar `Cmd+K`) ou│
│     & Navigation Globale      │ barre de recherche avec filtres immédiats.  │
└───────────────────────────────┴─────────────────────────────────────────────┘
```

---

## 4. Navigation Responsive et Contextes Tactiles

### 4.1. Adaptation Smartphone (Mobile First)
* **La règle du pouce (*Thumb Zone*) :** Sur smartphone, placer les 3 ou 4 destinations vitales dans la zone basse de l'écran (*Bottom Navigation Bar*), accessible sans contorsion du pouce.
* **Le traitement du menu dépliant (*Drawer / Hamburger*) :** Réservé exclusivement aux rubriques secondaires, aux paramètres de compte ou aux mentions légales. Les fonctionnalités quotidiennes ne doivent jamais être dissimulées derrière un menu fermé.
* **Zones tactiles minimales :** Dimensions minimales de 44x44 pixels pour chaque cible cliquable afin d'éviter les erreurs de sélection.

### 4.2. Adaptation Tablettes et Grands Écrans
* Possibilité de replier la barre latérale en mode icônes seules (*Rail Navigation*) pour libérer de l'espace sur les tables complexes.
* Utilisation d'un agencement à deux ou trois colonnes (*Split-view*) pour afficher simultanément la liste de navigation et le détail de l'élément sélectionné.

---

## 5. États Système et Repères d'Orientation

Chaque élément de navigation doit posséder une incarnation graphique explicite pour chacun de ses états opérationnels :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 LES 7 ÉTATS DU CONTRÔLE DE NAVIGATION                       │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Repos (Default)       │ Lisible, discret, intégré à la surface de fond.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Survol (Hover)        │ Changement subtil de fond ou de teinte (desktop).│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Focus Clavier         │ Anneau de contraste net et visible (min 3:1).    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Actif / Sélectionné   │ Teinte d'accent affirmée, filet de repère ou fond│
│                          │ distinct certifiant l'écran courant.             │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 5. Pressé (Active)       │ Enfoncement optique ou retour tactile immédiat.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 6. Inaccessible (Disabled│ Opacité atténuée avec infobulle expliquant       │
│    avec motif)           │ pourquoi la section est momentanément fermée.    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 7. Indicateur de Badge   │ Pastille numérique discrète signalant un état    │
│    (Notification Count)  │ nouveau (ex. 3 messages non lus).                │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 6. Pathologies et Erreurs de Navigation à Proscrire

L'évaluation d'un système de navigation doit éliminer méthodiquement les écueils suivants :
1. **Les impasses de navigation :** Écrans d'où l'usager ne peut sortir qu'en utilisant le bouton « Revenir en arrière » du navigateur.
2. **Le masquage superflu :** Cacher des fonctions vitales sous prétexte d'épuré esthétique.
3. **Les libellés homonymes ou flous :** Utiliser des termes vagues comme *« Plus »*, *« Outils »*, *« Informations »* sans explicitation.
4. **Les variations imprévisibles :** Déplacer la barre de navigation d'un écran à l'autre au sein d'une même application.
5. **L'absence de confirmation lors de l'abandon :** Quitter un formulaire en cours sans avertir l'utilisateur qu'il perdra sa saisie.

---

## 7. Checklist de Contrôle du Système de Navigation

```markdown
### Grille de Recette du Système de Navigation
- [ ] L'usager identifie immédiatement où il se trouve sur n'importe quel écran.
- [ ] Les 3 à 5 fonctionnalités vitales sont directement accessibles sans ouvrir de menu caché.
- [ ] Sur smartphone, les commandes principales sont situées dans la zone de confort du pouce.
- [ ] La navigation au clavier est fluide, avec un ordre logique de tabulation et un focus visible.
- [ ] Un fil d'Ariane est présent dès lors que l'arborescence dépasse 2 niveaux de profondeur.
- [ ] L'état sélectionné (page courante) est nettement différencié de l'état de simple survol.
- [ ] La conservation des filtres et positions est assurée lors du retour arrière.
- [ ] Les zones de clic mobiles respectent la dimension minimale de 44x44px.
```
