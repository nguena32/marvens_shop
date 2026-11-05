<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #fff; color: var(--text); padding: 2rem; }
        .container { max-width: 1100px; margin: 0 auto; }
        h1 { font-size: 1.6rem; margin-bottom: 1.5rem; }
        table { width: 100%; border-collapse: collapse; border: 1px solid var(--border); border-radius: 6px; overflow: hidden; }
        th { background: #f6f3f5; padding: 0.8rem 1rem; border-bottom: 1px solid var(--border); text-align: left; font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); }
        td { padding: 0.8rem 1rem; border-bottom: 1px solid var(--border); font-size: 0.85rem; }
        .badge { display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #dbeafe; color: #1e40af; }
        .badge-delivered { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <div>
                <a href="/admin/dashboard" style="color: var(--text-muted); font-size: 0.85rem; text-decoration: none;">&larr; Retour au tableau de bord</a>
                <h1 style="margin-top:0.3rem;">Commandes Reçues</h1>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>WhatsApp</th>
                    <th>Mode</th>
                    <th>Montant Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="8" style="text-align: center; color: var(--text-muted); padding: 2rem;">Aucune commande trouvée.</td></tr>
                <?php else: ?>
                    <?php foreach ($orders as $ord): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($ord['order_number']) ?></strong></td>
                            <td><?= htmlspecialchars($ord['created_at']) ?></td>
                            <td><?= htmlspecialchars($ord['customer_name']) ?></td>
                            <td><?= htmlspecialchars($ord['customer_whatsapp']) ?></td>
                            <td><?= $ord['delivery_mode'] === 'pickup' ? 'Retrait' : 'Livraison' ?></td>
                            <td><strong><?= number_format($ord['total_amount'], 0, ',', ' ') ?> FCFA</strong></td>
                            <td><span class="badge badge-<?= htmlspecialchars($ord['order_status']) ?>"><?= htmlspecialchars($ord['order_status']) ?></span></td>
                            <td><a href="/admin/commandes/<?= (int) $ord['id'] ?>" style="color: #000; text-decoration: underline; font-weight: 600;">Détail</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
