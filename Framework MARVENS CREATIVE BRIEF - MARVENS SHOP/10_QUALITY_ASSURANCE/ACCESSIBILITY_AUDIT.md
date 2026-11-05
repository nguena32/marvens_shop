# ACCESSIBILITY AUDIT — Protocole d'audit d'accessibilité numérique (WCAG 2.2 AA)
## MARVENS CREATIVE BRIEF V1.0 · PHASE 10_QUALITY_ASSURANCE

> **Document :** Protocole d'évaluation de conformité d'accessibilité numérique  
> **Référentiel de base :** WCAG 2.2 (Web Content Accessibility Guidelines - Niveau AA)  
> **Statut :** Protocole d'audit actif  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## 1. Objectifs, périmètre et niveau d'exigence visé

L'accessibilité numérique n'est ni un supplément d'âme ni une contrainte réglementaire lointaine : elle est l'incarnation de la **Premium Quality** de Marvens Group. Une interface inaccessible aux personnes en situation de handicap, aux usagers malvoyants ou aux personnes manipulant un écran sous un soleil éclatant est une interface défaillante.

### Référentiel légal et technique
* **Norme retenue :** **WCAG 2.2 au Niveau AA**.
* **Posture de preuve :** L'audit d'accessibilité combine obligatoirement des contrôles mathématiques (contrastes de couleurs), des vérifications manuelles (navigation 100 % au clavier sans souris) et des tests sur lecteurs d'écran. Les tests automatisés ne suffisent jamais à certifier la conformité.

---

## 2. Les 4 principes fondamentaux du W3C / WCAG

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 4 PILIERS WCAG APPLIQUÉS À MARVENS                   │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. PERCEPTIBLE           │ L'information doit être perceptible par au moins │
│    (Perceivable)         │ un sens (contrastes stricts, textes alternatifs).│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. UTILISABLE            │ L'interface doit pouvoir être manipulée au       │
│    (Operable)            │ clavier, sans piège, avec un temps suffisant.    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. COMPRÉHENSIBLE        │ Les textes sont clairs, les comportements sont   │
│    (Understandable)      │ prévisibles, les erreurs sont expliquées.        │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. ROBUSTE               │ Le code HTML est sémantique et compatible avec   │
│    (Robust)              │ l'ensemble des technologies d'assistance.        │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Grille de contrôle détaillée des critères WCAG 2.2 AA

### 3.1. Principe 1 : Perceptible
| Critère WCAG | Description du test | Seuil de conformité | Statut type |
| :--- | :--- | :--- | :---: |
| **1.1.1 Non-text Content** | Toute image porteuse de sens a un attribut `alt`. | Texte alternatif pertinent | `PASS` / `FAIL` |
| **1.3.1 Info & Relationships** | Structure balisée (titres `h1`-`h6`, listes, tables).| Sémantique HTML pure | `PASS` / `FAIL` |
| **1.4.1 Use of Color** | La couleur n'est jamais le seul signal d'état. | Association texte/icône | `PASS` / `FAIL` |
| **1.4.3 Contrast (Minimum)** | Texte normal : ratio minimum **4.5:1** face au fond. | Formule mathématique W3C | `PASS` / `FAIL` |
| **1.4.11 Non-text Contrast** | Composants UI et icônes d'action : ratio **3.0:1**.| Séparateurs et icônes nets| `PASS` / `FAIL` |
| **1.4.12 Text Spacing** | Aucun contenu tronqué si interligne passe à 1.5. | Conteneurs flexibles | `PASS` / `FAIL` |

