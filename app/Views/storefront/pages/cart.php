<?php
/**
 * Page Récapitulative du Panier
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$items = $cart['items'] ?? [];
$subtotal = $cart['subtotal'] ?? 0;
?>
<section class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
    <div class="mb-8 border-b border-border pb-4">
        <h1 class="text-2xl sm:text-3xl font-headline font-bold text-on-surface">Mon Panier d'Achats</h1>
        <p class="text-xs text-outline mt-1">Vérifiez vos articles avant de finaliser votre commande</p>
    </div>

    <?php if (empty($items)): ?>
        <div class="card-theme p-12 text-center bg-surface max-w-xl mx-auto space-y-4">
            <span class="material-symbols-outlined text-6xl text-outline">shopping_bag</span>
            <h3 class="font-headline font-bold text-lg text-on-surface">Votre panier est actuellement vide</h3>
            <p class="text-xs text-outline">Parcourez notre catalogue pour découvrir nos articles et commencer vos achats.</p>
            <div class="pt-2">
                <a href="/catalogue" class="px-6 py-2.5 bg-primary text-on-primary btn-theme text-xs font-semibold inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">storefront</span>
                    Découvrir nos produits
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Liste des articles -->
            <div class="lg:col-span-8 space-y-4">
                <?php foreach ($items as $item): ?>
                    <div class="card-theme p-4 bg-surface flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-16 h-16 rounded-xl bg-surface-container flex-shrink-0 overflow-hidden">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover"/>
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-outline">
                                        <span class="material-symbols-outlined">image</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-headline font-bold text-sm text-on-surface"><?= htmlspecialchars($item['name']) ?></h4>
                                <div class="text-xs text-primary font-bold mt-0.5">
                                    <?= number_format((float)$item['price'], 0, ',', ' ') ?> FCFA
                                </div>
                            </div>
                        </div>

                        <!-- Modifier quantité & Supprimer -->
                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                            <form method="POST" action="/panier/modifier" class="flex items-center border border-border rounded-lg bg-surface">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="item_key" value="<?= htmlspecialchars($item['key']) ?>">
                                <button type="submit" name="quantity" value="<?= max(0, $item['quantity'] - 1) ?>" class="px-2.5 py-1 text-xs font-bold hover:bg-surface-container">-</button>
                                <span class="px-2 text-xs font-bold"><?= (int)$item['quantity'] ?></span>
                                <button type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>" class="px-2.5 py-1 text-xs font-bold hover:bg-surface-container">+</button>
                            </form>

                            <div class="text-right min-w-[90px]">
                                <span class="font-headline font-bold text-sm text-on-surface">
                                    <?= number_format((float)$item['total'], 0, ',', ' ') ?> FCFA
                                </span>
                            </div>

                            <form method="POST" action="/panier/supprimer">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="item_key" value="<?= htmlspecialchars($item['key']) ?>">
                                <button type="submit" class="text-outline hover:text-error transition p-1" title="Supprimer cet article">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Récapitulatif -->
            <div class="lg:col-span-4 card-theme p-6 bg-surface space-y-4">
                <h3 class="font-headline font-bold text-base text-on-surface border-b border-border pb-3">Récapitulatif de commande</h3>
                <div class="flex items-center justify-between text-xs text-outline">
                    <span>Sous-total articles</span>
                    <span class="font-bold text-on-surface"><?= number_format((float)$subtotal, 0, ',', ' ') ?> FCFA</span>
                </div>
                <div class="flex items-center justify-between text-xs text-outline">
                    <span>Frais de livraison</span>
                    <span class="text-on-surface font-medium">Calculés à l'étape suivante</span>
                </div>
                <div class="border-t border-border pt-3 flex items-center justify-between">
                    <span class="font-headline font-bold text-sm text-on-surface">Total provisoire</span>
                    <span class="font-headline font-bold text-lg text-primary"><?= number_format((float)$subtotal, 0, ',', ' ') ?> FCFA</span>
                </div>

                <a href="/checkout" class="w-full py-3 bg-primary text-on-primary btn-theme text-xs font-semibold flex items-center justify-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">lock</span>
                    Passer la commande
                </a>
                <a href="/catalogue" class="w-full py-2 border border-border rounded-xl text-center text-xs font-medium hover:bg-surface-container block transition">
                    Continuer mes achats
                </a>
            </div>
        </div>
    <?php endif; ?>
</section>
