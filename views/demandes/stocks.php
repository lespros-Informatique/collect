<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Gestion des Stocks</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group">
                    <a href="<?= $validator->url('admin/demandes') ?>" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Retour aux demandes
                    </a>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- Formulaire d'entrée de stock -->
            <section id="horizontal-form-layouts">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ajouter du stock</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form id="stock-form" class="form-horizontal formStock">
                                        <div class="form-group row">
                                            <label class="col-md-2 label-control" for="type_mouvement">Type de mouvement</label>
                                            <div class="col-md-4">
                                                <select id="type_mouvement" name="type_mouvement" class="form-control" required>
                                                    <option value="ENTREE">Entrée de stock</option>
                                                    <option value="RETOUR">Retour de stock</option>
                                                </select>
                                            </div>
                                            
                                            <label class="col-md-2 label-control" for="categorie_code">Catégorie</label>
                                            <div class="col-md-4">
                                                <select id="categorie_code" name="categorie_code" class="form-control" required>
                                                    <option value="">Sélectionner une catégorie</option>
                                                    <?php if (!empty($categories)): ?>
                                                        <?php foreach ($categories as $cat): ?>
                                                            <option value="<?= $cat['code_categorie'] ?>"><?= $cat['libelle_categorie'] ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 label-control" for="quantite">Quantité</label>
                                            <div class="col-md-4">
                                                <input type="number" id="quantite" name="quantite" class="form-control" placeholder="Quantité" min="1" required>
                                            </div>
                                            
                                            <label class="col-md-2 label-control" for="commentaire">Commentaire</label>
                                            <div class="col-md-4">
                                                <input type="text" id="commentaire" name="commentaire" class="form-control" placeholder="Commentaire (optionnel)">
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Historique des mouvements -->
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Historique des mouvements de stock</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <table class="table table-striped table-bordered" id="stocks-table">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Type</th>
                                                <th>Quantité</th>
                                                <th>Catégorie</th>
                                                <th>Utilisateur</th>
                                                <th>Commentaire</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($historique)): ?>
                                                <?php foreach ($historique as $stock): ?>
                                                    <tr>
                                                        <td><?= $stock['code_stock'] ?></td>
                                                        <td>
                                                            <?php if ($stock['type_mouvement'] == 'ENTREE'): ?>
                                                                <span class="badge badge-success">Entrée</span>
                                                            <?php elseif ($stock['type_mouvement'] == 'SORTIE'): ?>
                                                                <span class="badge badge-warning">Sortie</span>
                                                            <?php else: ?>
                                                                <span class="badge badge-info">Retour</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $stock['quantite_stock'] ?></td>
                                                        <td><?= $stock['libelle_categorie'] ?? $stock['categorie_code'] ?? '-' ?></td>
                                                        <td><?= ($stock['nom_user'] ?? '') . ' ' . ($stock['prenom_user'] ?? '') ?: '-' ?></td>
                                                        <td><?= $stock['commentaire'] ?? '-' ?></td>
                                                        <td><?= date('d/m/Y H:i', strtotime($stock['date_mouvement'])) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Aucun mouvement de stock</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include '../public/inc/footer.php'; ?>

<script>
$(document).ready(function() {
    $('#stocks-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[6, 'desc']]
    });
});
</script>

<script>
$(document).ready(function() {
    $('#stocks-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[6, 'desc']]
    });
});
</script>
