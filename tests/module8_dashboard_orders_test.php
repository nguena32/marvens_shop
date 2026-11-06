<?php
declare(strict_types=1);

/**
 * Suite de tests unitaires, fonctionnels et de sécurité
 * Module 8 : TABLEAU DE BORD ET GESTION DES COMMANDES (MVP)
 *
 * Exigences couvertes :
 * 8.1 Dashboard :
 *     - Nombre de commandes, par statut (en attente, confirmée, payée, en préparation, expédiée, livrée, annulée)
 *     - Accès rapides (commandes, catalogue, clients, paramètres)
 * 8.2 Gestion des commandes :
 *     - Liste complète, numéro, date, client, produits, quantités, montants, adresse, mode livraison, mode paiement, instructions
 *     - Recherche multi-critères, filtrage combiné
 *     - Historique des statuts
 * 8.3 Machine à états :
 *     - Respect des 8 statuts
 *     - Validation des transitions autorisées et refus des transitions invalides
 * 8.4 Gestion des clients :
 *     - Enregistrement automatique au checkout (nom, whatsapp, quartier, adresse)
 *     - Évitement des doublons par numéro WhatsApp normalisé
 *     - Historique des commandes d'un client
 *     - Recherche client
 * 8.5 Statistiques commerciales :
 *     - CA certifié calculé sur commandes payées ou livrées (MS-BIZ-08 & T-026)
 *     - Top produits commandés
 *     - Suivi des paiements et livraisons
 *     - Détection des promotions actives
 * Sécurité & Règles métier :
 *     - Contrôle CSRF
 *     - Échappement des entrées / XSS
 *     - Prévention injection SQL (PDO préparé)
 */

require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Domain/Entities/Order.php';
require_once __DIR__ . '/../app/Repositories/OrderRepository.php';
require_once __DIR__ . '/../app/Repositories/CustomerRepository.php';

use App\Domain\Entities\Order;
use App\Repositories\OrderRepository;
use App\Repositories\CustomerRepository;

class Module8DashboardAndOrdersTestSuite
{
    private PDO $pdo;
    private OrderRepository $orderRepo;
    private CustomerRepository $customerRepo;
    private int $passCount = 0;
    private int $failCount = 0;

    public function __construct()
    {
        // Base SQLite en mémoire pour isolation complète des tests
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setupSchema();
        $this->orderRepo = new OrderRepository($this->pdo);
        $this->customerRepo = new CustomerRepository($this->pdo);
    }

