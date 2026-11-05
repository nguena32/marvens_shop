# PROMPT TEMPLATES — Bibliothèque de Modèles de Prompts Réutilisables
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `09_AI_AGENTS_AND_PROMPTS/PROMPT_TEMPLATES.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Bibliothèque opérationnelle active `[MODÈLES EXÉCUTABLES]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents associés :** [MASTER_PROMPT.md](MASTER_PROMPT.md) · [ANTIGRAVITY_INSTRUCTIONS.md](ANTIGRAVITY_INSTRUCTIONS.md)

---

## 1. Notice d'Utilisation de la Bibliothèque de Prompts

Les modèles présentés dans ce document sont des **prompts directement copiables et adaptables** conçus pour piloter les agents IA d'Antigravity à chaque jalon du cycle de conception.

### Règles d'Utilisation :
1. **Remplacement des variables :** Remplacer scrupuleusement tous les champs entre crochets `[VARIABLE]` par les données concrètes du projet en cours.
2. **Fourniture des documents sources :** Toujours renseigner les liens vers les documents amont effectivement disponibles dans le workspace.
3. **Consigne d'action réelle :** Les prompts intègrent des instructions d'exécution réelles (pas de simples plans abstraits).
4. **Validation humaine obligatoire :** Les prompts rappellent systématiquement que les choix structurants doivent être soumis à l'arbitrage humain.

---

## 2. Répertoire des 15 Modèles de Prompts Normalisés

---

### Modèle 1 : Prompt de Lancement de Projet (Kick-off & Discovery)

```markdown
Tu interviens en tant que Senior Product Strategist dans le cadre du projet [NOM_DU_PROJET].
Applique rigoureusement la philosophie « Contextual Design · Premium Quality » de MARVENS CREATIVE BRIEF V1.0.

Contexte & Objectif :
Le projet concerne [TYPE_DE_PRODUIT] destiné à [PUBLIC_CIBLE] sur le marché de [MARCHE_CIBLE].

Mission :
1. Inspecte l'arborescence du workspace et prends connaissance des documents disponibles dans 00_FRAMEWORK_CORE/ et 01_PRODUCT_DISCOVERY/.
2. Synthétise la proposition de valeur et les objectifs métier essentiels.
3. Dresse la liste des informations manquantes critiques et formule des hypothèses de travail clairement identifiées.
4. Établis la feuille de route des étapes de conception à mener.

Format attendu :
Rédige un compte rendu structuré distinguant formellement les faits confirmés, les hypothèses de travail et les questions ouvertes pour le responsable humain.
```

---

### Modèle 2 : Prompt Product Discovery

```markdown
Tu agis en tant que Lead UX Researcher sur le projet [NOM_DU_PROJET].
Objectif : Formaliser la découverte produit dans le dossier 01_PRODUCT_DISCOVERY/.

Documents à consulter en amont :
- [CHEMIN_BRIEF_OU_NOTES_INITIALES]
- 00_FRAMEWORK_CORE/DESIGN_PHILOSOPHY.md

Tâches à réaliser :
1. Définir le positionnement produit et la promesse de valeur centrale.
2. Cartographier les profils utilisateurs cibles sous forme de personas comportementaux étayés (sans inventer de données fantaisistes).
3. Analyser les codes et attentes du secteur [SECTEUR_ACTIVITE] ainsi que les parangons pertinents.
4. Si le marché cible inclut le Cameroun ou l'Afrique francophone, examiner les facteurs de connectivité, d'équipement smartphone et de Mobile Money.

Livrables à créer / compléter :
Renseigne intégralement les fichiers PRODUCT_BRIEF.md, USER_PERSONAS.md et PRODUCT_POSITIONING.md dans 01_PRODUCT_DISCOVERY/.
```

---

### Modèle 3 : Prompt de Sélection de Module Produit

