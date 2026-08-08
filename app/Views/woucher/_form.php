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
                    <label for="woucher_agenzia_id" class="form-label">
                        <?= esc(lang('Woucher.woucher_agenzia_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_agenzia_id"
                        id="woucher_agenzia_id"
                        value="<?= esc(old('woucher_agenzia_id', $row->woucher_agenzia_id ?? ($context['woucher_agenzia_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_agenzia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_agenzia_id-error"
                        aria-invalid="<?= isset($errors['woucher_agenzia_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_agenzia_id'])): ?>
                        <div id="woucher_agenzia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_agenzia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_preno_id" class="form-label">
                        <?= esc(lang('Woucher.woucher_preno_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_preno_id"
                        id="woucher_preno_id"
                        value="<?= esc(old('woucher_preno_id', $row->woucher_preno_id ?? ($context['woucher_preno_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_preno_id-error"
                        aria-invalid="<?= isset($errors['woucher_preno_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_preno_id'])): ?>
                        <div id="woucher_preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_hotel_id" class="form-label">
                        <?= esc(lang('Woucher.woucher_hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_hotel_id"
                        id="woucher_hotel_id"
                        value="<?= esc(old('woucher_hotel_id', $row->woucher_hotel_id ?? ($context['woucher_hotel_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_hotel_id-error"
                        aria-invalid="<?= isset($errors['woucher_hotel_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_hotel_id'])): ?>
                        <div id="woucher_hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_in" class="form-label">
                        <?= esc(lang('Woucher.woucher_in')) ?>
                    </label>
                    <input
                        type="date"
                        name="woucher_in"
                        id="woucher_in"
                        value="<?= esc(old('woucher_in', $row->woucher_in ?? ($context['woucher_in'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_in']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_in-error"
                        aria-invalid="<?= isset($errors['woucher_in']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['woucher_in'])): ?>
                        <div id="woucher_in-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_in']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_notti" class="form-label">
                        <?= esc(lang('Woucher.woucher_notti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_notti"
                        id="woucher_notti"
                        value="<?= esc(old('woucher_notti', $row->woucher_notti ?? ($context['woucher_notti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_notti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_notti-error"
                        aria-invalid="<?= isset($errors['woucher_notti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_notti'])): ?>
                        <div id="woucher_notti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_notti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_out" class="form-label">
                        <?= esc(lang('Woucher.woucher_out')) ?>
                    </label>
                    <input
                        type="date"
                        name="woucher_out"
                        id="woucher_out"
                        value="<?= esc(old('woucher_out', $row->woucher_out ?? ($context['woucher_out'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_out']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_out-error"
                        aria-invalid="<?= isset($errors['woucher_out']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['woucher_out'])): ?>
                        <div id="woucher_out-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_out']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_numero" class="form-label">
                        <?= esc(lang('Woucher.woucher_numero')) ?>
                    </label>
                    <input
                        type="text"
                        name="woucher_numero"
                        id="woucher_numero"
                        value="<?= esc(old('woucher_numero', $row->woucher_numero ?? ($context['woucher_numero'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_numero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_numero-error"
                        aria-invalid="<?= isset($errors['woucher_numero']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['woucher_numero'])): ?>
                        <div id="woucher_numero-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_numero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_serie" class="form-label">
                        <?= esc(lang('Woucher.woucher_serie')) ?>
                    </label>
                    <input
                        type="text"
                        name="woucher_serie"
                        id="woucher_serie"
                        value="<?= esc(old('woucher_serie', $row->woucher_serie ?? ($context['woucher_serie'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_serie']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_serie-error"
                        aria-invalid="<?= isset($errors['woucher_serie']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['woucher_serie'])): ?>
                        <div id="woucher_serie-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_serie']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_singole" class="form-label">
                        <?= esc(lang('Woucher.woucher_singole')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_singole"
                        id="woucher_singole"
                        value="<?= esc(old('woucher_singole', $row->woucher_singole ?? ($context['woucher_singole'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_singole']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_singole-error"
                        aria-invalid="<?= isset($errors['woucher_singole']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_singole'])): ?>
                        <div id="woucher_singole-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_singole']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_singole_staff" class="form-label">
                        <?= esc(lang('Woucher.woucher_singole_staff')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_singole_staff"
                        id="woucher_singole_staff"
                        value="<?= esc(old('woucher_singole_staff', $row->woucher_singole_staff ?? ($context['woucher_singole_staff'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_singole_staff']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_singole_staff-error"
                        aria-invalid="<?= isset($errors['woucher_singole_staff']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_singole_staff'])): ?>
                        <div id="woucher_singole_staff-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_singole_staff']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_doppia" class="form-label">
                        <?= esc(lang('Woucher.woucher_doppia')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_doppia"
                        id="woucher_doppia"
                        value="<?= esc(old('woucher_doppia', $row->woucher_doppia ?? ($context['woucher_doppia'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_doppia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_doppia-error"
                        aria-invalid="<?= isset($errors['woucher_doppia']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_doppia'])): ?>
                        <div id="woucher_doppia-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_doppia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_tripla" class="form-label">
                        <?= esc(lang('Woucher.woucher_tripla')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_tripla"
                        id="woucher_tripla"
                        value="<?= esc(old('woucher_tripla', $row->woucher_tripla ?? ($context['woucher_tripla'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_tripla']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_tripla-error"
                        aria-invalid="<?= isset($errors['woucher_tripla']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_tripla'])): ?>
                        <div id="woucher_tripla-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_tripla']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_quadrupla" class="form-label">
                        <?= esc(lang('Woucher.woucher_quadrupla')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_quadrupla"
                        id="woucher_quadrupla"
                        value="<?= esc(old('woucher_quadrupla', $row->woucher_quadrupla ?? ($context['woucher_quadrupla'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_quadrupla']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_quadrupla-error"
                        aria-invalid="<?= isset($errors['woucher_quadrupla']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_quadrupla'])): ?>
                        <div id="woucher_quadrupla-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_quadrupla']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_cildren_n" class="form-label">
                        <?= esc(lang('Woucher.woucher_cildren_n')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_cildren_n"
                        id="woucher_cildren_n"
                        value="<?= esc(old('woucher_cildren_n', $row->woucher_cildren_n ?? ($context['woucher_cildren_n'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_cildren_n']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_cildren_n-error"
                        aria-invalid="<?= isset($errors['woucher_cildren_n']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_cildren_n'])): ?>
                        <div id="woucher_cildren_n-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_cildren_n']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_doppia_studenti" class="form-label">
                        <?= esc(lang('Woucher.woucher_doppia_studenti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_doppia_studenti"
                        id="woucher_doppia_studenti"
                        value="<?= esc(old('woucher_doppia_studenti', $row->woucher_doppia_studenti ?? ($context['woucher_doppia_studenti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_doppia_studenti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_doppia_studenti-error"
                        aria-invalid="<?= isset($errors['woucher_doppia_studenti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_doppia_studenti'])): ?>
                        <div id="woucher_doppia_studenti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_doppia_studenti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_tripla_studenti" class="form-label">
                        <?= esc(lang('Woucher.woucher_tripla_studenti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_tripla_studenti"
                        id="woucher_tripla_studenti"
                        value="<?= esc(old('woucher_tripla_studenti', $row->woucher_tripla_studenti ?? ($context['woucher_tripla_studenti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_tripla_studenti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_tripla_studenti-error"
                        aria-invalid="<?= isset($errors['woucher_tripla_studenti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_tripla_studenti'])): ?>
                        <div id="woucher_tripla_studenti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_tripla_studenti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_quadrupla_studenti" class="form-label">
                        <?= esc(lang('Woucher.woucher_quadrupla_studenti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_quadrupla_studenti"
                        id="woucher_quadrupla_studenti"
                        value="<?= esc(old('woucher_quadrupla_studenti', $row->woucher_quadrupla_studenti ?? ($context['woucher_quadrupla_studenti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_quadrupla_studenti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_quadrupla_studenti-error"
                        aria-invalid="<?= isset($errors['woucher_quadrupla_studenti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_quadrupla_studenti'])): ?>
                        <div id="woucher_quadrupla_studenti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_quadrupla_studenti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_quintupla_studenti" class="form-label">
                        <?= esc(lang('Woucher.woucher_quintupla_studenti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_quintupla_studenti"
                        id="woucher_quintupla_studenti"
                        value="<?= esc(old('woucher_quintupla_studenti', $row->woucher_quintupla_studenti ?? ($context['woucher_quintupla_studenti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_quintupla_studenti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_quintupla_studenti-error"
                        aria-invalid="<?= isset($errors['woucher_quintupla_studenti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_quintupla_studenti'])): ?>
                        <div id="woucher_quintupla_studenti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_quintupla_studenti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_tot_pax" class="form-label">
                        <?= esc(lang('Woucher.woucher_tot_pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_tot_pax"
                        id="woucher_tot_pax"
                        value="<?= esc(old('woucher_tot_pax', $row->woucher_tot_pax ?? ($context['woucher_tot_pax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_tot_pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_tot_pax-error"
                        aria-invalid="<?= isset($errors['woucher_tot_pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_tot_pax'])): ?>
                        <div id="woucher_tot_pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_tot_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_tot_adulti" class="form-label">
                        <?= esc(lang('Woucher.woucher_tot_adulti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_tot_adulti"
                        id="woucher_tot_adulti"
                        value="<?= esc(old('woucher_tot_adulti', $row->woucher_tot_adulti ?? ($context['woucher_tot_adulti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_tot_adulti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_tot_adulti-error"
                        aria-invalid="<?= isset($errors['woucher_tot_adulti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_tot_adulti'])): ?>
                        <div id="woucher_tot_adulti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_tot_adulti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_tot_studenti" class="form-label">
                        <?= esc(lang('Woucher.woucher_tot_studenti')) ?>
                    </label>
                    <input
                        type="number"
                        name="woucher_tot_studenti"
                        id="woucher_tot_studenti"
                        value="<?= esc(old('woucher_tot_studenti', $row->woucher_tot_studenti ?? ($context['woucher_tot_studenti'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_tot_studenti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_tot_studenti-error"
                        aria-invalid="<?= isset($errors['woucher_tot_studenti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_tot_studenti'])): ?>
                        <div id="woucher_tot_studenti-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_tot_studenti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="woucher_note" class="form-label">
                        <?= esc(lang('Woucher.woucher_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="woucher_note"
                        id="woucher_note"
                        value="<?= esc(old('woucher_note', $row->woucher_note ?? ($context['woucher_note'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['woucher_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="woucher_note-error"
                        aria-invalid="<?= isset($errors['woucher_note']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['woucher_note'])): ?>
                        <div id="woucher_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['woucher_note']) ?>
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

                    <a href="<?= site_url('woucher') ?>" class="btn btn-secondary">
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
