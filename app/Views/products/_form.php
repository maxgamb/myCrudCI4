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
                    <label for="name" class="form-label">
                        <?= esc(lang('Products.name')) ?>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="<?= esc(old('name', $row->name ?? ($context['name'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                        aria-describedby="name-error"
                        aria-invalid="<?= isset($errors['name']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['name'])): ?>
                        <div id="name-error" class="invalid-feedback d-block">
                            <?= esc($errors['name']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">
                        <?= esc(lang('Products.description')) ?>
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                        aria-describedby="description-error"
                        aria-invalid="<?= isset($errors['description']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('description', $row->description ?? ($context['description'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <div id="description-error" class="invalid-feedback d-block">
                            <?= esc($errors['description']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="price" class="form-label">
                        <?= esc(lang('Products.price')) ?>
                    </label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        value="<?= esc(old('price', $row->price ?? ($context['price'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                        aria-describedby="price-error"
                        aria-invalid="<?= isset($errors['price']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['price'])): ?>
                        <div id="price-error" class="invalid-feedback d-block">
                            <?= esc($errors['price']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="stock_quantity" class="form-label">
                        <?= esc(lang('Products.stock_quantity')) ?>
                    </label>
                    <input
                        type="number"
                        name="stock_quantity"
                        id="stock_quantity"
                        value="<?= esc(old('stock_quantity', $row->stock_quantity ?? ($context['stock_quantity'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['stock_quantity']) ? 'is-invalid' : '' ?>"
                        aria-describedby="stock_quantity-error"
                        aria-invalid="<?= isset($errors['stock_quantity']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['stock_quantity'])): ?>
                        <div id="stock_quantity-error" class="invalid-feedback d-block">
                            <?= esc($errors['stock_quantity']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="supplier_id" class="form-label">
                        <?= esc(lang('Products.supplier_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="supplier_id"
                        id="supplier_id"
                        value="<?= esc(old('supplier_id', $row->supplier_id ?? ($context['supplier_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['supplier_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="supplier_id-error"
                        aria-invalid="<?= isset($errors['supplier_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['supplier_id'])): ?>
                        <div id="supplier_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['supplier_id']) ?>
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

                    <a href="<?= site_url('products') ?>" class="btn btn-secondary">
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
