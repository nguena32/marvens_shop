# DIRECTION 02 — LUXURY EDITORIAL
## Bibliothèque de Systèmes de Design Marvens Creative Brief
### Positionnement : Prestige, élégance, désirabilité

> **Identifiant :** `DIR-02-LUXURY-EDITORIAL`  
> **Famille :** Luxe Contemporain & Haute Élégance Éditoriale  
> **Usage idéal :** Marques premium, maisons de luxe, haute horlogerie, joaillerie, mode haut de gamme ou cosmétiques d'exception qui vendent par l'image, la qualité perçue et l'exclusivité.

---

## 1. Fiche d'Identité & ADN Visuel

| Dimension | Spécification de la Direction |
|---|---|
| **ADN Visuel** | Distingué, intemporel, voluptueux mais épuré, atmosphérique, souverain. Émotions transmises : privilège, désir, sérénité, rareté, pérennité. |
| **Positionnement** | L'expérience digitale d'une grande maison de prestige. L'espace blanc devient une matière noble, le temps de contemplation est valorisé, chaque produit est traité comme une œuvre. |
| **Plateforme idéale** | **Exploration & génération visuelle :** Google Stitch (prompts de mise en page haute couture, compositions asymétriques à grand blanc tournant).<br>**Documentation système :** Marvens Creative Brief (`02_ART_DIRECTION/DIRECTIONS/02_LUXURY_EDITORIAL.md`).<br>**Implémentation UI :** Antigravity / Codex (PHP Vanilla, CSS épuré, typographie web de haute qualité).<br>**Validation :** Design Review Marvens (contrôle de la finesse des séparateurs et de la respiration spatiale). |

---

## 2. Palette Chromatique

Harmonie feutrée, minérale et prestigieuse.

