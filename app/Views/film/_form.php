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
                <div class="col-12 crud-form-section-col">
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_general" open>
                        <summary class="fw-semibold">General</summary>

                        <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="title" class="form-label">
                        <?= esc(lang('Film.title')) ?>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="<?= esc(old('title', $row->{'title'} ?? ($context['title'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                        aria-describedby="title-error"
                        aria-invalid="<?= isset($errors['title']) ? 'true' : 'false' ?>"
                        required maxlength="128"
                    >
                    <?php if (!empty($errors['title'])): ?>
                        <div id="title-error" class="invalid-feedback d-block">
                            <?= esc($errors['title']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">
                        <?= esc(lang('Film.description')) ?>
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                        aria-describedby="description-error"
                        aria-invalid="<?= isset($errors['description']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('description', $row->{'description'} ?? ($context['description'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <div id="description-error" class="invalid-feedback d-block">
                            <?= esc($errors['description']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="rental_rate" class="form-label">
                        <?= esc(lang('Film.rental_rate')) ?>
                    </label>
                    <input
                        type="number"
                        name="rental_rate"
                        id="rental_rate"
                        value="<?= esc(old('rental_rate', $row->{'rental_rate'} ?? ($context['rental_rate'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rental_rate']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rental_rate-error"
                        aria-invalid="<?= isset($errors['rental_rate']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['rental_rate'])): ?>
                        <div id="rental_rate-error" class="invalid-feedback d-block">
                            <?= esc($errors['rental_rate']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="replacement_cost" class="form-label">
                        <?= esc(lang('Film.replacement_cost')) ?>
                    </label>
                    <input
                        type="number"
                        name="replacement_cost"
                        id="replacement_cost"
                        value="<?= esc(old('replacement_cost', $row->{'replacement_cost'} ?? ($context['replacement_cost'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['replacement_cost']) ? 'is-invalid' : '' ?>"
                        aria-describedby="replacement_cost-error"
                        aria-invalid="<?= isset($errors['replacement_cost']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['replacement_cost'])): ?>
                        <div id="replacement_cost-error" class="invalid-feedback d-block">
                            <?= esc($errors['replacement_cost']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="rating" class="form-label">
                        <?= esc(lang('Film.rating')) ?>
                    </label>
                    <input
                        type="text"
                        name="rating"
                        id="rating"
                        value="<?= esc(old('rating', $row->{'rating'} ?? ($context['rating'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rating']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rating-error"
                        aria-invalid="<?= isset($errors['rating']) ? 'true' : 'false' ?>"
                        maxlength="5"
                    >
                    <?php if (!empty($errors['rating'])): ?>
                        <div id="rating-error" class="invalid-feedback d-block">
                            <?= esc($errors['rating']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="special_features" class="form-label">
                        <?= esc(lang('Film.special_features')) ?>
                    </label>
                    <input
                        type="text"
                        name="special_features"
                        id="special_features"
                        value="<?= esc(old('special_features', $row->{'special_features'} ?? ($context['special_features'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['special_features']) ? 'is-invalid' : '' ?>"
                        aria-describedby="special_features-error"
                        aria-invalid="<?= isset($errors['special_features']) ? 'true' : 'false' ?>"
                        maxlength="54"
                    >
                    <?php if (!empty($errors['special_features'])): ?>
                        <div id="special_features-error" class="invalid-feedback d-block">
                            <?= esc($errors['special_features']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="uploads" class="form-label">
                        <?= esc(lang('Film.uploads')) ?>
                    </label>
                    <input type="file" name="uploads" id="uploads" class="form-control <?= isset($errors['uploads']) ? 'is-invalid' : '' ?>"
                        aria-describedby="uploads-error"
                        aria-invalid="<?= isset($errors['uploads']) ? 'true' : 'false' ?>"
                        maxlength="200">
                    <?php if (!empty($errors['uploads'])): ?>
                        <div id="uploads-error" class="invalid-feedback d-block">
                            <?= esc($errors['uploads']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                        </div>
                    </details>
                </div>
                <div class="col-6 crud-form-section-col">
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_section_mssksdrj_9wvjn" open>
                        <summary class="fw-semibold">prova</summary>

                        <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="original_language_id" class="form-label">
                        <?= esc(lang('Film.original_language_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">
                    <select
                        name="original_language_id"
                        id="original_language_id"
                        class="form-select <?= isset($errors['original_language_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="original_language_id-error"
                        aria-invalid="<?= isset($errors['original_language_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['original_language_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('original_language_id', $row->{'original_language_id'} ?? ($context['original_language_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="original_language_id"
                            data-base-url="<?= site_url('language/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_original_language_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_original_language_id"
                            aria-controls="related_create_original_language_id"
                            data-related-field="original_language_id"
                            data-panel-target="related_create_original_language_id"
                            data-state-target="related_create_original_language_id_state"
                            title="Create new Language"
                            aria-label="Create new Language"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
</div>
                    <?php if (!empty($errors['original_language_id'])): ?>
                        <div id="original_language_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['original_language_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['original_language_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[original_language_id]"
                            id="related_create_original_language_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_original_language_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_original_language_id_label"
                            data-related-field="original_language_id"
                            data-state-target="related_create_original_language_id_state"
                            data-toggle-target="related_create_original_language_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_original_language_id_label">New Language</h2>
                                    <small class="text-muted">Relation original_language_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="original_language_id"
                                    data-state-target="related_create_original_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new Language"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new Language data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('film/_related_create_original_language_id', [
                                    'relatedField'        => 'original_language_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'relatedCreateOptions' => (array) ($relatedCreateOptions ?? []),
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-between gap-2">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="original_language_id"
                                    data-state-target="related_create_original_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="original_language_id"
                                    data-state-target="related_create_original_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new Language
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="rental_duration" class="form-label">
                        <?= esc(lang('Film.rental_duration')) ?>
                    </label>
                    <input
                        type="number"
                        name="rental_duration"
                        id="rental_duration"
                        value="<?= esc(old('rental_duration', $row->{'rental_duration'} ?? ($context['rental_duration'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rental_duration']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rental_duration-error"
                        aria-invalid="<?= isset($errors['rental_duration']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['rental_duration'])): ?>
                        <div id="rental_duration-error" class="invalid-feedback d-block">
                            <?= esc($errors['rental_duration']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="length" class="form-label">
                        <?= esc(lang('Film.length')) ?>
                    </label>
                    <input
                        type="text"
                        name="length"
                        id="length"
                        value="<?= esc(old('length', $row->{'length'} ?? ($context['length'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['length']) ? 'is-invalid' : '' ?>"
                        aria-describedby="length-error"
                        aria-invalid="<?= isset($errors['length']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['length'])): ?>
                        <div id="length-error" class="invalid-feedback d-block">
                            <?= esc($errors['length']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                        </div>
                    </details>
                </div>
                <div class="col-6 crud-form-section-col">
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_section_msrobuix_a8whk" open>
                        <summary class="fw-semibold">Test</summary>
                        <div class="small text-muted mt-1 mb-2">Descrizione</div>
                        <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="release_year" class="form-label">
                        <?= esc(lang('Film.release_year')) ?>
                    </label>
                    <input
                        type="text"
                        name="release_year"
                        id="release_year"
                        value="<?= esc(old('release_year', $row->{'release_year'} ?? ($context['release_year'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['release_year']) ? 'is-invalid' : '' ?>"
                        aria-describedby="release_year-error"
                        aria-invalid="<?= isset($errors['release_year']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['release_year'])): ?>
                        <div id="release_year-error" class="invalid-feedback d-block">
                            <?= esc($errors['release_year']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="language_id" class="form-label">
                        <?= esc(lang('Film.language_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">
                    <select
                        name="language_id"
                        id="language_id"
                        class="form-select <?= isset($errors['language_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="language_id-error"
                        aria-invalid="<?= isset($errors['language_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['language_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('language_id', $row->{'language_id'} ?? ($context['language_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="language_id"
                            data-base-url="<?= site_url('language/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_language_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_language_id"
                            aria-controls="related_create_language_id"
                            data-related-field="language_id"
                            data-panel-target="related_create_language_id"
                            data-state-target="related_create_language_id_state"
                            title="Create new Language"
                            aria-label="Create new Language"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
</div>
                    <?php if (!empty($errors['language_id'])): ?>
                        <div id="language_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['language_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['language_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[language_id]"
                            id="related_create_language_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_language_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_language_id_label"
                            data-related-field="language_id"
                            data-state-target="related_create_language_id_state"
                            data-toggle-target="related_create_language_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_language_id_label">New Language</h2>
                                    <small class="text-muted">Relation language_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="language_id"
                                    data-state-target="related_create_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new Language"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new Language data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('film/_related_create_language_id', [
                                    'relatedField'        => 'language_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'relatedCreateOptions' => (array) ($relatedCreateOptions ?? []),
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-between gap-2">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="language_id"
                                    data-state-target="related_create_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="language_id"
                                    data-state-target="related_create_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new Language
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                        </div>
                    </details>
                </div>
                <!-- mycrud:start relation-panels -->
                <?php
                $m2mCreateEnabled = true;
                $m2mEditEnabled = true;
                $m2mVisible = ($row === null && $m2mCreateEnabled) || ($row !== null && $m2mEditEnabled);
                ?>
                <?php if ($m2mVisible): ?>
                <div class="col-12 col-md-6">
                    <!-- mycrud:start many-to-many relation -->
                    <div class="card border-primary-subtle h-100">
                        <div class="card-header"><i class="bi bi-diagram-2 me-1"></i><strong>Actor</strong> <small class="text-muted">N:N</small></div>
                        <div class="card-body">
                            <?php
                            $manyOld = old('_many', $manyToManySelected ?? []);
                            $selected = array_map('strval', (array) ($manyOld['many__film_actor__film_id'] ?? []));
                            $manyOptions = (array) (($manyToManyOptions ?? [])['many__film_actor__film_id'] ?? []);
                            ?>
                            <input type="hidden" name="_many_present[many__film_actor__film_id]" value="1">
                            <div id="many_component_many__film_actor__film_id" class="crud-many-selector">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <label class="form-label mb-0">Select Actor</label>
                                    <span class="badge text-bg-secondary" data-many-count>0 selected</span>
                                </div>

                                <div class="d-flex flex-wrap gap-1 mb-2" data-many-selected></div>

                                <div class="input-group input-group-sm mb-2 crud-many-primary-actions">
                                    <button
                                        class="btn btn-outline-secondary text-start flex-grow-1"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#many_picker_many__film_actor__film_id"
                                        aria-expanded="false"
                                        aria-controls="many_picker_many__film_actor__film_id"
                                    >
                                        <i class="bi bi-search me-1"></i>Search and select Actor
                                    </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm crud-many-related-create-toggle"
                                    id="many_related_create_many__film_actor__film_id_toggle"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#many_related_create_many__film_actor__film_id"
                                    aria-controls="many_related_create_many__film_actor__film_id"
                                    title="Create new Actor"
                                    aria-label="Create new Actor"
                                >
                                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>New Actor
                                </button>                                </div>

                                <div class="collapse mt-2" id="many_picker_many__film_actor__film_id">
                                    <div class="border rounded p-2 bg-body-tertiary">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input
                                                type="search"
                                                class="form-control"
                                                placeholder="Search Actor..."
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
                                                        name="_many[many__film_actor__film_id][]"
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
                                $manyCreateRelatedActive = !empty($manyCreateRelatedState['many__film_actor__film_id']);
                                ?>
                                <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                                    <input
                                        type="hidden"
                                        name="_many_new[many__film_actor__film_id]"
                                        id="many_related_create_many__film_actor__film_id_state"
                                        value="<?= $manyCreateRelatedActive ? '1' : '0' ?>"
                                    >
                                    <span
                                        class="badge text-bg-success<?= $manyCreateRelatedActive ? '' : ' d-none' ?>"
                                        id="many_related_create_many__film_actor__film_id_ready"
                                    >
                                        <i class="bi bi-check-circle me-1" aria-hidden="true"></i>
                                        New Actor ready
                                    </span>
                                    <button
                                        type="button"
                                        class="btn btn-link btn-sm text-danger p-0<?= $manyCreateRelatedActive ? '' : ' d-none' ?> crud-many-related-create-remove"
                                        id="many_related_create_many__film_actor__film_id_remove"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <div
                                    id="many_related_create_many__film_actor__film_id"
                                    class="offcanvas offcanvas-end crud-many-related-create-panel"
                                    style="--bs-offcanvas-width: min(640px, 100vw);"
                                    tabindex="-1"
                                    aria-labelledby="many_related_create_many__film_actor__film_id_label"
                                    data-state-target="many_related_create_many__film_actor__film_id_state"
                                    data-toggle-target="many_related_create_many__film_actor__film_id_toggle"
                                    data-ready-target="many_related_create_many__film_actor__film_id_ready"
                                    data-remove-target="many_related_create_many__film_actor__film_id_remove"
                                    data-bs-backdrop="static"
                                >
                                    <div class="offcanvas-header border-bottom">
                                        <div>
                                            <h2 class="offcanvas-title h5 mb-0" id="many_related_create_many__film_actor__film_id_label">New Actor</h2>
                                            <small class="text-muted">Create and add to this many-to-many relation</small>
                                        </div>
                                        <button
                                            type="button"
                                            class="btn-close crud-many-related-create-cancel"
                                            data-bs-dismiss="offcanvas"
                                            aria-label="Cancel new Actor"
                                        ></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class="alert alert-light border small" role="note">
                                            Enter the new Actor data. It will be created with the main record and automatically added to this selection when the main form is submitted.
                                        </div>
                                        <div class="row g-3" data-many-related-fields>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_actor__film_id_first_name">First Name</label>
    <input
    id="many_related_create_many__film_actor__film_id_first_name"
    type="text"
    name="_many_related[many__film_actor__film_id][first_name]"
    value="<?= esc((string) old('_many_related.many__film_actor__film_id.first_name', '')) ?>"
    class="form-control <?= isset($errors['many__film_actor__film_id__many_related__first_name']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled required maxlength="45"
>
    <?php if (!empty($errors['many__film_actor__film_id__many_related__first_name'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_actor__film_id__many_related__first_name']) ?></div><?php endif; ?>
</div>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_actor__film_id_last_name">Last Name</label>
    <input
    id="many_related_create_many__film_actor__film_id_last_name"
    type="text"
    name="_many_related[many__film_actor__film_id][last_name]"
    value="<?= esc((string) old('_many_related.many__film_actor__film_id.last_name', '')) ?>"
    class="form-control <?= isset($errors['many__film_actor__film_id__many_related__last_name']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled required maxlength="45"
>
    <?php if (!empty($errors['many__film_actor__film_id__many_related__last_name'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_actor__film_id__many_related__last_name']) ?></div><?php endif; ?>
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
                                            Apply new Actor
                                        </button>
                                    </div>
                                </div>

                                <div class="form-text"><i class="bi bi-shield-check me-1"></i>Selected associations are revalidated server-side before pivot synchronization.</div>
                            </div>
                            <script>
                            (() => {
                                const root = document.getElementById('many_component_many__film_actor__film_id');
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
                <?php
                $m2mCreateEnabled = true;
                $m2mEditEnabled = true;
                $m2mVisible = ($row === null && $m2mCreateEnabled) || ($row !== null && $m2mEditEnabled);
                ?>
                <?php if ($m2mVisible): ?>
                <div class="col-12 col-md-6">
                    <!-- mycrud:start many-to-many relation -->
                    <div class="card border-primary-subtle h-100">
                        <div class="card-header"><i class="bi bi-diagram-2 me-1"></i><strong>Category</strong> <small class="text-muted">N:N</small></div>
                        <div class="card-body">
                            <?php
                            $manyOld = old('_many', $manyToManySelected ?? []);
                            $selected = array_map('strval', (array) ($manyOld['many__film_category__film_id'] ?? []));
                            $manyOptions = (array) (($manyToManyOptions ?? [])['many__film_category__film_id'] ?? []);
                            ?>
                            <input type="hidden" name="_many_present[many__film_category__film_id]" value="1">
                            <div id="many_component_many__film_category__film_id" class="crud-many-selector">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <label class="form-label mb-0">Select Category</label>
                                    <span class="badge text-bg-secondary" data-many-count>0 selected</span>
                                </div>

                                <div class="d-flex flex-wrap gap-1 mb-2" data-many-selected></div>

                                <div class="input-group input-group-sm mb-2 crud-many-primary-actions">
                                    <button
                                        class="btn btn-outline-secondary text-start flex-grow-1"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#many_picker_many__film_category__film_id"
                                        aria-expanded="false"
                                        aria-controls="many_picker_many__film_category__film_id"
                                    >
                                        <i class="bi bi-search me-1"></i>Search and select Category
                                    </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm crud-many-related-create-toggle"
                                    id="many_related_create_many__film_category__film_id_toggle"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#many_related_create_many__film_category__film_id"
                                    aria-controls="many_related_create_many__film_category__film_id"
                                    title="Create new Category"
                                    aria-label="Create new Category"
                                >
                                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>New Category
                                </button>                                </div>

                                <div class="collapse mt-2" id="many_picker_many__film_category__film_id">
                                    <div class="border rounded p-2 bg-body-tertiary">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input
                                                type="search"
                                                class="form-control"
                                                placeholder="Search Category..."
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
                                                        name="_many[many__film_category__film_id][]"
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
                                $manyCreateRelatedActive = !empty($manyCreateRelatedState['many__film_category__film_id']);
                                ?>
                                <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                                    <input
                                        type="hidden"
                                        name="_many_new[many__film_category__film_id]"
                                        id="many_related_create_many__film_category__film_id_state"
                                        value="<?= $manyCreateRelatedActive ? '1' : '0' ?>"
                                    >
                                    <span
                                        class="badge text-bg-success<?= $manyCreateRelatedActive ? '' : ' d-none' ?>"
                                        id="many_related_create_many__film_category__film_id_ready"
                                    >
                                        <i class="bi bi-check-circle me-1" aria-hidden="true"></i>
                                        New Category ready
                                    </span>
                                    <button
                                        type="button"
                                        class="btn btn-link btn-sm text-danger p-0<?= $manyCreateRelatedActive ? '' : ' d-none' ?> crud-many-related-create-remove"
                                        id="many_related_create_many__film_category__film_id_remove"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <div
                                    id="many_related_create_many__film_category__film_id"
                                    class="offcanvas offcanvas-end crud-many-related-create-panel"
                                    style="--bs-offcanvas-width: min(640px, 100vw);"
                                    tabindex="-1"
                                    aria-labelledby="many_related_create_many__film_category__film_id_label"
                                    data-state-target="many_related_create_many__film_category__film_id_state"
                                    data-toggle-target="many_related_create_many__film_category__film_id_toggle"
                                    data-ready-target="many_related_create_many__film_category__film_id_ready"
                                    data-remove-target="many_related_create_many__film_category__film_id_remove"
                                    data-bs-backdrop="static"
                                >
                                    <div class="offcanvas-header border-bottom">
                                        <div>
                                            <h2 class="offcanvas-title h5 mb-0" id="many_related_create_many__film_category__film_id_label">New Category</h2>
                                            <small class="text-muted">Create and add to this many-to-many relation</small>
                                        </div>
                                        <button
                                            type="button"
                                            class="btn-close crud-many-related-create-cancel"
                                            data-bs-dismiss="offcanvas"
                                            aria-label="Cancel new Category"
                                        ></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div class="alert alert-light border small" role="note">
                                            Enter the new Category data. It will be created with the main record and automatically added to this selection when the main form is submitted.
                                        </div>
                                        <div class="row g-3" data-many-related-fields>
<div class="col-12 col-md-6">
    <label class="form-label" for="many_related_create_many__film_category__film_id_name">Name</label>
    <input
    id="many_related_create_many__film_category__film_id_name"
    type="text"
    name="_many_related[many__film_category__film_id][name]"
    value="<?= esc((string) old('_many_related.many__film_category__film_id.name', '')) ?>"
    class="form-control <?= isset($errors['many__film_category__film_id__many_related__name']) ? 'is-invalid' : '' ?> crud-many-related-field"
    data-many-related-field
    disabled required maxlength="25"
>
    <?php if (!empty($errors['many__film_category__film_id__many_related__name'])): ?><div class="invalid-feedback d-block"><?= esc($errors['many__film_category__film_id__many_related__name']) ?></div><?php endif; ?>
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
                                            Apply new Category
                                        </button>
                                    </div>
                                </div>

                                <div class="form-text"><i class="bi bi-shield-check me-1"></i>Selected associations are revalidated server-side before pivot synchronization.</div>
                            </div>
                            <script>
                            (() => {
                                const root = document.getElementById('many_component_many__film_category__film_id');
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
