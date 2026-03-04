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
    <div class="modal-dialog modal-lg" role="document">
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
                <!-- Code Paiement -->
                <div class="form-group">
                    <label for="code_paiement">Code Paiement :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code_paiement" name="code_paiement" placeholder="Code paiement" required>
                        <span class="input-group-addon"><i class="feather icon-hashtag"></i></span>
                    </div>
                    <div class="error-message" id="codePaiementError"></div>
                </div>

                <!-- Inscription -->
                <div class="form-group">
                    <label for="inscription">Inscription :</label>
                    <div class="input-group">
                        <select class="form-control" id="inscription" name="inscription" required>
                            <option value="">... Sélectionnez une inscription ...</option>
                            <?php if (isset($inscriptions) && !empty($inscriptions)): ?>
                                <?php foreach ($inscriptions as $inscription): ?>
                                    <option value="<?= $inscription['code_inscription'] ?>"><?= htmlspecialchars($inscription['code_inscription']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-file-text"></i></span>
                    </div>
                </div>

                <!-- Montant -->
                <div class="form-group">
                    <label for="montant">Montant :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="montant" name="montant" placeholder="Montant du paiement" required>
                        <span class="input-group-addon"><i class="feather icon-dollar-sign"></i></span>
                    </div>
                    <div class="error-message" id="montantError"></div>
                </div>

                <!-- Téléphone -->
                <div class="form-group">
                    <label for="telephone">Téléphone :</label>
                    <div class="input-group">
                        <input type="tel" class="form-control" id="telephone" name="telephone" maxlength="10" placeholder="10 chiffres">
                        <span class="input-group-addon"><i class="feather icon-phone"></i></span>
                    </div>
                </div>

                <!-- Réseau -->
                <div class="form-group">
                    <label for="reseau">Réseau :</label>
                    <div class="input-group">
                        <select class="form-control" id="reseau" name="reseau">
                            <option value="ESPECES">Espèces</option>
                            <option value="WAVE">Wave</option>
                            <option value="MOOV_MONEY">Moov Money</option>
                            <option value="ORANGE_MONEY">Orange Money</option>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-credit-card"></i></span>
                    </div>
                </div>

                <!-- Nombre de jours -->
                <div class="form-group">
                    <label for="nombre_jour">Nombre de jours payé :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="nombre_jour" name="nombre_jour" placeholder="Nombre de jours" required>
                        <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                    </div>
                </div>

                <!-- Type de paiement -->
                <div class="form-group">
                    <label for="type">Type de paiement :</label>
                    <div class="input-group">
                        <select class="form-control" id="type" name="type">
                            <option value="manuel">Manuel</option>
                            <option value="automatique">Automatique</option>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-settings"></i></span>
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

<script>
    $(document).ready(function() {
        addPaiement();
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>
