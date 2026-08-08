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
                    <label for="prod_lista_mone" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_mone')) ?>
                    </label>
                    <input
                        type="text"
                        name="prod_lista_mone"
                        id="prod_lista_mone"
                        value="<?= esc(old('prod_lista_mone', $row->prod_lista_mone ?? ($context['prod_lista_mone'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_mone']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_mone-error"
                        aria-invalid="<?= isset($errors['prod_lista_mone']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['prod_lista_mone'])): ?>
                        <div id="prod_lista_mone-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_mone']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prod_lista_descrixione" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_descrixione')) ?>
                    </label>
                    <input
                        type="text"
                        name="prod_lista_descrixione"
                        id="prod_lista_descrixione"
                        value="<?= esc(old('prod_lista_descrixione', $row->prod_lista_descrixione ?? ($context['prod_lista_descrixione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_descrixione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_descrixione-error"
                        aria-invalid="<?= isset($errors['prod_lista_descrixione']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['prod_lista_descrixione'])): ?>
                        <div id="prod_lista_descrixione-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_descrixione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prod_lista_allergenici" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_allergenici')) ?>
                    </label>
                    <input
                        type="text"
                        name="prod_lista_allergenici"
                        id="prod_lista_allergenici"
                        value="<?= esc(old('prod_lista_allergenici', $row->prod_lista_allergenici ?? ($context['prod_lista_allergenici'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_allergenici']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_allergenici-error"
                        aria-invalid="<?= isset($errors['prod_lista_allergenici']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['prod_lista_allergenici'])): ?>
                        <div id="prod_lista_allergenici-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_allergenici']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prod_lista_costo_unitario" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_costo_unitario')) ?>
                    </label>
                    <input
                        type="number"
                        name="prod_lista_costo_unitario"
                        id="prod_lista_costo_unitario"
                        value="<?= esc(old('prod_lista_costo_unitario', $row->prod_lista_costo_unitario ?? ($context['prod_lista_costo_unitario'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_costo_unitario']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_costo_unitario-error"
                        aria-invalid="<?= isset($errors['prod_lista_costo_unitario']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prod_lista_costo_unitario'])): ?>
                        <div id="prod_lista_costo_unitario-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_costo_unitario']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prod_lista_img" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_img')) ?>
                    </label>
                    <input
                        type="text"
                        name="prod_lista_img"
                        id="prod_lista_img"
                        value="<?= esc(old('prod_lista_img', $row->prod_lista_img ?? ($context['prod_lista_img'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_img']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_img-error"
                        aria-invalid="<?= isset($errors['prod_lista_img']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['prod_lista_img'])): ?>
                        <div id="prod_lista_img-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_img']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prod_lista_data" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_data')) ?>
                    </label>
                    <input
                        type="date"
                        name="prod_lista_data"
                        id="prod_lista_data"
                        value="<?= esc(old('prod_lista_data', $row->prod_lista_data ?? ($context['prod_lista_data'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_data-error"
                        aria-invalid="<?= isset($errors['prod_lista_data']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prod_lista_data'])): ?>
                        <div id="prod_lista_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prod_lista_user_id" class="form-label">
                        <?= esc(lang('ProdottiLista.prod_lista_user_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="prod_lista_user_id"
                        id="prod_lista_user_id"
                        value="<?= esc(old('prod_lista_user_id', $row->prod_lista_user_id ?? ($context['prod_lista_user_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prod_lista_user_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prod_lista_user_id-error"
                        aria-invalid="<?= isset($errors['prod_lista_user_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prod_lista_user_id'])): ?>
                        <div id="prod_lista_user_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['prod_lista_user_id']) ?>
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

                    <a href="<?= site_url('prodotti_lista') ?>" class="btn btn-secondary">
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