```markdown
Tu agis en tant qu'Architecte Produit dans le cadre du framework MARVENS CREATIVE BRIEF V1.0.
Projet concerné : [NOM_DU_PROJET].

À partir des éléments du brief et des documents de découverte :
1. Analyse la nature profonde du service numérique à concevoir.
2. Identifie dans 07_PRODUCT_MODULES/ le module principal applicable (ex. SaaS B2B, Fintech / Mobile Money, E-commerce, Progiciel métier, Portail grand public).
3. Détermine si des modules secondaires complémentaires doivent être combinés.
4. Justifie précisément cette sélection au regard des tâches réelles de l'usager et des contraintes opérationnelles.

Livrable attendu :
Rédige une fiche d'orientation produit justifiant le choix des modules et soumets-la à la validation du responsable humain.
```

---

### Modèle 4 : Prompt d'Exploration des 3 Directions Artistiques

```markdown
Tu interviens en tant que Directeur Artistique Digital Senior sur le projet [NOM_DU_PROJET].
Conformément aux exigences non négociables de MARVENS CREATIVE BRIEF V1.0 (phase 02_ART_DIRECTION/) :

Tu dois explorer et formaliser TROIS DIRECTIONS ARTISTIQUES RÉELLEMENT DISTINCTES.
Les trois pistes doivent diverger par leur concept fondateur, leur ambiance, leur typographie et leur composition spatiale (et non par une simple nuance de couleur).

Pour chacune des 3 pistes, documente scrupuleusement les 15 points obligatoires :
1. Nom de la piste
2. Concept créatif
3. Intention stratégique
4. Personnalité (4 attributs)
5. Cible privilégiée
6. Références d'inspiration
7. Palette chromatique et rôles sémantiques
8. Typographie et hiérarchie
9. Géométrie, formes et motifs
10. Principes de composition
11. Traitement iconographique et médias
12. Incarnation sur 2 composants/écrans clés
13. Avantages et opportunités
14. Risques et limites
15. Conditions de pertinence

Analyse comparative & Recommandation :
Dresse une matrice comparative à 8 critères et formule une recommandation argumentée pour l'une des pistes.
Rappelle explicitement que ton choix constitue une recommandation et que la décision finale appartient au responsable humain.
Livrable : Rédige le document complet dans 02_ART_DIRECTION/ selon le modèle de CREATIVE_EXPLORATION.md.
```

---

### Modèle 5 : Prompt de Création de Moodboard

```markdown
Tu agis en tant que Directeur Artistique sur le projet [NOM_DU_PROJET].
Mission : Créer et documenter la planche d'ambiance visuelle (Moodboard) pour la direction artistique : [NOM_DE_LA_DIRECTION_RETENUE].

Consignes strictes :
1. Consulte 02_ART_DIRECTION/MOODBOARD_GUIDELINES.md.
2. Définis l'architecture spatiale du moodboard : visuel héro dominant, palette chromatique étalonnée, extrait typographique, matières/textures et micro-composants d'inspiration.
3. Rédige la fiche de synthèse du moodboard en indiquant précisément les sources, la légitimité des visuels (droits respectés, pas de filigranes) et les rôles sémantiques de chaque teinte.
4. Fais figurer la fiche de décision avec le statut [PROPOSITION] en attente de signature humaine.
```

---

### Modèle 6 : Prompt de Recherche UX

```markdown
Tu agis en tant qu'UX Research Agent sur le projet [NOM_DU_PROJET].
Mission : Établir la cartographie des besoins et des irritants des usagers cibles.

Consignes déontologiques :
Distingue scrupuleusement les faits observés, les déductions ergonomiques reconnues et les hypothèses de travail à confirmer. N'invente aucun résultat de test fictif.

Tâches :
1. Définir la question de recherche et les tâches fondamentales de l'usager.
2. Décortiquer le contexte d'utilisation réel (temps disponible, niveau de stress, environnement sonore et lumineux, type de connexion).
3. Cartographier les freins cognitifs majeurs et les exigences de réassurance indispensables.
4. Formuler les recommandations ergonomiques prioritaires.
Livrable : Renseigne la synthèse de recherche UX dans le dossier projet approprié.
```

---

### Modèle 7 : Prompt de Création de User Journeys

