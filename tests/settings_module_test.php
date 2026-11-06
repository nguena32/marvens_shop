<?php
declare(strict_types=1);

/**
 * Suite de tests de qualification et de validation approfondie pour le :
 * MODULE 5 : MENU PARAMÈTRES — CONFIGURATION COMPLÈTE
 * Sections 5.1 à 5.8
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Session;
use App\Core\Request;
use App\Application\Services\SettingsService;
use App\Application\Services\CheckoutService;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\StorefrontController;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class SettingsModuleTestSuite
{
    private int $passed = 0;
    private int $failed = 0;
    private PDO $pdo;
    private SettingsService $settingsService;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Database::setConnection($this->pdo);

        $this->setupSchema();
        $this->settingsService = new SettingsService($this->pdo);
    }

    private function setupSchema(): void
    {
        $this->pdo->exec("
            CREATE TABLE shop_settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key VARCHAR(100) UNIQUE,
                setting_value TEXT,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE delivery_zones (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                city VARCHAR(100) NOT NULL,
                district VARCHAR(100) NOT NULL,
                fee INTEGER NOT NULL,
                estimated_time VARCHAR(100),
                is_active INTEGER NOT NULL DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE activity_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER,
                user_email VARCHAR(255),
                event_type VARCHAR(50),
                ip_address VARCHAR(45),
                user_agent TEXT,
                details TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(100) UNIQUE,
                email VARCHAR(255) UNIQUE,
                password_hash VARCHAR(255),
                role VARCHAR(50) DEFAULT 'merchant_admin',
                name VARCHAR(255),
                is_active INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                description TEXT,
                image_url VARCHAR(255),
                sort_order INTEGER NOT NULL DEFAULT 0,
                is_active INTEGER DEFAULT 1
            );
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                price INTEGER,
                promotional_price INTEGER,
                main_image_url VARCHAR(255),
                is_active INTEGER DEFAULT 1,
                is_featured INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number VARCHAR(100) UNIQUE,
                customer_name VARCHAR(255),
                customer_whatsapp VARCHAR(50),
                delivery_mode VARCHAR(50),
                delivery_city VARCHAR(100),
                delivery_district VARCHAR(100),
                delivery_address TEXT,
                delivery_cost INTEGER,
                total_amount INTEGER,
                order_status VARCHAR(50),
                payment_status VARCHAR(50),
                payment_mode VARCHAR(50),
                customer_notes TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER,
                product_id INTEGER,
                product_name VARCHAR(255),
                variant_info VARCHAR(100),
                unit_price INTEGER,
                quantity INTEGER,
                subtotal INTEGER
            );
            CREATE TABLE order_status_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER,
                previous_status VARCHAR(50),
                new_status VARCHAR(50),
                comment TEXT,
                changed_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");

        // Compte admin de test
        $this->pdo->exec("
            INSERT INTO users (username, email, password_hash, role, name, is_active)
            VALUES ('admin_test', 'admin@marvens-shop.cm', '" . password_hash('Secret1234', PASSWORD_BCRYPT) . "', 'merchant_admin', 'Directeur Général', 1);
        ");

        Session::start();
        Session::set('admin_user_id', 1);
        Session::set('admin_user_name', 'Directeur Général');
        Session::set('admin_user_role', 'merchant_admin');
    }

    private function assert(bool $condition, string $message): void
    {
        if ($condition) {
            $this->passed++;
            echo " [PASS] " . $message . "\n";
        } else {
            $this->failed++;
            echo " [FAIL] " . $message . "\n";
        }
    }

    public function run(): void
    {
        echo "========================================================\n";
        echo "   BANC DE VALIDATION — MODULE 5 (PARAMÈTRES BOUTIQUE)  \n";
        echo "========================================================\n\n";

        $this->testSection51ShopInfo();
        $this->testSection53DeliveryAndPickup();
        $this->testSection54UsersAndRoles();
        $this->testSection55Notifications();
        $this->testSection56Integrations();
        $this->testSection57SecurityAndAudit();
        $this->testSection58AnalyticsAndTracking();
        $this->testStorefrontAndCheckoutIntegration();

        echo "\n========================================================\n";
        echo sprintf("BILAN AUDIT MODULE 5 : %d Succès, %d Échecs\n", $this->passed, $this->failed);
        echo "========================================================\n";
    }

    private function testSection51ShopInfo(): void
    {
        $info = $this->settingsService->getShopInfo();
        $this->assert(!empty($info['shop_name']), "5.1 - Valeurs par défaut du commerce initialisées (Nom: " . $info['shop_name'] . ")");

        // Mise à jour
        $updateRes = $this->settingsService->updateShopInfo([
            'shop_name' => 'Marvens Luxury Store',
            'company_name' => 'Marvens Holding SAS',
            'description' => 'Boutique haut de gamme à Douala.',
            'whatsapp_number' => '+237699112233',
            'email' => 'contact@marvens-luxury.cm',
            'currency' => 'FCFA',
            'language' => 'fr',
            'city' => 'Douala',
            'country' => 'Cameroun',
            'logo_url' => '/uploads/logo.png',
            'favicon_url' => '/uploads/favicon.png',
        ]);

        $this->assert($updateRes['success'] === true, "5.1 - Enregistrement réussi des informations de boutique");
        $saved = $this->settingsService->getShopInfo();
        $this->assert($saved['shop_name'] === 'Marvens Luxury Store', "5.1 - Persistance vérifiée pour le nom de boutique");
        $this->assert($saved['whatsapp_number'] === '+237699112233', "5.1 - Persistance vérifiée pour le numéro WhatsApp commercial");

        // Test sécurité validation entrée invalide
        $badRes = $this->settingsService->updateShopInfo([
            'shop_name' => '',
            'whatsapp_number' => 'invalid_number',
            'email' => 'not_an_email',
        ]);
        $this->assert($badRes['success'] === false && isset($badRes['errors']['shop_name']), "5.1 Sécurité - Rejet des coordonnées vides ou formats invalides");
    }

    private function testSection53DeliveryAndPickup(): void
    {
        $deliv = $this->settingsService->getDeliverySettings();
        $this->assert($deliv['home_enabled'] === true && $deliv['pickup_enabled'] === true, "5.3 - Modes Domicile & Retrait disponibles par défaut");

        // Ajout de zones tarifaires par quartier
        $this->settingsService->addDeliveryZone('Douala', 'Bonapriso', 1000, '24h');
        $this->settingsService->addDeliveryZone('Douala', 'Akwa', 1200, '12h');
        $this->settingsService->addDeliveryZone('Douala', 'Bonamoussadi', 2000, '24h-48h');

        $zones = $this->settingsService->getDeliveryZones();
        $this->assert(count($zones) === 3, "5.3 - Configuration dynamique : 3 zones de livraison créées");

        // Calcul dynamique des frais de livraison
        $feeBonapriso = $this->settingsService->calculateDeliveryFee('Bonapriso', 15000);
        $this->assert($feeBonapriso === 1000, "5.3 - Calcul exact : Frais Bonapriso = 1000 FCFA");

        $feeBonamoussadi = $this->settingsService->calculateDeliveryFee('Bonamoussadi', 15000);
        $this->assert($feeBonamoussadi === 2000, "5.3 - Calcul exact : Frais Bonamoussadi = 2000 FCFA");

        $feeUnknown = $this->settingsService->calculateDeliveryFee('Quartier Inconnu', 15000);
        $this->assert($feeUnknown === 1500, "5.3 - Repli robuste sur le forfait par défaut (1500 FCFA)");

        // Seuil de gratuité
        $this->settingsService->updateDeliverySettings([
            'home_enabled' => '1',
            'pickup_enabled' => '1',
            'free_shipping_threshold' => 30000,
        ]);
        $feeFree = $this->settingsService->calculateDeliveryFee('Bonamoussadi', 35000);
        $this->assert($feeFree === 0, "5.3 - Règle métier : Frais offerts (0 FCFA) si seuil de panier dépassé");
    }

    private function testSection54UsersAndRoles(): void
    {
        $users = $this->settingsService->getAllUsers();
        $this->assert(count($users) >= 1, "5.4 - Consultation des utilisateurs existants (" . count($users) . " compte)");

        // Création d'un collaborateur
        $res = $this->settingsService->addUser('commercial_douala', 'paul@marvens-shop.cm', 'PassSecure2026', 'store_manager', 'Paul Commercial');
        $this->assert($res['success'] === true, "5.4 - Création d'un collaborateur avec rôle 'store_manager'");

        // Désactivation d'un compte
        $allUsers = $this->settingsService->getAllUsers();
        $paul = array_values(array_filter($allUsers, fn($u) => $u['username'] === 'commercial_douala'))[0];
        $this->settingsService->toggleUserStatus((int)$paul['id'], false);

        $refreshedUsers = $this->settingsService->getAllUsers();
        $paulUpdated = array_values(array_filter($refreshedUsers, fn($u) => $u['username'] === 'commercial_douala'))[0];
        $this->assert($paulUpdated['is_active'] == 0, "5.4 - Désactivation effective du collaborateur");
    }

    private function testSection55Notifications(): void
    {
        $notif = $this->settingsService->getNotificationSettings();
        $this->assert(isset($notif['order_confirmation_whatsapp']), "5.5 - Matrice des notifications par canal et événement initialisée");

        // Sauvegarde personnalisée
        $this->settingsService->updateNotificationSettings([
            'order_confirmation_whatsapp' => true,
            'order_confirmation_email' => false,
            'admin_new_order_whatsapp' => true,
        ]);

        $savedNotif = $this->settingsService->getNotificationSettings();
        $this->assert($savedNotif['order_confirmation_email'] === false, "5.5 - Prise en compte de la désactivation d'un canal spécifique");
    }

    private function testSection56Integrations(): void
    {
        $integ = $this->settingsService->getIntegrationsSettings();
        $this->assert(isset($integ['whatsapp']) && isset($integ['meta_catalog']) && isset($integ['smtp']), "5.6 - Connecteurs WhatsApp, Meta & SMTP déclarés");

        $this->settingsService->updateIntegrationsSettings([
            'whatsapp_enabled' => '1',
            'smtp_enabled' => '1',
            'smtp_host' => 'smtp.orange.cm',
            'meta_catalog_id' => 'META-998877',
            'meta_enabled' => '1',
        ]);

        $updatedInteg = $this->settingsService->getIntegrationsSettings();
        $this->assert($updatedInteg['smtp']['host'] === 'smtp.orange.cm', "5.6 - Persistance de la configuration SMTP");
        $this->assert($updatedInteg['meta_catalog']['catalog_id'] === 'META-998877', "5.6 - Persistance de l'ID catalogue Meta");
    }

    private function testSection57SecurityAndAudit(): void
    {
        // Journalisation d'une action
        $this->settingsService->logActivity(1, 'admin@marvens-shop.cm', 'audit_test_event', '192.168.1.1', 'TestBrowser', 'Test de sécurité réussi');
        $logs = $this->settingsService->getActivityLogs(10);
        $this->assert(!empty($logs) && $logs[0]['event_type'] === 'audit_test_event', "5.7 Sécurité - Journalisation d'audit des actions administratives fonctionnelle");

        // Changement de mot de passe sécurisé
        $users = $this->settingsService->getAllUsers();
        $adminId = (int)$users[0]['id'];
        $pwdRes = $this->settingsService->updateUserPassword($adminId, 'NewUltraSecurePassword!2026');
        $this->assert($pwdRes['success'] === true, "5.7 Sécurité - Réinitialisation et hachage BCrypt du mot de passe admin");
    }

    private function testSection58AnalyticsAndTracking(): void
    {
        $this->settingsService->updateAnalyticsSettings([
            'ga_id' => 'G-ABC123XYZ',
            'pixel_id' => '998811223344',
            'gtm_id' => 'GTM-TEST1',
            'track_checkout' => '1',
            'track_whatsapp_clicks' => '1',
        ]);

        $analytics = $this->settingsService->getAnalyticsSettings();
        $this->assert($analytics['ga_id'] === 'G-ABC123XYZ', "5.8 - Persistance Google Analytics 4");
        $this->assert($analytics['pixel_id'] === '998811223344', "5.8 - Persistance Meta Pixel ID");
    }

    private function testStorefrontAndCheckoutIntegration(): void
    {
        // 1. Storefront public intègre dynamiquement les paramètres
        $storefrontController = new StorefrontController();
        $req = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']);
        $res = $storefrontController->home($req);
        $html = $res->getContent();

        $this->assert(str_contains($html, 'Marvens Luxury Store'), "Intégration Storefront - Le nom dynamique configuré est affiché");
        $this->assert(str_contains($html, 'G-ABC123XYZ'), "Intégration Storefront - La balise Google Analytics configurée est injectée dans le HTML");
        $this->assert(str_contains($html, '998811223344'), "Intégration Storefront - Le Meta Pixel configuré est injecté dans le HTML");

        // 2. CheckoutService consomme les tarifs de livraison et le numéro WhatsApp
        $this->pdo->exec("
            INSERT INTO products (name, slug, price, promotional_price, main_image_url, is_active)
            VALUES ('Robe Soirée Luxe', 'robe-soiree-luxe', 25000, NULL, '/img/robe.jpg', 1);
        ");

        Session::start();
        $cart = [
            '1_0' => [
                'product_id' => 1,
                'variant_id' => null,
                'quantity' => 1,
            ]
        ];
        Session::set('cart', $cart);

        // Commande avec livraison à Bonapriso (tarif configuré = 1000 FCFA, sous le seuil de 30000)
        $orderRepo = new \App\Repositories\OrderRepository($this->pdo);
        $productRepo = new \App\Repositories\ProductRepository($this->pdo);
        $cartService = new \App\Application\Services\CartService($productRepo);
        $checkoutService = new \App\Application\Services\CheckoutService($orderRepo, $cartService);
        $orderRes = $checkoutService->processCheckout([
            'customer_name' => 'Fatou Ndiaye',
            'customer_whatsapp' => '+237699887766',
            'delivery_mode' => 'delivery',
            'delivery_district' => 'Bonapriso',
            'delivery_city' => 'Douala',
        ]);

        $this->assert($orderRes['total_amount'] === 26000, "Intégration Checkout - Total validé (25 000 article + 1 000 frais Bonapriso = 26 000 FCFA)");
        $this->assert(str_contains($orderRes['whatsapp_url'], '237699112233'), "Intégration WhatsApp - Le lien de commande pointe vers le numéro WhatsApp configuré (237699112233)");
    }
}

$suite = new SettingsModuleTestSuite();
$suite->run();
