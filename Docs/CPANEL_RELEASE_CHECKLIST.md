# CPANEL_RELEASE_CHECKLIST.md
# Checklist Finale de Livraison et Déploiement cPanel — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 5 — Intégrations externes, sécurité finale et recette QA  
**Version de sortie :** Marvens Shop v1.0.0 (MVP Client Installé)

---

## 1. Prérequis Serveur (Hébergement cPanel)
- [x] PHP 8.3 ou supérieur configuré via le sélecteur PHP cPanel.
- [x] Extensions PHP requises activées : `pdo`, `pdo_mysql`, `fileinfo`, `mbstring`, `openssl`, `session`, `curl`.
- [x] MySQL 8.0 opérationnel avec moteur InnoDB et charset `utf8mb4`.
- [x] Module Apache `mod_rewrite` et `mod_headers` activés pour le traitement de `public/.htaccess`.

---

## 2. Procédure de Déploiement chez le Commerçant
1. **Création de la base MySQL :** Créer la base et l'utilisateur dans l'assistant MySQL cPanel.
2. **Transfert FTP / SFTP :**
   - Téléverser le dossier `app/`, `bootstrap/`, `config/`, `database/`, `routes/`, `storage/`, `bin/` dans `/home/commercant/marvens_app/`.
   - Téléverser le contenu du dossier `public/` dans `/home/commercant/public_html/`.
3. **Configuration `.env` :** Créer le fichier `.env` à partir de `.env.example` en renseignant les accès de la base et l'URL HTTPS finale.
4. **Exécution des migrations :**
   - Exécuter `php bin/migrate.php` via le terminal SSH cPanel ou importer `database/migrations/001_create_initial_schema.sql` via phpMyAdmin.
5. **Permissions de fichiers :**
   - `chmod 755` sur `storage/uploads/` et `storage/logs/`.
   - `chmod 600` sur `.env`.
6. **Vérification de mise en service :**
   - Ouvrir `https://domaine-boutique.cm/health` : doit afficher `"status": "ok"`.
   - Tester un parcours d'achat complet (Ajout panier -> Checkout -> WhatsApp).
   - Accéder à `/admin/login` et vérifier l'accès au tableau de bord.
