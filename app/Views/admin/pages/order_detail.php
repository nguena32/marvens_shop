<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Commande #<?= htmlspecialchars($order['order_number']) ?> — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f6f3f5; color: var(--text); padding: 2rem; line-height: 1.5; }
        .container { max-width: 900px; margin: 0 auto; }
        .card { background: #fff; border: 1px solid var(--border); border-radius: 6px; padding: 1.5rem; margin-bottom: 1.5rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        h1 { font-size: 1.4rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; border-bottom: 1px solid var(--border); text-align: left; font-size: 0.85rem; }
        th { background: #f6f3f5; }
        .btn-whatsapp { background: #25D366; color: #fff; padding: 0.6rem 1rem; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem; }
        .btn-update { background: #000; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem; }
        select { padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a href="/admin/commandes" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none;">&larr; Retour aux commandes</a>
                <h1>Commande <?= htmlspecialchars($order['order_number']) ?></h1>
            </div>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $order['customer_whatsapp']) ?>?text=<?= rawurlencode('Bonjour ' . $order['customer_name'] . ', concernant votre commande ' . $order['order_number']) ?>" target="_blank" class="btn-whatsapp">
                Ouvrir discussion WhatsApp client
            </a>
        </div>

        <div class="card">
            <h2 style="font-size: 1.1rem; margin-bottom: 0.8rem;">Statut & Traitement</h2>
            <form method="POST" action="/admin/commandes/<?= (int) $order['id'] ?>/statut" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <label style="font-size: 0.85rem; font-weight: 600;">Statut actuel :</label>
                <select name="order_status">
                    <option value="pending" <?= $order['order_status'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                    <option value="confirmed" <?= $order['order_status'] === 'confirmed' ? 'selected' : '' ?>>Confirmée</option>
                    <option value="payment_pending" <?= $order['order_status'] === 'payment_pending' ? 'selected' : '' ?>>Paiement en attente</option>
                    <option value="paid" <?= $order['order_status'] === 'paid' ? 'selected' : '' ?>>Payée</option>
                    <option value="preparing" <?= $order['order_status'] === 'preparing' ? 'selected' : '' ?>>En préparation</option>
                    <option value="shipped" <?= $order['order_status'] === 'shipped' ? 'selected' : '' ?>>Expédiée</option>
                    <option value="delivered" <?= $order['order_status'] === 'delivered' ? 'selected' : '' ?>>Livrée</option>
                    <option value="cancelled" <?= $order['order_status'] === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                </select>
                <input type="text" name="comment" placeholder="Motif ou note..." style="padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px; flex-grow: 1;">
                <button type="submit" class="btn-update">Mettre à jour le statut</button>
            </form>
        </div>

        <div class="card">
            <h2 style="font-size: 1.1rem; margin-bottom: 0.8rem;">Coordonnées Client & Livraison</h2>
            <div style="font-size: 0.9rem;">
                <div><strong>Client :</strong> <?= htmlspecialchars($order['customer_name']) ?></div>
                <div><strong>WhatsApp :</strong> <?= htmlspecialchars($order['customer_whatsapp']) ?></div>
                <div><strong>Mode :</strong> <?= $order['delivery_mode'] === 'pickup' ? 'Retrait boutique' : 'Livraison à domicile' ?></div>
                <?php if ($order['delivery_mode'] === 'delivery'): ?>
                    <div><strong>Quartier / Ville :</strong> <?= htmlspecialchars($order['delivery_district'] ?? '') ?> (<?= htmlspecialchars($order['delivery_city'] ?? '') ?>)</div>
                    <div><strong>Repère :</strong> <?= htmlspecialchars($order['delivery_address'] ?? 'Non précisé') ?></div>
                <?php endif; ?>
                <?php if (!empty($order['customer_notes'])): ?>
                    <div style="margin-top: 0.5rem; color: #b45309;"><strong>Note client :</strong> <?= htmlspecialchars($order['customer_notes']) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <h2 style="font-size: 1.1rem; margin-bottom: 0.8rem;">Articles commandés</h2>
            <table>
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($it['product_name']) ?></strong>
                                <?php if (!empty($it['variant_info'])): ?>
                                    <span style="font-size: 0.8rem; color: var(--text-muted);">(<?= htmlspecialchars($it['variant_info']) ?>)</span>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($it['unit_price'], 0, ',', ' ') ?> FCFA</td>
                            <td><?= (int) $it['quantity'] ?></td>
                            <td><?= number_format($it['subtotal'], 0, ',', ' ') ?> FCFA</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="text-align: right; margin-top: 1rem; font-size: 1.1rem;">
                Frais de livraison : <?= number_format($order['delivery_cost'], 0, ',', ' ') ?> FCFA<br>
                <strong>TOTAL : <?= number_format($order['total_amount'], 0, ',', ' ') ?> FCFA</strong>
            </div>
        </div>
    </div>
</body>
</html>
