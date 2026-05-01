<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Détails de la Demande</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="btn-group">
                    <a href="<?= $validator->url('admin/demandes') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="user-profile">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (!empty($demande)): ?>
                        <div class="card profile-with-cover">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="profiletimeline-section">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-primary">
                                                        <h4 class="card-title text-white">Informations de la demande</h4>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <ul class="list-group list-group-unbordered">
                                                                <li class="list-group-item">
                                                                    <strong>Code:</strong> 
                                                                    <span class="float-right"><?= $demande['code_demande'] ?></span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Quantité:</strong> 
                                                                    <span class="float-right"><?= $demande['total_demande'] ?> carnets</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Catégorie:</strong> 
                                                                    <span class="float-right"><?= $demande['categorie_code'] ?: '-' ?></span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Utilisateur:</strong> 
                                                                    <span class="float-right"><?= $demande['utilisateur_code'] ?: '-' ?></span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Statut:</strong> 
                                                                    <span class="float-right">
                                                                        <?php if ($demande['etat_demande'] == 1): ?>
                                                                            <span class="badge badge-warning">En attente</span>
                                                                        <?php elseif ($demande['etat_demande'] == 2): ?>
                                                                            <span class="badge badge-success">Validée</span>
                                                                        <?php else: ?>
                                                                            <span class="badge badge-danger">Rejetée</span>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Gestionnaire:</strong> 
                                                                    <span class="float-right"><?= $demande['gestionnaire_code'] ?: '-' ?></span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Date de création:</strong> 
                                                                    <span class="float-right"><?= date('d/m/Y H:i', strtotime($demande['created_at_demande'])) ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <?php if ($demande['etat_demande'] == 1): ?>
                                                <div class="card">
                                                    <div class="card-header bg-success">
                                                        <h4 class="card-title text-white">Actions</h4>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body text-center">
                                                            <button class="btn btn-success btn-lg mb-1 btn-valider-demande" data-code="<?= $demande['code_demande'] ?>">
                                                                <i class="fa fa-check"></i> Valider la demande
                                                            </button>
                                                            <button class="btn btn-danger btn-lg mb-1 btn-rejeter-demande" data-code="<?= $demande['code_demande'] ?>">
                                                                <i class="fa fa-times"></i> Rejeter la demande
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-danger">
                            Demande introuvable.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include '../public/inc/footer.php'; ?>
