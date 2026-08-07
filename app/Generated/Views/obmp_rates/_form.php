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
                    <label for="obmp_cm_rooms_id" class="form-label">
                        <?= esc(lang('ObmpRates.obmp_cm_rooms_id')) ?>
                    </label>
                    <select
                        name="obmp_cm_rooms_id"
                        id="obmp_cm_rooms_id"
                        class="form-select <?= isset($errors['obmp_cm_rooms_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_cm_rooms_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_cm_rooms_id', $row->obmp_cm_rooms_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_cm_rooms_id'])): ?>
                        <div id="obmp_cm_rooms_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_restriction_id" class="form-label">
                        <?= esc(lang('ObmpRates.obmp_restriction_id')) ?>
                    </label>
                    <select
                        name="obmp_restriction_id"
                        id="obmp_restriction_id"
                        class="form-select <?= isset($errors['obmp_restriction_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_restriction_id-error"
                        aria-invalid="<?= isset($errors['obmp_restriction_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_restriction_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_restriction_id', $row->obmp_restriction_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_restriction_id'])): ?>
                        <div id="obmp_restriction_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_restriction_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpRates.hotel_id')) ?>
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
                    <label for="obmp_board_cod" class="form-label">
                        <?= esc(lang('ObmpRates.obmp_board_cod')) ?>
                    </label>
                    <select
                        name="obmp_board_cod"
                        id="obmp_board_cod"
                        class="form-select <?= isset($errors['obmp_board_cod']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_board_cod-error"
                        aria-invalid="<?= isset($errors['obmp_board_cod']) ? 'true' : 'false' ?>"
                        maxlength="6"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_board_cod'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_board_cod', $row->obmp_board_cod ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_board_cod'])): ?>
                        <div id="obmp_board_cod-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_board_cod']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cancellation_cod" class="form-label">
                        <?= esc(lang('ObmpRates.obmp_cancellation_cod')) ?>
                    </label>
                    <select
                        name="obmp_cancellation_cod"
                        id="obmp_cancellation_cod"
                        class="form-select <?= isset($errors['obmp_cancellation_cod']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cancellation_cod-error"
                        aria-invalid="<?= isset($errors['obmp_cancellation_cod']) ? 'true' : 'false' ?>"
                        maxlength="6"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_cancellation_cod'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_cancellation_cod', $row->obmp_cancellation_cod ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_cancellation_cod'])): ?>
                        <div id="obmp_cancellation_cod-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cancellation_cod']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_payment_cod" class="form-label">
                        <?= esc(lang('ObmpRates.obmp_payment_cod')) ?>
                    </label>
                    <select
                        name="obmp_payment_cod"
                        id="obmp_payment_cod"
                        class="form-select <?= isset($errors['obmp_payment_cod']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_payment_cod-error"
                        aria-invalid="<?= isset($errors['obmp_payment_cod']) ? 'true' : 'false' ?>"
                        maxlength="6"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_payment_cod'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_payment_cod', $row->obmp_payment_cod ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_payment_cod'])): ?>
                        <div id="obmp_payment_cod-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_payment_cod']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="rate_sum" class="form-label">
                        <?= esc(lang('ObmpRates.rate_sum')) ?>
                    </label>
                    <input
                        type="number"
                        name="rate_sum"
                        id="rate_sum"
                        value="<?= esc(old('rate_sum', $row->rate_sum ?? '')) ?>"
                        class="form-control <?= isset($errors['rate_sum']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rate_sum-error"
                        aria-invalid="<?= isset($errors['rate_sum']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['rate_sum'])): ?>
                        <div id="rate_sum-error" class="invalid-feedback d-block">
                            <?= esc($errors['rate_sum']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="rate_mol" class="form-label">
                        <?= esc(lang('ObmpRates.rate_mol')) ?>
                    </label>
                    <input
                        type="number"
                        name="rate_mol"
                        id="rate_mol"
                        value="<?= esc(old('rate_mol', $row->rate_mol ?? '')) ?>"
                        class="form-control <?= isset($errors['rate_mol']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rate_mol-error"
                        aria-invalid="<?= isset($errors['rate_mol']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['rate_mol'])): ?>
                        <div id="rate_mol-error" class="invalid-feedback d-block">
                            <?= esc($errors['rate_mol']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="rate_stato" class="form-label">
                        <?= esc(lang('ObmpRates.rate_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="rate_stato"
                        id="rate_stato"
                        value="<?= esc(old('rate_stato', $row->rate_stato ?? '')) ?>"
                        class="form-control <?= isset($errors['rate_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rate_stato-error"
                        aria-invalid="<?= isset($errors['rate_stato']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['rate_stato'])): ?>
                        <div id="rate_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['rate_stato']) ?>
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

                    <a href="<?= site_url('obmp_rates') ?>" class="btn btn-secondary">
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
