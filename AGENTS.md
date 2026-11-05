# AGENTS.md — Marvens Shop

> Instructions permanentes pour les agents IA et développeurs intervenant sur Marvens Shop.  
> Version initiale : 05 novembre 2026.  
> Statut : synthèse opérationnelle des sources du projet ; les décisions « À valider » restent ouvertes.

## 1. Identité et objectif du projet

Marvens Shop est une solution e-commerce destinée aux commerçants qui souhaitent disposer d'une boutique web professionnelle, personnalisée et reliée à leur activité commerciale. Le MVP fournit un mini-site public, un catalogue, un panier, un parcours de commande, l'enregistrement des commandes, la préparation d'un message WhatsApp et un tableau de bord permettant au commerçant de suivre et traiter les commandes.

La proposition de valeur est de permettre au commerçant de vendre en ligne sans devoir construire lui-même une infrastructure complexe : Marvens installe et configure le script sur le domaine ou sous-domaine du client. Le parcours central est **Catalogue → Panier → Commande enregistrée → WhatsApp → Suivi dashboard**.

Le modèle MVP confirmé est une **installation indépendante par commerçant**, avec sa propre configuration et sa base de données. Marvens Shop n'est pas un SaaS dans cette version : pas d'inscription autonome, de provisioning multi-tenant, de base partagée ni de facturation SaaS.

Utilisateurs principaux : visiteur/acheteur, commerçant administrateur et, si validé, personnel avec permissions limitées. Le modèle économique envisagé est l'installation et la configuration de la solution par Marvens ; les modalités commerciales exactes ne sont pas une règle de développement à inventer.

## 2. Sources de référence

### Sources faisant autorité

1. `Marvens_Shop_Document_Complet_MVP.docx` — vision, parcours, périmètre et modèle d'installation.
2. `CAHIER_DES_CHARGES_FONCTIONNEL_TECHNIQUE.md` — périmètre fonctionnel, rôles, règles métier, critères, sécurité et exigences non fonctionnelles.
3. `FONCTIONNALITÉS.docx` — fonctionnalités publiques, dashboard, thèmes et paramètres.
4. `Paramètres.docx` — configuration de la boutique, apparence, livraison, utilisateurs, intégrations et sécurité.
5. `ARCHITECTURE_TECHNIQUE_PROJET.md` — architecture de référence, modules, routes, données, sécurité, stockage, cron, déploiement et tests.
6. `PLAN_REALISATION_APPLICATION.md` — phases, étapes, dépendances, agents et gates de validation.
7. ZIP `MARVENS_CREATIVE_BRIEF_MARVENS_SHOP_20261104_151943.zip` — cadre UX/UI, direction artistique, design system, responsive, accessibilité, performance et standards de code.
8. `themes/` — templates Stitch à inventorier et intégrer uniquement s'ils existent et sont compatibles.
9. `AGENTS.md` locaux — instructions de ce fichier et instructions spécifiques des sous-dossiers.

### Règle de consultation économique

- Lire d'abord ce fichier, puis identifier la phase/étape et les fichiers directement concernés.
- Ne relire que les sections utiles des sources, pas l'ensemble des documents à chaque tâche.
- Pour une règle métier, consulter le cahier des charges et la section correspondante de l'architecture.
- Pour un choix technique, consulter l'architecture et les standards PHP/Frontend du Creative Brief.
- Pour une maquette ou un composant, consulter les fichiers UX/UI et le thème réellement concerné.
- Pour une tâche de test, consulter le plan, les critères d'acceptation et les standards QA.
- Respecter les `AGENTS.md` locaux ; en cas de conflit, signaler le conflit et appliquer la priorité de la section 3.

### Priorité des sources en cas de contradiction

1. Décision explicitement validée par le porteur du projet.
2. Cahier des charges fonctionnel et technique.
3. Règles métier et critères d'acceptation.
4. Architecture technique.
5. Plan de réalisation.
6. Charte graphique et maquettes.
7. Conventions existantes du dépôt.
8. Recommandation technique de l'agent.

Une mention **À valider** reste une question ouverte. Ne la convertis jamais en décision sans validation explicite.

## 3. Règles métier non négociables

Les règles ci-dessous sont les invariants du MVP. Le cahier des charges reste la référence pour les identifiants détaillés et les critères associés.

