<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\Database;
use App\Core\Logger;
use App\Application\Services\RateLimiterService;
use PDO;

/**
 * Contrôleur d'authentification pour le compte administrateur commerçant
 * Sécurisé selon OWASP : Rate Limiting, Régénération ID, Neutralité des messages, Audit
 */
class AuthController extends Controller
{
    private RateLimiterService $rateLimiter;

    public function __construct()
    {
        $this->rateLimiter = new RateLimiterService();
    }

    public function showLogin(Request $request): Response
    {
        Session::start();
        if (Session::get('admin_user_id')) {
            return $this->redirect('/admin/dashboard');
        }

        $error = Session::get('flash_error');
        Session::remove('flash_error');

        return $this->render('admin.pages.login', [
            'error' => $error,
        ]);
    }

    public function login(Request $request): Response
    {
        $this->validateCsrf($request);

        $username = trim((string) $request->input('username', ''));
        $password = (string) $request->input('password', '');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        if ($username === '' || $password === '') {
            Session::set('flash_error', 'Veuillez saisir votre identifiant et votre mot de passe.');
            return $this->redirect('/admin/login');
        }

        // Protection brute-force : Rate limiting
        if ($this->rateLimiter->isLockedOut($ip, $username)) {
            Session::set('flash_error', 'Trop de tentatives de connexion infructueuses. Veuillez patienter 15 minutes avant de réessayer.');
            return $this->redirect('/admin/login');
        }

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE (username = :username OR email = :email) AND is_active = 1 LIMIT 1');
            $stmt->execute([
                'username' => $username,
                'email' => $username,
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Message neutre pour éviter l'énumération d'utilisateurs
            if (!$user || !password_verify($password, $user['password_hash'])) {
                $this->rateLimiter->recordFailedAttempt($ip, $username);
                Session::set('flash_error', 'Identifiants invalides ou compte inactif.');
                return $this->redirect('/admin/login');
            }

            // Réinitialiser les tentatives après succès
            $this->rateLimiter->clearAttempts($ip, $username);

            // Régénération stricte de session (anti session fixation)
            Session::regenerate(true);
            Session::set('admin_user_id', $user['id']);
            Session::set('admin_user_name', $user['name'] ?? $user['username']);
            Session::set('admin_user_role', $user['role']);

            Logger::info("Connexion administrateur réussie", [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'ip' => $ip,
            ]);

            return $this->redirect('/admin/dashboard');
        } catch (\Exception $e) {
            Logger::error("Erreur système lors du login", ['error' => $e->getMessage()]);
            Session::set('flash_error', 'Une erreur temporaire est survenue. Veuillez réessayer.');
            return $this->redirect('/admin/login');
        }
    }

    public function logout(Request $request): Response
    {
        Session::start();
        $userId = Session::get('admin_user_id');
        Logger::info("Déconnexion administrateur", ['user_id' => $userId]);

        Session::destroy();
        return $this->redirect('/admin/login');
    }
}
