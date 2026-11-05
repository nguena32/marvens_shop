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
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Gestion des Commandes</h1>
                        <p class="text-sm text-outline">Suivi des commandes, facturation et interactions WhatsApp clients</p>
                    </div>

                    <!-- Filtres -->
                    <div class="flex items-center gap-1 bg-surface-container-low p-1 rounded-xl border border-border text-xs font-medium">
                        <a href="/admin/commandes" class="px-3 py-1.5 rounded-lg <?= empty($current_status) ? 'bg-surface text-on-surface shadow-sm font-semibold' : 'text-outline hover:text-on-surface' ?>">Toutes</a>
                        <a href="/admin/commandes?status=pending" class="px-3 py-1.5 rounded-lg <?= ($current_status === 'pending') ? 'bg-surface text-on-surface shadow-sm font-semibold' : 'text-outline hover:text-on-surface' ?>">En attente</a>
                        <a href="/admin/commandes?status=confirmed" class="px-3 py-1.5 rounded-lg <?= ($current_status === 'confirmed') ? 'bg-surface text-on-surface shadow-sm font-semibold' : 'text-outline hover:text-on-surface' ?>">Confirmées</a>
                        <a href="/admin/commandes?status=shipped" class="px-3 py-1.5 rounded-lg <?= ($current_status === 'shipped') ? 'bg-surface text-on-surface shadow-sm font-semibold' : 'text-outline hover:text-on-surface' ?>">Expédiées</a>
                        <a href="/admin/commandes?status=delivered" class="px-3 py-1.5 rounded-lg <?= ($current_status === 'delivered') ? 'bg-surface text-on-surface shadow-sm font-semibold' : 'text-outline hover:text-on-surface' ?>">Livrées</a>
                    </div>
                </div>

                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-xs font-semibold uppercase text-outline border-b border-border">
                                <th class="py-3 px-4">Référence</th>
                                <th class="py-3 px-4">Date</th>
                                <th class="py-3 px-4">Client</th>
                                <th class="py-3 px-4">WhatsApp</th>
                                <th class="py-3 px-4">Livraison</th>
                                <th class="py-3 px-4">Total</th>
                                <th class="py-3 px-4">Statut</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm text-on-surface">
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="8" class="py-12 text-center text-outline">
                                        Aucune commande trouvée.
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
                                        <td class="py-3 px-4 font-medium"><?= htmlspecialchars($ord['customer_name']) ?></td>
                                        <td class="py-3 px-4 text-outline"><?= htmlspecialchars($ord['customer_whatsapp']) ?></td>
                                        <td class="py-3 px-4 text-xs">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container text-on-surface">
                                                <?= $ord['delivery_mode'] === 'pickup' ? 'Retrait boutique' : 'Livraison' ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 font-semibold">
                                            <?= number_format((float)$ord['total_amount'], 0, ',', ' ') ?> FCFA
                                        </td>
                                        <td class="py-3 px-4">
                                            <?php
                                                $badgeClass = match($ord['order_status']) {
                                                    'pending' => 'bg-amber-100 text-amber-800',
                                                    'confirmed' => 'bg-blue-100 text-blue-800',
                                                    'shipped' => 'bg-purple-100 text-purple-800',
                                                    'delivered' => 'bg-emerald-100 text-emerald-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                                $label = match($ord['order_status']) {
                                                    'pending' => 'En attente',
                                                    'confirmed' => 'Confirmée',
                                                    'shipped' => 'Expédiée',
                                                    'delivered' => 'Livrée',
                                                    'cancelled' => 'Annulée',
                                                    default => htmlspecialchars($ord['order_status']),
                                                };
                                            ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?= $badgeClass ?>">
                                                <?= $label ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="/admin/commandes/<?= (int) $ord['id'] ?>" class="inline-flex items-center gap-1 bg-primary text-on-primary px-3 py-1 rounded-lg text-xs font-medium hover:bg-surface-container-high hover:text-on-surface transition-all">
                                                Traiter
                                            </a>
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