| ID | Règle critique | Application serveur / interdiction | Acceptation |
|---|---|---|---|
| MS-BIZ-01 | Une installation indépendante par commerçant au MVP. | Configuration et DB dédiées ; ne pas introduire un tenant resolver ou `tenant_id` universel. | Installation et données d'un commerce ne dépendent pas d'une autre installation. |
| MS-BIZ-02 | Seuls les produits publiés et disponibles selon les règles activées sont proposés à l'achat. | Revalider produit, publication, variante et disponibilité au checkout ; ne pas faire confiance au panier client. | URL directe et checkout refusent les produits non achetables. |
| MS-BIZ-03 | Prix, quantités, promotions et total sont calculés/validés côté serveur. | Le client ne fournit jamais le prix final autoritaire ; recalculer sous contrôle serveur. | Manipuler le POST ne change pas le total accepté. |
| MS-BIZ-04 | Une commande est persistée avant l'ouverture de WhatsApp. | Transaction et commit avant génération du lien externe. | La commande reste consultable même si WhatsApp ne s'ouvre pas. |
| MS-BIZ-05 | Ouvrir WhatsApp ne prouve ni envoi, ni confirmation, ni paiement. | Ne pas changer automatiquement les statuts sur le seul clic/lien. | État de commande et paiement restent distincts. |
| MS-BIZ-06 | Les statuts de commande suivent une transition autorisée et sont historisés. | Service métier serveur ; refuser transitions non prévues. | Chaque transition acceptée/refusée est testée. |
| MS-BIZ-07 | Changer de thème ne modifie pas les données commerciales. | Thèmes whitelisted et couche présentation séparée. | Produits, catégories, images, commandes, clients et paramètres restent intacts. |
| MS-BIZ-08 | Le paiement en ligne est hors MVP. | Ne pas créer de gateway ni prétendre qu'un paiement est reçu. | Le suivi manuel/configuré reste séparé du statut commande. |
| MS-BIZ-09 | Toute importation est validée et rapportée ; les doublons doivent être maîtrisés. | Valider ligne, format, mapping et idempotence côté serveur. | Rapport d'erreurs, aperçu/confirmation selon parcours, pas de doublons non maîtrisés. |
| MS-BIZ-10 | Les intégrations externes ne doivent pas rendre la boutique existante indisponible. | Timeout, erreurs neutralisées, fallback et reprise contrôlée. | Erreur Meta/WhatsApp/import n'efface ni commande ni catalogue existant. |

- Toute règle métier est appliquée côté serveur, jamais uniquement dans l'interface.
- Le client, les champs cachés, le JavaScript, les paramètres d'URL et les données importées sont non fiables.
- Le statut exact, les transitions, les modes de livraison/paiement activés et les règles de stock non confirmées doivent être vérifiés dans les sources ; ne pas inventer.
- Les références `MS-BIZ-*` sont des identifiants de synthèse de ce fichier, pas des identifiants officiels du cahier des charges. Préserver et citer les IDs officiels lorsqu'ils existent dans les documents.

## 4. Utilisateurs, rôles et autorisations

### Rôles documentés

- **Visiteur / acheteur invité** : consulter la boutique, le catalogue et les pages publiques ; préparer panier et commande selon le parcours validé. Aucun compte client n'est confirmé comme obligatoire.
- **`merchant_admin`** : rôle MVP documenté ; accès complet à l'installation selon permissions : dashboard, catalogue, commandes, paramètres, thèmes et imports activés.
- **`staff`** : rôle éventuel **À valider**. Ne pas le créer tant que les permissions précises ne sont pas décidées.
- **`marvens_support`** : accès support éventuel **À valider** ; aucun accès implicite à toutes les installations. Toute session support doit être temporaire, autorisée et auditée si ce rôle est approuvé.

Les catégories de personnel mentionnées dans les fonctionnalités (responsable commercial, gestionnaire de stock, comptable, préparateur, support client, marketing) ne constituent pas automatiquement des rôles applicatifs actifs. Leur activation et matrice détaillée restent à valider.

### Contrôle d'accès obligatoire

