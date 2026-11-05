# CAHIER DES CHARGES FONCTIONNEL ET TECHNIQUE
## MARVENS SHOP — MVP installé individuellement chez le commerçant

**Version :** 1.0 — 05 novembre 2026  
**Statut :** document de cadrage consolidé — décisions non confirmées signalées « À valider »  
**Périmètre :** application e-commerce légère, mini-site public, commandes structurées, WhatsApp Business, import catalogue Meta, dashboard commerçant  
**Socle imposé :** PHP 8.3+ Vanilla MVC, MySQL 8, PDO, HTML5/CSS3, JavaScript Vanilla, Bootstrap 5, cPanel mutualisé

> **Convention de lecture**
> - **Confirmé** : explicitement présent dans les sources du projet.
> - **Recommandation** : proposition nécessaire pour rendre la spécification exploitable, à valider par le porteur.
> - **À valider** : choix métier, commercial ou technique qui ne peut pas être déduit avec certitude.
> - **MVP** : script installé séparément sur le domaine/sous-domaine de chaque client. Ce document ne spécifie pas un SaaS multi-tenant.

---

# 1. Résumé exécutif

Marvens Shop est une solution de social commerce destinée aux commerçants, entrepreneurs et petites entreprises, en priorité au Cameroun puis dans les marchés francophones africains. Elle répond à une difficulté opérationnelle : les ventes gérées uniquement par conversations WhatsApp et réseaux sociaux rendent la présentation des produits, la collecte des coordonnées, la reconstitution des commandes et leur suivi difficiles.

Le MVP fournit à chaque client une boutique web personnalisée installée sur son domaine ou sous-domaine. Le mini-site présente le catalogue et les produits ; le panier collecte les articles, quantités et variantes ; le formulaire crée une commande persistante ; WhatsApp ouvre ensuite une conversation préremplie ; le dashboard permet au commerçant de consulter, confirmer et suivre la commande.

**Le point essentiel :** la commande est enregistrée côté serveur avant l’ouverture de WhatsApp. L’ouverture de WhatsApp ne prouve pas que le message a été envoyé ni que la commande a été confirmée. Ces états doivent être distincts dans le système.

Le paiement n’est pas intégré au MVP. Le paiement à la livraison est le mode recommandé par les sources complémentaires, mais la liste des modes affichés et leur activation restent à valider par boutique. Les paiements sont confirmés manuellement par le commerçant. Le MVP n’est pas une plateforme SaaS : chaque client possède une installation, une base de données et une configuration séparées. Marvens assure l’installation, la configuration, la formation et la maintenance selon une offre/contrat.

L’import du catalogue Meta est prévu via OAuth officiel, sous réserve des permissions, de l’éligibilité du compte, des endpoints disponibles et de la revue Meta applicable. Un import CSV/Excel est prévu comme alternative de catalogue. Les thèmes Stitch fournis dans le dossier `themes` de l’espace de travail doivent être utilisés comme choix de templates ; le framework Marvens Creative Brief fourni dans l’archive ZIP doit servir de référence de direction artistique, UX/UI, responsive, accessibilité et standards techniques.

## 1.1 Principes directeurs

1. **Commande structurée avant conversation** : aucune commande ne dépend exclusivement d’un message WhatsApp.
2. **WhatsApp comme canal de communication** : l’application prépare le message, mais ne prétend pas envoyer ou confirmer automatiquement le message.
3. **Paiement séparé** : pas de paiement en ligne ni de passerelle dans le MVP.
4. **Installation client dédiée** : pas de SaaS, multi-tenant ou inscription autonome dans cette version.
5. **Données et présentation séparées** : un changement de thème ne modifie ni produits, ni commandes, ni clients.
6. **Mobile-first** : parcours public et administration utilisables sur smartphone, avec adaptation tablette/desktop.
7. **PHP Vanilla MVC** : aucune dépendance à Laravel, Node.js de production ou Docker.
8. **Sécurité par défaut** : contrôle serveur, sessions sécurisées, PDO préparé, validation, journaux et sauvegardes.
9. **Évolution progressive** : fonctionnalités non nécessaires au premier pilote sont reportées.

---

# 2. Sources analysées et synthèse

## 2.1 Sources du projet prises en compte

- `Marvens_Shop_Document_Complet_MVP.docx` (document complet du projet MVP client installé).
- `Paramètres.docx` (menu paramètres et rubriques e-commerce).
- `FONCTIONNALITÉS.docx` (fonctionnalités, dont paramètres, thèmes et paiement à la livraison).
- `MARVENS_CREATIVE_BRIEF_MARVENS_SHOP_20261104_151943.zip` (framework de conception : direction artistique, UX, UI, design system, standards frontend/PHP, sécurité, accessibilité, intégration Stitch et prompts agents).

Les copies doublonnées des documents MVP et Paramètres ont été considérées comme des doublons de contenu, et non comme des sources de décisions différentes.

## 2.2 Informations confirmées

| Sujet | Éléments confirmés |
|---|---|
| Produit | Mini-site e-commerce et gestion structurée des commandes, connecté au parcours WhatsApp. |
| Cible | Commerçants, entrepreneurs et petites entreprises ; Cameroun en priorité, puis Afrique francophone. |
| Modèle MVP | Script installé individuellement sur le domaine/sous-domaine du client. |
| Prestation | Installation, configuration, formation et maintenance assurées par Marvens. |
| SaaS | Reporté après validation commerciale et technique du MVP. |
| Mini-site | Accueil, catalogue, catégories, recherche, filtres, fiches produits, produits mis en avant, informations pratiques et contact WhatsApp. |
| Catalogue | Création/modification/publication/dépublication, catégories, images, prix, référence, disponibilité, variantes et promotions. |
| Import | Import Meta OAuth officiel et import CSV/Excel ; rapport d’import, anti-doublons et reprise. |
| Commande | Panier, quantités, variantes, coordonnées, livraison, mode de paiement, instructions, numéro unique et sauvegarde avant WhatsApp. |
| Dashboard | Liste/détail des commandes, recherche, filtres, historique et mise à jour des statuts. |
| Paiement | Séparé du système de commande ; confirmation manuelle. Paiement à la livraison indiqué comme orientation à privilégier dans les fonctionnalités complémentaires. |
| Technique | PHP 8.3+ Vanilla MVC, MySQL 8, PDO, HTML5/CSS3, JS Vanilla, Bootstrap 5, cPanel mutualisé. |
| PWA | Installabilité et cache contrôlé ; pas de promesse de commande hors ligne. |
| Thèmes | Le commerçant choisit un thème Stitch ; données et logique restent indépendantes du thème. |
| Paramètres | Informations boutique, apparence, livraison/retrait, utilisateurs/permissions, notifications, intégrations, sécurité, analytics/suivi et paramètres avancés. |

## 2.3 Hypothèses/recommandations retenues pour rendre le document exploitable

| ID | Recommandation | Statut |
|---|---|---|
| H-01 | Le MVP commence avec un compte commerçant administrateur unique par installation ; les comptes secondaires sont activables selon le besoin réel. | Recommandation issue du document MVP |
| H-02 | Les commandes sont créées avec le statut `pending` (en attente) et un état séparé `whatsapp_status` (non ouvert, ouvert/préparé, envoyé non vérifiable, ou non renseigné). | À valider |
| H-03 | Les statuts commande, paiement et livraison sont séparés afin d’éviter une seule machine d’état surchargée. | Recommandation |
| H-04 | Les variantes sont facultatives et activées selon les produits du client. | Confirmé dans l’esprit ; modèle exact à valider |
| H-05 | Les montants sont stockés en unité monétaire entière (FCFA sans décimales pour le cas courant) et la devise est conservée sur la commande. | À valider selon devises activées |
| H-06 | La livraison à domicile et le retrait en boutique sont configurables. Les frais peuvent être définis par zone/ville/quartier. | Confirmé, tarifs à configurer |
| H-07 | Les notifications automatiques sont limitées au canal réellement configuré ; WhatsApp automatique n’est pas inclus sans intégration officielle dédiée. | Recommandation |
| H-08 | Les thèmes livrés dans `themes/` sont la source des templates disponibles. | Confirmé par demande, fichiers thèmes non visibles dans le montage courant |
| H-09 | La personnalisation guidée permet de modifier logo, favicon, couleurs et polices ; les personnalisations de mise en page avancées dépendent des capacités de chaque thème. | À valider |
| H-10 | L’export CSV et les rôles avancés sont P1, sauf besoin identifié lors du pilote. | Recommandation de priorisation |

## 2.4 Informations manquantes ou décisions bloquantes

- Liste et contenu exacts des thèmes Stitch du dossier `themes/` (non présent dans les fichiers montés au moment de la rédaction). Il faut les inventorier et vérifier leur compatibilité avant de les intégrer.
- Domaine, hébergement, ressources PHP/MySQL et limites d’upload pour chaque client.
- Modes de paiement proposés (paiement à la livraison recommandé ; autres modes à confirmer).
- Zones de livraison, frais, minimum éventuel et règle de calcul.
- Politique de stock : simple disponibilité manuelle ou décrémentation à la commande.
- Règles précises de variantes, prix par variante et disponibilité.
- Fréquence et champs synchronisés depuis Meta.
- Nombre de comptes secondaires et granularité RBAC du pilote.
- Politique de conservation/suppression des données.
- Langues, devises, fuseau horaire par client.
- Contrat de maintenance, délai de réponse, responsabilités et prix.
- Conditions Meta (permissions, revue, limites et endpoints disponibles) à vérifier avant le développement de l’intégration.

---

# 3. Contexte et vision produit

## 3.1 Contexte

Les commerçants utilisent souvent WhatsApp Business, Facebook, Instagram, TikTok ou d’autres réseaux comme canaux de découverte et de vente. La présentation des produits et la prise de commande restent toutefois réparties dans les conversations. Les clients peuvent demander plusieurs informations, les commandes sont reconstituées manuellement, et les détails de livraison ou de paiement peuvent être oubliés.

Marvens Shop structure cette activité sans imposer immédiatement un e-commerce complexe ni un SaaS. Il s’agit d’un outil de vente léger et accompagné.

## 3.2 Problème à résoudre

- Le client doit retrouver les produits dans des conversations ou publications.
- Les commandes reçues en messages ne suivent pas toujours un format standard.
- Le commerçant ressaisit les produits, quantités, variantes, coordonnées et montants.
- Les informations clients, commandes, paiement et livraison sont dispersées.
- Il est difficile de connaître l’état réel d’une commande.
- Les erreurs, oublis et temps de traitement peuvent augmenter.
- Les statistiques commerciales sont limitées ou absentes.

## 3.3 Proposition de valeur

**Promesse commerciale confirmée :** « Transformez votre WhatsApp Business en une véritable boutique en ligne, avec catalogue, commandes organisées et suivi commercial. »

Marvens Shop ne doit pas être présenté uniquement comme un constructeur de site. La valeur est de réduire les opérations manuelles entre la découverte d’un produit et le traitement d’une commande : catalogue accessible, panier structuré, commande persistante, suivi dans le dashboard et conversation WhatsApp.

## 3.4 Clients et utilisateurs ciblés

- Commerçants de détail.
- Petites entreprises et entrepreneurs.
- Vendeurs actifs sur WhatsApp Business et réseaux sociaux.
- Commerçants qui ont besoin d’un catalogue web, mais pas d’un système complexe.
- Première zone commerciale : Cameroun ; extension envisagée vers l’Afrique francophone.

**À valider :** segments prioritaires (mode, beauté, accessoires, électronique, alimentation, etc.), taille de catalogue et volume de commandes attendu.

## 3.5 Objectifs commerciaux et opérationnels

1. Installer une boutique personnalisée par client.
2. Faciliter la découverte et la présentation des produits.
3. Structurer la collecte de commandes.
4. Réduire les erreurs de ressaisie.
5. Centraliser les commandes et l’historique clients.
6. Faciliter le partage depuis les réseaux sociaux.
7. Importer un catalogue Meta autorisé.
8. Former le commerçant à gérer son catalogue et ses commandes.
9. Mesurer le coût réel d’installation, de formation et de maintenance.
10. Collecter les retours du pilote pour décider du SaaS.

## 3.6 Modèle économique envisagé

Le MVP est vendu comme **prestation personnalisée**, pas comme abonnement SaaS automatisé. L’offre peut inclure :

