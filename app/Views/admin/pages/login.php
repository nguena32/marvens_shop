<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur — Marvens Shop</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f6f3f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .login-card { background: #fff; padding: 2.5rem; border: 1px solid #e4e2e4; border-radius: 6px; width: 100%; max-width: 380px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h1 { font-size: 1.3rem; margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background: #000; color: #fff; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; margin-top: 1rem; }
        .error-msg { background: #fee2e2; color: #991b1b; padding: 0.6rem; border-radius: 4px; font-size: 0.85rem; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Marvens Shop Admin</h1>
        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="/admin/login">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
            <div class="form-group">
                <label for="username">Identifiant ou Email</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
