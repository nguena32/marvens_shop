# ACCESSIBILITY — Accessibilité Numérique et Conception Inclusive
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `04_UX_DESIGN/ACCESSIBILITY.md`  
> **Statut :** Référence méthodologique active  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Référentiel International de Base :** WCAG 2.2 Niveau AA (Web Content Accessibility Guidelines)  
> **Documents amont associés :** [UX_PRINCIPLES.md](UX_PRINCIPLES.md) · [INTERACTION_DESIGN.md](INTERACTION_DESIGN.md) · [ART_DIRECTION_GUIDELINES.md](../02_ART_DIRECTION/ART_DIRECTION_GUIDELINES.md)

---

## 1. Positionnement Éthique et Stratégique

Dans le cadre du framework **MARVENS CREATIVE BRIEF V1.0**, l'accessibilité numérique (*Digital Accessibility / a11y*) n'est ni une option de dernière minute, ni une contrainte réglementaire subie, ni un compromis esthétique au détriment de l'élégance.

### Pourquoi l'accessibilité est un pilier de la qualité Premium :
* **L'universalité par conception (*Inclusive by Design*) :** Un produit d'exception doit fonctionner avec la même perfection pour un dirigeant pressé sur un smartphone en plein soleil, pour un collaborateur non-voyant utilisant un lecteur d'écran, ou pour un utilisateur temporairement blessé à la main.
* **La robustesse technique :** Une interface accessible repose sur une sémantique irréprochable et un code propre, ce qui accélère la vitesse de chargement, fiabilise le référencement et réduit les bugs sur tous les terminaux.
* **L'égalité républicaine et l'éthique Marvens :** Aucune catégorie d'usagers ne doit être écartée des services conçus par le groupe en raison de limitations fonctionnelles, sensorielles ou cognitives.

---

## 2. Le Référentiel WCAG 2.2 et ses 4 Principes Fédérateurs

