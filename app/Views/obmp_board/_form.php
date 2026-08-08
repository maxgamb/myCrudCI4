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
                    <label for="obmp_board_id" class="form-label">
                        <?= esc(lang('ObmpBoard.obmp_board_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_board_id"
                        id="obmp_board_id"
                        value="<?= esc(old('obmp_board_id', $row->obmp_board_id ?? ($context['obmp_board_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_board_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_board_id-error"
                        aria-invalid="<?= isset($errors['obmp_board_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['obmp_board_id'])): ?>
                        <div id="obmp_board_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_board_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_board_title" class="form-label">
                        <?= esc(lang('ObmpBoard.obmp_board_title')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_board_title"
                        id="obmp_board_title"
                        value="<?= esc(old('obmp_board_title', $row->obmp_board_title ?? ($context['obmp_board_title'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_board_title']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_board_title-error"
                        aria-invalid="<?= isset($errors['obmp_board_title']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['obmp_board_title'])): ?>
                        <div id="obmp_board_title-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_board_title']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_board" class="form-label">
                        <?= esc(lang('ObmpBoard.obmp_board')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_board"
                        id="obmp_board"
                        value="<?= esc(old('obmp_board', $row->obmp_board ?? ($context['obmp_board'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_board']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_board-error"
                        aria-invalid="<?= isset($errors['obmp_board']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['obmp_board'])): ?>
                        <div id="obmp_board-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_board']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_board_cod" class="form-label">
                        <?= esc(lang('ObmpBoard.obmp_board_cod')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_board_cod"
                        id="obmp_board_cod"
                        value="<?= esc(old('obmp_board_cod', $row->obmp_board_cod ?? ($context['obmp_board_cod'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_board_cod']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_board_cod-error"
                        aria-invalid="<?= isset($errors['obmp_board_cod']) ? 'true' : 'false' ?>"
                        required maxlength="6"
                    >
                    <?php if (!empty($errors['obmp_board_cod'])): ?>
                        <div id="obmp_board_cod-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_board_cod']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="board_lg" class="form-label">
                        <?= esc(lang('ObmpBoard.board_lg')) ?>
                    </label>
                    <input
                        type="text"
                        name="board_lg"
                        id="board_lg"
                        value="<?= esc(old('board_lg', $row->board_lg ?? ($context['board_lg'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['board_lg']) ? 'is-invalid' : '' ?>"
                        aria-describedby="board_lg-error"
                        aria-invalid="<?= isset($errors['board_lg']) ? 'true' : 'false' ?>"
                        required maxlength="4"
                    >
                    <?php if (!empty($errors['board_lg'])): ?>
                        <div id="board_lg-error" class="invalid-feedback d-block">
                            <?= esc($errors['board_lg']) ?>
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

                    <a href="<?= site_url('obmp_board') ?>" class="btn btn-secondary">
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
