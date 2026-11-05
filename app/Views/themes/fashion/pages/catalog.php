<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue Complet — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #8d4b00; --surface: #fff8f5; --surface-card: #ffffff; --border: #dbc2b0; --text-main: #231a13; --text-muted: #554336; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text-main); line-height: 1.5; padding-bottom: 4rem; }
        header { background: #fff; border-bottom: 1px solid var(--border); padding: 1rem 1.5rem; }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Space Grotesk', sans-serif; font-size: 1.4rem; font-weight: 700; color: var(--primary); text-decoration: none; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap; }
        .search-box input { padding: 0.6rem 1rem; border: 1px solid var(--border); border-radius: 6px; width: 280px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; }
        .card { background: var(--surface-card); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; }
        .card-img { width: 100%; aspect-ratio: 1/1; background: #eedfd5; display: flex; align-items: center; justify-content: center; }
        .card-body { padding: 1rem; display: flex; flex-direction: column; flex-grow: 1; }
        .card-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.1rem; color: var(--text-main); text-decoration: none; margin-bottom: 0.4rem; }
        .card-price { font-size: 1.15rem; font-weight: 700; color: var(--primary); margin-top: auto; padding-top: 0.5rem; }
        .btn-add { background: var(--primary); color: #fff; border: none; padding: 0.6rem; border-radius: 6px; cursor: pointer; font-weight: 600; margin-top: 0.6rem; }
        @media (max-width: 600px) { .grid { grid-template-columns: repeat(2, 1fr); gap: 0.8rem; } }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="/" class="logo">MARVENS SHOP</a>
            <a href="/panier" style="color: var(--text-main); text-decoration: none; font-weight: 600;">Panier (<?= (int) ($cart_count ?? 0) ?>)</a>
        </div>
    </header>

    <div class="container">
        <div class="toolbar">
            <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.8rem;">Tous nos articles</h1>
            <form method="GET" action="/catalogue" class="search-box">
                <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" placeholder="Rechercher un article...">
            </form>
        </div>

        <div class="grid">
            <?php if (empty($products)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--text-muted); padding: 3rem;">Aucun article ne correspond à votre recherche.</p>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
                    <div class="card">
                        <div class="card-img">
                            <?php if (!empty($p['main_image_url'])): ?>
                                <img src="/<?= ltrim(htmlspecialchars($p['main_image_url']), '/') ?>" alt="<?= htmlspecialchars($p['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
                            <?php else: ?>
                                <?= htmlspecialchars($p['name']) ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <a href="/produit/<?= htmlspecialchars($p['slug']) ?>" class="card-title"><?= htmlspecialchars($p['name']) ?></a>
                            <div class="card-price"><?= number_format($p['price'], 0, ',', ' ') ?> FCFA</div>
                            <form method="POST" action="/panier/ajouter">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add" style="width:100%;">Ajouter</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
