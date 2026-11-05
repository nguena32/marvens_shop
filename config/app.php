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
];
