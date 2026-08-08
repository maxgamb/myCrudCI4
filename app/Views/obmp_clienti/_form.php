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
                    <label for="obm_cliente_first_name" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_first_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_first_name"
                        id="obm_cliente_first_name"
                        value="<?= esc(old('obm_cliente_first_name', $row->obm_cliente_first_name ?? ($context['obm_cliente_first_name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_first_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_first_name-error"
                        aria-invalid="<?= isset($errors['obm_cliente_first_name']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_first_name'])): ?>
                        <div id="obm_cliente_first_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_first_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_last_name" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_last_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_last_name"
                        id="obm_cliente_last_name"
                        value="<?= esc(old('obm_cliente_last_name', $row->obm_cliente_last_name ?? ($context['obm_cliente_last_name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_last_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_last_name-error"
                        aria-invalid="<?= isset($errors['obm_cliente_last_name']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_last_name'])): ?>
                        <div id="obm_cliente_last_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_last_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_email" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="obm_cliente_email"
                        id="obm_cliente_email"
                        value="<?= esc(old('obm_cliente_email', $row->obm_cliente_email ?? ($context['obm_cliente_email'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_email-error"
                        aria-invalid="<?= isset($errors['obm_cliente_email']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_email'])): ?>
                        <div id="obm_cliente_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_city" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_city')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_city"
                        id="obm_cliente_city"
                        value="<?= esc(old('obm_cliente_city', $row->obm_cliente_city ?? ($context['obm_cliente_city'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_city']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_city-error"
                        aria-invalid="<?= isset($errors['obm_cliente_city']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_city'])): ?>
                        <div id="obm_cliente_city-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_city']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_country" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_country')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_country"
                        id="obm_cliente_country"
                        value="<?= esc(old('obm_cliente_country', $row->obm_cliente_country ?? ($context['obm_cliente_country'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_country']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_country-error"
                        aria-invalid="<?= isset($errors['obm_cliente_country']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_country'])): ?>
                        <div id="obm_cliente_country-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_country']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="lingua" class="form-label">
                        <?= esc(lang('ObmpClienti.lingua')) ?>
                    </label>
                    <input
                        type="text"
                        name="lingua"
                        id="lingua"
                        value="<?= esc(old('lingua', $row->lingua ?? ($context['lingua'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['lingua']) ? 'is-invalid' : '' ?>"
                        aria-describedby="lingua-error"
                        aria-invalid="<?= isset($errors['lingua']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['lingua'])): ?>
                        <div id="lingua-error" class="invalid-feedback d-block">
                            <?= esc($errors['lingua']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_phone" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_phone')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_phone"
                        id="obm_cliente_phone"
                        value="<?= esc(old('obm_cliente_phone', $row->obm_cliente_phone ?? ($context['obm_cliente_phone'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_phone']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_phone-error"
                        aria-invalid="<?= isset($errors['obm_cliente_phone']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_phone'])): ?>
                        <div id="obm_cliente_phone-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_phone']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_newsletter" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_newsletter')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_newsletter"
                        id="obm_cliente_newsletter"
                        value="<?= esc(old('obm_cliente_newsletter', $row->obm_cliente_newsletter ?? ($context['obm_cliente_newsletter'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_newsletter']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_newsletter-error"
                        aria-invalid="<?= isset($errors['obm_cliente_newsletter']) ? 'true' : 'false' ?>"
                        maxlength="1"
                    >
                    <?php if (!empty($errors['obm_cliente_newsletter'])): ?>
                        <div id="obm_cliente_newsletter-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_newsletter']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_pass" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_pass')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_pass"
                        id="obm_cliente_pass"
                        value="<?= esc(old('obm_cliente_pass', $row->obm_cliente_pass ?? ($context['obm_cliente_pass'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_pass']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_pass-error"
                        aria-invalid="<?= isset($errors['obm_cliente_pass']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_pass'])): ?>
                        <div id="obm_cliente_pass-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_pass']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_data_insert" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_data_insert')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="obm_cliente_data_insert"
                        id="obm_cliente_data_insert"
                        value="<?= esc(old('obm_cliente_data_insert', isset($row->obm_cliente_data_insert) ? str_replace(' ', 'T', substr((string) $row->obm_cliente_data_insert, 0, 16)) : ($context['obm_cliente_data_insert'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_data_insert']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_data_insert-error"
                        aria-invalid="<?= isset($errors['obm_cliente_data_insert']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obm_cliente_data_insert'])): ?>
                        <div id="obm_cliente_data_insert-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_data_insert']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_cc_type" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_cc_type')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_cc_type"
                        id="obm_cliente_cc_type"
                        value="<?= esc(old('obm_cliente_cc_type', $row->obm_cliente_cc_type ?? ($context['obm_cliente_cc_type'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_cc_type']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_cc_type-error"
                        aria-invalid="<?= isset($errors['obm_cliente_cc_type']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['obm_cliente_cc_type'])): ?>
                        <div id="obm_cliente_cc_type-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_cc_type']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_cc_number" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_cc_number')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_cc_number"
                        id="obm_cliente_cc_number"
                        value="<?= esc(old('obm_cliente_cc_number', $row->obm_cliente_cc_number ?? ($context['obm_cliente_cc_number'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_cc_number']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_cc_number-error"
                        aria-invalid="<?= isset($errors['obm_cliente_cc_number']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_cc_number'])): ?>
                        <div id="obm_cliente_cc_number-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_cc_number']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_holder" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_holder')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_holder"
                        id="obm_cliente_holder"
                        value="<?= esc(old('obm_cliente_holder', $row->obm_cliente_holder ?? ($context['obm_cliente_holder'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_holder']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_holder-error"
                        aria-invalid="<?= isset($errors['obm_cliente_holder']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obm_cliente_holder'])): ?>
                        <div id="obm_cliente_holder-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_holder']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_cc_expire" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_cc_expire')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_cc_expire"
                        id="obm_cliente_cc_expire"
                        value="<?= esc(old('obm_cliente_cc_expire', $row->obm_cliente_cc_expire ?? ($context['obm_cliente_cc_expire'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_cc_expire']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_cc_expire-error"
                        aria-invalid="<?= isset($errors['obm_cliente_cc_expire']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['obm_cliente_cc_expire'])): ?>
                        <div id="obm_cliente_cc_expire-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_cc_expire']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obm_cliente_cc_security" class="form-label">
                        <?= esc(lang('ObmpClienti.obm_cliente_cc_security')) ?>
                    </label>
                    <input
                        type="text"
                        name="obm_cliente_cc_security"
                        id="obm_cliente_cc_security"
                        value="<?= esc(old('obm_cliente_cc_security', $row->obm_cliente_cc_security ?? ($context['obm_cliente_cc_security'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obm_cliente_cc_security']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obm_cliente_cc_security-error"
                        aria-invalid="<?= isset($errors['obm_cliente_cc_security']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['obm_cliente_cc_security'])): ?>
                        <div id="obm_cliente_cc_security-error" class="invalid-feedback d-block">
                            <?= esc($errors['obm_cliente_cc_security']) ?>
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

                    <a href="<?= site_url('obmp_clienti') ?>" class="btn btn-secondary">
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
