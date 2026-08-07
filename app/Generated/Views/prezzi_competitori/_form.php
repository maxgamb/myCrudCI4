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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('PrezziCompetitori.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_id-error"
                        aria-invalid="<?= isset($errors['hotel_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_prezzo" class="form-label">
                        <?= esc(lang('PrezziCompetitori.data_prezzo')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_prezzo"
                        id="data_prezzo"
                        value="<?= esc(old('data_prezzo', $row->data_prezzo ?? '')) ?>"
                        class="form-control <?= isset($errors['data_prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_prezzo-error"
                        aria-invalid="<?= isset($errors['data_prezzo']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['data_prezzo'])): ?>
                        <div id="data_prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_prezzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="percentile_10" class="form-label">
                        <?= esc(lang('PrezziCompetitori.percentile_10')) ?>
                    </label>
                    <input
                        type="number"
                        name="percentile_10"
                        id="percentile_10"
                        value="<?= esc(old('percentile_10', $row->percentile_10 ?? '')) ?>"
                        class="form-control <?= isset($errors['percentile_10']) ? 'is-invalid' : '' ?>"
                        aria-describedby="percentile_10-error"
                        aria-invalid="<?= isset($errors['percentile_10']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['percentile_10'])): ?>
                        <div id="percentile_10-error" class="invalid-feedback d-block">
                            <?= esc($errors['percentile_10']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="percentile_25" class="form-label">
                        <?= esc(lang('PrezziCompetitori.percentile_25')) ?>
                    </label>
                    <input
                        type="number"
                        name="percentile_25"
                        id="percentile_25"
                        value="<?= esc(old('percentile_25', $row->percentile_25 ?? '')) ?>"
                        class="form-control <?= isset($errors['percentile_25']) ? 'is-invalid' : '' ?>"
                        aria-describedby="percentile_25-error"
                        aria-invalid="<?= isset($errors['percentile_25']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['percentile_25'])): ?>
                        <div id="percentile_25-error" class="invalid-feedback d-block">
                            <?= esc($errors['percentile_25']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="percentile_50" class="form-label">
                        <?= esc(lang('PrezziCompetitori.percentile_50')) ?>
                    </label>
                    <input
                        type="number"
                        name="percentile_50"
                        id="percentile_50"
                        value="<?= esc(old('percentile_50', $row->percentile_50 ?? '')) ?>"
                        class="form-control <?= isset($errors['percentile_50']) ? 'is-invalid' : '' ?>"
                        aria-describedby="percentile_50-error"
                        aria-invalid="<?= isset($errors['percentile_50']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['percentile_50'])): ?>
                        <div id="percentile_50-error" class="invalid-feedback d-block">
                            <?= esc($errors['percentile_50']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="percentile_75" class="form-label">
                        <?= esc(lang('PrezziCompetitori.percentile_75')) ?>
                    </label>
                    <input
                        type="number"
                        name="percentile_75"
                        id="percentile_75"
                        value="<?= esc(old('percentile_75', $row->percentile_75 ?? '')) ?>"
                        class="form-control <?= isset($errors['percentile_75']) ? 'is-invalid' : '' ?>"
                        aria-describedby="percentile_75-error"
                        aria-invalid="<?= isset($errors['percentile_75']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['percentile_75'])): ?>
                        <div id="percentile_75-error" class="invalid-feedback d-block">
                            <?= esc($errors['percentile_75']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="percentile_90" class="form-label">
                        <?= esc(lang('PrezziCompetitori.percentile_90')) ?>
                    </label>
                    <input
                        type="number"
                        name="percentile_90"
                        id="percentile_90"
                        value="<?= esc(old('percentile_90', $row->percentile_90 ?? '')) ?>"
                        class="form-control <?= isset($errors['percentile_90']) ? 'is-invalid' : '' ?>"
                        aria-describedby="percentile_90-error"
                        aria-invalid="<?= isset($errors['percentile_90']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['percentile_90'])): ?>
                        <div id="percentile_90-error" class="invalid-feedback d-block">
                            <?= esc($errors['percentile_90']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="indice_disponibilita" class="form-label">
                        <?= esc(lang('PrezziCompetitori.indice_disponibilita')) ?>
                    </label>
                    <input
                        type="number"
                        name="indice_disponibilita"
                        id="indice_disponibilita"
                        value="<?= esc(old('indice_disponibilita', $row->indice_disponibilita ?? '')) ?>"
                        class="form-control <?= isset($errors['indice_disponibilita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="indice_disponibilita-error"
                        aria-invalid="<?= isset($errors['indice_disponibilita']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['indice_disponibilita'])): ?>
                        <div id="indice_disponibilita-error" class="invalid-feedback d-block">
                            <?= esc($errors['indice_disponibilita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_acuisizione" class="form-label">
                        <?= esc(lang('PrezziCompetitori.data_acuisizione')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_acuisizione"
                        id="data_acuisizione"
                        value="<?= esc(old('data_acuisizione', $row->data_acuisizione ?? '')) ?>"
                        class="form-control <?= isset($errors['data_acuisizione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_acuisizione-error"
                        aria-invalid="<?= isset($errors['data_acuisizione']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['data_acuisizione'])): ?>
                        <div id="data_acuisizione-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_acuisizione']) ?>
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

                    <a href="<?= site_url('prezzi_competitori') ?>" class="btn btn-secondary">
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