- frais de conception/configuration et installation ;
- déploiement sur domaine ou sous-domaine ;
- configuration de l’identité visuelle et du catalogue ;
- formation initiale ;
- maintenance et assistance récurrentes selon contrat ;
- services complémentaires (saisie produits, import, visuels, marketing ou intégrations).

Les prix doivent être établis après estimation du temps, de la personnalisation, de l’hébergement, du support et de la valeur apportée. **À valider :** grille tarifaire, durée d’engagement, renouvellement, hébergement inclus ou payé par le client.

## 3.7 Différenciateurs

- Mise en place accompagnée par Marvens.
- Installation dédiée au client.
- Boutique adaptée à son identité.
- Thèmes professionnels sélectionnables.
- Commandes enregistrées indépendamment de WhatsApp.
- Dashboard de suivi.
- Import catalogue officiel Meta lorsque disponible.
- Simplicité du parcours pour des utilisateurs mobiles.
- Paiement séparé, limitant les dépendances de paiement du MVP.

## 3.8 Indicateurs de succès

| KPI | Définition proposée | Cible initiale |
|---|---|---|
| Boutiques installées | Instances mises en production | À valider après pilote |
| Boutiques activées | Boutique avec catalogue publié et lien partagé | À valider |
| Produits publiés | Produits visibles dans la boutique | Suivi par boutique |
| Commandes créées | Commandes persistées sur une période | Suivi hebdomadaire |
| Taux de confirmation | Commandes confirmées / commandes enregistrées | À valider |
| Temps de traitement | Durée entre réception et première action commerçant | Baseline puis réduction |
| Erreurs de commande | Erreurs signalées / commandes | Baseline puis réduction |
| Usage dashboard | Commerçant actif dans le dashboard | À valider |
| Incidents | Nombre et sévérité des incidents | Suivi mensuel |
| Coût de déploiement | Temps/coûts directs par installation | Mesure dès le premier client |
| Renouvellement maintenance | Clients qui renouvellent | À mesurer après échéance |

## 3.9 Hors périmètre

- Inscription libre et onboarding autonome.
- SaaS multi-tenant partagé.
- Provisionnement automatique de boutiques/domaines.
- Plans et paiement d’abonnements SaaS.
- Marketplace centrale.
- Application mobile native.
- Paiement en ligne intégré ou agrégation de paiement.
- Stock avancé multi-entrepôt.
- Automatisations marketing complexes.
- Programme de fidélité, avis clients ou campagnes automatisées, sauf décision P1 ultérieure.
- Fonctionnement complet des commandes hors ligne.
- Synchronisation Meta illimitée ou garantie indépendamment des API.

---

# 4. Périmètre et limites du MVP

## 4.1 Architecture de déploiement métier

Chaque client reçoit une instance autonome :

- code applicatif installé sur son domaine ou sous-domaine ;
- base MySQL dédiée ;
- configuration de boutique propre ;
- compte administrateur initial ;
- stockage média séparé ;
- paramètres livraison, paiement, WhatsApp et thème ;
- intervention Marvens pour installation, configuration, formation et maintenance.

La séparation des instances constitue l’isolation primaire du MVP. Les contrôles d’accès restent obligatoires au sein de chaque instance. L’architecture SaaS multi-tenant est exclue.

## 4.2 Périmètre fonctionnel MVP

1. Authentification administrateur.
2. Configuration de la boutique.
3. Sélection de thème et personnalisation guidée.
4. Gestion catégories, produits, images, prix, disponibilité et variantes simples.
5. Mini-site public responsive.
6. Panier.
7. Formulaire de commande.
8. Enregistrement transactionnel et numéro de commande.
9. Ouverture WhatsApp avec message prérempli.
10. Dashboard commandes et changements de statut.
11. Gestion minimale des clients et historique.
12. Paramètres livraison/retrait.
13. Paiement manuel, avec paiement à la livraison comme option recommandée.
14. Import Meta sous réserve de validation des permissions.
15. Import CSV/Excel.
16. Statistiques simples.
17. Sécurité, logs, sauvegarde et restauration.
18. PWA installable si compatible avec l’hébergement et les navigateurs.

---

# 5. Utilisateurs, rôles et permissions

## 5.1 Rôles

| Rôle | Responsabilités | Accès et actions | Interdictions/restrictions |
|---|---|---|---|
| Administrateur Marvens / support | Installation, configuration technique, diagnostic, mise à jour, maintenance | Accès technique à l’instance selon autorisation contractuelle ; consultation logs techniques ; intervention documentée | Ne doit pas utiliser les données client hors intervention autorisée ; accès temporaire et tracé ; pas d’accès permanent implicite |
| Propriétaire / commerçant administrateur | Gérer la boutique et son activité | Paramètres, thème, produits, catégories, commandes, clients, livraison, paiement manuel, utilisateurs si activés, statistiques et intégrations | Ne peut pas accéder à une autre instance client |
| Administrateur client (si distinct) | Gestion opérationnelle globale de la boutique | Produits, commandes, clients et paramètres accordés | Accès aux secrets et fonctions sensibles limité au besoin ; permissions exactes à valider |
| Responsable commercial / vendeur | Traiter demandes et commandes | Consulter clients/commandes, confirmer disponibilité, modifier statut commercial, ouvrir WhatsApp | Pas de gestion des secrets, sauvegardes, comptes ou intégrations Meta, sauf permission explicite |
| Gestionnaire de stock | Suivre disponibilité et produits | Consulter/mettre à jour disponibilité, produits et variantes | Pas de paramètres boutique, paiement, sécurité ou export client complet sans permission |
| Comptable | Contrôler paiements et rapports | Voir montants, état paiement, rapports et commandes selon droits | Pas de modification produit ou configuration sécurité |
| Préparateur / expédition | Préparer et remettre les commandes | Consulter commandes confirmées, adresse et instructions nécessaires ; modifier préparation/expédition | Accès limité aux données client nécessaires ; pas de paiement ou configuration |
| Support client | Répondre aux clients et suivre commandes | Consulter commande, coordonnées nécessaires, historique ; ajouter note ou statut autorisé | Pas de suppression, export complet, paramètres ou données sensibles |
| Marketing | Promotions et campagnes | Gérer promotions et contenus de mise en avant si activés | Pas de commandes, paiement, sécurité ni intégrations sensibles sans permission |
| Acheteur final | Parcourir, choisir, commander | Voir boutique publique, panier, formulaire, soumettre commande, ouvrir WhatsApp | Pas de compte requis pour commander dans le MVP ; ne voit que ses données de commande accessibles via parcours autorisé |

**Décision MVP recommandée :** un seul compte propriétaire administrateur au départ. Les rôles secondaires sont P1 ou activés si le pilote l’exige. Si activés, ils utilisent un RBAC côté serveur avec permissions explicites, pas seulement des menus masqués.

## 5.2 Matrice de permissions indicative

Légende : **A** = autorisé ; **L** = lecture ; **M** = modification ; **—** = interdit par défaut ; **C** = selon permission.

| Fonction | Marvens support | Propriétaire | Admin client | Vendeur | Stock | Comptable | Préparateur | Support | Marketing |
|---|---:|---:|---:|---:|---:|---:|---:|---:|
| Paramètres boutique | C | A | C | — | — | — | — | C |
| Thème/identité | C | A | C | — | — | — | — | C |
| Produits | C | A | A | C | — | L | L | C |
| Catégories | C | A | A | C | — | — | — | C |
| Commandes | C | A | A | L | L | C | C | — |
| Changer statut commande | C | A | A | C | — | C | C | — |
| Clients | C | A | A | C | L | C | C | C |
| Paiements manuels | C | A | C | C | A | — | L | — |
| Livraison | C | A | C | C | — | C | L | — |
| Utilisateurs | C | A | C | — | — | — | — | — |
| Meta OAuth / secrets | C | A | C | — | — | — | — | — |
| Analytics | C | A | C | L | L | — | — | C |
| Logs sécurité | C | A | C | — | — | — | — | — |
| Sauvegarde/restauration | C | A | C | — | — | — | — | — |

**À valider :** accès exact de Marvens support, permissions d’administration client, nécessité de comptes secondaires, et possibilité de consulter les données de commandes en support.

## 5.3 Cycle de vie des comptes

- **Création :** par Marvens lors de l’installation ; aucun signup public MVP.
- **Activation :** compte initial créé avec mot de passe temporaire ou procédure d’initialisation sécurisée ; changement obligatoire au premier accès recommandé.
- **Modification :** propriétaire/admin autorisé.
- **Désactivation :** révoque immédiatement l’accès ; conserve les traces d’audit.
- **Suppression :** compte utilisateur supprimé logiquement ou anonymisé selon politique ; les commandes et audits ne doivent pas être effacés automatiquement.
- **Suspension :** par propriétaire/admin selon politique ; accès bloqué et sessions révoquées.
- **Réinitialisation :** token aléatoire, expirant, à usage unique ; ne révèle pas si l’adresse existe.
- **Sessions :** révocation par compte, déconnexion globale disponible pour les rôles autorisés.
- **Support Marvens :** accès temporaire, autorisé, journalisé et révocable.

---

# 6. Parcours utilisateurs

## 6.1 Installation assistée par Marvens

**Point de départ :** qualification commerciale validée.

1. Marvens recueille le nom commercial, identité juridique, contacts, logo, couleurs, catalogue, livraison, paiement, WhatsApp et domaine.
2. Vérifie les prérequis d’hébergement, PHP, MySQL, HTTPS et stockage.
3. Crée la base et l’utilisateur DB à privilèges limités.
4. Installe le script et configure l’environnement.
5. Crée le compte propriétaire.
6. Sélectionne un thème et configure les paramètres.
7. Ajoute/import les produits.
8. Configure zones/frais de livraison et mode de paiement.
9. Teste le parcours public → panier → commande → dashboard → WhatsApp.
10. Effectue une sauvegarde initiale.
11. Forme le commerçant et remet les consignes.

**Résultat :** boutique en ligne opérationnelle, compte administrateur remis et tests documentés.

**Erreurs/reprise :** échec base, domaine/SSL, import incomplet ou API Meta indisponible ; corriger et relancer sans dupliquer les produits. La boutique ne doit pas être publiée avant les vérifications essentielles.

## 6.2 Connexion et déconnexion administrateur

1. L’utilisateur ouvre `/admin/login`.
2. Saisit e-mail et mot de passe.
3. Le serveur vérifie le compte actif, le hash, les tentatives et les permissions.
4. En cas de succès, régénère l’identifiant de session et ouvre le dashboard.
5. En cas d’échec, affiche un message générique et applique limitation.
6. Déconnexion : invalide la session serveur, supprime le cookie et redirige vers login.

**Résultat :** accès uniquement à l’utilisateur actif et autorisé.

## 6.3 Mot de passe oublié

1. L’utilisateur saisit son e-mail.
2. Le système affiche un message générique identique que l’adresse existe ou non.
3. Si compte valide, génère un token sécurisé à usage unique et expiration courte.
4. Envoie un lien via e-mail configuré.
5. L’utilisateur définit un nouveau mot de passe.
6. Le token est invalidé et les sessions existantes révoquées selon la politique.

**À valider :** service SMTP, durée du token et politique de révocation.

## 6.4 Configuration initiale de la boutique

1. Propriétaire ouvre Paramètres.
2. Complète les informations générales.
3. Configure contacts client et WhatsApp.
4. Choisit langue, devise et fuseau.
5. Choisit un thème disponible.
6. Personnalise logo, favicon, couleurs et typographies selon capacités du thème.
7. Configure livraison/retrait, zones et frais.
8. Configure les modes de paiement manuels.
9. Prévisualise la boutique.
10. Publie.

**Erreurs :** champ obligatoire manquant, image invalide, thème absent ou paramètre incohérent ; conserver les données saisies et présenter une erreur près du champ.

## 6.5 Parcours catalogue

1. Administrateur ouvre Produits.
2. Crée un produit ou lance un import.
3. Renseigne nom, description, prix, référence, catégorie, images, disponibilité et variantes.
4. Le serveur valide les données.
5. Le produit est enregistré en brouillon.
6. L’administrateur prévisualise puis publie.
7. Le produit apparaît dans le mini-site selon visibilité.

**Résultat :** produit consultable et correctement présenté.

## 6.6 Parcours acheteur

