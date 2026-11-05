# CHANGELOG — Historique des versions
## MARVENS CREATIVE BRIEF V1.0

> **Système de versionnement :** Versionnement sémantique (SemVer : *Majeure.Mineure.Correctif*)  
> **Dossier :** `00_FRAMEWORK_CORE/`  
> **Entité émettrice :** Marvens Group — Pôle Design & Stratégie Produit

---

## Convention de versionnement

Les évolutions du framework central s'articulent selon les principes suivants :

* **Version Majeure (`X.0.0`) :** Refonte structurelle, réorientation philosophique profonde, modification des rôles fondamentaux de gouvernance ou restructuration complète des phases du processus créatif.
* **Version Mineure (`x.Y.0`) :** Ajout de nouvelles étapes, création de nouveaux gabarits de livrables, enrichissement de la grille d'évaluation ou formalisation de nouvelles règles d'accessibilité sans rupture de compatibilité.
* **Version Corrective (`x.y.Z`) :** Corrections typographiques, clarifications de formulations ambiguës, ajustements de liens relatifs ou réorganisations mineures de mise en page.

---

## Historique des versions

### [2.0.0] — 2026-11-04

#### Évolution majeure : Bibliothèque de Systèmes de Design & Lutte Anti-Généricité IA

* **Bibliothèque des 5 Directions Artistiques de Référence :**
  * `DIR 01 — Swiss Editorial Commerce` (Professionnel, structuré, distinctif).
  * `DIR 02 — Luxury Editorial` (Prestige, élégance, désirabilité).
  * `DIR 03 — Afro-Contemporary` (Culture, modernité, identité africaine contemporaine).
  * `DIR 04 — Organic Modern` (Nature, authenticité, douceur).
  * `DIR 05 — Neo-Brutalism` (Audace, jeunesse, différenciation).
* **Création du Design Differentiation Engine (`00_FRAMEWORK_CORE/DESIGN_DIFFERENTIATION_ENGINE.md`) :**
  * Règle 1 : Interdiction formelle des recettes visuelles automatiques (dégradés violet/bleu sans justification, cartes grises uniformes 12px, ombres baveuses).
  * Règle 2 : Conception obligatoirement enracinée dans le secteur métier et le catalogue.
  * Règle 3 : Singularité de la composition et des sections héro.
  * Règle 4 : Non-partage d'identités visuelles entre applications distinctes.
  * Matrice des 10 dimensions d'arbitrage obligatoires.
* **Module Stitch Integration (`07_STITCH_INTEGRATION/STITCH_INTEGRATION_GUIDE.md`) :**
  * Protocole complet d'utilisation de Google Stitch comme accélérateur d'exploration visuelle sans dépendance exclusive.
  * Structure de Master Prompt Stitch avec interdictions anti-génériques.
* **Système de Sauvegarde et Historique des Archives ZIP :**
  * Persistance des projets dans `storage/projects_history.json`.
  * Vue récapitulative de l'historique et re-téléchargement sécurisé des ZIP antérieurs sans régénération.
* **Mise à jour des Agents IA :**
  * `09_AI_AGENTS_AND_PROMPTS/MASTER_PROMPT.md` mis à jour avec les 5 directions et interdictions strictes.
  * `09_AI_AGENTS_AND_PROMPTS/DESIGN_REVIEW_AGENT.md` et `10_QUALITY_ASSURANCE/DESIGN_REVIEW_CHECKLIST.md` enrichis avec les contrôles anti-généricité.
* **Guide d'utilisation V2.0 (`00_FRAMEWORK_CORE/GUIDE_UTILISATION.md`)** enrichi avec le workflow complet en 7 étapes et l'étude de cas e-commerce concrète.

---

### [1.0.0] — 2026-10-31

#### Création et initialisation du socle `00_FRAMEWORK_CORE/`

* **Mise en place de la doctrine centrale :**
  * Formalisation officielle de la philosophie directrice : **Contextual Design · Premium Quality**.
  * Établissement du principe d'autonomie et de singularité visuelle de chaque produit au sein de l'écosystème Marvens Group.
  * Définition concrète et mesurable des critères d'exigence Premium (précision typographique, rigueur des échelles, harmonie des espacements, contrastes stricts WCAG AA, robustesse des états).

* **Architecture opérationnelle et documentaire :**
  * Création des six fichiers piliers du socle méthodologique :
    * [`README.md`](./README.md) : Point d'entrée officiel, présentation générale, principes et parcours de lecture.
    * [`FRAMEWORK_OVERVIEW.md`](./FRAMEWORK_OVERVIEW.md) : Vision stratégique, pathologies évitées, modèle d'articulation en trois niveaux (Framework central, Briefs spécifiques, Instructions IA) et périmètre d'application.
    * [`DESIGN_PHILOSOPHY.md`](./DESIGN_PHILOSOPHY.md) : Fondements doctrinaux, analyse de la simplicité utile, adaptation culturelle/matérielle, inventaire strict de ce que le framework n'impose pas et grille d'auto-évaluation.
    * [`CREATIVE_PROCESS.md`](./CREATIVE_PROCESS.md) : Processus opérationnel séquentiel en 8 phases (Phase 0 à Phase 7) intégrant les 3 jalons obligatoires de validation humaine.
    * [`GOVERNANCE.md`](./GOVERNANCE.md) : Règles de gouvernance, matrice RACI, protocole de décision Humain-IA réaffirmant la souveraineté du responsable de projet, traitement des désaccords et gestion des exceptions.
    * [`CHANGELOG.md`](./CHANGELOG.md) : Journal officiel d'historique et règles d'évolution des documents.

* **Encadrement du partenariat Humain–IA :**
  * Définition stricte du rôle des agents IA comme explorateurs, analystes et formulateurs de recommandations argumentées.
  * Interdiction d'auto-validation définitive par l'IA sans arbitrage écrit du responsable humain.
  * Instauration du devoir de transparence avec qualification obligatoire des énoncés (`[FAIT ÉTABLI]`, `[HYPOTHÈSE DE TRAVAIL]`, `[RECOMMANDATION CRÉATIVE]`).

---

## Modèle de saisie pour les versions futures

```markdown
### [X.Y.Z] — AAAA-MM-JJ

#### Contexte de la mise à jour
* Motivation de l'évolution, retours d'expérience de projets ou nouvelles exigences métier.

#### Ajouts (Added)
* Nouveaux principes, critères, outils ou documents introduits.

#### Modifications (Changed)
* Ajustements de processus, de rôles ou de directives existantes.

#### Dépréciations / Retraits (Deprecated / Removed)
* Éléments rendus obsolètes ou supprimés du socle central.

#### Corrections (Fixed)
* Clarifications rédactionnelles, corrections de liens ou d'incohérences de terminologie.
```
