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
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('RefAgendaClienti.preno_id')) ?>
                    </label>
                    <select
                        name="preno_id"
                        id="preno_id"
                        class="form-select <?= isset($errors['preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_id-error"
                        aria-invalid="<?= isset($errors['preno_id']) ? 'true' : 'false' ?>"
                        required
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
                    <label for="clienti_id" class="form-label">
                        <?= esc(lang('RefAgendaClienti.clienti_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="clienti_id"
                        id="clienti_id"
                        value="<?= esc(old('clienti_id', $row->clienti_id ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_id-error"
                        aria-invalid="<?= isset($errors['clienti_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['clienti_id'])): ?>
                        <div id="clienti_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('RefAgendaClienti.tipologia_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="tipologia_id"
                        id="tipologia_id"
                        value="<?= esc(old('tipologia_id', $row->tipologia_id ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_id-error"
                        aria-invalid="<?= isset($errors['tipologia_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_a_c_datarecord" class="form-label">
                        <?= esc(lang('RefAgendaClienti.ref_a_c_datarecord')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="ref_a_c_datarecord"
                        id="ref_a_c_datarecord"
                        value="<?= esc(old('ref_a_c_datarecord', isset($row->ref_a_c_datarecord) ? str_replace(' ', 'T', substr((string) $row->ref_a_c_datarecord, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['ref_a_c_datarecord']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_a_c_datarecord-error"
                        aria-invalid="<?= isset($errors['ref_a_c_datarecord']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_a_c_datarecord'])): ?>
                        <div id="ref_a_c_datarecord-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_a_c_datarecord']) ?>
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

                    <a href="<?= site_url('ref_agenda_clienti') ?>" class="btn btn-secondary">
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
