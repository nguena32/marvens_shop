<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #8d4b00; --surface: #fff8f5; --border: #dbc2b0; --text-main: #231a13; --text-muted: #554336; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text-main); line-height: 1.5; padding-bottom: 4rem; }
        header { background: #fff; border-bottom: 1px solid var(--border); padding: 1rem 1.5rem; }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Space Grotesk', sans-serif; font-size: 1.3rem; font-weight: 700; color: var(--primary); text-decoration: none; }
        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1.5rem; }
        .product-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 2rem; }
        .product-gallery { width: 100%; aspect-ratio: 1/1; background: #eedfd5; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--text-muted); }
        .product-details { display: flex; flex-direction: column; }
        h1 { font-family: 'Space Grotesk', sans-serif; font-size: 1.8rem; margin-bottom: 0.5rem; }
        .sku { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem; text-transform: uppercase; }
        .price { font-size: 1.6rem; font-weight: 700; color: var(--primary); margin-bottom: 1.5rem; }
        .description { font-size: 0.95rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 2rem; border-top: 1px solid var(--border); padding-top: 1rem; }
        .btn-add { background: var(--primary); color: #fff; padding: 0.85rem 1.8rem; border-radius: 6px; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; width: 100%; }
        .btn-whatsapp-direct { background: #25D366; color: #fff; padding: 0.85rem 1.8rem; border-radius: 6px; font-weight: 700; font-size: 1rem; text-decoration: none; display: block; text-align: center; margin-top: 0.8rem; }
        @media (max-width: 768px) { .product-layout { grid-template-columns: 1fr; gap: 1.5rem; } }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="/" class="logo">MARVENS SHOP</a>
            <a href="/panier" style="color: var(--text-main); text-decoration: none;">Panier (<?= (int) ($cart_count ?? 0) ?>)</a>
        </div>
    </header>

    <div class="container">
        <div class="product-layout">
            <div class="product-gallery">
                <?php if (!empty($product['main_image_url'])): ?>
                    <img src="/<?= ltrim(htmlspecialchars($product['main_image_url']), '/') ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                <?php else: ?>
                    <?= htmlspecialchars($product['name']) ?>
                <?php endif; ?>
            </div>

            <div class="product-details">
                <h1><?= htmlspecialchars($product['name']) ?></h1>
                <?php if (!empty($product['sku'])): ?>
                    <div class="sku">Réf : <?= htmlspecialchars($product['sku']) ?></div>
                <?php endif; ?>

                <div class="price">
                    <?= number_format($product['price'], 0, ',', ' ') ?> FCFA
                </div>

                <div class="description">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Aucune description disponible pour cet article.')) ?>
                </div>

                <form method="POST" action="/panier/ajouter">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                    
                    <?php if (!empty($product['variants'])): ?>
                        <div style="margin-bottom: 1.2rem;">
                            <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:0.4rem;">Option / Taille :</label>
                            <select name="variant" style="width:100%; padding:0.6rem; border:1px solid var(--border); border-radius:4px;">
                                <?php foreach ($product['variants'] as $v): ?>
                                    <option value="<?= htmlspecialchars($v['variant_name']) ?>">
                                        <?= htmlspecialchars($v['variant_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                        <label style="font-size: 0.85rem; font-weight: 600;">Quantité :</label>
                        <input type="number" name="quantity" value="1" min="1" max="99" style="width: 70px; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                    </div>

                    <button type="submit" class="btn-add">Ajouter au panier</button>
                    <a href="https://wa.me/237699000000?text=<?= rawurlencode('Bonjour, je souhaite des infos sur : ' . $product['name']) ?>" target="_blank" class="btn-whatsapp-direct">
                        Commander directement sur WhatsApp
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
