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
                    <label for="mod_conto_id" class="form-label">
                        <?= esc(lang('ModificaConti.mod_conto_id')) ?>
                    </label>
                    <select
                        name="mod_conto_id"
                        id="mod_conto_id"
                        class="form-select <?= isset($errors['mod_conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_conto_id-error"
                        aria-invalid="<?= isset($errors['mod_conto_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['mod_conto_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('mod_conto_id', $row->mod_conto_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['mod_conto_id'])): ?>
                        <div id="mod_conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_hotel_id" class="form-label">
                        <?= esc(lang('ModificaConti.mod_hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_hotel_id"
                        id="mod_hotel_id"
                        value="<?= esc(old('mod_hotel_id', $row->mod_hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_hotel_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_hotel_id-error"
                        aria-invalid="<?= isset($errors['mod_hotel_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_hotel_id'])): ?>
                        <div id="mod_hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_foglio_id" class="form-label">
                        <?= esc(lang('ModificaConti.mod_foglio_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_foglio_id"
                        id="mod_foglio_id"
                        value="<?= esc(old('mod_foglio_id', $row->mod_foglio_id ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_foglio_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_foglio_id-error"
                        aria-invalid="<?= isset($errors['mod_foglio_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_foglio_id'])): ?>
                        <div id="mod_foglio_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_foglio_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_clienti_id" class="form-label">
                        <?= esc(lang('ModificaConti.mod_clienti_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_clienti_id"
                        id="mod_clienti_id"
                        value="<?= esc(old('mod_clienti_id', $row->mod_clienti_id ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_clienti_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_clienti_id-error"
                        aria-invalid="<?= isset($errors['mod_clienti_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_clienti_id'])): ?>
                        <div id="mod_clienti_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_clienti_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_in_conto" class="form-label">
                        <?= esc(lang('ModificaConti.mod_in_conto')) ?>
                    </label>
                    <input
                        type="date"
                        name="mod_in_conto"
                        id="mod_in_conto"
                        value="<?= esc(old('mod_in_conto', $row->mod_in_conto ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_in_conto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_in_conto-error"
                        aria-invalid="<?= isset($errors['mod_in_conto']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['mod_in_conto'])): ?>
                        <div id="mod_in_conto-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_in_conto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_out_preno" class="form-label">
                        <?= esc(lang('ModificaConti.mod_out_preno')) ?>
                    </label>
                    <input
                        type="date"
                        name="mod_out_preno"
                        id="mod_out_preno"
                        value="<?= esc(old('mod_out_preno', $row->mod_out_preno ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_out_preno']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_out_preno-error"
                        aria-invalid="<?= isset($errors['mod_out_preno']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['mod_out_preno'])): ?>
                        <div id="mod_out_preno-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_out_preno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_out_conto" class="form-label">
                        <?= esc(lang('ModificaConti.mod_out_conto')) ?>
                    </label>
                    <input
                        type="date"
                        name="mod_out_conto"
                        id="mod_out_conto"
                        value="<?= esc(old('mod_out_conto', $row->mod_out_conto ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_out_conto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_out_conto-error"
                        aria-invalid="<?= isset($errors['mod_out_conto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_out_conto'])): ?>
                        <div id="mod_out_conto-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_out_conto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_preno_id" class="form-label">
                        <?= esc(lang('ModificaConti.mod_preno_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_preno_id"
                        id="mod_preno_id"
                        value="<?= esc(old('mod_preno_id', $row->mod_preno_id ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_preno_id-error"
                        aria-invalid="<?= isset($errors['mod_preno_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_preno_id'])): ?>
                        <div id="mod_preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_camera_id" class="form-label">
                        <?= esc(lang('ModificaConti.mod_camera_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_camera_id"
                        id="mod_camera_id"
                        value="<?= esc(old('mod_camera_id', $row->mod_camera_id ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_camera_id-error"
                        aria-invalid="<?= isset($errors['mod_camera_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_camera_id'])): ?>
                        <div id="mod_camera_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_numero_camera" class="form-label">
                        <?= esc(lang('ModificaConti.mod_numero_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_numero_camera"
                        id="mod_numero_camera"
                        value="<?= esc(old('mod_numero_camera', $row->mod_numero_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_numero_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_numero_camera-error"
                        aria-invalid="<?= isset($errors['mod_numero_camera']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_numero_camera'])): ?>
                        <div id="mod_numero_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_numero_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_trattamento_sog" class="form-label">
                        <?= esc(lang('ModificaConti.mod_trattamento_sog')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_trattamento_sog"
                        id="mod_trattamento_sog"
                        value="<?= esc(old('mod_trattamento_sog', $row->mod_trattamento_sog ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_trattamento_sog']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_trattamento_sog-error"
                        aria-invalid="<?= isset($errors['mod_trattamento_sog']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_trattamento_sog'])): ?>
                        <div id="mod_trattamento_sog-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_trattamento_sog']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_tipo_camera" class="form-label">
                        <?= esc(lang('ModificaConti.mod_tipo_camera')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_tipo_camera"
                        id="mod_tipo_camera"
                        value="<?= esc(old('mod_tipo_camera', $row->mod_tipo_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_tipo_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_tipo_camera-error"
                        aria-invalid="<?= isset($errors['mod_tipo_camera']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_tipo_camera'])): ?>
                        <div id="mod_tipo_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_tipo_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_prezzo" class="form-label">
                        <?= esc(lang('ModificaConti.mod_prezzo')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_prezzo"
                        id="mod_prezzo"
                        value="<?= esc(old('mod_prezzo', $row->mod_prezzo ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_prezzo-error"
                        aria-invalid="<?= isset($errors['mod_prezzo']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_prezzo'])): ?>
                        <div id="mod_prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_prezzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_nome_cliente" class="form-label">
                        <?= esc(lang('ModificaConti.mod_nome_cliente')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_nome_cliente"
                        id="mod_nome_cliente"
                        value="<?= esc(old('mod_nome_cliente', $row->mod_nome_cliente ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_nome_cliente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_nome_cliente-error"
                        aria-invalid="<?= isset($errors['mod_nome_cliente']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_nome_cliente'])): ?>
                        <div id="mod_nome_cliente-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_nome_cliente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_cognome_cliente" class="form-label">
                        <?= esc(lang('ModificaConti.mod_cognome_cliente')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_cognome_cliente"
                        id="mod_cognome_cliente"
                        value="<?= esc(old('mod_cognome_cliente', $row->mod_cognome_cliente ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_cognome_cliente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_cognome_cliente-error"
                        aria-invalid="<?= isset($errors['mod_cognome_cliente']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_cognome_cliente'])): ?>
                        <div id="mod_cognome_cliente-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_cognome_cliente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_preno_agenzia" class="form-label">
                        <?= esc(lang('ModificaConti.mod_preno_agenzia')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_preno_agenzia"
                        id="mod_preno_agenzia"
                        value="<?= esc(old('mod_preno_agenzia', $row->mod_preno_agenzia ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_preno_agenzia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_preno_agenzia-error"
                        aria-invalid="<?= isset($errors['mod_preno_agenzia']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_preno_agenzia'])): ?>
                        <div id="mod_preno_agenzia-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_preno_agenzia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_mercato" class="form-label">
                        <?= esc(lang('ModificaConti.mod_mercato')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_mercato"
                        id="mod_mercato"
                        value="<?= esc(old('mod_mercato', $row->mod_mercato ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_mercato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_mercato-error"
                        aria-invalid="<?= isset($errors['mod_mercato']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_mercato'])): ?>
                        <div id="mod_mercato-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_mercato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_conti_stato_camere" class="form-label">
                        <?= esc(lang('ModificaConti.mod_conti_stato_camere')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_conti_stato_camere"
                        id="mod_conti_stato_camere"
                        value="<?= esc(old('mod_conti_stato_camere', $row->mod_conti_stato_camere ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_conti_stato_camere']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_conti_stato_camere-error"
                        aria-invalid="<?= isset($errors['mod_conti_stato_camere']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_conti_stato_camere'])): ?>
                        <div id="mod_conti_stato_camere-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_conti_stato_camere']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_acconto" class="form-label">
                        <?= esc(lang('ModificaConti.mod_acconto')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_acconto"
                        id="mod_acconto"
                        value="<?= esc(old('mod_acconto', $row->mod_acconto ?? '')) ?>"
                        class="form-control <?= isset($errors['mod_acconto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_acconto-error"
                        aria-invalid="<?= isset($errors['mod_acconto']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mod_acconto'])): ?>
                        <div id="mod_acconto-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_acconto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="modifica_conti_adebiti_utente_id" class="form-label">
                        <?= esc(lang('ModificaConti.modifica_conti_adebiti_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="modifica_conti_adebiti_utente_id"
                        id="modifica_conti_adebiti_utente_id"
                        value="<?= esc(old('modifica_conti_adebiti_utente_id', $row->modifica_conti_adebiti_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['modifica_conti_adebiti_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="modifica_conti_adebiti_utente_id-error"
                        aria-invalid="<?= isset($errors['modifica_conti_adebiti_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['modifica_conti_adebiti_utente_id'])): ?>
                        <div id="modifica_conti_adebiti_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['modifica_conti_adebiti_utente_id']) ?>
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

                    <a href="<?= site_url('modifica_conti') ?>" class="btn btn-secondary">
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
