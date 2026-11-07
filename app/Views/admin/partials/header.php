<header class="fixed top-0 left-0 md:left-72 right-0 h-16 bg-surface/90 backdrop-blur-xl border-b border-border z-30 flex items-center justify-between px-3 sm:px-space-md md:px-space-lg transition-all duration-300">
    <!-- Partie Gauche : Bouton Hamburger Mobile + Recherche -->
    <div class="flex items-center gap-2 sm:gap-space-md flex-1 max-w-lg">
        <button type="button" 
                onclick="toggleAdminSidebar(true)" 
                class="md:hidden p-2 -ml-1 text-on-surface hover:bg-surface-container rounded-xl flex items-center justify-center min-h-[44px] min-w-[44px]"
                aria-label="Ouvrir le menu de navigation">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>

        <form method="GET" action="/admin/commandes" class="flex items-center gap-2 w-full bg-surface-container-low px-3 py-1.5 rounded-xl border border-border focus-within:border-primary transition-all">
            <span class="material-symbols-outlined text-outline text-[20px] shrink-0">search</span>
            <input class="w-full bg-transparent text-sm text-on-surface placeholder:text-outline focus:outline-none" 
                   name="search" 
                   placeholder="Rechercher commandes, clients..." 
                   type="text"/>
        </form>
    </div>

    <!-- Partie Droite : Notifications, Raccourci Produit, Profil -->
    <div class="flex items-center gap-1.5 sm:gap-space-md shrink-0 ml-2">
        <a href="/admin/commandes?status=pending" 
           class="relative p-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container rounded-xl min-h-[44px] min-w-[44px] flex items-center justify-center transition-colors" 
           title="Commandes en attente">
            <span class="material-symbols-outlined text-[22px]">notifications</span>
            <?php if (($pending_orders ?? 0) > 0): ?>
                <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-secondary ring-2 ring-surface animate-pulse"></span>
            <?php endif; ?>
        </a>

        <a href="/admin/produits/nouveau" 
           class="bg-primary text-white px-3 sm:px-space-md py-2 rounded-xl text-xs sm:text-label-sm font-semibold hover:opacity-90 transition-all flex items-center gap-1 min-h-[40px] shadow-sm">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span class="hidden sm:inline">Nouveau Produit</span>
        </a>

        <a href="/admin/parametres/utilisateurs" 
           class="w-10 h-10 rounded-xl bg-surface-container border border-border flex items-center justify-center cursor-pointer text-on-surface hover:bg-surface-container-high transition-colors min-h-[40px] min-w-[40px]" 
           title="Profil Administrateur">
            <span class="material-symbols-outlined text-[20px]">person</span>
        </a>
    </div>
</header>
