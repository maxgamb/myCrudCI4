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
                        <?= esc(lang('EfPriceTable.hotel_id')) ?>
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
                    <label for="from" class="form-label">
                        <?= esc(lang('EfPriceTable.from')) ?>
                    </label>
                    <input
                        type="date"
                        name="from"
                        id="from"
                        value="<?= esc(old('from', $row->from ?? ($context['from'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['from']) ? 'is-invalid' : '' ?>"
                        aria-describedby="from-error"
                        aria-invalid="<?= isset($errors['from']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['from'])): ?>
                        <div id="from-error" class="invalid-feedback d-block">
                            <?= esc($errors['from']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="to" class="form-label">
                        <?= esc(lang('EfPriceTable.to')) ?>
                    </label>
                    <input
                        type="date"
                        name="to"
                        id="to"
                        value="<?= esc(old('to', $row->to ?? ($context['to'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['to']) ? 'is-invalid' : '' ?>"
                        aria-describedby="to-error"
                        aria-invalid="<?= isset($errors['to']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['to'])): ?>
                        <div id="to-error" class="invalid-feedback d-block">
                            <?= esc($errors['to']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="single" class="form-label">
                        <?= esc(lang('EfPriceTable.single')) ?>
                    </label>
                    <input
                        type="number"
                        name="single"
                        id="single"
                        value="<?= esc(old('single', $row->single ?? ($context['single'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['single']) ? 'is-invalid' : '' ?>"
                        aria-describedby="single-error"
                        aria-invalid="<?= isset($errors['single']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['single'])): ?>
                        <div id="single-error" class="invalid-feedback d-block">
                            <?= esc($errors['single']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="single_plus" class="form-label">
                        <?= esc(lang('EfPriceTable.single_plus')) ?>
                    </label>
                    <input
                        type="number"
                        name="single_plus"
                        id="single_plus"
                        value="<?= esc(old('single_plus', $row->single_plus ?? ($context['single_plus'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['single_plus']) ? 'is-invalid' : '' ?>"
                        aria-describedby="single_plus-error"
                        aria-invalid="<?= isset($errors['single_plus']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['single_plus'])): ?>
                        <div id="single_plus-error" class="invalid-feedback d-block">
                            <?= esc($errors['single_plus']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tw_db" class="form-label">
                        <?= esc(lang('EfPriceTable.tw_db')) ?>
                    </label>
                    <input
                        type="number"
                        name="tw_db"
                        id="tw_db"
                        value="<?= esc(old('tw_db', $row->tw_db ?? ($context['tw_db'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tw_db']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tw_db-error"
                        aria-invalid="<?= isset($errors['tw_db']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tw_db'])): ?>
                        <div id="tw_db-error" class="invalid-feedback d-block">
                            <?= esc($errors['tw_db']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="student" class="form-label">
                        <?= esc(lang('EfPriceTable.student')) ?>
                    </label>
                    <input
                        type="number"
                        name="student"
                        id="student"
                        value="<?= esc(old('student', $row->student ?? ($context['student'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['student']) ? 'is-invalid' : '' ?>"
                        aria-describedby="student-error"
                        aria-invalid="<?= isset($errors['student']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['student'])): ?>
                        <div id="student-error" class="invalid-feedback d-block">
                            <?= esc($errors['student']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="fam_tr" class="form-label">
                        <?= esc(lang('EfPriceTable.fam_tr')) ?>
                    </label>
                    <input
                        type="number"
                        name="fam_tr"
                        id="fam_tr"
                        value="<?= esc(old('fam_tr', $row->fam_tr ?? ($context['fam_tr'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['fam_tr']) ? 'is-invalid' : '' ?>"
                        aria-describedby="fam_tr-error"
                        aria-invalid="<?= isset($errors['fam_tr']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['fam_tr'])): ?>
                        <div id="fam_tr-error" class="invalid-feedback d-block">
                            <?= esc($errors['fam_tr']) ?>
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

                    <a href="<?= site_url('ef_price_table') ?>" class="btn btn-secondary">
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
