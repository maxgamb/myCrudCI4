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
                    <label for="id" class="form-label">
                        <?= esc(lang('ParsedEmails.id')) ?>
                    </label>
                    <input
                        type="number"
                        name="id"
                        id="id"
                        value="<?= esc(old('id', $row->id ?? '')) ?>"
                        class="form-control <?= isset($errors['id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="id-error"
                        aria-invalid="<?= isset($errors['id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['id'])): ?>
                        <div id="id-error" class="invalid-feedback d-block">
                            <?= esc($errors['id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ParsedEmails.hotel_id')) ?>
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
                    <label for="category" class="form-label">
                        <?= esc(lang('ParsedEmails.category')) ?>
                    </label>
                    <input
                        type="text"
                        name="category"
                        id="category"
                        value="<?= esc(old('category', $row->category ?? '')) ?>"
                        class="form-control <?= isset($errors['category']) ? 'is-invalid' : '' ?>"
                        aria-describedby="category-error"
                        aria-invalid="<?= isset($errors['category']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['category'])): ?>
                        <div id="category-error" class="invalid-feedback d-block">
                            <?= esc($errors['category']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="referente_tipo" class="form-label">
                        <?= esc(lang('ParsedEmails.referente_tipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="referente_tipo"
                        id="referente_tipo"
                        value="<?= esc(old('referente_tipo', $row->referente_tipo ?? '')) ?>"
                        class="form-control <?= isset($errors['referente_tipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="referente_tipo-error"
                        aria-invalid="<?= isset($errors['referente_tipo']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['referente_tipo'])): ?>
                        <div id="referente_tipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['referente_tipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prenotazione_tipo" class="form-label">
                        <?= esc(lang('ParsedEmails.prenotazione_tipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="prenotazione_tipo"
                        id="prenotazione_tipo"
                        value="<?= esc(old('prenotazione_tipo', $row->prenotazione_tipo ?? '')) ?>"
                        class="form-control <?= isset($errors['prenotazione_tipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prenotazione_tipo-error"
                        aria-invalid="<?= isset($errors['prenotazione_tipo']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['prenotazione_tipo'])): ?>
                        <div id="prenotazione_tipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['prenotazione_tipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="finalita" class="form-label">
                        <?= esc(lang('ParsedEmails.finalita')) ?>
                    </label>
                    <input
                        type="text"
                        name="finalita"
                        id="finalita"
                        value="<?= esc(old('finalita', $row->finalita ?? '')) ?>"
                        class="form-control <?= isset($errors['finalita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="finalita-error"
                        aria-invalid="<?= isset($errors['finalita']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['finalita'])): ?>
                        <div id="finalita-error" class="invalid-feedback d-block">
                            <?= esc($errors['finalita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="segmento_commerciale" class="form-label">
                        <?= esc(lang('ParsedEmails.segmento_commerciale')) ?>
                    </label>
                    <input
                        type="text"
                        name="segmento_commerciale"
                        id="segmento_commerciale"
                        value="<?= esc(old('segmento_commerciale', $row->segmento_commerciale ?? '')) ?>"
                        class="form-control <?= isset($errors['segmento_commerciale']) ? 'is-invalid' : '' ?>"
                        aria-describedby="segmento_commerciale-error"
                        aria-invalid="<?= isset($errors['segmento_commerciale']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['segmento_commerciale'])): ?>
                        <div id="segmento_commerciale-error" class="invalid-feedback d-block">
                            <?= esc($errors['segmento_commerciale']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="raw_email" class="form-label">
                        <?= esc(lang('ParsedEmails.raw_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="raw_email"
                        id="raw_email"
                        value="<?= esc(old('raw_email', $row->raw_email ?? '')) ?>"
                        class="form-control <?= isset($errors['raw_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="raw_email-error"
                        aria-invalid="<?= isset($errors['raw_email']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['raw_email'])): ?>
                        <div id="raw_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['raw_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="json_parsed" class="form-label">
                        <?= esc(lang('ParsedEmails.json_parsed')) ?>
                    </label>
                    <input
                        type="text"
                        name="json_parsed"
                        id="json_parsed"
                        value="<?= esc(old('json_parsed', $row->json_parsed ?? '')) ?>"
                        class="form-control <?= isset($errors['json_parsed']) ? 'is-invalid' : '' ?>"
                        aria-describedby="json_parsed-error"
                        aria-invalid="<?= isset($errors['json_parsed']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['json_parsed'])): ?>
                        <div id="json_parsed-error" class="invalid-feedback d-block">
                            <?= esc($errors['json_parsed']) ?>
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

                    <a href="<?= site_url('parsed_emails') ?>" class="btn btn-secondary">
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
