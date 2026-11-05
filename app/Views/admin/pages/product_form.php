<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f6f3f5; color: var(--text); padding: 2rem; }
        .container { max-width: 650px; margin: 0 auto; background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 2rem; }
        h1 { font-size: 1.4rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem; }
        input[type="text"], input[type="number"], select, textarea { width: 100%; padding: 0.65rem; border: 1px solid var(--border); border-radius: 4px; font-family: inherit; }
        .btn-save { background: #000; color: #fff; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/produits" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">&larr; Retour à la liste</a>
        <h1 style="margin-top: 0.5rem;">Nouveau Produit</h1>

        <form method="POST" action="/admin/produits/nouveau" enctype="multipart/form-data">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <div class="form-group">
                <label for="name">Nom de l'article *</label>
                <input type="text" id="name" name="name" required placeholder="Ex: Robe Longue Sahara">
            </div>

            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select id="category_id" name="category_id">
                    <option value="">-- Sans catégorie --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= (int) $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="price">Prix standard (FCFA) *</label>
                    <input type="number" id="price" name="price" required placeholder="Ex: 18500">
                </div>
                <div class="form-group">
                    <label for="promotional_price">Prix promotionnel (FCFA)</label>
                    <input type="number" id="promotional_price" name="promotional_price" placeholder="Optionnel">
                </div>
            </div>

            <div class="form-group">
                <label for="sku">Référence SKU</label>
                <input type="text" id="sku" name="sku" placeholder="Ex: ROBE-001">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Caractéristiques, matière, conseils d'entretien..."></textarea>
            </div>

            <div class="form-group">
                <label for="image">Photo principale de l'article (JPEG, PNG, WEBP - Max 5Mo)</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp">
            </div>

            <button type="submit" class="btn-save">Enregistrer et Publier</button>
        </form>
    </div>
</body>
</html>
