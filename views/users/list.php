<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <i class="feather icon-users"></i> Gestion des Utilisateurs
                        </h4>
                        <a class="heading-elements-toggle"><i class="feather icon-user-plus font-medium-3 btn btn-round btn-primary btn-sm"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <span>
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addUsertModal">
                                        <i class="feather icon-user-plus"></i> Nouvel Utilisateur
                                    </button>
                                </span>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users-contacts" class="table table-striped table-bordered dataex-visibility-disable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>Téléphone</th>
                                        <th>Email</th>
                                        <th>Rôle</th>
                                        <th>Statut</th>
                                        <th>Détails</th>
                                        <th>Modification</th>
                                        <th>Etat </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($users as $user): $i++;
                                        $cryptedParams = $this->validator->crypter($user['id_user']); ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= htmlspecialchars($user['nom_user'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($user['telephone_user'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($user['email_user'] ?? 'N/A') ?></td>
                                            <td>
                                                <span class="badge badge-<?= $user['role_code'] == 'ROLE-ADMIN-001' ? 'primary' : ($user['role_code'] == 'ROLE-COM-001' ? 'info' : 'secondary') ?>">
                                                    <?= ucfirst($user['role_code'] ?? '') ?>
                                                </span>
                                            </td>
                                            <td><?= Validator::viewStatus('lock', 'unlock', $user['etat_user'], STATUS_ACTIVE) ?></td>
                                            <td>
                                                <a href="<?= RACINE ?>user/details/<?= $cryptedParams; ?>" class="btn btn-sm btn-outline-primary mr-1" title="Détails">
                                                    <?= Validator::icon('eye'); ?> Détails
                                                </a>
                                                </td>
                                                <td>
                                                <a href="<?= RACINE ?>user/edition/<?= $cryptedParams; ?>" class="btn btn-sm btn-primary mr-1" title="Modifier">
                                                    <?= Validator::icon('edit'); ?> Modifier
                                                </a>
                                                </td>
                                                <td>
                                                <button onclick="changeDeleteById('userController/changer',<?= $user['id_user']; ?>)" class="btn btn-sm btn-<?= $user['etat_user'] == 1 ? 'warning' : 'success' ?>" title="Changer le statut">
                                                    <?= Validator::icon('retweet'); ?> Changer
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUsertModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        
            <!-- En-tête -->
            <div class="modal-header text-light">
                <h5 class="modal-title" id="modalTitle">Espace d'enregistrement</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body">
            <form class="formUser" method="POST">
                         <!-- chambre -->

          <!-- Email -->
          <div class="form-group">
              <label for="email">Email :</label>
              <div class="input-group">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Entrer l'adresse email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                  <span class="input-group-addon"> <?=Validator::icon('envelope'); ?></span>
              </div>
              <div class="error-message" id="emailError"></div>
          </div>

          <!-- Nom -->
          <div class="form-group">
              <label for="nom">Nom :</label>
              <div class="input-group">
                  <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrer le nom complet" required>
                  <span class="input-group-addon"> <?=Validator::icon('user'); ?></span>
              </div>
              <div class="error-message" id="nomError"></div>
          </div>

          <!-- Téléphone -->
          <div class="form-group">
              <label for="telephone">Numéro de Téléphone:</label>
              <div class="input-group">
                  <input type="tel" class="form-control" id="telephone" name="telephone" maxlength="10" placeholder="Entrer 10 chiffres" required pattern="[0-9]{10}">
                  <span class="input-group-addon"> <?=Validator::icon('phone'); ?></span>
              </div>
              <div class="error-message" id="telephoneError"></div>
          </div>

          <!-- Rôle -->
          <div class="form-group">
              <label for="role">Rôle:</label>
              <div class="input-group">
                  <select class="form-control" id="role" name="role" required>
                      <option value="">... Sélectionnez un rôle ...</option>
                      <?php if (isset($allRoles) && !empty($allRoles)): ?>
                        <?php foreach ($allRoles as $role): ?>
                          <option value="<?= $role['code_role'] ?>"><?= htmlspecialchars($role['libelle_role']) ?></option>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <option value="ROLE-ADMIN-001">Administrateur</option>
                        <option value="ROLE-COMP-001">Comptable</option>
                        <option value="ROLE-SUP-001">Superviseur</option>
                        <option value="ROLE-COM-001">Commercial</option>
                      <?php endif; ?>
                  </select>
                  <span class="input-group-addon"> <?=Validator::icon('user-secret'); ?></span>
              </div>
              <div class="error-message" id="roleError"></div>
          </div>

          <!-- Prénom -->
          <div class="form-group">
              <label for="prenom">Prénom :</label>
              <div class="input-group">
                  <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrer le prénom" required>
                  <span class="input-group-addon"> <?=Validator::icon('user'); ?></span>
              </div>
              <div class="error-message" id="prenomError"></div>
          </div>

          <!-- Quartier -->
          <div class="form-group">
              <label for="quartier">Quartier :</label>
              <div class="input-group">
                  <input type="text" class="form-control" id="quartier" name="quartier" placeholder="Quartier" required>
                  <span class="input-group-addon"> <?=Validator::icon('map-pin'); ?></span>
              </div>
              <div class="error-message" id="quartierError"></div>
          </div>

          <!-- Zone -->
          <div class="form-group">
              <label for="zone">Zone :</label>
              <div class="input-group">
                  <input type="text" class="form-control" id="zone" name="zone" placeholder="Zone" required>
                  <span class="input-group-addon"> <?=Validator::icon('map'); ?></span>
              </div>
              <div class="error-message" id="zoneError"></div>
          </div>

        <!-- Pied de page -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn_actions">Sauvegarder</button>
        <span type="button" class="btn btn-danger" data-dismiss="modal">Annuler</span>
      </div>
      </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delete-user').on('click', function() {
            const id = $(this).data('id');
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                $.ajax({
                    url: '<?= RACINE ?>admin/users/delete',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status == 1) {
                            toastr.success(res.msg);
                            location.reload();
                        } else {
                            toastr.error(res.msg);
                        }
                    }
                });
            }
        });

        $('.toggle-status').on('click', function() {
            const id = $(this).data('id');
            $.ajax({
                url: '<?= RACINE ?>admin/users/toggleStatus',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status == 1) {
                        toastr.success(res.msg);
                        location.reload();
                    } else {
                        toastr.error(res.msg);
                    }
                }
            });
        });
    });
</script>

<?php require_once '../public/inc/footer.php'; ?>