<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Informations de la boutique — Paramètres Marvens Shop</title>
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
                    <span class="text-indigo-600">Module 5.1</span>
                </div>
                <h1 class="text-3xl font-extrabold font-['Space_Grotesk'] text-gray-900">Informations de la Boutique</h1>
                <p class="text-sm text-gray-500 mt-1">Identité commerciale, coordonnées publiques et préférences régionales.</p>
            </div>
            <a href="/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold hover:bg-gray-50 shadow-sm">
                <span class="material-symbols-outlined text-base">visibility</span> Voir le site
            </a>
        </header>

        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/parametres/boutique" class="space-y-8">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <!-- 1. Identité de la boutique -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">storefront</span> Identité & Marque
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nom commercial de la boutique *</label>
                        <input type="text" name="shop_name" value="<?= htmlspecialchars($shop['shop_name'] ?? '') ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nom juridique de l'entreprise</label>
                        <input type="text" name="company_name" value="<?= htmlspecialchars($shop['company_name'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Description courte de la boutique</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"><?= htmlspecialchars($shop['description'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">URL du Logo principal</label>
                        <input type="text" name="logo_url" value="<?= htmlspecialchars($shop['logo_url'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">URL du Favicon</label>
                        <input type="text" name="favicon_url" value="<?= htmlspecialchars($shop['favicon_url'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <!-- 2. Contacts & WhatsApp -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">chat</span> Canaux de Contact & WhatsApp
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Numéro WhatsApp Business (Réception commandes) *</label>
                        <input type="text" name="whatsapp_number" value="<?= htmlspecialchars($shop['whatsapp_number'] ?? '') ?>" required
                               placeholder="+237699000000"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm">
                        <p class="text-xs text-gray-500 mt-1">Format international recommandé (ex: +237699000000).</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Téléphone d'appel direct</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($shop['phone'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Email professionnel</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($shop['email'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Adresse physique</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($shop['address'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Ville</label>
                        <input type="text" name="city" value="<?= htmlspecialchars($shop['city'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pays</label>
                        <input type="text" name="country" value="<?= htmlspecialchars($shop['country'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <!-- 3. Localisation & Préférences régionales -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-600">public</span> Préférences Régionales
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Devise principale</label>
                        <select name="currency" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            <option value="FCFA" <?= ($shop['currency'] ?? '') === 'FCFA' ? 'selected' : '' ?>>FCFA (Franc CFA)</option>
                            <option value="EUR" <?= ($shop['currency'] ?? '') === 'EUR' ? 'selected' : '' ?>>EUR (€ - Euro)</option>
                            <option value="USD" <?= ($shop['currency'] ?? '') === 'USD' ? 'selected' : '' ?>>USD ($ - Dollar US)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Langue de l'interface</label>
                        <select name="language" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            <option value="fr" <?= ($shop['language'] ?? '') === 'fr' ? 'selected' : '' ?>>Français</option>
                            <option value="en" <?= ($shop['language'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Fuseau horaire</label>
                        <input type="text" name="timezone" value="<?= htmlspecialchars($shop['timezone'] ?? 'Africa/Douala') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span> Enregistrer les informations
                </button>
            </div>
        </form>
    </main>
</body>
</html>
