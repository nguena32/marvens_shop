<!-- Aside Sidebar conforme au design Swiss Editorial Commerce -->
<aside class="fixed left-0 top-0 h-full w-72 bg-surface border-r border-border z-50 flex flex-col pt-space-lg pb-space-lg">
    <div class="px-space-lg mb-space-lg flex items-center gap-space-sm">
        <?php 
            $settingsHelper = new \App\Application\Services\SettingsService();
            $adminShopInfo = $settingsHelper->getShopInfo();
        ?>
        <?php if (!empty($adminShopInfo['logo_url'])): ?>
            <img src="<?= htmlspecialchars(str_starts_with($adminShopInfo['logo_url'], 'http') ? $adminShopInfo['logo_url'] : '/' . ltrim($adminShopInfo['logo_url'], '/')) ?>" 
                 alt="<?= htmlspecialchars($adminShopInfo['shop_name'] ?? 'Marvens Shop') ?>" 
                 class="h-9 max-w-[120px] object-contain rounded-lg"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"/>
            <div class="h-9 w-9 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-lg tracking-wider" style="display:none;">
                <?= strtoupper(substr($adminShopInfo['shop_name'] ?? 'M', 0, 1)) ?>
            </div>
        <?php else: ?>
            <div class="h-9 w-9 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-lg tracking-wider">
                <?= strtoupper(substr($adminShopInfo['shop_name'] ?? 'M', 0, 1)) ?>
            </div>
        <?php endif; ?>
        <span class="font-headline-md text-on-surface tracking-tight truncate"><?= htmlspecialchars($adminShopInfo['shop_name'] ?? 'Marvens Shop') ?></span>
    </div>
    
    <nav class="flex-1 px-space-md space-y-space-xs">
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'dashboard' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/dashboard">
            <span class="material-symbols-outlined mr-space-md">dashboard</span>Tableau de bord
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'products' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/produits">
            <span class="material-symbols-outlined mr-space-md">inventory_2</span>Catalogue
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'categories' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/categories">
            <span class="material-symbols-outlined mr-space-md">folder</span>Catégories
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'orders' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/commandes">
            <span class="material-symbols-outlined mr-space-md">shopping_bag</span>Commandes
            <?php if (($pending_orders ?? 0) > 0): ?>
                <span class="ml-auto text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded-full"><?= (int) $pending_orders ?></span>
            <?php endif; ?>
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'customers' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/clients">
            <span class="material-symbols-outlined mr-space-md">group</span>Clients
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'statistics' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/statistiques">
            <span class="material-symbols-outlined mr-space-md">insights</span>Statistiques
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'import' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all" href="/admin/import">
            <span class="material-symbols-outlined mr-space-md">cloud_download</span>Importations
        </a>
        <div class="pt-2 pb-1 px-space-md text-[11px] font-semibold tracking-wider text-outline uppercase">Paramètres Boutique</div>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_shop' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/boutique">
            <span class="material-symbols-outlined mr-space-md text-[20px]">store</span>Informations Boutique
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'themes' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/themes">
            <span class="material-symbols-outlined mr-space-md text-[20px]">palette</span>Thèmes & Modèles
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'appearance' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/apparence">
            <span class="material-symbols-outlined mr-space-md text-[20px]">format_paint</span>Couleurs & Style
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'typography' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/typographie">
            <span class="material-symbols-outlined mr-space-md text-[20px]">match_case</span>Polices d'écriture
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_delivery' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/livraison">
            <span class="material-symbols-outlined mr-space-md text-[20px]">local_shipping</span>Livraison & Retrait
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_users' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/utilisateurs">
            <span class="material-symbols-outlined mr-space-md text-[20px]">group</span>Utilisateurs & Rôles
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_notifications' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/notifications">
            <span class="material-symbols-outlined mr-space-md text-[20px]">notifications</span>Notifications
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_integrations' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/integrations">
            <span class="material-symbols-outlined mr-space-md text-[20px]">hub</span>Applications & API
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_security' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/securite">
            <span class="material-symbols-outlined mr-space-md text-[20px]">shield</span>Sécurité & Audit
        </a>
        <a class="flex items-center px-space-md py-space-xs rounded-xl <?= ($active_tab ?? '') === 'settings_analytics' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:opacity-90' ?> transition-all text-sm" href="/admin/parametres/analytics">
            <span class="material-symbols-outlined mr-space-md text-[20px]">query_stats</span>Analytics & Pixel
        </a>
    </nav>
    
    <div class="px-space-md mb-space-md">
        <form method="POST" action="/admin/logout">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
            <button type="submit" class="w-full flex items-center px-space-md py-space-sm rounded-xl text-error hover:bg-error-container hover:text-on-error-container transition-all text-label-md font-medium">
                <span class="material-symbols-outlined mr-space-md">logout</span>Déconnexion
            </button>
        </form>
    </div>

    <div class="px-space-lg pt-space-md border-t border-border flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-label-sm text-on-surface-variant">Boutique Ouverte</span>
        </div>
        <a href="/" target="_blank" class="text-xs text-outline hover:text-on-surface flex items-center gap-1" title="Voir la boutique en ligne">
            <span class="material-symbols-outlined text-[16px]">visibility</span>
        </a>
    </div>
</aside>
