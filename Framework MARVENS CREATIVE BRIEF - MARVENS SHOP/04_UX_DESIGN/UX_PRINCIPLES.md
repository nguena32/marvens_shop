# UX PRINCIPLES — Principes Fondamentaux de l'Expérience Utilisateur
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `04_UX_DESIGN/UX_PRINCIPLES.md`  
> **Statut :** Référence méthodologique active  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [FRAMEWORK_OVERVIEW.md](../00_FRAMEWORK_CORE/FRAMEWORK_OVERVIEW.md) · [DESIGN_PHILOSOPHY.md](../00_FRAMEWORK_CORE/DESIGN_PHILOSOPHY.md) · [CREATIVE_PROCESS.md](../00_FRAMEWORK_CORE/CREATIVE_PROCESS.md) · [GOVERNANCE.md](../00_FRAMEWORK_CORE/GOVERNANCE.md) · [ART_DIRECTION_GUIDELINES.md](../02_ART_DIRECTION/ART_DIRECTION_GUIDELINES.md)

---

## 1. Rôle et Périmètre de l'Expérience Utilisateur (UX)

### 1.1. Définition et Dimensions Fondamentales
Dans l'écosystème **MARVENS CREATIVE BRIEF V1.0**, l'Expérience Utilisateur (UX) n'est ni un simple agencement d'écrans ni une couche cosmétique. Elle englobe **l'ensemble des perceptions, émotions, interactions et réponses cognitives d'une personne confrontée à un produit numérique**, avant, pendant et après son utilisation.

L'expérience utilisateur s'articule autour de six dimensions interconnectées :
1. **L'Utilité (*Utility*) :** Le produit apporte-t-il une réponse concrète, pertinente et efficace à un problème réel de l'usager ?
2. **L'Utilisabilité (*Usability*) :** Les tâches s'accomplissent-elles avec fluidité, un minimum d'efforts et un taux d'erreur négligeable ?
3. **La Clarté et Découvrabilité (*Findability*) :** L'utilisateur comprend-il immédiatement l'état du système et repère-t-il sans friction les informations clés ?
4. **La Crédibilité et Confiance (*Credibility*) :** Le produit inspire-t-il la sécurité, le sérieux et la transparence, notamment lors d'opérations sensibles (paiements, données privées) ?
5. **L'Accessibilité et l'Inclusion (*Accessibility*) :** L'interface reste-t-elle utilisable quelles que soient les capacités physiques, sensorielles, cognitives ou les contraintes matérielles de l'usager ?
6. **La Désirabilité (*Desirability*) :** L'interaction suscite-t-elle un sentiment d'élégance, de sérénité et de maîtrise propre au standard *Premium Quality* de Marvens ?

### 1.2. Articulation UX, UI, Produit, Métier, Contenu et Technologie
La démarche UX opère comme le chef d'orchestre de la conception fonctionnelle :

```
                  ┌──────────────────────────────────────────┐
                  │              VISION PRODUIT              │
                  │   Objectifs business, proposition valeur │
                  └────────────────────┬─────────────────────┘
                                       │
                                       ▼
                  ┌──────────────────────────────────────────┐
                  │          CONTRAINTES MÉTIER & SI         │
                  │  Réglementation, flux d'échange, données │
                  └────────────────────┬─────────────────────┘
                                       │
                                       ▼
        ┌──────────────────────────────────────────────────────────────┐
        │            ARCHITECTURE DE L'EXPÉRIENCE (UX)                 │
        │    Besoins usagers, scénarios, organisation, comportements   │
        └──────────────┬───────────────────────────────┬───────────────┘
                       │                               │
                       ▼                               ▼
        ┌──────────────────────────────┐ ┌─────────────────────────────┐
        │   INTERFACE UTILISATEUR(UI)  │ │     STRATÉGIE DE CONTENU    │
        │   Tokens, grilles, contrastes│ │   Micro-copie, terminologie │
        └──────────────┬───────────────┘ └─────────────┬───────────────┘
                       │                               │
                       └───────────────┬───────────────┘
                                       ▼
                        ┌──────────────────────────────┐
                        │       SOCLE TECHNIQUE        │
                        │    Performance, APIs, réseau │
                        └──────────────────────────────┘
```

* **UX vs UI :** La UX conçoit la logique, l'organisation spatiale des concepts, les flux de décisions et la résilience aux erreurs. L'UI concrétise cette architecture sous forme visuelle, tactile et typographique. Une interface peut être visuellement séduisante mais ergonomiquement désastreuse si la logique UX est défaillante.
* **UX et Métier :** L'UX traduit des règles de gestion complexes en parcours simples, sans dénaturer la rigueur imposée par le secteur d'activité.
* **UX et Technologie :** L'UX anticipe les limites de l'infrastructure (latence réseau, déconnexions, puissance des terminaux) pour garantir une expérience ininterrompue.

