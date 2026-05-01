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

                <?php
                $totalCotisation = $totalPayer['total_du_a_payer'];


                $totalRestant = max(0, $totalCotisation - $totalPaye);
                $percent = $totalCotisation > 0 ? ($totalPaye / $totalCotisation) * 100 : 0;
                ?>

                <!-- 🔥 CARDS STATS -->
                <div class="row mb-3">

                    <div class="col-md-4">
                        <div class="card text-white bg-primary shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa fa-wallet fa-2x mr-3"></i>
                                <div>
                                    <h6>Total dû</h6>
                                    <h4><?= number_format($totalCotisation, 0, ',', ' ') ?> CFA</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white bg-success shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa fa-check-circle fa-2x mr-3"></i>
                                <div>
                                    <h6>Total payé</h6>
                                    <h4><?= number_format($totalPaye, 0, ',', ' ') ?> CFA</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-white <?= $totalRestant == 0 ? 'bg-success' : 'bg-warning' ?> shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa fa-exclamation-circle fa-2x mr-3"></i>
                                <div>
                                    <h6>Reste à payer</h6>
                                    <h4><?= number_format($totalRestant, 0, ',', ' ') ?> CFA</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 📊 PROGRESS BAR -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h6>Progression du paiement</h6>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success"
                                style="width: <?= $percent ?>%">
                            </div>
                        </div>
                        <small><?= round($percent) ?>% payé</small>
                    </div>
                </div>

                <!-- 📄 INFOS -->
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-user-check"></i> Détails de l'inscription
                        </h4>
                       
                        <div class="heading-elements">
                            <a href="<?= RACINE ?>admin/inscriptions" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informations</h5>
                                <p><strong>Code:</strong> <?= $inscription['code_inscription'] ?? '' ?></p>
                                <p><strong>Type:</strong> <?= $inscription['type_inscription'] ?? '' ?></p>
                                <p><strong>Date début:</strong> <?= Validator::formatDateTime($inscription['date_debut'] ?? '') ?></p>
                                <p><strong>Date fin:</strong> <?= Validator::formatDateTime($inscription['date_fin'] ?? '') ?></p>
                                <p>
                                    <strong>État:</strong>
                                    <?= Validator::badgeEtatInscription($inscription['etat_inscription']) ?>
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h5>Client</h5>
                                <p><strong>Nom:</strong> <?= $client['nom_client'] ?? '' ?></p>
                                <p><strong>Téléphone:</strong> <?= $client['telephone_client'] ?? '' ?></p>
                                <p><strong>Quartier:</strong> <?= $client['quartier_client'] ?? '' ?></p>
                                <p><strong>Zone:</strong> <?= $client['zone_client'] ?? '' ?></p>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5>Commercial</h5>
                                <p><strong>Nom:</strong> <?= ($user['nom_user'] ?? '') . ' ' . ($user['prenom_user'] ?? '') ?></p>
                                <p><strong>Téléphone:</strong> <?= $user['telephone_user'] ?? '' ?></p>
                            </div>
                        </div>

                        <!-- 🧾 KITS -->
                        <div class="mt-4">
                            <h5>Kits sélectionnés</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kit</th>
                                        <th>Cotisation</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; foreach ($kits as $kit): $i++; ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $kit['libelle_choix'] ?? '' ?></td>
                                            <td><?= number_format($kit['cotisation_choix'] ?? 0, 0, ',', ' ') ?> CFA</td>
                                            <td><?= $kit['description_choix'] ?? '' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="bg-primary text-white">
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td colspan="2"><strong><?= number_format($totalCotisation, 0, ',', ' ') ?> CFA</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- 💰 PAIEMENTS -->
                        <div class="mt-4 table-responsive">
                            <h5>Historique des paiements</h5>
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
                                    <?php $total = 0; $i = 0; foreach ($paiements as $p): $i++; $total += $p['montant_paiement']; ?>
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

                                    <?php if (!empty($paiements)): ?>
                                        <tr class="bg-success text-white">
                                            <td colspan="2"><strong>Total payé</strong></td>
                                            <td colspan="4"><strong><?= number_format($total, 0, ',', ' ') ?> CFA</strong></td>
                                        </tr>
                                    <?php endif; ?>
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