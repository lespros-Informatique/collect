<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content -->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="col-sm-12">
        <a href="<?= RACINE ?>admin/users" class="btn btn-sm btn-outline-secondary">
          <i class="fa fa-arrow-left"></i> Retour à la liste
        </a>
      </div>
    </div>

    <div class="content-body">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Modifier l'utilisateur</h4>
            </div>
            <div class="card-body">
              <form class="formEdituser" method="POST">
                <input type="hidden" id="id_user" name="id_user" value="<?= htmlspecialchars($userProfile['id_user']) ?>">

                <!-- Email -->
                <div class="form-group">
                  <label for="email">Email :</label>
                  <div class="input-group">
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($userProfile['email']) ?>" required 
                           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    <span class="input-group-addon"> <?= Validator::icon('envelope'); ?></span>
                  </div>
                  <div class="error-message" id="emailError"></div>
                </div>

                <!-- Nom -->
                <div class="form-group">
                  <label for="nom">Nom :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nom" name="nom" 
                           value="<?= htmlspecialchars($userProfile['nom']) ?>" required>
                    <span class="input-group-addon"> <?= Validator::icon('user'); ?></span>
                  </div>
                  <div class="error-message" id="nomError"></div>
                </div>

                <!-- Téléphone -->
                <div class="form-group">
                  <label for="telephone">Numéro de Téléphone:</label>
                  <div class="input-group">
                    <input type="tel" class="form-control" id="telephone" name="telephone" 
                           value="<?= htmlspecialchars($userProfile['telephone']) ?>" 
                           maxlength="10" required pattern="[0-9]{10}">
                    <span class="input-group-addon"> <?= Validator::icon('phone'); ?></span>
                  </div>
                  <div class="error-message" id="telephoneError"></div>
                </div>

                <!-- Rôle -->
                <div class="form-group">
                  <label for="role">Rôle:</label>
                  <div class="input-group">
                    <select class="form-control" id="role" name="role" required>
                      <option value="">... Sélectionnez un rôle ...</option>
                      <option value="admin" <?= $userProfile['role'] == 'admin' ? 'selected' : '' ?>>Administrateur</option>
                      <option value="staff" <?= $userProfile['role'] == 'staff' ? 'selected' : '' ?>>Personnel</option>
                      <option value="livreur" <?= $userProfile['role'] == 'livreur' ? 'selected' : '' ?>>Livreur</option>
                    </select>
                    <span class="input-group-addon"> <?= Validator::icon('user-secret'); ?></span>
                  </div>
                  <div class="error-message" id="roleError"></div>
                </div>

                <!-- Statut -->
                <div class="form-group">
                  <label for="actif">Statut:</label>
                  <div class="input-group">
                    <select class="form-control" id="actif" name="actif" required>
                      <option value="">... Sélectionnez le statut ...</option>
                      <option value="1" <?= $userProfile['actif'] == 1 ? 'selected' : '' ?>>Actif</option>
                      <option value="0" <?= $userProfile['actif'] == 0 ? 'selected' : '' ?>>Inactif</option>
                    </select>
                    <span class="input-group-addon"> <?= Validator::icon('toggle-on'); ?></span>
                  </div>
                  <div class="error-message" id="actifError"></div>
                </div>

                <!-- Informations système (lecture seule) -->
                <div class="form-group">
                  <label>Code utilisateur :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($userProfile['code_user']) ?>" readonly>
                    <span class="input-group-addon"> <?= Validator::icon('code'); ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label>Membre depuis :</label>
                  <div class="input-group">
                    <input type="text" class="form-control" 
                           value="<?= Validator::formatDate($userProfile['created_at']) ?>" readonly>
                    <span class="input-group-addon"> <?= Validator::icon('calendar'); ?></span>
                  </div>
                </div>

                <div class="form-actions">
                  <button type="submit" class="btn btn-primary btn_actions">
                    <i class="fa fa-save"></i> Sauvegarder
                  </button>
                  <a href="<?= RACINE ?>admin/users" class="btn btn-secondary">
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