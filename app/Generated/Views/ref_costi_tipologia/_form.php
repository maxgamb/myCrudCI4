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
                    <label for="costi_var_id" class="form-label">
                        <?= esc(lang('RefCostiTipologia.costi_var_id')) ?>
                    </label>
                    <select
                        name="costi_var_id"
                        id="costi_var_id"
                        class="form-select <?= isset($errors['costi_var_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="costi_var_id-error"
                        aria-invalid="<?= isset($errors['costi_var_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['costi_var_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('costi_var_id', $row->costi_var_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['costi_var_id'])): ?>
                        <div id="costi_var_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['costi_var_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('RefCostiTipologia.tipologia_id')) ?>
                    </label>
                    <select
                        name="tipologia_id"
                        id="tipologia_id"
                        class="form-select <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_id-error"
                        aria-invalid="<?= isset($errors['tipologia_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['tipologia_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('tipologia_id', $row->tipologia_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('RefCostiTipologia.hotel_id')) ?>
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
                    <label for="stay" class="form-label">
                        <?= esc(lang('RefCostiTipologia.stay')) ?>
                    </label>
                    <input
                        type="number"
                        name="stay"
                        id="stay"
                        value="<?= esc(old('stay', $row->stay ?? '')) ?>"
                        class="form-control <?= isset($errors['stay']) ? 'is-invalid' : '' ?>"
                        aria-describedby="stay-error"
                        aria-invalid="<?= isset($errors['stay']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['stay'])): ?>
                        <div id="stay-error" class="invalid-feedback d-block">
                            <?= esc($errors['stay']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="days" class="form-label">
                        <?= esc(lang('RefCostiTipologia.days')) ?>
                    </label>
                    <input
                        type="number"
                        name="days"
                        id="days"
                        value="<?= esc(old('days', $row->days ?? '')) ?>"
                        class="form-control <?= isset($errors['days']) ? 'is-invalid' : '' ?>"
                        aria-describedby="days-error"
                        aria-invalid="<?= isset($errors['days']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['days'])): ?>
                        <div id="days-error" class="invalid-feedback d-block">
                            <?= esc($errors['days']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="check_out" class="form-label">
                        <?= esc(lang('RefCostiTipologia.check_out')) ?>
                    </label>
                    <input
                        type="number"
                        name="check_out"
                        id="check_out"
                        value="<?= esc(old('check_out', $row->check_out ?? '')) ?>"
                        class="form-control <?= isset($errors['check_out']) ? 'is-invalid' : '' ?>"
                        aria-describedby="check_out-error"
                        aria-invalid="<?= isset($errors['check_out']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['check_out'])): ?>
                        <div id="check_out-error" class="invalid-feedback d-block">
                            <?= esc($errors['check_out']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('RefCostiTipologia.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? '')) ?>"
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
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <span class="submit-normal"><i class="bi bi-check-circle"></i> Salva</span>
                        <span class="submit-loading d-none">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            Salvataggio...
                        </span>
                    </button>

                    <a href="<?= site_url('ref_costi_tipologia') ?>" class="btn btn-secondary">
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
