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
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('Clienti.preno_id')) ?>
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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('Clienti.hotel_id')) ?>
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
                    <label for="camera_id" class="form-label">
                        <?= esc(lang('Clienti.camera_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="camera_id"
                        id="camera_id"
                        value="<?= esc(old('camera_id', $row->camera_id ?? '')) ?>"
                        class="form-control <?= isset($errors['camera_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_id-error"
                        aria-invalid="<?= isset($errors['camera_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camera_id'])): ?>
                        <div id="camera_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['camera_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camera_numero" class="form-label">
                        <?= esc(lang('Clienti.camera_numero')) ?>
                    </label>
                    <input
                        type="number"
                        name="camera_numero"
                        id="camera_numero"
                        value="<?= esc(old('camera_numero', $row->camera_numero ?? '')) ?>"
                        class="form-control <?= isset($errors['camera_numero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camera_numero-error"
                        aria-invalid="<?= isset($errors['camera_numero']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['camera_numero'])): ?>
                        <div id="camera_numero-error" class="invalid-feedback d-block">
                            <?= esc($errors['camera_numero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camara_tipologia" class="form-label">
                        <?= esc(lang('Clienti.camara_tipologia')) ?>
                    </label>
                    <input
                        type="text"
                        name="camara_tipologia"
                        id="camara_tipologia"
                        value="<?= esc(old('camara_tipologia', $row->camara_tipologia ?? '')) ?>"
                        class="form-control <?= isset($errors['camara_tipologia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="camara_tipologia-error"
                        aria-invalid="<?= isset($errors['camara_tipologia']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['camara_tipologia'])): ?>
                        <div id="camara_tipologia-error" class="invalid-feedback d-block">
                            <?= esc($errors['camara_tipologia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_nome" class="form-label">
                        <?= esc(lang('Clienti.clienti_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_nome"
                        id="clienti_nome"
                        value="<?= esc(old('clienti_nome', $row->clienti_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_nome-error"
                        aria-invalid="<?= isset($errors['clienti_nome']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_nome'])): ?>
                        <div id="clienti_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cogno" class="form-label">
                        <?= esc(lang('Clienti.clienti_cogno')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cogno"
                        id="clienti_cogno"
                        value="<?= esc(old('clienti_cogno', $row->clienti_cogno ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cogno']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cogno-error"
                        aria-invalid="<?= isset($errors['clienti_cogno']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cogno'])): ?>
                        <div id="clienti_cogno-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cogno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_a" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_a')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_a"
                        id="cliente_nato_a"
                        value="<?= esc(old('cliente_nato_a', $row->cliente_nato_a ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_a']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_a-error"
                        aria-invalid="<?= isset($errors['cliente_nato_a']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nato_a'])): ?>
                        <div id="cliente_nato_a-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_a']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_il" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_il')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_il"
                        id="cliente_nato_il"
                        value="<?= esc(old('cliente_nato_il', $row->cliente_nato_il ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_il']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_il-error"
                        aria-invalid="<?= isset($errors['cliente_nato_il']) ? 'true' : 'false' ?>"
                        maxlength="12"
                    >
                    <?php if (!empty($errors['cliente_nato_il'])): ?>
                        <div id="cliente_nato_il-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_il']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nazione" class="form-label">
                        <?= esc(lang('Clienti.cliente_nazione')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nazione"
                        id="cliente_nazione"
                        value="<?= esc(old('cliente_nazione', $row->cliente_nazione ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nazione-error"
                        aria-invalid="<?= isset($errors['cliente_nazione']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nazione'])): ?>
                        <div id="cliente_nazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_provincia" class="form-label">
                        <?= esc(lang('Clienti.cliente_provincia')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_provincia"
                        id="cliente_provincia"
                        value="<?= esc(old('cliente_provincia', $row->cliente_provincia ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_provincia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_provincia-error"
                        aria-invalid="<?= isset($errors['cliente_provincia']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_provincia'])): ?>
                        <div id="cliente_provincia-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_provincia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_residenza" class="form-label">
                        <?= esc(lang('Clienti.cliente_residenza')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_residenza"
                        id="cliente_residenza"
                        value="<?= esc(old('cliente_residenza', $row->cliente_residenza ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_residenza']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_residenza-error"
                        aria-invalid="<?= isset($errors['cliente_residenza']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_residenza'])): ?>
                        <div id="cliente_residenza-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_residenza']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_cocumento_tipo" class="form-label">
                        <?= esc(lang('Clienti.cliente_cocumento_tipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_cocumento_tipo"
                        id="cliente_cocumento_tipo"
                        value="<?= esc(old('cliente_cocumento_tipo', $row->cliente_cocumento_tipo ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_cocumento_tipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_cocumento_tipo-error"
                        aria-invalid="<?= isset($errors['cliente_cocumento_tipo']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_cocumento_tipo'])): ?>
                        <div id="cliente_cocumento_tipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_cocumento_tipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_cocumento_numero" class="form-label">
                        <?= esc(lang('Clienti.cliente_cocumento_numero')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_cocumento_numero"
                        id="cliente_cocumento_numero"
                        value="<?= esc(old('cliente_cocumento_numero', $row->cliente_cocumento_numero ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_cocumento_numero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_cocumento_numero-error"
                        aria-invalid="<?= isset($errors['cliente_cocumento_numero']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_cocumento_numero'])): ?>
                        <div id="cliente_cocumento_numero-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_cocumento_numero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_cocumento_rilasciato_il" class="form-label">
                        <?= esc(lang('Clienti.cliente_cocumento_rilasciato_il')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_cocumento_rilasciato_il"
                        id="cliente_cocumento_rilasciato_il"
                        value="<?= esc(old('cliente_cocumento_rilasciato_il', $row->cliente_cocumento_rilasciato_il ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_cocumento_rilasciato_il']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_cocumento_rilasciato_il-error"
                        aria-invalid="<?= isset($errors['cliente_cocumento_rilasciato_il']) ? 'true' : 'false' ?>"
                        required maxlength="12"
                    >
                    <?php if (!empty($errors['cliente_cocumento_rilasciato_il'])): ?>
                        <div id="cliente_cocumento_rilasciato_il-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_cocumento_rilasciato_il']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_sesso" class="form-label">
                        <?= esc(lang('Clienti.cliente_sesso')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_sesso"
                        id="cliente_sesso"
                        value="<?= esc(old('cliente_sesso', $row->cliente_sesso ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_sesso']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_sesso-error"
                        aria-invalid="<?= isset($errors['cliente_sesso']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_sesso'])): ?>
                        <div id="cliente_sesso-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_sesso']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_nome1" class="form-label">
                        <?= esc(lang('Clienti.clienti_nome1')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_nome1"
                        id="clienti_nome1"
                        value="<?= esc(old('clienti_nome1', $row->clienti_nome1 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_nome1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_nome1-error"
                        aria-invalid="<?= isset($errors['clienti_nome1']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_nome1'])): ?>
                        <div id="clienti_nome1-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_nome1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_nome2" class="form-label">
                        <?= esc(lang('Clienti.clienti_nome2')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_nome2"
                        id="clienti_nome2"
                        value="<?= esc(old('clienti_nome2', $row->clienti_nome2 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_nome2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_nome2-error"
                        aria-invalid="<?= isset($errors['clienti_nome2']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_nome2'])): ?>
                        <div id="clienti_nome2-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_nome2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_nome3" class="form-label">
                        <?= esc(lang('Clienti.clienti_nome3')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_nome3"
                        id="clienti_nome3"
                        value="<?= esc(old('clienti_nome3', $row->clienti_nome3 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_nome3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_nome3-error"
                        aria-invalid="<?= isset($errors['clienti_nome3']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_nome3'])): ?>
                        <div id="clienti_nome3-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_nome3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_nome4" class="form-label">
                        <?= esc(lang('Clienti.clienti_nome4')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_nome4"
                        id="clienti_nome4"
                        value="<?= esc(old('clienti_nome4', $row->clienti_nome4 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_nome4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_nome4-error"
                        aria-invalid="<?= isset($errors['clienti_nome4']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_nome4'])): ?>
                        <div id="clienti_nome4-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_nome4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cogno1" class="form-label">
                        <?= esc(lang('Clienti.clienti_cogno1')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cogno1"
                        id="clienti_cogno1"
                        value="<?= esc(old('clienti_cogno1', $row->clienti_cogno1 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cogno1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cogno1-error"
                        aria-invalid="<?= isset($errors['clienti_cogno1']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cogno1'])): ?>
                        <div id="clienti_cogno1-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cogno1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cogno2" class="form-label">
                        <?= esc(lang('Clienti.clienti_cogno2')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cogno2"
                        id="clienti_cogno2"
                        value="<?= esc(old('clienti_cogno2', $row->clienti_cogno2 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cogno2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cogno2-error"
                        aria-invalid="<?= isset($errors['clienti_cogno2']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cogno2'])): ?>
                        <div id="clienti_cogno2-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cogno2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cogno3" class="form-label">
                        <?= esc(lang('Clienti.clienti_cogno3')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cogno3"
                        id="clienti_cogno3"
                        value="<?= esc(old('clienti_cogno3', $row->clienti_cogno3 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cogno3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cogno3-error"
                        aria-invalid="<?= isset($errors['clienti_cogno3']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cogno3'])): ?>
                        <div id="clienti_cogno3-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cogno3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cogno4" class="form-label">
                        <?= esc(lang('Clienti.clienti_cogno4')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cogno4"
                        id="clienti_cogno4"
                        value="<?= esc(old('clienti_cogno4', $row->clienti_cogno4 ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cogno4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cogno4-error"
                        aria-invalid="<?= isset($errors['clienti_cogno4']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cogno4'])): ?>
                        <div id="clienti_cogno4-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cogno4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_a1" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_a1')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_a1"
                        id="cliente_nato_a1"
                        value="<?= esc(old('cliente_nato_a1', $row->cliente_nato_a1 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_a1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_a1-error"
                        aria-invalid="<?= isset($errors['cliente_nato_a1']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nato_a1'])): ?>
                        <div id="cliente_nato_a1-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_a1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_a2" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_a2')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_a2"
                        id="cliente_nato_a2"
                        value="<?= esc(old('cliente_nato_a2', $row->cliente_nato_a2 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_a2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_a2-error"
                        aria-invalid="<?= isset($errors['cliente_nato_a2']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nato_a2'])): ?>
                        <div id="cliente_nato_a2-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_a2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_a3" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_a3')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_a3"
                        id="cliente_nato_a3"
                        value="<?= esc(old('cliente_nato_a3', $row->cliente_nato_a3 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_a3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_a3-error"
                        aria-invalid="<?= isset($errors['cliente_nato_a3']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nato_a3'])): ?>
                        <div id="cliente_nato_a3-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_a3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_a4" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_a4')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_a4"
                        id="cliente_nato_a4"
                        value="<?= esc(old('cliente_nato_a4', $row->cliente_nato_a4 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_a4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_a4-error"
                        aria-invalid="<?= isset($errors['cliente_nato_a4']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nato_a4'])): ?>
                        <div id="cliente_nato_a4-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_a4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_il1" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_il1')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_il1"
                        id="cliente_nato_il1"
                        value="<?= esc(old('cliente_nato_il1', $row->cliente_nato_il1 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_il1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_il1-error"
                        aria-invalid="<?= isset($errors['cliente_nato_il1']) ? 'true' : 'false' ?>"
                        maxlength="12"
                    >
                    <?php if (!empty($errors['cliente_nato_il1'])): ?>
                        <div id="cliente_nato_il1-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_il1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_il2" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_il2')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_il2"
                        id="cliente_nato_il2"
                        value="<?= esc(old('cliente_nato_il2', $row->cliente_nato_il2 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_il2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_il2-error"
                        aria-invalid="<?= isset($errors['cliente_nato_il2']) ? 'true' : 'false' ?>"
                        maxlength="12"
                    >
                    <?php if (!empty($errors['cliente_nato_il2'])): ?>
                        <div id="cliente_nato_il2-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_il2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_il3" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_il3')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_il3"
                        id="cliente_nato_il3"
                        value="<?= esc(old('cliente_nato_il3', $row->cliente_nato_il3 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_il3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_il3-error"
                        aria-invalid="<?= isset($errors['cliente_nato_il3']) ? 'true' : 'false' ?>"
                        maxlength="12"
                    >
                    <?php if (!empty($errors['cliente_nato_il3'])): ?>
                        <div id="cliente_nato_il3-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_il3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nato_il4" class="form-label">
                        <?= esc(lang('Clienti.cliente_nato_il4')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nato_il4"
                        id="cliente_nato_il4"
                        value="<?= esc(old('cliente_nato_il4', $row->cliente_nato_il4 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nato_il4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nato_il4-error"
                        aria-invalid="<?= isset($errors['cliente_nato_il4']) ? 'true' : 'false' ?>"
                        maxlength="12"
                    >
                    <?php if (!empty($errors['cliente_nato_il4'])): ?>
                        <div id="cliente_nato_il4-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nato_il4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_sesso1" class="form-label">
                        <?= esc(lang('Clienti.cliente_sesso1')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_sesso1"
                        id="cliente_sesso1"
                        value="<?= esc(old('cliente_sesso1', $row->cliente_sesso1 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_sesso1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_sesso1-error"
                        aria-invalid="<?= isset($errors['cliente_sesso1']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_sesso1'])): ?>
                        <div id="cliente_sesso1-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_sesso1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_sesso2" class="form-label">
                        <?= esc(lang('Clienti.cliente_sesso2')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_sesso2"
                        id="cliente_sesso2"
                        value="<?= esc(old('cliente_sesso2', $row->cliente_sesso2 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_sesso2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_sesso2-error"
                        aria-invalid="<?= isset($errors['cliente_sesso2']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_sesso2'])): ?>
                        <div id="cliente_sesso2-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_sesso2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_sesso3" class="form-label">
                        <?= esc(lang('Clienti.cliente_sesso3')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_sesso3"
                        id="cliente_sesso3"
                        value="<?= esc(old('cliente_sesso3', $row->cliente_sesso3 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_sesso3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_sesso3-error"
                        aria-invalid="<?= isset($errors['cliente_sesso3']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_sesso3'])): ?>
                        <div id="cliente_sesso3-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_sesso3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_sesso4" class="form-label">
                        <?= esc(lang('Clienti.cliente_sesso4')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_sesso4"
                        id="cliente_sesso4"
                        value="<?= esc(old('cliente_sesso4', $row->cliente_sesso4 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_sesso4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_sesso4-error"
                        aria-invalid="<?= isset($errors['cliente_sesso4']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_sesso4'])): ?>
                        <div id="cliente_sesso4-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_sesso4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nazione1" class="form-label">
                        <?= esc(lang('Clienti.cliente_nazione1')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nazione1"
                        id="cliente_nazione1"
                        value="<?= esc(old('cliente_nazione1', $row->cliente_nazione1 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nazione1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nazione1-error"
                        aria-invalid="<?= isset($errors['cliente_nazione1']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nazione1'])): ?>
                        <div id="cliente_nazione1-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nazione1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nazione2" class="form-label">
                        <?= esc(lang('Clienti.cliente_nazione2')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nazione2"
                        id="cliente_nazione2"
                        value="<?= esc(old('cliente_nazione2', $row->cliente_nazione2 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nazione2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nazione2-error"
                        aria-invalid="<?= isset($errors['cliente_nazione2']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nazione2'])): ?>
                        <div id="cliente_nazione2-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nazione2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nazione3" class="form-label">
                        <?= esc(lang('Clienti.cliente_nazione3')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nazione3"
                        id="cliente_nazione3"
                        value="<?= esc(old('cliente_nazione3', $row->cliente_nazione3 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nazione3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nazione3-error"
                        aria-invalid="<?= isset($errors['cliente_nazione3']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nazione3'])): ?>
                        <div id="cliente_nazione3-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nazione3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_nazione4" class="form-label">
                        <?= esc(lang('Clienti.cliente_nazione4')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_nazione4"
                        id="cliente_nazione4"
                        value="<?= esc(old('cliente_nazione4', $row->cliente_nazione4 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_nazione4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_nazione4-error"
                        aria-invalid="<?= isset($errors['cliente_nazione4']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_nazione4'])): ?>
                        <div id="cliente_nazione4-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_nazione4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_provincia1" class="form-label">
                        <?= esc(lang('Clienti.cliente_provincia1')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_provincia1"
                        id="cliente_provincia1"
                        value="<?= esc(old('cliente_provincia1', $row->cliente_provincia1 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_provincia1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_provincia1-error"
                        aria-invalid="<?= isset($errors['cliente_provincia1']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_provincia1'])): ?>
                        <div id="cliente_provincia1-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_provincia1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_provincia2" class="form-label">
                        <?= esc(lang('Clienti.cliente_provincia2')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_provincia2"
                        id="cliente_provincia2"
                        value="<?= esc(old('cliente_provincia2', $row->cliente_provincia2 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_provincia2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_provincia2-error"
                        aria-invalid="<?= isset($errors['cliente_provincia2']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_provincia2'])): ?>
                        <div id="cliente_provincia2-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_provincia2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_provincia3" class="form-label">
                        <?= esc(lang('Clienti.cliente_provincia3')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_provincia3"
                        id="cliente_provincia3"
                        value="<?= esc(old('cliente_provincia3', $row->cliente_provincia3 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_provincia3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_provincia3-error"
                        aria-invalid="<?= isset($errors['cliente_provincia3']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_provincia3'])): ?>
                        <div id="cliente_provincia3-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_provincia3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cliente_provincia4" class="form-label">
                        <?= esc(lang('Clienti.cliente_provincia4')) ?>
                    </label>
                    <input
                        type="text"
                        name="cliente_provincia4"
                        id="cliente_provincia4"
                        value="<?= esc(old('cliente_provincia4', $row->cliente_provincia4 ?? '')) ?>"
                        class="form-control <?= isset($errors['cliente_provincia4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cliente_provincia4-error"
                        aria-invalid="<?= isset($errors['cliente_provincia4']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['cliente_provincia4'])): ?>
                        <div id="cliente_provincia4-error" class="invalid-feedback d-block">
                            <?= esc($errors['cliente_provincia4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cc_tip" class="form-label">
                        <?= esc(lang('Clienti.clienti_cc_tip')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cc_tip"
                        id="clienti_cc_tip"
                        value="<?= esc(old('clienti_cc_tip', $row->clienti_cc_tip ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cc_tip']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cc_tip-error"
                        aria-invalid="<?= isset($errors['clienti_cc_tip']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cc_tip'])): ?>
                        <div id="clienti_cc_tip-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cc_tip']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cc_n" class="form-label">
                        <?= esc(lang('Clienti.clienti_cc_n')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cc_n"
                        id="clienti_cc_n"
                        value="<?= esc(old('clienti_cc_n', $row->clienti_cc_n ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cc_n']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cc_n-error"
                        aria-invalid="<?= isset($errors['clienti_cc_n']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cc_n'])): ?>
                        <div id="clienti_cc_n-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cc_n']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_cc_scad" class="form-label">
                        <?= esc(lang('Clienti.clienti_cc_scad')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_cc_scad"
                        id="clienti_cc_scad"
                        value="<?= esc(old('clienti_cc_scad', $row->clienti_cc_scad ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_cc_scad']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_cc_scad-error"
                        aria-invalid="<?= isset($errors['clienti_cc_scad']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_cc_scad'])): ?>
                        <div id="clienti_cc_scad-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_cc_scad']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_tel" class="form-label">
                        <?= esc(lang('Clienti.clienti_tel')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_tel"
                        id="clienti_tel"
                        value="<?= esc(old('clienti_tel', $row->clienti_tel ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_tel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_tel-error"
                        aria-invalid="<?= isset($errors['clienti_tel']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_tel'])): ?>
                        <div id="clienti_tel-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_tel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_fax" class="form-label">
                        <?= esc(lang('Clienti.clienti_fax')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_fax"
                        id="clienti_fax"
                        value="<?= esc(old('clienti_fax', $row->clienti_fax ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_fax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_fax-error"
                        aria-invalid="<?= isset($errors['clienti_fax']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_fax'])): ?>
                        <div id="clienti_fax-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_fax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_email" class="form-label">
                        <?= esc(lang('Clienti.clienti_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="clienti_email"
                        id="clienti_email"
                        value="<?= esc(old('clienti_email', $row->clienti_email ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_email-error"
                        aria-invalid="<?= isset($errors['clienti_email']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_email'])): ?>
                        <div id="clienti_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_note" class="form-label">
                        <?= esc(lang('Clienti.clienti_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="clienti_note"
                        id="clienti_note"
                        value="<?= esc(old('clienti_note', $row->clienti_note ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_note-error"
                        aria-invalid="<?= isset($errors['clienti_note']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['clienti_note'])): ?>
                        <div id="clienti_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="privacy" class="form-label">
                        <?= esc(lang('Clienti.privacy')) ?>
                    </label>
                    <input
                        type="number"
                        name="privacy"
                        id="privacy"
                        value="<?= esc(old('privacy', $row->privacy ?? '')) ?>"
                        class="form-control <?= isset($errors['privacy']) ? 'is-invalid' : '' ?>"
                        aria-describedby="privacy-error"
                        aria-invalid="<?= isset($errors['privacy']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['privacy'])): ?>
                        <div id="privacy-error" class="invalid-feedback d-block">
                            <?= esc($errors['privacy']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="marketing" class="form-label">
                        <?= esc(lang('Clienti.marketing')) ?>
                    </label>
                    <input
                        type="number"
                        name="marketing"
                        id="marketing"
                        value="<?= esc(old('marketing', $row->marketing ?? '')) ?>"
                        class="form-control <?= isset($errors['marketing']) ? 'is-invalid' : '' ?>"
                        aria-describedby="marketing-error"
                        aria-invalid="<?= isset($errors['marketing']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['marketing'])): ?>
                        <div id="marketing-error" class="invalid-feedback d-block">
                            <?= esc($errors['marketing']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="lingua" class="form-label">
                        <?= esc(lang('Clienti.lingua')) ?>
                    </label>
                    <input
                        type="text"
                        name="lingua"
                        id="lingua"
                        value="<?= esc(old('lingua', $row->lingua ?? '')) ?>"
                        class="form-control <?= isset($errors['lingua']) ? 'is-invalid' : '' ?>"
                        aria-describedby="lingua-error"
                        aria-invalid="<?= isset($errors['lingua']) ? 'true' : 'false' ?>"
                        required maxlength="10"
                    >
                    <?php if (!empty($errors['lingua'])): ?>
                        <div id="lingua-error" class="invalid-feedback d-block">
                            <?= esc($errors['lingua']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">
                        <?= esc(lang('Clienti.password')) ?>
                    </label>
                    <input
                        type="text"
                        name="password"
                        id="password"
                        value="<?= esc(old('password', $row->password ?? '')) ?>"
                        class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="password-error"
                        aria-invalid="<?= isset($errors['password']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['password'])): ?>
                        <div id="password-error" class="invalid-feedback d-block">
                            <?= esc($errors['password']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="clienti_utente_id" class="form-label">
                        <?= esc(lang('Clienti.clienti_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="clienti_utente_id"
                        id="clienti_utente_id"
                        value="<?= esc(old('clienti_utente_id', $row->clienti_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['clienti_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="clienti_utente_id-error"
                        aria-invalid="<?= isset($errors['clienti_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['clienti_utente_id'])): ?>
                        <div id="clienti_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['clienti_utente_id']) ?>
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

                    <a href="<?= site_url('clienti') ?>" class="btn btn-secondary">
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
