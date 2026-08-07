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
                    <label for="log_ric_hotel_id" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="log_ric_hotel_id"
                        id="log_ric_hotel_id"
                        value="<?= esc(old('log_ric_hotel_id', $row->log_ric_hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_hotel_id-error"
                        aria-invalid="<?= isset($errors['log_ric_hotel_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_hotel_id'])): ?>
                        <div id="log_ric_hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ric_dal" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="log_ric_dal"
                        id="log_ric_dal"
                        value="<?= esc(old('log_ric_dal', $row->log_ric_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_dal-error"
                        aria-invalid="<?= isset($errors['log_ric_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_dal'])): ?>
                        <div id="log_ric_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ric_al" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="log_ric_al"
                        id="log_ric_al"
                        value="<?= esc(old('log_ric_al', $row->log_ric_al ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_al-error"
                        aria-invalid="<?= isset($errors['log_ric_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_al'])): ?>
                        <div id="log_ric_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ric_data" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_data')) ?>
                    </label>
                    <input
                        type="date"
                        name="log_ric_data"
                        id="log_ric_data"
                        value="<?= esc(old('log_ric_data', $row->log_ric_data ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_data-error"
                        aria-invalid="<?= isset($errors['log_ric_data']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_data'])): ?>
                        <div id="log_ric_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ric_notti" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_notti')) ?>
                    </label>
                    <input
                        type="number"
                        name="log_ric_notti"
                        id="log_ric_notti"
                        value="<?= esc(old('log_ric_notti', $row->log_ric_notti ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_notti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_notti-error"
                        aria-invalid="<?= isset($errors['log_ric_notti']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_notti'])): ?>
                        <div id="log_ric_notti-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_notti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ric_wind" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_wind')) ?>
                    </label>
                    <input
                        type="number"
                        name="log_ric_wind"
                        id="log_ric_wind"
                        value="<?= esc(old('log_ric_wind', $row->log_ric_wind ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_wind']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_wind-error"
                        aria-invalid="<?= isset($errors['log_ric_wind']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_wind'])): ?>
                        <div id="log_ric_wind-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_wind']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ric_utente_id" class="form-label">
                        <?= esc(lang('LogRichieste.log_ric_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="log_ric_utente_id"
                        id="log_ric_utente_id"
                        value="<?= esc(old('log_ric_utente_id', $row->log_ric_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ric_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ric_utente_id-error"
                        aria-invalid="<?= isset($errors['log_ric_utente_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['log_ric_utente_id'])): ?>
                        <div id="log_ric_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ric_utente_id']) ?>
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

                    <a href="<?= site_url('log_richieste') ?>" class="btn btn-secondary">
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
