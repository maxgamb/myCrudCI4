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
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('Fields.camera_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="camera_id"
                        id="camera_id"
                        value="<?= esc(old('camera_id', $row->camera_id ?? '')) ?>"
                        class="form-control <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['camera_id'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Fields.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numero_camera" class="form-label">
                        <?= esc(lang('Fields.numero_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="numero_camera"
                        id="numero_camera"
                        value="<?= esc(old('numero_camera', $row->numero_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['numero_camera']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['numero_camera'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['numero_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_camera" class="form-label">
                        <?= esc(lang('Fields.tipologia_camera')) ?>
                    </label>
                    <input
                        type="text"
                        name="tipologia_camera"
                        id="tipologia_camera"
                        value="<?= esc(old('tipologia_camera', $row->tipologia_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_camera']) ? 'is-invalid' : '' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['tipologia_camera'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('Fields.tipologia_id')) ?>
                    </label>
                    <select
                        name="tipologia_id"
                        id="tipologia_id"
                        class="form-select <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
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
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_max_pax" class="form-label">
                        <?= esc(lang('Fields.camere_max_pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_max_pax"
                        id="camere_max_pax"
                        value="<?= esc(old('camere_max_pax', $row->camere_max_pax ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_max_pax']) ? 'is-invalid' : '' ?>"
                    >
                    <?php if (!empty($errors['camere_max_pax'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_max_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_metri_quadri" class="form-label">
                        <?= esc(lang('Fields.camere_metri_quadri')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_metri_quadri"
                        id="camere_metri_quadri"
                        value="<?= esc(old('camere_metri_quadri', $row->camere_metri_quadri ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_metri_quadri']) ? 'is-invalid' : '' ?>"
                    >
                    <?php if (!empty($errors['camere_metri_quadri'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_metri_quadri']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_vista" class="form-label">
                        <?= esc(lang('Fields.camere_vista')) ?>
                    </label>
                    <input
                        type="text"
                        name="camere_vista"
                        id="camere_vista"
                        value="<?= esc(old('camere_vista', $row->camere_vista ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_vista']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['camere_vista'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_vista']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_piano" class="form-label">
                        <?= esc(lang('Fields.camere_piano')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_piano"
                        id="camere_piano"
                        value="<?= esc(old('camere_piano', $row->camere_piano ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_piano']) ? 'is-invalid' : '' ?>"
                    >
                    <?php if (!empty($errors['camere_piano'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_piano']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_bagno" class="form-label">
                        <?= esc(lang('Fields.camere_bagno')) ?>
                    </label>
                    <input
                        type="text"
                        name="camere_bagno"
                        id="camere_bagno"
                        value="<?= esc(old('camere_bagno', $row->camere_bagno ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_bagno']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['camere_bagno'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_bagno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_edificio" class="form-label">
                        <?= esc(lang('Fields.camere_edificio')) ?>
                    </label>
                    <input
                        type="text"
                        name="camere_edificio"
                        id="camere_edificio"
                        value="<?= esc(old('camere_edificio', $row->camere_edificio ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_edificio']) ? 'is-invalid' : '' ?>"
                        maxlength="3"
                    >
                    <?php if (!empty($errors['camere_edificio'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_edificio']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="review_tot" class="form-label">
                        <?= esc(lang('Fields.review_tot')) ?>
                    </label>
                    <input
                        type="number"
                        name="review_tot"
                        id="review_tot"
                        value="<?= esc(old('review_tot', $row->review_tot ?? '')) ?>"
                        class="form-control <?= isset($errors['review_tot']) ? 'is-invalid' : '' ?>"
                    >
                    <?php if (!empty($errors['review_tot'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['review_tot']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_data_record" class="form-label">
                        <?= esc(lang('Fields.camere_data_record')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="camere_data_record"
                        id="camere_data_record"
                        value="<?= esc(old('camere_data_record', $row->camere_data_record ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_data_record']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['camere_data_record'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_data_record']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camere_utente_id" class="form-label">
                        <?= esc(lang('Fields.camere_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="camere_utente_id"
                        id="camere_utente_id"
                        value="<?= esc(old('camere_utente_id', $row->camere_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['camere_utente_id']) ? 'is-invalid' : '' ?>"
                    >
                    <?php if (!empty($errors['camere_utente_id'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['camere_utente_id']) ?>
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

                    <a href="<?= site_url('camere') ?>" class="btn btn-secondary">
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
