<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Livraison et Retrait — Paramètres Marvens Shop</title>
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
                    <span class="text-indigo-600">Module 5.3</span>
                </div>
                <h1 class="text-3xl font-extrabold font-['Space_Grotesk'] text-gray-900">Livraison & Retrait en boutique</h1>
                <p class="text-sm text-gray-500 mt-1">Configurez les modes de délivrance, les frais par quartier et les instructions clients.</p>
            </div>
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

        <!-- 1. Modes de livraison activés -->
        <form method="POST" action="/admin/parametres/livraison" class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">tune</span> Activation des Méthodes
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="p-4 rounded-xl border border-gray-200 flex items-start gap-4">
                    <input type="checkbox" name="home_enabled" value="1" id="home_enabled" class="mt-1 w-5 h-5 text-indigo-600 rounded" <?= !empty($delivery['home_enabled']) ? 'checked' : '' ?>>
                    <div>
                        <label for="home_enabled" class="font-bold text-gray-900 text-sm cursor-pointer">Livraison à Domicile</label>
                        <p class="text-xs text-gray-500 mt-0.5">Permet aux clients d'indiquer leur adresse et quartier pour une expédition par coursier.</p>
                    </div>
                </div>

                <div class="p-4 rounded-xl border border-gray-200 flex items-start gap-4">
                    <input type="checkbox" name="pickup_enabled" value="1" id="pickup_enabled" class="mt-1 w-5 h-5 text-indigo-600 rounded" <?= !empty($delivery['pickup_enabled']) ? 'checked' : '' ?>>
                    <div>
                        <label for="pickup_enabled" class="font-bold text-gray-900 text-sm cursor-pointer">Retrait en Boutique (Click & Collect)</label>
                        <p class="text-xs text-gray-500 mt-0.5">Permet aux acheteurs de récupérer leurs colis directement en magasin sans frais de port.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Livraison Gratuite à partir de (FCFA)</label>
                    <input type="number" name="free_shipping_threshold" value="<?= (int)($delivery['free_shipping_threshold'] ?? 0) ?>"
                           placeholder="0 = Pas de gratuité automatique"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    <p class="text-xs text-gray-500 mt-1">Exemple : 50 000 FCFA pour offrir la livraison aux gros paniers.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Adresse du point de retrait physique</label>
                    <input type="text" name="pickup_address" value="<?= htmlspecialchars($delivery['pickup_address'] ?? '') ?>"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Instructions de livraison affichées aux clients</label>
                    <textarea name="instructions" rows="2"
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"><?= htmlspecialchars($delivery['instructions'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow transition-all">
                    Enregistrer les modalités
                </button>
            </div>
        </form>

        <!-- 2. Grille des zones et tarifs par quartier -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">map</span> Quartiers desservis & Tarifs
                </span>
                <span class="text-xs font-medium text-gray-500"><?= count($delivery['zones'] ?? []) ?> zones configurées</span>
            </h2>

            <!-- Formulaire d'ajout rapide de zone -->
            <form method="POST" action="/admin/parametres/livraison/zones/ajouter" class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6 flex flex-wrap gap-4 items-end">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <div class="flex-1 min-w-[140px]">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ville</label>
                    <input type="text" name="city" value="Douala" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Quartier / Zone *</label>
                    <input type="text" name="district" placeholder="ex: Bonapriso, Akwa, Bonamoussadi" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div class="w-36">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tarif (FCFA)</label>
                    <input type="number" name="fee" value="1500" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div class="w-40">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Délai estimé</label>
                    <input type="text" name="estimated_time" value="24h" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-sm flex items-center gap-1 shadow">
                    <span class="material-symbols-outlined text-base">add</span> Ajouter
                </button>
            </form>

            <!-- Tableau des zones -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 font-semibold text-xs uppercase">
                            <th class="py-3 px-4">Ville</th>
                            <th class="py-3 px-4">Quartier / Zone</th>
                            <th class="py-3 px-4">Frais de livraison</th>
                            <th class="py-3 px-4">Délai estimé</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($delivery['zones'])): ?>
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400">Aucun quartier personnalisé défini. Le forfait par défaut de 1 500 FCFA s'applique.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($delivery['zones'] as $zone): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-medium text-gray-900"><?= htmlspecialchars($zone['city'] ?? '') ?></td>
                                    <td class="py-3 px-4 font-bold text-indigo-900"><?= htmlspecialchars($zone['district'] ?? '') ?></td>
                                    <td class="py-3 px-4 font-bold text-emerald-600"><?= number_format((int)$zone['fee'], 0, ',', ' ') ?> FCFA</td>
                                    <td class="py-3 px-4 text-gray-500"><?= htmlspecialchars($zone['estimated_time'] ?? '24h') ?></td>
                                    <td class="py-3 px-4 text-right">
                                        <form method="POST" action="/admin/parametres/livraison/zones/<?= (int)$zone['id'] ?>/supprimer" onsubmit="return confirm('Supprimer ce quartier ?');" class="inline">
                                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 p-1" title="Supprimer">
                                                <span class="material-symbols-outlined text-base">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
