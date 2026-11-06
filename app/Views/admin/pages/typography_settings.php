<?php
/**
 * Vue d'Administration : Paramètres → Personnalisation des Polices d'Écriture (Typographie)
 * Exigence complète Module 4 (Sections 4.1, 4.2, 4.3)
 */
$active_tab = 'typography';
$targetThemeId = $target_theme_id ?? 'fashion';
$activeThemeId = $active_theme_id ?? 'fashion';
$targetTheme = $target_theme ?? null;
$typo = $typography ?? [];
$defaultTypo = $default_typography ?? [];
$fontLibrary = $font_library ?? [];
$themes = $all_themes ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Personnalisation des Polices d'Écriture — Marvens Shop</title>
    <style>
        @layer base {
            html, body { margin:0; padding:0; }
            body { overscroll-behavior:none; }
        }
        ::-webkit-scrollbar { display:none; }
        .font-sample-card {
            transition: all 0.2s ease;
        }
        .font-sample-card:hover {
            border-color: #000000;
        }
        .device-preview-container {
            transition: max-width 0.3s ease, border-radius 0.3s ease;
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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800&family=DM+Sans:wght@400;500;700&family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@400;600;700;800&family=Outfit:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
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

                <!-- En-tête : Paramètres de Typographie & Sélecteur de Thème -->
                <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-2xl">match_case</span>
                            <h1 class="text-2xl font-bold text-on-surface">Personnalisation des Polices d'Écriture</h1>
                        </div>
                        <p class="text-xs text-outline mt-1 max-w-2xl">
                            Module 4 : Configurez la typographie globale, sélectionnez les polices dans la bibliothèque, prévisualisez en direct sur ordinateur et smartphone, puis appliquez automatiquement à tous les éléments de la boutique.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-xs font-semibold text-outline">Thème à éditer :</label>
                        <select onchange="window.location.href='/admin/parametres/typographie?theme=' + this.value" class="bg-surface-container border border-border text-xs rounded-xl px-3 py-2 font-bold focus:outline-none focus:ring-2 focus:ring-primary">
                            <?php foreach ($themes as $id => $th): ?>
                                <option value="<?= htmlspecialchars($id) ?>" <?= $id === $targetThemeId ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($th->getName()) ?> <?= $id === $activeThemeId ? '(Actif)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <a href="/theme/preview/<?= htmlspecialchars($targetThemeId) ?>" target="_blank" class="px-3 py-2 rounded-xl border border-border bg-surface text-xs font-semibold hover:bg-surface-container flex items-center gap-1.5 transition">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                            <span>Boutique</span>
                        </a>
                    </div>
                </div>

                <!-- Grille principale : Formulaire de Typographie & Prévisualisation Live Responsive -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                    <!-- Colonne gauche : Formulaire de Typographie (Sections 4.1 & 4.2) -->
                    <div class="lg:col-span-7 flex flex-col gap-6">

                        <form method="POST" action="/admin/parametres/typographie" id="formTypography">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <input type="hidden" name="theme_id" value="<?= htmlspecialchars($targetThemeId) ?>">

                            <!-- 4.1 Typographie Globale -->
                            <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm mb-6">
                                <div class="flex items-center justify-between pb-4 mb-4 border-b border-border">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-xl">text_fields</span>
                                        <h2 class="text-base font-bold text-on-surface">4.1 Typographie Globale</h2>
                                    </div>
                                    <span class="text-[11px] bg-surface-container px-2 py-0.5 rounded text-outline font-mono">5 Éléments • Tailles • Graisses</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Police des Titres -->
                                    <div class="p-3 bg-surface-container-low rounded-xl border border-border">
                                        <label class="block text-xs font-bold text-on-surface mb-1">Police des titres</label>
                                        <select name="font_titles" id="font_titles" onchange="updateLiveTypography()" class="w-full bg-surface border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold focus:ring-2 focus:ring-primary">
                                            <?php foreach ($fontLibrary as $name => $f): ?>
                                                <option value="<?= htmlspecialchars($name) ?>" <?= ($typo['font_titles'] ?? '') === $name ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($f['category']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Police des Sous-titres -->
                                    <div class="p-3 bg-surface-container-low rounded-xl border border-border">
                                        <label class="block text-xs font-bold text-on-surface mb-1">Police des sous-titres</label>
                                        <select name="font_subtitles" id="font_subtitles" onchange="updateLiveTypography()" class="w-full bg-surface border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold focus:ring-2 focus:ring-primary">
                                            <?php foreach ($fontLibrary as $name => $f): ?>
                                                <option value="<?= htmlspecialchars($name) ?>" <?= ($typo['font_subtitles'] ?? '') === $name ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($f['category']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Police du corps de texte -->
                                    <div class="p-3 bg-surface-container-low rounded-xl border border-border">
                                        <label class="block text-xs font-bold text-on-surface mb-1">Police du corps de texte</label>
                                        <select name="font_body" id="font_body" onchange="updateLiveTypography()" class="w-full bg-surface border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold focus:ring-2 focus:ring-primary">
                                            <?php foreach ($fontLibrary as $name => $f): ?>
                                                <option value="<?= htmlspecialchars($name) ?>" <?= ($typo['font_body'] ?? '') === $name ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($f['category']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Police des boutons -->
                                    <div class="p-3 bg-surface-container-low rounded-xl border border-border">
                                        <label class="block text-xs font-bold text-on-surface mb-1">Police des boutons</label>
                                        <select name="font_buttons" id="font_buttons" onchange="updateLiveTypography()" class="w-full bg-surface border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold focus:ring-2 focus:ring-primary">
                                            <?php foreach ($fontLibrary as $name => $f): ?>
                                                <option value="<?= htmlspecialchars($name) ?>" <?= ($typo['font_buttons'] ?? '') === $name ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($f['category']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Police des éléments d'accentuation (Prix, Badges, Promos) -->
                                    <div class="p-3 bg-surface-container-low rounded-xl border border-border md:col-span-2">
                                        <label class="block text-xs font-bold text-on-surface mb-1">Police des éléments d'accentuation (Prix & Badges)</label>
                                        <select name="font_accents" id="font_accents" onchange="updateLiveTypography()" class="w-full bg-surface border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold focus:ring-2 focus:ring-primary">
                                            <?php foreach ($fontLibrary as $name => $f): ?>
                                                <option value="<?= htmlspecialchars($name) ?>" <?= ($typo['font_accents'] ?? '') === $name ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($f['category']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Tailles & Échelles -->
                                <div class="mt-4 pt-4 border-t border-border grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-bold text-on-surface mb-1">Taille des titres</label>
                                        <select name="size_titles" id="size_titles" onchange="updateLiveTypography()" class="w-full bg-surface-container border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold">
                                            <option value="scale-compact" <?= ($typo['size_titles'] ?? '') === 'scale-compact' ? 'selected' : '' ?>>Compact (-10%)</option>
                                            <option value="scale-normal" <?= ($typo['size_titles'] ?? '') === 'scale-normal' ? 'selected' : '' ?>>Normal (Standard)</option>
                                            <option value="scale-large" <?= ($typo['size_titles'] ?? '') === 'scale-large' ? 'selected' : '' ?>>Généreux (+15%)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-on-surface mb-1">Taille des sous-titres</label>
                                        <select name="size_subtitles" id="size_subtitles" onchange="updateLiveTypography()" class="w-full bg-surface-container border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold">
                                            <option value="scale-compact" <?= ($typo['size_subtitles'] ?? '') === 'scale-compact' ? 'selected' : '' ?>>Compact (-10%)</option>
                                            <option value="scale-normal" <?= ($typo['size_subtitles'] ?? '') === 'scale-normal' ? 'selected' : '' ?>>Normal (Standard)</option>
                                            <option value="scale-large" <?= ($typo['size_subtitles'] ?? '') === 'scale-large' ? 'selected' : '' ?>>Généreux (+15%)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-on-surface mb-1">Taille du texte</label>
                                        <select name="size_body" id="size_body" onchange="updateLiveTypography()" class="w-full bg-surface-container border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold">
                                            <option value="scale-compact" <?= ($typo['size_body'] ?? '') === 'scale-compact' ? 'selected' : '' ?>>Compact (-10%)</option>
                                            <option value="scale-normal" <?= ($typo['size_body'] ?? '') === 'scale-normal' ? 'selected' : '' ?>>Normal (Standard)</option>
                                            <option value="scale-large" <?= ($typo['size_body'] ?? '') === 'scale-large' ? 'selected' : '' ?>>Généreux (+10%)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Épaisseurs & Styles -->
                                <div class="mt-4 pt-4 border-t border-border grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-bold text-on-surface mb-1">Épaisseur des titres</label>
                                        <select name="weight_titles" id="weight_titles" onchange="updateLiveTypography()" class="w-full bg-surface-container border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold">
                                            <option value="font-normal" <?= ($typo['weight_titles'] ?? '') === 'font-normal' ? 'selected' : '' ?>>Normal (400)</option>
                                            <option value="font-medium" <?= ($typo['weight_titles'] ?? '') === 'font-medium' ? 'selected' : '' ?>>Médium (500)</option>
                                            <option value="font-semibold" <?= ($typo['weight_titles'] ?? '') === 'font-semibold' ? 'selected' : '' ?>>Semi-Gras (600)</option>
                                            <option value="font-bold" <?= ($typo['weight_titles'] ?? '') === 'font-bold' ? 'selected' : '' ?>>Gras (700)</option>
                                            <option value="font-black" <?= ($typo['weight_titles'] ?? '') === 'font-black' ? 'selected' : '' ?>>Ultra-Gras (900)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-on-surface mb-1">Épaisseur des textes</label>
                                        <select name="weight_body" id="weight_body" onchange="updateLiveTypography()" class="w-full bg-surface-container border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold">
                                            <option value="font-normal" <?= ($typo['weight_body'] ?? '') === 'font-normal' ? 'selected' : '' ?>>Normal (400)</option>
                                            <option value="font-medium" <?= ($typo['weight_body'] ?? '') === 'font-medium' ? 'selected' : '' ?>>Médium (500)</option>
                                            <option value="font-semibold" <?= ($typo['weight_body'] ?? '') === 'font-semibold' ? 'selected' : '' ?>>Semi-Gras (600)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-on-surface mb-1">Style des titres</label>
                                        <select name="style_titles" id="style_titles" onchange="updateLiveTypography()" class="w-full bg-surface-container border border-border text-xs rounded-lg px-2.5 py-1.5 font-semibold">
                                            <option value="normal" <?= ($typo['style_titles'] ?? '') === 'normal' ? 'selected' : '' ?>>Normal</option>
                                            <option value="uppercase" <?= ($typo['style_titles'] ?? '') === 'uppercase' ? 'selected' : '' ?>>Majuscules (UPPERCASE)</option>
                                            <option value="italic" <?= ($typo['style_titles'] ?? '') === 'italic' ? 'selected' : '' ?>>Italique (Oblique)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- 4.2 Bibliothèque de polices : Consultation & Sélection rapide -->
                            <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm mb-6">
                                <div class="flex items-center justify-between pb-4 mb-4 border-b border-border">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-xl">library_books</span>
                                        <h2 class="text-base font-bold text-on-surface">4.2 Bibliothèque de Polices</h2>
                                    </div>
                                    <span class="text-[11px] bg-surface-container px-2 py-0.5 rounded text-outline font-mono"><?= count($fontLibrary) ?> Polices Web Sécurisées</span>
                                </div>

                                <p class="text-xs text-outline mb-3">
                                    Cliquez sur une police ci-dessous pour l'appliquer immédiatement comme <strong>Police des titres</strong> ou <strong>Police de texte</strong> :
                                </p>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                                    <?php foreach ($fontLibrary as $name => $f): ?>
                                        <div class="font-sample-card p-3 rounded-xl border border-border bg-surface-container-low hover:bg-surface flex flex-col justify-between gap-2 cursor-pointer" onclick="quickApplyFont('<?= htmlspecialchars($name) ?>')">
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs font-bold text-on-surface"><?= htmlspecialchars($name) ?></span>
                                                <span class="text-[10px] text-outline bg-surface px-1.5 py-0.5 rounded border border-border"><?= htmlspecialchars($f['category']) ?></span>
                                            </div>
                                            <div class="text-sm font-medium text-on-surface py-1" style="font-family: <?= htmlspecialchars($f['family']) ?>;">
                                                <?= htmlspecialchars($f['preview_text']) ?>
                                            </div>
                                            <div class="flex items-center justify-between text-[11px] text-primary font-semibold">
                                                <span><?= htmlspecialchars($f['description']) ?></span>
                                                <span class="material-symbols-outlined text-[16px]">touch_app</span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Boutons d'Action : Enregistrer & Réinitialiser -->
                            <div class="flex items-center justify-between bg-surface p-4 rounded-2xl border border-border shadow-sm">
                                <button type="submit" class="px-6 py-2.5 bg-primary text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition flex items-center gap-2 shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">save</span>
                                    <span>Enregistrer les préférences typographiques</span>
                                </button>
                        </form>

                                <!-- Formulaire de réinitialisation distinct pour isolation stricte -->
                                <form method="POST" action="/admin/parametres/typographie/reinitialiser" onsubmit="return confirm('Confirmez-vous la réinitialisation des polices du thème <?= htmlspecialchars($targetThemeId) ?> aux valeurs par défaut d\'origine ?');">
                                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                    <input type="hidden" name="theme_id" value="<?= htmlspecialchars($targetThemeId) ?>">
                                    <button type="submit" class="px-4 py-2.5 bg-surface-container hover:bg-red-50 text-error hover:border-red-200 border border-border rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                        <span>Réinitialiser les polices du thème</span>
                                    </button>
                                </form>
                            </div>
                    </div>

                    <!-- Colonne droite : Prévisualisation Live Responsive (Mobile & Ordinateur) (Exigence 4.2 & 4.3) -->
                    <div class="lg:col-span-5 sticky top-20 flex flex-col gap-4">
                        <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                            <div class="flex items-center justify-between pb-3 border-b border-border">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-xl">devices</span>
                                    <h3 class="text-xs font-bold text-on-surface uppercase tracking-wider">Aperçu en temps réel</h3>
                                </div>
                                <div class="flex items-center gap-1 bg-surface-container p-1 rounded-lg">
                                    <button type="button" onclick="setPreviewDevice('desktop')" id="btnDeviceDesktop" class="px-2.5 py-1 rounded text-xs font-semibold bg-surface shadow-xs text-on-surface flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">laptop</span>
                                        <span>Bureau</span>
                                    </button>
                                    <button type="button" onclick="setPreviewDevice('mobile')" id="btnDeviceMobile" class="px-2.5 py-1 rounded text-xs font-semibold text-outline hover:text-on-surface flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">smartphone</span>
                                        <span>Mobile</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Canevas de rendu interactif -->
                            <div class="mt-4 flex justify-center bg-surface-container-low p-3 rounded-xl border border-dashed border-border overflow-hidden">
                                <div id="previewContainer" class="device-preview-container w-full bg-white rounded-xl border border-border p-4 shadow-sm flex flex-col gap-4" style="max-width: 100%;">

                                    <!-- En-tête de navigation du mini-site -->
                                    <div class="flex items-center justify-between pb-3 border-b border-border">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded bg-primary text-white flex items-center justify-center font-bold text-xs">M</div>
                                            <span id="previewShopName" class="font-bold text-sm tracking-tight text-on-surface">Marvens Shop</span>
                                        </div>
                                        <div id="previewNavLinks" class="flex items-center gap-3 text-xs font-medium text-outline">
                                            <span>Accueil</span>
                                            <span>Catalogue</span>
                                            <span>WhatsApp</span>
                                        </div>
                                    </div>

                                    <!-- Fiche Produit & Carte (Exigence 4.3 : Titres, Sous-titres, Descriptions, Boutons, Prix) -->
                                    <div class="border border-border rounded-xl p-3 bg-surface flex flex-col gap-3">
                                        <div class="flex items-center justify-between">
                                            <span id="previewBadge" class="bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded">ÉDITION SPÉCIALE</span>
                                            <span id="previewPrice" class="text-sm font-bold text-primary">25 000 FCFA</span>
                                        </div>

                                        <div>
                                            <h4 id="previewTitle" class="text-base font-bold text-on-surface">Robe Soirée Satin Prestige</h4>
                                            <h5 id="previewSubtitle" class="text-xs text-outline mt-0.5">Collection Haute Couture & Glamour</h5>
                                        </div>

                                        <p id="previewDescription" class="text-xs text-on-surface-variant leading-relaxed">
                                            Tissu doux en satin haute densité, finitions soignées à la main. Idéal pour vos cérémonies et soirées d'exception.
                                        </p>

                                        <!-- Éléments de formulaire & Sélecteur -->
                                        <div class="flex items-center gap-2">
                                            <select id="previewSelect" class="w-1/2 bg-surface-container border border-border text-[11px] rounded-lg p-1.5">
                                                <option>Taille M (Disponible)</option>
                                                <option>Taille L (Disponible)</option>
                                            </select>
                                            <button type="button" id="previewBtn" class="w-1/2 py-2 bg-primary text-white text-xs font-semibold rounded-lg flex items-center justify-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">shopping_bag</span>
                                                <span>Commander</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Réassurance & Contact WhatsApp -->
                                    <div class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-lg flex items-center justify-between text-xs text-emerald-800">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[16px]">chat</span>
                                            <span id="previewWaText" class="font-semibold">Commande instantanée par WhatsApp</span>
                                        </div>
                                        <span class="text-[10px] font-bold bg-emerald-200 px-1.5 py-0.5 rounded">Paiement Livraison</span>
                                    </div>

                                </div>
                            </div>

                            <!-- Légende de conformité typographique -->
                            <div class="mt-3 text-[11px] text-outline flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px] text-emerald-600">verified</span>
                                <span>Rendu temps réel conforme aux polices et graisses sélectionnées.</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Script JavaScript Vanilla pour la Prévisualisation Live Responsive (Module 4) -->
    <script>
        const fontLibraryMap = <?= json_encode($fontLibrary, JSON_UNESCAPED_SLASHES) ?>;

        function setPreviewDevice(mode) {
            const container = document.getElementById('previewContainer');
            const btnDesktop = document.getElementById('btnDeviceDesktop');
            const btnMobile = document.getElementById('btnDeviceMobile');

            if (mode === 'mobile') {
                container.style.maxWidth = '340px';
                container.style.borderRadius = '24px';
                btnMobile.className = 'px-2.5 py-1 rounded text-xs font-semibold bg-surface shadow-xs text-on-surface flex items-center gap-1';
                btnDesktop.className = 'px-2.5 py-1 rounded text-xs font-semibold text-outline hover:text-on-surface flex items-center gap-1';
            } else {
                container.style.maxWidth = '100%';
                container.style.borderRadius = '12px';
                btnDesktop.className = 'px-2.5 py-1 rounded text-xs font-semibold bg-surface shadow-xs text-on-surface flex items-center gap-1';
                btnMobile.className = 'px-2.5 py-1 rounded text-xs font-semibold text-outline hover:text-on-surface flex items-center gap-1';
            }
        }

        function quickApplyFont(fontName) {
            document.getElementById('font_titles').value = fontName;
            document.getElementById('font_subtitles').value = fontName;
            updateLiveTypography();
        }

        function updateLiveTypography() {
            const fontTitles = document.getElementById('font_titles').value;
            const fontSubtitles = document.getElementById('font_subtitles').value;
            const fontBody = document.getElementById('font_body').value;
            const fontButtons = document.getElementById('font_buttons').value;
            const fontAccents = document.getElementById('font_accents').value;

            const sizeTitles = document.getElementById('size_titles').value;
            const sizeSubtitles = document.getElementById('size_subtitles').value;
            const sizeBody = document.getElementById('size_body').value;

            const weightTitles = document.getElementById('weight_titles').value;
            const weightBody = document.getElementById('weight_body').value;
            const styleTitles = document.getElementById('style_titles').value;

            // Détermination des polices CSS
            const familyTitles = (fontLibraryMap[fontTitles] && fontLibraryMap[fontTitles].family) || "'Space Grotesk', sans-serif";
            const familySubtitles = (fontLibraryMap[fontSubtitles] && fontLibraryMap[fontSubtitles].family) || "'Space Grotesk', sans-serif";
            const familyBody = (fontLibraryMap[fontBody] && fontLibraryMap[fontBody].family) || "'Inter', sans-serif";
            const familyButtons = (fontLibraryMap[fontButtons] && fontLibraryMap[fontButtons].family) || "'Inter', sans-serif";
            const familyAccents = (fontLibraryMap[fontAccents] && fontLibraryMap[fontAccents].family) || "'Space Grotesk', sans-serif";

            // Échelles de taille
            const scaleTitleMap = { 'scale-compact': '14px', 'scale-normal': '16px', 'scale-large': '19px' };
            const scaleSubMap = { 'scale-compact': '11px', 'scale-normal': '12px', 'scale-large': '14px' };
            const scaleBodyMap = { 'scale-compact': '11px', 'scale-normal': '12px', 'scale-large': '13px' };

            const weightMap = {
                'font-normal': '400',
                'font-medium': '500',
                'font-semibold': '600',
                'font-bold': '700',
                'font-black': '900'
            };

            // Titre
            const elTitle = document.getElementById('previewTitle');
            elTitle.style.fontFamily = familyTitles;
            elTitle.style.fontSize = scaleTitleMap[sizeTitles] || '16px';
            elTitle.style.fontWeight = weightMap[weightTitles] || '700';
            elTitle.style.textTransform = (styleTitles === 'uppercase') ? 'uppercase' : 'none';
            elTitle.style.fontStyle = (styleTitles === 'italic') ? 'italic' : 'normal';

            // Sous-titre
            const elSubtitle = document.getElementById('previewSubtitle');
            elSubtitle.style.fontFamily = familySubtitles;
            elSubtitle.style.fontSize = scaleSubMap[sizeSubtitles] || '12px';

            // Nom Boutique
            const elShopName = document.getElementById('previewShopName');
            elShopName.style.fontFamily = familyTitles;
            elShopName.style.fontWeight = weightMap[weightTitles] || '700';

            // Descriptions & Texte
            const elDesc = document.getElementById('previewDescription');
            elDesc.style.fontFamily = familyBody;
            elDesc.style.fontSize = scaleBodyMap[sizeBody] || '12px';
            elDesc.style.fontWeight = weightMap[weightBody] || '400';

            // Formulaires & Selects
            document.getElementById('previewSelect').style.fontFamily = familyBody;

            // Boutons
            const elBtn = document.getElementById('previewBtn');
            elBtn.style.fontFamily = familyButtons;

            // Éléments d'accentuation (Prix, Badges)
            const elPrice = document.getElementById('previewPrice');
            elPrice.style.fontFamily = familyAccents;

            const elBadge = document.getElementById('previewBadge');
            elBadge.style.fontFamily = familyAccents;

            // Navigation
            const elNav = document.getElementById('previewNavLinks');
            elNav.style.fontFamily = familySubtitles;
        }

        // Initialisation immédiate au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            updateLiveTypography();
        });
    </script>
</body>
</html>