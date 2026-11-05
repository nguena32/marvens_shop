<header class="fixed top-0 left-72 right-0 h-16 bg-surface/80 backdrop-blur-xl border-b border-border z-40 flex items-center justify-between px-space-lg">
    <div class="flex items-center gap-space-md w-96">
        <span class="material-symbols-outlined text-outline">search</span>
        <input class="w-full bg-transparent text-body-md text-on-surface placeholder:text-outline focus:outline-none" placeholder="Rechercher commandes, clients, produits..." type="text"/>
    </div>
    <div class="flex items-center gap-space-md">
        <a href="/admin/commandes?status=pending" class="relative p-space-xs text-on-surface-variant hover:text-on-surface" title="Commandes en attente">
            <span class="material-symbols-outlined">notifications</span>
            <?php if (($pending_orders ?? 0) > 0): ?>
                <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-secondary"></span>
            <?php endif; ?>
        </a>
        <a href="/admin/produits/nouveau" class="bg-primary text-on-primary px-space-md py-1.5 rounded-lg text-label-sm font-medium hover:bg-surface-container-high hover:text-on-surface transition-all flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">add</span> Nouveau Produit
        </a>
        <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center cursor-pointer" title="Administrateur">
            <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
        </div>
    </div>
</header>
