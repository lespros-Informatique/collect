<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Détails du client</h4>
                        <a href="<?= RACINE ?>admin/clients" class="btn btn-secondary btn-sm">Retour</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informations personnelles</h5>
                                <p><strong>Nom:</strong> <?= $client['nom_client'] ?? '' ?></p>
                                <p><strong>Téléphone:</strong> <?= $client['telephone_client'] ?? '' ?></p>
                                <p><strong>Quartier:</strong> <?= $client['quartier_client'] ?? '' ?></p>
                                <p><strong>Zone:</strong> <?= $client['zone_client'] ?? '' ?></p>
                                <p><strong>Date d'inscription:</strong> <?= Validator::formatDate($client['created_at_client'] ?? '') ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Statistiques</h5>
                                <p><strong>Nombre d'inscriptions:</strong> <?= count($inscriptions) ?></p>
                                <p><strong>Dernière inscription:</strong>
                                    <?php
                                    if (!empty($inscriptions)) {
                                        $lastInscription = $inscriptions[0];
                                        echo Validator::formatDateTime($lastInscription['date_debut']);
                                    } else {
                                        echo 'Aucune inscription';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Historique des inscriptions</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code Inscription</th>
                                                <th>Date début</th>
                                                <th>Date fin</th>
                                                <th>Type</th>
                                                <th>État</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($inscriptions as $inscription): $i++; ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $inscription['code_inscription'] ?? '' ?></td>
                                                    <td><?= Validator::formatDateTime($inscription['date_debut'] ?? '') ?></td>
                                                    <td><?= Validator::formatDateTime($inscription['date_fin'] ?? '') ?></td>
                                                    <td><?= $inscription['type_inscription'] ?? '' ?></td>
                                                    <td>
                                                        <span class="badge badge-<?= $inscription['etat_inscription'] == 1 ? 'success' : 'danger' ?>">
                                                            <?= $inscription['etat_inscription'] == 1 ? 'Active' : 'Inactive' ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($inscriptions)): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Aucune inscription trouvée</td>
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
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>