1. Ouvre le lien public depuis WhatsApp, réseau social ou navigateur.
2. Parcourt la page d’accueil, les catégories ou la recherche.
3. Ouvre une fiche produit.
4. Choisit variante/quantité si applicable.
5. Ajoute au panier.
6. Modifie quantités ou retire un produit.
7. Consulte le récapitulatif.
8. Saisit nom, téléphone WhatsApp, adresse/quartier, livraison/retrait, paiement et instructions.
9. Valide.
10. Le serveur revalide prix, disponibilité, quantités, livraison et montant.
11. La commande et ses lignes sont enregistrées transactionnellement.
12. Un numéro unique est attribué.
13. Une page de confirmation affiche le numéro et un bouton WhatsApp avec message prérempli.
14. L’acheteur transmet manuellement le message.
15. Le commerçant consulte la commande et confirme les détails.

**Résultat :** commande persistée ; WhatsApp est une étape de communication distincte.

**Cas d’erreur :** produit indisponible, prix changé, quantité invalide, livraison non desservie, panne serveur ou WhatsApp non installé. Afficher un message clair ; ne pas perdre le panier. Si l’enregistrement échoue, ne pas afficher une commande créée.

## 6.7 Parcours de traitement commerçant

1. Ouvre dashboard.
2. Consulte commandes en attente.
3. Ouvre le détail et vérifie produits, client, montant, livraison et instructions.
4. Contacte le client si nécessaire via WhatsApp.
5. Confirme disponibilité et frais.
6. Met à jour le statut commercial.
7. Confirme manuellement le paiement lorsque reçu.
8. Prépare et expédie ou remet la commande.
9. Marque livrée ou annulée, avec motif si applicable.
10. Les changements sont horodatés et auditables.

## 6.8 Parcours import Meta

1. Administrateur ouvre Applications/Import Meta.
2. Lance OAuth.
3. L’application génère et vérifie `state`.
4. Le commerçant autorise les permissions demandées.
5. Le serveur traite le callback et récupère les catalogues autorisés.
6. Le commerçant choisit un catalogue.
7. L’application affiche un aperçu des produits importables.
8. L’administrateur sélectionne les produits et lance l’import.
9. Le serveur valide, déduplique via identifiant externe et enregistre le résultat.
10. Le rapport affiche succès, ignorés, erreurs et raisons.
11. Une nouvelle importation peut être relancée sans doublon.

**Reprise :** token expiré/révoqué → demande de reconnexion ; API indisponible → conserver le rapport et proposer une nouvelle tentative ; produit absent → marquer non synchronisé, ne pas supprimer automatiquement le produit local.

## 6.9 Parcours changement de thème

1. Administrateur ouvre Apparence.
2. Consulte les thèmes disponibles.
3. Choisit un thème et prévisualise.
4. Ajuste logo, couleurs et polices autorisés.
5. Enregistre le thème actif.
6. Le mini-site utilise le nouveau thème.
7. Les produits, commandes, clients, URLs et paramètres métier restent inchangés.

## 6.10 Suspension ou fermeture

- Suspension compte : bloque login, révoque sessions, conserve données.
- Fermeture boutique : boutique publique désactivée, dashboard accessible aux administrateurs autorisés pour export/archivage selon contrat.
- Suppression des données : procédure documentée et confirmée ; ne pas supprimer automatiquement les données légales ou historiques nécessaires.
- **À valider :** durée de conservation, export avant fermeture et responsabilités contractuelles.

---

# 7. Modules et fonctionnalités

## 7.1 Module d’authentification et de sessions

**Objectif :** protéger l’administration et contrôler l’accès.

**Pages :** connexion, mot de passe oublié, nouveau mot de passe, sessions actives, profil.

**Fonctions :**
- login par adresse e-mail ;
- hash PHP `password_hash()` et vérification `password_verify()` ;
- gestion de session sécurisée ;
- limitation de tentatives ;
- déconnexion ;
- réinitialisation sécurisée ;
- gestion utilisateurs/permissions si activée.

**Données :** utilisateurs, rôles, permissions, sessions, tokens de récupération, logs.

**Règles :**
- e-mail normalisé et unique ;
- compte désactivé = accès refusé ;
- aucune réponse ne révèle l’existence du compte ;
- régénération de session après login et privilège ;
- token de récupération expirant, à usage unique.

**Critères :**
- compte actif avec bon mot de passe accède au dashboard ;
- compte désactivé ne peut pas se connecter ;
- session invalide après logout ;
- brute force limité ;
- token réutilisé/refusé.

## 7.2 Module paramètres boutique

**Objectif :** gérer les informations affichées et les préférences de l’instance.

**Rubriques :**
1. Informations de la boutique.
2. Apparence et identité visuelle.
3. Livraison et retrait.
4. Utilisateurs et permissions.
5. Notifications.
6. Applications et intégrations.
7. Sécurité.
8. Analytics et suivi.
9. Paramètres avancés.

### Informations de boutique

| Champ | Description | Validation |
|---|---|---|
| Nom boutique | Nom commercial public | Obligatoire, longueur limitée |
| Logo | Logo public | MIME image autorisé, taille limitée |
| Favicon | Icône navigateur | Formats image admis |
| Description | Présentation | Longueur limitée, échappement |
| Nom entreprise | Identité juridique | Facultatif/à valider |
| Adresse | Adresse physique | Texte |
| Pays, ville | Localisation | Liste/texte normalisé |
| Téléphone | Contact professionnel | Format contrôlé |
| WhatsApp | Numéro commercial | Format international normalisé |
| E-mail | Contact professionnel | Validation e-mail |
| Langue | Langue principale | Liste supportée |
| Devise | FCFA, EUR, USD, etc. | Liste supportée et cohérente |
| Fuseau | Date/heure | Liste IANA ou choix maîtrisé |

Distinguer profil légal de l’entreprise et contacts affichés aux clients.

### Apparence et identité

- choix des thèmes disponibles ;
- logo/favicon ;
- couleurs principales, secondaires et boutons ;
- typographies ;
- style de cartes produits ;
- disposition catalogue ;
- header/footer ;
- sections accueil ;
- aperçu avant publication.

La personnalisation avancée doit rester bornée par les capacités du thème. Ne pas permettre de modifier directement le code via le dashboard.

### Livraison et retrait

- livraison à domicile ;
- retrait en boutique ;
- villes/zones/quartiers desservis ;
- tarif par zone ;
- activation/désactivation des méthodes ;
- instructions de livraison.

**À valider :** tarif fixe, par quartier, par ville, gratuit à partir d’un montant, minimum de commande, et gestion de plusieurs points de retrait.

### Notifications

Événements possibles :
- confirmation de commande ;
- commande en préparation ;
- commande expédiée ;
- commande livrée ;
- commande annulée ;
- remboursement effectué (non inclus au MVP tant que paiement intégré absent) ;
- création compte ;
- reset mot de passe ;
- nouvelle commande ;
- stock faible/épuisé ;
- nouvelle demande client.

Canaux : e-mail ; WhatsApp seulement si intégration officielle disponible/configurée. Le MVP peut utiliser WhatsApp via ouverture de conversation manuelle, sans notification automatique.

### Applications et intégrations

- WhatsApp Business (numéro et lien de contact) ;
- SMTP/email ;
- Meta catalogue ;
- Google Analytics ;
- Google Search Console ;
- Meta Pixel ;
- Meta Conversions API ;
- Google Tag Manager ;
- import/export produits ;
- API externes/webhooks uniquement si un besoin validé.

Chaque intégration affiche : non configurée, configuration requise, connectée, erreur, permission expirée. Ne pas afficher connecté si le test de connexion n’a pas réussi.

### Sécurité

- changement mot de passe ;
- sessions ;
- déconnexion autres appareils ;
- historique connexion ;
- journal d’activité ;
- tentatives login ;
- permissions ;
- accès API ;
- révocation clés ;
- sauvegardes/restauration.

### Analytics et suivi

- configuration outils externes ;
- suivi événements et conversions ;
- campagnes ;
- ventes ;
- abandons panier lorsque les événements sont réellement collectés et que les règles de confidentialité le permettent.

Les statistiques internes de ventes restent dans le dashboard principal.

## 7.3 Module thèmes et rendu boutique

**Objectif :** donner une identité visuelle professionnelle sans coupler le design aux données.

**Référence design :** le ZIP `MARVENS_CREATIVE_BRIEF...` constitue le cadre de direction artistique, architecture UX, design system, accessibilité et standards frontend. Les thèmes Stitch du dossier `themes/` doivent être inventoriés et utilisés comme templates sélectionnables.

**Exigences :**
- registre des thèmes avec identifiant, nom, aperçu, version, compatibilité et statut ;
- un thème actif par boutique ;
- thème rendu côté serveur ou via templates PHP maîtrisés ;
- données catalogue injectées via ViewModels/DTO, pas dans le code thème ;
- tokens visuels centralisés ;
- responsive ;
- fallback si thème invalide ;
- validation du thème avant activation ;
- aucun thème ne peut modifier les règles de commande, permissions ou requêtes SQL ;
- thème désactivé/retiré ne supprime pas les données ;
- conserver le thème actif et les réglages lors d’une mise à jour.

**À valider :** formats livrés par Stitch, niveau de réécriture nécessaire, nombre de thèmes du MVP et licences des ressources externes.

## 7.4 Module catalogue

**Objectif :** gérer produits, catégories, médias et disponibilité.

**Pages :** liste produits, création/édition, détail, catégories, import, rapport import.

**Champs produit :**
- nom ;
- slug ;
- description ;
- référence/SKU ;
- prix ;
- devise ;
- catégorie ;
- images ;
- disponibilité ;
- visibilité (brouillon/publié/archivé) ;
- mise en avant ;
- promotion (prix promo et dates si activée) ;
- source (manuel, CSV, Meta) ;
- identifiant externe Meta ;
- timestamps.

**Fonctions :**
- créer/modifier ;
- publier/dépublier ;
- supprimer/archiver ;
- catégories et ordre ;
- image principale et galerie ;
- recherche/filtre ;
- variantes (taille, couleur, attribut) si nécessaires ;
- promotion ;
- import CSV/Excel ;
- import Meta multi-produits ;
- rapport d’erreur et reprise.

**Règles :**
- produit public uniquement s’il est publié et disponible ;
- prix non négatif ;
- slug unique dans l’instance ;
- image validée et renommée ;
- produit référencé dans une commande conservé via snapshot ;
- suppression logique si déjà commandé ;
- variante requise si le produit possède des options obligatoires ;
- import ne doit pas écraser une donnée locale non synchronisée sans règle explicite.

**Cas limites :** produit sans image, prix modifié après ajout panier, variante désactivée, doublon SKU, import partiel, catégorie supprimée.

## 7.5 Module mini-site public

**Pages/sections :**
- accueil ;
- catalogue ;
- catégorie ;
- recherche ;
- fiche produit ;
- panier ;
- checkout ;
- confirmation ;
- informations livraison/retour/conditions ;
- contact WhatsApp.

**Fonctions :**
- identité visuelle ;
- produits mis en avant, nouveautés, promotions ;
- recherche ;
- filtre prix ;
- catégories ;
- fiche avec photos, description, prix, référence, variantes et disponibilité ;
- produits similaires si données suffisantes ;
- bouton WhatsApp ;
- partage URL.

**Règles :**
- contenu public échappé ;
- pages indexables selon configuration ;
- pas d’exposition de données administratives ;
- images optimisées ;
- prix et disponibilité affichés depuis serveur ;
- aucune donnée de commande en cache public.

## 7.6 Module panier et checkout

**Objectif :** transformer les choix produits en commande structurée.

**Fonctions :**
- ajout/retrait ;
- quantité ;
- variante ;
- recalcul du sous-total ;
- sélection livraison/retrait ;
- saisie client ;
- mode paiement ;
- instructions ;
- récapitulatif ;
- validation finale.

**Données checkout :**
- nom client ;
- numéro WhatsApp/téléphone ;
- e-mail facultatif ;
- adresse/quartier ;
- ville/zone ;
- livraison ou retrait ;
- mode de paiement configuré ;
- instruction ;
- articles/variantes/quantités.

**Règles métier :**
- serveur revalide prix, disponibilité et variante ;
- montant calculé serveur, jamais confiance au montant navigateur ;
- frais livraison calculés à partir de zone configurée ;
- panier vide impossible à valider ;
- quantité positive et plafonnée ;
- transaction DB atomique pour commande et lignes ;
- snapshots produit (nom, référence, variante, prix unitaire) conservés ;
- numéro de commande unique non séquentiel ou code non devinable ;
- commande enregistrée avant redirection WhatsApp ;
- panier préservé si validation échoue ;
- aucune commande marquée envoyée parce que WhatsApp s’est ouvert.

