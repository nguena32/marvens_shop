<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Analytics & Suivi Marketing — Paramètres Marvens Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#F8F9FA] text-[#1A1A1A] font-['Plus_Jakarta_Sans',sans-serif] flex min-h-screen">

    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="flex-1 ml-72 p-10 max-w-6xl">
        <header class="mb-8 flex justify-between items-center">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                    <span>Paramètres</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-indigo-600">Module 5.8</span>
                </div>
                <h1 class="text-3xl font-extrabold font-['Space_Grotesk'] text-gray-900">Analytics & Suivi Marketing</h1>
                <p class="text-sm text-gray-500 mt-1">Configurez les identifiants de mesure de conversion (Google Analytics 4, Meta Pixel & GTM).</p>
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
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition-all">
                    Enregistrer les traceurs
                </button>
            </div>
        </form>
    </main>
</body>
</html>
