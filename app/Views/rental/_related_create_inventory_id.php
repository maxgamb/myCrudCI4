<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-md-6">
                <label for="related_create_inventory_id_film_id" class="form-label"><?= esc('Film Id') ?></label>
                <select
                    name="_related[inventory_id][film_id]"
                    id="related_create_inventory_id_film_id"
                    class="form-select <?= isset($errors['inventory_id__related__film_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="inventory_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['inventory_id']['film_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['inventory_id']['film_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['inventory_id__related__film_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['inventory_id__related__film_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-md-6">
                <label for="related_create_inventory_id_store_id" class="form-label"><?= esc('Store Id') ?></label>
                <select
                    name="_related[inventory_id][store_id]"
                    id="related_create_inventory_id_store_id"
                    class="form-select <?= isset($errors['inventory_id__related__store_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="inventory_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['inventory_id']['store_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['inventory_id']['store_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['inventory_id__related__store_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['inventory_id__related__store_id']) ?></div>
                <?php endif; ?>
            </div></div>