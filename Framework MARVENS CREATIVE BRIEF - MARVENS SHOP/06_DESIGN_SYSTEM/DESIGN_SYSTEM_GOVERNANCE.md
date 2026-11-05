# DESIGN SYSTEM GOVERNANCE — Gouvernance et Cycle de Vie
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `06_DESIGN_SYSTEM/DESIGN_SYSTEM_GOVERNANCE.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Référence méthodologique active `[PROPOSITION NORMATIVE DU FRAMEWORK]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [GOVERNANCE.md](../00_FRAMEWORK_CORE/GOVERNANCE.md) · [CREATIVE_PROCESS.md](../00_FRAMEWORK_CORE/CREATIVE_PROCESS.md) · [DESIGN_TOKENS.md](DESIGN_TOKENS.md)

---

## 1. Mission et Périmètre de la Gouvernance

Le Design System de Marvens Group est un **bien commun vivant**. Sans gouvernance explicite, tout système de design tend naturellement vers l'entropie : prolifération de composants redondants, création sauvage de classes CSS isolées, dérive des contrastes et fragmentation de l'expérience utilisateur.

La gouvernance a pour mission de :
* Préserver l'intégrité, la cohérence et l'excellence de finition (*Premium Quality*) du système dans le temps.
* Définir les règles claires de contribution, d'évolution, de versionnement et de dépréciation.
* Encadrer la collaboration entre les concepteurs humains, les développeurs et les agents d'intelligence artificielle.

---

## 2. Rôles, Responsabilités et Autorité Décisionnelle

La gouvernance repose sur une séparation nette entre l'analyse, la proposition et le pouvoir de décision finale, conformément à [GOVERNANCE.md](../00_FRAMEWORK_CORE/GOVERNANCE.md) :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       MATRICE DES RESPONSABILITÉS (RACI)                    │
├──────────────────────────┬──────────┬──────────┬──────────┬─────────────────┤
│ Activité / Décision      │ Agent IA │ Designer │ Dev Lead │ Décisionnaire H.│
├──────────────────────────┼──────────┼──────────┼──────────┼─────────────────┤
│ Proposition nouveau token│    R     │    R     │    C     │        A        │
│ Spécification composant  │    R     │    R     │    C     │        A        │
│ Revue technique CSS      │    C     │    I     │    R     │        A        │
│ Audit d'accessibilité    │    R     │    C     │    C     │        A        │
│ Validation formelle v1.x │    I     │    C     │    C     │      A (Seul)   │
│ Dépréciation d'un token  │    C     │    R     │    R     │        A        │
└──────────────────────────┴──────────┴──────────┴──────────┴─────────────────┘
* R = Réalise / Propose | A = Approuve (Décideur final) | C = Consulté | I = Informé
```

> [!IMPORTANT]
> **Souveraineté Humaine :** Les agents IA analysent, recommandent, rédigent et testent les spécifications. **Aucune modification structurante du Design System ne peut être publiée ou déclarée validée sans l'accord formel du responsable humain.**

---

## 3. Cycle de Vie d'une Évolution du Design System

Toute création de composant, modification de token ou ajustement architectural suit un cycle en six étapes rigoureusement jalonnées :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     LE CYCLE EN 6 ÉTAPES D'UNE ÉVOLUTION                    │
└─────────────────────────────────────────────────────────────────────────────┘
                                       │
                                       ▼
                     [ 1. PROPOSITION & BESOIN MÉTIER ]
                     Formulation du cas d'usage (min 3 écrans)
                                       │
                                       ▼
                     [ 2. ANALYSE D'IMPACT & RECOMMANDATION ]
                     Examen d'antériorité (peut-on composer ?)
                                       │
                                       ▼
                     [ 3. SPÉCIFICATION DESIGN & ACCESSIBILITÉ ]
                     Anatomie, tokens, états, a11y WCAG AA
                                       │
                                       ▼
                     [ 4. REVUE TECHNIQUE & COMPATIBILITÉ ]
                     Vérification CSS Vanilla / Bootstrap 5
                                       │
                                       ▼
                     [ 5. ARBITRAGE DU RESPONSABLE HUMAIN ]
                     Signature de la fiche de décision
                                       │
                                       ▼
                     [ 6. PUBLICATION, VERSIONNEMENT & COMM. ]
                     Mise à jour des tables et changelog
```

