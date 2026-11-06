<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sécurité & Audit — Paramètres Marvens Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#F8F9FA] text-[#1A1A1A] font-['Plus_Jakarta_Sans',sans-serif] flex min-h-screen">

    <?php require __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="flex-1 ml-72 p-10 max-w-6xl">
        <header class="mb-8 flex justify-between items-center">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">
                    <span>Paramètres</span>
                    <span class="material-symbols-outlined text-xs">chevron_right</span>
                    <span class="text-indigo-600">Module 5.7</span>
                </div>
                <h1 class="text-3xl font-extrabold font-['Space_Grotesk'] text-gray-900">Sécurité & Journal d'Audit</h1>
                <p class="text-sm text-gray-500 mt-1">Protection d'accès, renouvellement des identifiants et traçabilité des actions sensibles.</p>
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

        <!-- 1. Modification du mot de passe administrateur -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">lock_reset</span> Modifier mon mot de passe
            </h2>
            <form method="POST" action="/admin/parametres/securite/mot-de-passe" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nouveau mot de passe *</label>
                    <input type="password" name="new_password" placeholder="Min. 8 caractères" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Confirmer le mot de passe *</label>
                    <input type="password" name="confirm_password" placeholder="Confirmer" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm flex items-center justify-center gap-1 shadow">
                        <span class="material-symbols-outlined text-base">security</span> Mettre à jour
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. Gestion des Sauvegardes et Restauration (Module 9.3) -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600">backup</span> Sauvegardes du Système & Restauration
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Sauvegardez l'état de la base de données ou les fichiers téléversés pour une maintenance et reprise d'activité sereines.</p>
                </div>
                <div class="flex gap-2">
                    <form method="POST" action="/admin/parametres/securite/sauvegarde/db">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <button type="submit" class="px-3 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold rounded-lg text-xs flex items-center gap-1 border border-indigo-200">
                            <span class="material-symbols-outlined text-sm">database</span> Sauvegarder Base SQL
                        </button>
                    </form>
                    <form method="POST" action="/admin/parametres/securite/sauvegarde/fichiers">
                        <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        <button type="submit" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold rounded-lg text-xs flex items-center gap-1 border border-gray-200">
                            <span class="material-symbols-outlined text-sm">folder_zip</span> Archiver Médias
                        </button>
                    </form>
                </div>
            </div>

            <?php if (!empty($backups)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400 font-semibold text-[11px] uppercase">
                                <th class="py-2 px-3">Date</th>
                                <th class="py-2 px-3">Fichier</th>
                                <th class="py-2 px-3">Type</th>
                                <th class="py-2 px-3">Taille</th>
                                <th class="py-2 px-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach ($backups as $b): ?>
                                <tr>
                                    <td class="py-2.5 px-3 text-xs text-gray-500"><?= htmlspecialchars((string)$b['created_at']) ?></td>
                                    <td class="py-2.5 px-3 font-mono text-xs text-gray-800 font-semibold"><?= htmlspecialchars((string)$b['filename']) ?></td>
                                    <td class="py-2.5 px-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $b['backup_type'] === 'db' ? 'bg-indigo-50 text-indigo-700' : 'bg-amber-50 text-amber-700' ?>">
                                            <?= strtoupper(htmlspecialchars((string)$b['backup_type'])) ?>
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-xs text-gray-600"><?= number_format((float)$b['size_bytes'] / 1024, 1) ?> Ko</td>
                                    <td class="py-2.5 px-3 text-right">
                                        <?php if ($b['backup_type'] === 'db'): ?>
                                            <form method="POST" action="/admin/parametres/securite/restauration" onsubmit="return confirm('Attention : la restauration écrasera les données actuelles de la base. Confirmer ?');" class="inline">
                                                <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                                                <input type="hidden" name="filename" value="<?= htmlspecialchars((string)$b['filename']) ?>">
                                                <button type="submit" class="px-2.5 py-1 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded text-xs inline-flex items-center gap-1 shadow-sm">
                                                    <span class="material-symbols-outlined text-[13px]">restore</span> Restaurer
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="py-4 text-center text-xs text-gray-400">Aucune archive créée pour l'instant. Utilisez les boutons ci-dessus pour déclencher une sauvegarde manuelle.</div>
            <?php endif; ?>
        </div>

        <!-- 3. Journal d'Audit et Activité Récente -->
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">history</span> Journal des Activités & Événements de Sécurité
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-gray-500 font-semibold text-xs uppercase">
                            <th class="py-3 px-4">Date & Heure</th>
                            <th class="py-3 px-4">Événement</th>
                            <th class="py-3 px-4">Utilisateur</th>
                            <th class="py-3 px-4">Adresse IP</th>
                            <th class="py-3 px-4">Détails</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($logs)): ?>
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400">Aucun journal d'activité enregistré pour le moment.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($logs as $l): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-xs text-gray-500"><?= htmlspecialchars((string)$l['created_at']) ?></td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-700">
                                            <?= htmlspecialchars((string)$l['event_type']) ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-800"><?= htmlspecialchars((string)($l['user_email'] ?? 'Système')) ?></td>
                                    <td class="py-3 px-4 text-xs font-mono text-gray-500"><?= htmlspecialchars((string)$l['ip_address']) ?></td>
                                    <td class="py-3 px-4 text-xs text-gray-600"><?= htmlspecialchars((string)$l['details']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
