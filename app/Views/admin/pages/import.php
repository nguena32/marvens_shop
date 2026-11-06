<?php
$active_tab = 'import';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Importation de Catalogue — Marvens Shop</title>
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
            <div class="max-w-4xl mx-auto flex flex-col gap-space-lg">
                
                <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface">Importation du Catalogue</h1>
                        <p class="text-sm text-outline">Intégrez rapidement vos fiches produits via fichier CSV/Excel ou synchronisez votre catalogue Meta</p>
                    </div>

                    <a href="/admin/import/modele" class="border border-border text-on-surface px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-low transition-all flex items-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">download</span> Modèle CSV type
                    </a>
                </div>

                <?php if (!empty($report)): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-space-md rounded-2xl shadow-sm">
                        <h3 class="font-bold text-sm mb-1 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span> Rapport d'exécution de l'import :
                        </h3>
                        <div class="text-xs space-y-0.5">
                            <div>Articles créés : <strong><?= (int) ($report['created'] ?? 0) ?></strong></div>
                            <div>Articles mis à jour (déduplication) : <strong><?= (int) ($report['updated'] ?? 0) ?></strong></div>
                        </div>
                        <?php if (!empty($report['errors'])): ?>
                            <div class="mt-2 text-xs text-red-700 bg-red-50 p-3 rounded-lg border border-red-200">
                                <strong>Lignes avec anomalies / non importées :</strong>
                                <ul class="list-disc list-inside mt-1 space-y-0.5">
                                    <?php foreach ($report['errors'] as $err): ?>
                                        <li><?= htmlspecialchars($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Import CSV & Excel -->
                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <h2 class="text-lg font-bold text-on-surface mb-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">table_view</span> 1. Fichier CSV ou Excel (.xlsx) de Produits
                    </h2>
                    <p class="text-sm text-outline mb-space-md">
                        Téléversez votre listing. Formats acceptés : <code>.csv</code> (séparateur virgule, point-virgule ou tabulation) ou <code>.xlsx</code> natif.<br>
                        Colonnes reconnues : <code>name</code>, <code>price</code>, <code>promotional_price</code>, <code>sku</code>, <code>category</code>, <code>description</code>, <code>image_url</code>.
                    </p>

                    <form method="POST" action="/admin/import/csv" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <div>
                            <input type="file" name="import_file" accept=".csv,.xlsx" required class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-outline">
                                Taille maximale : 10 Mo • Déduplication automatique par SKU et Slug
                            </div>
                            <button type="submit" class="bg-[#D97706] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-[#b45309] transition-all flex items-center gap-2 shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">cloud_upload</span> Lancer l'importation
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Connecteur Meta -->
                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-on-surface mb-1 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">storefront</span> 2. Synchronisation Meta Catalog (Facebook / Instagram Shopping)
                            </h2>
                            <p class="text-xs text-outline mb-space-md">
                                Importez vos produits directement depuis vos catalogues Meta Business Suite via OAuth Graph API v19.0.
                            </p>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold <?= !empty($meta_status['connected']) ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' ?>">
                                <?= htmlspecialchars($meta_status['status'] ?? 'NON CONFIGURÉ') ?>
                            </span>
                        </div>
                    </div>

                    <div class="bg-surface-container-low border border-border p-space-md rounded-xl text-sm mb-space-md">
                        <div class="text-xs text-outline mb-2"><?= htmlspecialchars($meta_status['message'] ?? '') ?></div>
                        
                        <?php if (empty($meta_status['connected'])): ?>
                            <div class="flex items-center gap-2">
                                <a href="/admin/import/meta/connect" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-semibold hover:bg-blue-700 transition-all flex items-center gap-1.5 shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">sync_lock</span> Connecter mon compte Meta
                                </a>
                                <span class="text-xs text-outline">Connexion OAuth sécurisée avec jeton temporaire</span>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center justify-between">
                                <div class="text-xs font-semibold text-emerald-700 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">verified</span> Compte Meta synchronisé
                                </div>
                                <form method="POST" action="/admin/import/meta/disconnect" class="inline">
                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <button type="submit" class="text-xs text-red-600 hover:underline">Déconnecter</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Liste des Catalogues Meta Détectés -->
                    <?php if (!empty($meta_catalogs)): ?>
                        <div class="mt-4 pt-4 border-t border-border">
                            <h3 class="text-sm font-bold text-on-surface mb-2">Catalogues disponibles dans votre compte :</h3>
                            <div class="space-y-3">
                                <?php foreach ($meta_catalogs as $cat): ?>
                                    <div class="p-3 bg-white rounded-xl border border-border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
                                        <div>
                                            <div class="font-semibold text-sm"><?= htmlspecialchars($cat['name']) ?></div>
                                            <div class="text-xs text-outline">ID : <?= htmlspecialchars($cat['id']) ?> • <?= (int)($cat['product_count'] ?? 0) ?> produit(s) répertorié(s)</div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="/admin/import/meta/preview?catalog_id=<?= urlencode($cat['id']) ?>" class="px-3 py-1.5 border border-border rounded-lg text-xs font-medium hover:bg-surface-container-low transition-all">
                                                Aperçu des fiches
                                            </a>
                                            <form method="POST" action="/admin/import/meta/sync">
                                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                <input type="hidden" name="catalog_id" value="<?= htmlspecialchars($cat['id']) ?>">
                                                <button type="submit" class="bg-primary text-on-primary px-3.5 py-1.5 rounded-lg text-xs font-semibold hover:bg-surface-container-high transition-all shadow-xs">
                                                    Importer ce catalogue
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Aperçu des Produits Meta si demandé -->
                    <?php if (!empty($meta_preview_products)): ?>
                        <div class="mt-4 pt-4 border-t border-border">
                            <h3 class="text-sm font-bold text-on-surface mb-2">Aperçu des articles récupérés depuis Meta :</h3>
                            <div class="border border-border rounded-xl overflow-hidden text-xs">
                                <table class="w-full text-left">
                                    <thead class="bg-surface-container-low font-semibold text-outline">
                                        <tr>
                                            <th class="p-2">Visuel</th>
                                            <th class="p-2">Désignation</th>
                                            <th class="p-2">SKU Meta</th>
                                            <th class="p-2">Prix</th>
                                            <th class="p-2">Disponibilité</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border">
                                        <?php foreach ($meta_preview_products as $mp): ?>
                                            <tr>
                                                <td class="p-2">
                                                    <img src="<?= htmlspecialchars($mp['image_url']) ?>" alt="" class="w-8 h-8 rounded object-cover border border-border">
                                                </td>
                                                <td class="p-2 font-medium"><?= htmlspecialchars($mp['name']) ?></td>
                                                <td class="p-2 font-mono text-outline"><?= htmlspecialchars($mp['retailer_id']) ?></td>
                                                <td class="p-2 font-semibold"><?= number_format((float)$mp['price'], 0, ',', ' ') ?> FCFA</td>
                                                <td class="p-2 text-emerald-700"><?= htmlspecialchars($mp['availability']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </main>
    </div>
</body>
</html>
