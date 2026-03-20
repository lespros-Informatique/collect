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

                <li class=" nav-item"><a href="#"><i class="feather icon-tag"></i><span class="menu-title" data-i18n="Templates">Catégories</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/categories" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des catégories</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-gift"></i><span class="menu-title" data-i18n="Templates">Kits</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/kits" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des kits</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-layers"></i><span class="menu-title" data-i18n="Templates">Familles</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/familles" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des familles</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-box"></i><span class="menu-title" data-i18n="Templates">Articles</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/articles" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des articles</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-user-plus"></i><span class="menu-title" data-i18n="Templates">Inscriptions</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/inscriptions" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des inscriptions</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-dollar-sign"></i><span class="menu-title" data-i18n="Templates">Paiements</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/paiements" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des paiements</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-trending-up"></i><span class="menu-title" data-i18n="Templates">Versements</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/versements" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des versements</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Templates">Clients</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/clients" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des clients</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-download"></i><span class="menu-title" data-i18n="Templates">Retraits</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/retraits" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des retraits</a>
                        </li>
                    </ul>
                </li>

                <li class=" nav-item"><a href="#"><i class="feather icon-file-text"></i><span class="menu-title" data-i18n="Templates">Demandes</span></a>
                    <ul class="menu-content">
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/demandes" data-i18n="Vertical"> <i class="feather icon-list"></i> Liste des demandes</a>
                        </li>
                         <li>
                        <a class="menu-item" href="<?=RACINE?>admin/demandes/stocks" data-i18n="Vertical"> <i class="feather icon-cubes"></i> Gestion des stocks</a>
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
