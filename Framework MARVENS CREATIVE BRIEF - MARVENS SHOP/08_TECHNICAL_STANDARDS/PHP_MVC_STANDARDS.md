# PHP MVC STANDARDS — Architecture et Normes PHP 8.3+ Vanilla MVC
## MARVENS CREATIVE BRIEF V1.0 · PHASE 08_TECHNICAL_STANDARDS

> **Document :** Standards d'architecture backend PHP Vanilla MVC, sécurité PDO, routage et déploiement cPanel  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Périmètre technique :** PHP 8.3+ Vanilla MVC strict, MySQL 8 InnoDB, PDO, Apache mod_rewrite, hébergement cPanel  
> **Documents associés :** [FRONTEND_STANDARDS.md](FRONTEND_STANDARDS.md) · [SECURITY.md](SECURITY.md) · [PERFORMANCE.md](PERFORMANCE.md)

---

## Sommaire

1. [Principes cardinaux de l'architecture PHP Vanilla MVC](#1-principes-cardinaux-de-larchitecture-php-vanilla-mvc)
2. [Structure de répertoires de référence (Compatible cPanel / `public_html`)](#2-structure-de-répertoires-de-référence-compatible-cpanel--public_html)
3. [Point d'entrée unique (*Front Controller*) et routage sécurisé](#3-point-dentrée-unique-front-controller-et-routage-sécurisé)
4. [Contrôleurs minces (*Thin Controllers*) et gestion des flux](#4-contrôleurs-minces-thin-controllers-et-gestion-des-flux)
5. [Modèles et persistance des données via PDO](#5-modèles-et-persistance-des-données-via-pdo)
6. [Couche de services métier (*Domain Services*) et transactions](#6-couche-de-services-métier-domain-services-et-transactions)
7. [Moteur de vues, layouts et échappement contextuel](#7-moteur-de-vues-layouts-et-échappement-contextuel)
8. [Gestion des sessions et authentification robuste](#8-gestion-des-sessions-et-authentification-robuste)
9. [Gestion des configurations et variables d'environnement](#9-gestion-des-configurations-et-variables-denvironnement)
10. [Journalisation, traçabilité et traitement des exceptions](#10-journalisation-traçabilité-et-traitement-des-exceptions)
11. [Directives de déploiement sécurisé sur cPanel](#11-directives-de-déploiement-sécurisé-sur-cpanel)
12. [Anti-patterns PHP backend formellement proscrits](#12-anti-patterns-php-backend-formellement-proscrits)
13. [Checklist de conformité PHP MVC](#13-checklist-de-conformité-php-mvc)
14. [Références officielles](#14-références-officielles)

---

## 1. Principes cardinaux de l'architecture PHP Vanilla MVC

Dans le contexte des produits numériques de Marvens Group, le choix d'un **PHP 8.3+ Vanilla MVC strict** (sans dépendance à des frameworks lourds comme Laravel ou Symfony) découle d'un choix pragmatique :
- **Performance native maximale :** Zéro surcharge de conteneur d'injection ou de bootstraps démesurés ; le temps de réponse serveur descend sous les 30 ms.
- **Portabilité absolue :** Déploiement sans friction sur les hébergements mutualisés cPanel courants sans requérir de conteneurs Docker ou de droits `root`.
- **Maîtrise totale du code :** Clarté de la maintenance, zéro faille masquée dans des paquets Composer obsolètes, longévité pluriannuelle.

### Principes stricts :
1. **Typage fort systématique :** Chaque fichier PHP débute par `declare(strict_types=1);`. Les arguments, retours de fonctions et propriétés de classe sont rigoureusement typés (types scalaires, unions, types de retour `void` ou `never`).
2. **Contrôleurs minces, modèles stricts, services riches :** Les contrôleurs se limitent à valider la requête HTTP, solliciter un service métier et retourner une vue ou une réponse JSON.
3. **Zéro requête SQL hors des modèles :** Aucune instruction SQL ne peut résider dans un contrôleur ou une vue.
4. **Zéro logique métier dans les vues :** Les templates PHP n'exécutent que des boucles d'affichage et des conditions de visibilité simples.

---

## 2. Structure de répertoires de référence (Compatible cPanel / `public_html`)

La sécurité d'une application PHP repose en premier lieu sur **l'isolation des sources privées en dehors de la racine publique** du serveur web :

```text
/home/marvens/
├── app_core/                         /* HORS DU WEB ROOT : Inaccessible directement */
│   ├── Controllers/                  /* Contrôleurs HTTP (AuthController, InvoiceController) */
│   ├── Models/                       /* Modèles d'accès données PDO (User, Invoice, Product) */
│   ├── Services/                     /* Logique métier pure (PaymentService, BillingService) */
│   ├── Middleware/                   /* Filtres de requêtes (AuthMiddleware, CsrfMiddleware) */
│   ├── Core/                         /* Moteur MVC (Router, Database, View, Container) */
│   ├── Validators/                   /* Règles de validation des formulaires */
│   └── Views/                        /* Templates PHP (Layouts, Partials, Pages) */
├── config/                           /* Fichiers de configuration PHP protégés */
│   ├── app.php
│   └── database.php
├── storage/                          /* Fichiers locaux non publics */
│   ├── logs/                         /* Fichiers de traces chiffrées */
│   └── uploads/                      /* Pièces jointes (justificatifs téléversés) */
└── public_html/                      /* SEUL DOSSIER EXPOSÉ PAR LE SERVEUR APACHE */
    ├── .htaccess                     /* Règles de réécriture d'URL et protection */
    ├── index.php                     /* Front Controller unique */
    └── assets/                       /* Fichiers statiques (css, js, img, fonts, icons) */
```

> **Note d'adaptation cPanel :** Si l'hébergement mutualisé ne permet pas d'accéder au parent de `public_html/`, la racine de l'application est placée dans un sous-dossier `app_core/` à l'intérieur de `public_html/`, protégé par un fichier `.htaccess` contenant `Deny from all`.

---

## 3. Point d'entrée unique (*Front Controller*) et routage sécurisé

Toute requête entrante transite obligatoirement par `public_html/index.php`. Le fichier `.htaccess` intercepte et redirige toutes les URLs propres vers ce point d'entrée :

```apache
# public_html/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]

# Sécurisation des en-têtes de base
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-XSS-Protection "1; mode=block"
```

```php
<?php
// public_html/index.php
declare(strict_types=1);

// Démarrage du chronomètre de performance
define('APP_START_TIME', microtime(true));
define('ROOT_PATH', dirname(__DIR__));

// Autoloader standardisé PSR-4 Vanilla
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = ROOT_PATH . '/app_core/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;
use App\Core\Session;

Session::start();

$router = new Router();
require ROOT_PATH . '/config/routes.php';

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (\Throwable $e) {
    App\Core\ErrorHandler::handleException($e);
}
```

---

## 4. Contrôleurs minces (*Thin Controllers*) et gestion des flux

Un contrôleur est un simple chef d'orchestre. Il ne contient aucun calcul complexe :

```php
<?php
// app_core/Controllers/InvoiceController.php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Core\Response;
use App\Services\InvoiceService;
use App\Validators\InvoiceValidator;

class InvoiceController
{
    public function __construct(
        private InvoiceService $invoiceService = new InvoiceService()
    ) {}

    /**
     * Traitement de la création d'une nouvelle facture client
     */
    public function store(): Response
    {
        $payload = $_POST;
        
        $validator = new InvoiceValidator($payload);
        if (!$validator->validate()) {
            return Response::json([
                'success' => false,
                'message' => 'Veuillez corriger les anomalies du formulaire.',
                'errors' => $validator->getErrors()
            ], 422);
        }

        try {
            $invoiceId = $this->invoiceService->createInvoice($payload, (int)$_SESSION['user_id']);
            
            return Response::json([
                'success' => true,
                'message' => 'Facture émise avec succès.',
                'data' => ['invoice_id' => $invoiceId]
            ], 201);
        } catch (\DomainException $e) {
            return Response::json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
```

---

## 5. Modèles et persistance des données via PDO

### 5.1 Connexion Singleton sécurisée avec PDO
```php
<?php
// app_core/Core/Database.php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

final class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $config = require ROOT_PATH . '/config/database.php';
            
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $config['host'], $config['database']);
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false, // Utilisation des vraies requêtes préparées MySQL
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];

            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $options);
            } catch (PDOException $e) {
                error_log('[Database Connection Failure]: ' . $e->getMessage());
                throw new \RuntimeException('Erreur critique de liaison avec la base de données.');
            }
        }

        return self::$instance;
    }
}
```

### 5.2 Requêtes préparées strictes dans les modèles
```php
<?php
// app_core/Models/InvoiceModel.php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class InvoiceModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Recherche d'une facture par identifiant unique et entité
     */
    public function findById(int $invoiceId, int $companyId): ?array
    {
        $sql = 'SELECT id, invoice_number, total_amount, status, created_at 
                FROM invoices 
                WHERE id = :id AND company_id = :company_id 
                LIMIT 1';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $invoiceId,
            'company_id' => $companyId
        ]);

        $result = $stmt->fetch();
        return $result ?: null;
    }
}
```

---

## 6. Couche de services métier (*Domain Services*) et transactions

La logique transactionnelle (ex. émettre une facture et décrémenter le stock dans un inventaire) s'exécute dans une transaction PDO protégée :

```php
<?php
// app_core/Services/InvoiceService.php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Models\InvoiceModel;
use App\Models\StockModel;
use PDO;

class InvoiceService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function createInvoice(array $data, int $userId): int
    {
        $this->db->beginTransaction();

        try {
            // 1. Insertion de la facture
            $stmt = $this->db->prepare('INSERT INTO invoices (company_id, client_id, total_amount, created_by) VALUES (?, ?, ?, ?)');
            $stmt->execute([$data['company_id'], $data['client_id'], $data['total_amount'], $userId]);
            $invoiceId = (int)$this->db->lastInsertId();

            // 2. Décrémentation atomique des stocks
            $stockModel = new StockModel();
            foreach ($data['items'] as $item) {
                $stockModel->decrementStock((int)$item['product_id'], (int)$item['quantity']);
            }

            $this->db->commit();
            return $invoiceId;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            error_log('[Invoice Creation Error]: ' . $e->getMessage());
            throw new \DomainException('Échec de la validation de la facture. Opération annulée.');
        }
    }
}
```

---

## 7. Moteur de vues, layouts et échappement contextuel

Pour neutraliser les attaques Cross-Site Scripting (XSS), tout affichage de données textuelles dans les templates PHP doit faire l'objet d'un échappement systématique via une fonction utilitaire globale `e()` :

```php
<?php
// Helper d'échappement universel
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
```

```php
<!-- app_core/Views/invoices/show.php -->
<div class="c-card">
  <h2>Facture #<?= e($invoice['invoice_number']) ?></h2>
  <p>Montant : <strong><?= number_format((float)$invoice['total_amount'], 0, ',', ' ') ?> FCFA</strong></p>
  <span class="badge badge--<?= e($invoice['status']) ?>"><?= e($invoice['status_label']) ?></span>
</div>
```

---

## 8. Gestion des sessions et authentification robuste

Pour résister au vol de session et aux attaques par fixation :
- Configuration des directives `session.cookie_httponly = 1`, `session.cookie_secure = 1`, et `session.cookie_samesite = 'Lax'`.
- Régénération de l'identifiant de session (`session_regenerate_id(true)`) dès qu'un utilisateur s'authentifie ou change de privilège.
- Stockage des mots de passe exclusivement au moyen de l'algorithme officiel recommandé `password_hash($password, PASSWORD_DEFAULT)` et contrôle via `password_verify()`.

---

## 9. Gestion des configurations et variables d'environnement

- Les secrets (mots de passe de base MySQL, clés secrètes d'API Mobile Money) ne sont **jamais écrits en dur dans les fichiers source du dépôt**.
- Utilisation d'un fichier `.env` protégé en lecture ou d'un fichier de configuration local `config/env.local.php` ignoré par git (`.gitignore`).

---

## 10. Journalisation, traçabilité et traitement des exceptions

- En environnement de production (`APP_ENV=production`), les directives PHP `display_errors = Off` et `log_errors = On` sont obligatoires.
- Les erreurs critiques sont écrites dans `storage/logs/app-YYYY-MM-DD.log`. L'utilisateur ne reçoit qu'un message générique et courtois : *"Une erreur technique est survenue. Nos équipes d'exploitation ont été informées."*

---

## 11. Directives de déploiement sécurisé sur cPanel

Lors du déploiement via FTP/Git sur un compte cPanel :
1. Les fichiers du dossier `app_core/`, `config/` et `storage/` sont placés dans `/home/username/app_core/`.
2. Seul le contenu de `public/` est copié dans `/home/username/public_html/`.
3. Les permissions des fichiers PHP sont positionnées en `0644` et les dossiers en `0755`. Le dossier `storage/` doit être inscriptible par le processus web (`www-data` ou utilisateur cPanel).

---

## 12. Anti-patterns PHP backend formellement proscrits

- ❌ **Requêtes SQL concaténées :** Proscription absolue de `SELECT * FROM users WHERE email = '$email'`. Toujours utiliser des requêtes préparées PDO avec paramètres nommés ou positionnels.
- ❌ **Exécution de requêtes SQL dans les vues HTML :** Détruit la séparation des responsabilités et empêche toute mise en cache.
- ❌ **Utilisation d'anciennes fonctions obsolètes :** Fonctions `mysql_*`, algorithmes `md5()` ou `sha1()` pour les mots de passe formellement interdits.
- ❌ **Exposition des répertoires de code source :** Laisser `config/` ou `.env` accessible via une URL directe de navigateur.

---

## 13. Checklist de conformité PHP MVC

| # | Règle d'architecture backend | Vérification effectuée | Statut |
|---|---|---|---|
| **01** | Typage strict | `declare(strict_types=1);` présent sur chaque script PHP | [ ] |
| **02** | Requêtes PDO préparées | 100 % des requêtes MySQL exécutées via requêtes préparées | [ ] |
| **03** | Échappement XSS | Toutes les variables affichées dans les vues passent par `e()` | [ ] |
| **04** | Protection des sessions | Cookies `HttpOnly`, `Secure` et `SameSite=Lax` activés | [ ] |
| **05** | Zéro secret dans le code | Aucune clé d'accès ou mot de passe MySQL stocké en clair | [ ] |
| **06** | Transactions maîtrisées | Opérations financières imbriquées dans un `beginTransaction() / commit()` | [ ] |
| **07** | Isolation des dossiers | Code source et configuration situés hors de `public_html` | [ ] |
| **08** | Erreurs masquées en prod | `display_errors` désactivé et erreurs redirigées vers les logs | [ ] |

---

## 14. Références officielles

- **Documentation officielle PHP 8.3+ :** <https://www.php.net/docs.php> *(Consulté le 31/10/2026)*.
- **PHP Data Objects (PDO) Documentation :** <https://www.php.net/manual/fr/book.pdo.php> *(Consulté le 31/10/2026)*.
- **OWASP PHP Security Cheat Sheet :** <https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html> *(Consulté le 31/10/2026)*.
