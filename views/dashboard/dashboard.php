    <?php require_once '../public/inc/header.php'; ?>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Grouped multiple cards for statistics starts here -->
                <div class="row grouped-multiple-statistics-card">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title ">
                                    <span class="text-uppercase">Statistiques du Restaurant</span>

                                    <span style="cursor:pointer" class="badge badge-primary ml-2"  data-toggle="modal" data-target="#calendarActive">Aujourd'hui</span>
                                </h4>
                                <a class="heading-elements-toggle"><i class="feather icon-printer font-medium-3 btn btn-round btn-primary btn-sm"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <span>
                                            <a href="<?= RACINE ?>pdf/pdf-general" target="_blank" class="btn btn-primary pull-right" ><i class="feather icon-printer"></i> PDF</a>
                                        </span>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon primary d-flex justify-content-center mr-3">
                                                <i class="fa fa-utensils font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalPlats ?? 0; ?></h3>
                                                <p class="sub-heading">Total Plats</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>admin/plats"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-plats" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon dark d-flex justify-content-center mr-3">
                                                <i class="fa fa-shopping-cart font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalCommandes ?? 0 ?></h3>
                                                <p class="sub-heading">Total Commandes</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger "><a href="<?=RACINE; ?>admin/commandes"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-commandes" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon success d-flex justify-content-center mr-3">
                                                <i class="fa fa-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $totalClients ?? 0 ?> </h3>
                                                <p class="sub-heading">Total Clients</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>admin/clients"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-clients" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
       
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <span class="card-icon success d-flex justify-content-center mr-3">
                                                        <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                                    </span>
                                                    <div class="stats-amount mr-3">
                                                        <h3 class="heading-text text-bold-600"><?= $stats['active_members'] ?? 0; ?></h3>
                                                        <p class="sub-heading">Membres Actifs</p>
                                                    </div>
                                                    <span class="inc-dec-percentage">
                                                        <small class="success"><a href="<?=RACINE; ?>admin/users"><i class="fa fa-eye"></i></a> </small>
                                                        <a href="<?= RACINE ?>pdf/pdf-utilisateurs" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start">
                                            <span class="card-icon warning d-flex justify-content-center mr-3">
                                                <i class="fa fa-euro-sign font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= number_format($revenusAujourdhui ?? 0, 0, ',', ' '); ?> FCFA</h3>
                                                <p class="sub-heading">Revenus Aujourd'hui</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger"><a href="<?=RACINE; ?>commande/list"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-revenus" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon secondary d-flex justify-content-center mr-3">
                                                <i class="fa fa-shopping-cart font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $commandesAujourdhui ?? 0 ?> </h3>
                                                <p class="sub-heading">Commandes Aujourd'hui</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>commande/list"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-commandes-aujourdhui" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Grouped multiple cards for statistics ends here -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
	<?php require_once '../public/inc/footer.php'; ?>
