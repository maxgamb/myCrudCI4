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
                    <label for="first_name" class="form-label">
                        <?= esc(lang('Staff.first_name')) ?>
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
                        <?= esc(lang('Staff.last_name')) ?>
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

                <div class="col-md-6">
                    <label for="address_id" class="form-label">
                        <?= esc(lang('Staff.address_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
                        name="address_id"
                        id="address_id"
                        class="form-select <?= isset($errors['address_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="address_id-error"
                        aria-invalid="<?= isset($errors['address_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['address_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('address_id', $row->{'address_id'} ?? ($context['address_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="address_id"
                            data-base-url="<?= site_url('address/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a></div>
                    <?php if (!empty($errors['address_id'])): ?>
                        <div id="address_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['address_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="picture" class="form-label">
                        <?= esc(lang('Staff.picture')) ?>
                    </label>
                    <textarea
                        name="picture"
                        id="picture"
                        class="form-control <?= isset($errors['picture']) ? 'is-invalid' : '' ?>"
                        aria-describedby="picture-error"
                        aria-invalid="<?= isset($errors['picture']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('picture', $row->{'picture'} ?? ($context['picture'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['picture'])): ?>
                        <div id="picture-error" class="invalid-feedback d-block">
                            <?= esc($errors['picture']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <?= esc(lang('Staff.email')) ?>
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

                <div class="col-md-6">
                    <label for="store_id" class="form-label">
                        <?= esc(lang('Staff.store_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
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
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="store_id"
                            data-base-url="<?= site_url('store/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
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
                            title="Crea nuovo Store"
                            aria-label="Crea nuovo Store"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?></div>
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
                            tabindex="-1"
                            aria-labelledby="related_create_store_id_label"
                            data-related-field="store_id"
                            data-state-target="related_create_store_id_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_store_id_label">Nuovo Store</h2>
                                    <small class="text-muted">Relazione store_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="store_id"
                                    data-state-target="related_create_store_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo Store"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo Store. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('staff/_related_create_store_id', [
                                    'relatedField'        => 'store_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="store_id"
                                    data-state-target="related_create_store_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo Store
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="active" class="form-label">
                        <?= esc(lang('Staff.active')) ?>
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

                <div class="col-md-6">
                    <label for="username" class="form-label">
                        <?= esc(lang('Staff.username')) ?>
                    </label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        value="<?= esc(old('username', $row->{'username'} ?? ($context['username'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                        aria-describedby="username-error"
                        aria-invalid="<?= isset($errors['username']) ? 'true' : 'false' ?>"
                        required maxlength="16"
                    >
                    <?php if (!empty($errors['username'])): ?>
                        <div id="username-error" class="invalid-feedback d-block">
                            <?= esc($errors['username']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">
                        <?= esc(lang('Staff.password')) ?>
                    </label>
                    <input
                        type="text"
                        name="password"
                        id="password"
                        value="<?= esc(old('password', $row->{'password'} ?? ($context['password'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="password-error"
                        aria-invalid="<?= isset($errors['password']) ? 'true' : 'false' ?>"
                        maxlength="40"
                    >
                    <?php if (!empty($errors['password'])): ?>
                        <div id="password-error" class="invalid-feedback d-block">
                            <?= esc($errors['password']) ?>
                        </div>
                    <?php endif; ?>
                </div>

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
