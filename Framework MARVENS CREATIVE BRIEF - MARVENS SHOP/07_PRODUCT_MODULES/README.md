# 07_PRODUCT_MODULES — Guide d'utilisation des modules produits
## MARVENS CREATIVE BRIEF V1.0

> **Document :** Architecture, indexation et règles d'utilisation des modules spécialisés  
> **Statut :** Référence méthodologique et opérationnelle active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

## 1. Finalité et place dans l'architecture Marvens

Le dossier `07_PRODUCT_MODULES/` constitue la **couche d'application spécialisée** du référentiel **MARVENS CREATIVE BRIEF V1.0**. 

Si le socle méthodologique (`00_FRAMEWORK_CORE/`) et la charte visuelle (`03_BRAND_AND_VISUAL_IDENTITY/`) posent les règles universelles de rigueur, d'accessibilité et d'élégance, ils ne peuvent appréhender de manière indifférenciée les contraintes propres à un site vitrine, un ERP industriel, une caisse tactile de point de vente ou une application mobile.

Le présent dossier adapte et concrétise les principes du framework selon la famille spécifique du produit numérique à concevoir.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    CASCADE OPÉRATIONNELLE DU FRAMEWORK                      │
│                                                                             │
│  [00_FRAMEWORK_CORE]       ──► Doctrine universelle, gouvernance, méthode.  │
│          │                                                                  │
│          ▼                                                                  │
│  [01_PRODUCT_DISCOVERY]    ──► Problème, marché, personas, modèle B2B/B2C.  │
│          │                                                                  │
│          ▼                                                                  │
│  [07_PRODUCT_MODULES]      ──► RÈGLES SPÉCIALISÉES PAR FAMILLE DE PRODUIT   │
│          │                     (Website, SaaS, ERP, POS, E-commerce, etc.)  │
│          ▼                                                                  │
│  [DESIGN EXECUTION (04/05)]──► Wireframes, UI haute fidélité, Design Tokens.│
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Matrice générale des 8 catégories couvertes

Le référentiel structure les exigences de conception autour de huit grands archétypes :

| Module | Fichier de référence | Nature dominante | Priorité fondamentale de conception |
| :--- | :--- | :--- | :--- |
| **1. WEBSITE** | [`MODULE_WEBSITE.md`](./MODULE_WEBSITE.md) | Site vitrine, institutionnel, éditorial | Compréhension d'offre, crédibilité, autorité et conversion. |
| **2. SAAS** | [`MODULE_SAAS.md`](./MODULE_SAAS.md) | Logiciel B2B/B2C accessible en ligne | Productivité, onboarding fluide, visibilité d'état et rétention. |
| **3. ERP** | [`MODULE_ERP.md`](./MODULE_ERP.md) | Système intégré de gestion d'entreprise | Densité d'information, contrôle des droits, traçabilité et flux. |
| **4. POS** | [`MODULE_POS.md`](./MODULE_POS.md) | Caisse enregistreuse et encaissement | Vitesse d'exécution tactile, zéro friction et résilience réseau. |
| **5. ECOMMERCE** | [`MODULE_ECOMMERCE.md`](./MODULE_ECOMMERCE.md) | Boutique et marketplace en ligne | Découverte catalogue, transparence tarifaire et checkout sans faille.|
| **6. CONTENT** | [`MODULE_CONTENT_PLATFORM.md`](./MODULE_CONTENT_PLATFORM.md) | Plateforme médias, formation, streaming | Confort de lecture/écoute, recherche, reprise et progression. |
| **7. PWA** | [`MODULE_PWA.md`](./MODULE_PWA.md) | Web App progressive installable | Résilience hors-ligne (*offline-first*), cache et légèreté. |
| **8. MOBILE APP** | [`MODULE_MOBILE_APP.md`](./MODULE_MOBILE_APP.md) | Application native / multiplateforme | Ergonomie tactile du pouce, conventions d'OS et réactivité. |

