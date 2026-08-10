<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_country_id_country" class="form-label"><?= esc('Country') ?></label>
                <input
                    type="text"
                    name="_related[country_id][country]"
                    id="related_create_country_id_country"
                    value="<?= esc((string) (($relatedPayloadState['country_id']['country'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['country_id__related__country']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="country_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="50"
                >                <?php if (!empty($errors['country_id__related__country'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['country_id__related__country']) ?></div>
                <?php endif; ?>
            </div></div>