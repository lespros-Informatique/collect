<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-settings"></i> Paramètres du Système
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Informations de l'Entreprise</h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="formSettings" method="POST">
                                            <div class="form-group">
                                                <label for="entreprise_nom">Nom de l'entreprise :</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="entreprise_nom" name="entreprise_nom" placeholder="Nom de l'entreprise">
                                                    <span class="input-group-addon"><i class="feather icon-briefcase"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="entreprise_email">Email :</label>
                                                <div class="input-group">
                                                    <input type="email" class="form-control" id="entreprise_email" name="entreprise_email" placeholder="Email">
                                                    <span class="input-group-addon"><i class="feather icon-mail"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="entreprise_tel">Téléphone :</label>
                                                <div class="input-group">
                                                    <input type="tel" class="form-control" id="entreprise_tel" name="entreprise_tel" placeholder="Téléphone">
                                                    <span class="input-group-addon"><i class="feather icon-phone"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="entreprise_adresse">Adresse :</label>
                                                <div class="input-group">
                                                    <textarea class="form-control" id="entreprise_adresse" name="entreprise_adresse" placeholder="Adresse"></textarea>
                                                    <span class="input-group-addon"><i class="feather icon-map-pin"></i></span>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn_actions">
                                                <i class="feather icon-save"></i> Sauvegarder
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Préférences du Système</h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="formPreferences" method="POST">
                                            <div class="form-group">
                                                <label for="devise">Devise :</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="devise" name="devise">
                                                        <option value="XOF">FCFA (XOF)</option>
                                                        <option value="EUR">Euro (EUR)</option>
                                                        <option value="USD">Dollar (USD)</option>
                                                    </select>
                                                    <span class="input-group-addon"><i class="feather icon-dollar-sign"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="timezone">Fuseau horaire :</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="timezone" name="timezone">
                                                        <option value="Africa/Abidjan">Abidjan (GMT+0)</option>
                                                        <option value="Africa/Accra">Accra (GMT+0)</option>
                                                        <option value="Africa/Lagos">Lagos (GMT+1)</option>
                                                        <option value="Africa/Paris">Paris (GMT+1)</option>
                                                    </select>
                                                    <span class="input-group-addon"><i class="feather icon-globe"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="categorie_par_defaut">Catégorie par défaut :</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="categorie_par_defaut" name="categorie_par_defaut">
                                                        <?php if (isset($categories) && !empty($categories)): ?>
                                                            <?php foreach ($categories as $categorie): ?>
                                                                <option value="<?= $categorie['code_categorie'] ?>"><?= htmlspecialchars($categorie['libelle_categorie']) ?></option>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <option value="">Aucune catégorie</option>
                                                        <?php endif; ?>
                                                    </select>
                                                    <span class="input-group-addon"><i class="feather icon-tag"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="reseau_defaut">Réseau de paiement par défaut :</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="reseau_defaut" name="reseau_defaut">
                                                        <option value="ESPECES">Espèces</option>
                                                        <option value="WAVE">Wave</option>
                                                        <option value="MOOV_MONEY">Moov Money</option>
                                                        <option value="ORANGE_MONEY">Orange Money</option>
                                                    </select>
                                                    <span class="input-group-addon"><i class="feather icon-credit-card"></i></span>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn_actions">
                                                <i class="feather icon-save"></i> Sauvegarder
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Gestion des Rôles</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Code</th>
                                                        <th>Libellé</th>
                                                        <th>Etat</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 0;
                                                    if (isset($roles) && !empty($roles)):
                                                        foreach ($roles as $role): $i++; ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= htmlspecialchars($role['code_role']) ?></td>
                                                                <td><?= htmlspecialchars($role['libelle_role']) ?></td>
                                                                <td>
                                                                    <?php if($role['etat_role'] == 1): ?>
                                                                        <span class="badge badge-success">Actif</span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-danger">Inactif</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary">
                                                                        <i class="feather icon-edit"></i> Modifier
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; 
                                                    else: ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">Aucun rôle trouvé</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>
