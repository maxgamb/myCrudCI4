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
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_section_1786613734762" open>
                        <summary class="fw-semibold">Anagrafica</summary>

                        <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">
                        <?= esc(lang('Customer.first_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        value="<?= esc(old('first_name', $row->{'first_name'} ?? ($context['first_name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="first_name-error"
                        aria-invalid="<?= isset($errors['first_name']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['first_name'])): ?>
                        <div id="first_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['first_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="last_name" class="form-label">
                        <?= esc(lang('Customer.last_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="last_name"
                        id="last_name"
                        value="<?= esc(old('last_name', $row->{'last_name'} ?? ($context['last_name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="last_name-error"
                        aria-invalid="<?= isset($errors['last_name']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['last_name'])): ?>
                        <div id="last_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['last_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                        </div>
                    </details>
                </div>
                <div class="col-12 crud-form-section-col">
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_section_1786613822807" open>
                        <summary class="fw-semibold">Indizzo</summary>

                        <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="address_id" class="form-label">
                        <?= esc(lang('Customer.address_id')) ?>
                    </label>
                    <input
                        type="hidden"
                        name="address_id"
                        id="address_id"
                        value="<?= esc(old('address_id', $row->{'address_id'} ?? ($context['address_id'] ?? ''))) ?>"
                        class="crud-relation-value"
                    >
                    <input
                        type="search"
                        name="address_id__label"
                        id="address_id_search"
                        value="<?= esc(old('address_id__label', $row->{'address_id__label'} ?? ($contextLabels['address_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['address_id']) ? 'is-invalid' : '' ?> crud-relation-search"
                        data-url="<?= site_url('customer/relation-options/address_id') ?>"
                        data-value-target="address_id"
                        data-results-target="address_id_results"
                        data-min-chars="2"
                        autocomplete="off"
                        aria-describedby="address_id-error"
                    >
                    <select
                        id="address_id_results"
                        class="form-select mt-2 d-none crud-relation-results"
                        size="5"
                        aria-label="Search results"
                    ></select><div class="d-flex gap-1 mt-2 relation-navigation-actions">                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="address_id"
                            data-base-url="<?= site_url('address/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_address_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_address_id"
                            aria-controls="related_create_address_id"
                            data-related-field="address_id"
                            data-panel-target="related_create_address_id"
                            data-state-target="related_create_address_id_state"
                            title="Create new Address"
                            aria-label="Create new Address"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?></div>
                    <?php if (!empty($errors['address_id'])): ?>
                        <div id="address_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['address_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['address_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[address_id]"
                            id="related_create_address_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_address_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_address_id_label"
                            data-related-field="address_id"
                            data-state-target="related_create_address_id_state"
                            data-toggle-target="related_create_address_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_address_id_label">New Address</h2>
                                    <small class="text-muted">Relation address_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="address_id"
                                    data-state-target="related_create_address_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new Address"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new Address data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('customer/_related_create_address_id', [
                                    'relatedField'        => 'address_id',
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
                                    data-related-field="address_id"
                                    data-state-target="related_create_address_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="address_id"
                                    data-state-target="related_create_address_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new Address
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <?= esc(lang('Customer.email')) ?>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="<?= esc(old('email', $row->{'email'} ?? ($context['email'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email-error"
                        aria-invalid="<?= isset($errors['email']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['email'])): ?>
                        <div id="email-error" class="invalid-feedback d-block">
                            <?= esc($errors['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                        </div>
                    </details>
                </div>
                <div class="col-12 crud-form-section-col">
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_general" open>
                        <summary class="fw-semibold">Dati generali</summary>

                        <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label for="store_id" class="form-label">
                        <?= esc(lang('Customer.store_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">
                    <select
                        name="store_id"
                        id="store_id"
                        class="form-select <?= isset($errors['store_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="store_id-error"
                        aria-invalid="<?= isset($errors['store_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['store_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('store_id', $row->{'store_id'} ?? ($context['store_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="store_id"
                            data-base-url="<?= site_url('store/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_store_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_store_id"
                            aria-controls="related_create_store_id"
                            data-related-field="store_id"
                            data-panel-target="related_create_store_id"
                            data-state-target="related_create_store_id_state"
                            title="Create new Store"
                            aria-label="Create new Store"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
</div>
                    <?php if (!empty($errors['store_id'])): ?>
                        <div id="store_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['store_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['store_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[store_id]"
                            id="related_create_store_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_store_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_store_id_label"
                            data-related-field="store_id"
                            data-state-target="related_create_store_id_state"
                            data-toggle-target="related_create_store_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_store_id_label">New Store</h2>
                                    <small class="text-muted">Relation store_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="store_id"
                                    data-state-target="related_create_store_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new Store"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new Store data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('customer/_related_create_store_id', [
                                    'relatedField'        => 'store_id',
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
                                    data-related-field="store_id"
                                    data-state-target="related_create_store_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="store_id"
                                    data-state-target="related_create_store_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new Store
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="active" class="form-label">
                        <?= esc(lang('Customer.active')) ?>
                    </label>
                    <input type="hidden" name="active" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="active"
                            id="active"
                            value="1"
                            class="form-check-input <?= isset($errors['active']) ? 'is-invalid' : '' ?>"
                            <?= old('active', $row->{'active'} ?? ($context['active'] ?? '')) ? 'checked' : '' ?>
                        aria-describedby="active-error"
                        aria-invalid="<?= isset($errors['active']) ? 'true' : 'false' ?>"
                        required
                        >
                    </div>
                    <?php if (!empty($errors['active'])): ?>
                        <div id="active-error" class="invalid-feedback d-block">
                            <?= esc($errors['active']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-none">
                    <input type="hidden" name="create_date" id="create_date" value="<?= esc(old('create_date', $row->{'create_date'} ?? ($context['create_date'] ?? date('Y-m-d H:i:s')))) ?>">
                    <?php if (!empty($errors['create_date'])): ?>
                        <div id="create_date-error" class="invalid-feedback d-block">
                            <?= esc($errors['create_date']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                        </div>
                    </details>
                </div>
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
