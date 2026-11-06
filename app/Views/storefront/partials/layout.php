<?php
/**
 * Layout principal du Storefront public adaptatif selon le thème actif
 * Variables attendues :
 * - $theme : instance de App\Domain\Themes\Theme
 * - $title : titre de la page
 * - $cart_count : nombre d'articles au panier
 * - $shop_name : nom de la boutique
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$colors = $theme ? $theme->getTailwindColors() : [];
$typography = $theme ? $theme->getTypography() : ['headline' => 'Space Grotesk', 'body' => 'Inter'];
$activeTab = $active_tab ?? 'home';
$pageTitle = ($title ?? 'Accueil') . ' — ' . ($shop_name ?? 'Marvens Shop');
?>
<!DOCTYPE html>
<html lang="fr" data-theme="<?= htmlspecialchars($themeId) ?>">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- PWA Manifest & App Icons -->
    <link rel="manifest" href="/manifest.json"/>
    <meta name="theme-color" content="<?= htmlspecialchars($colors['primary'] ?? '#4f46e5') ?>"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="default"/>
    <meta name="apple-mobile-web-app-title" content="<?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?>"/>
    <link rel="apple-touch-icon" href="/assets/icons/icon-192x192.png"/>

    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
            main > :first-child { margin-top:0!important; }
            main > :last-child { margin-bottom:0!important; }
        }
        ::-webkit-scrollbar { display:none; }
        
        <?php if ($themeId === 'luxe'): ?>
            /* Styles spécifiques Theme Luxe (Neo-Brutalist Bauhaus) */
            .btn-theme {
                border: 2px solid #1a1a1a !important;
                box-shadow: 4px 4px 0px #1a1a1a !important;
                border-radius: 0px !important;
                transition: all 0.15s ease !important;
                text-transform: uppercase !important;
                font-weight: 700 !important;
            }
            .btn-theme:hover {
                transform: translate(2px, 2px) !important;
                box-shadow: 2px 2px 0px #1a1a1a !important;
            }
            .card-theme {
                border: 2px solid #1a1a1a !important;
                border-radius: 0px !important;
                box-shadow: 4px 4px 0px #1a1a1a !important;
            }
            .badge-theme {
                border: 2px solid #1a1a1a !important;
                border-radius: 0px !important;
                box-shadow: 2px 2px 0px #1a1a1a !important;
            }
        <?php elseif ($themeId === 'bello'): ?>
            /* Styles spécifiques Theme Bello (Chaleureux & Doux) */
            .btn-theme {
                border-radius: 1rem !important;
                font-weight: 600 !important;
                transition: all 0.2s ease !important;
            }
            .btn-theme:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 12px rgba(194, 65, 12, 0.2) !important;
            }
            .card-theme {
                border-radius: 1.5rem !important;
                border: 1px solid #fed7aa !important;
                background-color: #fdfaf6 !important;
            }
        <?php elseif ($themeId === 'naya'): ?>
            /* Styles spécifiques Theme Naya (Émeraude Fraîcheur) */
            .btn-theme {
                border-radius: 9999px !important;
                font-weight: 600 !important;
                transition: all 0.2s ease !important;
            }
            .btn-theme:hover {
                transform: scale(1.02) !important;
                box-shadow: 0 4px 14px rgba(4, 120, 87, 0.2) !important;
            }
            .card-theme {
                border-radius: 1rem !important;
                border: 1px solid #bbf7d0 !important;
                background-color: #ffffff !important;
            }
        <?php elseif ($themeId === 'shop'): ?>
            /* Styles spécifiques Theme Shop (Swiss Editorial) */
            .btn-theme {
                border-radius: 0.5rem !important;
                font-weight: 600 !important;
                transition: all 0.15s ease !important;
            }
            .btn-theme:hover {
                background-color: #1b1b1d !important;
                color: #ffffff !important;
            }
            .card-theme {
                border-radius: 0.75rem !important;
                border: 1px solid #e2e8f0 !important;
                background-color: #ffffff !important;
            }
        <?php else: ?>
            /* Styles spécifiques Theme Fashion (Éditorial Ambre) */
            .btn-theme {
                border-radius: 0.75rem !important;
                font-weight: 600 !important;
                transition: all 0.2s ease !important;
            }
            .card-theme {
                border-radius: 1rem !important;
                border: 1px solid #e2e8f0 !important;
                background-color: #ffffff !important;
            }
        <?php endif; ?>

        /* Injection dynamique des styles personnalisés (Module 3 : Personnalisation des Couleurs) */
        <?= $dynamic_css ?? '' ?>
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: <?= json_encode($colors, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?>,
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "2xl": "1rem", "3xl": "1.5rem", "full": "9999px" },
                    fontFamily: {
                        "headline": ["<?= htmlspecialchars($typography['headline'] ?? 'Space Grotesk') ?>", "sans-serif"],
                        "body": ["<?= htmlspecialchars($typography['body'] ?? 'Inter') ?>", "sans-serif"],
                    }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="<?= htmlspecialchars($google_fonts_url ?? 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700;800&display=swap') ?>" rel="stylesheet"/>
    <?php if (!empty($shop_info['favicon_url'])): ?>
        <link rel="icon" type="image/x-icon" href="<?= htmlspecialchars($shop_info['favicon_url']) ?>">
    <?php endif; ?>
    <?php if (!empty($analytics['ga_id'])): ?>
        <!-- Google Analytics 4 (Module 5.8) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($analytics['ga_id']) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= htmlspecialchars($analytics['ga_id']) ?>');
        </script>
    <?php endif; ?>
    <?php if (!empty($analytics['pixel_id'])): ?>
        <!-- Meta Pixel (Module 5.8) -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?= htmlspecialchars($analytics['pixel_id']) ?>');
            fbq('track', 'PageView');
        </script>
    <?php endif; ?>
