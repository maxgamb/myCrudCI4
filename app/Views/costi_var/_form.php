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
                    <label for="costi_area_id" class="form-label">
                        <?= esc(lang('CostiVar.costi_area_id')) ?>
                    </label>
                    <select
                        name="costi_area_id"
                        id="costi_area_id"
                        class="form-select <?= isset($errors['costi_area_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_area_id-error"
                        aria-invalid="<?= isset($errors['costi_area_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['costi_area_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('costi_area_id', $row->costi_area_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['costi_area_id'])): ?>
                        <div id="costi_area_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_area_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="costi_var_sub_1" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_sub_1')) ?>
                    </label>
                    <input
                        type="text"
                        name="costi_var_sub_1"
                        id="costi_var_sub_1"
                        value="<?= esc(old('costi_var_sub_1', $row->costi_var_sub_1 ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_sub_1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_sub_1-error"
                        aria-invalid="<?= isset($errors['costi_var_sub_1']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['costi_var_sub_1'])): ?>
                        <div id="costi_var_sub_1-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_sub_1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="costi_var_sub_2" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_sub_2')) ?>
                    </label>
                    <input
                        type="text"
                        name="costi_var_sub_2"
                        id="costi_var_sub_2"
                        value="<?= esc(old('costi_var_sub_2', $row->costi_var_sub_2 ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_sub_2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_sub_2-error"
                        aria-invalid="<?= isset($errors['costi_var_sub_2']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['costi_var_sub_2'])): ?>
                        <div id="costi_var_sub_2-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_sub_2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('CostiVar.hotel_id')) ?>
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
                    <label for="costi_var_codice" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_codice')) ?>
                    </label>
                    <input
                        type="number"
                        name="costi_var_codice"
                        id="costi_var_codice"
                        value="<?= esc(old('costi_var_codice', $row->costi_var_codice ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_codice']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_codice-error"
                        aria-invalid="<?= isset($errors['costi_var_codice']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['costi_var_codice'])): ?>
                        <div id="costi_var_codice-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_codice']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="costi_var_nome" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="costi_var_nome"
                        id="costi_var_nome"
                        value="<?= esc(old('costi_var_nome', $row->costi_var_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_nome-error"
                        aria-invalid="<?= isset($errors['costi_var_nome']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['costi_var_nome'])): ?>
                        <div id="costi_var_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="costi_var_deposito" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_deposito')) ?>
                    </label>
                    <input
                        type="number"
                        name="costi_var_deposito"
                        id="costi_var_deposito"
                        value="<?= esc(old('costi_var_deposito', $row->costi_var_deposito ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_deposito']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_deposito-error"
                        aria-invalid="<?= isset($errors['costi_var_deposito']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['costi_var_deposito'])): ?>
                        <div id="costi_var_deposito-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_deposito']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mag_quantita" class="form-label">
                        <?= esc(lang('CostiVar.mag_quantita')) ?>
                    </label>
                    <input
                        type="number"
                        name="mag_quantita"
                        id="mag_quantita"
                        value="<?= esc(old('mag_quantita', $row->mag_quantita ?? '')) ?>"
                        class="form-control <?= isset($errors['mag_quantita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mag_quantita-error"
                        aria-invalid="<?= isset($errors['mag_quantita']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mag_quantita'])): ?>
                        <div id="mag_quantita-error" class="invalid-feedback d-block">
                            <?= esc($errors['mag_quantita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="costi_var_prezzo_uso" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_prezzo_uso')) ?>
                    </label>
                    <input
                        type="number"
                        name="costi_var_prezzo_uso"
                        id="costi_var_prezzo_uso"
                        value="<?= esc(old('costi_var_prezzo_uso', $row->costi_var_prezzo_uso ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_prezzo_uso']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_prezzo_uso-error"
                        aria-invalid="<?= isset($errors['costi_var_prezzo_uso']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['costi_var_prezzo_uso'])): ?>
                        <div id="costi_var_prezzo_uso-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_prezzo_uso']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mag_prezzo_lavaggio" class="form-label">
                        <?= esc(lang('CostiVar.mag_prezzo_lavaggio')) ?>
                    </label>
                    <input
                        type="number"
                        name="mag_prezzo_lavaggio"
                        id="mag_prezzo_lavaggio"
                        value="<?= esc(old('mag_prezzo_lavaggio', $row->mag_prezzo_lavaggio ?? '')) ?>"
                        class="form-control <?= isset($errors['mag_prezzo_lavaggio']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mag_prezzo_lavaggio-error"
                        aria-invalid="<?= isset($errors['mag_prezzo_lavaggio']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mag_prezzo_lavaggio'])): ?>
                        <div id="mag_prezzo_lavaggio-error" class="invalid-feedback d-block">
                            <?= esc($errors['mag_prezzo_lavaggio']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="costi_var_addebbito" class="form-label">
                        <?= esc(lang('CostiVar.costi_var_addebbito')) ?>
                    </label>
                    <input
                        type="number"
                        name="costi_var_addebbito"
                        id="costi_var_addebbito"
                        value="<?= esc(old('costi_var_addebbito', $row->costi_var_addebbito ?? '')) ?>"
                        class="form-control <?= isset($errors['costi_var_addebbito']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_addebbito-error"
                        aria-invalid="<?= isset($errors['costi_var_addebbito']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['costi_var_addebbito'])): ?>
                        <div id="costi_var_addebbito-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_addebbito']) ?>
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

                    <a href="<?= site_url('costi_var') ?>" class="btn btn-secondary">
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
