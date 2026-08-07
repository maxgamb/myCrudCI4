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
                    <label for="nazione_iso2" class="form-label">
                        <?= esc(lang('NazioniBandiera.nazione_iso2')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazione_iso2"
                        id="nazione_iso2"
                        value="<?= esc(old('nazione_iso2', $row->nazione_iso2 ?? '')) ?>"
                        class="form-control <?= isset($errors['nazione_iso2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazione_iso2-error"
                        aria-invalid="<?= isset($errors['nazione_iso2']) ? 'true' : 'false' ?>"
                        maxlength="4"
                    >
                    <?php if (!empty($errors['nazione_iso2'])): ?>
                        <div id="nazione_iso2-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazione_iso2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Nazioni_Codice" class="form-label">
                        <?= esc(lang('NazioniBandiera.Nazioni_Codice')) ?>
                    </label>
                    <input
                        type="number"
                        name="Nazioni_Codice"
                        id="Nazioni_Codice"
                        value="<?= esc(old('Nazioni_Codice', $row->Nazioni_Codice ?? '')) ?>"
                        class="form-control <?= isset($errors['Nazioni_Codice']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Nazioni_Codice-error"
                        aria-invalid="<?= isset($errors['Nazioni_Codice']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['Nazioni_Codice'])): ?>
                        <div id="Nazioni_Codice-error" class="invalid-feedback d-block">
                            <?= esc($errors['Nazioni_Codice']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="emoji" class="form-label">
                        <?= esc(lang('NazioniBandiera.emoji')) ?>
                    </label>
                    <input
                        type="text"
                        name="emoji"
                        id="emoji"
                        value="<?= esc(old('emoji', $row->emoji ?? '')) ?>"
                        class="form-control <?= isset($errors['emoji']) ? 'is-invalid' : '' ?>"
                        aria-describedby="emoji-error"
                        aria-invalid="<?= isset($errors['emoji']) ? 'true' : 'false' ?>"
                        maxlength="8"
                    >
                    <?php if (!empty($errors['emoji'])): ?>
                        <div id="emoji-error" class="invalid-feedback d-block">
                            <?= esc($errors['emoji']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cod_emoji" class="form-label">
                        <?= esc(lang('NazioniBandiera.cod_emoji')) ?>
                    </label>
                    <input
                        type="text"
                        name="cod_emoji"
                        id="cod_emoji"
                        value="<?= esc(old('cod_emoji', $row->cod_emoji ?? '')) ?>"
                        class="form-control <?= isset($errors['cod_emoji']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cod_emoji-error"
                        aria-invalid="<?= isset($errors['cod_emoji']) ? 'true' : 'false' ?>"
                        maxlength="18"
                    >
                    <?php if (!empty($errors['cod_emoji'])): ?>
                        <div id="cod_emoji-error" class="invalid-feedback d-block">
                            <?= esc($errors['cod_emoji']) ?>
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

                    <a href="<?= site_url('nazioni_bandiera') ?>" class="btn btn-secondary">
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
