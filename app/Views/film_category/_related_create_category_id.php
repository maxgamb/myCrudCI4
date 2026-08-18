<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="related_create_category_id_name" class="form-label"><?= esc('Name') ?></label>
                <input
                    type="text"
                    name="_related[category_id][name]"
                    id="related_create_category_id_name"
                    value="<?= esc((string) (($relatedPayloadState['category_id']['name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['category_id__related__name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="category_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="25"
                >
                <?php if (!empty($errors['category_id__related__name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['category_id__related__name']) ?></div>
                <?php endif; ?>
            </div></div>
