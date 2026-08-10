<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_store_id_manager_staff_id" class="form-label"><?= esc('Manager Staff Id') ?></label>
                <input
                    type="number"
                    name="_related[store_id][manager_staff_id]"
                    id="related_create_store_id_manager_staff_id"
                    value="<?= esc((string) (($relatedPayloadState['store_id']['manager_staff_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['store_id__related__manager_staff_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="store_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['store_id__related__manager_staff_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['store_id__related__manager_staff_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_store_id_address_id" class="form-label"><?= esc('Address Id') ?></label>
                <input
                    type="number"
                    name="_related[store_id][address_id]"
                    id="related_create_store_id_address_id"
                    value="<?= esc((string) (($relatedPayloadState['store_id']['address_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['store_id__related__address_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="store_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['store_id__related__address_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['store_id__related__address_id']) ?></div>
                <?php endif; ?>
            </div></div>