---

## 2. Principes Directeurs de Conception UX

Les treize principes suivants constituent la doctrine obligatoire pour l'ensemble des créations numériques de Marvens Group :

### Principe 1 : L'utilisateur et ses objectifs avant l'interface
Concevoir systématiquement à partir de la tâche réelle que l'usager cherche à accomplir, et non à partir d'une liste arbitraire d'écrans prédéfinis. Réduire au strict minimum le nombre d'obstacles entre l'intention de l'usager et sa réalisation.

### Principe 2 : Le contexte avant les conventions
Les standards généraux du web doivent s'adapter au contexte opérationnel concret du produit : conditions lumineuses extrêmes, mobilité terrain, bruit ambiant, urgence, stress décisionnel ou spécificités culturelles locales.

### Principe 3 : La clarté absolue
Une interface doit éliminer toute ambiguïté. Chaque action, chaque label, chaque conséquence et chaque étape suivante doivent être immédiatement compréhensibles dès le premier regard.

### Principe 4 : La simplicité utile
La simplicité selon Marvens consiste à éliminer l'inutile pour révéler l'essentiel, et non à supprimer des fonctions nécessaires. Ne jamais masquer des fonctionnalités critiques sous prétexte de minimalisme esthétique.

### Principe 5 : La cohérence et la prévisibilité
Les mêmes causes doivent produire les mêmes effets dans l'ensemble du système. Les conventions de disposition, d'action et de rétroaction doivent rester stables d'un écran à l'autre pour accélérer l'apprentissage.

### Principe 6 : Le contrôle utilisateur et la réversibilité
L'usager doit toujours se sentir maître de l'interface. Toute action importante doit être confirmable, annulable ou modifiable. Les impasses et les processus irréversibles imposés sans avertissement sont bannis.

### Principe 7 : La prévention active des erreurs
La meilleure gestion des erreurs consiste à rendre leur survenue impossible par conception (guidage de saisie, masquage des choix contradictoires, désactivation contextuelle explicite). Lorsqu'une erreur survient, elle doit être expliquée sans culpabiliser l'utilisateur et assortie d'un chemin de résolution immédiat.

### Principe 8 : La visibilité de l'état du système (Feedback immédiat)
Le système ne doit jamais être silencieux. Chaque action (clic, soumission, traitement de fond) doit renvoyer un accusé de réception visuel ou textuel immédiat en moins de 150 millisecondes.

### Principe 9 : L'accessibilité universelle et l'inclusion
Concevoir dès le premier jour pour les personnes en situation de handicap temporaire, situationnel ou permanent. L'accessibilité n'est pas une option, c'est une exigence éthique et qualitative.

### Principe 10 : La transparence et la confiance
Dans les parcours impliquant des paiements, des données personnelles ou des autorisations techniques, le produit doit justifier clairement ses demandes. Aucun coût caché, aucun accord forcé, aucune zone d'ombre.

### Principe 11 : La performance perçue et la gestion des temps d'attente
Une expérience fluide dépend autant de la vitesse réelle que de la manière dont les temps d'attente sont communiqués. Éliminer les écrans de blocage opaques au profit de squelettes de chargement (*skeletons*) et de retours de progression explicites.

### Principe 12 : La continuité d'expérience et résilience aux coupures
L'interface doit tolérer les interruptions inopinées (appel téléphonique entrant, fermeture accidentelle d'onglet, passage sous un tunnel réseau) et préserver systématiquement les données saisies par l'usager.

### Principe 13 : La qualité Premium par la justesse
La qualité premium se mesure à la suppression radicale de toute friction inutile, à l'élégance du guidage et à la précision des micro-interactions.

---

## 3. Analyse et Compréhension Contextuelle des Utilisateurs

Il est formellement interdit à un agent IA ou à un designer d'inventer des profils utilisateurs fictifs déconnectés du brief validé dans `01_PRODUCT_DISCOVERY/`.

