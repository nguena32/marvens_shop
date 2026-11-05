# TYPOGRAPHY SYSTEM — Système typographique
## MARVENS CREATIVE BRIEF V1.0 · PHASE 03_BRAND_AND_VISUAL_IDENTITY

> **Document :** Spécification doctrinale, hiérarchie et ingénierie typographique  
> **Statut :** Référence méthodologique et opérationnelle active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## Sommaire
1. [Rôle de la typographie et vision doctrinale](#1-rôle-de-la-typographie-et-vision-doctrinale)
2. [Articulation des 3 niveaux du framework](#2-articulation-des-3-niveaux-du-framework)
3. [Critères de sélection des fontes pour le contexte Marvens](#3-critères-de-sélection-des-fontes-pour-le-contexte-marvens)
4. [Familles fonctionnelles et binômes typographiques](#4-familles-fonctionnelles-et-binômes-typographiques)
5. [Échelle modulaire et proportions harmoniques (Type Scale)](#5-échelle-modulaire-et-proportions-harmoniques-type-scale)
6. [Règles de composition et rythme vertical](#6-règles-de-composition-et-rythme-vertical)
7. [Typographie responsive et fluidité multi-écrans](#7-typographie-responsive-et-fluidité-multi-écrans)
8. [Accessibilité, lisibilité et rendu optique](#8-accessibilité-lisibilité-et-rendu-optique)
9. [Performance web, licences et sous-ensembles linguistiques](#9-performance-web-licences-et-sous-ensembles-linguistiques)
10. [Nomenclature des tokens typographiques](#10-nomenclature-des-tokens-typographiques)
11. [Gabarit de spécification pour un produit](#11-gabarit-de-spécification-pour-un-produit)
12. [Erreurs typographiques et anti-patterns](#12-erreurs-typographiques-et-anti-patterns)
13. [Checklist de validation typographique](#13-checklist-de-validation-typographique)

---

## 1. Rôle de la typographie et vision doctrinale

Dans le référentiel **MARVENS CREATIVE BRIEF V1.0**, la typographie n'est pas un simple habit de présentation du texte : elle est l'armature structurelle de l'expérience utilisateur et l'expression la plus pure de la **Premium Quality**.

Une typographie maîtrisée structure la pensée de l'usager, réduit sa fatigue cognitive et communique instantanément le niveau de sérieux et de rigueur du produit. À l'inverse, une typographie approximative (tailles arbitraires, interlignages étouffants, contrastes flous) ruine immédiatement la crédibilité d'un logiciel professionnel.

---

## 2. Articulation des 3 niveaux du framework

* **Niveau A — Principes permanents du Framework :**  
  Toute typographie doit garantir une lisibilité absolue sur écrans modestes (taille de corps minimale de 16px sur desktop et 14px sur mobile). L'échelle doit découler d'un ratio modulaire géométrique prouvé.
* **Niveau B — Méthode de décision :**  
  Sélection méthodique par l'agent IA : étude du profil usager $\rightarrow$ vérification de la couverture diacritique française/internationale $\rightarrow$ audit de licence commerciale gratuite/libre $\rightarrow$ calibration du rythme vertical $\rightarrow$ recommandation de binôme argumenté.
* **Niveau C — Paramètres propres au produit :**  
  Les polices précises (ex: Inter, Plus Jakarta Sans, Outfit, DM Sans) sont arrêtées produit par produit selon le brief spécifique validé.

---

## 3. Critères de sélection des fontes pour le contexte Marvens

Toute police candidate à l'intégration dans un produit Marvens doit satisfaire à sept critères éliminatoires :

1. **Complétude linguistique et diacritique :** Prise en charge intégrale des caractères accentués français (é, è, ê, à, ç, œ, etc.) et des devises (symbole FCFA / XAF, €, $).
2. **Excellence optique en petite taille (Hinting & X-Height) :** Hauteur d'x (*x-height*) généreuse et ouvertures franches permettant une lecture limpide en 12px et 14px sur des dalles d'écran à faible densité de pixels.
3. **Disponibilité des graisses nécessaires :** Minimum 4 graisses distinctes disponibles (*Regular 400*, *Medium 500*, *SemiBold 600*, *Bold 700*).
4. **Licence d'exploitation pérenne et ouverte :** Priorité aux licences libres d'utilisation commerciale sans redevance (Google Fonts, SIL Open Font License 1.1).
5. **Poids et performance de chargement :** Fichiers légers au format WOFF2 moderne ; possibilité de sous-ensembles (*subsetting*) pour ne pas alourdir la bande passante mobile.
6. **Différenciation et personnalité :** Éviter les polices système banales tout en fuyant les fantaisies typographiques illisibles dans un logiciel de travail.

---

## 4. Familles fonctionnelles et binômes typographiques

Le framework préconise l'utilisation de deux familles complémentaires au maximum par produit :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    ARCHITECTURE DES FAMILLES TYPOGRAPHIQUES                 │
│                                                                             │
│   ┌───────────────────────────────┐     ┌───────────────────────────────┐   │
│   │     POLICE DE TITRAGE         │     │        POLICE DE CORPS        │   │
│   │     (Heading / Display)       │     │         (Body & UI)           │   │
│   ├───────────────────────────────┤     ├───────────────────────────────┤   │
│   │ • Rôle : Autorité, caractère, │     │ • Rôle : Lisibilité maximale, │   │
│   │   affirmation de marque.      │     │   neutralité, confort d'usage.│   │
│   │ • Usages : H1, H2, bannières, │     │ • Usages : Textes, champs,    │   │
│   │   chiffres clés du dashboard. │     │   tableaux, boutons, tooltips.│   │
│   │ • Exemples : Plus Jakarta Sans│     │ • Exemples : Inter, Roboto,   │   │
│   │   Outfit, Cabinet Grotesk.    │     │   DM Sans.                    │   │
│   └───────────────────────────────┘     └───────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
```

> **Option Monospace :** Une troisième police à chasse fixe (ex: JetBrains Mono ou Roboto Mono) peut être adjointe uniquement pour les interfaces techniques, les identifiants de transactions de caisse ou les numéros de comptes bancaires/téléphones.

---

## 5. Échelle modulaire et proportions harmoniques (Type Scale)

Le système de taille de texte repose sur un ratio harmonique de **1.25 (Major Third)**, offrant une hiérarchie nette et perceptible sans écarts disproportionnés :

| Niveau Sémantique | Taille (rem / px) | Hauteur de ligne (Line-Height) | Graisse (Weight) | Usage type |
| :--- | :--- | :--- | :--- | :--- |
| `display` | 2.441rem / ~39px | 1.15 (115%) | Bold 700 | Titres d'impact, chiffres clés de KPI. |
| `h1` | 1.953rem / ~31px | 1.20 (120%) | Bold 700 / SemiBold 600| Titre principal de page ou d'écran. |
| `h2` | 1.563rem / ~25px | 1.25 (125%) | SemiBold 600 | Titres de grandes sections de contenu. |
| `h3` | 1.250rem / ~20px | 1.30 (130%) | SemiBold 600 | En-têtes de cartes, sous-sections. |
| `h4` / `lead`| 1.125rem / ~18px | 1.40 (140%) | Medium 500 / Regular 400 | Paragraphes d'introduction, sous-titres. |
| `body-base` | **1.000rem / 16px** | **1.50 (150%)** | **Regular 400** | **Texte courant de lecture, paragraphes.** |
| `ui-button` | 0.938rem / ~15px | 1.00 (Centré) | Medium 500 / SemiBold 600| Libellés de boutons, onglets. |
| `caption` | 0.813rem / ~13px | 1.40 (140%) | Regular 400 / Medium 500 | Métadonnées, légendes, dates. |
| `micro` | 0.688rem / ~11px | 1.30 (130%) | Medium 500 | Badges compacts, pastilles d'état. |

---

## 6. Règles de composition et rythme vertical

1. **Longueur de ligne optimale (Measure) :**  
   Pour un confort de lecture soutenu, la largeur d'un bloc de texte courant doit être comprise entre **45 et 75 caractères** par ligne (espaces compris). Au-delà, l'œil de l'usager peine à retrouver la ligne suivante ; en-deçà, le rythme de lecture est haché.
2. **Alignement rigoureux à gauche :**  
   Tout texte de plus de deux lignes doit être aligné à gauche (*left-aligned*). Le texte justifié est strictement proscrit sur les interfaces web (création de « rivières » blanches inesthétiques et néfastes à la lisibilité). Le texte centré est réservé aux courts titres ou en-têtes de cartes d'accueil.
3. **Hiérarchie par la couleur et l'espacement :**  
   La distinction hiérarchique s'opère par le couple *taille + graisse*, mais aussi par la nuance de gris du texte (ex: Titres en `#0F172A`, corps en `#334155`, légendes en `#64748B`).

---

## 7. Typographie responsive et fluidité multi-écrans

Sur smartphone (largeur < 768px), les grands titres doivent être réduits pour éviter les coupures disgracieuses de mots :
* Le niveau `display` passe de 39px à 28px.
* Le niveau `h1` passe de 31px à 24px.
* Le niveau `body-base` reste strictement maintenu à **16px** (ou 15px minimum) pour prévenir le zoom automatique intempestif des navigateurs mobiles lors de la saisie dans un champ de formulaire.

---

## 8. Performance web, licences et sous-ensembles linguistiques

Pour respecter la contrainte de sobriété réseau sur les marchés africains :
* **Format WOFF2 exclusif :** Utiliser exclusivement le format compressé WOFF2 pour les polices web.
* **Sous-ensemble latin restreint (Subsetting) :** Ne charger que les glyphes de la langue d'usage (Latin-Basic + Latin-Extended pour les accents français), éliminant les caractères cyrilliques ou asiatiques inutiles (réduction de 80 % du poids du fichier de police).
* **Propriété `font-display: swap` :** Obligatoire pour garantir l'affichage immédiat du texte avec une police système de secours pendant le chargement réseau, sans effet de texte invisible (*FOIT*).

---

## 9. Nomenclature des tokens typographiques

```css
/* Tokens de Taille */
--font-size-display: 2.441rem;
--font-size-h1:      1.953rem;
--font-size-h2:      1.563rem;
--font-size-h3:      1.250rem;
--font-size-body:    1.000rem;
--font-size-caption: 0.813rem;

/* Tokens de Graisse */
--font-weight-regular:  400;
--font-weight-medium:   500;
--font-weight-semibold: 600;
--font-weight-bold:     700;

/* Tokens de Hauteur de Ligne */
--line-height-tight:  1.2;
--line-height-normal: 1.5;
--line-height-loose:  1.75;
```

---

## 10. Gabarit de spécification pour un produit

```markdown
### Système Typographique Officiel — [Nom du Produit]
* **Police d'Affichage / Titres :** [Nom de la police] | Licence : [OFL / Commerciale]
* **Police de Corps & UI :** [Nom de la police] | Licence : [OFL / Commerciale]
* **Graisses chargées en production :** 400, 500, 600, 700 (WOFF2 uniquement)
* **Échelle validée :** [Ratio 1.25 / Paliers rem]
* **Vérification diacritiques français :** [Confirmé le AAAA-MM-JJ]
* **Statut :** [ ] Proposition IA  [ ] Validé par le Responsable Humain
```

---

## 11. Erreurs typographiques et anti-patterns

1. **Le syndrome du patchwork :** Utiliser plus de deux polices de caractères sur un même produit, créant un sentiment d'amateurisme.
2. **Le micro-texte illisible :** Utiliser des tailles inférieures à 12px pour des informations essentielles (conditions, prix de base, messages d'erreur).
3. **L'interlignage étouffant :** Associer un grand titre à un interlignage par défaut trop large ou un texte long à un interlignage inférieur à 1.4.
4. **La surcharge de graisses grasses :** Mettre l'intégralité d'un écran en gras (*Bold*), détruisant tout contraste de lecture.

---

## 12. Checklist de validation typographique

- [ ] Les deux polices retenues possèdent une licence libre commerciale vérifiée (ex: Google Fonts OFL).
- [ ] Tous les caractères accentués français et symboles monétaires s'affichent correctement sans substitution.
- [ ] La taille minimale de corps de texte est de 16px (15px sur petit mobile).
- [ ] Les hauteurs de ligne et longueurs de ligne respectent les ratios recommandés.
- [ ] Les tokens typographiques sont intégrés dans les styles CSS du projet.
- [ ] Le responsable humain a approuvé formellement le parti pris typographique.
