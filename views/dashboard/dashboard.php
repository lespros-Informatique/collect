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
                                    <span class="text-uppercase">Statistiques du Système de Collecte</span>

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
                                                <i class="fa fa-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalClients ?? 0; ?></h3>
                                                <p class="sub-heading">Total Clients</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>admin/clients"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-clients" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon dark d-flex justify-content-center mr-3">
                                                <i class="fa fa-user-plus font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalInscriptions ?? 0 ?></h3>
                                                <p class="sub-heading">Total Inscriptions</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger "><a href="<?=RACINE; ?>admin/inscriptions"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-inscriptions" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
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
                                                <i class="fa fa-tags font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $totalCategories ?? 0 ?> </h3>
                                                <p class="sub-heading">Total Catégories</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>admin/categories"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-categories" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex align-items-start">
                                                    <span class="card-icon success d-flex justify-content-center mr-3">
                                                        <i class="feather icon-gift font-large-2 customize-icon font-large-2 p-1"></i>
                                                    </span>
                                                    <span class="stats-amount mr-3">
                                                        <h3 class="heading-text text-bold-600"><?= $totalKits ?? 0; ?></h3>
                                                        <p class="sub-heading">Total Kits</p>
                                                    </span>
                                                    <span class="inc-dec-percentage">
                                                        <small class="success"><a href="<?=RACINE; ?>admin/kits"><i class="fa fa-eye"></i></a> </small>
                                                        <a href="<?= RACINE ?>pdf/pdf-kits" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
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
                                                <i class="fa fa-dollar-sign font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= number_format($revenusAujourdhui ?? 0, 0, ',', ' '); ?> FCFA</h3>
                                                <p class="sub-heading">Paiements Aujourd'hui</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger"><a href="<?=RACINE; ?>admin/paiements"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-paiements" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon secondary d-flex justify-content-center mr-3">
                                                <i class="fa fa-file-text font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $paiementsAujourdhui ?? 0 ?> </h3>
                                                <p class="sub-heading">Nombre de Paiements Aujourd'hui</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>admin/paiements"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-paiements-aujourdhui" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
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
                                        <div class="d-flex align-items-start">
                                            <span class="card-icon info d-flex justify-content-center mr-3">
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $inscriptionsAujourdhui ?? 0; ?></h3>
                                                <p class="sub-heading">Inscriptions Aujourd'hui</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>admin/inscriptions"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-inscriptions-aujourdhui" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon danger d-flex justify-content-center mr-3">
                                                <i class="feather icon-download font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $totalRetraits ?? 0 ?> </h3>
                                                <p class="sub-heading">Total Retraits</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger"><a href="<?=RACINE; ?>admin/retraits"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-retraits" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
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
