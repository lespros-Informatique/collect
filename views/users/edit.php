<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content -->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
<div class="card-header">
      <h4 class="card-title">
          <i class="feather icon-users"></i> Modifier l'utilisateur
      </h4>
      <div class="heading-elements">
          <a href="<?= RACINE ?>user/details/<?= $this->validator->crypter($userProfile['code_user']) ?>" class="btn btn-sm btn-outline-secondary">
              <i class="fa fa-arrow-left"></i> Retour au profil
          </a>
      </div>
  </div>

    <div class="content-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Modifier l'utilisateur</h4>
            </div>
            <div class="card-body">
              <form class="formEditUser" method="POST">
                <input type="hidden" id="id_user" name="id_user" value="<?= ($userProfile['id_user'] ?? '') ?>">

                <!-- Email -->
                <div class="form-group">
                  <label for="email">Email :</label>
                  <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email_user" 
                           value="<?= ($userProfile['email_user'] ?? '') ?>" 
                          >
                    <span class="input-group-addon"> <?= Validator::icon('envelope'); ?></span>
                  </div>
                  <div class="error-message" id="emailError"></div>
                </div>

                <!-- Nom -->
                <div class="form-group">
                  <label for="nom">Nom :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nom" name="nom_user" 
                           value="<?= ($userProfile['nom_user'] ?? '') ?>" required>
                    <span class="input-group-addon"> <?= Validator::icon('user'); ?></span>
                  </div>
                  <div class="error-message" id="nomError"></div>
                </div>

                <!-- Prénom -->
                <div class="form-group">
                  <label for="prenom">Prénom :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="prenom" name="prenom_user" 
                           value="<?= ($userProfile['prenom_user'] ?? '') ?>">
                    <span class="input-group-addon"> <?= Validator::icon('user'); ?></span>
                  </div>
                  <div class="error-message" id="prenomError"></div>
                </div>

                <!-- Téléphone -->
                <div class="form-group">
                  <label for="telephone">Numéro de Téléphone:</label>
                  <div class="input-group">
                    <input type="tel" class="form-control" id="telephone" name="telephone_user" 
                           value="<?= ($userProfile['telephone_user'] ?? '') ?>" 
                           maxlength="10" required pattern="[0-9]{10}">
                    <span class="input-group-addon"> <?= Validator::icon('phone'); ?></span>
                  </div>
                  <div class="error-message" id="telephoneError"></div>
                </div>

                <!-- Quartier -->
                <div class="form-group">
                  <label for="quartier">Quartier :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="quartier" name="quartier_user" 
                           value="<?= ($userProfile['quartier_user'] ?? '') ?>">
                    <span class="input-group-addon"> <?= Validator::icon('map-pin'); ?></span>
                  </div>
                  <div class="error-message" id="quartierError"></div>
                </div>

                <!-- Zone -->
                <div class="form-group">
                  <label for="zone">Zone :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="zone" name="zone_user" 
                           value="<?= ($userProfile['zone_user'] ?? '') ?>">
                    <span class="input-group-addon"> <?= Validator::icon('map'); ?></span>
                  </div>
                  <div class="error-message" id="zoneError"></div>
                </div>

                <!-- Rôle -->
                <div class="form-group">
                  <label for="role">Rôle:</label>
                  <div class="input-group">
                    <select class="form-control" id="role" name="role_code" required>
                      <option value="">... Sélectionnez un rôle ...</option>
                      <?php if (isset($allRoles) && !empty($allRoles)){ ?>
                        <?php foreach ($allRoles as $role): ?>
                          <option value="<?= $role['code_role'] ?>" <?= ($userProfile['role_code'] ?? '') == $role['code_role'] ? 'selected' : '' ?>><?= htmlspecialchars($role['libelle_role']) ?></option>
                        <?php endforeach; ?>
                      <?php } ?>
                       
                    </select>
                    <span class="input-group-addon"> <?= Validator::icon('user-secret'); ?></span>
                  </div>
                  <div class="error-message" id="roleError"></div>
                </div>

                <!-- Informations système (lecture seule) -->
                <div class="form-group">
                  <label>Code utilisateur :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" 
                           value="<?= ($userProfile['code_user'] ?? '') ?>" readonly>
                    <span class="input-group-addon"> <?= Validator::icon('code'); ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label>Membre depuis :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" 
                           value="<?= Validator::formatDate($userProfile['date_created_user'] ?? '') ?>" readonly>
                    <span class="input-group-addon"> <?= Validator::icon('calendar'); ?></span>
                  </div>
                </div>

                <div class="form-actions">
                  <button type="submit" class="btn btn-primary btn_actions">
                    <i class="fa fa-save"></i> Sauvegarder
                  </button>
                  <a href="<?= RACINE ?>admin/users" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i> Annuler
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Content -->


<?php require_once '../public/inc/footer.php'; ?>
