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
                    <label for="log_nome" class="form-label">
                        <?= esc(lang('LogIn.log_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="log_nome"
                        id="log_nome"
                        value="<?= esc(old('log_nome', $row->log_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['log_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_nome-error"
                        aria-invalid="<?= isset($errors['log_nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['log_nome'])): ?>
                        <div id="log_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_pass" class="form-label">
                        <?= esc(lang('LogIn.log_pass')) ?>
                    </label>
                    <input
                        type="text"
                        name="log_pass"
                        id="log_pass"
                        value="<?= esc(old('log_pass', $row->log_pass ?? '')) ?>"
                        class="form-control <?= isset($errors['log_pass']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_pass-error"
                        aria-invalid="<?= isset($errors['log_pass']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['log_pass'])): ?>
                        <div id="log_pass-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_pass']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_ip" class="form-label">
                        <?= esc(lang('LogIn.log_ip')) ?>
                    </label>
                    <input
                        type="text"
                        name="log_ip"
                        id="log_ip"
                        value="<?= esc(old('log_ip', $row->log_ip ?? '')) ?>"
                        class="form-control <?= isset($errors['log_ip']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_ip-error"
                        aria-invalid="<?= isset($errors['log_ip']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['log_ip'])): ?>
                        <div id="log_ip-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_ip']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_out" class="form-label">
                        <?= esc(lang('LogIn.log_out')) ?>
                    </label>
                    <input
                        type="text"
                        name="log_out"
                        id="log_out"
                        value="<?= esc(old('log_out', $row->log_out ?? '')) ?>"
                        class="form-control <?= isset($errors['log_out']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_out-error"
                        aria-invalid="<?= isset($errors['log_out']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['log_out'])): ?>
                        <div id="log_out-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_out']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="log_time" class="form-label">
                        <?= esc(lang('LogIn.log_time')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="log_time"
                        id="log_time"
                        value="<?= esc(old('log_time', isset($row->log_time) ? str_replace(' ', 'T', substr((string) $row->log_time, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['log_time']) ? 'is-invalid' : '' ?>"
                        aria-describedby="log_time-error"
                        aria-invalid="<?= isset($errors['log_time']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['log_time'])): ?>
                        <div id="log_time-error" class="invalid-feedback d-block">
                            <?= esc($errors['log_time']) ?>
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

                    <a href="<?= site_url('log_in') ?>" class="btn btn-secondary">
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
