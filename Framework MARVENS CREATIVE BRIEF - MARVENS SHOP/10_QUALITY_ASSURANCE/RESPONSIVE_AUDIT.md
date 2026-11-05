# RESPONSIVE AUDIT — Protocole d'audit d'adaptation multi-écrans
## MARVENS CREATIVE BRIEF V1.0 · PHASE 10_QUALITY_ASSURANCE

> **Document :** Méthodologie d'évaluation d'adaptation ergonomique responsive  
> **Statut :** Protocole d'audit actif  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## 1. Objectifs et approche Mobile-First contextuelle

L'audit responsive a pour mission de s'assurer qu'un produit numérique ne se contente pas d'être « redimensionnable », mais offre une **continuité d'usage exemplaire** quel que soit le terminal utilisé.

Dans le contexte des marchés de Marvens Group (Cameroun & zone CEMAC) :
* Plus de **70 % du trafic web et des accès commerçants** s'effectuent sur smartphone (terminaux Android d'entrée à moyenne gamme avec résolutions courantes de 360px à 414px de large).
* L'approche **Mobile-First** n'est donc pas une posture théorique mais un impératif vital d'affaires : un produit dégradé sur smartphone est un échec immédiat.

---

## 2. Matrice des 6 viewports de référence pour les tests

Pour couvrir l'ensemble des scénarios réels sans dispersion, les audits doivent obligatoirement tester l'interface sur six profils de résolution normalisés :

| Profil Viewport | Largeur testée | Appareils représentatifs | Enjeux ergonomiques prioritaires |
| :--- | :--- | :--- | :--- |
| **1. Petit Mobile** | **360px à 375px** | Smartphones d'entrée de gamme, iPhone SE | Absence absolue de défilement horizontal, compacité des cartes, titres non tronqués. |
| **2. Mobile Standard** | **390px à 414px** | Samsung Galaxy A-series, iPhone standard | Confort tactile de la Thumb Zone, navigation basse, formulaires aérés. |
| **3. Tablette Portrait**| **768px à 820px** | iPad, tablettes de caisse en comptoir | Réorganisation des grilles (2 colonnes), menus tiroirs, lisibilité des totaux. |
| **4. Tablette Paysage**| **1024px à 1180px**| Caisses tactiles POS, iPad Pro avec clavier | Bascule sur navigation latérale, affichage combiné (ticket + catalogue). |
| **5. Laptop Standard** | **1366px à 1440px**| Ordinateurs portables bureautiques PME | Densité équilibrée des tableaux de données, sidebar permanente. |
| **6. Grand Desktop**   | **1920px (1080p)** | Postes fixes de direction, écrans larges | Encadrement de la largeur maximale (Max-Width) pour éviter l'étirement excessif. |

---

## 3. Grille d'inspection systématique responsive

Pour chaque écran audité, sept contrôles structurels doivent être validés :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 7 CONTRÔLES FONDAMENTAUX DU RESPONSIVE               │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Zéro débordement      │ Aucun défilement horizontal involontaire sur la  │
│    (No Horizontal Scroll)│ page globale. La largeur reste bridée à 100vw.   │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Cibles tactiles       │ Sur mobile, tous les boutons et liens mesurent au│
│    (Touch Targets)       │ minimum 44x44px d'envergure interactive.         │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Rupture de tableau    │ Les tableaux larges basculent sur cartes mobiles │
│    (Table Reflow)        │ ou défilent uniquement à l'intérieur de leur bloc│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Navigation adaptée    │ Menu burger ou barre basse sur smartphone ;      │
│    (Adaptive Nav)        │ menu développé sur desktop sans chevauchement.   │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 5. Fenêtres modales      │ Les modales de bureau se transforment en tiroir  │
│    (Bottom Sheet)        │ coulissant par le bas (Bottom Sheet) sur mobile. │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 6. Taille minimale texte │ Le corps de texte ne descend jamais sous 14px sur│
│    (Text Readability)    │ smartphone pour éviter le zoom forcé du mobile.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 7. Densité d'images      │ Les visuels s'adaptent avec `max-width: 100%` et │
│    (Media Scaling)       │ hauteur automatique sans déformation d'aspect.   │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 4. Gestion des composants complexes sur petit écran

### 4.1. Tableaux de bord et indicateurs (KPIs)
* Sur desktop : 4 colonnes alignées horizontalement.
* Sur mobile : bascule en carrousel horizontal tactile doux avec pastilles d'amorce (*peek effect*) ou disposition verticale en 2x2 tuiles.

### 4.2. Formulaires de paiement et de saisie
* Empilement vertical systématique des champs sur mobile (abandon des formulaires en 2 colonnes qui étouffent la frappe au clavier virtuel).
* Clavier contextuel adapté (`inputmode="numeric"` pour les codes OTP et montants FCFA).

---

## 5. Modèle de matrice d'audit responsive par écran

```markdown
### Matrice de Contrôle Responsive — [Nom de l'écran : Écran de Caisse / POS]

| Critère de test | Petit Mobile (375px) | Tablette (768px) | Laptop (1440px) | Observations / Anomalies |
| :--- | :---: | :---: | :---: | :--- |
| **Absence d'overflow horizontal** | `PASS` | `PASS` | `PASS` | Cadrage parfait à 100vw. |
| **Lisibilité typographique** | `PASS` | `PASS` | `PASS` | Titres à 20px sur mobile, 28px desktop. |
| **Cibles de clic $\ge 44\times 44\text{px}$**| `PASS` | `PASS` | `PASS` | Boutons d'encaissement massifs. |
| **Comportement des modales** | `PASS` (Bottom sheet)| `PASS` | `PASS` (Centrée) | Adaptation fluide du conteneur. |
| **Formulaires et claviers** | `PASS` | `PASS` | `PASS` | Déclenchement automatique pavé num. |
```

---

## 6. Fiche de constat d'anomalie responsive

```markdown
### [RESP-ANOMALIE-001] Débordement horizontal sur tableau de stock
* **Écran :** Gestion des stocks / Liste des produits
* **Viewport concerné :** 375px (Mobile)
* **Gravité :** P1 (Majeur)
* **Constat :**  
  Le tableau de stock à 8 colonnes force la page entière à défiler horizontalement, coupant le bouton d'ajout de produit à droite de l'écran.
* **Correction recommandée :**  
  Appliquer un conteneur d'isolation `overflow-x: auto` sur la table uniquement, ou basculer en vue cartes résumées sur écran < 768px.
* **Statut :** [ ] Ouvert  [ ] Résolu
```
