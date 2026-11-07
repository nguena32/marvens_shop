<?php
$active_tab = 'customers';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include dirname(__DIR__) . '/partials/favicon.php'; ?>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gestion des Clients — Marvens Shop</title>
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

    <div class="md:pl-72 min-h-screen flex flex-col pb-16 md:pb-0">
        <?php include dirname(__DIR__) . '/partials/header.php';
        include dirname(__DIR__) . '/partials/bottom_nav.php'; ?>

        <main class="relative pt-16 bg-background min-h-screen p-space-lg">
            <div class="max-w-7xl mx-auto flex flex-col gap-space-lg">
                
                <!-- En-tête (Module 8.4) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-space-md bg-surface p-space-lg rounded-2xl border border-border shadow-sm">
                    <div>
                        <h1 class="text-2xl font-bold text-on-surface tracking-tight">Répertoire & Gestion des Clients</h1>
                        <p class="text-sm text-outline">Enregistrement automatique au checkout, numéros WhatsApp, historique d'achats</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs bg-surface-container-high text-on-surface font-semibold px-3 py-1.5 rounded-xl border border-border">
                            Total : <?= (int)($total_count ?? count($customers)) ?> client(s)
                        </span>
                    </div>
                </div>

                <!-- Barre de Recherche Client (8.4 Recherche client : nom / WhatsApp) -->
                <form method="GET" action="/admin/clients" class="bg-surface p-space-md rounded-2xl border border-border flex items-center gap-3 shadow-sm text-xs">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline text-[18px]">search</span>
                        <input type="text" name="search" value="<?= htmlspecialchars($current_search ?? '') ?>" placeholder="Rechercher par nom complet ou numéro WhatsApp (ex: 699112233)..." class="w-full bg-surface-container-low border border-border rounded-xl pl-9 pr-3 py-2 text-sm text-on-surface">
                    </div>
                    <button type="submit" class="bg-primary text-white px-5 py-2 rounded-xl font-semibold hover:opacity-90 transition-all">
                        Rechercher
                    </button>
                    <?php if (!empty($current_search)): ?>
                        <a href="/admin/clients" class="px-3 py-2 border border-border rounded-xl hover:bg-surface-container-low font-semibold text-outline" title="Effacer le filtre">
                            Réinitialiser
                        </a>
                    <?php endif; ?>
                </form>

                <!-- Tableau des Clients (8.4 Nom, WhatsApp, Adresse, Quartier, Historique) -->
                <div class="bg-surface rounded-2xl border border-border overflow-hidden shadow-sm">
                    <!-- Vue Cartes Mobile (< md) -->
                    <div class="block md:hidden divide-y divide-border">
                        <?php if (empty($customers)): ?>
                            <div class="py-12 text-center text-outline text-xs">
                                Aucun client enregistré pour l'instant.
                            </div>
                        <?php else: ?>
                            <?php foreach ($customers as $cust): ?>
                                <?php 
                                    $clean = preg_replace('/[^0-9]/', '', (string)$cust['whatsapp']);
                                    $waUrl = "https://wa.me/" . $clean;
                                ?>
                                <div class="p-4 flex flex-col gap-2.5 bg-surface hover:bg-surface-container-low/40 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center font-bold text-xs text-on-surface">
                                                <?= mb_strtoupper(mb_substr($cust['name'], 0, 1)) ?>
                                            </div>
                                            <a href="/admin/clients/<?= (int) $cust['id'] ?>" class="font-bold text-sm text-primary hover:underline">
                                                <?= htmlspecialchars($cust['name']) ?>
                                            </a>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-surface-container text-on-surface">
                                            <?= (int) $cust['orders_count'] ?> cmd
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs pt-1 border-t border-border/40">
                                        <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-1 text-[#25D366] font-semibold">
                                            <span class="material-symbols-outlined text-[16px]">chat</span>
                                            <?= htmlspecialchars($cust['whatsapp']) ?>
                                        </a>
                                        <span class="font-bold text-sm text-emerald-700">
                                            <?= number_format((float)$cust['total_spent'], 0, ',', ' ') ?> FCFA
                                        </span>
                                    </div>

                                    <div class="text-[11px] text-outline">
                                        <?= htmlspecialchars(($cust['city'] ?? 'Douala') . (!empty($cust['district']) ? ' (' . $cust['district'] . ')' : '')) ?>
                                        <?php if (!empty($cust['address'])): ?>
                                            — <span class="italic"><?= htmlspecialchars($cust['address']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <a href="/admin/clients/<?= (int) $cust['id'] ?>" class="w-full py-2.5 rounded-xl bg-surface-container-high text-on-surface text-xs font-semibold text-center hover:bg-surface-container-highest transition-colors min-h-[44px] flex items-center justify-center border border-border mt-1">
                                        Voir la fiche client & ses commandes &rarr;
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Vue Tableau Desktop (>= md) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low text-xs font-semibold uppercase text-outline border-b border-border">
                                <th class="py-3 px-4">Client</th>
                                <th class="py-3 px-4">WhatsApp Direct</th>
                                <th class="py-3 px-4">Ville & Quartier</th>
                                <th class="py-3 px-4">Adresse précise</th>
                                <th class="py-3 px-4 text-center">Commandes</th>
                                <th class="py-3 px-4 text-right">Volume dépensé</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm text-on-surface">
                            <?php if (empty($customers)): ?>
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-outline">
                                        Aucun client enregistré pour l'instant.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($customers as $cust): ?>
                                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                                        <td class="py-3 px-4 font-semibold text-primary">
                                            <a href="/admin/clients/<?= (int) $cust['id'] ?>" class="hover:underline flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-surface-container flex items-center justify-center font-bold text-xs text-on-surface">
                                                    <?= mb_strtoupper(mb_substr($cust['name'], 0, 1)) ?>
                                                </div>
                                                <?= htmlspecialchars($cust['name']) ?>
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 font-mono text-xs">
                                            <?php 
                                                $clean = preg_replace('/[^0-9]/', '', (string)$cust['whatsapp']);
                                                $waUrl = "https://wa.me/" . $clean;
                                            ?>
                                            <a href="<?= $waUrl ?>" target="_blank" class="inline-flex items-center gap-1 text-[#25D366] hover:underline font-semibold">
                                                <span class="material-symbols-outlined text-[15px]">chat</span>
                                                <?= htmlspecialchars($cust['whatsapp']) ?>
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 text-xs text-outline">
                                            <?= htmlspecialchars(($cust['city'] ?? 'Douala') . (!empty($cust['district']) ? ' (' . $cust['district'] . ')' : '')) ?>
                                        </td>
                                        <td class="py-3 px-4 text-xs text-outline max-w-xs truncate">
                                            <?= htmlspecialchars($cust['address'] ?? 'Non renseignée') ?>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container text-on-surface">
                                                <?= (int) $cust['orders_count'] ?>
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 font-bold text-right text-emerald-700">
                                            <?= number_format((float)$cust['total_spent'], 0, ',', ' ') ?> FCFA
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="/admin/clients/<?= (int) $cust['id'] ?>" class="inline-flex items-center gap-1 bg-surface-container-high text-on-surface px-3 py-1.5 rounded-xl text-xs font-semibold hover:bg-surface-container-highest transition-all border border-border min-h-[36px]">
                                                Fiche & Commandes &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (($total_pages ?? 1) > 1): ?>
                        <div class="p-space-md border-t border-border flex items-center justify-between text-xs text-outline">
                            <span>Page <?= (int)($current_page ?? 1) ?> sur <?= (int)$total_pages ?></span>
                            <div class="flex items-center gap-1">
                                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                    <a href="?page=<?= $p ?>&search=<?= urlencode((string)($current_search ?? '')) ?>" class="px-2.5 py-1 rounded-lg border border-border <?= ($p === ($current_page ?? 1)) ? 'bg-primary text-white font-bold' : 'hover:bg-surface-container-low' ?>">
                                        <?= $p ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
