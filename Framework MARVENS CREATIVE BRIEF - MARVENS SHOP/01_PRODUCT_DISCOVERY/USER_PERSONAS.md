# USER PERSONAS — Personas et compréhension des utilisateurs
## MARVENS CREATIVE BRIEF V1.0 · PHASE 01_PRODUCT_DISCOVERY

> **Type de document :** Fiches personas et modélisation Jobs-To-Be-Done (JTBD)  
> **Statut :** Proto-personas / Hypothèses de travail documentées  
> **Date de référence :** 31 octobre 2026  
> **Méthode :** Synthèse d'observations terrain et retours d'usage en Afrique centrale  

---

## 1. Méthodologie et statut de preuve

> **Avertissement méthodologique :** Les profils décrits ci-dessous sont des **proto-personas** fondés sur des observations opérationnelles et des modèles d'usage documentés dans le contexte camerounais et sous-régional. Ils ne se substituent pas à une campagne d'entretiens qualitatifs formels mais constituent la base de référence pour le cadrage ergonomique et le design d'interaction.

---

## 2. Distinction des rôles usagers dans l'écosystème B2B

* **Le Décideur / Payeur :** Le propriétaire, chef d'entreprise ou gérant. Il arbitre l'investissement, paie l'abonnement en Mobile Money et veut contrôler la santé de son activité à distance.
* **L'Utilisateur Final (Opérateur) :** Le caissier, vendeur, réceptionniste ou gestionnaire de stock. Il manipule l'outil toute la journée sous la pression des clients en file d'attente.
* **Le Client Final / Bénéficiaire :** Le client du commerce qui reçoit son reçu par WhatsApp ou SMS et juge le sérieux de l'enseigne.

---

## 3. Fiches détaillées des Personas prioritaires

### Persona 1 : Ibrahim — Le Commerçant / Chef d'Entreprise Prévoyant (Décideur & Payeur)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ PERSONA 1 : IBRAHIM (42 ans) — Propriétaire de 2 commerces (Douala/Yaoundé) │
├─────────────────────────────────────────────────────────────────────────────┤
│ "Je veux savoir exactement ce qui est entré dans mes caisses aujourd'hui,   │
│  même quand je suis en déplacement, sans dépendre de la bonne foi de mes    │
│  employés."                                                                 │
├────────────────────────────────┬────────────────────────────────────────────┤
│ CONTEXTE & HABITUDES           │ OBJECTIFS PRIORITAIRES                     │
│ • Smartphone Android récent    │ • Éliminer les couveuses et fraudes caisse │
│ • Utilise WhatsApp en continu  │ • Consulter son chiffre d'affaires en live │
│ • Paie tout en Orange/MTN MoMo │ • Gérer ses réapprovisionnements à temps   │
├────────────────────────────────┼────────────────────────────────────────────┤
│ FRUSTRATIONS MAJEURES          │ ATTENTES ENVERS LE PRODUIT                 │
│ • Les écarts de caisse en fin  │ • Dashboard mobile ultra-clair et lisible  │
│   de mois inexpliqués.         │ • Notification journalière du total caisse │
│ • Les logiciels compliqués où  │ • Abonnement simple renouvelable par MoMo  │
│   il faut une semaine de cours.│ • Support local réactif en cas de souci    │
└────────────────────────────────┴────────────────────────────────────────────┘
```

* **Déclencheur d'adoption :** Une grosse rupture de stock inattendue ou un vol de caisse majeur dans l'une de ses boutiques.
* **Critère de fidélisation :** S'il peut vérifier en 15 secondes sur son téléphone avant de dormir le bilan net de sa journée.

---

### Persona 2 : Carine — L'Opératrice de Vente / Caissière sous Pression (Utilisatrice Finale)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ PERSONA 2 : CARINE (26 ans) — Caissière & Gestionnaire d'Accueil             │
├─────────────────────────────────────────────────────────────────────────────┤
│ "Aux heures de pointe, les clients s'impatientent. Si mon écran bloque ou   │
│  si je dois faire dix clics pour sortir une facture, c'est l'enfer."        │
├────────────────────────────────┬────────────────────────────────────────────┤
│ CONTEXTE & HABITUDES           │ OBJECTIFS PRIORITAIRES                     │
│ • Très habile sur WhatsApp/    │ • Encaisser le client en moins de 30 sec   │
│   TikTok, moins sur ordinateurs│ • Ne faire aucune erreur de rendu monnaie  │
│ • Écran tactile ou PC moyen    │ • Sortir une clôture juste sans sueur      │
├────────────────────────────────┼────────────────────────────────────────────┤
│ FRUSTRATIONS MAJEURES          │ ATTENTES ENVERS LE PRODUIT                 │
│ • Les boutons trop petits ou   │ • Gros boutons tactiles pour les actions   │
│   mal placés sur l'écran.      │ • Saisie rapide au clavier ou au doigt     │
│ • La peur de bloquer la caisse │ • Confirmation visuelle rassurante         │
│   devant une file de clients.  │ • Fonctionnement fluide même en réseau lent│
└────────────────────────────────┴────────────────────────────────────────────┘
```

