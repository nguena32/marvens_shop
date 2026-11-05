# PRODUCT BRIEF — Fiche de cadrage du produit
## MARVENS CREATIVE BRIEF V1.0 · PHASE 01_PRODUCT_DISCOVERY

> **Type de document :** Fiche de cadrage produit (Product Brief)  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Date de référence :** 31 octobre 2026  
> **Entité porteuse :** Marvens Group SARL (Yaoundé, Cameroun)  
> **Doctrine :** Contextual Design · Premium Quality  

---

## 1. Informations générales

* **Nom du produit / projet :** Écosystème des Solutions Numériques & SaaS B2B Marvens Group  
  *(Appliqué au cadre de référence : Suite d'applications de gestion d'entreprise, POS, RH et portails marchands contextualisés CEMAC)*.
* **Version du brief :** V1.0.0.
* **Entité porteuse :** Marvens Group SARL `[CONFIRMÉ : Entreprise de services numériques et TIC basée à Yaoundé, Cameroun]`.
* **Responsable & Parties prenantes :** Direction Générale Marvens Group, Product Owners internes, Équipes d'ingénierie logicielle, Partenaires intégrateurs de paiement `[CONFIRMÉ]`.
* **Statut de validation :** En attente d'arbitrage officiel par le responsable de projet Marvens `[RECOMMANDATION IA]`.

---

## 2. Résumé exécutif