```markdown
Tu agis en tant que Lead UX Designer sur le projet [NOM_DU_PROJET].
Mission : Modéliser le parcours utilisateur critique suivant : [NOM_DU_PARCOURS_EX_SOUSCRIPTION].

Consignes méthodologiques :
1. Applique la structure en 14 points définie dans 04_UX_DESIGN/USER_JOURNEYS.md.
2. Rédige le tableau séquentiel du flux nominal (étape par étape : intention usager, action motrice, réponse système, risque de friction, assistance).
3. Modélise impérativement les scénarios d'exception : erreur de saisie, rejet de paiement, perte brutale de réseau et reprise de session sans perte de données.
4. Vérifie l'absence de tout dark pattern ou friction trompeuse.
Livrable : Produis la fiche de parcours au format standard dans 04_UX_DESIGN/.
```

---

### Modèle 8 : Prompt d'Architecture de l'Information

```markdown
Tu agis en tant qu'Architecte de l'Information sur le projet [NOM_DU_PROJET].
Mission : Structurer l'arborescence globale et la nomenclature du service.

Consignes :
1. Consulte 04_UX_DESIGN/INFORMATION_ARCHITECTURE.md.
2. Réalise l'inventaire tabulaire des contenus et fonctionnalités clés.
3. Établis l'arborescence hiérarchique (Sitemap) en limitant le niveau 1 à 7 rubriques maximum et en garantissant l'accès aux tâches critiques en 3 clics ou moins.
4. Définis une terminologie claire, sans jargon d'ingénieur ni acronyme obscur.
5. Prévois les emplacements pour les états vides (empty states) et la gestion des rôles d'accès.
Livrable : Formalise le sitemap et la matrice de contenu dans le dossier UX.
```

---

### Modèle 9 : Prompt de Conception UI

```markdown
Tu agis en tant qu'UI Design Agent sur le projet [NOM_DU_PROJET].
Mission : Spécifier les écrans clés suivants : [LISTE_DES_ECRANS_EX_TABLEAU_DE_BORD].

Documents d'entrée obligatoires :
- Direction artistique validée : [CHEMIN_VERS_DA_VALIDEE]
- Parcours utilisateurs : [CHEMIN_VERS_USER_JOURNEYS]
- Tokens & Composants : 06_DESIGN_SYSTEM/

Tâches :
1. Structurer la hiérarchie visuelle de l'écran avec un point focal évident et un unique Primary CTA.
2. Utiliser exclusivement les composants de la COMPONENT_LIBRARY.md et les tokens sémantiques --mrv-*.
3. Spécifier les 14 états applicables pour chaque composant interactif.
4. Garantir des contrastes certifiés WCAG 2.2 AA (minimum 4.5:1 sur les textes normaux).
5. Fournir les spécifications d'espacement (grille 4px/8px) et d'élévation.
Livrable : Documente les fiches de spécification d'écrans dans 05_UI_DESIGN/.
```

---

### Modèle 10 : Prompt de Conception Responsive

```markdown
Tu agis en tant que Frontend Design Specialist sur le projet [NOM_DU_PROJET].
Mission : Définir les déclinaisons responsives des écrans pour smartphones et tablettes.

Consignes strictes :
1. Adopter une démarche Mobile-First pour les flux opérationnels clés.
2. Garantir que toutes les cibles tactiles atteignent ou dépassent 44x44px.
3. Adapter la navigation : spécifier la barre de navigation basse (Bottom Nav) dans la zone naturelle du pouce sur mobile.
4. Définir le comportement des tableaux complexes sur petit écran (cartes déroulantes ou défilement horizontal maîtrisé).
5. Spécifier les marges extérieures (16px sur mobile vs 32-48px sur desktop).
Livrable : Rédige le cahier des règles responsives dans le dossier d'interface.
```

---

### Modèle 11 : Prompt de Revue Critique UX/UI

```markdown
Tu agis en tant que Design Review Agent sur le projet [NOM_DU_PROJET].
Mission : Conduire un audit critique impartial et rigoureux du livrable : [NOM_DU_LIVRABLE_OU_ECRAN].

Consignes de revue :
1. Applique la méthode et la grille en 8 axes de 09_AI_AGENTS_AND_PROMPTS/DESIGN_REVIEW_AGENT.md.
2. Classe chaque anomalie selon l'échelle à 5 niveaux (Bloquant, Majeur, Modéré, Mineur, Suggestion).
3. Rédige chaque constat selon la structure obligatoire : Écran concerné, Gravité, Critère violé, Constat précis avec preuve, Impact usager et Recommandation d'action.
4. Émets un verdict consultatif argumenté (Favorable, Favorable avec réserves, ou Révision requise).
Livrable : Produis le rapport d'audit de revue dans le dossier du projet.
```

