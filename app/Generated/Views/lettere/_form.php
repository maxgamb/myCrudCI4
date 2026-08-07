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
                    <label for="etichetta" class="form-label">
                        <?= esc(lang('Lettere.etichetta')) ?>
                    </label>
                    <input
                        type="text"
                        name="etichetta"
                        id="etichetta"
                        value="<?= esc(old('etichetta', $row->etichetta ?? '')) ?>"
                        class="form-control <?= isset($errors['etichetta']) ? 'is-invalid' : '' ?>"
                        aria-describedby="etichetta-error"
                        aria-invalid="<?= isset($errors['etichetta']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['etichetta'])): ?>
                        <div id="etichetta-error" class="invalid-feedback d-block">
                            <?= esc($errors['etichetta']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Lettere.hotel_id')) ?>
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
                    <label for="titolo" class="form-label">
                        <?= esc(lang('Lettere.titolo')) ?>
                    </label>
                    <input
                        type="text"
                        name="titolo"
                        id="titolo"
                        value="<?= esc(old('titolo', $row->titolo ?? '')) ?>"
                        class="form-control <?= isset($errors['titolo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="titolo-error"
                        aria-invalid="<?= isset($errors['titolo']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['titolo'])): ?>
                        <div id="titolo-error" class="invalid-feedback d-block">
                            <?= esc($errors['titolo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="reparto" class="form-label">
                        <?= esc(lang('Lettere.reparto')) ?>
                    </label>
                    <input
                        type="text"
                        name="reparto"
                        id="reparto"
                        value="<?= esc(old('reparto', $row->reparto ?? '')) ?>"
                        class="form-control <?= isset($errors['reparto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reparto-error"
                        aria-invalid="<?= isset($errors['reparto']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['reparto'])): ?>
                        <div id="reparto-error" class="invalid-feedback d-block">
                            <?= esc($errors['reparto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="contoller" class="form-label">
                        <?= esc(lang('Lettere.contoller')) ?>
                    </label>
                    <input
                        type="text"
                        name="contoller"
                        id="contoller"
                        value="<?= esc(old('contoller', $row->contoller ?? '')) ?>"
                        class="form-control <?= isset($errors['contoller']) ? 'is-invalid' : '' ?>"
                        aria-describedby="contoller-error"
                        aria-invalid="<?= isset($errors['contoller']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['contoller'])): ?>
                        <div id="contoller-error" class="invalid-feedback d-block">
                            <?= esc($errors['contoller']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="en" class="form-label">
                        <?= esc(lang('Lettere.en')) ?>
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
                        <?= esc(lang('Lettere.it')) ?>
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
                        <?= esc(lang('Lettere.es')) ?>
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
                        <?= esc(lang('Lettere.fr')) ?>
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
                        <?= esc(lang('Lettere.de')) ?>
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
                    <label for="data_stamp" class="form-label">
                        <?= esc(lang('Lettere.data_stamp')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="data_stamp"
                        id="data_stamp"
                        value="<?= esc(old('data_stamp', isset($row->data_stamp) ? str_replace(' ', 'T', substr((string) $row->data_stamp, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['data_stamp']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_stamp-error"
                        aria-invalid="<?= isset($errors['data_stamp']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['data_stamp'])): ?>
                        <div id="data_stamp-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_stamp']) ?>
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

                    <a href="<?= site_url('lettere') ?>" class="btn btn-secondary">
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
