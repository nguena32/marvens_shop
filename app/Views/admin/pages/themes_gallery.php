<?php
$active_tab = 'themes';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Thèmes & Apparence — Marvens Shop</title>
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
                
                <div class="bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <h1 class="text-2xl font-bold text-on-surface">Bibliothèque de Thèmes</h1>
                    <p class="text-sm text-outline">Personnalisez l'apparence publique de votre boutique sans jamais altérer vos produits, commandes ou réglages.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                    <!-- Thème Fashion -->
                    <div class="bg-surface rounded-2xl border border-border p-space-md shadow-sm flex flex-col justify-between">
                        <div>
                            <?php if ($active_theme === 'fashion'): ?>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full mb-3">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> ACTIF ACTUELLEMENT
                                </span>
                            <?php endif; ?>
                            <div class="aspect-video w-full rounded-xl bg-[#fff8f5] border border-border flex items-center justify-center font-bold text-[#8d4b00] mb-space-md text-sm">
                                Fashion (Éditorial Ambre)
                            </div>
                            <h3 class="font-bold text-base text-on-surface">Theme Fashion</h3>
                            <p class="text-xs text-outline mt-1 mb-space-lg">Style prêt-à-porter féminin raffiné, tons ambrés et élégance éditoriale moderne.</p>
                        </div>
                        <?php if ($active_theme !== 'fashion'): ?>
                            <form method="POST" action="/admin/themes/activer">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="theme" value="fashion">
                                <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all">
                                    Activer ce thème
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Thème Bello -->
                    <div class="bg-surface rounded-2xl border border-border p-space-md shadow-sm flex flex-col justify-between">
                        <div>
                            <?php if ($active_theme === 'bello'): ?>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full mb-3">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> ACTIF ACTUELLEMENT
                                </span>
                            <?php endif; ?>
                            <div class="aspect-video w-full rounded-xl bg-[#fdfaf6] border border-border flex items-center justify-center font-bold text-[#c2410c] mb-space-md text-sm">
                                Bello (Chaleureux & Doux)
                            </div>
                            <h3 class="font-bold text-base text-on-surface">Theme Bello</h3>
                            <p class="text-xs text-outline mt-1 mb-space-lg">Mise en avant visuelle soignée, contrastes doux et lisibilité commerciale épurée.</p>
                        </div>
                        <?php if ($active_theme !== 'bello'): ?>
                            <form method="POST" action="/admin/themes/activer">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="theme" value="bello">
                                <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all">
                                    Activer ce thème
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Thème Luxe -->
                    <div class="bg-surface rounded-2xl border border-border p-space-md shadow-sm flex flex-col justify-between">
                        <div>
                            <?php if ($active_theme === 'luxe'): ?>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-full mb-3">
                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> ACTIF ACTUELLEMENT
                                </span>
                            <?php endif; ?>
                            <div class="aspect-video w-full rounded-xl bg-[#18181b] border border-border flex items-center justify-center font-bold text-[#f4f4f5] mb-space-md text-sm">
                                Luxe (Sombre & Premium)
                            </div>
                            <h3 class="font-bold text-base text-on-surface">Theme Luxe</h3>
                            <p class="text-xs text-outline mt-1 mb-space-lg">Ambiance nocturne haut de gamme pour articles d'exception, horlogerie et maroquinerie.</p>
                        </div>
                        <?php if ($active_theme !== 'luxe'): ?>
                            <form method="POST" action="/admin/themes/activer">
                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                <input type="hidden" name="theme" value="luxe">
                                <button type="submit" class="w-full bg-primary text-on-primary py-2 rounded-xl text-xs font-semibold hover:bg-surface-container-high hover:text-on-surface transition-all">
                                    Activer ce thème
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
