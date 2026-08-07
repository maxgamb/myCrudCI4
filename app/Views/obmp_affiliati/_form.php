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
                    <label for="obmp_aff_societa" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_societa')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_aff_societa"
                        id="obmp_aff_societa"
                        value="<?= esc(old('obmp_aff_societa', $row->obmp_aff_societa ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_societa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_societa-error"
                        aria-invalid="<?= isset($errors['obmp_aff_societa']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_aff_societa'])): ?>
                        <div id="obmp_aff_societa-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_societa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_aff_sito" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_sito')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_aff_sito"
                        id="obmp_aff_sito"
                        value="<?= esc(old('obmp_aff_sito', $row->obmp_aff_sito ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_sito']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_sito-error"
                        aria-invalid="<?= isset($errors['obmp_aff_sito']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_aff_sito'])): ?>
                        <div id="obmp_aff_sito-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_sito']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_aff_email" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="obmp_aff_email"
                        id="obmp_aff_email"
                        value="<?= esc(old('obmp_aff_email', $row->obmp_aff_email ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_email-error"
                        aria-invalid="<?= isset($errors['obmp_aff_email']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['obmp_aff_email'])): ?>
                        <div id="obmp_aff_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_aff_pasword" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_pasword')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_aff_pasword"
                        id="obmp_aff_pasword"
                        value="<?= esc(old('obmp_aff_pasword', $row->obmp_aff_pasword ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_pasword']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_pasword-error"
                        aria-invalid="<?= isset($errors['obmp_aff_pasword']) ? 'true' : 'false' ?>"
                        maxlength="20"
                    >
                    <?php if (!empty($errors['obmp_aff_pasword'])): ?>
                        <div id="obmp_aff_pasword-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_pasword']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_aff_cookies" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_cookies')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_aff_cookies"
                        id="obmp_aff_cookies"
                        value="<?= esc(old('obmp_aff_cookies', $row->obmp_aff_cookies ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_cookies']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_cookies-error"
                        aria-invalid="<?= isset($errors['obmp_aff_cookies']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_aff_cookies'])): ?>
                        <div id="obmp_aff_cookies-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_cookies']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_aff_commisione" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_commisione')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_aff_commisione"
                        id="obmp_aff_commisione"
                        value="<?= esc(old('obmp_aff_commisione', $row->obmp_aff_commisione ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_commisione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_commisione-error"
                        aria-invalid="<?= isset($errors['obmp_aff_commisione']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_aff_commisione'])): ?>
                        <div id="obmp_aff_commisione-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_commisione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_aff_mark_up" class="form-label">
                        <?= esc(lang('ObmpAffiliati.obmp_aff_mark_up')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_aff_mark_up"
                        id="obmp_aff_mark_up"
                        value="<?= esc(old('obmp_aff_mark_up', $row->obmp_aff_mark_up ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_aff_mark_up']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_aff_mark_up-error"
                        aria-invalid="<?= isset($errors['obmp_aff_mark_up']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_aff_mark_up'])): ?>
                        <div id="obmp_aff_mark_up-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_aff_mark_up']) ?>
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

                    <a href="<?= site_url('obmp_affiliati') ?>" class="btn btn-secondary">
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