## 7.7 Module commandes

**Pages :** liste, détail, historique, éventuellement impression/export ultérieur.

**Liste :**
- numéro ;
- date ;
- client ;
- montant ;
- état commande ;
- état paiement ;
- état livraison ;
- recherche ;
- filtre statut, période et client.

**Détail :**
- produits/variantes/quantités ;
- snapshots prix ;
- coordonnées ;
- livraison/retrait ;
- paiement ;
- instructions ;
- historique statuts ;
- actions permises.

### Statuts recommandés

**Statut commande :**
- `pending` — reçue, en attente de traitement ;
- `confirmed` — disponibilité/commande confirmée par commerçant ;
- `preparing` — en préparation ;
- `shipped` — remise au transporteur/en livraison ;
- `delivered` — remise au client ;
- `cancelled` — annulée avec motif.

**Statut paiement séparé :**
- `unpaid` — non confirmé ;
- `pending` — paiement attendu ;
- `paid` — paiement confirmé manuellement ;
- `failed` — échec (si un mode externe est introduit) ;
- `refunded` — remboursé (hors MVP, sauf besoin manuel).

**Statut livraison séparé :**
- `not_required` (retrait ou non applicable) ;
- `pending` ;
- `preparing` ;
- `shipped` ;
- `delivered`;
- `cancelled`.

**État WhatsApp :**
- `not_started`;
- `link_ready`;
- `customer_opened` (uniquement si l’application peut le savoir ; sinon ne pas prétendre) ;
- `unknown`;
- `manual_confirmed_sent` (confirmation manuelle du commerçant, à distinguer d’un statut API).

**Règles :**
- transitions validées côté serveur ;
- changement statut consigné avec acteur, date et ancien/nouveau statut ;
- annulation exige un motif recommandé ;
- une commande livrée ne revient pas à préparation sans action administrative contrôlée ;
- paiement confirmé ne signifie pas automatiquement livré ;
- dashboard ne comptabilise pas une commande en attente comme revenu réalisé.

## 7.8 Module clients

**Objectif :** retrouver les informations clients liées aux commandes.

**Fonctions MVP :**
- fiche client créée/actualisée à partir du checkout ;
- nom, téléphone, e-mail facultatif, adresse/quartier ;
- historique des commandes ;
- recherche téléphone/nom ;
- éviter les doublons simples par téléphone normalisé.

**Confidentialité :**
- accès selon rôle ;
- données minimales ;
- pas d’export complet par défaut ;
- politique de conservation à valider.

## 7.9 Module paiements manuels

Le MVP n’encaisse pas et ne vérifie pas automatiquement les paiements.

**Fonctions :**
- afficher le mode sélectionné ;
- enregistrer état paiement ;
- saisir note/référence éventuelle ;
- marquer payé par un rôle autorisé ;
- historiser l’acteur et l’heure.

**À valider :**
- paiement à la livraison comme choix par défaut ;
- autres modes (Mobile Money ou virement) affichés uniquement si le commerçant les accepte ;
- confirmation manuelle des paiements ;
- traitement des remboursements hors périmètre.

## 7.10 Module livraison et retrait

- activer livraison à domicile ;
- activer retrait en boutique ;
- définir zones, villes, quartiers ;
- tarif par zone ;
- instructions ;
- association à commande ;
- statut livraison.

**À valider :** zone par code postal ou texte, tarif par distance, frais gratuits, minimum commande, délai affiché et gestion multi-adresses.

## 7.11 Module import CSV/Excel

- téléchargement d’un modèle ;
- sélection fichier ;
- validation colonnes ;
- aperçu ;
- import ;
- rapport succès/ignorés/erreurs ;
- possibilité de corriger et relancer.

**Sécurité :** taille et MIME contrôlés ; fichier stocké temporairement hors public ; pas d’exécution ; formule spreadsheet non réexportée sans neutralisation.

## 7.12 Module Meta OAuth et catalogue

**Fonctions :**
- démarrer OAuth ;
- valider `state` ;
- callback ;
- stocker token serveur ;
- afficher catalogues autorisés ;
- sélectionner catalogue ;
- preview ;
- import multi-produits ;
- rapport ;
- reconnecter/déconnecter ;
- synchronisation contrôlée si autorisée.

**Règles de synchronisation :**
- clé externe Meta pour éviter doublons ;
- importer champs accessibles ;
- prix synchronisé uniquement si option active ;
- description locale protégée contre écrasement non désiré ;
- images importées uniquement depuis source autorisée ;
- produit absent marqué non synchronisé, pas supprimé automatiquement ;
- token expiré/révoqué → reconnexion ;
- logs sans token ;
- limites API et permissions respectées.

**Dépendance bloquante :** vérifier les permissions, endpoints, review Meta et l’accès aux catalogues pour le type de compte ciblé avant de promettre une disponibilité générale.

## 7.13 Module dashboard et statistiques

**Dashboard MVP :**
- commandes reçues ;
- commandes en attente ;
- commandes confirmées ;
- commandes livrées ;
- chiffre d’affaires avec définition explicite ;
- produits les plus commandés ;
- commandes récentes ;
- alertes stock faible si suivi activé.

**Définition recommandée du chiffre d’affaires :** somme des commandes `paid` ou `delivered`, selon filtre choisi ; la définition affichée doit être explicite. Les commandes annulées et en attente ne doivent pas être assimilées à du revenu réalisé.

## 7.14 PWA

- manifest ;
- icônes ;
- nom et couleur ;
- mode installable ;
- service worker pour ressources statiques ;
- cache sélectif des pages publiques ;
- stratégie de mise à jour contrôlée ;
- indicateur offline ;
- pages admin, commandes, données client et réponses sensibles non mises en cache ;
- commande/import/changement statut nécessitent serveur.

---

# 8. Classification MoSCoW

| Fonctionnalité | MoSCoW | Justification | Dépendances | Livraison |
|---|---|---|---|---|
| Installation dédiée client | Must | Modèle commercial MVP | cPanel, domaine, DB | MVP |
| Authentification admin | Must | Sécurité dashboard | PHP sessions, DB | MVP |
| Paramètres boutique essentiels | Must | Identité et contacts | Auth | MVP |
| Choix thème Stitch | Must | Boutique personnalisée | Inventaire thèmes, rendu | MVP |
| Personnalisation logo/couleurs | Must | Identité client | Thème, upload sécurisé | MVP |
| Catalogue/catégories | Must | Présentation produit | DB, média | MVP |
| Fiche produit publique | Must | Découverte | Catalogue, thème | MVP |
| Panier | Must | Construction commande | Catalogue | MVP |
| Checkout | Must | Collecte commande | Livraison/paiement | MVP |
| Enregistrement transactionnel | Must | Fiabilité commande | DB transactions | MVP |
| Numéro commande unique | Must | Suivi et référence | DB | MVP |
| WhatsApp prérempli | Must | Canal commercial | Numéro boutique, URL | MVP |
| Dashboard commandes | Must | Traitement | Auth, commandes | MVP |
| Statuts commande | Must | Suivi opérationnel | Historique | MVP |
| Paiement manuel | Must | Le paiement reste séparé | Commandes | MVP |
| Livraison/retrait simple | Must | Calcul et traitement | Paramètres zones | MVP |
| Import CSV/Excel | Should | Facilite catalogues | Parser sécurisé | MVP si besoin pilote / sinon P1 |
| Meta OAuth/catalogue | Should (P0 souhaité dans doc source) | Import officiel et valeur différenciante | App Meta, permissions, review | MVP conditionnel |
| Rapport import et anti-doublons | Must si import livré | Fiabilité | CSV/Meta | MVP |
| Statistiques simples | Should | Pilotage | Commandes | MVP/P1 |
| Comptes secondaires/RBAC avancé | Should | Besoin d’équipe | Auth/permissions | P1 ou pilote |
| Notifications e-mail | Should | Communication | SMTP | P1 |
| Notifications WhatsApp automatiques | Could | Dépend intégration officielle | API WhatsApp | P2 |
| Analytics externes | Could | Mesure marketing | Consentement/config | P1/P2 |
| Export CSV commandes/clients | Should | Opérations/rapport | Permissions, données | P1 |
| Synchronisation Meta planifiée | Could | Mise à jour automatique | Cron, quotas API | P1 |
| Avis clients | Could | Réassurance | modération | P2 |
| Domaine personnalisé avancé | Could | Branding | DNS/SSL | P1 |
| SaaS multi-tenant | Won’t now | Hors modèle MVP | architecture SaaS | Version future |
| Signup autonome | Won’t now | Installation Marvens | SaaS onboarding | Version future |
| Abonnement SaaS/facturation | Won’t now | Pas SaaS | paiement récurrent | Version future |
| Marketplace centrale | Won’t now | Hors périmètre | multi-tenant | Version future |
| Paiement en ligne intégré | Won’t now | Paiement séparé | PSP, conformité | Version future |
| Stock multi-entrepôt | Won’t now | Complexité non nécessaire | inventaire avancé | Version future |
| Application native | Won’t now | PWA suffisante au MVP | mobile | Version future |

**Note de cohérence :** le document MVP source classe l’import Meta parmi les P0, tandis que la disponibilité réelle dépend des permissions Meta. Il est donc fonctionnellement prioritaire, mais sa livraison doit être conditionnée à une validation technique précoce. Si Meta bloque, le MVP reste utilisable avec saisie manuelle et import CSV.

---

# 9. Règles métier

| ID | Règle |
|---|---|
| RB-01 | Chaque instance correspond à un seul commerçant/client dans le MVP. |
| RB-02 | La commande est enregistrée côté serveur avant ouverture WhatsApp. |
| RB-03 | Une commande enregistrée n’est pas automatiquement confirmée. |
| RB-04 | Le commerçant confirme disponibilité, frais et paiement via le processus opérationnel. |
| RB-05 | Le paiement est séparé du statut commande et confirmé manuellement. |
| RB-06 | Les prix et totaux sont recalculés serveur au checkout. |
| RB-07 | Les lignes de commande conservent un snapshot produit, variante, prix et quantité. |
| RB-08 | Les produits non publiés ou indisponibles ne peuvent pas être commandés. |
| RB-09 | Les variantes obligatoires doivent être choisies avant validation. |
| RB-10 | Le panier peut être conservé après erreur de validation. |
| RB-11 | Les frais de livraison proviennent des règles configurées ; aucune estimation client non validée ne doit être inventée. |
| RB-12 | Le retrait en boutique ne doit pas facturer un tarif livraison sauf configuration explicite. |
| RB-13 | Les commandes annulées nécessitent un motif recommandé et restent dans l’historique. |
| RB-14 | Le chiffre d’affaires exclut les commandes en attente et annulées. |
| RB-15 | Un import Meta doit être idempotent : relancer ne crée pas de doublons. |
| RB-16 | Les champs locaux ne sont pas écrasés par Meta sans règle de synchronisation explicite. |
| RB-17 | Un produit absent du catalogue Meta n’est pas supprimé automatiquement. |
| RB-18 | Changer de thème ne modifie aucune donnée métier. |
| RB-19 | Les secrets OAuth restent côté serveur et ne sont jamais affichés dans les pages ou logs. |
| RB-20 | Toutes les actions sensibles sont contrôlées côté serveur et journalisées. |
| RB-21 | Les pages admin et données privées ne sont pas mises en cache par le service worker. |
| RB-22 | Les suppressions référencées par commandes sont logiques ou archivées, pas destructives. |
| RB-23 | Une intégration n’est affichée « connectée » qu’après validation de son état. |
| RB-24 | Les notifications sont envoyées uniquement via les canaux effectivement configurés. |
| RB-25 | L’activation d’un rôle secondaire doit être explicite et soumise à permissions. |

---

# 10. Exigences UX/UI et responsive

## 10.1 Principes

- Mobile First ; priorité au smartphone.
- Interface publique distincte de l’administration.
- Utiliser le framework Creative Brief pour la direction artistique, la structure UX, les tokens, l’accessibilité et les standards.
- Utiliser les thèmes Stitch présents dans `themes/` comme templates sélectionnables, après inventaire et adaptation.
- Les données métier restent indépendantes des templates.
- Formulaires courts, labels explicites, feedback immédiat.
- Actions principales accessibles sans menus complexes.
- Aucun écran ne doit dépendre d’un hover pour révéler une action essentielle.
- Contraste, focus clavier, textes alternatifs, erreurs compréhensibles.
- Prévoir chargement, succès, erreur, vide, offline et indisponibilité.
- Optimiser images et requêtes pour connexions modestes.

