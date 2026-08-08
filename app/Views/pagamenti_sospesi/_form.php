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
                        <?= esc(lang('PagamentiSospesi.hotel_id')) ?>
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
                    <label for="sospeso_id" class="form-label">
                        <?= esc(lang('PagamentiSospesi.sospeso_id')) ?>
                    </label>
                    <select
                        name="sospeso_id"
                        id="sospeso_id"
                        class="form-select <?= isset($errors['sospeso_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_id-error"
                        aria-invalid="<?= isset($errors['sospeso_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['sospeso_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('sospeso_id', $row->sospeso_id ?? ($context['sospeso_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="sospeso_id"
                            data-base-url="<?= site_url('sospesi/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('sospesi/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['sospeso_id'])): ?>
                        <div id="sospeso_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="paga_sosp_importo" class="form-label">
                        <?= esc(lang('PagamentiSospesi.paga_sosp_importo')) ?>
                    </label>
                    <input
                        type="number"
                        name="paga_sosp_importo"
                        id="paga_sosp_importo"
                        value="<?= esc(old('paga_sosp_importo', $row->paga_sosp_importo ?? ($context['paga_sosp_importo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['paga_sosp_importo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="paga_sosp_importo-error"
                        aria-invalid="<?= isset($errors['paga_sosp_importo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['paga_sosp_importo'])): ?>
                        <div id="paga_sosp_importo-error" class="invalid-feedback d-block">
                            <?= esc($errors['paga_sosp_importo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_pagamento" class="form-label">
                        <?= esc(lang('PagamentiSospesi.data_pagamento')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_pagamento"
                        id="data_pagamento"
                        value="<?= esc(old('data_pagamento', $row->data_pagamento ?? ($context['data_pagamento'] ?? ''))) ?>"
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
                    <label for="paga_modalita" class="form-label">
                        <?= esc(lang('PagamentiSospesi.paga_modalita')) ?>
                    </label>
                    <input
                        type="text"
                        name="paga_modalita"
                        id="paga_modalita"
                        value="<?= esc(old('paga_modalita', $row->paga_modalita ?? ($context['paga_modalita'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['paga_modalita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="paga_modalita-error"
                        aria-invalid="<?= isset($errors['paga_modalita']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['paga_modalita'])): ?>
                        <div id="paga_modalita-error" class="invalid-feedback d-block">
                            <?= esc($errors['paga_modalita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_rec_paga_sosp" class="form-label">
                        <?= esc(lang('PagamentiSospesi.data_rec_paga_sosp')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="data_rec_paga_sosp"
                        id="data_rec_paga_sosp"
                        value="<?= esc(old('data_rec_paga_sosp', isset($row->data_rec_paga_sosp) ? str_replace(' ', 'T', substr((string) $row->data_rec_paga_sosp, 0, 16)) : ($context['data_rec_paga_sosp'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['data_rec_paga_sosp']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_rec_paga_sosp-error"
                        aria-invalid="<?= isset($errors['data_rec_paga_sosp']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['data_rec_paga_sosp'])): ?>
                        <div id="data_rec_paga_sosp-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_rec_paga_sosp']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamenti_sospesi_utente_id" class="form-label">
                        <?= esc(lang('PagamentiSospesi.pagamenti_sospesi_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="pagamenti_sospesi_utente_id"
                        id="pagamenti_sospesi_utente_id"
                        value="<?= esc(old('pagamenti_sospesi_utente_id', $row->pagamenti_sospesi_utente_id ?? ($context['pagamenti_sospesi_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pagamenti_sospesi_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamenti_sospesi_utente_id-error"
                        aria-invalid="<?= isset($errors['pagamenti_sospesi_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pagamenti_sospesi_utente_id'])): ?>
                        <div id="pagamenti_sospesi_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamenti_sospesi_utente_id']) ?>
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

                    <a href="<?= site_url('pagamenti_sospesi') ?>" class="btn btn-secondary">
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
