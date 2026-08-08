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
                    <label for="title" class="form-label">
                        <?= esc(lang('Question.title')) ?>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="<?= esc(old('title', $row->title ?? ($context['title'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                        aria-describedby="title-error"
                        aria-invalid="<?= isset($errors['title']) ? 'true' : 'false' ?>"
                        maxlength="240"
                    >
                    <?php if (!empty($errors['title'])): ?>
                        <div id="title-error" class="invalid-feedback d-block">
                            <?= esc($errors['title']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tex_lingue_id_pro" class="form-label">
                        <?= esc(lang('Question.tex_lingue_id_pro')) ?>
                    </label>
                    <input
                        type="number"
                        name="tex_lingue_id_pro"
                        id="tex_lingue_id_pro"
                        value="<?= esc(old('tex_lingue_id_pro', $row->tex_lingue_id_pro ?? ($context['tex_lingue_id_pro'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tex_lingue_id_pro']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tex_lingue_id_pro-error"
                        aria-invalid="<?= isset($errors['tex_lingue_id_pro']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tex_lingue_id_pro'])): ?>
                        <div id="tex_lingue_id_pro-error" class="invalid-feedback d-block">
                            <?= esc($errors['tex_lingue_id_pro']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tex_lingue_id_con" class="form-label">
                        <?= esc(lang('Question.tex_lingue_id_con')) ?>
                    </label>
                    <input
                        type="number"
                        name="tex_lingue_id_con"
                        id="tex_lingue_id_con"
                        value="<?= esc(old('tex_lingue_id_con', $row->tex_lingue_id_con ?? ($context['tex_lingue_id_con'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tex_lingue_id_con']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tex_lingue_id_con-error"
                        aria-invalid="<?= isset($errors['tex_lingue_id_con']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tex_lingue_id_con'])): ?>
                        <div id="tex_lingue_id_con-error" class="invalid-feedback d-block">
                            <?= esc($errors['tex_lingue_id_con']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tex_pro" class="form-label">
                        <?= esc(lang('Question.tex_pro')) ?>
                    </label>
                    <input
                        type="text"
                        name="tex_pro"
                        id="tex_pro"
                        value="<?= esc(old('tex_pro', $row->tex_pro ?? ($context['tex_pro'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tex_pro']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tex_pro-error"
                        aria-invalid="<?= isset($errors['tex_pro']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['tex_pro'])): ?>
                        <div id="tex_pro-error" class="invalid-feedback d-block">
                            <?= esc($errors['tex_pro']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tex_no" class="form-label">
                        <?= esc(lang('Question.tex_no')) ?>
                    </label>
                    <input
                        type="text"
                        name="tex_no"
                        id="tex_no"
                        value="<?= esc(old('tex_no', $row->tex_no ?? ($context['tex_no'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tex_no']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tex_no-error"
                        aria-invalid="<?= isset($errors['tex_no']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['tex_no'])): ?>
                        <div id="tex_no-error" class="invalid-feedback d-block">
                            <?= esc($errors['tex_no']) ?>
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

                    <a href="<?= site_url('question') ?>" class="btn btn-secondary">
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
