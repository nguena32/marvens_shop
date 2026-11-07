<!-- Aside Sidebar conforme au design Swiss Editorial Commerce & Responsive Drawer -->
<!-- Backdrop mobile / tablette -->
<div id="sidebar-backdrop" 
     class="fixed inset-0 bg-black/50 z-40 hidden md:hidden backdrop-blur-xs transition-opacity duration-300 opacity-0"
     onclick="toggleAdminSidebar(false)"></div>

<aside id="admin-sidebar" 
       class="fixed left-0 top-0 h-full w-72 bg-surface border-r border-border z-50 flex flex-col pt-space-md pb-space-lg transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 shadow-2xl md:shadow-none">
    
    <div class="px-space-lg mb-space-md flex items-center justify-between">
        <div class="flex items-center gap-space-sm min-w-0">
            <?php 
                $settingsHelper = new \App\Application\Services\SettingsService();
                $adminShopInfo = $settingsHelper->getShopInfo();
            ?>
            <?php if (!empty($adminShopInfo['logo_url'])): ?>
                <img src="<?= htmlspecialchars(str_starts_with($adminShopInfo['logo_url'], 'http') ? $adminShopInfo['logo_url'] : '/' . ltrim($adminShopInfo['logo_url'], '/')) ?>" 
                     alt="<?= htmlspecialchars($adminShopInfo['shop_name'] ?? 'Marvens Shop') ?>" 
                     class="h-9 max-w-[110px] object-contain rounded-lg shrink-0"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"/>
                <div class="h-9 w-9 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-lg tracking-wider shrink-0" style="display:none;">
                    <?= strtoupper(substr($adminShopInfo['shop_name'] ?? 'M', 0, 1)) ?>
                </div>
            <?php else: ?>
                <div class="h-9 w-9 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-lg tracking-wider shrink-0">
                    <?= strtoupper(substr($adminShopInfo['shop_name'] ?? 'M', 0, 1)) ?>
                </div>
            <?php endif; ?>
            <span class="font-headline-md text-on-surface tracking-tight truncate font-bold text-base"><?= htmlspecialchars($adminShopInfo['shop_name'] ?? 'Marvens Shop') ?></span>
        </div>
        <!-- Bouton fermer tiroir mobile -->
        <button type="button" 
                onclick="toggleAdminSidebar(false)" 
                class="md:hidden p-2 rounded-xl text-outline hover:text-on-surface hover:bg-surface-container transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center"
                aria-label="Fermer le menu">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
    </div>
    
    <nav class="flex-1 px-space-md space-y-1 overflow-y-auto overscroll-contain">
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'dashboard' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/dashboard">
            <span class="material-symbols-outlined mr-space-md text-[20px]">dashboard</span>Tableau de bord
        </a>
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'products' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/produits">
            <span class="material-symbols-outlined mr-space-md text-[20px]">inventory_2</span>Catalogue
        </a>
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'categories' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/categories">
            <span class="material-symbols-outlined mr-space-md text-[20px]">folder</span>Catégories
        </a>
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'orders' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/commandes">
            <span class="material-symbols-outlined mr-space-md text-[20px]">shopping_bag</span>Commandes
            <?php if (($pending_orders ?? 0) > 0): ?>
                <span class="ml-auto text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded-full"><?= (int) $pending_orders ?></span>
            <?php endif; ?>
        </a>
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'customers' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/clients">
            <span class="material-symbols-outlined mr-space-md text-[20px]">group</span>Clients
        </a>
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'statistics' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/statistiques">
            <span class="material-symbols-outlined mr-space-md text-[20px]">insights</span>Statistiques
        </a>
        <a class="flex items-center px-space-md py-2.5 rounded-xl min-h-[44px] <?= ($active_tab ?? '') === 'import' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all" href="/admin/import">
            <span class="material-symbols-outlined mr-space-md text-[20px]">cloud_download</span>Importations
        </a>
        
        <div class="pt-3 pb-1 px-space-md text-[11px] font-semibold tracking-wider text-outline uppercase">Paramètres Boutique</div>
        
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_shop' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/boutique">
            <span class="material-symbols-outlined mr-space-md text-[18px]">store</span>Informations Boutique
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'themes' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/themes">
            <span class="material-symbols-outlined mr-space-md text-[18px]">palette</span>Thèmes & Modèles
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'appearance' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/apparence">
            <span class="material-symbols-outlined mr-space-md text-[18px]">format_paint</span>Couleurs & Style
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'typography' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/typographie">
            <span class="material-symbols-outlined mr-space-md text-[18px]">match_case</span>Polices d'écriture
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_delivery' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/livraison">
            <span class="material-symbols-outlined mr-space-md text-[18px]">local_shipping</span>Livraison & Retrait
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_users' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/utilisateurs">
            <span class="material-symbols-outlined mr-space-md text-[18px]">group</span>Utilisateurs & Rôles
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_notifications' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/notifications">
            <span class="material-symbols-outlined mr-space-md text-[18px]">notifications</span>Notifications
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_integrations' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/integrations">
            <span class="material-symbols-outlined mr-space-md text-[18px]">hub</span>Applications & API
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_security' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/securite">
            <span class="material-symbols-outlined mr-space-md text-[18px]">shield</span>Sécurité & Audit
        </a>
        <a class="flex items-center px-space-md py-2 rounded-xl min-h-[40px] <?= ($active_tab ?? '') === 'settings_analytics' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' ?> transition-all text-sm" href="/admin/parametres/analytics">
            <span class="material-symbols-outlined mr-space-md text-[18px]">query_stats</span>Analytics & Pixel
        </a>
    </nav>
    
    <div class="px-space-md my-space-sm">
        <form method="POST" action="/admin/logout">
            <input type="hidden" name="_csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
            <button type="submit" class="w-full flex items-center px-space-md py-2 rounded-xl text-error hover:bg-error-container hover:text-on-error-container transition-all text-label-md font-medium min-h-[44px]">
                <span class="material-symbols-outlined mr-space-md text-[20px]">logout</span>Déconnexion
            </button>
        </form>
    </div>

    <div class="px-space-lg pt-space-sm border-t border-border flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-label-sm text-on-surface-variant">Boutique Ouverte</span>
        </div>
        <a href="/" target="_blank" class="p-1.5 rounded-lg text-outline hover:text-on-surface hover:bg-surface-container transition-colors flex items-center justify-center min-h-[36px] min-w-[36px]" title="Voir la boutique en ligne">
            <span class="material-symbols-outlined text-[18px]">visibility</span>
        </a>
    </div>
</aside>

<script>
    function toggleAdminSidebar(open) {
        var sidebar = document.getElementById('admin-sidebar');
        var backdrop = document.getElementById('sidebar-backdrop');
        if (!sidebar || !backdrop) return;
        
        var willOpen = (typeof open === 'boolean') ? open : sidebar.classList.contains('-translate-x-full');
        
        if (willOpen) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            setTimeout(function() {
                backdrop.classList.remove('opacity-0');
            }, 10);
            document.body.classList.add('overflow-hidden', 'md:overflow-auto');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0');
            setTimeout(function() {
                backdrop.classList.add('hidden');
            }, 300);
            document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
        }
    }
</script>
