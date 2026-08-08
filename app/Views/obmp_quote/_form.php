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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpQuote.hotel_id')) ?>
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
                    <label for="quote_lg" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_lg')) ?>
                    </label>
                    <input
                        type="text"
                        name="quote_lg"
                        id="quote_lg"
                        value="<?= esc(old('quote_lg', $row->quote_lg ?? ($context['quote_lg'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_lg']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_lg-error"
                        aria-invalid="<?= isset($errors['quote_lg']) ? 'true' : 'false' ?>"
                        required maxlength="6"
                    >
                    <?php if (!empty($errors['quote_lg'])): ?>
                        <div id="quote_lg-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_lg']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_dal" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="quote_dal"
                        id="quote_dal"
                        value="<?= esc(old('quote_dal', $row->quote_dal ?? ($context['quote_dal'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_dal-error"
                        aria-invalid="<?= isset($errors['quote_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['quote_dal'])): ?>
                        <div id="quote_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_al" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="quote_al"
                        id="quote_al"
                        value="<?= esc(old('quote_al', $row->quote_al ?? ($context['quote_al'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_al-error"
                        aria-invalid="<?= isset($errors['quote_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['quote_al'])): ?>
                        <div id="quote_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_titolo" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_titolo')) ?>
                    </label>
                    <input
                        type="text"
                        name="quote_titolo"
                        id="quote_titolo"
                        value="<?= esc(old('quote_titolo', $row->quote_titolo ?? ($context['quote_titolo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_titolo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_titolo-error"
                        aria-invalid="<?= isset($errors['quote_titolo']) ? 'true' : 'false' ?>"
                        required maxlength="8"
                    >
                    <?php if (!empty($errors['quote_titolo'])): ?>
                        <div id="quote_titolo-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_titolo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_cognome" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_cognome')) ?>
                    </label>
                    <input
                        type="text"
                        name="quote_cognome"
                        id="quote_cognome"
                        value="<?= esc(old('quote_cognome', $row->quote_cognome ?? ($context['quote_cognome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_cognome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_cognome-error"
                        aria-invalid="<?= isset($errors['quote_cognome']) ? 'true' : 'false' ?>"
                        maxlength="225"
                    >
                    <?php if (!empty($errors['quote_cognome'])): ?>
                        <div id="quote_cognome-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_cognome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_nome" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="quote_nome"
                        id="quote_nome"
                        value="<?= esc(old('quote_nome', $row->quote_nome ?? ($context['quote_nome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_nome-error"
                        aria-invalid="<?= isset($errors['quote_nome']) ? 'true' : 'false' ?>"
                        maxlength="225"
                    >
                    <?php if (!empty($errors['quote_nome'])): ?>
                        <div id="quote_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_email" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="quote_email"
                        id="quote_email"
                        value="<?= esc(old('quote_email', $row->quote_email ?? ($context['quote_email'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_email-error"
                        aria-invalid="<?= isset($errors['quote_email']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['quote_email'])): ?>
                        <div id="quote_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="trattamento_id" class="form-label">
                        <?= esc(lang('ObmpQuote.trattamento_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="trattamento_id"
                        id="trattamento_id"
                        value="<?= esc(old('trattamento_id', $row->trattamento_id ?? ($context['trattamento_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['trattamento_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="trattamento_id-error"
                        aria-invalid="<?= isset($errors['trattamento_id']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['trattamento_id'])): ?>
                        <div id="trattamento_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['trattamento_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="trariffa_id" class="form-label">
                        <?= esc(lang('ObmpQuote.trariffa_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="trariffa_id"
                        id="trariffa_id"
                        value="<?= esc(old('trariffa_id', $row->trariffa_id ?? ($context['trariffa_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['trariffa_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="trariffa_id-error"
                        aria-invalid="<?= isset($errors['trariffa_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['trariffa_id'])): ?>
                        <div id="trariffa_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['trariffa_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cax_policy_id" class="form-label">
                        <?= esc(lang('ObmpQuote.cax_policy_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="cax_policy_id"
                        id="cax_policy_id"
                        value="<?= esc(old('cax_policy_id', $row->cax_policy_id ?? ($context['cax_policy_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['cax_policy_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cax_policy_id-error"
                        aria-invalid="<?= isset($errors['cax_policy_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['cax_policy_id'])): ?>
                        <div id="cax_policy_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['cax_policy_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_tel_rich" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_tel_rich')) ?>
                    </label>
                    <input
                        type="number"
                        name="quote_tel_rich"
                        id="quote_tel_rich"
                        value="<?= esc(old('quote_tel_rich', $row->quote_tel_rich ?? ($context['quote_tel_rich'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_tel_rich']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_tel_rich-error"
                        aria-invalid="<?= isset($errors['quote_tel_rich']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['quote_tel_rich'])): ?>
                        <div id="quote_tel_rich-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_tel_rich']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_cc_rich" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_cc_rich')) ?>
                    </label>
                    <input
                        type="number"
                        name="quote_cc_rich"
                        id="quote_cc_rich"
                        value="<?= esc(old('quote_cc_rich', $row->quote_cc_rich ?? ($context['quote_cc_rich'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_cc_rich']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_cc_rich-error"
                        aria-invalid="<?= isset($errors['quote_cc_rich']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['quote_cc_rich'])): ?>
                        <div id="quote_cc_rich-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_cc_rich']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_del" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_del')) ?>
                    </label>
                    <input
                        type="date"
                        name="quote_del"
                        id="quote_del"
                        value="<?= esc(old('quote_del', $row->quote_del ?? ($context['quote_del'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_del']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_del-error"
                        aria-invalid="<?= isset($errors['quote_del']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['quote_del'])): ?>
                        <div id="quote_del-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_del']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_data_time" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_data_time')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="quote_data_time"
                        id="quote_data_time"
                        value="<?= esc(old('quote_data_time', isset($row->quote_data_time) ? str_replace(' ', 'T', substr((string) $row->quote_data_time, 0, 16)) : ($context['quote_data_time'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_data_time']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_data_time-error"
                        aria-invalid="<?= isset($errors['quote_data_time']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['quote_data_time'])): ?>
                        <div id="quote_data_time-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_data_time']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('ObmpQuote.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? ($context['utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="utente_id-error"
                        aria-invalid="<?= isset($errors['utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['utente_id'])): ?>
                        <div id="utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['utente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_stato" class="form-label">
                        <?= esc(lang('ObmpQuote.quote_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="quote_stato"
                        id="quote_stato"
                        value="<?= esc(old('quote_stato', $row->quote_stato ?? ($context['quote_stato'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quote_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_stato-error"
                        aria-invalid="<?= isset($errors['quote_stato']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['quote_stato'])): ?>
                        <div id="quote_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_stato']) ?>
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

                    <a href="<?= site_url('obmp_quote') ?>" class="btn btn-secondary">
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
