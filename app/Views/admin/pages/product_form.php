<?php
$active_tab = 'products';
$isEdit = !empty($product['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $isEdit ? 'Modifier le Produit' : 'Ajouter un Produit' ?> — Marvens Shop</title>
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
        }
        ::-webkit-scrollbar { display:none; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-container": "#fe932c",
                        "tertiary": "#000000",
                        "surface-container-low": "#f6f3f5",
                        "primary": "#000000",
                        "on-primary": "#ffffff",
                        "outline": "#76777d",
                        "surface-container": "#f0edef",
                        "on-surface": "#1b1b1d",
                        "secondary": "#904d00",
                        "surface-container-highest": "#e4e2e4",
                        "surface-container-high": "#eae7e9",
                        "surface": "#FFFFFF",
                        "background": "#F8FAFC",
                        "border": "#E2E8F0",
                        "on-surface-variant": "#45464d",
                        "error": "#ba1a1a"
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                    spacing: { "space-sm": "8px", "space-lg": "24px", "space-xs": "4px", "space-xl": "48px", "space-md": "16px" },
                    fontFamily: { "body-md": ["Inter"], "headline-md": ["Inter"], "headline-sm": ["Inter"] }
                }
            }
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet"/>
</head>
<body class="bg-background font-body-md text-on-surface">

    <?php include dirname(__DIR__) . '/partials/sidebar.php'; ?>

    <div class="pl-72">
        <?php include dirname(__DIR__) . '/partials/header.php'; ?>

        <main class="relative pt-16 bg-background min-h-screen p-space-lg">
            <div class="max-w-4xl mx-auto flex flex-col gap-space-lg">
                
                <?php if (!empty($errors)): ?>
                    <div class="p-space-md rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
                        <ul class="list-disc list-inside">
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($feedback)): ?>
                    <?php 
                    $feedbackType = is_array($feedback) ? ($feedback['type'] ?? 'success') : 'success';
                    $feedbackMsg = is_array($feedback) ? ($feedback['message'] ?? '') : (string)$feedback;
                    ?>
                    <div class="p-space-md rounded-2xl <?= $feedbackType === 'error' ? 'bg-rose-50 border border-rose-200 text-rose-800' : 'bg-emerald-50 border border-emerald-200 text-emerald-800' ?> text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined <?= $feedbackType === 'error' ? 'text-rose-600' : 'text-emerald-600' ?>">
                            <?= $feedbackType === 'error' ? 'error' : 'check_circle' ?>
                        </span>
                        <span><?= htmlspecialchars($feedbackMsg) ?></span>
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-between bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <a href="/admin/produits" class="text-xs text-outline hover:text-on-surface flex items-center gap-1 mb-1">
                            <span class="material-symbols-outlined text-[14px]">arrow_back</span> Retour au catalogue
                        </a>
                        <h1 class="text-2xl font-bold text-on-surface"><?= $isEdit ? 'Modifier la Fiche Produit' : 'Nouveau Produit' ?></h1>
                    </div>
                </div>

                <div class="bg-surface rounded-2xl border border-border p-space-lg shadow-sm">
                    <form method="POST" action="<?= $isEdit ? '/admin/produits/' . (int)$product['id'] . '/modifier' : '/admin/produits/nouveau' ?>" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                        <!-- Section 1 : Informations Générales -->
                        <div class="space-y-4">
                            <h2 class="text-base font-bold text-on-surface border-b border-border pb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">info</span> 1. Informations générales
                            </h2>

                            <div>
                                <label for="name" class="block text-xs font-semibold text-outline uppercase mb-1">Désignation de l'article *</label>
                                <input type="text" id="name" name="name" required value="<?= htmlspecialchars($product['name'] ?? '') ?>" placeholder="Ex: Robe Longue Sahara" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_id" class="block text-xs font-semibold text-outline uppercase mb-1">Catégorie</label>
                                    <select id="category_id" name="category_id" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                                        <option value="">-- Sans catégorie --</option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= (int) $cat['id'] ?>" <?= ((int)($product['category_id'] ?? 0) === (int)$cat['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="sku" class="block text-xs font-semibold text-outline uppercase mb-1">
                                        Référence SKU <span class="text-[10px] text-outline font-normal normal-case">(générée automatiquement si vide)</span>
                                    </label>
                                    <input type="text" id="sku" name="sku" value="<?= htmlspecialchars($product['sku'] ?? '') ?>" placeholder="Ex: ROBE-001 (ou laisser vide)" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none font-mono text-xs">
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-semibold text-outline uppercase mb-1">Description & Caractéristiques</label>
                                <textarea id="description" name="description" rows="3" placeholder="Matière, coupe, finitions..." class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Section 2 : Tarifs & Promotions -->
                        <div class="space-y-4 pt-2">
                            <h2 class="text-base font-bold text-on-surface border-b border-border pb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">payments</span> 2. Tarifs & Promotions
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-xs font-semibold text-outline uppercase mb-1">Prix standard (FCFA) *</label>
                                    <input type="number" id="price" name="price" required value="<?= htmlspecialchars((string)($product['price'] ?? '')) ?>" placeholder="Ex: 18500" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none font-semibold">
                                </div>
                                <div>
                                    <label for="promotional_price" class="block text-xs font-semibold text-outline uppercase mb-1">Prix promotionnel (FCFA)</label>
                                    <input type="number" id="promotional_price" name="promotional_price" value="<?= htmlspecialchars((string)($product['promotional_price'] ?? '')) ?>" placeholder="Optionnel (barrera le prix standard)" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm focus:outline-none text-red-600 font-semibold">
                                </div>
                            </div>
                        </div>

                        <!-- Section 3 : Visuel Principal & Médias -->
                        <div class="space-y-4 pt-2">
                            <h2 class="text-base font-bold text-on-surface border-b border-border pb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">image</span> 3. Image Principale
                            </h2>

                            <?php if (!empty($product['main_image_url'])): ?>
                                <div class="flex items-center gap-4 bg-surface-container-low p-3 rounded-xl border border-border">
                                    <img src="<?= htmlspecialchars(str_starts_with($product['main_image_url'], 'http') ? $product['main_image_url'] : '/' . ltrim($product['main_image_url'], '/')) ?>" alt="" class="w-16 h-16 rounded-lg object-cover border border-border">
                                    <div class="text-xs text-outline">
                                        <span class="font-semibold text-on-surface block">Image principale active</span>
                                        Choisissez un nouveau fichier ci-dessous pour la remplacer, ou sélectionnez une photo depuis la galerie ci-après.
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div>
                                <label for="image" class="block text-xs font-semibold text-outline uppercase mb-1">Sélectionner une image principale (JPEG, PNG, WEBP - Max 5 Mo)</label>
                                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                            </div>

                            <!-- Galerie d'images et vidéos additionnelles -->
                            <div class="pt-3 border-t border-dashed border-border space-y-3">
                                <div>
                                    <label class="block text-xs font-semibold text-outline uppercase mb-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">perm_media</span>
                                        Ajouter des photos & vidéos additionnelles
                                    </label>
                                    <input type="file" name="media_files[]" multiple accept="image/jpeg,image/png,image/webp,video/mp4,video/webm,video/ogg,video/quicktime" class="w-full bg-surface-container-low border border-border rounded-xl px-3 py-2 text-sm">
                                    <p class="text-[11px] text-outline mt-1">Vous pouvez sélectionner plusieurs fichiers simultanément (Images max 5 Mo, Vidéos MP4/WebM max 30 Mo).</p>
                                </div>
                            </div>
                        </div>

                        <?php if ($isEdit && !empty($product['media'])): ?>
                            <!-- Section 3.2 : Médias enregistrés -->
                            <div class="space-y-3 pt-2">
                                <h3 class="text-xs font-bold text-outline uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px]">collections</span>
                                    Galerie enregistrée (<?= count($product['media']) ?> média<?= count($product['media']) > 1 ? 's' : '' ?>)
                                </h3>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <?php foreach ($product['media'] as $mediaItem): ?>
                                        <div class="relative bg-surface-container-low border border-border rounded-xl overflow-hidden group flex flex-col justify-between">
                                            <div class="relative aspect-square bg-black/5 flex items-center justify-center overflow-hidden">
                                                <?php if ($mediaItem['media_type'] === 'video'): ?>
                                                    <video src="<?= htmlspecialchars(str_starts_with($mediaItem['media_url'], 'http') ? $mediaItem['media_url'] : '/' . ltrim($mediaItem['media_url'], '/')) ?>" class="w-full h-full object-cover" muted></video>
                                                    <span class="absolute top-2 right-2 bg-black/70 text-white text-[10px] px-1.5 py-0.5 rounded flex items-center gap-1 font-semibold">
                                                        <span class="material-symbols-outlined text-[12px]">videocam</span> Vidéo
                                                    </span>
                                                <?php else: ?>
                                                    <img src="<?= htmlspecialchars(str_starts_with($mediaItem['media_url'], 'http') ? $mediaItem['media_url'] : '/' . ltrim($mediaItem['media_url'], '/')) ?>" alt="" class="w-full h-full object-cover">
                                                    <span class="absolute top-2 right-2 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded font-semibold">
                                                        Image
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="p-2 bg-white flex items-center justify-between gap-1 border-t border-border">
                                                <?php if ($mediaItem['media_type'] === 'image'): ?>
                                                    <button type="button" onclick="submitMediaAction('<?= (int)$mediaItem['id'] ?>', 'definir-principale')" title="Définir comme image principale" class="text-[11px] font-semibold text-primary hover:text-secondary flex items-center gap-0.5">
                                                        <span class="material-symbols-outlined text-[14px]">star</span> Principale
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-[11px] text-outline italic">Vidéo</span>
                                                <?php endif; ?>

                                                <button type="button" onclick="if(confirm('Supprimer définitivement ce média ?')) submitMediaAction('<?= (int)$mediaItem['id'] ?>', 'supprimer')" title="Supprimer ce média" class="text-red-500 hover:text-red-700 p-1">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Section 4 : Variantes & Stock (Tailles, Couleurs) -->
                        <div class="space-y-4 pt-2">
                            <div class="flex items-center justify-between border-b border-border pb-2">
                                <h2 class="text-base font-bold text-on-surface flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary">tune</span> 4. Variantes & Stock (Tailles, Couleurs)
                                </h2>
                                <button type="button" onclick="addVariantRow()" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">add_circle</span> Ajouter une variante
                                </button>
                            </div>
                            <p class="text-xs text-outline">Laissez vide si le produit ne comporte pas d'options de déclinaisons.</p>

                            <div id="variants-container" class="space-y-3">
                                <?php 
                                $variants = $product['variants'] ?? [];
                                if (empty($variants)) {
                                    $variants = [['variant_name' => '', 'size' => '', 'color' => '', 'stock_quantity' => 10, 'price_override' => '']];
                                }
                                ?>
                                <?php foreach ($variants as $idx => $v): ?>
                                    <div class="variant-row grid grid-cols-1 sm:grid-cols-5 gap-2 bg-surface-container-low p-3 rounded-xl border border-border items-center">
                                        <div class="sm:col-span-2">
                                            <input type="text" name="variants[<?= $idx ?>][variant_name]" value="<?= htmlspecialchars($v['variant_name'] ?? '') ?>" placeholder="Nom (ex: Taille L / Noir)" class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                                        </div>
                                        <div>
                                            <input type="text" name="variants[<?= $idx ?>][size]" value="<?= htmlspecialchars($v['size'] ?? '') ?>" placeholder="Taille (ex: M, 42)" class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                                        </div>
                                        <div>
                                            <input type="number" name="variants[<?= $idx ?>][stock_quantity]" value="<?= (int)($v['stock_quantity'] ?? 0) ?>" placeholder="Stock" class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="variants[<?= $idx ?>][price_override]" value="<?= htmlspecialchars((string)($v['price_override'] ?? '')) ?>" placeholder="Prix spéc." class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                                            <button type="button" onclick="this.closest('.variant-row').remove()" class="text-red-500 hover:text-red-700 p-1">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Section 5 : Visibilité & Mise en avant -->
                        <div class="space-y-3 pt-2 border-t border-border">
                            <h2 class="text-base font-bold text-on-surface flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary">visibility</span> 5. Visibilité & Publication
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-center gap-2 cursor-pointer bg-surface-container-low p-3 rounded-xl border border-border">
                                    <input type="checkbox" name="is_active" value="1" <?= (!isset($product['is_active']) || $product['is_active']) ? 'checked' : '' ?> class="w-4 h-4 rounded text-primary focus:ring-0">
                                    <div>
                                        <span class="text-sm font-semibold block">Publier sur la boutique</span>
                                        <span class="text-xs text-outline">Visible immédiatement par les visiteurs</span>
                                    </div>
                                </label>

                                <label class="flex items-center gap-2 cursor-pointer bg-surface-container-low p-3 rounded-xl border border-border">
                                    <input type="checkbox" name="is_featured" value="1" <?= (!empty($product['is_featured'])) ? 'checked' : '' ?> class="w-4 h-4 rounded text-primary focus:ring-0">
                                    <div>
                                        <span class="text-sm font-semibold block">Mettre en vedette (Accueil)</span>
                                        <span class="text-xs text-outline">Apparaît dans la sélection phare du thème</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-border flex justify-end gap-3">
                            <a href="/admin/produits" class="px-5 py-2.5 border border-border rounded-xl text-sm font-medium hover:bg-surface-container-low transition-all">Annuler</a>
                            <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-sm">
                                <?= $isEdit ? 'Enregistrer les modifications' : 'Enregistrer et Publier' ?>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script>
        let variantIndex = 100;
        function addVariantRow() {
            variantIndex++;
            const container = document.getElementById('variants-container');
            const row = document.createElement('div');
            row.className = 'variant-row grid grid-cols-1 sm:grid-cols-5 gap-2 bg-surface-container-low p-3 rounded-xl border border-border items-center';
            row.innerHTML = `
                <div class="sm:col-span-2">
                    <input type="text" name="variants[${variantIndex}][variant_name]" placeholder="Nom (ex: Taille XL / Rouge)" class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                </div>
                <div>
                    <input type="text" name="variants[${variantIndex}][size]" placeholder="Taille" class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                </div>
                <div>
                    <input type="number" name="variants[${variantIndex}][stock_quantity]" value="10" placeholder="Stock" class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                </div>
                <div class="flex items-center gap-2">
                    <input type="number" name="variants[${variantIndex}][price_override]" placeholder="Prix spéc." class="w-full bg-white border border-border rounded-lg px-2.5 py-1.5 text-xs">
                    <button type="button" onclick="this.closest('.variant-row').remove()" class="text-red-500 hover:text-red-700 p-1">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            `;
            container.appendChild(row);
        }

        <?php if ($isEdit): ?>
        function submitMediaAction(mediaId, action) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/produits/<?= (int)$product['id'] ?>/media/${mediaId}/${action}`;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_csrf_token';
            csrfInput.value = '<?= htmlspecialchars($csrf_token ?? '') ?>';
            form.appendChild(csrfInput);

            document.body.appendChild(form);
            form.submit();
        }
        <?php endif; ?>
    </script>
</body>
</html>
