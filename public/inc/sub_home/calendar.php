<div class="modal fade" id="calendarActive" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        
            <!-- En-tête -->
            <div class="modal-header text-light" <?=BG_COLOR_VERT; ?>>
                <h5 class="modal-title" id="modalTitle">Activer une année</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Corps du modal -->
            <div class="modal-body bg-light">
                <div class="container py-3">
                    <div class="row g-3">
                        <?php foreach ($calendarActive as $cal): ?>
                            <?php $isActive = ($cal['id_annee'] == ANNEE_ID); ?>
                            <div class="col-md-3 col-sm-6">
                                <div class="card border-0 shadow-sm <?= $isActive ? 'bg-success bg-opacity-10' : 'bg-white'; ?> hover-scale"
                                     style="cursor: pointer;"
                                     onclick="activerAnnee(<?= $cal['id_annee']; ?>)">
                                    <div class="card-body text-center">
                                        <div class="fs-5 fw-bold <?= $isActive ? 'text-dark' : 'text-dark'; ?>">
                                            <?= htmlspecialchars($cal['libelle_annee']); ?>
                                        </div>
                                        <?php if ($isActive): ?>
                                            <div class="badge bg-success mt-2">
                                                <?= VALIDATOR::ficon("check-circle") ?> Année active
                                            </div>
                                        <?php else: ?>
                                            <div onclick=" changeDeleteById('anneeController/homeActive',<?= $cal['id_annee']; ?>)" class="text-muted mt-2 small">Cliquez pour activer</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>