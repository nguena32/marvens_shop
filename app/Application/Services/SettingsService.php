<?php
declare(strict_types=1);

namespace App\Application\Services;

use PDO;
use App\Core\Database;
use App\Core\Config;

/**
 * Service centralisant la gestion du Menu Paramètres (Sections 5.1 à 5.8)
 * Conforme à l'architecture Vanilla MVC et aux règles de sécurité applicative.
 */
class SettingsService
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
    }

    /**
     * Récupère la valeur d'une clé ou une valeur par défaut.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM shop_settings WHERE setting_key = :key LIMIT 1");
        $stmt->execute(['key' => $key]);
        $val = $stmt->fetchColumn();

        if ($val === false) {
            return $default;
        }

        // Si c'est du JSON, on décode automatiquement
        $decoded = json_decode((string)$val, true);
        if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_object($decoded))) {
            return $decoded;
        }

        return $val;
    }

    /**
     * Enregistre ou met à jour une valeur.
     */
    public function set(string $key, mixed $value): bool
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            $value = (string)$value;
        }

        $driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver === 'sqlite') {
            $stmt = $this->pdo->prepare("
                INSERT INTO shop_settings (setting_key, setting_value, updated_at)
                VALUES (:k, :v, CURRENT_TIMESTAMP)
                ON CONFLICT(setting_key) DO UPDATE SET setting_value = :v, updated_at = CURRENT_TIMESTAMP
            ");
            return $stmt->execute(['k' => $key, 'v' => $value]);
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO shop_settings (setting_key, setting_value)
            VALUES (:k, :v)
            ON DUPLICATE KEY UPDATE setting_value = :v, updated_at = CURRENT_TIMESTAMP
        ");
        return $stmt->execute(['k' => $key, 'v' => $value]);
    }

    // =========================================================================
    // 5.1 INFORMATIONS DE LA BOUTIQUE
    // =========================================================================

    public function getShopInfo(): array
    {
        return [
            'shop_name' => (string)$this->get('shop_name', Config::get('app.name', 'Marvens Shop')),
            'company_name' => (string)$this->get('company_name', 'Marvens Group SARL'),
            'description' => (string)$this->get('shop_description', 'Boutique officielle Marvens Shop. Mode, accessoires et tendances exclusives.'),
            'address' => (string)$this->get('shop_address', Config::get('app.address', 'Akwa, Boulevard de la Liberté')),
            'city' => (string)$this->get('shop_city', 'Douala'),
            'country' => (string)$this->get('shop_country', 'Cameroun'),
            'phone' => (string)$this->get('shop_phone', Config::get('app.phone', '+237699000000')),
            'whatsapp_number' => (string)$this->get('whatsapp_number', Config::get('app.whatsapp_number', '+237699000000')),
            'email' => (string)$this->get('shop_email', Config::get('app.email', 'contact@marvens-shop.cm')),
            'language' => (string)$this->get('shop_language', 'fr'),
            'currency' => (string)$this->get('shop_currency', 'FCFA'),
            'timezone' => (string)$this->get('shop_timezone', 'Africa/Douala'),
            'logo_url' => (string)$this->get('shop_logo_url', '/themes/fashion/assets/img/logo.png'),
            'favicon_url' => (string)$this->get('shop_favicon_url', '/themes/fashion/assets/img/favicon.png'),
        ];
    }

    public function updateShopInfo(array $data): array
    {
        $errors = [];

        $name = trim((string)($data['shop_name'] ?? ''));
        if (empty($name) || mb_strlen($name) > 100) {
            $errors['shop_name'] = 'Le nom de la boutique est obligatoire (max 100 caractères).';
        }

        $email = trim((string)($data['email'] ?? ''));
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Le format de l\'adresse e-mail est invalide.';
        }

        $rawWhatsapp = trim((string)($data['whatsapp_number'] ?? ''));
        // Nettoyage et normalisation du numéro : accepter les chiffres, espaces, tirets, points, parenthèses et indicatif + / 00
        $cleanWhatsapp = trim($rawWhatsapp);
        $hasLeadingPlus = str_starts_with($cleanWhatsapp, '+');
        $hasLeadingDoubleZero = str_starts_with($cleanWhatsapp, '00');
        $digitsOnly = preg_replace('/[^0-9]/', '', $cleanWhatsapp);

        // Si le numéro commence par '00', convertir en indicatif international standard
        if ($hasLeadingDoubleZero && strlen($digitsOnly) > 2) {
            $digitsOnly = substr($digitsOnly, 2);
            $hasLeadingPlus = true;
        }

        if (empty($rawWhatsapp) || strlen($digitsOnly) < 8 || strlen($digitsOnly) > 16) {
            $errors['whatsapp_number'] = 'Le numéro WhatsApp est obligatoire et doit comporter entre 8 et 15 chiffres (ex: +237 699 00 00 00).';
        } else {
            // Normaliser avec le '+' pour le stockage international canonique
            $whatsapp = '+' . $digitsOnly;
        }

        $allowedCurrencies = ['FCFA', 'EUR', 'USD', 'XAF', 'XOF'];
        $currency = trim($data['currency'] ?? 'FCFA');
        if (!in_array($currency, $allowedCurrencies, true)) {
            $currency = 'FCFA';
        }

        $allowedLanguages = ['fr', 'en'];
        $language = trim($data['language'] ?? 'fr');
        if (!in_array($language, $allowedLanguages, true)) {
            $language = 'fr';
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Sauvegarder
        $this->set('shop_name', $name);
        $this->set('company_name', trim($data['company_name'] ?? ''));
        $this->set('shop_description', trim($data['description'] ?? ''));
        $this->set('shop_address', trim($data['address'] ?? ''));
        $this->set('shop_city', trim($data['city'] ?? 'Douala'));
        $this->set('shop_country', trim($data['country'] ?? 'Cameroun'));
        $this->set('shop_phone', trim($data['phone'] ?? ''));
        $this->set('whatsapp_number', $whatsapp);
        $this->set('shop_email', $email);
        $this->set('shop_language', $language);
        $this->set('shop_currency', $currency);
        $this->set('shop_timezone', trim($data['timezone'] ?? 'Africa/Douala'));

        $logoUrl = trim($data['logo_url'] ?? '');
        if ($logoUrl !== '') {
            $this->set('shop_logo_url', $logoUrl);
        }
        $faviconUrl = trim($data['favicon_url'] ?? '');
        if ($faviconUrl !== '') {
            $this->set('shop_favicon_url', $faviconUrl);
        }

        return ['success' => true];
    }

    // =========================================================================
    // 5.3 LIVRAISON ET RETRAIT
    // =========================================================================

    public function getDeliverySettings(): array
    {
        $homeEnabled = (bool)$this->get('delivery_home_enabled', '1');
        $pickupEnabled = (bool)$this->get('delivery_pickup_enabled', '1');
        $freeShippingThreshold = (int)$this->get('delivery_free_threshold', '0'); // 0 = désactivé
        $pickupAddress = (string)$this->get('delivery_pickup_address', 'Boutique Principale - Akwa, Douala (Ouvert du Lun au Sam de 9h à 19h)');
        $instructions = (string)$this->get('delivery_instructions', 'Les livraisons se font entre 9h et 18h. Notre livreur vous contactera par appel ou WhatsApp avant de se déplacer.');

        $zones = $this->getDeliveryZones();

        return [
            'home_enabled' => $homeEnabled,
            'pickup_enabled' => $pickupEnabled,
            'free_shipping_threshold' => $freeShippingThreshold,
            'pickup_address' => $pickupAddress,
            'instructions' => $instructions,
            'zones' => $zones,
        ];
    }

    public function updateDeliverySettings(array $data): bool
    {
        $this->set('delivery_home_enabled', !empty($data['home_enabled']) ? '1' : '0');
        $this->set('delivery_pickup_enabled', !empty($data['pickup_enabled']) ? '1' : '0');
        $this->set('delivery_free_threshold', max(0, (int)($data['free_shipping_threshold'] ?? 0)));
        $this->set('delivery_pickup_address', trim($data['pickup_address'] ?? ''));
        $this->set('delivery_instructions', trim($data['instructions'] ?? ''));
        return true;
    }

    public function getDeliveryZones(bool $onlyActive = false): array
    {
        try {
            $sql = "SELECT * FROM delivery_zones";
            if ($onlyActive) {
                $sql .= " WHERE is_active = 1";
            }
            $sql .= " ORDER BY city ASC, district ASC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            // Table non créée ou fallback
            return [];
        }
    }

    public function addDeliveryZone(string $city, string $district, int $fee, string $estimatedTime = '24h - 48h'): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO delivery_zones (city, district, fee, estimated_time, is_active)
            VALUES (:city, :district, :fee, :estimated_time, 1)
        ");
        return $stmt->execute([
            'city' => trim($city),
            'district' => trim($district),
            'fee' => max(0, $fee),
            'estimated_time' => trim($estimatedTime),
        ]);
    }

    public function updateDeliveryZone(int $id, string $city, string $district, int $fee, string $estimatedTime, bool $isActive): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE delivery_zones
            SET city = :city, district = :district, fee = :fee, estimated_time = :estimated_time, is_active = :is_active
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'city' => trim($city),
            'district' => trim($district),
            'fee' => max(0, $fee),
            'estimated_time' => trim($estimatedTime),
            'is_active' => $isActive ? 1 : 0,
        ]);
    }

    public function deleteDeliveryZone(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM delivery_zones WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function calculateDeliveryFee(?string $district, int $subtotal): int
    {
        $settings = $this->getDeliverySettings();

        // Gratuit si seuil de gratuité dépassé
        if ($settings['free_shipping_threshold'] > 0 && $subtotal >= $settings['free_shipping_threshold']) {
            return 0;
        }

        if (empty($district)) {
            return 1500; // Forfait de base
        }

        try {
            $stmt = $this->pdo->prepare("SELECT fee FROM delivery_zones WHERE district = :district AND is_active = 1 LIMIT 1");
            $stmt->execute(['district' => trim($district)]);
            $fee = $stmt->fetchColumn();

            if ($fee !== false) {
                return (int)$fee;
            }
        } catch (\Exception $e) {
            // ignore
        }

        return 1500;
    }

    // =========================================================================
    // 5.4 UTILISATEURS ET GESTION DES COMPTES
    // =========================================================================

    public function getAllUsers(): array
    {
        $stmt = $this->pdo->query("SELECT id, username, email, role, name, is_active, created_at FROM users ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRoles(): array
    {
        return [
            'merchant_admin' => 'Propriétaire / Administrateur',
            'store_manager' => 'Responsable commercial',
            'stock_manager' => 'Gestionnaire de stock',
            'support' => 'Support client',
            'preparer' => 'Préparateur de commande',
        ];
    }

    public function addUser(string $username, string $email, string $password, string $role, string $name = ''): array
    {
        $username = trim($username);
        $email = trim($email);

        if (empty($username) || strlen($username) < 3) {
            return ['success' => false, 'error' => 'Le nom d\'utilisateur doit contenir au moins 3 caractères.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Format d\'adresse e-mail invalide.'];
        }

        if (strlen($password) < 8) {
            return ['success' => false, 'error' => 'Le mot de passe doit comporter au moins 8 caractères.'];
        }

        $allowedRoles = array_keys($this->getUserRoles());
        if (!in_array($role, $allowedRoles, true)) {
            $role = 'store_manager';
        }

        // Vérifier unicité
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1");
        $stmt->execute(['u' => $username, 'e' => $email]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'Ce nom d\'utilisateur ou cet e-mail est déjà utilisé.'];
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, email, password_hash, role, name, is_active)
            VALUES (:u, :e, :h, :r, :n, 1)
        ");
        $stmt->execute([
            'u' => $username,
            'e' => $email,
            'h' => $hash,
            'r' => $role,
            'n' => trim($name),
        ]);

        return ['success' => true];
    }

    public function toggleUserStatus(int $userId, bool $active): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_active = :a WHERE id = :id");
        return $stmt->execute(['a' => $active ? 1 : 0, 'id' => $userId]);
    }

    public function updateUserPassword(int $userId, string $newPassword): array
    {
        if (strlen($newPassword) < 8) {
            return ['success' => false, 'error' => 'Le mot de passe doit contenir au moins 8 caractères.'];
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :h WHERE id = :id");
        $stmt->execute(['h' => $hash, 'id' => $userId]);

        return ['success' => true];
    }

    // =========================================================================
    // 5.5 NOTIFICATIONS
    // =========================================================================

    public function getNotificationSettings(): array
    {
        $default = [
            'order_confirmation_email' => true,
            'order_confirmation_whatsapp' => true,
            'order_preparing_email' => true,
            'order_preparing_whatsapp' => false,
            'order_shipped_email' => true,
            'order_shipped_whatsapp' => true,
            'order_delivered_email' => true,
            'order_delivered_whatsapp' => false,
            'order_cancelled_email' => true,
            'order_cancelled_whatsapp' => false,
            'admin_new_order_email' => true,
            'admin_new_order_whatsapp' => true,
            'admin_low_stock_email' => true,
            'admin_out_of_stock_email' => true,
        ];

        $saved = $this->get('notification_settings', $default);
        if (is_array($saved)) {
            return array_merge($default, $saved);
        }

        return $default;
    }

    public function updateNotificationSettings(array $settings): bool
    {
        return $this->set('notification_settings', $settings);
    }

    // =========================================================================
    // 5.6 APPLICATIONS ET INTÉGRATIONS
    // =========================================================================

    public function getIntegrationsSettings(): array
    {
        return [
            'whatsapp' => [
                'name' => 'WhatsApp Business',
                'description' => 'Canal direct de réception de commandes et échanges clients.',
                'enabled' => (bool)$this->get('integration_whatsapp_enabled', '1'),
                'phone' => (string)$this->get('whatsapp_number', '+237699000000'),
                'status' => 'connected',
            ],
            'smtp' => [
                'name' => 'Service E-mail (SMTP)',
                'description' => 'Envoi des confirmations de commandes et alertes système.',
                'enabled' => (bool)$this->get('integration_smtp_enabled', '0'),
                'host' => (string)$this->get('smtp_host', 'mail.marvens-shop.cm'),
                'port' => (string)$this->get('smtp_port', '465'),
                'user' => (string)$this->get('smtp_user', 'no-reply@marvens-shop.cm'),
                'encryption' => (string)$this->get('smtp_encryption', 'ssl'),
                'status' => ((bool)$this->get('integration_smtp_enabled', '0')) ? 'connected' : 'not_configured',
            ],
            'meta_catalog' => [
                'name' => 'Catalogue Meta / Instagram Shopping',
                'description' => 'Synchronisation avec Facebook Shop et Instagram Shopping.',
                'enabled' => (bool)$this->get('integration_meta_enabled', '0'),
                'catalog_id' => (string)$this->get('meta_catalog_id', ''),
                'status' => ((bool)$this->get('integration_meta_enabled', '0')) ? 'connected' : 'not_configured',
            ],
            'google_analytics' => [
                'name' => 'Google Analytics 4',
                'description' => 'Analyse du trafic et comportement d\'achat.',
                'enabled' => (bool)$this->get('integration_ga_enabled', '0'),
                'measurement_id' => (string)$this->get('ga_measurement_id', ''),
                'status' => !empty($this->get('ga_measurement_id', '')) ? 'connected' : 'not_configured',
            ],
            'meta_pixel' => [
                'name' => 'Meta Pixel & CAPI',
                'description' => 'Suivi des conversions publicitaires Facebook & Instagram.',
                'enabled' => (bool)$this->get('integration_pixel_enabled', '0'),
                'pixel_id' => (string)$this->get('meta_pixel_id', ''),
                'status' => !empty($this->get('meta_pixel_id', '')) ? 'connected' : 'not_configured',
            ],
        ];
    }

    public function updateIntegrationsSettings(array $data): bool
    {
        $this->set('integration_whatsapp_enabled', !empty($data['whatsapp_enabled']) ? '1' : '0');
        $this->set('integration_smtp_enabled', !empty($data['smtp_enabled']) ? '1' : '0');
        $this->set('smtp_host', trim($data['smtp_host'] ?? ''));
        $this->set('smtp_port', trim($data['smtp_port'] ?? '465'));
        $this->set('smtp_user', trim($data['smtp_user'] ?? ''));
        $this->set('smtp_encryption', trim($data['smtp_encryption'] ?? 'ssl'));

        $this->set('integration_meta_enabled', !empty($data['meta_enabled']) ? '1' : '0');
        $this->set('meta_catalog_id', trim($data['meta_catalog_id'] ?? ''));

        $this->set('integration_ga_enabled', !empty($data['ga_enabled']) ? '1' : '0');
        $this->set('ga_measurement_id', trim($data['ga_measurement_id'] ?? ''));

        $this->set('integration_pixel_enabled', !empty($data['pixel_enabled']) ? '1' : '0');
        $this->set('meta_pixel_id', trim($data['meta_pixel_id'] ?? ''));

        return true;
    }

    // =========================================================================
    // 5.7 SÉCURITÉ & LOGS D'ACTIVITÉ
    // =========================================================================

    public function logActivity(?int $userId, ?string $userEmail, string $eventType, ?string $ip = null, ?string $userAgent = null, ?string $details = null): void
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO activity_logs (user_id, user_email, event_type, ip_address, user_agent, details)
                VALUES (:uid, :uemail, :event, :ip, :ua, :details)
            ");
            $stmt->execute([
                'uid' => $userId,
                'uemail' => $userEmail,
                'event' => $eventType,
                'ip' => $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'),
                'ua' => $userAgent ?? mb_substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 255),
                'details' => $details,
            ]);
        } catch (\Exception $e) {
            // Silencieux si table non migrée
        }
    }

    public function getActivityLogs(int $limit = 50): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM activity_logs ORDER BY id DESC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return [];
        }
    }

    // =========================================================================
    // 5.8 ANALYTICS & TAGS MARKETING
    // =========================================================================

    public function getAnalyticsSettings(): array
    {
        return [
            'ga_id' => (string)$this->get('ga_measurement_id', ''),
            'pixel_id' => (string)$this->get('meta_pixel_id', ''),
            'gtm_id' => (string)$this->get('gtm_container_id', ''),
            'track_checkout' => (bool)$this->get('track_checkout_enabled', '1'),
            'track_whatsapp_clicks' => (bool)$this->get('track_whatsapp_clicks_enabled', '1'),
        ];
    }

    public function updateAnalyticsSettings(array $data): bool
    {
        $this->set('ga_measurement_id', trim($data['ga_id'] ?? ''));
        $this->set('meta_pixel_id', trim($data['pixel_id'] ?? ''));
        $this->set('gtm_container_id', trim($data['gtm_id'] ?? ''));
        $this->set('track_checkout_enabled', !empty($data['track_checkout']) ? '1' : '0');
        $this->set('track_whatsapp_clicks_enabled', !empty($data['track_whatsapp_clicks']) ? '1' : '0');
        return true;
    }
}
