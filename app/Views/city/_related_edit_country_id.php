<?php
$relatedEditActive = !empty($relatedEditActive);
$relatedEditValues = (array) ($relatedEditValues ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_edit_country_id_country" class="form-label"><?= esc('Country') ?></label>
                <input type="text" name="_related_edit_data[country_id][country]" id="related_edit_country_id_country" value="<?= esc(old('_related_edit_data.country_id.country', $relatedEditValues['country'] ?? '')) ?>" class="form-control <?= !empty($errors['country_id__related_edit__country']) ? 'is-invalid' : '' ?> crud-related-edit-field" data-related-field="country_id" <?= $relatedEditActive ? '' : 'disabled' ?> required maxlength="50">
                <?php if (!empty($errors['country_id__related_edit__country'])): ?><div class="invalid-feedback d-block"><?= esc($errors['country_id__related_edit__country']) ?></div><?php endif; ?>
            </div></div>