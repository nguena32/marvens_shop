<!-- Barre de navigation inférieure pour Smartphone & Tactile compact -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-surface/95 backdrop-blur-md border-t border-border z-30 flex items-center justify-around px-2 pb-[env(safe-area-inset-bottom,0px)] shadow-[0_-4px_12px_rgba(0,0,0,0.03)]">
    <a href="/admin/dashboard" 
       class="flex flex-col items-center justify-center flex-1 py-1 min-h-[48px] rounded-xl transition-all <?= ($active_tab ?? '') === 'dashboard' ? 'text-primary font-bold' : 'text-outline hover:text-on-surface' ?>">
        <span class="material-symbols-outlined text-[22px] <?= ($active_tab ?? '') === 'dashboard' ? 'scale-110' : '' ?>">dashboard</span>
        <span class="text-[10px] tracking-tight mt-0.5">Accueil</span>
    </a>

    <a href="/admin/commandes" 
       class="flex flex-col items-center justify-center flex-1 py-1 min-h-[48px] rounded-xl relative transition-all <?= ($active_tab ?? '') === 'orders' ? 'text-primary font-bold' : 'text-outline hover:text-on-surface' ?>">
        <div class="relative">
            <span class="material-symbols-outlined text-[22px] <?= ($active_tab ?? '') === 'orders' ? 'scale-110' : '' ?>">shopping_bag</span>
            <?php if (($pending_orders ?? 0) > 0): ?>
                <span class="absolute -top-1 -right-2 text-[9px] font-bold bg-amber-500 text-white rounded-full px-1 min-w-[14px] text-center"><?= (int)$pending_orders ?></span>
            <?php endif; ?>
        </div>
        <span class="text-[10px] tracking-tight mt-0.5">Commandes</span>
    </a>

    <a href="/admin/produits" 
       class="flex flex-col items-center justify-center flex-1 py-1 min-h-[48px] rounded-xl transition-all <?= ($active_tab ?? '') === 'products' ? 'text-primary font-bold' : 'text-outline hover:text-on-surface' ?>">
        <span class="material-symbols-outlined text-[22px] <?= ($active_tab ?? '') === 'products' ? 'scale-110' : '' ?>">inventory_2</span>
        <span class="text-[10px] tracking-tight mt-0.5">Catalogue</span>
    </a>

    <a href="/admin/clients" 
       class="flex flex-col items-center justify-center flex-1 py-1 min-h-[48px] rounded-xl transition-all <?= ($active_tab ?? '') === 'customers' ? 'text-primary font-bold' : 'text-outline hover:text-on-surface' ?>">
        <span class="material-symbols-outlined text-[22px] <?= ($active_tab ?? '') === 'customers' ? 'scale-110' : '' ?>">group</span>
        <span class="text-[10px] tracking-tight mt-0.5">Clients</span>
    </a>

    <button type="button" 
            onclick="toggleAdminSidebar(true)" 
            class="flex flex-col items-center justify-center flex-1 py-1 min-h-[48px] rounded-xl text-outline hover:text-on-surface transition-all"
            aria-label="Plus d'options">
        <span class="material-symbols-outlined text-[22px]">menu</span>
        <span class="text-[10px] tracking-tight mt-0.5">Plus</span>
    </button>
</nav>
