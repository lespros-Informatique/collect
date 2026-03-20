<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-dollar-sign"></i> Gestion des Paiements
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addPaiementModal">
                                        <i class="feather icon-plus"></i> Nouveau Paiement
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
                                        <th>Versement</th>
                                        <th>Utilisateur</th>
                                        <th>Inscription</th>
                                        <th>Montant</th>
                                        <th>Téléphone</th>
                                        <th>Réseau</th>
                                        <th>Nombre jours</th>
                                        <th>Type</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($paiements as $paiement): $i++; 
                                        $cryptedParams = $this->validator->crypter($paiement['code_paiement']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($paiement['code_paiement'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['versement_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['user_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['inscription_code'] ?? 'N/A') ?></td>
                                            <td><?= number_format($paiement['montant_paiement'], 0, ',', ' ') ?> F</td>
                                            <td><?= htmlspecialchars($paiement['telephone_paiement'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['reseau_paiement'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['nombre_jour_paye'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($paiement['type_paiement'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php if($paiement['statut_paiement'] == 1): ?>
                                                    <span class="badge badge-success">Validé</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">En attente</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= Validator::formatDate($paiement['created_at_paiement']) ?></td>
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
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouveau Paiement</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formPaiement" method="POST">
                <!-- Sélection User -->
                <div class="form-group">
                    <label for="user_select">Utilisateur :</label>
                    <div class="input-group">
                        <select class="form-control" id="user_select" name="user_code" required>
                            <option value="">... Sélectionnez un utilisateur ...</option>
                            <?php if (isset($users) && !empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['code_user'] ?>"><?= htmlspecialchars($user['nom_user'] . ' ' . $user['prenom_user']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-user"></i></span>
                    </div>
                </div>

                <!-- Sélection Inscription (dépend du user) -->
                <div class="form-group">
                    <label for="inscription_select">Inscription :</label>
                        <select class="form-control" id="inscription_select" name="inscription" required disabled>
                            <option value="">... Sélectionnez d'abord un utilisateur ...</option>
                        </select>
                </div>

                <!-- Zone des détails de l'inscription -->
                <div id="inscription_details" class="mb-3">
                    <!-- Les détails seront chargés dynamiquement ici -->
                </div>

                <!-- Nombre de jours -->
                <div class="form-group">
                    <label for="nombre_jour">Nombre de jours payé :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="nombre_jour" name="nombre_jour" placeholder="Nombre de jours" min="1" required>
                        <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                    </div>
                </div>

                <!-- Affichage du montant calculé -->
                <div id="montant_display" class="alert alert-success mb-3" style="display: none;">
                    <h5 class="mb-0">Montant à payer: <strong id="montant_value">0</strong> F</h5>
                </div>

                <!-- Champ montant caché -->
                <input type="hidden" id="montant" name="montant" value="">

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
