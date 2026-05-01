<?php require_once '../public/inc/header.php'; ?>

<style>
.card {
    border: none;
    border-radius: 12px;
}
.shadow-sm {
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}
.card h4 {
    font-weight: 600;
}
</style>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <!-- 🔥 CARDS STATS -->
    <div class="card-header">
                                    <h4 class="card-title">Details Versement <span class="badge badge-primary"><?= $code ?></span></h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <?= Validator::badgeStatutVersement($statut); ?>
                                        </ul>
                                    </div>
                                </div>
                        <!-- 💰 PAIEMENTS -->
                        <div class="mt-4 table-responsive">
                            <h5>Détail des paiements du versement</h5>
                            <table id="users-contacts" class="table table-striped table-bordered dataex-visibility-disable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Montant</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0; $i = 0; 
                                    foreach ($paiements as $p): $i++; $total += $p['montant_paiement']; ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $p['code_paiement'] ?></td>
                                            <td><?= number_format($p['montant_paiement'], 0, ',', ' ') ?> CFA</td>
                                            <td><?= Validator::formatDateTime($p['created_at_paiement']) ?></td>
                                            <td>
                                                <span class="badge badge-<?= $p['statut_paiement'] == 1 ? 'success' : 'warning' ?>">
                                                    <?= $p['statut_paiement'] == 1 ? 'Payé' : 'En attente' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>