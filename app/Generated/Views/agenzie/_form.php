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
                        <?= esc(lang('Agenzie.hotel_id')) ?>
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
                    <label for="agenzia_tipologia" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_tipologia')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_tipologia"
                        id="agenzia_tipologia"
                        value="<?= esc(old('agenzia_tipologia', $row->agenzia_tipologia ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_tipologia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_tipologia-error"
                        aria-invalid="<?= isset($errors['agenzia_tipologia']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_tipologia'])): ?>
                        <div id="agenzia_tipologia-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_tipologia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_nome" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_nome"
                        id="agenzia_nome"
                        value="<?= esc(old('agenzia_nome', $row->agenzia_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_nome-error"
                        aria-invalid="<?= isset($errors['agenzia_nome']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_nome'])): ?>
                        <div id="agenzia_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_via" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_via')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_via"
                        id="agenzia_via"
                        value="<?= esc(old('agenzia_via', $row->agenzia_via ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_via']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_via-error"
                        aria-invalid="<?= isset($errors['agenzia_via']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_via'])): ?>
                        <div id="agenzia_via-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_via']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_citta" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_citta')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_citta"
                        id="agenzia_citta"
                        value="<?= esc(old('agenzia_citta', $row->agenzia_citta ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_citta']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_citta-error"
                        aria-invalid="<?= isset($errors['agenzia_citta']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_citta'])): ?>
                        <div id="agenzia_citta-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_citta']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_state" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_state')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_state"
                        id="agenzia_state"
                        value="<?= esc(old('agenzia_state', $row->agenzia_state ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_state']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_state-error"
                        aria-invalid="<?= isset($errors['agenzia_state']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_state'])): ?>
                        <div id="agenzia_state-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_state']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_country" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_country')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_country"
                        id="agenzia_country"
                        value="<?= esc(old('agenzia_country', $row->agenzia_country ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_country']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_country-error"
                        aria-invalid="<?= isset($errors['agenzia_country']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_country'])): ?>
                        <div id="agenzia_country-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_country']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_cap" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_cap')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_cap"
                        id="agenzia_cap"
                        value="<?= esc(old('agenzia_cap', $row->agenzia_cap ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_cap']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_cap-error"
                        aria-invalid="<?= isset($errors['agenzia_cap']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_cap'])): ?>
                        <div id="agenzia_cap-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_cap']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_tel" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_tel')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_tel"
                        id="agenzia_tel"
                        value="<?= esc(old('agenzia_tel', $row->agenzia_tel ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_tel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_tel-error"
                        aria-invalid="<?= isset($errors['agenzia_tel']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_tel'])): ?>
                        <div id="agenzia_tel-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_tel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_fax" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_fax')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_fax"
                        id="agenzia_fax"
                        value="<?= esc(old('agenzia_fax', $row->agenzia_fax ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_fax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_fax-error"
                        aria-invalid="<?= isset($errors['agenzia_fax']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_fax'])): ?>
                        <div id="agenzia_fax-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_fax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_email" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="agenzia_email"
                        id="agenzia_email"
                        value="<?= esc(old('agenzia_email', $row->agenzia_email ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_email-error"
                        aria-invalid="<?= isset($errors['agenzia_email']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_email'])): ?>
                        <div id="agenzia_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_web" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_web')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_web"
                        id="agenzia_web"
                        value="<?= esc(old('agenzia_web', $row->agenzia_web ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_web']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_web-error"
                        aria-invalid="<?= isset($errors['agenzia_web']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['agenzia_web'])): ?>
                        <div id="agenzia_web-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_web']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_par_iva" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_par_iva')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_par_iva"
                        id="agenzia_par_iva"
                        value="<?= esc(old('agenzia_par_iva', $row->agenzia_par_iva ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_par_iva']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_par_iva-error"
                        aria-invalid="<?= isset($errors['agenzia_par_iva']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_par_iva'])): ?>
                        <div id="agenzia_par_iva-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_par_iva']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_par_cf" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_par_cf')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_par_cf"
                        id="agenzia_par_cf"
                        value="<?= esc(old('agenzia_par_cf', $row->agenzia_par_cf ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_par_cf']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_par_cf-error"
                        aria-invalid="<?= isset($errors['agenzia_par_cf']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['agenzia_par_cf'])): ?>
                        <div id="agenzia_par_cf-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_par_cf']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_pec" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_pec')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_pec"
                        id="agenzia_pec"
                        value="<?= esc(old('agenzia_pec', $row->agenzia_pec ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_pec']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_pec-error"
                        aria-invalid="<?= isset($errors['agenzia_pec']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['agenzia_pec'])): ?>
                        <div id="agenzia_pec-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_pec']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_sid" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_sid')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_sid"
                        id="agenzia_sid"
                        value="<?= esc(old('agenzia_sid', $row->agenzia_sid ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_sid']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_sid-error"
                        aria-invalid="<?= isset($errors['agenzia_sid']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['agenzia_sid'])): ?>
                        <div id="agenzia_sid-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_sid']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_referente" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_referente')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_referente"
                        id="agenzia_referente"
                        value="<?= esc(old('agenzia_referente', $row->agenzia_referente ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_referente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_referente-error"
                        aria-invalid="<?= isset($errors['agenzia_referente']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agenzia_referente'])): ?>
                        <div id="agenzia_referente-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_referente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_banca_nome" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_banca_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_banca_nome"
                        id="agenzia_banca_nome"
                        value="<?= esc(old('agenzia_banca_nome', $row->agenzia_banca_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_banca_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_banca_nome-error"
                        aria-invalid="<?= isset($errors['agenzia_banca_nome']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_banca_nome'])): ?>
                        <div id="agenzia_banca_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_banca_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_banca_iban" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_banca_iban')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_banca_iban"
                        id="agenzia_banca_iban"
                        value="<?= esc(old('agenzia_banca_iban', $row->agenzia_banca_iban ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_banca_iban']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_banca_iban-error"
                        aria-invalid="<?= isset($errors['agenzia_banca_iban']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_banca_iban'])): ?>
                        <div id="agenzia_banca_iban-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_banca_iban']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_banca_swift" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_banca_swift')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_banca_swift"
                        id="agenzia_banca_swift"
                        value="<?= esc(old('agenzia_banca_swift', $row->agenzia_banca_swift ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_banca_swift']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_banca_swift-error"
                        aria-invalid="<?= isset($errors['agenzia_banca_swift']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_banca_swift'])): ?>
                        <div id="agenzia_banca_swift-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_banca_swift']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_banca_iata" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_banca_iata')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_banca_iata"
                        id="agenzia_banca_iata"
                        value="<?= esc(old('agenzia_banca_iata', $row->agenzia_banca_iata ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_banca_iata']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_banca_iata-error"
                        aria-invalid="<?= isset($errors['agenzia_banca_iata']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_banca_iata'])): ?>
                        <div id="agenzia_banca_iata-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_banca_iata']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_cc_tipo" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_cc_tipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_cc_tipo"
                        id="agenzia_cc_tipo"
                        value="<?= esc(old('agenzia_cc_tipo', $row->agenzia_cc_tipo ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_cc_tipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_cc_tipo-error"
                        aria-invalid="<?= isset($errors['agenzia_cc_tipo']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_cc_tipo'])): ?>
                        <div id="agenzia_cc_tipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_cc_tipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_cc_nome" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_cc_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_cc_nome"
                        id="agenzia_cc_nome"
                        value="<?= esc(old('agenzia_cc_nome', $row->agenzia_cc_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_cc_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_cc_nome-error"
                        aria-invalid="<?= isset($errors['agenzia_cc_nome']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_cc_nome'])): ?>
                        <div id="agenzia_cc_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_cc_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_cc_numero" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_cc_numero')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_cc_numero"
                        id="agenzia_cc_numero"
                        value="<?= esc(old('agenzia_cc_numero', $row->agenzia_cc_numero ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_cc_numero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_cc_numero-error"
                        aria-invalid="<?= isset($errors['agenzia_cc_numero']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_cc_numero'])): ?>
                        <div id="agenzia_cc_numero-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_cc_numero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_cc_scadenza" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_cc_scadenza')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_cc_scadenza"
                        id="agenzia_cc_scadenza"
                        value="<?= esc(old('agenzia_cc_scadenza', $row->agenzia_cc_scadenza ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_cc_scadenza']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_cc_scadenza-error"
                        aria-invalid="<?= isset($errors['agenzia_cc_scadenza']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_cc_scadenza'])): ?>
                        <div id="agenzia_cc_scadenza-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_cc_scadenza']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_cc_cod_sicurezza" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_cc_cod_sicurezza')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_cc_cod_sicurezza"
                        id="agenzia_cc_cod_sicurezza"
                        value="<?= esc(old('agenzia_cc_cod_sicurezza', $row->agenzia_cc_cod_sicurezza ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_cc_cod_sicurezza']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_cc_cod_sicurezza-error"
                        aria-invalid="<?= isset($errors['agenzia_cc_cod_sicurezza']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['agenzia_cc_cod_sicurezza'])): ?>
                        <div id="agenzia_cc_cod_sicurezza-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_cc_cod_sicurezza']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_login" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_login')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_login"
                        id="agenzia_login"
                        value="<?= esc(old('agenzia_login', $row->agenzia_login ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_login']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_login-error"
                        aria-invalid="<?= isset($errors['agenzia_login']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['agenzia_login'])): ?>
                        <div id="agenzia_login-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_login']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_password" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_password')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_password"
                        id="agenzia_password"
                        value="<?= esc(old('agenzia_password', $row->agenzia_password ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_password-error"
                        aria-invalid="<?= isset($errors['agenzia_password']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['agenzia_password'])): ?>
                        <div id="agenzia_password-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_password']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_ab_web" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_ab_web')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_ab_web"
                        id="agenzia_ab_web"
                        value="<?= esc(old('agenzia_ab_web', $row->agenzia_ab_web ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_ab_web']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_ab_web-error"
                        aria-invalid="<?= isset($errors['agenzia_ab_web']) ? 'true' : 'false' ?>"
                        maxlength="2"
                    >
                    <?php if (!empty($errors['agenzia_ab_web'])): ?>
                        <div id="agenzia_ab_web-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_ab_web']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_ab_affiliati" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_ab_affiliati')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_ab_affiliati"
                        id="agenzia_ab_affiliati"
                        value="<?= esc(old('agenzia_ab_affiliati', $row->agenzia_ab_affiliati ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_ab_affiliati']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_ab_affiliati-error"
                        aria-invalid="<?= isset($errors['agenzia_ab_affiliati']) ? 'true' : 'false' ?>"
                        maxlength="2"
                    >
                    <?php if (!empty($errors['agenzia_ab_affiliati'])): ?>
                        <div id="agenzia_ab_affiliati-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_ab_affiliati']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_ad_vis" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_ad_vis')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_ad_vis"
                        id="agenzia_ad_vis"
                        value="<?= esc(old('agenzia_ad_vis', $row->agenzia_ad_vis ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_ad_vis']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_ad_vis-error"
                        aria-invalid="<?= isset($errors['agenzia_ad_vis']) ? 'true' : 'false' ?>"
                        maxlength="2"
                    >
                    <?php if (!empty($errors['agenzia_ad_vis'])): ?>
                        <div id="agenzia_ad_vis-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_ad_vis']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_ab_sospeso" class="form-label">
                        <?= esc(lang('Agenzie.agenzia_ab_sospeso')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_ab_sospeso"
                        id="agenzia_ab_sospeso"
                        value="<?= esc(old('agenzia_ab_sospeso', $row->agenzia_ab_sospeso ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_ab_sospeso']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_ab_sospeso-error"
                        aria-invalid="<?= isset($errors['agenzia_ab_sospeso']) ? 'true' : 'false' ?>"
                        maxlength="2"
                    >
                    <?php if (!empty($errors['agenzia_ab_sospeso'])): ?>
                        <div id="agenzia_ab_sospeso-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_ab_sospeso']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzie_utente_id" class="form-label">
                        <?= esc(lang('Agenzie.agenzie_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzie_utente_id"
                        id="agenzie_utente_id"
                        value="<?= esc(old('agenzie_utente_id', $row->agenzie_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzie_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzie_utente_id-error"
                        aria-invalid="<?= isset($errors['agenzie_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzie_utente_id'])): ?>
                        <div id="agenzie_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzie_utente_id']) ?>
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

                    <a href="<?= site_url('agenzie') ?>" class="btn btn-secondary">
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
