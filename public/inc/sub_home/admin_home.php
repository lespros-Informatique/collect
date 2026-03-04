    <?php require_once '../public/inc/header.php'; ?>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Grouped multiple cards for statistics starts here -->
                <div class="row grouped-multiple-statistics-card">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title ">
                                    <span class="text-uppercase">Statistiques des membres</span>
                                    
                                    <span style="cursor:pointer" class="badge badge-primary ml-2"  data-toggle="modal" data-target="#calendarActive"><?= "ANNEE"; ?></span>
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
                            <?php require_once 'calendar.php'; ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon primary d-flex justify-content-center mr-3">
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalMembre ?? 0; ?></h3>
                                                <p class="sub-heading">Total Membre</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>user/membre"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-membre" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon dark d-flex justify-content-center mr-3">
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalRespo ?? 0 ?></h3>
                                                <p class="sub-heading">Total Responsable</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger "><a href="<?=RACINE; ?>user/respo"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-respo" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
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
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $totalActif ?? 0 ?> </h3>
                                                <p class="sub-heading">Total Actif</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>user/list"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-actif" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start">
                                            <span class="card-icon danger d-flex justify-content-center mr-3">
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalInactif ?? 0; ?></h3>
                                                <p class="sub-heading">Total Inactif</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger"><a href="<?=RACINE; ?>user/inactif"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-inactif" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            
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
                                            <span class="card-icon warning d-flex justify-content-center mr-3">
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"><?= $totalGars ?? 0; ?></h3>
                                                <p class="sub-heading">Total Garçon</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="danger"><a href="<?=RACINE; ?>user/garcon"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-garcon" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-xl-6 col-sm-6 col-12">
                                        <div class="d-flex align-items-start border-right-blue-grey border-right-lighten-5">
                                            <span class="card-icon secondary d-flex justify-content-center mr-3">
                                                <i class="feather icon-users font-large-2 customize-icon font-large-2 p-1"></i>
                                            </span>
                                            <div class="stats-amount mr-3">
                                                <h3 class="heading-text text-bold-600"> <?= $totalGos ?? 0 ?> </h3>
                                                <p class="sub-heading">Total Fille</p>
                                            </div>
                                            <span class="inc-dec-percentage">
                                                <small class="success"><a href="<?=RACINE; ?>user/fille"><i class="fa fa-eye"></i></a> </small>
                                                <a href="<?= RACINE ?>pdf/pdf-fille" target="_blank" class="pull-right btn-sm" ><i class="feather icon-printer font-medium-3 "></i></a>
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
