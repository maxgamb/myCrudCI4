<?php
$formTitle = $formTitle ?? 'Gestione record';
$formIcon = $formIcon ?? 'bi-pencil-square';
$formAction = $formAction ?? current_url();
$row = $row ?? null;
$errors = $errors ?? [];
$options = $options ?? [];
$context = $context ?? [];
$contextLabels = $contextLabels ?? [];
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
                    <label for="nome_hotel" class="form-label">
                        <?= esc(lang('Hotels.nome_hotel')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_hotel"
                        id="nome_hotel"
                        value="<?= esc(old('nome_hotel', $row->nome_hotel ?? ($context['nome_hotel'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_hotel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_hotel-error"
                        aria-invalid="<?= isset($errors['nome_hotel']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nome_hotel'])): ?>
                        <div id="nome_hotel-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_hotel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_tipologia" class="form-label">
                        <?= esc(lang('Hotels.hotel_tipologia')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_tipologia"
                        id="hotel_tipologia"
                        value="<?= esc(old('hotel_tipologia', $row->hotel_tipologia ?? ($context['hotel_tipologia'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_tipologia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_tipologia-error"
                        aria-invalid="<?= isset($errors['hotel_tipologia']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_tipologia'])): ?>
                        <div id="hotel_tipologia-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_tipologia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_categoria" class="form-label">
                        <?= esc(lang('Hotels.hotel_categoria')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_categoria"
                        id="hotel_categoria"
                        value="<?= esc(old('hotel_categoria', $row->hotel_categoria ?? ($context['hotel_categoria'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_categoria']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_categoria-error"
                        aria-invalid="<?= isset($errors['hotel_categoria']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_categoria'])): ?>
                        <div id="hotel_categoria-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_categoria']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_citta" class="form-label">
                        <?= esc(lang('Hotels.hotel_citta')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_citta"
                        id="hotel_citta"
                        value="<?= esc(old('hotel_citta', $row->hotel_citta ?? ($context['hotel_citta'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_citta']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_citta-error"
                        aria-invalid="<?= isset($errors['hotel_citta']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_citta'])): ?>
                        <div id="hotel_citta-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_citta']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_via" class="form-label">
                        <?= esc(lang('Hotels.hotel_via')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_via"
                        id="hotel_via"
                        value="<?= esc(old('hotel_via', $row->hotel_via ?? ($context['hotel_via'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_via']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_via-error"
                        aria-invalid="<?= isset($errors['hotel_via']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_via'])): ?>
                        <div id="hotel_via-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_via']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_tel" class="form-label">
                        <?= esc(lang('Hotels.hotel_tel')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_tel"
                        id="hotel_tel"
                        value="<?= esc(old('hotel_tel', $row->hotel_tel ?? ($context['hotel_tel'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_tel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_tel-error"
                        aria-invalid="<?= isset($errors['hotel_tel']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_tel'])): ?>
                        <div id="hotel_tel-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_tel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_fax" class="form-label">
                        <?= esc(lang('Hotels.hotel_fax')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_fax"
                        id="hotel_fax"
                        value="<?= esc(old('hotel_fax', $row->hotel_fax ?? ($context['hotel_fax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_fax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_fax-error"
                        aria-invalid="<?= isset($errors['hotel_fax']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_fax'])): ?>
                        <div id="hotel_fax-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_fax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_email" class="form-label">
                        <?= esc(lang('Hotels.hotel_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="hotel_email"
                        id="hotel_email"
                        value="<?= esc(old('hotel_email', $row->hotel_email ?? ($context['hotel_email'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_email-error"
                        aria-invalid="<?= isset($errors['hotel_email']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_email'])): ?>
                        <div id="hotel_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_stato" class="form-label">
                        <?= esc(lang('Hotels.hotel_stato')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_stato"
                        id="hotel_stato"
                        value="<?= esc(old('hotel_stato', $row->hotel_stato ?? ($context['hotel_stato'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_stato-error"
                        aria-invalid="<?= isset($errors['hotel_stato']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_stato'])): ?>
                        <div id="hotel_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_cap" class="form-label">
                        <?= esc(lang('Hotels.hotel_cap')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_cap"
                        id="hotel_cap"
                        value="<?= esc(old('hotel_cap', $row->hotel_cap ?? ($context['hotel_cap'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_cap']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_cap-error"
                        aria-invalid="<?= isset($errors['hotel_cap']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['hotel_cap'])): ?>
                        <div id="hotel_cap-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_cap']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_piva" class="form-label">
                        <?= esc(lang('Hotels.hotel_piva')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_piva"
                        id="hotel_piva"
                        value="<?= esc(old('hotel_piva', $row->hotel_piva ?? ($context['hotel_piva'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_piva']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_piva-error"
                        aria-invalid="<?= isset($errors['hotel_piva']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_piva'])): ?>
                        <div id="hotel_piva-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_piva']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_numero_camere" class="form-label">
                        <?= esc(lang('Hotels.hotel_numero_camere')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_numero_camere"
                        id="hotel_numero_camere"
                        value="<?= esc(old('hotel_numero_camere', $row->hotel_numero_camere ?? ($context['hotel_numero_camere'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_numero_camere']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_numero_camere-error"
                        aria-invalid="<?= isset($errors['hotel_numero_camere']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['hotel_numero_camere'])): ?>
                        <div id="hotel_numero_camere-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_numero_camere']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotels_utente_id" class="form-label">
                        <?= esc(lang('Hotels.hotels_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotels_utente_id"
                        id="hotels_utente_id"
                        value="<?= esc(old('hotels_utente_id', $row->hotels_utente_id ?? ($context['hotels_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotels_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotels_utente_id-error"
                        aria-invalid="<?= isset($errors['hotels_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotels_utente_id'])): ?>
                        <div id="hotels_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotels_utente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_web" class="form-label">
                        <?= esc(lang('Hotels.hotel_web')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_web"
                        id="hotel_web"
                        value="<?= esc(old('hotel_web', $row->hotel_web ?? ($context['hotel_web'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_web']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_web-error"
                        aria-invalid="<?= isset($errors['hotel_web']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_web'])): ?>
                        <div id="hotel_web-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_web']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_logo" class="form-label">
                        <?= esc(lang('Hotels.hotel_logo')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_logo"
                        id="hotel_logo"
                        value="<?= esc(old('hotel_logo', $row->hotel_logo ?? ($context['hotel_logo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_logo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_logo-error"
                        aria-invalid="<?= isset($errors['hotel_logo']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_logo'])): ?>
                        <div id="hotel_logo-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_logo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_mappa" class="form-label">
                        <?= esc(lang('Hotels.hotel_mappa')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_mappa"
                        id="hotel_mappa"
                        value="<?= esc(old('hotel_mappa', $row->hotel_mappa ?? ($context['hotel_mappa'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_mappa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_mappa-error"
                        aria-invalid="<?= isset($errors['hotel_mappa']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_mappa'])): ?>
                        <div id="hotel_mappa-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_mappa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_reach_by_car" class="form-label">
                        <?= esc(lang('Hotels.hotel_reach_by_car')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_reach_by_car"
                        id="hotel_reach_by_car"
                        value="<?= esc(old('hotel_reach_by_car', $row->hotel_reach_by_car ?? ($context['hotel_reach_by_car'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_reach_by_car']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_reach_by_car-error"
                        aria-invalid="<?= isset($errors['hotel_reach_by_car']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_reach_by_car'])): ?>
                        <div id="hotel_reach_by_car-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_reach_by_car']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_reach_by_treno" class="form-label">
                        <?= esc(lang('Hotels.hotel_reach_by_treno')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_reach_by_treno"
                        id="hotel_reach_by_treno"
                        value="<?= esc(old('hotel_reach_by_treno', $row->hotel_reach_by_treno ?? ($context['hotel_reach_by_treno'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_reach_by_treno']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_reach_by_treno-error"
                        aria-invalid="<?= isset($errors['hotel_reach_by_treno']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_reach_by_treno'])): ?>
                        <div id="hotel_reach_by_treno-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_reach_by_treno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_reach_aereo" class="form-label">
                        <?= esc(lang('Hotels.hotel_reach_aereo')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_reach_aereo"
                        id="hotel_reach_aereo"
                        value="<?= esc(old('hotel_reach_aereo', $row->hotel_reach_aereo ?? ($context['hotel_reach_aereo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_reach_aereo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_reach_aereo-error"
                        aria-invalid="<?= isset($errors['hotel_reach_aereo']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_reach_aereo'])): ?>
                        <div id="hotel_reach_aereo-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_reach_aereo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_reach_nave" class="form-label">
                        <?= esc(lang('Hotels.hotel_reach_nave')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_reach_nave"
                        id="hotel_reach_nave"
                        value="<?= esc(old('hotel_reach_nave', $row->hotel_reach_nave ?? ($context['hotel_reach_nave'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_reach_nave']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_reach_nave-error"
                        aria-invalid="<?= isset($errors['hotel_reach_nave']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_reach_nave'])): ?>
                        <div id="hotel_reach_nave-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_reach_nave']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_foto_piccola" class="form-label">
                        <?= esc(lang('Hotels.hotel_foto_piccola')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_foto_piccola"
                        id="hotel_foto_piccola"
                        value="<?= esc(old('hotel_foto_piccola', $row->hotel_foto_piccola ?? ($context['hotel_foto_piccola'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_foto_piccola']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_foto_piccola-error"
                        aria-invalid="<?= isset($errors['hotel_foto_piccola']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_foto_piccola'])): ?>
                        <div id="hotel_foto_piccola-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_foto_piccola']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_foto_grande" class="form-label">
                        <?= esc(lang('Hotels.hotel_foto_grande')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_foto_grande"
                        id="hotel_foto_grande"
                        value="<?= esc(old('hotel_foto_grande', $row->hotel_foto_grande ?? ($context['hotel_foto_grande'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_foto_grande']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_foto_grande-error"
                        aria-invalid="<?= isset($errors['hotel_foto_grande']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_foto_grande'])): ?>
                        <div id="hotel_foto_grande-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_foto_grande']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_testo_en" class="form-label">
                        <?= esc(lang('Hotels.hotel_testo_en')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_testo_en"
                        id="hotel_testo_en"
                        value="<?= esc(old('hotel_testo_en', $row->hotel_testo_en ?? ($context['hotel_testo_en'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_testo_en']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_testo_en-error"
                        aria-invalid="<?= isset($errors['hotel_testo_en']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_testo_en'])): ?>
                        <div id="hotel_testo_en-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_testo_en']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_testo_it" class="form-label">
                        <?= esc(lang('Hotels.hotel_testo_it')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_testo_it"
                        id="hotel_testo_it"
                        value="<?= esc(old('hotel_testo_it', $row->hotel_testo_it ?? ($context['hotel_testo_it'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_testo_it']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_testo_it-error"
                        aria-invalid="<?= isset($errors['hotel_testo_it']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_testo_it'])): ?>
                        <div id="hotel_testo_it-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_testo_it']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_disp_modo" class="form-label">
                        <?= esc(lang('Hotels.hotel_disp_modo')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_disp_modo"
                        id="hotel_disp_modo"
                        value="<?= esc(old('hotel_disp_modo', $row->hotel_disp_modo ?? ($context['hotel_disp_modo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_disp_modo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_disp_modo-error"
                        aria-invalid="<?= isset($errors['hotel_disp_modo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_disp_modo'])): ?>
                        <div id="hotel_disp_modo-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_disp_modo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_limite_vendite_web" class="form-label">
                        <?= esc(lang('Hotels.hotel_limite_vendite_web')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_limite_vendite_web"
                        id="hotel_limite_vendite_web"
                        value="<?= esc(old('hotel_limite_vendite_web', $row->hotel_limite_vendite_web ?? ($context['hotel_limite_vendite_web'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_limite_vendite_web']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_limite_vendite_web-error"
                        aria-invalid="<?= isset($errors['hotel_limite_vendite_web']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_limite_vendite_web'])): ?>
                        <div id="hotel_limite_vendite_web-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_limite_vendite_web']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_limite_vendite_xml" class="form-label">
                        <?= esc(lang('Hotels.hotel_limite_vendite_xml')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_limite_vendite_xml"
                        id="hotel_limite_vendite_xml"
                        value="<?= esc(old('hotel_limite_vendite_xml', $row->hotel_limite_vendite_xml ?? ($context['hotel_limite_vendite_xml'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_limite_vendite_xml']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_limite_vendite_xml-error"
                        aria-invalid="<?= isset($errors['hotel_limite_vendite_xml']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_limite_vendite_xml'])): ?>
                        <div id="hotel_limite_vendite_xml-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_limite_vendite_xml']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_incremento_prezzo_xml" class="form-label">
                        <?= esc(lang('Hotels.hotel_incremento_prezzo_xml')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_incremento_prezzo_xml"
                        id="hotel_incremento_prezzo_xml"
                        value="<?= esc(old('hotel_incremento_prezzo_xml', $row->hotel_incremento_prezzo_xml ?? ($context['hotel_incremento_prezzo_xml'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_incremento_prezzo_xml']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_incremento_prezzo_xml-error"
                        aria-invalid="<?= isset($errors['hotel_incremento_prezzo_xml']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_incremento_prezzo_xml'])): ?>
                        <div id="hotel_incremento_prezzo_xml-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_incremento_prezzo_xml']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_booking_attivazione" class="form-label">
                        <?= esc(lang('Hotels.hotel_booking_attivazione')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_booking_attivazione"
                        id="hotel_booking_attivazione"
                        value="<?= esc(old('hotel_booking_attivazione', $row->hotel_booking_attivazione ?? ($context['hotel_booking_attivazione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_booking_attivazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_booking_attivazione-error"
                        aria-invalid="<?= isset($errors['hotel_booking_attivazione']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_booking_attivazione'])): ?>
                        <div id="hotel_booking_attivazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_booking_attivazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_booking_url" class="form-label">
                        <?= esc(lang('Hotels.hotel_booking_url')) ?>
                    </label>
                    <input
                        type="url"
                        name="hotel_booking_url"
                        id="hotel_booking_url"
                        value="<?= esc(old('hotel_booking_url', $row->hotel_booking_url ?? ($context['hotel_booking_url'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_booking_url']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_booking_url-error"
                        aria-invalid="<?= isset($errors['hotel_booking_url']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['hotel_booking_url'])): ?>
                        <div id="hotel_booking_url-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_booking_url']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_booking_agenzia" class="form-label">
                        <?= esc(lang('Hotels.hotel_booking_agenzia')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_booking_agenzia"
                        id="hotel_booking_agenzia"
                        value="<?= esc(old('hotel_booking_agenzia', $row->hotel_booking_agenzia ?? ($context['hotel_booking_agenzia'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_booking_agenzia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_booking_agenzia-error"
                        aria-invalid="<?= isset($errors['hotel_booking_agenzia']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_booking_agenzia'])): ?>
                        <div id="hotel_booking_agenzia-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_booking_agenzia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_tarif_cambia_gg" class="form-label">
                        <?= esc(lang('Hotels.hotel_tarif_cambia_gg')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_tarif_cambia_gg"
                        id="hotel_tarif_cambia_gg"
                        value="<?= esc(old('hotel_tarif_cambia_gg', $row->hotel_tarif_cambia_gg ?? ($context['hotel_tarif_cambia_gg'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_tarif_cambia_gg']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_tarif_cambia_gg-error"
                        aria-invalid="<?= isset($errors['hotel_tarif_cambia_gg']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_tarif_cambia_gg'])): ?>
                        <div id="hotel_tarif_cambia_gg-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_tarif_cambia_gg']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_tarif_listino_nome_id" class="form-label">
                        <?= esc(lang('Hotels.hotel_tarif_listino_nome_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_tarif_listino_nome_id"
                        id="hotel_tarif_listino_nome_id"
                        value="<?= esc(old('hotel_tarif_listino_nome_id', $row->hotel_tarif_listino_nome_id ?? ($context['hotel_tarif_listino_nome_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_tarif_listino_nome_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_tarif_listino_nome_id-error"
                        aria-invalid="<?= isset($errors['hotel_tarif_listino_nome_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_tarif_listino_nome_id'])): ?>
                        <div id="hotel_tarif_listino_nome_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_tarif_listino_nome_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_agenzia_attivazione" class="form-label">
                        <?= esc(lang('Hotels.hotel_agenzia_attivazione')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_agenzia_attivazione"
                        id="hotel_agenzia_attivazione"
                        value="<?= esc(old('hotel_agenzia_attivazione', $row->hotel_agenzia_attivazione ?? ($context['hotel_agenzia_attivazione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_agenzia_attivazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_agenzia_attivazione-error"
                        aria-invalid="<?= isset($errors['hotel_agenzia_attivazione']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_agenzia_attivazione'])): ?>
                        <div id="hotel_agenzia_attivazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_agenzia_attivazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_type_booking" class="form-label">
                        <?= esc(lang('Hotels.hotel_type_booking')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_type_booking"
                        id="hotel_type_booking"
                        value="<?= esc(old('hotel_type_booking', $row->hotel_type_booking ?? ($context['hotel_type_booking'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_type_booking']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_type_booking-error"
                        aria-invalid="<?= isset($errors['hotel_type_booking']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_type_booking'])): ?>
                        <div id="hotel_type_booking-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_type_booking']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_check_in" class="form-label">
                        <?= esc(lang('Hotels.hotel_check_in')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_check_in"
                        id="hotel_check_in"
                        value="<?= esc(old('hotel_check_in', $row->hotel_check_in ?? ($context['hotel_check_in'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_check_in']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_check_in-error"
                        aria-invalid="<?= isset($errors['hotel_check_in']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['hotel_check_in'])): ?>
                        <div id="hotel_check_in-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_check_in']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_check_out" class="form-label">
                        <?= esc(lang('Hotels.hotel_check_out')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_check_out"
                        id="hotel_check_out"
                        value="<?= esc(old('hotel_check_out', $row->hotel_check_out ?? ($context['hotel_check_out'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_check_out']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_check_out-error"
                        aria-invalid="<?= isset($errors['hotel_check_out']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['hotel_check_out'])): ?>
                        <div id="hotel_check_out-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_check_out']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_serv_inclusi" class="form-label">
                        <?= esc(lang('Hotels.hotel_serv_inclusi')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_serv_inclusi"
                        id="hotel_serv_inclusi"
                        value="<?= esc(old('hotel_serv_inclusi', $row->hotel_serv_inclusi ?? ($context['hotel_serv_inclusi'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_serv_inclusi']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_serv_inclusi-error"
                        aria-invalid="<?= isset($errors['hotel_serv_inclusi']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['hotel_serv_inclusi'])): ?>
                        <div id="hotel_serv_inclusi-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_serv_inclusi']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_cancel_pol" class="form-label">
                        <?= esc(lang('Hotels.hotel_cancel_pol')) ?>
                    </label>
                    <input
                        type="text"
                        name="hotel_cancel_pol"
                        id="hotel_cancel_pol"
                        value="<?= esc(old('hotel_cancel_pol', $row->hotel_cancel_pol ?? ($context['hotel_cancel_pol'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['hotel_cancel_pol']) ? 'is-invalid' : '' ?>"
                        aria-describedby="hotel_cancel_pol-error"
                        aria-invalid="<?= isset($errors['hotel_cancel_pol']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['hotel_cancel_pol'])): ?>
                        <div id="hotel_cancel_pol-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_cancel_pol']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="facebook" class="form-label">
                        <?= esc(lang('Hotels.facebook')) ?>
                    </label>
                    <input
                        type="text"
                        name="facebook"
                        id="facebook"
                        value="<?= esc(old('facebook', $row->facebook ?? ($context['facebook'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['facebook']) ? 'is-invalid' : '' ?>"
                        aria-describedby="facebook-error"
                        aria-invalid="<?= isset($errors['facebook']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['facebook'])): ?>
                        <div id="facebook-error" class="invalid-feedback d-block">
                            <?= esc($errors['facebook']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="google" class="form-label">
                        <?= esc(lang('Hotels.google')) ?>
                    </label>
                    <input
                        type="text"
                        name="google"
                        id="google"
                        value="<?= esc(old('google', $row->google ?? ($context['google'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['google']) ? 'is-invalid' : '' ?>"
                        aria-describedby="google-error"
                        aria-invalid="<?= isset($errors['google']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['google'])): ?>
                        <div id="google-error" class="invalid-feedback d-block">
                            <?= esc($errors['google']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="instagram" class="form-label">
                        <?= esc(lang('Hotels.instagram')) ?>
                    </label>
                    <input
                        type="text"
                        name="instagram"
                        id="instagram"
                        value="<?= esc(old('instagram', $row->instagram ?? ($context['instagram'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['instagram']) ? 'is-invalid' : '' ?>"
                        aria-describedby="instagram-error"
                        aria-invalid="<?= isset($errors['instagram']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['instagram'])): ?>
                        <div id="instagram-error" class="invalid-feedback d-block">
                            <?= esc($errors['instagram']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="twitter" class="form-label">
                        <?= esc(lang('Hotels.twitter')) ?>
                    </label>
                    <input
                        type="text"
                        name="twitter"
                        id="twitter"
                        value="<?= esc(old('twitter', $row->twitter ?? ($context['twitter'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['twitter']) ? 'is-invalid' : '' ?>"
                        aria-describedby="twitter-error"
                        aria-invalid="<?= isset($errors['twitter']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['twitter'])): ?>
                        <div id="twitter-error" class="invalid-feedback d-block">
                            <?= esc($errors['twitter']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="linkedin" class="form-label">
                        <?= esc(lang('Hotels.linkedin')) ?>
                    </label>
                    <input
                        type="text"
                        name="linkedin"
                        id="linkedin"
                        value="<?= esc(old('linkedin', $row->linkedin ?? ($context['linkedin'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['linkedin']) ? 'is-invalid' : '' ?>"
                        aria-describedby="linkedin-error"
                        aria-invalid="<?= isset($errors['linkedin']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['linkedin'])): ?>
                        <div id="linkedin-error" class="invalid-feedback d-block">
                            <?= esc($errors['linkedin']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="analytics" class="form-label">
                        <?= esc(lang('Hotels.analytics')) ?>
                    </label>
                    <input
                        type="text"
                        name="analytics"
                        id="analytics"
                        value="<?= esc(old('analytics', $row->analytics ?? ($context['analytics'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['analytics']) ? 'is-invalid' : '' ?>"
                        aria-describedby="analytics-error"
                        aria-invalid="<?= isset($errors['analytics']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['analytics'])): ?>
                        <div id="analytics-error" class="invalid-feedback d-block">
                            <?= esc($errors['analytics']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email_desk" class="form-label">
                        <?= esc(lang('Hotels.email_desk')) ?>
                    </label>
                    <input
                        type="email"
                        name="email_desk"
                        id="email_desk"
                        value="<?= esc(old('email_desk', $row->email_desk ?? ($context['email_desk'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['email_desk']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email_desk-error"
                        aria-invalid="<?= isset($errors['email_desk']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['email_desk'])): ?>
                        <div id="email_desk-error" class="invalid-feedback d-block">
                            <?= esc($errors['email_desk']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tripadvisor" class="form-label">
                        <?= esc(lang('Hotels.tripadvisor')) ?>
                    </label>
                    <input
                        type="text"
                        name="tripadvisor"
                        id="tripadvisor"
                        value="<?= esc(old('tripadvisor', $row->tripadvisor ?? ($context['tripadvisor'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tripadvisor']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tripadvisor-error"
                        aria-invalid="<?= isset($errors['tripadvisor']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['tripadvisor'])): ?>
                        <div id="tripadvisor-error" class="invalid-feedback d-block">
                            <?= esc($errors['tripadvisor']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="trip_rec_url" class="form-label">
                        <?= esc(lang('Hotels.trip_rec_url')) ?>
                    </label>
                    <input
                        type="url"
                        name="trip_rec_url"
                        id="trip_rec_url"
                        value="<?= esc(old('trip_rec_url', $row->trip_rec_url ?? ($context['trip_rec_url'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['trip_rec_url']) ? 'is-invalid' : '' ?>"
                        aria-describedby="trip_rec_url-error"
                        aria-invalid="<?= isset($errors['trip_rec_url']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['trip_rec_url'])): ?>
                        <div id="trip_rec_url-error" class="invalid-feedback d-block">
                            <?= esc($errors['trip_rec_url']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pec" class="form-label">
                        <?= esc(lang('Hotels.pec')) ?>
                    </label>
                    <input
                        type="text"
                        name="pec"
                        id="pec"
                        value="<?= esc(old('pec', $row->pec ?? ($context['pec'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pec']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pec-error"
                        aria-invalid="<?= isset($errors['pec']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['pec'])): ?>
                        <div id="pec-error" class="invalid-feedback d-block">
                            <?= esc($errors['pec']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sdi" class="form-label">
                        <?= esc(lang('Hotels.sdi')) ?>
                    </label>
                    <input
                        type="text"
                        name="sdi"
                        id="sdi"
                        value="<?= esc(old('sdi', $row->sdi ?? ($context['sdi'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sdi']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sdi-error"
                        aria-invalid="<?= isset($errors['sdi']) ? 'true' : 'false' ?>"
                        required maxlength="20"
                    >
                    <?php if (!empty($errors['sdi'])): ?>
                        <div id="sdi-error" class="invalid-feedback d-block">
                            <?= esc($errors['sdi']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ae_user" class="form-label">
                        <?= esc(lang('Hotels.ae_user')) ?>
                    </label>
                    <input
                        type="text"
                        name="ae_user"
                        id="ae_user"
                        value="<?= esc(old('ae_user', $row->ae_user ?? ($context['ae_user'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ae_user']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ae_user-error"
                        aria-invalid="<?= isset($errors['ae_user']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['ae_user'])): ?>
                        <div id="ae_user-error" class="invalid-feedback d-block">
                            <?= esc($errors['ae_user']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ae_password" class="form-label">
                        <?= esc(lang('Hotels.ae_password')) ?>
                    </label>
                    <input
                        type="text"
                        name="ae_password"
                        id="ae_password"
                        value="<?= esc(old('ae_password', $row->ae_password ?? ($context['ae_password'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ae_password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ae_password-error"
                        aria-invalid="<?= isset($errors['ae_password']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['ae_password'])): ?>
                        <div id="ae_password-error" class="invalid-feedback d-block">
                            <?= esc($errors['ae_password']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ae_pin" class="form-label">
                        <?= esc(lang('Hotels.ae_pin')) ?>
                    </label>
                    <input
                        type="text"
                        name="ae_pin"
                        id="ae_pin"
                        value="<?= esc(old('ae_pin', $row->ae_pin ?? ($context['ae_pin'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ae_pin']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ae_pin-error"
                        aria-invalid="<?= isset($errors['ae_pin']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['ae_pin'])): ?>
                        <div id="ae_pin-error" class="invalid-feedback d-block">
                            <?= esc($errors['ae_pin']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ae_codice_fiscale" class="form-label">
                        <?= esc(lang('Hotels.ae_codice_fiscale')) ?>
                    </label>
                    <input
                        type="text"
                        name="ae_codice_fiscale"
                        id="ae_codice_fiscale"
                        value="<?= esc(old('ae_codice_fiscale', $row->ae_codice_fiscale ?? ($context['ae_codice_fiscale'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ae_codice_fiscale']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ae_codice_fiscale-error"
                        aria-invalid="<?= isset($errors['ae_codice_fiscale']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['ae_codice_fiscale'])): ?>
                        <div id="ae_codice_fiscale-error" class="invalid-feedback d-block">
                            <?= esc($errors['ae_codice_fiscale']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sa_nome" class="form-label">
                        <?= esc(lang('Hotels.sa_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="sa_nome"
                        id="sa_nome"
                        value="<?= esc(old('sa_nome', $row->sa_nome ?? ($context['sa_nome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sa_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sa_nome-error"
                        aria-invalid="<?= isset($errors['sa_nome']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['sa_nome'])): ?>
                        <div id="sa_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['sa_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sa_chiave" class="form-label">
                        <?= esc(lang('Hotels.sa_chiave')) ?>
                    </label>
                    <input
                        type="text"
                        name="sa_chiave"
                        id="sa_chiave"
                        value="<?= esc(old('sa_chiave', $row->sa_chiave ?? ($context['sa_chiave'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sa_chiave']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sa_chiave-error"
                        aria-invalid="<?= isset($errors['sa_chiave']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['sa_chiave'])): ?>
                        <div id="sa_chiave-error" class="invalid-feedback d-block">
                            <?= esc($errors['sa_chiave']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ae_test" class="form-label">
                        <?= esc(lang('Hotels.ae_test')) ?>
                    </label>
                    <input
                        type="number"
                        name="ae_test"
                        id="ae_test"
                        value="<?= esc(old('ae_test', $row->ae_test ?? ($context['ae_test'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ae_test']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ae_test-error"
                        aria-invalid="<?= isset($errors['ae_test']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['ae_test'])): ?>
                        <div id="ae_test-error" class="invalid-feedback d-block">
                            <?= esc($errors['ae_test']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="citytax" class="form-label">
                        <?= esc(lang('Hotels.citytax')) ?>
                    </label>
                    <input
                        type="number"
                        name="citytax"
                        id="citytax"
                        value="<?= esc(old('citytax', $row->citytax ?? ($context['citytax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['citytax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="citytax-error"
                        aria-invalid="<?= isset($errors['citytax']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['citytax'])): ?>
                        <div id="citytax-error" class="invalid-feedback d-block">
                            <?= esc($errors['citytax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="wifi_network" class="form-label">
                        <?= esc(lang('Hotels.wifi_network')) ?>
                    </label>
                    <input
                        type="text"
                        name="wifi_network"
                        id="wifi_network"
                        value="<?= esc(old('wifi_network', $row->wifi_network ?? ($context['wifi_network'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['wifi_network']) ? 'is-invalid' : '' ?>"
                        aria-describedby="wifi_network-error"
                        aria-invalid="<?= isset($errors['wifi_network']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['wifi_network'])): ?>
                        <div id="wifi_network-error" class="invalid-feedback d-block">
                            <?= esc($errors['wifi_network']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="wifi_password" class="form-label">
                        <?= esc(lang('Hotels.wifi_password')) ?>
                    </label>
                    <input
                        type="text"
                        name="wifi_password"
                        id="wifi_password"
                        value="<?= esc(old('wifi_password', $row->wifi_password ?? ($context['wifi_password'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['wifi_password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="wifi_password-error"
                        aria-invalid="<?= isset($errors['wifi_password']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['wifi_password'])): ?>
                        <div id="wifi_password-error" class="invalid-feedback d-block">
                            <?= esc($errors['wifi_password']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="chek_email" class="form-label">
                        <?= esc(lang('Hotels.chek_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="chek_email"
                        id="chek_email"
                        value="<?= esc(old('chek_email', $row->chek_email ?? ($context['chek_email'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['chek_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="chek_email-error"
                        aria-invalid="<?= isset($errors['chek_email']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['chek_email'])): ?>
                        <div id="chek_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['chek_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="chek_tel" class="form-label">
                        <?= esc(lang('Hotels.chek_tel')) ?>
                    </label>
                    <input
                        type="number"
                        name="chek_tel"
                        id="chek_tel"
                        value="<?= esc(old('chek_tel', $row->chek_tel ?? ($context['chek_tel'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['chek_tel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="chek_tel-error"
                        aria-invalid="<?= isset($errors['chek_tel']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['chek_tel'])): ?>
                        <div id="chek_tel-error" class="invalid-feedback d-block">
                            <?= esc($errors['chek_tel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nexi_alias" class="form-label">
                        <?= esc(lang('Hotels.nexi_alias')) ?>
                    </label>
                    <input
                        type="text"
                        name="nexi_alias"
                        id="nexi_alias"
                        value="<?= esc(old('nexi_alias', $row->nexi_alias ?? ($context['nexi_alias'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nexi_alias']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nexi_alias-error"
                        aria-invalid="<?= isset($errors['nexi_alias']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nexi_alias'])): ?>
                        <div id="nexi_alias-error" class="invalid-feedback d-block">
                            <?= esc($errors['nexi_alias']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nexi_key" class="form-label">
                        <?= esc(lang('Hotels.nexi_key')) ?>
                    </label>
                    <input
                        type="text"
                        name="nexi_key"
                        id="nexi_key"
                        value="<?= esc(old('nexi_key', $row->nexi_key ?? ($context['nexi_key'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nexi_key']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nexi_key-error"
                        aria-invalid="<?= isset($errors['nexi_key']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nexi_key'])): ?>
                        <div id="nexi_key-error" class="invalid-feedback d-block">
                            <?= esc($errors['nexi_key']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nexi_url" class="form-label">
                        <?= esc(lang('Hotels.nexi_url')) ?>
                    </label>
                    <input
                        type="url"
                        name="nexi_url"
                        id="nexi_url"
                        value="<?= esc(old('nexi_url', $row->nexi_url ?? ($context['nexi_url'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nexi_url']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nexi_url-error"
                        aria-invalid="<?= isset($errors['nexi_url']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['nexi_url'])): ?>
                        <div id="nexi_url-error" class="invalid-feedback d-block">
                            <?= esc($errors['nexi_url']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cir_bdsr" class="form-label">
                        <?= esc(lang('Hotels.cir_bdsr')) ?>
                    </label>
                    <input
                        type="text"
                        name="cir_bdsr"
                        id="cir_bdsr"
                        value="<?= esc(old('cir_bdsr', $row->cir_bdsr ?? ($context['cir_bdsr'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['cir_bdsr']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cir_bdsr-error"
                        aria-invalid="<?= isset($errors['cir_bdsr']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['cir_bdsr'])): ?>
                        <div id="cir_bdsr-error" class="invalid-feedback d-block">
                            <?= esc($errors['cir_bdsr']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cin_bdsr" class="form-label">
                        <?= esc(lang('Hotels.cin_bdsr')) ?>
                    </label>
                    <input
                        type="text"
                        name="cin_bdsr"
                        id="cin_bdsr"
                        value="<?= esc(old('cin_bdsr', $row->cin_bdsr ?? ($context['cin_bdsr'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['cin_bdsr']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cin_bdsr-error"
                        aria-invalid="<?= isset($errors['cin_bdsr']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['cin_bdsr'])): ?>
                        <div id="cin_bdsr-error" class="invalid-feedback d-block">
                            <?= esc($errors['cin_bdsr']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="catastale_id" class="form-label">
                        <?= esc(lang('Hotels.catastale_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="catastale_id"
                        id="catastale_id"
                        value="<?= esc(old('catastale_id', $row->catastale_id ?? ($context['catastale_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['catastale_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="catastale_id-error"
                        aria-invalid="<?= isset($errors['catastale_id']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['catastale_id'])): ?>
                        <div id="catastale_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['catastale_id']) ?>
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

                    <a href="<?= site_url('hotels') ?>" class="btn btn-secondary">
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
            valueTarget.dispatchEvent(new Event('change', {bubbles: true}));
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
            valueTarget.dispatchEvent(new Event('change', {bubbles: true}));
            input.value = selected.textContent || '';
            results.classList.add('d-none');
        });

        results.addEventListener('dblclick', function () {
            results.dispatchEvent(new Event('change'));
        });
    });

    // Mantiene il link al record padre sincronizzato con il valore FK,
    // qualunque sia il controllo usato (hidden, select, input o select AJAX).
    const refreshParentLink = function (link) {
        const source = document.getElementById(link.dataset.valueSource || '');
        if (!source) return;
        const value = String(source.value || '').trim();
        const baseUrl = String(link.dataset.baseUrl || '').replace(/\/$/, '');
        if (value === '' || baseUrl === '') {
            link.href = '#';
            link.classList.add('disabled');
            link.setAttribute('aria-disabled', 'true');
            return;
        }
        link.href = baseUrl + '/' + encodeURIComponent(value);
        link.classList.remove('disabled');
        link.removeAttribute('aria-disabled');
    };

    document.querySelectorAll('.js-relation-parent-link').forEach(function (link) {
        const source = document.getElementById(link.dataset.valueSource || '');
        refreshParentLink(link);
        source?.addEventListener('change', function () { refreshParentLink(link); });
        source?.addEventListener('input', function () { refreshParentLink(link); });
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
