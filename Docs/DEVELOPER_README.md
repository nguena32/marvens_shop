# DEVELOPER_README.md
# Guide Développeur et Prise en Main Locale — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 3 — Fondations techniques et contrats de modules  
**Stack :** PHP 8.3+ Vanilla MVC, MySQL 8 / SQLite (Tests), HTML5/CSS3/JS Vanilla.

---

## 1. Démarrage Rapide en Local

### Prérequis
- PHP 8.3 ou supérieur installé sur la machine (`php -v`).
- Extensions PHP actives : `pdo`, `pdo_mysql`, `pdo_sqlite`, `fileinfo`, `mbstring`, `openssl`, `session`.
- Aucune installation de Composer ou de Node.js n'est requise.

### Procédure d'Initialisation
1. Dupliquer le fichier de configuration d'exemple :
   ```bash
   cp .env.example .env
   ```
2. Configurer les accès MySQL locaux dans `.env` (ou laisser la configuration par défaut).
3. Lancer les tests unitaires et d'intégration :
   ```bash
   php tests/test_runner.php
   ```
4. Démarrer le serveur de développement PHP intégré :
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```
5. Accéder à l'application dans votre navigateur :
   - Vitrine publique : `http://127.0.0.1:8000/`
   - Diagnostic de santé : `http://127.0.0.1:8000/health`
   - Administration : `http://127.0.0.1:8000/admin/login`

---

## 2. Commandes Disponibles

| Commande | Rôle |
|---|---|
| `php tests/test_runner.php` | Exécute la suite de tests unitaires et d'intégration (Routage, Validation, CSRF, Migrations, Sécurité). |
| `php bin/migrate.php` | Applique les migrations SQL ordonnées sur la base de données configurée. |
| `php -S 127.0.0.1:8000 -t public` | Lance le serveur local de test sans nécessiter Apache ou Nginx. |