* **Déclencheur d'adoption :** Un outil qui lui simplifie la vie plutôt que de lui compliquer la tâche.
* **Critère ergonomique fondamental :** Zéro temps de latence au clic, boutons d'action hautement contrastés et lisibles sans hésitation.

---

## 4. Modélisation Jobs-To-Be-Done (JTBD)

### Job 1 : Clôture et transparence de caisse (Ibrahim)
* **Quand :** La journée de vente se termine et que les boutiques ferment leurs portes,
* **Je veux :** Avoir un état consolidé infalsifiable des ventes réparties entre espèces et Mobile Money,
* **Afin de :** M'endormir l'esprit tranquille en sachant exactement ce que mon entreprise a produit aujourd'hui.

### Job 2 : Encaissement rapide sans incident (Carine)
* **Quand :** Un client se présente avec trois articles pendant une coupure internet intermittente,
* **Je veux :** Valider l'opération et imprimer ou envoyer le reçu sans que le système ne m'affiche une page blanche d'erreur,
* **Afin de :** Préserver la confiance du client et maintenir le flux sans tension.

---

## 5. Parcours utilisateur de haut niveau (High-Level Journey)

```text
[1. Découverte] ──► Démonstration vidéo directe sur WhatsApp ou recommandation d'un pair.
       │
[2. Évaluation] ──► Test direct d'une version de démonstration sans friction d'inscription lourde.
       │
[3. Souscription] ─► Paiement instantané du premier mois via Orange Money ou MTN MoMo en FCFA.
       │
[4. Prise en main] ─► Assistant d'onboarding en 3 étapes : Création boutique, ajout 3 produits, premier ticket.
       │
[5. Usage quotidien]► Encaissements instantanés, alertes stock bas, notification WhatsApp au patron.
       │
[6. Rétention] ────► Rappel discret de renouvellement MoMo 3 jours avant échéance en un clic.
```

---

## 6. Accessibilité, cas limites et environnements contraignants

1. **Éclairage violent ou pénombre :** L'interface doit maintenir des contrastes très fermes (noir profond / blanc pur ou surfaces foncées non délavées) pour rester lisible dans des boutiques faiblement éclairées ou sous vitrine en plein soleil.
2. **Écrans de résolution modeste :** Conception calibrée en priorité pour des résolutions d'ordinateurs standards (1366x768) et des écrans mobiles d'entrée de gamme (375px de large).
3. **Fatigue oculaire :** Éviter les fonds d'un blanc éblouissant continu ; privilégier des gris de surface subtils et reposants.


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Marché cible et profils d'usagers
- **Périmètre géographique :** Yaounde
- **Segments d'utilisateurs :**
- B2B

- **Profils d'usage au quotidien :** Commerçant
- **Besoins vitaux et irritants :** •	Les clients doivent parcourir les conversations pour retrouver les produits.
•	Les commandes arrivent souvent sous forme de messages non structurés.
•	Le commerçant reconstitue manuellement les articles, quantités et montants.
•	Les coordonnées clients, adresses, paiements et livraisons sont dispersés.
•	Le suivi des commandes et l’historique sont difficiles à maintenir.
•	Les erreurs, oublis et pertes de temps peuvent augmenter avec le volume.
•	Le commerçant dispose de peu d’indicateurs pour piloter ses ventes.
- **Contexte opérationnel :** 4G, ordinateur, mobile, tablette, Francais
<!-- MARVENS_PROJECT_CONTEXT:END -->
