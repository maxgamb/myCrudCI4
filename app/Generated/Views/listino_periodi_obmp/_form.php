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
                    <label for="listino_nome_id" class="form-label">
                        <?= esc(lang('ListinoPeriodiObmp.listino_nome_id')) ?>
                    </label>
                    <select
                        name="listino_nome_id"
                        id="listino_nome_id"
                        class="form-select <?= isset($errors['listino_nome_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_nome_id-error"
                        aria-invalid="<?= isset($errors['listino_nome_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['listino_nome_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('listino_nome_id', $row->listino_nome_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['listino_nome_id'])): ?>
                        <div id="listino_nome_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_nome_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="listino_periodi_flex" class="form-label">
                        <?= esc(lang('ListinoPeriodiObmp.listino_periodi_flex')) ?>
                    </label>
                    <input
                        type="number"
                        name="listino_periodi_flex"
                        id="listino_periodi_flex"
                        value="<?= esc(old('listino_periodi_flex', $row->listino_periodi_flex ?? '')) ?>"
                        class="form-control <?= isset($errors['listino_periodi_flex']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_periodi_flex-error"
                        aria-invalid="<?= isset($errors['listino_periodi_flex']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['listino_periodi_flex'])): ?>
                        <div id="listino_periodi_flex-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_periodi_flex']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="listino_dal" class="form-label">
                        <?= esc(lang('ListinoPeriodiObmp.listino_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="listino_dal"
                        id="listino_dal"
                        value="<?= esc(old('listino_dal', $row->listino_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['listino_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_dal-error"
                        aria-invalid="<?= isset($errors['listino_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['listino_dal'])): ?>
                        <div id="listino_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="listino_al" class="form-label">
                        <?= esc(lang('ListinoPeriodiObmp.listino_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="listino_al"
                        id="listino_al"
                        value="<?= esc(old('listino_al', $row->listino_al ?? '')) ?>"
                        class="form-control <?= isset($errors['listino_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_al-error"
                        aria-invalid="<?= isset($errors['listino_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['listino_al'])): ?>
                        <div id="listino_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ListinoPeriodiObmp.hotel_id')) ?>
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
                    <label for="listino_periodi" class="form-label">
                        <?= esc(lang('ListinoPeriodiObmp.listino_periodi')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="listino_periodi"
                        id="listino_periodi"
                        value="<?= esc(old('listino_periodi', isset($row->listino_periodi) ? str_replace(' ', 'T', substr((string) $row->listino_periodi, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['listino_periodi']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_periodi-error"
                        aria-invalid="<?= isset($errors['listino_periodi']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['listino_periodi'])): ?>
                        <div id="listino_periodi-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_periodi']) ?>
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

                    <a href="<?= site_url('listino_periodi_obmp') ?>" class="btn btn-secondary">
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
