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
                    <label for="Comuni_Codice" class="form-label">
                        <?= esc(lang('Fields.Comuni_Codice')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Codice"
                        id="Comuni_Codice"
                        value="<?= esc(old('Comuni_Codice', $row->Comuni_Codice ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_Codice']) ? 'is-invalid' : '' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Codice'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Codice']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Nome" class="form-label">
                        <?= esc(lang('Fields.Comuni_Nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Nome"
                        id="Comuni_Nome"
                        value="<?= esc(old('Comuni_Nome', $row->Comuni_Nome ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_Nome']) ? 'is-invalid' : '' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Nome'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Prov" class="form-label">
                        <?= esc(lang('Fields.Comuni_Prov')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Prov"
                        id="Comuni_Prov"
                        value="<?= esc(old('Comuni_Prov', $row->Comuni_Prov ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_Prov']) ? 'is-invalid' : '' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Prov'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Prov']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_CAP" class="form-label">
                        <?= esc(lang('Fields.Comuni_CAP')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_CAP"
                        id="Comuni_CAP"
                        value="<?= esc(old('Comuni_CAP', $row->Comuni_CAP ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_CAP']) ? 'is-invalid' : '' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_CAP'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_CAP']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Prefisso" class="form-label">
                        <?= esc(lang('Fields.Comuni_Prefisso')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Prefisso"
                        id="Comuni_Prefisso"
                        value="<?= esc(old('Comuni_Prefisso', $row->Comuni_Prefisso ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_Prefisso']) ? 'is-invalid' : '' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_Prefisso'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Prefisso']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_ColExcel" class="form-label">
                        <?= esc(lang('Fields.Comuni_ColExcel')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_ColExcel"
                        id="Comuni_ColExcel"
                        value="<?= esc(old('Comuni_ColExcel', $row->Comuni_ColExcel ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_ColExcel']) ? 'is-invalid' : '' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['Comuni_ColExcel'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_ColExcel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Nazione" class="form-label">
                        <?= esc(lang('Fields.Comuni_Nazione')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Nazione"
                        id="Comuni_Nazione"
                        value="<?= esc(old('Comuni_Nazione', $row->Comuni_Nazione ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_Nazione']) ? 'is-invalid' : '' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['Comuni_Nazione'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Nazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Comuni_Lingua" class="form-label">
                        <?= esc(lang('Fields.Comuni_Lingua')) ?>
                    </label>
                    <input
                        type="text"
                        name="Comuni_Lingua"
                        id="Comuni_Lingua"
                        value="<?= esc(old('Comuni_Lingua', $row->Comuni_Lingua ?? '')) ?>"
                        class="form-control <?= isset($errors['Comuni_Lingua']) ? 'is-invalid' : '' ?>"
                        required maxlength="4"
                    >
                    <?php if (!empty($errors['Comuni_Lingua'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Comuni_Lingua']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazione_iso2" class="form-label">
                        <?= esc(lang('Fields.nazione_iso2')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazione_iso2"
                        id="nazione_iso2"
                        value="<?= esc(old('nazione_iso2', $row->nazione_iso2 ?? '')) ?>"
                        class="form-control <?= isset($errors['nazione_iso2']) ? 'is-invalid' : '' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['nazione_iso2'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nazione_iso2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazione_iso3" class="form-label">
                        <?= esc(lang('Fields.nazione_iso3')) ?>
                    </label>
                    <input
                        type="text"
                        name="nazione_iso3"
                        id="nazione_iso3"
                        value="<?= esc(old('nazione_iso3', $row->nazione_iso3 ?? '')) ?>"
                        class="form-control <?= isset($errors['nazione_iso3']) ? 'is-invalid' : '' ?>"
                        required maxlength="5"
                    >
                    <?php if (!empty($errors['nazione_iso3'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['nazione_iso3']) ?>
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

                    <a href="<?= site_url('comuni') ?>" class="btn btn-secondary">
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
