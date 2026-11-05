<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_dashboard" name="shell-type"/>
    <title>Administration — Tableau de Bord Marvens Shop</title>
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
            main > :first-child { margin-top:0!important; }
            main > :last-child { margin-bottom:0!important; }
        }
        ::-webkit-scrollbar { display:none; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#fe932c",
                        "tertiary": "#000000",
                        "surface-container-low": "#f6f3f5",
                        "primary": "#000000",
                        "outline": "#76777d",
                        "inverse-surface": "#303032",
                        "tertiary-container": "#271901",
                        "on-error-container": "#93000a",
                        "on-background": "#1b1b1d",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed-variant": "#574425",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#663500",
                        "surface-container": "#f0edef",
                        "on-surface": "#1b1b1d",
                        "secondary": "#904d00",
                        "on-tertiary-fixed": "#271901",
                        "outline-variant": "#c6c6cd",
                        "surface-container-highest": "#e4e2e4",
                        "tertiary-fixed": "#fcdeb5",
                        "on-primary-fixed-variant": "#3f465c",
                        "surface-container-high": "#eae7e9",
                        "secondary-fixed-dim": "#ffb77d",
                        "inverse-on-surface": "#f3f0f2",
                        "surface-tint": "#565e74",
                        "surface-variant": "#e4e2e4",
                        "primary-fixed": "#dae2fd",
                        "surface": "#FFFFFF",
                        "on-tertiary-container": "#98805d",
                        "primary-fixed-dim": "#bec6e0",
                        "secondary-fixed": "#ffdcc3",
                        "on-surface-variant": "#45464d",
                        "on-tertiary": "#ffffff",
                        "surface-bright": "#fcf8fa",
                        "background": "#F8FAFC",
                        "surface-dim": "#dcd9db",
                        "border": "#E2E8F0",
                        "on-error": "#ffffff",
                        "on-primary-container": "#7c839b",
                        "error": "#ba1a1a",
                        "inverse-primary": "#bec6e0",
                        "primary-container": "#131b2e",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed": "#2f1500",
                        "tertiary-fixed-dim": "#dec29a",
                        "surface-container-lowest": "#ffffff"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "space-sm": "8px",
                        "space-lg": "24px",
                        "space-xs": "4px",
                        "margin": "32px",
                        "space-xl": "48px",
                        "space-md": "16px",
                        "gutter": "24px"
                    },
                    fontFamily: {
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-sm": ["Inter"],
                        "headline-xl": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-sm": ["Inter"]
                    },
                    fontSize: {
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-lg": ["36px", { "lineHeight": "44px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-sm": ["12px", { "lineHeight": "16px", "fontWeight": "400" }],
                        "headline-xl": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-md": ["14px", { "lineHeight": "20px", "fontWeight": "500" }],
                        "headline-sm": ["18px", { "lineHeight": "24px", "fontWeight": "600" }]
                    }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background font-body-md text-on-surface">
    <!-- Aside Sidebar conforme au design Swiss Editorial Commerce -->
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface border-r border-border z-50 flex flex-col pt-space-lg pb-space-lg">
        <div class="px-space-lg mb-space-lg flex items-center gap-space-sm">
            <div class="h-9 w-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-lg tracking-wider">
                M
            </div>
            <span class="font-headline-md text-on-surface tracking-tight">Marvens Shop</span>
        </div>
        <nav class="flex-1 px-space-md space-y-space-xs" data-active-classes="bg-secondary-container text-on-secondary-container font-medium rounded-xl">
            <a class="flex items-center px-space-md py-space-sm rounded-xl bg-secondary-container text-on-secondary-container font-medium transition-all" data-path="tableau-de-bord" href="/admin/dashboard">
                <span class="material-symbols-outlined mr-space-md">dashboard</span>Tableau de bord
            </a>
            <a class="flex items-center px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="catalogue" href="/admin/produits">
                <span class="material-symbols-outlined mr-space-md">inventory_2</span>Catalogue
            </a>
            <a class="flex items-center px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="commandes" href="/admin/commandes">
                <span class="material-symbols-outlined mr-space-md">shopping_bag</span>Commandes
                <?php if (($pending_orders ?? 0) > 0): ?>
                    <span class="ml-auto text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded-full"><?= (int) $pending_orders ?></span>
                <?php endif; ?>
            </a>
            <a class="flex items-center px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="import" href="/admin/import">
                <span class="material-symbols-outlined mr-space-md">cloud_download</span>Importations
            </a>
            <a class="flex items-center px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all" data-path="themes" href="/admin/themes">
                <span class="material-symbols-outlined mr-space-md">palette</span>Thèmes & Apparence
            </a>
        </nav>
        
        <div class="px-space-md mb-space-md">
            <form method="POST" action="/admin/logout">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <button type="submit" class="w-full flex items-center px-space-md py-space-sm rounded-xl text-error hover:bg-error-container hover:text-on-error-container transition-all text-label-md font-medium">
                    <span class="material-symbols-outlined mr-space-md">logout</span>Déconnexion
                </button>
            </form>
        </div>

        <div class="px-space-lg pt-space-md border-t border-border flex items-center justify-between">
            <div class="flex items-center gap-space-sm">
                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-label-sm text-on-surface-variant">Boutique Ouverte</span>
            </div>
            <a href="/" target="_blank" class="text-xs text-outline hover:text-on-surface flex items-center gap-1" title="Voir la boutique en ligne">
                <span class="material-symbols-outlined text-[16px]">visibility</span>
            </a>
        </div>
    </aside>

    <div class="pl-72">
        <!-- Header Supérieur -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-surface/80 backdrop-blur-xl border-b border-border z-40 flex items-center justify-between px-space-lg">
            <div class="flex items-center gap-space-md w-96">
                <span class="material-symbols-outlined text-outline">search</span>
                <input class="w-full bg-transparent text-body-md text-on-surface placeholder:text-outline focus:outline-none" placeholder="Rechercher commandes, clients, produits..." type="text"/>
            </div>
            <div class="flex items-center gap-space-md">
                <a href="/admin/commandes?status=pending" class="relative p-space-xs text-on-surface-variant hover:text-on-surface" title="Commandes en attente">
                    <span class="material-symbols-outlined">notifications</span>
                    <?php if (($pending_orders ?? 0) > 0): ?>
                        <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-secondary"></span>
                    <?php endif; ?>
                </a>
                <a href="/admin/produits/nouveau" class="bg-primary text-on-primary px-space-md py-1.5 rounded-lg text-label-sm font-medium hover:bg-surface-container-high hover:text-on-surface transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">add</span> Nouveau Produit
                </a>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center cursor-pointer" title="Administrateur">
                    <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                </div>
            </div>
        </header>

        <main class="relative pt-16 bg-background min-h-screen">
            <div class="flex flex-col w-full p-space-lg space-y-space-xl">
                
                <!-- Section 1: Real-time Pilot Header (4 Cards) -->
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    <!-- Card 1: Daily Revenue -->
                    <div class="bg-surface rounded-lg p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm text-outline uppercase tracking-wider">Chiffre d'affaires</span>
                            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">payments</span>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-headline-lg text-on-surface"><?= number_format($total_revenue ?? 0, 0, ',', ' ') ?> FCFA</h3>
                            <span class="text-body-sm text-emerald-600 flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[16px]">trending_up</span> Envois & ventes confirmées
                            </span>
                        </div>
                        <div class="w-full bg-surface-container h-1 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full w-[75%]"></div>
                        </div>
                    </div>

                    <!-- Card 2: Pending WhatsApp Orders -->
                    <div class="bg-surface rounded-lg p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm text-outline uppercase tracking-wider">Validation WhatsApp</span>
                            <span class="material-symbols-outlined text-[#25D366]" style="font-variation-settings: 'FILL' 1;">chat</span>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-headline-lg text-on-surface"><?= (int) ($pending_orders ?? 0) ?></h3>
                            <span class="text-body-sm text-outline mt-1 block">En attente de confirmation client</span>
                        </div>
                        <a href="/admin/commandes?status=pending" class="flex items-center justify-between text-label-sm hover:underline">
                            <span class="text-secondary font-medium">Action requise</span>
                            <span class="material-symbols-outlined text-sm text-outline">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Card 3: Conversion Rate Yaoundé / Actifs -->
                    <div class="bg-surface rounded-lg p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm text-outline uppercase tracking-wider">Catalogue Actif</span>
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">location_on</span>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-headline-lg text-on-surface"><?= (int) ($total_products ?? 0) ?> ref</h3>
                            <span class="text-body-sm text-emerald-600 flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span> Produits publiés en ligne
                            </span>
                        </div>
                        <div class="w-full bg-surface-container h-1 rounded-full overflow-hidden">
                            <div class="bg-primary h-full w-[85%]"></div>
                        </div>
                    </div>

                    <!-- Card 4: Meta API Sync -->
                    <div class="bg-surface rounded-lg p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-label-sm text-outline uppercase tracking-wider">Meta API Sync</span>
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-headline-sm text-on-surface">Connecté &amp; Actif</h3>
                            <span class="text-body-sm text-outline mt-1 block">Passerelle Catalogue & WA</span>
                        </div>
                        <div class="flex items-center justify-between text-label-sm text-outline">
                            <span>Catalog ID: #98421</span>
                            <a href="/admin/import" class="hover:text-on-surface"><span class="material-symbols-outlined text-sm">sync</span></a>
                        </div>
                    </div>
                </section>

                <!-- Section 2: Quick Management & Shortcuts (Meta & WhatsApp Gateway) -->
                <section class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
                    <!-- Meta / Instagram Shopping Import -->
                    <div class="bg-surface rounded-lg p-space-lg border border-border flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-secondary text-2xl">storefront</span>
                                    <h4 class="text-headline-sm text-on-surface">Catalogue Meta / Instagram</h4>
                                </div>
                                <span class="text-label-sm bg-primary-fixed text-on-primary-fixed px-space-sm py-1 rounded-full">Auto-sync</span>
                            </div>
                            <p class="text-body-md text-outline mb-space-lg">
                                Synchronisez instantanément vos nouveautés depuis votre gestionnaire de commerce Facebook et Instagram Shopping ou importez via fichier CSV.
                            </p>
                        </div>
                        <div class="flex items-center gap-space-md">
                            <a href="/admin/import" class="bg-[#D97706] text-on-primary px-space-md py-2.5 rounded-lg text-label-md font-medium hover:bg-[#b45309] transition-all flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px]">cloud_download</span> Importer le catalogue
                            </a>
                            <a href="/admin/produits" class="border border-border text-on-surface px-space-md py-2.5 rounded-lg text-label-md font-medium hover:bg-surface-container-low transition-all">
                                Configurer les règles
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp Direct Gateway -->
                    <div class="bg-surface rounded-lg p-space-lg border border-border flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-space-md">
                                <div class="flex items-center gap-space-sm">
                                    <span class="material-symbols-outlined text-[#25D366] text-2xl">forum</span>
                                    <h4 class="text-headline-sm text-on-surface">Passerelle WhatsApp Direct</h4>
                                </div>
                                <span class="text-label-sm bg-emerald-100 text-emerald-800 px-space-sm py-1 rounded-full">En ligne</span>
                            </div>
                            <p class="text-body-md text-outline mb-space-lg">
                                Suivez les commandes en temps réel, relancez les clients et envoyez des récapitulatifs instantanés directement via WhatsApp.
                            </p>
                        </div>
                        <div class="flex items-center gap-space-md">
                            <a href="/admin/commandes" class="bg-surface-container-high text-on-surface px-space-md py-2.5 rounded-lg text-label-md font-medium hover:bg-surface-container-highest transition-all flex items-center gap-space-sm">
                                <span class="material-symbols-outlined text-[18px]">settings</span> Paramètres WhatsApp
                            </a>
                            <a href="/admin/commandes" class="border border-border text-on-surface px-space-md py-2.5 rounded-lg text-label-md font-medium hover:bg-surface-container-low transition-all">
                                Modèles de messages
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Critical Stock Management -->
                <section class="bg-surface rounded-lg p-space-lg border border-border">
                    <div class="flex items-center justify-between mb-space-lg">
                        <div>
                            <h3 class="text-headline-md text-on-surface">Gestion des stocks critiques</h3>
                            <p class="text-body-sm text-outline">Articles nécessitant un réapprovisionnement urgent pour la zone CEMAC</p>
                        </div>
                        <a href="/admin/produits" class="text-secondary text-label-md font-medium hover:underline flex items-center gap-1">
                            Voir tout le stock <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                        <?php if (!empty($low_stock_items)): ?>
                            <?php foreach ($low_stock_items as $item): ?>
                                <div class="bg-surface-container-low p-space-md rounded-lg border border-border flex items-center gap-space-md">
                                    <div class="w-16 h-16 rounded bg-cover bg-center shrink-0 bg-surface-container" style="background-image: url('<?= htmlspecialchars($item['main_image_url'] ?? 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200') ?>')"></div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-label-md text-on-surface truncate"><?= htmlspecialchars($item['product_name']) ?></h5>
                                        <span class="text-body-sm text-error font-medium">
                                            <?= (int)$item['stock_quantity'] <= 1 ? 'Rupture imminente (' . (int)$item['stock_quantity'] . ')' : 'Restent ' . (int)$item['stock_quantity'] . ' unités' ?>
                                        </span>
                                        <div class="w-full bg-surface-container h-1.5 rounded-full mt-2 overflow-hidden">
                                            <div class="bg-error h-full" style="width: <?= min(100, (int)$item['stock_quantity'] * 20) ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Stock Item 1 -->
                            <div class="bg-surface-container-low p-space-md rounded-lg border border-border flex items-center gap-space-md">
                                <div class="w-16 h-16 rounded bg-cover bg-center shrink-0" style="background-image: url('https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=200')"></div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-label-md text-on-surface truncate">Sneakers Urbaines Marvens</h5>
                                    <span class="text-body-sm text-error font-medium">Restent 3 paires</span>
                                    <div class="w-full bg-surface-container h-1.5 rounded-full mt-2 overflow-hidden">
                                        <div class="bg-error h-full w-[15%]"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Stock Item 2 -->
                            <div class="bg-surface-container-low p-space-md rounded-lg border border-border flex items-center gap-space-md">
                                <div class="w-16 h-16 rounded bg-cover bg-center shrink-0" style="background-image: url('https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=200')"></div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-label-md text-on-surface truncate">Sac Cuir Minimaliste</h5>
                                    <span class="text-body-sm text-amber-600 font-medium">Restent 5 unités</span>
                                    <div class="w-full bg-surface-container h-1.5 rounded-full mt-2 overflow-hidden">
                                        <div class="bg-amber-500 h-full w-[25%]"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Stock Item 3 -->
                            <div class="bg-surface-container-low p-space-md rounded-lg border border-border flex items-center gap-space-md">
                                <div class="w-16 h-16 rounded bg-cover bg-center shrink-0" style="background-image: url('https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=200')"></div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-label-md text-on-surface truncate">Montre Chrono Édition Or</h5>
                                    <span class="text-body-sm text-error font-medium">Rupture imminente (1)</span>
                                    <div class="w-full bg-surface-container h-1.5 rounded-full mt-2 overflow-hidden">
                                        <div class="bg-error h-full w-[5%]"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Section 4: Interactive Recent Orders Table -->
                <section class="bg-surface rounded-lg border border-border overflow-hidden">
                    <div class="p-space-lg border-b border-border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md">
                        <div>
                            <h3 class="text-headline-md text-on-surface">Commandes Récentes</h3>
                            <p class="text-body-sm text-outline">Suivi en temps réel des flux clients et interactions WhatsApp</p>
                        </div>
                        
                        <!-- Status Filters -->
                        <div class="flex items-center gap-space-xs bg-surface-container-low p-1 rounded-lg border border-border text-label-sm">
                            <a href="/admin/dashboard" class="px-space-md py-1.5 rounded <?= empty($current_filter) ? 'bg-surface text-on-surface font-medium shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Tous</a>
                            <a href="/admin/dashboard?status=pending" class="px-space-md py-1.5 rounded <?= ($current_filter === 'pending') ? 'bg-surface text-on-surface font-medium shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">En attente</a>
                            <a href="/admin/dashboard?status=confirmed" class="px-space-md py-1.5 rounded <?= ($current_filter === 'confirmed') ? 'bg-surface text-on-surface font-medium shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Confirmé WA</a>
                            <a href="/admin/dashboard?status=shipped" class="px-space-md py-1.5 rounded <?= ($current_filter === 'shipped') ? 'bg-surface text-on-surface font-medium shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Expédié</a>
                            <a href="/admin/dashboard?status=delivered" class="px-space-md py-1.5 rounded <?= ($current_filter === 'delivered') ? 'bg-surface text-on-surface font-medium shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Livré</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low text-label-sm text-outline border-b border-border">
                                    <th class="py-space-md px-space-lg font-medium">Commande</th>
                                    <th class="py-space-md px-space-lg font-medium">Client</th>
                                    <th class="py-space-md px-space-lg font-medium">Localisation</th>
                                    <th class="py-space-md px-space-lg font-medium">Montant</th>
                                    <th class="py-space-md px-space-lg font-medium">Statut</th>
                                    <th class="py-space-md px-space-lg font-medium text-right">Action WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border text-body-md text-on-surface">
                                <?php if (empty($recent_orders)): ?>
                                    <tr>
                                        <td colspan="6" class="py-space-xl px-space-lg text-center text-outline">
                                            Aucune commande ne correspond aux critères sélectionnés.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recent_orders as $ord): ?>
                                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                                            <td class="py-space-md px-space-lg font-medium">
                                                <a href="/admin/commandes/<?= (int) $ord['id'] ?>" class="hover:underline">
                                                    #<?= htmlspecialchars($ord['order_number']) ?>
                                                </a>
                                            </td>
                                            <td class="py-space-md px-space-lg">
                                                <div class="font-medium"><?= htmlspecialchars($ord['customer_name']) ?></div>
                                                <span class="text-body-sm text-outline"><?= htmlspecialchars($ord['customer_whatsapp']) ?></span>
                                            </td>
                                            <td class="py-space-md px-space-lg">
                                                <?= htmlspecialchars(($ord['delivery_city'] ?? 'Yaoundé') . (!empty($ord['delivery_district']) ? ' (' . $ord['delivery_district'] . ')' : '')) ?>
                                            </td>
                                            <td class="py-space-md px-space-lg font-medium">
                                                <?= number_format((float) $ord['total_amount'], 0, ',', ' ') ?> FCFA
                                            </td>
                                            <td class="py-space-md px-space-lg">
                                                <?php
                                                    $statusBadge = match($ord['order_status']) {
                                                        'pending' => 'bg-amber-100 text-amber-800',
                                                        'confirmed' => 'bg-blue-100 text-blue-800',
                                                        'shipped' => 'bg-purple-100 text-purple-800',
                                                        'delivered' => 'bg-emerald-100 text-emerald-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                    $statusLabel = match($ord['order_status']) {
                                                        'pending' => 'En attente',
                                                        'confirmed' => 'Confirmé WhatsApp',
                                                        'shipped' => 'Expédié',
                                                        'delivered' => 'Livré',
                                                        'cancelled' => 'Annulé',
                                                        default => htmlspecialchars($ord['order_status']),
                                                    };
                                                ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-label-sm <?= $statusBadge ?>">
                                                    <?= $statusLabel ?>
                                                </span>
                                            </td>
                                            <td class="py-space-md px-space-lg text-right">
                                                <?php 
                                                    $cleanPhone = preg_replace('/[^0-9]/', '', (string)$ord['customer_whatsapp']);
                                                    $waMsg = urlencode("Bonjour " . $ord['customer_name'] . ", nous faisons le suivi de votre commande #" . $ord['order_number'] . " sur Marvens Shop.");
                                                    $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . $waMsg;
                                                ?>
                                                <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-1 bg-[#25D366]/10 text-[#25D366] px-space-md py-1.5 rounded-lg text-label-sm font-medium hover:bg-[#25D366]/20 transition-all">
                                                    <span class="material-symbols-outlined text-[16px]">chat</span> 
                                                    <?= $ord['order_status'] === 'pending' ? 'Relancer WA' : 'Ouvrir chat' ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer / Pagination -->
                    <div class="p-space-md border-t border-border flex items-center justify-between text-body-sm text-outline">
                        <span>Affichage de <?= count($recent_orders) ?> sur <?= (int) ($total_orders ?? 0) ?> commandes</span>
                        <div class="flex items-center gap-space-xs">
                            <a href="/admin/commandes" class="px-space-md py-1.5 rounded border border-border bg-surface text-on-surface hover:bg-surface-container-low font-medium">
                                Consulter toutes les commandes &rarr;
                            </a>
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>
</body>
</html>
