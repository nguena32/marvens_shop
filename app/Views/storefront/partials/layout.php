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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
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
                </nav>
            </div>

            <!-- Barre de recherche -->
            <form action="/catalogue" method="GET" class="hidden sm:flex items-center bg-surface-container px-3 py-1.5 rounded-lg border border-border w-64 md:w-80">
                <span class="material-symbols-outlined text-outline text-[18px] mr-2">search</span>
                <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" placeholder="Rechercher un produit..." class="bg-transparent border-none outline-none text-xs w-full text-on-surface placeholder:text-outline"/>
            </form>

            <div class="flex items-center gap-3">
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
    <footer class="bg-surface border-t border-border mt-auto pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-primary text-on-primary flex items-center justify-center font-bold text-xs">
                        <?= strtoupper(substr($shop_name ?? 'M', 0, 1)) ?>
                    </div>
                    <span class="font-headline font-bold text-base"><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?></span>
                </div>
                <p class="text-xs text-outline leading-relaxed">
                    Votre boutique en ligne avec service de commande WhatsApp direct et paiement à la livraison sécurisé.
                </p>
                <div class="flex items-center gap-1 text-xs text-emerald-600 font-medium">
                    <span class="material-symbols-outlined text-[16px]">verified</span> Boutique vérifiée
                </div>
            </div>

            <div>
                <h4 class="font-headline font-semibold text-xs uppercase tracking-wider mb-3 text-on-surface">Navigation</h4>
                <ul class="space-y-2 text-xs text-outline">
                    <li><a href="/" class="hover:text-primary transition">Accueil</a></li>
                    <li><a href="/catalogue" class="hover:text-primary transition">Tous les produits</a></li>
                    <li><a href="/panier" class="hover:text-primary transition">Mon panier d'achats</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-headline font-semibold text-xs uppercase tracking-wider mb-3 text-on-surface">Engagements</h4>
                <ul class="space-y-2 text-xs text-outline">
                    <li class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">local_shipping</span> Livraison rapide</li>
                    <li class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">payments</span> Paiement à réception</li>
                    <li class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">chat</span> Échange WhatsApp humain</li>
                </ul>
            </div>

            <div>
                <h4 class="font-headline font-semibold text-xs uppercase tracking-wider mb-3 text-on-surface">Thème Actif</h4>
                <div class="p-3 rounded-xl border border-border bg-surface-container-low text-xs">
                    <div class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getName()) ?></div>
                    <div class="text-[11px] text-outline mt-0.5"><?= htmlspecialchars($theme->getLayoutStyle()) ?></div>
                    <div class="flex gap-1.5 mt-2">
                        <?php foreach ($theme->getPrimaryColors() as $c): ?>
                            <span class="w-3.5 h-3.5 rounded-full border border-black/10" style="background-color: <?= htmlspecialchars($c) ?>"></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 pt-4 border-t border-border flex flex-col sm:flex-row items-center justify-between text-xs text-outline">
            <div>&copy; <?= date('Y') ?> <?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?>. Tous droits réservés.</div>
            <div class="mt-2 sm:mt-0">Propulsé par <strong class="text-on-surface">Marvens Shop MVP</strong></div>
        </div>
    </footer>
</body>
</html>
