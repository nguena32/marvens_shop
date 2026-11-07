<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Analytics & Suivi Marketing — Paramètres Marvens Shop</title>
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
            <div class="max-w-6xl mx-auto flex flex-col gap-space-lg">
                <header class="flex justify-between items-center bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-outline mb-1">
                            <span>Paramètres</span>
                            <span class="material-symbols-outlined text-xs">chevron_right</span>
                            <span class="text-primary font-bold">Module 5.8</span>
                        </div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Analytics & Suivi Marketing</h1>
                        <p class="text-sm text-outline mt-1">Configurez les identifiants de mesure de conversion (Google Analytics 4, Meta Pixel & GTM).</p>
                    </div>
                </header>

        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/parametres/analytics" class="space-y-6">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">query_stats</span> Identifiants de Mesure
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Google Analytics 4 (ID de mesure G-XXXXXXX)</label>
                        <input type="text" name="ga_id" value="<?= htmlspecialchars($analytics['ga_id'] ?? '') ?>" placeholder="G-XXXXXXXXXX"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                        <p class="text-xs text-gray-500 mt-1">Injecté automatiquement dans l'entête public de toutes les pages.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Meta Pixel ID (Facebook / Instagram)</label>
                        <input type="text" name="pixel_id" value="<?= htmlspecialchars($analytics['pixel_id'] ?? '') ?>" placeholder="ex: 987654321012345"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                        <p class="text-xs text-gray-500 mt-1">Trace les événements PageView, AddToCart et InitiateCheckout.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Google Tag Manager (GTM-XXXXXXX)</label>
                        <input type="text" name="gtm_id" value="<?= htmlspecialchars($analytics['gtm_id'] ?? '') ?>" placeholder="GTM-XXXXXXX"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm font-mono">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">track_changes</span> Événements Collectés
                </h2>

                <div class="space-y-4">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="track_checkout" value="1" class="w-5 h-5 text-indigo-600 rounded" <?= !empty($analytics['track_checkout']) ? 'checked' : '' ?>>
                        <div>
                            <span class="font-bold text-sm text-gray-900 block">Suivi du tunnel d'achat et validation de panier</span>
                            <span class="text-xs text-gray-500">Collecte anonymisée des conversions au checkout.</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="track_whatsapp_clicks" value="1" class="w-5 h-5 text-indigo-600 rounded" <?= !empty($analytics['track_whatsapp_clicks']) ? 'checked' : '' ?>>
                        <div>
                            <span class="font-bold text-sm text-gray-900 block">Suivi des clics d'ouverture WhatsApp</span>
                            <span class="text-xs text-gray-500">Enregistre l'intention d'envoi du message au commerçant.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-primary hover:opacity-90 text-white font-bold rounded-xl shadow transition-all">
                    Enregistrer les traceurs
                </button>
            </div>
        </form>
            </div>
        </main>
    </div>
</body>
</html>
