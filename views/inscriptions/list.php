<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Filtres -->
            <div class="card mb-2">
                <div class="card-body">
                    <form id="filterForm" class="form-inline" method="post">
                        <div class="row w-100">
                            <div class="col-md-4">
                                <label class="mr-2">Commercial:</label>
                                <select name="user_code" class="form-control form-control-sm select2">
                                    <option value="">Tous les commerciaux</option>
                                    <?php foreach ($users as $u): ?>
                                    <option value="<?= htmlspecialchars($u['code_user']) ?>">
                                        <?= htmlspecialchars(($u['nom_user'] ?? '') . ' ' . ($u['prenom_user'] ?? '')) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="mr-2">Catégorie:</label>
                                <select name="categorie_code" class="form-control form-control-sm select2">
                                    <option value="">Toutes les catégories</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['code_categorie']) ?>">
                                        <?= htmlspecialchars($cat['libelle_categorie'] ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-filter"></i> Filtrer
                                </button>
                                <button type="submit" class="btn btn-sm btn-outline-secondary ml-1">
                                    <i class="fa fa-times"></i> Réinitialiser
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-user-plus"></i> Gestion des Inscriptions
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users-contacts" class="table table-striped table-bordered dataex-visibility-disable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Utilisateur</th>
                                        <th>Client</th>
                                        <th>Type</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Etat</th>
                                        <th>Détails</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($inscriptions as $inscription): $i++; 
                                        $cryptedParams = $validator->crypter($inscription['code_inscription']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($inscription['code_inscription']) ?></td>
                                            <td><?= htmlspecialchars($inscription['user_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($inscription['client_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($inscription['type_inscription'] ?? 'N/A') ?></td>
                                            <td><?= Validator::formatDate($inscription['date_debut']) ?></td>
                                            <td><?= Validator::formatDate($inscription['date_fin']) ?></td>
                                            <td>
                                                <?php if($inscription['etat_inscription'] == 1): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php elseif($inscription['etat_inscription'] == 2): ?>
                                                    <span class="badge badge-info">Soldée</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= RACINE ?>admin/inscriptions/details/<?= $cryptedParams ?>" class="btn btn-sm btn-secondary mr-1" title="Détails">
                                                    <i class="feather icon-eye"></i> Détails
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= RACINE ?>admin/inscriptions/details/<?= $cryptedParams ?>" class="btn btn-sm btn-secondary mr-1" title="Détails">
                                                    <i class="feather icon-eye"></i>
                                                </a>
                                                
                                                <?php if($inscription['etat_inscription'] != 2): ?>
                                                <button type="button" class="btn btn-sm btn-primary mr-1 btn-payer-inscription" 
                                                    data-inscription="<?= htmlspecialchars($inscription['code_inscription']) ?>"
                                                    data-user="<?= htmlspecialchars($inscription['user_code'] ?? '') ?>"
                                                    title="Effectuer un paiement">
                                                    <i class="feather icon-dollar-sign"></i> Payer
                                                </button>
                                                <?php endif; ?>
                                                
                                                <a href="<?= RACINE ?>admin/inscriptions/choix/<?= $inscription['client_code'] ?>" class="btn btn-sm btn-success" title="Réinscrire">
                                                    <i class="feather icon-refresh-cw"></i>
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

<!-- Modal pour ajouter un paiement -->
<div class="modal fade" id="addPaiementModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="feather icon-dollar-sign"></i> Nouveau Paiement
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formPaiement" method="POST">
                    <div class="row">
                        <!-- Sélection de l'utilisateur -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_select">Utilisateur <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather icon-user"></i>
                                        </div>
                                    </div>
                                    <select class="form-control" id="user_select" name="user_code" required>
                                        <option value="">... Sélectionnez un utilisateur ...</option>
                                        <?php if (isset($users) && !empty($users)): ?>
                                            <?php foreach ($users as $user): ?>
                                                <option value="<?= htmlspecialchars($user['code_user']) ?>">
                                                    <?= htmlspecialchars(($user['nom_user'] ?? '') . ' ' . ($user['prenom_user'] ?? '')) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sélection de l'inscription -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inscription_select">Inscription <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather icon-file-text"></i>
                                        </div>
                                    </div>
                                    <select class="form-control" id="inscription_select" name="inscription" required disabled>
                                        <option value="">Sélectionnez d'abord un utilisateur</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Détails de l'inscription -->
                    <div id="inscription_details"></div>
                    
                    <!-- Nombre de jours et montant -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_jour">Nombre de jours <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" id="nombre_jour" name="nombre_jour" min="1" placeholder="Nombre de jours à payer" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="montant">Montant (F CFA) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather icon-dollar-sign"></i>
                                        </div>
                                    </div>
                                    <input type="number" class="form-control" id="montant" name="montant" min="1" placeholder="Montant à payer" required readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Affichage du montant -->
                    <div id="montant_display" class="alert alert-success mt-2" style="display: none;">
                        <i class="feather icon-check-circle"></i>
                        Montant à payer: <strong id="montant_value">0</strong> F
                    </div>
                    
                    <!-- Champs cachés pour type et réseau (optionnels) -->
                    <input type="hidden" name="type" value="manuel">
                    <input type="hidden" name="reseau" value="ESPECES">
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Fermer
                        </button>
                        <button type="submit" class="btn btn-primary btn_actions">
                            <i class="feather icon-save"></i> Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>