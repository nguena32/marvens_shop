<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Core\Session;
use App\Core\Response;

/**
 * Middleware d'authentification pour protéger les routes d'administration
 */
class AuthMiddleware
{
    public static function check(): ?Response
    {
        Session::start();
        $userId = Session::get('admin_user_id');
        $userRole = Session::get('admin_user_role');

        if (!$userId || $userRole !== 'merchant_admin') {
            return Response::redirect('/admin/login', 302);
        }

        return null;
    }
}
