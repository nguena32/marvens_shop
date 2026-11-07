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
use App\Http\Controllers\PwaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingsController;

/** @var Router $router */

// 1. Diagnostic de santé & PWA
$router->get('/health', [HealthController::class, 'check'], 'health.check');
$router->get('/manifest.json', [PwaController::class, 'manifest'], 'pwa.manifest');
$router->get('/sw.js', [PwaController::class, 'serviceWorker'], 'pwa.sw');
$router->get('/offline', [PwaController::class, 'offline'], 'pwa.offline');

// 2. Storefront Public (Parcours Client & Pages Pratiques)
$router->get('/', [StorefrontController::class, 'home'], 'storefront.home');
$router->get('/catalogue', [StorefrontController::class, 'catalog'], 'storefront.catalog');
$router->get('/produit/{slug}', [StorefrontController::class, 'product'], 'storefront.product');
$router->get('/theme/preview/{theme}', [StorefrontController::class, 'previewTheme'], 'theme.preview');
$router->get('/a-propos', [StorefrontController::class, 'pageAbout'], 'storefront.about');
$router->get('/contact', [StorefrontController::class, 'pageContact'], 'storefront.contact');
$router->get('/livraison', [StorefrontController::class, 'pageDelivery'], 'storefront.delivery');
$router->get('/conditions-vente', [StorefrontController::class, 'pageTerms'], 'storefront.terms');
$router->get('/politique-confidentialite', [StorefrontController::class, 'pagePrivacy'], 'storefront.privacy');

// 3. Panier & Checkout
$router->get('/panier', [CartController::class, 'index'], 'cart.index');
$router->post('/panier/ajouter', [CartController::class, 'add'], 'cart.add');
$router->post('/panier/modifier', [CartController::class, 'update'], 'cart.update');
$router->post('/panier/supprimer', [CartController::class, 'remove'], 'cart.remove');

$router->get('/checkout', [CartController::class, 'showCheckout'], 'checkout.index');
$router->post('/checkout', [CartController::class, 'processCheckout'], 'checkout.process');
$router->get('/commande/confirmation/{order_number}', [CartController::class, 'confirmation'], 'order.confirmation');

// 4. Authentification Administrateur
$router->get('/admin', fn() => \App\Core\Response::redirect('/admin/login', 302), 'admin.index');
$router->get('/admin/login', [AuthController::class, 'showLogin'], 'admin.login');
$router->post('/admin/login', [AuthController::class, 'login'], 'admin.login.post');
$router->post('/admin/logout', [AuthController::class, 'logout'], 'admin.logout');

// 5. Dashboard et Gestion Commerciale (Module 8)
$router->get('/admin/dashboard', [AdminController::class, 'dashboard'], 'admin.dashboard');
$router->get('/admin/commandes', [AdminController::class, 'orders'], 'admin.orders');
$router->get('/admin/commandes/{id}', [AdminController::class, 'orderDetail'], 'admin.order.detail');
$router->post('/admin/commandes/{id}/statut', [AdminController::class, 'updateOrderStatus'], 'admin.order.status');
$router->post('/admin/commandes/{id}/paiement', [AdminController::class, 'updateOrderPayment'], 'admin.order.payment');

// 5.1 Clients & Historique (Module 8.4)
$router->get('/admin/clients', [AdminController::class, 'customers'], 'admin.customers');
$router->get('/admin/clients/{id}', [AdminController::class, 'customerDetail'], 'admin.customer.detail');

// 5.2 Statistiques Commerciales (Module 8.5)
$router->get('/admin/statistiques', [AdminController::class, 'statistics'], 'admin.statistics');

// 6. Catalogue Admin & Produits
$router->get('/admin/produits', [AdminController::class, 'products'], 'admin.products');
$router->get('/admin/produits/nouveau', [AdminController::class, 'createProduct'], 'admin.product.create');
$router->post('/admin/produits/nouveau', [AdminController::class, 'createProduct'], 'admin.product.store');
$router->get('/admin/produits/{id}/modifier', [AdminController::class, 'editProduct'], 'admin.product.edit');
$router->post('/admin/produits/{id}/modifier', [AdminController::class, 'updateProduct'], 'admin.product.update');
$router->post('/admin/produits/{id}/statut', [AdminController::class, 'toggleProductStatus'], 'admin.product.status');
$router->post('/admin/produits/{id}/featured', [AdminController::class, 'toggleProductFeatured'], 'admin.product.featured');
$router->post('/admin/produits/{id}/supprimer', [AdminController::class, 'deleteProduct'], 'admin.product.delete');
$router->post('/admin/produits/{id}/media/ajouter', [AdminController::class, 'addProductMedia'], 'admin.product.media.add');
$router->post('/admin/produits/{id}/media/{media_id}/supprimer', [AdminController::class, 'deleteProductMedia'], 'admin.product.media.delete');
$router->post('/admin/produits/{id}/media/{media_id}/definir-principale', [AdminController::class, 'setProductMainMedia'], 'admin.product.media.set_main');

// 6.2 Catégories Admin
$router->get('/admin/categories', [AdminController::class, 'categories'], 'admin.categories');
$router->get('/admin/categories/nouvelle', [AdminController::class, 'createCategory'], 'admin.category.create');
$router->post('/admin/categories/nouvelle', [AdminController::class, 'createCategory'], 'admin.category.store');
$router->get('/admin/categories/{id}/modifier', [AdminController::class, 'editCategory'], 'admin.category.edit');
$router->post('/admin/categories/{id}/modifier', [AdminController::class, 'updateCategory'], 'admin.category.update');
$router->post('/admin/categories/{id}/statut', [AdminController::class, 'toggleCategoryStatus'], 'admin.category.status');
$router->post('/admin/categories/{id}/supprimer', [AdminController::class, 'deleteCategory'], 'admin.category.delete');

