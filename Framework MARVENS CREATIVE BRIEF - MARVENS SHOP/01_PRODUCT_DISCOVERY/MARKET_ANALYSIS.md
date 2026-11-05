# MARKET ANALYSIS — Analyse du marché
## MARVENS CREATIVE BRIEF V1.0 · PHASE 01_PRODUCT_DISCOVERY

> **Type de document :** Étude de marché contextuelle et dimensionnement  
> **Statut :** Analyse documentaire et Recommandations IA — Soumis à validation  
> **Date de référence :** 31 octobre 2026  
> **Périmètre géographique primaire :** Cameroun (Douala, Yaoundé, métropoles régionales)  
> **Périmètre d'expansion secondaire :** Zone CEMAC (Gabon, Congo, Tchad, RCA, Guinée Équatoriale)  

---

## 1. Définition et frontières du marché

* **Catégorie de marché :** Logiciels de gestion d'entreprise B2B (SaaS), systèmes d'encaissement et de point de vente (POS), et outils numériques d'opérations pour TPE/PME.
* **Périmètre d'étude :** Entreprises formelles et secteur informel structuré du commerce, des services et de l'artisanat dans les zones urbaines majeures camerounaises.
* **Horizon temporel :** 2025 – 2028.

---

## 2. Dynamiques sectorielles et données de marché vérifiées

### 2.1. L'infrastructure Mobile Money comme moteur absolu
Le Cameroun constitue le cœur financier numérique de l'Afrique centrale :
* **Poids régional :** Le Cameroun concentre plus de **60 % à 65 % des volumes de transactions de paiement mobile de toute la zone CEMAC** `[CONFIRMÉ : Rapports BEAC / simiz.io / Banque Mondiale]`.
* **Volumes en circulation :** Plus de **5 000 à 5 800 milliards de FCFA** de flux financiers annuels transitent par les réseaux mobiles `[CONFIRMÉ]`.
* **Base d'utilisateurs :** Entre **13,2 et 15 millions de comptes actifs** pour un taux de pénétration d'environ 54 % de la population totale `[CONFIRMÉ : ART / GSMA]`.
* **Duopole de référence :** Le marché est dominé par **Orange Money** (~52 % de parts de marché) et **MTN Mobile Money (MoMo)** (~45 %) `[CONFIRMÉ : Mordor Intelligence / Team France Export]`.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                   PAYSAGE DU PAIEMENT NUMÉRIQUE AU CAMEROUN                 │
│                                                                             │
│   Cartes Bancaires Internationales : [██░░░░░░░░] < 15 % de pénétration    │
│   Comptes Mobile Money Actifs      : [███████████] > 54 % de la population   │
│                                                                             │
│   RÉALITÉ SAAS B2B : UN PARCOURS DE PAIEMENT SANS MOBILE MONEY EST VOTÉ À   │
│                      UN TAUX D'ÉCHEC DE CONVERSION SUPÉRIEUR À 80%.         │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 3. Segmentation de la demande B2B

1. **Segment A — Micro-commerces & Boutiques de détail (Volume élevé / Panier modéré) :**
   * *Acteurs :* Prêt-à-porter, alimentation spécialisée, pressing, cosmétique, quincaillerie de quartier.
   * *Besoin :* Suivi des encaissements en caisse, contrôle des stocks contre le vol, édition de tickets de vente, clôture journalière.
   * *Capacité de paiement :* 5 000 à 15 000 FCFA / mois.
2. **Segment B — PME de services & Sociétés établies (Panier moyen / Forte fidélité) :**
   * *Acteurs :* Cabinets d'expertise, agences de transport/sécurité, prestataires logistiques, cliniques, PME B2B.
   * *Besoin :* Gestion RH/paie simplifiée, facturation conforme OHADA, CRM relation client, suivi des créances.
   * *Capacité de paiement :* 25 000 à 75 000 FCFA / mois.