### 3.2. Principe 2 : Utilisable
| Critère WCAG | Description du test | Seuil de conformité | Statut type |
| :--- | :--- | :--- | :---: |
| **2.1.1 Keyboard** | L'intégralité du produit est pilotable à la touche `Tab`.| Aucune action bloquée | `PASS` / `FAIL` |
| **2.1.2 No Keyboard Trap** | Le focus peut entrer ET sortir de tout conteneur/modal.| Touche `Échap` fonctionnelle| `PASS` / `FAIL` |
| **2.4.3 Focus Order** | L'ordre de tabulation suit la logique de lecture humaine.| Séquence naturelle haut-bas| `PASS` / `FAIL` |
| **2.4.7 Focus Visible** | L'élément actif affiche un anneau de focus contrasté.| Anneau $\ge 2\text{px}$ visible | `PASS` / `FAIL` |
| **2.5.5 Target Size (Enhanced)**| Cibles tactiles d'une dimension minimale de 44x44px. | Zone de tap respectée | `PASS` / `FAIL` |

### 3.3. Principe 3 : Compréhensible
| Critère WCAG | Description du test | Seuil de conformité | Statut type |
| :--- | :--- | :--- | :---: |
| **3.1.1 Language of Page** | Attribut `lang="fr"` présent sur la balise `<html>`.| Langue officielle déclarée | `PASS` / `FAIL` |
| **3.2.2 On Input** | La saisie dans un champ ne déclenche pas d'action surprise.| Soumission par bouton explicite| `PASS` / `FAIL` |
| **3.3.1 Error Identification**| L'erreur indique quel champ est fautif et pourquoi.| Libellé d'erreur visible | `PASS` / `FAIL` |
| **3.3.2 Labels or Instructions**| Chaque champ de saisie a une étiquette `<label>` liée.| `for="id"` présent | `PASS` / `FAIL` |

### 3.4. Principe 4 : Robuste
| Critère WCAG | Description du test | Seuil de conformité | Statut type |
| :--- | :--- | :--- | :---: |
| **4.1.2 Name, Role, Value** | Les composants personnalisés exposent leurs attributs ARIA.| `aria-expanded`, `aria-label`| `PASS` / `FAIL` |
| **4.1.3 Status Messages** | Les alertes dynamiques sont notifiées aux lecteurs d'écran.| Attribut `role="status"` | `PASS` / `FAIL` |

---

## 4. Protocole d'investigation en 4 étapes obligatoires

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    PROTOCOLE DE TEST D'ACCESSIBILITÉ MARVENS                │
│                                                                             │
│  [ÉTAPE 1 : Audit Mathématique des Contrastes]                              │
│  Mesure systématique au colorimètre de tous les couples texte/surface.      │
│                     │                                                       │
│                     ▼                                                       │
│  [ÉTAPE 2 : Parcours Intégral au Clavier (Sans Souris)]                     │
│  Navigation complète (Touche Tab, Flèches, Espace, Entrée, Échap)           │
│  du premier écran au paiement final. Vérification du Focus Visible.        │
│                     │                                                       │
│                     ▼                                                       │
│  [ÉTAPE 3 : Contrôle de Sémantique & Lecteur d'Écran]                       │
│  Test sur NVDA (Windows) ou VoiceOver (Mac/iOS) pour vérifier que           │
│  chaque bouton et statut est intelligible à l'oral.                         │
│                     │                                                       │
│                     ▼                                                       │
│  [ÉTAPE 4 : Test de Zoom & Grossissement de Texte (200%)]                   │
│  Agrandissement du navigateur à 200% sans perte d'information ni collision. │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 5. Fiche d'anomalie d'accessibilité

```markdown
### [A11Y-ANOMALIE-001] Contraste insuffisant sur le bouton secondaire
* **Composant / Écran :** Bouton "Annuler la transaction" / Écran de caisse
* **Critère WCAG enfreint :** 1.4.3 Contrast (Minimum) — Niveau AA
* **Mesure constatée :** Texte gris `#94A3B8` sur fond blanc `#FFFFFF` ➔ Ratio de 2.4:1 (Seuil légal : 4.5:1)
* **Gravité :** P1 (Majeur)
* **Impact :** Les personnes malvoyantes et les caissiers sous forte luminosité ne distinguent pas le libellé.
* **Correction recommandée :** Utiliser le token `--color-text-secondary` (`#475569`), offrant un ratio de 5.2:1.
* **Statut :** [ ] Ouvert  [ ] Résolu
```
