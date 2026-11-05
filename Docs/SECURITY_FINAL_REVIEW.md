# SECURITY_FINAL_REVIEW.md
# Revue Finale de Sécurité Applicative — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 5 — Intégrations externes, sécurité finale et recette QA  
**Agent :** Ingénieur Sécurité Applicative / Lead QA (Google Antigravity)  
**Périmètre audité :** 100% des contrôleurs, requêtes SQL, formulaires et templates HTML.

---

## 1. Synthèse des Domaines Vérifiés

| Domaine de Sécurité | Mécanismes et Contre-mesures | Niveau de Risque Résiduel |
|---|---|---|
| **Injections SQL** | 100% des requêtes passent par `PDO::prepare()` avec paramètres nommés. Aucune concaténation SQL de variable utilisateur. Désactivation de l'émulation PDO. | **NÉGLIGEABLE** |
| **Cross-Site Scripting (XSS)** | Sorties échappées via `htmlspecialchars(..., ENT_QUOTES \| ENT_SUBSTITUTE, 'UTF-8')`. Pas d'injection de HTML brut dans les vues publiques ou admin. | **NÉGLIGEABLE** |
| **Cross-Site Request Forgery (CSRF)** | Jeton cryptographique de 64 caractères hexadécimaux stocké en session. Vérification systématique par `hash_equals` sur `POST /panier/ajouter`, `POST /checkout`, `POST /admin/login`, `POST /admin/commandes/{id}/statut`, `POST /admin/themes/activer`, `POST /admin/import/csv`. | **NÉGLIGEABLE** |
| **Authentification & Sessions** | Mots de passe chiffrés en `Argon2id` / `Bcrypt` via `password_hash()`. Régénération d'ID de session à la connexion. Destruction totale au logout. Cookies protégés par `HttpOnly`, `SameSite=Lax`. | **FAIBLE** |
| **Contrôle d'Accès / IDOR** | `AuthMiddleware` verrouille chaque point d'entrée d'administration. Le rôle `merchant_admin` est vérifié côté serveur. Pas d'exposition directe d'actions d'administration. | **FAIBLE** |
| **Téléversement de Fichiers** | Inspection du MIME réel par `finfo_file()`, extension déduite du MIME réel, renommage cryptographique de 32 caractères aléatoires, stockage dans `storage/uploads/` avec interdiction d'exécution de scripts PHP. | **FAIBLE** |
| **Exposition de Fichiers Privés** | Règle Apache `.htaccess` bloquant l'accès direct HTTP à `.env`, `.git`, `storage/logs` et `database/`. | **FAIBLE** |
| **Manipulation de Prix (Business Logic)** | Recalcul autoritaire serveur : le total d'une commande ne dépend jamais du formulaire POST mais de la base SQL. | **NÉGLIGEABLE** |

---

## 2. Recommandations et Bonnes Pratiques pour l'Administrateur
1. **Activer HTTPS systématiquement :** Sur cPanel, forcer la redirection vers HTTPS (Let's Encrypt / AutoSSL) et basculer `SESSION_SECURE_COOKIE=true` dans `.env`.
2. **Droits de fichiers cPanel :** Conserver `chmod 755` sur les dossiers et `chmod 644` sur les fichiers PHP. Attribuer `chmod 600` au fichier `.env`.
