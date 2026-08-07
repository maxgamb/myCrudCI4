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
                    <label for="note_utente_rispondi_id" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_rispondi_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="note_utente_rispondi_id"
                        id="note_utente_rispondi_id"
                        value="<?= esc(old('note_utente_rispondi_id', $row->note_utente_rispondi_id ?? '')) ?>"
                        class="form-control <?= isset($errors['note_utente_rispondi_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_rispondi_id-error"
                        aria-invalid="<?= isset($errors['note_utente_rispondi_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['note_utente_rispondi_id'])): ?>
                        <div id="note_utente_rispondi_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_rispondi_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Utente_id" class="form-label">
                        <?= esc(lang('NoteUtente.Utente_id')) ?>
                    </label>
                    <select
                        name="Utente_id"
                        id="Utente_id"
                        class="form-select <?= isset($errors['Utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Utente_id-error"
                        aria-invalid="<?= isset($errors['Utente_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['Utente_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('Utente_id', $row->Utente_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['Utente_id'])): ?>
                        <div id="Utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['Utente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('NoteUtente.hotel_id')) ?>
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
                    <label for="reparto" class="form-label">
                        <?= esc(lang('NoteUtente.reparto')) ?>
                    </label>
                    <input
                        type="number"
                        name="reparto"
                        id="reparto"
                        value="<?= esc(old('reparto', $row->reparto ?? '')) ?>"
                        class="form-control <?= isset($errors['reparto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reparto-error"
                        aria-invalid="<?= isset($errors['reparto']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['reparto'])): ?>
                        <div id="reparto-error" class="invalid-feedback d-block">
                            <?= esc($errors['reparto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="titolo" class="form-label">
                        <?= esc(lang('NoteUtente.titolo')) ?>
                    </label>
                    <input
                        type="text"
                        name="titolo"
                        id="titolo"
                        value="<?= esc(old('titolo', $row->titolo ?? '')) ?>"
                        class="form-control <?= isset($errors['titolo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="titolo-error"
                        aria-invalid="<?= isset($errors['titolo']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['titolo'])): ?>
                        <div id="titolo-error" class="invalid-feedback d-block">
                            <?= esc($errors['titolo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note_utente_tex" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_tex')) ?>
                    </label>
                    <textarea
                        name="note_utente_tex"
                        id="note_utente_tex"
                        class="form-control <?= isset($errors['note_utente_tex']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_tex-error"
                        aria-invalid="<?= isset($errors['note_utente_tex']) ? 'true' : 'false' ?>"
                        required
                    ><?= esc(old('note_utente_tex', $row->note_utente_tex ?? '')) ?></textarea>
                    <?php if (!empty($errors['note_utente_tex'])): ?>
                        <div id="note_utente_tex-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_tex']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note_utente_per" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_per')) ?>
                    </label>
                    <input
                        type="number"
                        name="note_utente_per"
                        id="note_utente_per"
                        value="<?= esc(old('note_utente_per', $row->note_utente_per ?? '')) ?>"
                        class="form-control <?= isset($errors['note_utente_per']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_per-error"
                        aria-invalid="<?= isset($errors['note_utente_per']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['note_utente_per'])): ?>
                        <div id="note_utente_per-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_per']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note_utente_stato" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="note_utente_stato"
                        id="note_utente_stato"
                        value="<?= esc(old('note_utente_stato', $row->note_utente_stato ?? '')) ?>"
                        class="form-control <?= isset($errors['note_utente_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_stato-error"
                        aria-invalid="<?= isset($errors['note_utente_stato']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['note_utente_stato'])): ?>
                        <div id="note_utente_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note_utente_dal" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="note_utente_dal"
                        id="note_utente_dal"
                        value="<?= esc(old('note_utente_dal', $row->note_utente_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['note_utente_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_dal-error"
                        aria-invalid="<?= isset($errors['note_utente_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['note_utente_dal'])): ?>
                        <div id="note_utente_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note_utente_al" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="note_utente_al"
                        id="note_utente_al"
                        value="<?= esc(old('note_utente_al', $row->note_utente_al ?? '')) ?>"
                        class="form-control <?= isset($errors['note_utente_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_al-error"
                        aria-invalid="<?= isset($errors['note_utente_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['note_utente_al'])): ?>
                        <div id="note_utente_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note_utente_data" class="form-label">
                        <?= esc(lang('NoteUtente.note_utente_data')) ?>
                    </label>
                    <input
                        type="date"
                        name="note_utente_data"
                        id="note_utente_data"
                        value="<?= esc(old('note_utente_data', $row->note_utente_data ?? '')) ?>"
                        class="form-control <?= isset($errors['note_utente_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note_utente_data-error"
                        aria-invalid="<?= isset($errors['note_utente_data']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['note_utente_data'])): ?>
                        <div id="note_utente_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['note_utente_data']) ?>
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

                    <a href="<?= site_url('note_utente') ?>" class="btn btn-secondary">
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
