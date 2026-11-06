<?php
/**
 * Page Checkout & Saisie des coordonnées client
 * Conforme Module 7.2 : Nom, WhatsApp, Adresse, Quartier, Ville, Mode de livraison,
 * Mode de paiement, Instructions, Récapitulatif, Validation serveur,
 * Calcul dynamique des frais de livraison et persistance sécurisée.
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$items = $cart['items'] ?? [];
$subtotal = $cart['subtotal'] ?? 0;
$zones = $delivery_settings['zones'] ?? [];
$old = $old ?? [];
?>
<section class="py-8 sm:py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <div class="mb-6 border-b border-border pb-4">
        <h1 class="text-2xl sm:text-3xl font-headline font-bold text-on-surface">Validation de Commande</h1>
        <p class="text-xs text-outline mt-1">Renseignez vos coordonnées pour la livraison et la finalisation sur WhatsApp</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="mb-6 p-4 rounded-xl bg-error/10 border border-error/20 text-error text-xs space-y-1">
            <strong>Veuillez corriger les erreurs suivantes :</strong>
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $field => $errs): ?>
                    <?php foreach ((array)$errs as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/checkout" id="checkout-form" class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

        <!-- Formulaire client -->
        <div class="lg:col-span-7 card-theme p-5 sm:p-6 bg-surface space-y-4">
            <h3 class="font-headline font-bold text-sm sm:text-base text-on-surface border-b border-border pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">person_pin_circle</span>
                Informations client & Réception
            </h3>

            <!-- Nom & WhatsApp -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1" for="customer_name">Nom et Prénom *</label>
                    <input type="text" id="customer_name" name="customer_name" required value="<?= htmlspecialchars($old['customer_name'] ?? '') ?>" placeholder="Ex: Jean Dupont" class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1" for="customer_whatsapp">Numéro WhatsApp (avec indicatif) *</label>
                    <input type="text" id="customer_whatsapp" name="customer_whatsapp" required value="<?= htmlspecialchars($old['customer_whatsapp'] ?? '') ?>" placeholder="Ex: +237 690 00 00 00" class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
                </div>
            </div>

            <!-- Mode de livraison -->
            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="delivery_mode">Mode de réception *</label>
                <select id="delivery_mode" name="delivery_mode" class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary">
                    <option value="delivery" <?= ($old['delivery_mode'] ?? '') === 'delivery' ? 'selected' : '' ?>>Livraison à domicile ou au bureau</option>
                    <option value="pickup" <?= ($old['delivery_mode'] ?? '') === 'pickup' ? 'selected' : '' ?>>Retrait direct en boutique (Gratuit)</option>
                </select>
                <?php if (!empty($delivery_settings['pickup_address'])): ?>
                    <p id="pickup-info" class="text-[11px] text-outline mt-1.5 p-2 rounded-lg bg-surface-container hidden">
                        <span class="font-semibold text-on-surface">Adresse du point de retrait :</span> <?= htmlspecialchars($delivery_settings['pickup_address']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Ville & Quartier -->
            <div id="delivery-location-fields" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="delivery_city">Ville *</label>
                        <input type="text" id="delivery_city" name="delivery_city" required value="<?= htmlspecialchars($old['delivery_city'] ?? 'Douala') ?>" placeholder="Ex: Douala, Yaoundé..." class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1" for="delivery_district">Quartier</label>
                        <?php if (!empty($zones)): ?>
                            <input list="districts-list" id="delivery_district" name="delivery_district" value="<?= htmlspecialchars($old['delivery_district'] ?? '') ?>" placeholder="Sélectionnez ou saisissez un quartier" class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
                            <datalist id="districts-list">
                                <?php foreach ($zones as $zone): ?>
                                    <option value="<?= htmlspecialchars($zone['district']) ?>" data-fee="<?= (int)$zone['fee'] ?>">
                                        <?= htmlspecialchars($zone['district']) ?> (<?= htmlspecialchars($zone['city']) ?> — <?= number_format((float)$zone['fee'], 0, ',', ' ') ?> FCFA)
                                    </option>
                                <?php endforeach; ?>
                            </datalist>
                        <?php else: ?>
                            <input type="text" id="delivery_district" name="delivery_district" value="<?= htmlspecialchars($old['delivery_district'] ?? '') ?>" placeholder="Ex: Akwa, Bastos, Bonapriso..." class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-on-surface mb-1" for="delivery_address">Adresse / Repère précis</label>
                    <textarea id="delivery_address" name="delivery_address" rows="2" placeholder="Ex: Face Boulangerie de la Paix, Immeuble vitré, 2ème étage..." class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"><?= htmlspecialchars($old['delivery_address'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Mode de paiement -->
            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="payment_mode">Mode de règlement *</label>
                <select id="payment_mode" name="payment_mode" class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary">
                    <option value="cash_on_delivery" <?= ($old['payment_mode'] ?? '') === 'cash_on_delivery' ? 'selected' : '' ?>>Paiement à la livraison / à réception (Espèces)</option>
                    <option value="orange_money" <?= ($old['payment_mode'] ?? '') === 'orange_money' ? 'selected' : '' ?>>Orange Money (Transfert direct après validation WhatsApp)</option>
                    <option value="mtn_momo" <?= ($old['payment_mode'] ?? '') === 'mtn_momo' ? 'selected' : '' ?>>MTN Mobile Money (Transfert direct après validation WhatsApp)</option>
                </select>
                <p class="text-[11px] text-outline mt-1">
                    Le règlement s'effectue directement auprès du commerçant selon les modalités convenues.
                </p>
            </div>

            <!-- Instructions / Notes -->
            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="customer_notes">Instructions ou commentaire particulier (facultatif)</label>
                <textarea id="customer_notes" name="customer_notes" rows="2" placeholder="Ex: Appelez-moi 30 min avant de livrer, créneau horaire souhaité..." class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"><?= htmlspecialchars($old['customer_notes'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- Récapitulatif et validation -->
        <div class="lg:col-span-5 card-theme p-5 sm:p-6 bg-surface space-y-4">
            <h3 class="font-headline font-bold text-sm sm:text-base text-on-surface border-b border-border pb-3 flex items-center justify-between">
                <span>Récapitulatif de commande</span>
                <span class="text-xs text-outline font-normal"><?= count($items) ?> article(s)</span>
            </h3>

            <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                <?php foreach ($items as $item): ?>
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-border/50 last:border-b-0">
                        <div class="truncate max-w-[200px]">
                            <span class="font-bold text-on-surface"><?= (int)$item['quantity'] ?>x</span>
                            <span class="text-on-surface"><?= htmlspecialchars($item['name']) ?></span>
                            <?php if (!empty($item['variant_info'])): ?>
                                <span class="text-[10px] text-outline block">(<?= htmlspecialchars($item['variant_info']) ?>)</span>
                            <?php endif; ?>
                        </div>
                        <span class="font-bold text-on-surface"><?= number_format((float)($item['line_total'] ?? $item['total']), 0, ',', ' ') ?> FCFA</span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="border-t border-border pt-3 space-y-2 text-xs text-outline">
                <div class="flex items-center justify-between">
                    <span>Sous-total articles</span>
                    <span class="font-bold text-on-surface" id="display-subtotal" data-subtotal="<?= (int)$subtotal ?>"><?= number_format((float)$subtotal, 0, ',', ' ') ?> FCFA</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Frais de livraison</span>
                    <span class="font-bold text-on-surface" id="display-shipping">1 500 FCFA</span>
                </div>
                <div class="border-t border-border pt-2 flex items-center justify-between text-sm">
                    <span class="font-headline font-bold text-on-surface">Total à payer</span>
                    <span class="font-headline font-bold text-lg text-primary" id="display-total"><?= number_format((float)($subtotal + 1500), 0, ',', ' ') ?> FCFA</span>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-primary text-on-primary btn-theme text-xs font-bold flex items-center justify-center gap-2 shadow-md hover:opacity-95 transition">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Confirmer & Ouvrir WhatsApp
            </button>

            <div class="p-3 bg-surface-container rounded-xl text-[11px] text-outline space-y-1">
                <div class="flex items-center gap-1.5 font-semibold text-on-surface">
                    <span class="material-symbols-outlined text-[15px] text-emerald-600">verified_user</span>
                    Processus sécurisé certifié
                </div>
                <p>
                    1. Votre commande est immédiatement enregistrée dans notre base de données.<br>
                    2. Le message récapitulatif WhatsApp s'ouvre avec votre référence unique.<br>
                    3. Vous validez directement avec le commerçant l'expédition et le paiement.
                </p>
            </div>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryMode = document.getElementById('delivery_mode');
    const pickupInfo = document.getElementById('pickup-info');
    const locationFields = document.getElementById('delivery-location-fields');
    const districtInput = document.getElementById('delivery_district');
    const displayShipping = document.getElementById('display-shipping');
    const displayTotal = document.getElementById('display-total');
    const displaySubtotal = document.getElementById('display-subtotal');
    
    const subtotal = parseInt(displaySubtotal.dataset.subtotal, 10) || 0;
    const freeThreshold = <?= (int)($delivery_settings['free_shipping_threshold'] ?? 0) ?>;

    const zoneFees = {
        <?php foreach ($zones as $z): ?>
            "<?= addslashes(mb_strtolower(trim($z['district']))) ?>": <?= (int)$z['fee'] ?>,
        <?php endforeach; ?>
    };

    function recalculate() {
        const mode = deliveryMode.value;
        let shippingFee = 0;

        if (mode === 'pickup') {
            if (pickupInfo) pickupInfo.classList.remove('hidden');
            shippingFee = 0;
            displayShipping.textContent = "Gratuit (Retrait)";
        } else {
            if (pickupInfo) pickupInfo.classList.add('hidden');
            if (freeThreshold > 0 && subtotal >= freeThreshold) {
                shippingFee = 0;
                displayShipping.textContent = "Gratuit (Offert)";
            } else {
                const districtVal = districtInput ? districtInput.value.trim().toLowerCase() : '';
                if (districtVal && zoneFees[districtVal] !== undefined) {
                    shippingFee = zoneFees[districtVal];
                } else {
                    shippingFee = 1500;
                }
                displayShipping.textContent = new Intl.NumberFormat('fr-FR').format(shippingFee) + " FCFA";
            }
        }

        const grandTotal = subtotal + shippingFee;
        displayTotal.textContent = new Intl.NumberFormat('fr-FR').format(grandTotal) + " FCFA";
    }

    if (deliveryMode) deliveryMode.addEventListener('change', recalculate);
    if (districtInput) districtInput.addEventListener('input', recalculate);
    recalculate();
});
</script>