<?php
$active_tab = 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_dashboard" name="shell-type"/>
    <title>Administration — Tableau de Bord Marvens Shop</title>
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
            main > :first-child { margin-top:0!important; }
            main > :last-child { margin-bottom:0!important; }
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
                        "inverse-surface": "#303032",
                        "tertiary-container": "#271901",
                        "on-error-container": "#93000a",
                        "on-background": "#1b1b1d",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#663500",
                        "surface-container": "#f0edef",
                        "on-surface": "#1b1b1d",
                        "secondary": "#904d00",
                        "surface-container-highest": "#e4e2e4",
                        "surface-container-high": "#eae7e9",
                        "surface": "#FFFFFF",
                        "background": "#F8FAFC",
                        "border": "#E2E8F0",
                        "error": "#ba1a1a"
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                    spacing: { "space-sm": "8px", "space-lg": "24px", "space-xs": "4px", "margin": "32px", "space-xl": "48px", "space-md": "16px" },
                    fontFamily: { "body-md": ["Inter"], "headline-md": ["Inter"], "headline-lg": ["Inter"], "headline-sm": ["Inter"] }
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

        <main class="relative pt-16 bg-background min-h-screen">
            <div class="flex flex-col w-full p-space-lg space-y-space-lg">
                
                <!-- En-tête avec raccourcis d'accès rapide (Module 8.1) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Tableau de Bord Commercial</h1>
                        <p class="text-sm text-outline">Supervision globale, accès direct aux commandes, catalogue, clients et réglages</p>
                    </div>

                    <!-- 8.1 Raccourcis d'accès rapide -->
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="/admin/commandes" class="inline-flex items-center gap-1.5 bg-primary text-white px-3.5 py-2 rounded-xl text-xs font-semibold hover:opacity-90 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">shopping_bag</span> Commandes (<?= (int)$total_orders ?>)
                        </a>
                        <a href="/admin/produits" class="inline-flex items-center gap-1.5 bg-surface-container-high text-on-surface px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-highest transition-all border border-border">
                            <span class="material-symbols-outlined text-[16px]">inventory_2</span> Catalogue
                        </a>
                        <a href="/admin/clients" class="inline-flex items-center gap-1.5 bg-surface-container-high text-on-surface px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-highest transition-all border border-border">
                            <span class="material-symbols-outlined text-[16px]">group</span> Clients (<?= (int)($total_customers ?? 0) ?>)
                        </a>
                        <a href="/admin/parametres/boutique" class="inline-flex items-center gap-1.5 bg-surface-container-high text-on-surface px-3.5 py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-highest transition-all border border-border">
                            <span class="material-symbols-outlined text-[16px]">settings</span> Paramètres
                        </a>
                    </div>
                </div>

                <!-- 8.1 Cartes d'indicateurs clés & Chiffre d'Affaires certifié -->
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
                    <!-- CA Réalisé (Payé ou Livré) -->
                    <div class="bg-surface rounded-2xl p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-outline uppercase tracking-wider">CA Réalisé (Payé / Livré)</span>
                            <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">payments</span>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-2xl font-bold text-on-surface"><?= number_format($total_revenue ?? 0, 0, ',', ' ') ?> FCFA</h3>
                            <span class="text-xs text-emerald-600 flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">verified</span> Règle MS-BIZ-08 conforme
                            </span>
                        </div>
                        <div class="text-[11px] text-outline">
                            Potentiel brut engagé : <span class="font-semibold text-on-surface"><?= number_format($revenue_potential ?? 0, 0, ',', ' ') ?> FCFA</span>
                        </div>
                    </div>

                    <!-- Commandes en attente -->
                    <div class="bg-surface rounded-2xl p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-outline uppercase tracking-wider">En attente (Pending)</span>
                            <span class="material-symbols-outlined text-amber-500" style="font-variation-settings: 'FILL' 1;">hourglass_empty</span>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-2xl font-bold text-amber-600"><?= (int) ($pending_orders ?? 0) ?></h3>
                            <span class="text-xs text-outline mt-1 block">Nécessite contact WhatsApp</span>
                        </div>
                        <a href="/admin/commandes?status=pending" class="flex items-center justify-between text-xs text-secondary font-semibold hover:underline">
                            <span>Traiter les attentes</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Commandes payées & confirmées -->
                    <div class="bg-surface rounded-2xl p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-outline uppercase tracking-wider">Payées / Confirmées</span>
                            <span class="material-symbols-outlined text-blue-600" style="font-variation-settings: 'FILL' 1;">task_alt</span>
                        </div>
                        <div class="my-space-md">
                            <div class="flex items-baseline gap-2">
                                <h3 class="text-2xl font-bold text-on-surface"><?= (int)($paid_orders ?? 0) ?> <span class="text-xs font-normal text-outline">payées</span></h3>
                                <span class="text-sm font-semibold text-blue-600">/ <?= (int)($confirmed_orders ?? 0) ?> <span class="text-xs font-normal text-outline">conf.</span></span>
                            </div>
                            <span class="text-xs text-outline mt-1 block">Préparation ou expédition prête</span>
                        </div>
                        <a href="/admin/commandes?status=confirmed" class="flex items-center justify-between text-xs text-blue-600 font-semibold hover:underline">
                            <span>Voir le carnet actif</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>

                    <!-- Commandes livrées -->
                    <div class="bg-surface rounded-2xl p-space-md shadow-sm border border-border flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-outline uppercase tracking-wider">Livrées (Finalisées)</span>
                            <span class="material-symbols-outlined text-emerald-600" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                        </div>
                        <div class="my-space-md">
                            <h3 class="text-2xl font-bold text-emerald-700"><?= (int) ($delivered_orders ?? 0) ?></h3>
                            <span class="text-xs text-emerald-600 mt-1 block">Remises aux clients avec succès</span>
                        </div>
                        <a href="/admin/commandes?status=delivered" class="flex items-center justify-between text-xs text-emerald-700 font-semibold hover:underline">
                            <span>Consulter les archives</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </section>

                <!-- 8.1 & 8.3 Grille Complète des 8 Statuts du Cahier des Charges -->
                <section class="bg-surface rounded-2xl p-space-lg border border-border shadow-sm">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-sm mb-space-md border-b border-border pb-3">
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Répartition Complète des Commandes par Statut (Section 8.1 & 8.3)</h3>
                            <p class="text-xs text-outline">Cycle de traitement de bout en bout des 8 états officiels</p>
                        </div>
                        <a href="/admin/statistiques" class="text-xs text-secondary font-semibold hover:underline flex items-center gap-1">
                            Rapport statistiques complet <span class="material-symbols-outlined text-sm">query_stats</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                        <!-- 1. En attente -->
                        <a href="/admin/commandes?status=pending" class="p-3 rounded-xl border border-amber-200 bg-amber-50 hover:bg-amber-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-amber-800">En attente</span>
                            <span class="text-2xl font-black text-amber-900 mt-1"><?= (int)($status_counts['pending'] ?? 0) ?></span>
                        </a>

                        <!-- 2. Confirmée -->
                        <a href="/admin/commandes?status=confirmed" class="p-3 rounded-xl border border-blue-200 bg-blue-50 hover:bg-blue-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-blue-800">Confirmée</span>
                            <span class="text-2xl font-black text-blue-900 mt-1"><?= (int)($status_counts['confirmed'] ?? 0) ?></span>
                        </a>

                        <!-- 3. Paiement en attente -->
                        <a href="/admin/commandes?status=payment_pending" class="p-3 rounded-xl border border-orange-200 bg-orange-50 hover:bg-orange-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-orange-800">Paiement att.</span>
                            <span class="text-2xl font-black text-orange-900 mt-1"><?= (int)($status_counts['payment_pending'] ?? 0) ?></span>
                        </a>

                        <!-- 4. Payée -->
                        <a href="/admin/commandes?status=paid" class="p-3 rounded-xl border border-teal-200 bg-teal-50 hover:bg-teal-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-teal-800">Payée</span>
                            <span class="text-2xl font-black text-teal-900 mt-1"><?= (int)($status_counts['paid'] ?? 0) ?></span>
                        </a>

                        <!-- 5. En préparation -->
                        <a href="/admin/commandes?status=preparing" class="p-3 rounded-xl border border-indigo-200 bg-indigo-50 hover:bg-indigo-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-indigo-800">En prép.</span>
                            <span class="text-2xl font-black text-indigo-900 mt-1"><?= (int)($status_counts['preparing'] ?? 0) ?></span>
                        </a>

                        <!-- 6. Expédiée -->
                        <a href="/admin/commandes?status=shipped" class="p-3 rounded-xl border border-purple-200 bg-purple-50 hover:bg-purple-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-purple-800">Expédiée</span>
                            <span class="text-2xl font-black text-purple-900 mt-1"><?= (int)($status_counts['shipped'] ?? 0) ?></span>
                        </a>

                        <!-- 7. Livrée -->
                        <a href="/admin/commandes?status=delivered" class="p-3 rounded-xl border border-emerald-200 bg-emerald-50 hover:bg-emerald-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-emerald-800">Livrée</span>
                            <span class="text-2xl font-black text-emerald-900 mt-1"><?= (int)($status_counts['delivered'] ?? 0) ?></span>
                        </a>

                        <!-- 8. Annulée -->
                        <a href="/admin/commandes?status=cancelled" class="p-3 rounded-xl border border-red-200 bg-red-50 hover:bg-red-100 transition-all flex flex-col">
                            <span class="text-[11px] font-semibold text-red-800">Annulée</span>
                            <span class="text-2xl font-black text-red-900 mt-1"><?= (int)($status_counts['cancelled'] ?? 0) ?></span>
                        </a>
                    </div>
                </section>

                <!-- Section 3: Interactive Recent Orders Table -->
                <section class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <div class="p-space-lg border-b border-border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-md">
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Commandes Récentes</h3>
                            <p class="text-xs text-outline">Suivi en temps réel des flux clients et interactions WhatsApp</p>
                        </div>
                        
                        <!-- Status Filters -->
                        <div class="flex flex-wrap items-center gap-1 bg-surface-container-low p-1 rounded-xl border border-border text-xs">
                            <a href="/admin/dashboard" class="px-3 py-1.5 rounded-lg <?= empty($current_filter) ? 'bg-surface text-on-surface font-semibold shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Toutes</a>
                            <a href="/admin/dashboard?status=pending" class="px-3 py-1.5 rounded-lg <?= ($current_filter === 'pending') ? 'bg-surface text-on-surface font-semibold shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">En attente</a>
                            <a href="/admin/dashboard?status=confirmed" class="px-3 py-1.5 rounded-lg <?= ($current_filter === 'confirmed') ? 'bg-surface text-on-surface font-semibold shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Confirmées</a>
                            <a href="/admin/dashboard?status=paid" class="px-3 py-1.5 rounded-lg <?= ($current_filter === 'paid') ? 'bg-surface text-on-surface font-semibold shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Payées</a>
                            <a href="/admin/dashboard?status=shipped" class="px-3 py-1.5 rounded-lg <?= ($current_filter === 'shipped') ? 'bg-surface text-on-surface font-semibold shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Expédiées</a>
                            <a href="/admin/dashboard?status=delivered" class="px-3 py-1.5 rounded-lg <?= ($current_filter === 'delivered') ? 'bg-surface text-on-surface font-semibold shadow-sm' : 'text-outline hover:text-on-surface' ?> transition-all">Livrées</a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-surface-container-low text-xs uppercase font-semibold text-outline border-b border-border">
                                    <th class="py-3 px-4">Commande</th>
                                    <th class="py-3 px-4">Client</th>
                                    <th class="py-3 px-4">Localisation</th>
                                    <th class="py-3 px-4">Montant</th>
                                    <th class="py-3 px-4">Statut</th>
                                    <th class="py-3 px-4 text-right">Action WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border text-on-surface">
                                <?php if (empty($recent_orders)): ?>
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-outline">
                                            Aucune commande ne correspond aux critères sélectionnés.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recent_orders as $ord): ?>
                                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                                            <td class="py-3 px-4 font-semibold">
                                                <a href="/admin/commandes/<?= (int) $ord['id'] ?>" class="text-primary hover:underline">
                                                    #<?= htmlspecialchars($ord['order_number']) ?>
                                                </a>
                                            </td>
                                            <td class="py-3 px-4">
                                                <div class="font-medium"><?= htmlspecialchars($ord['customer_name']) ?></div>
                                                <span class="text-xs text-outline"><?= htmlspecialchars($ord['customer_whatsapp']) ?></span>
                                            </td>
                                            <td class="py-3 px-4 text-xs">
                                                <?= htmlspecialchars(($ord['delivery_city'] ?? 'Douala') . (!empty($ord['delivery_district']) ? ' (' . $ord['delivery_district'] . ')' : '')) ?>
                                            </td>
                                            <td class="py-3 px-4 font-semibold">
                                                <?= number_format((float) $ord['total_amount'], 0, ',', ' ') ?> FCFA
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border <?= \App\Domain\Entities\Order::getStatusBadgeClass($ord['order_status']) ?>">
                                                    <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($ord['order_status'])) ?>
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-right">
                                                <?php 
                                                    $cleanPhone = preg_replace('/[^0-9]/', '', (string)$ord['customer_whatsapp']);
                                                    $waMsg = urlencode("Bonjour " . $ord['customer_name'] . ", nous faisons le suivi de votre commande #" . $ord['order_number'] . " sur Marvens Shop.");
                                                    $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . $waMsg;
                                                ?>
                                                <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-1 bg-[#25D366]/10 text-[#25D366] px-3 py-1.5 rounded-xl text-xs font-semibold hover:bg-[#25D366]/20 transition-all">
                                                    <span class="material-symbols-outlined text-[16px]">chat</span> 
                                                    <?= $ord['order_status'] === 'pending' ? 'Relancer WA' : 'Ouvrir chat' ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer / Pagination -->
                    <div class="p-space-md border-t border-border flex items-center justify-between text-xs text-outline">
                        <span>Affichage de <?= count($recent_orders) ?> sur <?= (int) ($total_orders ?? 0) ?> commandes</span>
                        <div class="flex items-center gap-2">
                            <a href="/admin/commandes" class="px-3 py-1.5 rounded-xl border border-border bg-surface text-on-surface hover:bg-surface-container-low font-semibold">
                                Consulter toutes les commandes &rarr;
                            </a>
                        </div>
                    </div>
                </section>

            </div>
        </main>
    </div>
</body>
</html>
