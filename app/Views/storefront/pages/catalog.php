<?php
/**
 * Page Catalogue Complet
 * Conforme 1.2 : Affichage produits, catégories, recherche, filtrage par prix,
 * nouveautés, promotions, produits populaires, disponibles, pagination / tri, responsive.
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$curFilter = $current_filter ?? '';
?>
<section class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <!-- En-tête catalogue -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-border pb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-headline font-bold text-on-surface">Catalogue des Articles</h1>
            <p class="text-xs sm:text-sm text-outline mt-1">
                <?= count($products ?? []) ?> article(s) disponible(s) immédiatement
            </p>
        </div>

        <!-- Recherche textuelle & Filtre rapide -->
        <form action="/catalogue" method="GET" class="flex flex-wrap items-center gap-2">
            <?php if (!empty($current_cat)): ?>
                <input type="hidden" name="cat" value="<?= (int)$current_cat ?>">
            <?php endif; ?>
            <?php if (!empty($curFilter)): ?>
                <input type="hidden" name="filter" value="<?= htmlspecialchars($curFilter) ?>">
            <?php endif; ?>

            <div class="flex items-center bg-surface-container px-3 py-1.5 rounded-xl border border-border">
                <span class="material-symbols-outlined text-outline text-[18px] mr-2">search</span>
                <input type="text" name="q" value="<?= htmlspecialchars($search_query ?? '') ?>" placeholder="Rechercher nom, réf..." class="bg-transparent border-none outline-none text-xs text-on-surface placeholder:text-outline w-36 sm:w-48"/>
            </div>

            <button type="submit" class="px-3.5 py-1.5 bg-primary text-on-primary btn-theme text-xs font-semibold">
                Chercher
            </button>
            <?php if (!empty($search_query) || !empty($current_cat) || !empty($min_price) || !empty($max_price) || !empty($curFilter)): ?>
                <a href="/catalogue" class="p-1.5 text-outline hover:text-error" title="Réinitialiser filtres">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Barre de Filtres : Prix & Tri -->
    <div class="bg-surface p-4 rounded-2xl border border-border mb-6 flex flex-wrap items-center justify-between gap-4 text-xs">
        <!-- Filtre Prix -->
        <form action="/catalogue" method="GET" class="flex flex-wrap items-center gap-2">
            <?php if (!empty($current_cat)): ?>
                <input type="hidden" name="cat" value="<?= (int)$current_cat ?>">
            <?php endif; ?>
            <?php if (!empty($search_query)): ?>
                <input type="hidden" name="q" value="<?= htmlspecialchars($search_query) ?>">
            <?php endif; ?>
            <?php if (!empty($curFilter)): ?>
                <input type="hidden" name="filter" value="<?= htmlspecialchars($curFilter) ?>">
            <?php endif; ?>

            <span class="font-bold text-on-surface flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px] text-primary">filter_alt</span> Prix (FCFA) :
            </span>
            <input type="number" name="min_price" value="<?= $min_price !== null ? (int)$min_price : '' ?>" placeholder="Min" class="w-20 px-2 py-1 rounded-lg border border-border bg-surface text-center outline-none">
            <span>—</span>
            <input type="number" name="max_price" value="<?= $max_price !== null ? (int)$max_price : '' ?>" placeholder="Max" class="w-24 px-2 py-1 rounded-lg border border-border bg-surface text-center outline-none">
            <button type="submit" class="px-3 py-1 bg-surface-container text-on-surface hover:bg-primary hover:text-on-primary rounded-lg font-semibold transition">
                Filtrer
            </button>
        </form>

        <!-- Filtres par Typologie : Nouveautés, Promos, Populaires, Prix -->
        <div class="flex flex-wrap items-center gap-1.5">
            <?php
                $buildUrl = function($filterVal) use ($current_cat, $search_query, $min_price, $max_price) {
                    $p = [];
                    if (!empty($current_cat)) $p['cat'] = $current_cat;
                    if (!empty($search_query)) $p['q'] = $search_query;
                    if ($min_price) $p['min_price'] = $min_price;
                    if ($max_price) $p['max_price'] = $max_price;
                    if ($filterVal) $p['filter'] = $filterVal;
                    return '/catalogue' . (!empty($p) ? '?' . http_build_query($p) : '');
                };
            ?>
            <a href="<?= $buildUrl('') ?>" class="px-2.5 py-1 rounded-lg border <?= empty($curFilter) ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-outline hover:text-on-surface' ?> font-semibold">
                Tous
            </a>
            <a href="<?= $buildUrl('promotions') ?>" class="px-2.5 py-1 rounded-lg border <?= $curFilter === 'promotions' ? 'bg-red-600 text-white border-red-600' : 'bg-surface border-border text-outline hover:text-on-surface' ?> font-semibold flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">local_offer</span> Promos
            </a>
            <a href="<?= $buildUrl('populaires') ?>" class="px-2.5 py-1 rounded-lg border <?= $curFilter === 'populaires' ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-outline hover:text-on-surface' ?> font-semibold flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">star</span> Populaires
            </a>
            <a href="<?= $buildUrl('nouveautes') ?>" class="px-2.5 py-1 rounded-lg border <?= $curFilter === 'nouveautes' ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-outline hover:text-on-surface' ?> font-semibold">
                Nouveautés
            </a>
            <a href="<?= $buildUrl('price_asc') ?>" class="px-2.5 py-1 rounded-lg border <?= $curFilter === 'price_asc' ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-outline hover:text-on-surface' ?> font-semibold" title="Prix croissant">
                Prix ↑
            </a>
            <a href="<?= $buildUrl('price_desc') ?>" class="px-2.5 py-1 rounded-lg border <?= $curFilter === 'price_desc' ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-outline hover:text-on-surface' ?> font-semibold" title="Prix décroissant">
                Prix ↓
            </a>
        </div>
    </div>

    <!-- Catégories / Pills horizontales -->
    <?php if (!empty($categories)): ?>
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-6 scrollbar-none">
            <?php
                $catBase = function($catId = null) use ($search_query, $min_price, $max_price, $curFilter) {
                    $p = [];
                    if ($catId) $p['cat'] = $catId;
                    if (!empty($search_query)) $p['q'] = $search_query;
                    if ($min_price) $p['min_price'] = $min_price;
                    if ($max_price) $p['max_price'] = $max_price;
                    if ($curFilter) $p['filter'] = $curFilter;
                    return '/catalogue' . (!empty($p) ? '?' . http_build_query($p) : '');
                };
            ?>
            <a href="<?= $catBase(null) ?>" class="px-3.5 py-1.5 rounded-xl border <?= empty($current_cat) ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-on-surface hover:bg-surface-container' ?> text-xs font-semibold whitespace-nowrap transition">
                Tous les rayons
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php $isSelected = !empty($current_cat) && (int)$current_cat === (int)$cat['id']; ?>
                <a href="<?= $catBase((int)$cat['id']) ?>" class="px-3.5 py-1.5 rounded-xl border <?= $isSelected ? 'bg-primary text-on-primary border-primary' : 'bg-surface border-border text-on-surface hover:bg-surface-container' ?> text-xs font-semibold whitespace-nowrap transition">
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
            <p class="text-xs text-outline mt-1 mb-4">Essayez d'ajuster vos filtres de prix ou parcourez l'ensemble de notre catalogue.</p>
            <a href="/catalogue" class="px-4 py-2 bg-primary text-on-primary btn-theme text-xs font-semibold inline-block">
                Réinitialiser tous les filtres
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($products as $prod): ?>
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
                        <?php elseif (!empty($prod['is_featured'])): ?>
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
