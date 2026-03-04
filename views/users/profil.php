<?php require_once '../public/inc/header.php'; ?>

<style>
  @media (max-width: 767px) {
    .card {
      margin-left: 5px;
      margin-right: 5px;
    }
  }
</style>

<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 mb-2">
        </div>
      </div>
      
      <div class="content-body">
        <section id="user-profile">
          <div class="row justify-content-center">
            <div class="col-12 col-md-8 px-1">
              <div class="card shadow-lg rounded-lg">
                <div class="card-body text-center">
                <h2 class="content-header-title text-center">
                    <i class="feather icon-user"></i> Mon Profil
                </h2>
                <!-- Cover -->
              
        <div class="col-md-12 col-12 d-flex align-items-center justify-content-center">
          <div class="text-center">
            <div class="avatar bg-primary mb-1" style="width: 80px; height: 80px;">
              <span class="avatar-content" style="font-size: 2.5rem;">
                <i class="feather icon-user text-white"></i>
              </span>
            </div>
          </div>
        </div>

           
           
                <!-- Nom et Titre -->
                <h3 class="text-muted mb-3"><?= ROLE; ?></h3>

                <!-- Infos principales -->
                <div class="text-left mt-4 px-3">
                  <h5 class="alert alert-primary" >
                      <i class="feather icon-info"></i> Informations personnelles
                  </h5>
                  <hr>
                  <table class="table table-borderless">
                      <tr>
                          <td><strong><i class="feather icon-user"></i> Nom & Prénoms :</strong></td>
                          <td><?= htmlspecialchars(USER_NAME); ?></td>
                      </tr>
                      <tr>
                          <td><strong><i class="feather icon-phone"></i> Téléphone :</strong></td>
                          <td><?= htmlspecialchars(USER_PHONE); ?></td>
                      </tr>
                   
                      <tr>
                          <td><strong><i class="feather icon-users"></i> Email :</strong></td>
                          <td><?= htmlspecialchars(USER_EMAIL); ?></td>
                      </tr>
                  </table>
                </div>


                <!-- Paramètres -->
                <div class="text-left mt-4 px-3 mb-4">
                  <h5 class="alert alert-warning" >
                      <i class="feather icon-lock"></i> Changer votre mot de passe
                  </h5>

                  <hr>
                  <form class="formEditPassword" method="POST">
                      
                    <div class="form-group">
                      <label for="anPassword">Ancien mot de passe *</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="feather icon-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="password" id="anPassword" placeholder="*************" required>
                        <div class="input-group-append">
                          <span class="input-group-text" onclick="profilTogglePassword('anPassword')" style="cursor: pointer;">
                            <i class="feather icon-eye" id="togglePasswordIcon"></i>
                          </span>
                        </div>
                      </div>
                      <div class="error-message text-danger" id="anPasswordError"></div>
                    </div>
                    
                    <div class="form-group">
                      <label for="newPassword">Nouveau mot de passe *</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="feather icon-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="*************" required>
                        <div class="input-group-append">
                          <span class="input-group-text" onclick="profilTogglePassword('newPassword')" style="cursor: pointer;">
                            <i class="feather icon-eye" id="newTogglePasswordIcon"></i>
                          </span>
                        </div>
                      </div>
                      <div class="error-message text-danger" id="newPasswordError"></div>
                      <small class="form-text text-muted">Le mot de passe doit contenir au moins 6 caractères</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-2 btn_actions">
                        <i class="feather icon-save"></i> Modifier maintenant
                    </button>
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
<?php require_once '../public/inc/footer.php'; ?>
