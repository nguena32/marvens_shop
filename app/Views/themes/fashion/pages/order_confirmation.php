<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Enregistrée — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #8d4b00; --surface: #fff8f5; --border: #dbc2b0; --text-main: #231a13; --text-muted: #554336; --whatsapp: #25D366; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text-main); line-height: 1.5; padding-bottom: 4rem; }
        .container { max-width: 650px; margin: 3rem auto; padding: 0 1.5rem; text-align: center; }
        .success-card { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 2.5rem 2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
        .badge-check { width: 64px; height: 64px; background: #dcfce7; color: #15803d; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem; }
        h1 { font-family: 'Space Grotesk', sans-serif; font-size: 1.8rem; margin-bottom: 0.5rem; }
        .order-ref { background: var(--surface); border: 1px dashed var(--border); padding: 0.8rem; border-radius: 6px; font-size: 1.25rem; font-weight: 700; color: var(--primary); margin: 1.2rem 0; }
        p { color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem; }
        .btn-whatsapp { background: var(--whatsapp); color: #fff; text-decoration: none; font-weight: 700; font-size: 1.1rem; padding: 1rem 1.8rem; border-radius: 8px; display: inline-flex; align-items: center; gap: 0.6rem; transition: 0.2s; box-shadow: 0 4px 10px rgba(37,211,102,0.3); }
        .btn-whatsapp:hover { background: #20ba5a; }
        .details-box { text-align: left; background: #fafafa; border: 1px solid #eee; border-radius: 6px; padding: 1rem; margin-top: 2rem; font-size: 0.85rem; }
        .details-box h3 { font-size: 0.95rem; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="badge-check">✓</div>
            <h1>Commande Enregistrée !</h1>
            <p>Votre commande a été enregistrée avec succès dans notre système de gestion.</p>

            <div class="order-ref">
                Réf : <?= htmlspecialchars($order['order_number']) ?>
            </div>

            <p style="font-weight: 500; color: var(--text-main);">
                👉 <strong>Étape finale indispensable :</strong> Cliquez sur le bouton ci-dessous pour ouvrir WhatsApp et envoyer votre commande au commerçant afin de confirmer l'heure et la livraison.
            </p>

            <a href="<?= htmlspecialchars($whatsapp_url) ?>" target="_blank" class="btn-whatsapp">
                <span>Finaliser sur WhatsApp</span> &rarr;
            </a>

            <div class="details-box">
                <h3>Récapitulatif enregistré :</h3>
                <div><strong>Client :</strong> <?= htmlspecialchars($order['customer_name']) ?> (<?= htmlspecialchars($order['customer_whatsapp']) ?>)</div>
                <div><strong>Montant Total :</strong> <?= number_format($order['total_amount'], 0, ',', ' ') ?> FCFA</div>
                <div><strong>Mode :</strong> <?= $order['delivery_mode'] === 'pickup' ? 'Retrait en boutique' : 'Livraison à domicile' ?></div>
            </div>

            <p style="margin-top: 1.5rem; font-size: 0.8rem;">
                <a href="/" style="color: var(--primary); text-decoration: underline;">Retour à l'accueil de la boutique</a>
            </p>
        </div>
    </div>
</body>
</html>