## 10.2 Navigation publique

- Accueil
- Catalogue
- Catégories
- Recherche
- Fiche produit
- Panier
- Checkout
- Confirmation commande
- Livraison/retours/conditions
- Contact WhatsApp

## 10.3 Navigation administration

- Dashboard
- Commandes
- Produits
- Catégories
- Clients
- Import catalogue
- Promotions (si MVP)
- Statistiques
- Paramètres
  - Informations boutique
  - Apparence/thèmes
  - Livraison/retrait
  - Utilisateurs/permissions
  - Notifications
  - Applications/intégrations
  - Sécurité
  - Analytics/suivi
  - Paramètres avancés

## 10.4 Pages par rôle

| Page | Propriétaire | Vendeur | Stock | Comptable | Préparateur | Support |
|---|---|---|---|---|---|
| Dashboard | complet | limité | limité | financier | opérationnel | support |
| Commandes | CRUD statuts | traiter | lecture | lecture | préparation/livraison | lecture/notes |
| Produits | complet | consultation/édition selon droit | stock/produit | — | lecture | lecture |
| Clients | complet | nécessaire à vente | — | lecture limitée | données livraison | support |
| Paiement | complet | état limité | — | gestion | — | lecture |
| Livraison | complet | consultation | — | — | mise à jour | lecture |
| Paramètres | complet | — | — | — | — | — |
| Import Meta | complet | — | — | — | — | — |
| Sécurité/logs | complet | — | — | — | — | — |

## 10.5 Composants et états

- champs avec label et aide ;
- validation côté client pour ergonomie et côté serveur pour sécurité ;
- tableaux responsive : cartes sur mobile ou scroll horizontal maîtrisé ;
- recherche avec délai raisonnable, pagination serveur ;
- confirmation pour suppression/annulation ;
- alertes non bloquantes pour succès ;
- erreurs avec action corrective ;
- états vides avec action de démarrage ;
- confirmation de commande avec numéro et état WhatsApp clairement séparé ;
- aperçu thème avant activation ;
- confirmation avant changement d’intégration ou révocation.

## 10.6 Responsive

- téléphone : navigation compacte, CTA visible, formulaire en une colonne, panier lisible ;
- tablette : colonnes adaptées, dashboard compact ;
- desktop : sidebar/dashboard et tableaux enrichis ;
- tests au minimum sur largeurs 360, 390, 768, 1024 et 1440 px (valeurs à valider) ;
- pas de débordement horizontal global ;
- cibles tactiles recommandées ≥ 44 × 44 CSS px.

## 10.7 Accessibilité

- HTML sémantique ;
- labels explicites ;
- navigation clavier ;
- focus visible ;
- contraste WCAG 2.1 AA recommandé ;
- alternatives textuelles ;
- erreurs annoncées et associées au champ ;
- boutons avec libellés compréhensibles ;
- pas de couleur seule pour exprimer un statut ;
- respect `prefers-reduced-motion` ;
- zoom navigateur 200 % sans perte majeure.

---

# 11. Architecture technique

## 11.1 Stack imposée

| Couche | Technologie |
|---|---|
| Backend | PHP 8.3+ Vanilla, MVC modulaire |
| Base | MySQL 8 |
| Accès données | PDO, requêtes préparées |
| Frontend | HTML5, CSS3, JavaScript Vanilla |
| UI | Bootstrap 5 avec personnalisation légère |
| API | REST JSON lorsque utile |
| Hébergement | cPanel mutualisé |
| Configuration | `.env` hors webroot ou `config.php` protégé |
| Production | aucun Node.js, Docker ou processus permanent obligatoire |
| PWA | manifest + service worker contrôlé |

## 11.2 Organisation des dossiers proposée

```text
marvens-shop/
├── app/
│   ├── Core/
│   │   ├── Router.php
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── Session.php
│   │   ├── Auth.php
│   │   ├── Csrf.php
│   │   ├── Validator.php
│   │   ├── Logger.php
│   │   └── View.php
│   ├── Modules/
│   │   ├── Auth/
│   │   ├── Store/
│   │   ├── Theme/
│   │   ├── Catalog/
│   │   ├── Cart/
│   │   ├── Orders/
│   │   ├── Customers/
│   │   ├── Delivery/
│   │   ├── Payments/
│   │   ├── MetaImport/
│   │   ├── CsvImport/
│   │   ├── Analytics/
│   │   ├── Settings/
│   │   └── Users/
│   ├── Services/
│   ├── Repositories/
│   ├── Middleware/
│   └── Views/
│       ├── admin/
│       ├── public/
│       └── emails/
├── config/
│   ├── app.php
│   ├── database.php
│   └── permissions.php
├── database/
│   ├── migrations/
│   ├── seeds/
│   └── schema.sql
├── public/
│   ├── index.php
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── themes/
│   │   └── [theme-id]/
│   ├── manifest.webmanifest
│   └── service-worker.js
├── themes/
│   ├── registry.php
│   └── [theme-id]/
│       ├── templates/
│       ├── assets/
│       └── theme.json
├── storage/
│   ├── uploads/
│   ├── imports/
│   ├── exports/
│   ├── logs/
│   ├── cache/
│   └── backups/
├── routes/
│   ├── web.php
│   └── api.php
├── tests/
│   ├── Unit/
│   ├── Integration/
│   └── Functional/
├── .env.example
├── .htaccess
└── README_DEPLOYMENT.md
```

**Règle webroot :** idéalement le document root du domaine pointe vers `public/`. Si l’hébergement cPanel ne permet pas cette configuration, les dossiers `app`, `config`, `database`, `storage`, `themes` doivent être hors `public_html` et seuls les assets publics sont exposés.

## 11.3 Responsabilités des composants

- **Router** : mapping URL/méthode vers contrôleur, gestion 404/405.
- **Controller** : orchestration HTTP, validation entrée, appel services, réponse.
- **Service** : règles métier, transactions et orchestration.
- **Repository/Model** : accès PDO, requêtes SQL, mapping données.
- **View** : rendu HTML, échappement contextuel, layout.
- **Middleware** : authentification, rôle, CSRF, throttling, headers.
- **Core** : sessions, config, logs, réponses JSON et exceptions.
- **Theme renderer** : charge template approuvé et variables de présentation.
- **Import service** : validation, normalisation, anti-doublons et rapport.

## 11.4 Principes d’architecture

- MVC strict : contrôleur sans SQL direct ; logique métier dans services ; SQL dans repositories.
- PDO avec requêtes préparées.
- Transactions pour commande et lignes.
- Services idempotents pour import.
- Configuration centralisée par instance.
- Migrations versionnées.
- Aucun secret dans le dépôt.
- API REST uniquement pour actions nécessitant JSON/asynchronisme ; formulaire classique possible pour pages simples.
- Aucun endpoint d’admin sans middleware.
- Pas de framework backend supplémentaire.

---

# 12. Modèle de données

## 12.1 Principes

- Une instance = une boutique ; pas de `tenant_id` obligatoire dans le MVP. Le futur SaaS devra ajouter un cloisonnement tenant partout.
- Clés primaires numériques internes ; identifiants publics non devinables pour commande.
- Timestamps `created_at`, `updated_at` ; `deleted_at` pour suppression logique si nécessaire.
- Snapshots dans lignes de commande.
- Historique des transitions.
- Index sur les champs de recherche/filtre.
- Utiliser `DECIMAL` pour prix si devises à décimales ; pour FCFA, stockage entier possible mais format de devise à valider.
- UTF-8 `utf8mb4`.
- Suppression restrictive sur commande et lignes ; éviter cascade destructive.

## 12.2 Entités principales

| Table | Champs essentiels (indicatifs) | Clés/index |
|---|---|---|
| `store_settings` | id, store_name, legal_name, description, logo_path, favicon_path, address, country, city, phone, whatsapp, email, language, currency, timezone, active_theme_id, status, created_at, updated_at | PK id ; unique éventuel domaine |
| `users` | id, name, email, password_hash, status, last_login_at, password_changed_at, created_at, updated_at, deleted_at | PK ; unique email |
| `roles` | id, code, name, description | unique code |
| `permissions` | id, code, label | unique code |
| `user_roles` | user_id, role_id | PK composite ; FK |
| `role_permissions` | role_id, permission_id | PK composite ; FK |
| `categories` | id, name, slug, description, sort_order, status, created_at, updated_at, deleted_at | unique slug ; index status/order |
| `products` | id, category_id, name, slug, description, sku, price, currency, status, availability, featured, promotion_price, promotion_start, promotion_end, source, external_source_id, sync_enabled, created_at, updated_at, deleted_at | unique slug ; unique source/external id ; index category/status |
| `product_media` | id, product_id, path, alt_text, sort_order, is_primary, created_at | FK ; index product/order |
| `product_variants` | id, product_id, name, sku, attributes_json, price_override, availability, status, created_at, updated_at | FK ; unique SKU selon règle |
| `customers` | id, name, phone_normalized, email, address, city, neighborhood, created_at, updated_at | index phone ; e-mail facultatif |
| `orders` | id, public_order_code, customer_id, order_status, payment_status, delivery_status, whatsapp_status, subtotal, delivery_fee, total, currency, delivery_method, payment_method, address_snapshot, customer_name_snapshot, phone_snapshot, instructions, cancellation_reason, created_at, updated_at | unique public code ; index date/status/customer |
| `order_items` | id, order_id, product_id nullable, variant_id nullable, product_name_snapshot, sku_snapshot, variant_snapshot, unit_price_snapshot, quantity, line_total | FK order ; index order |
| `order_status_history` | id, order_id, actor_user_id nullable, old_status, new_status, note, created_at | index order/date |
| `payment_records` | id, order_id, status, method, amount, reference, note, confirmed_by, confirmed_at, created_at | index order/status |
| `delivery_zones` | id, name, city, neighborhood, fee, active, sort_order | index city/active |
| `theme_registry` | id, theme_code, name, version, preview_path, status, compatibility_json | unique theme_code |
| `store_theme_settings` | id, theme_code, settings_json, active, updated_at | unique active (règle applicative) |
| `meta_connections` | id, external_user_id, token_ciphertext, token_expires_at, scopes_json, status, connected_at, updated_at | token jamais lisible en clair |
| `meta_catalogs` | id, connection_id, external_catalog_id, name, last_import_at, status | unique connection/external catalog |
| `import_jobs` | id, source, catalog_id nullable, file_path nullable, status, total_count, success_count, skipped_count, error_count, report_json, started_by, created_at, completed_at | index status/date |
| `import_items` | id, job_id, external_id nullable, product_id nullable, status, error_code, error_message, created_at | index job/status |
| `notification_settings` | id, event_code, channel, enabled, configuration_json | unique event/channel |
| `integration_settings` | id, provider, status, config_json, last_test_at, last_error_code | unique provider |
| `password_reset_tokens` | id, user_id, token_hash, expires_at, used_at, created_at | index user/expiry |
| `login_attempts` | id, email_hash, ip_hash, result, created_at | index email/time |
| `audit_logs` | id, actor_user_id nullable, event_code, entity_type, entity_id, outcome, correlation_id, metadata_json, created_at | index event/date/entity |
| `app_settings` | id, setting_key, setting_value, updated_at | unique key |

## 12.3 Relations

- Category 1—N Products.
- Product 1—N Media.
- Product 1—N Variants.
- Customer 1—N Orders.
- Order 1—N Order Items.
- Order 1—N Status History.
- Order 1—N Payment Records.
- Meta Connection 1—N Catalogs.
- Import Job 1—N Import Items.
- User N—N Roles.
- Role N—N Permissions.

## 12.4 Indexes et contraintes

- Unique `users.email` après normalisation.
- Unique `products.slug`.
- Unique `(source, external_source_id)` lorsque l’identifiant externe est renseigné.
- Unique `orders.public_order_code`.
- Index `orders(order_status, created_at)`.
- Index `orders(payment_status, created_at)`.
- Index `orders(customer_id, created_at)`.
- Index `products(category_id, status)`.
- Index `products(status, featured)`.
- Index `customers(phone_normalized)`.
- Index `order_status_history(order_id, created_at)`.
- Foreign keys avec `RESTRICT`/`SET NULL` selon conservation historique.
- Quantité > 0 ; prix et frais >= 0 ; total cohérent calculé côté serveur.
- Unicité d’un thème actif garantie par logique applicative et transaction.

