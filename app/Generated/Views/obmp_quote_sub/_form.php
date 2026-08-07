<?php
$formTitle = $formTitle ?? 'Gestione record';
$formIcon = $formIcon ?? 'bi-pencil-square';
$formAction = $formAction ?? current_url();
$row = $row ?? null;
$errors = $errors ?? [];
$options = $options ?? [];
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
                    <label for="obmp_quote_id" class="form-label">
                        <?= esc(lang('ObmpQuoteSub.obmp_quote_id')) ?>
                    </label>
                    <select
                        name="obmp_quote_id"
                        id="obmp_quote_id"
                        class="form-select <?= isset($errors['obmp_quote_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_quote_id-error"
                        aria-invalid="<?= isset($errors['obmp_quote_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_quote_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_quote_id', $row->obmp_quote_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_quote_id'])): ?>
                        <div id="obmp_quote_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_quote_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpQuoteSub.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_id-error"
                        aria-invalid="<?= isset($errors['hotel_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_sub_jeson" class="form-label">
                        <?= esc(lang('ObmpQuoteSub.quote_sub_jeson')) ?>
                    </label>
                    <input
                        type="text"
                        name="quote_sub_jeson"
                        id="quote_sub_jeson"
                        value="<?= esc(old('quote_sub_jeson', $row->quote_sub_jeson ?? '')) ?>"
                        class="form-control <?= isset($errors['quote_sub_jeson']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_sub_jeson-error"
                        aria-invalid="<?= isset($errors['quote_sub_jeson']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['quote_sub_jeson'])): ?>
                        <div id="quote_sub_jeson-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_sub_jeson']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quote_sub_data" class="form-label">
                        <?= esc(lang('ObmpQuoteSub.quote_sub_data')) ?>
                    </label>
                    <input
                        type="date"
                        name="quote_sub_data"
                        id="quote_sub_data"
                        value="<?= esc(old('quote_sub_data', $row->quote_sub_data ?? '')) ?>"
                        class="form-control <?= isset($errors['quote_sub_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quote_sub_data-error"
                        aria-invalid="<?= isset($errors['quote_sub_data']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['quote_sub_data'])): ?>
                        <div id="quote_sub_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['quote_sub_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="randomd_string" class="form-label">
                        <?= esc(lang('ObmpQuoteSub.randomd_string')) ?>
                    </label>
                    <input
                        type="text"
                        name="randomd_string"
                        id="randomd_string"
                        value="<?= esc(old('randomd_string', $row->randomd_string ?? '')) ?>"
                        class="form-control <?= isset($errors['randomd_string']) ? 'is-invalid' : '' ?>"
                        aria-describedby="randomd_string-error"
                        aria-invalid="<?= isset($errors['randomd_string']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['randomd_string'])): ?>
                        <div id="randomd_string-error" class="invalid-feedback d-block">
                            <?= esc($errors['randomd_string']) ?>
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

                    <a href="<?= site_url('obmp_quote_sub') ?>" class="btn btn-secondary">
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
            input.value = selected.textContent || '';
            results.classList.add('d-none');
        });

        results.addEventListener('dblclick', function () {
            results.dispatchEvent(new Event('change'));
        });
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
