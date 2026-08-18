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
                    <label for="address" class="form-label">
                        <?= esc(lang('Address.address')) ?>
                    </label>
                    <input
                        type="text"
                        name="address"
                        id="address"
                        value="<?= esc(old('address', $row->{'address'} ?? ($context['address'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                        aria-describedby="address-error"
                        aria-invalid="<?= isset($errors['address']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['address'])): ?>
                        <div id="address-error" class="invalid-feedback d-block">
                            <?= esc($errors['address']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="address2" class="form-label">
                        <?= esc(lang('Address.address2')) ?>
                    </label>
                    <input
                        type="text"
                        name="address2"
                        id="address2"
                        value="<?= esc(old('address2', $row->{'address2'} ?? ($context['address2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['address2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="address2-error"
                        aria-invalid="<?= isset($errors['address2']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['address2'])): ?>
                        <div id="address2-error" class="invalid-feedback d-block">
                            <?= esc($errors['address2']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="district" class="form-label">
                        <?= esc(lang('Address.district')) ?>
                    </label>
                    <input
                        type="text"
                        name="district"
                        id="district"
                        value="<?= esc(old('district', $row->{'district'} ?? ($context['district'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['district']) ? 'is-invalid' : '' ?>"
                        aria-describedby="district-error"
                        aria-invalid="<?= isset($errors['district']) ? 'true' : 'false' ?>"
                        required maxlength="20"
                    >
                    <?php if (!empty($errors['district'])): ?>
                        <div id="district-error" class="invalid-feedback d-block">
                            <?= esc($errors['district']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="city_id" class="form-label">
                        <?= esc(lang('Address.city_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">
                    <select
                        name="city_id"
                        id="city_id"
                        class="form-select <?= isset($errors['city_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="city_id-error"
                        aria-invalid="<?= isset($errors['city_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['city_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('city_id', $row->{'city_id'} ?? ($context['city_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="city_id"
                            data-base-url="<?= site_url('city/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_city_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_city_id"
                            aria-controls="related_create_city_id"
                            data-related-field="city_id"
                            data-panel-target="related_create_city_id"
                            data-state-target="related_create_city_id_state"
                            title="Create new City"
                            aria-label="Create new City"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
</div>
                    <?php if (!empty($errors['city_id'])): ?>
                        <div id="city_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['city_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['city_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[city_id]"
                            id="related_create_city_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_city_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min(640px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="related_create_city_id_label"
                            data-related-field="city_id"
                            data-state-target="related_create_city_id_state"
                            data-toggle-target="related_create_city_id_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_city_id_label">New City</h2>
                                    <small class="text-muted">Relation city_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="city_id"
                                    data-state-target="related_create_city_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new City"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new City data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>
                                <?= view('address/_related_create_city_id', [
                                    'relatedField'        => 'city_id',
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
                                    data-related-field="city_id"
                                    data-state-target="related_create_city_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="city_id"
                                    data-state-target="related_create_city_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new City
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="postal_code" class="form-label">
                        <?= esc(lang('Address.postal_code')) ?>
                    </label>
                    <input
                        type="text"
                        name="postal_code"
                        id="postal_code"
                        value="<?= esc(old('postal_code', $row->{'postal_code'} ?? ($context['postal_code'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['postal_code']) ? 'is-invalid' : '' ?>"
                        aria-describedby="postal_code-error"
                        aria-invalid="<?= isset($errors['postal_code']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['postal_code'])): ?>
                        <div id="postal_code-error" class="invalid-feedback d-block">
                            <?= esc($errors['postal_code']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        <?= esc(lang('Address.phone')) ?>
                    </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="<?= esc(old('phone', $row->{'phone'} ?? ($context['phone'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                        aria-describedby="phone-error"
                        aria-invalid="<?= isset($errors['phone']) ? 'true' : 'false' ?>"
                        required maxlength="20"
                    >
                    <?php if (!empty($errors['phone'])): ?>
                        <div id="phone-error" class="invalid-feedback d-block">
                            <?= esc($errors['phone']) ?>
                        </div>
                    <?php endif; ?>
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