- Vérifier côté serveur, sur chaque action protégée : authentification, permission, ressource, action et contexte de l'installation.
- Utiliser une Policy ou un mécanisme équivalent ; ne pas se limiter à masquer les boutons.
- Protéger chaque route, API, téléchargement, modification de statut et opération d'import.
- Refuser l'accès aux ressources non autorisées ; utiliser `404` pour masquer une ressource inexistante ou hors périmètre lorsque le contrat le prévoit.
- Journaliser les changements sensibles sans données secrètes.
- Pour le MVP single-installation, le périmètre est la boutique/installation courante ; **ne pas implémenter artificiellement RBAC multi-tenant**.
- Si une évolution SaaS est validée ultérieurement, définir avant son code tenant resolver, scopes, rôles, permissions, isolation DB/files/cache/logs/jobs et tests croisés.

## 5. Périmètre fonctionnel et priorités

Classer les fonctions selon le cahier des charges et le plan. Ne pas déplacer une fonction de catégorie sans décision validée.

### MVP obligatoire / cœur du parcours

- Installation/configuration individuelle de la boutique par Marvens.
- Mini-site public : accueil, catalogue, catégories, fiche produit et pages pratiques confirmées.
- Gestion de catalogue et catégories : création, modification, publication, visibilité et images selon le périmètre.
- Panier, validation de commande, validation serveur et numéro unique.
- Persistance de la commande avant WhatsApp ; message prérempli avec informations utiles.
- Dashboard et gestion des commandes : liste, détail, recherche/filtre et statuts autorisés.
- Paramètres essentiels de boutique et numéro WhatsApp.
- Thème actif et rendu responsive, avec préservation des données.
- Authentification administrateur, sessions, permissions et protections serveur.
- Sécurité, migrations, tests et procédure de déploiement cPanel.

### MVP conditionnel / dépendant d'une validation ou d'un accès

- Import CSV ; import Excel/XLSX selon bibliothèque et extensions cPanel.
- Import Meta Catalog via OAuth/Graph API : seulement après vérification de l'app, des scopes, des permissions et de l'accès réel au catalogue.
- Variantes, tailles, couleurs et stock : implémenter selon inclusion confirmée au MVP.
- Bibliothèque de thèmes Stitch : inventaire réel de `themes/`, vérification d'intégrité et conformité avant activation.
- Prévisualisation, personnalisation des couleurs/polices et reset : selon maquettes validées et fichiers de thème présents.
- Notifications e-mail/WhatsApp automatisées, Analytics, Pixel, Search Console, GTM, Conversions API : ne pas activer sans décision, credentials et critères.
- PWA/service worker : stratégie exacte d'installation, cache et offline **À valider** ; ne pas mettre en cache pages admin, checkout, commandes ou données sensibles.

### Version ultérieure / hors MVP confirmé

- SaaS multi-tenant, inscription autonome, provisioning, facturation SaaS.
- Paiement en ligne / passerelle.
- Marketplace.
- Stock avancé, fidélité, couponing et transporteur/API livraison non confirmés.
- SMS/push, automatisations de notification et fonctionnalités nécessitant workers permanents.
- Microservices, Docker, Node.js en production ou architecture distribuée.

Le paiement à la livraison est proposé comme mode privilégié dans les sources ; les modes réellement activés sont **À valider**.

## 6. Architecture technique obligatoire

### Stack et déploiement

- **Confirmé/imposé :** PHP 8.3+ Vanilla MVC, MySQL 8, PDO, HTML5, CSS3, JavaScript Vanilla, Bootstrap 5.
- **Cible :** cPanel/shared hosting ; fichiers + SQL, scripts CLI et cron cPanel.
- **Interdits sans validation :** Laravel ou autre framework backend, Node.js en production, Docker, workers persistants, microservices, CQRS, event bus ou cache distribué.
- Composer/autoload ou bibliothèque PHP : seulement si compatible cPanel, utile et approuvé ; éviter dépendances lourdes.
- HTTPS en production, secrets propres à l'installation et configuration séparée du code.

### Couches et responsabilités

1. **Entrée publique / Router** : reçoit HTTP, résout route et méthode ; aucun métier.
2. **Middleware** : session, auth, CSRF, rate limit, headers, correlation ID.
3. **Controller** : parse requête, validation d'entrée/DTO, appelle un cas d'usage et construit la réponse. Aucun SQL ni règle métier.
4. **Application service / use case** : orchestre transaction et workflow.
5. **Domain / entités / policies** : règles, invariants, transitions et autorisations métier ; ne dépend pas de HTTP, PDO, session ou fournisseur externe.
6. **Repository** : SQL PDO, requêtes préparées, mapping et persistance.
7. **Infrastructure/adapters** : fichiers, Meta, e-mail, WhatsApp link, logger, cron.
8. **View** : HTML échappé et présentation ; aucune DB ni logique métier.
9. **JavaScript** : amélioration UX, interaction et validation préliminaire ; jamais autorité de sécurité.

