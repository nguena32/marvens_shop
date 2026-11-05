<?php
$active_tab = 'products';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Ajouter un Produit — Marvens Shop</title>
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
            <div class="max-w-3xl mx-auto flex flex-col gap-space-lg">
                
                <div class="flex items-center justify-between bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <a href="/admin/produits" class="text-xs text-outline hover:text-on-surface flex items-center gap-1 mb-1">
                            <span class="material-symbols-outlined text-[14px]">arrow_back</span> Retour au catalogue
                        </a>
                        <h1 class="text-2xl font-bold text-on-surface">Nouveau Produit</h1>
                    </div>
                </div>

                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <form method="POST" action="/admin/produits/nouveau" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                        <div>
                            <label for="name" class="block text-xs font-semibold text-outline uppercase mb-1">Désignation de l'article *</label>
                            <input type="text" id="name" name="name" required placeholder="Ex: Robe Longue Sahara" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                        </div>

                        <div>
                            <label for="category_id" class="block text-xs font-semibold text-outline uppercase mb-1">Catégorie</label>
                            <select id="category_id" name="category_id" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                                <option value="">-- Sans catégorie --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= (int) $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block text-xs font-semibold text-outline uppercase mb-1">Prix standard (FCFA) *</label>
                                <input type="number" id="price" name="price" required placeholder="Ex: 18500" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                            </div>
                            <div>
                                <label for="promotional_price" class="block text-xs font-semibold text-outline uppercase mb-1">Prix promotionnel (FCFA)</label>
                                <input type="number" id="promotional_price" name="promotional_price" placeholder="Optionnel" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label for="sku" class="block text-xs font-semibold text-outline uppercase mb-1">Référence SKU</label>
                            <input type="text" id="sku" name="sku" placeholder="Ex: ROBE-001" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-semibold text-outline uppercase mb-1">Description & Caractéristiques</label>
                            <textarea id="description" name="description" rows="3" placeholder="Matière, coupe, finitions..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none"></textarea>
                        </div>

                        <div>
                            <label for="image" class="block text-xs font-semibold text-outline uppercase mb-1">Photo principale (JPEG, PNG, WEBP - Max 5 Mo)</label>
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                        </div>

                        <div class="pt-4 border-t border-border flex justify-end">
                            <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-surface-container-high hover:text-on-surface transition-all shadow-sm">
                                Enregistrer et Publier
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
