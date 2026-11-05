# MODULE_MOBILE_APP — Module Applications Mobiles (Natives & Hybrides)
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Applications mobiles natives et multiplateformes (iOS & Android)  
> **Statut :** Spécification de référence active  
> **Doctrine :** Contextual Design · Premium Quality  
> **Date de mise à jour :** 31 octobre 2026  
> **Version :** 1.0.0  

---

<!-- MARVENS_PROJECT_CONTEXT:START -->
> [!IMPORTANT]
> **STATUT PROJET DE CE MODULE :** `NON_APPLICABLE`  
> **Projet :** MARVENS SHOP  
> **Évaluation :** ⚪ NON APPLICABLE (Consulter pour référence méthodologique)

---
<!-- MARVENS_PROJECT_CONTEXT:END -->



## 1. Typologies et nature des applications mobiles

Le module Mobile App s'applique aux projets exigeant une présence dédiée sur smartphone via les boutiques d'applications (Google Play Store, Apple App Store) ou distribuées en format APK pour des flottes d'entreprises.

### Typologies couvertes
* **Application Mobile Native & Multiplateforme :** Conçue avec des frameworks mobiles adaptés (Flutter, React Native ou natif Kotlin/Swift).
* **Application Compagnon Terrain :** Outil mobile synchronisé avec un ERP ou SaaS web (ex: application livreur, agent commercial en tournée, scanner d'inventaire).
* **Application Grand Public :** Services transactionnels B2C à forte fidélité (banque mobile, micro-crédit, fidélité client).

---

## 2. Priorités fondamentales d'expérience utilisateur (UX)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 4 COMMANDEMENTS DU DESIGN MOBILE                     │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Ergonomie du pouce    │ Les actions vitales se situent dans la "Thumb    │
│    (Thumb Zone Friendly) │ Zone" naturelle (tiers inférieur de l'écran).    │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Cibles tactiles       │ Aucune zone interactive en-deçà de 44x44px       │
│    (Touch Targets)       │ (recommandation iOS) ou 48x48px (Android Material│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Gestion d'interruption│ L'application mémorise instantanément l'état en  │
│    (State Persistence)   │ cas d'appel téléphonique entrant ou bascule d'app│
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Respect des codes d'OS│ Respect des gestes natifs (balayage retour,      │
│    (Platform Conventions)│ barre d'onglets basse vs menu burger).           │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Architecture spatiale et navigation mobile

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    ANATOMIE D'UN ÉCRAN MOBILE STANDARD                      │
│                                                                             │
│  [STATUS BAR (Système)] ──► Heure, batterie, signal réseau (Non masquée).   │
│  [APP BAR / HEADER] ──────► Titre de page centré ou gauche + Action retour. │
│                                                                             │
│  [ZONE DE CONTENU] ───────► Cartes déroulantes, formulaires, listes.        │
│    (Défilement fluide)                                                      │
│                                                                             │
│  [ZONE DU POUCE (CRITIQUE)]► BOUTON D'ACTION FLOTTANT (FAB) OU CTA FIXE     │
│                              Exemple : [ ENCAISSER LE CLIENT (64px) ]       │
│                                                                             │
│  [BOTTOM NAVIGATION BAR] ─► 3 à 5 onglets maximum avec icônes + libellés :  │
│                              [ Accueil ] [ Ventes ] [ Stock ] [ Profil ]    │
│  [HOME INDICATOR] ────────► Marge de sécurité basse (Safe Area Insets).     │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Gestion des gestes tactiles et retours haptiques

1. **Gestes naturels :**  
   * *Balayage horizontal (Swipe) :* Pour archiver une ligne ou changer d'onglet.
   * *Tirer pour actualiser (Pull-to-refresh) :* Actualisation discrète avec indicateur rotatif de taille réduite.
2. **Retour haptique subtil (Haptic Feedback) :**  
   Vibration microscopique confirmant une action réussie (ex: bip haptique lors d'un scan code-barre ou d'un encaissement validé). Proscrire les vibrations longues et bruyantes.

---

## 5. Gestion des permissions et de la batterie

* **Justification contextuelle des permissions :**  
  Ne jamais demander l'accès à la caméra, à la géolocalisation ou aux contacts dès le lancement de l'application. Demander la permission **au moment précis où l'usager clique sur une action qui l'exige** (ex: clic sur « Scanner un code-barre » $\rightarrow$ affichage d'un dialogue expliquant la raison avant l'invite système).
* **Sobriété énergétique :**  
  Optimiser la fréquence des requêtes GPS et synchronisations réseau pour éviter la surchauffe des smartphones d'entrée de gamme et l'épuisement prématuré de la batterie.

---

## 6. Livrables types pour un module Mobile App

1. **Arborescence mobile et cartographie de la barre d'onglets basse.**
2. **Maquettes détaillées sous les résolutions de référence (iPhone 375x812px / Android 360x800px).**
3. **Spécification des Safe Areas (encoche supérieure et barre d'accueil basse).**
4. **Protocole de demande des permissions système (caméra, notifications, localisation).**
5. **Inventaire des micro-interactions et retours haptiques.**