Dépendances autorisées : Presentation → Application → Domain ; Application utilise des contrats/adapters ; Infrastructure implémente les contrats. Domain ne dépend pas des détails infrastructurels.

### Règles architecturales interdites

- Logique métier ou calcul de total autoritaire dans contrôleurs/vues.
- SQL dans contrôleurs, vues, scripts frontend ou domaine.
- Accès DB depuis vues.
- Dépendance directe du domaine envers HTTP, PDO, session ou API externe.
- Secrets dans le dépôt, HTML, JavaScript, URL, logs ou compte rendu.
- Exécution de PHP/JS/CSS non inspecté fourni par un thème ou import.
- Ajout de technologie incompatible avec cPanel sans validation.
- Préparer prématurément un SaaS ou introduire un `tenant_id` global sans décision.

## 7. Organisation du dépôt

L'architecture propose notamment cette séparation. **Inspecter l'arborescence réelle avant toute création ou déplacement.** Si le dépôt diffère, préserver l'existant et proposer une migration progressive ; ne pas restructurer massivement.

| Emplacement cible | Responsabilité |
|---|---|
| `public/` | seul document root idéal : `index.php`, assets publics, images publiables, manifest/service worker si PWA validée |
| `app/` | code applicatif privé |
| `app/Domain/` | entités, règles, policies, exceptions métier |
| `app/Application/` ou `app/Services/` | cas d'usage, orchestration, DTO |
| `app/Http/Controllers/` | contrôleurs HTTP |
| `app/Http/Middleware/` | auth, CSRF, headers, rate limit, correlation ID |
| `app/Repositories/` ou `app/Infrastructure/Persistence/` | repositories PDO et mapping |
| `app/Infrastructure/` | adapters Meta, fichiers, mail, logs et autres services externes |
| `app/Validators/` | validation structurée d'entrées |
| `app/Views/` ou `views/` | layouts, pages et composants HTML |
| `routes/` | définition des routes web/API |
| `config/` | configuration non secrète et loader ; secrets hors dépôt |
| `database/migrations/` | migrations versionnées et réversibles autant que possible |
| `database/seeders/` | données de démonstration/test non sensibles |
| `storage/` ou chemin privé configuré | uploads privés, imports temporaires, sessions, logs, backups |
| `bin/` | commandes CLI et runner cron |
| `tests/` | unitaires, intégration, fonctionnels et sécurité |
| `docs/` | documentation d'installation, décisions et opérations |

- `public/` ne doit jamais exposer `app/`, `config/`, `database/`, `routes/`, `tests/`, `bin/`, `.env`, sessions, logs, backups ou imports privés.
- Si cPanel impose `public_html` : placer le code privé au-dessus de `public_html` ; n'y laisser que le contenu de `public/`. Si impossible, bloquer explicitement les dossiers privés et vérifier par tests HTTP.
- Le chemin exact de stockage et la présence de chaque dossier doivent être confirmés dans le dépôt/hébergement ; ne pas supposer qu'ils existent déjà.

## 8. Conventions de développement

