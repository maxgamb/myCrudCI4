<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_staff_id_first_name" class="form-label"><?= esc('First Name') ?></label>
                <input
                    type="text"
                    name="_related[staff_id][first_name]"
                    id="related_create_staff_id_first_name"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['first_name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__first_name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="45"
                >                <?php if (!empty($errors['staff_id__related__first_name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__first_name']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_last_name" class="form-label"><?= esc('Last Name') ?></label>
                <input
                    type="text"
                    name="_related[staff_id][last_name]"
                    id="related_create_staff_id_last_name"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['last_name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__last_name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="45"
                >                <?php if (!empty($errors['staff_id__related__last_name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__last_name']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_address_id" class="form-label"><?= esc('Address Id') ?></label>
                <input
                    type="number"
                    name="_related[staff_id][address_id]"
                    id="related_create_staff_id_address_id"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['address_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__address_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['staff_id__related__address_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__address_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_email" class="form-label"><?= esc('Email') ?></label>
                <input
                    type="email"
                    name="_related[staff_id][email]"
                    id="related_create_staff_id_email"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['email'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__email']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="50"
                >                <?php if (!empty($errors['staff_id__related__email'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__email']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_store_id" class="form-label"><?= esc('Store Id') ?></label>
                <input
                    type="number"
                    name="_related[staff_id][store_id]"
                    id="related_create_staff_id_store_id"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['store_id'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__store_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >                <?php if (!empty($errors['staff_id__related__store_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__store_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_active" class="form-label"><?= esc('Active') ?></label>
                <input
                    type="hidden"
                    name="_related[staff_id][active]"
                    value="0"
                    class="crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                >
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="_related[staff_id][active]"
                        id="related_create_staff_id_active"
                        value="1"
                        class="form-check-input crud-related-create-field"
                        data-related-field="staff_id"
                        <?= $relatedCreateActive ? '' : 'disabled' ?>
                        <?= !empty($relatedPayloadState['staff_id']['active']) ? 'checked' : '' ?>
                    >
                </div>                <?php if (!empty($errors['staff_id__related__active'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__active']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_username" class="form-label"><?= esc('Username') ?></label>
                <input
                    type="text"
                    name="_related[staff_id][username]"
                    id="related_create_staff_id_username"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['username'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__username']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="16"
                >                <?php if (!empty($errors['staff_id__related__username'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__username']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_staff_id_password" class="form-label"><?= esc('Password') ?></label>
                <input
                    type="text"
                    name="_related[staff_id][password]"
                    id="related_create_staff_id_password"
                    value="<?= esc((string) (($relatedPayloadState['staff_id']['password'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['staff_id__related__password']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="staff_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="40"
                >                <?php if (!empty($errors['staff_id__related__password'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['staff_id__related__password']) ?></div>
                <?php endif; ?>
            </div></div>