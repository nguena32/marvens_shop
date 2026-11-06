# Guide d'utilisation et Diagnostic — Système Centralisé de Logs

Le système de journalisation de **Marvens Shop** est conçu pour assurer une traçabilité complète, sécurisée et performante des erreurs et événements d'exploitation, conformément aux contraintes de sécurité OWASP, RGPD et des hébergements mutualisés cPanel (PHP 8.3+ Vanilla MVC).

---

## 1. Emplacement et Organisation des Logs

Tous les fichiers journaux sont stockés dans le répertoire privé hors Document Root :
`/storage/logs/`

### Organisation par canaux :
* **`app-YYYY-MM-DD.log`** : Événements applicatifs, commandes, cycle de vie panier et sauvegardes.
* **`php-YYYY-MM-DD.log`** : Erreurs PHP natives, warnings, notices et erreurs capturées au shutdown.
* **`database-YYYY-MM-DD.log`** : Échecs de connexion et erreurs PDO/MySQL.
* **`security-YYYY-MM-DD.log`** : Échecs de login, rate limit brute-force, échecs CSRF et violations d'accès.
* **`integrations-YYYY-MM-DD.log`** : Anomalies de liaison externe (WhatsApp, Meta Graph API, Webhooks).

---

## 2. Format des Entrées (JSON Lines & ISO 8601)

Chaque événement est consigné sur une ligne unique JSON (JSON Lines) horodatée en ISO 8601 (ATOM) :

```json
{
  "timestamp": "2026-11-06T16:55:00+01:00",
  "channel": "app",
  "level": "INFO",
  "request_id": "8e3b1c5a9d20f4e1",
  "message": "Sauvegarde base de données effectuée",
  "http": {
    "method": "POST",
    "uri": "/admin/parametres/securite/sauvegarde-db",
    "ip": "192.168.1.10"
  },
  "context": {
    "file": "backup_db_2026-11-06_16-55-00.sql",
    "size": 2048
  },
  "user_id": 1
}
```

En cas d'exception, un bloc `exception` détaille la classe, le code, l'emplacement et une stack trace sécurisée de 10 niveaux.

---

## 3. Sécurité et Masquage (Redaction)

Le logger neutralise automatiquement toute donnée sensible avant écriture :
* **Mots de passe** : `password`, `password_hash`, `new_password`...
* **Jetons & Sessions** : `token`, `bearer`, `_csrf_token`, `cookie`, `session_id`, `meta_access_token`.
* **Paiement** : `card_number`, `cvv`.
* **Injection CRLF** : Les retours chariot (`\r`, `\n`) sont remplacés par des espaces afin d'éviter toute falsification des lignes de logs.
* **Protection HTTP** : Les répertoires `storage/` et `storage/logs/` disposent chacun d'un `.htaccess` avec `Require all denied` interdisant tout accès via navigateur.

---

## 4. Corrélation des Requêtes (`request_id`)

Chaque cycle HTTP dispose d'un identifiant de corrélation unique (`request_id`).
* En cas d'incident en production (`APP_DEBUG=false`), l'utilisateur voit un écran sobre avec la mention :
  > *« Référence d'incident : **REQUEST_ID** »*
* Le gestionnaire technique peut instantanément retrouver toutes les anomalies liées à cette requête en filtrant par ce `request_id`.

---

## 5. Rotation et Rétention Automatique

* **Rotation par taille** : Si un fichier dépasse la limite fixée (par défaut 10 Mo via `config/logging.php`), une rotation automatique vers `.1.log`, `.2.log` est effectuée.
* **Rétention** : Les logs de plus de 30 jours sont automatiquement purgés par le runner de maintenance cPanel :
  ```bash
  php bin/cron.php
  ```

---

## 6. Diagnostic Rapide sous cPanel

### Depuis le Gestionnaire de Fichiers cPanel :
1. Accéder au dossier situé au-dessus de `public_html` : `storage/logs/`.
2. Ouvrir le fichier du canal souhaité (ex: `php-AAAA-MM-JJ.log` ou `security-AAAA-MM-JJ.log`).

### En Ligne de Commande SSH / Terminal cPanel :
* **Rechercher un incident par request_id :**
  ```bash
  grep "VOTRE_REQUEST_ID" storage/logs/*.log
  ```
* **Surveiller les erreurs applicatives en direct :**
  ```bash
  tail -f storage/logs/app-$(date +%F).log
  ```
* **Afficher les 20 dernières erreurs de sécurité :**
  ```bash
  tail -n 20 storage/logs/security-$(date +%F).log
  ```
