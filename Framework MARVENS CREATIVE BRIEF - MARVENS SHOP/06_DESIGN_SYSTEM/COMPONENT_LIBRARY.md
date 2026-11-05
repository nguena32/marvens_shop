# COMPONENT LIBRARY — Bibliothèque de Composants
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `06_DESIGN_SYSTEM/COMPONENT_LIBRARY.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Référence méthodologique active `[PROPOSITION NORMATIVE DU FRAMEWORK]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [DESIGN_TOKENS.md](DESIGN_TOKENS.md) · [CSS_ARCHITECTURE.md](CSS_ARCHITECTURE.md) · [UI_GUIDELINES.md](../05_UI_DESIGN/UI_GUIDELINES.md) · [INTERACTION_DESIGN.md](../04_UX_DESIGN/INTERACTION_DESIGN.md)

---

## 1. Rôle et Philosophie de la Bibliothèque

La **Component Library** de Marvens Group constitue le répertoire de spécifications normatives des éléments d'interface réutilisables.

### Principes Cardinaux de Conception des Composants :
1. **Responsabilité Unique (*Single Responsibility*) :** Chaque composant accomplit une fonction d'interaction ou d'affichage précise et s'abstient de gérer la logique métier globale de l'application.
2. **Consommation Intégrale des Tokens :** Zéro style en valeur brute codée en dur. Tout espacement, couleur, rayon ou typographie provient d'un token `--mrv-*`.
3. **Accessibilité Native (a11y) :** Les composants intègrent les balises HTML5 sémantiques, les rôles ARIA adéquats et les comportements clavier obligatoires.
4. **Composition plutôt qu'Héritage lourd :** Construire des blocs complexes par imbrication de briques simples plutôt que par des composants géants et monolithiques.
5. **Indépendance Technique :** Les spécifications sont conçues pour être implémentées directement en HTML5 / CSS3 / Vanilla JS ou au-dessus de Bootstrap 5 sans dépendance obligatoire envers un framework JS lourd (React, Vue).

---

## 2. Taxonomie et Hiérarchie des Composants

Pour organiser la bibliothèque avec clarté, Marvens classe ses composants en quatre niveaux d'abstraction :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 1. PRIMITIVES & ÉLÉMENTS DE BASE (Base Elements)                            │
│ Briques atomiques simples : Bouton, Icône, Champ texte, Case à cocher, Badge│
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Imbriqué dans
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 2. COMPOSANTS COMPOSÉS (Molecules / Organisms)                              │
│ Combinaisons fonctionnelles : Barre de recherche, Carte média, Dialogue     │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Imbriqué dans
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 3. PATTERNS DE MISE EN PAGE & STRUCTURE (Layout Patterns)                   │
│ En-tête applicatif, Barre latérale rétractable, Grille de tableau de bord   │
└──────────────────────────────────────┬──────────────────────────────────────┘
                                       │ Déployé dans
                                       ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│ 4. COMPOSANTS MÉTIER SPÉCIFIQUES (Domain Components)                        │
│ Blocs dédiés à un produit : Sélecteur Mobile Money, Carte d'audit fiscal   │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 3. Répertoire des 24 Composants Fondamentaux du Framework

