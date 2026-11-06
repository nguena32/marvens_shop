<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Utilisateurs & Permissions — Paramètres Marvens Shop</title>
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
            <div class="max-w-6xl mx-auto flex flex-col gap-space-lg">
                <header class="flex justify-between items-center bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-outline mb-1">
                            <span>Paramètres</span>
                            <span class="material-symbols-outlined text-xs">chevron_right</span>
                            <span class="text-primary font-bold">Module 5.4</span>
                        </div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Utilisateurs & Permissions</h1>
                        <p class="text-sm text-outline mt-1">Gestion des comptes d'accès, attribution des rôles et contrôle d'activité.</p>
                    </div>
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

        <!-- Formulaire d'ajout d'utilisateur -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">person_add</span> Ajouter un collaborateur
            </h2>
            <form method="POST" action="/admin/parametres/utilisateurs/ajouter" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nom complet</label>
                    <input type="text" name="name" placeholder="ex: Jean Dupont" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nom d'utilisateur *</label>
                    <input type="text" name="username" placeholder="ex: jdupont" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email professionnel *</label>
                    <input type="email" name="email" placeholder="jean@marvens-shop.cm" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Mot de passe temporaire *</label>
                    <input type="password" name="password" placeholder="Min. 8 caractères" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Rôle & Permissions *</label>
                    <select name="role" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                        <?php foreach ($roles as $rKey => $rLabel): ?>
                            <option value="<?= htmlspecialchars($rKey) ?>"><?= htmlspecialchars($rLabel) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm flex items-center justify-center gap-1 shadow">
                        <span class="material-symbols-outlined text-base">check</span> Créer le compte
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des utilisateurs existants -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">badge</span> Comptes actifs & autorisations
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 font-semibold text-xs uppercase">
                            <th class="py-3 px-4">Utilisateur</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Rôle</th>
                            <th class="py-3 px-4">Statut</th>
                            <th class="py-3 px-4">Créé le</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($users as $u): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="font-bold text-gray-900"><?= htmlspecialchars($u['name'] ?: $u['username']) ?></div>
                                    <div class="text-xs text-gray-400">@<?= htmlspecialchars($u['username']) ?></div>
                                </td>
                                <td class="py-3 px-4 text-gray-600"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                        <?= htmlspecialchars($roles[$u['role']] ?? $u['role']) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if (!empty($u['is_active'])): ?>
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Actif
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-rose-500">
                                            <span class="w-2 h-2 rounded-full bg-rose-500"></span> Désactivé
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-xs text-gray-500"><?= htmlspecialchars(substr((string)($u['created_at'] ?? ''), 0, 10)) ?></td>
                                <td class="py-3 px-4 text-right">
                                    <form method="POST" action="/admin/parametres/utilisateurs/<?= (int)$u['id'] ?>/statut" class="inline">
                                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                        <input type="hidden" name="active" value="<?= !empty($u['is_active']) ? '0' : '1' ?>">
                                        <button type="submit" class="text-xs font-semibold px-3 py-1 rounded-lg border border-gray-200 hover:bg-gray-100 <?= !empty($u['is_active']) ? 'text-amber-700' : 'text-emerald-700' ?>">
                                            <?= !empty($u['is_active']) ? 'Désactiver' : 'Réactiver' ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
            </div>
        </main>
    </div>
</body>
</html>
