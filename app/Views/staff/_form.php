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
                    <label for="cognome" class="form-label">
                        <?= esc(lang('Staff.cognome')) ?>
                    </label>
                    <input
                        type="text"
                        name="cognome"
                        id="cognome"
                        value="<?= esc(old('cognome', $row->cognome ?? '')) ?>"
                        class="form-control <?= isset($errors['cognome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cognome-error"
                        aria-invalid="<?= isset($errors['cognome']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['cognome'])): ?>
                        <div id="cognome-error" class="invalid-feedback d-block">
                            <?= esc($errors['cognome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome" class="form-label">
                        <?= esc(lang('Staff.nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome"
                        id="nome"
                        value="<?= esc(old('nome', $row->nome ?? '')) ?>"
                        class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome-error"
                        aria-invalid="<?= isset($errors['nome']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['nome'])): ?>
                        <div id="nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="citta" class="form-label">
                        <?= esc(lang('Staff.citta')) ?>
                    </label>
                    <input
                        type="text"
                        name="citta"
                        id="citta"
                        value="<?= esc(old('citta', $row->citta ?? '')) ?>"
                        class="form-control <?= isset($errors['citta']) ? 'is-invalid' : '' ?>"
                        aria-describedby="citta-error"
                        aria-invalid="<?= isset($errors['citta']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['citta'])): ?>
                        <div id="citta-error" class="invalid-feedback d-block">
                            <?= esc($errors['citta']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="provincia" class="form-label">
                        <?= esc(lang('Staff.provincia')) ?>
                    </label>
                    <input
                        type="text"
                        name="provincia"
                        id="provincia"
                        value="<?= esc(old('provincia', $row->provincia ?? '')) ?>"
                        class="form-control <?= isset($errors['provincia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="provincia-error"
                        aria-invalid="<?= isset($errors['provincia']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['provincia'])): ?>
                        <div id="provincia-error" class="invalid-feedback d-block">
                            <?= esc($errors['provincia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="staff_nazione" class="form-label">
                        <?= esc(lang('Staff.staff_nazione')) ?>
                    </label>
                    <input
                        type="text"
                        name="staff_nazione"
                        id="staff_nazione"
                        value="<?= esc(old('staff_nazione', $row->staff_nazione ?? '')) ?>"
                        class="form-control <?= isset($errors['staff_nazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="staff_nazione-error"
                        aria-invalid="<?= isset($errors['staff_nazione']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['staff_nazione'])): ?>
                        <div id="staff_nazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['staff_nazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="indirizzo" class="form-label">
                        <?= esc(lang('Staff.indirizzo')) ?>
                    </label>
                    <input
                        type="text"
                        name="indirizzo"
                        id="indirizzo"
                        value="<?= esc(old('indirizzo', $row->indirizzo ?? '')) ?>"
                        class="form-control <?= isset($errors['indirizzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="indirizzo-error"
                        aria-invalid="<?= isset($errors['indirizzo']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['indirizzo'])): ?>
                        <div id="indirizzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['indirizzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">
                        <?= esc(lang('Staff.telefono')) ?>
                    </label>
                    <input
                        type="text"
                        name="telefono"
                        id="telefono"
                        value="<?= esc(old('telefono', $row->telefono ?? '')) ?>"
                        class="form-control <?= isset($errors['telefono']) ? 'is-invalid' : '' ?>"
                        aria-describedby="telefono-error"
                        aria-invalid="<?= isset($errors['telefono']) ? 'true' : 'false' ?>"
                        required maxlength="40"
                    >
                    <?php if (!empty($errors['telefono'])): ?>
                        <div id="telefono-error" class="invalid-feedback d-block">
                            <?= esc($errors['telefono']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cellulare" class="form-label">
                        <?= esc(lang('Staff.cellulare')) ?>
                    </label>
                    <input
                        type="text"
                        name="cellulare"
                        id="cellulare"
                        value="<?= esc(old('cellulare', $row->cellulare ?? '')) ?>"
                        class="form-control <?= isset($errors['cellulare']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cellulare-error"
                        aria-invalid="<?= isset($errors['cellulare']) ? 'true' : 'false' ?>"
                        required maxlength="40"
                    >
                    <?php if (!empty($errors['cellulare'])): ?>
                        <div id="cellulare-error" class="invalid-feedback d-block">
                            <?= esc($errors['cellulare']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <?= esc(lang('Staff.email')) ?>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="<?= esc(old('email', $row->email ?? '')) ?>"
                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email-error"
                        aria-invalid="<?= isset($errors['email']) ? 'true' : 'false' ?>"
                        required maxlength="40"
                    >
                    <?php if (!empty($errors['email'])): ?>
                        <div id="email-error" class="invalid-feedback d-block">
                            <?= esc($errors['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="genere" class="form-label">
                        <?= esc(lang('Staff.genere')) ?>
                    </label>
                    <input
                        type="text"
                        name="genere"
                        id="genere"
                        value="<?= esc(old('genere', $row->genere ?? '')) ?>"
                        class="form-control <?= isset($errors['genere']) ? 'is-invalid' : '' ?>"
                        aria-describedby="genere-error"
                        aria-invalid="<?= isset($errors['genere']) ? 'true' : 'false' ?>"
                        required maxlength="2"
                    >
                    <?php if (!empty($errors['genere'])): ?>
                        <div id="genere-error" class="invalid-feedback d-block">
                            <?= esc($errors['genere']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="reparto_id" class="form-label">
                        <?= esc(lang('Staff.reparto_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="reparto_id"
                        id="reparto_id"
                        value="<?= esc(old('reparto_id', $row->reparto_id ?? '')) ?>"
                        class="form-control <?= isset($errors['reparto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reparto_id-error"
                        aria-invalid="<?= isset($errors['reparto_id']) ? 'true' : 'false' ?>"
                        required maxlength="20"
                    >
                    <?php if (!empty($errors['reparto_id'])): ?>
                        <div id="reparto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['reparto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="staff_stato" class="form-label">
                        <?= esc(lang('Staff.staff_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="staff_stato"
                        id="staff_stato"
                        value="<?= esc(old('staff_stato', $row->staff_stato ?? '')) ?>"
                        class="form-control <?= isset($errors['staff_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="staff_stato-error"
                        aria-invalid="<?= isset($errors['staff_stato']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['staff_stato'])): ?>
                        <div id="staff_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['staff_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="staff_datarecod" class="form-label">
                        <?= esc(lang('Staff.staff_datarecod')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="staff_datarecod"
                        id="staff_datarecod"
                        value="<?= esc(old('staff_datarecod', isset($row->staff_datarecod) ? str_replace(' ', 'T', substr((string) $row->staff_datarecod, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['staff_datarecod']) ? 'is-invalid' : '' ?>"
                        aria-describedby="staff_datarecod-error"
                        aria-invalid="<?= isset($errors['staff_datarecod']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['staff_datarecod'])): ?>
                        <div id="staff_datarecod-error" class="invalid-feedback d-block">
                            <?= esc($errors['staff_datarecod']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('Staff.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="utente_id-error"
                        aria-invalid="<?= isset($errors['utente_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['utente_id'])): ?>
                        <div id="utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['utente_id']) ?>
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

                    <a href="<?= site_url('staff') ?>" class="btn btn-secondary">
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
