# UX AUDIT — Protocole et méthode d'audit d'expérience utilisateur
## MARVENS CREATIVE BRIEF V1.0 · PHASE 10_QUALITY_ASSURANCE

> **Document :** Méthodologie d'inspection heuristique et d'évaluation ergonomique  
> **Statut :** Protocole d'audit actif  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## 1. Objectifs, périmètre et posture méthodologique

L'audit UX a pour mission d'évaluer scientifiquement et objectivement l'expérience offerte par un produit numérique. Il traque les frictions, les incompréhensions, les lenteurs et les risques d'abandon.

### Posture de rigueur
* Un audit UX ne repose pas sur les goûts personnels de l'auditeur. Il s'appuie sur des heuristiques d'utilisabilité universellement reconnues (notamment les **10 Heuristiques de Nielsen & Molich** et les principes de psychologie cognitive de Gestalt).
* Les affirmations péremptoires (« l'interface n'est pas agréable ») sont bannies. Tout problème relevé doit être documenté avec un scénario de reproduction précis, l'impact sur l'utilisateur et une recommandation corrective concrète.

---

## 2. Grille d'évaluation heuristique contextualisée Marvens

L'inspection heuristique examine le produit sous sept dimensions fondamentales :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 7 DIMENSIONS DE L'AUDIT ERGONOMIQUE                  │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Visibilité du système │ L'usager sait toujours ce qui se passe (retours, │
│    (System Status)       │ barres de progression, témoins de connexion MoMo)│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Alignement réel       │ Vocabulaire, concepts et métaphores calqués sur  │
│    (Real World Match)    │ la réalité métier des commerçants et PME locales.│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Liberté & Contrôle    │ Possibilité d'annuler une action, de revenir en  │
│    (User Control)        │ arrière et de corriger une saisie sans blocage.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Prévention d'erreur   │ Conception proactive empêchant la faute avant    │
│    (Error Prevention)    │ qu'elle ne survienne (seuils, masquage de boutons│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 5. Reconnaissance facile │ Réduire la charge mémorielle : les options et    │
│    (Recognition > Recall)│ boutons importants sont sous les yeux de l'usager│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 6. Efficacité des flux   │ Raccourcis pour les experts, rapidité des tâches │
│    (Task Efficiency)     │ fréquentes (clôture de caisse, facturation).     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 7. Diagnostic d'erreur   │ Messages clairs en français simple sans code brut│
│    (Error Recovery)      │ indiquant comment débloquer la situation.        │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Méthodes d'investigation et niveaux de preuve

L'audit UX s'appuie sur trois niveaux méthodologiques complémentaires :

1. **Revue Heuristique Experte (Inspection systématique) :**  
   L'expert UX ou l'agent IA parcourt chaque écran en confrontant l'interface à la grille heuristique.
2. **Cognitive Walkthrough (Parcours de tâche pas-à-pas) :**  
   Simulation pas-à-pas des 3 tâches critiques du persona principal (ex: *« Carine doit encaisser un client avec un pantalon en Mobile Money en moins de 30 secondes »*). Pour chaque étape, l'auditeur répond aux 4 questions canoniques :
   * L'utilisateur sait-il quelle action accomplir ?
   * Voit-il le bouton ou l'élément nécessaire ?
   * Comprend-il que cette action produit l'effet désiré ?
   * Obtient-il un retour rassurant après l'action ?
3. **Tests Utilisateurs Réels (Usability Testing) :**  
   Observation directe d'utilisateurs représentatifs sans guidage. *Condition stricte : ne consigner des citations ou résultats de tests réels que si la session a effectivement eu lieu. Ne jamais fabriquer de faux tests.*

---

## 4. Échelle de sévérité des anomalies UX

Tout problème relevé doit être classé selon une échelle de gravité standardisée en 4 niveaux :

| Gravité | Définition opérationnelle | Conséquence sur le produit |
| :--- | :--- | :--- |
| **P0 — Bloquant (Critical)** | Empêche l'accomplissement d'une tâche vitale (ex: impossible de valider un paiement, bouton inactif). | **Arrêt immédiat** de la livraison. |
| **P1 — Majeur (Major)** | Entraîne une friction sévère, un risque élevé d'erreur ou une confusion durable pour la majorité des usagers. | Doit être corrigé avant la mise en production. |
| **P2 — Modéré (Minor)** | Gêne ergonomique ou ralentissement sans blocage (ex: libellé ambigu, mauvaise disposition secondaire). | À planifier dans l'itération en cours. |
| **P3 — Cosmétique (Trivial)** | Amélioration esthétique mineure ou perfectionnement de détail sans impact fonctionnel. | Traité en amélioration continue. |

---

## 5. Modèle officiel de fiche d'anomalie UX (UX Issue Report)

Toute non-conformité relevée lors de l'audit doit être consignée selon ce format :

```markdown
### [UX-ANOMALIE-001] Libellé court et précis du problème
* **Écran / Flux concerné :** [ex: Écran Panier / Validation de commande]
* **Heuristique enfreinte :** [ex: Prévention des erreurs / Clarté du feedback]
* **Niveau de Gravité :** [P0 Bloquant / P1 Majeur / P2 Modéré / P3 Cosmétique]
* **Description détaillée du constat :**  
  Lorsque l'utilisateur saisit son numéro de téléphone avec des espaces (ex: "699 00 11 22"), le système rejette le champ avec le message technique "Format invalide" sans nettoyer automatiquement les espaces.
* **Preuve / Scénario de reproduction :**  
  1. Se rendre sur la page checkout.  
  2. Saisir le numéro avec des espaces.  
  3. Constater le blocage du bouton de validation.
* **Impact utilisateur :**  
  Friction majeure et risque d'abandon de panier par incompréhension chez les usagers habitués à espacer les chiffres.
* **Recommandation corrective :**  
  Implémenter un nettoyage automatique des espaces et tirets côté client à la saisie, et formater visuellement le numéro sous la forme locale standard `6XX XX XX XX`.
* **Statut :** [ ] Ouvert  [ ] En cours  [ ] Résolu  [ ] Vérifié
```

---

## 6. Synthèse d'audit et recommandations hiérarchisées

L'audit UX se conclut systématiquement par une synthèse managériale :
* **Bilan volumétrique :** Nombre d'anomalies réparties par gravité (P0, P1, P2, P3).
* **Top 3 des chantiers prioritaires :** Les trois interventions qui apporteront le plus grand gain de conversion ou de productivité immédiat.
* **Décision de validation UX :** Avis formel de l'auditeur (Validation sans réserve / Validation sous réserve de correction des P0-P1 / Rejet pour refonte d'ergonomie).
