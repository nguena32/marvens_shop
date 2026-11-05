# DESIGN REVIEW CHECKLIST — Grille de Contrôle Qualité et Anti-Généricité
## MARVENS CREATIVE BRIEF V2.0 · PHASE 10_QUALITY_ASSURANCE

> **Emplacement :** `10_QUALITY_ASSURANCE/DESIGN_REVIEW_CHECKLIST.md`  
> **Statut :** Liste de contrôle obligatoire avant tout jalon de livraison  
> **Doctrine :** *Contextual Design · Anti-Generic AI · Flawless Execution*

---

## Sommaire de la Revue

Cette liste de contrôle doit être complétée conjointement par le designer, l'agent IA et le responsable de projet avant toute validation d'étape.

---

## 1. Identité de Marque & Brand DNA

- [ ] L'univers visuel traduit fidèlement la personnalité, la mission et les valeurs du projet.
- [ ] La direction artistique appliquée correspond sans ambiguïté à l'une des 5 directions officielles (`Swiss Editorial`, `Luxury Editorial`, `Afro-Contemporary`, `Organic Modern`, `Neo-Brutalism`).
- [ ] La signature visuelle et le logotype sont intégrés avec respect des zones d'exclusion.
- [ ] L'ambiance générale ne crée aucun contresens émotionnel par rapport à la cible visée.

---

## 2. Contrôle Anti-Généricité & Différenciation

- [ ] **Test du bandeau masqué :** Si on masque le logo, reconnaît-on encore la singularité du produit ?
- [ ] **Dégradés interdits :** Aucun dégradé violet/bleu fluo générique non justifié par la charte.
- [ ] **Cartes & Conteneurs :** Les cartes ont une géométrie motivée (bords vifs pour Swiss Editorial, pleines pages pour Luxury, galets pour Organic Modern, bordures épaisses pour Neo-Brutalism), et non un arrondi uniforme de 12px copié d'un template SaaS.
- [ ] **Ombrages :** Aucune ombre portée floue et grisâtre étalée partout sans justification lumineuse.
- [ ] **Tableaux de bord :** Zéro alignement passif de 4 KPI cards clonées. L'information prioritaire est mise en scène selon les flux réels du métier.
- [ ] **Section Héro :** La composition d'accroche présente une mise en scène originale adaptée au produit et non un simple "titre à gauche / image à droite" passe-partout.
- [ ] **Catalogue produit :** La présentation des articles répond spécifiquement à la nature des produits (mode, électronique, alimentation, etc.).

---

## 3. Architecture UX & Ergonomie

- [ ] Les parcours d'utilisation majeurs sont fluides, logiques et sans impasse.
- [ ] La hiérarchie visuelle guide le regard du premier coup d'œil vers l'action prioritaire.
- [ ] La navigation est intuitive et structurée selon le modèle mental des utilisateurs.
- [ ] Tous les états des composants sont pensés : repos, survol, clic/actif, focus clavier, état désactivé, chargement, erreur, confirmation de succès.
- [ ] Les messages d'erreur sont bienveillants, explicites et indiquent la voie de résolution.

---

## 4. Rigueur UI & Système de Design

- [ ] La palette de couleurs est restreinte et chaque couleur possède un rôle fonctionnel clair.
- [ ] L'échelle typographique est respectée (pas plus de 2 familles de polices, 4 à 5 graisses/tailles bien hiérarchisées).
- [ ] Les espacements suivent une grille modulaire stricte (multiples de 4px ou 8px).
- [ ] Les alignements sont rigoureux et nets.

---

## 5. Responsive & Adaptation Terrain

- [ ] L'expérience mobile a été conçue comme une expérience de premier rang, non comme une simple réduction du desktop.
- [ ] Les zones d'action tactile (*touch targets*) mesurent au minimum 44px $\times$ 44px (ou 48px pour les applications terrain).
- [ ] Les textes restent parfaitement lisibles sur petit écran sans zoom horizontal.
- [ ] Les contrastes permettent une utilisation en extérieur sous lumière vive (ratio $\ge$ 4.5:1 pour le texte normal, $\ge$ 7:1 pour les flux critiques).

---

## 6. Fidélité d'Intégration Technique (PHP / CSS / Bootstrap)

- [ ] L'interface développée en PHP Vanilla MVC est conforme au pixel près à la maquette validée.
- [ ] Aucune dépendance inutile n'a été ajoutée (pas de framework CSS redondant, pas de Node.js en production).
- [ ] Le code HTML est sémantique (`<main>`, `<nav>`, `<article>`, `<header>`, `<footer>`).
- [ ] Les performances de chargement sont optimales (poids des images compressé, polices web optimisées).
