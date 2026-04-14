    <?php require_once '../public/inc/header.php'; ?>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="" class="retour">campagne</a>
                                </li>
                                <li class="breadcrumb-item active">liste
                                </li>
                            </ol>
                        </div>
                    </div>
                    <!-- <h3 class="content-header-title mb-0">Print Datatable</h3> -->
                </div>
                <!-- <div class="content-header-right col-md-6 col-12">
                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-settings icon-left"></i> Settings</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
                        </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="feather icon-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="feather icon-pie-chart"></i></a>
                    </div>
                </div> -->
            </div>
            <div class="content-body">

                <!-- Disable auto print table -->
                <section id="disable-print">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Liste des campagnes</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements mb-2">
                                        <ul class="list-inline ">
                                            <span>
                                                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addCampagneModal"> <?= Validator::ficon('plus'); ?> Nouvelle campagne</button>
                                            </span>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        // var_dump($rapports);
                        $allCampagne = $this->validator->getAllByElement("campagnes", "entreprise_code", CODE_ENTREPRISE);
 
                                if ($allCampagne) {
                                    foreach ($allCampagne as $value) {
                                        $cryptedParams = $this->validator->crypter($value['id_campagne']);

                                        if ($value['etat_campagne'] == 1) {
                                            $etat = '<span class=" text-success px-2 py-1 rounded-pill">
                                                    Active
                                                </span>';
                                        } else {
                                            $etat = '<span class=" text-danger px-2 py-1 rounded-pill">
                                                    Inactif
                                                </span>';
                                        }
                                        
                                ?>
                                <div class="col-xl-4 col-lg-6 col-12 mb-3 element-item" style="display: block;">
                                    <div class="card shadow-sm border-0 rounded-4 succ-card h-100">
                                        <div class="card-body">

                                            <!-- HEADER -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3 class="fw-bold text-dark mb-0">
                                                    <?= $value['libelle_campagne'] ?>
                                                </h3>
                                                <div>
                                                    <a href="#" class="text-decoration-none text-primary">
                                                        <?= Validator::ficon('edit'); ?>
                                                    </a>
                                                    <?= $etat ?>
                                                </div>
                                            </div>

                                            <!-- STATS -->
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="stat-box">
                                                        <h4 class="mb-0 text-primary"><?= @$value['nbre_client'] ?></h4>
                                                        <small class="text-muted">Clients</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="stat-box">
                                                        <h4 class="mb-0 text-warning"><?= @$value['nbre_users'] ?></h4>
                                                        <small class="text-muted">Produits</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- BUTTON -->
                                            <div class="mt-4">
                                                <a href="<?= RACINE; ?>campagne/details/<?= $cryptedParams ?>" 
                                                class="btn btn-primary w-100 rounded-pill">
                                                🚀 Gérer la campagne
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <?php
                                    }
                                } else {
                                    echo '<h3 class="text-danger text-center text-sm mt-5">Aucune campagne pour l\'instant</h3>';
                                }
                                ?>
                    </div>

                    <div class="row justify-content-center mt-2 mb-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-separate pagination-flat" id="paginationControls"></ul>
                        </nav>
                    </div>
                </section>
                <!--/ Disable auto print table -->


            </div>
        </div>
    </div>
    <!-- END: Content-->

    
<!-- Modal pour ajouter un campagne -->
<div class="modal fade" id="addCampagneModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #20AFB1;">
                <h5 class="modal-title" id="modalTitle">Nouvelle campagne</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formCampagne" method="POST" >

                <!-- Libellé -->
                <div class="form-group">
                    <label for="code">code :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code" name="code" value="<?=$this->validator->generateCode("campagnes", "code_campagne", "CAMP", 8)?>" readonly placeholder="Libellé du kit" required>
                        <span class="input-group-addon"><i class="feather icon-gift"></i></span>
                    </div>
                    <div class="error-message" id="codeError"></div>
                </div>

                <!-- Libellé -->
                <div class="form-group">
                    <label for="libelle">Libellé :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libellé du kit" required>
                        <span class="input-group-addon"><i class="feather icon-gift"></i></span>
                    </div>
                    <div class="error-message" id="libelleError"></div>
                </div>

            <!-- Pied de page -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn_actions">Sauvegarder</button>
                <span type="button" class="btn btn-danger" data-dismiss="modal">Annuler</span>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>


    <!-- footer -->

    <!-- END: Content-->
	<?php require_once '../public/inc/footer.php'; ?>