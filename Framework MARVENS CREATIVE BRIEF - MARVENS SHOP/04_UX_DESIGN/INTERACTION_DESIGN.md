# INTERACTION DESIGN — Conception des Interactions
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `04_UX_DESIGN/INTERACTION_DESIGN.md`  
> **Statut :** Référence méthodologique active  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents amont associés :** [UX_PRINCIPLES.md](UX_PRINCIPLES.md) · [NAVIGATION_SYSTEM.md](NAVIGATION_SYSTEM.md) · [ART_DIRECTION_GUIDELINES.md](../02_ART_DIRECTION/ART_DIRECTION_GUIDELINES.md)

---

## 1. Définition et Vocabulaire Fondamental

Le design d'interaction (*Interaction Design / IxD*) définit **la manière dont l'utilisateur et le système dialoguent dans le temps et dans l'espace**. Il modélise les déclencheurs, les actions motrices, les réactions dynamiques et les changements d'état d'une interface numérique.

### Les 7 Notions Clés du Dialogue Homme-Machine :
1. **L'Action Utilisateur :** Le geste intentionnel accompli par la personne (clic, appui tactile, frappe clavier, glisser-déposer, balayage).
2. **Le Déclencheur (*Trigger*) :** L'élément graphique ou l'événement système provoquant l'interaction.
3. **Le Signifiant & l'Affordance (*Signifier*) :** Les indices visuels indiquant à l'usager comment et où agir (ex. relief d'un bouton, curseur pointeur, champ encadré).
4. **La Réponse Système & le Rétro-signal (*Feedback*) :** La manifestation immédiate par laquelle le système accuse réception de l'action.
5. **L'État d'Interface (*UI State*) :** La condition formelle d'un composant à un instant précis de son cycle de vie.
6. **La Transition Spatiale (*Motion*) :** Le mouvement fluide reliant deux états pour préserver la continuité cognitive sans désorienter l'utilisateur.
7. **La Micro-Interaction :** La boucle de rétroaction unitaire accomplissant une sous-tâche ciblée (ex. basculer un interrupteur, afficher une pastille de validation).

---

## 2. Principes Directeurs des Interactions

Toute interaction au sein des produits Marvens doit être rigoureusement guidée par les règles suivantes :

### 2.1. Rétroaction Immédiate et Déterministe
Le système ne doit jamais laisser l'utilisateur dans l'incertitude :
* **Moins de 100ms :** Rétroaction optique immédiate sur l'élément cliqué (enfoncement, changement de couleur).
* **Entre 100ms et 300ms :** Réaction perceptible sans perturbation du flux d'attention.
* **Plus de 300ms :** Affichage obligatoire d'un indicateur de chargement contextuel (*spinner*, barre ou *skeleton*).
* **Plus de 2 secondes :** Message textuel explicatif sur l'opération en cours avec option d'annulation si possible.

### 2.2. Visibilité Absolue des Affordances
Un élément interactif doit ressembler à un élément interactif. Ne jamais contraindre l'usager à balayer l'écran à la souris pour découvrir ce qui est cliquable (*mystery meat navigation* interdite).

### 2.3. Réversibilité et Prévention des Catastrophes
* **Actions banales :** Réalisables en un clic avec possibilité d'annulation a posteriori (*Undo* via notification toast persistante 5 secondes).
* **Actions destructives critiques (ex. suppression définitive de compte, virement irréversible) :** Dialogue modal bloquant avec saisie explicite de confirmation (ex. retaper le mot « SUPPRIMER » ou confirmation biométrique).

### 2.4. Tolérance et Préservation des Données
Le système doit être amnésique de ses propres lenteurs mais jamais des efforts de l'utilisateur : toute donnée déjà saisie dans un formulaire doit être conservée localement en cas d'erreur de validation, de rejet serveur ou de coupure réseau.

---

## 3. Matrice Exhaustive des États d'Interface

Chaque composant interactif d'un produit Marvens doit impérativement disposer d'un comportement documenté pour l'ensemble des états opérationnels applicables :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       LES 14 ÉTATS D'INTERFACE MARVENS                      │
├────────────────────┬────────────────────────────────────────────────────────┤
│ 1. Initial/Repos   │ État natif passif avant toute interaction.             │
│ 2. Survol (Hover)  │ Réaction au passage du pointeur (souris).              │
│ 3. Focus Clavier   │ Anneau visible d'accessibilité à la tabulation.        │
│ 4. Pressé (Active) │ Compression visuelle au moment de l'appui.             │
│ 5. Sélectionné     │ Confirmation visuelle que l'élément est coché/choisi.  │
│ 6. Désactivé (Dis.)│ Rendu atténué justifié (avec infobulle de motif).      │
│ 7. Chargement      │ Indicateur d'activité bloquant la double soumission.   │
│ 8. Succès          │ Validation positive (vert sémantique, coche animée).   │
│ 9. Erreur          │ Signalement net d'anomalie avec message explicatif.    │
│ 10. État Vide      │ Écran ou bloc sans données avec guidage d'action.      │
│ 11. Données Part.  │ Chargement partiel ou progressif (*lazy loading*).     │
│ 12. Hors Ligne     │ Signalement de perte réseau et mode de reprise prévu.  │
│ 13. Expiré         │ Session ou lien ayant atteint sa date limite.          │
│ 14. Non Autorisé   │ Refus d'accès clair avec proposition d'élévation.      │
└────────────────────┴────────────────────────────────────────────────────────┘
```

---

## 4. Familles d'Interactions et Standards d'Implémentation

### 4.1. Boutons et Déclencheurs d'Actions
* **Prévention du double-clic involontaire :** Dès le premier clic, le bouton passe instantanément en état *Loading* et se désactive pour empêcher les doubles soumissions ou les doubles débits financiers.
* **Hiérarchie stricte par écran :** Un seul bouton d'action primaire (*Primary CTA*) par vue pour concentrer le regard.

### 4.2. Formulaires et Champs de Saisie
* **Validation contextuelle au bon moment :** Ne jamais déclencher d'erreur en rouge tant que l'usager est en train de taper (*inline validation on blur*).
* **Labels visibles en permanence :** Bannir les formulaires n'utilisant que des *placeholders* évanescents. Le libellé du champ doit rester lisible même quand le champ est rempli.
* **Formatage et masques intelligents :** Séparation automatique des chiffres de téléphone, des montants et des dates pour prévenir les erreurs de frappe.

### 4.3. Modales, Dialogues et Tiroirs (*Drawers*)
* Fermeture accessible par trois moyens convergents : bouton croix explicite, clic sur le fond assombri (*backdrop*), ou touche `Échap` du clavier.
* Piégeage du focus clavier à l'intérieur de la modale active (*Focus Trap*) pour garantir l'accessibilité.

### 4.4. Notifications et Messages Système
* **Toasts éphémères :** Réservés aux confirmations d'actions mineures réversibles (durée 4 à 6 secondes, avec bouton Annuler).
* **Bannières d'alerte contextuelles :** Persistantes, ancrées dans la page, pour les blocages nécessitant une intervention de l'usager.

---

## 5. Gestion des Erreurs et Robustesse Opérationnelle

Un design d'interaction Premium se juge à sa capacité à gérer les moments de crise avec bienveillance et rigueur :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    PROTOCOLE DE TRAITEMENT D'UNE ERREUR                     │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Localisation Précise  │ Mettre l'erreur en évidence exactement à côté de │
│                          │ l'élément fautif (champ spécifique, pas en haut) │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Langage Respectueux   │ Bannir les codes d'erreur bruts (ex. « Erreur    │
│    et Compréhensible     │ 500 » ou « NullPointer ») et les tons accusateurs│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Solution Actionnable  │ Expliquer exactement quoi faire pour débloquer   │
│                          │ la situation (ex. « Votre mot de passe doit... »)│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Maintien des Acquis   │ Ne JAMAIS effacer les champs valides déjà saisis.│
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 6. Micro-Interactions et Animations Fonctionnelles

Dans MARVENS CREATIVE BRIEF V1.0, **l'animation est un outil d'orientation spatiale et de réassurance cognitive**, et non un spectacle visuel.

* **Durée étalonnée :** 150ms à 250ms pour les micro-interactions d'état ; 250ms à 350ms pour les ouvertures de panneaux ou dialogues.
* **Courbes naturelles :** Accélération progressive en sortie (*ease-out*) pour les apparitions, décélération en entrée (*ease-in*) pour les fermetures.
* **Respect impératif de l'accessibilité :** Si l'utilisateur a configuré son système d'exploitation avec l'option `prefers-reduced-motion`, toutes les transitions animées sont immédiatement désactivées au profit d'apparitions nettes instantanées.

---

## 7. Spécification d'Interaction Réutilisable (Modèle Opérationnel)

Chaque interaction complexe doit être documentée pour l'équipe de développement selon le gabarit ci-dessous :

```markdown
# FICHE DE SPÉCIFICATION D'INTERACTION — [Identifiant & Nom]

* **Composant Cible :** [Ex. Bouton de validation de paiement]
* **Écran / Vue Associée :** [Ex. Vue Récapitulative Commande]
* **Date & Version :** AAAA-MM-JJ (V1.0)

---

### 1. Déclenchement & Préconditions
* **Préconditions :** Formulaire valide à 100%, connexion réseau disponible.
* **Déclencheur :** Clic souris gauche / Tap tactile sur le CTA « Confirmer le paiement ».

---

### 2. Séquence Dynamique d'États

| Étape | État Composant | Manifestation Visuelle | Comportement Système & API |
| :---: | :--- | :--- | :--- |
| **01** | Pressé (*Active*) | Enfoncement 1px, assombrissement 5% | Déclenchement requête POST /api/pay |
| **02** | Chargement (*Loading*)| Remplacement du label par spinner | Désactivation de tout nouveau clic |
| **03** | Succès (*Success*) | Remplacement par icône coche verte | Redirection automatique sous 1.2 sec |
| **04** | Échec (*Error*) | Bordure rouge + vibration subtile | Réactivation du bouton + toast erreur |

---

### 3. Comportements Clavier & Accessibilité
* **Touche Entrée / Espace :** Déclenche l'action si le bouton a le focus.
* **Annonce Lecteur d'Écran :** Déclaration dynamique via `aria-live="polite"` : *« Paiement en cours de traitement »*.

---

### 4. Gestion des Cas Dégradés (Réseau Faible)
* Si aucun retour serveur sous 5 secondes : Affichage d'un texte d'attente rassurant : *« Vérification auprès de l'opérateur en cours, veuillez ne pas quitter cette page... »*.
```


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Exigences UX/UI et flux utilisateurs
- **Modules applicables retenus :** MODULE_ECOMMERCE, MODULE_PWA
- **Fonctionnalités prioritaires MVP :**
- Gestion du catalogue
- Tableau de bord et gestion des commandes
- Gestion commerciale et indicateurs
- Panier et commande
- Tableau de bord et gestion des commandes
- Connexion OAuth Meta
- Importer depuis Meta

- **Parcours utilisateurs clés :** Parcours acheteur
25.	Le client ouvre le mini-site depuis un lien partagé.
26.	Il recherche ou parcourt les produits.
27.	Il consulte une fiche, choisit quantité et variante.
28.	Il ajoute au panier.
29.	Il renseigne ses coordonnées et informations de livraison/paiement.
30.	Il valide ; la commande est enregistrée et un numéro est attribué.
31.	Le site ouvre WhatsApp avec un message prérempli.
32.	Le client envoie le message au commerçant.
33.	Le commerçant confirme la disponibilité, les frais et le paiement.
34.	Le commerçant met à jour le statut dans le tableau de bord.
- **Rôles utilisateurs :** Administrateur Marvens (support technique), Commerçant / administrateur client, Opérateur / vendeur client (si activé), Client acheteur
- **Terminaux prioritaires :** desktop, tablet, mobile
- **Langues et accessibilité :** Francais
<!-- MARVENS_PROJECT_CONTEXT:END -->
