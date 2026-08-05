<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-pencil-square"></i> Modifica record</h1>
        </div>

        <div class="card-body">
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif; ?>

            <?= form_open('agenda/update/' . $row->preno_id, [
                'class'   => 'row g-3',
                'enctype' => 'multipart/form-data',
                'id'      => 'myCrudForm',
            ]) ?>
                <input type="hidden" name="_submission_token" value="<?= esc($submissionToken ?? '') ?>">

                <div class="col-md-12">
                    <label for="hotel_id" class="form-label">Hotel Id</label>
                    <input
                        type="hidden"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
                        class="form-control <?= isset($errors['hotel_id']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['hotel_id'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="preno_in_data" class="form-label">Preno In Data</label>
                    <input
                        type="hidden"
                        name="preno_in_data"
                        id="preno_in_data"
                        value="<?= esc(old('preno_in_data', $row->preno_in_data ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_in_data']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_in_data'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="preno_importo" class="form-label">Preno Importo</label>
                    <input
                        type="number"
                        name="preno_importo"
                        id="preno_importo"
                        value="<?= esc(old('preno_importo', $row->preno_importo ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_importo']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_importo'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="preno_impoto_mod" class="form-label">Preno Impoto Mod</label>
                    <input
                        type="hidden"
                        name="preno_impoto_mod"
                        id="preno_impoto_mod"
                        value="<?= esc(old('preno_impoto_mod', $row->preno_impoto_mod ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_impoto_mod']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_impoto_mod'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_dal" class="form-label">Preno Dal</label>
                    <input
                        type="date"
                        name="preno_dal"
                        id="preno_dal"
                        value="<?= esc(old('preno_dal', $row->preno_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_dal']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_dal'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_al" class="form-label">Preno Al</label>
                    <input
                        type="date"
                        name="preno_al"
                        id="preno_al"
                        value="<?= esc(old('preno_al', $row->preno_al ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_al']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_al'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_nome" class="form-label">Preno Nome</label>
                    <input
                        type="text"
                        name="preno_nome"
                        id="preno_nome"
                        value="<?= esc(old('preno_nome', $row->preno_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_nome']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_nome'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_cogno" class="form-label">Preno Cogno</label>
                    <input
                        type="text"
                        name="preno_cogno"
                        id="preno_cogno"
                        value="<?= esc(old('preno_cogno', $row->preno_cogno ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_cogno']) ? 'is-invalid' : '' ?>"
                        required maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_cogno'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_n_notti" class="form-label">Preno N Notti</label>
                    <input
                        type="hidden"
                        name="preno_n_notti"
                        id="preno_n_notti"
                        value="<?= esc(old('preno_n_notti', $row->preno_n_notti ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_n_notti']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_n_notti'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_arr_ore" class="form-label">Preno Arr Ore</label>
                    <select
                        name="preno_arr_ore"
                        id="preno_arr_ore"
                        class="form-select <?= isset($errors['preno_arr_ore']) ? 'is-invalid' : '' ?>"
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
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_arr_ore'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_trattamento" class="form-label">Preno Trattamento</label>
                    <select
                        name="preno_trattamento"
                        id="preno_trattamento"
                        class="form-select <?= isset($errors['preno_trattamento']) ? 'is-invalid' : '' ?>"
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
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_trattamento'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="t1" class="form-label">T1</label>
                    <select
                        name="t1"
                        id="t1"
                        class="form-select <?= isset($errors['t1']) ? 'is-invalid' : '' ?>"
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
                    <div class="invalid-feedback">
                        <?= esc($errors['t1'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="t2" class="form-label">T2</label>
                    <select
                        name="t2"
                        id="t2"
                        class="form-select <?= isset($errors['t2']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['t2'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="t3" class="form-label">T3</label>
                    <select
                        name="t3"
                        id="t3"
                        class="form-select <?= isset($errors['t3']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['t3'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="t4" class="form-label">T4</label>
                    <select
                        name="t4"
                        id="t4"
                        class="form-select <?= isset($errors['t4']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['t4'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="t5" class="form-label">T5</label>
                    <select
                        name="t5"
                        id="t5"
                        class="form-select <?= isset($errors['t5']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['t5'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="t6" class="form-label">T6</label>
                    <select
                        name="t6"
                        id="t6"
                        class="form-select <?= isset($errors['t6']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['t6'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="q1" class="form-label">Q1</label>
                    <input
                        type="number"
                        name="q1"
                        id="q1"
                        value="<?= esc(old('q1', $row->q1 ?? '')) ?>"
                        class="form-control <?= isset($errors['q1']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['q1'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="q2" class="form-label">Q2</label>
                    <input
                        type="number"
                        name="q2"
                        id="q2"
                        value="<?= esc(old('q2', $row->q2 ?? '')) ?>"
                        class="form-control <?= isset($errors['q2']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['q2'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="q3" class="form-label">Q3</label>
                    <input
                        type="number"
                        name="q3"
                        id="q3"
                        value="<?= esc(old('q3', $row->q3 ?? '')) ?>"
                        class="form-control <?= isset($errors['q3']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['q3'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="q4" class="form-label">Q4</label>
                    <input
                        type="number"
                        name="q4"
                        id="q4"
                        value="<?= esc(old('q4', $row->q4 ?? '')) ?>"
                        class="form-control <?= isset($errors['q4']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['q4'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="q5" class="form-label">Q5</label>
                    <input
                        type="number"
                        name="q5"
                        id="q5"
                        value="<?= esc(old('q5', $row->q5 ?? '')) ?>"
                        class="form-control <?= isset($errors['q5']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['q5'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="q6" class="form-label">Q6</label>
                    <input
                        type="number"
                        name="q6"
                        id="q6"
                        value="<?= esc(old('q6', $row->q6 ?? '')) ?>"
                        class="form-control <?= isset($errors['q6']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['q6'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="p1" class="form-label">P1</label>
                    <input
                        type="number"
                        name="p1"
                        id="p1"
                        value="<?= esc(old('p1', $row->p1 ?? '')) ?>"
                        class="form-control <?= isset($errors['p1']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['p1'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="p2" class="form-label">P2</label>
                    <input
                        type="number"
                        name="p2"
                        id="p2"
                        value="<?= esc(old('p2', $row->p2 ?? '')) ?>"
                        class="form-control <?= isset($errors['p2']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['p2'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="p3" class="form-label">P3</label>
                    <input
                        type="number"
                        name="p3"
                        id="p3"
                        value="<?= esc(old('p3', $row->p3 ?? '')) ?>"
                        class="form-control <?= isset($errors['p3']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['p3'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="p4" class="form-label">P4</label>
                    <input
                        type="number"
                        name="p4"
                        id="p4"
                        value="<?= esc(old('p4', $row->p4 ?? '')) ?>"
                        class="form-control <?= isset($errors['p4']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['p4'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="p5" class="form-label">P5</label>
                    <input
                        type="number"
                        name="p5"
                        id="p5"
                        value="<?= esc(old('p5', $row->p5 ?? '')) ?>"
                        class="form-control <?= isset($errors['p5']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['p5'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="p6" class="form-label">P6</label>
                    <input
                        type="number"
                        name="p6"
                        id="p6"
                        value="<?= esc(old('p6', $row->p6 ?? '')) ?>"
                        class="form-control <?= isset($errors['p6']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['p6'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_agenzia" class="form-label">Preno Agenzia</label>
                    <select
                        name="preno_agenzia"
                        id="preno_agenzia"
                        class="form-select <?= isset($errors['preno_agenzia']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_agenzia'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="voucher_id" class="form-label">Voucher Id</label>
                    <input
                        type="text"
                        name="voucher_id"
                        id="voucher_id"
                        value="<?= esc(old('voucher_id', $row->voucher_id ?? '')) ?>"
                        class="form-control <?= isset($errors['voucher_id']) ? 'is-invalid' : '' ?>"
                        maxlength="50"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['voucher_id'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="ota_voucher" class="form-label">Ota Voucher</label>
                    <input
                        type="text"
                        name="ota_voucher"
                        id="ota_voucher"
                        value="<?= esc(old('ota_voucher', $row->ota_voucher ?? '')) ?>"
                        class="form-control <?= isset($errors['ota_voucher']) ? 'is-invalid' : '' ?>"
                        maxlength="50"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['ota_voucher'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="allotment_id" class="form-label">Allotment Id</label>
                    <input
                        type="hidden"
                        name="allotment_id"
                        id="allotment_id"
                        value="<?= esc(old('allotment_id', $row->allotment_id ?? '')) ?>"
                        class="form-control <?= isset($errors['allotment_id']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['allotment_id'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_cc_tip" class="form-label">Preno Cc Tip</label>
                    <select
                        name="preno_cc_tip"
                        id="preno_cc_tip"
                        class="form-select <?= isset($errors['preno_cc_tip']) ? 'is-invalid' : '' ?>"
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
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_cc_tip'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_cc_n" class="form-label">Preno Cc N</label>
                    <input
                        type="text"
                        name="preno_cc_n"
                        id="preno_cc_n"
                        value="<?= esc(old('preno_cc_n', $row->preno_cc_n ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_cc_n']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_cc_n'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_cc_scad" class="form-label">Preno Cc Scad</label>
                    <input
                        type="text"
                        name="preno_cc_scad"
                        id="preno_cc_scad"
                        value="<?= esc(old('preno_cc_scad', $row->preno_cc_scad ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_cc_scad']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_cc_scad'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_tel" class="form-label">Preno Tel</label>
                    <input
                        type="text"
                        name="preno_tel"
                        id="preno_tel"
                        value="<?= esc(old('preno_tel', $row->preno_tel ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_tel']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_tel'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_fax" class="form-label">Preno Fax</label>
                    <input
                        type="text"
                        name="preno_fax"
                        id="preno_fax"
                        value="<?= esc(old('preno_fax', $row->preno_fax ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_fax']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_fax'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_email" class="form-label">Preno Email</label>
                    <input
                        type="email"
                        name="preno_email"
                        id="preno_email"
                        value="<?= esc(old('preno_email', $row->preno_email ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_email']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_email'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_mercato" class="form-label">Preno Mercato</label>
                    <input
                        type="text"
                        name="preno_mercato"
                        id="preno_mercato"
                        value="<?= esc(old('preno_mercato', $row->preno_mercato ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_mercato']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_mercato'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="nazione_iso2" class="form-label">Nazione Iso2</label>
                    <select
                        name="nazione_iso2"
                        id="nazione_iso2"
                        class="form-select <?= isset($errors['nazione_iso2']) ? 'is-invalid' : '' ?>"
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
                    <div class="invalid-feedback">
                        <?= esc($errors['nazione_iso2'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_note" class="form-label">Preno Note</label>
                    <input
                        type="text"
                        name="preno_note"
                        id="preno_note"
                        value="<?= esc(old('preno_note', $row->preno_note ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_note']) ? 'is-invalid' : '' ?>"
                        maxlength="4294967295"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_note'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_fax" class="form-label">Preno Doc Fax</label>
                    <input type="hidden" name="preno_doc_fax" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_fax"
                            id="preno_doc_fax"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_fax']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_fax', $row->preno_doc_fax ?? '') ? 'checked' : '' ?>
                            maxlength="2"
                        >
                    </div>
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_doc_fax'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_email" class="form-label">Preno Doc Email</label>
                    <input type="hidden" name="preno_doc_email" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_email"
                            id="preno_doc_email"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_email']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_email', $row->preno_doc_email ?? '') ? 'checked' : '' ?>
                            maxlength="2"
                        >
                    </div>
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_doc_email'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_form" class="form-label">Preno Doc Form</label>
                    <input type="hidden" name="preno_doc_form" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_form"
                            id="preno_doc_form"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_form']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_form', $row->preno_doc_form ?? '') ? 'checked' : '' ?>
                            maxlength="2"
                        >
                    </div>
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_doc_form'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_mail" class="form-label">Preno Doc Mail</label>
                    <input type="hidden" name="preno_doc_mail" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_mail"
                            id="preno_doc_mail"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_mail']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_mail', $row->preno_doc_mail ?? '') ? 'checked' : '' ?>
                            maxlength="2"
                        >
                    </div>
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_doc_mail'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_vaglia" class="form-label">Preno Doc Vaglia</label>
                    <input type="hidden" name="preno_doc_vaglia" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_vaglia"
                            id="preno_doc_vaglia"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_vaglia']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_vaglia', $row->preno_doc_vaglia ?? '') ? 'checked' : '' ?>
                            maxlength="2"
                        >
                    </div>
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_doc_vaglia'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_doc_woucher" class="form-label">Preno Doc Woucher</label>
                    <input type="hidden" name="preno_doc_woucher" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="preno_doc_woucher"
                            id="preno_doc_woucher"
                            value="1"
                            class="form-check-input <?= isset($errors['preno_doc_woucher']) ? 'is-invalid' : '' ?>"
                            <?= old('preno_doc_woucher', $row->preno_doc_woucher ?? '') ? 'checked' : '' ?>
                            maxlength="2"
                        >
                    </div>
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_doc_woucher'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_pag_modalita" class="form-label">Preno Pag Modalita</label>
                    <select
                        name="preno_pag_modalita"
                        id="preno_pag_modalita"
                        class="form-select <?= isset($errors['preno_pag_modalita']) ? 'is-invalid' : '' ?>"
                        
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
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_pag_modalita'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_caparra" class="form-label">Preno Caparra</label>
                    <input
                        type="number"
                        name="preno_caparra"
                        id="preno_caparra"
                        value="<?= esc(old('preno_caparra', $row->preno_caparra ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_caparra']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_caparra'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_stato" class="form-label">Preno Stato</label>
                    <input
                        type="radio"
                        name="preno_stato"
                        id="preno_stato"
                        value="<?= esc(old('preno_stato', $row->preno_stato ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_stato']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_stato'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="data_opzione" class="form-label">Data Opzione</label>
                    <input
                        type="date"
                        name="data_opzione"
                        id="data_opzione"
                        value="<?= esc(old('data_opzione', $row->data_opzione ?? '')) ?>"
                        class="form-control <?= isset($errors['data_opzione']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['data_opzione'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="cancella_data_record" class="form-label">Cancella Data Record</label>
                    <input
                        type="hidden"
                        name="cancella_data_record"
                        id="cancella_data_record"
                        value="<?= esc(old('cancella_data_record', $row->cancella_data_record ?? '')) ?>"
                        class="form-control <?= isset($errors['cancella_data_record']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['cancella_data_record'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="cancella_user" class="form-label">Cancella User</label>
                    <input
                        type="hidden"
                        name="cancella_user"
                        id="cancella_user"
                        value="<?= esc(old('cancella_user', $row->cancella_user ?? '')) ?>"
                        class="form-control <?= isset($errors['cancella_user']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['cancella_user'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="cancella_pass" class="form-label">Cancella Pass</label>
                    <input
                        type="hidden"
                        name="cancella_pass"
                        id="cancella_pass"
                        value="<?= esc(old('cancella_pass', $row->cancella_pass ?? '')) ?>"
                        class="form-control <?= isset($errors['cancella_pass']) ? 'is-invalid' : '' ?>"
                        maxlength="100"
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['cancella_pass'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="preno_data_record" class="form-label">Preno Data Record</label>
                    <input
                        type="hidden"
                        name="preno_data_record"
                        id="preno_data_record"
                        value="<?= esc(old('preno_data_record', $row->preno_data_record ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_data_record']) ? 'is-invalid' : '' ?>"
                        required
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['preno_data_record'] ?? '') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="agenda_utente_id" class="form-label">Agenda Utente Id</label>
                    <input
                        type="hidden"
                        name="agenda_utente_id"
                        id="agenda_utente_id"
                        value="<?= esc(old('agenda_utente_id', $row->agenda_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['agenda_utente_id']) ? 'is-invalid' : '' ?>"
                        
                    >
                    <div class="invalid-feedback">
                        <?= esc($errors['agenda_utente_id'] ?? '') ?>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <span class="submit-normal"><i class="bi bi-check-circle"></i> Salva</span>
                        <span class="submit-loading d-none">
                            <span class="spinner-border spinner-border-sm"></span> Salvataggio...
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

<?= $this->endSection() ?>