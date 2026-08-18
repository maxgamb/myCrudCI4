<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="related_create_address_id_address" class="form-label"><?= esc('Address') ?></label>
                <input
                    type="text"
                    name="_related[address_id][address]"
                    id="related_create_address_id_address"
                    value="<?= esc((string) (($relatedPayloadState['address_id']['address'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['address_id__related__address']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="50"
                >
                <?php if (!empty($errors['address_id__related__address'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__address']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_address_id_address2" class="form-label"><?= esc('Address2') ?></label>
                <input
                    type="text"
                    name="_related[address_id][address2]"
                    id="related_create_address_id_address2"
                    value="<?= esc((string) (($relatedPayloadState['address_id']['address2'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['address_id__related__address2']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="50"
                >
                <?php if (!empty($errors['address_id__related__address2'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__address2']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_address_id_district" class="form-label"><?= esc('District') ?></label>
                <input
                    type="text"
                    name="_related[address_id][district]"
                    id="related_create_address_id_district"
                    value="<?= esc((string) (($relatedPayloadState['address_id']['district'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['address_id__related__district']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="20"
                >
                <?php if (!empty($errors['address_id__related__district'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__district']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_address_id_city_id" class="form-label"><?= esc('City Id') ?></label>
                <select
                    name="_related[address_id][city_id]"
                    id="related_create_address_id_city_id"
                    class="form-select <?= isset($errors['address_id__related__city_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['address_id']['city_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['address_id']['city_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['address_id__related__city_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__city_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_address_id_postal_code" class="form-label"><?= esc('Postal Code') ?></label>
                <input
                    type="text"
                    name="_related[address_id][postal_code]"
                    id="related_create_address_id_postal_code"
                    value="<?= esc((string) (($relatedPayloadState['address_id']['postal_code'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['address_id__related__postal_code']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="10"
                >
                <?php if (!empty($errors['address_id__related__postal_code'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__postal_code']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_address_id_phone" class="form-label"><?= esc('Phone') ?></label>
                <input
                    type="text"
                    name="_related[address_id][phone]"
                    id="related_create_address_id_phone"
                    value="<?= esc((string) (($relatedPayloadState['address_id']['phone'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['address_id__related__phone']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="20"
                >
                <?php if (!empty($errors['address_id__related__phone'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__phone']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_address_id_location" class="form-label"><?= esc('Location') ?></label>
                <input
                    type="text"
                    name="_related[address_id][location]"
                    id="related_create_address_id_location"
                    value="<?= esc((string) (($relatedPayloadState['address_id']['location'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['address_id__related__location']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="address_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required placeholder="WKT geometry"
                >
                <?php if (!empty($errors['address_id__related__location'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['address_id__related__location']) ?></div>
                <?php endif; ?>
            </div></div>
