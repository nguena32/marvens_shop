<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #8d4b00; --surface: #fff8f5; --surface-card: #ffffff; --border: #dbc2b0; --text-main: #231a13; --text-muted: #554336; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text-main); line-height: 1.5; padding-bottom: 3rem; }
        header { background: #fff; border-bottom: 1px solid var(--border); padding: 1rem 1.5rem; }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Space Grotesk', sans-serif; font-size: 1.3rem; font-weight: 700; color: var(--primary); text-decoration: none; }
        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1.5rem; }
        h1 { font-family: 'Space Grotesk', sans-serif; font-size: 1.8rem; margin-bottom: 1.5rem; }
        .cart-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); margin-bottom: 2rem; }
        th { background: #fdeade; padding: 0.8rem 1rem; text-align: left; font-size: 0.85rem; font-weight: 600; }
        td { padding: 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        .cart-summary { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 1.5rem; max-width: 400px; margin-left: auto; }
        .summary-line { display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 1rem; }
        .total-line { font-size: 1.25rem; font-weight: 700; color: var(--primary); border-top: 1px solid var(--border); padding-top: 0.8rem; }
        .btn-checkout { background: var(--primary); color: #fff; padding: 0.8rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; display: block; text-align: center; margin-top: 1.2rem; border: none; cursor: pointer; }
        .btn-back { color: var(--text-muted); text-decoration: underline; font-size: 0.9rem; display: inline-block; margin-top: 1rem; }
        .btn-danger { background: none; border: none; color: #ba1a1a; cursor: pointer; text-decoration: underline; font-size: 0.85rem; }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="/" class="logo">MARVENS SHOP</a>
            <a href="/catalogue" style="color: var(--text-main); text-decoration: none; font-size: 0.9rem;">Continuer mes achats</a>
        </div>
    </header>

    <div class="container">
        <h1>Votre Panier</h1>

        <?php if (empty($cart['items'])): ?>
            <div style="background: #fff; border: 1px solid var(--border); padding: 3rem; text-align: center; border-radius: 8px;">
                <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 1rem;">Votre panier est actuellement vide.</p>
                <a href="/catalogue" class="btn-checkout" style="display: inline-block;">Parcourir les produits</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart['items'] as $key => $item): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($item['name']) ?></strong>
                                <?php if (!empty($item['variant_info'])): ?>
                                    <div style="font-size: 0.8rem; color: var(--text-muted);"><?= htmlspecialchars($item['variant_info']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($item['unit_price'], 0, ',', ' ') ?> FCFA</td>
                            <td>
                                <form method="POST" action="/panier/modifier" style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <input type="hidden" name="item_key" value="<?= htmlspecialchars($key) ?>">
                                    <input type="number" name="quantity" value="<?= (int) $item['quantity'] ?>" min="1" max="99" style="width: 60px; padding: 0.3rem;">
                                    <button type="submit" style="padding: 0.3rem 0.5rem; cursor: pointer;">MAJ</button>
                                </form>
                            </td>
                            <td><strong><?= number_format($item['line_total'], 0, ',', ' ') ?> FCFA</strong></td>
                            <td>
                                <form method="POST" action="/panier/supprimer">
                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <input type="hidden" name="item_key" value="<?= htmlspecialchars($key) ?>">
                                    <button type="submit" class="btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="summary-line">
                    <span>Articles (<?= (int) $cart['count'] ?>)</span>
                    <span><?= number_format($cart['subtotal'], 0, ',', ' ') ?> FCFA</span>
                </div>
                <div class="summary-line">
                    <span>Frais de livraison</span>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Calculés à l'étape suivante</span>
                </div>
                <div class="summary-line total-line">
                    <span>Sous-total</span>
                    <span><?= number_format($cart['subtotal'], 0, ',', ' ') ?> FCFA</span>
                </div>
                <a href="/checkout" class="btn-checkout">Valider la commande</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