- Suivre le style et les conventions déjà présentes ; ajouter une convention seulement si nécessaire et cohérente.
- Classes et interfaces : PascalCase ; méthodes et variables : camelCase ; constantes : `UPPER_SNAKE_CASE` ; fichiers cohérents avec leur classe ; routes explicites et REST-like sans ajouter d'API inutile.
- Tables/colonnes : convention snake_case cohérente avec les migrations existantes ; contraintes et index nommés explicitement.
- PHP strict : déclarer `declare(strict_types=1);` lorsque compatible avec le fichier existant ; types paramètres/retours ; éviter `mixed` non justifié.
- Valider et normaliser toutes les entrées côté serveur ; utiliser allowlists pour statuts, rôles, thèmes, MIME, extensions et actions.
- PDO : requêtes préparées ; paramètres bindés ; jamais de concaténation d'entrée dans SQL.
- Transactions : encadrer checkout et mutations multi-écritures ; rollback sur échec ; ne pas effectuer un appel externe non réversible dans une transaction DB.
- Pagination : côté serveur, bornée ; éviter de charger des catalogues/commandes sans limite.
- Dates : stocker selon convention architecture et convertir vers le fuseau configuré de la boutique ; fuseau par défaut `Africa/Douala` dans le contexte technique, mais choix utilisateur/config exact à confirmer.
- Montants : utiliser type décimal ou unité entière selon décision ; l'unité/arrondi FCFA est **À valider**. Ne pas utiliser les flottants binaires pour calculs financiers.
- Erreurs : réponses neutres en production ; exception détaillée uniquement dans logs privés avec correlation ID.
- Logs structurés : date, niveau, événement, correlation ID, contexte minimal ; jamais mot de passe, token, secret, données carte ou contenu client non nécessaire.
- Idempotence : checkout, import, cron et webhook éventuel doivent résister aux répétitions ; clés et contraintes DB si approprié.
- Migrations : versionnées, ordonnées, testées sur DB vierge et DB existante ; ne jamais modifier directement production sans autorisation.
- Commentaires : expliquer le pourquoi d'une règle non évidente, pas paraphraser le code.
- Documenter les décisions structurantes, les limites et la procédure opérationnelle.
- Préférer des changements petits, cohérents et testables. Pas de refactorisation globale hors tâche.

## 9. Multi-tenant et protection des données

**Le MVP n'est pas multi-tenant.** Une installation dédiée et une DB/configuration distincte par commerçant assurent le périmètre. Ne pas implémenter un tenant resolver, un `tenant_id` universel, un super-admin multi-clients ou des scopes SaaS sans validation explicite.

Pour chaque requête protégée :
- résoudre côté serveur l'installation/configuration active ;
- ne jamais faire confiance à un `tenant_id`, `shop_id`, rôle ou propriétaire envoyé par le client ;
- contrôler l'accès à la ressource et à l'action ;
- ne pas exposer par ID direct une commande, un client, un fichier ou un import non autorisé ;
- retourner le statut d'erreur prévu, `404` si l'architecture le prévoit pour masquer une ressource ;
- auditer les tentatives d'accès hors périmètre sans logger de données sensibles.

Tests obligatoires : ressource inexistante, identifiant modifié, session non autorisée, rôle insuffisant, accès à une autre installation de test si environnement multi-installation disponible. Si un vrai SaaS est validé plus tard, exiger une conception d'isolation complète avant développement.

## 10. Sécurité obligatoire

Appliquer les contrôles serveur et standards du Creative Brief. Tester au minimum :

- **SQL injection** : PDO préparé, paramètres bindés, whitelist pour identifiants SQL dynamiques.
- **XSS** : échappement contextualisé à la sortie ; contenu importé/description considéré non fiable ; pas de HTML arbitraire.
- **CSRF** : token synchronisé sur mutations, déconnexion et formulaires admin ; validation serveur.
- **Session** : `session.use_strict_mode`, `session_regenerate_id(true)` après login, invalidation à la déconnexion/suspension ; cookies `Secure`, `HttpOnly`, `SameSite` et path/domain restrictifs.
- **Brute force** : rate limit login par identifiant/IP pseudonymisée, délais progressifs, audit ; pas de blocage permanent abusif.
- **IDOR** : policy par ressource/action, contrôle propriétaire/périmètre, IDs non considérés secrets.
- **Double soumission** : idempotence checkout et contrainte unique ; éviter doubles commandes sur rafraîchissement/retry.
- **Uploads** : MIME détecté côté serveur, extension allowlist, taille/dimensions bornées, nom généré, stockage privé, pas d'exécution, validation d'image ; CSV/XLSX contrôlés et macros interdites.
- **Path traversal** : ne jamais utiliser directement chemin fourni par client ; canonicaliser et vérifier racine autorisée.
- **Secrets** : `.env` non versionné, hors webroot, permissions minimales ; `.env.example` uniquement avec placeholders ; clés Meta chiffrées au repos si stockées.
- **Production** : debug désactivé, aucune stack trace/SQL/chemin privé exposé ; HTTPS.
- **Webhooks** : aucun webhook requis pour le MVP ; si validé, signature sur corps brut, timestamp/anti-rejeu, idempotence, secret hors dépôt.
- **Appels externes** : HTTPS, timeout, réponse validée, retry borné sur erreurs transitoires ; ne pas suivre des URL arbitraires importées.
- **Effet externe critique** : revalider permissions et règles métier juste avant mutation ou appel ; gérer l'échec sans perdre la commande.
- **Logs** : aucun mot de passe, clé API, token, cookie, session ID brut, secret ou données client sensibles.
- **Fichiers privés** : uploads non publics, sessions, logs, exports, imports et backups hors document root.
- **Sauvegardes** : accès restreint, politique de rétention à valider, chiffrement si données personnelles incluses et test de restauration.
- **Permissions** : vérification serveur sur chaque mutation, download, route API et changement de statut.

