<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= htmlspecialchars($product['name']) ?> — Marvens Shop</title>
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
                <a href="/catalogue" class="text-label-md text-on-surface-variant hover:text-on-surface">Catalogue</a>
                <a href="/panier" class="relative p-space-sm rounded-xl hover:bg-surface-container-high text-on-surface-variant flex items-center gap-2">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span class="text-label-md font-semibold">Panier (<?= (int) ($cart_count ?? 0) ?>)</span>
                </a>
            </div>
        </div>
    </header>

    <main class="w-full pt-28 pb-space-xl min-h-screen">
        <div class="max-w-5xl mx-auto px-gutter flex flex-col gap-space-lg">
            
            <a href="/catalogue" class="text-body-sm text-on-surface-variant hover:text-primary flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Retour au catalogue
            </a>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-xl bg-surface p-space-xl rounded-2xl border border-border shadow-sm">
                <!-- Visuel Produit -->
                <div class="relative aspect-square rounded-xl overflow-hidden bg-surface-container border border-border">
                    <img src="<?= htmlspecialchars(!empty($product['main_image_url']) ? '/' . ltrim($product['main_image_url'], '/') : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800') ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
                    <?php if (!empty($product['promotional_price'])): ?>
                        <span class="absolute top-4 left-4 bg-red-600 text-white px-space-md py-1 rounded-md text-body-sm font-bold shadow-sm">Offre Promo</span>
                    <?php endif; ?>
                </div>

                <!-- Détails & Ajout Panier -->
                <div class="flex flex-col justify-between">
                    <div class="flex flex-col gap-space-sm">
                        <span class="text-body-sm text-primary font-semibold uppercase tracking-wider"><?= htmlspecialchars($product['category_name'] ?? 'Collection Marvens') ?></span>
                        <h1 class="text-headline-lg font-headline-lg text-on-surface"><?= htmlspecialchars($product['name']) ?></h1>
                        
                        <?php if (!empty($product['sku'])): ?>
                            <span class="text-body-sm text-outline">Référence : <?= htmlspecialchars($product['sku']) ?></span>
                        <?php endif; ?>

                        <div class="my-space-md">
                            <?php if (!empty($product['promotional_price'])): ?>
                                <div class="flex items-baseline gap-space-sm">
                                    <span class="text-headline-xl font-headline-xl text-red-600"><?= number_format((float)$product['promotional_price'], 0, ',', ' ') ?> FCFA</span>
                                    <span class="text-headline-sm text-on-surface-variant line-through"><?= number_format((float)$product['price'], 0, ',', ' ') ?> FCFA</span>
                                </div>
                            <?php else: ?>
                                <span class="text-headline-xl font-headline-xl text-primary"><?= number_format((float)$product['price'], 0, ',', ' ') ?> FCFA</span>
                            <?php endif; ?>
                        </div>

                        <div class="text-body-md text-on-surface-variant border-t border-b border-border py-space-md my-space-xs leading-relaxed">
                            <?= nl2br(htmlspecialchars($product['description'] ?? 'Article de confection soignée issu de notre sélection exclusive. Disponible pour expédition immédiate.')) ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-space-md mt-space-lg">
                        <form action="/panier/ajouter" method="POST" class="flex flex-col gap-space-sm">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                            
                            <?php if (!empty($product['variants'])): ?>
                                <label class="text-label-md font-semibold text-on-surface">Choisir une variante :</label>
                                <select name="variant_id" class="w-full bg-surface-container border border-border p-space-sm rounded-xl text-body-md text-on-surface">
                                    <?php foreach ($product['variants'] as $v): ?>
                                        <option value="<?= (int)$v['id'] ?>">
                                            <?= htmlspecialchars($v['variant_name']) ?> (Stock : <?= (int)$v['stock_quantity'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                            <div class="flex items-center gap-space-sm">
                                <label class="text-label-md font-semibold text-on-surface">Quantité :</label>
                                <input type="number" name="quantity" value="1" min="1" max="10" class="w-20 bg-surface-container border border-border p-space-sm rounded-xl text-center text-body-md">
                            </div>

                            <button type="submit" class="w-full bg-primary hover:bg-primary-container text-on-primary py-space-md rounded-xl font-headline-sm font-bold text-center transition-colors shadow-md flex items-center justify-center gap-2 mt-space-sm">
                                <span class="material-symbols-outlined">add_shopping_cart</span> Ajouter au panier
                            </button>
                        </form>

                        <?php 
                            $directWaText = urlencode("Bonjour, je souhaite commander l'article *" . $product['name'] . "* au prix de " . number_format((float)($product['promotional_price'] ?? $product['price']), 0, ',', ' ') . " FCFA.");
                            $directWaUrl = "https://wa.me/?text=" . $directWaText;
                        ?>
                        <a href="<?= $directWaUrl ?>" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-space-md rounded-xl font-headline-sm font-bold text-center transition-colors shadow-sm flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">chat</span> Commander directement via WhatsApp
                        </a>
                    </div>
                </div>
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
