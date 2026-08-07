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
                        <?= esc(lang('Cassa.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
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
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('Cassa.preno_id')) ?>
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
                                <?= (string) old('preno_id', $row->preno_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_id'])): ?>
                        <div id="preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="out_conto" class="form-label">
                        <?= esc(lang('Cassa.out_conto')) ?>
                    </label>
                    <input
                        type="date"
                        name="out_conto"
                        id="out_conto"
                        value="<?= esc(old('out_conto', $row->out_conto ?? '')) ?>"
                        class="form-control <?= isset($errors['out_conto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="out_conto-error"
                        aria-invalid="<?= isset($errors['out_conto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['out_conto'])): ?>
                        <div id="out_conto-error" class="invalid-feedback d-block">
                            <?= esc($errors['out_conto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="conto_id" class="form-label">
                        <?= esc(lang('Cassa.conto_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="conto_id"
                        id="conto_id"
                        value="<?= esc(old('conto_id', $row->conto_id ?? '')) ?>"
                        class="form-control <?= isset($errors['conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conto_id-error"
                        aria-invalid="<?= isset($errors['conto_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['conto_id'])): ?>
                        <div id="conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="totale_importo" class="form-label">
                        <?= esc(lang('Cassa.totale_importo')) ?>
                    </label>
                    <input
                        type="number"
                        name="totale_importo"
                        id="totale_importo"
                        value="<?= esc(old('totale_importo', $row->totale_importo ?? '')) ?>"
                        class="form-control <?= isset($errors['totale_importo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="totale_importo-error"
                        aria-invalid="<?= isset($errors['totale_importo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['totale_importo'])): ?>
                        <div id="totale_importo-error" class="invalid-feedback d-block">
                            <?= esc($errors['totale_importo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="totale_modificato" class="form-label">
                        <?= esc(lang('Cassa.totale_modificato')) ?>
                    </label>
                    <input
                        type="number"
                        name="totale_modificato"
                        id="totale_modificato"
                        value="<?= esc(old('totale_modificato', $row->totale_modificato ?? '')) ?>"
                        class="form-control <?= isset($errors['totale_modificato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="totale_modificato-error"
                        aria-invalid="<?= isset($errors['totale_modificato']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['totale_modificato'])): ?>
                        <div id="totale_modificato-error" class="invalid-feedback d-block">
                            <?= esc($errors['totale_modificato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamento_importo_pag" class="form-label">
                        <?= esc(lang('Cassa.pagamento_importo_pag')) ?>
                    </label>
                    <input
                        type="number"
                        name="pagamento_importo_pag"
                        id="pagamento_importo_pag"
                        value="<?= esc(old('pagamento_importo_pag', $row->pagamento_importo_pag ?? '')) ?>"
                        class="form-control <?= isset($errors['pagamento_importo_pag']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamento_importo_pag-error"
                        aria-invalid="<?= isset($errors['pagamento_importo_pag']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pagamento_importo_pag'])): ?>
                        <div id="pagamento_importo_pag-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamento_importo_pag']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamento_forma" class="form-label">
                        <?= esc(lang('Cassa.pagamento_forma')) ?>
                    </label>
                    <input
                        type="text"
                        name="pagamento_forma"
                        id="pagamento_forma"
                        value="<?= esc(old('pagamento_forma', $row->pagamento_forma ?? '')) ?>"
                        class="form-control <?= isset($errors['pagamento_forma']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamento_forma-error"
                        aria-invalid="<?= isset($errors['pagamento_forma']) ? 'true' : 'false' ?>"
                        maxlength="3"
                    >
                    <?php if (!empty($errors['pagamento_forma'])): ?>
                        <div id="pagamento_forma-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamento_forma']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cassa_stato_camera" class="form-label">
                        <?= esc(lang('Cassa.cassa_stato_camera')) ?>
                    </label>
                    <input
                        type="text"
                        name="cassa_stato_camera"
                        id="cassa_stato_camera"
                        value="<?= esc(old('cassa_stato_camera', $row->cassa_stato_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['cassa_stato_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cassa_stato_camera-error"
                        aria-invalid="<?= isset($errors['cassa_stato_camera']) ? 'true' : 'false' ?>"
                        maxlength="3"
                    >
                    <?php if (!empty($errors['cassa_stato_camera'])): ?>
                        <div id="cassa_stato_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['cassa_stato_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso" class="form-label">
                        <?= esc(lang('Cassa.sospeso')) ?>
                    </label>
                    <input
                        type="text"
                        name="sospeso"
                        id="sospeso"
                        value="<?= esc(old('sospeso', $row->sospeso ?? '')) ?>"
                        class="form-control <?= isset($errors['sospeso']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso-error"
                        aria-invalid="<?= isset($errors['sospeso']) ? 'true' : 'false' ?>"
                        maxlength="2"
                    >
                    <?php if (!empty($errors['sospeso'])): ?>
                        <div id="sospeso-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="fattura_numero" class="form-label">
                        <?= esc(lang('Cassa.fattura_numero')) ?>
                    </label>
                    <input
                        type="number"
                        name="fattura_numero"
                        id="fattura_numero"
                        value="<?= esc(old('fattura_numero', $row->fattura_numero ?? '')) ?>"
                        class="form-control <?= isset($errors['fattura_numero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="fattura_numero-error"
                        aria-invalid="<?= isset($errors['fattura_numero']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['fattura_numero'])): ?>
                        <div id="fattura_numero-error" class="invalid-feedback d-block">
                            <?= esc($errors['fattura_numero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_pagante" class="form-label">
                        <?= esc(lang('Cassa.nome_pagante')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_pagante"
                        id="nome_pagante"
                        value="<?= esc(old('nome_pagante', $row->nome_pagante ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_pagante']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_pagante-error"
                        aria-invalid="<?= isset($errors['nome_pagante']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nome_pagante'])): ?>
                        <div id="nome_pagante-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_pagante']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cassa_utente_id" class="form-label">
                        <?= esc(lang('Cassa.cassa_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="cassa_utente_id"
                        id="cassa_utente_id"
                        value="<?= esc(old('cassa_utente_id', $row->cassa_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['cassa_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cassa_utente_id-error"
                        aria-invalid="<?= isset($errors['cassa_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['cassa_utente_id'])): ?>
                        <div id="cassa_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['cassa_utente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="divisa" class="form-label">
                        <?= esc(lang('Cassa.divisa')) ?>
                    </label>
                    <input
                        type="text"
                        name="divisa"
                        id="divisa"
                        value="<?= esc(old('divisa', $row->divisa ?? '')) ?>"
                        class="form-control <?= isset($errors['divisa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="divisa-error"
                        aria-invalid="<?= isset($errors['divisa']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['divisa'])): ?>
                        <div id="divisa-error" class="invalid-feedback d-block">
                            <?= esc($errors['divisa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nexi_cod_aut" class="form-label">
                        <?= esc(lang('Cassa.nexi_cod_aut')) ?>
                    </label>
                    <input
                        type="text"
                        name="nexi_cod_aut"
                        id="nexi_cod_aut"
                        value="<?= esc(old('nexi_cod_aut', $row->nexi_cod_aut ?? '')) ?>"
                        class="form-control <?= isset($errors['nexi_cod_aut']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nexi_cod_aut-error"
                        aria-invalid="<?= isset($errors['nexi_cod_aut']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['nexi_cod_aut'])): ?>
                        <div id="nexi_cod_aut-error" class="invalid-feedback d-block">
                            <?= esc($errors['nexi_cod_aut']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nexi_codTrans" class="form-label">
                        <?= esc(lang('Cassa.nexi_codTrans')) ?>
                    </label>
                    <input
                        type="text"
                        name="nexi_codTrans"
                        id="nexi_codTrans"
                        value="<?= esc(old('nexi_codTrans', $row->nexi_codTrans ?? '')) ?>"
                        class="form-control <?= isset($errors['nexi_codTrans']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nexi_codTrans-error"
                        aria-invalid="<?= isset($errors['nexi_codTrans']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nexi_codTrans'])): ?>
                        <div id="nexi_codTrans-error" class="invalid-feedback d-block">
                            <?= esc($errors['nexi_codTrans']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nexi_pan" class="form-label">
                        <?= esc(lang('Cassa.nexi_pan')) ?>
                    </label>
                    <input
                        type="text"
                        name="nexi_pan"
                        id="nexi_pan"
                        value="<?= esc(old('nexi_pan', $row->nexi_pan ?? '')) ?>"
                        class="form-control <?= isset($errors['nexi_pan']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nexi_pan-error"
                        aria-invalid="<?= isset($errors['nexi_pan']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nexi_pan'])): ?>
                        <div id="nexi_pan-error" class="invalid-feedback d-block">
                            <?= esc($errors['nexi_pan']) ?>
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

                    <a href="<?= site_url('cassa') ?>" class="btn btn-secondary">
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
