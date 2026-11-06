<?php
declare(strict_types=1);

use App\Core\Env;

return [
    'name' => Env::get('APP_NAME', 'Marvens Shop'),
    'env' => Env::get('APP_ENV', 'production'),
    'debug' => Env::get('APP_DEBUG', false),
    'url' => Env::get('APP_URL', 'http://localhost'),
    'secret' => Env::get('APP_SECRET', 'secret_key_marvens_shop_must_be_set'),
    'timezone' => Env::get('SHOP_TIMEZONE', 'Africa/Douala'),
    'currency' => Env::get('SHOP_CURRENCY', 'FCFA'),
    'theme' => Env::get('SHOP_DEFAULT_THEME', 'fashion'),
    'whatsapp_number' => Env::get('SHOP_WHATSAPP_NUMBER', '+237699000000'),
    'phone' => Env::get('SHOP_PHONE', '+237699000000'),
    'email' => Env::get('SHOP_EMAIL', 'contact@marvens-shop.cm'),
    'address' => Env::get('SHOP_ADDRESS', 'Douala, Cameroun (Akwa / Bonapriso)'),
];
