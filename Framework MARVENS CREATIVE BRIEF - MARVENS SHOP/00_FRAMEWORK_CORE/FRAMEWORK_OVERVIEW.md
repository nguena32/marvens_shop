# FRAMEWORK OVERVIEW — Vision générale et architecture
## MARVENS CREATIVE BRIEF V2.0 · BIBLIOTHÈQUE DE SYSTÈMES DE DESIGN

> **Document :** Architecture opérationnelle et modèle de conception  
> **Statut :** Référence centrale active V2.0  
> **Conformité :** *Contextual Design · Premium Quality · Anti-Generic AI*  
> **Composants clés :** Bibliothèque des 5 Directions + Design Differentiation Engine + Google Stitch Integration

---

## 1. Raison d'être du framework

Les initiatives numériques souffrent fréquemment d'un écueil récurrent : la déconnexion entre la vision stratégique d'un produit et son incarnation visuelle et fonctionnelle. Trop souvent, les projets basculent directement d'une idée abstraite au code source ou à des gabarits préconçus, aboutissant à des produits interchangeables, inadaptés aux usagers et techniquement coûteux à corriger.

Le **MARVENS CREATIVE BRIEF V1.0** a été créé pour constituer le socle méthodologique unifié de Marvens Group. Il apporte une démarche rationnelle, exigeante et éprouvée pour piloter la direction artistique, l'expérience utilisateur et l'architecture des interfaces.

---

## 2. Pathologies et écueils de conception traités

Ce framework prévient et élimine méthodiquement six dysfonctionnements critiques :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       PATHOLOGIES DE CONCEPTION ÉVITÉES                     │
├────────────────────────────────┬────────────────────────────────────────────┤
│ 1. Les interfaces clonées      │ Éviter les gabarits "SaaS standard" ou     │
│    et génériques               │ templates préfabriqués sans âme.           │
├────────────────────────────────┼────────────────────────────────────────────┤
│ 2. L'arbitraire esthétique     │ Remplacer les goûts subjectifs isolés par  │
│    non justifié                │ des choix fondés sur le contexte réel.     │
├────────────────────────────────┼────────────────────────────────────────────┤
│ 3. La cécité usagers           │ Interdire la conception déconnectée du     │
│    et terrain                  │ profil, matériel et environnement ciblé.   │
├────────────────────────────────┼────────────────────────────────────────────┤
│ 4. La confusion Marque/Produit │ Distinguer l'image globale du Groupe de    │
│                                │ l'identité autonome requise par le produit.│
├────────────────────────────────┼────────────────────────────────────────────┤
│ 5. Le saut prématuré au dev    │ Empêcher le codage avant que les parcours, │
│                                │ états limites et UI soient clarifiés.      │
├────────────────────────────────┼────────────────────────────────────────────┤
│ 6. La boîte noire des IA       │ Canaliser la génération IA par un cadrage  │
│    (hallucination créative)    │ rigoureux et des revues de contrôle.       │
└────────────────────────────────┴────────────────────────────────────────────┘
```

---

## 3. Objectifs stratégiques et opérationnels

### Objectifs stratégiques
* **Renforcer la crédibilité perçue :** Transmettre immédiatement le sentiment de solidité, d'élégance et de sérieux propre à Marvens Group.
* **Accélérer le Time-to-Market de conception :** Réduire les allers-retours grâce à un processus de validation séquencé et explicite.
* **Garantir la longévité des solutions :** Concevoir des interfaces robustes qui ne se démodent pas au gré des effets de mode visuels passagers.

### Objectifs opérationnels
* Fournir aux designers et agents IA une grille de travail standardisée.
* Doter les développeurs d'artefacts d'ingénierie d'interface clairs (tokens de design, comportements d'état, règles de responsivité).
* Formaliser des critères mesurables d'acceptation du design.

---

## 4. Périmètre d'application : Ce qui relève du framework et ce qui en est exclu

### Inclus dans le périmètre
* **Direction Artistique Numérique :** Définition de l'univers visuel, choix typographiques, harmonies colorimétriques sémantiques, iconographie, imagerie et ton d'expression graphique.
* **Architecture de l'Expérience Utilisateur (UX) :** Cartographie des flux, hiérarchie de l'information, modélisation des parcours clés, gestion des frictions et micro-copies d'orientation.
* **Design d'Interface Utilisateur (UI) :** Conception des composants, grilles de mise en page, comportements responsifs (desktop, tablette, mobile), contrastes et conformité d'accessibilité (WCAG AA).
* **États et Comportements Systèmes :** Spécification formelle des états *Default*, *Hover*, *Active*, *Focus*, *Loading*, *Empty state*, *Partial data*, *Disabled* et *Error state*.
* **Validation de Conception :** Processus de recette visuelle et ergonomique préalable au développement.

### Exclu du périmètre direct (Hors-scope)
* **Architecture logicielle et choix de stack technique :** Le framework n'impose ni langage (PHP, Python, TypeScript, etc.), ni framework applicatif (React, Vue, Laravel), sauf lorsque des contraintes de performance ou de rendu influent directement sur l'interaction utilisateur.
* **Développement métier et code de production :** Le framework ne produit pas le code applicatif final.
* **Modèle commercial et tarification :** Les décisions de pricing et de politique commerciale n'en relèvent pas, hormis l'optimisation UX des tunnels de conversion et grilles tarifaires.

---

## 5. Principes structurants fondamentaux

Le framework repose sur l'équilibre de six principes :

1. **Un socle méthodologique universel :** Les mêmes étapes de réflexion, de questionnement et de validation s'appliquent à tous les projets Marvens.
2. **Une identité singulière par produit :** Chaque produit est une entité distincte qui possède son propre univers graphique et son registre émotionnel.
3. **L'ancrage contextuel absolu :** La solution retenue découle impérativement de l'environnement physique, sociologique et technologique de l'usager final.
4. **Le standard de qualité Premium :** L'exigence de clarté, de précision optique et de netteté ne fait l'objet d'aucun compromis, quel que soit le budget.
5. **La progression jalonnée par étapes :** Chaque étape produit un livrable exploitable conditionnant l'engagement de l'étape suivante.
6. **La souveraineté de l'arbitrage humain :** L'intelligence artificielle est un accélérateur et un conseiller d'excellence ; le responsable humain reste le garant stratégique et décisionnaire final.

---

## 6. Modèle opératoire en 3 niveaux

L'architecture opérationnelle de Marvens Group dissocie nettement le cadre universel, le contexte d'un produit donné et la commande passée à un agent IA :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ NIVEAU 1 : LE FRAMEWORK CENTRAL (`00_FRAMEWORK_CORE/`)                      │
│ Règles pérennes, philosophie, méthodologie de design, gouvernance et normes │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Cadre et alimente
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ NIVEAU 2 : LE BRIEF PROPRE AU PROJET (`01_PROJECT_BRIEFS/[NOM_PRODUIT]/`)   │
│ Contexte marché, personas, promesse de valeur, contraintes et identité      │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Pilote et spécifie
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ NIVEAU 3 : INSTRUCTIONS D'EXÉCUTION IA (Prompts & Mandats ciblés)           │
│ Tâches délimitées, livrables attendus, critères de sortie et limites        │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 7. Rôles et responsabilités générales

* **Pilote de Projet / Responsable Marvens :**
  * Rédige ou valide le brief initial du projet (Niveau 2).
  * Exprime les contraintes d'affaires et les objectifs stratégiques.
  * Tranche entre les propositions d'orientation artistique.
  * Valide officiellement les passages de jalons.
* **Agent IA (Designer / Concepteur) :**
  * Analyse le brief et met en évidence les ambiguïtés à lever.
  * Explore des pistes conceptuelles et esthétiques documentées.
  * Rédige les spécifications UX détaillées et les règles de mise en page.
  * Alerte sur les risques d'usabilité, de performance ou d'accessibilité.
  * Ne décrète jamais arbitrairement un livrable comme « validé définitivement ».
* **Designer Visuel / UI Humain :**
  * Donne corps aux concepts validés ou affine les maquettes proposées par l'IA.
  * Veille à l'harmonie fine, aux nuances émotionnelles et à la cohérence de marque.
* **Équipe de Développement :**
  * Reçoit les spécifications complètes.
  * Signale d'éventuelles contraintes techniques d'implémentation avant le gel du design.

---

## 8. Séquence logique de travail

La conception d'un produit s'effectue selon le flux logique suivant :

```text
[Framework Central] 
       │
       ▼
