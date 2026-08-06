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
                    <label for="nome_tipologia" class="form-label">
                        <?= esc(lang('Fields.nome_tipologia')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia"
                        id="nome_tipologia"
                        value="<?= esc(old('nome_tipologia', $row->nome_tipologia ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_tipologia']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nome_tipologia'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_en" class="form-label">
                        <?= esc(lang('Fields.nome_tipologia_en')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_en"
                        id="nome_tipologia_en"
                        value="<?= esc(old('nome_tipologia_en', $row->nome_tipologia_en ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_en']) ? 'is-invalid' : '' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_en'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_en']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_fr" class="form-label">
                        <?= esc(lang('Fields.nome_tipologia_fr')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_fr"
                        id="nome_tipologia_fr"
                        value="<?= esc(old('nome_tipologia_fr', $row->nome_tipologia_fr ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_fr']) ? 'is-invalid' : '' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_fr'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_fr']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_de" class="form-label">
                        <?= esc(lang('Fields.nome_tipologia_de')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_de"
                        id="nome_tipologia_de"
                        value="<?= esc(old('nome_tipologia_de', $row->nome_tipologia_de ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_de']) ? 'is-invalid' : '' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_de'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_de']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_sp" class="form-label">
                        <?= esc(lang('Fields.nome_tipologia_sp')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_sp"
                        id="nome_tipologia_sp"
                        value="<?= esc(old('nome_tipologia_sp', $row->nome_tipologia_sp ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_sp']) ? 'is-invalid' : '' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_sp'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_sp']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_jp" class="form-label">
                        <?= esc(lang('Fields.nome_tipologia_jp')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_jp"
                        id="nome_tipologia_jp"
                        value="<?= esc(old('nome_tipologia_jp', $row->nome_tipologia_jp ?? '')) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_jp']) ? 'is-invalid' : '' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_jp'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_jp']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_sigla" class="form-label">
                        <?= esc(lang('Fields.tipologia_sigla')) ?>
                    </label>
                    <input
                        type="text"
                        name="tipologia_sigla"
                        id="tipologia_sigla"
                        value="<?= esc(old('tipologia_sigla', $row->tipologia_sigla ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_sigla']) ? 'is-invalid' : '' ?>"
                        required maxlength="10"
                    >
                    <?php if (!empty($errors['tipologia_sigla'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_sigla']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numero_pax" class="form-label">
                        <?= esc(lang('Fields.numero_pax')) ?>
                    </label>
                    <input
                        type="text"
                        name="numero_pax"
                        id="numero_pax"
                        value="<?= esc(old('numero_pax', $row->numero_pax ?? '')) ?>"
                        class="form-control <?= isset($errors['numero_pax']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['numero_pax'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['numero_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_camera_data_record" class="form-label">
                        <?= esc(lang('Fields.tipologia_camera_data_record')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="tipologia_camera_data_record"
                        id="tipologia_camera_data_record"
                        value="<?= esc(old('tipologia_camera_data_record', $row->tipologia_camera_data_record ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_camera_data_record']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['tipologia_camera_data_record'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_camera_data_record']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_camera_utente_id" class="form-label">
                        <?= esc(lang('Fields.tipologia_camera_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="tipologia_camera_utente_id"
                        id="tipologia_camera_utente_id"
                        value="<?= esc(old('tipologia_camera_utente_id', $row->tipologia_camera_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['tipologia_camera_utente_id']) ? 'is-invalid' : '' ?>"
                    >
                    <?php if (!empty($errors['tipologia_camera_utente_id'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_camera_utente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="perc_prezzo" class="form-label">
                        <?= esc(lang('Fields.perc_prezzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="perc_prezzo"
                        id="perc_prezzo"
                        value="<?= esc(old('perc_prezzo', $row->perc_prezzo ?? '')) ?>"
                        class="form-control <?= isset($errors['perc_prezzo']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['perc_prezzo'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['perc_prezzo']) ?>
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

                    <a href="<?= site_url('tipologia_camera') ?>" class="btn btn-secondary">
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
