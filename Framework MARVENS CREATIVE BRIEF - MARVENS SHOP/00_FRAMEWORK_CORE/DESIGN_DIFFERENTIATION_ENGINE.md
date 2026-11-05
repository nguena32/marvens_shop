# DESIGN DIFFERENTIATION ENGINE — Moteur de Différenciation de Design
## MARVENS CREATIVE BRIEF V2.0 · LUTTE CONTRE LE DESIGN GÉNÉRIQUE IA

> **Emplacement :** `00_FRAMEWORK_CORE/DESIGN_DIFFERENTIATION_ENGINE.md`  
> **Statut :** Directive méthodologique obligatoire pour tout projet Marvens  
> **Mission :** Empêcher mathématiquement et conceptuellement les agents IA de produire des interfaces interchangeables, lisses ou standardisées.

---

## 1. Raison d'Être du Moteur de Différenciation

Les modèles d'intelligence artificielle générative ont une tendance statistique naturelle à converger vers la "moyenne" des interfaces du web : des cartes blanches à coins arrondis de 12px sur fond gris clair `#F8F9FA`, des dégradés violet/bleu non justifiés, un titre centré avec sous-titre et deux boutons arrondis, accompagnés de 3 KPI cards avec icônes colorées.

Le **Design Differentiation Engine** brise ce réflexe en imposant pour chaque projet une **grille de décision explicite et argumentée sur 10 dimensions fondamentales**.

---

## 2. Les 4 Règles Inviolables Anti-Design Générique

### Règle 1 — Interdiction des recettes visuelles automatiques
Sauf justification expresse liée à la marque ou au métier du produit, il est **formellement interdit** aux agents d'appliquer d'emblée :
- Des dégradés violet/bleu fluo ou arcs-en-ciel néon.
- Des fonds blancs uniformes surchargés de cartes grises flottantes identiques.
- Des cartes à bords arrondis uniformes sur tous les écrans sans raison structurelle.
- Des ombres portées excessives et floues (*diffuse drop shadows* décoratives).
- Des badges et micro-icônes dans chaque interstice sans utilité sémantique.
- Des dashboards composés systématiquement de 4 KPI cards clonées d'un template.
- Des sections héro composées systématiquement d'un titre à gauche et d'une image/mockup à droite.
- Des grilles de catalogue génériques sans considération pour le volume ou la nature des articles.

### Règle 2 — Conception enracinée dans le métier et le catalogue
Une boutique de mode ne s'organise pas comme une quincaillerie industrielle ou une plateforme de produits frais :
- **Mode & Habillement :** Photographie éditoriale, silhouettes entières, looks, matières, tombés de tissu, guides des tailles interactifs.
- **Électronique & Équipement :** Spécifications techniques millimétrées, comparaisons côte-à-côte, compatibilité matérielle, pièces détachées.
- **Alimentation & Frais :** Origine géographique, date de récolte/fraîcheur, labels bio/AOP, conservation, confiance immédiate.
- **Cosmétique & Soin :** Routines d'application, transparence absolue de la liste INCI (ingrédients), type de peau, textures en macro.
- **Artisanat & Objets d'art :** Histoire de l'artisan, temps de façonnage, matières nobles, finitions uniques.

### Règle 3 — Singularité de composition
L'agent doit formaliser une structure de page d'accueil et de navigation originale, dictée par la priorité cognitive de l'usager et non par un gabarit préexistant.

### Règle 4 — Non-partage d'identités visuelles
Deux applications de l'écosystème Marvens ne doivent en aucun cas partager la même composition, la même forme de carte, la même typographie ou le même univers d'ombres. La réutilisation n'est permise que pour la robustesse technique (MVC, sécurité, accessibilité).

---

## 3. Matrice d'Arbitrage des 10 Dimensions

Pour chaque projet initialisé, l'équipe ou l'agent doit répondre aux **10 questions obligatoires** du tableau suivant :

| Dimension | Question Obligatoire à Résoudre | Décision Documentée Exigée |
|---|---|---|
| **1. Brand DNA** | Quelle personnalité, cible, promesse et émotion distinguent le produit de tout concurrent ? | Définition des 3 traits de caractère de la marque et du contrat émotionnel. |
| **2. Layout & Composition** | Pourquoi cette composition spatiale plutôt qu'une grille classique à colonnes égales ? | Justification du rythme visuel, de la densité et de l'équilibre des zones de lecture. |
| **3. Navigation** | Quelle navigation répond exactement aux habitudes réelles de l'usager cible ? | Choix motivé : barre supérieure ultra-fine, menu latéral persistant, navigation par onglets bas mobile, ou storytelling linéaire. |
| **4. Typographie** | Quelle personnalité et quelle tonalité vocale la typographie véhicule-t-elle ? | Choix croisé d'une Display de caractère et d'une fonte de lecture avec échelle typographique calibrée. |
| **5. Logique des Couleurs** | Quelle justification fonctionnelle, culturelle et émotionnelle régit la palette ? | Rôle attribué à chaque teinte (fond, encre, accentuation d'action, statut de validation). |
| **6. Traitement Produits** | Comment les articles du catalogue sont-ils mis en scène différemment des standards ? | Forme géométrique des cartes, proportion visuel/texte, mise en avant du prix ou de la matière. |
| **7. Direction Photographique** | Quel traitement d'image, éclairage et cadrage correspondent à l'univers du produit ? | Choix de la lumière (naturelle, studio contrasté, flash brut), cadrages et textures d'arrière-plan. |
| **8. Interactions & Motion** | Quelles micro-interactions rendent l'usage gratifiant et reconnaissable ? | Comportement au survol, vitesse des transitions, retour haptique ou visuel lors de la confirmation. |
| **9. Expérience Mobile** | Quelle ergonomie spécifique a été conçue pour l'usage smartphone sur le terrain ? | Position des boutons d'action clés à portée de pouce (*thumb zone*), lisibilité sous soleil intense. |
| **10. Composants Décoratifs & Délimitation** | Quels composants sont propres au projet et lesquels respectent les standards ? | Choix des bordures, séparateurs, rayons d'arrondis et ombres exclusives au produit. |

---

## 4. Protocole d'Intégration dans le Cycle de Conception

1. **Phase d'Initialisation :** Renseignement des réponses du questionnaire projet.
2. **Phase Direction Artistique :** Sélection de l'un des 5 systèmes de design (`Swiss Editorial`, `Luxury Editorial`, `Afro-Contemporary`, `Organic Modern`, `Neo-Brutalism`).
3. **Phase Stitch / Prototypage :** Injection de la matrice de différenciation dans le prompt de génération pour interdire à l'IA les templates par défaut.
4. **Phase Design Review :** Contrôle systématique des points anti-généricité avant toute transmission au développement Antigravity / Codex.
