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
                    <label for="actor_id" class="form-label">
                        <?= esc(lang('ActorInfo.actor_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="actor_id"
                        id="actor_id"
                        value="<?= esc(old('actor_id', $row->{'actor_id'} ?? ($context['actor_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['actor_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="actor_id-error"
                        aria-invalid="<?= isset($errors['actor_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['actor_id'])): ?>
                        <div id="actor_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['actor_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="first_name" class="form-label">
                        <?= esc(lang('ActorInfo.first_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        value="<?= esc(old('first_name', $row->{'first_name'} ?? ($context['first_name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="first_name-error"
                        aria-invalid="<?= isset($errors['first_name']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['first_name'])): ?>
                        <div id="first_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['first_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">
                        <?= esc(lang('ActorInfo.last_name')) ?>
                    </label>
                    <input
                        type="text"
                        name="last_name"
                        id="last_name"
                        value="<?= esc(old('last_name', $row->{'last_name'} ?? ($context['last_name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="last_name-error"
                        aria-invalid="<?= isset($errors['last_name']) ? 'true' : 'false' ?>"
                        required maxlength="45"
                    >
                    <?php if (!empty($errors['last_name'])): ?>
                        <div id="last_name-error" class="invalid-feedback d-block">
                            <?= esc($errors['last_name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="film_info" class="form-label">
                        <?= esc(lang('ActorInfo.film_info')) ?>
                    </label>
                    <textarea
                        name="film_info"
                        id="film_info"
                        class="form-control <?= isset($errors['film_info']) ? 'is-invalid' : '' ?>"
                        aria-describedby="film_info-error"
                        aria-invalid="<?= isset($errors['film_info']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('film_info', $row->{'film_info'} ?? ($context['film_info'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['film_info'])): ?>
                        <div id="film_info-error" class="invalid-feedback d-block">
                            <?= esc($errors['film_info']) ?>
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

                    <a href="<?= site_url('actor_info') ?>" class="btn btn-secondary">
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
