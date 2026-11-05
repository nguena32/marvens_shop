# VISUAL STYLE LIBRARY — Bibliothèque des Systèmes de Design
## MARVENS CREATIVE BRIEF V2.0 · BIBLIOTHÈQUE DE RÉFÉRENCE OFFICIELLE

> **Emplacement :** `02_ART_DIRECTION/VISUAL_STYLE_LIBRARY.md`  
> **Statut :** Bibliothèque active de systèmes de design  
> **Doctrine :** *Contextual Design · Anti-Generic AI · Distinctive Brand Architecture*  
> **Documents associés :** [ART_DIRECTION_GUIDELINES.md](ART_DIRECTION_GUIDELINES.md) · [DESIGN_DIFFERENTIATION_ENGINE.md](../00_FRAMEWORK_CORE/DESIGN_DIFFERENTIATION_ENGINE.md) · [STITCH_INTEGRATION_GUIDE.md](../07_STITCH_INTEGRATION/STITCH_INTEGRATION_GUIDE.md)

---

## 1. Objectif de la Bibliothèque de Systèmes de Design

La **Visual Style Library** fait évoluer le framework Marvens Creative Brief d'une simple collection de styles vers une **bibliothèque structurée de systèmes de design réutilisables, personnalisables et différenciés**.

> [!IMPORTANT]
> **Interdiction formelle du design générique par IA :**  
> Les agents IA et concepteurs ne doivent en aucun cas appliquer des recettes visuelles automatisées (dégradés violet/bleu sans justification, cartes grises génériques, ombres excessives). Chaque produit doit posséder une direction artistique justifiée par son marché, sa cible, son métier et sa promesse de valeur.

Cette bibliothèque intègre exactement les **5 directions artistiques de référence** du framework Marvens.

---

