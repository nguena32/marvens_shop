<?php
declare(strict_types=1);

/**
 * Déclaration des routes complètes du MVP fonctionnel
 */

use App\Core\Router;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminController;

/** @var Router $router */

// 1. Diagnostic de santé
$router->get('/health', [HealthController::class, 'check'], 'health.check');

// 2. Storefront Public (Parcours Client)
$router->get('/', [StorefrontController::class, 'home'], 'storefront.home');
$router->get('/catalogue', [StorefrontController::class, 'catalog'], 'storefront.catalog');
$router->get('/produit/{slug}', [StorefrontController::class, 'product'], 'storefront.product');
$router->get('/theme/preview/{theme}', [StorefrontController::class, 'previewTheme'], 'theme.preview');

// 3. Panier & Checkout
$router->get('/panier', [CartController::class, 'index'], 'cart.index');
$router->post('/panier/ajouter', [CartController::class, 'add'], 'cart.add');
$router->post('/panier/modifier', [CartController::class, 'update'], 'cart.update');
$router->post('/panier/supprimer', [CartController::class, 'remove'], 'cart.remove');

$router->get('/checkout', [CartController::class, 'showCheckout'], 'checkout.index');
$router->post('/checkout', [CartController::class, 'processCheckout'], 'checkout.process');
$router->get('/commande/confirmation/{order_number}', [CartController::class, 'confirmation'], 'order.confirmation');

// 4. Authentification Administrateur
$router->get('/admin/login', [AuthController::class, 'showLogin'], 'admin.login');
$router->post('/admin/login', [AuthController::class, 'login'], 'admin.login.post');
$router->post('/admin/logout', [AuthController::class, 'logout'], 'admin.logout');

// 5. Dashboard et Gestion Commerciale
$router->get('/admin/dashboard', [AdminController::class, 'dashboard'], 'admin.dashboard');
$router->get('/admin/commandes', [AdminController::class, 'orders'], 'admin.orders');
$router->get('/admin/commandes/{id}', [AdminController::class, 'orderDetail'], 'admin.order.detail');
$router->post('/admin/commandes/{id}/statut', [AdminController::class, 'updateOrderStatus'], 'admin.order.status');

// 6. Catalogue Admin
$router->get('/admin/produits', [AdminController::class, 'products'], 'admin.products');
$router->get('/admin/produits/nouveau', [AdminController::class, 'createProduct'], 'admin.product.create');
$router->post('/admin/produits/nouveau', [AdminController::class, 'createProduct'], 'admin.product.store');

// 7. Thèmes & Personnalisation (Exigence Module 2)
$router->get('/admin/themes', [AdminController::class, 'themes'], 'admin.themes');
$router->post('/admin/themes/activer', [AdminController::class, 'switchTheme'], 'admin.themes.switch');
$router->post('/admin/themes/rollback', [AdminController::class, 'rollbackTheme'], 'admin.themes.rollback');
$router->post('/admin/themes/reinitialiser', [AdminController::class, 'resetTheme'], 'admin.themes.reset');

// 8. Importation Catalogue (CSV / Meta)
$router->get('/admin/import', [AdminController::class, 'showImport'], 'admin.import');
$router->post('/admin/import/csv', [AdminController::class, 'processCsvImport'], 'admin.import.csv');
