<?php
declare(strict_types=1);

// Récupération des informations de la boutique (nom, logo, etc.)
$shopName = 'Marvens Shop';
$shopLogo = null;
try {
    $settingsHelper = new \App\Application\Services\SettingsService();
    $shopInfo = $settingsHelper->getShopInfo();
    if (!empty($shopInfo['shop_name'])) {
        $shopName = $shopInfo['shop_name'];
    }
    if (!empty($shopInfo['logo_url'])) {
        $shopLogo = str_starts_with($shopInfo['logo_url'], 'http') 
            ? $shopInfo['logo_url'] 
            : '/' . ltrim($shopInfo['logo_url'], '/');
    }
} catch (\Throwable $e) {
    // Fallback silencieux en cas d'erreur de base de données
}
?>
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — <?= htmlspecialchars($shopName) ?></title>
    
    <!-- Typographie : Plus Jakarta Sans (distinctive, moderne, lisible) & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN conforme à l'administration du projet) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="h-full bg-slate-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen selection:bg-slate-900 selection:text-white">

    <!-- Barre supérieure discrète & contextuelle -->
    <header class="w-full max-w-5xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 rounded-md py-1 px-1.5 -ml-1.5">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Boutique</span>
        </a>
        <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
            <span>Console marchand</span>
        </div>
    </header>

    <!-- Zone principale centrée -->
    <main class="flex-1 flex items-center justify-center px-4 py-6 sm:py-12">
        <div class="w-full max-w-[390px]">
            
            <!-- Carte principale : design épuré, bordure nette, structure sobre -->
            <div class="bg-white border border-slate-200/90 rounded-2xl p-7 sm:p-8 shadow-xs">
                
                <!-- En-tête : identité du commerçant -->
                <div class="mb-7">
                    <div class="flex items-center gap-3 mb-4">
                        <?php if ($shopLogo): ?>
                            <img src="<?= htmlspecialchars($shopLogo) ?>" 
                                 alt="<?= htmlspecialchars($shopName) ?>" 
                                 class="h-10 w-10 object-contain rounded-lg border border-slate-200 bg-white p-1"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="h-10 w-10 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-sm tracking-wider" style="display:none;">
                                <?= strtoupper(substr($shopName, 0, 2)) ?>
                            </div>
                        <?php else: ?>
                            <div class="h-10 w-10 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-sm tracking-wider">
                                <?= strtoupper(substr($shopName, 0, 2)) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Espace de gestion</span>
                            <span class="block text-sm font-semibold text-slate-900 truncate max-w-[220px]"><?= htmlspecialchars($shopName) ?></span>
                        </div>
                    </div>

                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                        Connexion
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Accédez au suivi des commandes et au catalogue.
                    </p>
                </div>

                <!-- Message d'alerte en cas d'erreur -->
                <?php if (!empty($error)): ?>
                    <div role="alert" class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 flex items-start gap-2.5 text-red-900 text-xs leading-relaxed">
                        <span class="material-symbols-outlined text-[18px] text-red-600 shrink-0 mt-0.5">error</span>
                        <div class="font-medium">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form method="POST" action="/admin/login" class="space-y-4" novalidate>
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                    <!-- Identifiant / Email -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Identifiant ou adresse e-mail
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               required 
                               autofocus 
                               autocomplete="username"
                               placeholder="ex: admin"
                               class="w-full px-3.5 py-2.5 bg-white text-slate-900 placeholder:text-slate-400 text-sm rounded-lg border border-slate-300 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition-colors">
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-700">
                                Mot de passe
                            </label>
                        </div>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="w-full pl-3.5 pr-10 py-2.5 bg-white text-slate-900 placeholder:text-slate-400 text-sm rounded-lg border border-slate-300 focus:border-slate-900 focus:ring-1 focus:ring-slate-900 outline-none transition-colors">
                            <button type="button" 
                                    id="togglePasswordBtn" 
                                    aria-label="Afficher ou masquer le mot de passe"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 focus:outline-none transition-colors">
                                <span class="material-symbols-outlined text-[18px]" id="togglePasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Soumission -->
                    <div class="pt-2">
                        <button type="submit" 
                                id="submitBtn"
                                class="w-full bg-slate-900 hover:bg-slate-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2 text-white font-medium py-2.5 px-4 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                            <span>Se connecter</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </div>
                </form>

                <!-- Note de bas de carte -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">lock</span>
                        Session chiffrée
                    </span>
                    <span>Marvens Shop</span>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer sobre -->
    <footer class="w-full max-w-5xl mx-auto px-6 py-4 text-center sm:text-left text-xs text-slate-400">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($shopName) ?>. Tous droits réservés.</p>
    </footer>

    <!-- Script toggle mot de passe et indicateur de chargement -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            if (toggleBtn && passwordInput && toggleIcon) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    toggleIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
                });
            }

            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            if (form && submitBtn) {
                form.addEventListener('submit', function () {
                    if (form.checkValidity()) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Connexion...</span>
                        `;
                    }
                });
            }
        });
    </script>
</body>
</html>