---

## 3. Règle de sélection et de combinaison des modules (Produits hybrides)

Dans la réalité des projets de Marvens Group, un produit n'appartient que rarement à une case étanche. La majorité des solutions modernes sont des **produits hybrides**.

### Protocole de traitement des produits hybrides :
1. **Identifier le module primaire (Cœur de valeur) :**  
   Quel est le flux d'usage quotidien principal ? (ex: pour un logiciel de pressing avec encaissement en boutique et gestion des stocks en arrière-boutique, le module primaire est **POS**, le module secondaire est **ERP/SaaS**).
2. **Identifier les modules complémentaires (Extensions d'expérience) :**  
   Associer les chapitres spécialisés nécessaires (ex: pour une boutique e-commerce installable sur smartphone sans passer par les stores, associer **ECOMMERCE + PWA**).
3. **Arbitrage explicite des contradictions de design :**  
   Si le module Website préconise de grands espaces aérés et de grands visuels tandis que le module ERP préconise une forte densité de données, l'arbitrage découle de la zone d'écran concernée :
   * *Sur la page publique de présentation :* Application des règles du module **WEBSITE**.
   * *Dans le tableau de bord de gestion :* Application des règles du module **ERP/SAAS**.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    EXEMPLES DE COMBINAISONS FRÉQUENTES                      │
├──────────────────────────┬──────────────────────┬───────────────────────────┤
│ TYPOLOGIE DE PRODUIT     │ MODULE PRIMAIRE      │ MODULES COMPLÉMENTAIRES   │
├──────────────────────────┼──────────────────────┼───────────────────────────┤
│ Gestion de Caisse & Stock│ MODULE_POS           │ MODULE_SAAS / MODULE_ERP  │
│ Boutique en ligne PWA    │ MODULE_ECOMMERCE     │ MODULE_PWA                │
│ Logiciel SaaS B2B Métier │ MODULE_SAAS          │ MODULE_ERP                │
│ Plateforme Ebook/Podcast │ MODULE_CONTENT_PLAT. │ MODULE_PWA / MODULE_ECOM. │
└──────────────────────────┴──────────────────────┴───────────────────────────┘
```

---

## 4. Gouvernance et responsabilités Humain–IA

* **L'Agent IA :**  
  * Analyse le Product Brief du projet et détermine les modules applicables.
  * Extrait les critères d'ergonomie et d'architecture propres à la catégorie.
  * Rédige les spécifications des parcours en respectant la check-list du module.
  * Alerte sur les incompatibilités matérielles, réseau ou cognitives.
* **Le Responsable Humain :**  
  * Valide la priorisation des modules retenus pour le projet.
  * Tranche les arbitrages en cas de conflit d'expérience (densité vs épuration).
  * Conserve la souveraineté sur la validation finale de la conception avant transmission aux équipes de développement.

---

## 5. Ordre recommandé de consultation

Pour aborder la conception d'un nouveau produit :
1. Lire le brief dans `01_PRODUCT_DISCOVERY/` pour comprendre la proposition de valeur.
2. Ouvrir le présent `README.md` et identifier le ou les modules applicables.
3. Étudier en détail le fichier de module concerné (`MODULE_[NOM].md`).
4. Confronter les recommandations du module avec les tokens de `03_BRAND_AND_VISUAL_IDENTITY/` pour produire les maquettes et spécifications UI/UX.


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Synthèse de cadrage pour ce volet
- **Projet :** MARVENS SHOP
- **Modules :** MODULE_ECOMMERCE, MODULE_PWA
- **Terminaux prioritaires :** desktop, tablet, mobile
- **Contexte usagers :** 4G, ordinateur, mobile, tablette, Francais
- **Précisions complémentaires :** [À DÉFINIR / À CONFIRMER]
<!-- MARVENS_PROJECT_CONTEXT:END -->
