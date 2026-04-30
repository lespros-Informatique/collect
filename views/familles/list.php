<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-layers"></i> Gestion des Familles
                        </h4>
                        <a class="heading-elements-toggle"><i class="feather icon-plus me-1 font-medium-3 btn btn-round btn-primary btn-sm"></i></a>

                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addFamilleModal">
                                        <i class="feather icon-plus"></i> Nouvelle Famille
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
                                        <th>Date création</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($familles as $famille): $i++; 
                                        $cryptedParams = $this->validator->crypter($famille['id_famille']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($famille['code_famille']) ?></td>
                                            <td><?= htmlspecialchars($famille['libelle_famille']) ?></td>
                                            <td><?= htmlspecialchars($famille['description_famille'] ?? 'N/A') ?></td>
                                            <td><?= Validator::formatDate($famille['created_at_famille']) ?></td>
                                            <td>
                                                <?php if($famille['etat_famille'] == 1): ?>
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

<!-- Modal pour ajouter une famille -->
<div class="modal fade" id="addFamilleModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouvelle Famille</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formFamille" method="POST">
                <!-- Libellé -->
                <div class="form-group">
                    <label for="libelle">Libellé :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libellé de la famille" required>
                        <span class="input-group-addon"><i class="feather icon-tag"></i></span>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description (facultatif) :</label>
                    <div class="input-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Description de la famille"></textarea>
                        <span class="input-group-addon"><i class="feather icon-file-text"></i></span>
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
        addFamille();
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>
