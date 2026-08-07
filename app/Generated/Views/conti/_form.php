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
                        <?= esc(lang('Conti.hotel_id')) ?>
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
                    <label for="foglio_id" class="form-label">
                        <?= esc(lang('Conti.foglio_id')) ?>
                    </label>
                    <select
                        name="foglio_id"
                        id="foglio_id"
                        class="form-select <?= isset($errors['foglio_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="foglio_id-error"
                        aria-invalid="<?= isset($errors['foglio_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['foglio_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('foglio_id', $row->foglio_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['foglio_id'])): ?>
                        <div id="foglio_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['foglio_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_id" class="form-label">
                        <?= esc(lang('Conti.clienti_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="clienti_id"
                        id="clienti_id"
                        value="<?= esc(old('clienti_id', $row->clienti_id ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_id-error"
                        aria-invalid="<?= isset($errors['clienti_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['clienti_id'])): ?>
                        <div id="clienti_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="in_conto" class="form-label">
                        <?= esc(lang('Conti.in_conto')) ?>
                    </label>
                    <input
                        type="date"
                        name="in_conto"
                        id="in_conto"
                        value="<?= esc(old('in_conto', $row->in_conto ?? '')) ?>"
                        class="form-control <?= isset($errors['in_conto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="in_conto-error"
                        aria-invalid="<?= isset($errors['in_conto']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['in_conto'])): ?>
                        <div id="in_conto-error" class="invalid-feedback d-block">
                            <?= esc($errors['in_conto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="in_conto_time" class="form-label">
                        <?= esc(lang('Conti.in_conto_time')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="in_conto_time"
                        id="in_conto_time"
                        value="<?= esc(old('in_conto_time', isset($row->in_conto_time) ? str_replace(' ', 'T', substr((string) $row->in_conto_time, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['in_conto_time']) ? 'is-invalid' : '' ?>"
                        aria-describedby="in_conto_time-error"
                        aria-invalid="<?= isset($errors['in_conto_time']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['in_conto_time'])): ?>
                        <div id="in_conto_time-error" class="invalid-feedback d-block">
                            <?= esc($errors['in_conto_time']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="out_preno" class="form-label">
                        <?= esc(lang('Conti.out_preno')) ?>
                    </label>
                    <input
                        type="date"
                        name="out_preno"
                        id="out_preno"
                        value="<?= esc(old('out_preno', $row->out_preno ?? '')) ?>"
                        class="form-control <?= isset($errors['out_preno']) ? 'is-invalid' : '' ?>"
                        aria-describedby="out_preno-error"
                        aria-invalid="<?= isset($errors['out_preno']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['out_preno'])): ?>
                        <div id="out_preno-error" class="invalid-feedback d-block">
                            <?= esc($errors['out_preno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="out_conto" class="form-label">
                        <?= esc(lang('Conti.out_conto')) ?>
                    </label>
                    <input
                        type="date"
                        name="out_conto"
                        id="out_conto"
                        value="<?= esc(old('out_conto', $row->out_conto ?? '')) ?>"
                        class="form-control <?= isset($errors['out_conto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="out_conto-error"
                        aria-invalid="<?= isset($errors['out_conto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['out_conto'])): ?>
                        <div id="out_conto-error" class="invalid-feedback d-block">
                            <?= esc($errors['out_conto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('Conti.preno_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="preno_id"
                        id="preno_id"
                        value="<?= esc(old('preno_id', $row->preno_id ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_id-error"
                        aria-invalid="<?= isset($errors['preno_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['preno_id'])): ?>
                        <div id="preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('Conti.camera_id')) ?>
                    </label>
                    <select
                        name="camera_id"
                        id="camera_id"
                        class="form-select <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_id-error"
                        aria-invalid="<?= isset($errors['camera_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['camera_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('camera_id', $row->camera_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['camera_id'])): ?>
                        <div id="camera_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numero_camera" class="form-label">
                        <?= esc(lang('Conti.numero_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="numero_camera"
                        id="numero_camera"
                        value="<?= esc(old('numero_camera', $row->numero_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['numero_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="numero_camera-error"
                        aria-invalid="<?= isset($errors['numero_camera']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['numero_camera'])): ?>
                        <div id="numero_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['numero_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="trattamento_sog" class="form-label">
                        <?= esc(lang('Conti.trattamento_sog')) ?>
                    </label>
                    <input
                        type="text"
                        name="trattamento_sog"
                        id="trattamento_sog"
                        value="<?= esc(old('trattamento_sog', $row->trattamento_sog ?? '')) ?>"
                        class="form-control <?= isset($errors['trattamento_sog']) ? 'is-invalid' : '' ?>"
                        aria-describedby="trattamento_sog-error"
                        aria-invalid="<?= isset($errors['trattamento_sog']) ? 'true' : 'false' ?>"
                        maxlength="3"
                    >
                    <?php if (!empty($errors['trattamento_sog'])): ?>
                        <div id="trattamento_sog-error" class="invalid-feedback d-block">
                            <?= esc($errors['trattamento_sog']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipo_camera" class="form-label">
                        <?= esc(lang('Conti.tipo_camera')) ?>
                    </label>
                    <input
                        type="text"
                        name="tipo_camera"
                        id="tipo_camera"
                        value="<?= esc(old('tipo_camera', $row->tipo_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['tipo_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipo_camera-error"
                        aria-invalid="<?= isset($errors['tipo_camera']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['tipo_camera'])): ?>
                        <div id="tipo_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipo_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('Conti.tipologia_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="tipologia_id"
                        id="tipologia_id"
                        value="<?= esc(old('tipologia_id', $row->tipologia_id ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_id-error"
                        aria-invalid="<?= isset($errors['tipologia_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzo" class="form-label">
                        <?= esc(lang('Conti.prezzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="prezzo"
                        id="prezzo"
                        value="<?= esc(old('prezzo', $row->prezzo ?? '')) ?>"
                        class="form-control <?= isset($errors['prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzo-error"
                        aria-invalid="<?= isset($errors['prezzo']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['prezzo'])): ?>
                        <div id="prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_cliente" class="form-label">
                        <?= esc(lang('Conti.nome_cliente')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_cliente"
                        id="nome_cliente"
                        value="<?= esc(old('nome_cliente', $row->nome_cliente ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_cliente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_cliente-error"
                        aria-invalid="<?= isset($errors['nome_cliente']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nome_cliente'])): ?>
                        <div id="nome_cliente-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_cliente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cognome_cliente" class="form-label">
                        <?= esc(lang('Conti.cognome_cliente')) ?>
                    </label>
                    <input
                        type="text"
                        name="cognome_cliente"
                        id="cognome_cliente"
                        value="<?= esc(old('cognome_cliente', $row->cognome_cliente ?? '')) ?>"
                        class="form-control <?= isset($errors['cognome_cliente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cognome_cliente-error"
                        aria-invalid="<?= isset($errors['cognome_cliente']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cognome_cliente'])): ?>
                        <div id="cognome_cliente-error" class="invalid-feedback d-block">
                            <?= esc($errors['cognome_cliente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_agenzia" class="form-label">
                        <?= esc(lang('Conti.preno_agenzia')) ?>
                    </label>
                    <input
                        type="number"
                        name="preno_agenzia"
                        id="preno_agenzia"
                        value="<?= esc(old('preno_agenzia', $row->preno_agenzia ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_agenzia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_agenzia-error"
                        aria-invalid="<?= isset($errors['preno_agenzia']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['preno_agenzia'])): ?>
                        <div id="preno_agenzia-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_agenzia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mercato" class="form-label">
                        <?= esc(lang('Conti.mercato')) ?>
                    </label>
                    <input
                        type="text"
                        name="mercato"
                        id="mercato"
                        value="<?= esc(old('mercato', $row->mercato ?? '')) ?>"
                        class="form-control <?= isset($errors['mercato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mercato-error"
                        aria-invalid="<?= isset($errors['mercato']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['mercato'])): ?>
                        <div id="mercato-error" class="invalid-feedback d-block">
                            <?= esc($errors['mercato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="conti_stato_camere" class="form-label">
                        <?= esc(lang('Conti.conti_stato_camere')) ?>
                    </label>
                    <input
                        type="number"
                        name="conti_stato_camere"
                        id="conti_stato_camere"
                        value="<?= esc(old('conti_stato_camere', $row->conti_stato_camere ?? '')) ?>"
                        class="form-control <?= isset($errors['conti_stato_camere']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conti_stato_camere-error"
                        aria-invalid="<?= isset($errors['conti_stato_camere']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['conti_stato_camere'])): ?>
                        <div id="conti_stato_camere-error" class="invalid-feedback d-block">
                            <?= esc($errors['conti_stato_camere']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="acconto" class="form-label">
                        <?= esc(lang('Conti.acconto')) ?>
                    </label>
                    <input
                        type="number"
                        name="acconto"
                        id="acconto"
                        value="<?= esc(old('acconto', $row->acconto ?? '')) ?>"
                        class="form-control <?= isset($errors['acconto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="acconto-error"
                        aria-invalid="<?= isset($errors['acconto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['acconto'])): ?>
                        <div id="acconto-error" class="invalid-feedback d-block">
                            <?= esc($errors['acconto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="conto_pag_modalita" class="form-label">
                        <?= esc(lang('Conti.conto_pag_modalita')) ?>
                    </label>
                    <input
                        type="text"
                        name="conto_pag_modalita"
                        id="conto_pag_modalita"
                        value="<?= esc(old('conto_pag_modalita', $row->conto_pag_modalita ?? '')) ?>"
                        class="form-control <?= isset($errors['conto_pag_modalita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conto_pag_modalita-error"
                        aria-invalid="<?= isset($errors['conto_pag_modalita']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['conto_pag_modalita'])): ?>
                        <div id="conto_pag_modalita-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_pag_modalita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="conti_utente_id" class="form-label">
                        <?= esc(lang('Conti.conti_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="conti_utente_id"
                        id="conti_utente_id"
                        value="<?= esc(old('conti_utente_id', $row->conti_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['conti_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conti_utente_id-error"
                        aria-invalid="<?= isset($errors['conti_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['conti_utente_id'])): ?>
                        <div id="conti_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conti_utente_id']) ?>
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

                    <a href="<?= site_url('conti') ?>" class="btn btn-secondary">
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
