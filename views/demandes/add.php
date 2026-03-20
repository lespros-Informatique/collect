<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Nouvelle Demande de Carnets</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group">
                    <a href="<?= $validator->url('admin/demandes') ?>" class="btn btn-secondary btn-sm">
                        <i class="fa fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="horizontal-form-layouts">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Formulaire de demande</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <form id="demande-form" class="form-horizontal formDemande">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="categorie_code">Catégorie <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
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
                                            <label class="col-md-3 label-control" for="utilisateur_code">Utilisateur <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <select id="utilisateur_code" name="utilisateur_code" class="form-control" required>
                                                    <option value="">Sélectionner un utilisateur</option>
                                                    <?php if (!empty($users)): ?>
                                                        <?php foreach ($users as $user): ?>
                                                            <option value="<?= $user['code_user'] ?>"><?= $user['nom_user'] . ' ' . $user['prenom_user'] ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="total_demande">Quantité de carnets <span class="text-danger">*</span></label>
                                            <div class="col-md-9">
                                                <input type="number" id="total_demande" name="total_demande" class="form-control" placeholder="Nombre de carnets" min="1" value="1" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Stock disponible</label>
                                            <div class="col-md-9">
                                                <div id="stock-info" class="alert alert-info">
                                                    Veuillez sélectionner une catégorie pour voir le stock disponible
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-check"></i> Enregistrer la demande
                                            </button>
                                            <a href="<?= $validator->url('admin/demandes') ?>" class="btn btn-secondary">Annuler</a>
                                        </div>
                                    </form>
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
