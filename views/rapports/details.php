<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-trending-up"></i> Détails du rapport <span class="badge badge-primary"><?= htmlspecialchars($code) ?></span>
                        
                        </h4>
                        <ul class="list-inline mb-0 ">
                            <small><?= Validator::badgeStatutVersement($statut); ?></small>
                        </ul>
                        <?php if($statut == STATUT[0]): ?>
                        <ul class="list-inline mb-0">
                            <span data-code="<?= $code ?>"  class="validerRapport badge badge-info badge-pill float-right" style="cursor: pointer;" onclick="validerRapport(this.getAttribute('data-code'))"><?= Validator::icon('check-circle') ?> Valider le rapport</span>
                        </ul>
                        <?php endif; ?>
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
