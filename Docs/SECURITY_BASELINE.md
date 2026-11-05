# SECURITY_BASELINE.md
# Référentiel de Sécurité et Protections Réalisées — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 3 — Fondations techniques et contrats de modules  
**Agent :** Lead Developer / Sécurité Applicative (Google Antigravity)  
**Normes de référence :** OWASP Top 10, Creative Brief (`08_TECHNICAL_STANDARDS/FRONTEND_STANDARDS.md`), `AGENTS.md` (Section 10).

---

## 1. Protections Réellement Implémentées dans le Socle

| Risque OWASP / Vulnérabilité | Mesure de Protection Concrète | Emplacement du Code | Statut Test |
|---|---|---|---|
| **Injections SQL** | Utilisation exclusive de **PDO avec requêtes préparées** et typage strict des paramètres. Désactivation explicite de l'émulation (`PDO::ATTR_EMULATE_PREPARES => false`). | `app/Core/Database.php` | **Validé** |
| **Injections XSS (Cross-Site Scripting)** | Échappement systématique de toutes les données dynamiques à la sortie via `htmlspecialchars(..., ENT_QUOTES \| ENT_SUBSTITUTE, 'UTF-8')`. | `app/Core/View.php` | **Validé** |
| **Failles CSRF (Cross-Site Request Forgery)** | Génération automatique d'un jeton cryptographique aléatoire de 64 caractères hexadécimaux en session. Contrôle strict par comparaison temporelle constante (`hash_equals`) sur toutes les requêtes mutantes. | `app/Core/Session.php`, `app/Http/Controllers/Controller.php` | **Validé (Test Suite)** |
| **Fixation et Vol de Session** | Configuration stricte des cookies de session (`HttpOnly: true`, `SameSite: Lax`, `Secure: true` en production HTTPS). Régénération automatique de l'ID de session lors de l'authentification (`session_regenerate_id(true)`). | `app/Core/Session.php`, `app/Http/Controllers/AuthController.php` | **Validé (Test Suite)** |
| **Élévation de Privilèges / IDOR** | Contrôle serveur systématique du rôle de session (`merchant_admin`) via middleware sur toutes les routes d'administration. Pas de rôle client ou invité autorisé dans le back-office. | `app/Http/Middleware/AuthMiddleware.php` | **Validé** |
| **Téléversement de Fichiers Dangereux** | Vérification du type MIME réel côté serveur via `finfo_file()` (JPEG, PNG, WEBP uniquement), génération d'un nom de fichier cryptographique aléatoire de 32 caractères, limitation de taille bornée à 5 Mo. Stockage hors exécution de scripts. | `app/Infrastructure/Storage/FileStorageService.php` | **Validé** |
| **Exposition des Fichiers Privés** | Règle de réécriture Apache interdisant l'accès direct aux fichiers `.env`, `.git`, aux journaux d'erreurs et aux dossiers de données privées. | `public/.htaccess` | **Validé** |
| **Fuite de Stacktrace en Production** | Gestionnaire d'erreurs filtrant les messages techniques détaillés en fonction de la variable `APP_DEBUG`. Réponses neutres et génériques retournées au client en environnement de production. | `app/Http/Controllers/HealthController.php` | **Validé** |

---

## 2. Checklist d'Audit de Sécurité pour l'Étape 4

Lors du développement fonctionnel à l'Étape 4, chaque agent devra impérativement vérifier :
- [ ] Aucun calcul de prix ou de montant total ne provient d'un champ masqué du formulaire ou d'un paramètre d'URL.
- [ ] Toute action de mise à jour ou de suppression de produit/commande inclut un champ `<input type="hidden" name="_csrf_token" value="...">`.
- [ ] Les uploads d'images passent exclusivement par l'instance de `FileStorageService`.
- [ ] Les identifiants de commandes (`order_number`) sont générés de manière aléatoire ou séquentielle opaque (ex: `#CMD-20261105-XXXX`) et ne révèlent pas la clé primaire incrémentale directe.
