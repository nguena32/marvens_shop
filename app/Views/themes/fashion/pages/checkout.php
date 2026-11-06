<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finaliser ma Commande — Marvens Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #8d4b00; --surface: #fff8f5; --border: #dbc2b0; --text-main: #231a13; --text-muted: #554336; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--surface); color: var(--text-main); line-height: 1.5; padding-bottom: 4rem; }
        header { background: #fff; border-bottom: 1px solid var(--border); padding: 1rem 1.5rem; }
        .header-content { max-width: 900px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Space Grotesk', sans-serif; font-size: 1.3rem; font-weight: 700; color: var(--primary); text-decoration: none; }
        .container { max-width: 900px; margin: 2rem auto; padding: 0 1.5rem; }
        h1 { font-family: 'Space Grotesk', sans-serif; font-size: 1.8rem; margin-bottom: 1.5rem; }
        .checkout-grid { display: grid; grid-template-columns: 3fr 2fr; gap: 2rem; }
        .card { background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 1.5rem; }
        .section-subtitle { font-family: 'Space Grotesk', sans-serif; font-size: 1.2rem; margin-bottom: 1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.3rem; }
        input[type="text"], select, textarea { width: 100%; padding: 0.65rem; border: 1px solid var(--border); border-radius: 4px; font-family: inherit; }
        .btn-submit { background: var(--primary); color: #fff; padding: 0.85rem 1.5rem; border-radius: 6px; font-weight: 700; font-size: 1.05rem; width: 100%; border: none; cursor: pointer; margin-top: 1rem; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 0.8rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem; }
        .summary-item { display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 0.5rem; }
        .summary-total { border-top: 1px solid var(--border); margin-top: 1rem; padding-top: 1rem; font-weight: 700; font-size: 1.2rem; color: var(--primary); display: flex; justify-content: space-between; }
        @media (max-width: 768px) { .checkout-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="/" class="logo">MARVENS SHOP</a>
            <a href="/panier" style="color: var(--text-main); font-size: 0.9rem;">&larr; Retour au panier</a>
        </div>
    </header>

    <div class="container">
        <h1>Validation de votre Commande</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <strong>Attention :</strong> Veuillez corriger les informations saisies pour valider votre commande.
            </div>
        <?php endif; ?>

        <form method="POST" action="/checkout">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
            
            <div class="checkout-grid">
                <div class="card">
                    <h2 class="section-subtitle">1. Coordonnées de contact</h2>
                    <div class="form-group">
                        <label for="customer_name">Votre Nom & Prénom *</label>
                        <input type="text" id="customer_name" name="customer_name" required placeholder="Ex: Amina Njoya">
                    </div>
                    <div class="form-group">
                        <label for="customer_whatsapp">Votre Numéro WhatsApp * (pour confirmer la livraison)</label>
                        <input type="text" id="customer_whatsapp" name="customer_whatsapp" required placeholder="Ex: 699000000 ou +237 699 00 00 00">
                    </div>

                    <h2 class="section-subtitle" style="margin-top: 1.5rem;">2. Mode de réception</h2>
                    <div class="form-group">
                        <label for="delivery_mode">Option choisie *</label>
                        <select id="delivery_mode" name="delivery_mode">
                            <option value="delivery">Livraison à domicile (Forfait 1 500 FCFA)</option>
                            <option value="pickup">Retrait gratuit en boutique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delivery_city">Ville *</label>
                        <input type="text" id="delivery_city" name="delivery_city" required value="Douala" placeholder="Ex: Douala, Yaoundé...">
                    </div>
                    <div class="form-group">
                        <label for="delivery_district">Quartier</label>
                        <input type="text" id="delivery_district" name="delivery_district" placeholder="Ex: Akwa, Bonapriso, Bastos...">
                    </div>
                    <div class="form-group">
                        <label for="delivery_address">Repère ou adresse précise</label>
                        <input type="text" id="delivery_address" name="delivery_address" placeholder="Ex: Face Boulangerie, Immeuble Blanc, 2ème étage">
                    </div>

                    <h2 class="section-subtitle" style="margin-top: 1.5rem;">3. Mode de règlement & Instructions</h2>
                    <div class="form-group">
                        <label for="payment_mode">Mode de règlement *</label>
                        <select id="payment_mode" name="payment_mode">
                            <option value="cash_on_delivery">Paiement à la livraison / à réception (Espèces)</option>
                            <option value="orange_money">Orange Money (Après validation WhatsApp)</option>
                            <option value="mtn_momo">MTN Mobile Money (Après validation WhatsApp)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="customer_notes">Commentaire ou instructions éventuelles</label>
                        <textarea id="customer_notes" name="customer_notes" rows="2" placeholder="Précisions sur la taille, horaires souhaités..."></textarea>
                    </div>
                </div>

                <div>
                    <div class="card">
                        <h2 class="section-subtitle">Récapitulatif de commande</h2>
                        <?php foreach ($cart['items'] as $item): ?>
                            <div class="summary-item">
                                <span><?= (int) $item['quantity'] ?>x <?= htmlspecialchars($item['name']) ?></span>
                                <strong><?= number_format($item['line_total'], 0, ',', ' ') ?> FCFA</strong>
                            </div>
                        <?php endforeach; ?>

                        <div class="summary-item" style="margin-top: 1rem; border-top: 1px dashed var(--border); padding-top: 0.5rem;">
                            <span>Sous-total articles</span>
                            <span><?= number_format($cart['subtotal'], 0, ',', ' ') ?> FCFA</span>
                        </div>
                        <div class="summary-item">
                            <span>Frais de livraison estimés</span>
                            <span>1 500 FCFA</span>
                        </div>

                        <div class="summary-total">
                            <span>TOTAL NET</span>
                            <span><?= number_format($cart['subtotal'] + 1500, 0, ',', ' ') ?> FCFA</span>
                        </div>

                        <button type="submit" class="btn-submit">Confirmer la commande &rarr;</button>
                        <p style="font-size: 0.75rem; color: var(--text-muted); text-align: center; margin-top: 0.8rem;">
                            🔒 Commande enregistrée en direct. Vous serez redirigé vers WhatsApp pour échanger avec le vendeur.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
