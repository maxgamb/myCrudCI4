<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_store_id" class="form-label"><?= esc('Store Id') ?></label>
                <select
                    name="_related[customer_id][store_id]"
                    id="related_create_customer_id_store_id"
                    class="form-select <?= isset($errors['customer_id__related__store_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['customer_id']['store_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['customer_id']['store_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['customer_id__related__store_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__store_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_first_name" class="form-label"><?= esc('First Name') ?></label>
                <input
                    type="text"
                    name="_related[customer_id][first_name]"
                    id="related_create_customer_id_first_name"
                    value="<?= esc((string) (($relatedPayloadState['customer_id']['first_name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['customer_id__related__first_name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="45"
                >
                <?php if (!empty($errors['customer_id__related__first_name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__first_name']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_last_name" class="form-label"><?= esc('Last Name') ?></label>
                <input
                    type="text"
                    name="_related[customer_id][last_name]"
                    id="related_create_customer_id_last_name"
                    value="<?= esc((string) (($relatedPayloadState['customer_id']['last_name'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['customer_id__related__last_name']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="45"
                >
                <?php if (!empty($errors['customer_id__related__last_name'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__last_name']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_email" class="form-label"><?= esc('Email') ?></label>
                <input
                    type="email"
                    name="_related[customer_id][email]"
                    id="related_create_customer_id_email"
                    value="<?= esc((string) (($relatedPayloadState['customer_id']['email'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['customer_id__related__email']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="50"
                >
                <?php if (!empty($errors['customer_id__related__email'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__email']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_address_id" class="form-label"><?= esc('Address Id') ?></label>
                <select
                    name="_related[customer_id][address_id]"
                    id="related_create_customer_id_address_id"
                    class="form-select <?= isset($errors['customer_id__related__address_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['customer_id']['address_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['customer_id']['address_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['customer_id__related__address_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__address_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_active" class="form-label"><?= esc('Active') ?></label>
                <input
                    type="hidden"
                    name="_related[customer_id][active]"
                    value="0"
                    class="crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                >
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="_related[customer_id][active]"
                        id="related_create_customer_id_active"
                        value="1"
                        class="form-check-input crud-related-create-field"
                        data-related-field="customer_id"
                        <?= $relatedCreateActive ? '' : 'disabled' ?>
                        <?= !empty($relatedPayloadState['customer_id']['active']) ? 'checked' : '' ?>
                    >
                </div>
                <?php if (!empty($errors['customer_id__related__active'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__active']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_customer_id_create_date" class="form-label"><?= esc('Create Date') ?></label>
                <input
                    type="datetime-local"
                    name="_related[customer_id][create_date]"
                    id="related_create_customer_id_create_date"
                    value="<?= esc((string) (($relatedPayloadState['customer_id']['create_date'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['customer_id__related__create_date']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="customer_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >
                <?php if (!empty($errors['customer_id__related__create_date'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['customer_id__related__create_date']) ?></div>
                <?php endif; ?>
            </div></div>