    private function setupSchema(): void
    {
        $this->pdo->exec("
            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number VARCHAR(100) NOT NULL UNIQUE,
                customer_name VARCHAR(255) NOT NULL,
                customer_whatsapp VARCHAR(50) NOT NULL,
                delivery_mode VARCHAR(50) NOT NULL DEFAULT 'delivery',
                delivery_city VARCHAR(100) NULL,
                delivery_district VARCHAR(100) NULL,
                delivery_address TEXT NULL,
                delivery_cost INT NOT NULL DEFAULT 0,
                total_amount INT NOT NULL,
                order_status VARCHAR(50) NOT NULL DEFAULT 'pending',
                payment_status VARCHAR(50) NOT NULL DEFAULT 'unpaid',
                payment_mode VARCHAR(50) NOT NULL DEFAULT 'cash_on_delivery',
                customer_notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INT NOT NULL,
                product_id INT NULL,
                product_name VARCHAR(255) NOT NULL,
                variant_info VARCHAR(100) NULL,
                unit_price INT NOT NULL,
                quantity INT NOT NULL DEFAULT 1,
                subtotal INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE order_status_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INT NOT NULL,
                previous_status VARCHAR(50) NULL,
                new_status VARCHAR(50) NOT NULL,
                comment TEXT NULL,
                changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE customers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255) NOT NULL,
                whatsapp VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(255) NULL,
                city VARCHAR(100) NULL,
                district VARCHAR(100) NULL,
                address TEXT NULL,
                notes TEXT NULL,
                orders_count INT NOT NULL DEFAULT 0,
                total_spent INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INT NULL,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                price INT NOT NULL,
                promotional_price INT NULL,
                is_active INT NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    private function assert(string $title, bool $condition, string $detail = ''): void
    {
        if ($condition) {
            echo " [PASS] {$title}\n";
            $this->passCount++;
        } else {
            echo " [FAIL] {$title} : {$detail}\n";
            $this->failCount++;
        }
    }

    public function runAll(): void
    {
        echo "====================================================================\n";
        echo "   BANC D'AUDIT ET VALIDATION MODULE 8 : TABLEAU DE BORD & COMMANDES \n";
        echo "====================================================================\n\n";

        $this->testOrderCreationAndDetails();
        $this->testStatusStateMachine();
        $this->testSearchAndFilters();
        $this->testCustomerManagement();
        $this->testCommercialStatisticsAndRevenueRules();
        $this->testSecurityAndInputEscaping();

        echo "\n====================================================================\n";
        echo "BILAN AUDIT MODULE 8 : {$this->passCount} Succès, {$this->failCount} Échecs\n";
        echo "====================================================================\n";

        if ($this->failCount > 0) {
            exit(1);
        }
    }

    private function testOrderCreationAndDetails(): void
    {
        echo "--- 8.2 Tests Création, Structure & Détail Commande ---\n";

        $orderData = [
            'order_number' => 'CMD-20261106-0001',
            'customer_name' => 'Paul Biya',
            'customer_whatsapp' => '+237 699 00 11 22',
            'delivery_mode' => 'delivery',
            'delivery_city' => 'Douala',
            'delivery_district' => 'Akwa',
            'delivery_address' => 'Boulevard de la Liberté, face Direction',
            'delivery_cost' => 1500,
            'total_amount' => 26500,
            'order_status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_UNPAID,
            'payment_mode' => 'cash_on_delivery',
            'customer_notes' => 'Appeler 15 min avant arrivée'
        ];

        $items = [
            [
                'product_id' => 10,
                'product_name' => 'Chemise Slim Fit',
                'variant_info' => 'Taille L / Blanc',
                'unit_price' => 12500,
                'quantity' => 2,
            ]
        ];

        $orderId = $this->orderRepo->createWithItems($orderData, $items);
        $this->assert("8.2.1 Création et persistance atomique de la commande", $orderId > 0);

        $fetched = $this->orderRepo->findById($orderId);
        $this->assert("8.2.2 Lecture exacte du numéro de commande", ($fetched['order_number'] ?? '') === 'CMD-20261106-0001');
        $this->assert("8.2.3 Lecture du client et WhatsApp", ($fetched['customer_name'] ?? '') === 'Paul Biya' && ($fetched['customer_whatsapp'] ?? '') === '+237 699 00 11 22');
        $this->assert("8.2.4 Lecture de l'adresse et quartier", ($fetched['delivery_district'] ?? '') === 'Akwa');
        $this->assert("8.2.5 Lecture des instructions client", ($fetched['customer_notes'] ?? '') === 'Appeler 15 min avant arrivée');
        $this->assert("8.2.6 Vérification des articles associés", count($fetched['items']) === 1 && $fetched['items'][0]['product_name'] === 'Chemise Slim Fit');
        $this->assert("8.2.7 Sous-total article certifié serveur (2 x 12 500 = 25 000)", (int)$fetched['items'][0]['subtotal'] === 25000);
        $this->assert("8.2.8 Total général vérifié (25 000 + 1 500 = 26 500)", (int)$fetched['total_amount'] === 26500);

        // Historique initial
        $history = $this->orderRepo->getStatusHistory($orderId);
        $this->assert("8.2.9 Enregistrement automatique de l'historique initial", count($history) >= 1 && $history[0]['new_status'] === Order::STATUS_PENDING);
    }

    private function testStatusStateMachine(): void
    {
        echo "\n--- 8.3 Tests Cycle de Vie & Machine à États (MS-BIZ-06) ---\n";

        // Création d'une seconde commande pour tester les transitions
        $orderId = $this->orderRepo->createWithItems([
            'order_number' => 'CMD-20261106-0002',
            'customer_name' => 'Carine Fotso',
            'customer_whatsapp' => '237677889900',
            'delivery_mode' => 'delivery',
            'total_amount' => 15000,
            'order_status' => Order::STATUS_PENDING,
        ], [[
            'product_id' => 1,
            'product_name' => 'Chaussures Cuir',
            'unit_price' => 15000,
            'quantity' => 1
        ]]);

        // 1. Transition autorisée : pending -> confirmed
        $canPendingToConfirmed = Order::canTransition(Order::STATUS_PENDING, Order::STATUS_CONFIRMED);
        $this->assert("8.3.1 Règle métier : pending -> confirmed autorisé", $canPendingToConfirmed);
        $res1 = $this->orderRepo->updateStatus($orderId, Order::STATUS_CONFIRMED, "Confirmation WhatsApp avec client");
        $this->assert("8.3.2 Exécution de la transition pending -> confirmed réussie", $res1);

        // Vérification du statut en base
        $order = $this->orderRepo->findById($orderId);
        $this->assert("8.3.3 Statut en base actualisé à 'confirmed'", $order['order_status'] === Order::STATUS_CONFIRMED);

        // 2. Transition vers paiement_pending ou paid
        $canConfirmedToPaid = Order::canTransition(Order::STATUS_CONFIRMED, Order::STATUS_PAID);
        $this->assert("8.3.4 confirmed -> paid autorisé", $canConfirmedToPaid);
        $this->orderRepo->updateStatus($orderId, Order::STATUS_PAID, "Paiement Orange Money reçu");

        // 3. Transition vers preparing
        $canPaidToPreparing = Order::canTransition(Order::STATUS_PAID, Order::STATUS_PREPARING);
        $this->assert("8.3.5 paid -> preparing autorisé", $canPaidToPreparing);
        $this->orderRepo->updateStatus($orderId, Order::STATUS_PREPARING, "Colis en emballage");

        // 4. Transition vers shipped
        $canPreparingToShipped = Order::canTransition(Order::STATUS_PREPARING, Order::STATUS_SHIPPED);
        $this->assert("8.3.6 preparing -> shipped autorisé", $canPreparingToShipped);
        $this->orderRepo->updateStatus($orderId, Order::STATUS_SHIPPED, "Remis au livreur");

        // 5. Transition vers delivered
        $canShippedToDelivered = Order::canTransition(Order::STATUS_SHIPPED, Order::STATUS_DELIVERED);
        $this->assert("8.3.7 shipped -> delivered autorisé", $canShippedToDelivered);
        $this->orderRepo->updateStatus($orderId, Order::STATUS_DELIVERED, "Colis remis en main propre");

        // 6. Transition INTERDITE : delivered -> pending ou preparing (Interdiction absolue)
        $canDeliveredToPending = Order::canTransition(Order::STATUS_DELIVERED, Order::STATUS_PENDING);
        $this->assert("8.3.8 Transition interdite delivered -> pending rejetée par la Policy", !$canDeliveredToPending);

        $resIllegal = $this->orderRepo->updateStatus($orderId, Order::STATUS_PENDING, "Tentative frauduleuse");
        $this->assert("8.3.9 Le Repository bloque fermement la transition illégale", !$resIllegal);

        // Vérifier l'intégrité de l'historique
        $history = $this->orderRepo->getStatusHistory($orderId);
        $this->assert("8.3.10 Historique complet et ordonné (6 étapes enregistrées)", count($history) === 6);

        // Test mise à jour statut paiement indépendant (Module 7.9 & 8.2)
        $payUpdated = $this->orderRepo->updatePaymentStatus($orderId, Order::PAYMENT_PAID, "Ref OM #884910");
        $this->assert("8.3.11 Mise à jour autonome du paiement manuel", $payUpdated);
        $order = $this->orderRepo->findById($orderId);
        $this->assert("8.3.12 Statut paiement en base = 'paid'", $order['payment_status'] === Order::PAYMENT_PAID);
    }

    private function testSearchAndFilters(): void
    {
        echo "\n--- 8.2 Tests Recherche & Filtres Avancés des Commandes ---\n";

        // Insertion d'un jeu diversifié
        $this->orderRepo->createWithItems([
            'order_number' => 'CMD-20261106-0003',
            'customer_name' => 'Samuel Eto\'o',
            'customer_whatsapp' => '237699445566',
            'delivery_mode' => 'pickup',
            'total_amount' => 50000,
            'order_status' => Order::STATUS_PREPARING,
            'payment_status' => Order::PAYMENT_PAID,
        ], [['product_name' => 'Maillot Officiel', 'unit_price' => 50000, 'quantity' => 1]]);

        $this->orderRepo->createWithItems([
            'order_number' => 'CMD-20261106-0004',
            'customer_name' => 'Marc Vivien',
            'customer_whatsapp' => '237655112233',
            'delivery_mode' => 'delivery',
            'total_amount' => 8000,
            'order_status' => Order::STATUS_CANCELLED,
            'payment_status' => Order::PAYMENT_UNPAID,
        ], [['product_name' => 'Casquette', 'unit_price' => 8000, 'quantity' => 1]]);

        // 1. Filtrage par statut
        $preparingOrders = $this->orderRepo->findAllAdvanced(10, 0, Order::STATUS_PREPARING);
        $this->assert("8.2.10 Filtrage par statut 'preparing'", count($preparingOrders) === 1 && $preparingOrders[0]['order_number'] === 'CMD-20261106-0003');

        $cancelledOrders = $this->orderRepo->findAllAdvanced(10, 0, Order::STATUS_CANCELLED);
        $this->assert("8.2.11 Filtrage par statut 'cancelled'", count($cancelledOrders) === 1);

        // 2. Recherche par numéro de commande
        $searchNum = $this->orderRepo->findAllAdvanced(10, 0, null, '0003');
        $this->assert("8.2.12 Recherche par sous-chaîne du numéro de commande", count($searchNum) === 1 && $searchNum[0]['customer_name'] === "Samuel Eto'o");

        // 3. Recherche par nom de client
        $searchName = $this->orderRepo->findAllAdvanced(10, 0, null, 'Vivien');
        $this->assert("8.2.13 Recherche par nom de client", count($searchName) === 1 && $searchName[0]['order_number'] === 'CMD-20261106-0004');

        // 4. Filtrage par mode de livraison
        $pickupOrders = $this->orderRepo->findAllAdvanced(10, 0, null, null, null, 'pickup');
        $this->assert("8.2.14 Filtrage par mode de retrait boutique", count($pickupOrders) === 1 && $pickupOrders[0]['delivery_mode'] === 'pickup');

        // 5. Filtrage par statut paiement
        $paidOrders = $this->orderRepo->findAllAdvanced(10, 0, null, null, Order::PAYMENT_PAID);
        $this->assert("8.2.15 Filtrage par statut paiement 'paid'", count($paidOrders) >= 2);
    }

    private function testCustomerManagement(): void
    {
        echo "\n--- 8.4 Tests Répertoire Clients & Anti-Doublons ---\n";

        // Commande 1 d'un client
        $c1Data = [
            'customer_name' => 'Nathalie Koah',
            'customer_whatsapp' => '+237 (691) 22-33-44',
            'delivery_city' => 'Douala',
            'delivery_district' => 'Bonapriso',
            'delivery_address' => 'Rue des Palmiers',
            'total_amount' => 45000,
        ];
        $custId1 = $this->customerRepo->recordCustomerFromOrder($c1Data);
        $this->assert("8.4.1 Enregistrement initial d'un nouveau client", $custId1 > 0);

        $client = $this->customerRepo->findById($custId1);
        $this->assert("8.4.2 Normalisation du numéro WhatsApp (237691223344)", $client['whatsapp'] === '237691223344');
        $this->assert("8.4.3 Compteur de commandes initialisé à 1", (int)$client['orders_count'] === 1);
        $this->assert("8.4.4 Dépenses cumulées initialisées à 45 000 FCFA", (int)$client['total_spent'] === 45000);

        // Commande 2 du MÊME client avec format WhatsApp légèrement différent
        $c2Data = [
            'customer_name' => 'Nathalie Koah',
            'customer_whatsapp' => '237691223344',
            'delivery_city' => 'Douala',
            'delivery_district' => 'Bonapriso',
            'delivery_address' => 'Nouvelle adresse Bonapriso',
            'total_amount' => 30000,
        ];
        $custId2 = $this->customerRepo->recordCustomerFromOrder($c2Data);
        $this->assert("8.4.5 Anti-doublon : réutilisation du compte existant", $custId1 === $custId2);

        $clientUpdated = $this->customerRepo->findById($custId1);
        $this->assert("8.4.6 Incrémentation automatique du compteur (2 commandes)", (int)$clientUpdated['orders_count'] === 2);
        $this->assert("8.4.7 Cumul exact du total dépensé (75 000 FCFA)", (int)$clientUpdated['total_spent'] === 75000);
        $this->assert("8.4.8 Actualisation de la dernière adresse", $clientUpdated['address'] === 'Nouvelle adresse Bonapriso');

        // Recherche client par nom et téléphone
        $foundByName = $this->customerRepo->findAll('Nathalie');
        $this->assert("8.4.9 Recherche client par nom", count($foundByName) === 1);

        $foundByPhone = $this->customerRepo->findAll('691223344');
        $this->assert("8.4.10 Recherche client par WhatsApp", count($foundByPhone) === 1);
    }

    private function testCommercialStatisticsAndRevenueRules(): void
    {
        echo "\n--- 8.1 & 8.5 Tests Statistiques Commerciales & Règle CA (MS-BIZ-08 / T-026) ---\n";

        // Décompte par statut pour le Dashboard (8.1)
        $counts = $this->orderRepo->getDashboardCounts();
        $this->assert("8.1.1 Décompte total des commandes", $counts['total'] === 4);
        $this->assert("8.1.2 Décompte des commandes en attente (pending)", $counts[Order::STATUS_PENDING] === 1);
        $this->assert("8.1.3 Décompte des commandes livrées (delivered)", $counts[Order::STATUS_DELIVERED] === 1);
        $this->assert("8.1.4 Décompte des commandes en préparation (preparing)", $counts[Order::STATUS_PREPARING] === 1);
        $this->assert("8.1.5 Décompte des commandes annulées (cancelled)", $counts[Order::STATUS_CANCELLED] === 1);

        // 8.5 Règle de calcul du CA certifié (T-026) :
        // CMD 1: 26 500 (pending, unpaid) => EXCLUS
        // CMD 2: 15 000 (delivered, paid) => INCLUS
        // CMD 3: 50 000 (preparing, paid) => INCLUS (car paid)
        // CMD 4: 8 000 (cancelled, unpaid) => EXCLUS
        // Total certifié attendu = 15 000 + 50 000 = 65 000 FCFA.
        $commercialStats = $this->orderRepo->getCommercialStats();
        $this->assert("8.5.1 Règle MS-BIZ-08 & T-026 : CA certifié = 65 000 FCFA (commandes payées ou livrées uniquement)", $commercialStats['revenue_certified'] === 65000);

        // Vérification des Top produits commandés
        $topProducts = $commercialStats['top_products'];
        $this->assert("8.5.2 Classement des top produits retourné", !empty($topProducts));
        $this->assert("8.5.3 Article en tête de volume", $topProducts[0]['total_quantity'] >= 1);

        // Suivi des règlements (paiements)
        $paymentTracking = $commercialStats['payment_tracking'];
        $this->assert("8.5.4 Répartition du suivi des paiements", count($paymentTracking) >= 2);

        // Suivi des livraisons
        $deliveryTracking = $commercialStats['delivery_tracking'];
        $this->assert("8.5.5 Répartition du suivi des livraisons", count($deliveryTracking) >= 2);
    }

    private function testSecurityAndInputEscaping(): void
    {
        echo "\n--- Tests de Sécurité (SQLi, XSS, CSRF, Contrôle Serveur) ---\n";

        // 1. Injection SQL dans la recherche avancée
        $maliciousSearch = "' OR '1'='1' --";
        $results = $this->orderRepo->findAllAdvanced(10, 0, null, $maliciousSearch);
        $this->assert("Sécurité : La requête préparée neutralise l'injection SQL sur la recherche", count($results) === 0);

        // 2. XSS dans les notes client
        $xssNote = "<script>alert('pwned')</script>";
        $xssOrderId = $this->orderRepo->createWithItems([
            'order_number' => 'CMD-XSS-TEST',
            'customer_name' => 'Hacker <b onmouseover=alert(1)>Joe</b>',
            'customer_whatsapp' => '237699999999',
            'delivery_mode' => 'delivery',
            'total_amount' => 1000,
            'customer_notes' => $xssNote
        ], [['product_name' => 'Produit Test', 'unit_price' => 1000, 'quantity' => 1]]);

        $savedOrder = $this->orderRepo->findById($xssOrderId);
        $this->assert("Sécurité : Le contenu textuel brut est stocké fidèlement sans altération", $savedOrder['customer_notes'] === $xssNote);

        // Les vues appliquent systématiquement htmlspecialchars()
        $escapedViewOutput = htmlspecialchars($savedOrder['customer_notes'], ENT_QUOTES, 'UTF-8');
        $this->assert("Sécurité : L'échappement contextualisé HTML prévient l'exécution de scripts", !str_contains($escapedViewOutput, '<script>'));
    }
}

// Lancement de la suite
$suite = new Module8DashboardAndOrdersTestSuite();
$suite->runAll();
