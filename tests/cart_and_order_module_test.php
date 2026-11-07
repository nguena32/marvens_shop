<?php
declare(strict_types=1);

/**
 * Suite de tests unitaires, fonctionnels et de sécurité dédiée au Module 7 : Panier et Commande
 * Couvre l'intégralité des sections 7.1 (Panier), 7.2 (Formulaire de commande) et 7.3 (Transmission WhatsApp)
 */

require_once __DIR__ . '/../bootstrap/app.php';

use App\Core\Database;
use App\Core\Session;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Application\Services\CartService;
use App\Application\Services\CheckoutService;
use App\Application\Services\SettingsService;
use App\Domain\Entities\Order;

class CartAndOrderModuleTestSuite
{
    private int $passed = 0;
    private int $failed = 0;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        Database::setConnection($this->pdo);
        $this->setupSchema();
    }

    private function setupSchema(): void
    {
        $this->pdo->exec("
            CREATE TABLE shop_settings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                setting_key VARCHAR(100) UNIQUE,
                setting_value TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE delivery_zones (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                city VARCHAR(100) NOT NULL DEFAULT 'Douala',
                district VARCHAR(100) NOT NULL,
                fee INTEGER NOT NULL DEFAULT 1500,
                estimated_time VARCHAR(100) DEFAULT '24h - 48h',
                is_active INTEGER NOT NULL DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                description TEXT,
                image_url VARCHAR(255),
                sort_order INTEGER DEFAULT 0,
                is_active INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER,
                name VARCHAR(255),
                slug VARCHAR(255) UNIQUE,
                sku VARCHAR(100),
                description TEXT,
                price INTEGER,
                promotional_price INTEGER,
                main_image_url VARCHAR(255),
                is_active INTEGER DEFAULT 1,
                is_featured INTEGER DEFAULT 0,
                meta_product_id VARCHAR(100),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE product_variants (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER,
                variant_name VARCHAR(100),
                size VARCHAR(50),
                color VARCHAR(50),
                price_override INTEGER,
                stock_quantity INTEGER DEFAULT 0,
                is_available INTEGER DEFAULT 1,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
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
                delivery_date DATE,
                delivery_cost INTEGER,
                total_amount INTEGER,
                order_status VARCHAR(50),
                payment_status VARCHAR(50),
                payment_mode VARCHAR(50),
                customer_notes TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER,
                product_id INTEGER,
                product_name VARCHAR(255),
                variant_info VARCHAR(100),
                unit_price INTEGER,
                quantity INTEGER,
                subtotal INTEGER,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
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
    }

    private function assert(string $description, bool $condition, string $error = ''): void
    {
        if ($condition) {
            $this->passed++;
            echo " [PASS] {$description}\n";
        } else {
            $this->failed++;
            echo " [FAIL] {$description} : {$error}\n";
        }
    }

    public function runAll(): int
    {
        echo "====================================================================\n";
        echo "   BANC D'AUDIT ET VALIDATION MODULE 7 : PANIER ET COMMANDE (MVP)  \n";
        echo "====================================================================\n\n";

        $productRepo = new ProductRepository($this->pdo);
        $orderRepo = new OrderRepository($this->pdo);
        $cartService = new CartService($productRepo);
        $checkoutService = new CheckoutService($orderRepo, $cartService);
        $settingsService = new SettingsService($this->pdo);

        // Paramétrage boutique
        $settingsService->set('shop_name', 'Marvens Boutique Prestigieuse');
        $settingsService->set('whatsapp_number', '+237 699 00 11 22');

        // Création de 2 produits pour les tests
        $p1Id = $productRepo->create([
            'name' => 'Chemise Slim Fit',
            'slug' => 'chemise-slim-fit',
            'price' => 15000,
            'promotional_price' => 12000,
            'is_active' => 1,
            'main_image_url' => '/uploads/chemise.jpg'
        ]);

        $p2Id = $productRepo->create([
            'name' => 'Pantalon Chino',
            'slug' => 'pantalon-chino',
            'price' => 20000,
            'promotional_price' => null,
            'is_active' => 1,
            'main_image_url' => '/uploads/pantalon.jpg'
        ]);

        $p3Disabled = $productRepo->create([
            'name' => 'Article Épuisé Inactif',
            'slug' => 'article-epuise',
            'price' => 5000,
            'is_active' => 0
        ]);

        // =========================================================================
        // 7.1 PANIER D'ACHATS
        // =========================================================================
        echo "--- 7.1 Tests Panier d'Achats ---\n";
        $cartService->clear();

        // 7.1.1 Ajouter un produit
        $add1 = $cartService->addItem($p1Id, 2, 'Taille M / Bleu');
        $this->assert("7.1.1 Ajouter un produit au panier", $add1 === true);

        // 7.1.2 Choisir les variantes
        $add2 = $cartService->addItem($p1Id, 1, 'Taille L / Blanc');
        $this->assert("7.1.2 Choisir des variantes différentes pour un même produit", $add2 === true);

        $calc = $cartService->getCartCalculation();
        $this->assert("7.1.3 Présence distincte des 2 déclinaisons d'articles", count($calc['items']) === 2);

        // 7.1.4 Afficher les produits, quantités, prix et sous-total
        $items = array_values($calc['items']);
        $this->assert("7.1.4 Affichage correct du nom de produit", $items[0]['name'] === 'Chemise Slim Fit');
        $this->assert("7.1.5 Affichage correct des quantités", $items[0]['quantity'] === 2 && $items[1]['quantity'] === 1);
        $this->assert("7.1.6 Respect du prix promo en base (12 000 FCFA)", $items[0]['unit_price'] === 12000);
        $this->assert("7.1.7 Calcul du sous-total ligne (2 x 12 000 = 24 000 FCFA)", $items[0]['line_total'] === 24000);
        $this->assert("7.1.8 Calcul du total général panier (24 000 + 12 000 = 36 000 FCFA)", $calc['subtotal'] === 36000);

        // 7.1.9 Modifier les quantités
        $itemKey = array_keys($calc['items'])[0];
        $cartService->updateQuantity($itemKey, 3);
        $calcAfterUpdate = $cartService->getCartCalculation();
        $this->assert("7.1.9 Modifier la quantité (passage à 3)", $calcAfterUpdate['items'][$itemKey]['quantity'] === 3);
        $this->assert("7.1.10 Recalcul dynamique du sous-total après modification (3 x 12 000 = 36 000)", $calcAfterUpdate['items'][$itemKey]['line_total'] === 36000);

        // 7.1.11 Retirer un produit
        $cartService->removeItem($itemKey);
        $calcAfterRemove = $cartService->getCartCalculation();
        $this->assert("7.1.11 Retirer un produit du panier", count($calcAfterRemove['items']) === 1 && !isset($calcAfterRemove['items'][$itemKey]));

        // 7.1.12 Vérifier la disponibilité (produit inactif ou dépublié exclu du panier)
        $addDisabled = $cartService->addItem($p3Disabled, 1);
        $this->assert("7.1.12 Refus d'ajouter un produit inactif", $addDisabled === false);

        // Désactivation d'un produit déjà au panier
        $this->pdo->exec("UPDATE products SET is_active = 0 WHERE id = {$p1Id}");
        $calcDispo = $cartService->getCartCalculation();
        $this->assert("7.1.13 Le calcul serveur filtre automatiquement les produits devenus indisponibles", empty($calcDispo['items']));
        $this->pdo->exec("UPDATE products SET is_active = 1 WHERE id = {$p1Id}"); // Réactivation

        // 7.1.14 Conserver le panier pendant la navigation (Session persistante)
        $cartItemsSession = Session::get('cart');
        $this->assert("7.1.14 Panier conservé dans la session de navigation", !empty($cartItemsSession));

        // =========================================================================
        // 7.2 FORMULAIRE DE COMMANDE
        // =========================================================================
        echo "\n--- 7.2 Tests Formulaire de Commande ---\n";

        // Ajout d'articles sains
        $cartService->clear();
        $cartService->addItem($p1Id, 1, 'Taille M');
        $cartService->addItem($p2Id, 1); // 12000 + 20000 = 32000 FCFA

        // Configuration d'une zone de livraison
        $settingsService->addDeliveryZone('Douala', 'Bonapriso', 1000, '24h');

        $orderPayload = [
            'customer_name' => 'Alain Manga',
            'customer_whatsapp' => '+237699112233',
            'delivery_city' => 'Douala',
            'delivery_district' => 'Bonapriso',
            'delivery_address' => 'Rue Tokoto, Porte 4',
            'delivery_mode' => 'delivery',
            'payment_mode' => 'orange_money',
            'customer_notes' => 'Livrer entre 12h et 14h'
        ];

        // Validation des informations obligatoires & Enregistrement
        $result = $checkoutService->processCheckout($orderPayload);
        $orderNumber = $result['order_number'];

        $this->assert("7.2.1 Enregistrement de la commande réussi", $result['order_id'] > 0);
        $this->assert("7.2.2 Génération d'un numéro unique (format CMD-YYYYMMDD-XXXX)", (bool)preg_match('/^CMD-\d{8}-\d{4}$/', $orderNumber));

        // Vérification de la commande persistée en base
        $savedOrder = $orderRepo->findByOrderNumber($orderNumber);
        $this->assert("7.2.3 Persistance exacte du nom client", $savedOrder['customer_name'] === 'Alain Manga');
        $this->assert("7.2.4 Persistance exacte du numéro WhatsApp", $savedOrder['customer_whatsapp'] === '+237699112233');
        $this->assert("7.2.5 Persistance de la ville", $savedOrder['delivery_city'] === 'Douala');
        $this->assert("7.2.6 Persistance du quartier", $savedOrder['delivery_district'] === 'Bonapriso');
        $this->assert("7.2.7 Persistance de l'adresse précise", $savedOrder['delivery_address'] === 'Rue Tokoto, Porte 4');
        $this->assert("7.2.8 Persistance du mode de livraison", $savedOrder['delivery_mode'] === 'delivery');
        $this->assert("7.2.9 Persistance du mode de paiement", $savedOrder['payment_mode'] === 'orange_money');
        $this->assert("7.2.10 Persistance des instructions particulières", $savedOrder['customer_notes'] === 'Livrer entre 12h et 14h');

        // Vérification des lignes d'articles et quantités enregistrées
        $orderItems = $savedOrder['items'];
        $this->assert("7.2.11 Vérification de l'enregistrement des 2 articles", count($orderItems) === 2);
        $this->assert("7.2.12 Calcul automatique des frais de zone (1 000 FCFA pour Bonapriso)", (int)$savedOrder['delivery_cost'] === 1000);
        $this->assert("7.2.13 Total général certifié serveur (32 000 + 1 000 = 33 000 FCFA)", (int)$savedOrder['total_amount'] === 33000);
        $this->assert("7.2.14 Statut initial 'pending' (en attente)", $savedOrder['order_status'] === 'pending');
        $this->assert("7.2.15 Vidage automatique du panier après finalisation", empty($cartService->getCartItems()));

        // =========================================================================
        // 7.3 TRANSMISSION WHATSAPP
        // =========================================================================
        echo "\n--- 7.3 Tests Transmission WhatsApp ---\n";

        $waLink = $result['whatsapp_url'];
        $this->assert("7.3.1 Préparation du lien WhatsApp avec wa.me", str_contains($waLink, 'https://wa.me/237699001122'));

        $decodedMessage = urldecode(parse_url($waLink, PHP_URL_QUERY));
        $this->assert("7.3.2 Message inclut le numéro unique de commande", str_contains($decodedMessage, $orderNumber));
        $this->assert("7.3.3 Message inclut le nom du client", str_contains($decodedMessage, 'Alain Manga'));
        $this->assert("7.3.4 Message inclut le numéro WhatsApp du client", str_contains($decodedMessage, '+237699112233'));
        $this->assert("7.3.5 Message inclut les produits et déclinaisons", str_contains($decodedMessage, 'Chemise Slim Fit (Taille M)'));
        $this->assert("7.3.6 Message inclut les quantités et montants par ligne", str_contains($decodedMessage, '1x Pantalon Chino : 20 000 FCFA'));
        $this->assert("7.3.7 Message inclut le montant total à payer", str_contains($decodedMessage, '33 000 FCFA'));
        $this->assert("7.3.8 Message inclut la ville et quartier de livraison", str_contains($decodedMessage, 'Bonapriso, Douala'));
        $this->assert("7.3.9 Message inclut l'adresse ou repère", str_contains($decodedMessage, 'Rue Tokoto, Porte 4'));
        $this->assert("7.3.10 Message inclut le mode de règlement", str_contains($decodedMessage, 'Orange Money'));
        $this->assert("7.3.11 Message inclut les instructions particulières", str_contains($decodedMessage, 'Livrer entre 12h et 14h'));
        $this->assert("7.3.12 Règle MS-BIZ-04 : La commande est en base avant transmission WhatsApp", $orderRepo->findByOrderNumber($orderNumber) !== null);

        echo "\n====================================================================\n";
        echo "BILAN AUDIT MODULE 7 : {$this->passed} Succès, {$this->failed} Échecs\n";
        echo "====================================================================\n";

        return $this->failed === 0 ? 0 : 1;
    }
}

$suite = new CartAndOrderModuleTestSuite();
exit($suite->runAll());
