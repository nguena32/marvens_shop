<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?> — Prêt-à-porter & Mode</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8d4b00;
            --primary-hover: #b15f00;
            --surface: #fff8f5;
            --surface-card: #ffffff;
            --surface-subtle: #fdeade;
            --text-main: #231a13;
            --text-muted: #554336;
            --border: #dbc2b0;
            --whatsapp: #25D366;
            --promo: #ba1a1a;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text-main); line-height: 1.5; }
        header { background: #fff; border-bottom: 1px solid var(--border); padding: 1rem 1.5rem; position: sticky; top: 0; z-index: 100; }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--primary); text-decoration: none; }
        .nav-links a { margin-left: 1.5rem; text-decoration: none; color: var(--text-main); font-weight: 500; font-size: 0.95rem; }
        .cart-btn { background: var(--surface-subtle); border: 1px solid var(--border); padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; color: var(--text-main); font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; }
        .badge { background: var(--primary); color: #fff; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 999px; }
        .container { max-width: 1200px; margin: 0 auto; padding: 1.5rem; }
        .hero { background: var(--surface-subtle); border: 1px solid var(--border); border-radius: 12px; padding: 3rem 2rem; margin-bottom: 2.5rem; text-align: center; }
        .hero h1 { font-family: 'Space Grotesk', sans-serif; font-size: clamp(1.8rem, 4vw, 2.8rem); margin-bottom: 0.8rem; }
        .hero p { color: var(--text-muted); max-width: 600px; margin: 0 auto 1.5rem; font-size: 1.05rem; }
        .btn-primary { background: var(--primary); color: #fff; padding: 0.75rem 1.8rem; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; border: none; cursor: pointer; }
        .btn-primary:hover { background: var(--primary-hover); }
        .section-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.5rem; margin-bottom: 1.2rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem; }
        .card { background: var(--surface-card); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(35,26,19,0.08); }
        .card-img { width: 100%; aspect-ratio: 1/1; background: #eedfd5; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: var(--text-muted); position: relative; }
        .card-body { padding: 1rem; display: flex; flex-direction: column; flex-grow: 1; }
        .card-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.1rem; margin-bottom: 0.4rem; color: var(--text-main); text-decoration: none; }
        .card-price { font-size: 1.15rem; font-weight: 700; color: var(--primary); margin-top: auto; padding-top: 0.5rem; }
        .promo-price { color: var(--promo); }
        .old-price { font-size: 0.85rem; text-decoration: line-through; color: var(--text-muted); margin-left: 0.5rem; }
        .whatsapp-banner { background: var(--whatsapp); color: #fff; border-radius: 8px; padding: 1.2rem; text-align: center; margin-top: 3rem; text-decoration: none; display: block; font-weight: 600; font-size: 1.05rem; }
        footer { border-top: 1px solid var(--border); background: #fff; padding: 2rem 1.5rem; margin-top: 4rem; text-align: center; color: var(--text-muted); font-size: 0.85rem; }
        @media (max-width: 600px) { .grid { grid-template-columns: repeat(2, 1fr); gap: 0.8rem; } .nav-links { display: none; } }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="/" class="logo"><?= htmlspecialchars($shop_name ?? 'MARVENS SHOP') ?></a>
            <nav class="nav-links">
                <a href="/">Accueil</a>
                <a href="/catalogue">Catalogue</a>
            </nav>
            <a href="/panier" class="cart-btn">
                <span>Panier</span>
                <span class="badge"><?= (int) ($cart_count ?? 0) ?></span>
            </a>
        </div>
    </header>

    <div class="container">
        <section class="hero">
            <h1>Boutique officielle & Commandes WhatsApp</h1>
            <p>Commandez vos articles en quelques clics, recevez une référence unique et échangez directement avec nous pour la livraison.</p>
            <a href="/catalogue" class="btn-primary">Découvrir le catalogue</a>
        </section>

        <h2 class="section-title">Nos articles du moment</h2>
        <div class="grid">
            <?php if (empty($products)): ?>
                <p style="grid-column: 1/-1; color: var(--text-muted); text-align: center; padding: 2rem;">Aucun article disponible pour le moment.</p>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <div class="card">
                        <div class="card-img">
                            <?php if (!empty($p['main_image_url'])): ?>
                                <img src="/<?= htmlspecialchars($p['main_image_url']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
                            <?php else: ?>
                                <?= htmlspecialchars($p['name']) ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" class="card-title"><?= htmlspecialchars($p['name']) ?></a>
                            <div class="card-price">
                                <?php if (!empty($p['promotional_price']) && $p['promotional_price'] < $p['price']): ?>
                                    <span class="promo-price"><?= number_format($p['promotional_price'], 0, ',', ' ') ?> FCFA</span>
                                    <span class="old-price"><?= number_format($p['price'], 0, ',', ' ') ?> FCFA</span>
                                <?php else: ?>
                                    <?= number_format($p['price'], 0, ',', ' ') ?> FCFA
                                <?php endif; ?>
                            </div>
                            <form method="POST" action="/panier/ajouter" style="margin-top: 0.8rem;">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-primary" style="width: 100%; padding: 0.5rem;">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <a href="https://wa.me/237699000000" target="_blank" class="whatsapp-banner">
            💬 Une question ? Discutez avec notre service commercial sur WhatsApp
        </a>
    </div>

    <footer>
        <p>&copy; 2026 Marvens Shop — Boutique indépendante installée par Marvens Group.</p>
    </footer>
</body>
</html>
