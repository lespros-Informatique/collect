<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-gift"></i> Gestion des Kits
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addKitModal">
                                        <i class="feather icon-plus"></i> Nouveau Kit
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
                                        <th>Libellé</th>
                                        <th>Description</th>
                                        <th>Cotisation</th>
                                        <th>Catégorie</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($choix as $kit): $i++; 
                                        $cryptedParams = $this->validator->crypter($kit['code_choix']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($kit['code_choix']) ?></td>
                                            <td><?= htmlspecialchars($kit['libelle_choix']) ?></td>
                                            <td><?= htmlspecialchars($kit['description_choix'] ?? 'N/A') ?></td>
                                            <td><?= number_format($kit['cotisation_choix'], 0, ',', ' ') ?> F</td>
                                            <td><?= htmlspecialchars($kit['categorie_code'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php if($kit['etat_choix'] == 1): ?>
                                                    <span class="badge badge-success">Active</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Inactive</span>
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

<!-- Modal pour ajouter un kit -->
<div class="modal fade" id="addKitModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouveau Kit</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formKit" method="POST">
                <!-- Code Kit -->
                <div class="form-group">
                    <label for="code_kit">Code Kit :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code_kit" name="code_kit" placeholder="Code kit" required>
                        <span class="input-group-addon"><i class="feather icon-hashtag"></i></span>
                    </div>
                    <div class="error-message" id="codeKitError"></div>
                </div>

                <!-- Catégorie -->
                <div class="form-group">
                    <label for="categorie">Catégorie :</label>
                    <div class="input-group">
                        <select class="form-control" id="categorie" name="categorie" required>
                            <option value="">... Sélectionnez une catégorie ...</option>
                            <?php if (isset($categories) && !empty($categories)): ?>
                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?= $categorie['code_categorie'] ?>"><?= htmlspecialchars($categorie['libelle_categorie']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-tag"></i></span>
                    </div>
                </div>

                <!-- Libellé -->
                <div class="form-group">
                    <label for="libelle">Libellé :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libellé du kit" required>
                        <span class="input-group-addon"><i class="feather icon-gift"></i></span>
                    </div>
                    <div class="error-message" id="libelleError"></div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description :</label>
                    <div class="input-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Description du kit"></textarea>
                        <span class="input-group-addon"><i class="feather icon-file-text"></i></span>
                    </div>
                </div>

                <!-- Cotisation -->
                <div class="form-group">
                    <label for="cotisation">Cotisation :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="cotisation" name="cotisation" placeholder="Montant de la cotisation" required>
                        <span class="input-group-addon"><i class="feather icon-dollar-sign"></i></span>
                    </div>
                    <div class="error-message" id="cotisationError"></div>
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
        addKit();
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>
