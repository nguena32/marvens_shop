# DESIGN SCORING — Système de notation et seuils de décision
## MARVENS CREATIVE BRIEF V1.0 · PHASE 10_QUALITY_ASSURANCE

> **Document :** Modèle de scoring pondéré, règles de blocage et rapport de conformité  
> **Statut :** Système de notation officiel actif  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## 1. Objectif et philosophie du Design Scoring

Le système de **Design Scoring** de Marvens Group a pour fonction de transformer des constats d'audits qualitatifs en un **indicateur synthétique, objectif et communicable**.

Il permet aux comités de pilotage, directeurs artistiques et Product Owners de prendre des décisions d'arbitrage éclairées sur des bases vérifiables et reproductibles.

> **Règle doctrinale fondamentale :**  
> Un score numérique élevé ne constitue jamais une garantie absolue de qualité. **Une seule anomalie critique (P0) bloque immédiatement le produit**, même si le score global atteint 95/100. La conformité est à la fois quantitative et qualitative.

---

## 2. Matrice des 5 dimensions évaluées et pondérations officielles

Le score global est calculé sur **100 points**, répartis entre les cinq dimensions piliers de la conception :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                      PONDÉRATION DU DESIGN SCORE GLOBAL                     │
├─────────────────────────────────────────┬───────────┬───────────────────────┤
│ DIMENSION ÉVALUÉE                       │ PONDÉRATION│ FINALITÉ DU CONTRÔLE  │
├─────────────────────────────────────────┼───────────┼───────────────────────┤
│ 1. Conformité au Brief & Valeur Produit │  20 pts   │ Adéquation métier     │
│ 2. Qualité Ergonomique & UX             │  25 pts   │ Fluidité des parcours │
│ 3. Adaptation Responsive & Tactile      │  20 pts   │ Continuité multi-écran│
│ 4. Accessibilité Numérique (WCAG AA)    │  20 pts   │ Contrastes & A11y     │
│ 5. Rigueur Design System & Finition UI  │  15 pts   │ Cohérence des tokens  │
├─────────────────────────────────────────┼───────────┼───────────────────────┤
│ TOTAL GLOBAL NORMALISÉ                  │  100 pts  │ Score d'excellence    │
└─────────────────────────────────────────┴───────────┴───────────────────────┘
```

---

## 3. Barème de notation et formule de calcul

Chaque dimension comprend 4 à 5 critères spécifiques notés de 0 à 10 :
* **10 / 10 :** Parfait, conforme en tout point avec preuves tangibles.
* **8 / 10 :** Conforme avec une imperfection mineure sans impact utilisateur.
* **5 / 10 :** Partiellement conforme, plusieurs défauts modérés (P2).
* **0 / 10 :** Défaillance majeure ou anomalie bloquante (P0/P1) sur la dimension.

### Formule de calcul :
$$\text{Score Global} = \sum (\text{Note Dimension sur 10} \times \text{Poids de la Dimension}) / 10$$

*Exemple :*
* Conformité Brief : 9/10 $\times$ 20 = 18 pts
* Qualité UX : 8.5/10 $\times$ 25 = 21.25 pts
* Responsive : 9/10 $\times$ 20 = 18 pts
* Accessibilité : 8/10 $\times$ 20 = 16 pts
* Design System : 9.5/10 $\times$ 15 = 14.25 pts  
**Score Final = 87.5 / 100**.

---

## 4. Règles de blocage impératif (Kill Switches)

Indépendamment du total obtenu, la validation du design est **automatiquement rejetée avec statut BLOQUÉ** si l'une des conditions suivantes est constatée :

1. **Présence d'au moins 1 anomalie P0 (Bloquante).**
2. **Échec complet du flux principal de vente / conversion** (ex: tunnel de paiement non testable ou impasses ergonomiques).
3. **Absence d'adaptation sur la résolution de référence Petit Mobile (375px)** avec présence de défilement horizontal parasite.
4. **Non-respect flagrant des ratios de contraste légaux** sur les textes d'actions critiques (< 3:1).
5. **Non-conformité majeure avec les impératifs du Product Brief** (omission de fonctionnalités de sécurité requises).

---

## 5. Niveaux de maturité et seuils d'arbitrage

Le score final classe la proposition dans l'une des cinq catégories d'acceptation :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       GRILLE D'INTERPRÉTATION DU SCORE                      │
├─────────────┬────────────────────────────────┬──────────────────────────────┤
│ SCORE       │ MENTION OFFICIELLE             │ DÉCISION DU COMITÉ DE REVUE  │
├─────────────┼────────────────────────────────┼──────────────────────────────┤
│ 90 à 100    │ Excellence Premium             │ VALIDÉ : Passage immédiat Dev│
│ 80 à 89     │ Conforme avec réserves         │ VALIDÉ : Sous réserve des P2 │
│ 70 à 79     │ Ajustements requis             │ AJOURNÉ : Révision obligatoire│
│ 50 à 69     │ Qualité insuffisante           │ REJETÉ : Refonte partielle   │
│ < 50        │ Non conforme                   │ REJETÉ : Recommencer le brief│
└─────────────┴────────────────────────────────┴──────────────────────────────┘
```

> **Seuil minimal Marvens :** Aucun produit ne peut être transféré aux équipes d'ingénierie logicielle s'il n'atteint pas le score minimal de **80 / 100** sans aucun blocage critique.

---

## 6. Modèle de rapport synthétique de scoring (Executive Report)

```markdown
### Rapport de Scoring Qualité Design — [Nom du Produit]
* **Date d'évaluation :** [AAAA-MM-JJ]
* **Évaluateur responsable :** [Nom du Lead Designer / IA]
* **Version auditée :** V1.0.0-Release Candidate

| Dimension évaluée | Note brute (sur 10) | Poids | Score pondéré | Statut |
| :--- | :---: | :---: | :---: | :---: |
| 1. Conformité au Brief & Valeur | 9.0 / 10 | 20% | 18.0 / 20 | Conforme |
| 2. Ergonomie & Qualité UX | 8.8 / 10 | 25% | 22.0 / 25 | Conforme |
| 3. Adaptation Responsive | 9.2 / 10 | 20% | 18.4 / 20 | Excellent |
| 4. Accessibilité WCAG AA | 8.5 / 10 | 20% | 17.0 / 20 | Conforme |
| 5. Design System & UI Tokens | 9.5 / 10 | 15% | 14.25 / 15| Excellent |
| **TOTAL GÉNÉRAL** | — | **100%** | **89.65 / 100** | **MENTION : CONFORME** |

#### Vérification des règles de blocage :
* Anomalies P0 (Bloquantes) : **0 détectée** `[PASS]`
* Débordement horizontal sur mobile : **0 détecté** `[PASS]`
* Tunnel de conversion testé : **100% fonctionnel** `[PASS]`

#### Décision finale soumise au responsable humain :
* [X] **RECOMMANDATION D'APPROBATION POUR LE DÉVELOPPEMENT**
* [ ] REJET / NOUVELLE PASSE DE CONCEPTION REQUISE

*Signature du responsable humain Marvens Group :* ___________________________
```
