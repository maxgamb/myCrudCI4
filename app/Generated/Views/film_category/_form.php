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
                    <label for="film_id" class="form-label">
                        <?= esc(lang('FilmCategory.film_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">
                    <select
                        name="film_id"
                        id="film_id"
                        class="form-select <?= isset($errors['film_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="film_id-error"
                        aria-invalid="<?= isset($errors['film_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['film_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('film_id', $row->{'film_id'} ?? ($context['film_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="film_id"
                            data-base-url="<?= site_url('film/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_film_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_film_id"
                            aria-controls="related_create_film_id"
                            data-related-field="film_id"
                            data-panel-target="related_create_film_id"
                            data-state-target="related_create_film_id_state"
                            title="Create new Film"
                            aria-label="Create new Film"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
</div>
                    <?php if (!empty($errors['film_id'])): ?>
                        <div id="film_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['film_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['film_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[film_id]"
                            id="related_create_film_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_film_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_film_id_label"
                            data-related-field="film_id"
                            data-state-target="related_create_film_id_state"
                            data-toggle-target="related_create_film_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_film_id_label">New Film</h2>
                                    <small class="text-muted">Relation film_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="film_id"
                                    data-state-target="related_create_film_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new Film"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new Film data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('film_category/_related_create_film_id', [
                                    'relatedField'        => 'film_id',
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
                                    data-related-field="film_id"
                                    data-state-target="related_create_film_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="film_id"
                                    data-state-target="related_create_film_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new Film
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="category_id" class="form-label">
                        <?= esc(lang('FilmCategory.category_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">
                    <select
                        name="category_id"
                        id="category_id"
                        class="form-select <?= isset($errors['category_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="category_id-error"
                        aria-invalid="<?= isset($errors['category_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['category_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('category_id', $row->{'category_id'} ?? ($context['category_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="category_id"
                            data-base-url="<?= site_url('category/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_category_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_category_id"
                            aria-controls="related_create_category_id"
                            data-related-field="category_id"
                            data-panel-target="related_create_category_id"
                            data-state-target="related_create_category_id_state"
                            title="Create new Category"
                            aria-label="Create new Category"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
</div>
                    <?php if (!empty($errors['category_id'])): ?>
                        <div id="category_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['category_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['category_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[category_id]"
                            id="related_create_category_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_category_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_category_id_label"
                            data-related-field="category_id"
                            data-state-target="related_create_category_id_state"
                            data-toggle-target="related_create_category_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_category_id_label">New Category</h2>
                                    <small class="text-muted">Relation category_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="category_id"
                                    data-state-target="related_create_category_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new Category"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new Category data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('film_category/_related_create_category_id', [
                                    'relatedField'        => 'category_id',
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
                                    data-related-field="category_id"
                                    data-state-target="related_create_category_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="category_id"
                                    data-state-target="related_create_category_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new Category
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
