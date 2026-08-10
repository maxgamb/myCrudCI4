<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_city_id_city" class="form-label"><?= esc('City') ?></label>
                <input
                    type="text"
                    name="_related[city_id][city]"
                    id="related_create_city_id_city"
                    value="<?= esc((string) (($relatedPayloadState['city_id']['city'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['city_id__related__city']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="city_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="50"
                >                <?php if (!empty($errors['city_id__related__city'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['city_id__related__city']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_city_id_country_id" class="form-label"><?= esc('Country Id') ?></label>
                <input
                    type="number"
                    name="_related[city_id][country_id]"
                    id="related_create_city_id_country_id"
                    value="<?= esc((string) (($relatedPayloadState['city_id']['country_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['city_id__related__country_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="city_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['city_id__related__country_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['city_id__related__country_id']) ?></div>
                <?php endif; ?>
            </div></div>