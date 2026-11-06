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
                
                <?php if (!empty($feedback)): ?>
                    <div class="p-space-md rounded-2xl border text-sm <?= ($feedback['type'] ?? 'info') === 'success' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-800' ?>">
                        <?= htmlspecialchars($feedback['message'] ?? '') ?>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Catalogue des Produits</h1>
                        <p class="text-sm text-outline">Gestion des fiches produits, prix, visuels, variantes et disponibilité</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/admin/categories" class="border border-border text-on-surface px-4 py-2 rounded-xl text-sm font-medium hover:bg-surface-container-low transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">folder</span> Catégories
                        </a>
                        <a href="/admin/import" class="border border-border text-on-surface px-4 py-2 rounded-xl text-sm font-medium hover:bg-surface-container-low transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">cloud_download</span> Importer
                        </a>
                        <a href="/admin/produits/nouveau" class="bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all flex items-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">add</span> Nouveau Produit
                        </a>
                    </div>
                </div>

                <!-- Filtres et recherche -->
                <div class="bg-surface p-space-md rounded-2xl border border-border flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" action="/admin/produits" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                        <div class="relative min-w-[240px]">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline text-[18px]">search</span>
                            <input type="text" name="search" value="<?= htmlspecialchars($current_search ?? '') ?>" placeholder="Rechercher nom, SKU..." class="w-full pl-9 pr-3 py-1.5 bg-surface-container-low border border-border rounded-xl text-sm focus:outline-none">
                        </div>

                        <select name="category_id" onchange="this.form.submit()" class="bg-surface-container-low border border-border rounded-xl px-3 py-1.5 text-sm">
                            <option value="">Toutes les catégories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int)$cat['id'] ?>" <?= ((int)($current_category ?? 0) === (int)$cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="status" onchange="this.form.submit()" class="bg-surface-container-low border border-border rounded-xl px-3 py-1.5 text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="active" <?= ($current_status ?? '') === 'active' ? 'selected' : '' ?>>En ligne</option>
                            <option value="inactive" <?= ($current_status ?? '') === 'inactive' ? 'selected' : '' ?>>Masqués / Hors ligne</option>
                            <option value="promo" <?= ($current_status ?? '') === 'promo' ? 'selected' : '' ?>>En promotion</option>
                            <option value="featured" <?= ($current_status ?? '') === 'featured' ? 'selected' : '' ?>>Mis en avant</option>
                        </select>

                        <?php if (!empty($current_search) || !empty($current_category) || !empty($current_status)): ?>
                            <a href="/admin/produits" class="text-xs text-outline hover:text-on-surface underline">Réinitialiser</a>
                        <?php endif; ?>
                    </form>
                    <div class="text-xs text-outline font-medium">
                        Total : <strong><?= count($products) ?></strong> article(s)
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
                                <th class="py-3 px-4">Variantes & Stock</th>
                                <th class="py-3 px-4">Statut</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm text-on-surface">
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-outline">
                                        Aucun produit trouvé selon les critères sélectionnés.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $p): ?>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-lg bg-surface-container bg-cover bg-center shrink-0 border border-border" style="background-image: url('<?= htmlspecialchars(!empty($p['main_image_url']) ? (str_starts_with($p['main_image_url'], 'http') ? $p['main_image_url'] : '/' . ltrim($p['main_image_url'], '/')) : 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=100') ?>')"></div>
                                                <div>
                                                    <div class="font-semibold flex items-center gap-1.5">
                                                        <?= htmlspecialchars($p['name']) ?>
                                                        <?php if (!empty($p['is_featured'])): ?>
                                                            <span class="material-symbols-outlined text-amber-500 text-[16px]" title="Mis en avant sur l'accueil">star</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span class="text-xs text-outline font-mono"><?= htmlspecialchars($p['sku'] ?? 'Sans SKU') ?></span>
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
                                        <td class="py-3 px-4 text-xs text-outline">
                                            <?php if ((int)($p['variants_count'] ?? 0) > 0): ?>
                                                <span class="font-medium text-on-surface"><?= (int)$p['variants_count'] ?> var.</span> (<?= (int)($p['total_stock'] ?? 0) ?> en stock)
                                            <?php else: ?>
                                                Article standard
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2">
                                                <form method="POST" action="/admin/produits/<?= (int)$p['id'] ?>/statut">
                                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                    <button type="submit" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?= $p['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' ?>" title="Cliquez pour changer la publication">
                                                        <?= $p['is_active'] ? 'En ligne' : 'Masqué' ?>
                                                    </button>
                                                </form>
                                                <form method="POST" action="/admin/produits/<?= (int)$p['id'] ?>/featured">
                                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                    <button type="submit" class="text-xs p-1 rounded hover:bg-surface-container-high <?= $p['is_featured'] ? 'text-amber-600 font-semibold' : 'text-outline' ?>" title="Mettre en avant sur la boutique">
                                                        <span class="material-symbols-outlined text-[16px]"><?= $p['is_featured'] ? 'hotel_class' : 'star_border' ?></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" target="_blank" class="p-1.5 text-outline hover:text-on-surface rounded-lg transition-all" title="Voir sur la boutique">
                                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                                </a>
                                                <a href="/admin/produits/<?= (int)$p['id'] ?>/modifier" class="p-1.5 text-outline hover:text-on-surface hover:bg-surface-container-high rounded-lg transition-all" title="Modifier la fiche">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                </a>
                                                <form method="POST" action="/admin/produits/<?= (int)$p['id'] ?>/supprimer" onsubmit="return confirm('Confirmez-vous la suppression de ce produit ?');" class="inline">
                                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                    <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-all" title="Supprimer">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
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
