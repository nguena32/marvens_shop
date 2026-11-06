<?php
/**
 * Page Contact & Informations pratiques
 */
$waNum = preg_replace('/[^0-9]/', '', (string)($whatsapp_number ?? '237699000000'));
$waUrl = "https://wa.me/" . $waNum . "?text=" . rawurlencode("Bonjour " . ($shop_name ?? 'Marvens Shop') . ", je souhaite des informations sur votre boutique.");
?>
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
    <nav class="flex items-center gap-2 text-xs text-outline mb-6">
        <a href="/" class="hover:text-primary transition">Accueil</a>
        <span>/</span>
        <span class="text-on-surface font-medium">Contact</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        <div class="md:col-span-7 card-theme p-8 bg-surface space-y-6">
            <div>
                <span class="text-xs text-primary font-bold uppercase tracking-wider">Service Client</span>
                <h1 class="text-2xl sm:text-3xl font-headline font-bold text-on-surface mt-1">Nous Contacter</h1>
                <p class="text-xs text-outline mt-1 leading-relaxed">
                    Vous avez une question sur un article, une taille, ou le suivi de votre commande ? Notre équipe vous répond immédiatement.
                </p>
            </div>

            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-3">
                <div class="flex items-center gap-2 font-bold text-xs">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">chat</span>
                    <span>Assistance WhatsApp Directe (Privilégiée)</span>
                </div>
                <p class="text-xs leading-relaxed text-emerald-800">
                    Pour une réponse instantanée, privilégiez l'échange sur WhatsApp. Cliquez ci-dessous pour démarrer une conversation avec notre conseiller commercial.
                </p>
                <a href="<?= htmlspecialchars($waUrl) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm">
                    <span class="material-symbols-outlined text-[16px]">chat</span>
                    Ouvrir WhatsApp (+<?= htmlspecialchars($waNum) ?>)
                </a>
            </div>

            <div class="space-y-4 pt-4 border-t border-border">
                <div class="flex items-start gap-3 text-xs">
                    <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">call</span>
                    <div>
                        <div class="font-bold text-on-surface">Téléphone</div>
                        <div class="text-outline"><?= htmlspecialchars($shop_phone ?? '+237 699 00 00 00') ?></div>
                    </div>
                </div>
                <div class="flex items-start gap-3 text-xs">
                    <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">mail</span>
                    <div>
                        <div class="font-bold text-on-surface">Adresse E-mail</div>
                        <div class="text-outline"><?= htmlspecialchars($shop_email ?? 'contact@marvens-shop.cm') ?></div>
                    </div>
                </div>
                <div class="flex items-start gap-3 text-xs">
                    <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">location_on</span>
                    <div>
                        <div class="font-bold text-on-surface">Point de Retrait & Showroom</div>
                        <div class="text-outline"><?= htmlspecialchars($shop_address ?? 'Douala, Cameroun (Akwa)') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-5 card-theme p-6 bg-surface space-y-4">
            <h3 class="font-headline font-bold text-base text-on-surface border-b border-border pb-3">Horaires d'Ouverture</h3>
            <div class="space-y-3 text-xs text-outline">
                <div class="flex justify-between">
                    <span>Lundi — Vendredi :</span>
                    <span class="font-bold text-on-surface">08h30 — 18h30</span>
                </div>
                <div class="flex justify-between">
                    <span>Samedi :</span>
                    <span class="font-bold text-on-surface">09h00 — 17h00</span>
                </div>
                <div class="flex justify-between">
                    <span>Dimanche :</span>
                    <span class="text-emerald-600 font-bold">WhatsApp ouvert</span>
                </div>
            </div>

            <div class="pt-4 border-t border-border">
                <h4 class="font-headline font-semibold text-xs text-on-surface mb-2">Informations pratiques</h4>
                <p class="text-[11px] text-outline leading-relaxed">
                    Toutes les commandes passées sur notre site font l'objet d'un suivi téléphonique ou WhatsApp avant expédition pour convenir de l'horaire précis de livraison.
                </p>
            </div>
        </div>
    </div>
</section>