</head>
<body class="bg-background font-body text-on-surface antialiased flex flex-col min-h-screen">

    <?php if (isset($preview_mode) && $preview_mode): ?>
        <!-- Bandeau d'information de prévisualisation de thème -->
        <div class="bg-amber-500 text-slate-900 px-4 py-2 font-semibold text-xs flex items-center justify-between sticky top-0 z-50 shadow-md">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">visibility</span>
                <span>Mode Prévisualisation — Thème : <strong><?= htmlspecialchars($theme->getName()) ?></strong> (Non encore actif sur la boutique publique)</span>
            </div>
            <div class="flex items-center gap-2">
                <form method="POST" action="/admin/themes/activer" class="inline">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="theme" value="<?= htmlspecialchars($theme->getId()) ?>">
                    <button type="submit" class="bg-slate-900 text-white px-3 py-1 rounded text-xs hover:bg-slate-800 transition">
                        Confirmer et Activer ce Thème
                    </button>
                </form>
                <a href="/admin/themes" class="bg-white/80 text-slate-900 px-3 py-1 rounded text-xs hover:bg-white transition">
                    Retour à l'admin
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Top Announcement Bar -->
    <div class="bg-primary text-on-primary px-4 py-2 text-xs flex items-center justify-between">
        <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Boutique en ligne officielle • Commande et livraison express au Cameroun</span>
            </div>
            <div class="hidden md:flex items-center gap-6">
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">local_shipping</span> Paiement à la livraison</span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">chat</span> WhatsApp Direct</span>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 bg-surface/90 backdrop-blur-md z-40 border-b border-border shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-6">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold font-headline text-base">
                        <?= strtoupper(substr($shop_name ?? 'M', 0, 1)) ?>
                    </div>
                    <span class="font-headline font-bold text-lg tracking-tight text-on-surface"><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?></span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="/" class="<?= $activeTab === 'home' ? 'text-primary font-bold' : 'text-on-surface/70 hover:text-primary' ?> transition">Accueil</a>
                    <a href="/catalogue" class="<?= $activeTab === 'catalog' ? 'text-primary font-bold' : 'text-on-surface/70 hover:text-primary' ?> transition">Catalogue</a>
                    <a href="/livraison" class="<?= $activeTab === 'delivery' ? 'text-primary font-bold' : 'text-on-surface/70 hover:text-primary' ?> transition">Livraison</a>
                    <a href="/contact" class="<?= $activeTab === 'contact' ? 'text-primary font-bold' : 'text-on-surface/70 hover:text-primary' ?> transition">Contact</a>
                </nav>
            </div>

            <!-- Barre de recherche -->
            <form action="/catalogue" method="GET" class="hidden sm:flex items-center bg-surface-container px-3 py-1.5 rounded-lg border border-border w-48 lg:w-72">
                <span class="material-symbols-outlined text-outline text-[18px] mr-2">search</span>
                <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" placeholder="Rechercher un produit..." class="bg-transparent border-none outline-none text-xs w-full text-on-surface placeholder:text-outline"/>
            </form>

            <div class="flex items-center gap-3">
                <?php 
                    $headerWaNum = preg_replace('/[^0-9]/', '', (string)($whatsapp_number ?? '237699000000'));
                    $headerWaUrl = "https://wa.me/" . $headerWaNum . "?text=" . rawurlencode("Bonjour " . ($shop_name ?? 'Marvens Shop') . ", je souhaite des informations.");
                ?>
                <a href="<?= htmlspecialchars($headerWaUrl) ?>" target="_blank" class="hidden sm:flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-xl text-xs font-semibold transition shadow-sm" title="Contactez-nous sur WhatsApp">
                    <span class="material-symbols-outlined text-[16px]">chat</span>
                    <span>WhatsApp</span>
                </a>
                <a href="/panier" class="relative flex items-center gap-2 bg-primary text-on-primary px-3 py-2 btn-theme text-xs font-semibold shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                    <span class="hidden sm:inline">Panier</span>
                    <?php if (($cart_count ?? 0) > 0): ?>
                        <span class="bg-error text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                            <?= (int) $cart_count ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 w-full">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer Commercial Universel -->
    <!-- Footer -->
    <footer class="bg-surface border-t border-border mt-auto pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- 1. Identité & Réassurance -->
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-xs">
                        <?= strtoupper(substr($shop_name ?? 'M', 0, 1)) ?>
                    </div>
                    <span class="font-headline font-bold text-base text-on-surface"><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?></span>
                </div>
                <p class="text-xs text-outline leading-relaxed">
                    <?= htmlspecialchars($shop_info['description'] ?? 'Votre boutique en ligne avec service de commande WhatsApp direct et paiement à la livraison sécurisé.') ?>
                </p>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-200">
                    <span class="material-symbols-outlined text-[14px]">verified</span> Boutique officielle vérifiée
                </div>
            </div>

            <!-- 2. Navigation Rapide -->
            <div>
                <h4 class="font-headline font-semibold text-xs uppercase tracking-wider mb-3 text-on-surface">Navigation</h4>
                <ul class="space-y-2.5 text-xs text-outline">
                    <li><a href="/" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">chevron_right</span> Accueil</a></li>
                    <li><a href="/catalogue" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">chevron_right</span> Tous les produits</a></li>
                    <li><a href="/catalogue?filter=populaires" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">chevron_right</span> Produits populaires</a></li>
                    <li><a href="/panier" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">chevron_right</span> Mon panier d'achats</a></li>
                </ul>
            </div>

            <!-- 3. Informations & Engagements -->
            <div>
                <h4 class="font-headline font-semibold text-xs uppercase tracking-wider mb-3 text-on-surface">Service Client</h4>
                <ul class="space-y-2.5 text-xs text-outline">
                    <li><a href="/livraison" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">local_shipping</span> Livraison & Retrait</a></li>
                    <li><a href="/contact" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">support_agent</span> Contact & Support</a></li>
                    <li><a href="/a-propos" class="hover:text-primary transition flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">info</span> À propos de nous</a></li>
                    <li class="pt-1 text-[11px] text-outline/80 flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-primary">payments</span> Paiement sécurisé à la livraison</li>
                </ul>
            </div>

            <!-- 4. Contact & WhatsApp Direct -->
            <div>
                <h4 class="font-headline font-semibold text-xs uppercase tracking-wider mb-3 text-on-surface">Contact Direct</h4>
                <div class="space-y-3 text-xs text-outline">
                    <?php 
                        $footerWaNum = preg_replace('/[^0-9]/', '', (string)($shop_info['whatsapp_number'] ?? $whatsapp_number ?? '237699000000'));
                        $footerWaUrl = "https://wa.me/" . $footerWaNum . "?text=" . rawurlencode("Bonjour " . ($shop_name ?? 'Marvens Shop') . ", je souhaite commander.");
                    ?>
                    <a href="<?= htmlspecialchars($footerWaUrl) ?>" target="_blank" class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 transition font-medium">
                        <span class="material-symbols-outlined text-emerald-600 text-base">chat</span>
                        <div>
                            <div class="text-[10px] uppercase font-bold text-emerald-600">Commander via WhatsApp</div>
                            <div class="text-xs font-semibold"><?= htmlspecialchars($shop_info['whatsapp_number'] ?? '+237 699 00 00 00') ?></div>
                        </div>
                    </a>

                    <?php if (!empty($shop_info['address']) || !empty($shop_info['city'])): ?>
                        <div class="flex items-start gap-2 pt-1 text-[11px]">
                            <span class="material-symbols-outlined text-[16px] text-outline shrink-0 mt-0.5">location_on</span>
                            <span><?= htmlspecialchars(($shop_info['address'] ?? '') . (!empty($shop_info['city']) ? ', ' . $shop_info['city'] : '')) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($shop_info['email'])): ?>
                        <div class="flex items-center gap-2 text-[11px]">
                            <span class="material-symbols-outlined text-[16px] text-outline shrink-0">mail</span>
                            <span class="truncate"><?= htmlspecialchars($shop_info['email']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pt-5 border-t border-border flex flex-col sm:flex-row items-center justify-between text-xs text-outline">
            <div>&copy; <?= date('Y') ?> <?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?>. Tous droits réservés.</div>
            <div class="mt-2 sm:mt-0 flex items-center gap-3">
                <span>Expédition rapide & Suivi personnalisé</span>
                <span>•</span>
                <span>Paiement à réception</span>
            </div>
        </div>
    </footer>

    <!-- Service Worker PWA & Bannière d'état réseau -->
    <div id="pwa-offline-badge" style="display:none; position:fixed; bottom:1rem; left:50%; transform:translateX(-50%); z-index:9999; background:#1f2937; color:#f9fafb; padding:0.6rem 1.2rem; border-radius:9999px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.3); font-size:12px; font-weight:600; display:flex; align-items:center; gap:0.5rem;">
        <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#ef4444;"></span>
        Mode Hors-Ligne actif
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((reg) => {
                    console.log('PWA ServiceWorker actif avec scope:', reg.scope);
                }).catch((err) => {
                    console.warn('Enregistrement ServiceWorker ignoré:', err);
                });
            });
        }

        const offlineBadge = document.getElementById('pwa-offline-badge');
        function updateOnlineStatus() {
            if (offlineBadge) {
                offlineBadge.style.display = navigator.onLine ? 'none' : 'flex';
            }
        }
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
        updateOnlineStatus();
    </script>
</body>
</html>
