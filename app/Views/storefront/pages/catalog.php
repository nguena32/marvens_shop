<?php
/**
 * Page Catalogue Complet
 */
$themeId = $theme ? $theme->getId() : 'fashion';
?>
<section class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <!-- En-tête catalogue -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-border pb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-headline font-bold text-on-surface">Catalogue de la Boutique</h1>
            <p class="text-xs sm:text-sm text-outline mt-1">
                <?= count($products ?? []) ?> article(s) disponible(s) immédiatement
            </p>
        </div>

        <!-- Recherche mobile / filtres rapides -->
        <form action="/catalogue" method="GET" class="flex items-center gap-2">
            <?php if (!empty($current_cat)): ?>
                <input type="hidden" name="cat" value="<?= (int)$current_cat ?>">
            <?php endif; ?>
            <div class="flex items-center bg-surface-container px-3 py-1.5 rounded-lg border border-border">
                <span class="material-symbols-outlined text-outline text-[18px] mr-2">search</span>
                <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" placeholder="Filtrer par nom..." class="bg-transparent border-none outline-none text-xs text-on-surface placeholder:text-outline w-40 sm:w-56"/>
            </div>
            <button type="submit" class="px-3 py-1.5 bg-primary text-on-primary btn-theme text-xs font-semibold">
                Chercher
            </button>
            <?php if (!empty($search_query) || !empty($current_cat)): ?>
                <a href="/catalogue" class="p-1.5 text-outline hover:text-error" title="Réinitialiser filtres">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Catégories / Filtres -->
    <?php if (!empty($categories)): ?>
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-6 scrollbar-none">
            <a href="/catalogue<?= !empty($search_query) ? '?q=' . urlencode($search_query) : '' ?>" class="px-3.5 py-1.5 rounded-xl border <?= empty($current_cat) ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-on-surface hover:bg-surface-container' ?> text-xs font-semibold whitespace-nowrap transition">
                Tous les articles
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php $isSelected = !empty($current_cat) && (int)$current_cat === (int)$cat['id']; ?>
                <a href="/catalogue?cat=<?= (int)$cat['id'] ?><?= !empty($search_query) ? '&q=' . urlencode($search_query) : '' ?>" class="px-3.5 py-1.5 rounded-xl border <?= $isSelected ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-on-surface hover:bg-surface-container' ?> text-xs font-semibold whitespace-nowrap transition">
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Grille des produits -->
    <?php if (empty($products)): ?>
        <div class="p-12 text-center rounded-2xl border border-border bg-surface">
            <span class="material-symbols-outlined text-5xl text-outline mb-3">search_off</span>
            <h3 class="font-headline font-bold text-base text-on-surface">Aucun article ne correspond à votre recherche</h3>
            <p class="text-xs text-outline mt-1 mb-4">Essayez avec d'autres mots-clés ou consultez l'ensemble du catalogue.</p>
            <a href="/catalogue" class="px-4 py-2 bg-primary text-on-primary btn-theme text-xs font-semibold inline-block">
                Afficher tous les articles
            </a>
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
