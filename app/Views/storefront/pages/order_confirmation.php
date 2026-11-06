<?php
/**
 * Page de confirmation de commande
 */
$themeId = $theme ? $theme->getId() : 'fashion';
?>
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto w-full text-center">
    <div class="card-theme p-8 bg-surface space-y-6">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-700 mx-auto flex items-center justify-center">
            <span class="material-symbols-outlined text-4xl">check_circle</span>
        </div>

        <div>
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">
                Commande Enregistrée avec Succès
            </span>
            <h1 class="text-2xl sm:text-3xl font-headline font-bold text-on-surface mt-3">
                Merci pour votre commande !
            </h1>
            <p class="text-xs sm:text-sm text-outline mt-1">
                Numéro de référence officiel : <strong class="font-mono text-on-surface"><?= htmlspecialchars($order['order_number'] ?? '') ?></strong>
            </p>
        </div>

        <div class="p-4 rounded-xl bg-surface-container-low border border-border text-left text-xs space-y-2">
            <div class="flex justify-between">
                <span class="text-outline">Client :</span>
                <span class="font-semibold text-on-surface"><?= htmlspecialchars($order['customer_name'] ?? '') ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-outline">WhatsApp :</span>
                <span class="font-semibold text-on-surface"><?= htmlspecialchars($order['customer_whatsapp'] ?? '') ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-outline">Montant total :</span>
                <span class="font-bold text-primary"><?= number_format((float)($order['total_amount'] ?? 0), 0, ',', ' ') ?> FCFA</span>
            </div>
            <div class="flex justify-between">
                <span class="text-outline">Mode de paiement :</span>
                <span class="text-on-surface font-medium">Paiement à la livraison</span>
            </div>
        </div>

        <?php if (!empty($whatsapp_url)): ?>
            <div class="space-y-3 pt-2">
                <a href="<?= htmlspecialchars($whatsapp_url) ?>" target="_blank" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg transition">
                    <span class="material-symbols-outlined">chat</span>
                    Envoyer ma commande sur WhatsApp
                </a>
                <p class="text-[11px] text-outline">
                    Si WhatsApp ne s'ouvre pas automatiquement, cliquez sur le bouton vert ci-dessus.
                </p>
            </div>
        <?php endif; ?>

        <div class="pt-4 border-t border-border flex justify-center gap-4">
            <a href="/" class="text-xs text-primary font-semibold hover:underline">
                Retour à l'accueil
            </a>
            <span>•</span>
            <a href="/catalogue" class="text-xs text-outline hover:text-on-surface">
                Continuer les achats
            </a>
        </div>
    </div>
</section>
