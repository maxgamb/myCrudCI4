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
                    <label for="prodotti_lista_id" class="form-label">
                        <?= esc(lang('Prodotti.prodotti_lista_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="prodotti_lista_id"
                        id="prodotti_lista_id"
                        value="<?= esc(old('prodotti_lista_id', $row->prodotti_lista_id ?? '')) ?>"
                        class="form-control <?= isset($errors['prodotti_lista_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prodotti_lista_id-error"
                        aria-invalid="<?= isset($errors['prodotti_lista_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['prodotti_lista_id'])): ?>
                        <div id="prodotti_lista_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['prodotti_lista_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Prodotti.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_id-error"
                        aria-invalid="<?= isset($errors['hotel_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_prodotto" class="form-label">
                        <?= esc(lang('Prodotti.nome_prodotto')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_prodotto"
                        id="nome_prodotto"
                        value="<?= esc(old('nome_prodotto', $row->nome_prodotto ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_prodotto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_prodotto-error"
                        aria-invalid="<?= isset($errors['nome_prodotto']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nome_prodotto'])): ?>
                        <div id="nome_prodotto-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_prodotto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzo_prodotto" class="form-label">
                        <?= esc(lang('Prodotti.prezzo_prodotto')) ?>
                    </label>
                    <input
                        type="number"
                        name="prezzo_prodotto"
                        id="prezzo_prodotto"
                        value="<?= esc(old('prezzo_prodotto', $row->prezzo_prodotto ?? '')) ?>"
                        class="form-control <?= isset($errors['prezzo_prodotto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzo_prodotto-error"
                        aria-invalid="<?= isset($errors['prezzo_prodotto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prezzo_prodotto'])): ?>
                        <div id="prezzo_prodotto-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzo_prodotto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_prodotto" class="form-label">
                        <?= esc(lang('Prodotti.tipologia_prodotto')) ?>
                    </label>
                    <input
                        type="text"
                        name="tipologia_prodotto"
                        id="tipologia_prodotto"
                        value="<?= esc(old('tipologia_prodotto', $row->tipologia_prodotto ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_prodotto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_prodotto-error"
                        aria-invalid="<?= isset($errors['tipologia_prodotto']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['tipologia_prodotto'])): ?>
                        <div id="tipologia_prodotto-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_prodotto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="reparto_prodotto" class="form-label">
                        <?= esc(lang('Prodotti.reparto_prodotto')) ?>
                    </label>
                    <input
                        type="text"
                        name="reparto_prodotto"
                        id="reparto_prodotto"
                        value="<?= esc(old('reparto_prodotto', $row->reparto_prodotto ?? '')) ?>"
                        class="form-control <?= isset($errors['reparto_prodotto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reparto_prodotto-error"
                        aria-invalid="<?= isset($errors['reparto_prodotto']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['reparto_prodotto'])): ?>
                        <div id="reparto_prodotto-error" class="invalid-feedback d-block">
                            <?= esc($errors['reparto_prodotto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cent_costo_prodotto" class="form-label">
                        <?= esc(lang('Prodotti.cent_costo_prodotto')) ?>
                    </label>
                    <input
                        type="number"
                        name="cent_costo_prodotto"
                        id="cent_costo_prodotto"
                        value="<?= esc(old('cent_costo_prodotto', $row->cent_costo_prodotto ?? '')) ?>"
                        class="form-control <?= isset($errors['cent_costo_prodotto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cent_costo_prodotto-error"
                        aria-invalid="<?= isset($errors['cent_costo_prodotto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['cent_costo_prodotto'])): ?>
                        <div id="cent_costo_prodotto-error" class="invalid-feedback d-block">
                            <?= esc($errors['cent_costo_prodotto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prodotti_utente_id" class="form-label">
                        <?= esc(lang('Prodotti.prodotti_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="prodotti_utente_id"
                        id="prodotti_utente_id"
                        value="<?= esc(old('prodotti_utente_id', $row->prodotti_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['prodotti_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prodotti_utente_id-error"
                        aria-invalid="<?= isset($errors['prodotti_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prodotti_utente_id'])): ?>
                        <div id="prodotti_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['prodotti_utente_id']) ?>
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

                    <a href="<?= site_url('prodotti') ?>" class="btn btn-secondary">
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
