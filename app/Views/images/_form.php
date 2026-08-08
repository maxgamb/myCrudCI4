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
                        <?= esc(lang('Images.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
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
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('Images.camera_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="camera_id"
                        id="camera_id"
                        value="<?= esc(old('camera_id', $row->camera_id ?? ($context['camera_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_id-error"
                        aria-invalid="<?= isset($errors['camera_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camera_id'])): ?>
                        <div id="camera_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_id" class="form-label">
                        <?= esc(lang('Images.obmp_cm_rooms_id')) ?>
                    </label>
                    <select
                        name="obmp_cm_rooms_id"
                        id="obmp_cm_rooms_id"
                        class="form-select <?= isset($errors['obmp_cm_rooms_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_cm_rooms_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_cm_rooms_id', $row->obmp_cm_rooms_id ?? ($context['obmp_cm_rooms_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="obmp_cm_rooms_id"
                            data-base-url="<?= site_url('obmp_cm_rooms/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('obmp_cm_rooms/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['obmp_cm_rooms_id'])): ?>
                        <div id="obmp_cm_rooms_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('Images.tipologia_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="tipologia_id"
                        id="tipologia_id"
                        value="<?= esc(old('tipologia_id', $row->tipologia_id ?? ($context['tipologia_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_id-error"
                        aria-invalid="<?= isset($errors['tipologia_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="img_small" class="form-label">
                        <?= esc(lang('Images.img_small')) ?>
                    </label>
                    <input
                        type="text"
                        name="img_small"
                        id="img_small"
                        value="<?= esc(old('img_small', $row->img_small ?? ($context['img_small'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['img_small']) ? 'is-invalid' : '' ?>"
                        aria-describedby="img_small-error"
                        aria-invalid="<?= isset($errors['img_small']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['img_small'])): ?>
                        <div id="img_small-error" class="invalid-feedback d-block">
                            <?= esc($errors['img_small']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="img_medium" class="form-label">
                        <?= esc(lang('Images.img_medium')) ?>
                    </label>
                    <input
                        type="text"
                        name="img_medium"
                        id="img_medium"
                        value="<?= esc(old('img_medium', $row->img_medium ?? ($context['img_medium'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['img_medium']) ? 'is-invalid' : '' ?>"
                        aria-describedby="img_medium-error"
                        aria-invalid="<?= isset($errors['img_medium']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['img_medium'])): ?>
                        <div id="img_medium-error" class="invalid-feedback d-block">
                            <?= esc($errors['img_medium']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="img_large" class="form-label">
                        <?= esc(lang('Images.img_large')) ?>
                    </label>
                    <input
                        type="text"
                        name="img_large"
                        id="img_large"
                        value="<?= esc(old('img_large', $row->img_large ?? ($context['img_large'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['img_large']) ? 'is-invalid' : '' ?>"
                        aria-describedby="img_large-error"
                        aria-invalid="<?= isset($errors['img_large']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['img_large'])): ?>
                        <div id="img_large-error" class="invalid-feedback d-block">
                            <?= esc($errors['img_large']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="titolo" class="form-label">
                        <?= esc(lang('Images.titolo')) ?>
                    </label>
                    <input
                        type="text"
                        name="titolo"
                        id="titolo"
                        value="<?= esc(old('titolo', $row->titolo ?? ($context['titolo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['titolo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="titolo-error"
                        aria-invalid="<?= isset($errors['titolo']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['titolo'])): ?>
                        <div id="titolo-error" class="invalid-feedback d-block">
                            <?= esc($errors['titolo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('Images.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? ($context['utente_id'] ?? ''))) ?>"
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

                    <a href="<?= site_url('images') ?>" class="btn btn-secondary">
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
