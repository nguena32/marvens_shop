# DIRECTION 01 — SWISS EDITORIAL COMMERCE
## Bibliothèque de Systèmes de Design Marvens Creative Brief
### Positionnement : Professionnel, structuré, distinctif

> **Identifiant :** `DIR-01-SWISS-EDITORIAL-COMMERCE`  
> **Famille :** Design Éditorial & Structuré / Commerce de Précision  
> **Usage idéal :** Boutiques et plateformes qui recherchent un positionnement sérieux, moderne, hautement professionnel et intemporel.

---

## 1. Fiche d'Identité & ADN Visuel

| Dimension | Spécification de la Direction |
|---|---|
| **ADN Visuel** | Rigueur helvétique, clarté cartésienne, typographie magistrale, autorité discrète, netteté millimétrique. Émotions transmises : confiance inébranlable, compétence, maîtrise, transparence. |
| **Positionnement** | La promesse d'une clarté absolue sans artifice. L'interface se retire au profit du produit, organisé avec la noblesse d'une publication de design suisse et l'efficacité d'un commerce de précision. |
| **Plateforme idéale** | **Exploration & génération visuelle :** Google Stitch (prompts typographiques et modulaires à grilles apparentes).<br>**Documentation système :** Marvens Creative Brief (`02_ART_DIRECTION/DIRECTIONS/01_SWISS_EDITORIAL_COMMERCE.md`).<br>**Implémentation UI :** Antigravity / Codex (PHP Vanilla, CSS Grid natif / Bootstrap 5 épuré).<br>**Validation :** Design Review Marvens (contrôle strict des alignements et ratios). |

---

## 2. Palette Chromatique

La couleur est purement sémantique et hiérarchique. Pas de dégradés gratuits.

- **Fond principal (*Canvas*) :** `#F8F9FA` (Blanc cassé minéral) ou `#FFFFFF` pur.
- **Encre / Texte primaire (*Ink*) :** `#111827` (Anthracite profond, presque noir).
- **Texte secondaire & Légendes :** `#4B5563` (Gris neutre 600, ratio contraste $\ge$ 5.8:1).
- **Bordures & Séparateurs (*Grid lines*) :** `#E5E7EB` (Filet 1px net et franc).
- **Couleur d'accent fonctionnel unique (*Accent*) :** `#0F172A` (Noir profond) ou un accent unique de signalisation au choix du produit (ex. `#D9381E` Rouge Suisse ou `#0047AB` Bleu Cobalt pour l'appel à l'action clé).
- **Surface d'emphase :** `#F3F4F6` (Gris structurel pour les blocs de métadonnées).

---

## 3. Typographie

La typographie est l'élément d'architecture numéro un de cette direction.

- **Famille Titrage (*Display*) :** Néo-Grotesque suisse rigoureuse — `Inter`, `Helvetica Now`, `Neue Haas Grotesk` ou `Plus Jakarta Sans`.
- **Famille Courante (*Body*) :** `Inter` ou `System UI` sans empattement, hautement lisible.
- **Famille Données & Prix (*Data*) :** Monospace technique ou chiffres tabulaires alignés (`font-variant-numeric: tabular-nums;`).
- **Hiérarchie :**
  - **H1 Titre héro :** 48px - 64px, weight 700, line-height 1.05, tracking `-0.03em`.
  - **H2 Section :** 28px - 36px, weight 600, line-height 1.15, tracking `-0.02em`.
  - **H3 Carte / Sous-titre :** 18px - 22px, weight 600, line-height 1.25.
  - **Body text :** 15px - 16px, weight 400, line-height 1.5, couleur `#374151`.
  - **Captions / Micro-labels :** 11px - 12px, weight 600, uppercase, letter-spacing `+0.06em`.

---

## 4. Composition Spatiale & Grille

- **Grille :** Modulaire 12 colonnes, alignements rigides au pixel près, gutters marqués (24px - 32px).
- **Lignes de construction :** Filets séparateurs de 1px continus délimitant les zones d'information (*grid boundaries visibles*).
- **Densité :** Équilibrée à dense. L'espace blanc est actif et ordonné, non vide.
- **Asymétrie :** Contrôlée — alternance entre colonnes larges pour le visuel produit et colonnes fines pour les caractéristiques techniques.

---

## 5. Direction Photographique

- **Style :** Épuré, net, fond neutre (gris clair, blanc studio ou ombre portée franche et courte).
- **Cadrage :** Centré ou aligné sur la grille, produit photographié de face ou à angle droit parfait.
- **Lumière :** Directe, diffuse, sans halo décoratif ni flou artistique excessif.
- **Cohérence :** Même ratio d'image (1:1 ou 4:5) sur l'ensemble du catalogue.

