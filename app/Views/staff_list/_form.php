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
                    <label for="ID" class="form-label">
                        <?= esc(lang('StaffList.ID')) ?>
                    </label>
                    <input
                        type="number"
                        name="ID"
                        id="ID"
                        value="<?= esc(old('ID', $row->{'ID'} ?? ($context['ID'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ID']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ID-error"
                        aria-invalid="<?= isset($errors['ID']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ID'])): ?>
                        <div id="ID-error" class="invalid-feedback d-block">
                            <?= esc($errors['ID']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">
                        <?= esc(lang('StaffList.name')) ?>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="<?= esc(old('name', $row->{'name'} ?? ($context['name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="name-error"
                        aria-invalid="<?= isset($errors['name']) ? 'true' : 'false' ?>"
                        maxlength="91"
                    >
                    <?php if (!empty($errors['name'])): ?>
                        <div id="name-error" class="invalid-feedback d-block">
                            <?= esc($errors['name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">
                        <?= esc(lang('StaffList.address')) ?>
                    </label>
                    <input
                        type="text"
                        name="address"
                        id="address"
                        value="<?= esc(old('address', $row->{'address'} ?? ($context['address'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                        aria-describedby="address-error"
                        aria-invalid="<?= isset($errors['address']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['address'])): ?>
                        <div id="address-error" class="invalid-feedback d-block">
                            <?= esc($errors['address']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="zip code" class="form-label">
                        <?= esc(lang('StaffList.zip code')) ?>
                    </label>
                    <input
                        type="text"
                        name="zip code"
                        id="zip code"
                        value="<?= esc(old('zip code', $row->{'zip code'} ?? ($context['zip code'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['zip code']) ? 'is-invalid' : '' ?>"
                        aria-describedby="zip code-error"
                        aria-invalid="<?= isset($errors['zip code']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['zip code'])): ?>
                        <div id="zip code-error" class="invalid-feedback d-block">
                            <?= esc($errors['zip code']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        <?= esc(lang('StaffList.phone')) ?>
                    </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="<?= esc(old('phone', $row->{'phone'} ?? ($context['phone'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                        aria-describedby="phone-error"
                        aria-invalid="<?= isset($errors['phone']) ? 'true' : 'false' ?>"
                        required maxlength="20"
                    >
                    <?php if (!empty($errors['phone'])): ?>
                        <div id="phone-error" class="invalid-feedback d-block">
                            <?= esc($errors['phone']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">
                        <?= esc(lang('StaffList.city')) ?>
                    </label>
                    <input
                        type="text"
                        name="city"
                        id="city"
                        value="<?= esc(old('city', $row->{'city'} ?? ($context['city'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>"
                        aria-describedby="city-error"
                        aria-invalid="<?= isset($errors['city']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['city'])): ?>
                        <div id="city-error" class="invalid-feedback d-block">
                            <?= esc($errors['city']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="country" class="form-label">
                        <?= esc(lang('StaffList.country')) ?>
                    </label>
                    <input
                        type="text"
                        name="country"
                        id="country"
                        value="<?= esc(old('country', $row->{'country'} ?? ($context['country'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['country']) ? 'is-invalid' : '' ?>"
                        aria-describedby="country-error"
                        aria-invalid="<?= isset($errors['country']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['country'])): ?>
                        <div id="country-error" class="invalid-feedback d-block">
                            <?= esc($errors['country']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="SID" class="form-label">
                        <?= esc(lang('StaffList.SID')) ?>
                    </label>
                    <input
                        type="number"
                        name="SID"
                        id="SID"
                        value="<?= esc(old('SID', $row->{'SID'} ?? ($context['SID'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['SID']) ? 'is-invalid' : '' ?>"
                        aria-describedby="SID-error"
                        aria-invalid="<?= isset($errors['SID']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['SID'])): ?>
                        <div id="SID-error" class="invalid-feedback d-block">
                            <?= esc($errors['SID']) ?>
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

                    <a href="<?= site_url('staff_list') ?>" class="btn btn-secondary">
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
