<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-trending-up"></i> Gestion des rapports
                        
                        </h4>
                        <a class="heading-elements-toggle"><i class="feather icon-send me-1 font-medium-3 btn btn-round btn-primary btn-sm"></i></a>

                        <div class="heading-elements">
                            <ul class="list-inline mb-0 d-flex align-items-center justify-content-end">
                                <span class="d-flex align-items-center justify-content-end">
                                
                                    <button type="button" data-user-code="<?= USER_CODE ?>" class="btn btn-primary  d-inline-block" id="addRapportBtn" >
                                        <i class="feather icon-send"></i> Envoyer mon rapport
                                    </button>
                                    <a href="<?= RACINE ?>rapports/mes-rapports" class="btn btn-warning  d-inline-block ml-2" >
                                        <i class="feather icon-list"></i> Mes rapports
                                    </a>
                                </span>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            
                            <table id="users-contacts" class="table table-striped table-bordered dataex-visibility-disable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Montant</th>
                                        <th>Date création</th>
                                        <th>Réseau</th>
                                        <th>Statut</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                    $totalVersements = 0;
                                    foreach ($versements as $versement): $i++; 
                                        $cryptedParams = $this->validator->crypter($versement['code_versement'].'separator'. $versement['statut_versement']); ?>
                                        <?php $totalVersements += $versement['montant_versement']; ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($versement['code_versement']) ?></td>
                                            <td><?= number_format($versement['montant_versement'], 0, ',', ' ') ?> F</td>
                                            <td><?= Validator::formatDate($versement['date_created_versement']) ?></td>
                                            <td><?= htmlspecialchars($versement['reseau_versement'] ?? 'N/A') ?></td>
                                            <td>
                                                <?= Validator::badgeStatutVersement($versement['statut_versement']) ?>
                                            </td>
                                            <td>
                                                <a href="<?= RACINE ?>versements/details/<?= $cryptedParams ?>" class="btn btn-sm btn-primary">
                                                    <i class="feather icon-eye"></i> Détails
                                                </a>
                                            </td>
                                        </tr>

                                    <?php endforeach; ?>
                                    <?php if (!empty($versements)): ?>
                                        <tr class="bg-success text-white">
                                            <td colspan="2"><strong>Total versé</strong></td>
                                            <td colspan="4"><strong><?= number_format($totalVersements, 0, ',', ' ') ?> F</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <input type="hidden" name="montant_total" id="montant_total" value="<?= $totalVersements ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>
