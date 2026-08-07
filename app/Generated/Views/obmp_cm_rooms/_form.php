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
                    <label for="obmp_cm_id" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_id')) ?>
                    </label>
                    <select
                        name="obmp_cm_id"
                        id="obmp_cm_id"
                        class="form-select <?= isset($errors['obmp_cm_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_cm_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_cm_id', $row->obmp_cm_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_cm_id'])): ?>
                        <div id="obmp_cm_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpCmRooms.hotel_id')) ?>
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
                    <label for="obmp_cm_rooms_room_id" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_room_id"
                        id="obmp_cm_rooms_room_id"
                        value="<?= esc(old('obmp_cm_rooms_room_id', $row->obmp_cm_rooms_room_id ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_room_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_room_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_room_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_room_id'])): ?>
                        <div id="obmp_cm_rooms_room_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_room_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_attiva" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_attiva')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_attiva"
                        id="obmp_cm_rooms_attiva"
                        value="<?= esc(old('obmp_cm_rooms_attiva', $row->obmp_cm_rooms_attiva ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_attiva']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_attiva-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_attiva']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_attiva'])): ?>
                        <div id="obmp_cm_rooms_attiva-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_attiva']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_tipologia_id" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_tipologia_id')) ?>
                    </label>
                    <select
                        name="obmp_cm_rooms_tipologia_id"
                        id="obmp_cm_rooms_tipologia_id"
                        class="form-select <?= isset($errors['obmp_cm_rooms_tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_tipologia_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_tipologia_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_cm_rooms_tipologia_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_cm_rooms_tipologia_id', $row->obmp_cm_rooms_tipologia_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['obmp_cm_rooms_tipologia_id'])): ?>
                        <div id="obmp_cm_rooms_tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_room_note" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_room_note"
                        id="obmp_cm_rooms_room_note"
                        value="<?= esc(old('obmp_cm_rooms_room_note', $row->obmp_cm_rooms_room_note ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_room_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_room_note-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_room_note']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_room_note'])): ?>
                        <div id="obmp_cm_rooms_room_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_room_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_room_var_prezzo" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_var_prezzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_room_var_prezzo"
                        id="obmp_cm_rooms_room_var_prezzo"
                        value="<?= esc(old('obmp_cm_rooms_room_var_prezzo', $row->obmp_cm_rooms_room_var_prezzo ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_room_var_prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_room_var_prezzo-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_room_var_prezzo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_room_var_prezzo'])): ?>
                        <div id="obmp_cm_rooms_room_var_prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_room_var_prezzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_room_min_prezzo" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_min_prezzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_room_min_prezzo"
                        id="obmp_cm_rooms_room_min_prezzo"
                        value="<?= esc(old('obmp_cm_rooms_room_min_prezzo', $row->obmp_cm_rooms_room_min_prezzo ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_room_min_prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_room_min_prezzo-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_room_min_prezzo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_room_min_prezzo'])): ?>
                        <div id="obmp_cm_rooms_room_min_prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_room_min_prezzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_trattamento" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_trattamento')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_trattamento"
                        id="obmp_cm_rooms_trattamento"
                        value="<?= esc(old('obmp_cm_rooms_trattamento', $row->obmp_cm_rooms_trattamento ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_trattamento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_trattamento-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_trattamento']) ? 'true' : 'false' ?>"
                        maxlength="4"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_trattamento'])): ?>
                        <div id="obmp_cm_rooms_trattamento-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_trattamento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_max_pax" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_max_pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_max_pax"
                        id="obmp_cm_rooms_max_pax"
                        value="<?= esc(old('obmp_cm_rooms_max_pax', $row->obmp_cm_rooms_max_pax ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_max_pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_max_pax-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_max_pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_max_pax'])): ?>
                        <div id="obmp_cm_rooms_max_pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_max_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_max_room" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_max_room')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_max_room"
                        id="obmp_cm_rooms_max_room"
                        value="<?= esc(old('obmp_cm_rooms_max_room', $row->obmp_cm_rooms_max_room ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_max_room']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_max_room-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_max_room']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_max_room'])): ?>
                        <div id="obmp_cm_rooms_max_room-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_max_room']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_nesting" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_nesting')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_rooms_nesting"
                        id="obmp_cm_rooms_nesting"
                        value="<?= esc(old('obmp_cm_rooms_nesting', $row->obmp_cm_rooms_nesting ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_nesting']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_nesting-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_nesting']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_nesting'])): ?>
                        <div id="obmp_cm_rooms_nesting-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_nesting']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="citytax" class="form-label">
                        <?= esc(lang('ObmpCmRooms.citytax')) ?>
                    </label>
                    <input
                        type="number"
                        name="citytax"
                        id="citytax"
                        value="<?= esc(old('citytax', $row->citytax ?? '')) ?>"
                        class="form-control <?= isset($errors['citytax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="citytax-error"
                        aria-invalid="<?= isset($errors['citytax']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['citytax'])): ?>
                        <div id="citytax-error" class="invalid-feedback d-block">
                            <?= esc($errors['citytax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_foto" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_foto"
                        id="obmp_cm_rooms_foto"
                        value="<?= esc(old('obmp_cm_rooms_foto', $row->obmp_cm_rooms_foto ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_foto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_foto-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_foto']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_foto'])): ?>
                        <div id="obmp_cm_rooms_foto-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_foto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_foto150" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto150')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_foto150"
                        id="obmp_cm_rooms_foto150"
                        value="<?= esc(old('obmp_cm_rooms_foto150', $row->obmp_cm_rooms_foto150 ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_foto150']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_foto150-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_foto150']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_foto150'])): ?>
                        <div id="obmp_cm_rooms_foto150-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_foto150']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_foto270" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto270')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_foto270"
                        id="obmp_cm_rooms_foto270"
                        value="<?= esc(old('obmp_cm_rooms_foto270', $row->obmp_cm_rooms_foto270 ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_foto270']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_foto270-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_foto270']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_foto270'])): ?>
                        <div id="obmp_cm_rooms_foto270-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_foto270']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_foto700" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto700')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_foto700"
                        id="obmp_cm_rooms_foto700"
                        value="<?= esc(old('obmp_cm_rooms_foto700', $row->obmp_cm_rooms_foto700 ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_foto700']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_foto700-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_foto700']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_foto700'])): ?>
                        <div id="obmp_cm_rooms_foto700-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_foto700']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_rooms_utente_id" class="form-label">
                        <?= esc(lang('ObmpCmRooms.obmp_cm_rooms_utente_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_rooms_utente_id"
                        id="obmp_cm_rooms_utente_id"
                        value="<?= esc(old('obmp_cm_rooms_utente_id', $row->obmp_cm_rooms_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['obmp_cm_rooms_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_utente_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_utente_id']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['obmp_cm_rooms_utente_id'])): ?>
                        <div id="obmp_cm_rooms_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_utente_id']) ?>
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

                    <a href="<?= site_url('obmp_cm_rooms') ?>" class="btn btn-secondary">
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
