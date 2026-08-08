<?php
$formTitle = $formTitle ?? 'Gestione record';
$formIcon = $formIcon ?? 'bi-pencil-square';
$formAction = $formAction ?? current_url();
$row = $row ?? null;
$errors = $errors ?? [];
$options = $options ?? [];
$context = $context ?? [];
$contextLabels = $contextLabels ?? [];
$submissionToken = $submissionToken ?? '';
?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0">
                <i class="bi <?= esc($formIcon) ?>"></i>
                <?= esc($formTitle) ?>
            </h1>
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

                <div class="col-md-6">
                    <label for="ref_obm_data" class="form-label">
                        <?= esc(lang('RefObmpBooking.ref_obm_data')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="ref_obm_data"
                        id="ref_obm_data"
                        value="<?= esc(old('ref_obm_data', isset($row->ref_obm_data) ? str_replace(' ', 'T', substr((string) $row->ref_obm_data, 0, 16)) : ($context['ref_obm_data'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_obm_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_obm_data-error"
                        aria-invalid="<?= isset($errors['ref_obm_data']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_obm_data'])): ?>
                        <div id="ref_obm_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_obm_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('RefObmpBooking.preno_id')) ?>
                    </label>
                    <select
                        name="preno_id"
                        id="preno_id"
                        class="form-select <?= isset($errors['preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_id-error"
                        aria-invalid="<?= isset($errors['preno_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_id', $row->preno_id ?? ($context['preno_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="preno_id"
                            data-base-url="<?= site_url('agenda/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('agenda/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['preno_id'])): ?>
                        <div id="preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_id" class="form-label">
                        <?= esc(lang('RefObmpBooking.obm_cliente_id')) ?>
                    </label>
                    <select
                        name="obm_cliente_id"
                        id="obm_cliente_id"
                        class="form-select <?= isset($errors['obm_cliente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_id-error"
                        aria-invalid="<?= isset($errors['obm_cliente_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obm_cliente_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obm_cliente_id', $row->obm_cliente_id ?? ($context['obm_cliente_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="obm_cliente_id"
                            data-base-url="<?= site_url('obmp_clienti/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('obmp_clienti/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['obm_cliente_id'])): ?>
                        <div id="obm_cliente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('RefObmpBooking.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_id-error"
                        aria-invalid="<?= isset($errors['hotel_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_site" class="form-label">
                        <?= esc(lang('RefObmpBooking.ref_site')) ?>
                    </label>
                    <select
                        name="ref_site"
                        id="ref_site"
                        class="form-select <?= isset($errors['ref_site']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_site-error"
                        aria-invalid="<?= isset($errors['ref_site']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['ref_site'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('ref_site', $row->ref_site ?? ($context['ref_site'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="ref_site"
                            data-base-url="<?= site_url('obmp_ref_site/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('obmp_ref_site/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['ref_site'])): ?>
                        <div id="ref_site-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_site']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_agency" class="form-label">
                        <?= esc(lang('RefObmpBooking.ref_agency')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_agency"
                        id="ref_agency"
                        value="<?= esc(old('ref_agency', $row->ref_agency ?? ($context['ref_agency'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_agency']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_agency-error"
                        aria-invalid="<?= isset($errors['ref_agency']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_agency'])): ?>
                        <div id="ref_agency-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_agency']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_event" class="form-label">
                        <?= esc(lang('RefObmpBooking.ref_event')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_event"
                        id="ref_event"
                        value="<?= esc(old('ref_event', $row->ref_event ?? ($context['ref_event'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_event']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_event-error"
                        aria-invalid="<?= isset($errors['ref_event']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_event'])): ?>
                        <div id="ref_event-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_event']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_session" class="form-label">
                        <?= esc(lang('RefObmpBooking.ref_session')) ?>
                    </label>
                    <input
                        type="text"
                        name="ref_session"
                        id="ref_session"
                        value="<?= esc(old('ref_session', $row->ref_session ?? ($context['ref_session'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_session']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_session-error"
                        aria-invalid="<?= isset($errors['ref_session']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['ref_session'])): ?>
                        <div id="ref_session-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_session']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_cookie" class="form-label">
                        <?= esc(lang('RefObmpBooking.ref_cookie')) ?>
                    </label>
                    <input
                        type="text"
                        name="ref_cookie"
                        id="ref_cookie"
                        value="<?= esc(old('ref_cookie', $row->ref_cookie ?? ($context['ref_cookie'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_cookie']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_cookie-error"
                        aria-invalid="<?= isset($errors['ref_cookie']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['ref_cookie'])): ?>
                        <div id="ref_cookie-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_cookie']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="room_obmp_string" class="form-label">
                        <?= esc(lang('RefObmpBooking.room_obmp_string')) ?>
                    </label>
                    <input
                        type="text"
                        name="room_obmp_string"
                        id="room_obmp_string"
                        value="<?= esc(old('room_obmp_string', $row->room_obmp_string ?? ($context['room_obmp_string'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['room_obmp_string']) ? 'is-invalid' : '' ?>"
                        aria-describedby="room_obmp_string-error"
                        aria-invalid="<?= isset($errors['room_obmp_string']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['room_obmp_string'])): ?>
                        <div id="room_obmp_string-error" class="invalid-feedback d-block">
                            <?= esc($errors['room_obmp_string']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_id" class="form-label">
                        <?= esc(lang('RefObmpBooking.quote_id')) ?>
                    </label>
                    <select
                        name="quote_id"
                        id="quote_id"
                        class="form-select <?= isset($errors['quote_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_id-error"
                        aria-invalid="<?= isset($errors['quote_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['quote_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('quote_id', $row->quote_id ?? ($context['quote_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="quote_id"
                            data-base-url="<?= site_url('obmp_quote/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('obmp_quote/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['quote_id'])): ?>
                        <div id="quote_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_id']) ?>
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

                    <a href="<?= site_url('ref_obmp_booking') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annulla
                    </a>
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
