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
                    <label for="company" class="form-label">
                        <?= esc(lang('WrehSuppliers.company')) ?>
                    </label>
                    <input
                        type="text"
                        name="company"
                        id="company"
                        value="<?= esc(old('company', $row->company ?? '')) ?>"
                        class="form-control <?= isset($errors['company']) ? 'is-invalid' : '' ?>"
                        aria-describedby="company-error"
                        aria-invalid="<?= isset($errors['company']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['company'])): ?>
                        <div id="company-error" class="invalid-feedback d-block">
                            <?= esc($errors['company']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="contact_name" class="form-label">
                        <?= esc(lang('WrehSuppliers.contact_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="contact_name"
                        id="contact_name"
                        value="<?= esc(old('contact_name', $row->contact_name ?? '')) ?>"
                        class="form-control <?= isset($errors['contact_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="contact_name-error"
                        aria-invalid="<?= isset($errors['contact_name']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['contact_name'])): ?>
                        <div id="contact_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['contact_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        <?= esc(lang('WrehSuppliers.phone')) ?>
                    </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        value="<?= esc(old('phone', $row->phone ?? '')) ?>"
                        class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                        aria-describedby="phone-error"
                        aria-invalid="<?= isset($errors['phone']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['phone'])): ?>
                        <div id="phone-error" class="invalid-feedback d-block">
                            <?= esc($errors['phone']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <?= esc(lang('WrehSuppliers.email')) ?>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="<?= esc(old('email', $row->email ?? '')) ?>"
                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email-error"
                        aria-invalid="<?= isset($errors['email']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['email'])): ?>
                        <div id="email-error" class="invalid-feedback d-block">
                            <?= esc($errors['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">
                        <?= esc(lang('WrehSuppliers.address')) ?>
                    </label>
                    <textarea
                        name="address"
                        id="address"
                        class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                        aria-describedby="address-error"
                        aria-invalid="<?= isset($errors['address']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('address', $row->address ?? '')) ?></textarea>
                    <?php if (!empty($errors['address'])): ?>
                        <div id="address-error" class="invalid-feedback d-block">
                            <?= esc($errors['address']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('WrehSuppliers.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? '')) ?>"
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

                    <a href="<?= site_url('wreh_suppliers') ?>" class="btn btn-secondary">
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
