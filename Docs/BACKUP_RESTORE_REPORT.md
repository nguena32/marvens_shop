# BACKUP_RESTORE_REPORT.md
# Procédure de Sauvegarde et Restauration — Marvens Shop MVP

**Date :** 05 novembre 2026  
**Étape :** Étape 5 — Intégrations externes, sécurité finale et recette QA  
**Cible :** Environnement d'hébergement cPanel / Mutualisé

---

## 1. Périmètre de la Sauvegarde

Chaque installation de Marvens Shop est totalement indépendante et se compose de deux éléments vitaux :
1. **La base de données MySQL :** Contient l'ensemble des catalogues, catégories, comptes administrateurs, configurations de boutique et l'historique immuable des commandes (`orders`, `order_items`, `order_status_history`).
2. **Le dossier de stockage physique (`storage/uploads/`) :** Contient les photos originales des produits téléversées par le commerçant.

---

## 2. Procédure de Sauvegarde (Backup)

### A. Sauvegarde de la Base de Données
- **Via phpMyAdmin (cPanel) :**
  1. Ouvrir phpMyAdmin, sélectionner la base du commerce.
  2. Cliquer sur l'onglet **Exporter** -> Méthode rapide -> Format SQL -> Exécuter.
  3. Conserver le fichier `backup_YYYYMMDD.sql` dans un dossier d'archive sécurisé.
- **Via ligne de commande (SSH / Cron cPanel) :**
  ```bash
  mysqldump -u commercant_user -p commercant_marvens > /home/commercant/backups/db_$(date +%Y%m%d).sql
  ```

### B. Sauvegarde des Fichiers Médias
- Télécharger l'archive compressée du dossier `storage/uploads/` via le gestionnaire de fichiers cPanel ou par SFTP.

---

## 3. Procédure de Restauration (Restore)

1. En cas de sinistre ou de réinstallation sur un nouveau domaine :
   - Recréer une base MySQL vierge sur le serveur.
   - Importer le fichier SQL de sauvegarde via phpMyAdmin ou la commande :
     ```bash
     mysql -u commercant_user -p commercant_marvens < backup_YYYYMMDD.sql
     ```
2. Restaurer le dossier `storage/uploads/` dans l'arborescence de l'application.
3. Vérifier les accès en ouvrant `/health` et l'administration `/admin/dashboard`.
