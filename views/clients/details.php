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
                                <p><strong>Nom:</strong> <?= $client['nom'] ?? '' ?></p>
                                <p><strong>Téléphone:</strong> <?= $client['telephone'] ?? '' ?></p>
                                <p><strong>Email:</strong> <?= $client['email'] ?? '' ?></p>
                                <p><strong>Adresse:</strong> <?= $client['adresse'] ?? '' ?></p>
                                <p><strong>Date d'inscription:</strong> <?= Validator::formatDate($client['created_at'] ?? '') ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5>Statistiques</h5>
                                <p><strong>Nombre de commandes:</strong> <?= count($commandes) ?></p>
                                <p><strong>Dernière commande:</strong>
                                    <?php
                                    if (!empty($commandes)) {
                                        $lastOrder = $commandes[0];
                                        echo Validator::formatDateTime($lastOrder['created_at']);
                                    } else {
                                        echo 'Aucune commande';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Historique des commandes</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Commande</th>
                                                <th>Date</th>
                                                <th>Statut</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=0; foreach ($commandes as $commande): $i++; 
                                        $cryptedParams = $this->validator->crypter($commande['id_commande']); ?>
                                            
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= Validator::formatDateTime($commande['created_at'] ?? '') ?></td>
                                                    <td>
                                                        <span class="badge badge-<?= $commande['statut'] == 'livrée' ? 'success' : ($commande['statut'] == 'en préparation' ? 'warning' : 'info') ?>">
                                                            <?= $commande['statut'] ?? '' ?>
                                                        </span>
                                                    </td>
                                                    <td><?= number_format($commande['total'] ?? 0, 0, ',', ' ') ?> FCFA</td>
                                                    <td>
                                                        <a href="<?= RACINE ?>admin/commandes/details/<?= $cryptedParams ?>" class="btn btn-sm btn-primary">Voir détails</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php if (empty($commandes)): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Aucune commande trouvée</td>
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