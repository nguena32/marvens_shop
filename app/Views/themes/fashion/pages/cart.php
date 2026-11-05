<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Mon Panier — Marvens Shop</title>
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
                        "surface": "#fff8f5",
                        "surface-container": "#fdeade",
                        "surface-container-high": "#f7e5d9",
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
            <a href="/catalogue" class="text-label-md text-on-surface-variant hover:text-on-surface">Continuer mes achats</a>
        </div>
    </header>

    <main class="w-full pt-28 pb-space-xl min-h-screen">
        <div class="max-w-4xl mx-auto px-gutter flex flex-col gap-space-lg">
            <h1 class="text-headline-lg font-headline-lg text-on-surface">Votre Panier</h1>

            <?php if (empty($cart['items'])): ?>
                <div class="bg-surface border border-border p-space-xl text-center rounded-2xl shadow-sm">
                    <span class="material-symbols-outlined text-5xl text-outline mb-2">shopping_bag</span>
                    <p class="text-headline-sm text-on-surface mb-space-md">Votre panier est actuellement vide.</p>
                    <a href="/catalogue" class="inline-block bg-primary text-on-primary px-space-lg py-space-sm rounded-xl font-medium hover:bg-primary-container transition-colors shadow-sm">
                        Découvrir les articles
                    </a>
                </div>
            <?php else: ?>
                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-label-md text-on-surface-variant border-b border-border">
                                <th class="p-space-md">Article</th>
                                <th class="p-space-md">Prix</th>
                                <th class="p-space-md">Quantité</th>
                                <th class="p-space-md text-right">Sous-total</th>
                                <th class="p-space-md text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-body-md text-on-surface">
                            <?php foreach ($cart['items'] as $it): ?>
                                <tr>
                                    <td class="p-space-md font-medium">
                                        <?= htmlspecialchars($it['product_name']) ?>
                                        <?php if (!empty($it['variant_name'])): ?>
                                            <div class="text-body-sm text-on-surface-variant"><?= htmlspecialchars($it['variant_name']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-space-md"><?= number_format((float)$it['unit_price'], 0, ',', ' ') ?> FCFA</td>
                                    <td class="p-space-md">
                                        <form action="/panier/modifier" method="POST" class="inline-flex items-center gap-1">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                            <input type="hidden" name="item_key" value="<?= htmlspecialchars($it['key']) ?>">
                                            <input type="number" name="quantity" value="<?= (int)$it['quantity'] ?>" min="1" max="99" class="w-16 bg-surface-container border border-border rounded px-2 py-1 text-center" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="p-space-md font-semibold text-right"><?= number_format((float)$it['subtotal'], 0, ',', ' ') ?> FCFA</td>
                                    <td class="p-space-md text-center">
                                        <form action="/panier/supprimer" method="POST">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                            <input type="hidden" name="item_key" value="<?= htmlspecialchars($it['key']) ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-50" title="Supprimer">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="bg-surface rounded-2xl border border-border p-space-lg max-w-sm ml-auto shadow-sm flex flex-col gap-space-sm">
                    <div class="flex justify-between text-body-md text-on-surface-variant">
                        <span>Articles (<?= (int)$cart['count'] ?>) :</span>
                        <span><?= number_format((float)$cart['subtotal'], 0, ',', ' ') ?> FCFA</span>
                    </div>
                    <div class="flex justify-between text-headline-sm font-headline-sm text-primary pt-space-xs border-t border-border">
                        <span>Total :</span>
                        <span><?= number_format((float)$cart['subtotal'], 0, ',', ' ') ?> FCFA</span>
                    </div>
                    <a href="/checkout" class="mt-space-md w-full bg-primary hover:bg-primary-container text-on-primary py-space-sm rounded-xl font-headline-sm font-bold text-center transition-colors shadow-md flex items-center justify-center gap-2">
                        Valider la commande &rarr;
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="w-full bg-surface-container-low py-space-lg border-t border-border">
        <div class="max-w-7xl mx-auto px-gutter text-center text-on-surface-variant text-body-sm">
            © <?= date('Y') ?> Marvens Shop. Tous droits réservés.
        </div>
    </footer>
</body>
</html>
