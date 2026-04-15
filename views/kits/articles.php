<?php require_once '../public/inc/header.php'; ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="col-sm-12">
                <a href="<?= RACINE ?>admin/kits" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste des kits
                </a>
            </div>
        </div>

        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="feather icon-box"></i> Articles du kit : <?= htmlspecialchars($kit['libelle_choix'] ?? '') ?>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <strong>Kit:</strong> <?= htmlspecialchars($kit['libelle_choix'] ?? '') ?> - 
                                <strong>Cotisation:</strong> <?= number_format($kit['cotisation_choix'] ?? 0, 0, ',', ' ') ?> CFA
                            </div>

                            <form class="formKitArticles" method="POST">
                                <input type="hidden" name="kit_code" value="<?= htmlspecialchars($kitCode) ?>">
                                
                                <div class="form-group">
                                    <label for="articles">Sélectionner les articles:</label>
                                    <select id="articles" name="articles[]" multiple>
                                        <?php $selectedArticles = array_column($kitArticles, 'article_code'); ?>
                                        <?php foreach ($articles as $article): ?>
                                        <option value="<?= htmlspecialchars($article['code_article']) ?>" 
                                            <?= in_array($article['code_article'], $selectedArticles) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($article['libelle_article']) ?> (<?= htmlspecialchars($article['libelle_famille'] ?? 'N/A') ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <?php if (empty($articles)): ?>
                                <div class="alert alert-warning">
                                    Aucun article disponible. Veuillez créer des articles d'abord.
                                </div>
                                <?php endif; ?>

                                <div class="form-actions mt-3">
                                    <button type="submit" class="btn btn-primary btn_actions">
                                        <i class="feather icon-save"></i> Sauvegarder
                                    </button>
                                    <a href="<?= RACINE ?>admin/kits" class="btn btn-outline-danger">
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
<!-- END: Content-->

<?php require_once '../public/inc/footer.php'; ?>
