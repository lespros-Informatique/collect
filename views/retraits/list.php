<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-download"></i> Gestion des Retraits
                        </h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addRetraitModal">
                                        <i class="feather icon-plus"></i> Nouveau Retrait
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
                                        <th>Date retrait</th>
                                        <th>Utilisateur</th>
                                        <th>Inscription</th>
                                        <th>Type</th>
                                        <th>Détails</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($retraits as $retrait): $i++; 
                                        $cryptedParams = $this->validator->crypter($retrait['code_retrait']); ?>
                                    
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($retrait['code_retrait']) ?></td>
                                            <td><?= Validator::formatDate($retrait['date_retrait']) ?></td>
                                            <td><?= htmlspecialchars($retrait['user_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($retrait['inscription_code'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($retrait['type_retrait'] ?? 'N/A') ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailsModal<?= $i ?>">
                                                    <i class="feather icon-eye"></i> Voir
                                                </button>
                                                <!-- Modal pour voir les détails -->
                                                <div class="modal fade" id="detailsModal<?= $i ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Détails du Retrait</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php 
                                                                $details = json_decode($retrait['details'], true);
                                                                if ($details): ?>
                                                                    <p><strong>Choix:</strong> <?= htmlspecialchars($details['choix'] ?? 'N/A') ?></p>
                                                                    <?php if(isset($details['articles']) && is_array($details['articles'])): ?>
                                                                        <p><strong>Articles:</strong></p>
                                                                        <ul>
                                                                        <?php foreach($details['articles'] as $article): ?>
                                                                            <li><?= htmlspecialchars($article) ?></li>
                                                                        <?php endforeach; ?>
                                                                        </ul>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <p><?= htmlspecialchars($retrait['details'] ?? 'Aucun détail') ?></p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($retrait['etat_retrait'] == 1): ?>
                                                    <span class="badge badge-success">Actif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Annulé</span>
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

<!-- Modal pour ajouter un retrait -->
<div class="modal fade" id="addRetraitModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- En-tête -->
            <div class="modal-header text-light" style="background-color: #28a745;">
                <h5 class="modal-title" id="modalTitle">Nouveau Retrait</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formRetrait" method="POST">
                <!-- Code Retrait -->
                <div class="form-group">
                    <label for="code_retrait">Code Retrait :</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="code_retrait" name="code_retrait" placeholder="Code retrait" required>
                        <span class="input-group-addon"><i class="feather icon-hashtag"></i></span>
                    </div>
                    <div class="error-message" id="codeRetraitError"></div>
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

                <!-- Type -->
                <div class="form-group">
                    <label for="type">Type de retrait :</label>
                    <div class="input-group">
                        <select class="form-control" id="type" name="type">
                            <option value="inscription">Inscription</option>
                        </select>
                        <span class="input-group-addon"><i class="feather icon-tag"></i></span>
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
        addRetrait();
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>
