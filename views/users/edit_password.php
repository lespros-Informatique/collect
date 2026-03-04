<?php require_once '../public/inc/header.php'; ?><!-- header -->

<div class="container mt-3">
    <div class="card">
        <div class="card-header bg-info text-center text-light">
            <div class="d-flex justify-content-between">
                <h2>Espace de modification</h2>
                <p><a href="<?=RACINE?>user/profil" class="btn btn-default btn-sm"><i class="fa fa-user-tie fa-2x"></i> Profil</a></p>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" class="formPassword">
                <div class="row ancien_hidden">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Ancien mot de passe:</label>
                            <div class="input-icon box-password">
                                <span class="input-icon-addon">
                                    <i class="fa fa-lock fa-lg"></i>
                                </span>
                                <input type="hidden" name="id_utilisateur" value="<?= @$_SESSION['id_utilisateur'] ?>">
                                <input type="password" name="ancien_password" class="form-control eye-input clear" placeholder="Mot de passe">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nouveau mot de passe:</label>
                            <div class="input-icon box-password">
                                <span class="input-icon-addon">
                                    <i class="fa fa-lock fa-lg"></i>
                                </span>
                                <input type="password" name="nauveau_password" id="password" class="form-control nauveau_password clear" placeholder="Mot de passe">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row nouveau_hidden">
                    <div class="col-md-6">
                        <input type="hidden" name="btntEditProfil" value="1">
                        <button type="submit" name="btntEditProfil" class="btn btn-success btn-block btnModifierPassword" id="submitBtn"><i class="fa fa-edit"></i> Modifier</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger btn-block retour"><i class="fa fa-ban"></i> Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?><!-- footer -->