// 7. Thèmes & Personnalisation (Exigences Modules 2 & 3)
$router->get('/admin/themes', [AdminController::class, 'themes'], 'admin.themes');
$router->post('/admin/themes/activer', [AdminController::class, 'switchTheme'], 'admin.themes.switch');
$router->post('/admin/themes/rollback', [AdminController::class, 'rollbackTheme'], 'admin.themes.rollback');
$router->post('/admin/themes/reinitialiser', [AdminController::class, 'resetTheme'], 'admin.themes.reset');

// Module 3 : Paramètres → Personnalisation des Couleurs & Apparence
$router->get('/admin/parametres/apparence', [AdminController::class, 'appearanceSettings'], 'admin.settings.appearance');
$router->post('/admin/parametres/apparence', [AdminController::class, 'saveAppearanceSettings'], 'admin.settings.appearance.save');
$router->post('/admin/parametres/apparence/reinitialiser', [AdminController::class, 'resetAppearanceSettings'], 'admin.settings.appearance.reset');

// Module 4 : Paramètres → Personnalisation des Polices d'Écriture (Typographie)
$router->get('/admin/parametres/typographie', [AdminController::class, 'typographySettings'], 'admin.settings.typography');
$router->post('/admin/parametres/typographie', [AdminController::class, 'saveTypographySettings'], 'admin.settings.typography.save');
$router->post('/admin/parametres/typographie/reinitialiser', [AdminController::class, 'resetTypographySettings'], 'admin.settings.typography.reset');

// 8. Importation Catalogue (CSV / Excel / Meta)
$router->get('/admin/import', [AdminController::class, 'showImport'], 'admin.import');
$router->get('/admin/import/modele', [AdminController::class, 'downloadImportTemplate'], 'admin.import.template');
$router->post('/admin/import/csv', [AdminController::class, 'processCsvImport'], 'admin.import.csv');

// 8.1 Synchronisation Meta OAuth
$router->get('/admin/import/meta/connect', [AdminController::class, 'metaConnect'], 'admin.import.meta.connect');
$router->get('/admin/import/meta/callback', [AdminController::class, 'metaCallback'], 'admin.import.meta.callback');
$router->get('/admin/import/meta/preview', [AdminController::class, 'metaPreview'], 'admin.import.meta.preview');
$router->post('/admin/import/meta/sync', [AdminController::class, 'metaSync'], 'admin.import.meta.sync');
$router->post('/admin/import/meta/disconnect', [AdminController::class, 'metaDisconnect'], 'admin.import.meta.disconnect');

// 9. Menu Paramètres — Configuration Complète (Sections 5.1 à 5.8)
// 5.1 Informations Boutique
$router->get('/admin/parametres/boutique', [SettingsController::class, 'shopInfo'], 'admin.settings.shop');
$router->post('/admin/parametres/boutique', [SettingsController::class, 'saveShopInfo'], 'admin.settings.shop.save');

// 5.3 Livraison et Retrait
$router->get('/admin/parametres/livraison', [SettingsController::class, 'delivery'], 'admin.settings.delivery');
$router->post('/admin/parametres/livraison', [SettingsController::class, 'saveDeliverySettings'], 'admin.settings.delivery.save');
$router->post('/admin/parametres/livraison/zones/ajouter', [SettingsController::class, 'addDeliveryZone'], 'admin.settings.delivery.zone.add');
$router->post('/admin/parametres/livraison/zones/{id}/supprimer', [SettingsController::class, 'deleteDeliveryZone'], 'admin.settings.delivery.zone.delete');

// 5.4 Utilisateurs et Permissions
$router->get('/admin/parametres/utilisateurs', [SettingsController::class, 'users'], 'admin.settings.users');
$router->post('/admin/parametres/utilisateurs/ajouter', [SettingsController::class, 'createUser'], 'admin.settings.users.create');
$router->post('/admin/parametres/utilisateurs/{id}/statut', [SettingsController::class, 'toggleUser'], 'admin.settings.users.toggle');

// 5.5 Notifications
$router->get('/admin/parametres/notifications', [SettingsController::class, 'notifications'], 'admin.settings.notifications');
$router->post('/admin/parametres/notifications', [SettingsController::class, 'saveNotifications'], 'admin.settings.notifications.save');

// 5.6 Applications et Intégrations
$router->get('/admin/parametres/integrations', [SettingsController::class, 'integrations'], 'admin.settings.integrations');
$router->post('/admin/parametres/integrations', [SettingsController::class, 'saveIntegrations'], 'admin.settings.integrations.save');

// 5.7 Sécurité, Sauvegardes & Audit (Module 9)
$router->get('/admin/parametres/securite', [SettingsController::class, 'security'], 'admin.settings.security');
$router->post('/admin/parametres/securite/mot-de-passe', [SettingsController::class, 'updatePassword'], 'admin.settings.security.password');
$router->post('/admin/parametres/securite/sauvegarde/db', [SettingsController::class, 'backupDatabase'], 'admin.settings.security.backup.db');
$router->post('/admin/parametres/securite/sauvegarde/fichiers', [SettingsController::class, 'backupFiles'], 'admin.settings.security.backup.files');
$router->post('/admin/parametres/securite/restauration', [SettingsController::class, 'restoreDatabase'], 'admin.settings.security.restore');

// 5.8 Analytics & Suivi
$router->get('/admin/parametres/analytics', [SettingsController::class, 'analytics'], 'admin.settings.analytics');
$router->post('/admin/parametres/analytics', [SettingsController::class, 'saveAnalytics'], 'admin.settings.analytics.save');
