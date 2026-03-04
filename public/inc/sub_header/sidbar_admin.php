<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" navigation-header"><span>Général</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Général"></i>
                </li>
                <li class=" nav-item"><a href="<?= RACINE?>admin"><i class="feather icon-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="<?= RACINE?>admin" data-i18n="eCommerce"><i class="feather icon-bar-chart"></i> Tableau de bord</a>
                        </li>
                    </ul>
                </li>

                <li class=" navigation-header"><span>Gestion</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Gestion"></i>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Templates">Utilisateurs</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/users" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des utilisateurs</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-package"></i><span class="menu-title" data-i18n="Templates">Menu</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/plats" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des plats</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-shopping-cart"></i><span class="menu-title" data-i18n="Templates">Commandes</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/commandes" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des commandes</a>
                        </li>
                    </ul>

                <li class=" nav-item"><a href="#"><i class="feather icon-truck"></i><span class="menu-title" data-i18n="Templates">Livraisons</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/livraison-assignation" data-i18n="Vertical"> <i class="feather icon-user-plus"></i> Assignation des livraisons</a>
                        </li>
                    </ul>
                </li>

                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-users"></i><span class="menu-title" data-i18n="Templates">Clients</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/clients" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des clients</a>
                        </li>
                    </ul>
                </li>

                <li class=" navigation-header"><span>Configuration</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Configuration"></i>
                </li>

                <li class=" nav-item"><a href="<?=RACINE?>admin/settings"><i class="feather icon-settings"></i><span class="menu-title" data-i18n="Templates">Paramètres</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/settings" data-i18n="Vertical"> <i class="feather icon-sliders"></i> Configuration</a>
                        </li>
                    </ul>
                </li>

                <li class=" navigation-header"><span>Compte</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="Compte"></i>
                </li>
              
                <li class=" nav-item"><a href="<?= RACINE ?>user/profil"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Documentation">Mon profil</span></a>
                </li>
            </ul>
        </div>
    </div>
