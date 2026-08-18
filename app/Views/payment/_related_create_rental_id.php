<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="related_create_rental_id_rental_date" class="form-label"><?= esc('Rental Date') ?></label>
                <input
                    type="datetime-local"
                    name="_related[rental_id][rental_date]"
                    id="related_create_rental_id_rental_date"
                    value="<?= esc((string) (($relatedPayloadState['rental_id']['rental_date'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['rental_id__related__rental_date']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="rental_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required
                >
                <?php if (!empty($errors['rental_id__related__rental_date'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['rental_id__related__rental_date']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_rental_id_inventory_id" class="form-label"><?= esc('Inventory Id') ?></label>
                <select
                    name="_related[rental_id][inventory_id]"
                    id="related_create_rental_id_inventory_id"
                    class="form-select <?= isset($errors['rental_id__related__inventory_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="rental_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['rental_id']['inventory_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['rental_id']['inventory_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['rental_id__related__inventory_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['rental_id__related__inventory_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_rental_id_customer_id" class="form-label"><?= esc('Customer Id') ?></label>
                <select
                    name="_related[rental_id][customer_id]"
                    id="related_create_rental_id_customer_id"
                    class="form-select <?= isset($errors['rental_id__related__customer_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="rental_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['rental_id']['customer_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['rental_id']['customer_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['rental_id__related__customer_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['rental_id__related__customer_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_rental_id_return_date" class="form-label"><?= esc('Return Date') ?></label>
                <input
                    type="datetime-local"
                    name="_related[rental_id][return_date]"
                    id="related_create_rental_id_return_date"
                    value="<?= esc((string) (($relatedPayloadState['rental_id']['return_date'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['rental_id__related__return_date']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="rental_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>

                >
                <?php if (!empty($errors['rental_id__related__return_date'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['rental_id__related__return_date']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_rental_id_staff_id" class="form-label"><?= esc('Staff Id') ?></label>
                <select
                    name="_related[rental_id][staff_id]"
                    id="related_create_rental_id_staff_id"
                    class="form-select <?= isset($errors['rental_id__related__staff_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="rental_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['rental_id']['staff_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['rental_id']['staff_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['rental_id__related__staff_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['rental_id__related__staff_id']) ?></div>
                <?php endif; ?>
            </div></div>
