<?php
/**
 * Page Conditions de vente et de retour
 */
?>
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
    <nav class="flex items-center gap-2 text-xs text-outline mb-6">
        <a href="/" class="hover:text-primary transition">Accueil</a>
        <span>/</span>
        <span class="text-on-surface font-medium">Conditions de vente</span>
    </nav>

    <div class="card-theme p-8 bg-surface space-y-6">
        <div>
            <span class="text-xs text-primary font-bold uppercase tracking-wider">Cadre Légal & Commercial</span>
            <h1 class="text-2xl sm:text-4xl font-headline font-bold text-on-surface mt-1">Conditions de Vente & de Retour</h1>
            <p class="text-xs text-outline mt-1">Dernière mise à jour : 06 Novembre 2026</p>
        </div>

        <div class="space-y-6 text-xs sm:text-sm text-outline leading-relaxed">
            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">1. Objet et Champ d'Application</h3>
                <p>
                    Les présentes conditions régissent les ventes d'articles proposées sur le site <?= htmlspecialchars($shop_name ?? 'Marvens Shop') ?>. Toute commande passée sur la plateforme implique l'adhésion entière et sans réserve du client à ces conditions.
                </p>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">2. Prix et Monnaie</h3>
                <p>
                    Tous nos prix sont exprimés en Francs CFA (FCFA) et s'entendent toutes taxes comprises. Le montant facturé est celui validé par le serveur au moment de la commande. Les frais de livraison sont indiqués avant la validation finale.
                </p>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">3. Processus de Commande & WhatsApp</h3>
                <p>
                    Conformément au fonctionnement de Marvens Shop, la commande est enregistrée dans notre système avec un identifiant unique avant l'ouverture de WhatsApp. L'ouverture de l'application WhatsApp permet d'échanger directement avec le commerçant pour convenir des modalités finales de livraison.
                </p>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">4. Modalités de Paiement</h3>
                <p>
                    Le paiement s'effectue exclusivement à la livraison ou lors du retrait en boutique (en espèces ou par transfert Mobile Money : Orange Money / MTN MoMo). Aucun paiement en ligne par carte bancaire n'est requis ni collecté sur ce site.
                </p>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">5. Politique de Retour et Échange</h3>
                <p>
                    Vous disposez d'un délai de <strong>7 jours</strong> à compter de la réception de votre article pour solliciter un échange en cas de problème de taille ou de défaut avéré.
                </p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>L'article doit être dans son état d'origine, neuf, non porté et non lavé.</li>
                    <li>L'emballage et les étiquettes d'origine doivent être conservés intacts.</li>
                    <li>L'échange est traité rapidement via notre support WhatsApp.</li>
                </ul>
            </div>
        </div>

        <div class="pt-6 border-t border-border flex justify-between items-center text-xs">
            <a href="/" class="text-primary font-bold hover:underline">&larr; Retour à l'accueil</a>
            <a href="/politique-confidentialite" class="text-outline hover:text-on-surface">Politique de Confidentialité &rarr;</a>
        </div>
    </div>
</section>
