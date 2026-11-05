# TECHNICAL_FOUNDATIONS.md
# Fondations Techniques et Architecture MVC — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 3 — Fondations techniques et contrats de modules  
**Agent :** Architecte Logiciel Senior / Lead Developer PHP (Google Antigravity)  
**Conformité :** PHP 8.3+ Vanilla MVC strict, MySQL 8 InnoDB, cPanel / Mutualisé.

---

## 1. Vue d'Ensemble du Socle Technique

Le socle technique de Marvens Shop est conçu pour allier **rigueur architecturale (Clean Architecture / MVC Vanilla)** et **simplicité opérationnelle**. Il ne requiert aucun framework lourd (pas de Laravel), aucun runtime Node.js et aucun démon serveur permanent, garantissant une compatibilité immédiate avec les hébergements mutualisés et cPanel standards.

```
┌────────────────────────────────────────────────────────────────────────┐
│ REQUÊTE HTTP (Naviguateur / Client Mobile)                             │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ 1. public/index.php (Front Controller)
┌───────────────────────────────────▼────────────────────────────────────┐
│ COUCHE HTTP & ROUTAGE                                                  │
│ - bootstrap/app.php (Autoloader PSR-4, .env, Config, View, Session)   │
│ - routes/web.php    (Déclaration des routes web et admin)              │
│ - App\Core\Router   (Résolution des patterns {param} et verbes HTTP)   │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ 2. Dispatch vers Contrôleur
┌───────────────────────────────────▼────────────────────────────────────┐
│ APPLICATION & CONTRÔLEURS (App\Http\Controllers\)                      │
│ - Validation des entrées serveur (App\Core\Validator)                  │
│ - Vérification CSRF & Session (App\Core\Session)                       │
│ - Autorisation & Guards (App\Http\Middleware\AuthMiddleware)           │
│ - Appel aux Services Applicatifs & Repositories                        │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ 3. Persistance & Transactions
┌───────────────────────────────────▼────────────────────────────────────┐
│ PERSISTANCE & BASE DE DONNÉES                                          │
│ - App\Core\Database (Singleton PDO MySQL 8 / Prepared Statements)      │
│ - App\Core\MigrationRunner (Migrations versionnées .sql sous transac.) │
│ - database/migrations/ (Schéma fondateur immuable)                    │
└───────────────────────────────────┬────────────────────────────────────┘
                                    │ 4. Rendu de la réponse
┌───────────────────────────────────▼────────────────────────────────────┐
│ PRÉSENTATION & VUES (App\Views\)                                       │
│ - App\Core\View (Échappement htmlspecialchars contextuel)              │
│ - Vues de Thèmes Storefront (views/themes/fashion/)                    │
│ - Vues d'Administration Swiss Commerce (views/admin/)                  │
└────────────────────────────────────────────────────────────────────────┘
```

---

## 2. Arborescence du Projet

| Dossier / Fichier | Responsabilité dans l'architecture |
|---|---|
| `public/` | **Seul Document Root HTTP exposé**. Contient `index.php`, `.htaccess` et les assets statiques publics (`css/`, `js/`, `images/`). |
| `bootstrap/app.php` | Point de démarrage applicatif : autoloader natif PSR-4, chargement `.env`, initialisation de la configuration et des sessions. |
| `config/` | Fichiers de configuration PHP immuables (`app.php`, `database.php`). |
| `routes/web.php` | Déclaration centralisée des routes Storefront et Dashboard. |
| `app/Core/` | Noyau technique léger : `Env`, `Config`, `Database`, `Request`, `Response`, `Router`, `View`, `Session`, `Validator`, `MigrationRunner`. |
| `app/Http/Controllers/` | Contrôleurs de réception HTTP (ex: `HealthController`, `AuthController`). |
| `app/Http/Middleware/` | Filtres d'accès et d'authentification (`AuthMiddleware`). |
| `app/Domain/` | Entités et règles métier pures, indépendantes de la base ou de l'UI. |
| `app/Application/` | Services orchestrateurs de cas d'usage et DTO. |
| `app/Repositories/` | Abstractions d'accès aux données via PDO préparé. |
| `app/Infrastructure/` | Adaptateurs externes (stockage de fichiers, import CSV/Meta). |
| `app/Views/` | Gabarits de présentation HTML/PHP échappés (séparation thèmes / admin). |
| `database/migrations/` | Fichiers SQL ordonnés et versionnés (`001_create_initial_schema.sql`). |
| `storage/` | Répertoire hors Document Root pour uploads, logs et sessions. |
| `bin/` | Scripts d'automatisation CLI pour cPanel (ex: `bin/migrate.php`). |
| `tests/` | Suite de tests autonome (`tests/test_runner.php`). |