Ne désactive jamais une protection pour faire passer un test. Toute exception de sécurité doit être explicitement approuvée, limitée et documentée.

## 11. UX/UI, Responsive et PWA

### Références design

Utiliser le ZIP Creative Brief comme source UX/UI et consulter uniquement les fichiers pertinents : `PROJECT_CONTEXT.md`, `README_PROJECT.md`, `GENERATION_MANIFEST.md`, `04_UX_DESIGN/`, `05_UI_DESIGN/`, `06_DESIGN_SYSTEM/`, `08_TECHNICAL_STANDARDS/` et `10_QUALITY_ASSURANCE/`.

- **Confirmé :** Mobile First, responsive smartphone/tablette/desktop, thèmes Stitch en couche de présentation et conservation des données.
- **À valider :** thème/direction artistique retenu, points de rupture exacts, fonts externes, PWA installable/offline et budget précis de performance.
- Respecter strictement les maquettes approuvées. Si aucune maquette n'existe ou si le thème est absent, signaler le manque ; ne pas inventer un design déjà validé.
- Inventorier `themes/` avant de sélectionner ou coder un thème. Ne pas exécuter le code Stitch non inspecté ; normaliser, revoir sécurité/accessibilité et tester.
- Centraliser couleurs, typographies, espacements et styles dans tokens/config du thème ; éviter styles contradictoires dispersés.
- Un thème ne contient pas les données commerciales et ne modifie pas la logique panier/commande/dashboard.

### Obligations UI/accessibilité

- HTML sémantique ; labels explicites et messages d'erreur associés.
- Navigation clavier complète, ordre de tabulation logique et focus visible.
- Contraste WCAG AA ; ne pas communiquer un état uniquement par couleur.
- Cibles tactiles d'au moins **44 × 44 px**.
- Aucune action disponible uniquement au survol.
- Formulaires lisibles, validation et erreurs accessibles.
- Tableaux/listes adaptés au mobile : priorité aux données utiles, alternative en cartes si maquette validée.
- États explicites : chargement, vide, succès, erreur, indisponible et hors ligne lorsque pertinent.
- Images optimisées, dimensions connues, lazy loading hors contenu prioritaire ; éviter layout shift.
- Tester au minimum les viewports 320/360, 768, 1024 et desktop, clavier et lecteur d'écran lorsque disponible.

### PWA et performance

- PWA/service worker seulement selon périmètre validé.
- Cache contrôlé des ressources statiques publiques uniquement ; **ne jamais mettre en cache** dashboard, checkout, commandes, clients, sessions ou données sensibles.
- Pas de commande offline ni Background Sync critique sans décision et tests de conflits.
- Documenter compatibilité iOS/Android et comportement de mise à jour.
- Respecter les budgets performance du Creative Brief ; mesurer avant de déclarer conforme.
- Aucune donnée privée dans manifest, cache ou assets publics.

## 12. Méthode d'exécution du plan

Pour chaque mission :

1. Identifier phase et étape exacte de `PLAN_REALISATION_APPLICATION.md`.
2. Lire ce `AGENTS.md` et les seules sources utiles à la tâche.
3. Lire les `AGENTS.md` locaux concernés.
4. Inspecter l'état réel du dépôt, les fichiers modifiés, conventions, tests, migrations et config non sensibles.
5. Vérifier prérequis, dépendances et critères d'acceptation.
6. Annoncer brièvement le périmètre et les fichiers susceptibles d'être touchés.
7. Implémenter uniquement la tâche assignée ; ne pas développer une étape suivante.
8. Ajouter/adapter les tests pertinents.
9. Exécuter les contrôles disponibles et corriger les régressions provoquées.
10. Mettre à jour la documentation utile et les décisions.
11. Fournir le compte rendu factuel de la section 16.

