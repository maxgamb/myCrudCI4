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
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpCm.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
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
                    <label for="agenzia_id" class="form-label">
                        <?= esc(lang('ObmpCm.agenzia_id')) ?>
                    </label>
                    <select
                        name="agenzia_id"
                        id="agenzia_id"
                        class="form-select <?= isset($errors['agenzia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_id-error"
                        aria-invalid="<?= isset($errors['agenzia_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['agenzia_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('agenzia_id', $row->agenzia_id ?? ($context['agenzia_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="agenzia_id"
                            data-base-url="<?= site_url('agenzie/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('agenzie/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['agenzia_id'])): ?>
                        <div id="agenzia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_id_hotel_agenzia" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_id_hotel_agenzia')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_id_hotel_agenzia"
                        id="obmp_cm_id_hotel_agenzia"
                        value="<?= esc(old('obmp_cm_id_hotel_agenzia', $row->obmp_cm_id_hotel_agenzia ?? ($context['obmp_cm_id_hotel_agenzia'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_id_hotel_agenzia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_id_hotel_agenzia-error"
                        aria-invalid="<?= isset($errors['obmp_cm_id_hotel_agenzia']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['obmp_cm_id_hotel_agenzia'])): ?>
                        <div id="obmp_cm_id_hotel_agenzia-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_id_hotel_agenzia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_attiva" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_attiva')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_attiva"
                        id="obmp_cm_attiva"
                        value="<?= esc(old('obmp_cm_attiva', $row->obmp_cm_attiva ?? ($context['obmp_cm_attiva'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_attiva']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_attiva-error"
                        aria-invalid="<?= isset($errors['obmp_cm_attiva']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_attiva'])): ?>
                        <div id="obmp_cm_attiva-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_attiva']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_agenzia_url" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_agenzia_url')) ?>
                    </label>
                    <input
                        type="url"
                        name="obmp_cm_agenzia_url"
                        id="obmp_cm_agenzia_url"
                        value="<?= esc(old('obmp_cm_agenzia_url', $row->obmp_cm_agenzia_url ?? ($context['obmp_cm_agenzia_url'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_agenzia_url']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_agenzia_url-error"
                        aria-invalid="<?= isset($errors['obmp_cm_agenzia_url']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_agenzia_url'])): ?>
                        <div id="obmp_cm_agenzia_url-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_agenzia_url']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_agenzia_user" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_agenzia_user')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_agenzia_user"
                        id="obmp_cm_agenzia_user"
                        value="<?= esc(old('obmp_cm_agenzia_user', $row->obmp_cm_agenzia_user ?? ($context['obmp_cm_agenzia_user'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_agenzia_user']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_agenzia_user-error"
                        aria-invalid="<?= isset($errors['obmp_cm_agenzia_user']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_agenzia_user'])): ?>
                        <div id="obmp_cm_agenzia_user-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_agenzia_user']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_agenzia_password" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_agenzia_password')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_agenzia_password"
                        id="obmp_cm_agenzia_password"
                        value="<?= esc(old('obmp_cm_agenzia_password', $row->obmp_cm_agenzia_password ?? ($context['obmp_cm_agenzia_password'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_agenzia_password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_agenzia_password-error"
                        aria-invalid="<?= isset($errors['obmp_cm_agenzia_password']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_agenzia_password'])): ?>
                        <div id="obmp_cm_agenzia_password-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_agenzia_password']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_ws_agenzia_url" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_url')) ?>
                    </label>
                    <input
                        type="url"
                        name="obmp_cm_ws_agenzia_url"
                        id="obmp_cm_ws_agenzia_url"
                        value="<?= esc(old('obmp_cm_ws_agenzia_url', $row->obmp_cm_ws_agenzia_url ?? ($context['obmp_cm_ws_agenzia_url'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_ws_agenzia_url']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_ws_agenzia_url-error"
                        aria-invalid="<?= isset($errors['obmp_cm_ws_agenzia_url']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_ws_agenzia_url'])): ?>
                        <div id="obmp_cm_ws_agenzia_url-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_ws_agenzia_url']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_ws_agenzia_user" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_user')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_ws_agenzia_user"
                        id="obmp_cm_ws_agenzia_user"
                        value="<?= esc(old('obmp_cm_ws_agenzia_user', $row->obmp_cm_ws_agenzia_user ?? ($context['obmp_cm_ws_agenzia_user'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_ws_agenzia_user']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_ws_agenzia_user-error"
                        aria-invalid="<?= isset($errors['obmp_cm_ws_agenzia_user']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_ws_agenzia_user'])): ?>
                        <div id="obmp_cm_ws_agenzia_user-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_ws_agenzia_user']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_ws_agenzia_password" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_password')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_ws_agenzia_password"
                        id="obmp_cm_ws_agenzia_password"
                        value="<?= esc(old('obmp_cm_ws_agenzia_password', $row->obmp_cm_ws_agenzia_password ?? ($context['obmp_cm_ws_agenzia_password'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_ws_agenzia_password']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_ws_agenzia_password-error"
                        aria-invalid="<?= isset($errors['obmp_cm_ws_agenzia_password']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_ws_agenzia_password'])): ?>
                        <div id="obmp_cm_ws_agenzia_password-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_ws_agenzia_password']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id1" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id1')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id1"
                        id="obmp_cm_tipologia_id1"
                        value="<?= esc(old('obmp_cm_tipologia_id1', $row->obmp_cm_tipologia_id1 ?? ($context['obmp_cm_tipologia_id1'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id1-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id1']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id1'])): ?>
                        <div id="obmp_cm_tipologia_id1-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id1" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id1')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id1"
                        id="obmp_cm_room_id1"
                        value="<?= esc(old('obmp_cm_room_id1', $row->obmp_cm_room_id1 ?? ($context['obmp_cm_room_id1'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id1-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id1']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id1'])): ?>
                        <div id="obmp_cm_room_id1-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id2" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id2')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id2"
                        id="obmp_cm_tipologia_id2"
                        value="<?= esc(old('obmp_cm_tipologia_id2', $row->obmp_cm_tipologia_id2 ?? ($context['obmp_cm_tipologia_id2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id2-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id2']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id2'])): ?>
                        <div id="obmp_cm_tipologia_id2-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id2" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id2')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id2"
                        id="obmp_cm_room_id2"
                        value="<?= esc(old('obmp_cm_room_id2', $row->obmp_cm_room_id2 ?? ($context['obmp_cm_room_id2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id2-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id2']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id2'])): ?>
                        <div id="obmp_cm_room_id2-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id3" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id3')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id3"
                        id="obmp_cm_tipologia_id3"
                        value="<?= esc(old('obmp_cm_tipologia_id3', $row->obmp_cm_tipologia_id3 ?? ($context['obmp_cm_tipologia_id3'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id3-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id3']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id3'])): ?>
                        <div id="obmp_cm_tipologia_id3-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id3" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id3')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id3"
                        id="obmp_cm_room_id3"
                        value="<?= esc(old('obmp_cm_room_id3', $row->obmp_cm_room_id3 ?? ($context['obmp_cm_room_id3'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id3-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id3']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id3'])): ?>
                        <div id="obmp_cm_room_id3-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id4" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id4')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id4"
                        id="obmp_cm_tipologia_id4"
                        value="<?= esc(old('obmp_cm_tipologia_id4', $row->obmp_cm_tipologia_id4 ?? ($context['obmp_cm_tipologia_id4'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id4-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id4']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id4'])): ?>
                        <div id="obmp_cm_tipologia_id4-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id4" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id4')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id4"
                        id="obmp_cm_room_id4"
                        value="<?= esc(old('obmp_cm_room_id4', $row->obmp_cm_room_id4 ?? ($context['obmp_cm_room_id4'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id4-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id4']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id4'])): ?>
                        <div id="obmp_cm_room_id4-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id5" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id5')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id5"
                        id="obmp_cm_tipologia_id5"
                        value="<?= esc(old('obmp_cm_tipologia_id5', $row->obmp_cm_tipologia_id5 ?? ($context['obmp_cm_tipologia_id5'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id5']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id5-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id5']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id5'])): ?>
                        <div id="obmp_cm_tipologia_id5-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id5']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id5" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id5')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id5"
                        id="obmp_cm_room_id5"
                        value="<?= esc(old('obmp_cm_room_id5', $row->obmp_cm_room_id5 ?? ($context['obmp_cm_room_id5'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id5']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id5-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id5']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id5'])): ?>
                        <div id="obmp_cm_room_id5-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id5']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id6" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id6')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id6"
                        id="obmp_cm_tipologia_id6"
                        value="<?= esc(old('obmp_cm_tipologia_id6', $row->obmp_cm_tipologia_id6 ?? ($context['obmp_cm_tipologia_id6'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id6']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id6-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id6']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id6'])): ?>
                        <div id="obmp_cm_tipologia_id6-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id6']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id6" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id6')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id6"
                        id="obmp_cm_room_id6"
                        value="<?= esc(old('obmp_cm_room_id6', $row->obmp_cm_room_id6 ?? ($context['obmp_cm_room_id6'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id6']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id6-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id6']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id6'])): ?>
                        <div id="obmp_cm_room_id6-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id6']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id7" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id7')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id7"
                        id="obmp_cm_tipologia_id7"
                        value="<?= esc(old('obmp_cm_tipologia_id7', $row->obmp_cm_tipologia_id7 ?? ($context['obmp_cm_tipologia_id7'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id7']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id7-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id7']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id7'])): ?>
                        <div id="obmp_cm_tipologia_id7-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id7']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id7" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id7')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id7"
                        id="obmp_cm_room_id7"
                        value="<?= esc(old('obmp_cm_room_id7', $row->obmp_cm_room_id7 ?? ($context['obmp_cm_room_id7'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id7']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id7-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id7']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id7'])): ?>
                        <div id="obmp_cm_room_id7-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id7']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id8" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id8')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id8"
                        id="obmp_cm_tipologia_id8"
                        value="<?= esc(old('obmp_cm_tipologia_id8', $row->obmp_cm_tipologia_id8 ?? ($context['obmp_cm_tipologia_id8'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id8']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id8-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id8']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id8'])): ?>
                        <div id="obmp_cm_tipologia_id8-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id8']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id8" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id8')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id8"
                        id="obmp_cm_room_id8"
                        value="<?= esc(old('obmp_cm_room_id8', $row->obmp_cm_room_id8 ?? ($context['obmp_cm_room_id8'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id8']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id8-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id8']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id8'])): ?>
                        <div id="obmp_cm_room_id8-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id8']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id9" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id9')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id9"
                        id="obmp_cm_tipologia_id9"
                        value="<?= esc(old('obmp_cm_tipologia_id9', $row->obmp_cm_tipologia_id9 ?? ($context['obmp_cm_tipologia_id9'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id9']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id9-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id9']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id9'])): ?>
                        <div id="obmp_cm_tipologia_id9-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id9']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id9" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id9')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id9"
                        id="obmp_cm_room_id9"
                        value="<?= esc(old('obmp_cm_room_id9', $row->obmp_cm_room_id9 ?? ($context['obmp_cm_room_id9'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id9']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id9-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id9']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id9'])): ?>
                        <div id="obmp_cm_room_id9-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id9']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_tipologia_id10" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_tipologia_id10')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_tipologia_id10"
                        id="obmp_cm_tipologia_id10"
                        value="<?= esc(old('obmp_cm_tipologia_id10', $row->obmp_cm_tipologia_id10 ?? ($context['obmp_cm_tipologia_id10'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_tipologia_id10']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_tipologia_id10-error"
                        aria-invalid="<?= isset($errors['obmp_cm_tipologia_id10']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_tipologia_id10'])): ?>
                        <div id="obmp_cm_tipologia_id10-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_tipologia_id10']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_room_id10" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_room_id10')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_room_id10"
                        id="obmp_cm_room_id10"
                        value="<?= esc(old('obmp_cm_room_id10', $row->obmp_cm_room_id10 ?? ($context['obmp_cm_room_id10'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_room_id10']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_room_id10-error"
                        aria-invalid="<?= isset($errors['obmp_cm_room_id10']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_room_id10'])): ?>
                        <div id="obmp_cm_room_id10-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_room_id10']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_moltiplicatore" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_moltiplicatore')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_moltiplicatore"
                        id="obmp_cm_moltiplicatore"
                        value="<?= esc(old('obmp_cm_moltiplicatore', $row->obmp_cm_moltiplicatore ?? ($context['obmp_cm_moltiplicatore'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_moltiplicatore']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_moltiplicatore-error"
                        aria-invalid="<?= isset($errors['obmp_cm_moltiplicatore']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_moltiplicatore'])): ?>
                        <div id="obmp_cm_moltiplicatore-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_moltiplicatore']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_max_camere" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_max_camere')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_max_camere"
                        id="obmp_cm_max_camere"
                        value="<?= esc(old('obmp_cm_max_camere', $row->obmp_cm_max_camere ?? ($context['obmp_cm_max_camere'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_max_camere']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_max_camere-error"
                        aria-invalid="<?= isset($errors['obmp_cm_max_camere']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_max_camere'])): ?>
                        <div id="obmp_cm_max_camere-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_max_camere']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_min_camare" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_min_camare')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_min_camare"
                        id="obmp_cm_min_camare"
                        value="<?= esc(old('obmp_cm_min_camare', $row->obmp_cm_min_camare ?? ($context['obmp_cm_min_camare'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_min_camare']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_min_camare-error"
                        aria-invalid="<?= isset($errors['obmp_cm_min_camare']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_min_camare'])): ?>
                        <div id="obmp_cm_min_camare-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_min_camare']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_utente_id" class="form-label">
                        <?= esc(lang('ObmpCm.obmp_cm_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="obmp_cm_utente_id"
                        id="obmp_cm_utente_id"
                        value="<?= esc(old('obmp_cm_utente_id', $row->obmp_cm_utente_id ?? ($context['obmp_cm_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_utente_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_utente_id'])): ?>
                        <div id="obmp_cm_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_utente_id']) ?>
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

                    <a href="<?= site_url('obmp_cm') ?>" class="btn btn-secondary">
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
