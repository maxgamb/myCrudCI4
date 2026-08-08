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
                        <?= esc(lang('ObmpRestrictions.hotel_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_id-error"
                        aria-invalid="<?= isset($errors['hotel_id']) ? 'true' : 'false' ?>"
                        maxlength="45"
                    >
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="restr_nama" class="form-label">
                        <?= esc(lang('ObmpRestrictions.restr_nama')) ?>
                    </label>
                    <input
                        type="text"
                        name="restr_nama"
                        id="restr_nama"
                        value="<?= esc(old('restr_nama', $row->restr_nama ?? ($context['restr_nama'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['restr_nama']) ? 'is-invalid' : '' ?>"
                        aria-describedby="restr_nama-error"
                        aria-invalid="<?= isset($errors['restr_nama']) ? 'true' : 'false' ?>"
                        maxlength="45"
                    >
                    <?php if (!empty($errors['restr_nama'])): ?>
                        <div id="restr_nama-error" class="invalid-feedback d-block">
                            <?= esc($errors['restr_nama']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="restr_min_stay" class="form-label">
                        <?= esc(lang('ObmpRestrictions.restr_min_stay')) ?>
                    </label>
                    <input
                        type="number"
                        name="restr_min_stay"
                        id="restr_min_stay"
                        value="<?= esc(old('restr_min_stay', $row->restr_min_stay ?? ($context['restr_min_stay'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['restr_min_stay']) ? 'is-invalid' : '' ?>"
                        aria-describedby="restr_min_stay-error"
                        aria-invalid="<?= isset($errors['restr_min_stay']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['restr_min_stay'])): ?>
                        <div id="restr_min_stay-error" class="invalid-feedback d-block">
                            <?= esc($errors['restr_min_stay']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="restr_max_stay" class="form-label">
                        <?= esc(lang('ObmpRestrictions.restr_max_stay')) ?>
                    </label>
                    <input
                        type="number"
                        name="restr_max_stay"
                        id="restr_max_stay"
                        value="<?= esc(old('restr_max_stay', $row->restr_max_stay ?? ($context['restr_max_stay'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['restr_max_stay']) ? 'is-invalid' : '' ?>"
                        aria-describedby="restr_max_stay-error"
                        aria-invalid="<?= isset($errors['restr_max_stay']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['restr_max_stay'])): ?>
                        <div id="restr_max_stay-error" class="invalid-feedback d-block">
                            <?= esc($errors['restr_max_stay']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="restr_min_bw" class="form-label">
                        <?= esc(lang('ObmpRestrictions.restr_min_bw')) ?>
                    </label>
                    <input
                        type="number"
                        name="restr_min_bw"
                        id="restr_min_bw"
                        value="<?= esc(old('restr_min_bw', $row->restr_min_bw ?? ($context['restr_min_bw'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['restr_min_bw']) ? 'is-invalid' : '' ?>"
                        aria-describedby="restr_min_bw-error"
                        aria-invalid="<?= isset($errors['restr_min_bw']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['restr_min_bw'])): ?>
                        <div id="restr_min_bw-error" class="invalid-feedback d-block">
                            <?= esc($errors['restr_min_bw']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="restr_max_bw" class="form-label">
                        <?= esc(lang('ObmpRestrictions.restr_max_bw')) ?>
                    </label>
                    <input
                        type="number"
                        name="restr_max_bw"
                        id="restr_max_bw"
                        value="<?= esc(old('restr_max_bw', $row->restr_max_bw ?? ($context['restr_max_bw'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['restr_max_bw']) ? 'is-invalid' : '' ?>"
                        aria-describedby="restr_max_bw-error"
                        aria-invalid="<?= isset($errors['restr_max_bw']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['restr_max_bw'])): ?>
                        <div id="restr_max_bw-error" class="invalid-feedback d-block">
                            <?= esc($errors['restr_max_bw']) ?>
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

                    <a href="<?= site_url('obmp_restrictions') ?>" class="btn btn-secondary">
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
