<?php
$active_tab = 'orders';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gestion des Commandes — Marvens Shop</title>
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
                
                <!-- En-tête avec compteur total -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Gestion des Commandes</h1>
                        <p class="text-sm text-outline">Suivi, filtrage par statut/période, recherche client et traitement des commandes</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs bg-surface-container-high text-on-surface font-semibold px-3 py-1.5 rounded-xl border border-border">
                            Total : <?= (int)($total_count ?? count($orders)) ?> commande(s)
                        </span>
                        <a href="/admin/statistiques" class="inline-flex items-center gap-1.5 bg-primary text-white px-3.5 py-1.5 rounded-xl text-xs font-semibold hover:opacity-90 transition-all">
                            <span class="material-symbols-outlined text-[16px]">query_stats</span> Statistiques
                        </a>
                    </div>
                </div>

                <!-- 8.2 & 8.3 Filtres de Statut Rapide -->
                <div class="flex flex-wrap items-center gap-1.5 bg-surface p-2.5 rounded-2xl border border-border text-xs shadow-sm">
                    <span class="text-outline font-semibold px-2">Statut :</span>
                    <a href="/admin/commandes" class="px-3 py-1.5 rounded-xl <?= empty($current_status) ? 'bg-primary text-white font-semibold' : 'text-outline hover:text-on-surface bg-surface-container-low' ?>">
                        Tous (<?= (int)($status_counts['total'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=pending" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'pending') ? 'bg-amber-600 text-white font-semibold' : 'text-amber-800 bg-amber-50 hover:bg-amber-100' ?>">
                        En attente (<?= (int)($status_counts['pending'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=confirmed" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'confirmed') ? 'bg-blue-600 text-white font-semibold' : 'text-blue-800 bg-blue-50 hover:bg-blue-100' ?>">
                        Confirmées (<?= (int)($status_counts['confirmed'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=payment_pending" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'payment_pending') ? 'bg-orange-600 text-white font-semibold' : 'text-orange-800 bg-orange-50 hover:bg-orange-100' ?>">
                        Paiement att. (<?= (int)($status_counts['payment_pending'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=paid" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'paid') ? 'bg-teal-600 text-white font-semibold' : 'text-teal-800 bg-teal-50 hover:bg-teal-100' ?>">
                        Payées (<?= (int)($status_counts['paid'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=preparing" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'preparing') ? 'bg-indigo-600 text-white font-semibold' : 'text-indigo-800 bg-indigo-50 hover:bg-indigo-100' ?>">
                        En prép. (<?= (int)($status_counts['preparing'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=shipped" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'shipped') ? 'bg-purple-600 text-white font-semibold' : 'text-purple-800 bg-purple-50 hover:bg-purple-100' ?>">
                        Expédiées (<?= (int)($status_counts['shipped'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=delivered" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'delivered') ? 'bg-emerald-600 text-white font-semibold' : 'text-emerald-800 bg-emerald-50 hover:bg-emerald-100' ?>">
                        Livrées (<?= (int)($status_counts['delivered'] ?? 0) ?>)
                    </a>
                    <a href="/admin/commandes?status=cancelled" class="px-3 py-1.5 rounded-xl <?= ($current_status === 'cancelled') ? 'bg-red-600 text-white font-semibold' : 'text-red-800 bg-red-50 hover:bg-red-100' ?>">
                        Annulées (<?= (int)($status_counts['cancelled'] ?? 0) ?>)
                    </a>
                </div>

                <!-- 8.2 Formulaire de Recherche et Filtrage Avancé -->
                <form method="GET" action="/admin/commandes" class="bg-surface p-space-md rounded-2xl border border-border grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 shadow-sm text-xs">
                    <div>
                        <label class="block text-outline font-semibold uppercase mb-1">Recherche</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($current_search ?? '') ?>" placeholder="N° commande, client, tel..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-on-surface">
                    </div>
                    <div>
                        <label class="block text-outline font-semibold uppercase mb-1">Statut Paiement</label>
                        <select name="payment_status" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-on-surface">
                            <option value="">Tous</option>
                            <option value="unpaid" <?= ($current_payment_status ?? '') === 'unpaid' ? 'selected' : '' ?>>Non payé</option>
                            <option value="pending" <?= ($current_payment_status ?? '') === 'pending' ? 'selected' : '' ?>>En attente</option>
                            <option value="paid" <?= ($current_payment_status ?? '') === 'paid' ? 'selected' : '' ?>>Payé</option>
                            <option value="refunded" <?= ($current_payment_status ?? '') === 'refunded' ? 'selected' : '' ?>>Remboursé</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-outline font-semibold uppercase mb-1">Mode Livraison</label>
                        <select name="delivery_mode" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-on-surface">
                            <option value="">Tous</option>
                            <option value="delivery" <?= ($current_delivery_mode ?? '') === 'delivery' ? 'selected' : '' ?>>Livraison à domicile</option>
                            <option value="pickup" <?= ($current_delivery_mode ?? '') === 'pickup' ? 'selected' : '' ?>>Retrait en boutique</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-outline font-semibold uppercase mb-1">Date début</label>
                        <input type="date" name="date_from" value="<?= htmlspecialchars($current_date_from ?? '') ?>" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-on-surface">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-primary text-white py-2 rounded-xl font-semibold hover:opacity-90 transition-all">
                            Filtrer
                        </button>
                        <a href="/admin/commandes" class="px-3 py-2 border border-border rounded-xl hover:bg-surface-container-low font-semibold text-center" title="Réinitialiser">
                            <span class="material-symbols-outlined text-[16px]">refresh</span>
                        </a>
                    </div>
                </form>

                <!-- Tableau des Commandes (8.2 Liste des commandes) -->
                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-xs font-semibold uppercase text-outline border-b border-border">
                                <th class="py-3 px-4">Numéro</th>
                                <th class="py-3 px-4">Date</th>
                                <th class="py-3 px-4">Client</th>
                                <th class="py-3 px-4">Adresse & Quartier</th>
                                <th class="py-3 px-4">Livraison</th>
                                <th class="py-3 px-4">Paiement</th>
                                <th class="py-3 px-4">Montant</th>
                                <th class="py-3 px-4">Statut</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm text-on-surface">
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="9" class="py-12 text-center text-outline">
                                        Aucune commande trouvée selon les critères sélectionnés.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $ord): ?>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="py-3 px-4 font-semibold text-primary">
                                            <a href="/admin/commandes/<?= (int) $ord['id'] ?>" class="hover:underline">
                                                #<?= htmlspecialchars($ord['order_number']) ?>
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 text-xs text-outline">
                                            <?= htmlspecialchars(date('d/m/Y H:i', strtotime($ord['created_at']))) ?>
                                        </td>
                                        <td class="py-3 px-4 font-medium">
                                            <div><?= htmlspecialchars($ord['customer_name']) ?></div>
                                            <span class="text-xs text-outline"><?= htmlspecialchars($ord['customer_whatsapp']) ?></span>
                                        </td>
                                        <td class="py-3 px-4 text-xs text-outline">
                                            <?= htmlspecialchars(($ord['delivery_city'] ?? '') . (!empty($ord['delivery_district']) ? ' (' . $ord['delivery_district'] . ')' : '')) ?>
                                        </td>
                                        <td class="py-3 px-4 text-xs">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container text-on-surface">
                                                <?= $ord['delivery_mode'] === 'pickup' ? 'Retrait' : 'Domicile' ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-xs">
                                            <span class="font-semibold uppercase text-[11px] <?= $ord['payment_status'] === 'paid' ? 'text-teal-700' : 'text-amber-700' ?>">
                                                <?= htmlspecialchars($ord['payment_status']) ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 font-semibold">
                                            <?= number_format((float)$ord['total_amount'], 0, ',', ' ') ?> FCFA
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border <?= \App\Domain\Entities\Order::getStatusBadgeClass($ord['order_status']) ?>">
                                                <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($ord['order_status'])) ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="/admin/commandes/<?= (int) $ord['id'] ?>" class="inline-flex items-center gap-1 bg-primary text-white px-3 py-1.5 rounded-xl text-xs font-semibold hover:opacity-90 transition-all">
                                                Détails &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php if (($total_pages ?? 1) > 1): ?>
                        <div class="p-space-md border-t border-border flex items-center justify-between text-xs text-outline">
                            <span>Page <?= (int)($current_page ?? 1) ?> sur <?= (int)$total_pages ?></span>
                            <div class="flex items-center gap-1">
                                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                    <a href="?page=<?= $p ?>&status=<?= urlencode((string)($current_status ?? '')) ?>&search=<?= urlencode((string)($current_search ?? '')) ?>" class="px-2.5 py-1 rounded-lg border border-border <?= ($p === ($current_page ?? 1)) ? 'bg-primary text-white font-bold' : 'hover:bg-surface-container-low' ?>">
                                        <?= $p ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
