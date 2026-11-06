<?php
/**
 * Fiche détaillée d'un Produit
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$finalPrice = !empty($product['promo_price']) ? (float)$product['promo_price'] : (float)$product['price'];
$hasPromo = !empty($product['promo_price']) && (float)$product['promo_price'] < (float)$product['price'];
?>
<section class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <!-- Fil d'ariane -->
    <nav class="flex items-center gap-2 text-xs text-outline mb-6">
        <a href="/" class="hover:text-primary transition">Accueil</a>
        <span>/</span>
        <a href="/catalogue" class="hover:text-primary transition">Catalogue</a>
        <span>/</span>
        <span class="text-on-surface font-medium truncate max-w-xs"><?= htmlspecialchars($product['name']) ?></span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-start">
        <!-- Visuel Produit -->
        <div class="card-theme bg-surface overflow-hidden aspect-square flex items-center justify-center relative">
            <?php if (!empty($product['main_image_url'])): ?>
                <img src="<?= htmlspecialchars($product['main_image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover"/>
            <?php else: ?>
                <div class="text-outline text-center p-8">
                    <span class="material-symbols-outlined text-6xl">image</span>
                    <p class="text-xs mt-2">Visuel de présentation</p>
                </div>
            <?php endif; ?>

            <?php if ($hasPromo): ?>
                <span class="absolute top-4 left-4 bg-error text-white text-xs font-bold px-3 py-1 rounded badge-theme">
                    OFFRE PROMOTIONNELLE
                </span>
            <?php endif; ?>
        </div>

        <!-- Détails & Achat -->
        <div class="space-y-6">
            <div>
                <span class="text-xs text-primary font-bold uppercase tracking-wider">
                    <?= htmlspecialchars($product['category_name'] ?? 'Article officiel') ?>
                </span>
                <h1 class="text-2xl sm:text-4xl font-headline font-bold text-on-surface mt-1">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>
                <?php if (!empty($product['sku'])): ?>
                    <p class="text-xs text-outline mt-1 font-mono">Réf : <?= htmlspecialchars($product['sku']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Prix -->
            <div class="p-4 rounded-2xl bg-surface-container-low border border-border flex items-baseline gap-3">
                <span class="text-3xl font-headline font-bold text-primary">
                    <?= number_format($finalPrice, 0, ',', ' ') ?> FCFA
                </span>
                <?php if ($hasPromo): ?>
                    <span class="text-sm text-outline line-through">
                        <?= number_format((float)$product['price'], 0, ',', ' ') ?> FCFA
                    </span>
                    <span class="text-xs font-bold text-error bg-error/10 px-2 py-0.5 rounded">
                        Économie : <?= number_format((float)$product['price'] - $finalPrice, 0, ',', ' ') ?> FCFA
                    </span>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <h3 class="font-headline font-semibold text-sm text-on-surface">Description du produit</h3>
                <div class="text-xs sm:text-sm text-outline leading-relaxed prose prose-sm max-w-none">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Aucune description détaillée renseignée pour cet article.')) ?>
                </div>
            </div>

            <!-- Formulaire d'ajout au panier -->
            <form method="POST" action="/panier/ajouter" class="space-y-4 pt-4 border-t border-border">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">

                <div class="flex items-center gap-4">
                    <label for="quantity" class="text-xs font-medium text-on-surface">Quantité :</label>
                    <div class="flex items-center border border-border rounded-xl bg-surface overflow-hidden">
                        <button type="button" onclick="const q = document.getElementById('qty'); if (q.value > 1) q.value--;" class="px-3 py-1.5 text-on-surface hover:bg-surface-container transition font-bold">-</button>
                        <input type="number" id="qty" name="quantity" value="1" min="1" max="99" class="w-12 text-center text-xs font-bold bg-transparent border-none outline-none"/>
                        <button type="button" onclick="const q = document.getElementById('qty'); q.value++;" class="px-3 py-1.5 text-on-surface hover:bg-surface-container transition font-bold">+</button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 py-3 px-6 bg-primary text-on-primary btn-theme text-sm font-semibold flex items-center justify-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                        Ajouter au panier
                    </button>
                    <a href="/catalogue" class="py-3 px-4 border border-border rounded-xl text-center text-xs font-medium hover:bg-surface-container transition">
                        Continuer les achats
                    </a>
                </div>
            </form>

            <!-- Réassurance -->
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-border text-xs text-outline">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">local_shipping</span>
                    <span>Livraison à Yaoundé & Douala</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-[18px]">verified_user</span>
                    <span>Paiement sécurisé à la livraison</span>
                </div>
            </div>
        </div>
    </div>
</section>
