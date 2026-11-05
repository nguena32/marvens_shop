<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importation de Catalogue — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f6f3f5; color: var(--text); padding: 2rem; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 2rem; margin-bottom: 2rem; }
        h1 { font-size: 1.6rem; margin-bottom: 0.5rem; }
        .btn-upload { background: #000; color: #fff; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .report-box { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 1.2rem; border-radius: 6px; margin-bottom: 1.5rem; }
        .meta-status { background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; padding: 1.2rem; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">&larr; Retour au tableau de bord</a>
        <h1 style="margin-top: 0.5rem;">Importation du Catalogue</h1>

        <?php if (!empty($report)): ?>
            <div class="report-box">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">Rapport d'exécution de l'import :</h3>
                <div>✅ Produits créés : <strong><?= (int) $report['created'] ?></strong></div>
                <div>🔄 Produits mis à jour : <strong><?= (int) $report['updated'] ?></strong></div>
                <?php if (!empty($report['errors'])): ?>
                    <div style="margin-top: 0.5rem; color: #991b1b;">
                        <strong>Anomalies détectées :</strong>
                        <ul style="margin-left: 1.2rem; font-size: 0.85rem;">
                            <?php foreach ($report['errors'] as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Import CSV -->
        <div class="card">
            <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem;">1. Importation via Fichier CSV</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.2rem;">
                Téléversez votre fichier de produits au format standard (séparateur virgule ou point-virgule). Colonnes attendues : <code>name</code>, <code>price</code>, <code>sku</code>, <code>description</code>, <code>promotional_price</code>.
            </p>

            <form method="POST" action="/admin/import/csv" enctype="multipart/form-data">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <input type="file" name="csv_file" accept=".csv" required style="display: block; margin-bottom: 1rem;">
                <button type="submit" class="btn-upload">Lancer l'importation CSV</button>
            </form>
        </div>

        <!-- Connecteur Meta -->
        <div class="card">
            <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem;">2. Connecteur Catalogue Meta (Facebook / Instagram)</h2>
            <div class="meta-status">
                <strong>Statut du connecteur :</strong> <?= htmlspecialchars($meta_status['status'] ?? 'BLOCKED_EXTERNAL') ?><br>
                <span><?= htmlspecialchars($meta_status['message'] ?? '') ?></span>
            </div>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 1rem;">
                Conformément aux directives de l'Étape 5, l'import Meta nécessite la création préalable d'une application sur <a href="https://developers.facebook.com" target="_blank" style="color: #000; text-decoration: underline;">Meta for Developers</a> avec les autorisations <code>catalog_management</code> et un jeton OAuth valide.
            </p>
        </div>
    </div>
</body>
</html>
