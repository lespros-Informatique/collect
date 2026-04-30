<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="feather icon-gift"></i> Choisir un Kit pour <?= htmlspecialchars($client['nom_client'] ?? '') ?>
                            </h4>
                            <div class="heading-elements">
                                <a href="<?= RACINE ?>admin/clients" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-arrow-left"></i> Retour
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Informations client -->
                            <div class="alert alert-info">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Téléphone:</strong> <?= htmlspecialchars($client['telephone_client'] ?? '') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Quartier:</strong> <?= htmlspecialchars($client['quartier_client'] ?? '') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Zone:</strong> <?= htmlspecialchars($client['zone_client'] ?? '') ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulaire pour les autres champs -->
                            <form class="formChoixKit" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="client_code" value="<?= htmlspecialchars($clientCode ?? '') ?>">
                                
                                <!-- Type d'inscription -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type_inscription">Type d'inscription :</label>
                                            <div class="input-group">
                                                <input type="text" readonly class="form-control" id="type_inscription" value="inscription" name="type_inscription" required>
                                                <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (ROLE !== ROLE_COMMERCIAL){ ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="commercial">Commercial :</label>
                                                <select class="form-control select2" id="commercial" name="user_code" required>
                                                    <option value="">Sélectionner un commercial</option>
                                                    <?php foreach ($users as $user): ?>
                                                        <option value="<?= htmlspecialchars($user['user_code']) ?>" 
                                                            <?= ($user['user_code'] == $client['user_code']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($user['nom_user'] . ' ' . $user['prenom_user']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                        <input type="hidden" id="commercial" name="user_code" value="<?= $_SESSION['code_user'] ?>">
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sélection des kits -->
            <div class="row mt-2">
                <!-- Liste des kits disponibles -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="feather icon-box"></i> Kits disponibles
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Filtrer par catégorie -->
                            <div class="form-group">
                                <label for="filter_categorie">Filtrer par catégorie :</label>
                                <select class="form-control" id="filter_categorie" name="filter_categorie">
                                    <option value="">Toutes les catégories</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= htmlspecialchars($cat['code_categorie']) ?>">
                                            <?= htmlspecialchars($cat['libelle_categorie']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Grille des kits -->
                            <div class="row" id="kitsContainer">
                                <?php foreach ($choixList as $kit): ?>
                                    <div class="col-md-6 col-lg-4 kit-card" data-categorie="<?= htmlspecialchars($kit['categorie_code']) ?>">
                                        <div class="card text-center h-100">
                                            <div class="card-body">
                                                <?php if(!empty($kit['img_choix'])): ?>
                                                    <img src="<?= RACINE . $kit['img_choix'] ?>" alt="<?= htmlspecialchars($kit['libelle_choix']) ?>" 
                                                        class="img-fluid mb-2" style="max-height: 120px; object-fit: contain;">
                                                <?php else: ?>
                                                    <div class="bg-secondary text-white rounded p-4 mb-2" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="feather icon-gift" style="font-size: 48px;"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <h5><?= htmlspecialchars($kit['libelle_choix']) ?></h5>
                                                <p class="text-muted small"><?= htmlspecialchars($kit['description_choix'] ?? 'Aucune description') ?></p>
                                                <span class="badge badge-success" style="font-size: 16px;">
                                                    <?= number_format($kit['cotisation_choix'], 0, ',', ' ') ?> CFA
                                                </span>
                                            </div>
                                            <div class="card-footer bg-transparent">
                                                <button type="button" class="btn btn-primary btn-sm btn-choose-kit" 
                                                        data-code="<?= htmlspecialchars($kit['code_choix']) ?>"
                                                        data-libelle="<?= htmlspecialchars($kit['libelle_choix']) ?>"
                                                        data-cotisation="<?= htmlspecialchars($kit['cotisation_choix']) ?>">
                                                    <i class="feather icon-eye"></i> Voir & Choisir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panier / Sélection -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h4 class="card-title text-white">
                                <i class="feather icon-shopping-cart"></i> Ma sélection
                            </h4>
                        </div>
                        <div class="card-body">
                            <div id="selectionContainer">
                                <div class="text-center text-muted py-4">
                                    <i class="feather icon-shopping-cart" style="font-size: 48px;"></i>
                                    <p class="mt-2">Aucun kit sélectionné</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-success btn-block btn_actions formChoixKitSubmit">
                                <i class="feather icon-check-circle"></i> Finaliser l'inscription
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../public/inc/footer.php'; ?>
