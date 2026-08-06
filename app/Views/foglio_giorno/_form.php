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
                        <?= esc(lang('FoglioGiorno.hotel_id')) ?>
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
                    <label for="conto_id" class="form-label">
                        <?= esc(lang('FoglioGiorno.conto_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="conto_id"
                        id="conto_id"
                        value="<?= esc(old('conto_id', $row->conto_id ?? '')) ?>"
                        class="form-control <?= isset($errors['conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conto_id-error"
                        aria-invalid="<?= isset($errors['conto_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['conto_id'])): ?>
                        <div id="conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('FoglioGiorno.camera_id')) ?>
                    </label>
                    <select
                        name="camera_id"
                        id="camera_id"
                        class="form-select <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_id-error"
                        aria-invalid="<?= isset($errors['camera_id']) ? 'true' : 'false' ?>"
                        required
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
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('FoglioGiorno.preno_id')) ?>
                    </label>
                    <select
                        name="preno_id"
                        id="preno_id"
                        class="form-select <?= isset($errors['preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_id-error"
                        aria-invalid="<?= isset($errors['preno_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_id', $row->preno_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_id'])): ?>
                        <div id="preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('FoglioGiorno.tipologia_id')) ?>
                    </label>
                    <select
                        name="tipologia_id"
                        id="tipologia_id"
                        class="form-select <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_id-error"
                        aria-invalid="<?= isset($errors['tipologia_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['tipologia_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('tipologia_id', $row->tipologia_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numero_camera" class="form-label">
                        <?= esc(lang('FoglioGiorno.numero_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="numero_camera"
                        id="numero_camera"
                        value="<?= esc(old('numero_camera', $row->numero_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['numero_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="numero_camera-error"
                        aria-invalid="<?= isset($errors['numero_camera']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['numero_camera'])): ?>
                        <div id="numero_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['numero_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="foglio_prezzo_camera" class="form-label">
                        <?= esc(lang('FoglioGiorno.foglio_prezzo_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="foglio_prezzo_camera"
                        id="foglio_prezzo_camera"
                        value="<?= esc(old('foglio_prezzo_camera', $row->foglio_prezzo_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['foglio_prezzo_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="foglio_prezzo_camera-error"
                        aria-invalid="<?= isset($errors['foglio_prezzo_camera']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['foglio_prezzo_camera'])): ?>
                        <div id="foglio_prezzo_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['foglio_prezzo_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="date_foglio" class="form-label">
                        <?= esc(lang('FoglioGiorno.date_foglio')) ?>
                    </label>
                    <input
                        type="text"
                        name="date_foglio"
                        id="date_foglio"
                        value="<?= esc(old('date_foglio', $row->date_foglio ?? '')) ?>"
                        class="form-control <?= isset($errors['date_foglio']) ? 'is-invalid' : '' ?>"
                        aria-describedby="date_foglio-error"
                        aria-invalid="<?= isset($errors['date_foglio']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['date_foglio'])): ?>
                        <div id="date_foglio-error" class="invalid-feedback d-block">
                            <?= esc($errors['date_foglio']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_cliente" class="form-label">
                        <?= esc(lang('FoglioGiorno.nome_cliente')) ?>
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
                        <?= esc(lang('FoglioGiorno.cognome_cliente')) ?>
                    </label>
                    <input
                        type="text"
                        name="cognome_cliente"
                        id="cognome_cliente"
                        value="<?= esc(old('cognome_cliente', $row->cognome_cliente ?? '')) ?>"
                        class="form-control <?= isset($errors['cognome_cliente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cognome_cliente-error"
                        aria-invalid="<?= isset($errors['cognome_cliente']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['cognome_cliente'])): ?>
                        <div id="cognome_cliente-error" class="invalid-feedback d-block">
                            <?= esc($errors['cognome_cliente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="in_conto" class="form-label">
                        <?= esc(lang('FoglioGiorno.in_conto')) ?>
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
                    <label for="out_preno" class="form-label">
                        <?= esc(lang('FoglioGiorno.out_preno')) ?>
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
                    <label for="stato_camera" class="form-label">
                        <?= esc(lang('FoglioGiorno.stato_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="stato_camera"
                        id="stato_camera"
                        value="<?= esc(old('stato_camera', $row->stato_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['stato_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="stato_camera-error"
                        aria-invalid="<?= isset($errors['stato_camera']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['stato_camera'])): ?>
                        <div id="stato_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['stato_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_agenzia" class="form-label">
                        <?= esc(lang('FoglioGiorno.preno_agenzia')) ?>
                    </label>
                    <select
                        name="preno_agenzia"
                        id="preno_agenzia"
                        class="form-select <?= isset($errors['preno_agenzia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_agenzia-error"
                        aria-invalid="<?= isset($errors['preno_agenzia']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_agenzia'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_agenzia', $row->preno_agenzia ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_agenzia'])): ?>
                        <div id="preno_agenzia-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_agenzia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="foglio_utente_id" class="form-label">
                        <?= esc(lang('FoglioGiorno.foglio_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="foglio_utente_id"
                        id="foglio_utente_id"
                        value="<?= esc(old('foglio_utente_id', $row->foglio_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['foglio_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="foglio_utente_id-error"
                        aria-invalid="<?= isset($errors['foglio_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['foglio_utente_id'])): ?>
                        <div id="foglio_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['foglio_utente_id']) ?>
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

                    <a href="<?= site_url('foglio_giorno') ?>" class="btn btn-secondary">
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