En Afrique francophone subsaharienne et tout particulièrement dans la zone CEMAC (Cameroun, Gabon, Congo, Tchad, RCA, Guinée Équatoriale), les TPE, PME et organisations marchandes opèrent une transition numérique accélérée. Cependant, ces entreprises se heurtent à un fossé critique : les progiciels et plateformes SaaS internationaux (conçus pour l'Occident) sont onéreux, inadaptés aux réseaux internet instables, déconnectés des modes de paiement prédominants (Mobile Money) et reposent sur des conventions administratives étrangères. À l'opposé, les solutions locales artisanales souffrent d'une ergonomie dégradée, d'une instabilité chronique et d'un manque criant de finition.

Marvens Group entend combler ce vide structurel grâce au déploiement d'une génération de produits numériques et SaaS B2B fondés sur la doctrine **Contextual Design · Premium Quality**. Ces solutions allient une direction artistique prestigieuse, une ergonomie limpide, un fonctionnement résilient hors-ligne/bas débit, et une intégration native des infrastructures locales (Mobile Money Orange / MTN, interopérabilité régionale GIMACPAY).

---

## 3. Vision produit et ambition stratégique

* **Ambition à long terme :** Devenir la référence technologique et ergonomique des solutions logicielles et SaaS B2B en Afrique centrale francophone, incarnant le standard d'excellence et de fiabilité numérique pour les organisations modernes.
* **Impact recherché :** Démocratiser l'accès aux outils de gestion et de commerce de haut standing sans obliger les entreprises locales à subir des logiciels importés mal adaptés ou des interfaces dégradées.
* **Rôle dans l'écosystème Marvens :** Agir comme le moteur de valorisation des savoir-faire de Marvens Group, transformant l'expertise de services en actifs logiciels scalables à forte marge récurrente.

---

## 4. Problème à résoudre

### 4.1. Situation actuelle constatée
* **Déconnexion financière :** Moins de 15 % des acteurs économiques locaux disposent d'une carte bancaire internationale `[CONFIRMÉ : simiz.io / BCEAO-BEAC]`, rendant les abonnements SaaS étrangers (Stripe/cartes) inaccessibles ou complexes à renouveler.
* **Vulnérabilité réseau et matérielle :** Les coupures intermittentes de bande passante et l'usage prédominant de smartphones modestes ou d'ordinateurs reconditionnés pénalisent lourdement les web apps lourdes occidentales (SPAs obèses en JavaScript).
* **Friction ergonomique :** Les outils locaux existants sont souvent des formulaires bruts sans hiérarchie visuelle, générant un taux d'erreur de saisie élevé chez les opérateurs.
* **Solutions de contournement actuelles :** Cahiers papier de caisse, registres manuels, fichiers Excel partagés sur clés USB ou groupes WhatsApp informels, avec un risque massif de perte de données et de fraude interne.

---

## 5. Objectifs du produit

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                             OBJECTIFS TRIPLES                               │
├──────────────────────────┬──────────────────────────┬───────────────────────┤
│    OBJECTIFS USAGERS     │    OBJECTIFS BUSINESS    │ OBJECTIFS OPÉRATIONNELS│
├──────────────────────────┼──────────────────────────┼───────────────────────┤
│ • Prise en main < 15 min │ • Acquisition B2B locale │ • Disponibilité 99.5% │
│ • Zéro perte sur coupure │ • Rétention MoMo > 80%   │ • Poids page < 800 Ko │
│ • Lisibilité immédiate   │ • Modèle récurrent MRR   │ • Hand-off dev fluide │
└──────────────────────────┴──────────────────────────┴───────────────────────┘
```

---

## 6. Périmètre fonctionnel

### 6.1. Capacités et fonctionnalités essentielles (Périmètre coeur)
* **Architecture Mobile-First & Responsive Desktop :** Interface adaptée du smartphone 375px au moniteur 1080p.
* **Encaissement & Souscription Hybride :** Intégration directe des passerelles Mobile Money (Orange Money, MTN Mobile Money) et cash/virement bancaire local.
* **Mode Dégradé / Résilience Réseau :** Persistance locale des formulaires et retours visuels immédiats en cas d'interruption momentanée de la connexion.
* **Tableaux de bord & Reporting Visuel Synthétique :** Visualisation des indicateurs clés sans surcharge cognitive.
* **Gestion granulaire des rôles et sécurisation des accès :** Administrateur, Gérant, Opérateur de saisie, Auditeur.

### 6.2. Éléments explicitement hors-périmètre (V1)
* Dépendance à des technologies non maîtrisées ou serveurs Node.js lourds en production (respect strict du socle d'hébergement économique et robuste cPanel/Apache/PHP 8.3/MySQL).
* Intégration d'ERP industriels complexes lourds (SAP, Oracle) dans la première version.
* Spécifications de cryptomonnaies ou monnaies décentralisées non régulées par la COBAC/BEAC.

---

## 7. Public cible et cas d'usage

| Segment d'usage | Profil utilisateur | Décideur / Payeur | Cas d'usage type |
| :--- | :--- | :--- | :--- |
| **Commerces & Points de vente** | Caissier, gérant de boutique | Propriétaire / Commerçant | Enregistrement des ventes, clôture de caisse, suivi des stocks. |
| **PME & Prestataires de services** | Responsable administratif, comptable | Directeur Général / Gérant | Facturation certifiée, relance clients, suivi de trésorerie. |
| **Équipes en mobilité / Terrain** | Agent commercial, superviseur | Responsable des opérations | Saisie d'activité sur smartphone, consultation hors bureau. |

---

## 8. Modèle économique et tarification `[HYPOTHÈSE DE TRAVAIL]`

* **Modèle envisagé :** SaaS B2B par abonnement récurrent mensuel ou annuel, combiné à des frais de déploiement/configuration initiale optionnels.
* **Modalités de paiement :** Prélèvement ou réabonnement par Mobile Money (Orange/MTN) et facturation entreprise par virement/chèque.
* **Niveaux d'abonnements indicatifs à tester :**
  * *Formule Starter (Solo / Micro-commerce) :* 10 000 à 15 000 FCFA / mois.
  * *Formule Pro (PME multisite / multi-utilisateurs) :* 25 000 à 50 000 FCFA / mois.
  * *Formule Entreprise (Sur-mesure / Volume) :* Devis spécifique annuel.

> **Avertissement :** Ces montants constituent des hypothèses de travail destinées au calibrage des parcours UX et ne représentent pas des grilles commerciales définitives.

---

## 9. Contraintes et exigences d'environnement

* **Contraintes technologiques :** Compatibilité avec l'architecture d'hébergement validée (PHP 8.3 Vanilla MVC, MySQL 8, Bootstrap 5, Vanilla JS, hébergement cPanel). Absence de frameworks JS lourds côté client afin de garantir un affichage instantané même en 3G.
* **Accessibilité et lisibilité :** Respect des ratios de contraste WCAG AA, prise en compte des écrans à faible luminosité ou utilisés en extérieur.
* **Sécurité & Confidentialité :** Chiffrement des données sensibles, journalisation des transactions, séparation stricte des flux multi-tenants.

---

## 10. Indicateurs clés de succès (KPIs)

1. **Taux d'achèvement des tâches clés (Task Completion Rate) :** > 95 % sans assistance lors des tests utilisateurs.
2. **Temps moyen de complétion d'un flux opérationnel :** Réduction de 40 % par rapport aux solutions manuelles ou concurrentes.
3. **Taux de conversion au renouvellement d'abonnement MoMo :** > 75 % dès le 2e mois d'exploitation.
4. **Indice de satisfaction ergonomique (CSAT / SUS) :** Score System Usability Scale supérieur à 80/100.

---

## 11. Risques identifiés et validations attendues

* **Risque 1 : Instabilité des API de paiement locales.**  
  *Mitigation :* Concevoir des états d'attente asynchrones élégants et des mécanismes de vérification différée des transactions.
* **Risque 2 : Résistance au changement face aux habitudes informelles (papier).**  
  *Mitigation :* Interfaces épurées reproduisant la simplicité d'un carnet de caisse tout en automatisant les calculs.
* **Décision attendue du responsable humain :** Valider formellement la priorisation du premier produit de la suite à lancer en Phase 02 (Art Direction).


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Cadrage d'affaires et vision produit
- **Nom officiel :** MARVENS SHOP
- **Marque associée :** MARVENS SHOP
- **Slogan :** Transformez votre WhatsApp Business en une véritable boutique en ligne, avec catalogue, commandes organisées et suivi commercial.
- **Porteur / Organisation :** Marvens Group and Services SARL
- **Description d'ensemble :** Marvens Shop est une solution de mini-site e-commerce et de gestion des commandes destinée aux commerçants, entrepreneurs et petites entreprises, particulièrement en Afrique francophone. Elle permet au commerçant de présenter ses produits dans une boutique web personnalisée, de recevoir des commandes complètes et structurées, puis de communiquer avec ses clients via WhatsApp Business.
La première version ne sera pas un SaaS ouvert au public. Marvens développera un script applicatif MVP, puis installera et configurera une instance dédiée sur le nom de domaine du client. Marvens prendra en charge le déploiement en ligne, la configuration initiale, la formation et la maintenance. Cette approche permet de tester la solution auprès de vrais commerçants, de valider les usages et la valeur commerciale, puis de décider sur des données réelles du passage à une plateforme SaaS permettant aux commerçants de créer eux-mêmes leur compte.
Le principe fondamental est le suivant : le mini-site présente les produits et organise la commande ; le tableau de bord centralise les commandes et leur suivi ; WhatsApp facilite les échanges, la confirmation commerciale et la fidélisation. Dans le MVP, le paiement reste séparé et peut être confirmé manuellement.
- **Problème résolu :** •	Les clients doivent parcourir les conversations pour retrouver les produits.
•	Les commandes arrivent souvent sous forme de messages non structurés.
•	Le commerçant reconstitue manuellement les articles, quantités et montants.
•	Les coordonnées clients, adresses, paiements et livraisons sont dispersés.
•	Le suivi des commandes et l’historique sont difficiles à maintenir.
•	Les erreurs, oublis et pertes de temps peuvent augmenter avec le volume.
•	Le commerçant dispose de peu d’indicateurs pour piloter ses ventes.
- **Solution envisagée :** Marvens Shop ne doit pas être présenté comme un simple créateur de sites web. Sa valeur est la réduction du travail nécessaire pour transformer une demande en commande exploitable : catalogue accessible, panier structuré, commande enregistrée, suivi commercial et conversation WhatsApp.
Promesse commerciale : « Transformez votre WhatsApp Business en une véritable boutique en ligne, avec catalogue, commandes organisées et suivi commercial. »
- **Objectifs clés :**
- 1.	Créer une boutique en ligne personnalisée pour chaque client installé
- 2.	Améliorer la présentation et la découverte des produits
- 3.	Recevoir des commandes complètes et structurées.
- 5.	Centraliser les informations clients, commandes, paiements et livraisons.
- 4.	Réduire le traitement manuel et les erreurs de commande.

- **Critères de succès :** Marvens Shop MVP est une solution de social commerce installée individuellement chez chaque commerçant. Elle associe un mini-site mobile-first, un catalogue, un panier, l’enregistrement de commandes, un tableau de bord et WhatsApp Business. L’intégration Meta permet, lorsque les autorisations et données disponibles le permettent, d’importer et de synchroniser le catalogue du commerçant.
Marvens assure le déploiement, la configuration, la formation et la maintenance. Le choix de ne pas démarrer immédiatement en SaaS limite la complexité initiale et permet de tester la solution dans des conditions réelles. La future plateforme SaaS ne sera envisagée qu’après validation de la demande, du fonctionnement, des coûts et des besoins récurrents observés chez les premiers clients.
Principe directeur : le mini-site présente et structure les commandes ; WhatsApp facilite la communication et la confirmation ; le tableau de bord centralise le suivi ; le paiement reste séparé dans le MVP ; la sécurité, la formation et la maintenance sont intégrées au service fourni par Marvens.
<!-- MARVENS_PROJECT_CONTEXT:END -->
