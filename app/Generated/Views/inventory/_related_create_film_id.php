<?php
$relatedCreateActive = !empty($relatedCreateActive);
$relatedPayloadState = (array) ($relatedPayloadState ?? []);
$relatedCreateOptions = (array) ($relatedCreateOptions ?? []);
$errors = (array) ($errors ?? []);
?>
<div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="related_create_film_id_title" class="form-label"><?= esc('Title') ?></label>
                <input
                    type="text"
                    name="_related[film_id][title]"
                    id="related_create_film_id_title"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['title'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__title']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required maxlength="128"
                >
                <?php if (!empty($errors['film_id__related__title'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__title']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_description" class="form-label"><?= esc('Description') ?></label>
                <textarea
                    name="_related[film_id][description]"
                    id="related_create_film_id_description"
                    class="form-control <?= isset($errors['film_id__related__description']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="65535"
                ><?= esc((string) (($relatedPayloadState['film_id']['description'] ?? ''))) ?></textarea>
                <?php if (!empty($errors['film_id__related__description'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__description']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_release_year" class="form-label"><?= esc('Release Year') ?></label>
                <input
                    type="text"
                    name="_related[film_id][release_year]"
                    id="related_create_film_id_release_year"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['release_year'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__release_year']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>

                >
                <?php if (!empty($errors['film_id__related__release_year'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__release_year']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_language_id" class="form-label"><?= esc('Language Id') ?></label>
                <select
                    name="_related[film_id][language_id]"
                    id="related_create_film_id_language_id"
                    class="form-select <?= isset($errors['film_id__related__language_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     required min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['film_id']['language_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['film_id']['language_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['film_id__related__language_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__language_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_original_language_id" class="form-label"><?= esc('Original Language Id') ?></label>
                <select
                    name="_related[film_id][original_language_id]"
                    id="related_create_film_id_original_language_id"
                    class="form-select <?= isset($errors['film_id__related__original_language_id']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     min="0"
                >
                    <option value="">Seleziona...</option>
                    <?php foreach ((array) ($relatedCreateOptions['film_id']['original_language_id'] ?? []) as $relatedOption): ?>
                        <?php
                        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
                        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
                        ?>
                        <option value="<?= esc($relatedOptionId) ?>" <?= (string) (($relatedPayloadState['film_id']['original_language_id'] ?? '')) === $relatedOptionId ? 'selected' : '' ?>>
                            <?= esc($relatedOptionText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['film_id__related__original_language_id'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__original_language_id']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_rental_duration" class="form-label"><?= esc('Rental Duration') ?></label>
                <input
                    type="number"
                    name="_related[film_id][rental_duration]"
                    id="related_create_film_id_rental_duration"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['rental_duration'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__rental_duration']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     min="0"
                >
                <?php if (!empty($errors['film_id__related__rental_duration'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__rental_duration']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_rental_rate" class="form-label"><?= esc('Rental Rate') ?></label>
                <input
                    type="number"
                    name="_related[film_id][rental_rate]"
                    id="related_create_film_id_rental_rate"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['rental_rate'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__rental_rate']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     step="0.01"
                >
                <?php if (!empty($errors['film_id__related__rental_rate'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__rental_rate']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_length" class="form-label"><?= esc('Length') ?></label>
                <input
                    type="number"
                    name="_related[film_id][length]"
                    id="related_create_film_id_length"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['length'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__length']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     min="0"
                >
                <?php if (!empty($errors['film_id__related__length'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__length']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_replacement_cost" class="form-label"><?= esc('Replacement Cost') ?></label>
                <input
                    type="number"
                    name="_related[film_id][replacement_cost]"
                    id="related_create_film_id_replacement_cost"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['replacement_cost'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__replacement_cost']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     step="0.01"
                >
                <?php if (!empty($errors['film_id__related__replacement_cost'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__replacement_cost']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_rating" class="form-label"><?= esc('Rating') ?></label>
                <input
                    type="text"
                    name="_related[film_id][rating]"
                    id="related_create_film_id_rating"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['rating'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__rating']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="5"
                >
                <?php if (!empty($errors['film_id__related__rating'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__rating']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_special_features" class="form-label"><?= esc('Special Features') ?></label>
                <input
                    type="text"
                    name="_related[film_id][special_features]"
                    id="related_create_film_id_special_features"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['special_features'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__special_features']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="54"
                >
                <?php if (!empty($errors['film_id__related__special_features'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__special_features']) ?></div>
                <?php endif; ?>
            </div>            <div class="col-12 col-md-6">
                <label for="related_create_film_id_uploads" class="form-label"><?= esc('Uploads') ?></label>
                <input
                    type="text"
                    name="_related[film_id][uploads]"
                    id="related_create_film_id_uploads"
                    value="<?= esc((string) (($relatedPayloadState['film_id']['uploads'] ?? ''))) ?>"
                    class="form-control <?= isset($errors['film_id__related__uploads']) ? 'is-invalid' : '' ?> crud-related-create-field"
                    data-related-field="film_id"
                    <?= $relatedCreateActive ? '' : 'disabled' ?>
                     maxlength="200"
                >
                <?php if (!empty($errors['film_id__related__uploads'])): ?>
                    <div class="invalid-feedback d-block"><?= esc($errors['film_id__related__uploads']) ?></div>
                <?php endif; ?>
            </div></div>
