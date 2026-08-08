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
                        <?= esc(lang('Guasti.hotel_id')) ?>
                    </label>
                    <select
                        name="hotel_id"
                        id="hotel_id"
                        class="form-select <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_id-error"
                        aria-invalid="<?= isset($errors['hotel_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['hotel_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="hotel_id"
                            data-base-url="<?= site_url('hotels/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('hotels/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('Guasti.camera_id')) ?>
                    </label>
                    <select
                        name="camera_id"
                        id="camera_id"
                        class="form-select <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_id-error"
                        aria-invalid="<?= isset($errors['camera_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['camera_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('camera_id', $row->camera_id ?? ($context['camera_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="camera_id"
                            data-base-url="<?= site_url('camere/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('camere/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['camera_id'])): ?>
                        <div id="camera_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_priorita" class="form-label">
                        <?= esc(lang('Guasti.guasto_priorita')) ?>
                    </label>
                    <input
                        type="number"
                        name="guasto_priorita"
                        id="guasto_priorita"
                        value="<?= esc(old('guasto_priorita', $row->guasto_priorita ?? ($context['guasto_priorita'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_priorita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_priorita-error"
                        aria-invalid="<?= isset($errors['guasto_priorita']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['guasto_priorita'])): ?>
                        <div id="guasto_priorita-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_priorita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_area" class="form-label">
                        <?= esc(lang('Guasti.guasto_area')) ?>
                    </label>
                    <input
                        type="text"
                        name="guasto_area"
                        id="guasto_area"
                        value="<?= esc(old('guasto_area', $row->guasto_area ?? ($context['guasto_area'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_area']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_area-error"
                        aria-invalid="<?= isset($errors['guasto_area']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['guasto_area'])): ?>
                        <div id="guasto_area-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_area']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_piano" class="form-label">
                        <?= esc(lang('Guasti.guasto_piano')) ?>
                    </label>
                    <input
                        type="text"
                        name="guasto_piano"
                        id="guasto_piano"
                        value="<?= esc(old('guasto_piano', $row->guasto_piano ?? ($context['guasto_piano'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_piano']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_piano-error"
                        aria-invalid="<?= isset($errors['guasto_piano']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['guasto_piano'])): ?>
                        <div id="guasto_piano-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_piano']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_note" class="form-label">
                        <?= esc(lang('Guasti.guasto_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="guasto_note"
                        id="guasto_note"
                        value="<?= esc(old('guasto_note', $row->guasto_note ?? ($context['guasto_note'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_note-error"
                        aria-invalid="<?= isset($errors['guasto_note']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['guasto_note'])): ?>
                        <div id="guasto_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_stato" class="form-label">
                        <?= esc(lang('Guasti.guasto_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="guasto_stato"
                        id="guasto_stato"
                        value="<?= esc(old('guasto_stato', $row->guasto_stato ?? ($context['guasto_stato'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_stato-error"
                        aria-invalid="<?= isset($errors['guasto_stato']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['guasto_stato'])): ?>
                        <div id="guasto_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_data" class="form-label">
                        <?= esc(lang('Guasti.guasto_data')) ?>
                    </label>
                    <input
                        type="date"
                        name="guasto_data"
                        id="guasto_data"
                        value="<?= esc(old('guasto_data', $row->guasto_data ?? ($context['guasto_data'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_data-error"
                        aria-invalid="<?= isset($errors['guasto_data']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['guasto_data'])): ?>
                        <div id="guasto_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="guasto_utente_id" class="form-label">
                        <?= esc(lang('Guasti.guasto_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="guasto_utente_id"
                        id="guasto_utente_id"
                        value="<?= esc(old('guasto_utente_id', $row->guasto_utente_id ?? ($context['guasto_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['guasto_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="guasto_utente_id-error"
                        aria-invalid="<?= isset($errors['guasto_utente_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['guasto_utente_id'])): ?>
                        <div id="guasto_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['guasto_utente_id']) ?>
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

                    <a href="<?= site_url('guasti') ?>" class="btn btn-secondary">
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