### Gates et dépendances

- Étape 1 du plan : gate de cadrage ; aucune décision « À valider » ne devient confirmée par l'agent.
- Étapes 2 (UX/UI) et 3 (fondations) : parallèles après cadrage, sans empiéter sur les décisions de l'autre.
- Étape 4 (MVP) : attend les maquettes validées et fondations/contrats.
- Étape 5 (intégrations, sécurité finale, QA) : attend la stabilisation des parcours et contrats.
- Les contrôles sécurité/tests sont continus ; la recette finale intervient après intégration.

Un test non exécuté ou non terminé **ne doit pas arrêter la continuation du codage**. L'agent doit poursuivre les tâches non bloquées, consigner la cause, le risque et le test à reprendre. Ne jamais présenter un test manquant comme réussi ni déclarer l'étape terminée si un critère obligatoire reste non vérifié.

## 13. Tests et contrôles obligatoires

Choisir les tests selon la tâche et exécuter les tests ciblés pendant le développement, puis la suite complète disponible avant livraison.

- **Unitaires** : calculs prix/quantité, validation, transition statut, format message WhatsApp, mapping import.
- **Intégration** : PDO/repositories, transactions, migrations, stockage fichiers, adaptateurs externes sandbox.
- **Fonctionnels** : catalogue → panier → checkout → commande enregistrée → lien WhatsApp → dashboard.
- **Sécurité** : SQLi, XSS, CSRF, session fixation, brute force, IDOR, traversal, upload dangereux, secrets/logs.
- **Permissions** : routes, API, downloads, mutations, statut, rôle insuffisant et ressources hors périmètre.
- **Isolation installation** : vérification DB/config dédiée et absence d'accès aux fichiers/DB d'une autre installation ; pas de test tenant SaaS non implémenté.
- **Concurrence/idempotence** : double clic checkout, refresh, retry import/cron, unique order number.
- **Migrations** : DB vierge, DB existante, ordre, rollback si prévu, contraintes et indexes.
- **Webhooks** : seulement si intégration validée ; signature, timestamp, rejeu, idempotence et corps brut.
- **Cron** : CLI only, verrou, durée/lot borné, reprise et retry.
- **Responsive/accessibilité** : tailles, clavier, focus, contraste, labels, erreurs et states.
- **Non-régression** : parcours existants, changement thème sans perte, commande préservée, fallback externe.
- **PWA** : cache statique et exclusion des pages/données sensibles si PWA validée.
- **Backup/restore/déploiement** : installation cPanel, permissions, secrets, migrations et restauration si inclus dans la mission.

Si un test ne peut pas être exécuté, indiquer explicitement : test, cause, risque, alternative éventuelle et action de reprise. Ne pas supprimer/affaiblir le test pour faire passer la livraison.

## 14. Définition de terminé

Une tâche est terminée uniquement si :

- le comportement assigné est implémenté et limité au périmètre ;
- les règles métier et calculs serveur sont respectés ;
- authentification, permissions et périmètre d'installation sont vérifiés ;
- erreurs, cas limites et fallback sont traités ;
- migrations nécessaires sont présentes, versionnées et testées ;
- les tests pertinents passent ou les tests non exécutés sont explicitement consignés ;
- responsive/accessibilité sont vérifiés si l'interface est concernée ;
- aucun secret ou donnée sensible n'est exposé ;
- aucune régression connue n'a été introduite ;
- les critères d'acceptation ont une preuve de vérification ;
- documentation utile et décisions sont à jour ;
- limites, dépendances et actions manuelles restantes sont signalées.

Un test non terminé n'empêche pas les autres tâches de continuer, mais empêche de prétendre que le critère correspondant est validé.

## 15. Actions interdites

L'agent ne doit jamais :