### 3.1. Prise en Compte des Contextes Réels et Marchés Spécifiques
Pour les produits conçus à destination de marchés émergents, notamment au Cameroun et en Afrique francophone, l'analyse UX doit impérativement questionner les dimensions suivantes sans verser dans les stéréotypes :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                 GRILLE D'ANALYSE DES CONTRAINTES DE CONTEXTE                │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Équipement & Écrans   │ • Domination écrasante du smartphone (Mobile-First)│
│                          │ • Hétérogénéité des gammes d'appareils et mémoires│
│                          │ • Résolutions d'écrans modestes et luminosité forte│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Réseau & Connectivité │ • Connectivité instable, coupures fréquentes      │
│                          │ • Coût élevé des données mobiles au mégaoctet    │
│                          │ • Nécessité d'optimiser le poids des requêtes     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Littératie Numérique  │ • Niveaux disparates de familiarité informatique │
│                          │ • Importance de la clarté lexicale et des icônes  │
│                          │ • Besoin accru de réassurance et d'assistance    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Usages Financiers     │ • Prédominance du Mobile Money (Orange, MTN, etc.) │
│                          │ • Méfiance légitime envers les paiements inconnus │
│                          │ • Exigence de reçus téléchargeables ou archivables│
└──────────────────────────┴──────────────────────────────────────────────────┘
```

> [!IMPORTANT]
> Ces facteurs constituent des **axes de vérification systématiques**, non des hypothèses universelles. Chaque projet doit confirmer par des faits documentés les contraintes réelles de sa cible.

---

## 4. Critères Mesurables de la Qualité UX

La qualité d'une expérience utilisateur s'évalue au moyen de neuf critères concrets :

| Critère d'évaluation | Indicateur mesurable | Seuil attendu Marvens |
| :--- | :--- | :--- |
| **1. Facilité d'apprentissage** | Temps requis pour accomplir une tâche la première fois | Aucun blocage nécessitant une aide externe |
| **2. Taux de complétion** | % d'usagers menant le parcours clé à son terme | > 90% sur le parcours nominal |
| **3. Taux d'erreur utilisateur** | Nombre d'erreurs de saisie ou de mauvaise orientation | < 5% des actions engagées |
| **4. Efficience opérationnelle** | Nombre de clics ou étapes pour parvenir au but | Parcours direct sans bifurcation inutile |
| **5. Clarté perçue** | Compréhension des libellés et des statuts | 100% des messages d'état explicites |
| **6. Reprise après incident** | Temps pour corriger une erreur ou reprendre après coupure | Rétablissement immédiat sans perte de données |
| **7. Accessibilité certifiée** | Respect des critères WCAG 2.2 niveau AA | Zéro non-conformité bloquante |
| **8. Robustesse réseau** | Comportement en cas de latence > 3 secondes | Retour visuel informatif dès 300ms |
| **9. Score de confiance** | Absence de dark patterns et transparence | Conforme à la charte éthique Marvens |

---

## 5. Arbitrages et Éthique de Conception

### 5.1. Concilier Besoins Usagers et Objectifs Métier
Lorsqu'une tension émerge entre la conversion commerciale à court terme et le confort de l'utilisateur, Marvens privilégie la **confiance pérenne sur le gain immédiat**. Une friction imposée pour piéger l'usager détruit irrémédiablement la valeur du produit.

### 5.2. Interdiction Formelle des Dark Patterns
Sont rigoureusement proscrits sur tous les produits Marvens :
* **Les cases pré-cochées par défaut :** Consentements ou options payantes activées à l'insu de l'usager.
* **Le labyrinthe de résiliation (*Roach Motel*) :** Rendre l'inscription instantanée mais la sortie ou résiliation complexe et punitive.
* **Le faux sentiment d'urgence :** Fausses alertes de compteurs de stock ou comptes à rebours truqués.
* **La culpabilisation lexicale (*Confirmshaming*) :** Rédiger le refus d'une option sous une formule humiliante (*« Non merci, je n'aime pas faire des économies »*).
* **Les coûts cachés :** Révéler des frais obligatoires uniquement à l'étape finale du paiement.

---

## 6. Checklist de Contrôle UX (Avant Soumission)

L'agent IA ou le designer doit soumettre sa conception à la validation de la grille suivante :

```markdown
### Grille de Revue de Conformité UX
- [ ] Le parcours répond à un besoin utilisateur confirmé et documenté.
- [ ] L'interface ne comporte aucun Dark Pattern ni mécanisme trompeur.
- [ ] Le temps d'attente système supérieur à 300ms est accompagné d'un feedback visuel.
- [ ] L'usager dispose d'une confirmation explicite avant toute action irréversible.
- [ ] En cas d'erreur, le système propose un moyen concret de résoudre le problème.
- [ ] Les données saisies dans les formulaires sont préservées en cas d'incident ou de retour arrière.
- [ ] Les contrastes typographiques et les zones de clic respectent les standards d'accessibilité.
- [ ] L'affichage et l'interaction sont pensés en priorité pour le terminal cible dominant.
- [ ] Aucun jargon technique interne n'est visible par l'utilisateur final.
- [ ] Les demandes de données ou permissions sensibles sont motivées et transparentes.
```
