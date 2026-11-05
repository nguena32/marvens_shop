# MODULE_WEBSITE — Module Sites Web, Vitrines et Portails
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Sites web institutionnels, vitrines d'entreprises, pages de services et landing pages  
> **Statut :** Spécification de référence active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

<!-- MARVENS_PROJECT_CONTEXT:START -->
> [!IMPORTANT]
> **STATUT PROJET DE CE MODULE :** `NON_APPLICABLE`  
> **Projet :** MARVENS SHOP  
> **Évaluation :** ⚪ NON APPLICABLE (Consulter pour référence méthodologique)

---
<!-- MARVENS_PROJECT_CONTEXT:END -->



## 1. Objectifs et typologies couvertes

Le module Website régit la conception des interfaces publiques dont la mission première est d'établir la crédibilité d'une organisation, de présenter une offre avec limpidité et de convertir l'attention d'un visiteur en contact qualifié ou en acte d'achat.

### Typologies traitées
1. **Site Institutionnel / Corporate :** Présentation du Groupe, gouvernance, filiales, valeurs, actualités d'entreprise.
2. **Site Vitrine PME / Services :** Explication des métiers, expertises, références clients et formulaires de devis.
3. **Site Présentation Produit / SaaS Marketing :** Proposition de valeur d'un logiciel, démonstrations visuelles, grilles tarifaires et réassurance.
4. **Landing Page de Campagne :** Page unique ciblée sur un objectif de conversion exclusif (téléchargement, inscription webinaire, prise de contact commerciale).

---

## 2. Priorités fondamentales d'expérience utilisateur (UX)

* **Le test des 5 secondes :** Dès l'arrivée sur l'écran d'accueil, le visiteur doit comprendre sans équivoque : *qui parle*, *ce qui est proposé*, *à qui cela s'adresse* et *quelle est la prochaine étape*.
* **La crédibilité immédiate (Proof First) :** En Afrique centrale et sur les marchés émergents, la méfiance envers les sites web est forte. La réassurance doit être omniprésente : adresse physique réelle vérifiable, numéros de téléphone locaux (avec bouton d'appel direct WhatsApp), mentions légales et témoignages d'entreprises authentiques.
* **Le guidage vers l'action (Clear CTA) :** Une seule action primaire par écran visible (ex: « Demander une démo » ou « Nous contacter sur WhatsApp »), complétée par des actions secondaires plus douces (« Découvrir les tarifs »).

---

## 3. Architecture d'information et structure type d'un site vitrine

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    STRUCTURE ANATOMIQUE D'UNE PAGE D'ACCUEIL                │
│                                                                             │
│  [HEADER] ──► Logo produit/groupe, menu de navigation sobre, CTA d'action.  │
│      │                                                                      │
│  [HERO SECTION] ──► Titre percutant, sous-titre explicatif, CTA primaire   │
│      │              et visuel d'interface ou vidéo contextuelle courte.     │
│      │                                                                      │
│  [SOCIAL PROOF] ──► Logos de clients réels, chiffres clés ou accréditations.│
│      │                                                                      │
│  [BÉNÉFICES MÉTIER] ──► 3 piliers de valeur (problème usager ➔ solution).   │
│      │                                                                      │
│  [DÉMONSTRATION] ──► Captures réelles d'écrans commentées avec données nettes│
│      │                                                                      │
│  [TARIFS / OFFRES] ──► Tableaux transparents en monnaie locale (FCFA).      │
│      │                                                                      │
│  [FAQ RASSURANTE] ──► Réponses franches aux 5 objections majeures d'achat.  │
│      │                                                                      │
│  [CALL-TO-ACTION FINAL] ──► Rappel direct du bénéfice + formulaire ou MoMo.  │
│      │                                                                      │
│  [FOOTER] ──► Coordonnées complètes, Yaoundé/Douala, liens légaux, copyright.│
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Direction UI et composants clés

1. **Header & Navigation :**
   * Hauteur compacte (64px à 72px sur desktop, 56px sur mobile).
   * Navigation fixée (*sticky*) ou apparaissant au défilement vers le haut.
   * Menu burger sur mobile avec liens larges (hauteur de tap $\ge 48px$) et bouton WhatsApp proéminent.
2. **Hero Section :**
   * Pas de carrousels d'images automatiques (les bannières défilantes divisent par cinq le taux de clics et distraient l'usager).
   * Titre typographique fort (`font-size` 32px à 48px), contrasté à 100% sur son fond.
3. **Formulaire de contact :**
   * Règle de sobriété : **3 à 4 champs au maximum** (Nom, Téléphone WhatsApp, Nom de l'entreprise, Besoin). Chaque champ additionnel réduit le taux de conversion de 15%.
   * Validation en direct des champs sans rechargement de page.

---

## 5. Spécificités d'adaptation contextuelle (Cameroun & Francophonie)

* **Canal WhatsApp omniprésent :** L'intégration d'une pastille flottante WhatsApp discrète en bas à droite de l'écran est le levier de conversion numéro 1 pour les PME locales.
* **Sobriété du poids de page :** Poids total de la page d'accueil inférieur à **1.2 Mo** (tous assets compris). Les images doivent être au format WebP avec dimensions explicites pour éliminer tout sursaut de mise en page (*Cumulative Layout Shift* nul).
* **Bannissement des faux éléments :** Proscription absolue des faux avis clients, faux compteurs de stock sous pression (« Plus que 2 disponibles ! ») et faux logos de presse, qui détruisent la crédibilité auprès des décideurs B2B.

---

## 6. Livrables types de la phase de conception Website

1. **Arborescence globale (Sitemap) :** Plan des pages et flux de navigation hiérarchisé.
2. **Zoning & Wireframes :** Disposition des blocs fonctionnels écran par écran.
3. **Spécifications UI & Maquettes Responsive :** Écrans Desktop (1440px) et Mobile (375px).
4. **Matrice des formulaires et états d'envoi :** Spécification des écrans de succès et de reprise en cas d'échec réseau.
