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
                            <?php if (ROLE !== ROLE_COMMERCIAL){ ?>
                            <div class="col-md-4">
                                <select name="user_code" class="form-control form-control-sm select2">
                                    <option value="">Tous les commerciaux</option>
                                    <?php foreach ($users as $u): ?>
                                    <option value="<?= htmlspecialchars($u['code_user']) ?>">
                                        <?= htmlspecialchars(($u['nom_user'] ?? '') . ' ' . ($u['prenom_user'] ?? '')) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php } else {?>
                                <div class="col-md-4">
                                    <p class="text-center text-primary font-weight-bold "><?= USER_NAME ?></p>
                                </div>
                            <?php }?>
                            <div class="col-md-4 ">
                                <select name="categorie_code" class="form-control form-control-sm select2">
                                    <option value="">Toutes les catégories</option>
                                    <?php foreach ($categories as $cat): ?>
                                    <option value="<?= htmlspecialchars($cat['code_categorie']) ?>">
                                        <?= htmlspecialchars($cat['libelle_categorie'] ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end phone-mt-1">
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
                            <i class="feather icon-dollar-sign"></i> Espace de Cotation
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
                                        $cryptedParams = $this->validator->crypter($inscription['code_inscription']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($inscription['code_inscription']) ?></td>
                                            <td><?= htmlspecialchars($inscription['user_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($inscription['client_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($inscription['type_inscription'] ?? 'N/A') ?></td>
                                            <td><?= Validator::formatDate($inscription['date_debut']) ?></td>
                                            <td><?= Validator::formatDate($inscription['date_fin']) ?></td>
                                            <td>
                                                <?php if($inscription['etat_inscription'] == ETAT_INSCRIPTION[2]): ?>
                                                    <span class="badge badge-info">Soldée</span>
                                                    <?php elseif($inscription['etat_inscription'] == ETAT_INSCRIPTION[0]): ?>
                                                        <span class="badge badge-success">Active</span>
                                                    <?php elseif($inscription['etat_inscription'] == ETAT_INSCRIPTION[1]): ?>
                                                        <span class="badge badge-warning">En attente</span>
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
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="feather icon-settings"></i> Options
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="<?= RACINE ?>admin/inscriptions/details/<?= $cryptedParams ?>">
                                                            <i class="feather icon-eye"></i> Détails
                                                        </a>
                                                        <?php if($inscription['etat_inscription'] != ETAT_INSCRIPTION[2]): ?>
                                                        <button type="button" class="dropdown-item btn-payer-inscription" 
                                                            data-inscription="<?= htmlspecialchars($inscription['code_inscription']) ?>"
                                                            data-user="<?= htmlspecialchars($inscription['user_code'] ?? '') ?>">
                                                            <i class="feather icon-dollar-sign"></i> Payer
                                                        </button>
                                                        <?php endif; ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="<?= RACINE ?>admin/inscriptions/choix/<?= $inscription['client_code'] ?>">
                                                            <i class="feather icon-refresh-cw"></i> Réinscrire
                                                        </a>
                                                    </div>
                                                </div>
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
                        
                        <!-- Sélection de l'inscription -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inscription_select">Inscription <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather icon-file-text"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="inscription" id="inscription_select" class="form-control" readonly>
                                    <!-- <select class="form-control" id="inscription_select" name="inscription" disabled>
                                        <option value="">Sélectionnez d'abord un utilisateur</option>
                                    </select> -->
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
                                    <input type="number" min="1" class="form-control" id="nombre_jour" name="nombre_jour" placeholder="Nombre de jours à payer" required>
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
                    <input type="hidden" name="reseau" value="especes">
                    
                    <div class="modal-footer d-flex">
                        
                        <button type="submit" class="btn btn-primary btn_actions">
                            <i class="feather icon-save"></i> Sauvegarder
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="feather icon-x"></i> Fermer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>