[Brief Spécifique Produit] 
       │
       ▼
[Analyse & Hypothèses IA] 
       │
       ▼
[Propositions de Conception (Pistes A/B)] 
       │
       ▼
[Validation Humaine Obligatoire (Jalon DA)] 
       │
       ▼
[Conception Détaillée (UX/UI & États)] 
       │
       ▼
[Validation Finale avant Développement]
```

> **Note de flexibilité :** Ce flux représente la rigueur du raisonnement. L'ampleur des livrables doit rester strictement proportionnée à l'envergure du projet. Un composant critique ou un écran pivot exigera une documentation exhaustive, là où un projet expérimental ou un formulaire annexe pourra adopter une formalisation allégée.

---

## 9. Livrables types attendus à l'échelle d'un projet

Selon la typologie et la complexité du produit, le processus génère :

1. **Dossier de Cadrage & Brief Produit :** Problème résolu, cibles, scénarios d'usage, contraintes environnementales.
2. **Note de Direction Artistique :** Parti pris créatif, palette sémantique, binômes typographiques, ratios d'espacement, ambiance iconographique.
3. **Cartographie UX & Flux Utilisateurs :** Arborescence fonctionnelle, diagrammes d'étapes, gestion des embranchements logiques.
4. **Système de Règles UI :** Tokens de design (couleurs, rayons, ombres, espacements), composants structurés et catalogue des états (vide, erreur, succès, chargement).
5. **Dossier de Spécifications pour l'Ingénierie :** Documentation claire des comportements interactifs, micro-copies et exigences d'accessibilité.

---

## 10. Critères généraux d'évaluation de la conformité

L'application du framework est considérée comme conforme et réussie lorsque :
* Chaque décision esthétique trouve sa justification dans une réalité du brief ou du public cible.
* Aucun parti pris visuel n'a été retenu uniquement sur la base de sa popularité temporaire.
* Les états de dégradation (connexion lente, champs incomplets, listes vides) sont entièrement traités.
* Le responsable humain a explicitement acté la direction artistique choisie.
* Les développeurs peuvent implémenter l'interface sans devoir interpréter les intentions ou boucher des manques fonctionnels.


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Synthèse de cadrage pour ce volet
- **Projet :** MARVENS SHOP
- **Modules :** MODULE_ECOMMERCE, MODULE_PWA
- **Terminaux prioritaires :** desktop, tablet, mobile
- **Contexte usagers :** 4G, ordinateur, mobile, tablette, Francais
- **Précisions complémentaires :** [À DÉFINIR / À CONFIRMER]
<!-- MARVENS_PROJECT_CONTEXT:END -->
