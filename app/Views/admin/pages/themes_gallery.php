<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thèmes & Apparence — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --border: #e4e2e4; --text: #1b1b1d; --text-muted: #76777d; --primary: #000; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f6f3f5; color: var(--text); padding: 2rem; }
        .container { max-width: 1000px; margin: 0 auto; }
        h1 { font-size: 1.6rem; margin-bottom: 0.5rem; }
        p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem; }
        .themes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
        .theme-card { background: #fff; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; padding: 1.2rem; display: flex; flex-direction: column; }
        .theme-preview { width: 100%; aspect-ratio: 16/10; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-bottom: 1rem; }
        .btn-activate { background: #000; color: #fff; padding: 0.6rem; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; margin-top: auto; }
        .badge-active { background: #dcfce7; color: #15803d; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; display: inline-block; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem;">&larr; Retour au tableau de bord</a>
        <h1 style="margin-top: 0.5rem;">Bibliothèque de Thèmes</h1>
        <p>Sélectionnez le template visuel de votre boutique. <strong>Vos produits, catégories et commandes restent 100% intacts lors du changement.</strong></p>

        <div class="themes-grid">
            <!-- Thème Fashion -->
            <div class="theme-card">
                <?php if ($active_theme === 'fashion'): ?>
                    <span class="badge-active">ACTIF ACTUELLEMENT</span>
                <?php endif; ?>
                <div class="theme-preview" style="background: #fff8f5; color: #8d4b00;">Fashion (Éditorial Ambre)</div>
                <h3 style="font-size: 1.1rem; margin-bottom: 0.3rem;">Theme Fashion</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Style prêt-à-porter chaleureux, tons ambrés et élégance éditoriale.</p>
                <?php if ($active_theme !== 'fashion'): ?>
                    <form method="POST" action="/admin/themes/activer">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="theme" value="fashion">
                        <button type="submit" class="btn-activate" style="width: 100%;">Activer ce thème</button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Thème Bello -->
            <div class="theme-card">
                <?php if ($active_theme === 'bello'): ?>
                    <span class="badge-active">ACTIF ACTUELLEMENT</span>
                <?php endif; ?>
                <div class="theme-preview" style="background: #fdfaf6; color: #c2410c;">Bello (Chaleureux & Doux)</div>
                <h3 style="font-size: 1.1rem; margin-bottom: 0.3rem;">Theme Bello</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Mise en avant visuelle soignée, contrastes doux et lisibilité épurée.</p>
                <?php if ($active_theme !== 'bello'): ?>
                    <form method="POST" action="/admin/themes/activer">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="theme" value="bello">
                        <button type="submit" class="btn-activate" style="width: 100%;">Activer ce thème</button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Thème Luxe -->
            <div class="theme-card">
                <?php if ($active_theme === 'luxe'): ?>
                    <span class="badge-active">ACTIF ACTUELLEMENT</span>
                <?php endif; ?>
                <div class="theme-preview" style="background: #18181b; color: #f4f4f5;">Luxe (Sombre & Premium)</div>
                <h3 style="font-size: 1.1rem; margin-bottom: 0.3rem;">Theme Luxe</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Ambiance nocturne haut de gamme pour articles d'exception et maroquinerie.</p>
                <?php if ($active_theme !== 'luxe'): ?>
                    <form method="POST" action="/admin/themes/activer">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <input type="hidden" name="theme" value="luxe">
                        <button type="submit" class="btn-activate" style="width: 100%;">Activer ce thème</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
