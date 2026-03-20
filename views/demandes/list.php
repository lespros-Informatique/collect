<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Demandes de Carnets</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group">
                    <a href="<?= $validator->url('admin/demandes/add') ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Nouvelle demande
                    </a>
                    <a href="<?= $validator->url('admin/demandes/stocks') ?>" class="btn btn-info btn-sm">
                        <i class="fa fa-cubes"></i> Gestion des stocks
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistiques -->
        <div class="row match-height">
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="info"><?= $stats['total'] ?? 0 ?></h3>
                                    <h6>Total demandes</h6>
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-file-text info font-large-2 float-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="warning"><?= $stats['en_attente'] ?? 0 ?></h3>
                                    <h6>En attente</h6>
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-clock-o warning font-large-2 float-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="success"><?= $stats['validees'] ?? 0 ?></h3>
                                    <h6>Validées</h6>
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-check success font-large-2 float-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="danger"><?= $stats['rejetees'] ?? 0 ?></h3>
                                    <h6>Rejetées</h6>
                                </div>
                                <div class="align-self-center">
                                    <i class="fa fa-times danger font-large-2 float-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Liste des demandes</h4>
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <table class="table table-striped table-bordered" id="demandes-table">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Quantité</th>
                                                <th>Catégorie</th>
                                                <th>Utilisateur</th>
                                                <th>Statut</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($demandes)): ?>
                                                <?php foreach ($demandes as $demande): 
                                                    $userName = '';
                                                    foreach ($users as $user) {
                                                        if ($user['code_user'] == $demande['utilisateur_code']) {
                                                            $userName = $user['nom_user'] . ' ' . $user['prenom_user'];
                                                            break;
                                                        }
                                                    }
                                                    
                                                    $catName = '';
                                                    foreach ($categories as $cat) {
                                                        if ($cat['code_categorie'] == $demande['categorie_code']) {
                                                            $catName = $cat['libelle_categorie'];
                                                            break;
                                                        }
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?= $demande['code_demande'] ?></td>
                                                        <td><?= $demande['total_demande'] ?></td>
                                                        <td><?= $catName ?: '-' ?></td>
                                                        <td><?= $userName ?: '-' ?></td>
                                                        <td>
                                                            <?php if ($demande['etat_demande'] == 1): ?>
                                                                <span class="badge badge-warning">En attente</span>
                                                            <?php elseif ($demande['etat_demande'] == 2): ?>
                                                                <span class="badge badge-success">Validée</span>
                                                            <?php else: ?>
                                                                <span class="badge badge-danger">Rejetée</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= date('d/m/Y H:i', strtotime($demande['created_at_demande'])) ?></td>
                                                        <td>
                                                            <?php if ($demande['etat_demande'] == 1): ?>
                                                                <button class="btn btn-success btn-sm btn-valider-demande" data-code="<?= $demande['code_demande'] ?>" title="Valider">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                                <button class="btn btn-danger btn-sm btn-rejeter-demande" data-code="<?= $demande['code_demande'] ?>" title="Rejeter">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            <a href="<?= $validator->url('admin/demandes/details/' . $validator->crypter($demande['code_demande'])) ?>" class="btn btn-info btn-sm" title="Détails">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">Aucune demande trouvée</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include '../public/inc/footer.php'; ?>

<script>
$(document).ready(function() {
    $('#demandes-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        }
    });
});
</script>