## 12.5 Dictionnaire synthétique

| Donnée | Type recommandé | Description |
|---|---|---|
| `id` | BIGINT UNSIGNED | Identifiant interne |
| `public_order_code` | VARCHAR(32) | Référence commande non devinable |
| `status` | VARCHAR/ENUM contrôlé | État métier |
| `price`, `total`, `fee` | DECIMAL(12,2) ou BIGINT | Montants ; format final à valider |
| `currency` | CHAR(3) | ISO devise |
| `phone_normalized` | VARCHAR(20) | Téléphone international normalisé |
| `slug` | VARCHAR(180) | URL lisible, unique |
| `attributes_json` | JSON | Attributs de variante |
| `settings_json` | JSON | Paramètres de thème/configuration |
| `token_ciphertext` | TEXT/BLOB | Token OAuth chiffré |
| `created_at` | DATETIME | Création |
| `updated_at` | DATETIME | Dernière modification |
| `deleted_at` | DATETIME NULL | Suppression logique |
| `correlation_id` | VARCHAR(64) | Diagnostic d’une requête |

**À valider :** prix entier ou décimal, prise en charge multi-devise, durée de conservation, suppression/anonymisation, politique de stock.

---

# 13. API REST JSON

Les endpoints ci-dessous sont proposés uniquement pour les actions qui bénéficient d’une API. Les pages publiques et formulaires simples peuvent utiliser des routes web classiques. Toutes les routes admin exigent session authentifiée, permission, CSRF lorsque requête navigateur mutative, validation serveur et limitation de débit.

## 13.1 Format de réponse standard

Succès :

```json
{
  "success": true,
  "data": {},
  "meta": {
    "correlation_id": "..."
  }
}
```

Erreur :

```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Vérifiez les champs renseignés.",
    "fields": {}
  },
  "meta": {
    "correlation_id": "..."
  }
}
```

Ne pas renvoyer stack trace, SQL, chemin serveur, token, hash ou données d’un autre utilisateur.

## 13.2 Endpoints proposés

| Méthode / URL | Rôle | Entrées/validation | Réponse et erreurs |
|---|---|---|---|
| `POST /api/admin/login` | Public | email, password, CSRF, rate limit | 200 session ; 401 générique ; 429 |
| `POST /api/admin/logout` | Auth | CSRF | 204/200 ; 401 |
| `POST /api/admin/password/forgot` | Public | email, rate limit | message générique 200 |
| `POST /api/admin/password/reset` | Public | token, nouveau password | 200 ; 400 token invalide ; 422 |
| `GET /api/admin/products` | Admin catalogue | page, q, status, category | liste paginée ; 403/422 |
| `POST /api/admin/products` | Permission products.create | produit, CSRF, validation | 201 ; 422 |
| `GET /api/admin/products/{id}` | Permission products.read | ID validé | 200 ; 404 |
| `PUT /api/admin/products/{id}` | products.update | champs validés | 200 ; 404/422 |
| `POST /api/admin/products/{id}/publish` | products.publish | CSRF | 200 ; 409 si incohérent |
| `POST /api/admin/products/{id}/archive` | products.delete/archive | CSRF | 200 ; 409 si dépendance |
| `GET /api/admin/categories` | products.read | pagination | 200 |
| `POST /api/admin/categories` | categories.create | nom/slug | 201 ; 422 |
| `GET /api/public/products` | Public | q, category, price range, page | liste publiée ; 422 paramètres invalides |
| `GET /api/public/products/{slug}` | Public | slug | 200 ; 404 |
| `POST /api/public/orders` | Public | items, customer, delivery, payment, instructions ; honeypot/rate limit | 201 avec code commande ; 422/409/429 |
| `GET /api/admin/orders` | orders.read | statut, période, client, pagination | liste |
| `GET /api/admin/orders/{id}` | orders.read | ID | détail ; 404 |
| `POST /api/admin/orders/{id}/status` | orders.update | statut, note, CSRF | 200 ; 409 transition invalide |
| `POST /api/admin/orders/{id}/payment` | payments.update | status, reference, note | 200 ; 422 |
| `GET /api/admin/customers` | customers.read | q, page | liste |
| `GET /api/admin/customers/{id}` | customers.read | ID | détail/historique |
| `GET /api/admin/delivery-zones` | settings.read | — | zones |
| `POST /api/admin/delivery-zones` | settings.delivery | zone, fee, active | 201 |
| `PUT /api/admin/delivery-zones/{id}` | settings.delivery | champs | 200 |
| `GET /api/admin/themes` | Auth settings.read | — | thèmes compatibles |
| `POST /api/admin/themes/preview` | settings.theme | theme_code, settings | preview non persistante |
| `POST /api/admin/themes/activate` | settings.theme | theme_code, settings, CSRF | 200 |
| `GET /api/admin/meta/catalogs` | integration.meta | connexion valide | catalogues ; 401 token |
| `POST /api/admin/meta/import` | integration.meta | catalog_id, product_ids | 202 job ; 422/429 |
| `GET /api/admin/import-jobs/{id}` | import.read | ID | rapport |
| `POST /api/admin/import-jobs/{id}/retry` | import.execute | CSRF | 202 |
| `POST /api/admin/meta/disconnect` | integration.meta | CSRF | 200 |
| `GET /api/admin/dashboard` | dashboard.read | période | KPI |
| `GET /api/admin/audit-logs` | audit.read | période, event, pagination | logs filtrés |

## 13.3 Codes HTTP

- `200` succès.
- `201` ressource créée.
- `202` traitement asynchrone accepté.
- `204` succès sans corps.
- `400` requête mal formée.
- `401` non authentifié.
- `403` permission insuffisante.
- `404` ressource inconnue ou inaccessible.
- `409` conflit d’état, doublon ou transition invalide.
- `422` validation métier.
- `429` limite atteinte.
- `500` erreur interne générique.

## 13.4 Protection API

- session cookie sécurisée pour dashboard ;
- CSRF sur mutateurs navigateur ;
- rate limiting login, commande, import et reset ;
- validation JSON et Content-Type ;
- limites pagination et taille payload ;
- permission par route et ressource ;
- ID public non devinable pour commande ;
- logs avec correlation ID ;
- jamais de token dans query string ;
- CORS fermé par défaut (même origine) ;
- endpoints webhook uniquement si intégration réelle et signature validée.

---

# 14. Sécurité

## 14.1 Authentification et mots de passe

- E-mail normalisé.
- `password_hash()` avec `PASSWORD_ARGON2ID` si disponible ; sinon bcrypt correctement configuré.
- `password_verify()` et `password_needs_rehash()`.
- politique de mot de passe robuste ; ne pas stocker en clair.
- reset token aléatoire, hashé en base, expiration et usage unique.
- réponse générique pour login et reset.
- limitation progressive et journaux des échecs.
- MFA administrateur recommandé si faisable ; **À valider** pour MVP.

## 14.2 Sessions et cookies

- HTTPS obligatoire.
- cookies `Secure`, `HttpOnly`, `SameSite=Lax` ou politique adaptée.
- `session.use_strict_mode=1`.
- régénérer ID après login/élévation.
- durée d’inactivité et durée absolue **À valider**.
- invalidation serveur au logout/suspension.
- pas de session ID dans URL.
- pas de données sensibles dans localStorage.

## 14.3 CSRF, XSS, SQL injection

- token CSRF sur formulaire et actions mutatives.
- vérification Origin/Referer comme défense additionnelle.
- échappement contextuel des vues.
- éviter HTML utilisateur ; si contenu riche, sanitizer allowlist.
- PDO préparé pour toutes valeurs SQL.
- noms de colonnes/tri whitelistés, non interpolés arbitrairement.
- validation serveur systématique.
- CSP adaptée ; `X-Content-Type-Options: nosniff`, protection clickjacking, `Referrer-Policy`, HSTS après HTTPS confirmé.

## 14.4 Autorisations

- contrôle rôle/permission dans middleware et service.
- vérifier propriété de chaque ressource.
- ne pas considérer un ID opaque comme autorisation.
- vérifier permission au niveau action, pas seulement menu.
- accès support Marvens limité, autorisé et audité.
- permissions secondaires minimales.

## 14.5 Uploads

- allowlist formats image (JPEG, PNG, WebP ; SVG uniquement si sanitization sûre et besoin confirmé).
- contrôle MIME réel via `finfo`, extension et taille.
- nom généré par serveur, jamais nom fourni directement.
- stockage hors webroot ou répertoire non exécutable.
- ré-encodage images si possible.
- limite de dimensions et poids.
- protection path traversal.
- pas d’exécution PHP dans upload.
- fichier temporaire supprimé après import.
- accès privé aux exports et sauvegardes.

## 14.6 Secrets et intégrations

- `.env` hors public ; permissions minimales.
- `.env.example` sans secret.
- token Meta chiffré au repos si possible.
- clé de chiffrement hors DB et dépôt.
- jamais token dans logs, HTML, URL ou JS.
- rotation/revocation.
- scopes strictement nécessaires.
- callback OAuth vérifié et `state` aléatoire.
- déconnexion supprime/révèle pas token.
- webhook signature et replay protection si utilisés.

## 14.7 Données personnelles

- collecter uniquement données de commande nécessaires.
- expliquer usage des coordonnées.
- accès selon rôle.
- logs minimisés.
- exports protégés.
- politique de conservation et suppression **À valider**.
- données fictives en test.
- commande publique non accessible par ID séquentiel seul.

## 14.8 Sauvegarde et restauration

- sauvegarde DB et fichiers médias.
- stockage protégé, hors accès public.
- fréquence **À valider** ; recommandation initiale quotidienne DB et hebdomadaire fichiers pour pilote selon volume.
- rétention **À valider**.
- sauvegarde avant mise à jour.
- restauration testée sur instance de test.
- documenter procédure et responsable.
- surveiller espace disque et échec cron.

## 14.9 Hébergement et sécurité opérationnelle

- PHP maintenu et extensions nécessaires activées.
- HTTPS valide.
- permissions minimales.
- cPanel, SFTP/SSH limité si disponible.
- désactiver debug en production.
- supprimer fichiers install, dumps et backups publics.
- WAF/CDN si disponible.
- anti-spam et rate limit.
- procédure incident : isolation, rotation secrets, restauration, diagnostic, notification contractuelle.

---

# 15. Exigences non fonctionnelles

Les valeurs proposées sans source sont des objectifs initiaux **À valider** après mesure sur l’hébergement du pilote.

| ID | Domaine | Exigence mesurable proposée |
|---|---|---|
| NFR-01 | Performance | Pages publiques principales chargées en ≤ 3 s sur connexion mobile raisonnable pour catalogue de référence ; À valider par test. |
| NFR-02 | Backend | 95e percentile des pages simples ≤ 1,5 s hors API externe ; À valider selon hébergeur. |
| NFR-03 | Checkout | Enregistrement commande ≤ 3 s hors latence réseau ; pas de double commande en cas de double clic. |
| NFR-04 | Disponibilité | Objectif pilote ≥ 99 % mensuel hors maintenance et incidents hébergeur ; À valider contractuellement. |
| NFR-05 | Sécurité | Aucun secret exposé dans HTML/JS/logs ; tests OWASP de base avant mise en production. |
| NFR-06 | Auth | Rate limiting actif ; session renouvelée après login ; cookie sécurisé HTTPS. |
| NFR-07 | Fiabilité | Commande et lignes atomiques ; échec transaction = aucune commande partielle. |
| NFR-08 | Idempotence | Import relancé sans doublons ; checkout protégé contre soumission répétée via token/idempotency key si implémenté. |
| NFR-09 | Responsive | Fonctionnel à 360 px, 390 px, 768 px, 1024 px et 1440 px ; À valider sur appareils cibles. |
| NFR-10 | Accessibilité | WCAG 2.1 AA comme objectif ; focus, labels, contraste et clavier vérifiés. |
| NFR-11 | Compatibilité | Dernières versions stables de Chrome, Firefox, Edge, Safari mobile ; version exacte à valider. |
| NFR-12 | Réseau modeste | Images optimisées, pagination, JS léger, pas d’autoplay média ; test 3G simulé recommandé. |
| NFR-13 | Maintenabilité | Modules isolés, migrations versionnées, conventions PHP documentées, tests automatisés critiques. |
| NFR-14 | Évolutivité | Instance dédiée pouvant supporter catalogue et commandes pilote ; limites de volume à mesurer. |
| NFR-15 | PWA | Installable si navigateur compatible ; aucune donnée sensible en cache. |
| NFR-16 | Logs | Erreurs avec correlation ID ; rotation et rétention définies ; secrets et données sensibles exclus. |
| NFR-17 | Backup | Backup DB et médias ; restauration testée avant pilote et périodiquement. |
| NFR-18 | cPanel | Déploiement sans Node, Docker, root ou processus permanent. |
| NFR-19 | Upload | taille maximale configurable ; validation MIME/extension ; refus des fichiers exécutables. |
| NFR-20 | Confidentialité | accès à données client restreint ; politique de conservation documentée avant commercialisation. |

