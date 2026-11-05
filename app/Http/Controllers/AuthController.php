<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\Database;
use PDO;

/**
 * Contrôleur d'authentification pour le compte administrateur commerçant
 */
class AuthController extends Controller
{
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

        if ($username === '' || $password === '') {
            Session::set('flash_error', 'Veuillez saisir votre identifiant et votre mot de passe.');
            return $this->redirect('/admin/login');
        }

        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :u OR email = :u LIMIT 1');
            $stmt->execute(['u' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                Session::set('flash_error', 'Utilisateur non trouvé en base.');
                return $this->redirect('/admin/login');
            }

            if (!password_verify($password, $user['password_hash'])) {
                Session::set('flash_error', 'Mot de passe incorrect pour cet utilisateur.');
                return $this->redirect('/admin/login');
            }

            // Régénération de session (anti session fixation)
            Session::regenerate(true);
            Session::set('admin_user_id', $user['id']);
            Session::set('admin_user_name', $user['name'] ?? $user['username']);
            Session::set('admin_user_role', $user['role']);

            return $this->redirect('/admin/dashboard');
        } catch (\Exception $e) {
            Session::set('flash_error', 'Erreur système : ' . $e->getMessage());
            return $this->redirect('/admin/login');
        }
    }

    public function logout(Request $request): Response
    {
        Session::destroy();
        return $this->redirect('/admin/login');
    }
}
