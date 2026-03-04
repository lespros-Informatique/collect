  <!-- BEGIN: Header-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-light bg-gradient-x-grey-blue">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="<?=RACINE?>admin">
                        <!-- logo -->
                        <span style="position: relative; bottom:12px;" ><img src="<?= LOGO ?>" weight="50" height="50"></span>
                        <!-- logo -->
                        <h4 class="brand-text" style="position: relative; bottom:12px;"><?=APP_NAME?></h4>
                        </a>
                    </li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                    
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu"></i></a></li>
                        <li class="dropdown nav-item mega-dropdown d-none d-lg-block"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Accès Rapide</a>
                            <ul class="mega-dropdown-menu dropdown-menu row p-1">
                                <li class="col-md-4 bg-mega p-2">
                                    <h3 class="text-white mb-1 font-weight-bold">Gestion Restaurant</h3>
                                    <p class="text-white line-height-2">Accédez rapidement aux fonctionnalités principales de gestion de votre restaurant.</p>
                                    <a href="<?=RACINE?>admin" class="btn btn-outline-white">Tableau de bord</a>
                                </li>
                                <li class="col-md-8 px-2">
                                    <h6 class="font-weight-bold font-medium-2 ml-1">Modules</h6>
                                    <ul class="row mt-2">
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3" href="<?=RACINE?>admin/plats"><i class="feather icon-package font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Menu</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3" href="<?=RACINE?>admin/commandes"><i class="feather icon-shopping-cart font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Commandes</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mb-xl-3 mt-75 mt-xl-0" href="<?=RACINE?>admin/clients"><i class="feather icon-users font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-0">Clients</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0" href="<?=RACINE?>admin/users"><i class="feather icon-user-check font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Utilisateurs</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0" href="<?=RACINE?>admin/settings"><i class="feather icon-settings font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Paramètres</p>
                                            </a></li>
                                        <li class="col-6 col-xl-4"><a class="text-center mb-2 mt-75 mt-xl-0" href="<?=RACINE?>user/profil"><i class="feather icon-user font-large-1 mr-0"></i>
                                                <p class="font-medium-2 mt-25 mb-50">Mon Profil</p>
                                            </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <!-- begin notifications -->
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">0</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag badge badge-primary float-right m-0">0 Nouveau</span></h6>
                                </li>
                                <li class="scrollable-container media-list"><a href="javascript:void(0)">
                                        <div class="media">
                                            <div class="media-left align-self-center"><i class="feather icon-info icon-bg-circle bg-cyan"></i></div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Aucune notification</h6>
                                                <p class="notification-text font-small-3 text-muted">Vous n'avez aucune nouvelle notification pour le moment.</p><small>
                                                    <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Maintenant</time></small>
                                            </div>
                                        </div>
                                    </a>
                                    </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="<?=RACINE?>admin">Voir toutes les notifications</a></li>
                            </ul>
                        </li>
                      <!-- end notifications -->
                          <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="<?=RACINE?>app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i>

                                    </i>
                                </div>
                                    <span class="user-name"><?=USER_NAME?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="<?= RACINE ?>user/profil">
                                    <i class="feather icon-user"></i> Mon Profil
                                </a>
                                <a class="dropdown-item" href="<?=RACINE?>admin/settings">
                                    <i class="feather icon-settings"></i> Paramètres
                                </a>
                                    
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= RACINE ?>user/decon">
                                    <i class="feather icon-power"></i> Déconnexion
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->
