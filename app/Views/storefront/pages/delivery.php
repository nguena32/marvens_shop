<?php
/**
 * Page Livraison et Retrait en boutique
 */
?>
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
    <nav class="flex items-center gap-2 text-xs text-outline mb-6">
        <a href="/" class="hover:text-primary transition">Accueil</a>
        <span>/</span>
        <span class="text-on-surface font-medium">Livraison & Retrait</span>
    </nav>

    <div class="card-theme p-8 bg-surface space-y-8">
        <div>
            <span class="text-xs text-primary font-bold uppercase tracking-wider">Modalités & Délais</span>
            <h1 class="text-2xl sm:text-4xl font-headline font-bold text-on-surface mt-1">Livraison & Retrait en Boutique</h1>
            <p class="text-xs text-outline mt-1">Toutes les informations sur l'expédition de vos colis et les points de retrait.</p>
        </div>

        <!-- 2 modes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-2xl border border-border bg-surface-container-low space-y-4">
                <div class="w-12 h-12 rounded-xl bg-primary text-on-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">local_shipping</span>
                </div>
                <h3 class="font-headline font-bold text-base text-on-surface">1. Livraison à Domicile ou Bureau</h3>
                <p class="text-xs text-outline leading-relaxed">
                    Nous livrons vos colis directement à l'adresse ou au quartier renseigné lors de votre commande.
                </p>
                <ul class="text-xs text-outline space-y-2">
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-emerald-600 text-[16px]">check</span> <strong>Douala & Yaoundé :</strong> Livraison sous 24h à 48h (Forfait 1 500 FCFA).</li>
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-emerald-600 text-[16px]">check</span> <strong>Autres villes du Cameroun :</strong> Expédition par agence de voyage agréée (Bafoussam, Bamenda, Garoua, etc.).</li>
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-emerald-600 text-[16px]">check</span> <strong>Paiement à la livraison :</strong> Règlement en espèces ou par Mobile Money (Orange Money / MTN MoMo) à la remise du colis.</li>
                </ul>
            </div>

            <div class="p-6 rounded-2xl border border-border bg-surface-container-low space-y-4">
                <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">store</span>
                </div>
                <h3 class="font-headline font-bold text-base text-on-surface">2. Retrait Gratuit en Boutique</h3>
                <p class="text-xs text-outline leading-relaxed">
                    Passez votre commande en ligne et venez récupérer votre article directement à notre adresse sans frais de transport.
                </p>
                <ul class="text-xs text-outline space-y-2">
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-emerald-600 text-[16px]">check</span> <strong>Coût :</strong> Gratuit (0 FCFA).</li>
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-emerald-600 text-[16px]">check</span> <strong>Disponibilité :</strong> Préparation en 2 heures après confirmation WhatsApp.</li>
                    <li class="flex items-center gap-2"><span class="material-symbols-outlined text-emerald-600 text-[16px]">check</span> <strong>Essayage sur place :</strong> Possibilité de vérifier la conformité et la taille au moment du retrait.</li>
                </ul>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 space-y-2">
            <h4 class="font-headline font-bold text-xs uppercase tracking-wider flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-amber-700">info</span>
                Procédure de confirmation par WhatsApp
            </h4>
            <p class="text-xs leading-relaxed text-amber-800">
                Dès que vous validez votre panier sur le site, un bon de commande avec un numéro unique (ex: <code>CMD-20261106-XXXX</code>) est généré. Vous échangez ensuite par WhatsApp avec notre gestionnaire pour caler l'heure exacte de rendez-vous ou le coursier dédié.
            </p>
        </div>

        <div class="pt-4 border-t border-border flex justify-between items-center text-xs">
            <a href="/catalogue" class="text-primary font-bold hover:underline">&larr; Retour au catalogue</a>
            <a href="/conditions-vente" class="text-outline hover:text-on-surface">Conditions Générales de Vente &rarr;</a>
        </div>
    </div>
</section>
