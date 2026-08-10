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
$submissionToken = $submissionToken ?? '';
?>

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

                <div class="col-md-6">
                    <label for="rental_date" class="form-label">
                        <?= esc(lang('Rental.rental_date')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="rental_date"
                        id="rental_date"
                        value="<?= esc(old('rental_date', isset($row->{'rental_date'}) ? str_replace(' ', 'T', substr((string) $row->{'rental_date'}, 0, 16)) : ($context['rental_date'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rental_date']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rental_date-error"
                        aria-invalid="<?= isset($errors['rental_date']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['rental_date'])): ?>
                        <div id="rental_date-error" class="invalid-feedback d-block">
                            <?= esc($errors['rental_date']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="inventory_id" class="form-label">
                        <?= esc(lang('Rental.inventory_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
                        name="inventory_id"
                        id="inventory_id"
                        class="form-select <?= isset($errors['inventory_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="inventory_id-error"
                        aria-invalid="<?= isset($errors['inventory_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['inventory_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('inventory_id', $row->{'inventory_id'} ?? ($context['inventory_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="inventory_id"
                            data-base-url="<?= site_url('inventory/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_inventory_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_inventory_id"
                            aria-controls="related_create_inventory_id"
                            data-related-field="inventory_id"
                            data-panel-target="related_create_inventory_id"
                            data-state-target="related_create_inventory_id_state"
                            title="Crea nuovo Inventory"
                            aria-label="Crea nuovo Inventory"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?></div>
                    <?php if (!empty($errors['inventory_id'])): ?>
                        <div id="inventory_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['inventory_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['inventory_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[inventory_id]"
                            id="related_create_inventory_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_inventory_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            tabindex="-1"
                            aria-labelledby="related_create_inventory_id_label"
                            data-related-field="inventory_id"
                            data-state-target="related_create_inventory_id_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_inventory_id_label">Nuovo Inventory</h2>
                                    <small class="text-muted">Relazione inventory_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="inventory_id"
                                    data-state-target="related_create_inventory_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo Inventory"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo Inventory. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('rental/_related_create_inventory_id', [
                                    'relatedField'        => 'inventory_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="inventory_id"
                                    data-state-target="related_create_inventory_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo Inventory
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="customer_id" class="form-label">
                        <?= esc(lang('Rental.customer_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
                        name="customer_id"
                        id="customer_id"
                        class="form-select <?= isset($errors['customer_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="customer_id-error"
                        aria-invalid="<?= isset($errors['customer_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['customer_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('customer_id', $row->{'customer_id'} ?? ($context['customer_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="customer_id"
                            data-base-url="<?= site_url('customer/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_customer_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_customer_id"
                            aria-controls="related_create_customer_id"
                            data-related-field="customer_id"
                            data-panel-target="related_create_customer_id"
                            data-state-target="related_create_customer_id_state"
                            title="Crea nuovo Customer"
                            aria-label="Crea nuovo Customer"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?></div>
                    <?php if (!empty($errors['customer_id'])): ?>
                        <div id="customer_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['customer_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['customer_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[customer_id]"
                            id="related_create_customer_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_customer_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            tabindex="-1"
                            aria-labelledby="related_create_customer_id_label"
                            data-related-field="customer_id"
                            data-state-target="related_create_customer_id_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_customer_id_label">Nuovo Customer</h2>
                                    <small class="text-muted">Relazione customer_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="customer_id"
                                    data-state-target="related_create_customer_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo Customer"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo Customer. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('rental/_related_create_customer_id', [
                                    'relatedField'        => 'customer_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="customer_id"
                                    data-state-target="related_create_customer_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo Customer
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="return_date" class="form-label">
                        <?= esc(lang('Rental.return_date')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="return_date"
                        id="return_date"
                        value="<?= esc(old('return_date', isset($row->{'return_date'}) ? str_replace(' ', 'T', substr((string) $row->{'return_date'}, 0, 16)) : ($context['return_date'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['return_date']) ? 'is-invalid' : '' ?>"
                        aria-describedby="return_date-error"
                        aria-invalid="<?= isset($errors['return_date']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['return_date'])): ?>
                        <div id="return_date-error" class="invalid-feedback d-block">
                            <?= esc($errors['return_date']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="staff_id" class="form-label">
                        <?= esc(lang('Rental.staff_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
                        name="staff_id"
                        id="staff_id"
                        class="form-select <?= isset($errors['staff_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="staff_id-error"
                        aria-invalid="<?= isset($errors['staff_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['staff_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('staff_id', $row->{'staff_id'} ?? ($context['staff_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="staff_id"
                            data-base-url="<?= site_url('staff/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_staff_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_staff_id"
                            aria-controls="related_create_staff_id"
                            data-related-field="staff_id"
                            data-panel-target="related_create_staff_id"
                            data-state-target="related_create_staff_id_state"
                            title="Crea nuovo Staff"
                            aria-label="Crea nuovo Staff"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?></div>
                    <?php if (!empty($errors['staff_id'])): ?>
                        <div id="staff_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['staff_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['staff_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[staff_id]"
                            id="related_create_staff_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_staff_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            tabindex="-1"
                            aria-labelledby="related_create_staff_id_label"
                            data-related-field="staff_id"
                            data-state-target="related_create_staff_id_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_staff_id_label">Nuovo Staff</h2>
                                    <small class="text-muted">Relazione staff_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="staff_id"
                                    data-state-target="related_create_staff_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo Staff"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo Staff. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('rental/_related_create_staff_id', [
                                    'relatedField'        => 'staff_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="staff_id"
                                    data-state-target="related_create_staff_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo Staff
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <span class="submit-normal"><i class="bi bi-check-circle"></i> Salva</span>
                        <span class="submit-loading d-none">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            Salvataggio...
                        </span>
                    </button>

                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('myCrudForm');
    const submitButton = document.getElementById('submitButton');

    if (!form || !submitButton) return;

    let submitted = false;

    // Select AJAX per relazioni grandi: il browser carica soltanto i risultati
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
                    if (!response.ok) throw new Error('Errore ricerca relazione');

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

    // Mantiene il link al record padre sincronizzato con il valore FK,
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
        link.href = baseUrl + '/' + encodeURIComponent(value);
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
    // La select/relazione originaria resta visivamente e funzionalmente
    // invariata; quando _related_new[field]=1 il server ignora la FK esistente
    // e crea il nuovo parent nella stessa transazione del record principale.
    const setRelatedCreateState = function (panel, active) {
        const field = String(panel.dataset.relatedField || '');
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (field === '' || !state) return;

        state.value = active ? '1' : '0';
        panel.querySelectorAll('.crud-related-create-field').forEach(function (input) {
            input.disabled = !active;
        });
    };

    document.querySelectorAll('.crud-related-create-panel.offcanvas').forEach(function (panel) {
        const field = String(panel.dataset.relatedField || '');
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (field === '' || !state) return;

        setRelatedCreateState(panel, String(state.value || '0') === '1');

        panel.addEventListener('show.bs.offcanvas', function () {
            setRelatedCreateState(panel, true);
        });

        // Chiudere l'Offcanvas equivale ad annullare la creazione inline.
        // I valori digitati restano nel DOM e possono essere recuperati
        // riaprendo il pannello, ma non vengono inviati finché lo stato è 0.
        panel.addEventListener('hidden.bs.offcanvas', function () {
            setRelatedCreateState(panel, false);
        });

        // Se la validazione server ha restituito errori sul nuovo parent,
        // riapri automaticamente il pannello per mostrare campi ed errori.
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
