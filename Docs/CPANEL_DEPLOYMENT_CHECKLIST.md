# CPANEL_DEPLOYMENT_CHECKLIST.md
# Guide et Procédure de Déploiement cPanel / Mutualisé — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 3 — Fondations techniques et contrats de modules  
**Cible :** Hébergement Web cPanel standard (PHP 8.3+, MySQL 8, Apache avec mod_rewrite).

---

## 1. Topologie de Déploiement Idéale sur cPanel

Pour garantir une sécurité étanche, le code applicatif privé doit être placé **en dehors du dossier racine public** (`public_html`).

```
/home/commercant/
├── marvens_app/                 # Code privé de l'application (NON accessible depuis le web)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── storage/                 # Logs, uploads privés, sessions
│   ├── .env                     # Secrets de l'instance du commerçant
│   └── bin/
│
└── public_html/                 # Seul dossier accessible via http://domaine-client.cm/
    ├── index.php                # Pointe vers /home/commercant/marvens_app/public/index.php
    ├── .htaccess                # Règles de réécriture et sécurisation Apache
    └── assets/                  # CSS, JS, Images publiques du thème
        ├── css/
        ├── js/
        └── images/
```

> **Alternative (Si sous-domaine cPanel) :**  
> Si le client utilise un sous-domaine (ex: `boutique.domaine.cm`), configurer directement la racine du document (*Document Root*) dans cPanel vers `/home/commercant/marvens_app/public`.

---

## 2. Procédure Étape par Étape

### Étape 1 : Préparation de la Base de Données
1. Se connecter à l'interface cPanel du commerçant.
2. Ouvrir l'outil **Bases de données MySQL**.
3. Créer une nouvelle base : `commercant_marvens`.
4. Créer un utilisateur MySQL dédié avec un mot de passe fort : `commercant_user`.
5. Associer l'utilisateur à la base en lui attribuant **TOUS LES PRIVILÈGES**.

### Étape 2 : Téléversement des Fichiers
1. Utiliser le Gestionnaire de fichiers cPanel ou un client FTP (FileZilla en SFTP).
2. Déposer le dossier `marvens_app/` dans `/home/commercant/`.
3. Déposer le contenu du dossier `public/` dans `/home/commercant/public_html/`.

### Étape 3 : Configuration du Fichier `.env`
1. Dans `/home/commercant/marvens_app/`, dupliquer `.env.example` en `.env`.
2. Éditer le fichier avec les coordonnées réelles de l'hébergement :
   ```dotenv
   APP_NAME="Nom du Commerce"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://boutique.domaine.cm
   APP_SECRET=generer_une_chaine_aleatoire_tres_longue

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=commercant_marvens
   DB_USERNAME=commercant_user
   DB_PASSWORD=mot_de_passe_fort_genere
   ```

### Étape 4 : Exécution des Migrations
- **Méthode A (Terminal SSH cPanel) :**
  ```bash
  cd /home/commercant/marvens_app
  php bin/migrate.php
  ```
- **Méthode B (Import phpMyAdmin) :**
  Ouvrir phpMyAdmin depuis cPanel, sélectionner la base `commercant_marvens`, et importer directement le fichier `database/migrations/001_create_initial_schema.sql`.

### Étape 5 : Permissions des Dossiers
S'assurer des permissions Unix suivantes :
- `storage/` et sous-dossiers : **`chmod 755`** (écriture autorisée pour PHP).
- `.env` : **`chmod 600`** ou **`640`** (lecture réservée au propriétaire).
- Fichiers `.php` : **`chmod 644`**.

### Étape 6 : Contrôle de Santé
Ouvrir dans le navigateur l'URL de diagnostic :  
`https://boutique.domaine.cm/health`  
Elle doit retourner un JSON avec `"status": "ok"` et `"database": {"status": "connected"}`.
