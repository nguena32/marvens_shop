# PERFORMANCE — Standards de Performance Web et Optimisation Systémique
## MARVENS CREATIVE BRIEF V1.0 · PHASE 08_TECHNICAL_STANDARDS

> **Document :** Référentiel des métriques, budgets de performance, optimisations frontend, PHP, MySQL et hébergement mutualisé  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Objectifs cibles :** Core Web Vitals (LCP < 2.5s, INP < 200ms, CLS < 0.1), Poids page initial < 800 Ko, Réponse TTFB backend < 300 ms sur réseau mobile dégradé  
> **Documents associés :** [FRONTEND_STANDARDS.md](FRONTEND_STANDARDS.md) · [PHP_MVC_STANDARDS.md](PHP_MVC_STANDARDS.md) · [SECURITY.md](SECURITY.md)

---

## Sommaire

1. [Principes cardinaux de la performance contextuelle](#1-principes-cardinaux-de-la-performance-contextuelle)
2. [Indicateurs clés et seuils de référence (Core Web Vitals)](#2-indicateurs-clés-et-seuils-de-référence-core-web-vitals)
3. [Budgets de performance applicables](#3-budgets-de-performance-applicables)
4. [Optimisation de la couche Frontend (Assets, CSS, JS, Polices, Images)](#4-optimisation-de-la-couche-frontend-assets-css-js-polices-images)
5. [Optimisation du backend PHP 8.3 Vanilla](#5-optimisation-du-backend-php-83-vanilla)
6. [Optimisation de la base de données MySQL 8 et requêtes PDO](#6-optimisation-de-la-base-de-données-mysql-8-et-requêtes-pdo)
7. [Directives de mise en cache HTTP et serveur Apache/cPanel](#7-directives-de-mise-en-cache-http-et-serveur-apachecpanel)
8. [Résilience face aux réseaux à faible débit et latence élevée (Afrique centrale)](#8-résilience-face-aux-réseaux-à-faible-débit-et-latence-élevée-afrique-centrale)
9. [Protocole de mesure, outillage et détection des régressions](#9-protocole-de-mesure-outillage-et-détection-des-régressions)
10. [Anti-patterns de performance web](#10-anti-patterns-de-performance-web)
11. [Checklist de validation performance](#11-checklist-de-validation-performance)
12. [Références officielles](#12-références-officielles)

---

## 1. Principes cardinaux de la performance contextuelle

Dans la doctrine **MARVENS CREATIVE BRIEF V1.0**, la performance n'est pas un luxe d'ingénieur ou une simple quête de score théorique ; **c'est la condition sine qua non de l'utilisabilité réelle**.

En Afrique centrale et dans la zone CEMAC :
- Les forfaits de données mobiles sont comptabilisés au mégaoctet par les opérateurs télécoms (Orange, MTN) ; une page de 5 Mo coûte de l'argent réel à l'artisan ou au gérant de commerce.
- Les réseaux 3G/4G souffrent d'une gigue et d'une latence oscillant fréquemment entre 200 et 800 ms.
- Les terminaux (smartphones Android d'entrée de gamme, ordinateurs portables bureautiques modestes) disposent d'un processeur et d'une mémoire vive restreints.

> **Règle absolue :** Construire des applications légères, sobres en requêtes, qui démarrent instantanément sans gaspillage de bande passante.

---

## 2. Indicateurs clés et seuils de référence (Core Web Vitals)

Les applications web Marvens doivent respecter les critères de performance officiels définis par le W3C et Google (seuils 75e percentile) :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                    SEUILS DE PERFORMANCE CORE WEB VITALS                    │
├─────────────────────────┬──────────────┬──────────────┬─────────────────────┤
│ MÉTRIQUE OFFICIELLE     │ EXCELLENT    │ ACCEPTABLE   │ CRITIQUE / ÉCHEC    │
├─────────────────────────┼──────────────┼──────────────┼─────────────────────┤
│ LCP (Largest Contentful │ $\le$ 2.5 s  │ 2.5 s - 4.0 s│ > 4.0 s             │
│ Paint - Rendu majeur)   │              │              │                     │
├─────────────────────────┼──────────────┼──────────────┼─────────────────────┤
│ INP (Interaction to     │ $\le$ 200 ms │ 200 - 500 ms │ > 500 ms            │
│ Next Paint - Réactivité)│              │              │                     │
├─────────────────────────┼──────────────┼──────────────┼─────────────────────┤
│ CLS (Cumulative Layout  │ $\le$ 0.1    │ 0.1 - 0.25   │ > 0.25              │
│ Shift - Stabilité vis.) │              │              │                     │
├─────────────────────────┼──────────────┼──────────────┼─────────────────────┤
│ TTFB (Time to First     │ $\le$ 300 ms │ 300 - 800 ms │ > 800 ms            │
│ Byte - Réponse serveur) │              │              │                     │
└─────────────────────────┴──────────────┴──────────────┴─────────────────────┘
```

---

## 3. Budgets de performance applicables

Pour toute page applicative de l'écosystème Marvens (ERP, POS, SaaS, portail client) :

- **Poids total initial transféré (Gzip/Brotli) :** $\le$ **800 Ko** (hors pièces jointes documentaires de l'utilisateur).
- **Nombre de requêtes HTTP initiales :** $\le$ **25 requêtes**.
- **Poids JavaScript total :** $\le$ **120 Ko** transféré (Bootstrap Bundle + scripts applicatifs Vanilla).
- **Poids CSS total :** $\le$ **45 Ko** transféré (Bootstrap minifié + styles Marvens).
- **Temps d'exécution des requêtes SQL backend :** $\le$ **50 ms** par transaction.

---

## 4. Optimisation de la couche Frontend (Assets, CSS, JS, Polices, Images)

### 4.1 Stratégie de chargement des scripts et styles
- Chargement des styles CSS critiques dans le `<head>` avec le fichier minifié unique `main.css`.
- Chargement des scripts JavaScript systématiquement en fin de document avant la fermeture de `</body>` avec l'attribut `defer` :  
  `<script src="/assets/js/app.js" defer></script>`.

### 4.2 Élimination des décalages de mise en page (*CLS Zero*)
- Déclaration obligatoire des dimensions intrinsèques sur chaque balise image :  
  `<img src="logo.webp" width="180" height="40" alt="Marvens Group" loading="lazy">`.
- Réservation d'espace par `min-height` pour les blocs asynchrones (bannières, widgets de tableau de bord) pour éviter les sauts d'écran au chargement des données.

### 4.3 Optimisation des polices de caractères
- Hébergement local au format ultra-compressé `.woff2`.
- Utilisation de la propriété CSS `font-display: swap;` pour afficher immédiatement le texte avec la police système pendant le téléchargement de la typographie de marque.
- Pré-chargement de la police de texte principale :  
  `<link rel="preload" href="/assets/fonts/PlusJakartaSans-Regular.woff2" as="font" type="font/woff2" crossorigin>`.

---

## 5. Optimisation du backend PHP 8.3 Vanilla

Dans l'environnement PHP Vanilla MVC :
- **Activation d'OPcache :** En environnement mutualisé cPanel, s'assurer qu'OPcache est actif avec une mémoire suffisante (`opcache.memory_consumption = 128`, `opcache.revalidate_freq = 60`).
- **Élimination des calculs redondants :** Utiliser des variables de cache locales dans les boucles de traitement, bannir les requêtes d'accès récurrentes dans les itérations.
- **Mise en tampon de sortie (*Output Buffering*) :** Utilisation de `ob_start()` pour regrouper l'envoi de la page HTML en un seul paquet réseau compressé.

---

## 6. Optimisation de la base de données MySQL 8 et requêtes PDO

### 6.1 Indexation systématique
Chaque colonne utilisée dans une clause `WHERE`, `JOIN`, `ORDER BY` ou `GROUP BY` doit bénéficier d'un index adapté :
- Index primaire sur toutes les clés `id`.
- Index composites sur les recherches fréquentes (ex. `INDEX idx_invoices_company_status (company_id, status)`).

### 6.2 Proscription absolue des requêtes N+1
Ne jamais exécuter une requête SQL dans une boucle PHP :
```php
// ❌ ANTI-PATTERN CRITIQUE (N+1 Queries)
$invoices = $db->query('SELECT * FROM invoices LIMIT 50')->fetchAll();
foreach ($invoices as $invoice) {
    // 50 requêtes SQL supplémentaires inutiles !
    $client = $db->query("SELECT * FROM clients WHERE id = " . $invoice['client_id'])->fetch();
}

//  APPROCHE EXCELLENTE (1 seule requête avec jointure)
$sql = 'SELECT i.id, i.invoice_number, i.total_amount, c.company_name 
        FROM invoices i 
        INNER JOIN clients c ON i.client_id = c.id 
        WHERE i.company_id = :company_id 
        LIMIT 50';
$stmt = $db->prepare($sql);
$stmt->execute(['company_id' => $currentCompanyId]);
$invoices = $stmt->fetchAll();
```

---

## 7. Directives de mise en cache HTTP et serveur Apache/cPanel

Le fichier `public_html/.htaccess` doit exploiter les modules Apache `mod_deflate` et `mod_expires` pour décharger le serveur :

```apache
# Compression universelle Gzip / Deflate
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
  AddOutputFilterByType DEFLATE application/javascript application/json
  AddOutputFilterByType DEFLATE image/svg+xml
</IfModule>

# Mise en cache navigateur longue durée pour les assets statiques
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType image/svg+xml "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
  ExpiresByType font/woff2 "access plus 1 year"
</IfModule>
```

---

## 8. Résilience face aux réseaux à faible débit et latence élevée (Afrique centrale)

- **Minimisation des allers-retours réseau (RTT) :** Regrouper les requêtes API d'initialisation en un seul appel de synthèse (`/api/v1/dashboard/summary`) plutôt que d'émettre 6 requêtes Fetch séparées.
- **Timeouts maîtrisés :** Configurer un timeout strict de 10 secondes sur tout appel de passerelle externe (ex. API Orange Money / MTN MoMo) pour éviter de bloquer les processus PHP du serveur mutualisé.

---

## 9. Protocole de mesure, outillage et détection des régressions

L'évaluation de la performance ne repose pas sur des impressions subjectives mais sur un protocole normé :

1. **Test Lighthouse / PageSpeed Insights :**
   - Émulation profil : Mobile d'entrée de gamme, connexion 4G ralentie (latence 150 ms, débit descendant 1.6 Mbps).
   - Score de performance cible minimal : **$\ge$ 85 / 100**.
2. **Audit des requêtes SQL (*Query Log*) :**
   - Aucune page standard ne doit générer plus de 10 requêtes SQL au chargement.
3. **Surveillance du TTFB :**
   - Mesure directe via l'en-tête de chronométrie serveur : `header('X-Response-Time: ' . (microtime(true) - APP_START_TIME));`.

---

## 10. Anti-patterns de performance web

- ❌ **Bibliothèques JS externes obèses :** Importer Lodash, Moment.js ou jQuery pour des opérations que JavaScript Vanilla résout en 2 lignes.
- ❌ **Images non redimensionnées :** Téléverser une photo d'article de 4 000 × 3 000 px (4 Mo) pour l'afficher dans une vignette de 64 × 64 px.
- ❌ **Requêtes SQL non indexées avec balayage de table complet (*Full Table Scan*) :** Ralentit catastrophiquement le serveur dès que la table atteint 10 000 lignes.
- ❌ **Polices tierces bloquantes :** Utiliser 4 graisses différentes de Google Fonts chargées depuis des serveurs distants.

---

## 11. Checklist de validation performance

| # | Contrôle de performance | Critère exigé | Statut |
|---|---|---|---|
| **01** | Poids page total | Poids transféré inférieur à 800 Ko sur vue complète | [ ] |
| **02** | Compression serveur | Compression Gzip ou Brotli active sur CSS, JS et HTML | [ ] |
| **03** | Aucune requête N+1 | Requêtes SQL optimisées avec jointures explicites | [ ] |
| **04** | Index MySQL en place | Index créés sur toutes les clés de recherche et de tri | [ ] |
| **05** | Polices auto-hébergées | Fichiers WOFF2 locaux avec `font-display: swap` | [ ] |
| **06** | Images optimisées | Formats WebP/SVG utilisés avec attributs `width`/`height` | [ ] |
| **07** | Cache statique actif | En-têtes `Expires` et `Cache-Control` positionnés | [ ] |
| **08** | Temps de réponse backend | TTFB inférieur à 300 ms en conditions normales | [ ] |

---

## 12. Références officielles

- **Web Vitals Documentation (Google / W3C) :** <https://web.dev/vitals/> *(Consulté le 31/10/2026)*.
- **MDN Web Performance Guide :** <https://developer.mozilla.org/fr/docs/Web/Performance> *(Consulté le 31/10/2026)*.
- **MySQL 8.0 Optimization and Indexes :** <https://dev.mysql.com/doc/refman/8.0/en/optimization.html> *(Consulté le 31/10/2026)*.
- **PHP OPcache Documentation :** <https://www.php.net/manual/fr/book.opcache.php> *(Consulté le 31/10/2026)*.


<!-- MARVENS_PROJECT_CONTEXT:START -->
---
# ANNEXE DE CONTEXTE PROJET — MARVENS SHOP

> **Note méthodologique Marvens :** Ce bloc de cadrage a été injecté automatiquement à partir des réponses du responsable de projet. Les règles doctrinales supérieures du document demeurent la référence méthodologique absolue.

### Contraintes techniques et d'exécution
- **Technologies et intégrations :** [À DÉFINIR / À CONFIRMER]
- **Contraintes de calendrier et sécurité :** [À DÉFINIR / À CONFIRMER]
- **Contraintes réseau et connectivité :** 4G, ordinateur, mobile, tablette, Francais
- **Compléments & Notes :** [À DÉFINIR / À CONFIRMER]
<!-- MARVENS_PROJECT_CONTEXT:END -->
