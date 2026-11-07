<?php
$active_tab = 'statistics';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Statistiques Commerciales — Marvens Shop</title>
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

    <div class="md:pl-72 min-h-screen flex flex-col pb-16 md:pb-0">
        <?php include dirname(__DIR__) . '/partials/header.php';
        include dirname(__DIR__) . '/partials/bottom_nav.php'; ?>

        <main class="relative pt-16 bg-background min-h-screen p-space-lg">
            <div class="max-w-7xl mx-auto flex flex-col gap-space-lg">
                
                <!-- En-tête des Statistiques Commerciales (Module 8.5) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Statistiques & Analyse Commerciale</h1>
                        <p class="text-sm text-outline">Indicateurs de performance, chiffre d'affaires certifié, suivi des paiements et livraisons</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="/admin/commandes" class="inline-flex items-center gap-1.5 bg-surface-container-high text-on-surface px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-highest transition-all border border-border">
                            <span class="material-symbols-outlined text-[16px]">shopping_bag</span> Voir les commandes
                        </a>
                    </div>
                </div>

                <!-- 8.5 Indicateurs Clés & Chiffre d'Affaires certifié (MS-BIZ-08 / T-026) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                    <!-- CA Certifié (Payé ou Livré) -->
                    <div class="bg-surface rounded-2xl p-space-lg border border-border shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-outline uppercase tracking-wider">Chiffre d'affaires certifié</span>
                            <span class="material-symbols-outlined text-emerald-600">verified</span>
                        </div>
                        <div class="my-space-md">
                            <h2 class="text-3xl font-black text-on-surface"><?= number_format((float)($stats['revenue_certified'] ?? 0), 0, ',', ' ') ?> FCFA</h2>
                            <p class="text-xs text-emerald-700 mt-1 font-semibold">
                                Strictement calculé sur les commandes payées ou livrées (T-026).
                            </p>
                        </div>
                        <div class="text-[11px] text-outline pt-2 border-t border-border">
                            Volume brut engagé : <span class="font-bold text-on-surface"><?= number_format((float)($stats['revenue_potential'] ?? 0), 0, ',', ' ') ?> FCFA</span>
                        </div>
                    </div>

                    <!-- Volume de Commandes -->
                    <div class="bg-surface rounded-2xl p-space-lg border border-border shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-outline uppercase tracking-wider">Total des commandes</span>
                            <span class="material-symbols-outlined text-blue-600">shopping_cart</span>
                        </div>
                        <div class="my-space-md">
                            <h2 class="text-3xl font-black text-on-surface"><?= (int)($status_counts['total'] ?? 0) ?></h2>
                            <p class="text-xs text-outline mt-1">
                                Dont <span class="text-amber-600 font-bold"><?= (int)($status_counts['pending'] ?? 0) ?></span> en attente de confirmation WhatsApp.
                            </p>
                        </div>
                        <div class="text-[11px] text-outline pt-2 border-t border-border">
                            Livrées : <span class="font-bold text-emerald-700"><?= (int)($status_counts['delivered'] ?? 0) ?></span> | Payées : <span class="font-bold text-teal-700"><?= (int)($status_counts['paid'] ?? 0) ?></span>
                        </div>
                    </div>

                    <!-- Total Clients Enregistrés -->
                    <div class="bg-surface rounded-2xl p-space-lg border border-border shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-outline uppercase tracking-wider">Base Clients Enregistrée</span>
                            <span class="material-symbols-outlined text-secondary">people</span>
                        </div>
                        <div class="my-space-md">
                            <h2 class="text-3xl font-black text-on-surface"><?= (int)($total_customers ?? 0) ?></h2>
                            <p class="text-xs text-outline mt-1">
                                Clients uniques avec numéro WhatsApp et adresse.
                            </p>
                        </div>
                        <div class="pt-2 border-t border-border">
                            <a href="/admin/clients" class="text-xs text-secondary font-semibold hover:underline flex items-center justify-between">
                                <span>Consulter le fichier clients</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 8.5 Produits les plus commandés (Top 10) & Promotions Actives -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
                    <!-- Top Produits -->
                    <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                        <div class="p-space-md border-b border-border bg-surface-container-low font-bold text-sm flex items-center justify-between">
                            <span>Produits les plus commandés</span>
                            <span class="text-xs text-outline font-normal">Par volume d'articles vendus</span>
                        </div>
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="text-xs uppercase font-semibold text-outline border-b border-border bg-surface-container-low">
                                    <th class="p-3">Produit</th>
                                    <th class="p-3 text-center">Quantité</th>
                                    <th class="p-3 text-right">Volume (FCFA)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border text-on-surface text-xs">
                                <?php if (empty($stats['top_products'])): ?>
                                    <tr>
                                        <td colspan="3" class="p-6 text-center text-outline">
                                            Aucune vente enregistrée pour le moment.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($stats['top_products'] as $tp): ?>
                                        <tr class="hover:bg-surface-container-low/50">
                                            <td class="p-3 font-semibold text-primary">
                                                <?= htmlspecialchars($tp['product_name']) ?>
                                                <?php if (!empty($tp['variant_info'])): ?>
                                                    <span class="text-[11px] text-outline block font-normal"><?= htmlspecialchars($tp['variant_info']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="p-3 text-center font-bold">
                                                <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface">
                                                    <?= (int)$tp['total_quantity'] ?>
                                                </span>
                                            </td>
                                            <td class="p-3 text-right font-bold text-on-surface">
                                                <?= number_format((float)$tp['total_volume'], 0, ',', ' ') ?> FCFA
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Promotions Actives (8.5 Promotions actives) -->
                    <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                        <div class="p-space-md border-b border-border bg-surface-container-low font-bold text-sm flex items-center justify-between">
                            <span>Promotions Actives en Boutique</span>
                            <a href="/admin/produits" class="text-xs text-secondary font-semibold hover:underline">Gérer le catalogue &rarr;</a>
                        </div>
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="text-xs uppercase font-semibold text-outline border-b border-border bg-surface-container-low">
                                    <th class="p-3">Article</th>
                                    <th class="p-3 text-right">Prix normal</th>
                                    <th class="p-3 text-right">Prix promo</th>
                                    <th class="p-3 text-right">Économie</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border text-on-surface text-xs">
                                <?php if (empty($active_promos)): ?>
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-outline">
                                            Aucune promotion active pour le moment.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($active_promos as $promo): ?>
                                        <tr class="hover:bg-surface-container-low/50">
                                            <td class="p-3 font-semibold text-primary">
                                                <a href="/admin/produits/<?= (int)$promo['id'] ?>/modifier" class="hover:underline">
                                                    <?= htmlspecialchars($promo['name']) ?>
                                                </a>
                                            </td>
                                            <td class="p-3 text-right line-through text-outline">
                                                <?= number_format((float)$promo['price'], 0, ',', ' ') ?> FCFA
                                            </td>
                                            <td class="p-3 text-right font-bold text-emerald-700">
                                                <?= number_format((float)$promo['promotional_price'], 0, ',', ' ') ?> FCFA
                                            </td>
                                            <td class="p-3 text-right font-bold text-amber-700">
                                                - <?= number_format((float)($promo['price'] - $promo['promotional_price']), 0, ',', ' ') ?> FCFA
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 8.5 Suivi des Paiements & Suivi des Livraisons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <!-- Suivi des paiements -->
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-md flex items-center gap-2">
                            <span class="material-symbols-outlined text-teal-600">account_balance_wallet</span> Suivi des Règlements & Paiements
                        </h3>
                        <div class="space-y-3">
                            <?php foreach ($stats['payment_tracking'] as $pt): ?>
                                <div class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-border text-xs">
                                    <div>
                                        <span class="font-bold uppercase text-on-surface"><?= htmlspecialchars($pt['payment_status']) ?></span>
                                        <span class="text-outline block text-[11px]"><?= (int)$pt['count_orders'] ?> commande(s)</span>
                                    </div>
                                    <div class="font-black text-sm text-on-surface">
                                        <?= number_format((float)$pt['sum_amount'], 0, ',', ' ') ?> FCFA
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Suivi des livraisons -->
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-md flex items-center gap-2">
                            <span class="material-symbols-outlined text-purple-600">local_shipping</span> Suivi des Modes & Livraisons
                        </h3>
                        <div class="space-y-3">
                            <?php foreach ($stats['delivery_tracking'] as $dt): ?>
                                <div class="flex items-center justify-between p-3 rounded-xl bg-surface-container-low border border-border text-xs">
                                    <div>
                                        <span class="font-bold text-on-surface"><?= $dt['delivery_mode'] === 'pickup' ? 'Retrait boutique' : 'Livraison domicile' ?></span>
                                        <span class="text-outline block text-[11px]">Statut commande : <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($dt['order_status'])) ?></span>
                                    </div>
                                    <div class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface font-bold text-xs">
                                        <?= (int)$dt['count_orders'] ?> commande(s)
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
