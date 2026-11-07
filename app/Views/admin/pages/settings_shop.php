<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Informations de la boutique — Paramètres Marvens Shop</title>
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
            <div class="max-w-6xl mx-auto flex flex-col gap-space-lg">
                <header class="flex justify-between items-center bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-outline mb-1">
                            <span>Paramètres</span>
                            <span class="material-symbols-outlined text-xs">chevron_right</span>
                            <span class="text-primary font-bold">Module 5.1</span>
                        </div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Informations de la Boutique</h1>
                        <p class="text-sm text-outline mt-1">Identité commerciale, coordonnées publiques et préférences régionales.</p>
                    </div>
                    <a href="/" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-surface border border-border rounded-xl text-sm font-semibold hover:bg-surface-container-high transition-all shadow-sm">
                        <span class="material-symbols-outlined text-base">visibility</span> Voir le site
                    </a>
                </header>

        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center gap-3 text-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/parametres/boutique" enctype="multipart/form-data" class="space-y-8">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

            <!-- 1. Identité de la boutique -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-600">storefront</span> Identité & Marque
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nom commercial de la boutique *</label>
                        <input type="text" name="shop_name" value="<?= htmlspecialchars($shop['shop_name'] ?? '') ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nom juridique de l'entreprise</label>
                        <input type="text" name="company_name" value="<?= htmlspecialchars($shop['company_name'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Description courte de la boutique</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm"><?= htmlspecialchars($shop['description'] ?? '') ?></textarea>
                    </div>

                    <!-- Sélecteur & Upload Logo -->
                    <div class="bg-gray-50/70 border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-gray-800 uppercase flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-indigo-600">badge</span> Logo principal de la boutique
                                </label>
                                <span class="text-[11px] font-medium text-gray-500">PNG, JPG, WEBP, SVG</span>
                            </div>

                            <!-- Aperçu Logo actuel ou nouveau -->
                            <div class="flex items-center gap-4 my-3 p-3 bg-white border border-gray-200 rounded-xl">
                                <div class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                                    <img id="logoPreview" 
                                         src="<?= htmlspecialchars(!empty($shop['logo_url']) ? (str_starts_with($shop['logo_url'], 'http') ? $shop['logo_url'] : '/' . ltrim($shop['logo_url'], '/')) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'64\' height=\'64\' fill=\'%23d1d5db\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z\'/%3E%3C/svg%3E') ?>" 
                                         alt="Logo boutique" 
                                         class="max-h-14 max-w-14 object-contain">
                                </div>
                                <div class="text-xs text-gray-600 space-y-1 overflow-hidden">
                                    <p class="font-semibold text-gray-900 truncate" id="logoFileName">Logo actuel</p>
                                    <p class="text-[11px] text-gray-500 truncate" id="logoFilePath"><?= htmlspecialchars($shop['logo_url'] ?? 'Non défini') ?></p>
                                    <p class="text-[10px] text-emerald-600 font-medium">Parcourez vos fichiers pour remplacer l'image</p>
                                </div>
                            </div>

                            <!-- Champ de sélection de fichier local / externe -->
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-gray-600 uppercase">Téléverser une nouvelle image (fichier externe)</label>
                                <input type="file" 
                                       id="logoFileInput" 
                                       name="logo_file" 
                                       accept="image/jpeg,image/png,image/webp,image/svg+xml"
                                       class="w-full text-xs text-gray-700 bg-white border border-gray-200 rounded-xl px-3 py-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition cursor-pointer">
                            </div>
                        </div>

                        <!-- Option URL de secours repliable -->
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <details class="group">
                                <summary class="text-[11px] font-medium text-gray-500 hover:text-indigo-600 cursor-pointer flex items-center justify-between">
                                    <span>Ou spécifier une URL directe de logo</span>
                                    <span class="material-symbols-outlined text-xs group-open:rotate-180 transition-transform">expand_more</span>
                                </summary>
                                <div class="mt-2">
                                    <input type="text" 
                                           id="logoUrlInput" 
                                           name="logo_url" 
                                           value="<?= htmlspecialchars($shop['logo_url'] ?? '') ?>" 
                                           placeholder="https://... ou /uploads/..."
                                           class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-xs">
                                </div>
                            </details>
                        </div>
                    </div>

                    <!-- Sélecteur & Upload Favicon -->
                    <div class="bg-gray-50/70 border border-gray-200/80 rounded-2xl p-4 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-gray-800 uppercase flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px] text-amber-600">tab</span> Favicon de la boutique
                                </label>
                                <span class="text-[11px] font-medium text-gray-500">ICO, PNG, WEBP, SVG</span>
                            </div>

                            <!-- Aperçu Favicon actuel ou nouveau -->
                            <div class="flex items-center gap-4 my-3 p-3 bg-white border border-gray-200 rounded-xl">
                                <div class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                                    <img id="faviconPreview" 
                                         src="<?= htmlspecialchars(!empty($shop['favicon_url']) ? (str_starts_with($shop['favicon_url'], 'http') ? $shop['favicon_url'] : '/' . ltrim($shop['favicon_url'], '/')) : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'32\' height=\'32\' fill=\'%23d1d5db\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z\'/%3E%3C/svg%3E') ?>" 
                                         alt="Favicon boutique" 
                                         class="w-8 h-8 object-contain">
                                </div>
                                <div class="text-xs text-gray-600 space-y-1 overflow-hidden">
                                    <p class="font-semibold text-gray-900 truncate" id="faviconFileName">Favicon actuel</p>
                                    <p class="text-[11px] text-gray-500 truncate" id="faviconFilePath"><?= htmlspecialchars($shop['favicon_url'] ?? 'Non défini') ?></p>
                                    <p class="text-[10px] text-amber-600 font-medium">Recommandé : image carrée (32x32 ou 64x64 px)</p>
                                </div>
                            </div>

                            <!-- Champ de sélection de fichier local / externe -->
                            <div class="space-y-2">
                                <label class="block text-[11px] font-bold text-gray-600 uppercase">Téléverser une nouvelle icône (fichier externe)</label>
                                <input type="file" 
                                       id="faviconFileInput" 
                                       name="favicon_file" 
                                       accept="image/x-icon,image/vnd.microsoft.icon,image/png,image/jpeg,image/webp,image/svg+xml"
                                       class="w-full text-xs text-gray-700 bg-white border border-gray-200 rounded-xl px-3 py-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition cursor-pointer">
                            </div>
                        </div>

                        <!-- Option URL de secours repliable -->
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <details class="group">
                                <summary class="text-[11px] font-medium text-gray-500 hover:text-amber-600 cursor-pointer flex items-center justify-between">
                                    <span>Ou spécifier une URL directe de favicon</span>
                                    <span class="material-symbols-outlined text-xs group-open:rotate-180 transition-transform">expand_more</span>
                                </summary>
                                <div class="mt-2">
                                    <input type="text" 
                                           id="faviconUrlInput" 
                                           name="favicon_url" 
                                           value="<?= htmlspecialchars($shop['favicon_url'] ?? '') ?>" 
                                           placeholder="https://... ou /uploads/..."
                                           class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none text-xs">
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Contacts & WhatsApp -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">chat</span> Canaux de Contact & WhatsApp
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Numéro WhatsApp Business (Réception commandes) *</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                <span class="material-symbols-outlined text-[18px]">chat</span>
                            </span>
                            <input type="text" name="whatsapp_number" value="<?= htmlspecialchars($shop['whatsapp_number'] ?? '') ?>" required
                                   placeholder="+237 699 00 00 00"
                                   pattern="^\+?[0-9\s\-\.\(\)]{8,25}$"
                                   title="Numéro de téléphone avec indicatif international recommandé (ex: +237 699 00 00 00 ou +33 6 12 34 56 78)"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-medium">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Format international recommandé (ex: +237 699 00 00 00 ou +33 6 12 34 56 78). Les espaces et tirets sont automatiquement nettoyés.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Téléphone d'appel direct</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($shop['phone'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Email professionnel</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($shop['email'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Adresse physique</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($shop['address'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Ville</label>
                        <input type="text" name="city" value="<?= htmlspecialchars($shop['city'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pays</label>
                        <input type="text" name="country" value="<?= htmlspecialchars($shop['country'] ?? '') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <!-- 3. Localisation & Préférences régionales -->
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-600">public</span> Préférences Régionales
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Devise principale</label>
                        <select name="currency" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            <option value="FCFA" <?= ($shop['currency'] ?? '') === 'FCFA' ? 'selected' : '' ?>>FCFA (Franc CFA)</option>
                            <option value="EUR" <?= ($shop['currency'] ?? '') === 'EUR' ? 'selected' : '' ?>>EUR (€ - Euro)</option>
                            <option value="USD" <?= ($shop['currency'] ?? '') === 'USD' ? 'selected' : '' ?>>USD ($ - Dollar US)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Langue de l'interface</label>
                        <select name="language" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                            <option value="fr" <?= ($shop['language'] ?? '') === 'fr' ? 'selected' : '' ?>>Français</option>
                            <option value="en" <?= ($shop['language'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Fuseau horaire</label>
                        <input type="text" name="timezone" value="<?= htmlspecialchars($shop['timezone'] ?? 'Africa/Douala') ?>"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-3 bg-primary hover:opacity-90 text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span> Enregistrer les informations
                </button>
            </div>
        </form>

        <script>
            // Prévisualisation instantanée du Logo
            const logoFileInput = document.getElementById('logoFileInput');
            const logoPreview = document.getElementById('logoPreview');
            const logoFileName = document.getElementById('logoFileName');
            const logoFilePath = document.getElementById('logoFilePath');
            const logoUrlInput = document.getElementById('logoUrlInput');

            if (logoFileInput) {
                logoFileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            logoPreview.src = evt.target.result;
                            logoFileName.textContent = file.name;
                            logoFilePath.textContent = (file.size / 1024).toFixed(1) + ' Ko • Prêt à être enregistré';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (logoUrlInput) {
                logoUrlInput.addEventListener('input', function() {
                    const val = this.value.trim();
                    if (val && (!logoFileInput.files || logoFileInput.files.length === 0)) {
                        logoPreview.src = val;
                        logoFileName.textContent = 'Image distante (URL)';
                        logoFilePath.textContent = val;
                    }
                });
            }

            // Prévisualisation instantanée du Favicon
            const faviconFileInput = document.getElementById('faviconFileInput');
            const faviconPreview = document.getElementById('faviconPreview');
            const faviconFileName = document.getElementById('faviconFileName');
            const faviconFilePath = document.getElementById('faviconFilePath');
            const faviconUrlInput = document.getElementById('faviconUrlInput');

            if (faviconFileInput) {
                faviconFileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            faviconPreview.src = evt.target.result;
                            faviconFileName.textContent = file.name;
                            faviconFilePath.textContent = (file.size / 1024).toFixed(1) + ' Ko • Prêt à être enregistré';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (faviconUrlInput) {
                faviconUrlInput.addEventListener('input', function() {
                    const val = this.value.trim();
                    if (val && (!faviconFileInput.files || faviconFileInput.files.length === 0)) {
                        faviconPreview.src = val;
                        faviconFileName.textContent = 'Icône distante (URL)';
                        faviconFilePath.textContent = val;
                    }
                });
            }
        </script>
            </div>
        </main>
    </div>
</body>
</html>