## 2. Sommaire des 5 Systèmes de Design de Référence

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 LES 5 DIRECTIONS ARTISTIQUES DE RÉFÉRENCE                   │
├───────┬───────────────────────────────┬─────────────────────────────────────┤
│ DIR 01│ Swiss Editorial Commerce      │ Professionnel, structuré, distinctif│
│ DIR 02│ Luxury Editorial              │ Prestige, élégance, désirabilité    │
│ DIR 03│ Afro-Contemporary             │ Culture, modernité, identité afrique│
│ DIR 04│ Organic Modern                │ Nature, authenticité, douceur       │
│ DIR 05│ Neo-Brutalism                 │ Audace, jeunesse, différenciation   │
└───────┴───────────────────────────────┴─────────────────────────────────────┘
```

---

## 3. Synthèse Comparative des 5 Systèmes

| Direction | Positionnement & Cible | Émotion dominante | Typographie clé | Palette dominante | Traitement Produits & Cartes | Plateforme recommandée |
|---|---|---|---|---|---|---|
| **01. Swiss Editorial Commerce** | Boutiques professionnelles, quincaillerie de précision, B2B technique, horlogerie industrielle | Rigueur, compétence, clarté absolue | Néo-Grotesque (`Inter`, `Helvetica`), chiffres tabulaires | Blanc minéral `#F8F9FA`, encre noire `#111827`, accent cobalt ou rouge | Cartes rectangulaires strictes (radius: 0-2px), filets 1px, fiches techniques | **Stitch** (mise en page grille) $\rightarrow$ **Antigravity** (CSS Grid/PHP) |
| **02. Luxury Editorial** | Marques premium, haute couture, joaillerie, cosmétiques d'exception | Prestige, désir, privilège, exclusivité | Display Sérif (`Playfair`, `Cormorant`) + linéale fine | Albâtre `#FAF9F6`, ébène `#1A1817`, sable chaud `#F3EFEA`, or champagne | Visuels immersifs plein format (85% carte), absence de cadre lourd, storytelling | **Stitch** (mise en scène haute couture) $\rightarrow$ **Antigravity** |
| **03. Afro-Contemporary** | Marques africaines, mode contemporaine, fintechs locales, galeries, épicerie panafricaine | Fierté culturelle, vitalité, modernité digne | Display géométrique (`Syne`, `Epilogue`) + `Plus Jakarta Sans` | Ocre brûlé `#C25E38`, indigo `#1E293B`, terre d'ombre `#1C1917`, or solaire | Cartes chaleureuses, traçabilité locale ("Fait à Dakar"), badges Mobile Money / WhatsApp | **Stitch** (motifs vectoriels & teintes pigmentaires) $\rightarrow$ **Antigravity** |
| **04. Organic Modern** | Produits naturels, cosmétiques bio, alimentation saine, herboristerie, artisanat durable | Sérénité, pureté, bienveillance, santé | Sérif organique (`Fraunces`, `Lora`) + linéale douce | Lin lavé `#F7F5F0`, vert sauge `#4A6B53`, vert olive, terracotta poudrée | Formes douces et galets (radius: 16-24px, boutons pilules), décomposition ingrédients | **Stitch** (ambiances végétales & douces) $\rightarrow$ **Antigravity** |
| **05. Neo-Brutalism** | Streetwear, créateurs indépendants, médias alternatifs, startups décalées | Audace, énergie pop, liberté, irrévérence | Display ultra-lourde (`Cabinet Grotesk`, `Archivo Black`) + Monospace | Crème vintage `#FFFDF0`, bordures noires 2.5px, jaune fluo `#FFE600`, rose `#FF2A85` | Boîtes géométriques à contours noirs nets et ombres dures 4px (box-shadow 4px 4px 0px #000) | **Stitch** (compositions graphiques tranchées) $\rightarrow$ **Antigravity** |

---

## 4. Accès aux Fiches Complètes des Directions

Chaque direction artistique fait l'objet d'une fiche complète et détaillée accessible dans le dossier dédié :

1. [Fiche détaillée Direction 01 — Swiss Editorial Commerce](DIRECTIONS/01_SWISS_EDITORIAL_COMMERCE.md)
2. [Fiche détaillée Direction 02 — Luxury Editorial](DIRECTIONS/02_LUXURY_EDITORIAL.md)
3. [Fiche détaillée Direction 03 — Afro-Contemporary](DIRECTIONS/03_AFRO_CONTEMPORARY.md)
4. [Fiche détaillée Direction 04 — Organic Modern](DIRECTIONS/04_ORGANIC_MODERN.md)
5. [Fiche détaillée Direction 05 — Neo-Brutalism](DIRECTIONS/05_NEO_BRUTALISM.md)

---

## 5. Règle d'Attribution & Workflow Plateforme

Pour chaque projet, l'équipe et les agents doivent suivre le cycle d'outillage suivant :

```
┌───────────────────────────────┐
│ 1. MARVENS CREATIVE BRIEF     │ ──> Stratégie, Brand DNA & Choix de Direction (01 à 05)
└──────────────┬────────────────┘
               │
               ▼
┌───────────────────────────────┐
│ 2. GOOGLE STITCH              │ ──> Exploration & génération visuelle des écrans clés
└──────────────┬────────────────┘
               │
               ▼
┌───────────────────────────────┐
│ 3. DESIGN REVIEW & VALIDATION │ ──> Contrôle anti-généricité, fidélité DA, accessibilité
└──────────────┬────────────────┘
               │
               ▼
┌───────────────────────────────┐
│ 4. ANTIGRAVITY / CODEX        │ ──> Développement fonctionnel (PHP Vanilla MVC, MySQL, Bootstrap 5)
└───────────────────────────────┘
```

> **Note importante sur les outils :**  
> Google Stitch est l'outil privilégié pour l'exploration et le prototypage visuel rapide à partir du brief. Cependant, le framework Marvens Creative Brief conserve la pleine gouvernance des décisions et peut s'interfacer avec tout autre outil de maquettage ou de génération (Figma, v0, etc.) sans modification de la doctrine.


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Directives artistiques et identité de marque
- **Personnalité visuelle :** DIR_01_SWISS_EDITORIAL
- **Préférences chromatiques et style :** [À DÉFINIR / À CONFIRMER]
- **Inspirations de design déclarées :** [À DÉFINIR / À CONFIRMER]
<!-- MARVENS_PROJECT_CONTEXT:END -->