## 15.1 Compatibilité cPanel

- PHP 8.3 disponible, sinon installation refusée ou version cible ajustée explicitement.
- MySQL 8 compatible ; vérifier version réelle du serveur.
- extensions nécessaires : PDO MySQL, mbstring, fileinfo, openssl, json, curl, éventuellement GD.
- cron cPanel seulement si import planifié/sauvegarde automatisée est activée.
- tâches longues découpées ou déclenchées par cron ; pas de worker permanent.
- limites mémoire, temps d’exécution, upload et disque mesurées avant pilote.

---

# 16. Journalisation et gestion des erreurs

## 16.1 Catégories

- `auth` : login, logout, reset, verrouillage.
- `admin_action` : modifications sensibles.
- `catalog` : création, publication, suppression, import.
- `order` : création, changement de statut, annulation.
- `payment` : confirmation manuelle.
- `integration` : OAuth, import Meta, erreurs API.
- `security` : CSRF, permission refusée, upload rejeté.
- `system` : exception, DB, configuration, cron.
- `backup` : succès/échec backup/restauration.

## 16.2 Niveaux

| Niveau | Usage |
|---|---|
| DEBUG | détails temporaires en développement ; désactivé en production |
| INFO | opérations normales utiles |
| WARNING | situation récupérable, import partiel, permission/API dégradée |
| ERROR | action échouée, exception traitée |
| CRITICAL | indisponibilité, corruption, compromission ou perte de données possible |

## 16.3 Événements à enregistrer

- authentification réussie/échouée ;
- suspension/désactivation ;
- changement de rôle/permission ;
- changement paramètres sensibles ;
- import Meta/CSV, résultats et erreurs ;
- création commande et changements statut ;
- paiement marqué ;
- changement thème ;
- backup/restauration ;
- erreur serveur ;
- tentative d’accès interdit.

## 16.4 Données interdites dans les logs

- mots de passe ;
- tokens OAuth ;
- clés API ;
- cookies/session IDs ;
- données de paiement sensibles ;
- contenu complet des messages clients sans nécessité ;
- données personnelles excessives ;
- secrets de configuration.

## 16.5 Format et conservation

- logs centralisés sous `storage/logs`, hors public ;
- format structuré JSON ou lignes cohérentes ;
- timestamp UTC + timezone de présentation ;
- correlation ID par requête ;
- rotation quotidienne ou par taille ;
- rétention **À valider**, recommandation 30 à 90 jours pour logs opérationnels selon stockage ;
- logs de sécurité conservés selon politique ;
- accès réservé.

## 16.6 Messages utilisateur

- succès : « La commande a été enregistrée. Votre référence est … »
- erreur de validation : expliquer le champ à corriger ;
- erreur technique : « Une erreur est survenue. Réessayez plus tard. Référence : … »
- Meta : expliquer reconnexion/permission manquante sans exposer token ;
- offline : signaler que l’action nécessite internet ;
- ne jamais afficher SQL, chemin local, stack trace ou détails serveur.

---

# 17. Déploiement cPanel

## 17.1 Préparation

1. Vérifier domaine/sous-domaine et DNS.
2. Vérifier certificat HTTPS.
3. Vérifier PHP 8.3+, extensions et limites.
4. Vérifier MySQL 8.
5. Vérifier espace disque, mémoire et upload.
6. Créer base MySQL et utilisateur dédié à privilèges limités.
7. Préparer dossier de stockage hors webroot.
8. Définir le document root vers `public/` si possible.

## 17.2 Installation

1. Transférer les fichiers par SFTP ou gestionnaire cPanel.
2. Placer le code non public hors webroot.
3. Créer/importer le schéma SQL ou exécuter les migrations.
4. Configurer `.env`/`config.php` protégé.
5. Définir URL, DB, mail, clé de chiffrement, timezone.
6. Configurer le domaine et réécriture.
7. Créer dossiers `storage/uploads`, `imports`, `exports`, `logs`, `backups`.
8. Appliquer permissions minimales ; pas de `777` permanent.
9. Créer compte admin initial via procédure sécurisée.
10. Désactiver mode debug.
11. Configurer cron si besoin.
12. Activer headers/HTTPS.
13. Exécuter checklist post-déploiement.
14. Effectuer backup initial.
15. Former le client.

## 17.3 Checklist post-déploiement

- [ ] HTTPS et certificat valides.
- [ ] PHP version/extensions conformes.
- [ ] Connexion MySQL fonctionnelle.
- [ ] Webroot ne révèle pas `app/config/storage/database`.
- [ ] `.env` inaccessible depuis le web.
- [ ] Login admin fonctionne.
- [ ] Permissions contrôlées.
- [ ] Produit test créé et publié.
- [ ] Image upload validée.
- [ ] Panier et checkout testés.
- [ ] Commande enregistrée avant WhatsApp.
- [ ] Numéro commande unique.
- [ ] Dashboard et statuts testés.
- [ ] Livraison/retrait configurés.
- [ ] Paiement manuel configuré.
- [ ] Meta OAuth testé si livré.
- [ ] Logs sans secrets.
- [ ] Service worker ne cache pas pages sensibles.
- [ ] Backup et restauration vérifiés.
- [ ] Fichiers d’installation/dumps supprimés.
- [ ] Accès Marvens documenté et autorisé.
- [ ] Formation effectuée.
- [ ] PV de recette signé ou validation client documentée.

## 17.4 Maintenance

- corrections bugs ;
- mises à jour de sécurité ;
- compatibilité PHP ;
- sauvegardes ;
- contrôle espace disque ;
- surveillance certificat ;
- diagnostic intégration Meta ;
- procédure incident ;
- documentation des interventions.

**À valider contractuellement :** SLA, heures support, délais de réponse, fréquence backup, responsabilité domaine/hébergement, accès Marvens et coûts.

---

# 18. Stratégie de tests

## 18.1 Niveaux

- **Unitaires :** règles de calcul, validation, permissions, transitions, normalisation.
- **Intégration :** PDO/DB, transactions, upload, import, OAuth callback, mail.
- **Fonctionnels :** parcours utilisateur complet.
- **Sécurité :** CSRF, XSS, SQLi, auth, sessions, upload, permissions.
- **Responsive :** mobile/tablette/desktop.
- **PWA :** installation, cache, offline, update.
- **Ops :** backup/restauration, déploiement, cron.
- **Recette :** validation du commerçant.

## 18.2 Scénarios fonctionnels

| ID | Scénario | Résultat attendu |
|---|---|---|
| T-001 | Login valide | Dashboard ouvert, session régénérée |
| T-002 | Login invalide | Message générique, compteur/limite appliqué |
| T-003 | Compte désactivé | Accès refusé |
| T-004 | Logout | Session invalidée |
| T-005 | Reset token valide | Mot de passe changé, token invalidé |
| T-006 | Créer produit valide | Produit enregistré en brouillon |
| T-007 | Publier produit | Produit visible public |
| T-008 | Produit non publié | Produit inaccessible public |
| T-009 | Upload mauvais MIME | Fichier refusé |
| T-010 | Panier quantités | Sous-total correct |
| T-011 | Variante obligatoire manquante | Validation bloque |
| T-012 | Prix changé après panier | Checkout recalcule et informe |
| T-013 | Zone non desservie | Checkout bloque avec explication |
| T-014 | Checkout valide | Commande et lignes persistées atomiquement |
| T-015 | Double soumission | Pas de doublon involontaire |
| T-016 | WhatsApp ouvre | Commande reste enregistrée, état message distinct |
| T-017 | Transition statut invalide | 409/refus, aucune modification |
| T-018 | Paiement manuel | Statut payment mis à jour et audit |
| T-019 | Commande annulée | Motif et historique conservés |
| T-020 | Import CSV valide | Produits importés et rapport |
| T-021 | CSV invalide | Erreurs ligne par ligne, pas d’import silencieux |
| T-022 | Import Meta relancé | Pas de doublons |
| T-023 | Token Meta expiré | Reconnexion demandée |
| T-024 | Produit absent Meta | Produit local conservé |
| T-025 | Changer thème | Données catalogue/commande inchangées |
| T-026 | Dashboard KPI | Commandes pending exclues du revenu réalisé |
| T-027 | Permission vendeur | Accès aux actions autorisées uniquement |
| T-028 | CSRF invalide | Mutation refusée |
| T-029 | Tentative SQL injection | Aucun SQL exécuté, entrée rejetée/traitée |
| T-030 | XSS produit | Contenu échappé |
| T-031 | Service worker offline | Pages sensibles non accessibles depuis cache |
| T-032 | Backup/restauration | Instance restaurée et vérifiée |
| T-033 | Responsive mobile | Aucun débordement, checkout utilisable |
| T-034 | Logs | correlation ID présent, secret absent |
| T-035 | Installation cPanel | Déploiement sans Node/Docker/root |

## 18.3 Tests sécurité minimaux

- SQL injection sur recherche, login, paramètres, filtres.
- XSS stockée et réfléchie sur produits, catégories, instructions et notes.
- CSRF sur toutes mutations admin.
- IDOR/BOLA sur commande, client, produit et import.
- fixation de session.
- brute force login/reset.
- upload double extension, MIME falsifié, path traversal, fichier PHP.
- accès direct `.env`, logs, backups, SQL.
- OAuth state, callback, token expiré/révocation.
- rate limiting checkout/import.
- headers HTTP.
- contrôle permissions.
- secrets absents du frontend et des logs.

## 18.4 Recette commerçant

Le commerçant valide :
- identité et thème ;
- affichage produits ;
- livraison et paiement ;
- commande réelle de test ;
- WhatsApp ;
- dashboard ;
- statut ;
- formation ;
- procédures de support.

Une fonctionnalité est considérée terminée seulement lorsque les critères d’acceptation et les tests associés sont passés.

---

# 19. Critères d’acceptation (Given / When / Then)

