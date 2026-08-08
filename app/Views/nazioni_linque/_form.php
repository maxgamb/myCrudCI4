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
                    <label for="isoKey" class="form-label">
                        <?= esc(lang('NazioniLinque.isoKey')) ?>
                    </label>
                    <input
                        type="text"
                        name="isoKey"
                        id="isoKey"
                        value="<?= esc(old('isoKey', $row->isoKey ?? ($context['isoKey'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['isoKey']) ? 'is-invalid' : '' ?>"
                        aria-describedby="isoKey-error"
                        aria-invalid="<?= isset($errors['isoKey']) ? 'true' : 'false' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['isoKey'])): ?>
                        <div id="isoKey-error" class="invalid-feedback d-block">
                            <?= esc($errors['isoKey']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="iso3" class="form-label">
                        <?= esc(lang('NazioniLinque.iso3')) ?>
                    </label>
                    <input
                        type="text"
                        name="iso3"
                        id="iso3"
                        value="<?= esc(old('iso3', $row->iso3 ?? ($context['iso3'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['iso3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="iso3-error"
                        aria-invalid="<?= isset($errors['iso3']) ? 'true' : 'false' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['iso3'])): ?>
                        <div id="iso3-error" class="invalid-feedback d-block">
                            <?= esc($errors['iso3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazioni_EN" class="form-label">
                        <?= esc(lang('NazioniLinque.nazioni_EN')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazioni_EN"
                        id="nazioni_EN"
                        value="<?= esc(old('nazioni_EN', $row->nazioni_EN ?? ($context['nazioni_EN'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazioni_EN']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazioni_EN-error"
                        aria-invalid="<?= isset($errors['nazioni_EN']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['nazioni_EN'])): ?>
                        <div id="nazioni_EN-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazioni_EN']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazioni_ES" class="form-label">
                        <?= esc(lang('NazioniLinque.nazioni_ES')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazioni_ES"
                        id="nazioni_ES"
                        value="<?= esc(old('nazioni_ES', $row->nazioni_ES ?? ($context['nazioni_ES'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazioni_ES']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazioni_ES-error"
                        aria-invalid="<?= isset($errors['nazioni_ES']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['nazioni_ES'])): ?>
                        <div id="nazioni_ES-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazioni_ES']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazioni_FR" class="form-label">
                        <?= esc(lang('NazioniLinque.nazioni_FR')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazioni_FR"
                        id="nazioni_FR"
                        value="<?= esc(old('nazioni_FR', $row->nazioni_FR ?? ($context['nazioni_FR'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazioni_FR']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazioni_FR-error"
                        aria-invalid="<?= isset($errors['nazioni_FR']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['nazioni_FR'])): ?>
                        <div id="nazioni_FR-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazioni_FR']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazioni_DE" class="form-label">
                        <?= esc(lang('NazioniLinque.nazioni_DE')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazioni_DE"
                        id="nazioni_DE"
                        value="<?= esc(old('nazioni_DE', $row->nazioni_DE ?? ($context['nazioni_DE'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazioni_DE']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazioni_DE-error"
                        aria-invalid="<?= isset($errors['nazioni_DE']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['nazioni_DE'])): ?>
                        <div id="nazioni_DE-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazioni_DE']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazioni_IT" class="form-label">
                        <?= esc(lang('NazioniLinque.nazioni_IT')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazioni_IT"
                        id="nazioni_IT"
                        value="<?= esc(old('nazioni_IT', $row->nazioni_IT ?? ($context['nazioni_IT'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazioni_IT']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazioni_IT-error"
                        aria-invalid="<?= isset($errors['nazioni_IT']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['nazioni_IT'])): ?>
                        <div id="nazioni_IT-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazioni_IT']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="lg" class="form-label">
                        <?= esc(lang('NazioniLinque.lg')) ?>
                    </label>
                    <input
                        type="text"
                        name="lg"
                        id="lg"
                        value="<?= esc(old('lg', $row->lg ?? ($context['lg'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['lg']) ? 'is-invalid' : '' ?>"
                        aria-describedby="lg-error"
                        aria-invalid="<?= isset($errors['lg']) ? 'true' : 'false' ?>"
                        required maxlength="4"
                    >
                    <?php if (!empty($errors['lg'])): ?>
                        <div id="lg-error" class="invalid-feedback d-block">
                            <?= esc($errors['lg']) ?>
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

                    <a href="<?= site_url('nazioni_linque') ?>" class="btn btn-secondary">
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
