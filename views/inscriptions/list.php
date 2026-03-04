<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-user-plus"></i> Gestion des Inscriptions
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addInscriptionModal">
                                        <i class="feather icon-plus"></i> Nouvelle Inscription
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
                                        <th>Utilisateur</th>
                                        <th>Client</th>
                                        <th>Type</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Etat</th>
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
                                                <?php if($inscription['etat_inscription'] == 1): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= RACINE ?>admin/inscriptions/details/<?= $cryptedParams ?>" class="btn btn-sm btn-secondary mr-1" title="Détails">
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

<!-- Modal pour ajouter une inscription -->
<div class="modal fade" id="addInscriptionModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouvelle Inscription</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formInscription" method="POST">
                <!-- Code Inscription -->
                <div class="form-group">
                    <label for="code_inscription">Code Inscription :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code_inscription" name="code_inscription" placeholder="Code inscription" required>
                        <span class="input-group-addon"><i class="feather icon-hashtag"></i></span>
                    </div>
                    <div class="error-message" id="codeInscriptionError"></div>
                </div>

                <!-- Utilisateur -->
                <div class="form-group">
                    <label for="utilisateur">Utilisateur :</label>
                    <div class="input-group">
                        <select class="form-control" id="utilisateur" name="utilisateur" required>
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

                <!-- Client -->
                <div class="form-group">
                    <label for="client">Client :</label>
                    <div class="input-group">
                        <select class="form-control" id="client" name="client" required>
                            <option value="">... Sélectionnez un client ...</option>
                            <?php if (isset($clients) && !empty($clients)): ?>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= $client['code_client'] ?>"><?= htmlspecialchars($client['nom_client']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-user"></i></span>
                    </div>
                </div>

                <!-- Type -->
                <div class="form-group">
                    <label for="type">Type d'inscription :</label>
                    <div class="input-group">
                        <select class="form-control" id="type" name="type" required>
                            <option value="">... Sélectionnez le type ...</option>
                            <option value="annuel">Annuel</option>
                            <option value="mensuel">Mensuel</option>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                    </div>
                </div>

                <!-- Date début -->
                <div class="form-group">
                    <label for="date_debut">Date début :</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="date_debut" name="date_debut" required>
                        <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                    </div>
                </div>

                <!-- Date fin -->
                <div class="form-group">
                    <label for="date_fin">Date fin :</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="date_fin" name="date_fin" required>
                        <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
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
        addInscription();
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>
