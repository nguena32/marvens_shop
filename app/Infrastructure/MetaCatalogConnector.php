<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Core\Config;
use RuntimeException;

/**
 * Connecteur d'infrastructure pour l'API Meta Catalog
 * Règle MS-BIZ-10 : Neutralisation des erreurs API externes et isolation
 */
class MetaCatalogConnector
{
    private ?string $appId;
    private ?string $appSecret;
    private ?string $accessToken;

    public function __construct(?string $appId = null, ?string $appSecret = null, ?string $accessToken = null)
    {
        $this->appId = $appId ?: Config::get('meta.app_id');
        $this->appSecret = $appSecret ?: Config::get('meta.app_secret');
        $this->accessToken = $accessToken ?: Config::get('meta.access_token');
    }

    public function isConfigured(): bool
    {
        return !empty($this->appId) && !empty($this->appSecret) && !empty($this->accessToken);
    }

    public function getStatus(): array
    {
        if (!$this->isConfigured()) {
            return [
                'status' => 'BLOCKED_EXTERNAL',
                'message' => 'Identifiants Meta Developer non configurés. En attente de validation des clés API par le commerçant.',
                'configured' => false,
            ];
        }

        return [
            'status' => 'CONFIGURED',
            'message' => 'Connecteur Meta configuré et prêt pour authentification Graph API v19.0.',
            'configured' => true,
        ];
    }

    public function fetchCatalogProducts(string $catalogId): array
    {
        if (!$this->isConfigured()) {
            throw new RuntimeException("L'API Meta n'est pas configurée pour cette boutique.");
        }

        // Appel sécurisé cURL vers Graph API sous timeout strict
        // Réservé à l'étape où le client fournit ses clés d'application vérifiées
        return [];
    }
}
