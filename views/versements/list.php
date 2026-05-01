<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-trending-up"></i> Gestion des Versements
                        </h4>
                        <a class="heading-elements-toggle"><i class="feather icon-pocket me-1 font-medium-3 btn btn-round btn-primary btn-sm"></i></a>

                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addVersementModal">
                                        <i class="feather icon-plus"></i> Nouveau Versement
                                    </button>
                                </span>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users-contacts" class="table table-striped table-bordered dataex-visibility-disable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Rapport</th>
                                        <th>Utilisateur</th>
                                        <th>Montant</th>
                                        <th>Date création</th>
                                        <th>Réseau</th>
                                        <th>Statut</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                    foreach ($paiements as $paiement): $i++; 
                                        $cryptedParams = $this->validator->crypter($paiement['code_versement']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($paiement['code_versement']) ?></td>
                                            <td><?= htmlspecialchars($paiement['rapport_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['user_code'] ?? 'N/A') ?></td>
                                            <td><?= number_format($paiement['montant_versement'], 0, ',', ' ') ?> F</td>
                                            <td><?= Validator::formatDate($paiement['date_created_versement']) ?></td>
                                            <td><?= htmlspecialchars($paiement['reseau_versement'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php 
                                                $statut = $paiement['statut_versement'] ?? 'pending';
                                                $badgeClass = '';
                                                switch($statut) {
                                                    case 'succès': $badgeClass = 'success'; break;
                                                    case 'échec': $badgeClass = 'danger'; break;
                                                    case 'annulé': $badgeClass = 'warning'; break;
                                                    default: $badgeClass = 'info';
                                                }
                                                ?>
                                                <span class="badge badge-<?= $badgeClass ?>"><?= ucfirst($statut) ?></span>
                                            </td>
                                            <td>
                                                <?php if($paiement['etat_versement'] == 'Validé'): ?>
                                                    <span class="badge badge-success">Validé</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">En cours</span>
                                                <?php endif; ?>
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

<!-- Modal pour ajouter un versement -->
<div class="modal fade" id="addVersementModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouveau Versement</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formVersement" method="POST">

            <span class="text-primary font-weight-bold text-center d-block">Total encaissé: <?= number_format($paiementsInvalides, 0, ',', ' '); ?> F</span>

                <!-- Montant -->
                <div class="form-group">
                    <label for="montant">Montant :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="montant" name="montant" placeholder="Montant du versement" required>
                        <span class="input-group-addon"><i class="feather icon-dollar-sign"></i></span>
                    </div>
                    <div class="error-message" id="montantError"></div>
                </div>

                <!-- Réseau -->
                <div class="form-group">
                    <label for="reseau">Réseau :</label>
                    <div class="input-group">
                        <select class="form-control" id="reseau" name="reseau">
                            <option value="ESPACE">Espace</option>
                            <option value="WAVE">Wave</option>
                            <option value="MOOV_MONEY">Moov Money</option>
                            <option value="ORANGE_MONEY">Orange Money</option>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-credit-card"></i></span>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description (optionnel):</label>
                    <div class="input-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Description du versement" rows="3"></textarea>
                        <span class="input-group-addon"><i class="feather icon-edit"></i></span>
                    </div>
                </div>

            <!-- Pied de page -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn_actions">Sauvegarder</button>
                <span type="button" class="btn btn-danger" data-dismiss="modal">Annuler</span>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>
