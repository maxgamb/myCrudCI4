<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_inventory_id_film_id" class="form-label"><?= esc('Film Id') ?></label>
                <input
                    type="number"
                    name="_related[inventory_id][film_id]"
                    id="related_create_inventory_id_film_id"
                    value="<?= esc((string) (($relatedPayloadState['inventory_id']['film_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['inventory_id__related__film_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="inventory_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['inventory_id__related__film_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['inventory_id__related__film_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_inventory_id_store_id" class="form-label"><?= esc('Store Id') ?></label>
                <input
                    type="number"
                    name="_related[inventory_id][store_id]"
                    id="related_create_inventory_id_store_id"
                    value="<?= esc((string) (($relatedPayloadState['inventory_id']['store_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['inventory_id__related__store_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="inventory_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['inventory_id__related__store_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['inventory_id__related__store_id']) ?></div>
                <?php endif; ?>
            </div></div>