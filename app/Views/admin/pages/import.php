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
                
                <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <h1 class="text-2xl font-bold text-on-surface">Importation du Catalogue</h1>
                    <p class="text-sm text-outline">Intégrez rapidement vos fiches produits via fichier CSV ou synchronisez votre catalogue Meta</p>
                </div>

                <?php if (!empty($report)): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-space-md rounded-2xl shadow-sm">
                        <h3 class="font-bold text-sm mb-1 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span> Rapport d'exécution :
                        </h3>
                        <div class="text-xs space-y-0.5">
                            <div>Articles créés : <strong><?= (int) $report['created'] ?></strong></div>
                            <div>Articles mis à jour : <strong><?= (int) $report['updated'] ?></strong></div>
                        </div>
                        <?php if (!empty($report['errors'])): ?>
                            <div class="mt-2 text-xs text-red-700 bg-red-50 p-2 rounded-lg border border-red-200">
                                <strong>Anomalies détectées :</strong>
                                <ul class="list-disc list-inside mt-1">
                                    <?php foreach ($report['errors'] as $err): ?>
                                        <li><?= htmlspecialchars($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Import CSV -->
                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <h2 class="text-lg font-bold text-on-surface mb-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">table_view</span> 1. Fichier CSV de Produits
                    </h2>
                    <p class="text-sm text-outline mb-space-md">
                        Téléversez votre listing de produits au format standard. Colonnes supportées : <code>name</code>, <code>price</code>, <code>sku</code>, <code>description</code>, <code>promotional_price</code>.
                    </p>

                    <form method="POST" action="/admin/import/csv" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="file" name="csv_file" accept=".csv" required class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                        <button type="submit" class="bg-[#D97706] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-[#b45309] transition-all flex items-center gap-2 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">cloud_upload</span> Lancer l'importation CSV
                        </button>
                    </form>
                </div>

                <!-- Connecteur Meta -->
                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <h2 class="text-lg font-bold text-on-surface mb-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">storefront</span> 2. Synchronisation Meta Catalog (Facebook / Instagram Shopping)
                    </h2>
                    <div class="bg-blue-50 border border-blue-200 text-blue-900 p-space-md rounded-xl text-sm mb- space-md">
                        <strong>Statut de la passerelle :</strong> <?= htmlspecialchars($meta_status['status'] ?? 'BLOCKED_EXTERNAL') ?><br>
                        <span class="text-xs text-blue-700"><?= htmlspecialchars($meta_status['message'] ?? '') ?></span>
                    </div>
                    <p class="text-xs text-outline leading-relaxed mt-2">
                        L'accès à l'API Meta Graph requiert une application vérifiée avec le scope <code>catalog_management</code> et un token commerçant permanent.
                    </p>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
