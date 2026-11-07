<?php
$active_tab = 'categories';
$isEdit = !empty($category['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $isEdit ? 'Modifier la Catégorie' : 'Nouvelle Catégorie' ?> — Marvens Shop</title>
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
                        "on-primary": "#ffffff",
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

    <div class="md:pl-72 min-h-screen flex flex-col pb-16 md:pb-0">
        <?php include dirname(__DIR__) . '/partials/header.php';
        include dirname(__DIR__) . '/partials/bottom_nav.php'; ?>

        <main class="relative pt-16 bg-background min-h-screen p-space-lg">
            <div class="max-w-2xl mx-auto flex flex-col gap-space-lg">
                
                <?php if (!empty($errors)): ?>
                    <div class="p-space-md rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
                        <ul class="list-disc list-inside">
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-between bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <a href="/admin/categories" class="text-xs text-outline hover:text-on-surface flex items-center gap-1 mb-1">
                            <span class="material-symbols-outlined text-[14px]">arrow_back</span> Retour aux catégories
                        </a>
                        <h1 class="text-2xl font-bold text-on-surface"><?= $isEdit ? 'Modifier la Catégorie' : 'Nouvelle Catégorie' ?></h1>
                    </div>
                </div>

                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <form method="POST" action="<?= $isEdit ? '/admin/categories/' . (int)$category['id'] . '/modifier' : '/admin/categories/nouvelle' ?>" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                        <div>
                            <label for="name" class="block text-xs font-semibold text-outline uppercase mb-1">Nom de la catégorie *</label>
                            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($category['name'] ?? '') ?>" placeholder="Ex: Chaussures & Maroquinerie" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                        </div>

                        <div>
                            <label for="slug" class="block text-xs font-semibold text-outline uppercase mb-1">Identifiant URL (Slug) — Optionnel</label>
                            <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($category['slug'] ?? '') ?>" placeholder="Généré automatiquement si vide" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none font-mono text-xs">
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-semibold text-outline uppercase mb-1">Description</label>
                            <textarea id="description" name="description" rows="3" placeholder="Présentation du rayon..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="sort_order" class="block text-xs font-semibold text-outline uppercase mb-1">Ordre d'affichage (priorité croissante)</label>
                                <input type="number" id="sort_order" name="sort_order" value="<?= (int)($category['sort_order'] ?? 0) ?>" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-outline uppercase mb-1">Visibilité sur la boutique</label>
                                <label class="flex items-center gap-2 mt-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" <?= (!isset($category['is_active']) || $category['is_active']) ? 'checked' : '' ?> class="w-4 h-4 rounded text-primary focus:ring-0">
                                    <span class="text-sm font-medium">Activer cette catégorie</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="image" class="block text-xs font-semibold text-outline uppercase mb-1">Visuel de la catégorie (Optionnel)</label>
                            <?php if (!empty($category['image_url'])): ?>
                                <div class="mb-2 flex items-center gap-3">
                                    <img src="<?= htmlspecialchars(str_starts_with($category['image_url'], 'http') ? $category['image_url'] : '/' . ltrim($category['image_url'], '/')) ?>" alt="" class="w-12 h-12 rounded-lg object-cover border border-border">
                                    <span class="text-xs text-outline">Image actuelle conservée si aucun fichier sélectionné</span>
                                </div>
                            <?php endif; ?>
                            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                        </div>

                        <div class="pt-4 border-t border-border flex justify-end gap-2">
                            <a href="/admin/categories" class="px-4 py-2 border border-border rounded-xl text-sm font-medium hover:bg-surface-container-low transition-all">Annuler</a>
                            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-sm">
                                <?= $isEdit ? 'Mettre à jour' : 'Enregistrer' ?>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
