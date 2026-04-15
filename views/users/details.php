<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content -->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body">
      <div class="row">
        <!-- Colonne gauche - Photo et infos principales -->
        <div class="col-12 col-md-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="feather icon-user"></i> Profil Utilisateur</h4>
              <div class="heading-elements">
                <a href="<?= RACINE ?>admin/users" class="btn btn-sm btn-outline-secondary">
                  <i class="fa fa-arrow-left"></i> Retour
                </a>
              </div>
            </div>
            <div class="card-body text-center">
              <div class="mb-3">
                <?php if (!empty($userProfile['photo_user'])): ?>
                  <img class="img-rounded rounded-circle" src="<?= RACINE ?>public/uploads/users/<?= htmlspecialchars($userProfile['photo_user']) ?>" alt="Photo de profil" width="140" height="140" style="object-fit: cover;">
                <?php else: ?>
                  <img class="img-rounded rounded-circle" src="<?= RACINE ?>public/app-assets/images/portrait/small/avatar-s-1.png" alt="Photo de profil" width="140" height="140">
                <?php endif; ?>
              </div>
              <h4 class="font-weight-bold"><?= htmlspecialchars(($userProfile['nom_user'] ?? '') . ' ' . ($userProfile['prenom_user'] ?? '')) ?></h4>
              <p class="text-muted mb-2"><?= htmlspecialchars($userProfile['email_user'] ?? 'N/A') ?></p>
              <span class="badge badge-<?= $userProfile['etat_user'] == 1 ? 'success' : 'danger' ?> mb-3">
                <?= $userProfile['etat_user'] == 1 ? 'Actif' : 'Inactif' ?>
              </span>
              <div class="d-flex justify-content-center gap-2">
                <a href="<?= RACINE ?>user/edition/<?= $userProfile['id_user'] ?>" class="btn btn-primary btn-sm">
                  <i class="fa fa-edit"></i> Modifier
                </a>
                <button onclick="toggleUserStatus(<?= $userProfile['id_user'] ?>)" class="btn btn-<?= $userProfile['etat_user'] == 1 ? 'warning' : 'success' ?> btn-sm">
                  <i class="fa fa-<?= $userProfile['etat_user'] == 1 ? 'lock' : 'unlock' ?>"></i>
                  <?= $userProfile['etat_user'] == 1 ? 'Désactiver' : 'Activer' ?>
                </button>
              </div>
            </div>
          </div>

          <!-- Pièce d'identité -->
          <div class="card mt-3">
            <div class="card-header">
              <h5 class="card-title"><i class="fa fa-id-card"></i> Pièce d'identité</h5>
            </div>
            <div class="card-body">
              <?php if (!empty($userProfile['piece_user'])): ?>
                <p class="mb-2"><strong>Numéro:</strong> <?= htmlspecialchars($userProfile['piece_user']) ?></p>
                <?php if (strpos($userProfile['piece_user'], '.') !== false): ?>
                  <img src="<?= RACINE ?>public/uploads/pieces/<?= htmlspecialchars($userProfile['piece_user']) ?>" alt="Pièce d'identité" class="img-fluid rounded" style="max-height: 200px;">
                <?php endif; ?>
              <?php else: ?>
                <p class="text-muted mb-0">Aucune pièce enregistrée</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Colonne droite - Détails complets -->
        <div class="col-12 col-md-8">
          <!-- Informations personnelles -->
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-user"></i> Informations personnelles</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Code Utilisateur</small>
                      <strong><?= htmlspecialchars($userProfile['code_user'] ?? '') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Téléphone</small>
                      <strong><?= htmlspecialchars($userProfile['telephone_user'] ?? '') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Email</small>
                      <strong><?= htmlspecialchars($userProfile['email_user'] ?? 'N/A') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Quartier</small>
                      <strong><?= htmlspecialchars($userProfile['quartier_user'] ?? 'N/A') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Zone</small>
                      <strong><?= htmlspecialchars($userProfile['zone_user'] ?? 'N/A') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Membre depuis</small>
                      <strong><?= Validator::formatDate($userProfile['date_created_user'] ?? '') ?></strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Informations professionnelles -->
          <div class="card mt-3">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-briefcase"></i> Informations professionnelles</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Rôle</small>
                      <span class="badge badge-<?= $userProfile['role_code'] == 'code-admin' ? 'primary' : ($userProfile['role_code'] == 'code-commercial' ? 'info' : 'secondary') ?>">
                        <?= htmlspecialchars($userProfile['role_code'] ?? '') ?>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Succursale</small>
                      <strong><?= htmlspecialchars($userProfile['succursale_code'] ?? 'N/A') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">Créé par</small>
                      <strong><?= htmlspecialchars($userProfile['user_code'] ?? 'Système') ?></strong>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="media">
                    <div class="media-body">
                      <small class="text-muted d-block">ID Utilisateur</small>
                      <strong>#<?= $userProfile['id_user'] ?></strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Statut -->
          <div class="card mt-3">
            <div class="card-header">
              <h4 class="card-title"><i class="fa fa-toggle-on"></i> Statut du compte</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 text-center">
                  <div class="p-3 rounded" style="background-color: <?= $userProfile['etat_user'] == 1 ? '#d4edda' : '#f8d7da' ?>;">
                    <i class="fa fa-<?= $userProfile['etat_user'] == 1 ? 'check-circle' : 'times-circle' ?> fa-2x mb-2" style="color: <?= $userProfile['etat_user'] == 1 ? '#28a745' : '#dc3545' ?>;"></i>
                    <br>
                    <strong><?= $userProfile['etat_user'] == 1 ? 'Compte actif' : 'Compte inactif' ?></strong>
                  </div>
                </div>
                <div class="col-md-4 text-center">
                  <div class="p-3 rounded" style="background-color: #d1ecf1;">
                    <i class="fa fa-shield fa-2x mb-2" style="color: #17a2b8;"></i>
                    <br>
                    <strong>Mot de passe hashé</strong>
                  </div>
                </div>
                <div class="col-md-4 text-center">
                  <div class="p-3 rounded" style="background-color: #fff3cd;">
                    <i class="fa fa-clock-o fa-2x mb-2" style="color: #ffc107;"></i>
                    <br>
                    <strong><?= Validator::formatDate($userProfile['date_created_user'] ?? '') ?></strong>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Bouton Clients -->
          <div class="card mt-3">
            <div class="card-body text-center">
              <a href="<?= RACINE ?>admin/clients/user/<?= $validator->crypter($userProfile['code_user']) ?>" class="btn btn-lg btn-primary">
                <i class="fa fa-users"></i> Voir les clients (<?= $clientCount ?>)
              </a>
            </div>
          </div>
        </div>
      </div>
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