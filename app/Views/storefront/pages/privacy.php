<?php
/**
 * Page Politique de Confidentialité & Protection des données
 */
?>
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
    <nav class="flex items-center gap-2 text-xs text-outline mb-6">
        <a href="/" class="hover:text-primary transition">Accueil</a>
        <span>/</span>
        <span class="text-on-surface font-medium">Confidentialité</span>
    </nav>

    <div class="card-theme p-8 bg-surface space-y-6">
        <div>
            <span class="text-xs text-primary font-bold uppercase tracking-wider">Protection des Données</span>
            <h1 class="text-2xl sm:text-4xl font-headline font-bold text-on-surface mt-1">Politique de Confidentialité</h1>
            <p class="text-xs text-outline mt-1">Respect de votre vie privée et sécurisation de vos commandes</p>
        </div>

        <div class="space-y-6 text-xs sm:text-sm text-outline leading-relaxed">
            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">1. Données Collectées</h3>
                <p>
                    Dans le cadre de l'enregistrement de votre commande, nous collectons exclusivement les données strictement nécessaires au traitement et à la livraison de vos colis :
                </p>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <li>Nom et prénom de l'acheteur ;</li>
                    <li>Numéro de téléphone WhatsApp pour la confirmation et le suivi du coursier ;</li>
                    <li>Adresse ou quartier de livraison et instructions de repérage.</li>
                </ul>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">2. Finalité du Traitement</h3>
                <p>
                    Vos données sont utilisées uniquement par le commerçant gestionnaire de cette installation pour préparer vos commandes, générer les bordereaux de livraison et vous contacter sur WhatsApp. Aucune donnée n'est commercialisée, louée ou cédée à des tiers à des fins publicitaires.
                </p>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">3. Conservation et Sécurité</h3>
                <p>
                    L'application fonctionne sur une base de données MySQL 8 dédiée et isolée. Les accès au tableau de bord administrateur sont strictement protégés par mot de passe chiffré (Argon2id/Bcrypt), jetons CSRF et politiques d'accès étanches.
                </p>
            </div>

            <div>
                <h3 class="font-headline font-bold text-sm text-on-surface mb-2">4. Vos Droits</h3>
                <p>
                    Vous disposez d'un droit permanent d'accès, de rectification et d'effacement de vos coordonnées enregistrées. Pour exercer ce droit, il vous suffit de contacter le commerçant directement via notre service client WhatsApp ou par e-mail.
                </p>
            </div>
        </div>

        <div class="pt-6 border-t border-border flex justify-between items-center text-xs">
            <a href="/" class="text-primary font-bold hover:underline">&larr; Retour à l'accueil</a>
            <a href="/contact" class="text-outline hover:text-on-surface">Contacter le support &rarr;</a>
        </div>
    </div>
</section>
