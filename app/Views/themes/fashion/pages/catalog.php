<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Catalogue Complet — Marvens Shop</title>
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
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
                        "primary": "#8d4b00",
                        "primary-container": "#b15f00",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#fffbff",
                        "surface": "#fff8f5",
                        "surface-container": "#fdeade",
                        "surface-container-high": "#f7e5d9",
                        "surface-container-highest": "#f2dfd3",
                        "surface-container-low": "#fff1e9",
                        "background": "#F8FAFC",
                        "border": "#E2E8F0",
                        "text": "#0F172A",
                        "on-surface": "#231a13",
                        "on-surface-variant": "#554336"
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                    spacing: { "space-xl": "3rem", "margin": "2rem", "space-xs": "0.25rem", "space-sm": "0.5rem", "gutter": "1.5rem", "space-md": "1rem", "space-lg": "1.5rem" },
                    fontFamily: {
                        "headline-sm": ["Space Grotesk"],
                        "headline-md": ["Space Grotesk"],
                        "headline-lg": ["Space Grotesk"],
                        "headline-xl": ["Space Grotesk"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"]
                    }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
</head>
<body class="bg-background font-body-md text-text">
    <header class="fixed top-0 w-full z-50 bg-surface/80 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
        <div class="h-20 max-w-7xl mx-auto px-gutter flex items-center justify-between gap-space-lg">
            <a href="/" class="flex items-center gap-space-md text-decoration-none">
                <div class="h-9 w-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-lg">M</div>
                <span class="text-headline-sm font-headline-sm text-text">Marvens Shop</span>
            </a>
            <div class="flex items-center gap-space-md">
                <a href="/panier" class="relative p-space-sm rounded-xl hover:bg-surface-container-high text-on-surface-variant flex items-center gap-2">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span class="text-label-md font-semibold">Panier (<?= (int) ($cart_count ?? 0) ?>)</span>
                </a>
            </div>
        </div>
    </header>

    <main class="w-full pt-28 pb-space-xl min-h-screen">
        <div class="max-w-7xl mx-auto px-gutter flex flex-col gap-space-lg">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                <div>
                    <h1 class="text-headline-lg font-headline-lg text-on-surface">Tous nos articles</h1>
                    <p class="text-body-md text-on-surface-variant">Explorez notre sélection complète d'articles disponibles</p>
                </div>
                <form method="GET" action="/catalogue" class="flex items-center bg-surface-container px-space-md py-space-sm rounded-xl border border-border w-full md:w-80">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px] mr-2">search</span>
                    <input name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" class="bg-transparent text-label-md text-text outline-none w-full" placeholder="Rechercher par nom, réf..." type="text"/>
                    <?php if (!empty($current_cat)): ?>
                        <input type="hidden" name="cat" value="<?= (int)$current_cat ?>">
                    <?php endif; ?>
                </form>
            </div>

            <!-- Categories pills -->
            <?php if (!empty($categories)): ?>
                <div class="flex items-center gap-space-xs overflow-x-auto pb-2">
                    <a href="/catalogue<?= !empty($search_query) ? '?q=' . urlencode($search_query) : '' ?>" class="px-space-md py-1.5 rounded-xl border border-border text-label-md whitespace-nowrap transition-colors <?= empty($current_cat) ? 'bg-primary text-on-primary font-semibold' : 'bg-surface text-on-surface hover:bg-surface-container' ?>">
                        Tous
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <a href="/catalogue?cat=<?= (int)$cat['id'] ?><?= !empty($search_query) ? '&q=' . urlencode($search_query) : '' ?>" class="px-space-md py-1.5 rounded-xl border border-border text-label-md whitespace-nowrap transition-colors <?= ($current_cat === (int)$cat['id']) ? 'bg-primary text-on-primary font-semibold' : 'bg-surface text-on-surface hover:bg-surface-container' ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-lg">
                <?php if (empty($products)): ?>
                    <div class="col-span-full py-space-xl text-center bg-surface rounded-2xl border border-border text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl mb-2 text-outline">inventory_2</span>
                        <p class="text-body-lg">Aucun produit ne correspond à votre sélection.</p>
                        <a href="/catalogue" class="mt-4 inline-block text-primary font-semibold hover:underline">Réinitialiser les filtres</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <div class="bg-surface rounded-2xl p-space-md shadow-sm flex flex-col justify-between group border border-border hover:shadow-md transition-shadow">
                            <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" class="block">
                                <div class="relative w-full h-64 rounded-xl overflow-hidden bg-surface-container mb-space-md">
                                    <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-300" style="background-image: url('<?= htmlspecialchars(!empty($p['main_image_url']) ? '/' . ltrim($p['main_image_url'], '/') : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600') ?>')"></div>
                                    <?php if (!empty($p['promotional_price'])): ?>
                                        <span class="absolute bottom-3 left-3 bg-red-600 text-white px-space-sm py-1 rounded-md text-body-sm font-semibold shadow-sm">Promo</span>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <div class="flex flex-col gap-space-xs">
                                <span class="text-body-sm text-on-surface-variant"><?= htmlspecialchars($p['category_name'] ?? 'Collection') ?></span>
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

                                    <form action="/panier/ajouter" method="POST">
                                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                        <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary p-space-sm rounded-xl flex items-center justify-center transition-colors shadow-sm" title="Ajouter au panier">
                                            <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <footer class="w-full bg-surface-container-low py-space-lg border-t border-border">
        <div class="max-w-7xl mx-auto px-gutter text-center text-on-surface-variant text-body-sm">
            © <?= date('Y') ?> Marvens Shop. Tous droits réservés.
        </div>
    </footer>
</body>
</html>
