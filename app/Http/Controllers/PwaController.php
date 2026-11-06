<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Config;
use App\Application\Services\SettingsService;

/**
 * Contrôleur PWA : Manifest dynamique et Service Worker contrôlé
 * Module 9.1 PWA (Progressive Web App)
 */
class PwaController extends Controller
{
    private SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();
    }

    /**
     * Manifest PWA dynamique conforme W3C / Chrome / Safari
     */
    public function manifest(Request $request): Response
    {
        $shopName = (string) $this->settingsService->get('shop_name', Config::get('app.name', 'Marvens Shop'));
        $shopDesc = (string) $this->settingsService->get('shop_description', 'Boutique en ligne et gestion des commandes WhatsApp');
        $primaryColor = (string) $this->settingsService->get('primary_color', '#4f46e5');
        $themeColor = (string) $this->settingsService->get('theme_color', '#ffffff');

        $manifestData = [
            'name' => $shopName,
            'short_name' => mb_substr($shopName, 0, 12),
            'description' => $shopDesc,
            'start_url' => '/',
            'display' => 'standalone',
            'background_color' => $themeColor,
            'theme_color' => $primaryColor,
            'orientation' => 'portrait-primary',
            'scope' => '/',
            'icons' => [
                [
                    'src' => '/assets/icons/icon-192x192.png',
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any maskable'
                ],
                [
                    'src' => '/assets/icons/icon-512x512.png',
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any maskable'
                ]
            ]
        ];

        return Response::json($manifestData, 200);
    }

    /**
     * Service Worker dynamique avec Cache contrôlé des ressources publiques
     * Exclut formellement : /admin/*, /panier/valider, checkout, sessions, logs
     */
    public function serviceWorker(Request $request): Response
    {
        $version = 'marvens-v1.0.1';
        $jsContent = <<<JS
const CACHE_NAME = 'marvens-shop-static-{$version}';

// Ressources publiques autorisées au pré-cache
const PRECACHE_ASSETS = [
    '/',
    '/catalogue',
    '/a-propos',
    '/livraison',
    '/contact',
    '/offline',
    '/assets/icons/icon-192x192.png'
];

// Installation du Service Worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS);
        }).then(() => self.skipWaiting())
    );
});

// Activation et purge des anciens caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        return caches.delete(name);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Interception des requêtes HTTP (Stratégie Network-first avec fallback Cache pour le public)
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // REGLE NON NEGOCIABLE : JAMAIS de cache pour /admin, les requêtes POST, checkout ou API
    if (
        event.request.method !== 'GET' ||
        url.pathname.startsWith('/admin') ||
        url.pathname.startsWith('/commande') ||
        url.pathname.startsWith('/panier/valider') ||
        url.pathname.startsWith('/api')
    ) {
        return; // Passer directement au réseau natif sans interférence
    }

    // Pour les requêtes publiques GET : Réseau en priorité, puis Cache, puis page hors ligne
    event.respondWith(
        fetch(event.request)
            .then((networkResponse) => {
                // Mettre en cache dynamique les ressources statiques publiques (images, css, js)
                if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                    const responseToCache = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseToCache);
                    });
                }
                return networkResponse;
            })
            .catch(() => {
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    if (event.request.headers.get('accept')?.includes('text/html')) {
                        return caches.match('/offline');
                    }
                });
            })
    );
});
JS;

        return new Response($jsContent, 200, [
            'Content-Type' => 'application/javascript; charset=UTF-8',
            'Service-Worker-Allowed' => '/'
        ]);
    }

    /**
     * Page d'état hors-ligne conviviale
     */
    public function offline(Request $request): Response
    {
        $shopName = (string) $this->settingsService->get('shop_name', 'Marvens Shop');
        $html = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Vous êtes hors connexion — {$shopName}</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #f9fafb; color: #111827; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; padding: 1.5rem; text-align: center; }
        .card { background: white; padding: 2.5rem; border-radius: 1rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); max-width: 450px; width: 100%; border: 1px solid #e5e7eb; }
        .icon { font-size: 3.5rem; margin-bottom: 1rem; }
        h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: #1f2937; }
        p { color: #6b7280; font-size: 0.95rem; line-height: 1.5; margin-bottom: 1.5rem; }
        .btn { display: inline-block; background: #4f46e5; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: background 0.2s; border: none; cursor: pointer; }
        .btn:hover { background: #4338ca; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">📶</div>
        <h1>Connexion Internet indisponible</h1>
        <p>Il semble que vous soyez actuellement hors-ligne. Vous pouvez toujours consulter les pages récemment visitées ou réessayer dès que le réseau sera rétabli.</p>
        <button class="btn" onclick="window.location.reload()">Réessayer la connexion</button>
    </div>
</body>
</html>
HTML;

        return Response::html($html, 200);
    }
}
