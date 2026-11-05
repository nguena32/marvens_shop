# GUIDE D'UTILISATION OFFICIEL — MARVENS CREATIVE BRIEF V2.0
## De la Stratégie de Marque à l'Implémentation Différenciée

> **Emplacement :** `00_FRAMEWORK_CORE/GUIDE_UTILISATION.md`  
> **Statut :** Manuel opérationnel de référence  
> **Système :** Bibliothèque de Systèmes de Design & Framework Directeur

---

## Sommaire Général

1. [Vision et Mission de Marvens Creative Brief V2.0](#1-vision-et-mission-de-marvens-creative-brief-v20)
2. [L'Écosystème et le Workflow de Conception en 7 Étapes](#2-lécosystème-et-le-workflow-de-conception-en-7-étapes)
3. [La Bibliothèque des 5 Directions Artistiques](#3-la-bibliothèque-des-5-directions-artistiques)
4. [Le Design Differentiation Engine (Lutte contre le design générique IA)](#4-le-design-differentiation-engine-lutte-contre-le-design-générique-ia)
5. [Intégration Google Stitch : De l'Exploration Visuelle à la Validation](#5-intégration-google-stitch--de-lexploration-visuelle-à-la-validation)
6. [Transmission aux Agents Antigravity / Codex & Standards Techniques](#6-transmission-aux-agents-antigravity--codex--standards-techniques)
7. [Design Review & Assurance Qualité](#7-design-review--assurance-qualité)
8. [Système d'Initialisation, Sauvegarde et Historique des Archives ZIP](#8-système-dinitialisation-sauvegarde-et-historique-des-archives-zip)
9. [Étude de Cas Concrète : Boutique E-Commerce Différenciée](#9-étude-de-cas-concrète--boutique-e-commerce-différenciée)

---

## 1. Vision et Mission de Marvens Creative Brief V2.0

Le framework **Marvens Creative Brief** n'est ni un simple générateur de formulaires, ni une simple collection de moodboards. C'est le **système propriétaire de direction artistique et de conception produit de Marvens Group**.

Sa mission fondamentale est de :
- Conférer à chaque application une **identité de marque propre et singulière**.
- Bannir le réflexe des agents IA de produire des interfaces stéréotypées et génériques.
- Structurer les décisions créatives et ergonomiques avant toute écriture de code.
- Piloter efficacement les outils d'exploration visuelle (comme **Google Stitch**) tout en conservant une indépendance d'outillage totale.
- Fournir un cadre d'implémentation robuste aux agents de développement (**Antigravity**, **Codex**) sur la stack Marvens (PHP Vanilla MVC, MySQL, Bootstrap 5).

---

## 2. L'Écosystème et le Workflow de Conception en 7 Étapes

Le processus d'élaboration d'un produit Marvens suit un cycle rigoureux et séquentiel :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 LE WORKFLOW OPÉRATIONNEL MARVENS EN 7 ÉTAPES                │
├─────────────────────────────────────────────────────────────────────────────┤
│ Étape 1 : Marvens Creative Brief ──> Positionnement, Cible, Valeur, Métier │
│ Étape 2 : Marvens Art Direction  ──> Choix parmi les 5 Systèmes de Design  │
│ Étape 3 : Marvens UI / UX        ──> Parcours, Écrans, Navigation & Mobile  │
│ Étape 4 : Google Stitch          ──> Exploration & 3 Propositions Visuelles │
│ Étape 5 : Design Validation      ──> Arbitrage Humain & Score Qualité       │
│ Étape 6 : Antigravity / Codex    ──> Dév. PHP 8.3 Vanilla MVC & Bootstrap   │
│ Étape 7 : QA Design              ──> Audit de conformité pixel & accessibilité│
└─────────────────────────────────────────────────────────────────────────────┘
```

1. **Étape 1 — Marvens Creative Brief :** Cadrage complet du projet via l'application web ou les templates du dossier `01_PRODUCT_DISCOVERY/` et `11_PROJECT_TEMPLATES/`.
2. **Étape 2 — Marvens Art Direction :** Sélection et personnalisation d'une direction artistique officielle dans `02_ART_DIRECTION/DIRECTIONS/`.
3. **Étape 3 — Marvens UI/UX :** Définition de l'architecture d'information, des flux majeurs et de l'adaptation mobile.
4. **Étape 4 — Google Stitch :** Utilisation des prompts calibrés de `07_STITCH_INTEGRATION/` pour générer au moins 3 concepts d'écrans clés distincts.
5. **Étape 5 — Design Validation :** Évaluation humaine à l'aide de la checklist `10_QUALITY_ASSURANCE/DESIGN_REVIEW_CHECKLIST.md`.
6. **Étape 6 — Antigravity / Codex :** Développement de l'application selon les normes techniques pérennes de Marvens Group.
7. **Étape 7 — QA Design :** Contrôle final de l'interface en production par rapport à la maquette de référence.

---

## 3. La Bibliothèque des 5 Directions Artistiques

Le framework met à disposition 5 systèmes de design complets, chacun documenté avec ses règles typographiques, chromatiques, spatiales et ses interdictions :

1. **Swiss Editorial Commerce :**
   - *Pour :* Boutiques professionnelles, quincaillerie de précision, B2B technique, équipements industriels.
   - *ADN :* Rigueur cartésienne, clarté absolue, typographie néo-grotesque (`Inter` / `Helvetica`), filets séparateurs de 1px continus, cartes rectangulaires nettes (radius: 0-2px), prix en chiffres tabulaires.
2. **Luxury Editorial :**
   - *Pour :* Haute joaillerie, mode haut de gamme, cosmétiques d'exception, vins rares.
   - *ADN :* Sérif magistrale (`Playfair` / `Cormorant`), fond albâtre `#FAF9F6`, grand blanc tournant, visuels immersifs plein format, absence de bordures lourdes, storytelling exclusif.
3. **Afro-Contemporary :**
   - *Pour :* Marques panafricaines, mode contemporaine, fintechs africaines, épiceries fines, galeries d'art.
   - *ADN :* Ocre brûlé `#C25E38`, indigo profond `#1E293B`, terre d'ombre `#1C1917`, typographies géométriques expressives (`Syne` / `Epilogue`), motifs géométriques vectoriels subtils, Mobile-First et intégrations locales (Mobile Money, WhatsApp).
4. **Organic Modern :**
   - *Pour :* Alimentation biologique, soins naturels, herboristerie, artisanat éco-responsable.
   - *ADN :* Palette botanique (sauge `#4A6B53`, olive, terracotta poudrée), fond lin lavé `#F7F5F0`, formes galets douces (radius: 16-24px, boutons pilules), décomposition transparente des ingrédients.
5. **Neo-Brutalism :**
   - *Pour :* Streetwear, créateurs indépendants, médias alternatifs, startups fintech décalées.
   - *ADN :* Bordures noires épaisses (2.5px solid #000), ombres dures sans flou (`box-shadow: 4px 4px 0px #000`), aplats jaune fluo `#FFE600` et cyan acide, typographies massives et boutons mécaniques tactiles.

---

## 4. Le Design Differentiation Engine (Lutte contre le design générique IA)

Pour garantir que deux applications Marvens ne se ressemblent jamais, le module `00_FRAMEWORK_CORE/DESIGN_DIFFERENTIATION_ENGINE.md` impose de résoudre 10 arbitrages obligatoires :
1. **Brand DNA** (personnalité et promesse).
2. **Layout & Composition** (rythme et densité).
3. **Navigation** (structure adaptée aux habitudes utilisateurs).
4. **Typographie** (voix de marque et lisibilité).
5. **Logique des Couleurs** (justification sémantique).
6. **Traitement Produits** (mise en valeur adaptée à la catégorie d'articles).
7. **Direction Photographique** (éclairage et cadrages).
8. **Interactions & Micro-animations** (rythme et gratifications).
9. **Expérience Mobile** (ergonomie tactile à une main).
10. **Composants & Délimitations** (bordures, ombres, rayons spécifiques).

---

## 5. Intégration Google Stitch : De l'Exploration Visuelle à la Validation

Google Stitch intervient à l'étape 4 comme outil d'exploration :
- Utiliser le canevas de prompt documenté dans `07_STITCH_INTEGRATION/STITCH_INTEGRATION_GUIDE.md`.
- Demander impérativement **3 concepts d'interface différents** pour challenger la créativité.
- Refuser les sorties contenant des dégradés ou ombres interdits.
- Sélectionner la proposition la plus fidèle et affiner les composants.

---

## 6. Transmission aux Agents Antigravity / Codex & Standards Techniques

Une fois l'interface validée, elle est transmise aux agents de développement avec respect des contraintes d'infrastructure du groupe :
- **Architecture :** PHP 8.3+ Vanilla MVC (sans framework tiers lourd).
- **Base de données :** MySQL 8 via requêtes préparées PDO strictes.
- **Frontend :** HTML5 sémantique, CSS modulaire avec Design Tokens, Bootstrap 5 épuré.
- **Production :** Compatibilité totale mutualisé / cPanel, zéro Node.js en production, zéro conteneur Docker obligatoire, maîtrise des coûts d'hébergement.

---

## 7. Design Review & Assurance Qualité

Avant toute mise en ligne :
- Exécuter la checklist `10_QUALITY_ASSURANCE/DESIGN_REVIEW_CHECKLIST.md`.
- Contrôler le respect des contrastes WCAG 2.1 AA (minimum 4.5:1 pour le texte normal).
- Attribuer la note de validation via `09_AI_AGENTS_AND_PROMPTS/DESIGN_REVIEW_AGENT.md` (score minimal exigé : 85/100).

---

## 8. Système d'Initialisation, Sauvegarde et Historique des Archives ZIP

L'application web Marvens Creative Brief intègre un système complet d'initialisation et de persistance :
1. **Renseignement guidé :** Questionnaire interactif en 8 sections pour capturer le contexte projet.
2. **Assemblage automatisé :** Le moteur copie le framework source (73 documents doctrinaux intacts) et injecte le contexte projet personnalisé.
3. **Persistance des ZIP :** Chaque archive générée est stockée de manière sécurisée et immuable dans `storage/generated/` avec son horodatage et son empreinte unique.
4. **Historique des projets :** Un journal centralisé des projets créés est maintenu dans `storage/projects_history.json`.
5. **Re-téléchargement instantané :** Tout utilisateur peut accéder à la page d'historique (`index.php?action=history`) pour visualiser les projets créés, leur direction artistique et re-télécharger à tout moment l'archive ZIP sans régénérer.

---

## 9. Étude de Cas Concrète : Boutique E-Commerce Différenciée

### Contexte : "Kaly Botanics" — Soins cosmétiques bio d'Afrique centrale
- **Secteur :** Cosmétiques naturels et herboristerie.
- **Direction Artistique retenue :** Hybridation maîtrisée entre **04 Organic Modern** (70%) et **03 Afro-Contemporary** (30%).
- **Choix de différenciation :**
  - Fond lin naturel `#F7F5F0`, accents ocre doux `#C25E38` et vert sauge `#4A6B53`.
  - Cartes produits galets (`border-radius: 16px`), sans ombres agressives.
  - Fiches produits intégrant la liste des ingrédients INCI vulgarisée et le label "Récolté à l'état sauvage au Cameroun".
  - Intégration en haut de page du support direct WhatsApp et paiement Mobile Money pour les commandes rapides.
- **Résultat :** Une boutique immédiatement reconnaissable, chaleureuse, éthique et radicalement différente d'un template e-commerce générique.
