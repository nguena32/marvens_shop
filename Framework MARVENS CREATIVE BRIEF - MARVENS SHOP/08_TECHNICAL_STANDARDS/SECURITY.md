# SECURITY — Standards de Sécurité Applicative, OWASP et Protection des Données
## MARVENS CREATIVE BRIEF V1.0 · PHASE 08_TECHNICAL_STANDARDS

> **Document :** Référentiel de sécurité applicative, authentification, défense en profondeur et conformité OWASP Top 10  
> **Statut :** Recommandation IA — Soumis à validation humaine  
> **Version :** 1.0.0  
> **Date de référence :** 31 octobre 2026  
> **Doctrine :** *Contextual Design · Premium Quality*  
> **Cadre normatif :** OWASP Top 10 (2021/2026), OWASP ASVS Level 2, Bonnes pratiques de chiffrement PHP 8.3 / MySQL 8  
> **Documents associés :** [PHP_MVC_STANDARDS.md](PHP_MVC_STANDARDS.md) · [FRONTEND_STANDARDS.md](FRONTEND_STANDARDS.md) · [PERFORMANCE.md](PERFORMANCE.md)

---

## Sommaire

1. [Principes cardinaux de sécurité applicative (Security by Design)](#1-principes-cardinaux-de-sécurité-applicative-security-by-design)
2. [Modèle de menaces et vecteurs d'attaque prioritaires](#2-modèle-de-menaces-et-vecteurs-dattaque-prioritaires)
3. [Authentification robuste et gestion du cycle de vie des accès](#3-authentification-robuste-et-gestion-du-cycle-de-vie-des-accès)
4. [Sécurisation avancée des sessions HTTP](#4-sécurisation-avancée-des-sessions-http)
5. [Contrôle d'accès granulaire et prévention IDOR/BOLA](#5-contrôle-daccès-granulaire-et-prévention-idorbola)
6. [Défense absolue contre les injections SQL (PDO)](#6-défense-absolue-contre-les-injections-sql-pdo)
7. [Neutralisation des failles Cross-Site Scripting (XSS)](#7-neutralisation-des-failles-cross-site-scripting-xss)
8. [Protection Cross-Site Request Forgery (CSRF)](#8-protection-cross-site-request-forgery-csrf)
9. [Sécurité du téléversement de fichiers (File Upload Hardening)](#9-sécurité-du-téléversement-de-fichiers-file-upload-hardening)
10. [En-têtes de sécurité HTTP et Content Security Policy (CSP)](#10-en-têtes-de-sécurité-http-et-content-security-policy-csp)
11. [Gestion des secrets, clés API et variables d'environnement](#11-gestion-des-secrets-clés-api-et-variables-denvironnement)
12. [Sécurisation des Webhooks et intégrations de paiement (Mobile Money)](#12-sécurisation-des-webhooks-et-intégrations-de-paiement-mobile-money)
13. [Journalisation sécurisée d'audit et protection de la vie privée](#13-journalisation-sécurisée-daudit-et-protection-de-la-vie-privée)
14. [Checklist sécurité avant mise en production (OWASP Verification)](#14-checklist-sécurité-avant-mise-en-production-owasp-verification)
15. [Références officielles](#15-références-officielles)

---

## 1. Principes cardinaux de sécurité applicative (Security by Design)

Dans la doctrine **MARVENS CREATIVE BRIEF V1.0**, la sécurité des données financières, commerciales et personnelles des entreprises clientes est un engagement absolu. Les applications de gestion d'entreprise et plateformes SaaS de Marvens Group manipulent des flux monétaires et des inventaires stratégiques : aucune compromission ne peut être tolérée.

### Principes directeurs :
- **Défense en profondeur (*Defense in Depth*) :** La sécurité ne repose jamais sur un seul mécanisme (ex. ne pas se fier à la seule validation JavaScript ; le backend doit filtrer et rejeter systématiquement toute entrée illégitime).
- **Moindre privilège (*Least Privilege*) :** Les utilisateurs, processus serveur et connexions MySQL ne disposent que des droits strictement nécessaires à l'accomplissement de leur tâche.
- **Validation positive par liste blanche (*Allowlist Validation*) :** Définir précisément ce qui est autorisé plutôt que d'essayer de filtrer ce qui est réputé malveillant.
- **Non-exposition des détails internes :** Aucune trace de débogage, version de logiciel ou exception de base de données ne doit fuiter vers le client en production.

---

## 2. Modèle de menaces et vecteurs d'attaque prioritaires

Le modèle de menace couvre les 5 vecteurs les plus critiques pour les applications web B2B :

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       MATRICE DES VECTEURS DE MENACE                        │
├─────────────────────────┬───────────────────────────┬───────────────────────┤
│ RISQUE OWASP            │ IMPACT POTENTIEL          │ MESURE SYSTÉMIQUE     │
├─────────────────────────┼───────────────────────────┼───────────────────────┤
│ 1. Injection (SQL)      │ Vol ou corruption totale  │ Requêtes préparées    │
│                         │ de la base de données     │ PDO obligatoires      │
├─────────────────────────┼───────────────────────────┼───────────────────────┤
│ 2. Contrôle d'accès     │ Espionnage de factures    │ Vérification serveur  │
│    défaillant (IDOR)    │ d'une autre entreprise    │ `company_id` liée     │
├─────────────────────────┼───────────────────────────┼───────────────────────┤
│ 3. Vol de session       │ Usurpation de compte      │ Cookies HttpOnly,     │
│    (Session Hijacking)  │ administrateur / caisse   │ Secure, régénération  │
├─────────────────────────┼───────────────────────────┼───────────────────────┤
│ 4. Faille XSS           │ Injection de scripts mal- │ Échappement HTML5     │
│                         │ veillants, vol de jetons  │ systématique avec e() │
├─────────────────────────┼───────────────────────────┼───────────────────────┤
│ 5. Upload malveillant   │ Exécution de code PHP     │ Stockage hors racine, │
│    (Web Shell)          │ arbitraire sur le serveur │ vérification MIME/hex │
└─────────────────────────┴───────────────────────────┴───────────────────────┘
```

---

## 3. Authentification robuste et gestion du cycle de vie des accès

### 3.1 Hachage des mots de passe
Les mots de passe sont hachés au moyen des fonctions cryptographiques officielles de PHP 8.3 utilisant l'algorithme robuste Argon2id ou Bcrypt avec un coût adapté :

```php
// Hachage à la création / modification du compte
$passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT, ['cost' => 12]);

// Vérification lors de la connexion
if (!password_verify($inputPassword, $user['password_hash'])) {
    // Échec d'authentification
    SecurityLogger::logFailedLogin($email, $_SERVER['REMOTE_ADDR']);
    throw new \AuthException('Identifiants incorrects.');
}

// Mise à niveau automatique du hash si l'algorithme PHP évolue
if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT, ['cost' => 12])) {
    $newHash = password_hash($inputPassword, PASSWORD_DEFAULT, ['cost' => 12]);
    $userModel->updatePasswordHash($user['id'], $newHash);
}
```

### 3.2 Protection contre les attaques par force brute (*Rate Limiting*)
- Limitation stricte à **5 tentatives infructueuses consécutives** par adresse IP et compte sur une fenêtre de 15 minutes.
- Au-delà du seuil, verrouillage temporaire de 15 minutes avec temporisation progressive (*exponential backoff*).

---

## 4. Sécurisation avancée des sessions HTTP

Le fichier d'initialisation de session (`Session.php`) applique les réglages maximaux imposés par le PHP Security Guide :

```php
// Configuration sécurisée de la session PHP
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1'); // Inaccessible en JavaScript (rempart XSS)
ini_set('session.cookie_secure', '1');   // Uniquement transmis sous chiffrement HTTPS
ini_set('session.cookie_samesite', 'Lax'); // Protection contre les requêtes intersites
ini_set('session.gc_maxlifetime', '7200'); // Expiration après 2 heures d'inactivité

session_start();

// Régénération obligatoire de l'ID de session à la connexion pour bloquer la fixation
public static function regenerate(): void
{
    session_regenerate_id(true);
}
```

---

## 5. Contrôle d'accès granulaire et prévention IDOR/BOLA

Une faille de type *Insecure Direct Object Reference* (IDOR) survient lorsqu'un utilisateur remplace l'ID d'une ressource dans l'URL (ex. `/invoices/view?id=452`) pour consulter la facture d'un concurrent.

> **Règle absolue :** Tout modèle doit scoper ses requêtes par l'identifiant d'organisation de l'utilisateur connecté (`company_id`) extrait de la session de confiance :

```php
// ✅ CODE SÉCURISÉ CONTRE LES FAILLES IDOR
public function getInvoiceDetails(int $invoiceId): array
{
    $currentCompanyId = (int)$_SESSION['company_id']; // Vient de la session serveur, non de l'URL

    $stmt = $this->db->prepare('SELECT * FROM invoices WHERE id = :id AND company_id = :company_id LIMIT 1');
    $stmt->execute([
        'id' => $invoiceId,
        'company_id' => $currentCompanyId
    ]);

    $invoice = $stmt->fetch();
    if (!$invoice) {
        throw new \ForbiddenException('Accès refusé ou ressource inexistante.');
    }

    return $invoice;
}
```

---

## 6. Défense absolue contre les injections SQL (PDO)

- Aucune requête SQL ne doit concaténer ou interpoler des variables (`$var`).
- Utiliser systématiquement les requêtes préparées PDO avec `PDO::ATTR_EMULATE_PREPARES => false`.
- En cas de tri dynamique (`ORDER BY`), valider le champ contre une **liste blanche stricte** :

```php
// Sécurisation d'un tri dynamique
$allowedColumns = ['invoice_number', 'created_at', 'total_amount'];
$sortColumn = in_array($_GET['sort'] ?? '', $allowedColumns, true) ? $_GET['sort'] : 'created_at';
$sortDirection = ($_GET['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';

$sql = "SELECT id, invoice_number FROM invoices WHERE company_id = :cid ORDER BY {$sortColumn} {$sortDirection}";
$stmt = $this->db->prepare($sql);
$stmt->execute(['cid' => $companyId]);
```

---

## 7. Neutralisation des failles Cross-Site Scripting (XSS)

- Échappement systématique des données dynamiques affichées dans les vues via `e($var)`.
- Ne jamais injecter de données non nettoyées dans des contextes d'attributs HTML complexes ou des blocs de script `<script>`.
- Transmission de données du serveur vers le frontend exclusivement via des attributs `data-*` encodés en JSON sain :  
  `<div id="orderApp" data-config="<?= e(json_encode($safeConfig)) ?>"></div>`.

---

## 8. Protection Cross-Site Request Forgery (CSRF)

Toute requête mutative (état modifié en base via `POST`, `PUT`, `DELETE`) doit porter un jeton cryptographique aléatoire à usage unique :

```php
// Génération du jeton en session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Validation dans le middleware backend
public function validateCsrfToken(?string $submittedToken): void
{
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    if (!hash_equals($sessionToken, (string)$submittedToken)) {
        throw new \SecurityException('Validation de sécurité CSRF échouée. Veuillez rafraîchir la page.');
    }
}
```

---

## 9. Sécurité du téléversement de fichiers (File Upload Hardening)

Le téléversement de justificatifs (reçus de paiement, logos, PDFs) est une cible majeure :
1. **Validation de l'extension :** Liste blanche stricte (`['pdf', 'jpg', 'jpeg', 'png', 'webp']`).
2. **Validation du type MIME réel :** Utilisation de l'extension PHP Fileinfo (`finfo_file()`), ne jamais se fier à `$_FILES['file']['type']` envoyé par le client.
3. **Renommage aléatoire :** Le fichier est renommé avec un hash unique cryptographique : `hash('sha256', random_bytes(16)) . '.' . $extension`.
4. **Stockage hermétique :** Stockage dans `storage/uploads/` (en dehors du dossier racine web). Les fichiers sont servis via un script de streaming sécurisé vérifiant les droits d'accès.
5. **Désactivation de l'exécution :** Si le dossier est exposé, désactiver l'exécution de tout script via `.htaccess` (`php_flag engine off`).

---

## 10. En-têtes de sécurité HTTP et Content Security Policy (CSP)

Configuration obligatoire dans le fichier `.htaccess` ou via PHP :

```apache
# En-têtes de durcissement HTTP
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "DENY"
Header always set X-XSS-Protection "1; mode=block"
Header always set Referrer-Policy "strict-origin-when-cross-origin"
Header always set Permissions-Policy "geolocation=(), camera=(), microphone=()"

# Politique de sécurité du contenu (Content Security Policy - CSP)
Header always set Content-Security-Policy "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-ancestors 'none';"
```

---

## 11. Gestion des secrets, clés API et variables d'environnement

- Les clés de production des passerelles Orange Money / MTN Mobile Money et les identifiants MySQL sont stockés dans un fichier `.env` situé à la racine du projet (hors du web root).
- Le fichier `.env` est exclu du contrôle de version par la règle `.gitignore`.

---

## 12. Sécurisation des Webhooks et intégrations de paiement (Mobile Money)

Lors de la réception des notifications de paiement d'un opérateur télécom :
1. **Signature cryptographique :** Vérification systématique du hash HMAC (ex. SHA256 avec clé secrète partagée) transmis dans les en-têtes HTTP de la requête.
2. **Idempotence :** Vérifier si la transaction a déjà été validée en base avant de créditer un compte pour empêcher les attaques par rejeu.

---

## 13. Journalisation sécurisée d'audit et protection de la vie privée

- Les journaux d'audit enregistrent : date, heure, identifiant utilisateur, action réalisée, adresse IP et statut de l'opération.
- **Données strictement interdites dans les logs :** Mots de passe en clair, codes PIN de transaction Mobile Money, numéros de cartes de crédit ou tokens de session.

---

## 14. Checklist sécurité avant mise en production (OWASP Verification)

| # | Contrôle de sécurité applicative | Norme OWASP | Statut |
|---|---|---|---|
| **01** | Requêtes PDO préparées | A03:2021 (Injection) | [ ] |
| **02** | Contrôle d'accès IDOR | A01:2021 (Broken Access Control) | [ ] |
| **03** | Mots de passe Argon2id / Bcrypt | A02:2021 (Cryptographic Failures) | [ ] |
| **04** | Cookies HttpOnly + Secure | A07:2021 (Identification Failures) | [ ] |
| **05** | Protection anti-CSRF | A01:2021 (Access Control) | [ ] |
| **06** | Échappement HTML5 systématique | A03:2021 (XSS Prevention) | [ ] |
| **07** | Uploads stockés hors web root | A04:2021 (Insecure Design) | [ ] |
| **08** | En-têtes CSP et X-Frame-Options | A05:2021 (Security Misconfiguration) | [ ] |

---

## 15. Références officielles

- **OWASP Top 10 Web Application Security Risks :** <https://owasp.org/www-project-top-ten/> *(Consulté le 31/10/2026)*.
- **OWASP Cheat Sheet Series (Cross-Site Scripting, CSRF, Password Storage) :** <https://cheatsheetseries.owasp.org/> *(Consulté le 31/10/2026)*.
- **PHP Secure Coding Guidelines :** <https://www.php.net/manual/fr/security.php> *(Consulté le 31/10/2026)*.


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
