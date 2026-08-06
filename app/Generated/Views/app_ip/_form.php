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
                    <label for="ip_aderss" class="form-label">
                        <?= esc(lang('Fields.ip_aderss')) ?>
                    </label>
                    <input
                        type="text"
                        name="ip_aderss"
                        id="ip_aderss"
                        value="<?= esc(old('ip_aderss', $row->ip_aderss ?? '')) ?>"
                        class="form-control <?= isset($errors['ip_aderss']) ? 'is-invalid' : '' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['ip_aderss'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['ip_aderss']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Livello" class="form-label">
                        <?= esc(lang('Fields.Livello')) ?>
                    </label>
                    <input
                        type="number"
                        name="Livello"
                        id="Livello"
                        value="<?= esc(old('Livello', $row->Livello ?? '')) ?>"
                        class="form-control <?= isset($errors['Livello']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['Livello'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['Livello']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data" class="form-label">
                        <?= esc(lang('Fields.data')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="data"
                        id="data"
                        value="<?= esc(old('data', $row->data ?? '')) ?>"
                        class="form-control <?= isset($errors['data']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <?php if (!empty($errors['data'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc($errors['data']) ?>
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

                    <a href="<?= site_url('app_ip') ?>" class="btn btn-secondary">
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
