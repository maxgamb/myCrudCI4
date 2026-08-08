<?php
$formTitle = $formTitle ?? 'Gestione record';
$formIcon = $formIcon ?? 'bi-pencil-square';
$formAction = $formAction ?? current_url();
$row = $row ?? null;
$errors = $errors ?? [];
$options = $options ?? [];
$context = $context ?? [];
$contextLabels = $contextLabels ?? [];
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
                        <?= esc(lang('Manutenzioni.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
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
                    <label for="manut_priorita" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_priorita')) ?>
                    </label>
                    <input
                        type="text"
                        name="manut_priorita"
                        id="manut_priorita"
                        value="<?= esc(old('manut_priorita', $row->manut_priorita ?? ($context['manut_priorita'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_priorita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_priorita-error"
                        aria-invalid="<?= isset($errors['manut_priorita']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['manut_priorita'])): ?>
                        <div id="manut_priorita-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_priorita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="manut_area_guasto" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_area_guasto')) ?>
                    </label>
                    <input
                        type="text"
                        name="manut_area_guasto"
                        id="manut_area_guasto"
                        value="<?= esc(old('manut_area_guasto', $row->manut_area_guasto ?? ($context['manut_area_guasto'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_area_guasto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_area_guasto-error"
                        aria-invalid="<?= isset($errors['manut_area_guasto']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['manut_area_guasto'])): ?>
                        <div id="manut_area_guasto-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_area_guasto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="manut_piano" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_piano')) ?>
                    </label>
                    <input
                        type="text"
                        name="manut_piano"
                        id="manut_piano"
                        value="<?= esc(old('manut_piano', $row->manut_piano ?? ($context['manut_piano'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_piano']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_piano-error"
                        aria-invalid="<?= isset($errors['manut_piano']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['manut_piano'])): ?>
                        <div id="manut_piano-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_piano']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="manut_camera" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_camera')) ?>
                    </label>
                    <input
                        type="text"
                        name="manut_camera"
                        id="manut_camera"
                        value="<?= esc(old('manut_camera', $row->manut_camera ?? ($context['manut_camera'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_camera-error"
                        aria-invalid="<?= isset($errors['manut_camera']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['manut_camera'])): ?>
                        <div id="manut_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="manut_descrizione" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_descrizione')) ?>
                    </label>
                    <input
                        type="text"
                        name="manut_descrizione"
                        id="manut_descrizione"
                        value="<?= esc(old('manut_descrizione', $row->manut_descrizione ?? ($context['manut_descrizione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_descrizione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_descrizione-error"
                        aria-invalid="<?= isset($errors['manut_descrizione']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['manut_descrizione'])): ?>
                        <div id="manut_descrizione-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_descrizione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="manut_data_segnalazione" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_data_segnalazione')) ?>
                    </label>
                    <input
                        type="date"
                        name="manut_data_segnalazione"
                        id="manut_data_segnalazione"
                        value="<?= esc(old('manut_data_segnalazione', $row->manut_data_segnalazione ?? ($context['manut_data_segnalazione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_data_segnalazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_data_segnalazione-error"
                        aria-invalid="<?= isset($errors['manut_data_segnalazione']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['manut_data_segnalazione'])): ?>
                        <div id="manut_data_segnalazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_data_segnalazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="manut_stato" class="form-label">
                        <?= esc(lang('Manutenzioni.manut_stato')) ?>
                    </label>
                    <input
                        type="text"
                        name="manut_stato"
                        id="manut_stato"
                        value="<?= esc(old('manut_stato', $row->manut_stato ?? ($context['manut_stato'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['manut_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="manut_stato-error"
                        aria-invalid="<?= isset($errors['manut_stato']) ? 'true' : 'false' ?>"
                        maxlength="2"
                    >
                    <?php if (!empty($errors['manut_stato'])): ?>
                        <div id="manut_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['manut_stato']) ?>
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

                    <a href="<?= site_url('manutenzioni') ?>" class="btn btn-secondary">
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
            valueTarget.dispatchEvent(new Event('change', {bubbles: true}));
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
            valueTarget.dispatchEvent(new Event('change', {bubbles: true}));
            input.value = selected.textContent || '';
            results.classList.add('d-none');
        });

        results.addEventListener('dblclick', function () {
            results.dispatchEvent(new Event('change'));
        });
    });

    // Mantiene il link al record padre sincronizzato con il valore FK,
    // qualunque sia il controllo usato (hidden, select, input o select AJAX).
    const refreshParentLink = function (link) {
        const source = document.getElementById(link.dataset.valueSource || '');
        if (!source) return;
        const value = String(source.value || '').trim();
        const baseUrl = String(link.dataset.baseUrl || '').replace(/\/$/, '');
        if (value === '' || baseUrl === '') {
            link.href = '#';
            link.classList.add('disabled');
            link.setAttribute('aria-disabled', 'true');
            return;
        }
        link.href = baseUrl + '/' + encodeURIComponent(value);
        link.classList.remove('disabled');
        link.removeAttribute('aria-disabled');
    };

    document.querySelectorAll('.js-relation-parent-link').forEach(function (link) {
        const source = document.getElementById(link.dataset.valueSource || '');
        refreshParentLink(link);
        source?.addEventListener('change', function () { refreshParentLink(link); });
        source?.addEventListener('input', function () { refreshParentLink(link); });
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
