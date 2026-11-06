<?php
/**
 * Page d'accueil du Storefront Public
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$shopName = $shop_name ?? 'Marvens Shop';
?>
<!-- Hero Section Dynamique selon l'identité du thème -->
<section class="py-12 md:py-20 px-4 sm:px-6 lg:px-8 border-b border-border bg-gradient-to-b from-surface to-background">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-7 space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container rounded-full text-xs font-semibold text-primary badge-theme">
                <span class="material-symbols-outlined text-[14px]">storefront</span>
                <span>Boutique en ligne officielle</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-headline font-black text-on-surface tracking-tight leading-tight">
                Bienvenue sur <?= htmlspecialchars($shopName) ?>
            </h1>
            <p class="text-sm sm:text-base text-outline max-w-xl leading-relaxed">
                Découvrez nos collections sélectionnées avec rigueur. Ajoutez vos articles préférés au panier et finalisez votre commande directement sur WhatsApp en toute simplicité.
            </p>
            <div class="flex flex-wrap items-center gap-3 pt-2">
                <a href="/catalogue" class="px-6 py-3 bg-primary text-on-primary btn-theme text-sm font-semibold flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">grid_view</span>
                    Explorer le catalogue
                </a>
                <a href="#featured" class="px-6 py-3 bg-surface-container text-on-surface hover:bg-surface-container-high btn-theme text-sm font-semibold transition">
                    Articles du moment
                </a>
            </div>
        </div>

        <div class="lg:col-span-5 flex justify-center">
            <div class="card-theme p-6 w-full max-w-md bg-surface text-center space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-surface-container-high text-primary mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">shopping_cart_checkout</span>
                </div>
                <h3 class="font-headline font-bold text-lg text-on-surface">Commande 100% Facile</h3>
                <p class="text-xs text-outline leading-relaxed">
                    1. Choisissez vos produits<br>
                    2. Renseignez votre adresse de livraison<br>
                    3. Votre bon de commande WhatsApp est prêt instantanément !
                </p>
                <div class="pt-2 border-t border-border flex items-center justify-around text-xs text-on-surface font-medium">
                    <div class="flex items-center gap-1"><span class="material-symbols-outlined text-emerald-600 text-[16px]">verified</span> Garanti</div>
                    <div class="flex items-center gap-1"><span class="material-symbols-outlined text-primary text-[16px]">local_shipping</span> Express</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Catégories -->
<?php if (!empty($categories)): ?>
<section class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Nos Catégories</h2>
            <p class="text-xs text-outline">Parcourez notre catalogue par univers</p>
        </div>
        <a href="/catalogue" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
            Tout voir <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
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

<!-- Grille des Produits Phares -->
<section id="featured" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full mb-12">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Produits en Vedette</h2>
            <p class="text-xs text-outline">Disponibles immédiatement pour expédition</p>
        </div>
        <a href="/catalogue" class="text-xs text-primary font-semibold hover:underline">
            Voir le catalogue complet &rarr;
        </a>
    </div>

    <?php if (empty($products)): ?>
        <div class="p-12 text-center rounded-2xl border border-border bg-surface">
            <span class="material-symbols-outlined text-4xl text-outline mb-2">inventory_2</span>
            <p class="text-sm text-outline font-medium">Aucun produit actif pour le moment.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($products as $prod): ?>
                <?php
                    $finalPrice = !empty($prod['promo_price']) ? (float)$prod['promo_price'] : (float)$prod['price'];
                    $hasPromo = !empty($prod['promo_price']) && (float)$prod['promo_price'] < (float)$prod['price'];
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