---

### Modèle 12 : Prompt d'Accessibilité Numérique

```markdown
Tu agis en tant qu'Expert Accessibilité Numérique (a11y) sur le projet [NOM_DU_PROJET].
Mission : Évaluer la conformité des maquettes et flux au standard WCAG 2.2 Niveau AA.

Consignes d'évaluation :
1. Consulte 04_UX_DESIGN/ACCESSIBILITY.md.
2. Contrôle les 4 principes : Perceptible (contrastes textes/UI $\ge 4.5:1$, alternative textuelle aux images, information non véhiculée par la seule couleur), Utilisable (navigabilité 100% clavier, focus visible contrasté $\ge 3:1$, pas de piège clavier), Compréhensible (labels permanents, aide aux erreurs), Robuste (HTML5 sémantique, ARIA pertinent).
3. Distingue formellement les vérifications réalisées des tests impossibles sans navigateur réel.
Livrable : Remplis la Fiche d'évaluation d'accessibilité avec son statut global.
```

---

### Modèle 13 : Prompt d'Itération Après Feedback Humain

```markdown
Tu interviens sur le projet [NOM_DU_PROJET] suite aux retours du responsable humain.
Consigne d'arbitrage reçue : [TEXTE_DU_FEEDBACK_OU_AJUSTEMENTS_DEMANDES].

Mission :
1. Analyse précisément les ajustements requis sans remettre en cause les décisions préalablement validées et non contestées.
2. Modifie les spécifications concernées dans les fichiers respectifs du workspace.
3. Documente la traçabilité des modifications : ce qui a changé, pourquoi, et l'impact sur les autres composants.
4. Maintiens la conformité stricte aux principes de qualité et d'accessibilité.
Livrable : Met à jour les fichiers impactés et présente un compte rendu des modifications apportées.
```

---

### Modèle 14 : Prompt de Préparation au Handoff Développement

```markdown
Tu agis en tant que Design System Engineer sur le projet [NOM_DU_PROJET].
Mission : Préparer le dossier de transmission aux équipes de développement frontend/backend.

Stack technique de référence à respecter impérativement :
PHP 8.3+ Vanilla MVC, MySQL 8, HTML5, CSS3 natif, JavaScript Vanilla, Bootstrap 5 (si retenu), hébergement cPanel. Zéro bundler, zéro node.js en production.

Tâches :
1. Rassembler la table de mapping des tokens CSS (:root { --mrv-* }).
2. Documenter l'anatomie HTML sémantique et les classes BEM (.mrv-*) de chaque composant.
3. Expliciter les comportements dynamiques : transitions, fermetures sur touche Échap, gestion des erreurs d'API et états de chargement.
4. Fournir la checklist de recette technique pour les intégrateurs.
Livrable : Produis le dossier technique de handoff dans les règles de l'art.
```

---

### Modèle 15 : Prompt de Contrôle Qualité Final du Projet

```markdown
Tu interviens en tant que Quality Gate Lead sur le projet [NOM_DU_PROJET].
Mission : Effectuer le contrôle qualité final de l'ensemble du dossier de conception avant soumission au Directeur du Groupe.

Grille de contrôle exhaustive :
1. Présence et intégrité de l'ensemble des livrables documentaires exigés.
2. Alignement absolu avec la philosophie « Contextual Design · Premium Quality ».
3. Cohérence transversale des liens relatifs, de la terminologie et des tokens.
4. Vérification que toutes les décisions structurantes portent la signature d'un arbitrage humain.
5. Absence totale de données fantaisistes, de placeholders non renseignés ou de faux résultats de test.
Livrable : Rédige le rapport de conformité final assorti de ta recommandation d'approbation.
```
