<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #fff; color: var(--text); padding: 2rem; }
        .container { max-width: 1000px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; border: 1px solid var(--border); border-radius: 6px; overflow: hidden; margin-top: 1rem; }
        th, td { padding: 0.8rem 1rem; border-bottom: 1px solid var(--border); text-align: left; font-size: 0.85rem; }
        th { background: #f6f3f5; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; }
        .btn-add { background: #000; color: #fff; text-decoration: none; padding: 0.6rem 1rem; border-radius: 4px; font-weight: 600; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <a href="/admin/dashboard" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">&larr; Retour au tableau de bord</a>
                <h1 style="font-size: 1.5rem; margin-top: 0.3rem;">Catalogue des Produits</h1>
            </div>
            <a href="/admin/produits/nouveau" class="btn-add">+ Ajouter un produit</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Catégorie</th>
                    <th>Prix FCFA</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr><td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Aucun produit enregistré.</td></tr>
                <?php else: ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($p['name']) ?></strong></td>
                            <td><?= htmlspecialchars($p['category_name'] ?? 'Non classé') ?></td>
                            <td><strong><?= number_format($p['price'], 0, ',', ' ') ?> FCFA</strong></td>
                            <td><?= $p['is_active'] ? '✅ Actif' : '❌ Masqué' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
