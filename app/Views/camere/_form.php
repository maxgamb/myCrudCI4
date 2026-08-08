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
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('Camere.camera_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="camera_id"
                        id="camera_id"
                        value="<?= esc(old('camera_id', $row->camera_id ?? ($context['camera_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_id-error"
                        aria-invalid="<?= isset($errors['camera_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['camera_id'])): ?>
                        <div id="camera_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Camere.hotel_id')) ?>
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
                    <label for="numero_camera" class="form-label">
                        <?= esc(lang('Camere.numero_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="numero_camera"
                        id="numero_camera"
                        value="<?= esc(old('numero_camera', $row->numero_camera ?? ($context['numero_camera'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['numero_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="numero_camera-error"
                        aria-invalid="<?= isset($errors['numero_camera']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['numero_camera'])): ?>
                        <div id="numero_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['numero_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_camera" class="form-label">
                        <?= esc(lang('Camere.tipologia_camera')) ?>
                    </label>
                    <input
                        type="text"
                        name="tipologia_camera"
                        id="tipologia_camera"
                        value="<?= esc(old('tipologia_camera', $row->tipologia_camera ?? ($context['tipologia_camera'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tipologia_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_camera-error"
                        aria-invalid="<?= isset($errors['tipologia_camera']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['tipologia_camera'])): ?>
                        <div id="tipologia_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('Camere.tipologia_id')) ?>
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
                                <?= (string) old('tipologia_id', $row->tipologia_id ?? ($context['tipologia_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="tipologia_id"
                            data-base-url="<?= site_url('tipologia_camera/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('tipologia_camera/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_max_pax" class="form-label">
                        <?= esc(lang('Camere.camere_max_pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_max_pax"
                        id="camere_max_pax"
                        value="<?= esc(old('camere_max_pax', $row->camere_max_pax ?? ($context['camere_max_pax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_max_pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_max_pax-error"
                        aria-invalid="<?= isset($errors['camere_max_pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camere_max_pax'])): ?>
                        <div id="camere_max_pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_max_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_metri_quadri" class="form-label">
                        <?= esc(lang('Camere.camere_metri_quadri')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_metri_quadri"
                        id="camere_metri_quadri"
                        value="<?= esc(old('camere_metri_quadri', $row->camere_metri_quadri ?? ($context['camere_metri_quadri'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_metri_quadri']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_metri_quadri-error"
                        aria-invalid="<?= isset($errors['camere_metri_quadri']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camere_metri_quadri'])): ?>
                        <div id="camere_metri_quadri-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_metri_quadri']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_vista" class="form-label">
                        <?= esc(lang('Camere.camere_vista')) ?>
                    </label>
                    <input
                        type="text"
                        name="camere_vista"
                        id="camere_vista"
                        value="<?= esc(old('camere_vista', $row->camere_vista ?? ($context['camere_vista'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_vista']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_vista-error"
                        aria-invalid="<?= isset($errors['camere_vista']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['camere_vista'])): ?>
                        <div id="camere_vista-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_vista']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_piano" class="form-label">
                        <?= esc(lang('Camere.camere_piano')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_piano"
                        id="camere_piano"
                        value="<?= esc(old('camere_piano', $row->camere_piano ?? ($context['camere_piano'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_piano']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_piano-error"
                        aria-invalid="<?= isset($errors['camere_piano']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camere_piano'])): ?>
                        <div id="camere_piano-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_piano']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_bagno" class="form-label">
                        <?= esc(lang('Camere.camere_bagno')) ?>
                    </label>
                    <input
                        type="text"
                        name="camere_bagno"
                        id="camere_bagno"
                        value="<?= esc(old('camere_bagno', $row->camere_bagno ?? ($context['camere_bagno'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_bagno']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_bagno-error"
                        aria-invalid="<?= isset($errors['camere_bagno']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['camere_bagno'])): ?>
                        <div id="camere_bagno-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_bagno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_edificio" class="form-label">
                        <?= esc(lang('Camere.camere_edificio')) ?>
                    </label>
                    <input
                        type="text"
                        name="camere_edificio"
                        id="camere_edificio"
                        value="<?= esc(old('camere_edificio', $row->camere_edificio ?? ($context['camere_edificio'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_edificio']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_edificio-error"
                        aria-invalid="<?= isset($errors['camere_edificio']) ? 'true' : 'false' ?>"
                        maxlength="3"
                    >
                    <?php if (!empty($errors['camere_edificio'])): ?>
                        <div id="camere_edificio-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_edificio']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="review_tot" class="form-label">
                        <?= esc(lang('Camere.review_tot')) ?>
                    </label>
                    <input
                        type="number"
                        name="review_tot"
                        id="review_tot"
                        value="<?= esc(old('review_tot', $row->review_tot ?? ($context['review_tot'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['review_tot']) ? 'is-invalid' : '' ?>"
                        aria-describedby="review_tot-error"
                        aria-invalid="<?= isset($errors['review_tot']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['review_tot'])): ?>
                        <div id="review_tot-error" class="invalid-feedback d-block">
                            <?= esc($errors['review_tot']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_utente_id" class="form-label">
                        <?= esc(lang('Camere.camere_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_utente_id"
                        id="camere_utente_id"
                        value="<?= esc(old('camere_utente_id', $row->camere_utente_id ?? ($context['camere_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camere_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camere_utente_id-error"
                        aria-invalid="<?= isset($errors['camere_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camere_utente_id'])): ?>
                        <div id="camere_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['camere_utente_id']) ?>
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

                    <a href="<?= site_url('camere') ?>" class="btn btn-secondary">
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
