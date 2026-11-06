<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Service de chiffrement symétrique sécurisé (AES-256-GCM / CBC)
 * Module 9.2 : Protection des tokens Meta et données sensibles au repos
 */
class Crypto
{
    private static function getKey(): string
    {
        $secret = (string) Config::get('app.secret', 'secret_key_marvens_shop_must_be_set_32_chars!');
        return hash('sha256', $secret, true);
    }

    /**
     * Chiffre une chaîne en AES-256-CBC avec HMAC-SHA256 (authentifié)
     */
    public static function encrypt(string $plainText): string
    {
        if ($plainText === '') {
            return '';
        }

        $key = self::getKey();
        $iv = random_bytes(16);
        $cipherText = openssl_encrypt($plainText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        if ($cipherText === false) {
            throw new \RuntimeException("Échec du chiffrement OpenSSL.");
        }

        $hmac = hash_hmac('sha256', $iv . $cipherText, $key, true);
        return base64_encode($iv . $hmac . $cipherText);
    }

    /**
     * Déchiffre une chaîne chiffrée
     */
    public static function decrypt(string $cipherPayload): ?string
    {
        if ($cipherPayload === '') {
            return '';
        }

        $decoded = base64_decode($cipherPayload, true);
        if ($decoded === false || strlen($decoded) < 48) {
            return null; // Données altérées ou non chiffrées
        }

        $key = self::getKey();
        $iv = substr($decoded, 0, 16);
        $hmac = substr($decoded, 16, 32);
        $cipherText = substr($decoded, 48);

        $calculatedHmac = hash_hmac('sha256', $iv . $cipherText, $key, true);
        if (!hash_equals($hmac, $calculatedHmac)) {
            return null; // Altération détectée (tamper proof)
        }

        $decrypted = openssl_decrypt($cipherText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted !== false ? $decrypted : null;
    }
}
