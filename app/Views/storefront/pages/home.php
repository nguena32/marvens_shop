<?php
/**
 * Page d'accueil du Storefront Public
 * Conforme 1.1 : Présentation, Logo/Identité, Bannière, Commerce, Produits mis en avant,
 * Nouveautés, Promotions, Produits populaires, Catégories, Boutons catalogue, Contact WhatsApp, Infos pratiques.
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$shopName = $shop_name ?? 'Marvens Shop';
$waNum = preg_replace('/[^0-9]/', '', (string)($whatsapp_number ?? '237699000000'));
$waUrl = "https://wa.me/" . $waNum . "?text=" . rawurlencode("Bonjour " . $shopName . ", je souhaite commander sur votre boutique.");
?>
<!-- 1.1 Bannière principale & Présentation du commerce -->
<section class="py-12 md:py-16 px-4 sm:px-6 lg:px-8 border-b border-border bg-gradient-to-b from-surface to-background">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-7 space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container rounded-full text-xs font-semibold text-primary badge-theme">
                <span class="material-symbols-outlined text-[14px]">storefront</span>
                <span>Boutique en ligne officielle • <?= htmlspecialchars($shopName) ?></span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-headline font-black text-on-surface tracking-tight leading-tight">
                L'Élégance & la Qualité à portée de main
            </h1>
            <p class="text-xs sm:text-sm text-outline max-w-xl leading-relaxed">
                Parcourez notre catalogue exclusif. Commandez en quelques clics avec confirmation instantanée par <strong>WhatsApp</strong> et <strong>paiement à la livraison</strong> en toute sérénité.
            </p>
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="/catalogue" class="px-6 py-3 bg-primary text-on-primary btn-theme text-xs font-semibold flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">grid_view</span>
                    Accéder au catalogue complet
                </a>
                <a href="<?= htmlspecialchars($waUrl) ?>" target="_blank" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm transition">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    Contacter sur WhatsApp
                </a>
                <a href="#promotions" class="px-4 py-3 bg-surface-container text-on-surface hover:bg-surface-container-high btn-theme text-xs font-semibold transition">
                    Voir les promotions
                </a>
            </div>
        </div>

        <div class="lg:col-span-5 flex justify-center">
            <div class="card-theme p-6 w-full max-w-md bg-surface text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-surface-container-high text-primary mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">shopping_cart_checkout</span>
                </div>
                <h3 class="font-headline font-bold text-base text-on-surface">Commande 100% Simple & Rapide</h3>
                <p class="text-xs text-outline leading-relaxed">
                    1. Choisissez vos articles dans le catalogue<br>
                    2. Renseignez votre ville et quartier de livraison<br>
                    3. Finalisez l'échange direct avec le vendeur sur WhatsApp
                </p>
                <div class="pt-3 border-t border-border grid grid-cols-3 text-center gap-2 text-xs">
                    <div>
                        <div class="font-bold text-emerald-600">Paiement</div>
                        <div class="text-[10px] text-outline">À la livraison</div>
                    </div>
                    <div>
                        <div class="font-bold text-primary">Expédition</div>
                        <div class="text-[10px] text-outline">24h - 48h</div>
                    </div>
                    <div>
                        <div class="font-bold text-on-surface">Retours</div>
                        <div class="text-[10px] text-outline">7 jours</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 1.1 Catégories Principales -->
<?php if (!empty($categories)): ?>
<section class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-headline font-bold text-lg text-on-surface">Catégories Principales</h2>
            <p class="text-xs text-outline">Sélectionnez un univers pour filtrer le catalogue</p>
        </div>
        <a href="/catalogue" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
            Tout le catalogue <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
        </a>
    </div>

    <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
        <a href="/catalogue" class="px-4 py-2 rounded-xl border border-border bg-surface text-xs font-semibold whitespace-nowrap hover:bg-primary hover:text-on-primary transition">
            Tous les rayons
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="/catalogue?cat=<?= (int)$cat['id'] ?>" class="px-4 py-2 rounded-xl border border-border bg-surface text-xs font-semibold whitespace-nowrap hover:bg-primary hover:text-on-primary transition">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- 1.1 Promotions (si existantes) -->
<?php if (!empty($promotions)): ?>
<section id="promotions" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full border-t border-border">
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-error text-white text-[10px] font-bold uppercase tracking-wider mb-1">
                <span class="material-symbols-outlined text-[14px]">local_offer</span> Offres Spéciales
            </div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Promotions en Cours</h2>
            <p class="text-xs text-outline">Prix réduits exceptionnels valables jusqu'à épuisement des stocks</p>
        </div>
        <a href="/catalogue?filter=promotions" class="text-xs text-primary font-semibold hover:underline">
            Voir toutes les promos &rarr;
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <?php foreach (array_slice($promotions, 0, 4) as $prod): ?>
            <?php
                $finalPrice = (float)$prod['promotional_price'];
                $hasPromo = true;
            ?>
            <div class="card-theme bg-surface flex flex-col justify-between overflow-hidden group">
                <a href="/produit/<?= htmlspecialchars($prod['slug']) ?>" class="block relative aspect-square bg-surface-container overflow-hidden">
                    <?php if (!empty($prod['main_image_url'])): ?>
                        <img src="<?= htmlspecialchars($prod['main_image_url']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-outline">
                            <span class="material-symbols-outlined text-4xl">image</span>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-2 left-2 bg-error text-white text-[10px] font-bold px-2 py-0.5 rounded promo-theme">
                        PROMO
                    </span>
                </a>

                <div class="p-4 flex flex-col flex-1 justify-between gap-3 card-content-spacing">
                    <div>
                        <div class="text-[11px] text-outline font-medium uppercase tracking-wider mb-1">
                            <?= htmlspecialchars($prod['category_name'] ?? 'Boutique') ?>
                        </div>
                        <h3 class="font-headline font-bold text-sm text-on-surface line-clamp-2">
                            <a href="/produit/<?= htmlspecialchars($prod['slug']) ?>" class="hover:text-primary transition">
                                <?= htmlspecialchars($prod['name']) ?>
                            </a>
                        </h3>
                    </div>

                    <div>
                        <div class="flex items-baseline gap-2 mb-3">
                            <span class="font-headline font-bold text-base price-theme">
                                <?= number_format($finalPrice, 0, ',', ' ') ?> FCFA
                            </span>
                            <span class="text-xs text-outline line-through">
                                <?= number_format((float)$prod['price'], 0, ',', ' ') ?> FCFA
                            </span>
                        </div>

                        <form method="POST" action="/panier/ajouter">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <input type="hidden" name="product_id" value="<?= (int)$prod['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full py-2 bg-primary text-on-primary btn-theme text-xs font-semibold flex items-center justify-center gap-1.5 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- 1.1 Produits Mis en Avant & Populaires -->
<section id="featured" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full border-t border-border">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Produits en Vedette & Bestsellers</h2>
            <p class="text-xs text-outline">Les coups de cœur de notre clientèle</p>
        </div>
        <a href="/catalogue?filter=populaires" class="text-xs text-primary font-semibold hover:underline">
            Voir les populaires &rarr;
        </a>
    </div>

    <?php if (empty($featured_products)): ?>
        <div class="p-8 text-center rounded-2xl border border-border bg-surface text-outline text-xs">
            Aucun article en vedette pour le moment.
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach (array_slice($featured_products, 0, 4) as $prod): ?>
                <?php
                    $finalPrice = !empty($prod['promotional_price']) && (float)$prod['promotional_price'] < (float)$prod['price'] 
                        ? (float)$prod['promotional_price'] 
                        : (float)$prod['price'];
                    $hasPromo = !empty($prod['promotional_price']) && (float)$prod['promotional_price'] < (float)$prod['price'];
                ?>
                <div class="card-theme bg-surface flex flex-col justify-between overflow-hidden group">
                    <a href="/produit/<?= htmlspecialchars($prod['slug']) ?>" class="block relative aspect-square bg-surface-container overflow-hidden">
                        <?php if (!empty($prod['main_image_url'])): ?>
                            <img src="<?= htmlspecialchars($prod['main_image_url']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-outline">
                                <span class="material-symbols-outlined text-4xl">image</span>
                            </div>
                        <?php endif; ?>

                        <?php if ($hasPromo): ?>
                            <span class="absolute top-2 left-2 bg-error text-white text-[10px] font-bold px-2 py-0.5 rounded badge-theme">
                                PROMO
                            </span>
                        <?php else: ?>
                            <span class="absolute top-2 left-2 bg-primary text-on-primary text-[10px] font-bold px-2 py-0.5 rounded badge-theme">
                                VEDETTE
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="p-4 flex flex-col flex-1 justify-between gap-3">
                        <div>
                            <div class="text-[11px] text-outline font-medium uppercase tracking-wider mb-1">
                                <?= htmlspecialchars($prod['category_name'] ?? 'Boutique') ?>
                            </div>
                            <h3 class="font-headline font-bold text-sm text-on-surface line-clamp-2">
                                <a href="/produit/<?= htmlspecialchars($prod['slug']) ?>" class="hover:text-primary transition">
                                    <?= htmlspecialchars($prod['name']) ?>
                                </a>
                            </h3>
                        </div>

                        <div>
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="font-headline font-bold text-base text-primary">
                                    <?= number_format($finalPrice, 0, ',', ' ') ?> FCFA
                                </span>
                                <?php if ($hasPromo): ?>
                                    <span class="text-xs text-outline line-through">
                                        <?= number_format((float)$prod['price'], 0, ',', ' ') ?> FCFA
                                    </span>
                                <?php endif; ?>
                            </div>

                            <form method="POST" action="/panier/ajouter">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="product_id" value="<?= (int)$prod['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full py-2 bg-primary text-on-primary btn-theme text-xs font-semibold flex items-center justify-center gap-1.5 shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Ajouter au panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- 1.1 Nouveautés -->
<section class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full border-t border-border">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Dernières Nouveautés</h2>
            <p class="text-xs text-outline">Arrivages récents dans notre boutique</p>
        </div>
        <a href="/catalogue?filter=nouveautes" class="text-xs text-primary font-semibold hover:underline">
            Explorer les nouveautés &rarr;
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <?php foreach (array_slice($new_arrivals ?? $products, 0, 4) as $prod): ?>
            <?php
                $finalPrice = !empty($prod['promotional_price']) && (float)$prod['promotional_price'] < (float)$prod['price'] 
                    ? (float)$prod['promotional_price'] 
                    : (float)$prod['price'];
                $hasPromo = !empty($prod['promotional_price']) && (float)$prod['promotional_price'] < (float)$prod['price'];
            ?>
            <div class="card-theme bg-surface flex flex-col justify-between overflow-hidden group">
                <a href="/produit/<?= htmlspecialchars($prod['slug']) ?>" class="block relative aspect-square bg-surface-container overflow-hidden">
                    <?php if (!empty($prod['main_image_url'])): ?>
                        <img src="<?= htmlspecialchars($prod['main_image_url']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-outline">
                            <span class="material-symbols-outlined text-4xl">image</span>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-2 left-2 bg-surface-container text-on-surface text-[10px] font-bold px-2 py-0.5 rounded badge-theme">
                        NOUVEAU
                    </span>
                </a>

                <div class="p-4 flex flex-col flex-1 justify-between gap-3 card-content-spacing">
                    <div>
                        <div class="text-[11px] text-outline font-medium uppercase tracking-wider mb-1">
                            <?= htmlspecialchars($prod['category_name'] ?? 'Boutique') ?>
                        </div>
                        <h3 class="font-headline font-bold text-sm text-on-surface line-clamp-2">
                            <a href="/produit/<?= htmlspecialchars($prod['slug']) ?>" class="hover:text-primary transition">
                                <?= htmlspecialchars($prod['name']) ?>
                            </a>
                        </h3>
                    </div>

                    <div>
                        <div class="flex items-baseline gap-2 mb-3">
                            <span class="font-headline font-bold text-base price-theme">
                                <?= number_format($finalPrice, 0, ',', ' ') ?> FCFA
                            </span>
                            <?php if ($hasPromo): ?>
                                <span class="text-xs text-outline line-through">
                                    <?= number_format((float)$prod['price'], 0, ',', ' ') ?> FCFA
                                </span>
                            <?php endif; ?>
                        </div>

                        <form method="POST" action="/panier/ajouter">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <input type="hidden" name="product_id" value="<?= (int)$prod['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full py-2 bg-primary text-on-primary btn-theme text-xs font-semibold flex items-center justify-center gap-1.5 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                Ajouter au panier
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- 1.1 Informations Pratiques & Réassurance -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full border-t border-border mb-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-6 rounded-2xl bg-surface border border-border flex items-start gap-4">
            <span class="material-symbols-outlined text-primary text-3xl">local_shipping</span>
            <div>
                <h4 class="font-headline font-bold text-sm text-on-surface">Livraison Rapide</h4>
                <p class="text-xs text-outline mt-0.5">Expédition sécurisée sous 24h à 48h sur Douala et Yaoundé.</p>
                <a href="/livraison" class="text-[11px] text-primary font-semibold hover:underline mt-1 inline-block">Voir les tarifs &rarr;</a>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-surface border border-border flex items-start gap-4">
            <span class="material-symbols-outlined text-primary text-3xl">payments</span>
            <div>
                <h4 class="font-headline font-bold text-sm text-on-surface">Paiement à la Livraison</h4>
                <p class="text-xs text-outline mt-0.5">Réglez en cash ou Mobile Money à la réception du colis.</p>
                <a href="/conditions-vente" class="text-[11px] text-primary font-semibold hover:underline mt-1 inline-block">Modalités &rarr;</a>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-surface border border-border flex items-start gap-4">
            <span class="material-symbols-outlined text-primary text-3xl">store</span>
            <div>
                <h4 class="font-headline font-bold text-sm text-on-surface">Retrait en Boutique</h4>
                <p class="text-xs text-outline mt-0.5">Commandez en ligne et retirez votre colis sans frais.</p>
                <a href="/contact" class="text-[11px] text-primary font-semibold hover:underline mt-1 inline-block">Notre adresse &rarr;</a>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-surface border border-border flex items-start gap-4">
            <span class="material-symbols-outlined text-emerald-600 text-3xl">chat</span>
            <div>
                <h4 class="font-headline font-bold text-sm text-on-surface">Assistance WhatsApp</h4>
                <p class="text-xs text-outline mt-0.5">Des conseillers dédiés pour répondre à vos besoins 7j/7.</p>
                <a href="<?= htmlspecialchars($waUrl) ?>" target="_blank" class="text-[11px] text-emerald-600 font-semibold hover:underline mt-1 inline-block">Discuter maintenant &rarr;</a>
            </div>
        </div>
    </div>
</section>
