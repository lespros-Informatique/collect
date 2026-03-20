<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-users"></i> Gestion des Clients
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addClientModal">
                                        <i class="feather icon-user-plus"></i> Nouveau Client
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
                                        <th>Code Client</th>
                                        <th>Commercial</th>
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
                                            <td>
                                                <?php
                                                // Trouver le commercial qui a ajouté ce client
                                                $userName = 'N/A';
                                                foreach ($users as $u) {
                                                    if ($u['user_code'] == $client['user_code']) {
                                                        $userName = $u['nom_user'] . ' ' . $u['prenom_user'];
                                                        break;
                                                    }
                                                }
                                                echo htmlspecialchars($userName);
                                                ?>
                                            </td>
                                            <td><?= htmlspecialchars($client['nom_client']) ?></td>
                                            <td><?= htmlspecialchars($client['telephone_client']) ?></td>
                                            <td><?= htmlspecialchars($client['quartier_client'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($client['zone_client'] ?? 'N/A') ?></td>
                                            <td><?= Validator::formatDate($client['created_at_client']) ?></td>
                                            <td>
                                                <a href="<?= RACINE ?>admin/clients/details/<?= $cryptedParams ?>" class="btn btn-sm btn-secondary mr-1" title="Détails">
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

<!-- Modal pour ajouter un client -->
<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouveau Client</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formClient" method="POST" enctype="multipart/form-data">
                <!-- Nom -->
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom complet" required>
                        <span class="input-group-addon"><i class="feather icon-user"></i></span>
                    </div>
                    <div class="error-message" id="nomError"></div>
                </div>

                <!-- Téléphone -->
                <div class="form-group">
                    <label for="telephone">Téléphone :</label>
                    <div class="input-group">
                        <input type="tel" class="form-control" id="telephone" name="telephone" maxlength="10" placeholder="10 chiffres" required pattern="[0-9]{10}">
                        <span class="input-group-addon"><i class="feather icon-phone"></i></span>
                    </div>
                    <div class="error-message" id="telephoneError"></div>
                </div>

                <!-- Quartier -->
                <div class="form-group">
                    <label for="quartier">Quartier :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="quartier" name="quartier" placeholder="Quartier" required>
                        <span class="input-group-addon"><i class="feather icon-map-pin"></i></span>
                    </div>
                    <div class="error-message" id="quartierError"></div>
                </div>

                <!-- Zone -->
                <div class="form-group">
                    <label for="zone">Zone :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="zone" name="zone" placeholder="Zone" required>
                        <span class="input-group-addon"><i class="feather icon-map"></i></span>
                    </div>
                    <div class="error-message" id="zoneError"></div>
                </div>

                <!-- Commercial -->
                <div class="form-group">
                    <label for="user_code">Commercial :</label>
                    <div class="input-group">
                        <select class="form-control" id="user_code" name="user_code" required>
                            <option value="">Sélectionner un commercial</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= htmlspecialchars($user['user_code']) ?>">
                                    <?= htmlspecialchars($user['nom_user'] . ' ' . $user['prenom_user']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-user"></i></span>
                    </div>
                    <div class="error-message" id="user_codeError"></div>
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
