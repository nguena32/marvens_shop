<?php
/**
 * Vue d'Administration : Paramètres → Apparence & Personnalisation des Couleurs
 * Exigence complète Module 3 (Sections 3.1, 3.2, 3.3, 3.4)
 */
$active_tab = 'appearance';
$targetThemeId = $target_theme_id ?? 'fashion';
$activeThemeId = $active_theme_id ?? 'fashion';
$targetTheme = $target_theme ?? null;
$cust = $customization ?? [];
$defaultCust = $default_customization ?? [];
$themes = $all_themes ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Paramètres d'Apparence & Couleurs — Marvens Shop</title>
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
        }
        ::-webkit-scrollbar { display:none; }
        .color-preview-box {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid rgba(0,0,0,0.15);
            display: inline-block;
        }
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
            <div class="max-w-7xl mx-auto flex flex-col gap-space-lg">

                <!-- Feedback notification -->
                <?php if (!empty($feedback)): ?>
                    <div class="p-4 rounded-xl text-xs font-semibold flex items-center justify-between <?= ($feedback['type'] ?? '') === 'error' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' ?>">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]"><?= ($feedback['type'] ?? '') === 'error' ? 'error' : 'check_circle' ?></span>
                            <span><?= htmlspecialchars($feedback['message'] ?? '') ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- En-tête : Paramètres d'Apparence & Sélecteur de Thème -->
                <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-2xl">format_paint</span>
                            <h1 class="text-2xl font-bold text-on-surface">Personnalisation des Couleurs & Apparence</h1>
                        </div>
                        <p class="text-xs text-outline mt-1 max-w-2xl">
                            Ajustez l'identité visuelle de votre boutique : palette générale, styles des boutons et cartes produits. Chaque thème conserve sa propre palette par défaut et ses personnalisations avec prévisualisation immédiate.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-xs font-semibold text-outline">Thème à éditer :</label>
                        <select onchange="window.location.href='/admin/parametres/apparence?theme=' + this.value" class="bg-surface-container border border-border text-xs rounded-xl px-3 py-2 font-bold focus:outline-none focus:ring-2 focus:ring-primary">
                            <?php foreach ($themes as $t): ?>
                                <option value="<?= htmlspecialchars($t->getId()) ?>" <?= $t->getId() === $targetThemeId ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t->getName()) ?> <?= $t->getId() === $activeThemeId ? '(ACTIF)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <a href="/theme/preview/<?= htmlspecialchars($targetThemeId) ?>" target="_blank" class="px-3 py-2 rounded-xl border border-border bg-surface text-xs font-semibold hover:bg-surface-container flex items-center gap-1.5 transition">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                            Voir en direct
                        </a>
                    </div>
                </div>

                <!-- FORMULAIRE DE PERSONNALISATION ET PRÉVISUALISATION TEMPS RÉEL -->
                <form method="POST" action="/admin/parametres/apparence" id="appearanceForm" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="theme_id" value="<?= htmlspecialchars($targetThemeId) ?>">

                    <!-- Colonne Gauche : Paramètres des Couleurs et Composants (7 colonnes) -->
                    <div class="lg:col-span-7 flex flex-col gap-6">

                        <!-- 3.1 Palette Générale -->
                        <div class="bg-surface p-6 rounded-2xl border border-border shadow-sm space-y-4">
                            <div class="flex items-center justify-between border-b border-border pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-xl">palette</span>
                                    <h2 class="text-base font-bold text-on-surface">3.1 Palette Générale</h2>
                                </div>
                                <span class="text-[11px] bg-surface-container px-2 py-0.5 rounded text-outline font-mono">16 Teintes</span>
                            </div>

                            <p class="text-xs text-outline">
                                Lorsque vous modifiez la <strong>couleur principale</strong>, les boutons, liens et accents associés s'ajustent automatiquement selon les règles du thème.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                                <!-- Couleur Principale -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur principale</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_primary_color"><?= htmlspecialchars($cust['primary_color']) ?></span>
                                    </div>
                                    <input type="color" name="primary_color" id="input_primary_color" value="<?= htmlspecialchars($cust['primary_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('primary_color', this.value, true)">
                                </div>

                                <!-- Couleur Secondaire -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur secondaire</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_secondary_color"><?= htmlspecialchars($cust['secondary_color']) ?></span>
                                    </div>
                                    <input type="color" name="secondary_color" id="input_secondary_color" value="<?= htmlspecialchars($cust['secondary_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('secondary_color', this.value)">
                                </div>

                                <!-- Couleur Accent -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur d'accentuation</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_accent_color"><?= htmlspecialchars($cust['accent_color']) ?></span>
                                    </div>
                                    <input type="color" name="accent_color" id="input_accent_color" value="<?= htmlspecialchars($cust['accent_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('accent_color', this.value)">
                                </div>

                                <!-- Couleur de fond principale -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Fond principal</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_bg_primary"><?= htmlspecialchars($cust['bg_primary']) ?></span>
                                    </div>
                                    <input type="color" name="bg_primary" id="input_bg_primary" value="<?= htmlspecialchars($cust['bg_primary']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('bg_primary', this.value)">
                                </div>

                                <!-- Couleur de fond secondaire -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Fond secondaire</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_bg_secondary"><?= htmlspecialchars($cust['bg_secondary']) ?></span>
                                    </div>
                                    <input type="color" name="bg_secondary" id="input_bg_secondary" value="<?= htmlspecialchars($cust['bg_secondary']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('bg_secondary', this.value)">
                                </div>

                                <!-- Couleur des surfaces -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des surfaces</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_surface_color"><?= htmlspecialchars($cust['surface_color']) ?></span>
                                    </div>
                                    <input type="color" name="surface_color" id="input_surface_color" value="<?= htmlspecialchars($cust['surface_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('surface_color', this.value)">
                                </div>

                                <!-- Couleur des bordures -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des bordures</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_border_color"><?= htmlspecialchars($cust['border_color']) ?></span>
                                    </div>
                                    <input type="color" name="border_color" id="input_border_color" value="<?= htmlspecialchars($cust['border_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('border_color', this.value)">
                                </div>

                                <!-- Couleur des textes -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des textes</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_text_color"><?= htmlspecialchars($cust['text_color']) ?></span>
                                    </div>
                                    <input type="color" name="text_color" id="input_text_color" value="<?= htmlspecialchars($cust['text_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('text_color', this.value)">
                                </div>

                                <!-- Couleur des titres -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des titres</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_title_color"><?= htmlspecialchars($cust['title_color']) ?></span>
                                    </div>
                                    <input type="color" name="title_color" id="input_title_color" value="<?= htmlspecialchars($cust['title_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('title_color', this.value)">
                                </div>

                                <!-- Couleur des liens -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des liens</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_link_color"><?= htmlspecialchars($cust['link_color']) ?></span>
                                    </div>
                                    <input type="color" name="link_color" id="input_link_color" value="<?= htmlspecialchars($cust['link_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('link_color', this.value)">
                                </div>

                                <!-- Couleur des prix -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des prix</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_price_color"><?= htmlspecialchars($cust['price_color']) ?></span>
                                    </div>
                                    <input type="color" name="price_color" id="input_price_color" value="<?= htmlspecialchars($cust['price_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('price_color', this.value)">
                                </div>

                                <!-- Couleur des promotions -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des promotions</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_promo_color"><?= htmlspecialchars($cust['promo_color']) ?></span>
                                    </div>
                                    <input type="color" name="promo_color" id="input_promo_color" value="<?= htmlspecialchars($cust['promo_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('promo_color', this.value)">
                                </div>

                                <!-- Couleur des badges -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur des badges</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_badge_color"><?= htmlspecialchars($cust['badge_color']) ?></span>
                                    </div>
                                    <input type="color" name="badge_color" id="input_badge_color" value="<?= htmlspecialchars($cust['badge_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('badge_color', this.value)">
                                </div>

                                <!-- Couleur de navigation -->
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Éléments de navigation</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_nav_color"><?= htmlspecialchars($cust['nav_color']) ?></span>
                                    </div>
                                    <input type="color" name="nav_color" id="input_nav_color" value="<?= htmlspecialchars($cust['nav_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('nav_color', this.value)">
                                </div>
                            </div>
                        </div>

                        <!-- 3.2 Personnalisation des Boutons -->
                        <div class="bg-surface p-6 rounded-2xl border border-border shadow-sm space-y-4">
                            <div class="flex items-center justify-between border-b border-border pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-xl">smart_button</span>
                                    <h2 class="text-base font-bold text-on-surface">3.2 Personnalisation des Boutons</h2>
                                </div>
                                <span class="text-[11px] bg-surface-container px-2 py-0.5 rounded text-outline">Cohérence globale</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Fond bouton principal</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_btn_primary_bg"><?= htmlspecialchars($cust['btn_primary_bg']) ?></span>
                                    </div>
                                    <input type="color" name="btn_primary_bg" id="input_btn_primary_bg" value="<?= htmlspecialchars($cust['btn_primary_bg']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('btn_primary_bg', this.value)">
                                </div>

                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Fond bouton secondaire</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_btn_secondary_bg"><?= htmlspecialchars($cust['btn_secondary_bg']) ?></span>
                                    </div>
                                    <input type="color" name="btn_secondary_bg" id="input_btn_secondary_bg" value="<?= htmlspecialchars($cust['btn_secondary_bg']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('btn_secondary_bg', this.value)">
                                </div>

                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Texte des boutons</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_btn_text_color"><?= htmlspecialchars($cust['btn_text_color']) ?></span>
                                    </div>
                                    <input type="color" name="btn_text_color" id="input_btn_text_color" value="<?= htmlspecialchars($cust['btn_text_color']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('btn_text_color', this.value)">
                                </div>

                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Couleur au survol (Hover)</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_btn_hover_bg"><?= htmlspecialchars($cust['btn_hover_bg']) ?></span>
                                    </div>
                                    <input type="color" name="btn_hover_bg" id="input_btn_hover_bg" value="<?= htmlspecialchars($cust['btn_hover_bg']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('btn_hover_bg', this.value)">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1">Arrondi des boutons</label>
                                    <select name="btn_radius" id="select_btn_radius" onchange="updateLiveRadius('btn', this.value)" class="w-full bg-surface-container border border-border text-xs rounded-xl p-2.5 font-medium">
                                        <option value="rounded-none" <?= $cust['btn_radius'] === 'rounded-none' ? 'selected' : '' ?>>Rectangulaire strict (rounded-none)</option>
                                        <option value="rounded-md" <?= $cust['btn_radius'] === 'rounded-md' ? 'selected' : '' ?>>Légèrement adouci (rounded-md)</option>
                                        <option value="rounded-xl" <?= $cust['btn_radius'] === 'rounded-xl' ? 'selected' : '' ?>>Arrondi moderne (rounded-xl)</option>
                                        <option value="rounded-2xl" <?= $cust['btn_radius'] === 'rounded-2xl' ? 'selected' : '' ?>>Très arrondi (rounded-2xl)</option>
                                        <option value="rounded-full" <?= $cust['btn_radius'] === 'rounded-full' ? 'selected' : '' ?>>Pilule / Cercle (rounded-full)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1">Style de remplissage</label>
                                    <select name="btn_style" id="select_btn_style" class="w-full bg-surface-container border border-border text-xs rounded-xl p-2.5 font-medium">
                                        <option value="filled" <?= $cust['btn_style'] === 'filled' ? 'selected' : '' ?>>Plein (Filled)</option>
                                        <option value="outline" <?= $cust['btn_style'] === 'outline' ? 'selected' : '' ?>>Contour (Outline)</option>
                                        <option value="soft" <?= $cust['btn_style'] === 'soft' ? 'selected' : '' ?>>Doux (Soft tint)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 3.3 Personnalisation des Cartes Produits -->
                        <div class="bg-surface p-6 rounded-2xl border border-border shadow-sm space-y-4">
                            <div class="flex items-center justify-between border-b border-border pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-xl">view_agenda</span>
                                    <h2 class="text-base font-bold text-on-surface">3.3 Personnalisation des Cartes Produits</h2>
                                </div>
                                <span class="text-[11px] bg-surface-container px-2 py-0.5 rounded text-outline">Disposition & Rendu</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Fond des cartes</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_card_bg"><?= htmlspecialchars($cust['card_bg']) ?></span>
                                    </div>
                                    <input type="color" name="card_bg" id="input_card_bg" value="<?= htmlspecialchars($cust['card_bg']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('card_bg', this.value)">
                                </div>

                                <div class="flex items-center justify-between p-2.5 rounded-xl border border-border bg-surface-container-low">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface">Bordure des cartes</label>
                                        <span class="text-[11px] text-outline font-mono" id="label_card_border"><?= htmlspecialchars($cust['card_border']) ?></span>
                                    </div>
                                    <input type="color" name="card_border" id="input_card_border" value="<?= htmlspecialchars($cust['card_border']) ?>" class="w-9 h-9 cursor-pointer rounded-lg border-0 bg-transparent" oninput="updateLiveColor('card_border', this.value)">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1">Arrondi des cartes</label>
                                    <select name="card_radius" id="select_card_radius" onchange="updateLiveRadius('card', this.value)" class="w-full bg-surface-container border border-border text-xs rounded-xl p-2.5 font-medium">
                                        <option value="rounded-none" <?= $cust['card_radius'] === 'rounded-none' ? 'selected' : '' ?>>Angles droits (rounded-none - Neo-brutalist)</option>
                                        <option value="rounded-md" <?= $cust['card_radius'] === 'rounded-md' ? 'selected' : '' ?>>Adouci léger (rounded-md)</option>
                                        <option value="rounded-xl" <?= $cust['card_radius'] === 'rounded-xl' ? 'selected' : '' ?>>Arrondi élégant (rounded-xl)</option>
                                        <option value="rounded-2xl" <?= $cust['card_radius'] === 'rounded-2xl' ? 'selected' : '' ?>>Grand arrondi (rounded-2xl)</option>
                                        <option value="rounded-3xl" <?= $cust['card_radius'] === 'rounded-3xl' ? 'selected' : '' ?>>Organique doux (rounded-3xl - Bello)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1">Espacement intérieur (Padding)</label>
                                    <select name="card_spacing" id="select_card_spacing" class="w-full bg-surface-container border border-border text-xs rounded-xl p-2.5 font-medium">
                                        <option value="compact" <?= $cust['card_spacing'] === 'compact' ? 'selected' : '' ?>>Compact (Dense)</option>
                                        <option value="normal" <?= $cust['card_spacing'] === 'normal' ? 'selected' : '' ?>>Normal (Standard)</option>
                                        <option value="spacious" <?= $cust['card_spacing'] === 'spacious' ? 'selected' : '' ?>>Aéré (Spacious)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1">Présentation du prix</label>
                                    <select name="card_price_style" class="w-full bg-surface-container border border-border text-xs rounded-xl p-2.5 font-medium">
                                        <option value="standard" <?= $cust['card_price_style'] === 'standard' ? 'selected' : '' ?>>Standard fluide</option>
                                        <option value="bold" <?= $cust['card_price_style'] === 'bold' ? 'selected' : '' ?>>Gras percutant (Bold highlight)</option>
                                        <option value="badge" <?= $cust['card_price_style'] === 'badge' ? 'selected' : '' ?>>Encadré dans un badge de couleur</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1">Présentation des promotions</label>
                                    <select name="card_promo_style" class="w-full bg-surface-container border border-border text-xs rounded-xl p-2.5 font-medium">
                                        <option value="badge" <?= $cust['card_promo_style'] === 'badge' ? 'selected' : '' ?>>Badge coin supérieur</option>
                                        <option value="ribbon" <?= $cust['card_promo_style'] === 'ribbon' ? 'selected' : '' ?>>Ruban promo horizontal</option>
                                        <option value="pill" <?= $cust['card_promo_style'] === 'pill' ? 'selected' : '' ?>>Pastille avec pourcentage</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'Action & Soumission -->
                        <div class="flex items-center justify-between pt-2">
                            <button type="submit" class="px-6 py-3 rounded-xl bg-primary text-on-primary font-bold text-sm hover:bg-surface-container-high hover:text-on-surface transition shadow-md flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Enregistrer les modifications
                            </button>

                            <button type="button" onclick="document.getElementById('resetForm').submit();" class="px-4 py-2.5 rounded-xl border border-border bg-surface text-xs font-semibold text-error hover:bg-error-container hover:text-on-error-container transition flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                Réinitialiser aux couleurs du thème
                            </button>
                        </div>

                    </div>

                    <!-- Colonne Droite : Prévisualisation Interactive Live (5 colonnes) -->
                    <div class="lg:col-span-5">
                        <div class="sticky top-20 flex flex-col gap-4">
                            <div class="bg-surface p-5 rounded-2xl border border-border shadow-sm">
                                <div class="flex items-center justify-between mb-4 border-b border-border pb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-lg">preview</span>
                                        <h3 class="text-sm font-bold text-on-surface">Prévisualisation interactive en direct</h3>
                                    </div>
                                    <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">Temps réel</span>
                                </div>

                                <!-- Cadre de simulation de la vitrine -->
                                <div id="previewCanvas" class="p-4 rounded-2xl transition-all border" style="background-color: <?= htmlspecialchars($cust['bg_primary']) ?>; border-color: <?= htmlspecialchars($cust['border_color']) ?>;">
                                    
                                    <!-- Mini Header Navigation -->
                                    <div id="previewHeader" class="p-3 rounded-xl mb-4 flex items-center justify-between border" style="background-color: <?= htmlspecialchars($cust['surface_color']) ?>; border-color: <?= htmlspecialchars($cust['border_color']) ?>; color: <?= htmlspecialchars($cust['nav_color']) ?>;">
                                        <div class="flex items-center gap-2">
                                            <div id="previewLogo" class="w-6 h-6 rounded flex items-center justify-center font-bold text-xs" style="background-color: <?= htmlspecialchars($cust['primary_color']) ?>; color: #ffffff;">M</div>
                                            <span class="font-bold text-xs">Marvens Shop</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs">
                                            <span id="previewLink" class="font-semibold text-[11px]" style="color: <?= htmlspecialchars($cust['link_color']) ?>;">Accueil</span>
                                            <span id="previewBadge" class="text-[10px] font-bold px-2 py-0.5 rounded-full" style="background-color: <?= htmlspecialchars($cust['badge_color']) ?>; color: #ffffff;">Nouveau</span>
                                        </div>
                                    </div>

                                    <!-- Simulation d'une Carte Produit (3.3) -->
                                    <div id="previewCard" class="card-theme overflow-hidden border transition-all" style="background-color: <?= htmlspecialchars($cust['card_bg']) ?>; border-color: <?= htmlspecialchars($cust['card_border']) ?>; border-radius: <?= match($cust['card_radius'] ?? 'rounded-2xl') { 'rounded-none' => '0px', 'rounded-md' => '6px', 'rounded-xl' => '12px', 'rounded-2xl' => '16px', 'rounded-3xl' => '24px', default => '16px'} ?>;">
                                        <div class="aspect-[16/10] relative flex items-center justify-center" style="background-color: <?= htmlspecialchars($cust['bg_secondary']) ?>;">
                                            <span class="material-symbols-outlined text-4xl text-outline/50">shopping_bag</span>
                                            <span id="previewPromo" class="absolute top-2 left-2 text-[10px] font-bold px-2 py-0.5 rounded" style="background-color: <?= htmlspecialchars($cust['promo_color']) ?>; color: #ffffff;">
                                                PROMO -20%
                                            </span>
                                        </div>

                                        <div class="p-4 space-y-3">
                                            <div>
                                                <span class="text-[10px] uppercase font-bold tracking-wider" style="color: <?= htmlspecialchars($cust['secondary_color']) ?>;">Prêt-à-porter</span>
                                                <h4 id="previewTitle" class="font-bold text-sm" style="color: <?= htmlspecialchars($cust['title_color']) ?>;">Robe Élégante d'Été</h4>
                                                <p id="previewText" class="text-xs mt-0.5 leading-relaxed" style="color: <?= htmlspecialchars($cust['text_color']) ?>;">Tissu soyeux haute qualité, coupe fluide pour un confort absolu.</p>
                                            </div>

                                            <div class="flex items-baseline gap-2">
                                                <span id="previewPrice" class="font-bold text-base" style="color: <?= htmlspecialchars($cust['price_color']) ?>;">20 000 FCFA</span>
                                                <span class="text-xs line-through text-outline">25 000 FCFA</span>
                                            </div>

                                            <!-- Simulation des Boutons (3.2) -->
                                            <div class="pt-1 flex flex-col gap-2">
                                                <button type="button" id="previewBtnPrimary" class="w-full py-2.5 px-3 text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-sm" style="background-color: <?= htmlspecialchars($cust['btn_primary_bg']) ?>; color: <?= htmlspecialchars($cust['btn_text_color']) ?>; border-radius: <?= match($cust['btn_radius'] ?? 'rounded-xl') { 'rounded-none' => '0px', 'rounded-md' => '6px', 'rounded-xl' => '12px', 'rounded-2xl' => '16px', 'rounded-full' => '9999px', default => '12px'} ?>;">
                                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                                    <span>Ajouter au panier</span>
                                                </button>

                                                <button type="button" id="previewBtnSecondary" class="w-full py-2 px-3 text-xs font-semibold transition-all flex items-center justify-center gap-1.5 border" style="background-color: <?= htmlspecialchars($cust['btn_secondary_bg']) ?>; color: <?= htmlspecialchars($cust['btn_text_color']) ?>; border-color: <?= htmlspecialchars($cust['border_color']) ?>; border-radius: <?= match($cust['btn_radius'] ?? 'rounded-xl') { 'rounded-none' => '0px', 'rounded-md' => '6px', 'rounded-xl' => '12px', 'rounded-2xl' => '16px', 'rounded-full' => '9999px', default => '12px'} ?>;">
                                                    <span class="material-symbols-outlined text-[16px]">chat</span>
                                                    <span>Commander sur WhatsApp</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4 pt-3 border-t border-border flex items-center justify-between text-xs text-outline">
                                    <span>Rendu instantané côté client</span>
                                    <a href="/theme/preview/<?= htmlspecialchars($targetThemeId) ?>" target="_blank" class="text-primary font-semibold hover:underline flex items-center gap-1">
                                        Prévisualiser le catalogue complet &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <!-- Formulaire caché de réinitialisation -->
                <form id="resetForm" method="POST" action="/admin/parametres/apparence/reinitialiser" onsubmit="return confirm('Êtes-vous sûr de vouloir réinitialiser la palette du thème <?= htmlspecialchars($targetThemeId) ?> à ses valeurs par défaut ?');">
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    <input type="hidden" name="theme_id" value="<?= htmlspecialchars($targetThemeId) ?>">
                </form>

            </div>
        </main>
    </div>

    <!-- Script JavaScript Vanilla pour la Cascade Automatique et la Prévisualisation Live (Exigence 3.4) -->
    <script>
        function updateLiveColor(key, value, isPrimary = false) {
            // Mettre à jour le label hexadécimal sous le champ
            const lbl = document.getElementById('label_' + key);
            if (lbl) lbl.textContent = value;

            // Règle de cascade automatique (Exigence 3.4) :
            // Si la couleur principale change, les boutons principaux, liens et accents associés suivent automatiquement !
            if (isPrimary) {
                // Bouton principal
                document.getElementById('input_btn_primary_bg').value = value;
                document.getElementById('label_btn_primary_bg').textContent = value;
                document.getElementById('previewBtnPrimary').style.backgroundColor = value;

                // Liens
                document.getElementById('input_link_color').value = value;
                document.getElementById('label_link_color').textContent = value;
                document.getElementById('previewLink').style.color = value;

                // Accents
                document.getElementById('input_accent_color').value = value;
                document.getElementById('label_accent_color').textContent = value;

                // Logo preview & prix
                document.getElementById('previewLogo').style.backgroundColor = value;
                document.getElementById('previewPrice').style.color = value;
                document.getElementById('input_price_color').value = value;
                document.getElementById('label_price_color').textContent = value;
            }

            // Mises à jour des éléments de prévisualisation correspondants
            if (key === 'bg_primary') {
                document.getElementById('previewCanvas').style.backgroundColor = value;
            } else if (key === 'border_color') {
                document.getElementById('previewCanvas').style.borderColor = value;
                document.getElementById('previewHeader').style.borderColor = value;
                document.getElementById('previewCard').style.borderColor = value;
            } else if (key === 'surface_color') {
                document.getElementById('previewHeader').style.backgroundColor = value;
            } else if (key === 'nav_color') {
                document.getElementById('previewHeader').style.color = value;
            } else if (key === 'link_color') {
                document.getElementById('previewLink').style.color = value;
            } else if (key === 'badge_color') {
                document.getElementById('previewBadge').style.backgroundColor = value;
            } else if (key === 'card_bg') {
                document.getElementById('previewCard').style.backgroundColor = value;
            } else if (key === 'card_border') {
                document.getElementById('previewCard').style.borderColor = value;
            } else if (key === 'promo_color') {
                document.getElementById('previewPromo').style.backgroundColor = value;
            } else if (key === 'title_color') {
                document.getElementById('previewTitle').style.color = value;
            } else if (key === 'text_color') {
                document.getElementById('previewText').style.color = value;
            } else if (key === 'price_color') {
                document.getElementById('previewPrice').style.color = value;
            } else if (key === 'btn_primary_bg') {
                document.getElementById('previewBtnPrimary').style.backgroundColor = value;
            } else if (key === 'btn_secondary_bg') {
                document.getElementById('previewBtnSecondary').style.backgroundColor = value;
            } else if (key === 'btn_text_color') {
                document.getElementById('previewBtnPrimary').style.color = value;
                document.getElementById('previewBtnSecondary').style.color = value;
            }
        }

        function updateLiveRadius(target, radiusClass) {
            const radiusMap = {
                'rounded-none': '0px',
                'rounded-md': '6px',
                'rounded-lg': '8px',
                'rounded-xl': '12px',
                'rounded-2xl': '16px',
                'rounded-3xl': '24px',
                'rounded-full': '9999px'
            };
            const px = radiusMap[radiusClass] || '12px';

            if (target === 'btn') {
                document.getElementById('previewBtnPrimary').style.borderRadius = px;
                document.getElementById('previewBtnSecondary').style.borderRadius = px;
            } else if (target === 'card') {
                document.getElementById('previewCard').style.borderRadius = px;
            }
        }
    </script>
</body>
</html>
