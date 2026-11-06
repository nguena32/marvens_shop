<?php
$active_tab = 'themes';
/** @var App\Domain\Themes\Theme[] $themes */
$themesList = $themes ?? [];
$activeThemeId = $active_theme ?? 'fashion';
$previousThemeId = $previous_theme ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Bibliothèque de Thèmes & Apparence — Marvens Shop</title>
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

                <!-- Bandeau Header Gestion Thèmes -->
                <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-2xl">palette</span>
                            <h1 class="text-2xl font-bold text-on-surface">Bibliothèque de Thèmes Stitch</h1>
                        </div>
                        <p class="text-xs text-outline mt-1 max-w-2xl">
                            Sélectionnez, prévisualisez et appliquez un thème pour votre boutique sans jamais toucher au code. Vos produits, variantes, catégories, commandes, clients et réglages commerciaux restent strictement intacts.
                        </p>
                    </div>

                    <!-- Actions globales : Rollback & Reset & Personnalisation -->
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="/admin/parametres/apparence?theme=<?= htmlspecialchars($activeThemeId) ?>" class="px-3 py-2 rounded-xl bg-primary text-on-primary text-xs font-semibold hover:bg-surface-container-high hover:text-on-surface flex items-center gap-1.5 transition shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">format_paint</span>
                            Personnaliser les Couleurs
                        </a>

                        <?php if (!empty($previousThemeId)): ?>
                            <form method="POST" action="/admin/themes/rollback" onsubmit="return confirm('Voulez-vous restaurer le thème précédent (<?= htmlspecialchars($previousThemeId) ?>) ?');">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <button type="submit" class="px-3 py-2 rounded-xl border border-border bg-surface-container-low text-xs font-semibold hover:bg-surface-container flex items-center gap-1.5 transition">
                                    <span class="material-symbols-outlined text-[16px]">history</span>
                                    Revenir au thème précédent (<?= htmlspecialchars($previousThemeId) ?>)
                                </button>
                            </form>
                        <?php endif; ?>

                        <form method="POST" action="/admin/themes/reinitialiser" onsubmit="return confirm('Réinitialiser au thème par défaut de Marvens Shop (Fashion) ?');">
                            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                            <button type="submit" class="px-3 py-2 rounded-xl border border-border bg-surface text-xs font-semibold hover:bg-surface-container-high flex items-center gap-1.5 transition">
                                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                                Réinitialiser par défaut
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Grille des Thèmes sous forme de Cartes complètes -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($themesList as $theme): ?>
                        <?php 
                            $isCurrent = ($theme->getId() === $activeThemeId);
                        ?>
                        <div class="bg-surface rounded-2xl border <?= $isCurrent ? 'border-primary ring-2 ring-primary/20 shadow-md' : 'border-border shadow-sm' ?> p-5 flex flex-col justify-between transition-all hover:shadow-md">
                            <div>
                                <!-- Statut Thème Actif -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-mono uppercase tracking-wider text-outline font-semibold">
                                        ID : <?= htmlspecialchars($theme->getId()) ?>
                                    </span>
                                    <?php if ($isCurrent): ?>
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-800 bg-emerald-100 px-3 py-0.5 rounded-full shadow-sm">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span> THÈME ACTIF
                                        </span>
                                    <?php else: ?>
                                        <span class="text-xs text-outline font-medium">Disponible</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Image de prévisualisation -->
                                <div class="aspect-[16/10] w-full rounded-xl overflow-hidden border border-border mb-4 relative group bg-surface-container-low">
                                    <img src="<?= htmlspecialchars($theme->getPreviewImage()) ?>" alt="<?= htmlspecialchars($theme->getName()) ?>" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300"/>
                                    
                                    <!-- Overlay de prévisualisation rapide -->
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-4">
                                        <a href="/theme/preview/<?= htmlspecialchars($theme->getId()) ?>" target="_blank" class="px-3 py-1.5 bg-white text-slate-900 rounded-lg text-xs font-bold flex items-center gap-1 shadow-md hover:bg-slate-100 transition">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span> Prévisualiser l'accueil
                                        </a>
                                    </div>
                                </div>

                                <!-- Nom et description -->
                                <h3 class="font-bold text-base text-on-surface flex items-center justify-between">
                                    <span><?= htmlspecialchars($theme->getName()) ?></span>
                                </h3>
                                <p class="text-xs text-outline mt-1.5 leading-relaxed">
                                    <?= htmlspecialchars($theme->getDescription()) ?>
                                </p>

                                <!-- Palette de couleurs principales -->
                                <div class="mt-4 pt-3 border-t border-border">
                                    <span class="text-[11px] font-bold text-on-surface uppercase tracking-wider block mb-1.5">Palette de couleurs</span>
                                    <div class="flex items-center gap-2">
                                        <?php foreach ($theme->getPrimaryColors() as $c): ?>
                                            <div class="flex items-center gap-1 text-[10px] text-outline font-mono bg-surface-container-low px-1.5 py-0.5 rounded border border-border">
                                                <span class="w-3 h-3 rounded-full border border-black/10 flex-shrink-0" style="background-color: <?= htmlspecialchars($c) ?>"></span>
                                                <span><?= htmlspecialchars($c) ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Caractéristiques principales du thème -->
                                <div class="mt-4 pt-3 border-t border-border space-y-2">
                                    <span class="text-[11px] font-bold text-on-surface uppercase tracking-wider block">Caractéristiques du design</span>
                                    <ul class="space-y-1 text-xs text-outline">
                                        <?php foreach ($theme->getFeatures() as $feat): ?>
                                            <li class="flex items-start gap-1.5">
                                                <span class="material-symbols-outlined text-[14px] text-primary flex-shrink-0 mt-0.5">check</span>
                                                <span><?= htmlspecialchars($feat) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <!-- Détails des styles (Catalogue, Cartes, Navigation, Fiche, Panier, Accueil) -->
                                <div class="mt-4 pt-3 border-t border-border grid grid-cols-2 gap-2 text-[11px]">
                                    <div class="p-2 rounded bg-surface-container-low border border-border">
                                        <span class="text-outline font-medium block">Catalogue :</span>
                                        <span class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getCatalogStyle()) ?></span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low border border-border">
                                        <span class="text-outline font-medium block">Cartes produits :</span>
                                        <span class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getProductCardStyle()) ?></span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low border border-border">
                                        <span class="text-outline font-medium block">Navigation :</span>
                                        <span class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getNavigationStyle()) ?></span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low border border-border">
                                        <span class="text-outline font-medium block">Page produit :</span>
                                        <span class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getProductPageStyle()) ?></span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low border border-border">
                                        <span class="text-outline font-medium block">Panier :</span>
                                        <span class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getCartStyle()) ?></span>
                                    </div>
                                    <div class="p-2 rounded bg-surface-container-low border border-border">
                                        <span class="text-outline font-medium block">Page d'accueil :</span>
                                        <span class="font-semibold text-on-surface"><?= htmlspecialchars($theme->getHomeStyle()) ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions du thème (Prévisualiser / Activer / Personnaliser) -->
                            <div class="mt-6 pt-4 border-t border-border flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <a href="/theme/preview/<?= htmlspecialchars($theme->getId()) ?>" target="_blank" class="flex-1 py-2 px-3 rounded-xl border border-border bg-surface text-center text-xs font-semibold hover:bg-surface-container transition flex items-center justify-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        Prévisualiser
                                    </a>

                                    <a href="/admin/parametres/apparence?theme=<?= htmlspecialchars($theme->getId()) ?>" class="flex-1 py-2 px-3 rounded-xl border border-border bg-surface-container-low text-center text-xs font-semibold hover:bg-surface-container transition flex items-center justify-center gap-1" title="Modifier la palette et le style de ce thème">
                                        <span class="material-symbols-outlined text-[16px]">format_paint</span>
                                        Couleurs
                                    </a>
                                </div>

                                <?php if (!$isCurrent): ?>
                                    <form method="POST" action="/admin/themes/activer" class="w-full" onsubmit="return confirm('Confirmez-vous le passage au <?= htmlspecialchars($theme->getName()) ?> ?');">
                                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                        <input type="hidden" name="theme" value="<?= htmlspecialchars($theme->getId()) ?>">
                                        <button type="submit" class="w-full bg-primary text-on-primary py-2 px-3 rounded-xl text-xs font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all flex items-center justify-center gap-1 shadow-sm">
                                            <span class="material-symbols-outlined text-[16px]">check</span>
                                            Activer ce thème
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button disabled class="w-full bg-emerald-50 text-emerald-700 border border-emerald-200 py-2 px-3 rounded-xl text-xs font-bold cursor-default flex items-center justify-center gap-1">
                                        <span class="material-symbols-outlined text-[16px]">done_all</span>
                                        Thème actuellement actif
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Réassurance d'intégrité des données -->
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-xs text-blue-900 flex items-start gap-3">
                    <span class="material-symbols-outlined text-blue-700 text-xl flex-shrink-0">verified_user</span>
                    <div>
                        <strong class="font-bold">Garantie d'invariance des données commerciales (Règle MS-BIZ-07) :</strong>
                        <p class="mt-0.5 leading-relaxed text-blue-800">
                            Chaque thème est une couche de présentation découplée. Le passage d'un thème à un autre ne supprime ni ne modifie vos produits, catégories, descriptions, prix, variantes, stocks, commandes, clients ou configurations WhatsApp et paiements.
                        </p>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
