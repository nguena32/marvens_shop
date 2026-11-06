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
            <div class="max-w-5xl mx-auto flex flex-col gap-space-lg">
                
                <?php if (!empty($feedback)): ?>
                    <div class="p-4 rounded-xl border <?= $feedback['type'] === 'success' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200' ?> flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]"><?= $feedback['type'] === 'success' ? 'check_circle' : 'error' ?></span>
                        <span class="text-sm font-semibold"><?= htmlspecialchars($feedback['message']) ?></span>
                    </div>
                <?php endif; ?>

                <!-- En-tête de la commande (8.2 Numéro, Date, WhatsApp) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <a href="/admin/commandes" class="text-xs text-outline hover:text-on-surface flex items-center gap-1 mb-1 font-semibold">
                            <span class="material-symbols-outlined text-[14px]">arrow_back</span> Retour aux commandes
                        </a>
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-on-surface">Commande #<?= htmlspecialchars($order['order_number']) ?></h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border <?= \App\Domain\Entities\Order::getStatusBadgeClass($order['order_status']) ?>">
                                <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($order['order_status'])) ?>
                            </span>
                        </div>
                        <span class="text-xs text-outline mt-1 block">Passée le <?= htmlspecialchars(date('d/m/Y à H:i:s', strtotime($order['created_at']))) ?></span>
                    </div>

                    <?php 
                        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$order['customer_whatsapp']);
                        $waMsg = urlencode("Bonjour " . $order['customer_name'] . ", nous faisons le suivi de votre commande #" . $order['order_number'] . " sur Marvens Shop.");
                        $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . $waMsg;
                    ?>
                    <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-600 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">chat</span> Échanger sur WhatsApp
                    </a>
                </div>

                <!-- 8.2 & 8.3 Traitement des Statuts & 7.9 Suivi des Paiements -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <!-- Mise à jour du Statut de Commande (8.3) -->
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h2 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">sync</span> Statut de Commande (8.3)
                        </h2>
                        <form method="POST" action="/admin/commandes/<?= (int) $order['id'] ?>/statut" class="space-y-3">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            
                            <div>
                                <label class="block text-xs font-semibold text-outline uppercase mb-1">Modifier l'état</label>
                                <select name="order_status" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm text-on-surface font-medium">
                                    <option value="pending" <?= $order['order_status'] === 'pending' ? 'selected' : '' ?>>1. En attente</option>
                                    <option value="confirmed" <?= $order['order_status'] === 'confirmed' ? 'selected' : '' ?>>2. Confirmée</option>
                                    <option value="payment_pending" <?= $order['order_status'] === 'payment_pending' ? 'selected' : '' ?>>3. Paiement en attente</option>
                                    <option value="paid" <?= $order['order_status'] === 'paid' ? 'selected' : '' ?>>4. Payée</option>
                                    <option value="preparing" <?= $order['order_status'] === 'preparing' ? 'selected' : '' ?>>5. En préparation</option>
                                    <option value="shipped" <?= $order['order_status'] === 'shipped' ? 'selected' : '' ?>>6. Expédiée</option>
                                    <option value="delivered" <?= $order['order_status'] === 'delivered' ? 'selected' : '' ?>>7. Livrée</option>
                                    <option value="cancelled" <?= $order['order_status'] === 'cancelled' ? 'selected' : '' ?>>8. Annulée</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-outline uppercase mb-1">Motif / Commentaire (Historisé)</label>
                                <input type="text" name="comment" placeholder="Ex: Paiement reçu, colis préparé..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm text-on-surface">
                            </div>

                            <button type="submit" class="w-full bg-primary text-white py-2 rounded-xl text-xs font-semibold hover:opacity-90 transition-all">
                                Valider la transition de statut
                            </button>
                        </form>
                    </div>

                    <!-- Mise à jour du Paiement (7.9 & 8.5) -->
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h2 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-teal-600">payments</span> Suivi du Paiement (7.9)
                        </h2>
                        <form method="POST" action="/admin/commandes/<?= (int) $order['id'] ?>/paiement" class="space-y-3">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            
                            <div>
                                <label class="block text-xs font-semibold text-outline uppercase mb-1">Statut du règlement</label>
                                <select name="payment_status" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm text-on-surface font-medium">
                                    <option value="unpaid" <?= $order['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Non payé (unpaid)</option>
                                    <option value="pending" <?= $order['payment_status'] === 'pending' ? 'selected' : '' ?>>En attente (pending)</option>
                                    <option value="paid" <?= $order['payment_status'] === 'paid' ? 'selected' : '' ?>>Payé & certifié (paid)</option>
                                    <option value="refunded" <?= $order['payment_status'] === 'refunded' ? 'selected' : '' ?>>Remboursé (refunded)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-outline uppercase mb-1">Référence ou note de transaction</label>
                                <input type="text" name="payment_note" placeholder="Ex: Reçu Orange Money #88219..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm text-on-surface">
                            </div>

                            <button type="submit" class="w-full bg-teal-700 text-white py-2 rounded-xl text-xs font-semibold hover:bg-teal-800 transition-all">
                                Enregistrer l'état du paiement
                            </button>
                        </form>
                    </div>
                </div>

                <!-- 8.2 Client, Adresse, Mode de livraison, Instructions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg">
                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline">person</span> Informations Client (8.4)
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-outline">Nom client :</span> <span class="font-semibold"><?= htmlspecialchars($order['customer_name']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Numéro WhatsApp :</span> <span class="font-semibold text-primary"><?= htmlspecialchars($order['customer_whatsapp']) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">Mode de règlement :</span> <span class="capitalize"><?= htmlspecialchars(str_replace('_', ' ', $order['payment_mode'])) ?></span></div>
                            <div class="flex justify-between"><span class="text-outline">État du paiement :</span> <span class="font-bold uppercase text-xs <?= $order['payment_status'] === 'paid' ? 'text-teal-700' : 'text-amber-700' ?>"><?= htmlspecialchars($order['payment_status']) ?></span></div>
                        </div>

                        <?php if (!empty($previous_orders)): ?>
                            <div class="mt-4 pt-3 border-t border-border">
                                <span class="text-xs font-bold text-outline uppercase block mb-2">Historique commandes client (<?= count($previous_orders) ?>)</span>
                                <div class="space-y-1.5 max-h-36 overflow-y-auto pr-1">
                                    <?php foreach ($previous_orders as $prev): ?>
                                        <a href="/admin/commandes/<?= (int)$prev['id'] ?>" class="flex items-center justify-between p-2 rounded-lg bg-surface-container-low hover:bg-surface-container text-xs transition-colors">
                                            <span class="font-semibold text-primary">#<?= htmlspecialchars($prev['order_number']) ?></span>
                                            <span class="text-outline"><?= date('d/m/Y', strtotime($prev['created_at'])) ?></span>
                                            <span class="font-bold"><?= number_format((float)$prev['total_amount'], 0, ',', ' ') ?> FCFA</span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                        <h3 class="text-base font-bold text-on-surface mb-space-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline">local_shipping</span> Modalités de Livraison (8.2)
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-outline">Mode de livraison :</span> <span class="font-semibold"><?= $order['delivery_mode'] === 'pickup' ? 'Retrait en boutique' : 'Livraison à domicile' ?></span></div>
                            <?php if ($order['delivery_mode'] === 'delivery'): ?>
                                <div class="flex justify-between"><span class="text-outline">Ville & Quartier :</span> <span class="font-semibold"><?= htmlspecialchars($order['delivery_city'] ?? '') ?> (<?= htmlspecialchars($order['delivery_district'] ?? 'N/A') ?>)</span></div>
                                <div class="flex justify-between"><span class="text-outline">Adresse / Repère :</span> <span class="text-right max-w-xs"><?= htmlspecialchars($order['delivery_address'] ?? 'Non précisé') ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($order['delivery_date'])): ?>
                                <div class="flex justify-between items-center"><span class="text-outline">Date souhaitée :</span> <span class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded text-xs"><?= date('d/m/Y', strtotime($order['delivery_date'])) ?></span></div>
                            <?php endif; ?>
                            <?php if (!empty($order['customer_notes'])): ?>
                                <div class="p-3 bg-amber-50 text-amber-900 border border-amber-200 rounded-xl text-xs mt-3">
                                    <strong>Instructions du client :</strong><br>
                                    <?= nl2br(htmlspecialchars($order['customer_notes'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- 8.2 Produits, Quantités, Montants -->
                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <div class="p-space-md border-b border-border bg-surface-container-low font-bold text-sm flex items-center justify-between">
                        <span>Articles de la commande (<?= count($items) ?> produit(s))</span>
                        <span class="text-xs text-outline font-normal">Calcul certifié serveur (MS-BIZ-03)</span>
                    </div>
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="text-xs uppercase text-outline border-b border-border">
                                <th class="p-4">Produit & Déclinaison</th>
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
                                            <span class="text-xs text-outline block font-normal"><?= htmlspecialchars($it['variant_info']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-4"><?= number_format((float)$it['unit_price'], 0, ',', ' ') ?> FCFA</td>
                                    <td class="p-4 font-semibold"><?= (int)$it['quantity'] ?></td>
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
                                <td class="p-4 text-right text-primary font-black"><?= number_format((float)$order['total_amount'], 0, ',', ' ') ?> FCFA</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- 8.2 Historique Complet des Changements de Statut -->
                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <h3 class="text-base font-bold text-on-surface mb-space-md flex items-center gap-2">
                        <span class="material-symbols-outlined text-outline">history</span> Journal d'Historique des Statuts (MS-BIZ-06)
                    </h3>
                    <?php if (empty($history)): ?>
                        <p class="text-xs text-outline">Aucun historique disponible pour cette commande.</p>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($history as $h): ?>
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-surface-container-low border border-border text-xs">
                                    <div class="w-2 h-2 rounded-full bg-primary mt-1.5 shrink-0"></div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-on-surface">
                                                <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($h['new_status'])) ?>
                                                <?php if (!empty($h['previous_status'])): ?>
                                                    <span class="font-normal text-outline"> (depuis <?= htmlspecialchars(\App\Domain\Entities\Order::getStatusLabel($h['previous_status'])) ?>)</span>
                                                <?php endif; ?>
                                            </span>
                                            <span class="text-outline"><?= htmlspecialchars(date('d/m/Y H:i:s', strtotime($h['changed_at']))) ?></span>
                                        </div>
                                        <?php if (!empty($h['comment'])): ?>
                                            <p class="text-on-surface-variant mt-1"><?= htmlspecialchars($h['comment']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
