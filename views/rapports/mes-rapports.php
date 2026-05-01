
<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-trending-up"></i> historique rapports
                        </h4>
                        
                    </div>
            <div class="row">
                        <?php
                        if ($rapports) {
                            foreach ($rapports as $value) {
                                $cryptedParams = $this->validator->crypter($value['code_rapport'].'separator'.$value['statut_rapport']);
                        ?>

                                <div class="col-xl-4 col-lg-6 col-12 element-item" style="display: none;">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media">
                                                    <div class="media-body text-left w-100">
                                                        <?= Validator::badgeStatutVersement($value['statut_rapport']); ?>
                                                        <h4 class="primary">Rapport - <?= $value['code_rapport'] ?></h4>
                                                        <span>Date: <?= $value['date_created_rapport'] ?></span>
                                                    </div>
                                                </div>
                                                <div class=" mt-1 mb-0">
                                                    <a class="btn btn-secondary" href="<?= RACINE; ?>rapports/details/<?= $cryptedParams; ?>">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                        <?php
                            }
                        } else {
                            echo '<h3 class="text-danger ml-5 justify-content-center">Aucune donnée enregistée</h3>';
                        }
                        ?>
                    </div>
                    <div class="row justify-content-center mt-2">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-separate pagination-flat" id="paginationControls"></ul>
                        </nav>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>



