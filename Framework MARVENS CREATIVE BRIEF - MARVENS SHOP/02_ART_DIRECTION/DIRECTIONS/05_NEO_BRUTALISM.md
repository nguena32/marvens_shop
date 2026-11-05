# DIRECTION 05 — NEO-BRUTALISM
## Bibliothèque de Systèmes de Design Marvens Creative Brief
### Positionnement : Audace, jeunesse, différenciation

> **Identifiant :** `DIR-05-NEO-BRUTALISM`  
> **Famille :** Néo-Brutalisme Digital Contemporain  
> **Usage idéal :** Marques de streetwear, créateurs indépendants, médias alternatifs, startups fintech décalées, outils pour créateurs ou commerces qui veulent une boutique visuellement forte, mémorisable, audacieuse et électrisante.

---

## 1. Fiche d'Identité & ADN Visuel

| Dimension | Spécification de la Direction |
|---|---|
| **ADN Visuel** | Intrépide, franc, brut, énergique, irrévérencieux mais hautement fonctionnel. Rejet délibéré du conformisme lisse et aseptisé du web corporate. Émotions transmises : excitation, liberté créative, authenticité sans filtre, modernité urbaine percutante. |
| **Positionnement** | La boutique qu'on n'oublie jamais. Un parti-pris graphique total et assumé qui séduit instantanément les générations connectées à la recherche de singularité et d'énergie visuelle. |
| **Plateforme idéale** | **Exploration & génération visuelle :** Google Stitch (prompts néo-brutalistes avec bordures noires épaisses, ombres décalées dures et contrastes saturés).<br>**Documentation système :** Marvens Creative Brief (`02_ART_DIRECTION/DIRECTIONS/05_NEO_BRUTALISM.md`).<br>**Implémentation UI :** Antigravity / Codex (PHP Vanilla, CSS moderne avec box-shadows rigides sans flou et bordures franches).<br>**Validation :** Design Review Marvens (vérification que l'audace ne nuit ni à l'ergonomie ni à l'accessibilité). |

---

## 2. Palette Chromatique

Contrastes tranchés et francs, mariant des aplats pop vifs à un socle noir et blanc intransigeant.

- **Fond principal (*Canvas*) :** `#FFFDF0` (Crème vintage) ou `#F4F4F0` (Béton clair texturé) ou `#FFFFFF` pur.
- **Encre & Bordures maîtresses :** `#000000` pur (Noir absolu, bordures de 2px à 3px partout).
- **Couleurs d'accent primaires (Pop saturé) :**
  - **Jaune Électrique / Fluorescent :** `#FFE600` ou `#FFD028` (Attention immédiate, énergie pure).
  - **Cyan Acide :** `#00F0FF` ou `#22D3EE` (Fraîcheur digitale).
  - **Rose Vif / Magenta :** `#FF2A85` ou `#F43F5E` (Audace, jeunesse).
  - **Vert Néon / Lime :** `#22C55E` ou `#10B981` (Validation, succès vif).
- **Ombrages (*Hard Shadows*) :** `#000000` (Ombre portée dure décalée de 4px à 6px en X et Y, flou 0px : `box-shadow: 4px 4px 0px #000;`).

---

## 3. Typographie

Typographies massives, compactes, industrielles ou rétro-grotesques qui occupent l'espace sans complexe.

- **Famille Titrage (*Display*) :** Polices lourdes et affirmées — `Cabinet Grotesk`, `Clash Display`, `Space Grotesk`, `Archivo Black` ou `Syne Extra Bold`.
- **Famille Courante & Technique :** `Space Mono` ou `JetBrains Mono` pour les prix et métadonnées, `Inter` ou `DM Sans` (bold) pour le corps de texte.
- **Hiérarchie :**
  - **H1 Titre héro :** 52px - 84px, weight 900, majuscules percutantes, tracking serré, parfois surligné d'un aplat jaune fluo.
  - **H2 Section :** 32px - 48px, weight 800, encadré dans un cartouche noir à bordure franche.
  - **Body text :** 15px - 16px, weight 500, line-height 1.45, très contrasté.
  - **Prix & Badges :** Monospace en cartouche vif, entouré d'une bordure noire de 2px.

---

## 4. Composition Spatiale & Géométrie

- **Bordures systématiques :** Tous les conteneurs (cartes, boutons, bannières, filtres) possèdent une bordure noire franche de 2px ou 3px (`border: 2.5px solid #000;`).
- **Ombres dures (*Hard Shadows*) :** Décalage franc à 45° sans aucun flou gaussien (`box-shadow: 5px 5px 0px #000000;`).
- **Asymétrie & Tilted Elements :** Légères rotations volontaires de certains stickers ou badges (-2° ou +3°) pour briser la monotonie.

---

## 5. Direction Photographique

- **Style :** Flash direct franc, esthétique argentique crue, contraste élevé, poses naturelles sans retouches excessives.
- **Mise en scène :** Produits détourés avec filet noir ou photographiés sur fond uni fluo ou décor urbain réel.
- **Autodérision & Énergie :** Rire, spontanéité, cadrages obliques ou contre-plongées.

---

## 6. Présentation des Produits

- **Cartes produit :** Boîtes géométriques à contour noir 2px et ombre dure 4px.
- **Stickers & Tags :** Gommettes colorées (ex. `DROP NOUVEAU`, `LIMITED`, `SOLDOUT`) collées sur les coins d'images.
- **Fiche technique :** Liste claire présentée façon ticket de caisse ou bordereau de livraison stylisé.

---

## 7. Navigation & Architecture d'Information

- **Bannière défilante (*Marquee*) :** Texte animé défilant en continu avec messages d'information ou punchlines de marque.
- **Menu percutant :** Gros liens de navigation séparés par des filets noirs gras.
- **Clarté totale :** Malgré son style rebelle, le parcours d'achat reste ultra-évident et fluide.

---

## 8. Composants d'Interface

- **Boutons néo-brutalistes :** Fond jaune fluo ou blanc, bordure 2.5px noire, ombre dure 4px. Lors du clic/survol : l'ombre s'écrase (`transform: translate(2px, 2px); box-shadow: 2px 2px 0px #000;`) pour une sensation tactile mécanique très gratifiante.
- **Inputs de formulaire :** Cadre noir 2px, fond blanc pur, focus avec contour épais ou fond jaune pâle.

---

## 9. Motion Design & Micro-Interactions

- **Animations :** Réactives, nerveuses, mécaniques (durée 80ms à 150ms).
- **Effet clic tactile :** Déplacement franc du composant lors de la pression (*tactile button press*).

---

## 10. Adaptation Responsive & Ergonomie

- Desktop : Pleine puissance des décalages d'ombres, stickers inclinés et titrages géants.
- Mobile : Maintien des bordures noires et ombres dures (réduites à 3px pour ne pas déborder), adaptation des titrages pour éviter les césures accidentelles inesthétiques.

---

## 11. Accessibilité (WCAG 2.1 AA+)

- Règle d'or : Les contrastes sont naturellement exceptionnels grâce à la dominance des bordures et textes en noir pur (#000000) sur fonds clairs ou fluorescents (ratios > 10:1).
- Clarté des cibles : Les boutons néo-brutalistes étant volumineux et très délimités, ils offrent une excellente affordance pour tous les utilisateurs.

---

## 12. À Éviter Absolument (*Anti-Patterns*)

- ❌ Flous d'ombres esthétiques transparents (shadow-blur > 0).
- ❌ Dégradés pastel timides ou fondus invisibles.
- ❌ Illisibilité par provocation gratuite (le texte doit toujours être facile à lire).
- ❌ Surcharge bordélique rendant le panier ou le paiement anxiogène.
- ❌ Imitation superficielle sans soigner la solidité du code HTML/CSS.

---

## 13. Prompt Prêt à l'Emploi pour Agent de Design / Stitch

```text
CONCEPTION SOUS LA DIRECTION 05 — NEO-BRUTALISM
Produit : [Nom de la marque streetwear / média / créateur audacieux]
Objectif : Créer une boutique en ligne néo-brutaliste électrisante, mémorisable et ultra-affirmée.
Directives strictes :
- Bordures noires épaisses (2.5px solid #000) sur tous les blocs, cartes, boutons et séparateurs.
- Ombres dures sans aucun flou (box-shadow: 4px 4px 0px #000) avec effet de clic mécanique qui s'enfonce.
- Fond crème vintage (#FFFDF0) ou blanc, rehaussé d'aplats saturés : jaune électrique (#FFE600), rose vif (#FF2A85), cyan (#00F0FF).
- Typographie percutante : Display extra-bold (Cabinet Grotesk / Clash Display / Syne) et monospace pour les prix et données techniques.
- Stickers géométriques, bandeaux de texte défilants (marquees), micro-interactions nerveuses et tactiles.
- Garantir une expérience d'achat fluide et sans bug : [Détails catalogue et produit].
```

---

## 14. Critères de Validation & Revue Qualité

- [ ] L'interface provoque-t-elle un impact visuel fort et mémorable immédiat ?
- [ ] Les bordures noires et les ombres dures sont-elles nettes et sans flou ?
- [ ] Le retour haptique/visuel sur les boutons donne-t-il une sensation tactile franche ?
- [ ] La hiérarchie reste-t-elle parfaitement compréhensible malgré l'audace formelle ?
- [ ] Tous les contrastes texte/fond sont-ils largement supérieurs aux normes WCAG AA ?
