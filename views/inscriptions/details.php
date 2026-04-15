<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
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
                        <!-- Informations principales -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informations de l'inscription</h5>
                                <p><strong>Code:</strong> <?= $inscription['code_inscription'] ?? '' ?></p>
                                <p><strong>Type:</strong> <?= $inscription['type_inscription'] ?? '' ?></p>
                                <p><strong>Date début:</strong> <?= Validator::formatDateTime($inscription['date_debut'] ?? '') ?></p>
                                <p><strong>Date fin:</strong> <?= Validator::formatDateTime($inscription['date_fin'] ?? '') ?></p>
                                <p><strong>État:</strong> 
                                    <span class="badge badge-<?= $inscription['etat_inscription'] == 1 ? 'success' : 'danger' ?>">
                                        <?= $inscription['etat_inscription'] == 1 ? 'Active' : 'Inactive' ?>
                                    </span>
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

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Commercial</h5>
                                <p><strong>Nom:</strong> <?= ($user['nom_user'] ?? '') . ' ' . ($user['prenom_user'] ?? '') ?></p>
                                <p><strong>Téléphone:</strong> <?= $user['telephone_user'] ?? '' ?></p>
                            </div>
                        </div>

                        <!-- Kits sélectionnés -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Kits sélectionnés</h5>
                                <?php if (!empty($kits)): ?>
                                    <div class="table-responsive">
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
                                                <?php $i = 0; $totalCotisation = 0; foreach ($kits as $kit): $i++; ?>
                                                    <?php $totalCotisation += $kit['cotisation_choix'] ?? 0; ?>
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
                                <?php else: ?>
                                    <p class="text-muted">Aucun kit trouvé</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Historique des paiements -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Historique des paiements</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code paiement</th>
                                                <th>Montant</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; $totalPaye = 0; foreach ($paiements as $paiement): $i++; ?>
                                                <?php $totalPaye += $paiement['montant_paiement'] ?? 0; ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $paiement['code_paiement'] ?? '' ?></td>
                                                    <td><?= number_format($paiement['montant_paiement'] ?? 0, 0, ',', ' ') ?> CFA</td>
                                                    <td><?= Validator::formatDateTime($paiement['created_at_paiement'] ?? '') ?></td>
                                                    <td><?= $paiement['type_paiement'] ?? '' ?></td>
                                                    <td>
                                                        <span class="badge badge-<?= $paiement['statut_paiement'] == 1 ? 'success' : 'warning' ?>">
                                                            <?= $paiement['statut_paiement'] == 1 ? 'Payé' : 'En attente' ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($paiements)): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Aucun paiement trouvé</td>
                                                </tr>
                                            <?php else: ?>
                                                <tr class="bg-success text-white">
                                                    <td colspan="2"><strong>Total payé</strong></td>
                                                    <td colspan="4"><strong><?= number_format($totalPaye, 0, ',', ' ') ?> CFA</strong></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Solde restant -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-<?= $totalPaye >= $totalCotisation ? 'success' : 'warning' ?>">
                                    <h5>Récapitulatif</h5>
                                    <p><strong>Total dû:</strong> <?= number_format($totalCotisation, 0, ',', ' ') ?> CFA</p>
                                    <p><strong>Total payé:</strong> <?= number_format($totalPaye, 0, ',', ' ') ?> CFA</p>
                                    <p><strong>Reste à payer:</strong> <?= number_format(max(0, $totalCotisation - $totalPaye), 0, ',', ' ') ?> CFA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>
