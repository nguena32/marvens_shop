<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration — Tableau de Bord</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --admin-bg: #fff; --sidebar-bg: #f6f3f5; --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--admin-bg); color: var(--text); display: flex; min-height: 100vh; }
        aside { width: 240px; background: var(--sidebar-bg); border-right: 1px solid var(--border); padding: 1.5rem 1rem; display: flex; flex-direction: column; }
        .brand { font-size: 1.1rem; font-weight: 700; margin-bottom: 2rem; border-left: 3px solid #8d4b00; padding-left: 0.5rem; }
        .nav-links { list-style: none; display: flex; flex-direction: column; gap: 0.3rem; }
        .nav-links a { display: block; padding: 0.6rem 0.8rem; text-decoration: none; color: var(--text); font-size: 0.9rem; font-weight: 500; border-radius: 4px; }
        .nav-links a.active, .nav-links a:hover { background: #fff; border: 1px solid var(--border); }
        main { flex-grow: 1; padding: 2rem; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem; }
        .kpis { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .kpi { border: 1px solid var(--border); padding: 1.2rem; border-radius: 4px; }
        .kpi-title { font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem; }
        .kpi-num { font-size: 1.6rem; font-weight: 700; }
        .table-card { border: 1px solid var(--border); border-radius: 4px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.85rem; }
        th { background: var(--sidebar-bg); padding: 0.8rem 1rem; border-bottom: 1px solid var(--border); color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; }
        td { padding: 0.8rem 1rem; border-bottom: 1px solid var(--border); }
        .status-badge { display: inline-block; padding: 0.2rem 0.5rem; border-radius: 3px; font-size: 0.75rem; font-weight: 600; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-paid { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <aside>
        <div class="brand">MARVENS SHOP</div>
        <ul class="nav-links">
            <li><a href="/admin/dashboard" class="active">Tableau de bord</a></li>
            <li><a href="/admin/commandes">Commandes (<?= (int) ($pending_orders ?? 0) ?>)</a></li>
            <li><a href="/admin/produits">Produits</a></li>
            <li><a href="/admin/themes">Thèmes & Apparence</a></li>
            <li style="margin-top: 2rem;">
                <form method="POST" action="/admin/logout">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <button type="submit" style="background:none; border:none; color:#ba1a1a; cursor:pointer; font-weight:600; padding:0.6rem 0.8rem;">Déconnexion</button>
                </form>
            </li>
        </ul>
    </aside>

    <main>
        <div class="header">
            <div>
                <h1>Tableau de bord</h1>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Gestion opérationnelle de votre boutique en ligne</p>
            </div>
            <a href="/admin/produits/nouveau" style="background:#000; color:#fff; padding:0.6rem 1rem; border-radius:4px; text-decoration:none; font-size:0.85rem; font-weight:600;">+ Nouveau produit</a>
        </div>

        <div class="kpis">
            <div class="kpi">
                <div class="kpi-title">Commandes en attente</div>
                <div class="kpi-num" style="color: #d97706;"><?= (int) ($pending_orders ?? 0) ?></div>
            </div>
            <div class="kpi">
                <div class="kpi-title">Total Commandes</div>
                <div class="kpi-num"><?= (int) ($total_orders ?? 0) ?></div>
            </div>
            <div class="kpi">
                <div class="kpi-title">CA Réalisé (Payé)</div>
                <div class="kpi-num"><?= number_format($total_revenue ?? 0, 0, ',', ' ') ?> FCFA</div>
            </div>
            <div class="kpi">
                <div class="kpi-title">Produits Actifs</div>
                <div class="kpi-num"><?= (int) ($total_products ?? 0) ?></div>
            </div>
        </div>

        <div class="table-card">
            <div style="padding: 1rem; font-weight: 600; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                <span>Dernières Commandes</span>
                <a href="/admin/commandes" style="color: #000; font-size: 0.8rem; text-decoration: underline;">Voir tout</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut Commande</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">Aucune commande enregistrée pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent_orders as $ord): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($ord['order_number']) ?></strong></td>
                                <td><?= htmlspecialchars($ord['customer_name']) ?></td>
                                <td><?= number_format($ord['total_amount'], 0, ',', ' ') ?> FCFA</td>
                                <td>
                                    <span class="status-badge status-<?= htmlspecialchars($ord['order_status']) ?>">
                                        <?= htmlspecialchars($ord['order_status']) ?>
                                    </span>
                                </td>
                                <td><a href="/admin/commandes/<?= (int) $ord['id'] ?>" style="color: #000; text-decoration: underline;">Traiter</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
