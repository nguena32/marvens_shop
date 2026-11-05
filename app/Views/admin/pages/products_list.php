<?php
$active_tab = 'products';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Catalogue des Produits — Marvens Shop</title>
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
                        "secondary-container": "#fe932c",
                        "tertiary": "#000000",
                        "surface-container-low": "#f6f3f5",
                        "primary": "#000000",
                        "outline": "#76777d",
                        "surface-container": "#f0edef",
                        "on-surface": "#1b1b1d",
                        "secondary": "#904d00",
                        "surface-container-highest": "#e4e2e4",
                        "surface-container-high": "#eae7e9",
                        "surface": "#FFFFFF",
                        "background": "#F8FAFC",
                        "border": "#E2E8F0",
                        "on-surface-variant": "#45464d",
                        "error": "#ba1a1a"
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                    spacing: { "space-sm": "8px", "space-lg": "24px", "space-xs": "4px", "space-xl": "48px", "space-md": "16px" },
                    fontFamily: { "body-md": ["Inter"], "headline-md": ["Inter"], "headline-sm": ["Inter"] }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background font-body-md text-on-surface">

    <?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

    <div class="pl-72">
        <?php include dirname(__DIR__) . '/partials/header.php'; ?>

        <main class="relative pt-16 bg-background min-h-screen p-space-lg">
            <div class="max-w-7xl mx-auto flex flex-col gap-space-lg">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Catalogue des Produits</h1>
                        <p class="text-sm text-outline">Gestion des fiches produits, prix, visuels et publications</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/admin/import" class="border border-border text-on-surface px-4 py-2 rounded-xl text-sm font-medium hover:bg-surface-container-low transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">cloud_download</span> Importer
                        </a>
                        <a href="/admin/produits/nouveau" class="bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all flex items-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">add</span> Nouveau Produit
                        </a>
                    </div>
                </div>

                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-xs font-semibold uppercase text-outline border-b border-border">
                                <th class="py-3 px-4">Article</th>
                                <th class="py-3 px-4">Catégorie</th>
                                <th class="py-3 px-4">Prix Standard</th>
                                <th class="py-3 px-4">Prix Promo</th>
                                <th class="py-3 px-4">Statut</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm text-on-surface">
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-outline">
                                        Aucun produit enregistré pour le moment.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $p): ?>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-surface-container bg-cover bg-center shrink-0 border border-border" style="background-image: url('<?= htmlspecialchars(!empty($p['main_image_url']) ? '/' . ltrim($p['main_image_url'], '/') : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100') ?>')"></div>
                                                <div>
                                                    <div class="font-semibold"><?= htmlspecialchars($p['name']) ?></div>
                                                    <span class="text-xs text-outline"><?= htmlspecialchars($p['sku'] ?? 'Sans SKU') ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-outline"><?= htmlspecialchars($p['category_name'] ?? 'Non classé') ?></td>
                                        <td class="py-3 px-4 font-medium"><?= number_format((float)$p['price'], 0, ',', ' ') ?> FCFA</td>
                                        <td class="py-3 px-4">
                                            <?php if (!empty($p['promotional_price'])): ?>
                                                <span class="text-red-600 font-semibold"><?= number_format((float)$p['promotional_price'], 0, ',', ' ') ?> FCFA</span>
                                            <?php else: ?>
                                                <span class="text-xs text-outline">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?= $p['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' ?>">
                                                <?= $p['is_active'] ? 'En ligne' : 'Masqué' ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" target="_blank" class="inline-flex items-center gap-1 text-xs text-outline hover:text-on-surface mr-2" title="Voir sur la boutique">
                                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
