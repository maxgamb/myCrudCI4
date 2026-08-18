<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="related_create_original_language_id_name" class="form-label"><?= esc('Name') ?></label>
                <input
                    type="text"
                    name="_related[original_language_id][name]"
                    id="related_create_original_language_id_name"
                    value="<?= esc((string) (($relatedPayloadState['original_language_id']['name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['original_language_id__related__name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="original_language_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="20"
                >
                <?php if (!empty($errors['original_language_id__related__name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['original_language_id__related__name']) ?></div>
                <?php endif; ?>
            </div></div>