La bibliothèque Marvens structure les composants universels selon 8 familles d'usage :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                   LES 8 FAMILLES DE COMPOSANTS DU FRAMEWORK                 │
├──────────────────────┬──────────────────────────────────────────────────────┤
│ A. Actions           │ 1. Button, 2. Link, 3. Dropdown Button               │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ B. Formulaires       │ 4. Input Text, 5. Select, 6. Checkbox, 7. Radio,     │
│    & Saisie          │ 8. Switch / Toggle, 9. Textarea                      │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ C. Navigation        │ 10. Tabs, 11. Breadcrumbs, 12. Pagination            │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ D. Affichage         │ 13. Card, 14. Badge / Tag, 15. Avatar, 16. Accordion │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ E. Données           │ 17. Data Table, 18. Stat KPI Card                    │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ F. Rétroactions (FB) │ 19. Alert / Banner, 20. Toast, 21. Progress Bar      │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ G. États Systèmes    │ 22. Skeleton Loader, 23. Empty State                 │
├──────────────────────┼──────────────────────────────────────────────────────┤
│ H. Fenêtres Flott.   │ 24. Modal / Dialog, Drawer (Tiroir)                  │
└──────────────────────┴──────────────────────────────────────────────────────┘
```

---

## 4. Spécifications Détaillées des Composants Clés

Chaque composant de la bibliothèque doit être spécifié selon la structure normalisée en 7 points :

---

### Composant 1 : `Button` (Bouton d'Action)

* **Objectif & Rôle :** Déclencher une action immédiate dans le système (soumission, ouverture, confirmation).
* **Anatomie :** Conteneur interactif + Icône optionnelle (gauche ou droite) + Libellé textuel permanent.
* **Variantes Visuelles :**
  * `Primary` : Action prioritaire de la vue (fond `--mrv-color-action-primary`).
  * `Secondary` : Action d'accompagnement (fond transparent, bordure `--mrv-color-border-strong`).
  * `Tertiary / Ghost` : Action neutre sans bordure.
  * `Destructive` : Action risquée ou irréversible (fond `--mrv-color-feedback-danger`).
* **Tailles Normalisées :**
  * `Small` : Hauteur 32px, padding horizontal 12px, font 12px.
  * `Medium` (Défaut) : Hauteur 40px, padding horizontal 16px, font 14px.
  * `Large` : Hauteur 48px, padding horizontal 20px, font 16px (idéal mobile).
* **États Obligatoires :** `Default`, `Hover`, `Focus-visible` (contour contrasté 3:1), `Active`, `Disabled`, `Loading` (remplacement du libellé par spinner).
* **Accessibilité :** Balise HTML `<button type="button|submit">`, libellé explicite ou `aria-label` si icône seule.
* **Anti-usages :** Ne jamais utiliser un bouton stylé comme un lien textuel de navigation inter-pages ; ne pas aligner plus d'un bouton Primary par écran.

---

### Composant 2 : `Input` (Champ de Saisie Texte)

* **Objectif & Rôle :** Permettre la saisie de texte, chiffres, courriels ou mots de passe.
* **Anatomie :** Label permanent au-dessus du champ + Conteneur de saisie avec bordure + Icône contextuelle optionnelle + Texte d'aide ou message d'erreur en dessous.
* **Tailles Normalisées :** Hauteur 40px (Desktop) / 48px (Tactile mobile).
* **États Obligatoires :**
  * `Default` : Bordure `--mrv-color-border-strong`.
  * `Hover` : Bordure assombrie.
  * `Focus` : Anneau de focus `--mrv-color-action-primary` sans masquage.
  * `Filled` : Texte présent avec fond blanc propre.
  * `Disabled` : Fond grisé `--mrv-color-surface-subtle`, curseur `not-allowed`.
  * `Error` : Bordure rouge `--mrv-color-feedback-danger` + message explicatif sous le champ.
* **Accessibilité :** Association obligatoire du `<label for="champ-id">` avec `<input id="champ-id">`. Liaison de l'erreur via `aria-describedby="erreur-id"`.

---

### Composant 3 : `Card` (Carte Modulaire)

* **Objectif & Rôle :** Regrouper des informations et actions relatives à une entité métier unique (dossier, produit, commande).
* **Anatomie :** Conteneur de surface (`--mrv-color-surface-card`) + En-tête (*Header*) avec titre et action + Corps (*Body*) + Pied de carte optionnel (*Footer*).
* **Variantes :** `Flat` (contour seul, 0 ombre), `Elevated` (ombre subtile `--mrv-shadow-sm`), `Interactive` (surélévation au hover si toute la carte est cliquable).
* **Règles d'Usage :** Bannir l'encapsulation de tout et n'importe quoi dans des cartes. Une carte doit constituer une unité logique signifiante.

---

### Composant 4 : `Modal / Dialog` (Dialogue Modal Bloquant)

* **Objectif & Rôle :** Interrompre le flux pour exiger une décision ou afficher une tâche critique nécessitant l'attention totale de l'usager.
* **Anatomie :** Voile d'arrière-plan (*Backdrop* assombri 50%) + Boîte de dialogue centrée + Titre explicite + Corps informatif + Barre d'actions (Bouton d'annulation + Bouton de confirmation).
* **Comportements Obligatoires :**
  * Piégeage du focus clavier à l'intérieur de la modale (`Focus Trap`).
  * Fermeture instantanée via la touche `Échap`, la croix supérieure ou le clic sur le voile.
  * Restauration du focus sur le déclencheur initial dès la fermeture.

---

### Composant 5 : `Toast` (Notification Éphémère)

* **Objectif & Rôle :** Confirmer le succès ou le statut d'une action de fond sans bloquer l'interface.
* **Positionnement :** Angle inférieur droit ou supérieur droit, au-dessus du contenu (`--mrv-zindex-toast`).
* **Durée d'Affichage :** 4 à 6 secondes avec possibilité de fermeture manuelle immédiate.
* **Accessibilité :** Déclaré via `aria-live="polite"` pour les succès et `aria-live="assertive"` pour les alertes critiques.

---

### Composant 6 : `Skeleton Loader` (Squelette de Chargement)

* **Objectif & Rôle :** Améliorer la performance perçue en projetant la géométrie de la page avant la réception effective des données de l'API.
* **Aspect :** Blocs géométriques gris clair animés par un balayage lumineux discret (*shimmer*).
* **Règle de Réduction :** Si `prefers-reduced-motion` est actif, le scintillement animé est désactivé au profit d'un gris fixe statique.

---

## 5. Matrice des États Universels des Composants

L'ensemble des composants interactifs de la bibliothèque implémente la matrice d'état suivante :

| État | Comportement Visuel | Curseur | Accessibilité / ARIA |
| :--- | :--- | :--- | :--- |
| **Default** | Repos selon tokens | `default` ou `pointer` | Valeur standard |
| **Hover** | Contraste renforcé (+5-10%) | `pointer` | Non applicable en tactile |
| **Focus-visible** | Contour visible de 2px (ratio $\ge$ 3:1) | Selon élément | Révélé uniquement au clavier |
| **Active / Pressed** | Compression de 1px | `pointer` | Confirmation motrice |
| **Selected** | Accentuation nette de fond ou filet | `default` | `aria-selected="true"` |
| **Disabled** | Opacité atténuée (50%), pas de hover | `not-allowed` | `disabled` ou `aria-disabled="true"` |
| **Loading** | Spinner contextuel, action bloquée | `wait` | `aria-busy="true"` |
| **Error** | Teinte rouge sémantique, bordure nette | Selon élément | `aria-invalid="true"` |

---

## 6. Composants Spécifiques au Métier et Conditions d'Admission

Un composant spécifique ne peut être intégré à la bibliothèque globale que s'il répond à la règle des trois occurrences :
* Si un bloc n'est utilisé que sur **un seul écran**, il relève du module produit spécifique (`07_PRODUCT_MODULES/`) et ne pollue pas la bibliothèque centrale.
* Si le composant est utilisé sur **au moins trois écrans ou flux distincts**, il fait l'objet d'une spécification dans la bibliothèque du Design System.

---

## 7. Checklist d'Homologation d'un Composant

```markdown
### Grille de Revue de Conformité d'un Composant
- [ ] Le composant consomme exclusivement des tokens --mrv-*.
- [ ] La structure HTML utilise les balises sémantiques natives adaptées.
- [ ] Tous les états obligatoires (Hover, Focus, Disabled, Loading, Error) sont spécifiés.
- [ ] L'anneau de focus clavier est hautement visible sans masquage outline:none.
- [ ] Les zones tactiles sur smartphone atteignent le seuil minimal de 44x44px.
- [ ] Les attributs ARIA indispensables (aria-expanded, aria-controls, aria-live) sont définis.
- [ ] Les anti-usages sont explicitement documentés pour guider les développeurs.
```
