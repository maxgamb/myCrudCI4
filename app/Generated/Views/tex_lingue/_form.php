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
                    <label for="etichetta_lg" class="form-label">
                        <?= esc(lang('TexLingue.etichetta_lg')) ?>
                    </label>
                    <input
                        type="text"
                        name="etichetta_lg"
                        id="etichetta_lg"
                        value="<?= esc(old('etichetta_lg', $row->etichetta_lg ?? '')) ?>"
                        class="form-control <?= isset($errors['etichetta_lg']) ? 'is-invalid' : '' ?>"
                        aria-describedby="etichetta_lg-error"
                        aria-invalid="<?= isset($errors['etichetta_lg']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['etichetta_lg'])): ?>
                        <div id="etichetta_lg-error" class="invalid-feedback d-block">
                            <?= esc($errors['etichetta_lg']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="en" class="form-label">
                        <?= esc(lang('TexLingue.en')) ?>
                    </label>
                    <input
                        type="text"
                        name="en"
                        id="en"
                        value="<?= esc(old('en', $row->en ?? '')) ?>"
                        class="form-control <?= isset($errors['en']) ? 'is-invalid' : '' ?>"
                        aria-describedby="en-error"
                        aria-invalid="<?= isset($errors['en']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['en'])): ?>
                        <div id="en-error" class="invalid-feedback d-block">
                            <?= esc($errors['en']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="it" class="form-label">
                        <?= esc(lang('TexLingue.it')) ?>
                    </label>
                    <input
                        type="text"
                        name="it"
                        id="it"
                        value="<?= esc(old('it', $row->it ?? '')) ?>"
                        class="form-control <?= isset($errors['it']) ? 'is-invalid' : '' ?>"
                        aria-describedby="it-error"
                        aria-invalid="<?= isset($errors['it']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['it'])): ?>
                        <div id="it-error" class="invalid-feedback d-block">
                            <?= esc($errors['it']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="es" class="form-label">
                        <?= esc(lang('TexLingue.es')) ?>
                    </label>
                    <input
                        type="text"
                        name="es"
                        id="es"
                        value="<?= esc(old('es', $row->es ?? '')) ?>"
                        class="form-control <?= isset($errors['es']) ? 'is-invalid' : '' ?>"
                        aria-describedby="es-error"
                        aria-invalid="<?= isset($errors['es']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['es'])): ?>
                        <div id="es-error" class="invalid-feedback d-block">
                            <?= esc($errors['es']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="fr" class="form-label">
                        <?= esc(lang('TexLingue.fr')) ?>
                    </label>
                    <input
                        type="text"
                        name="fr"
                        id="fr"
                        value="<?= esc(old('fr', $row->fr ?? '')) ?>"
                        class="form-control <?= isset($errors['fr']) ? 'is-invalid' : '' ?>"
                        aria-describedby="fr-error"
                        aria-invalid="<?= isset($errors['fr']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['fr'])): ?>
                        <div id="fr-error" class="invalid-feedback d-block">
                            <?= esc($errors['fr']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="de" class="form-label">
                        <?= esc(lang('TexLingue.de')) ?>
                    </label>
                    <input
                        type="text"
                        name="de"
                        id="de"
                        value="<?= esc(old('de', $row->de ?? '')) ?>"
                        class="form-control <?= isset($errors['de']) ? 'is-invalid' : '' ?>"
                        aria-describedby="de-error"
                        aria-invalid="<?= isset($errors['de']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['de'])): ?>
                        <div id="de-error" class="invalid-feedback d-block">
                            <?= esc($errors['de']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="reparto_id" class="form-label">
                        <?= esc(lang('TexLingue.reparto_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="reparto_id"
                        id="reparto_id"
                        value="<?= esc(old('reparto_id', $row->reparto_id ?? '')) ?>"
                        class="form-control <?= isset($errors['reparto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reparto_id-error"
                        aria-invalid="<?= isset($errors['reparto_id']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['reparto_id'])): ?>
                        <div id="reparto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['reparto_id']) ?>
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

                    <a href="<?= site_url('tex_lingue') ?>" class="btn btn-secondary">
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
