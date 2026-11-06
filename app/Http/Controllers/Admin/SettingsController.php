<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Application\Services\SettingsService;

class SettingsController
{
    private SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
    }

    private function requireAuth(): ?Response
    {
        if (!Session::has('user_id')) {
            return Response::redirect('/admin/login', 302);
        }
        return null;
    }

    private function validateCsrf(Request $request): bool
    {
        $token = $request->input('_csrf_token');
        return !empty($token) && hash_equals(Session::get('_csrf_token', ''), $token);
    }

    // =========================================================================
    // 5.1 INFORMATIONS DE LA BOUTIQUE
    // =========================================================================

    public function shopInfo(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $shop = $this->settingsService->getShopInfo();
        $success = Session::getFlash('success');
        $error = Session::getFlash('error');

        $html = View::render('admin.pages.settings_shop', [
            'active_tab' => 'settings_shop',
            'shop' => $shop,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
            'error' => $error,
        ]);
        return Response::html($html);
    }

    public function saveShopInfo(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Session ou jeton de sécurité expiré. Veuillez réessayer.');
            return Response::redirect('/admin/parametres/boutique');
        }

        $res = $this->settingsService->updateShopInfo($request->all());
        if ($res['success']) {
            $this->settingsService->logActivity(
                (int)Session::get('user_id'),
                (string)Session::get('user_email'),
                'settings_shop_update',
                null,
                null,
                'Mise à jour des coordonnées et informations de la boutique'
            );
            Session::flash('success', 'Les informations de la boutique ont été enregistrées avec succès.');
        } else {
            $errMsg = reset($res['errors']);
            Session::flash('error', $errMsg ?: 'Erreur lors de la validation du formulaire.');
        }

        return Response::redirect('/admin/parametres/boutique');
    }

    // =========================================================================
    // 5.3 LIVRAISON ET RETRAIT
    // =========================================================================

    public function delivery(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $settings = $this->settingsService->getDeliverySettings();
        $success = Session::getFlash('success');
        $error = Session::getFlash('error');

        $html = View::render('admin.pages.settings_delivery', [
            'active_tab' => 'settings_delivery',
            'delivery' => $settings,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
            'error' => $error,
        ]);
        return Response::html($html);
    }

    public function saveDeliverySettings(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/livraison');
        }

        $this->settingsService->updateDeliverySettings($request->all());
        $this->settingsService->logActivity(
            (int)Session::get('user_id'),
            (string)Session::get('user_email'),
            'settings_delivery_update',
            null,
            null,
            'Mise à jour des modes et instructions de livraison'
        );

        Session::flash('success', 'Configuration des modes de livraison mise à jour.');
        return Response::redirect('/admin/parametres/livraison');
    }

    public function addDeliveryZone(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/livraison');
        }

        $city = (string)$request->input('city', 'Douala');
        $district = (string)$request->input('district', '');
        $fee = (int)$request->input('fee', 1500);
        $time = (string)$request->input('estimated_time', '24h - 48h');

        if (empty(trim($district))) {
            Session::flash('error', 'Le nom du quartier ou de la zone est obligatoire.');
            return Response::redirect('/admin/parametres/livraison');
        }

        $this->settingsService->addDeliveryZone($city, $district, $fee, $time);
        $this->settingsService->logActivity(
            (int)Session::get('user_id'),
            (string)Session::get('user_email'),
            'delivery_zone_add',
            null,
            null,
            "Ajout de la zone de livraison : {$district} ({$city}) - {$fee} FCFA"
        );

        Session::flash('success', "Zone {$district} ajoutée avec succès.");
        return Response::redirect('/admin/parametres/livraison');
    }

    public function deleteDeliveryZone(Request $request, array $params): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/livraison');
        }

        $id = (int)($params['id'] ?? 0);
        if ($id > 0) {
            $this->settingsService->deleteDeliveryZone($id);
            Session::flash('success', 'Zone supprimée.');
        }

        return Response::redirect('/admin/parametres/livraison');
    }

    // =========================================================================
    // 5.4 UTILISATEURS ET PERMISSIONS
    // =========================================================================

    public function users(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $users = $this->settingsService->getAllUsers();
        $roles = $this->settingsService->getUserRoles();
        $success = Session::getFlash('success');
        $error = Session::getFlash('error');

        $html = View::render('admin.pages.settings_users', [
            'active_tab' => 'settings_users',
            'users' => $users,
            'roles' => $roles,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
            'error' => $error,
        ]);
        return Response::html($html);
    }

    public function createUser(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/utilisateurs');
        }

        $username = (string)$request->input('username');
        $email = (string)$request->input('email');
        $password = (string)$request->input('password');
        $role = (string)$request->input('role');
        $name = (string)$request->input('name');

        $res = $this->settingsService->addUser($username, $email, $password, $role, $name);
        if ($res['success']) {
            $this->settingsService->logActivity(
                (int)Session::get('user_id'),
                (string)Session::get('user_email'),
                'user_create',
                null,
                null,
                "Création de l'utilisateur {$username} ({$role})"
            );
            Session::flash('success', "L'utilisateur {$username} a été créé avec succès.");
        } else {
            Session::flash('error', $res['error'] ?? 'Erreur lors de la création du compte.');
        }

        return Response::redirect('/admin/parametres/utilisateurs');
    }

    public function toggleUser(Request $request, array $params): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/utilisateurs');
        }

        $id = (int)($params['id'] ?? 0);
        $status = (bool)$request->input('active');

        // Interdiction de se désactiver soi-même
        if ($id === (int)Session::get('user_id') && !$status) {
            Session::flash('error', 'Vous ne pouvez pas désactiver votre propre compte administrateur.');
            return Response::redirect('/admin/parametres/utilisateurs');
        }

        $this->settingsService->toggleUserStatus($id, $status);
        Session::flash('success', 'Statut du compte mis à jour.');
        return Response::redirect('/admin/parametres/utilisateurs');
    }

    // =========================================================================
    // 5.5 NOTIFICATIONS
    // =========================================================================

    public function notifications(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $notif = $this->settingsService->getNotificationSettings();
        $success = Session::getFlash('success');

        $html = View::render('admin.pages.settings_notifications', [
            'active_tab' => 'settings_notifications',
            'notifications' => $notif,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
        ]);
        return Response::html($html);
    }

    public function saveNotifications(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/notifications');
        }

        $events = [
            'order_confirmation_email', 'order_confirmation_whatsapp',
            'order_preparing_email', 'order_preparing_whatsapp',
            'order_shipped_email', 'order_shipped_whatsapp',
            'order_delivered_email', 'order_delivered_whatsapp',
            'order_cancelled_email', 'order_cancelled_whatsapp',
            'admin_new_order_email', 'admin_new_order_whatsapp',
            'admin_low_stock_email', 'admin_out_of_stock_email'
        ];

        $settings = [];
        foreach ($events as $ev) {
            $settings[$ev] = !empty($request->input($ev));
        }

        $this->settingsService->updateNotificationSettings($settings);
        $this->settingsService->logActivity(
            (int)Session::get('user_id'),
            (string)Session::get('user_email'),
            'settings_notifications_update',
            null,
            null,
            'Mise à jour des canaux et déclencheurs de notifications'
        );

        Session::flash('success', 'Préférences de notifications enregistrées.');
        return Response::redirect('/admin/parametres/notifications');
    }

    // =========================================================================
    // 5.6 APPLICATIONS & INTÉGRATIONS
    // =========================================================================

    public function integrations(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $integrations = $this->settingsService->getIntegrationsSettings();
        $success = Session::getFlash('success');

        $html = View::render('admin.pages.settings_integrations', [
            'active_tab' => 'settings_integrations',
            'integrations' => $integrations,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
        ]);
        return Response::html($html);
    }

    public function saveIntegrations(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/integrations');
        }

        $this->settingsService->updateIntegrationsSettings($request->all());
        $this->settingsService->logActivity(
            (int)Session::get('user_id'),
            (string)Session::get('user_email'),
            'settings_integrations_update',
            null,
            null,
            'Mise à jour des intégrations tierces (WhatsApp, Meta, SMTP)'
        );

        Session::flash('success', 'Paramètres des applications et intégrations enregistrés.');
        return Response::redirect('/admin/parametres/integrations');
    }

    // =========================================================================
    // 5.7 SÉCURITÉ & AUDIT
    // =========================================================================

    public function security(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $logs = $this->settingsService->getActivityLogs(30);
        $success = Session::getFlash('success');
        $error = Session::getFlash('error');

        $html = View::render('admin.pages.settings_security', [
            'active_tab' => 'settings_security',
            'logs' => $logs,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
            'error' => $error,
        ]);
        return Response::html($html);
    }

    public function updatePassword(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/securite');
        }

        $newPassword = (string)$request->input('new_password');
        $confirmPassword = (string)$request->input('confirm_password');

        if ($newPassword !== $confirmPassword) {
            Session::flash('error', 'Les deux mots de passe ne correspondent pas.');
            return Response::redirect('/admin/parametres/securite');
        }

        $userId = (int)Session::get('user_id');
        $res = $this->settingsService->updateUserPassword($userId, $newPassword);

        if ($res['success']) {
            $this->settingsService->logActivity(
                $userId,
                (string)Session::get('user_email'),
                'password_change',
                null,
                null,
                'Changement de mot de passe administrateur réussi'
            );
            Session::flash('success', 'Votre mot de passe a été modifié avec succès.');
        } else {
            Session::flash('error', $res['error'] ?? 'Erreur lors du changement de mot de passe.');
        }

        return Response::redirect('/admin/parametres/securite');
    }

    // =========================================================================
    // 5.8 ANALYTICS ET SUIVI
    // =========================================================================

    public function analytics(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;

        $analytics = $this->settingsService->getAnalyticsSettings();
        $success = Session::getFlash('success');

        $html = View::render('admin.pages.settings_analytics', [
            'active_tab' => 'settings_analytics',
            'analytics' => $analytics,
            'csrf_token' => Session::csrfToken(),
            'success' => $success,
        ]);
        return Response::html($html);
    }

    public function saveAnalytics(Request $request): Response
    {
        if ($redirect = $this->requireAuth()) return $redirect;
        if (!$this->validateCsrf($request)) {
            Session::flash('error', 'Jeton CSRF invalide.');
            return Response::redirect('/admin/parametres/analytics');
        }

        $this->settingsService->updateAnalyticsSettings($request->all());
        $this->settingsService->logActivity(
            (int)Session::get('user_id'),
            (string)Session::get('user_email'),
            'settings_analytics_update',
            null,
            null,
            'Mise à jour des identifiants et traceurs analytics/Pixel'
        );

        Session::flash('success', 'Configuration des traceurs marketing et analytics enregistrée.');
        return Response::redirect('/admin/parametres/analytics');
    }
}
