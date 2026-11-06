<?php
/**
 * Page À Propos de la boutique
 */
?>
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
    <nav class="flex items-center gap-2 text-xs text-outline mb-6">
        <a href="/" class="hover:text-primary transition">Accueil</a>
        <span>/</span>
        <span class="text-on-surface font-medium">À propos</span>
    </nav>

    <div class="card-theme p-8 bg-surface space-y-6">
        <div>
            <span class="text-xs text-primary font-bold uppercase tracking-wider">Notre Histoire</span>
            <h1 class="text-2xl sm:text-4xl font-headline font-bold text-on-surface mt-1">À propos de <?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?></h1>
        </div>

        <div class="space-y-4 text-xs sm:text-sm text-outline leading-relaxed">
            <p>
                Bienvenue sur <strong><?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?></strong>, votre boutique en ligne de référence conçue pour vous offrir une expérience d'achat moderne, fluide et sécurisée.
            </p>
            <p>
                Notre mission est de rendre accessibles des produits de qualité supérieure avec une traçabilité totale et un service client personnalisé. Nous mettons un point d'honneur à simplifier chaque étape de votre commande : vous parcourez nos collections, ajoutez vos coups de cœur à votre panier, et finalisez l'échange directement avec nous sur WhatsApp.
            </p>
            <p>
                Grâce au modèle de commerce social Marvens Shop, vous bénéficiez de conseils en temps réel, de photos supplémentaires à la demande et d'un accompagnement sur mesure jusqu'à la remise en main propre de votre colis.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-border">
            <div class="p-4 rounded-xl bg-surface-container-low text-center space-y-2">
                <span class="material-symbols-outlined text-primary text-3xl">verified</span>
                <h4 class="font-headline font-bold text-xs text-on-surface">Qualité Vérifiée</h4>
                <p class="text-[11px] text-outline">Articles authentiques sélectionnés avec soin.</p>
            </div>
            <div class="p-4 rounded-xl bg-surface-container-low text-center space-y-2">
                <span class="material-symbols-outlined text-primary text-3xl">local_shipping</span>
                <h4 class="font-headline font-bold text-xs text-on-surface">Livraison Fiable</h4>
                <p class="text-[11px] text-outline">Expédition express à Douala, Yaoundé et partout au Cameroun.</p>
            </div>
            <div class="p-4 rounded-xl bg-surface-container-low text-center space-y-2">
                <span class="material-symbols-outlined text-emerald-600 text-3xl">chat</span>
                <h4 class="font-headline font-bold text-xs text-on-surface">Support WhatsApp</h4>
                <p class="text-[11px] text-outline">Une équipe humaine réactive à votre écoute 7j/7.</p>
            </div>
        </div>

        <div class="pt-6 border-t border-border flex justify-center">
            <a href="/catalogue" class="px-6 py-3 bg-primary text-on-primary btn-theme text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                Découvrir notre catalogue
            </a>
        </div>
    </div>
</section>