Le standard de conception retenu pour l'ensemble des créations Marvens est le niveau **WCAG 2.2 AA**. L'ensemble des maquettes et flux doit se conformer aux quatre principes cardinaux du W3C :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 4 PRINCIPES DU STANDARD WCAG 2.2                  │
├────────────────────┬────────────────────────────────────────────────────────┤
│ 1. PERCEPTIBLE     │ L'information et les composants doivent être présentés │
│                    │ de façon à être perceptibles par tous les sens usagers.│
├────────────────────┼────────────────────────────────────────────────────────┤
│ 2. UTILISABLE      │ Les composants d'interface et la navigation doivent    │
│                    │ être entièrement manœuvrables au clavier ou équivalent.│
├────────────────────┼────────────────────────────────────────────────────────┤
│ 3. COMPRÉHENSIBLE  │ Les informations et le fonctionnement de l'interface   │
│                    │ doivent être clairs, prévisibles et explicites.        │
├────────────────────┼────────────────────────────────────────────────────────┤
│ 4. ROBUSTE         │ Le contenu doit être suffisamment solide pour être lu  │
│                    │ par une grande variété d'agents, y compris d'assistance│
└────────────────────┴────────────────────────────────────────────────────────┘
```

---

## 3. Règles de Conception Pratiques par Principe

---

### A. Principe 1 : Perceptible

#### 1. Ratios de Contraste Colorimétrique (Norme WCAG AA)
* **Texte normal (< 18pt ou < 14pt gras) :** Ratio de contraste minimal strict de **4.5:1** contre son arrière-plan.
* **Texte de grand corps ($\ge$ 18pt ou $\ge$ 14pt gras) :** Ratio de contraste minimal de **3.0:1**.
* **Composants d'interface & Éléments graphiques signifiants :** Contraste minimal de **3.0:1** pour les bordures de champs actifs, icônes fonctionnelles et boutons.

#### 2. L'Information ne doit Jamais Reposer sur la Seule Couleur
Une erreur ne peut pas être signalée uniquement par du texte rouge. Elle doit obligatoirement être accompagnée d'une **icône d'alerte** ou d'un **préfixe textuel explicite** (*« Erreur : »*).

#### 3. Équivalents Textuels Systématiques (*Alt Text*)
* Toute image signifiante doit comporter un attribut textuel descriptif précis.
* Toute image purement décorative doit posséder un attribut vide `alt=""` ou `aria-hidden="true"` pour ne pas polluer la synthèse vocale des personnes déficientes visuelles.

#### 4. Redimensionnement et Zoom sans Perte
L'interface doit rester 100% lisible et opérationnelle jusqu'à un zoom d'agrandissement de **200%**, sans superposition de texte ni apparition d'un défilement horizontal sur les paragraphes.

---

### B. Principe 2 : Utilisable

#### 1. Navigabilité Intégrale au Clavier
* **Ordre de tabulation séquentiel :** L'ordre de focalisation (`Tab`) doit refléter exactement la hiérarchie logique de lecture visuelle.
* **Indicateur de focus hautement visible :** Ne JAMAIS désactiver le contour de focus (`outline: none` interdit sans solution de remplacement). L'anneau de focus doit contraster d'au moins **3:1** avec le fond.
* **Aucun piège au clavier (*Keyboard Trap*) :** L'utilisateur doit pouvoir entrer et sortir de n'importe quel composant uniquement à l'aide des touches `Tab` et `Shift+Tab`.

#### 2. Cibles Tactiles Confortables (*Touch Targets*)
* Dimension minimale de **44x44 pixels** (ou 48x48px sur mobile) pour toute zone interactive cliquable, avec un espacement suffisant entre deux commandes voisines.

#### 3. Absence de Dépendance Exclusive au Survol
Toute information révélée au survol de la souris (*Hover*) doit pouvoir être consultée sur écran tactile et au clavier (par clic ou touche Entrée) et pouvoir être refermée sans bouger le pointeur (touche `Échap`).

#### 4. Contrôle des Limites de Temps
Si une session expire (sécurité bancaire), l'utilisateur doit être averti au moins **2 minutes avant** avec la possibilité de prolonger le délai d'un simple clic.

---

### C. Principe 3 : Compréhensible

#### 1. Clarté Sémantique et Lisibilité
* Indication explicite de la langue principale de la page (`<html lang="fr">`).
* Formulations claires et directes, évitant les doubles négations dans les questions de confirmation.

#### 2. Prévisibilité des Contextes
L'activation d'un lien ou d'un bouton ne doit jamais provoquer l'ouverture inattendue d'un nouvel onglet sans avertissement préalable (icône et libellé masqué pour lecteur d'écran : *« Ouvre une nouvelle fenêtre »*).

#### 3. Assistance à la Saisie dans les Formulaires
* Chaque champ de saisie doit disposer d'un label textuel permanent relié sémantiquement (`<label for="id">`).
* Les messages d'erreur doivent identifier le champ concerné, expliquer la cause exacte de l'anomalie et fournir la règle de saisie attendue.

---

### D. Principe 4 : Robuste

#### 1. Structure HTML5 Sémantique
Privilégier systématiquement les éléments natifs du navigateur (`<button>`, `<input>`, `<a>`, `<nav>`, `<main>`, `<header>`) plutôt que des empilements artificiels de balises `<div>` ou `<span>`.

#### 2. Emploi Justifié et Rigoureux d'ARIA
Appliquer la première règle du W3C sur ARIA : *« Si un élément HTML natif existe pour accomplir la tâche, ne pas utiliser d'attributs ARIA »*. N'utiliser `aria-expanded`, `aria-controls` ou `aria-live` que pour les composants dynamiques complexes (accordéons, modales, toasts).

---

## 4. Protocole d'Audit et de Recette Accessibilité

L'homologation d'une interface au standard Marvens impose un processus de contrôle à trois niveaux :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 3 NIVEAUX D'AUDIT ACCESSIBILITÉ                      │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Revue de Conception   │ Contrôle des contrastes, des graisses, des zones │
│    (Figma / Wireframes)  │ tactiles et de l'absence de couleur isolée.      │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Audit Automatisé      │ Analyse par moteurs d'évaluation automatisés     │
│    (Code / Pré-prod)     │ (Lighthouse, Axe-core, Wave) pour repérer les    │
│                          │ oublis d'attributs ou contrastes machine.        │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Recette Manuelle &    │ Navigation 100% au clavier (sans souris) et test │
│    Aides Techniques      │ avec un lecteur d'écran (VoiceOver ou NVDA).     │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

> [!CAUTION]
> Les outils automatiques ne détectent qu'environ **30% à 40% des anomalies réelles d'accessibilité**. Une recette manuelle au clavier et une vérification humaine de la pertinence des textes alternatifs sont obligatoires.

---

## 5. Grille de Déclaration de Conformité (Modèle Opérationnel)

Chaque livraison d'interface doit s'accompagner de sa fiche de recette d'accessibilité documentée :

```markdown
# FICHE D'ÉVALUATION D'ACCESSIBILITÉ — [Nom du Produit]

* **Date de l'Audit :** AAAA-MM-JJ
* **Référentiel Cible :** WCAG 2.2 Niveau AA
* **Auditeur / Responsable :** [Nom du Lead UX / Agent IA]
* **Résultat Global :** [CONFORME AA / CONFORMITÉ PARTIELLE AVEC ACTIONS / NON CONFORME]

---

### 1. Synthèse des Contrôles Effectués

| Domaine de Contrôle | Outil / Méthode Utilisée | Statut de Recette | Remarques & Corrections |
| :--- | :--- | :---: | :--- |
| **Contrastes Textes & UI** | Analyseur de contraste optique | Conforme | Ratio moyen constaté : 6.2:1 |
| **Navigation Clavier** | Test manuel `Tab` / `Shift+Tab` | Conforme | Focus visible sur 100% des liens |
| **Cibles Tactiles Mobile** | Calibrage gabarit 44x44px | Conforme | Tous les boutons validés |
| **Alternatives Images** | Revue des balises `alt` | Conforme | Zéro image signifiante sans texte |
| **Formulaires & Labels** | Test d'association programmatique | Conforme | Labels explicites et permanents |
| **Lecteur d'Écran** | Test VoiceOver / NVDA sur tunnel | Conforme | Annonces fluides et intelligibles |

---

### 2. Réserves et Points sous Surveillance
* *Point 1 :* [Ex. Les graphiques financiers complexes disposent d'une alternative tabulaire accessible sous le canvas].
```


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