3. **Segment C — Grandes entreprises & Réseaux de franchises :**
   * *Besoin :* Déploiements sur-mesure, intégrations API comptables complexes.

---

## 4. Estimation du potentiel de marché (TAM · SAM · SOM) `[ESTIMATION MODÉLISÉE]`

Pour le premier produit SaaS B2B Marvens au Cameroun :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                            DIMENSIONNEMENT DE MARCHÉ                        │
│                                                                             │
│   TAM (Total Addressable Market) : ~ 300 000 entreprises & commerces        │
│   (Totalité des entités économiques recensées par l'INS Cameroun - RGE)     │
│                                │                                            │
│                                ▼                                            │
│   SAM (Serviceable Addressable Market) : ~ 60 000 PME / commerces           │
│   (Établissements urbains à Douala/Yaoundé équipés de terminaux numériques) │
│                                │                                            │
│                                ▼                                            │
│   SOM (Serviceable Obtainable Market - Objectif 24 mois) : 600 à 1 200 PME  │
│   (Part de marché réaliste de 1 à 2 % du SAM pour l'offre initiale Marvens) │
└─────────────────────────────────────────────────────────────────────────────┘
```

* **Potentiel de revenus estimé (SOM moyen à 25 000 FCFA/mois) :**
  * 800 clients actifs $\times$ 25 000 FCFA $\times$ 12 mois = **240 000 000 FCFA d'ARR (Annual Recurring Revenue)** `[HYPOTHÈSE DE TRAVAIL CHIFFRÉE]`.

---

## 5. Analyse PESTEL contextuelle

* **Politique :** Volonté gouvernementale de numérisation de l'économie et de formalisation fiscale des transactions commerciales.
* **Économique :** Pression sur les marges des PME ; recherche d'outils abordables générant un ROI immédiat en éliminant les pertes de caisse.
* **Socioculturel :** Culture orale et visuelle forte ; méfiance envers les systèmes opaques ; importance primordiale de la preuve sociale et du bouche-à-oreille local.
* **Technologique :** Pénétration massive du smartphone Android ; connectivité mobile 4G en ville avec micro-coupures fréquentes ; parc d'ordinateurs souvent vieillissants.
* **Environnemental :** Climat tropical chaud et humide ; coupures de courant périodiques exigeant que les terminaux mobiles puissent fonctionner sur batterie.
* **Légal / Réglementaire :** Exigences de conformité OHADA pour la facturation et tenue de comptes ; réglementations BEAC sur la monnaie électronique.

---

## 6. Opportunités et menaces majeures

### Opportunités
* **Faible pénétration des SaaS modernes :** La majorité des commerces utilise encore des cahiers papier ou des logiciels Windows 98/XP piratés non maintenus.
* **Familiarité totale avec le Mobile Money :** Tous les gérants et clients manipulent quotidiennement Orange Money ou MTN MoMo.
* **Désir de valorisation de marque :** Les gérants de PME veulent offrir une image moderne à leurs clients (factures nettes, reçus SMS/WhatsApp).

### Menaces
* **Attachement aux habitudes informelles :** Crainte injustifiée que la numérisation n'expose excessivement les activités aux services fiscaux.
* **Variabilité de la qualité de réseau télécom :** Déconnexions temporaires pouvant bloquer un commerce si le logiciel est mal architecturé.

---

## 7. Implications directes pour la conception du produit

1. **Architecture ultra-légère :** Pages légères, aucun script superflu, affichage prioritaire des données critiques.
2. **Intégration d'un mode dégradé :** Gestion locale des formulaires avec reprise automatique dès le retour du réseau.
3. **Double affichage monétaire explicite :** Affichage clair en FCFA / XAF sans ambiguïté de conversion.
4. **Export direct WhatsApp :** Possibilité d'envoyer un reçu ou une facture directement via WhatsApp (canal de communication B2B n°1 en Afrique centrale).


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
