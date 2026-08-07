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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Competitori.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
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
                    <label for="livello_dicompetizione" class="form-label">
                        <?= esc(lang('Competitori.livello_dicompetizione')) ?>
                    </label>
                    <input
                        type="number"
                        name="livello_dicompetizione"
                        id="livello_dicompetizione"
                        value="<?= esc(old('livello_dicompetizione', $row->livello_dicompetizione ?? '')) ?>"
                        class="form-control <?= isset($errors['livello_dicompetizione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="livello_dicompetizione-error"
                        aria-invalid="<?= isset($errors['livello_dicompetizione']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['livello_dicompetizione'])): ?>
                        <div id="livello_dicompetizione-error" class="invalid-feedback d-block">
                            <?= esc($errors['livello_dicompetizione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="competitore_nome" class="form-label">
                        <?= esc(lang('Competitori.competitore_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="competitore_nome"
                        id="competitore_nome"
                        value="<?= esc(old('competitore_nome', $row->competitore_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['competitore_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="competitore_nome-error"
                        aria-invalid="<?= isset($errors['competitore_nome']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['competitore_nome'])): ?>
                        <div id="competitore_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['competitore_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="competitore_venere_id" class="form-label">
                        <?= esc(lang('Competitori.competitore_venere_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="competitore_venere_id"
                        id="competitore_venere_id"
                        value="<?= esc(old('competitore_venere_id', $row->competitore_venere_id ?? '')) ?>"
                        class="form-control <?= isset($errors['competitore_venere_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="competitore_venere_id-error"
                        aria-invalid="<?= isset($errors['competitore_venere_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['competitore_venere_id'])): ?>
                        <div id="competitore_venere_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['competitore_venere_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="qualita_trivago" class="form-label">
                        <?= esc(lang('Competitori.qualita_trivago')) ?>
                    </label>
                    <input
                        type="number"
                        name="qualita_trivago"
                        id="qualita_trivago"
                        value="<?= esc(old('qualita_trivago', $row->qualita_trivago ?? '')) ?>"
                        class="form-control <?= isset($errors['qualita_trivago']) ? 'is-invalid' : '' ?>"
                        aria-describedby="qualita_trivago-error"
                        aria-invalid="<?= isset($errors['qualita_trivago']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['qualita_trivago'])): ?>
                        <div id="qualita_trivago-error" class="invalid-feedback d-block">
                            <?= esc($errors['qualita_trivago']) ?>
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

                    <a href="<?= site_url('competitori') ?>" class="btn btn-secondary">
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
