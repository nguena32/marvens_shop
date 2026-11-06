<?php
$active_tab = 'categories';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gestion des Catégories — Marvens Shop</title>
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
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Catégories de Produits</h1>
                        <p class="text-sm text-outline">Organisez les rayons, l'ordre d'affichage et la visibilité des articles de votre boutique</p>
                    </div>

                    <a href="/admin/categories/nouvelle" class="bg-primary text-white px-4 py-2 rounded-xl text-sm font-semibold hover:opacity-90 transition-all flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span> Nouvelle Catégorie
                    </a>
                </div>

                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-xs font-semibold uppercase text-outline border-b border-border">
                                <th class="py-3 px-4">Ordre</th>
                                <th class="py-3 px-4">Catégorie</th>
                                <th class="py-3 px-4">Slug</th>
                                <th class="py-3 px-4">Articles associés</th>
                                <th class="py-3 px-4">Visibilité</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm text-on-surface">
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-outline">
                                        Aucune catégorie enregistrée pour le moment.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $cat): ?>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="py-3 px-4 font-mono text-xs text-outline font-semibold">
                                            #<?= (int)$cat['sort_order'] ?>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                <?php if (!empty($cat['image_url'])): ?>
                                                    <div class="w-9 h-9 rounded-lg bg-surface-container bg-cover bg-center shrink-0 border border-border" style="background-image: url('<?= htmlspecialchars(str_starts_with($cat['image_url'], 'http') ? $cat['image_url'] : '/' . ltrim($cat['image_url'], '/')) ?>')"></div>
                                                <?php else: ?>
                                                    <div class="w-9 h-9 rounded-lg bg-surface-container flex items-center justify-center shrink-0 border border-border text-outline">
                                                        <span class="material-symbols-outlined text-[18px]">folder</span>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="font-semibold"><?= htmlspecialchars($cat['name']) ?></div>
                                                    <span class="text-xs text-outline line-clamp-1"><?= htmlspecialchars($cat['description'] ?? 'Aucune description') ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 font-mono text-xs text-outline">
                                            <?= htmlspecialchars($cat['slug']) ?>
                                        </td>
                                        <td class="py-3 px-4 font-medium">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                                <?= (int)($cat['products_count'] ?? 0) ?> article(s)
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <form method="POST" action="/admin/categories/<?= (int)$cat['id'] ?>/statut">
                                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                <button type="submit" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold <?= $cat['is_active'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800' ?>" title="Cliquez pour basculer">
                                                    <?= $cat['is_active'] ? 'Visible' : 'Masquée' ?>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="/admin/categories/<?= (int)$cat['id'] ?>/modifier" class="p-1.5 text-outline hover:text-on-surface hover:bg-surface-container-high rounded-lg transition-all" title="Modifier">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                </a>
                                                <form method="POST" action="/admin/categories/<?= (int)$cat['id'] ?>/supprimer" onsubmit="return confirm('Confirmez-vous la suppression de cette catégorie ? Les articles liés deviendront sans catégorie.');" class="inline">
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
