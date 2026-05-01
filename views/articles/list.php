<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-box"></i> Gestion des Articles
                        </h4>
                        <a class="heading-elements-toggle"><i class="feather icon-plus me-1 font-medium-3 btn btn-round btn-primary btn-sm"></i></a>

                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addArticleModal">
                                        <i class="feather icon-plus"></i> Nouvel Article
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
                                        <th>Famille</th>
                                        <th>Image</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($articles as $article): $i++; 
                                        $cryptedParams = $this->validator->crypter($article['id_article']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($article['code_article']) ?></td>
                                            <td><?= htmlspecialchars($article['libelle_article']) ?></td>
                                            <td><?= isset($article['libelle_famille']) ? htmlspecialchars($article['libelle_famille']) : (isset($article['famille_id']) ? htmlspecialchars($article['famille_id']) : 'N/A') ?></td>
                                            <td>
                                                <?php if(!empty($article['image_article'])): ?>
                                                    <img src="<?= RACINE .$article['image_article'] ?>" alt="" style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Pas d'image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($article['etat_article'] == 1): ?>
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

<!-- Modal pour ajouter un article -->
<div class="modal fade" id="addArticleModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouvel Article</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formArticle" method="POST" enctype="multipart/form-data">
                <!-- Libellé -->
                <div class="form-group">
                    <label for="libelle">Libellé :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="libelle" name="libelle" placeholder="Libellé de l'article" required>
                        <span class="input-group-addon"><i class="feather icon-tag"></i></span>
                    </div>
                </div>

                <!-- Famille -->
                <div class="form-group">
                    <label for="famille">Famille :</label>
                    <div class="input-group">
                        <select class="form-control" id="famille" name="famille" required>
                            <option value="">... Sélectionnez une famille ...</option>
                            <?php if (isset($familles) && !empty($familles)): ?>
                                <?php foreach ($familles as $famille): ?>
                                    <option value="<?= $famille['code_famille'] ?>"><?= htmlspecialchars($famille['libelle_famille']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-layers"></i></span>
                    </div>
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image">Image :</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <span class="input-group-addon"><i class="feather icon-image"></i></span>
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
        addArticle();
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>
