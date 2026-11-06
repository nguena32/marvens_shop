<?php
$active_tab = 'customers';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Fiche Client : <?= htmlspecialchars($customer['name']) ?> — Marvens Shop</title>
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
            <div class="max-w-5xl mx-auto flex flex-col gap-space-lg">
                
                <!-- En-tête Client (8.4 Fiche Client) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <a href="/admin/clients" class="text-xs text-outline hover:text-on-surface flex items-center gap-1 mb-1 font-semibold">
                            <span class="material-symbols-outlined text-[14px]">arrow_back</span> Retour aux clients
                        </a>
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-on-surface"><?= htmlspecialchars($customer['name']) ?></h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container text-on-surface">
                                <?= (int)$customer['orders_count'] ?> commande(s)
                            </span>
                        </div>
                        <span class="text-xs text-outline mt-1 block">Inscrit / première commande le <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($customer['created_at']))) ?></span>
                    </div>

                    <?php 
                        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$customer['whatsapp']);
                        $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode("Bonjour " . $customer['name'] . ", nous vous contactons depuis Marvens Shop.");
                    ?>
                    <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-600 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">chat</span> Contacter sur WhatsApp
                    </a>
                </div>

                <!-- 8.4 Détails du Profil : Nom, WhatsApp, Ville, Quartier, Adresse -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline">account_circle</span> Coordonnées Personnelles
                        </h3>
                        <div class="space-y-2.5 text-sm">
                            <div class="flex justify-between"><span class="text-outline">Nom complet :</span> <span class="font-bold"><?= htmlspecialchars($customer['name']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Numéro WhatsApp :</span> <span class="font-mono font-semibold text-primary"><?= htmlspecialchars($customer['whatsapp']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Email éventuel :</span> <span><?= htmlspecialchars($customer['email'] ?? 'Non précisé') ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Dépenses cumulées :</span> <span class="font-black text-emerald-700"><?= number_format((float)$customer['total_spent'], 0, ',', ' ') ?> FCFA</span></div>
                        </div>
                    </div>

                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline">location_on</span> Adresse & Localisation
                        </h3>
                        <div class="space-y-2.5 text-sm">
                            <div class="flex justify-between"><span class="text-outline">Ville :</span> <span class="font-semibold"><?= htmlspecialchars($customer['city'] ?? 'Douala') ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Quartier :</span> <span class="font-semibold"><?= htmlspecialchars($customer['district'] ?? 'Non précisé') ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Adresse / Repère :</span> <span class="text-right max-w-xs"><?= htmlspecialchars($customer['address'] ?? 'Non renseignée') ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Dernière activité :</span> <span class="text-outline"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($customer['updated_at']))) ?></span></div>
                        </div>
                    </div>
                </div>

                <!-- 8.4 Historique des Commandes Précédentes -->
                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <div class="p-space-md border-b border-border bg-surface-container-low font-bold text-sm flex items-center justify-between">
                        <span>Historique des Commandes Réalisées (<?= count($orders) ?>)</span>
                        <span class="text-xs text-outline font-normal">Toutes commandes associées à ce numéro</span>
                    </div>

                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="text-xs uppercase font-semibold text-outline border-b border-border bg-surface-container-low">
                                <th class="p-4">Référence</th>
                                <th class="p-4">Date</th>
                                <th class="p-4">Livraison</th>
                                <th class="p-4">Paiement</th>
                                <th class="p-4">Montant</th>
                                <th class="p-4">Statut</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-on-surface">
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-outline text-xs">
                                        Aucune commande passée par ce client pour le moment.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $ord): ?>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="p-4 font-semibold text-primary">
                                            <a href="/admin/commandes/<?= (int)$ord['id'] ?>" class="hover:underline">
                                                #<?= htmlspecialchars($ord['order_number']) ?>
                                            </a>
                                        </td>
                                        <td class="p-4 text-xs text-outline">
                                            <?= htmlspecialchars(date('d/m/Y H:i', strtotime($ord['created_at']))) ?>
                                        </td>
                                        <td class="p-4 text-xs">
                                            <span class="px-2 py-0.5 rounded bg-surface-container text-on-surface">
                                                <?= $ord['delivery_mode'] === 'pickup' ? 'Retrait' : 'Domicile' ?>
                                            </span>
                                        </td>
                                        <td class="p-4 text-xs font-semibold uppercase <?= $ord['payment_status'] === 'paid' ? 'text-teal-700' : 'text-amber-700' ?>">
                                            <?= htmlspecialchars($ord['payment_status']) ?>
                                        </td>
                                        <td class="p-4 font-bold">
                                            <?= number_format((float)$ord['total_amount'], 0, ',', ' ') ?> FCFA
                                        </td>
                                        <td class="p-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border <?= \App\Domain\Entities\Order::getStatusBadgeClass($ord['order_status']) ?>">
                                                <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($ord['order_status'])) ?>
                                            </span>
                                        </td>
                                        <td class="p-4 text-right">
                                            <a href="/admin/commandes/<?= (int)$ord['id'] ?>" class="inline-flex items-center gap-1 bg-primary text-on-primary px-3 py-1 rounded-xl text-xs font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all">
                                                Ouvrir &rarr;
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
