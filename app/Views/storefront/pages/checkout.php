<?php
/**
 * Page Checkout & Saisie des coordonnées client
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$items = $cart['items'] ?? [];
$subtotal = $cart['subtotal'] ?? 0;
?>
<section class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <div class="mb-8 border-b border-border pb-4">
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

    <form method="POST" action="/checkout" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

        <!-- Formulaire client -->
        <div class="lg:col-span-7 card-theme p-6 bg-surface space-y-4">
            <h3 class="font-headline font-bold text-base text-on-surface border-b border-border pb-3">Informations de livraison</h3>

            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="customer_name">Nom et Prénom *</label>
                <input type="text" id="customer_name" name="customer_name" required placeholder="Ex: Jean Dupont" class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
            </div>

            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="customer_whatsapp">Numéro WhatsApp (avec indicatif) *</label>
                <input type="text" id="customer_whatsapp" name="customer_whatsapp" required placeholder="Ex: +237 690 00 00 00" class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"/>
            </div>

            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="delivery_mode">Mode de réception *</label>
                <select id="delivery_mode" name="delivery_mode" class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary">
                    <option value="delivery">Livraison à domicile ou bureau (+1 500 FCFA)</option>
                    <option value="pickup">Retrait direct en boutique (Gratuit)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="delivery_address">Adresse ou quartier de livraison</label>
                <textarea id="delivery_address" name="delivery_address" rows="2" placeholder="Ex: Bastos, en face de l'ambassade..." class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-on-surface mb-1" for="customer_notes">Note facultative pour la commande</label>
                <textarea id="customer_notes" name="customer_notes" rows="2" placeholder="Ex: Appelez-moi avant de passer..." class="w-full px-3 py-2 rounded-xl border border-border bg-surface text-xs text-on-surface outline-none focus:border-primary"></textarea>
            </div>
        </div>

        <!-- Récapitulatif et validation -->
        <div class="lg:col-span-5 card-theme p-6 bg-surface space-y-4">
            <h3 class="font-headline font-bold text-base text-on-surface border-b border-border pb-3">Votre commande</h3>

            <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                <?php foreach ($items as $item): ?>
                    <div class="flex items-center justify-between text-xs">
                        <div class="truncate max-w-[200px]">
                            <span class="font-bold text-on-surface"><?= (int)$item['quantity'] ?>x</span>
                            <span><?= htmlspecialchars($item['name']) ?></span>
                        </div>
                        <span class="font-bold text-on-surface"><?= number_format((float)$item['total'], 0, ',', ' ') ?> FCFA</span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="border-t border-border pt-3 space-y-2 text-xs text-outline">
                <div class="flex items-center justify-between">
                    <span>Sous-total articles</span>
                    <span class="font-bold text-on-surface"><?= number_format((float)$subtotal, 0, ',', ' ') ?> FCFA</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Livraison indicative</span>
                    <span class="text-on-surface font-medium">+1 500 FCFA (si livraison)</span>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-primary text-on-primary btn-theme text-xs font-bold flex items-center justify-center gap-2 shadow-md">
                <span class="material-symbols-outlined text-[18px]">send</span>
                Confirmer & Ouvrir WhatsApp
            </button>

            <p class="text-[11px] text-outline text-center leading-relaxed">
                Votre commande sera enregistrée sur le système et le message WhatsApp pré-rempli s'ouvrira immédiatement.
            </p>
        </div>
    </form>
</section>
