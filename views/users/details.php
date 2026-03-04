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
      <!-- Profil utilisateur -->
      <section class="row">
        <div class="col-12 col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="card-img-actions text-center">
                <div class="card-img-actions-inner">
                  <img class="img-responsive img-rounded" src="<?= RACINE ?>public/app-assets/images/portrait/small/avatar-s-1.png" alt="Photo de profil" width="120" height="120">
                  <h4 class="mt-2"><?= htmlspecialchars($userProfile['nom']) ?></h4>
                  <p class="text-muted"><?= htmlspecialchars($userProfile['email']) ?></p>
                  <span class="badge badge-<?= $userProfile['actif'] == 1 ? 'success' : 'danger' ?>">
                    <?= $userProfile['actif'] == 1 ? 'Actif' : 'Inactif' ?>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Informations détaillées -->
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Informations</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Code Utilisateur</h5>
                      <p><?= htmlspecialchars($userProfile['code_user']) ?></p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Nom Complet</h5>
                      <p><?= htmlspecialchars($userProfile['nom']) ?></p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Téléphone</h5>
                      <p><?= htmlspecialchars($userProfile['telephone']) ?></p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Email</h5>
                      <p><?= htmlspecialchars($userProfile['email']) ?></p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Rôle</h5>
                      <p>
                        <span class="badge badge-<?= $userProfile['role'] == 'admin' ? 'primary' : ($userProfile['role'] == 'livreur' ? 'info' : 'secondary') ?>">
                          <?= ucfirst($userProfile['role']) ?>
                        </span>
                      </p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Statut</h5>
                      <p><span class="badge badge-<?= $userProfile['actif'] == 1 ? 'success' : 'danger' ?>"><?= $userProfile['actif'] == 1 ? 'Actif' : 'Inactif' ?></span></p>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Membre depuis</h5>
                      <p><?= Validator::formatDate($userProfile['created_at']) ?></p>
                    </div>
                  </div>
                  <?php if ($userProfile['updated_at']): ?>
                  <div class="media">
                    <div class="media-body">
                      <h5 class="media-heading">Dernière modification</h5>
                      <p><?= Validator::formatDate($userProfile['updated_at']) ?></p>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="card">
            <div class="card-body">
              <div class="text-center">
                <a href="<?= RACINE ?>user/edition/<?= $userProfile['id_user'] ?>" class="btn btn-primary">
                  <i class="fa fa-edit"></i> Modifier
                </a>
                <button onclick="toggleUserStatus(<?= $userProfile['id_user'] ?>)" class="btn btn-<?= $userProfile['actif'] == 1 ? 'warning' : 'success' ?>">
                  <i class="fa fa-<?= $userProfile['actif'] == 1 ? 'lock' : 'unlock' ?>"></i>
                  <?= $userProfile['actif'] == 1 ? 'Désactiver' : 'Activer' ?>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Contenu secondaire -->
        <div class="col-12 col-md-8">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Informations système</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="media">
                    <div class="media-left">
                      <i class="fa fa-database mr-2"></i>
                    </div>
                    <div class="media-body">
                      <h5 class="media-heading">ID Utilisateur</h5>
                      <p>#<?= $userProfile['id_user'] ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="media">
                    <div class="media-left">
                      <i class="fa fa-shield mr-2"></i>
                    </div>
                    <div class="media-body">
                      <h5 class="media-heading">Sécurité</h5>
                      <p>Mot de passe hashé</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
function toggleUserStatus(userId) {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de cet utilisateur ?')) {
        $.ajax({
            url: '<?= RACINE ?>admin/users/changer',
            type: 'POST',
            data: { id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    toastr.error(response.msg);
                }
            },
            error: function() {
                toastr.error('Une erreur est survenue');
            }
        });
    }
}

function editUser(userId) {
    window.location.href = '<?= RACINE ?>user/edition/' + btoa(userId);
}
</script>

<!-- END: Content -->

<?php require_once '../public/inc/footer.php'; ?>
