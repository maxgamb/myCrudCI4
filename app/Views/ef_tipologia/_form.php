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
                    <label for="pax" class="form-label">
                        <?= esc(lang('EfTipologia.pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="pax"
                        id="pax"
                        value="<?= esc(old('pax', $row->pax ?? ($context['pax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pax-error"
                        aria-invalid="<?= isset($errors['pax']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['pax'])): ?>
                        <div id="pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="4" class="form-label">
                        <?= esc(lang('EfTipologia.4')) ?>
                    </label>
                    <input
                        type="number"
                        name="4"
                        id="4"
                        value="<?= esc(old('4', $row->4 ?? ($context['4'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="4-error"
                        aria-invalid="<?= isset($errors['4']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['4'])): ?>
                        <div id="4-error" class="invalid-feedback d-block">
                            <?= esc($errors['4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="3" class="form-label">
                        <?= esc(lang('EfTipologia.3')) ?>
                    </label>
                    <input
                        type="number"
                        name="3"
                        id="3"
                        value="<?= esc(old('3', $row->3 ?? ($context['3'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="3-error"
                        aria-invalid="<?= isset($errors['3']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['3'])): ?>
                        <div id="3-error" class="invalid-feedback d-block">
                            <?= esc($errors['3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="2" class="form-label">
                        <?= esc(lang('EfTipologia.2')) ?>
                    </label>
                    <input
                        type="number"
                        name="2"
                        id="2"
                        value="<?= esc(old('2', $row->2 ?? ($context['2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="2-error"
                        aria-invalid="<?= isset($errors['2']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['2'])): ?>
                        <div id="2-error" class="invalid-feedback d-block">
                            <?= esc($errors['2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="1" class="form-label">
                        <?= esc(lang('EfTipologia.1')) ?>
                    </label>
                    <input
                        type="number"
                        name="1"
                        id="1"
                        value="<?= esc(old('1', $row->1 ?? ($context['1'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="1-error"
                        aria-invalid="<?= isset($errors['1']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['1'])): ?>
                        <div id="1-error" class="invalid-feedback d-block">
                            <?= esc($errors['1']) ?>
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

                    <a href="<?= site_url('ef_tipologia') ?>" class="btn btn-secondary">
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