---

## 4. Règles de Versionnement Sémantique (SemVer)

Le Design System Marvens applique les principes du versionnement sémantique `MAJOR.MINOR.PATCH` pour tracer ses évolutions :

1. **Version MAJEURE (`X.0.0`) :**
   * Rupture de compatibilité descendante (*Breaking changes*).
   * Suppression de tokens ou de composants dépréciés.
   * Refonte structurelle de l'architecture CSS ou renommage global du namespace.
2. **Version MINEURE (`1.X.0`) :**
   * Ajout de nouveaux composants ou de nouveaux tokens sans casser l'existant.
   * Ajout d'une nouvelle variante d'état ou amélioration d'accessibilité transparente.
   * Marquage formel d'un élément comme `[DÉPRÉCIÉ]`.
3. **Version CORRECTIVE / PATCH (`1.0.X`) :**
   * Correction d'un bug CSS, ajustement d'un contraste mineur, rectification typographique d'une documentation.

---

## 5. Gestion des Exceptions et Dérogations Produit

Le framework MARVENS CREATIVE BRIEF V1.0 applique le principe *Contextual Design*. Un produit peut légitimement nécessiter une dérogation par rapport aux tokens standards :

### Protocole de Dérogation :
1. **Justification Factuelle Obligatoire :** Démontrer pourquoi le système central ne répond pas à la contrainte métier ou technique spécifique du produit.
2. **Scoping Strict dans le Produit :** L'exception doit être déclarée dans le dossier propre au produit (`07_PRODUCT_MODULES/`) sous forme de token surchargé localement, sans modifier le cœur universel du framework.
3. **Interdiction du Fork Sauvage :** Ne jamais dupliquer l'intégralité du Design System pour modifier trois couleurs. Seules les variables nécessaires sont surchargées.

---

## 6. Registre des Décisions d'Architecture (ADR - Modèle Réutilisable)

Chaque arbitrage structurant relatif au Design System doit être consigné au moyen du gabarit standard suivant :

```markdown
# ADR-[NUMÉRO] — [Titre de la Décision]

* **Date :** AAAA-MM-JJ
* **Statut :** [PROPOSÉ / ACCEPTÉ / REJETÉ / DÉPRÉCIÉ]
* **Décideur Humain :** [Nom et Prénom, Rôle]
* **Contexte & Problématique :**
  > [Explication du problème technique ou fonctionnel ayant nécessité une décision]
* **Décision Adoptée :**
  > [Description précise de la solution retenue et des tokens/composants impactés]
* **Conséquences & Arbitrages :**
  * Avantages immédiats : [...]
  * Contraintes ou limites assumées : [...]
* **Impact sur la Compatibilité :** [Rétrocompatible / Nécessite migration]
```

---

## 7. Indicateurs de Santé du Design System (KPIs)

La vitalité et l'efficacité du système sont mesurées périodiquement au moyen de quatre indicateurs :
* **Taux d'Adoption des Tokens :** Ratio des déclarations CSS utilisant `var(--mrv-*)` par rapport aux valeurs en pixels ou couleurs hexadécimales en dur (Objectif : > 95%).
* **Taux de Réutilisation des Composants :** Nombre de composants standards réutilisés vs composants créés ad hoc par écran (Objectif : > 80%).
* **Score de Conformité Accessibilité :** Absence de régression WCAG AA lors des audits de recette.
* **Volume d'Exceptions Non Documentées :** Doit être strictement égal à zéro.

---

## 8. Checklist de Gouvernance

```markdown
### Grille de Contrôle de Gouvernance
- [ ] Chaque proposition d'évolution est motivée par un cas d'usage réel documenté.
- [ ] Le cycle en 6 étapes a été respecté avant toute publication normative.
- [ ] L'impact sur la rétrocompatibilité a été évalué selon les règles SemVer.
- [ ] En cas de dérogation produit, celle-ci est scopée localement sans polluer le socle.
- [ ] La décision finale porte la signature explicite du responsable humain.
- [ ] Le registre des décisions (ADR) et la documentation ont été mis à jour.
```
