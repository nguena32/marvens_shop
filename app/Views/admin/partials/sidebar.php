<!-- Aside Sidebar conforme au design Swiss Editorial Commerce -->
<aside class="fixed left-0 top-0 h-full w-72 bg-surface border-r border-border z-50 flex flex-col pt-space-lg pb-space-lg">
    <div class="px-space-lg mb-space-lg flex items-center gap-space-sm">
        <div class="h-9 w-9 rounded-lg bg-primary text-on-primary flex items-center justify-center font-bold text-lg tracking-wider">
            M
        </div>
        <span class="font-headline-md text-on-surface tracking-tight">Marvens Shop</span>
    </div>
    
    <nav class="flex-1 px-space-md space-y-space-xs">
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'dashboard' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' ?> transition-all" href="/admin/dashboard">
            <span class="material-symbols-outlined mr-space-md">dashboard</span>Tableau de bord
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'products' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' ?> transition-all" href="/admin/produits">
            <span class="material-symbols-outlined mr-space-md">inventory_2</span>Catalogue
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'orders' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' ?> transition-all" href="/admin/commandes">
            <span class="material-symbols-outlined mr-space-md">shopping_bag</span>Commandes
            <?php if (($pending_orders ?? 0) > 0): ?>
                <span class="ml-auto text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded-full"><?= (int) $pending_orders ?></span>
            <?php endif; ?>
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'import' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' ?> transition-all" href="/admin/import">
            <span class="material-symbols-outlined mr-space-md">cloud_download</span>Importations
        </a>
        <a class="flex items-center px-space-md py-space-sm rounded-xl <?= ($active_tab ?? '') === 'themes' ? 'bg-secondary-container text-on-secondary-container font-medium' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' ?> transition-all" href="/admin/themes">
            <span class="material-symbols-outlined mr-space-md">palette</span>Thèmes & Apparence
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
