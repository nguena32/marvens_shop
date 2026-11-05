<?php
$active_tab = 'orders';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Détail Commande #<?= htmlspecialchars($order['order_number']) ?> — Marvens Shop</title>
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
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <a href="/admin/commandes" class="text-xs text-outline hover:text-on-surface flex items-center gap-1 mb-1">
                            <span class="material-symbols-outlined text-[14px]">arrow_back</span> Retour aux commandes
                        </a>
                        <h1 class="text-2xl font-bold text-on-surface">Commande #<?= htmlspecialchars($order['order_number']) ?></h1>
                        <span class="text-xs text-outline">Passée le <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($order['created_at']))) ?></span>
                    </div>

                    <?php 
                        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$order['customer_whatsapp']);
                        $waMsg = urlencode("Bonjour " . $order['customer_name'] . ", nous faisons le suivi de votre commande #" . $order['order_number'] . " sur Marvens Shop.");
                        $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . $waMsg;
                    ?>
                    <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-emerald-600 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">chat</span> Échanger sur WhatsApp
                    </a>
                </div>

                <!-- Mise à jour du statut -->
                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <h2 class="text-lg font-bold text-on-surface mb-space-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">sync</span> Statut & Traitement
                    </h2>
                    <form method="POST" action="/admin/commandes/<?= (int) $order['id'] ?>/statut" class="flex flex-col md:flex-row gap-space-md items-stretch md:items-center">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-outline uppercase mb-1">Modifier le statut</label>
                            <select name="order_status" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                                <option value="pending" <?= $order['order_status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                                <option value="confirmed" <?= $order['order_status'] === 'confirmed' ? 'selected' : '' ?>>Confirmée</option>
                                <option value="payment_pending" <?= $order['order_status'] === 'payment_pending' ? 'selected' : '' ?>>Paiement en attente</option>
                                <option value="paid" <?= $order['order_status'] === 'paid' ? 'selected' : '' ?>>Payée</option>
                                <option value="preparing" <?= $order['order_status'] === 'preparing' ? 'selected' : '' ?>>En préparation</option>
                                <option value="shipped" <?= $order['order_status'] === 'shipped' ? 'selected' : '' ?>>Expédiée</option>
                                <option value="delivered" <?= $order['order_status'] === 'delivered' ? 'selected' : '' ?>>Livrée</option>
                                <option value="cancelled" <?= $order['order_status'] === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-outline uppercase mb-1">Note ou commentaire</label>
                            <input type="text" name="comment" placeholder="Note interne..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                        </div>

                        <div class="self-end mt-2 md:mt-0">
                            <button type="submit" class="bg-primary text-on-primary px-5 py-2 rounded-xl text-sm font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Coordonnées Client & Livraison -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline">person</span> Informations Client
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-outline">Nom complet :</span> <span class="font-semibold"><?= htmlspecialchars($order['customer_name']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Numéro WhatsApp :</span> <span class="font-semibold"><?= htmlspecialchars($order['customer_whatsapp']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Mode de règlement :</span> <span><?= htmlspecialchars($order['payment_mode']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Statut paiement :</span> <span class="font-semibold uppercase text-xs <?= $order['payment_status'] === 'paid' ? 'text-emerald-600' : 'text-amber-600' ?>"><?= htmlspecialchars($order['payment_status']) ?></span></div>
                        </div>
                    </div>

                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline">local_shipping</span> Modalités de Livraison
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-outline">Mode :</span> <span class="font-semibold"><?= $order['delivery_mode'] === 'pickup' ? 'Retrait en boutique' : 'Livraison à domicile' ?></span></div>
                            <?php if ($order['delivery_mode'] === 'delivery'): ?>
                                <div class="flex justify-between"><span class="text-outline">Ville & Quartier :</span> <span><?= htmlspecialchars($order['delivery_city'] ?? '') ?> (<?= htmlspecialchars($order['delivery_district'] ?? '') ?>)</span></div>
                                <div class="flex justify-between"><span class="text-outline">Adresse / Repère :</span> <span><?= htmlspecialchars($order['delivery_address'] ?? 'Non précisé') ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($order['customer_notes'])): ?>
                                <div class="p-2 bg-amber-50 text-amber-800 rounded-lg text-xs mt-2"><strong>Note client :</strong> <?= htmlspecialchars($order['customer_notes']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Articles commandés -->
                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <div class="p-space-md border-b border-border bg-surface-container-low font-bold text-sm">
                        Articles de la commande
                    </div>
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="text-xs uppercase text-outline border-b border-border">
                                <th class="p-4">Désignation</th>
                                <th class="p-4">Prix unitaire</th>
                                <th class="p-4">Quantité</th>
                                <th class="p-4 text-right">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            <?php foreach ($items as $it): ?>
                                <tr>
                                    <td class="p-4 font-medium">
                                        <?= htmlspecialchars($it['product_name']) ?>
                                        <?php if (!empty($it['variant_info'])): ?>
                                            <span class="text-xs text-outline block"><?= htmlspecialchars($it['variant_info']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4"><?= number_format((float)$it['unit_price'], 0, ',', ' ') ?> FCFA</td>
                                    <td class="p-4"><?= (int)$it['quantity'] ?></td>
                                    <td class="p-4 font-semibold text-right"><?= number_format((float)$it['subtotal'], 0, ',', ' ') ?> FCFA</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-border">
                                <td colspan="3" class="p-4 text-right text-outline">Frais de livraison :</td>
                                <td class="p-4 text-right font-medium"><?= number_format((float)$order['delivery_cost'], 0, ',', ' ') ?> FCFA</td>
                            </tr>
                            <tr class="bg-surface-container-low font-bold text-base">
                                <td colspan="3" class="p-4 text-right text-primary">Montant Total :</td>
                                <td class="p-4 text-right text-primary"><?= number_format((float)$order['total_amount'], 0, ',', ' ') ?> FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
