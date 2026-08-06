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

                <div class="d-none">
                    <input type="hidden" name="hotel_id" id="hotel_id" value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>">
                    <?php if (!empty($errors['hotel_id'])): ?>
                        <div id="hotel_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['hotel_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-none">
                    <input type="hidden" name="preno_in_data" id="preno_in_data" value="<?= esc(old('preno_in_data', $row->preno_in_data ?? '')) ?>">
                    <?php if (!empty($errors['preno_in_data'])): ?>
                        <div id="preno_in_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_in_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-12">
                    <label for="preno_importo" class="form-label">
                        <?= esc(lang('Agenda.preno_importo')) ?>
                    </label>
                    <input
                        type="number"
                        name="preno_importo"
                        id="preno_importo"
                        value="<?= esc(old('preno_importo', $row->preno_importo ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_importo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_importo-error"
                        aria-invalid="<?= isset($errors['preno_importo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['preno_importo'])): ?>
                        <div id="preno_importo-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_importo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-none">
                    <input type="hidden" name="preno_impoto_mod" id="preno_impoto_mod" value="<?= esc(old('preno_impoto_mod', $row->preno_impoto_mod ?? '')) ?>">
                    <?php if (!empty($errors['preno_impoto_mod'])): ?>
                        <div id="preno_impoto_mod-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_impoto_mod']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_dal" class="form-label">
                        <?= esc(lang('Agenda.preno_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="preno_dal"
                        id="preno_dal"
                        value="<?= esc(old('preno_dal', $row->preno_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_dal-error"
                        aria-invalid="<?= isset($errors['preno_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['preno_dal'])): ?>
                        <div id="preno_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_al" class="form-label">
                        <?= esc(lang('Agenda.preno_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="preno_al"
                        id="preno_al"
                        value="<?= esc(old('preno_al', $row->preno_al ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_al-error"
                        aria-invalid="<?= isset($errors['preno_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['preno_al'])): ?>
                        <div id="preno_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-none">
                    <input type="hidden" name="preno_n_notti" id="preno_n_notti" value="<?= esc(old('preno_n_notti', $row->preno_n_notti ?? '')) ?>">
                    <?php if (!empty($errors['preno_n_notti'])): ?>
                        <div id="preno_n_notti-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_n_notti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_arr_ore" class="form-label">
                        <?= esc(lang('Agenda.preno_arr_ore')) ?>
                    </label>
                    <select
                        name="preno_arr_ore"
                        id="preno_arr_ore"
                        class="form-select <?= isset($errors['preno_arr_ore']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_arr_ore-error"
                        aria-invalid="<?= isset($errors['preno_arr_ore']) ? 'true' : 'false' ?>"
                        maxlength="20"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_arr_ore'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_arr_ore', $row->preno_arr_ore ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_arr_ore'])): ?>
                        <div id="preno_arr_ore-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_arr_ore']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_trattamento" class="form-label">
                        <?= esc(lang('Agenda.preno_trattamento')) ?>
                    </label>
                    <select
                        name="preno_trattamento"
                        id="preno_trattamento"
                        class="form-select <?= isset($errors['preno_trattamento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_trattamento-error"
                        aria-invalid="<?= isset($errors['preno_trattamento']) ? 'true' : 'false' ?>"
                        required maxlength="3"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_trattamento'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_trattamento', $row->preno_trattamento ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_trattamento'])): ?>
                        <div id="preno_trattamento-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_trattamento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="t1" class="form-label">
                        <?= esc(lang('Agenda.t1')) ?>
                    </label>
                    <select
                        name="t1"
                        id="t1"
                        class="form-select <?= isset($errors['t1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="t1-error"
                        aria-invalid="<?= isset($errors['t1']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['t1'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('t1', $row->t1 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['t1'])): ?>
                        <div id="t1-error" class="invalid-feedback d-block">
                            <?= esc($errors['t1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="q1" class="form-label">
                        <?= esc(lang('Agenda.q1')) ?>
                    </label>
                    <input
                        type="number"
                        name="q1"
                        id="q1"
                        value="<?= esc(old('q1', $row->q1 ?? '')) ?>"
                        class="form-control <?= isset($errors['q1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="q1-error"
                        aria-invalid="<?= isset($errors['q1']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['q1'])): ?>
                        <div id="q1-error" class="invalid-feedback d-block">
                            <?= esc($errors['q1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="p1" class="form-label">
                        <?= esc(lang('Agenda.p1')) ?>
                    </label>
                    <input
                        type="number"
                        name="p1"
                        id="p1"
                        value="<?= esc(old('p1', $row->p1 ?? '')) ?>"
                        class="form-control <?= isset($errors['p1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="p1-error"
                        aria-invalid="<?= isset($errors['p1']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['p1'])): ?>
                        <div id="p1-error" class="invalid-feedback d-block">
                            <?= esc($errors['p1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="t2" class="form-label">
                        <?= esc(lang('Agenda.t2')) ?>
                    </label>
                    <select
                        name="t2"
                        id="t2"
                        class="form-select <?= isset($errors['t2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="t2-error"
                        aria-invalid="<?= isset($errors['t2']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['t2'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('t2', $row->t2 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['t2'])): ?>
                        <div id="t2-error" class="invalid-feedback d-block">
                            <?= esc($errors['t2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="q2" class="form-label">
                        <?= esc(lang('Agenda.q2')) ?>
                    </label>
                    <input
                        type="number"
                        name="q2"
                        id="q2"
                        value="<?= esc(old('q2', $row->q2 ?? '')) ?>"
                        class="form-control <?= isset($errors['q2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="q2-error"
                        aria-invalid="<?= isset($errors['q2']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['q2'])): ?>
                        <div id="q2-error" class="invalid-feedback d-block">
                            <?= esc($errors['q2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="p2" class="form-label">
                        <?= esc(lang('Agenda.p2')) ?>
                    </label>
                    <input
                        type="number"
                        name="p2"
                        id="p2"
                        value="<?= esc(old('p2', $row->p2 ?? '')) ?>"
                        class="form-control <?= isset($errors['p2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="p2-error"
                        aria-invalid="<?= isset($errors['p2']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['p2'])): ?>
                        <div id="p2-error" class="invalid-feedback d-block">
                            <?= esc($errors['p2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="t3" class="form-label">
                        <?= esc(lang('Agenda.t3')) ?>
                    </label>
                    <select
                        name="t3"
                        id="t3"
                        class="form-select <?= isset($errors['t3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="t3-error"
                        aria-invalid="<?= isset($errors['t3']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['t3'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('t3', $row->t3 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['t3'])): ?>
                        <div id="t3-error" class="invalid-feedback d-block">
                            <?= esc($errors['t3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="q3" class="form-label">
                        <?= esc(lang('Agenda.q3')) ?>
                    </label>
                    <input
                        type="number"
                        name="q3"
                        id="q3"
                        value="<?= esc(old('q3', $row->q3 ?? '')) ?>"
                        class="form-control <?= isset($errors['q3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="q3-error"
                        aria-invalid="<?= isset($errors['q3']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['q3'])): ?>
                        <div id="q3-error" class="invalid-feedback d-block">
                            <?= esc($errors['q3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="p3" class="form-label">
                        <?= esc(lang('Agenda.p3')) ?>
                    </label>
                    <input
                        type="number"
                        name="p3"
                        id="p3"
                        value="<?= esc(old('p3', $row->p3 ?? '')) ?>"
                        class="form-control <?= isset($errors['p3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="p3-error"
                        aria-invalid="<?= isset($errors['p3']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['p3'])): ?>
                        <div id="p3-error" class="invalid-feedback d-block">
                            <?= esc($errors['p3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="t4" class="form-label">
                        <?= esc(lang('Agenda.t4')) ?>
                    </label>
                    <select
                        name="t4"
                        id="t4"
                        class="form-select <?= isset($errors['t4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="t4-error"
                        aria-invalid="<?= isset($errors['t4']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['t4'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('t4', $row->t4 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['t4'])): ?>
                        <div id="t4-error" class="invalid-feedback d-block">
                            <?= esc($errors['t4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="q4" class="form-label">
                        <?= esc(lang('Agenda.q4')) ?>
                    </label>
                    <input
                        type="number"
                        name="q4"
                        id="q4"
                        value="<?= esc(old('q4', $row->q4 ?? '')) ?>"
                        class="form-control <?= isset($errors['q4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="q4-error"
                        aria-invalid="<?= isset($errors['q4']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['q4'])): ?>
                        <div id="q4-error" class="invalid-feedback d-block">
                            <?= esc($errors['q4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="p4" class="form-label">
                        <?= esc(lang('Agenda.p4')) ?>
                    </label>
                    <input
                        type="number"
                        name="p4"
                        id="p4"
                        value="<?= esc(old('p4', $row->p4 ?? '')) ?>"
                        class="form-control <?= isset($errors['p4']) ? 'is-invalid' : '' ?>"
                        aria-describedby="p4-error"
                        aria-invalid="<?= isset($errors['p4']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['p4'])): ?>
                        <div id="p4-error" class="invalid-feedback d-block">
                            <?= esc($errors['p4']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="t5" class="form-label">
                        <?= esc(lang('Agenda.t5')) ?>
                    </label>
                    <select
                        name="t5"
                        id="t5"
                        class="form-select <?= isset($errors['t5']) ? 'is-invalid' : '' ?>"
                        aria-describedby="t5-error"
                        aria-invalid="<?= isset($errors['t5']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['t5'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('t5', $row->t5 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['t5'])): ?>
                        <div id="t5-error" class="invalid-feedback d-block">
                            <?= esc($errors['t5']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="q5" class="form-label">
                        <?= esc(lang('Agenda.q5')) ?>
                    </label>
                    <input
                        type="number"
                        name="q5"
                        id="q5"
                        value="<?= esc(old('q5', $row->q5 ?? '')) ?>"
                        class="form-control <?= isset($errors['q5']) ? 'is-invalid' : '' ?>"
                        aria-describedby="q5-error"
                        aria-invalid="<?= isset($errors['q5']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['q5'])): ?>
                        <div id="q5-error" class="invalid-feedback d-block">
                            <?= esc($errors['q5']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="p5" class="form-label">
                        <?= esc(lang('Agenda.p5')) ?>
                    </label>
                    <input
                        type="number"
                        name="p5"
                        id="p5"
                        value="<?= esc(old('p5', $row->p5 ?? '')) ?>"
                        class="form-control <?= isset($errors['p5']) ? 'is-invalid' : '' ?>"
                        aria-describedby="p5-error"
                        aria-invalid="<?= isset($errors['p5']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['p5'])): ?>
                        <div id="p5-error" class="invalid-feedback d-block">
                            <?= esc($errors['p5']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="t6" class="form-label">
                        <?= esc(lang('Agenda.t6')) ?>
                    </label>
                    <select
                        name="t6"
                        id="t6"
                        class="form-select <?= isset($errors['t6']) ? 'is-invalid' : '' ?>"
                        aria-describedby="t6-error"
                        aria-invalid="<?= isset($errors['t6']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['t6'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('t6', $row->t6 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['t6'])): ?>
                        <div id="t6-error" class="invalid-feedback d-block">
                            <?= esc($errors['t6']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="q6" class="form-label">
                        <?= esc(lang('Agenda.q6')) ?>
                    </label>
                    <input
                        type="number"
                        name="q6"
                        id="q6"
                        value="<?= esc(old('q6', $row->q6 ?? '')) ?>"
                        class="form-control <?= isset($errors['q6']) ? 'is-invalid' : '' ?>"
                        aria-describedby="q6-error"
                        aria-invalid="<?= isset($errors['q6']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['q6'])): ?>
                        <div id="q6-error" class="invalid-feedback d-block">
                            <?= esc($errors['q6']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-2">
                    <label for="p6" class="form-label">
                        <?= esc(lang('Agenda.p6')) ?>
                    </label>
                    <input
                        type="number"
                        name="p6"
                        id="p6"
                        value="<?= esc(old('p6', $row->p6 ?? '')) ?>"
                        class="form-control <?= isset($errors['p6']) ? 'is-invalid' : '' ?>"
                        aria-describedby="p6-error"
                        aria-invalid="<?= isset($errors['p6']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['p6'])): ?>
                        <div id="p6-error" class="invalid-feedback d-block">
                            <?= esc($errors['p6']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_nome" class="form-label">
                        <?= esc(lang('Agenda.preno_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_nome"
                        id="preno_nome"
                        value="<?= esc(old('preno_nome', $row->preno_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_nome-error"
                        aria-invalid="<?= isset($errors['preno_nome']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['preno_nome'])): ?>
                        <div id="preno_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_cogno" class="form-label">
                        <?= esc(lang('Agenda.preno_cogno')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_cogno"
                        id="preno_cogno"
                        value="<?= esc(old('preno_cogno', $row->preno_cogno ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_cogno']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_cogno-error"
                        aria-invalid="<?= isset($errors['preno_cogno']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['preno_cogno'])): ?>
                        <div id="preno_cogno-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_cogno']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_agenzia" class="form-label">
                        <?= esc(lang('Agenda.preno_agenzia')) ?>
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
                    <label for="voucher_id" class="form-label">
                        <?= esc(lang('Agenda.voucher_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="voucher_id"
                        id="voucher_id"
                        value="<?= esc(old('voucher_id', $row->voucher_id ?? '')) ?>"
                        class="form-control <?= isset($errors['voucher_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="voucher_id-error"
                        aria-invalid="<?= isset($errors['voucher_id']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['voucher_id'])): ?>
                        <div id="voucher_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['voucher_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ota_voucher" class="form-label">
                        <?= esc(lang('Agenda.ota_voucher')) ?>
                    </label>
                    <input
                        type="text"
                        name="ota_voucher"
                        id="ota_voucher"
                        value="<?= esc(old('ota_voucher', $row->ota_voucher ?? '')) ?>"
                        class="form-control <?= isset($errors['ota_voucher']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ota_voucher-error"
                        aria-invalid="<?= isset($errors['ota_voucher']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['ota_voucher'])): ?>
                        <div id="ota_voucher-error" class="invalid-feedback d-block">
                            <?= esc($errors['ota_voucher']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-none">
                    <input type="hidden" name="allotment_id" id="allotment_id" value="<?= esc(old('allotment_id', $row->allotment_id ?? '')) ?>">
                    <?php if (!empty($errors['allotment_id'])): ?>
                        <div id="allotment_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['allotment_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_cc_tip" class="form-label">
                        <?= esc(lang('Agenda.preno_cc_tip')) ?>
                    </label>
                    <select
                        name="preno_cc_tip"
                        id="preno_cc_tip"
                        class="form-select <?= isset($errors['preno_cc_tip']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_cc_tip-error"
                        aria-invalid="<?= isset($errors['preno_cc_tip']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_cc_tip'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_cc_tip', $row->preno_cc_tip ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_cc_tip'])): ?>
                        <div id="preno_cc_tip-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_cc_tip']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_cc_n" class="form-label">
                        <?= esc(lang('Agenda.preno_cc_n')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_cc_n"
                        id="preno_cc_n"
                        value="<?= esc(old('preno_cc_n', $row->preno_cc_n ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_cc_n']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_cc_n-error"
                        aria-invalid="<?= isset($errors['preno_cc_n']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['preno_cc_n'])): ?>
                        <div id="preno_cc_n-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_cc_n']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_cc_scad" class="form-label">
                        <?= esc(lang('Agenda.preno_cc_scad')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_cc_scad"
                        id="preno_cc_scad"
                        value="<?= esc(old('preno_cc_scad', $row->preno_cc_scad ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_cc_scad']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_cc_scad-error"
                        aria-invalid="<?= isset($errors['preno_cc_scad']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['preno_cc_scad'])): ?>
                        <div id="preno_cc_scad-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_cc_scad']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_tel" class="form-label">
                        <?= esc(lang('Agenda.preno_tel')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_tel"
                        id="preno_tel"
                        value="<?= esc(old('preno_tel', $row->preno_tel ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_tel']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_tel-error"
                        aria-invalid="<?= isset($errors['preno_tel']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['preno_tel'])): ?>
                        <div id="preno_tel-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_tel']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-none">
                    <input type="hidden" name="preno_fax" id="preno_fax" value="<?= esc(old('preno_fax', $row->preno_fax ?? '')) ?>">
                    <?php if (!empty($errors['preno_fax'])): ?>
                        <div id="preno_fax-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_fax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_email" class="form-label">
                        <?= esc(lang('Agenda.preno_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="preno_email"
                        id="preno_email"
                        value="<?= esc(old('preno_email', $row->preno_email ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_email-error"
                        aria-invalid="<?= isset($errors['preno_email']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['preno_email'])): ?>
                        <div id="preno_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_mercato" class="form-label">
                        <?= esc(lang('Agenda.preno_mercato')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_mercato"
                        id="preno_mercato"
                        value="<?= esc(old('preno_mercato', $row->preno_mercato ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_mercato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_mercato-error"
                        aria-invalid="<?= isset($errors['preno_mercato']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['preno_mercato'])): ?>
                        <div id="preno_mercato-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_mercato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nazione_iso2" class="form-label">
                        <?= esc(lang('Agenda.nazione_iso2')) ?>
                    </label>
                    <select
                        name="nazione_iso2"
                        id="nazione_iso2"
                        class="form-select <?= isset($errors['nazione_iso2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nazione_iso2-error"
                        aria-invalid="<?= isset($errors['nazione_iso2']) ? 'true' : 'false' ?>"
                        maxlength="5"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['nazione_iso2'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('nazione_iso2', $row->nazione_iso2 ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['nazione_iso2'])): ?>
                        <div id="nazione_iso2-error" class="invalid-feedback d-block">
                            <?= esc($errors['nazione_iso2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_note" class="form-label">
                        <?= esc(lang('Agenda.preno_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="preno_note"
                        id="preno_note"
                        value="<?= esc(old('preno_note', $row->preno_note ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_note-error"
                        aria-invalid="<?= isset($errors['preno_note']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['preno_note'])): ?>
                        <div id="preno_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_fax" class="form-label">
                        <?= esc(lang('Agenda.preno_doc_fax')) ?>
                    </label>
                    <input type="hidden" name="preno_doc_fax" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_fax"
                            id="preno_doc_fax"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_fax']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_fax', $row->preno_doc_fax ?? '') ? 'checked' : '' ?>
                        aria-describedby="preno_doc_fax-error"
                        aria-invalid="<?= isset($errors['preno_doc_fax']) ? 'true' : 'false' ?>"
                        maxlength="2"
                        >
                    </div>
                    <?php if (!empty($errors['preno_doc_fax'])): ?>
                        <div id="preno_doc_fax-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_doc_fax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_email" class="form-label">
                        <?= esc(lang('Agenda.preno_doc_email')) ?>
                    </label>
                    <input type="hidden" name="preno_doc_email" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_email"
                            id="preno_doc_email"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_email']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_email', $row->preno_doc_email ?? '') ? 'checked' : '' ?>
                        aria-describedby="preno_doc_email-error"
                        aria-invalid="<?= isset($errors['preno_doc_email']) ? 'true' : 'false' ?>"
                        maxlength="2"
                        >
                    </div>
                    <?php if (!empty($errors['preno_doc_email'])): ?>
                        <div id="preno_doc_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_doc_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_form" class="form-label">
                        <?= esc(lang('Agenda.preno_doc_form')) ?>
                    </label>
                    <input type="hidden" name="preno_doc_form" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_form"
                            id="preno_doc_form"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_form']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_form', $row->preno_doc_form ?? '') ? 'checked' : '' ?>
                        aria-describedby="preno_doc_form-error"
                        aria-invalid="<?= isset($errors['preno_doc_form']) ? 'true' : 'false' ?>"
                        maxlength="2"
                        >
                    </div>
                    <?php if (!empty($errors['preno_doc_form'])): ?>
                        <div id="preno_doc_form-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_doc_form']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_mail" class="form-label">
                        <?= esc(lang('Agenda.preno_doc_mail')) ?>
                    </label>
                    <input type="hidden" name="preno_doc_mail" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_mail"
                            id="preno_doc_mail"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_mail']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_mail', $row->preno_doc_mail ?? '') ? 'checked' : '' ?>
                        aria-describedby="preno_doc_mail-error"
                        aria-invalid="<?= isset($errors['preno_doc_mail']) ? 'true' : 'false' ?>"
                        maxlength="2"
                        >
                    </div>
                    <?php if (!empty($errors['preno_doc_mail'])): ?>
                        <div id="preno_doc_mail-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_doc_mail']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_vaglia" class="form-label">
                        <?= esc(lang('Agenda.preno_doc_vaglia')) ?>
                    </label>
                    <input type="hidden" name="preno_doc_vaglia" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_vaglia"
                            id="preno_doc_vaglia"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_vaglia']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_vaglia', $row->preno_doc_vaglia ?? '') ? 'checked' : '' ?>
                        aria-describedby="preno_doc_vaglia-error"
                        aria-invalid="<?= isset($errors['preno_doc_vaglia']) ? 'true' : 'false' ?>"
                        maxlength="2"
                        >
                    </div>
                    <?php if (!empty($errors['preno_doc_vaglia'])): ?>
                        <div id="preno_doc_vaglia-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_doc_vaglia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_woucher" class="form-label">
                        <?= esc(lang('Agenda.preno_doc_woucher')) ?>
                    </label>
                    <input type="hidden" name="preno_doc_woucher" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_woucher"
                            id="preno_doc_woucher"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_woucher']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_woucher', $row->preno_doc_woucher ?? '') ? 'checked' : '' ?>
                        aria-describedby="preno_doc_woucher-error"
                        aria-invalid="<?= isset($errors['preno_doc_woucher']) ? 'true' : 'false' ?>"
                        maxlength="2"
                        >
                    </div>
                    <?php if (!empty($errors['preno_doc_woucher'])): ?>
                        <div id="preno_doc_woucher-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_doc_woucher']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_pag_modalita" class="form-label">
                        <?= esc(lang('Agenda.preno_pag_modalita')) ?>
                    </label>
                    <select
                        name="preno_pag_modalita"
                        id="preno_pag_modalita"
                        class="form-select <?= isset($errors['preno_pag_modalita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_pag_modalita-error"
                        aria-invalid="<?= isset($errors['preno_pag_modalita']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_pag_modalita'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_pag_modalita', $row->preno_pag_modalita ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_pag_modalita'])): ?>
                        <div id="preno_pag_modalita-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_pag_modalita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_caparra" class="form-label">
                        <?= esc(lang('Agenda.preno_caparra')) ?>
                    </label>
                    <input
                        type="number"
                        name="preno_caparra"
                        id="preno_caparra"
                        value="<?= esc(old('preno_caparra', $row->preno_caparra ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_caparra']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_caparra-error"
                        aria-invalid="<?= isset($errors['preno_caparra']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['preno_caparra'])): ?>
                        <div id="preno_caparra-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_caparra']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_stato" class="form-label">
                        <?= esc(lang('Agenda.preno_stato')) ?>
                    </label>
                    <select
                        name="preno_stato"
                        id="preno_stato"
                        class="form-select <?= isset($errors['preno_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_stato-error"
                        aria-invalid="<?= isset($errors['preno_stato']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['preno_stato'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('preno_stato', $row->preno_stato ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['preno_stato'])): ?>
                        <div id="preno_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_opzione" class="form-label">
                        <?= esc(lang('Agenda.data_opzione')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_opzione"
                        id="data_opzione"
                        value="<?= esc(old('data_opzione', $row->data_opzione ?? '')) ?>"
                        class="form-control <?= isset($errors['data_opzione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_opzione-error"
                        aria-invalid="<?= isset($errors['data_opzione']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['data_opzione'])): ?>
                        <div id="data_opzione-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_opzione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-none">
                    <input type="hidden" name="cancella_data_record" id="cancella_data_record" value="<?= esc(old('cancella_data_record', $row->cancella_data_record ?? '')) ?>">
                    <?php if (!empty($errors['cancella_data_record'])): ?>
                        <div id="cancella_data_record-error" class="invalid-feedback d-block">
                            <?= esc($errors['cancella_data_record']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cancella_user" class="form-label">
                        <?= esc(lang('Agenda.cancella_user')) ?>
                    </label>
                    <input
                        type="number"
                        name="cancella_user"
                        id="cancella_user"
                        value="<?= esc(old('cancella_user', $row->cancella_user ?? '')) ?>"
                        class="form-control <?= isset($errors['cancella_user']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cancella_user-error"
                        aria-invalid="<?= isset($errors['cancella_user']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['cancella_user'])): ?>
                        <div id="cancella_user-error" class="invalid-feedback d-block">
                            <?= esc($errors['cancella_user']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cancella_pass" class="form-label">
                        <?= esc(lang('Agenda.cancella_pass')) ?>
                    </label>
                    <input
                        type="text"
                        name="cancella_pass"
                        id="cancella_pass"
                        value="<?= esc(old('cancella_pass', $row->cancella_pass ?? '')) ?>"
                        class="form-control <?= isset($errors['cancella_pass']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cancella_pass-error"
                        aria-invalid="<?= isset($errors['cancella_pass']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['cancella_pass'])): ?>
                        <div id="cancella_pass-error" class="invalid-feedback d-block">
                            <?= esc($errors['cancella_pass']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenda_utente_id" class="form-label">
                        <?= esc(lang('Agenda.agenda_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenda_utente_id"
                        id="agenda_utente_id"
                        value="<?= esc(old('agenda_utente_id', $row->agenda_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['agenda_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenda_utente_id-error"
                        aria-invalid="<?= isset($errors['agenda_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenda_utente_id'])): ?>
                        <div id="agenda_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenda_utente_id']) ?>
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

                    <a href="<?= site_url('agenda') ?>" class="btn btn-secondary">
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
