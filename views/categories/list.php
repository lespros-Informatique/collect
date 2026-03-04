<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-tag"></i> Gestion des Catégories
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addCategorieModal">
                                        <i class="feather icon-plus"></i> Nouvelle Catégorie
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
                                        <th>Nombre de jours</th>
                                        <th>Date début</th>
                                        <th>Date fin</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($categories as $categorie): $i++; 
                                        $cryptedParams = $this->validator->crypter($categorie['code_categorie']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($categorie['code_categorie']) ?></td>
                                            <td><?= htmlspecialchars($categorie['libelle_categorie']) ?></td>
                                            <td><?= htmlspecialchars($categorie['description_categorie'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($categorie['nombre_jour'] ?? 'N/A') ?></td>
                                            <td><?= Validator::formatDate($categorie['date_debut']) ?></td>
                                            <td><?= Validator::formatDate($categorie['date_fin']) ?></td>
                                            <td>
                                                <?php if($categorie['etat_categorie'] == 1): ?>
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

<!-- Modal pour ajouter une catégorie -->
<div class="modal fade" id="addCategorieModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouvelle Catégorie</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formCategorie" method="POST">
                <!-- Code Catégorie -->
                <div class="form-group">
                    <label for="code_categorie">Code Catégorie :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code_categorie" name="code_categorie" placeholder="Code catégorie" required>
                        <span class="input-group-addon"><i class="feather icon-hashtag"></i></span>
                    </div>
                    <div class="error-message" id="codeCategorieError"></div>
                </div>

                <!-- Libellé -->
                <div class="form-group">
                    <label for="libelle">Libellé :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libellé de la catégorie" required>
                        <span class="input-group-addon"><i class="feather icon-tag"></i></span>
                    </div>
                    <div class="error-message" id="libelleError"></div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description :</label>
                    <div class="input-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Description de la catégorie"></textarea>
                        <span class="input-group-addon"><i class="feather icon-file-text"></i></span>
                    </div>
                </div>

                <!-- Nombre de jours -->
                <div class="form-group">
                    <label for="nombre_jour">Nombre de jours :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="nombre_jour" name="nombre_jour" placeholder="Nombre de jours">
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

<?php require_once '../public/inc/footer.php'; ?>
