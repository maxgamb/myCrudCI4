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
                    <label for="Comuni_Codice" class="form-label">
                        <?= esc(lang('Comuni.Comuni_Codice')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Codice"
                        id="Comuni_Codice"
                        value="<?= esc(old('Comuni_Codice', $row->Comuni_Codice ?? ($context['Comuni_Codice'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_Codice']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_Codice-error"
                        aria-invalid="<?= isset($errors['Comuni_Codice']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Codice'])): ?>
                        <div id="Comuni_Codice-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Codice']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Nome" class="form-label">
                        <?= esc(lang('Comuni.Comuni_Nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Nome"
                        id="Comuni_Nome"
                        value="<?= esc(old('Comuni_Nome', $row->Comuni_Nome ?? ($context['Comuni_Nome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_Nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_Nome-error"
                        aria-invalid="<?= isset($errors['Comuni_Nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Nome'])): ?>
                        <div id="Comuni_Nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Prov" class="form-label">
                        <?= esc(lang('Comuni.Comuni_Prov')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Prov"
                        id="Comuni_Prov"
                        value="<?= esc(old('Comuni_Prov', $row->Comuni_Prov ?? ($context['Comuni_Prov'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_Prov']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_Prov-error"
                        aria-invalid="<?= isset($errors['Comuni_Prov']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Prov'])): ?>
                        <div id="Comuni_Prov-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Prov']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_CAP" class="form-label">
                        <?= esc(lang('Comuni.Comuni_CAP')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_CAP"
                        id="Comuni_CAP"
                        value="<?= esc(old('Comuni_CAP', $row->Comuni_CAP ?? ($context['Comuni_CAP'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_CAP']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_CAP-error"
                        aria-invalid="<?= isset($errors['Comuni_CAP']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_CAP'])): ?>
                        <div id="Comuni_CAP-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_CAP']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Prefisso" class="form-label">
                        <?= esc(lang('Comuni.Comuni_Prefisso')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Prefisso"
                        id="Comuni_Prefisso"
                        value="<?= esc(old('Comuni_Prefisso', $row->Comuni_Prefisso ?? ($context['Comuni_Prefisso'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_Prefisso']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_Prefisso-error"
                        aria-invalid="<?= isset($errors['Comuni_Prefisso']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Prefisso'])): ?>
                        <div id="Comuni_Prefisso-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Prefisso']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_ColExcel" class="form-label">
                        <?= esc(lang('Comuni.Comuni_ColExcel')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_ColExcel"
                        id="Comuni_ColExcel"
                        value="<?= esc(old('Comuni_ColExcel', $row->Comuni_ColExcel ?? ($context['Comuni_ColExcel'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_ColExcel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_ColExcel-error"
                        aria-invalid="<?= isset($errors['Comuni_ColExcel']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_ColExcel'])): ?>
                        <div id="Comuni_ColExcel-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_ColExcel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Nazione" class="form-label">
                        <?= esc(lang('Comuni.Comuni_Nazione')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Nazione"
                        id="Comuni_Nazione"
                        value="<?= esc(old('Comuni_Nazione', $row->Comuni_Nazione ?? ($context['Comuni_Nazione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_Nazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_Nazione-error"
                        aria-invalid="<?= isset($errors['Comuni_Nazione']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['Comuni_Nazione'])): ?>
                        <div id="Comuni_Nazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Nazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Lingua" class="form-label">
                        <?= esc(lang('Comuni.Comuni_Lingua')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Lingua"
                        id="Comuni_Lingua"
                        value="<?= esc(old('Comuni_Lingua', $row->Comuni_Lingua ?? ($context['Comuni_Lingua'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['Comuni_Lingua']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Comuni_Lingua-error"
                        aria-invalid="<?= isset($errors['Comuni_Lingua']) ? 'true' : 'false' ?>"
                        required maxlength="4"
                    >
                    <?php if (!empty($errors['Comuni_Lingua'])): ?>
                        <div id="Comuni_Lingua-error" class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Lingua']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazione_iso2" class="form-label">
                        <?= esc(lang('Comuni.nazione_iso2')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazione_iso2"
                        id="nazione_iso2"
                        value="<?= esc(old('nazione_iso2', $row->nazione_iso2 ?? ($context['nazione_iso2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazione_iso2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazione_iso2-error"
                        aria-invalid="<?= isset($errors['nazione_iso2']) ? 'true' : 'false' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['nazione_iso2'])): ?>
                        <div id="nazione_iso2-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazione_iso2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazione_iso3" class="form-label">
                        <?= esc(lang('Comuni.nazione_iso3')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazione_iso3"
                        id="nazione_iso3"
                        value="<?= esc(old('nazione_iso3', $row->nazione_iso3 ?? ($context['nazione_iso3'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nazione_iso3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazione_iso3-error"
                        aria-invalid="<?= isset($errors['nazione_iso3']) ? 'true' : 'false' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['nazione_iso3'])): ?>
                        <div id="nazione_iso3-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazione_iso3']) ?>
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

                    <a href="<?= site_url('comuni') ?>" class="btn btn-secondary">
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
