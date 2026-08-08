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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Prezzi.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
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
                    <label for="conto_id" class="form-label">
                        <?= esc(lang('Prezzi.conto_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="conto_id"
                        id="conto_id"
                        value="<?= esc(old('conto_id', $row->conto_id ?? ($context['conto_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conto_id-error"
                        aria-invalid="<?= isset($errors['conto_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['conto_id'])): ?>
                        <div id="conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzo_dal" class="form-label">
                        <?= esc(lang('Prezzi.prezzo_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="prezzo_dal"
                        id="prezzo_dal"
                        value="<?= esc(old('prezzo_dal', $row->prezzo_dal ?? ($context['prezzo_dal'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prezzo_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzo_dal-error"
                        aria-invalid="<?= isset($errors['prezzo_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['prezzo_dal'])): ?>
                        <div id="prezzo_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzo_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzo_al" class="form-label">
                        <?= esc(lang('Prezzi.prezzo_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="prezzo_al"
                        id="prezzo_al"
                        value="<?= esc(old('prezzo_al', $row->prezzo_al ?? ($context['prezzo_al'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prezzo_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzo_al-error"
                        aria-invalid="<?= isset($errors['prezzo_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['prezzo_al'])): ?>
                        <div id="prezzo_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzo_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzo_valore" class="form-label">
                        <?= esc(lang('Prezzi.prezzo_valore')) ?>
                    </label>
                    <input
                        type="number"
                        name="prezzo_valore"
                        id="prezzo_valore"
                        value="<?= esc(old('prezzo_valore', $row->prezzo_valore ?? ($context['prezzo_valore'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prezzo_valore']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzo_valore-error"
                        aria-invalid="<?= isset($errors['prezzo_valore']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prezzo_valore'])): ?>
                        <div id="prezzo_valore-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzo_valore']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="libero" class="form-label">
                        <?= esc(lang('Prezzi.libero')) ?>
                    </label>
                    <input
                        type="text"
                        name="libero"
                        id="libero"
                        value="<?= esc(old('libero', $row->libero ?? ($context['libero'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['libero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="libero-error"
                        aria-invalid="<?= isset($errors['libero']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['libero'])): ?>
                        <div id="libero-error" class="invalid-feedback d-block">
                            <?= esc($errors['libero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzi_utente_id" class="form-label">
                        <?= esc(lang('Prezzi.prezzi_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="prezzi_utente_id"
                        id="prezzi_utente_id"
                        value="<?= esc(old('prezzi_utente_id', $row->prezzi_utente_id ?? ($context['prezzi_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['prezzi_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzi_utente_id-error"
                        aria-invalid="<?= isset($errors['prezzi_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prezzi_utente_id'])): ?>
                        <div id="prezzi_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzi_utente_id']) ?>
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

                    <a href="<?= site_url('prezzi') ?>" class="btn btn-secondary">
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
