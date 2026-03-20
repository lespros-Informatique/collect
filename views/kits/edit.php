<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content -->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="col-sm-12">
                <a href="<?= RACINE ?>admin/kits" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>

        <div class="content-body">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Modifier le kit</h4>
                        </div>
                        <div class="card-body">
                            <form class="formKitEdit" method="POST" enctype="multipart/form-data">
                                <input type="hidden" id="id" name="id" value="<?= $kit['id_choix'] ?? '' ?>">

                                <!-- Catégorie -->
                                <div class="form-group">
                                    <label for="categorie">Catégorie :</label>
                                    <div class="input-group">
                                        <select class="form-control" id="categorie" name="categorie" required>
                                            <option value="">... Sélectionnez une catégorie ...</option>
                                            <?php if (isset($categories) && !empty($categories)): ?>
                                                <?php foreach ($categories as $categorie): ?>
                                                    <option value="<?= $categorie['code_categorie'] ?>" <?= ($kit['categorie_code'] ?? '') == $categorie['code_categorie'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($categorie['libelle_categorie']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <span class="input-group-addon"><i class="feather icon-tag"></i></span>
                                    </div>
                                </div>

                                <!-- Libellé -->
                                <div class="form-group">
                                    <label for="libelle">Libellé :</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="libelle" name="libelle" 
                                               value="<?= htmlspecialchars($kit['libelle_choix'] ?? '') ?>" required>
                                        <span class="input-group-addon"><i class="feather icon-gift"></i></span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description :</label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($kit['description_choix'] ?? '') ?></textarea>
                                        <span class="input-group-addon"><i class="feather icon-file-text"></i></span>
                                    </div>
                                </div>

                                <!-- Cotisation -->
                                <div class="form-group">
                                    <label for="cotisation">Cotisation :</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="cotisation" name="cotisation" 
                                               value="<?= $kit['cotisation_choix'] ?? '' ?>" required>
                                        <span class="input-group-addon"><i class="feather icon-dollar-sign"></i></span>
                                    </div>
                                </div>

                                <!-- Image actuelle -->
                                <div class="form-group">
                                    <label>Image actuelle :</label>
                                    <div class="mb-2">
                                        <?php if (!empty($kit['img_choix'])): ?>
                                            <img src="<?= RACINE . $kit['img_choix'] ?>" alt="" style="max-width: 200px; max-height: 200px; object-fit: contain;">
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Pas d'image</span>
                                        <?php endif; ?>
                                    </div>
                                    <label for="image">Nouvelle image (laisser vide pour garder l'image actuelle) :</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <span class="input-group-addon"><i class="feather icon-image"></i></span>
                                    </div>
                                </div>

                                <!-- État -->
                                <div class="form-group">
                                    <label for="etat_choix">État :</label>
                                    <div class="input-group">
                                        <select class="form-control" id="etat_choix" name="etat_choix">
                                            <option value="1" <?= ($kit['etat_choix'] ?? 1) == 1 ? 'selected' : '' ?>>Actif</option>
                                            <option value="0" <?= ($kit['etat_choix'] ?? 1) == 0 ? 'selected' : '' ?>>Inactif</option>
                                        </select>
                                        <span class="input-group-addon"><i class="feather icon-toggle-left"></i></span>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn_actions">
                                        <i class="feather icon-save"></i> Sauvegarder
                                    </button>
                                    <a href="<?= RACINE ?>admin/kits" class="btn btn-secondary">
                                        <i class="feather icon-x"></i> Annuler
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