---

## 6. Présentation des Produits

- **Cartes produit :** Rectangulaires strictes (`border-radius: 0px` ou `2px`), délimitées par un filet subtil `#E5E7EB`.
- **Informations visibles :** Référence catalogue / code SKU en micro-label, nom du produit en typographie affirmée, spécifications essentielles sous forme de liste technique, prix avec alignement tabulaire.
- **Bouton d'action :** Direct, sobre, bouton rectangulaire plein ou contour franc.

---

## 7. Navigation & Architecture d'Information

- **Structure :** Barre de navigation horizontale compacte, fixée ou statique, séparée par une ligne de 1px.
- **Organisation :** Catégorisation rationnelle et alphabétique ou thématique claire, fil d'Ariane (*breadcrumb*) systématique.
- **Recherche & Filtres :** Filtres à facettes présentés sous forme de volet latéral rigoureux ou de barre d'options tabulées.

---

## 8. Composants d'Interface

- **Boutons :** Rectangles nets (`border-radius: 0px` ou `2px`), fond sombre texte blanc ou fond transparent bordure 1.5px. État survol : inversion franche sans zoom élastique.
- **Champs de formulaire :** Bordure inférieure ou contour 1px franc, étiquettes permanentes en petit corps au-dessus du champ.
- **Badges :** Neutres, monochromes, textes en majuscules techniques (ex. `EN STOCK`, `SÉLECTION`).

---

## 9. Motion Design & Micro-Interactions

- **Animations :** Zéro élasticité (*no spring physics*). Courbes d'accélération linéaires ou cubiques sobres (`cubic-bezier(0.16, 1, 0.3, 1)`).
- **Durée :** Très rapide (120ms à 180ms maximum).
- **Transitions :** Apparitions franches, fondus légers (opacity fade).

---

## 10. Adaptation Responsive

- **Desktop (1200px+) :** Grille multi-colonnes aérée avec métadonnées en marge.
- **Tablette (768px - 1024px) :** Reconfiguration en grille 2 ou 3 colonnes rigoureuses.
- **Mobile (375px - 430px) :** Monocolonne stricte, bordures horizontales séparatrices continues, hauteur de touch target minimale de 44px.

---

## 11. Accessibilité (WCAG 2.1 AA+)

- Ratio de contraste texte/fond minimum de 7:1 pour le texte principal et 4.5:1 pour le texte secondaire.
- Indicateurs de focus clavier : contour double net de 2px à fort contraste.
- Aucune information véhiculée exclusivement par la couleur.

---

## 12. À Éviter Absolument (*Anti-Patterns*)

- ❌ Cartes à coins très arrondis (`rounded-3xl` / `border-radius: 20px+`).
- ❌ Ombres portées volumineuses et floues (*diffuse drop shadows*).
- ❌ Dégradés multicolores (violet/bleu fluo).
- ❌ Icônes 3D ou illustrations décoratives non informatives.
- ❌ Surcharge de badges colorés style bonbon.

---

## 13. Prompt Prêt à l'Emploi pour Agent de Design / Stitch

```text
CONCEPTION SOUS LA DIRECTION 01 — SWISS EDITORIAL COMMERCE
Produit : [Nom du produit et catalogue]
Objectif : Créer une interface e-commerce éditoriale, ultra-structurée et rigoureuse inspirée du design graphique suisse.
Directives strictes :
- Grille modulaire 12 colonnes visiblement rythmée par de fins séparateurs de 1px (#E5E7EB).
- Typographie néo-grotesque (Inter / Helvetica style), hiérarchie tranchée, tracking resserré sur les titres, micro-labels techniques en majuscules.
- Fond blanc cassé (#F8F9FA) et encre noire/anthracite (#111827). Accent noir ou rouge suisse ponctuel pour l'action majeure.
- Cartes produits rectangulaires précises (radius: 0-2px), prix en chiffres tabulaires, fiches techniques claires.
- Zéro dégradé décoratif, zéro ombre portée floue, zéro composant arrondi générique.
- Respecter scrupuleusement le métier du produit : [Détails métier].
```

---

## 14. Critères de Validation & Revue Qualité

- [ ] La hiérarchie typographique est-elle le moteur principal de la page ?
- [ ] Les grilles et alignements sont-ils strictement respectés ?
- [ ] Les coins arrondis excessifs et ombres diffuses ont-ils été éliminés ?
- [ ] Les ratios de contraste sont-ils tous supérieurs ou égaux à 4.5:1 ?
- [ ] La présentation des produits reflète-t-elle le sérieux et le professionnalisme de la marque ?
