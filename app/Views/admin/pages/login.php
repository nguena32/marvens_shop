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
    <title>Connexion Administrateur — <?= htmlspecialchars($shopName) ?></title>
    
    <!-- Polices Google : Inter & Material Symbols Outlined -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN conforme à l'administration du projet) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: '#0f172a',
                        'primary-accent': '#f59e0b',
                        surface: '#ffffff',
                    }
                }
            }
        };
    </script>
    <style>
        /* Grille subtile d'arrière-plan */
        .bg-grid-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(rgba(148, 163, 184, 0.25) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        /* Effet de lueur diffuse */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.45;
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body class="h-full bg-grid-pattern font-sans antialiased text-slate-900 flex flex-col justify-between min-h-screen relative overflow-x-hidden selection:bg-slate-900 selection:text-white">

    <!-- Lueur d'ambiance décorative -->
    <div class="ambient-glow bg-amber-200/50 -top-32 -left-32"></div>
    <div class="ambient-glow bg-slate-300/60 -bottom-32 -right-32"></div>

    <!-- Header minimaliste avec retour boutique -->
    <header class="w-full relative z-10 px-6 py-5 flex items-center justify-between max-w-6xl mx-auto">
        <a href="/" class="inline-flex items-center gap-2 text-xs font-medium text-slate-600 hover:text-slate-900 transition-colors bg-white/80 hover:bg-white backdrop-blur-md px-3.5 py-1.5 rounded-full border border-slate-200/80 shadow-xs">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            <span>Retour à la boutique</span>
        </a>
        <div class="inline-flex items-center gap-1.5 text-xs text-slate-500 font-medium">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Espace sécurisé</span>
        </div>
    </header>

    <!-- Contenu Principal / Carte de Connexion -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-[430px]">
            
            <!-- Carte Glassmorphism & Ombre douce -->
            <div class="bg-white/95 backdrop-blur-xl border border-slate-200/90 rounded-3xl p-7 sm:p-9 shadow-xl shadow-slate-200/60 relative">
                
                <!-- Logo & Entête -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center mb-4">
                        <?php if ($shopLogo): ?>
                            <img src="<?= htmlspecialchars($shopLogo) ?>" 
                                 alt="<?= htmlspecialchars($shopName) ?>" 
                                 class="h-12 max-w-[140px] object-contain rounded-xl"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-slate-900 to-slate-800 text-white flex items-center justify-center font-bold text-xl shadow-md shadow-slate-900/10" style="display:none;">
                                <?= strtoupper(substr($shopName, 0, 1)) ?>
                            </div>
                        <?php else: ?>
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-slate-900 to-slate-800 text-white flex items-center justify-center font-bold text-xl shadow-md shadow-slate-900/10">
                                <?= strtoupper(substr($shopName, 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Administration
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Connectez-vous pour gérer votre boutique <span class="font-medium text-slate-700"><?= htmlspecialchars($shopName) ?></span>
                    </p>
                </div>

                <!-- Message d'erreur élégant -->
                <?php if (!empty($error)): ?>
                    <div class="mb-6 p-3.5 rounded-2xl bg-red-50/90 border border-red-200/80 flex items-start gap-3 text-red-800 animate-shake">
                        <span class="material-symbols-outlined text-[20px] text-red-600 shrink-0 mt-0.5">error</span>
                        <div class="text-xs sm:text-sm font-medium leading-relaxed">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Formulaire de Connexion -->
                <form method="POST" action="/admin/login" class="space-y-4" novalidate>
                    <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">

                    <!-- Champ Identifiant / Email -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Identifiant ou Email
                        </label>
                        <div class="relative rounded-2xl shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[19px]">person</span>
                            </div>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   placeholder="ex: admin ou contact@domaine.com"
                                   class="block w-full pl-10 pr-3.5 py-2.5 sm:py-3 bg-slate-50/60 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder:text-slate-400 text-sm rounded-2xl border border-slate-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none transition-all duration-200">
                        </div>
                    </div>

                    <!-- Champ Mot de passe avec toggle visibilité -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-700">
                                Mot de passe
                            </label>
                        </div>
                        <div class="relative rounded-2xl shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[19px]">lock</span>
                            </div>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="block w-full pl-10 pr-11 py-2.5 sm:py-3 bg-slate-50/60 hover:bg-slate-50 focus:bg-white text-slate-900 placeholder:text-slate-400 text-sm rounded-2xl border border-slate-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 outline-none transition-all duration-200">
                            <button type="button" 
                                    id="togglePasswordBtn" 
                                    aria-label="Afficher ou masquer le mot de passe"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-700 focus:outline-none transition-colors">
                                <span class="material-symbols-outlined text-[19px]" id="togglePasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Bouton de Soumission -->
                    <div class="pt-2">
                        <button type="submit" 
                                id="submitBtn"
                                class="w-full relative group overflow-hidden bg-slate-900 hover:bg-slate-800 text-white font-medium py-3 px-4 rounded-2xl text-sm transition-all duration-200 shadow-md shadow-slate-900/15 hover:shadow-lg hover:shadow-slate-900/20 active:scale-[0.99] flex items-center justify-center gap-2">
                            <span>Se connecter</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-0.5">login</span>
                        </button>
                    </div>
                </form>

                <!-- Information de sécurité discrète -->
                <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-center gap-2 text-slate-400 text-xs text-center">
                    <span class="material-symbols-outlined text-[15px]">verified_user</span>
                    <span>Accès protégé & journalisé • Marvens Shop</span>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer minimaliste -->
    <footer class="w-full relative z-10 py-5 text-center text-xs text-slate-400">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($shopName) ?> — Tous droits réservés.</p>
    </footer>

    <!-- Script pour le basculement du mot de passe & feedback interactif -->
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

            // État de chargement élégant à la soumission
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            if (form && submitBtn) {
                form.addEventListener('submit', function () {
                    if (form.checkValidity()) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Connexion en cours...</span>
                        `;
                    }
                });
            }
        });
    </script>
</body>
</html>
