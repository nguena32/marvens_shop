<?php
declare(strict_types=1);

namespace App\Application\Services;

use PDO;
use App\Core\Database;
use App\Core\Logger;

/**
 * Service de protection contre les attaques par force brute (Rate Limiting)
 * Module 9.2 Sécurité applicative
 */
class RateLimiterService
{
    private PDO $pdo;
    private int $maxAttempts;
    private int $decaySeconds;

    public function __construct(?PDO $pdo = null, int $maxAttempts = 5, int $decaySeconds = 900)
    {
        $this->pdo = $pdo ?? Database::getConnection();
        $this->maxAttempts = $maxAttempts; // Par défaut 5 tentatives max
        $this->decaySeconds = $decaySeconds; // Fenêtre de blocage de 15 minutes (900s)
    }

    /**
     * Vérifie si une IP ou un compte est temporairement bloqué
     */
    public function isLockedOut(string $ip, string $username): bool
    {
        $this->cleanup();

        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM login_attempts
            WHERE (ip_address = :ip OR username = :username)
            AND attempted_at >= datetime('now', '-' || :decay || ' seconds')
        ");

        // Compatibilité MySQL vs SQLite pour la fonction datetime
        $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'mysql') {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) FROM login_attempts
                WHERE (ip_address = :ip OR username = :username)
                AND attempted_at >= DATE_SUB(NOW(), INTERVAL :decay SECOND)
            ");
        }

        $stmt->bindValue(':ip', $ip);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':decay', $this->decaySeconds, PDO::PARAM_INT);
        $stmt->execute();

        $attempts = (int)$stmt->fetchColumn();

        if ($attempts >= $this->maxAttempts) {
            Logger::security("Rate limit atteint pour l'IP ou utilisateur", [
                'ip' => $ip,
                'username' => $username,
                'attempts' => $attempts,
                'max' => $this->maxAttempts,
            ]);
            return true;
        }

        return false;
    }

    /**
     * Enregistre un échec de tentative de connexion
     */
    public function recordFailedAttempt(string $ip, string $username): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO login_attempts (ip_address, username)
            VALUES (:ip, :username)
        ");
        $stmt->execute([
            'ip' => $ip,
            'username' => $username,
        ]);

        Logger::security("Échec de connexion administrateur", [
            'ip' => $ip,
            'username' => $username,
        ]);
    }

    /**
     * Réinitialise les tentatives suite à un succès
     */
    public function clearAttempts(string $ip, string $username): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM login_attempts
            WHERE ip_address = :ip OR username = :username
        ");
        $stmt->execute([
            'ip' => $ip,
            'username' => $username,
        ]);
    }

    /**
     * Nettoyage automatique des enregistrements expirés
     */
    public function cleanup(): void
    {
        try {
            $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
            if ($driver === 'mysql') {
                $this->pdo->exec("DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL 86400 SECOND)");
            } else {
                $this->pdo->exec("DELETE FROM login_attempts WHERE attempted_at < datetime('now', '-86400 seconds')");
            }
        } catch (\Exception $e) {
            // Ignorer si table inexistante lors des tests préliminaires
        }
    }
}