- **Fond principal (*Canvas*) :** `#FAF9F6` (Blanc albâtre / coquille d'œuf) ou fond noir profond `#0A0A0A` pour les collections nocturnes.
- **Surface secondaire :** `#F3EFEA` (Sable chaud ou lin pâle).
- **Texte primaire (*Text*) :** `#1A1817` (Ébène profond, doux pour le regard).
- **Texte secondaire / Sous-titres :** `#6B6661` (Taupe cendré).
- **Filets & Séparateurs :** `#E2DCD5` (Ligne de 0.5px à 1px ultra-fine).
- **Accents de prestige :** `#C5A880` (Or champagne patiné) ou `#8C7355` (Bronze satiné), utilisé avec une parcimonie extrême (icônes d'orfèvrerie, sceaux de marque).

---

## 3. Typographie

Contraste classique et poétique entre sérif littéraire et linéale discrète.

- **Famille Titrage (*Display*) :** Sérif d'élégance de haute volée — `Playfair Display`, `Cormorant Garamond`, `Bodoni Moda` ou `Ogg`.
- **Famille Courante (*Body*) :** Sans-serif humaniste raffinée et discrète — `Cinzel` (pour micro-titres), `EB Garamond` ou `Plus Jakarta Sans` en poids ultra-fin (300).
- **Hiérarchie :**
  - **H1 Titre héro :** 56px - 76px, weight 400 (regular) ou 300 (light), italique expressif sur certains mots clés, tracking normal à légèrement ouvert.
  - **H2 Collection :** 32px - 44px, weight 400 serif.
  - **Body text :** 15px - 17px, weight 300, line-height 1.7 (très aéré).
  - **Labels de collection / Prix :** 12px - 13px, sans-serif uppercase, letter-spacing `+0.12em` (très espacé).

---

## 4. Composition Spatiale & Rythme

- **Espace blanc (*White Space*) :** Généreux, immersif, sanctuarisé. Les sections respirent avec des paddings verticaux de 96px à 160px.
- **Grille & Asymétrie :** Compositions éditoriales en quinconce, alternance de pleines pages photographiques et d'encadrés de texte décentrés façon magazine d'art (*curated layout*).
- **Densité :** Volontairement basse pour conférer un sentiment d'abondance d'espace et de sérénité.

---

## 5. Direction Photographique

- **Style :** Haute couture, lumière naturelle ciselée, ombres douces et profondes, grain cinéma ou texture pellicule argentique subtile.
- **Cadrage :** Plans larges atmosphériques alternant avec des très gros plans macro révélant la texture de la matière (cuir, or, soie, céramique).
- **Mise en scène :** Produits mis en situation sur des matières brutes (pierre, lin, bois précieux) plutôt que sur un simple fond blanc détouré.

---

## 6. Présentation des Produits

- **Cartes produit :** Aucun cadre lourd, aucun contour criard. L'image occupe 85% de la surface de la carte.
- **Informations :** Nom du modèle en typographie fine, matières ou origine en sous-titre discret, prix affiché avec élégance et pudeur sans mention agressive de promotion.
- **Bouton d'action :** Lien texte souligné d'un filet fin ou bouton minimaliste à bordure or/noir (`border-radius: 0px`).

---

## 7. Navigation & Architecture d'Information

- **Structure :** En-tête centré épuré avec logo iconique, menus déroulants plein écran (*mega menu* immersif) avec mise en avant de récits de collections.
- **Parcours :** Récit de marque (*Storytelling*) omniprésent avant la transaction pure. Valorisation de l'histoire du créateur et du savoir-faire.

---

## 8. Composants d'Interface

- **Boutons :** Minimalistes, rectangulaires sans arrondis (`border-radius: 0px`), fond blanc texte noir ou fond noir texte blanc, état survol avec fondu très doux.
- **Formulaires & Sélecteurs :** Lignes simples de 1px sous les champs, sélecteurs de taille ou nuances sous forme de pastilles épurées.

---

## 9. Motion Design & Micro-Interactions

- **Animations :** Mouvement fluide, lent, majestueux (durées de 400ms à 700ms), avec courbes d'accélération sophistiquées (`cubic-bezier(0.25, 1, 0.5, 1)`).
- **Effets :** Fondu progressif au défilement (*gentle fade-in*), zoom très subtil (1.02x) sur les visuels produits au survol.

---

## 10. Adaptation Responsive

- **Desktop :** Richesse des mises en page asymétriques et grandes respirations.
- **Mobile :** Préservation de la hauteur des visuels produits en plein écran (*full-bleed cards*), menus épurés, boutons d'action raffinés et lisibles sans encombrer la composition.

---

## 11. Accessibilité (WCAG 2.1 AA+)

- Surveillance rigoureuse des contrastes des typographies fines : privilégier des tailles légèrement supérieures (16px+) pour compenser les poids fins (300).
- Contraste texte/fond $\ge$ 4.5:1 garanti sur les fonds ivoire ou ébène.

---

## 12. À Éviter Absolument (*Anti-Patterns*)

- ❌ Badges promotionnels rouges agressifs style "PROMO -50%".
- ❌ Boutons bombés avec ombres portées saturées ou reflets plastiques.
- ❌ Grilles compactes étouffantes avec 5 produits par ligne sur petit écran.
- ❌ Popups intrusives ou compteurs à rebours de fausse urgence.
- ❌ Polices d'écriture fantaisistes de mauvaise qualité.

---

## 13. Prompt Prêt à l'Emploi pour Agent de Design / Stitch

```text
CONCEPTION SOUS LA DIRECTION 02 — LUXURY EDITORIAL
Produit : [Nom de la marque et produit d'exception]
Objectif : Créer une boutique en ligne haut de gamme incarnant le prestige, la désirabilité et l'élégance éditoriale.
Directives strictes :
- Composition éditoriale asymétrique inspirée de la presse de mode de luxe, avec grand espace blanc tournant (#FAF9F6 ou #0A0A0A).
- Typographie contrastée associant une grande Display Sérif (Playfair Display / Cormorant) pour les titrages et une sans-serif fine et aérée pour les informations.
- Palette feutrée : albâtre (#FAF9F6), ébène (#1A1817), sable chaud (#F3EFEA) et accents or champagne discrets (#C5A880).
- Cartes produit sans bordure lourde (radius: 0px), visuels immersifs plein format valorisant les textures et finitions artisanales.
- Absence totale d'artifices promotionnels agressifs, boutons minimalistes haut de gamme, transitions lentes et soignées.
- Respecter scrupuleusement le positionnement exclusif : [Détails positionnement].
```

---

## 14. Critères de Validation & Revue Qualité

- [ ] L'espace blanc donne-t-il une sensation immédiate de prestige et de sérénité ?
- [ ] La typographie sérif est-elle équilibrée et impeccablement lisible ?
- [ ] Les produits sont-ils mis en scène avec une désirabilité maximale ?
- [ ] Tout élément criard ou promotionnel générique a-t-il été proscrit ?
- [ ] L'expérience mobile conserve-t-elle l'esprit haut de gamme sans tasser les contenus ?
