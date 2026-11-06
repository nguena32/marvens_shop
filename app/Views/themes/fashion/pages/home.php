<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_standard" name="shell-type"/>
    <title><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?> — Prêt-à-porter, Mode & Accessoires</title>
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
                        "surface-tint": "#904d00",
                        "on-error": "#ffffff",
                        "outline-variant": "#dbc2b0",
                        "secondary-container": "#dae2fd",
                        "surface": "#fff8f5",
                        "surface-container-highest": "#f2dfd3",
                        "border": "#E2E8F0",
                        "secondary-fixed": "#dae2fd",
                        "on-primary-container": "#fffbff",
                        "background": "#F8FAFC",
                        "inverse-surface": "#392e26",
                        "primary-container": "#b15f00",
                        "surface-dim": "#e9d7cb",
                        "primary": "#8d4b00",
                        "on-primary": "#ffffff",
                        "surface-variant": "#f2dfd3",
                        "tertiary-container": "#007abd",
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed": "#001d32",
                        "on-primary-fixed-variant": "#6e3900",
                        "on-secondary-container": "#5c647a",
                        "on-surface-variant": "#554336",
                        "primary-fixed": "#ffdcc3",
                        "outline": "#887364",
                        "text": "#0F172A",
                        "surface-container-low": "#fff1e9",
                        "error-container": "#ffdad6",
                        "surface-bright": "#fff8f5",
                        "on-tertiary-container": "#fdfcff",
                        "on-primary-fixed": "#2f1500",
                        "surface-container-high": "#f7e5d9",
                        "secondary": "#565e74",
                        "primary-fixed-dim": "#ffb77d",
                        "on-secondary-fixed": "#131b2e",
                        "on-background": "#231a13",
                        "tertiary-fixed-dim": "#96ccff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "tertiary-fixed": "#cee5ff",
                        "tertiary": "#006096",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#ffb77d",
                        "surface-container": "#fdeade",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed-variant": "#004a75",
                        "on-surface": "#231a13",
                        "secondary-fixed-dim": "#bec6e0",
                        "inverse-on-surface": "#ffede3",
                        "surface-container-lowest": "#ffffff"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "space-xl": "3rem",
                        "margin": "2rem",
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "gutter": "1.5rem",
                        "space-md": "1rem",
                        "space-lg": "1.5rem"
                    },
                    fontFamily: {
                        "headline-sm": ["Space Grotesk"],
                        "label-md": ["Inter"],
                        "body-sm": ["Inter"],
                        "headline-lg": ["Space Grotesk"],
                        "headline-md": ["Space Grotesk"],
                        "label-sm": ["Inter"],
                        "headline-xl": ["Space Grotesk"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    fontSize: {
                        "headline-sm": ["18px", { "lineHeight": "24px", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "20px", "fontWeight": "500" }],
                        "body-sm": ["12px", { "lineHeight": "16px", "fontWeight": "400" }],
                        "headline-lg": ["36px", { "lineHeight": "44px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "headline-xl": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }]
                    }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background font-body-md text-text">
    
    <!-- En-tête Principal Marvens Shop -->
    <header class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-20 max-w-7xl mx-auto px-gutter flex items-center justify-between gap-space-lg">
            <a href="/" class="flex items-center gap-space-md text-decoration-none">
                <div class="h-9 w-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-lg tracking-wider">
                    M
                </div>
                <span class="text-headline-sm font-headline-sm text-text"><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?></span>
            </a>
            
            <nav class="hidden md:flex items-center gap-space-lg" data-active-classes="bg-primary-container text-on-primary-container font-bold rounded-lg">
                <a class="text-label-md text-on-surface font-semibold hover:text-primary transition-colors" data-path="home" href="/">Accueil</a>
                <a class="text-label-md text-on-surface-variant hover:text-on-surface transition-colors" data-path="catalog" href="/catalogue">Catalogue</a>
                <a class="text-label-md text-on-surface-variant hover:text-on-surface transition-colors" data-path="categories" href="/catalogue">Catégories</a>
                <a class="text-label-md text-on-surface-variant hover:text-on-surface transition-colors" data-path="about" href="/#about">À propos</a>
            </nav>

            <div class="flex items-center gap-space-md">
                <form action="/catalogue" method="GET" class="hidden lg:flex items-center bg-surface-container px-space-md py-space-xs rounded-xl border border-border">
                    <span class="material-symbols-outlined text-on-surface-variant text-[18px] mr-2">search</span>
                    <input name="q" class="bg-transparent text-label-md text-text outline-none w-48" placeholder="Rechercher articles..." type="text"/>
                </form>

                <a class="relative p-space-sm rounded-xl hover:bg-surface-container-high hover:text-on-surface text-on-surface-variant transition-colors" data-path="cart" href="/panier" title="Mon Panier">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span class="absolute top-0 right-0 bg-primary text-on-primary text-label-sm w-4 h-4 rounded-full flex items-center justify-center font-bold">
                        <?= (int) ($cart_count ?? 0) ?>
                    </span>
                </a>

                <a class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-space-md py-space-sm rounded-xl text-label-md transition-colors" data-path="whatsapp-chat" href="https://wa.me/?text=Bonjour%20Marvens%20Shop,%20je%20souhaite%20des%20renseignements." target="_blank">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span class="hidden sm:inline">WhatsApp</span>
                </a>

                <a href="/admin/login" class="w-8 h-8 rounded-full bg-surface-container border border-border flex items-center justify-center text-on-surface hover:bg-surface-container-high transition-colors" title="Espace Administrateur">
                    <span class="material-symbols-outlined text-[18px]">person</span>
                </a>
            </div>
        </div>
    </header>

    <main class="w-full pt-20 bg-background">
        <div class="flex flex-col w-full">
            <div class="max-w-7xl mx-auto px-gutter py-space-lg w-full flex flex-col gap-space-xl">
                
                <!-- Top Hero Section avec Sidebar Catégories & Bannière Promotionnelle -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-space-lg items-stretch">
                    <!-- Left Sidebar: Catégories -->
                    <div class="hidden lg:flex flex-col bg-surface rounded-xl p-space-md shadow-sm justify-between border border-border">
                        <div class="flex flex-col gap-space-xs">
                            <div class="text-label-md font-headline-sm px-space-sm py-space-xs text-on-surface-variant flex items-center justify-between mb-space-xs">
                                <span>Catégories</span>
                                <span class="material-symbols-outlined text-[18px]">menu</span>
                            </div>
                            
                            <a class="flex items-center justify-between px-space-sm py-space-sm rounded-lg bg-primary-container text-on-primary-container font-medium text-label-md transition-colors" href="/catalogue">
                                <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">storefront</span> Tout le catalogue</span>
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </a>

                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <a class="flex items-center justify-between px-space-sm py-space-sm rounded-lg hover:bg-surface-container text-on-surface-variant text-label-md transition-colors" href="/catalogue?cat=<?= (int)$cat['id'] ?>">
                                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">checkroom</span> <?= htmlspecialchars($cat['name']) ?></span>
                                        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <a class="flex items-center justify-between px-space-sm py-space-sm rounded-lg hover:bg-surface-container text-on-surface-variant text-label-md transition-colors" href="/catalogue">
                                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">diamond</span> Robes de Soirée</span>
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </a>
                                <a class="flex items-center justify-between px-space-sm py-space-sm rounded-lg hover:bg-surface-container text-on-surface-variant text-label-md transition-colors" href="/catalogue">
                                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">styler</span> Ensembles &amp; Tailleurs</span>
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </a>
                                <a class="flex items-center justify-between px-space-sm py-space-sm rounded-lg hover:bg-surface-container text-on-surface-variant text-label-md transition-colors" href="/catalogue">
                                    <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">flash_auto</span> Sacs &amp; Maroquinerie</span>
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="bg-surface-container p-space-md rounded-xl mt-space-md">
                            <div class="text-label-md font-headline-sm text-primary mb-1">Service WhatsApp</div>
                            <p class="text-body-sm text-on-surface-variant mb-space-sm">Commandez directement pour un conseil personnalisé et confirmation immédiate.</p>
                            <a class="flex items-center justify-center gap-2 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-space-sm rounded-lg text-label-md transition-colors" href="https://wa.me/?text=Bonjour,%20je%20souhaite%20un%20conseil%20pour%20une%20commande." target="_blank">
                                <span class="material-symbols-outlined text-[18px]">chat</span> Discuter sur WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Right Banner: Hero Showcase -->
                    <div class="lg:col-span-3 relative rounded-2xl overflow-hidden bg-gradient-to-r from-surface-container-highest to-surface-container p-space-xl flex flex-col justify-center min-h-[420px]">
                        <div class="absolute inset-0 z-0 opacity-20 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1200')"></div>
                        <div class="relative z-10 max-w-lg flex flex-col items-start gap-space-md">
                            <span class="bg-primary-container text-on-primary-container px-space-md py-space-xs rounded-full text-label-sm font-bold uppercase tracking-wider">Collection Exclusive</span>
                            <h1 class="text-headline-xl text-on-surface font-headline-xl">Élégance &amp; Style au Féminin</h1>
                            <p class="text-body-lg text-on-surface-variant">Découvrez les dernières tendances de prêt-à-porter féminin, tenues élégantes et accessoires de qualité disponibles immédiatement au Cameroun.</p>
                            <div class="flex items-center gap-space-md mt-space-sm">
                                <a class="bg-primary hover:bg-primary/90 text-on-primary px-space-xl py-space-md rounded-xl text-label-md font-bold transition-transform hover:scale-105 shadow-md flex items-center gap-2" href="#catalog">
                                    <span>Découvrir la Boutique</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                                <a class="bg-surface hover:bg-surface-bright text-on-surface border border-border px-space-xl py-space-md rounded-xl text-label-md font-medium transition-colors flex items-center gap-2" href="https://wa.me/?text=Bonjour,%20je%20souhaite%20passer%20une%20commande%20rapide." target="_blank">
                                    <span class="material-symbols-outlined text-[18px] text-emerald-600">chat</span> Commande Rapide
                                </a>
                            </div>
                        </div>
                        <div class="absolute right-0 bottom-0 top-0 w-1/2 hidden md:block pointer-events-none">
                            <div class="w-full h-full bg-cover bg-right-top" style="background-image: url('https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800')"></div>
                        </div>
                    </div>
                </div>

                <!-- Category Circular Carousel / Grid -->
                <div class="flex flex-col gap-space-md">
                    <div class="flex items-center justify-between">
                        <h2 class="text-headline-md font-headline-md text-on-surface">Explorez par Catégorie</h2>
                        <span class="text-body-sm text-on-surface-variant">Collections soigneusement sélectionnées</span>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-space-md">
                        <?php 
                            $defaultCatImages = [
                                'Robes' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=200',
                                'Tailleurs' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=200',
                                'Sacs' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=200',
                                'Bijoux' => 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=200',
                                'Chaussures' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=200',
                                'Accessoires' => 'https://images.unsplash.com/photo-1606760227091-3dd870d97f1d?w=200',
                                'Chic' => 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?w=200',
                                'Homewear' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=200',
                            ];
                        ?>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $idx => $cat): ?>
                                <a class="flex flex-col items-center gap-space-sm group" href="/catalogue?cat=<?= (int)$cat['id'] ?>">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-surface-container overflow-hidden border border-border flex items-center justify-center group-hover:border-primary transition-all">
                                        <div class="w-full h-full bg-cover bg-center group-hover:scale-110 transition-transform duration-300" style="background-image: url('<?= htmlspecialchars($cat['image_url'] ?? array_values($defaultCatImages)[$idx % count($defaultCatImages)]) ?>')"></div>
                                    </div>
                                    <span class="text-label-md text-on-surface group-hover:text-primary transition-colors text-center"><?= htmlspecialchars($cat['name']) ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php foreach ($defaultCatImages as $name => $img): ?>
                                <a class="flex flex-col items-center gap-space-sm group" href="/catalogue">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-surface-container overflow-hidden border border-border flex items-center justify-center group-hover:border-primary transition-all">
                                        <div class="w-full h-full bg-cover bg-center group-hover:scale-110 transition-transform duration-300" style="background-image: url('<?= $img ?>')"></div>
                                    </div>
                                    <span class="text-label-md text-on-surface group-hover:text-primary transition-colors text-center"><?= $name ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Trending Products Section with XAF Pricing -->
                <div class="flex flex-col gap-space-md pt-space-md" id="catalog">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-space-sm">
                            <span class="material-symbols-outlined text-primary text-[24px]">local_fire_department</span>
                            <h2 class="text-headline-md font-headline-md text-on-surface">Tendance Actuelle</h2>
                        </div>
                        <a class="text-label-md text-primary font-bold hover:underline flex items-center gap-1" href="/catalogue">
                            Tout voir <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-lg">
                        <?php if (empty($products)): ?>
                            <p class="col-span-full py-space-xl text-center text-on-surface-variant bg-surface rounded-2xl border border-border">
                                Aucun produit n'est publié pour le moment.
                            </p>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                                <div class="bg-surface rounded-2xl p-space-md shadow-sm flex flex-col justify-between group border border-border hover:shadow-md transition-shadow">
                                    <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" class="block">
                                        <div class="relative w-full h-64 rounded-xl overflow-hidden bg-surface-container mb-space-md">
                                            <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-300" style="background-image: url('<?= htmlspecialchars(!empty($p['main_image_url']) ? '/' . ltrim($p['main_image_url'], '/') : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600') ?>')"></div>
                                            <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-surface/90 backdrop-blur-sm flex items-center justify-center text-on-surface hover:text-primary shadow-sm transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                                            </button>
                                            <?php if (!empty($p['promotional_price'])): ?>
                                                <span class="absolute bottom-3 left-3 bg-red-600 text-white px-space-sm py-1 rounded-md text-body-sm font-semibold shadow-sm">Promo</span>
                                            <?php elseif (!empty($p['is_featured'])): ?>
                                                <span class="absolute bottom-3 left-3 bg-surface-container-highest/90 backdrop-blur-sm px-space-sm py-1 rounded-md text-body-sm font-medium text-on-surface">Populaire</span>
                                            <?php endif; ?>
                                        </div>
                                    </a>

                                    <div class="flex flex-col gap-space-xs">
                                        <div class="flex items-center justify-between text-body-sm text-on-surface-variant">
                                            <span><?= htmlspecialchars($p['category_name'] ?? 'Collection') ?></span>
                                            <div class="flex items-center gap-1 text-amber-600"><span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span> 4.9</div>
                                        </div>
                                        <h3 class="text-headline-sm font-headline-sm text-on-surface truncate">
                                            <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" class="hover:text-primary transition-colors">
                                                <?= htmlspecialchars($p['name']) ?>
                                            </a>
                                        </h3>
                                        <div class="flex items-center justify-between mt-space-sm">
                                            <div class="flex flex-col">
                                                <?php if (!empty($p['promotional_price'])): ?>
                                                    <span class="text-headline-sm font-headline-sm text-red-600"><?= number_format((float)$p['promotional_price'], 0, ',', ' ') ?> FCFA</span>
                                                    <span class="text-body-sm text-on-surface-variant line-through"><?= number_format((float)$p['price'], 0, ',', ' ') ?> FCFA</span>
                                                <?php else: ?>
                                                    <span class="text-headline-sm font-headline-sm text-primary"><?= number_format((float)$p['price'], 0, ',', ' ') ?> FCFA</span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <form action="/panier/ajouter" method="POST">
                                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                    <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary p-space-sm rounded-xl flex items-center justify-center transition-colors shadow-sm" title="Ajouter au panier">
                                                        <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                                    </button>
                                                </form>

                                                <?php 
                                                    $directWaText = urlencode("Bonjour, je souhaite commander l'article *" . $p['name'] . "* au prix de " . number_format((float)($p['promotional_price'] ?? $p['price']), 0, ',', ' ') . " FCFA.");
                                                    $directWaUrl = "https://wa.me/?text=" . $directWaText;
                                                ?>
                                                <a class="bg-emerald-600 hover:bg-emerald-700 text-white p-space-sm rounded-xl flex items-center justify-center transition-colors shadow-sm" href="<?= $directWaUrl ?>" target="_blank" title="Commander sur WhatsApp">
                                                    <span class="material-symbols-outlined text-[20px]">chat</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Promotional Dual Banners (Summer Sale & New Arrivals) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <!-- Promo 1 -->
                    <div class="relative rounded-2xl overflow-hidden bg-surface-container-high p-space-xl flex flex-col justify-between min-h-[280px] border border-border">
                        <div class="absolute inset-0 z-0 opacity-15 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800')"></div>
                        <div class="relative z-10 max-w-xs flex flex-col items-start gap-space-sm">
                            <span class="text-label-sm font-bold uppercase tracking-wider text-primary">Offres Spéciales</span>
                            <h3 class="text-headline-md font-headline-md text-on-surface">Jusqu'à -30% sur nos Bestsellers</h3>
                            <p class="text-body-md text-on-surface-variant">Profitez de réductions exclusives sur notre sélection de sacs, robes et accessoires tendances.</p>
                            <a class="mt-space-sm bg-primary hover:bg-primary/90 text-on-primary px-space-lg py-space-sm rounded-xl text-label-md font-medium transition-colors shadow-sm" href="/catalogue">
                                Voir les Soldes
                            </a>
                        </div>
                    </div>

                    <!-- Promo 2 -->
                    <div class="relative rounded-2xl overflow-hidden bg-surface-container-highest p-space-xl flex flex-col justify-between min-h-[280px] border border-border">
                        <div class="absolute inset-0 z-0 opacity-15 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1529139574466-a303027c1d8b?w=800')"></div>
                        <div class="relative z-10 max-w-xs flex flex-col items-start gap-space-sm">
                            <span class="text-label-sm font-bold uppercase tracking-wider text-primary">Nouveautés</span>
                            <h3 class="text-headline-md font-headline-md text-on-surface">Les Coups de Cœur Marvens</h3>
                            <p class="text-body-md text-on-surface-variant">Des pièces sélectionnées avec soin pour sublimer votre style au quotidien.</p>
                            <a class="mt-space-sm bg-surface hover:bg-surface-bright text-on-surface border border-border px-space-lg py-space-sm rounded-xl text-label-md font-medium transition-colors shadow-sm" href="/catalogue">
                                Explorer
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Features bar inspired by reference footer badges -->
                <div class="bg-surface rounded-2xl p-space-lg grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-lg shadow-sm mb-space-xl border border-border">
                    <div class="flex items-center gap-space-md">
                        <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">local_shipping</span>
                        </div>
                        <div>
                            <h4 class="text-label-md font-headline-sm text-on-surface">Livraison Rapide</h4>
                            <p class="text-body-sm text-on-surface-variant">À Douala, Yaoundé &amp; partout au Cameroun</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-space-md">
                        <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">published_with_changes</span>
                        </div>
                        <div>
                            <h4 class="text-label-md font-headline-sm text-on-surface">Retours Faciles</h4>
                            <p class="text-body-sm text-on-surface-variant">Échanges rapides sous 7 jours</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-space-md">
                        <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">verified</span>
                        </div>
                        <div>
                            <h4 class="text-label-md font-headline-sm text-on-surface">Paiement à la Livraison</h4>
                            <p class="text-body-sm text-on-surface-variant">OM, MoMo ou espèces en main propre</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-space-md">
                        <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">support_agent</span>
                        </div>
                        <div>
                            <h4 class="text-label-md font-headline-sm text-on-surface">Assistance WhatsApp</h4>
                            <p class="text-body-sm text-on-surface-variant">Support et suivi instantané</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="w-full bg-surface-container-low py-space-xl border-t border-border">
        <div class="max-w-7xl mx-auto px-gutter flex flex-col md:flex-row justify-between items-center gap-space-md text-on-surface-variant text-body-sm">
            <div>© <?= date('Y') ?> <?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?>. Tous droits réservés.</div>
            <div class="flex gap-space-lg">
                <a class="hover:text-on-surface transition-colors" href="/catalogue">Catalogue</a>
                <a class="hover:text-on-surface transition-colors" href="/panier">Mon Panier</a>
                <a class="hover:text-on-surface transition-colors" href="/admin/login">Administration</a>
            </div>
        </div>
    </footer>
</body>
</html>
