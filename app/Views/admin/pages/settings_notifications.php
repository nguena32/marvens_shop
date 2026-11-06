<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Notifications — Paramètres Marvens Shop</title>
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
                    <span class="text-indigo-600">Module 5.5</span>
                </div>
                <h1 class="text-3xl font-extrabold font-['Space_Grotesk'] text-gray-900">Notifications & Alertes</h1>
                <p class="text-sm text-gray-500 mt-1">Gérez l'envoi des notifications aux acheteurs et alertes administratives par canal.</p>
            </div>
        </header>

        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/parametres/notifications" class="space-y-8">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <!-- 1. Notifications Clients -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">person_pin</span> Notifications Acheteurs (Cycle Commande)
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-gray-500 font-semibold text-xs uppercase">
                                <th class="py-3 px-4">Événement déclencheur</th>
                                <th class="py-3 px-4 text-center">Canal E-mail</th>
                                <th class="py-3 px-4 text-center">Canal WhatsApp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="py-3 px-4 font-medium text-gray-800">Confirmation de commande</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_confirmation_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['order_confirmation_email']) ? 'checked' : '' ?>>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_confirmation_whatsapp" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($notifications['order_confirmation_whatsapp']) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-medium text-gray-800">Commande en préparation</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_preparing_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['order_preparing_email']) ? 'checked' : '' ?>>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_preparing_whatsapp" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($notifications['order_preparing_whatsapp']) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-medium text-gray-800">Commande expédiée / prête</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_shipped_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['order_shipped_email']) ? 'checked' : '' ?>>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_shipped_whatsapp" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($notifications['order_shipped_whatsapp']) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-medium text-gray-800">Commande livrée</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_delivered_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['order_delivered_email']) ? 'checked' : '' ?>>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_delivered_whatsapp" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($notifications['order_delivered_whatsapp']) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-medium text-gray-800">Commande annulée</td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_cancelled_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['order_cancelled_email']) ? 'checked' : '' ?>>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <input type="checkbox" name="order_cancelled_whatsapp" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($notifications['order_cancelled_whatsapp']) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 2. Notifications Administrateur -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-600">notifications_active</span> Alertes Administrateur & Commerçant
                </h2>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <span class="font-bold text-gray-900 text-sm">Nouvelle commande passée</span>
                            <p class="text-xs text-gray-500">Alerte instantanée dès qu'une commande est enregistrée dans le panier.</p>
                        </div>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                                <input type="checkbox" name="admin_new_order_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['admin_new_order_email']) ? 'checked' : '' ?>> E-mail
                            </label>
                            <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                                <input type="checkbox" name="admin_new_order_whatsapp" value="1" class="w-4 h-4 text-emerald-600 rounded" <?= !empty($notifications['admin_new_order_whatsapp']) ? 'checked' : '' ?>> WhatsApp
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <span class="font-bold text-gray-900 text-sm">Alerte Stock Faible</span>
                            <p class="text-xs text-gray-500">Alerte dès qu'une variante produit descend sous 3 unités.</p>
                        </div>
                        <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                            <input type="checkbox" name="admin_low_stock_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['admin_low_stock_email']) ? 'checked' : '' ?>> E-mail
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div>
                            <span class="font-bold text-gray-900 text-sm">Produit Épuisé</span>
                            <p class="text-xs text-gray-500">Notification en cas de rupture de stock totale.</p>
                        </div>
                        <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                            <input type="checkbox" name="admin_out_of_stock_email" value="1" class="w-4 h-4 text-indigo-600 rounded" <?= !empty($notifications['admin_out_of_stock_email']) ? 'checked' : '' ?>> E-mail
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow transition-all">
                    Enregistrer les préférences
                </button>
            </div>
        </form>
    </main>
</body>
</html>
