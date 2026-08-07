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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('TaxPagamento.hotel_id')) ?>
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
                    <label for="conto_id" class="form-label">
                        <?= esc(lang('TaxPagamento.conto_id')) ?>
                    </label>
                    <select
                        name="conto_id"
                        id="conto_id"
                        class="form-select <?= isset($errors['conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conto_id-error"
                        aria-invalid="<?= isset($errors['conto_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['conto_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('conto_id', $row->conto_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['conto_id'])): ?>
                        <div id="conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratica_id" class="form-label">
                        <?= esc(lang('TaxPagamento.pratica_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="pratica_id"
                        id="pratica_id"
                        value="<?= esc(old('pratica_id', $row->pratica_id ?? '')) ?>"
                        class="form-control <?= isset($errors['pratica_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_id-error"
                        aria-invalid="<?= isset($errors['pratica_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pratica_id'])): ?>
                        <div id="pratica_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="importo" class="form-label">
                        <?= esc(lang('TaxPagamento.importo')) ?>
                    </label>
                    <input
                        type="number"
                        name="importo"
                        id="importo"
                        value="<?= esc(old('importo', $row->importo ?? '')) ?>"
                        class="form-control <?= isset($errors['importo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="importo-error"
                        aria-invalid="<?= isset($errors['importo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['importo'])): ?>
                        <div id="importo-error" class="invalid-feedback d-block">
                            <?= esc($errors['importo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamento_forma" class="form-label">
                        <?= esc(lang('TaxPagamento.pagamento_forma')) ?>
                    </label>
                    <input
                        type="text"
                        name="pagamento_forma"
                        id="pagamento_forma"
                        value="<?= esc(old('pagamento_forma', $row->pagamento_forma ?? '')) ?>"
                        class="form-control <?= isset($errors['pagamento_forma']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamento_forma-error"
                        aria-invalid="<?= isset($errors['pagamento_forma']) ? 'true' : 'false' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['pagamento_forma'])): ?>
                        <div id="pagamento_forma-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamento_forma']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tassa_stato" class="form-label">
                        <?= esc(lang('TaxPagamento.tassa_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="tassa_stato"
                        id="tassa_stato"
                        value="<?= esc(old('tassa_stato', $row->tassa_stato ?? '')) ?>"
                        class="form-control <?= isset($errors['tassa_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tassa_stato-error"
                        aria-invalid="<?= isset($errors['tassa_stato']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['tassa_stato'])): ?>
                        <div id="tassa_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['tassa_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_pagamento" class="form-label">
                        <?= esc(lang('TaxPagamento.data_pagamento')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_pagamento"
                        id="data_pagamento"
                        value="<?= esc(old('data_pagamento', $row->data_pagamento ?? '')) ?>"
                        class="form-control <?= isset($errors['data_pagamento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_pagamento-error"
                        aria-invalid="<?= isset($errors['data_pagamento']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['data_pagamento'])): ?>
                        <div id="data_pagamento-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_pagamento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tax_pagamento_utente_id" class="form-label">
                        <?= esc(lang('TaxPagamento.tax_pagamento_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="tax_pagamento_utente_id"
                        id="tax_pagamento_utente_id"
                        value="<?= esc(old('tax_pagamento_utente_id', $row->tax_pagamento_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['tax_pagamento_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tax_pagamento_utente_id-error"
                        aria-invalid="<?= isset($errors['tax_pagamento_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tax_pagamento_utente_id'])): ?>
                        <div id="tax_pagamento_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tax_pagamento_utente_id']) ?>
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

                    <a href="<?= site_url('tax_pagamento') ?>" class="btn btn-secondary">
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
