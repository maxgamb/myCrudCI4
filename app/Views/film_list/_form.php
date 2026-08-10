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
                    <label for="FID" class="form-label">
                        <?= esc(lang('FilmList.FID')) ?>
                    </label>
                    <input
                        type="number"
                        name="FID"
                        id="FID"
                        value="<?= esc(old('FID', $row->{'FID'} ?? ($context['FID'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['FID']) ? 'is-invalid' : '' ?>"
                        aria-describedby="FID-error"
                        aria-invalid="<?= isset($errors['FID']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['FID'])): ?>
                        <div id="FID-error" class="invalid-feedback d-block">
                            <?= esc($errors['FID']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="title" class="form-label">
                        <?= esc(lang('FilmList.title')) ?>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="<?= esc(old('title', $row->{'title'} ?? ($context['title'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                        aria-describedby="title-error"
                        aria-invalid="<?= isset($errors['title']) ? 'true' : 'false' ?>"
                        required maxlength="128"
                    >
                    <?php if (!empty($errors['title'])): ?>
                        <div id="title-error" class="invalid-feedback d-block">
                            <?= esc($errors['title']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">
                        <?= esc(lang('FilmList.description')) ?>
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                        aria-describedby="description-error"
                        aria-invalid="<?= isset($errors['description']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('description', $row->{'description'} ?? ($context['description'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <div id="description-error" class="invalid-feedback d-block">
                            <?= esc($errors['description']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="category" class="form-label">
                        <?= esc(lang('FilmList.category')) ?>
                    </label>
                    <input
                        type="text"
                        name="category"
                        id="category"
                        value="<?= esc(old('category', $row->{'category'} ?? ($context['category'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['category']) ? 'is-invalid' : '' ?>"
                        aria-describedby="category-error"
                        aria-invalid="<?= isset($errors['category']) ? 'true' : 'false' ?>"
                        maxlength="25"
                    >
                    <?php if (!empty($errors['category'])): ?>
                        <div id="category-error" class="invalid-feedback d-block">
                            <?= esc($errors['category']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">
                        <?= esc(lang('FilmList.price')) ?>
                    </label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        value="<?= esc(old('price', $row->{'price'} ?? ($context['price'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                        aria-describedby="price-error"
                        aria-invalid="<?= isset($errors['price']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['price'])): ?>
                        <div id="price-error" class="invalid-feedback d-block">
                            <?= esc($errors['price']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="length" class="form-label">
                        <?= esc(lang('FilmList.length')) ?>
                    </label>
                    <input
                        type="number"
                        name="length"
                        id="length"
                        value="<?= esc(old('length', $row->{'length'} ?? ($context['length'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['length']) ? 'is-invalid' : '' ?>"
                        aria-describedby="length-error"
                        aria-invalid="<?= isset($errors['length']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['length'])): ?>
                        <div id="length-error" class="invalid-feedback d-block">
                            <?= esc($errors['length']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="rating" class="form-label">
                        <?= esc(lang('FilmList.rating')) ?>
                    </label>
                    <input
                        type="text"
                        name="rating"
                        id="rating"
                        value="<?= esc(old('rating', $row->{'rating'} ?? ($context['rating'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rating']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rating-error"
                        aria-invalid="<?= isset($errors['rating']) ? 'true' : 'false' ?>"
                        maxlength="5"
                    >
                    <?php if (!empty($errors['rating'])): ?>
                        <div id="rating-error" class="invalid-feedback d-block">
                            <?= esc($errors['rating']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="actors" class="form-label">
                        <?= esc(lang('FilmList.actors')) ?>
                    </label>
                    <textarea
                        name="actors"
                        id="actors"
                        class="form-control <?= isset($errors['actors']) ? 'is-invalid' : '' ?>"
                        aria-describedby="actors-error"
                        aria-invalid="<?= isset($errors['actors']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('actors', $row->{'actors'} ?? ($context['actors'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['actors'])): ?>
                        <div id="actors-error" class="invalid-feedback d-block">
                            <?= esc($errors['actors']) ?>
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

                    <a href="<?= site_url('film_list') ?>" class="btn btn-secondary">
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
