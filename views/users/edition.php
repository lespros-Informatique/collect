<!-- header -->
<?php require_once '../public/inc/header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
 <!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <!-- Formulaire d'édition -->
    <div class="content-body">
      <section id="edit-user-form">
        <div class="row">

        <div class="col-md-6 d-flex align-items-center justify-content-center">
          <div class="text-center">
            <div class="avatar bg-primary mb-1">
              <span class="avatar-content" >
                <i class="feather icon-user text-white"></i>
              </span>
            </div>
            <h5 class="mt-1">Membre de la race bénie</h5>
          </div>
        </div>

           

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Modifier les informations de l'utilisateur</h4>
              </div>
              
              <div class="card-content">
                <div class="card-body">
                  <form class="formEdituser" method="POST" action="">
                    <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">

                    <!-- Nom -->
                    <div class="form-group">
                      <label for="nom">Nom</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="nom" name="nom" value="<?= $user['nom']; ?>" placeholder="Entrer le nom et prénom">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('user'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="nomError"></div>
                    </div>

                          <!-- prenom -->
                      <div class="form-group">
                      <label for="prenom">Nom</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $user['prenom']; ?>" placeholder="Entrer le nom et prénom">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('user'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="prenomError"></div>
                    </div>

                    <!-- Téléphone -->
                    <div class="form-group">
                      <label for="tel_user">Numéro de Téléphone</label>
                      <div class="input-group">
                        <input type="tel" class="form-control" id="tel" name="tel" value="<?= $user['telephone']; ?>" maxlength="10" placeholder="Entrer le numéro">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('phone'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="telError"></div>
                    </div>

                       <div class="form-group">
                      <label for="sexe">Sexe</label>
                      <div class="input-group">
                        <select class="form-control" id="sexe" name="sexe">
                          <option value="<?= $user['sexe_user']; ?>" selected><?= $user['sexe_user']; ?></option>
                          <?php if ($user['sexe_user'] != 'Homme'): ?>
                            <option value="Homme">Homme</option>
                          <?php endif; ?>
                          <?php if ($user['sexe_user'] != 'Femme'): ?>
                            <option value="Femme">Femme</option>
                          <?php endif; ?>
                        </select>
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('user-secret'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="roleError"></div>
                    </div>

                    <div class="form-group">
                      <label for="fonction_user">Profession</label>
                      <div class="input-group">
                        <input type="tel" class="form-control" id="fonction" name="fonction" value="<?= $user['profession_user']; ?>" >
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('briefcase'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="fonctionError"></div>
                    </div>

                    <!-- Rôle -->
                 
                    <div class="form-group">
                      <label for="role">Rôle</label>
                      <div class="input-group">
                        <select class="form-control" id="role" name="role">
                          <option value="<?= $user['id_role']; ?>" selected><?= $user['libelle']; ?></option>
                          <?php foreach ($roles as $role): ?>
                            <?php if ($role['id_role'] != $user['id_role']): ?>
                              <option value="<?= $role['id_role']; ?>"><?= $role['libelle']; ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('user-secret'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="roleError"></div>
                    </div>

                    <!-- Boutons -->
                    <div class="form-actions d-flex justify-content-between">
                      <button type="submit" class="btn btn-primary">Sauvegarder</button>  
                      <span type="button" class="btn btn-danger ml-1" onclick="go_b()"  data-dismiss="modal">Annuler</span>
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
<!-- END: Content-->

    <!-- END: Content-->
<!-- footer -->
<?php require_once '../public/inc/footer.php'; ?>
