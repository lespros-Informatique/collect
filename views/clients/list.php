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
                                        <th>Nom</th>
                                        <th>Téléphone</th>
                                        <th>Email</th>
                                        <th>Adresse</th>
                                        <th>Date d'inscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($clients as $client): $i++; 
                                        $cryptedParams = $this->validator->crypter($client['id_client']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($client['code_client']) ?></td>
                                            <td><?= htmlspecialchars($client['nom']) ?></td>
                                            <td><?= htmlspecialchars($client['telephone']) ?></td>
                                            <td><?= htmlspecialchars($client['email'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars(substr($client['adresse'], 0, 10)) ?>...</td>
                                            <td><?= Validator::formatDate($client['created_at']) ?></td>
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
            <form class="formClient" method="POST">
                <!-- Code Client -->
                <div class="form-group">
                    <label for="code_client">Code Client :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code_client" name="code_client" placeholder="Code client" required>
                        <span class="input-group-addon"><i class="feather icon-hashtag"></i></span>
                    </div>
                    <div class="error-message" id="codeClientError"></div>
                </div>

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

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email :</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@exemple.com">
                        <span class="input-group-addon"><i class="feather icon-mail"></i></span>
                    </div>
                    <div class="error-message" id="emailError"></div>
                </div>

                <!-- Adresse -->
                <div class="form-group">
                    <label for="adresse">Adresse :</label>
                    <div class="input-group">
                        <textarea class="form-control" id="adresse" name="adresse" rows="3" placeholder="Adresse complète" required></textarea>
                        <span class="input-group-addon"><i class="feather icon-map-pin"></i></span>
                    </div>
                    <div class="error-message" id="adresseError"></div>
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
        // Validation et soumission du formulaire client
        $('.formClient').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            $.ajax({
                url: '<?= RACINE ?>admin/clients/create',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status == 1) {
                        toastr.success(res.msg);
                        $('#addClientModal').modal('hide');
                        location.reload();
                    } else {
                        toastr.error(res.msg);
                    }
                }
            });
        });
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>