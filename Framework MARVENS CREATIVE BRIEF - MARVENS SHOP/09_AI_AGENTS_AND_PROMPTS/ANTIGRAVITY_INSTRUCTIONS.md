# ANTIGRAVITY INSTRUCTIONS — Instructions d'Exécution dans Antigravity
## MARVENS CREATIVE BRIEF V1.0

> **Emplacement :** `09_AI_AGENTS_AND_PROMPTS/ANTIGRAVITY_INSTRUCTIONS.md`  
> **Version :** V1.0  
> **Date de mise à jour :** 2026-10-31  
> **Statut :** Instruction opérationnelle active `[GUIDE DU WORKSPACE]`  
> **Philosophie :** *Contextual Design · Premium Quality*  
> **Documents associés :** [MASTER_PROMPT.md](MASTER_PROMPT.md) · [GOVERNANCE.md](../00_FRAMEWORK_CORE/GOVERNANCE.md)

---

## 1. Principes Opérationnels dans le Workspace Antigravity

Travailler dans l'environnement agentique Antigravity exige une rigueur méthodique d'exécution :
1. **Inspecter avant d'agir :** Ne jamais présupposer de l'existence, de l'emplacement ou du contenu d'un fichier. Toujours inspecter l'arborescence réelle du workspace avant toute opération d'écriture.
2. **Ne jamais détruire sans lire :** Interdiction d'écraser un document existant sans en avoir préalablement lu et assimilé le contenu pour préserver les décisions historiques déjà consignées.
3. **Conserver le périmètre strict :** Ne créer aucun fichier hors du dossier assigné par la consigne de travail. Ne pas anticiper spontanément les phases ultérieures.
4. **Agir réellement :** Ne pas se contenter de promettre des plans ou de produire des squelettes de sommaires vides. Chaque document doit contenir des spécifications réelles, exhaustives et exploitables.

---

## 2. Protocole de Consultation Progressive des Ressources

Avant d'engager une rédaction, l'agent Antigravity doit exécuter la séquence de lecture documentaire ordonnée suivante :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                     PROTOCOLE DE LECTURE EN 5 NIVEAUX                       │
├──────────────────────────────────────┬──────────────────────────────────────┤
│ NIVEAU 1 : Le Prompt de Mission      │ Lire intégralement le fichier prompt │
│                                      │ pour isoler le cahier des charges.   │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ NIVEAU 2 : Le Framework Core         │ Examiner `00_FRAMEWORK_CORE/`        │
│                                      │ (Gouvernance, Philosophie, Process). │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ NIVEAU 3 : Les Données Amont         │ Consulter `01_PRODUCT_DISCOVERY/`    │
│                                      │ (Brief, Personas, Marché).           │
├──────────────────────────────────────┼──────────────────────────────────────┤
│ NIVEAU 4 : Les Référentiels Visuels  │ Consulter `02_ART_DIRECTION/`,       │
│            et Ergonomiques           │ `04_UX_DESIGN/` et `06_DESIGN_SYSTEM/│
├──────────────────────────────────────┼──────────────────────────────────────┤
│ NIVEAU 5 : L'Arborescence Cible      │ Inspecter le dossier de destination  │
│                                      │ pour vérifier les fichiers existants.│
└──────────────────────────────────────┴──────────────────────────────────────┘
```

---

## 3. Gestion des Fichiers et Conventions d'Écriture

* **Format Universel :** Tous les documents sont rédigés en Markdown (`.md`) standard, valide et rigoureusement structuré.
* **Typographie des Titres :** Titre H1 unique en en-tête de document, suivi de sections H2 (`##`), sous-sections H3 (`###`) et H4 (`####`).
* **Liens Relatifs Vérifiés :** Tout renvoi vers un autre document du framework doit utiliser un lien Markdown relatif valide (ex. `[UX_PRINCIPLES.md](../04_UX_DESIGN/UX_PRINCIPLES.md)`).
* **Namespace et Identifiants :** Respecter scrupuleusement les préfixes du projet (`--mrv-*` pour les tokens, `.mrv-*` pour les classes CSS, `[ID-*]` pour les parcours et exigences).
* **Zéro Fichier Temporaire Polluant :** Ne pas laisser de fichiers de brouillon (`temp.txt`, `draft.md`) dans les dossiers du framework.

---

## 4. Règles de Décomposition et d'Exécution des Missions

Pour mener à bien une mission complexe sans saturation ni oubli :

```
[ Analyse des Exigences du Prompt ] ──► [ Matrice de Contrôle Interne ]
                                                    │
                                                    ▼
[ Relecture Croisée & Liens Relatifs ] ◄── [ Rédaction Complète Fichier par Fichier ]
                 │
                 ▼
[ Contrôle Qualité Final (Checklist) ] ──► [ Compte Rendu d'Exécution Exhaustif ]
```

1. **Découpage séquentiel :** Traiter les fichiers du livrable les uns après les autres de façon approfondie plutôt que de générer des ébauches simultanées.
2. **Gestion des blocages :** Si une ressource requise est absente, consigner l'absence dans le rapport, adopter une hypothèse de travail prudente documentée et poursuivre la mission sans se paralyser.
3. **Vérité de l'avancement :** Ne jamais annoncer une tâche comme terminée dans la réponse sans que le fichier n'ait été réellement écrit et vérifié sur le système de fichiers.

---

## 5. Protection du Périmètre Technique et Applicatif

* **Pas de Code de Production Inopiné :** Sauf consigne explicite contraire, les missions de design sont documentaires et méthodologiques. Ne pas générer de code applicatif PHP ou de tables SQL prématurément.
* **Respect de la Stack Technique Réelle :** Si des exemples techniques ou des classes CSS doivent être fournis, respecter scrupuleusement les contraintes validées (PHP 8.3 Vanilla MVC, CSS3 natif, Vanilla JS, Bootstrap 5, aucun bundler ni node.js en production).
* **Zéro Dépendance Fantôme :** Ne jamais introduire de packages npm, de compilateurs Sass ou d'outils tiers non validés formellement par le responsable humain.

---

## 6. Grille de Recette et d'Auto-Évaluation Avant Clôture

Avant de déclarer une tâche exécutée, l'agent Antigravity applique la checklist de contrôle suivante :

```markdown
### Grille de Recette de l'Agent Antigravity
- [ ] Le dossier cible a été créé au chemin exact prescrit par la consigne.
- [ ] Tous les fichiers exigés par le prompt sont présents avec leurs noms exacts.
- [ ] Chaque fichier contient un développement exhaustif (aucun squelette ni placeholder).
- [ ] Les liens relatifs Markdown entre documents sont cohérents et vérifiés.
- [ ] Les décisions du responsable humain et du Framework Core sont scrupuleusement respectées.
- [ ] Les hypothèses formulées sont explicitement qualifiées comme telles.
- [ ] Aucun fichier hors périmètre n'a été créé ou altéré.
- [ ] Le compte rendu final répond point par point au canevas imposé par le prompt.
```
