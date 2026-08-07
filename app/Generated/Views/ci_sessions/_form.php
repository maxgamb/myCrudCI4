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
                        <?= esc(lang('CiSessions.id')) ?>
                    </label>
                    <input
                        type="text"
                        name="id"
                        id="id"
                        value="<?= esc(old('id', $row->id ?? '')) ?>"
                        class="form-control <?= isset($errors['id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="id-error"
                        aria-invalid="<?= isset($errors['id']) ? 'true' : 'false' ?>"
                        required maxlength="128"
                    >
                    <?php if (!empty($errors['id'])): ?>
                        <div id="id-error" class="invalid-feedback d-block">
                            <?= esc($errors['id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ip_address" class="form-label">
                        <?= esc(lang('CiSessions.ip_address')) ?>
                    </label>
                    <input
                        type="text"
                        name="ip_address"
                        id="ip_address"
                        value="<?= esc(old('ip_address', $row->ip_address ?? '')) ?>"
                        class="form-control <?= isset($errors['ip_address']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ip_address-error"
                        aria-invalid="<?= isset($errors['ip_address']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['ip_address'])): ?>
                        <div id="ip_address-error" class="invalid-feedback d-block">
                            <?= esc($errors['ip_address']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="timestamp" class="form-label">
                        <?= esc(lang('CiSessions.timestamp')) ?>
                    </label>
                    <input
                        type="number"
                        name="timestamp"
                        id="timestamp"
                        value="<?= esc(old('timestamp', $row->timestamp ?? '')) ?>"
                        class="form-control <?= isset($errors['timestamp']) ? 'is-invalid' : '' ?>"
                        aria-describedby="timestamp-error"
                        aria-invalid="<?= isset($errors['timestamp']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['timestamp'])): ?>
                        <div id="timestamp-error" class="invalid-feedback d-block">
                            <?= esc($errors['timestamp']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data" class="form-label">
                        <?= esc(lang('CiSessions.data')) ?>
                    </label>
                    <textarea
                        name="data"
                        id="data"
                        class="form-control <?= isset($errors['data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data-error"
                        aria-invalid="<?= isset($errors['data']) ? 'true' : 'false' ?>"
                        required maxlength="65535"
                    ><?= esc(old('data', $row->data ?? '')) ?></textarea>
                    <?php if (!empty($errors['data'])): ?>
                        <div id="data-error" class="invalid-feedback d-block">
                            <?= esc($errors['data']) ?>
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

                    <a href="<?= site_url('ci_sessions') ?>" class="btn btn-secondary">
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
