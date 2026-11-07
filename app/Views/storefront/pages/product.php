<?php
/**
 * Fiche détaillée d'un Produit
 * Conforme 1.3 : Nom, Description, Prix, Prix promotionnel, Photos, Référence/SKU,
 * Catégorie, Disponibilité, Variantes, Tailles, Couleurs, Stock, Bouton Ajouter panier,
 * Bouton WhatsApp direct, Produits similaires, Template responsive.
 */
$themeId = $theme ? $theme->getId() : 'fashion';
$finalPrice = !empty($product['promotional_price']) && (float)$product['promotional_price'] < (float)$product['price']
    ? (float)$product['promotional_price']
    : (float)$product['price'];
$hasPromo = !empty($product['promotional_price']) && (float)$product['promotional_price'] < (float)$product['price'];

$variants = $product['variants'] ?? [];
$isAvailable = !empty($product['is_active']);

// Préparation URL WhatsApp direct
$shopName = $shop_name ?? 'Marvens Shop';
$waNum = preg_replace('/[^0-9]/', '', (string)($whatsapp_number ?? '237699000000'));
$waDirectMsg = "Bonjour " . $shopName . ", je souhaite commander l'article *" . $product['name'] . "* (Réf: " . ($product['sku'] ?? 'N/A') . ") au prix de " . number_format($finalPrice, 0, ',', ' ') . " FCFA.";
$waDirectUrl = "https://wa.me/" . $waNum . "?text=" . rawurlencode($waDirectMsg);
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
        <!-- 1.3 Visuel & Galerie Photos/Vidéos Produit -->
        <div class="space-y-4">
            <div class="card-theme bg-surface overflow-hidden aspect-square flex items-center justify-center relative rounded-2xl border border-border shadow-sm" id="main-media-container">
                <?php 
                $mainUrl = !empty($product['main_image_url']) 
                    ? (str_starts_with($product['main_image_url'], 'http') ? $product['main_image_url'] : '/' . ltrim($product['main_image_url'], '/'))
                    : '';
                ?>
                <?php if (!empty($mainUrl)): ?>
                    <img id="main-product-image" src="<?= htmlspecialchars($mainUrl) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover transition-all duration-300"/>
                    <video id="main-product-video" src="" controls playsinline class="w-full h-full object-cover hidden"></video>
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

                <!-- Badge Disponibilité -->
                <div class="absolute bottom-4 left-4 bg-surface/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1.5 shadow-sm border border-border">
                    <span class="w-2 h-2 rounded-full <?= $isAvailable ? 'bg-emerald-500' : 'bg-red-500' ?>"></span>
                    <span class="<?= $isAvailable ? 'text-emerald-700' : 'text-red-700' ?>"><?= $isAvailable ? 'En stock / Disponible' : 'Rupture de stock' ?></span>
                </div>
            </div>

            <!-- Galerie de miniatures (Images & Vidéos) -->
            <?php 
            $mediaList = $product['media'] ?? [];
            ?>
            <?php if (!empty($mediaList) || !empty($mainUrl)): ?>
                <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                    <?php if (!empty($mainUrl)): ?>
                        <button type="button" onclick="switchMainMedia('image', '<?= htmlspecialchars($mainUrl) ?>', this)" class="media-thumb-btn flex-shrink-0 w-16 h-16 rounded-xl border-2 border-primary overflow-hidden bg-surface relative focus:outline-none">
                            <img src="<?= htmlspecialchars($mainUrl) ?>" alt="" class="w-full h-full object-cover">
                        </button>
                    <?php endif; ?>

                    <?php foreach ($mediaList as $item): ?>
                        <?php 
                        $itemUrl = str_starts_with($item['media_url'], 'http') ? $item['media_url'] : '/' . ltrim($item['media_url'], '/');
                        $isVideo = ($item['media_type'] === 'video');
                        ?>
                        <button type="button" onclick="switchMainMedia('<?= $isVideo ? 'video' : 'image' ?>', '<?= htmlspecialchars($itemUrl) ?>', this)" class="media-thumb-btn flex-shrink-0 w-16 h-16 rounded-xl border border-border hover:border-outline overflow-hidden bg-surface-container relative focus:outline-none transition">
                            <?php if ($isVideo): ?>
                                <div class="w-full h-full flex flex-col items-center justify-center bg-zinc-900 text-white">
                                    <span class="material-symbols-outlined text-[20px] text-amber-400">play_circle</span>
                                    <span class="text-[9px] font-bold uppercase mt-0.5">Vidéo</span>
                                </div>
                            <?php else: ?>
                                <img src="<?= htmlspecialchars($itemUrl) ?>" alt="" class="w-full h-full object-cover">
                            <?php endif; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- 1.3 Détails, Variantes & Formulaire d'Achat -->
        <div class="space-y-6">
            <div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs text-primary font-bold uppercase tracking-wider">
                        <?= htmlspecialchars($product['category_name'] ?? 'Article officiel') ?>
                    </span>
                    <?php if (!empty($product['sku'])): ?>
                        <span class="text-xs text-outline font-mono bg-surface-container px-2 py-0.5 rounded">
                            SKU : <?= htmlspecialchars($product['sku']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <h1 class="text-2xl sm:text-4xl font-headline font-bold text-on-surface mt-1">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>
            </div>

            <!-- Prix & Économie promo -->
            <div class="p-4 rounded-2xl bg-surface-container-low border border-border flex flex-wrap items-baseline gap-3">
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
                <h3 class="font-headline font-semibold text-sm text-on-surface">Description</h3>
                <div class="text-xs sm:text-sm text-outline leading-relaxed prose prose-sm max-w-none">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Article de premier choix issu de notre sélection.')) ?>
                </div>
            </div>

            <!-- Formulaire d'ajout au panier avec choix de Variantes (Tailles, Couleurs, Stock) -->
            <form method="POST" action="/panier/ajouter" class="space-y-4 pt-4 border-t border-border">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">

                <?php if (!empty($variants)): ?>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface">
                            Sélectionnez une déclinaison (Taille / Couleur / Stock) :
                        </label>
                        <select name="variant" class="w-full px-3 py-2.5 rounded-xl border border-border bg-surface text-xs font-medium text-on-surface outline-none focus:border-primary">
                            <?php foreach ($variants as $v): ?>
                                <option value="<?= htmlspecialchars($v['variant_name']) ?>">
                                    <?= htmlspecialchars($v['variant_name']) ?>
                                    <?php if (!empty($v['size'])): ?> — Taille <?= htmlspecialchars($v['size']) ?><?php endif; ?>
                                    <?php if (!empty($v['color'])): ?> — <?= htmlspecialchars($v['color']) ?><?php endif; ?>
                                    (Dispo: <?= (int)$v['stock_quantity'] ?> ex.)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="flex items-center gap-4">
                    <label for="quantity" class="text-xs font-bold text-on-surface">Quantité :</label>
                    <div class="flex items-center border border-border rounded-xl bg-surface overflow-hidden">
                        <button type="button" onclick="const q = document.getElementById('qty'); if (q.value > 1) q.value--;" class="px-3 py-1.5 text-on-surface hover:bg-surface-container transition font-bold">-</button>
                        <input type="number" id="qty" name="quantity" value="1" min="1" max="99" class="w-12 text-center text-xs font-bold bg-transparent border-none outline-none"/>
                        <button type="button" onclick="const q = document.getElementById('qty'); q.value++;" class="px-3 py-1.5 text-on-surface hover:bg-surface-container transition font-bold">+</button>
                    </div>
                </div>

                <!-- 1.3 Bouton Ajouter au panier & Bouton WhatsApp direct -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit" class="flex-1 py-3 px-6 bg-primary text-on-primary btn-theme text-xs font-bold flex items-center justify-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                        Ajouter au panier
                    </button>
                    <a href="<?= htmlspecialchars($waDirectUrl) ?>" target="_blank" class="py-3 px-5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition">
                        <span class="material-symbols-outlined text-[18px]">chat</span>
                        Commander sur WhatsApp
                    </a>
                </div>
            </form>

            <!-- Réassurance -->
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-border text-xs text-outline">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">local_shipping</span>
                    <span>Livraison rapide partout au Cameroun</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-[18px]">payments</span>
                    <span>Paiement à réception en mains propres</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 1.3 Produits Similaires -->
    <?php if (!empty($similar_products)): ?>
        <div class="mt-16 pt-8 border-t border-border">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-headline font-bold text-xl text-on-surface">Produits Similaires</h3>
                    <p class="text-xs text-outline">D'autres articles de la même collection qui pourraient vous plaire</p>
                </div>
                <a href="/catalogue<?= !empty($product['category_id']) ? '?cat=' . (int)$product['category_id'] : '' ?>" class="text-xs text-primary font-semibold hover:underline">
                    Voir plus dans cette catégorie &rarr;
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <?php foreach ($similar_products as $sim): ?>
                    <?php
                        $simPrice = !empty($sim['promotional_price']) && (float)$sim['promotional_price'] < (float)$sim['price'] 
                            ? (float)$sim['promotional_price'] 
                            : (float)$sim['price'];
                        $simPromo = !empty($sim['promotional_price']) && (float)$sim['promotional_price'] < (float)$sim['price'];
                    ?>
                    <div class="card-theme bg-surface flex flex-col justify-between overflow-hidden group">
                        <a href="/produit/<?= htmlspecialchars($sim['slug']) ?>" class="block relative aspect-square bg-surface-container overflow-hidden">
                            <?php if (!empty($sim['main_image_url'])): ?>
                                <img src="<?= htmlspecialchars($sim['main_image_url']) ?>" alt="<?= htmlspecialchars($sim['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-outline">
                                    <span class="material-symbols-outlined text-3xl">image</span>
                                </div>
                            <?php endif; ?>
                            <?php if ($simPromo): ?>
                                <span class="absolute top-2 left-2 bg-error text-white text-[9px] font-bold px-1.5 py-0.5 rounded badge-theme">
                                    PROMO
                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="p-3 flex flex-col flex-1 justify-between gap-2">
                            <h4 class="font-headline font-bold text-xs text-on-surface line-clamp-1">
                                <a href="/produit/<?= htmlspecialchars($sim['slug']) ?>" class="hover:text-primary transition">
                                    <?= htmlspecialchars($sim['name']) ?>
                                </a>
                            </h4>
                            <div class="font-headline font-bold text-xs text-primary">
                                <?= number_format($simPrice, 0, ',', ' ') ?> FCFA
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <script>
        function switchMainMedia(type, url, btn) {
            const imgEl = document.getElementById('main-product-image');
            const vidEl = document.getElementById('main-product-video');

            if (!imgEl || !vidEl) return;

            if (type === 'video') {
                imgEl.classList.add('hidden');
                vidEl.classList.remove('hidden');
                vidEl.src = url;
                vidEl.load();
                vidEl.play().catch(() => {});
            } else {
                vidEl.pause();
                vidEl.classList.add('hidden');
                imgEl.classList.remove('hidden');
                imgEl.src = url;
            }

            document.querySelectorAll('.media-thumb-btn').forEach(b => {
                b.classList.remove('border-primary', 'border-2');
                b.classList.add('border-border');
            });
            if (btn) {
                btn.classList.add('border-primary', 'border-2');
                btn.classList.remove('border-border');
            }
        }
    </script>
</section>
