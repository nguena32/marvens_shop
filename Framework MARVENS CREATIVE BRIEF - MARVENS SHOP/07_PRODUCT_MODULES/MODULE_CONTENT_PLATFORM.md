# MODULE_CONTENT_PLATFORM — Module Plateformes de Contenus et Médias
## MARVENS CREATIVE BRIEF V1.0 · PHASE 07_PRODUCT_MODULES

> **Catégorie :** Plateformes d'apprentissage, bibliothèques numériques, podcasts, vidéos et médias éditoriaux  
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



## 1. Typologies et nature des plateformes de contenus

Ce module s'applique aux produits dont la proposition de valeur centrale repose sur la diffusion, la consommation et la monétisation de savoirs ou de médias.

### Typologies couvertes
* **Bibliothèques d'Ebooks & Documents :** Vente et lecture en ligne de livres numériques professionnels ou spécialisés.
* **Plateformes de Formations & LMS :** Cours en ligne structurés par modules, leçons, vidéos et quiz.
* **Plateformes Audio & Podcasts :** Écoute en continu, épisodes en série, téléchargement pour écoute nomade.
* **Portails Média & Publications Éditoriales :** Articles de fond, analyses économiques, newsletters payantes.

---

## 2. Priorités fondamentales d'expérience utilisateur (UX)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    LES 4 EXIGENCES CLÉS DU DESIGN DE CONTENUS               │
├──────────────────────────┬──────────────────────────────────────────────────┤
│ 1. Confort de lecture    │ Typographie irréprochable, fond reposant,        │
│    (Reading Ergonomics)  │ interlignage aéré et absence de distraction.     │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 2. Reprise transparente  │ L'utilisateur retrouve exactement sa page, sa    │
│    (Seamless Resume)     │ seconde d'écoute ou sa leçon sur tout appareil.  │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 3. Économie de bande     │ Préchargement intelligent (*streaming adaptatif*)│
│    passante (Data Saver) │ et option de téléchargement hors ligne.          │
├──────────────────────────┼──────────────────────────────────────────────────┤
│ 4. Découverte naturelle  │ Recommandations fondées sur l'intérêt réel et    │
│    (Organic Discovery)   │ recherche puissante par thématiques et auteurs.  │
└──────────────────────────┴──────────────────────────────────────────────────┘
```

---

## 3. Architecture d'information et structuration des contenus

* **Organisation hiérarchique :**  
  `Collection / Catégorie ──► Série / Ouvrage ──► Chapitre / Épisode ──► Contenu média`.
* **Métadonnées visibles dès la vignette :**  
  Durée estimée de lecture ou d'écoute (ex: *« 8 min de lecture »* ou *« 42 min d'audio »*), niveau d'expertise, date de publication et badge *Gratuit* ou *Premium*.
* **Recherche et filtres sémantiques :**  
  Filtrage rapide par format (Texte, Audio, Vidéo), par niveau ou par auteur.

---

## 4. Expérience de consommation multimédia

### 4.1. Lecteur Ebook / Texte (Reader View)
* Largeur de colonne de texte strictement limitée (entre 600px et 700px) pour un confort visuel optimal.
* Mode lecture reposant : possibilité de basculer entre mode blanc pur, mode sépia doux (fond crème `#FDFBF7`) et mode sombre.
* Barre de progression de lecture discrète en haut d'écran indiquant le pourcentage lu.

### 4.2. Lecteur Audio / Podcast (Audio Player)
* Barre de lecture persistante en bas d'écran (*Sticky Mini-Player*) permettant de continuer à naviguer sur la plateforme tout en écoutant.
* Boutons de saut rapide (+30s / -15s) indispensables pour l'apprentissage.
* Sélecteur de vitesse d'écoute (1x, 1.25x, 1.5x).

---

## 5. Modèles d'accès, monétisation et droits

* **Modèle Freemium / Teasing de contenu :**  
  Accès libre au premier chapitre ou aux premières minutes, puis invitation élégante à souscrire (*Paywall* non agressif explicitant le prix en FCFA par Mobile Money).
* **Gestion des licences et téléchargements sécurisés :**  
  Pour les produits payants (ebooks, cours), génération d'un filigrane discret (*watermark*) avec le numéro de téléphone de l'acheteur pour décourager le piratage sans pénaliser l'expérience.

---

## 6. Livrables types pour une plateforme de contenus

1. **Maquette du flux d'exploration catalogue et fiches collections.**
2. **Spécification du lecteur de texte (Reader) et des modes de confort visuel.**
3. **Interface du lecteur audio/vidéo avec états mini-player et plein écran.**
4. **Flux de déblocage paywall avec paiement instantané par Mobile Money.**
5. **Tableau de bord de suivi de progression personnelle de l'usager.**
