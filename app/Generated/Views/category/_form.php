<?php
$formTitle = $formTitle ?? 'Gestione record';
$formIcon = $formIcon ?? 'bi-pencil-square';
$formAction = $formAction ?? current_url();
$row = $row ?? null;
$errors = $errors ?? [];
$options = $options ?? [];
$context = $context ?? [];
$contextLabels = $contextLabels ?? [];
$navigationContext = (array) ($navigationContext ?? []);
$parentContext = (array) ($parentContext ?? []);
$submissionToken = $submissionToken ?? '';
?>

<!-- mycrud:start form -->
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">
                <i class="bi <?= esc($formIcon) ?>"></i>
                <?= esc($formTitle) ?>
            </h2>
        </div>

        <div class="card-body">
            <?php if (session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= esc(session('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
                </div>
            <?php endif; ?>

            <?= form_open($formAction, [
                'class'      => 'row g-3',
                'enctype'    => 'multipart/form-data',
                'id'         => 'myCrudForm',
                'novalidate' => true,
            ]) ?>

                <input type="hidden" name="_submission_token" value="<?= esc($submissionToken) ?>">
                <?php foreach ($navigationContext as $contextField => $contextValue): ?>
                    <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
                <?php endforeach; ?>
                <?php if (!empty($cascadeTrail)): ?>
                    <input type="hidden" name="_trail" value="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) $cascadeTrail)) ?>">
                <?php endif; ?>
                <?php if (!empty($parentContext['field'])): ?>
                    <input type="hidden" name="_parent_field" value="<?= esc((string) $parentContext['field']) ?>">
                <?php endif; ?>

<!-- mycrud:start fields -->
                <div class="col-md-6">
                    <label for="name" class="form-label">
                        <?= esc(lang('Category.name')) ?>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="<?= esc(old('name', $row->{'name'} ?? ($context['name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="name-error"
                        aria-invalid="<?= isset($errors['name']) ? 'true' : 'false' ?>"
                        required maxlength="25"
                    >
                    <?php if (!empty($errors['name'])): ?>
                        <div id="name-error" class="invalid-feedback d-block">
                            <?= esc($errors['name']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- mycrud:start relation-panels -->
                <?php
                $m2mCreateEnabled = true;
                $m2mEditEnabled = true;
                $m2mVisible = ($row === null && $m2mCreateEnabled) || ($row !== null && $m2mEditEnabled);
                ?>
                <?php if ($m2mVisible): ?>
                <div class="col-12 col-md-12">
                    <!-- mycrud:start many-to-many relation -->
                    <div class="card border-primary-subtle h-100">
                        <div class="card-header"><i class="bi bi-diagram-2 me-1"></i><strong>Film</strong> <small class="text-muted">N:N</small></div>
                        <div class="card-body">
                            <?php
                            $manyOld = old('_many', $manyToManySelected ?? []);
                            $selected = array_map('strval', (array) ($manyOld['many__film_category__category_id'] ?? []));
                            $manyOptions = (array) (($manyToManyOptions ?? [])['many__film_category__category_id'] ?? []);
                            ?>
                            <input type="hidden" name="_many_present[many__film_category__category_id]" value="1">
                            <div id="many_component_many__film_category__category_id" class="crud-many-selector">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <label class="form-label mb-0">Select Film</label>
                                    <span class="badge text-bg-secondary" data-many-count>0 selected</span>
                                </div>

                                <div class="d-flex flex-wrap gap-1 mb-2" data-many-selected></div>

                                <div class="input-group input-group-sm mb-2 crud-many-primary-actions">
                                    <button
                                        class="btn btn-outline-secondary text-start flex-grow-1"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#many_picker_many__film_category__category_id"
                                        aria-expanded="false"
                                        aria-controls="many_picker_many__film_category__category_id"
                                    >
                                        <i class="bi bi-search me-1"></i>Search and select Film
                                    </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm crud-many-related-create-toggle"
                                    id="many_related_create_many__film_category__category_id_toggle"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#many_related_create_many__film_category__category_id"
                                    aria-controls="many_related_create_many__film_category__category_id"
                                    title="Create new Film"
                                    aria-label="Create new Film"
                                >
                                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>New Film
                                </button>                                </div>

                                <div class="collapse mt-2" id="many_picker_many__film_category__category_id">
                                    <div class="border rounded p-2 bg-body-tertiary">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input
                                                type="search"
                                                class="form-control"
                                                placeholder="Search Film..."
                                                autocomplete="off"
                                                data-many-search
                                            >
                                        </div>
                                        <div class="list-group overflow-auto" style="max-height: 260px;" data-many-options>
                                            <?php foreach ($manyOptions as $option): ?>
                                                <?php
                                                $optionId = (string) ($option['id'] ?? '');
                                                $optionText = (string) ($option['text'] ?? $optionId);
                                                ?>
                                                <label class="list-group-item list-group-item-action py-2" data-many-option data-search="<?= esc(strtolower($optionText)) ?>">
                                                    <input
                                                        class="form-check-input me-2"
                                                        type="checkbox"
                                                        name="_many[many__film_category__category_id][]"
                                                        value="<?= esc($optionId) ?>"
                                                        data-many-checkbox
                                                        data-many-label="<?= esc($optionText) ?>"
                                                        <?= in_array($optionId, $selected, true) ? 'checked' : '' ?>
                                                    >
                                                    <span><?= esc($optionText) ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $manyCreateRelatedState = (array) old('_many_new', []);
                                $manyCreateRelatedActive = !empty($manyCreateRelatedState['many__film_category__category_id']);
                                ?>
                                <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                                    <input
                                        type="hidden"
                                        name="_many_new[many__film_category__category_id]"
                                        id="many_related_create_many__film_category__category_id_state"
                                        value="<?= $manyCreateRelatedActive ? '1' : '0' ?>"
                                    >
                                    <span
                                        class="badge text-bg-success<?= $manyCreateRelatedActive ? '' : ' d-none' ?>"
                                        id="many_related_create_many__film_category__category_id_ready"
                                    >
                                        <i class="bi bi-check-circle me-1" aria-hidden="true"></i>
                                        New Film ready
                                    </span>
                                    <button
                                        type="button"
                                        class="btn btn-link btn-sm text-danger p-0<?= $manyCreateRelatedActive ? '' : ' d-none' ?> crud-many-related-create-remove"
                                        id="many_related_create_many__film_category__category_id_remove"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <div
                                    id="many_related_create_many__film_category__category_id"
                                    class="offcanvas offcanvas-end crud-many-related-create-panel"
                                    style="--bs-offcanvas-width: min(640px, 100vw);"
                                    tabindex="-1"
                                    aria-labelledby="many_related_create_many__film_category__category_id_label"
                                    data-state-target="many_related_create_many__film_category__category_id_state"
                                    data-toggle-target="many_related_create_many__film_category__category_id_toggle"
                                    data-ready-target="many_related_create_many__film_category__category_id_ready"
                                    data-remove-target="many_related_create_many__film_category__category_id_remove"
                                    data-bs-backdrop="static"
                                >
                                    <div class="offcanvas-header border-bottom">
                                        <div>
                                            <h2 class="offcanvas-title h5 mb-0" id="many_related_create_many__film_category__category_id_label">New Film</h2>
                                            <small class="text-muted">Create and add to this many-to-many relation</small>
                                        </div>
                                        <button
                                            type="button"
                                            class="btn-close crud-many-related-create-cancel"
                                            data-bs-dismiss="offcanvas"
                                            aria-label="Cancel new Film"
                                        ></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class="alert alert-light border small" role="note">
                                            Enter the new Film data. It will be created with the main record and automatically added to this selection when the main form is submitted.
                                        </div>
                                        <div class="row g-3" data-many-related-fields>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_title">Title</label>
    <input
    id="many_related_create_many__film_category__category_id_title"
    type="text"
    name="_many_related[many__film_category__category_id][title]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.title', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__title']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled required maxlength="128"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__title'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__title']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_description">Description</label>
    <textarea
    id="many_related_create_many__film_category__category_id_description"
    name="_many_related[many__film_category__category_id][description]"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__description']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled maxlength="65535"
><?= esc((string) old('_many_related.many__film_category__category_id.description', '')) ?></textarea>
    <?php if (!empty($errors['many__film_category__category_id__many_related__description'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__description']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_release_year">Release Year</label>
    <input
    id="many_related_create_many__film_category__category_id_release_year"
    type="text"
    name="_many_related[many__film_category__category_id][release_year]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.release_year', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__release_year']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__release_year'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__release_year']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_language_id">Language Id</label>
    <select
    id="many_related_create_many__film_category__category_id_language_id"
    name="_many_related[many__film_category__category_id][language_id]"
    class="form-select <?= isset($errors['many__film_category__category_id__many_related__language_id']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled required min="0"
>
    <option value="">Select...</option>
    <?php foreach ((array) (($manyToManyRelatedCreateOptions ?? [])['many__film_category__category_id']['language_id'] ?? []) as $relatedOption): ?>
        <?php
        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
        ?>
        <option value="<?= esc($relatedOptionId) ?>" <?= (string) old('_many_related.many__film_category__category_id.language_id', '') === $relatedOptionId ? 'selected' : '' ?>>
            <?= esc($relatedOptionText) ?>
        </option>
    <?php endforeach; ?>
</select>
    <?php if (!empty($errors['many__film_category__category_id__many_related__language_id'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__language_id']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_original_language_id">Original Language Id</label>
    <select
    id="many_related_create_many__film_category__category_id_original_language_id"
    name="_many_related[many__film_category__category_id][original_language_id]"
    class="form-select <?= isset($errors['many__film_category__category_id__many_related__original_language_id']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled min="0"
>
    <option value="">Select...</option>
    <?php foreach ((array) (($manyToManyRelatedCreateOptions ?? [])['many__film_category__category_id']['original_language_id'] ?? []) as $relatedOption): ?>
        <?php
        $relatedOptionId = (string) ($relatedOption['id'] ?? '');
        $relatedOptionText = (string) ($relatedOption['text'] ?? $relatedOptionId);
        ?>
        <option value="<?= esc($relatedOptionId) ?>" <?= (string) old('_many_related.many__film_category__category_id.original_language_id', '') === $relatedOptionId ? 'selected' : '' ?>>
            <?= esc($relatedOptionText) ?>
        </option>
    <?php endforeach; ?>
</select>
    <?php if (!empty($errors['many__film_category__category_id__many_related__original_language_id'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__original_language_id']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_rental_duration">Rental Duration</label>
    <input
    id="many_related_create_many__film_category__category_id_rental_duration"
    type="number"
    name="_many_related[many__film_category__category_id][rental_duration]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.rental_duration', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__rental_duration']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled min="0"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__rental_duration'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__rental_duration']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_rental_rate">Rental Rate</label>
    <input
    id="many_related_create_many__film_category__category_id_rental_rate"
    type="number"
    name="_many_related[many__film_category__category_id][rental_rate]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.rental_rate', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__rental_rate']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled step="0.01"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__rental_rate'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__rental_rate']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_length">Length</label>
    <input
    id="many_related_create_many__film_category__category_id_length"
    type="number"
    name="_many_related[many__film_category__category_id][length]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.length', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__length']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled min="0"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__length'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__length']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_replacement_cost">Replacement Cost</label>
    <input
    id="many_related_create_many__film_category__category_id_replacement_cost"
    type="number"
    name="_many_related[many__film_category__category_id][replacement_cost]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.replacement_cost', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__replacement_cost']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled step="0.01"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__replacement_cost'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__replacement_cost']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_rating">Rating</label>
    <input
    id="many_related_create_many__film_category__category_id_rating"
    type="text"
    name="_many_related[many__film_category__category_id][rating]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.rating', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__rating']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled maxlength="5"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__rating'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__rating']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_special_features">Special Features</label>
    <input
    id="many_related_create_many__film_category__category_id_special_features"
    type="text"
    name="_many_related[many__film_category__category_id][special_features]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.special_features', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__special_features']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled maxlength="54"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__special_features'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__special_features']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__category_id_uploads">Uploads</label>
    <input
    id="many_related_create_many__film_category__category_id_uploads"
    type="text"
    name="_many_related[many__film_category__category_id][uploads]"
    value="<?= esc((string) old('_many_related.many__film_category__category_id.uploads', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__category_id__many_related__uploads']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled maxlength="200"
>
    <?php if (!empty($errors['many__film_category__category_id__many_related__uploads'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__category_id__many_related__uploads']) ?></div><?php endif; ?>
</div>
                                        </div>
                                    </div>
                                    <div class="offcanvas-footer border-top p-3 d-flex justify-content-between gap-2">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary crud-many-related-create-cancel"
                                            data-bs-dismiss="offcanvas"
                                        >
                                            <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                            Cancel
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-primary crud-many-related-create-apply"
                                            data-bs-dismiss="offcanvas"
                                        >
                                            <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                            Apply new Film
                                        </button>
                                    </div>
                                </div>

                                <div class="form-text"><i class="bi bi-shield-check me-1"></i>Selected associations are revalidated server-side before pivot synchronization.</div>
                            </div>
                            <script>
                            (() => {
                                const root = document.getElementById('many_component_many__film_category__category_id');
                                if (!root || root.dataset.initialized === '1') return;
                                root.dataset.initialized = '1';

                                const search = root.querySelector('[data-many-search]');
                                const selectedBox = root.querySelector('[data-many-selected]');
                                const count = root.querySelector('[data-many-count]');
                                const checkboxes = Array.from(root.querySelectorAll('[data-many-checkbox]'));
                                const optionRows = Array.from(root.querySelectorAll('[data-many-option]'));

                                const renderSelected = () => {
                                    const selected = checkboxes.filter((checkbox) => checkbox.checked);
                                    count.textContent = selected.length + ' selected';
                                    selectedBox.innerHTML = '';

                                    if (selected.length === 0) {
                                        const empty = document.createElement('span');
                                        empty.className = 'small text-muted';
                                        empty.textContent = 'No selection';
                                        selectedBox.appendChild(empty);
                                        return;
                                    }

                                    selected.forEach((checkbox) => {
                                        const badge = document.createElement('button');
                                        badge.type = 'button';
                                        badge.className = 'btn btn-primary btn-sm rounded-pill py-0 px-2';
                                        badge.setAttribute('aria-label', 'Remove ' + (checkbox.dataset.manyLabel || checkbox.value));
                                        badge.innerHTML = '<span class="me-1"></span><i class="bi bi-x-lg"></i>';
                                        badge.querySelector('span').textContent = checkbox.dataset.manyLabel || checkbox.value;
                                        badge.addEventListener('click', () => {
                                            checkbox.checked = false;
                                            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                                        });
                                        selectedBox.appendChild(badge);
                                    });
                                };

                                checkboxes.forEach((checkbox) => checkbox.addEventListener('change', renderSelected));

                                if (search) {
                                    search.addEventListener('input', () => {
                                        const needle = search.value.trim().toLocaleLowerCase();
                                        optionRows.forEach((row) => {
                                            row.hidden = needle !== '' && !String(row.dataset.search || '').includes(needle);
                                        });
                                    });
                                }

                                renderSelected();
                            })();
                            </script>
                        </div>
                    </div>
                    <!-- mycrud:end many-to-many relation -->
                </div>
                <?php endif; ?>
                <!-- mycrud:end relation-panels -->
                <!-- mycrud:end fields -->
                <!-- mycrud:start form-actions -->
                <div class="col-12 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <span class="submit-normal"><i class="bi bi-check-circle"></i> Salva</span>
                        <span class="submit-loading d-none">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            Salvataggio...
                        </span>
                    </button>
                    <?php if (!empty($parentContext['url'])): ?>
                        <a href="<?= esc((string) $parentContext['url']) ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Cancel and return to <?= esc((string) ($parentContext['label'] ?? 'parent record')) ?>
                        </a>
                    <?php endif; ?>

                </div>
                <!-- mycrud:end form-actions -->

            <?= form_close() ?>
        </div>
    </div>
</div>
<!-- mycrud:end form -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('myCrudForm');
    const submitButton = document.getElementById('submitButton');

    if (!form || !submitButton) return;

    let submitted = false;

    // AJAX select for large relations: the browser loads only results
    // cercati dall'utente, evitando migliaia di <option> nel form.
    document.querySelectorAll('.crud-relation-search').forEach(function (input) {
        const valueTarget = document.getElementById(input.dataset.valueTarget || '');
        const results = document.getElementById(input.dataset.resultsTarget || '');
        const minChars = Number.parseInt(input.dataset.minChars || '2', 10);
        let timer = null;
        let controller = null;

        if (!valueTarget || !results) return;

        input.addEventListener('input', function () {
            valueTarget.value = '';
            valueTarget.dispatchEvent(new Event('change', {bubbles: true}));
            results.classList.add('d-none');
            results.innerHTML = '';
            window.clearTimeout(timer);

            const query = input.value.trim();
            if (query.length < minChars) return;

            timer = window.setTimeout(async function () {
                controller?.abort();
                controller = new AbortController();

                try {
                    const separator = input.dataset.url.includes('?') ? '&' : '?';
                    const response = await fetch(
                        input.dataset.url + separator + 'q=' + encodeURIComponent(query),
                        {
                            headers: {'X-Requested-With': 'XMLHttpRequest'},
                            signal: controller.signal
                        }
                    );
                    if (!response.ok) throw new Error('Relation search error');

                    const payload = await response.json();
                    const rows = Array.isArray(payload.results) ? payload.results : [];
                    results.innerHTML = '';

                    rows.forEach(function (row) {
                        const option = document.createElement('option');
                        option.value = String(row.id ?? '');
                        option.textContent = String(row.text ?? '');
                        results.appendChild(option);
                    });

                    results.classList.toggle('d-none', rows.length === 0);
                } catch (error) {
                    if (error.name !== 'AbortError') console.error(error);
                }
            }, 350);
        });

        results.addEventListener('change', function () {
            const selected = results.options[results.selectedIndex];
            if (!selected) return;
            valueTarget.value = selected.value;
            valueTarget.dispatchEvent(new Event('change', {bubbles: true}));
            input.value = selected.textContent || '';
            results.classList.add('d-none');
        });

        results.addEventListener('dblclick', function () {
            results.dispatchEvent(new Event('change'));
        });
    });

    // Mantiene il link al parent record sincronizzato con il valore FK,
    // qualunque sia il controllo usato (hidden, select, input o select AJAX).
    const refreshParentLink = function (link) {
        const source = document.getElementById(link.dataset.valueSource || '');
        if (!source) return;
        const value = String(source.value || '').trim();
        const baseUrl = String(link.dataset.baseUrl || '').replace(/\/$/, '');
        if (value === '' || baseUrl === '') {
            link.href = '#';
            link.classList.add('disabled');
            link.setAttribute('aria-disabled', 'true');
            return;
        }
        let href = baseUrl + '/' + encodeURIComponent(value);
        const trail = String(link.dataset.trail || '').trim();
        if (trail !== '') {
            href += '?_trail=' + encodeURIComponent(trail);
        }
        link.href = href;
        link.classList.remove('disabled');
        link.removeAttribute('aria-disabled');
    };

    document.querySelectorAll('.js-relation-parent-link').forEach(function (link) {
        const source = document.getElementById(link.dataset.valueSource || '');
        refreshParentLink(link);
        source?.addEventListener('change', function () { refreshParentLink(link); });
        source?.addEventListener('input', function () { refreshParentLink(link); });
    });

    // Relational Create tramite Bootstrap Offcanvas. Il pannello si
    // sovrappone alla vista senza alterare il layout del form principale.
    // The original select/relation remains visually and functionally
    // invariata; quando _related_new[field]=1 il server ignora la FK esistente
    // and creates the new parent in the same transaction as the main record.
    const setRelatedCreateState = function (panel, active) {
        const field = String(panel.dataset.relatedField || '');
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (field === '' || !state) return;

        state.value = active ? '1' : '0';
        panel.querySelectorAll('.crud-related-create-field').forEach(function (input) {
            input.disabled = !active;
        });

        // If a new parent is created, the original foreign key may be empty:
        // the value will be set server-side with the newly generated primary key. Suspend
        // quindi solo il vincolo HTML5 required della FK, senza alterarne la UI.
        const source = document.getElementById(field);
        if (source) {
            if (!Object.prototype.hasOwnProperty.call(source.dataset, 'relatedOriginalRequired')) {
                source.dataset.relatedOriginalRequired = source.required ? '1' : '0';
            }
            if (active) {
                source.removeAttribute('required');
                source.setAttribute('aria-required', 'false');
            } else if (source.dataset.relatedOriginalRequired === '1') {
                source.setAttribute('required', 'required');
                source.setAttribute('aria-required', 'true');
            }
        }

        const toggle = document.getElementById(String(panel.dataset.toggleTarget || ''));
        if (toggle) {
            toggle.classList.toggle('active', active);
            toggle.setAttribute('aria-pressed', active ? 'true' : 'false');
        }
    };

    document.querySelectorAll('.crud-related-create-panel.offcanvas').forEach(function (panel) {
        const field = String(panel.dataset.relatedField || '');
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (field === '' || !state) return;

        setRelatedCreateState(panel, String(state.value || '0') === '1');

        panel.addEventListener('show.bs.offcanvas', function () {
            panel.dataset.relatedApplied = '0';
            setRelatedCreateState(panel, true);
        });

        panel.querySelectorAll('.crud-related-create-apply').forEach(function (button) {
            button.addEventListener('click', function () {
                panel.dataset.relatedApplied = '1';
                setRelatedCreateState(panel, true);
            });
        });

        panel.querySelectorAll('.crud-related-create-cancel').forEach(function (button) {
            button.addEventListener('click', function () {
                panel.dataset.relatedApplied = '0';
                setRelatedCreateState(panel, false);
            });
        });

        // Only "Apply" keeps inline creation active after closing.
        // X, Annulla ed eventuale chiusura da tastiera annullano l'operazione.
        panel.addEventListener('hidden.bs.offcanvas', function () {
            if (String(panel.dataset.relatedApplied || '0') !== '1') {
                setRelatedCreateState(panel, false);
            } else {
                setRelatedCreateState(panel, true);
            }
        });

        // If server validation returned errors for the new parent,
        // automatically reopen the panel to show fields and errors.
        if (String(state.value || '0') === '1' && window.bootstrap?.Offcanvas) {
            window.bootstrap.Offcanvas.getOrCreateInstance(panel).show();
        }
    });

    // Many-to-many Related Create uses the same offcanvas interaction pattern
    // as belongsTo Related Create. The main form stays compact; the nested
    // target form is enabled only after the user explicitly applies it.
    const setManyRelatedCreateState = function (panel, active) {
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (!state) return;

        state.value = active ? '1' : '0';
        panel.querySelectorAll('[data-many-related-field]').forEach(function (input) {
            input.disabled = !active;
        });

        const toggle = document.getElementById(String(panel.dataset.toggleTarget || ''));
        if (toggle) {
            toggle.classList.toggle('active', active);
            toggle.setAttribute('aria-pressed', active ? 'true' : 'false');
        }

        const ready = document.getElementById(String(panel.dataset.readyTarget || ''));
        if (ready) ready.classList.toggle('d-none', !active);

        const remove = document.getElementById(String(panel.dataset.removeTarget || ''));
        if (remove) remove.classList.toggle('d-none', !active);
    };

    document.querySelectorAll('.crud-many-related-create-panel.offcanvas').forEach(function (panel) {
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (!state) return;

        setManyRelatedCreateState(panel, String(state.value || '0') === '1');

        panel.addEventListener('show.bs.offcanvas', function () {
            panel.dataset.manyRelatedApplied = '0';
            setManyRelatedCreateState(panel, true);
        });

        panel.querySelectorAll('.crud-many-related-create-apply').forEach(function (button) {
            button.addEventListener('click', function () {
                panel.dataset.manyRelatedApplied = '1';
                setManyRelatedCreateState(panel, true);
            });
        });

        panel.querySelectorAll('.crud-many-related-create-cancel').forEach(function (button) {
            button.addEventListener('click', function () {
                panel.dataset.manyRelatedApplied = '0';
                setManyRelatedCreateState(panel, false);
            });
        });

        const remove = document.getElementById(String(panel.dataset.removeTarget || ''));
        if (remove) {
            remove.addEventListener('click', function () {
                panel.dataset.manyRelatedApplied = '0';
                setManyRelatedCreateState(panel, false);
                panel.querySelectorAll('[data-many-related-field]').forEach(function (input) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            });
        }

        panel.addEventListener('hidden.bs.offcanvas', function () {
            setManyRelatedCreateState(
                panel,
                String(panel.dataset.manyRelatedApplied || '0') === '1'
            );
        });

        // Reopen after server-side validation errors so the user sees the
        // invalid nested fields instead of a collapsed/hidden form.
        if (String(state.value || '0') === '1' && window.bootstrap?.Offcanvas) {
            window.bootstrap.Offcanvas.getOrCreateInstance(panel).show();
        }
    });

    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        if (submitted) {
            event.preventDefault();
            return;
        }

        submitted = true;
        submitButton.disabled = true;
        submitButton.querySelector('.submit-normal')?.classList.add('d-none');
        submitButton.querySelector('.submit-loading')?.classList.remove('d-none');
    });
});
</script>