- inventer une règle métier ou un rôle ;
- transformer une décision « À valider » en décision définitive ;
- modifier une fonctionnalité hors périmètre ou développer la prochaine étape sans demande ;
- désactiver une protection pour faire passer un test ;
- supprimer, écraser ou reformater des modifications utilisateur non liées ;
- exécuter une commande Git destructive (`reset --hard`, `clean -fd`, force push, suppression de branche) sans autorisation explicite ;
- modifier les données de production sans autorisation explicite ;
- exposer secret, mot de passe, token, cookie ou donnée sensible dans code, logs, commit ou compte rendu ;
- remplacer l'architecture sans justification et validation ;
- installer une dépendance lourde ou incompatible sans nécessité démontrée et validation ;
- déclarer une tâche terminée sans preuve de validation ;
- supprimer un test ou affaiblir ses assertions pour masquer un défaut ;
- déployer en production, exécuter migration destructive ou restaurer backup sans demande explicite ;
- modifier `.env` réel, secrets ou config de production sans autorisation ;
- ajouter un tenant resolver, paiement online, SaaS, notifications ou PWA offline non validés ;
- faire croire qu'un lien WhatsApp ouvert confirme l'envoi ou le paiement.

Avant toute commande potentiellement destructive, vérifier le diff, l'état Git et demander une autorisation explicite.

## 16. Format du compte rendu des agents

Réponse finale courte, factuelle et structurée :

```markdown
### Compte rendu
- **Résultat :** ...
- **Phase / étape :** ...
- **Fichiers modifiés :** ...
- **Migrations :** ... (ou aucune)
- **Tests exécutés :** ... — résultat
- **Critères d'acceptation vérifiés :** ... (preuve concise)
- **Décisions prises :** ... (avec statut Confirmé / Recommandé / À valider)
- **Limites / risques restants :** ...
- **Action manuelle :** ... (ou aucune)
```

Ne déclarer que ce qui a réellement été exécuté ou inspecté. Distinguer test réussi, échoué, non exécuté et bloqué.

## 17. Contradictions, lacunes et décisions à valider

### Contradictions ou précisions importantes

- **Multi-tenant/RBAC :** certaines instructions générales de mission peuvent demander tenant resolver, `tenant_id` et isolation tenant. L'architecture Marvens Shop confirme au contraire une installation dédiée par commerçant et exclut le SaaS du MVP. Pour cette version, appliquer l'isolation par installation/DB/config ; ne pas ajouter un multi-tenant SaaS. Le RBAC reste serveur, mais les rôles au-delà de `merchant_admin` sont à valider.
- **PWA/offline :** le cahier des fonctionnalités mentionne PWA/service worker, tandis que l'architecture précise que le périmètre offline/installable reste à valider. Préparer une compatibilité uniquement dans le périmètre confirmé ; ne pas mettre en cache de données sensibles.
- **Thèmes :** les sources prévoient les thèmes Stitch dans `themes/`, mais l'espace de travail analysé ne permet pas de confirmer le dossier. Inventorier le dépôt réel et les fichiers avant de coder ; ne pas inventer des thèmes existants.
- **Paiement :** aucune gateway en MVP ; paiement à la livraison proposé, modes réellement activés à valider. Le statut paiement ne doit pas être confondu avec le statut commande.
- **Rôles :** `merchant_admin` est le rôle MVP ; `staff` et `marvens_support` sont non confirmés. Les profils métier listés ne sont pas automatiquement des rôles autorisés.

### Décisions encore ouvertes

- Modes de paiement et livraison réellement activés, règles de frais et zones.
- Inclusion effective des variantes et du stock dans le MVP.
- Accès, scopes, version et disponibilité de l'intégration Meta.
- Bibliothèque et intégrité des thèmes Stitch dans le dépôt.
- Import Excel/XLSX et dépendance compatible cPanel.
- Notifications e-mail/WhatsApp automatiques et canal fiable.
- Périmètre installable/offline PWA et stratégie cache.
- Durées de session, rétention des données clients/commandes, export/suppression et rétention logs/backups.
- Unité monétaire/arrondi, limites upload, seuils performance et fréquence sauvegarde.
- Rôles staff/support, matrice détaillée et procédure d'accès support.

L'agent doit conserver ces éléments « À valider », signaler leur impact sur la tâche et demander arbitrage si nécessaire. Une décision ne peut être prise que par une source de priorité supérieure ou le porteur du projet.

---

**Principe directeur :** réaliser le MVP Marvens Shop de manière simple, sécurisée, testable et compatible cPanel ; respecter les sources et le plan ; préserver les données commerciales ; ne jamais confondre une recommandation technique avec une décision validée.
