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
            <h5 class="mt-1">Modifier les informations</h5>
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
                        <input type="text" class="form-control" id="nom" name="nom" value="<?= $user['nom_user'] ?? ''; ?>" placeholder="Entrer le nom">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('user'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="nomError"></div>
                    </div>

                    <!-- Prénom -->
                    <div class="form-group">
                      <label for="prenom">Prénom</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?= $user['prenom_user'] ?? ''; ?>" placeholder="Entrer le prénom">
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
                        <input type="tel" class="form-control" id="tel" name="tel" value="<?= $user['telephone_user'] ?? ''; ?>" maxlength="10" placeholder="Entrer le numéro">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('phone'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="telError"></div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                      <label for="email">Email</label>
                      <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email_user'] ?? ''; ?>" placeholder="Entrer l'email">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('mail'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="emailError"></div>
                    </div>

                    <!-- Quartier -->
                    <div class="form-group">
                      <label for="quartier">Quartier</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="quartier" name="quartier" value="<?= $user['quartier_user'] ?? ''; ?>" placeholder="Entrer le quartier">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('map-pin'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="quartierError"></div>
                    </div>

                    <!-- Zone -->
                    <div class="form-group">
                      <label for="zone">Zone</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="zone" name="zone" value="<?= $user['zone_user'] ?? ''; ?>" placeholder="Entrer la zone">
                        <div class="input-group-append">
                          <span class="input-group-text"><?= Validator::icon('map'); ?></span>
                        </div>
                      </div>
                      <div class="error-message" id="zoneError"></div>
                    </div>

                    <!-- Rôle -->
                
                    <div class="form-group">
                      <label for="role">Rôle</label>
                      <div class="input-group">
                        <select class="form-control" id="role" name="role">
                          <option value="<?= $user['role_code']; ?>" selected><?= $user['role_code']; ?></option>
                          <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                              <?php if ($role['code_role'] != $user['role_code']): ?>
                                <option value="<?= $role['code_role']; ?>"><?= $role['libelle_role']; ?></option>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          <?php endif; ?>
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
