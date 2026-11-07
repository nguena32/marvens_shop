<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Applications & Intégrations — Paramètres Marvens Shop</title>
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
                            <span class="text-primary font-bold">Module 5.6</span>
                        </div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Applications & Intégrations</h1>
                        <p class="text-sm text-outline mt-1">Connecteurs WhatsApp, passerelle email SMTP, catalogue Meta et services externes.</p>
                    </div>
                </header>

        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/parametres/integrations" class="space-y-6">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <!-- 1. WhatsApp Business -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-2xl">chat</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">WhatsApp Business</h3>
                            <p class="text-xs text-gray-500">Lien direct de commande et interaction instantanée avec les acheteurs.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Opérationnel</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500">Numéro lié : <strong><?= htmlspecialchars($integrations['whatsapp']['phone'] ?? '') ?></strong></span>
                    <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                        <input type="checkbox" name="whatsapp_enabled" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($integrations['whatsapp']['enabled']) ? 'checked' : '' ?>> Activer le canal
                    </label>
                </div>
            </div>

            <!-- 2. Serveur SMTP / E-mail -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-2xl">mail</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Service E-mail (SMTP Professionnel)</h3>
                            <p class="text-xs text-gray-500">Envoi des récapitulatifs de commandes et notifications de sécurité.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $integrations['smtp']['status'] === 'connected' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' ?>">
                        <?= $integrations['smtp']['status'] === 'connected' ? 'Connecté' : 'Non configuré' ?>
                    </span>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Hôte SMTP</label>
                        <input type="text" name="smtp_host" value="<?= htmlspecialchars($integrations['smtp']['host'] ?? '') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Port</label>
                        <input type="text" name="smtp_port" value="<?= htmlspecialchars($integrations['smtp']['port'] ?? '465') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Identifiant / Email</label>
                        <input type="text" name="smtp_user" value="<?= htmlspecialchars($integrations['smtp']['user'] ?? '') ?>" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Chiffrement</label>
                        <select name="smtp_encryption" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                            <option value="ssl" <?= ($integrations['smtp']['encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL (Port 465)</option>
                            <option value="tls" <?= ($integrations['smtp']['encryption'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS (Port 587)</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                        <input type="checkbox" name="smtp_enabled" value="1" class="w-4 h-4 text-blue-600 rounded" <?= !empty($integrations['smtp']['enabled']) ? 'checked' : '' ?>> Activer l'envoi SMTP
                    </label>
                </div>
            </div>

            <!-- 3. Meta Catalog -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-2xl">shopping_cart</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Catalogue Meta & Instagram Shopping</h3>
                            <p class="text-xs text-gray-500">Synchronisation des produits vers Meta Business Suite.</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Prêt</span>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Meta Catalog ID</label>
                        <input type="text" name="meta_catalog_id" value="<?= htmlspecialchars($integrations['meta_catalog']['catalog_id'] ?? '') ?>" placeholder="ex: 123456789012345" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                    </div>
                    <div class="flex items-end justify-end">
                        <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                            <input type="checkbox" name="meta_enabled" value="1" class="w-4 h-4 text-purple-600 rounded" <?= !empty($integrations['meta_catalog']['enabled']) ? 'checked' : '' ?>> Activer la synchronisation
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-primary hover:opacity-90 text-white font-bold rounded-xl shadow transition-all">
                    Enregistrer les intégrations
                </button>
            </div>
        </form>
            </div>
        </main>
    </div>
</body>
</html>