| ID | Étant donné | Lorsque | Alors |
|---|---|---|---|
| AC-01 | Une boutique installée et configurée | Un visiteur ouvre son domaine | La boutique publique s’affiche en responsive avec identité et produits publiés |
| AC-02 | Un produit publié et disponible | Le visiteur ouvre sa fiche | Nom, prix, images, référence et variantes disponibles sont affichés |
| AC-03 | Un produit non publié | Le visiteur tente d’ouvrir son URL | Le produit n’est pas accessible publiquement |
| AC-04 | Un panier contient des produits valides | Le client modifie les quantités | Le total est recalculé correctement |
| AC-05 | Un panier contient une variante obligatoire non choisie | Le client soumet checkout | Le serveur refuse et identifie le choix manquant |
| AC-06 | Un panier est valide | Le client confirme la commande | Le serveur revalide prix/disponibilité et enregistre commande + lignes dans une transaction |
| AC-07 | La commande est enregistrée | Le site ouvre WhatsApp | Le message contient numéro et détails essentiels ; l’état de commande n’est pas automatiquement confirmé |
| AC-08 | La commande est enregistrée | Le client ne transmet pas WhatsApp | La commande reste visible au dashboard avec état de transmission non confirmé |
| AC-09 | Un commerçant authentifié a orders.read | Il ouvre le dashboard | Il voit uniquement les commandes de son instance |
| AC-10 | Un vendeur sans permission paiement | Il tente de marquer payé | Le serveur refuse et journalise l’accès |
| AC-11 | Une commande est pending | Le commerçant la confirme | Statut devient confirmed et historique contient acteur/date |
| AC-12 | Une commande est pending | Le commerçant tente delivered directement | Transition refusée si la règle de transition l’interdit |
| AC-13 | Une commande est annulée | Un utilisateur consulte l’historique | Motif et statut restent visibles aux rôles autorisés |
| AC-14 | Paiement non confirmé | Dashboard calcule revenu réalisé | La commande n’est pas comptée comme payée |
| AC-15 | Un produit est importé depuis Meta | Le même import est relancé | Aucun doublon n’est créé |
| AC-16 | Un produit local a description modifiée | Import Meta est relancé | La description locale n’est pas écrasée sans règle de synchronisation explicite |
| AC-17 | Token Meta est révoqué | Import est lancé | L’import échoue proprement et demande reconnexion |
| AC-18 | Un produit disparaît de Meta | Synchronisation est effectuée | Produit local conservé et marqué non synchronisé |
| AC-19 | Le commerçant change thème | Le mini-site est rechargé | Nouveau thème visible, produits/commandes inchangés |
| AC-20 | Un fichier uploadé est exécutable ou MIME invalide | L’utilisateur tente upload | Fichier rejeté, non exécuté et événement journalisé |
| AC-21 | Une session admin est déconnectée | L’ancien cookie est réutilisé | L’accès est refusé |
| AC-22 | Une mutation admin sans CSRF valide | Requête est soumise | Le serveur refuse la mutation |
| AC-23 | Une erreur serveur survient | L’utilisateur reçoit la réponse | Message générique et correlation ID, sans détail technique |
| AC-24 | Une sauvegarde est réalisée | Elle est restaurée en environnement de test | DB et médias sont récupérables et vérifiés |
| AC-25 | Service worker actif | L’utilisateur est offline | Aucune commande/admin sensible n’est servie depuis cache |
| AC-26 | L’instance est installée sur cPanel | Checklist est exécutée | Application fonctionne sans Node, Docker ni root |
| AC-27 | Utilisateur secondaire est désactivé | Il tente login | Login refusé et sessions invalidées |
| AC-28 | Zone livraison configurée | Client choisit cette zone | Frais corrects sont ajoutés au total |
| AC-29 | Client choisit retrait | Checkout calcule le total | Aucun frais livraison non configuré n’est ajouté |
| AC-30 | Paramètre boutique requis manque | Publication est tentée | Publication bloquée avec liste des champs à corriger |

---

# 20. Risques et dépendances

| ID | Risque | Probabilité/impact | Mesure de réduction |
|---|---|---|---|
| R-01 | Permissions/API Meta insuffisantes | Moyen/Élevé | Spike technique avant implémentation ; import CSV/manual en fallback |
| R-02 | Revue Meta ou changement API | Moyen/Élevé | Permissions minimales, tests périodiques, découpler service Meta |
| R-03 | Thèmes Stitch incompatibles avec MVC | Moyen/Élevé | Inventorier fichiers, nettoyer templates, test thème pilote, renderer isolé |
| R-04 | Thèmes trop différents pour un système de personnalisation commun | Moyen/Moyen | Définir contrat thème et capacités par template ; options configurables bornées |
| R-05 | cPanel limité en CPU/mémoire/cron | Moyen/Élevé | Test charge sur hébergement réel ; imports paginés ; pas de worker permanent |
| R-06 | Client ne transmet pas WhatsApp | Élevé/Moyen | commande persistée ; état WhatsApp séparé ; relance dashboard |
| R-07 | Confusion commande vs paiement | Moyen/Élevé | statuts séparés, KPI définis, formation |
| R-08 | Frais livraison mal configurés | Moyen/Élevé | test par zone et confirmation commerçant |
| R-09 | Données client exposées | Faible/Très élevé | contrôle accès, logs minimisés, HTTPS, sauvegardes protégées |
| R-10 | Import crée doublons | Moyen/Moyen | external ID unique, idempotence, rapport |
| R-11 | Import écrase données locales | Moyen/Élevé | règles champ par champ, sync opt-in, audit |
| R-12 | Support Marvens coûteux | Moyen/Moyen | formation, documentation, contrat maintenance, diagnostic |
| R-13 | Sauvegarde non restaurable | Faible/Très élevé | test restauration périodique |
| R-14 | Scope MVP s’élargit | Élevé/Moyen | MoSCoW, comité de changement, priorité parcours principal |
| R-15 | Hébergement client non conforme | Moyen/Élevé | checklist pré-installation et conditions minimales |
| R-16 | Suppression produit affecte commandes | Moyen/Élevé | archive/suppression logique, snapshots |
| R-17 | PWA sert cache obsolète | Moyen/Moyen | version assets, stratégie update, cache uniquement public |
| R-18 | Utilisateurs secondaires trop permissifs | Moyen/Élevé | RBAC serveur, test par rôle, permissions minimales |
| R-19 | SMTP/notifications non disponibles | Moyen/Moyen | canal désactivé tant que configuré ; feedback clair |
| R-20 | Tarification commerciale non validée | Moyen/Moyen | mesurer coût installation/support pilote avant grille |

## 20.1 Dépendances

- Hébergement cPanel compatible PHP 8.3/MySQL 8.
- Domaine et HTTPS.
- Accès SMTP si e-mail.
- Compte Meta Business, catalogue et permissions si import Meta.
- Fichiers thèmes Stitch présents et validés.
- Assets logo/images du commerçant.
- Zones de livraison et tarifs.
- Numéro WhatsApp professionnel.
- Contrat de maintenance et accès support.
- Décisions de conservation des données.

## 20.2 Décisions pouvant bloquer

1. Disponibilité et format des thèmes.
2. Niveau de personnalisation offert.
3. Import Meta et permissions.
4. Politique stock et disponibilité.
5. Modes de paiement affichés.
6. Frais et zones de livraison.
7. Rôles secondaires.
8. domaine/hébergement et ressources.
9. mail et notifications.
10. contrat support, sauvegardes et données.

---

# 21. Roadmap indicative

| Phase | Travaux | Livrable |
|---|---|---|
| 1 — Validation | Clarifier décisions, inventorier thèmes, valider hosting et Meta | Cadrage validé |
| 2 — Socle | MVC, config, DB, auth, logs, sécurité | Application installable |
| 3 — Boutique | Paramètres, thème, catégories, produits, médias | Mini-site catalogue |
| 4 — Commerce | Panier, checkout, commande transactionnelle, WhatsApp | Parcours commande |
| 5 — Dashboard | Commandes, statuts, clients, paiement manuel, livraison | Gestion opérationnelle |
| 6 — Import | CSV, Meta OAuth/catalogue, rapports, anti-doublons | Import fonctionnel |
| 7 — QA | Sécurité, responsive, PWA, backup/restore, tests | Version pilote |
| 8 — Pilote | Installation client, formation, mesure usage/coût | Rapport pilote |
| 9 — Décision | Analyse besoins récurrents et support | Décision SaaS éventuel |

---

# 22. Décisions et informations à valider

| ID | Décision | Proposition par défaut | Responsable |
|---|---|---|---|
| D-01 | Domaine/hébergement | Client fournit ou Marvens inclut selon offre | Porteur/Marvens |
| D-02 | Nombre de comptes | Un propriétaire admin pour premier MVP | Porteur |
| D-03 | Rôles secondaires | P1 sauf besoin pilote | Porteur |
| D-04 | Paiement | Paiement à la livraison recommandé ; confirmation manuelle | Porteur/commerçant |
| D-05 | Modes paiement affichés | Seulement ceux acceptés par le commerçant | Commerçant |
| D-06 | Livraison | Livraison domicile + retrait ; zones et tarifs configurés | Commerçant |
| D-07 | Stock | Disponibilité manuelle dans MVP ; décrémentation à valider | Porteur |
| D-08 | Variantes | Activer si produits concernés ; prix par variante à valider | Commerçant |
| D-09 | Thèmes | Inventorier `themes/`, définir nombre MVP et capacités | Design/tech |
| D-10 | Meta | Tester OAuth/catalogue, permissions et revue avant engagement | Tech/Marvens |
| D-11 | Sync Meta | Import manuel à la demande ; planifiée P1 | Porteur |
| D-12 | Notifications | E-mail si SMTP ; WhatsApp automatique hors MVP | Porteur |
| D-13 | Analytics externes | Opt-in/configuration plus tard | Porteur |
| D-14 | Devise | FCFA par défaut pour Cameroun ; multi-devise à valider | Porteur |
| D-15 | Langue | Français par défaut ; autres langues à valider | Porteur |
| D-16 | Conservation données | Politique définie avant mise en production | Porteur/contractuel |
| D-17 | Backup | Fréquence, rétention, responsable et restauration | Marvens/client |
| D-18 | Support | SLA et coût de maintenance contractuels | Marvens |
| D-19 | Accès Marvens | Accès limité, tracé et révocable | Client/Marvens |
| D-20 | KPI revenu | Payées ou livrées ; filtre visible | Porteur |

---

# 23. Glossaire

| Terme | Définition |
|---|---|
| Instance dédiée | Installation autonome pour un client |
| MVP | Première version commercialisable limitée aux fonctions essentielles |
| SaaS | Service partagé accessible en ligne avec gestion autonome des comptes |
| Multi-tenant | Architecture dans laquelle plusieurs clients partagent une application avec isolation logique |
| OAuth | Protocole d’autorisation déléguée |
| Meta Catalog | Catalogue produit accessible via les services Meta et permissions du compte |
| Snapshot | Copie des données commerciales au moment de la commande |
| PWA | Progressive Web App, site pouvant être installable et bénéficier de fonctions web |
| RBAC | Contrôle d’accès par rôles et permissions |
| CSRF | Attaque visant à déclencher une action authentifiée depuis un autre contexte |
| XSS | Injection de script dans une page web |
| Idempotence | Répéter une opération sans créer de doublons ou effets supplémentaires |
| cPanel | Interface d’administration d’hébergement mutualisé |

---

# 24. Conclusion

Marvens Shop MVP est une solution de social commerce installée individuellement chez chaque commerçant. Elle associe un mini-site mobile-first, un catalogue, un panier, une commande enregistrée, un tableau de bord, des paramètres de boutique et WhatsApp Business comme canal de communication. L’import Meta est prévu lorsque les autorisations et données accessibles le permettent.

Marvens réalise le déploiement, la configuration, la formation et la maintenance. Le paiement reste séparé dans le MVP et peut être confirmé manuellement ; le paiement à la livraison est recommandé comme mode initial, à confirmer par le commerçant. La boutique utilise un thème Stitch sélectionné, avec personnalisation guidée et séparation stricte entre présentation et données.

Le MVP doit être évalué sur l’usage réel : boutiques activées, commandes générées, taux de confirmation, temps de traitement, erreurs, coût d’installation et maintenance. La création d’un SaaS ne sera envisagée qu’après validation du produit, des coûts et des besoins récurrents.

**Parcours directeur :**

`Catalogue → Panier → Commande enregistrée → WhatsApp → Confirmation commerçant → Préparation/Livraison → Suivi dashboard`

**Règle finale de réalisation :** aucune fonctionnalité ne doit être considérée terminée sans critères d’acceptation vérifiables, tests associés, contrôle de sécurité et documentation suffisante pour qu’un développeur puisse reprendre le projet sans explication orale.

---

## Annexe A — Checklist de validation du dossier design

- [ ] Extraire et inventorier tous les thèmes Stitch du dossier `themes/`.
- [ ] Documenter pour chaque thème : nom, version, pages, composants, tokens, responsive, dépendances, licence et preview.
- [ ] Vérifier le framework Marvens Creative Brief : direction artistique, UX, navigation, design tokens, composants, accessibilité, standards PHP/frontend et sécurité.
- [ ] Définir le contrat commun des thèmes : variables d’entrée, pages supportées, options de personnalisation et fallback.
- [ ] Vérifier que les thèmes ne contiennent pas de logique métier ni de données clients.
- [ ] Tester un thème sur accueil, catalogue, fiche produit, panier et checkout.
- [ ] Vérifier changement de thème sans perte de données.
- [ ] Vérifier performance et accessibilité de chaque thème avant publication.

## Annexe B — Definition of Done (DoD)

Une fonctionnalité est livrable lorsque :

1. exigences et règles métier documentées ;
2. permissions définies et contrôlées côté serveur ;
3. validation serveur présente ;
4. erreurs utilisateur compréhensibles ;
5. logs utiles sans données sensibles ;
6. tests unitaires/intégration/fonctionnels pertinents passés ;
7. responsive et accessibilité vérifiés ;
8. aucune régression sur catalogue, commande et WhatsApp ;
9. documentation technique mise à jour ;
10. critères d’acceptation validés.

