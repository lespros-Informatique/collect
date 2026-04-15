<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-users"></i> Clients de <?= htmlspecialchars(($user['nom_user'] ?? '') . ' ' . ($user['prenom_user'] ?? '')) ?>
                        </h4>
                        <div class="heading-elements">
                            <a href="<?= RACINE ?>admin/users/details/<?= $validator->crypter($user['id_user']) ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i> Retour au profil
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users-contacts" class="table table-striped table-bordered dataex-visibility-disable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code Client</th>
                                        <th>Nom</th>
                                        <th>Téléphone</th>
                                        <th>Quartier</th>
                                        <th>Zone</th>
                                        <th>Date d'inscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($clients as $client): $i++; 
                                        $cryptedParams = $validator->crypter($client['code_client']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($client['code_client']) ?></td>
                                            <td><?= htmlspecialchars($client['nom_client']) ?></td>
                                            <td><?= htmlspecialchars($client['telephone_client']) ?></td>
                                            <td><?= htmlspecialchars($client['quartier_client'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($client['zone_client'] ?? 'N/A') ?></td>
                                            <td><?= Validator::formatDate($client['created_at_client']) ?></td>
                                            <td>
                                                <a href="<?= RACINE ?>admin/clients/details/<?= $cryptedParams ?>" class="btn btn-sm btn-outline-primary mr-1" title="Détails">
                                                    <i class="feather icon-eye"></i> Détails
                                                </a>
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