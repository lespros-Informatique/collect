<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-gift"></i> Détails du Kit
                        </h4>
                        <div class="heading-elements">
                            <a href="<?= RACINE ?>admin/kits" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i> Retour
                            </a>
                            <a href="<?= RACINE ?>admin/kits/edit/<?= $validator->crypter($kit['code_choix']) ?>" class="btn btn-primary btn-sm ml-1">
                                <i class="feather icon-edit"></i> Modifier
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Informations principales -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informations du Kit</h5>
                                <p><strong>Code:</strong> <?= $kit['code_choix'] ?? '' ?></p>
                                <p><strong>Libellé:</strong> <?= $kit['libelle_choix'] ?? '' ?></p>
                                <p><strong>Description:</strong> <?= $kit['description_choix'] ?? 'N/A' ?></p>
                                <p><strong>Cotisation:</strong> <?= number_format($kit['cotisation_choix'] ?? 0, 0, ',', ' ') ?> CFA</p>
                                <p><strong>État:</strong> 
                                    <span class="badge badge-<?= $kit['etat_choix'] == 1 ? 'success' : 'danger' ?>">
                                        <?= $kit['etat_choix'] == 1 ? 'Actif' : 'Inactif' ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Catégorie</h5>
                                <p><strong>Code:</strong> <?= $kit['categorie_code'] ?? 'N/A' ?></p>
                                <?php if (!empty($categorie)): ?>
                                    <p><strong>Libellé:</strong> <?= $categorie['libelle_categorie'] ?? '' ?></p>
                                <?php endif; ?>
                                
                                <!-- Image du kit -->
                                <?php if(!empty($kit['img_choix'])): ?>
                                    <h5 class="mt-3">Image</h5>
                                    <img src="<?= RACINE . $kit['img_choix'] ?>" alt="" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Articles du kit -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Articles du kit</h5>
                                <?php if (!empty($articles)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Libellé</th>
                                                    <th>Famille</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; foreach ($articles as $article): $i++; ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $article['code_article'] ?? '' ?></td>
                                                    <td><?= $article['libelle_article'] ?? '' ?></td>
                                                    <td><?= $article['libelle_famille'] ?? 'N/A' ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">Aucun article trouvé dans ce kit</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Inscriptions utilisant ce kit -->
                        <?php if (!empty($inscriptions)): ?>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Inscriptions utilisant ce kit</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Code inscription</th>
                                                <th>Client</th>
                                                <th>Date début</th>
                                                <th>État</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; foreach ($inscriptions as $inscription): $i++; ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $inscription['code_inscription'] ?? '' ?></td>
                                                <td><?= ($inscription['nom_client'] ?? 'N/A') ?></td>
                                                <td><?= Validator::formatDateTime($inscription['date_debut'] ?? '') ?></td>
                                                <td>
                                                    <span class="badge badge-<?= $inscription['etat_inscription'] == ETAT_INSCRIPTION[1] ? 'success' : 'danger' ?>">
                                                        <?= $inscription['etat_inscription'] == ETAT_INSCRIPTION[1] ? 'Active' : 'Inactive' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= RACINE ?>admin/inscriptions/details/<?= $validator->crypter($inscription['code_inscription']) ?>" class="btn btn-sm btn-info">
                                                        <i class="feather icon-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>
