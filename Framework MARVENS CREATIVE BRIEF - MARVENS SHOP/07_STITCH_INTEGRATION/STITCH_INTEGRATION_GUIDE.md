# STITCH INTEGRATION GUIDE — Guide d'Intégration et d'Exploration Visuelle
## MARVENS CREATIVE BRIEF V2.0 · GOOGLE STITCH AS CREATIVE COMPANION

> **Emplacement :** `07_STITCH_INTEGRATION/STITCH_INTEGRATION_GUIDE.md`  
> **Statut :** Protocole d'exploration et de maquetage validé  
> **Doctrine :** *Strategy First, Tool Agnostic · Controlled AI Generation*  
> **Documents associés :** [VISUAL_STYLE_LIBRARY.md](../02_ART_DIRECTION/VISUAL_STYLE_LIBRARY.md) · [DESIGN_DIFFERENTIATION_ENGINE.md](../00_FRAMEWORK_CORE/DESIGN_DIFFERENTIATION_ENGINE.md) · [DESIGN_REVIEW_CHECKLIST.md](../10_QUALITY_ASSURANCE/DESIGN_REVIEW_CHECKLIST.md)

---

## 1. Rôle et Articulation de Google Stitch dans l'Écosystème Marvens

Dans l'architecture de conception **Marvens Creative Brief**, Google Stitch est positionné comme un **puissant accélérateur d'exploration visuelle et de prototypage d'interface**, et non comme un décideur stratégique.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LE CYCLE DE GOUVERNANCE CRÉATIVE                      │
├─────────────────────────────────────────────────────────────────────────────┤
│ 1. MARVENS CREATIVE BRIEF │ Pilote : Stratégie, Brand DNA, DA, Règles Métier│
│ 2. GOOGLE STITCH          │ Outil  : Exploration multi-propositions, maquettes │
│ 3. DESIGN REVIEW MARVENS  │ Filtre : Contrôle anti-généricité, validation DA   │
│ 4. ANTIGRAVITY / CODEX    │ Moteur : Implémentation PHP Vanilla MVC / Bootstrap│
└─────────────────────────────────────────────────────────────────────────────┘
```

> [!NOTE]
> **Autonomie du framework :**  
> Marvens Creative Brief n'a pas de dépendance technique obligatoire avec Google Stitch. Le framework produit des spécifications universelles qui peuvent alimenter aussi bien Stitch que Figma, un atelier de design ou directement un agent d'implémentation.

---

## 2. Le Protocole en 11 Étapes : du Brief à la Validation

Pour concevoir une interface singulière avec Google Stitch :

1. **Extraction du Brand DNA :** Récupérer la personnalité, la cible, la promesse et l'émotion dominante définies dans le brief.
2. **Attribution de la Direction Artistique :** Sélectionner l'une des 5 directions officielles (`Swiss Editorial`, `Luxury Editorial`, `Afro-Contemporary`, `Organic Modern`, `Neo-Brutalism`).
3. **Application de la Matrice de Différenciation :** Remplir les décisions d'arbitrage (Layout, cartes, typographie, ombres, mobile).
4. **Formulation du Master Prompt Stitch :** Compiler les contraintes et interdictions dans le prompt prêt à l'emploi.
5. **Génération Multi-Variantes :** Demander explicitement à Stitch de produire **au minimum 3 propositions de composition profondément distinctes** pour l'écran clé (ex. page d'accueil ou fiche produit).
6. **Évaluation selon la Grille Marvens :** Noter chaque proposition sur l'identité, l'adéquation métier et l'absence de clichés génériques.
7. **Sélection et Itération :** Retenir la meilleure proposition et demander à Stitch des ajustements fins sur les composants spécifiques.
8. **Déclinaison des Écrans Seconds :** Générer les écrans de flux transactionnel (panier, checkout, confirmation, compte).
9. **Formalisation de la Synthèse Validée :** Enregistrer les maquettes et captures dans le dossier de documentation projet (`docs/design-references/`).
10. **Transmission à Antigravity / Codex :** Fournir les visuels validés et le cahier des charges aux agents de développement.
11. **Contrôle QA Design Post-Implémentation :** Comparer au pixel près l'interface développée en PHP/CSS avec la maquette validée.

---

## 3. Structure d'un Prompt Optimisé pour Google Stitch

Pour obtenir des interfaces de haute qualité débarrassées des automatismes génériques de l'IA, le prompt Stitch doit impérativement respecter la structure suivante :

```text
PROMPT STRUCTURE MARVENS CREATIVE BRIEF -> GOOGLE STITCH

[1. CONTEXTE PRODUIT & MARCHÉ]
Rôle : Tu es un designer UI/UX senior d'exception.
Produit : [Nom du projet]
Activité & Catalogue : [Description exacte des articles et du secteur métier]
Cible & Usagers : [Profil des utilisateurs et contexte d'usage]

[2. DIRECTION ARTISTIQUE ASSIGNÉE]
Direction sélectionnée : [01 Swiss Editorial | 02 Luxury Editorial | 03 Afro-Contemporary | 04 Organic Modern | 05 Neo-Brutalism]
ADN visuel attendu : [Copier le bloc ADN de la fiche correspondante]
Palette chromatique stricte :
- Fond principal : [Code HEX]
- Encre / Texte : [Code HEX]
- Accents : [Code HEX]
Typographie : [Display Titres] + [Body Texte]
Forme des conteneurs : [Rayons de courbure ex: 0px / 16px, type de bordure]
Traitement des ombres : [Type d'ombre ex: aucune / dure 4px / feutrée]

[3. RÈGLES DE DIFFÉRENCIATION & ANTI-GÉNÉRICITÉ (INTERDICTIONS FORMELLES)]
- INTERDIT : Dégradés bleu/violet génériques, fonds gris ternes avec cartes identiques, arrondis 12px partout.
- INTERDIT : 3 KPI cards de dashboard copiées d'un template.
- INTERDIT : Héro standard titre gauche / image droite.
- OBLIGATOIRE : Conception ancrée dans la spécificité métier : [Préciser les éléments métier clés].

[4. ÉCRANS & COMPOSANTS À GÉNÉRER]
Écran prioritaire : [Ex: Page d'accueil avec mise en avant collection + Carte produit détaillée]
Composants obligatoires : [Navigation personnalisée, filtres métiers, boutons d'action typés].
Génère 3 variations de composition spatiale fortement différenciées.
```

---

## 4. Transmission Technique vers Antigravity & Standards Marvens

Lorsque la maquette Stitch est validée par l'arbitrage humain, la transmission aux agents de développement (Antigravity ou Codex) doit respecter le cadre technique Marvens :

- **Stack Front :** HTML5 sémantique, CSS3 moderne (Variables CSS personnalisées / Design Tokens) et Bootstrap 5 épuré de ses styles par défaut.
- **Stack Back :** PHP 8.3+ Vanilla MVC (sans framework lourd, sans Node.js en production).
- **Base de données :** MySQL 8 via PDO sécurisé.
- **Accessibilité :** Ratios de contraste WCAG AA validés sur la maquette.
