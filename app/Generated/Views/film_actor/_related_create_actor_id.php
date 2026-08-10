<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_actor_id_first_name" class="form-label"><?= esc('First Name') ?></label>
                <input
                    type="text"
                    name="_related[actor_id][first_name]"
                    id="related_create_actor_id_first_name"
                    value="<?= esc((string) (($relatedPayloadState['actor_id']['first_name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['actor_id__related__first_name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="actor_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="45"
                >                <?php if (!empty($errors['actor_id__related__first_name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['actor_id__related__first_name']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_actor_id_last_name" class="form-label"><?= esc('Last Name') ?></label>
                <input
                    type="text"
                    name="_related[actor_id][last_name]"
                    id="related_create_actor_id_last_name"
                    value="<?= esc((string) (($relatedPayloadState['actor_id']['last_name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['actor_id__related__last_name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="actor_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="45"
                >                <?php if (!empty($errors['actor_id__related__last_name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['actor_id__related__last_name']) ?></div>
                <?php endif; ?>
            </div></div>