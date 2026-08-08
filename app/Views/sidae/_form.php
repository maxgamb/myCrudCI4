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
                        <?= esc(lang('Sidae.hotel_id')) ?>
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
                    <label for="conto_id" class="form-label">
                        <?= esc(lang('Sidae.conto_id')) ?>
                    </label>
                    <select
                        name="conto_id"
                        id="conto_id"
                        class="form-select <?= isset($errors['conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="conto_id-error"
                        aria-invalid="<?= isset($errors['conto_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['conto_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('conto_id', $row->conto_id ?? ($context['conto_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="conto_id"
                            data-base-url="<?= site_url('conti/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('conti/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['conto_id'])): ?>
                        <div id="conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="foglio_id" class="form-label">
                        <?= esc(lang('Sidae.foglio_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="foglio_id"
                        id="foglio_id"
                        value="<?= esc(old('foglio_id', $row->foglio_id ?? ($context['foglio_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['foglio_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="foglio_id-error"
                        aria-invalid="<?= isset($errors['foglio_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['foglio_id'])): ?>
                        <div id="foglio_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['foglio_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_cliente" class="form-label">
                        <?= esc(lang('Sidae.nome_cliente')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_cliente"
                        id="nome_cliente"
                        value="<?= esc(old('nome_cliente', $row->nome_cliente ?? ($context['nome_cliente'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_cliente']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_cliente-error"
                        aria-invalid="<?= isset($errors['nome_cliente']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['nome_cliente'])): ?>
                        <div id="nome_cliente-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_cliente']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pag_room" class="form-label">
                        <?= esc(lang('Sidae.pag_room')) ?>
                    </label>
                    <input
                        type="number"
                        name="pag_room"
                        id="pag_room"
                        value="<?= esc(old('pag_room', $row->pag_room ?? ($context['pag_room'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pag_room']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pag_room-error"
                        aria-invalid="<?= isset($errors['pag_room']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['pag_room'])): ?>
                        <div id="pag_room-error" class="invalid-feedback d-block">
                            <?= esc($errors['pag_room']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="aliquota" class="form-label">
                        <?= esc(lang('Sidae.aliquota')) ?>
                    </label>
                    <input
                        type="number"
                        name="aliquota"
                        id="aliquota"
                        value="<?= esc(old('aliquota', $row->aliquota ?? ($context['aliquota'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['aliquota']) ? 'is-invalid' : '' ?>"
                        aria-describedby="aliquota-error"
                        aria-invalid="<?= isset($errors['aliquota']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['aliquota'])): ?>
                        <div id="aliquota-error" class="invalid-feedback d-block">
                            <?= esc($errors['aliquota']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="quan_room" class="form-label">
                        <?= esc(lang('Sidae.quan_room')) ?>
                    </label>
                    <input
                        type="number"
                        name="quan_room"
                        id="quan_room"
                        value="<?= esc(old('quan_room', $row->quan_room ?? ($context['quan_room'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['quan_room']) ? 'is-invalid' : '' ?>"
                        aria-describedby="quan_room-error"
                        aria-invalid="<?= isset($errors['quan_room']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['quan_room'])): ?>
                        <div id="quan_room-error" class="invalid-feedback d-block">
                            <?= esc($errors['quan_room']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pag_extra" class="form-label">
                        <?= esc(lang('Sidae.pag_extra')) ?>
                    </label>
                    <input
                        type="number"
                        name="pag_extra"
                        id="pag_extra"
                        value="<?= esc(old('pag_extra', $row->pag_extra ?? ($context['pag_extra'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pag_extra']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pag_extra-error"
                        aria-invalid="<?= isset($errors['pag_extra']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['pag_extra'])): ?>
                        <div id="pag_extra-error" class="invalid-feedback d-block">
                            <?= esc($errors['pag_extra']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="extra_aliquota" class="form-label">
                        <?= esc(lang('Sidae.extra_aliquota')) ?>
                    </label>
                    <input
                        type="number"
                        name="extra_aliquota"
                        id="extra_aliquota"
                        value="<?= esc(old('extra_aliquota', $row->extra_aliquota ?? ($context['extra_aliquota'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['extra_aliquota']) ? 'is-invalid' : '' ?>"
                        aria-describedby="extra_aliquota-error"
                        aria-invalid="<?= isset($errors['extra_aliquota']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['extra_aliquota'])): ?>
                        <div id="extra_aliquota-error" class="invalid-feedback d-block">
                            <?= esc($errors['extra_aliquota']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pag_citytax" class="form-label">
                        <?= esc(lang('Sidae.pag_citytax')) ?>
                    </label>
                    <input
                        type="number"
                        name="pag_citytax"
                        id="pag_citytax"
                        value="<?= esc(old('pag_citytax', $row->pag_citytax ?? ($context['pag_citytax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pag_citytax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pag_citytax-error"
                        aria-invalid="<?= isset($errors['pag_citytax']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['pag_citytax'])): ?>
                        <div id="pag_citytax-error" class="invalid-feedback d-block">
                            <?= esc($errors['pag_citytax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamentoTipo" class="form-label">
                        <?= esc(lang('Sidae.pagamentoTipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="pagamentoTipo"
                        id="pagamentoTipo"
                        value="<?= esc(old('pagamentoTipo', $row->pagamentoTipo ?? ($context['pagamentoTipo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pagamentoTipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamentoTipo-error"
                        aria-invalid="<?= isset($errors['pagamentoTipo']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['pagamentoTipo'])): ?>
                        <div id="pagamentoTipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamentoTipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamentoCityTax" class="form-label">
                        <?= esc(lang('Sidae.pagamentoCityTax')) ?>
                    </label>
                    <input
                        type="text"
                        name="pagamentoCityTax"
                        id="pagamentoCityTax"
                        value="<?= esc(old('pagamentoCityTax', $row->pagamentoCityTax ?? ($context['pagamentoCityTax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pagamentoCityTax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamentoCityTax-error"
                        aria-invalid="<?= isset($errors['pagamentoCityTax']) ? 'true' : 'false' ?>"
                        required maxlength="50"
                    >
                    <?php if (!empty($errors['pagamentoCityTax'])): ?>
                        <div id="pagamentoCityTax-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamentoCityTax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="codiceLotteria" class="form-label">
                        <?= esc(lang('Sidae.codiceLotteria')) ?>
                    </label>
                    <input
                        type="text"
                        name="codiceLotteria"
                        id="codiceLotteria"
                        value="<?= esc(old('codiceLotteria', $row->codiceLotteria ?? ($context['codiceLotteria'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['codiceLotteria']) ? 'is-invalid' : '' ?>"
                        aria-describedby="codiceLotteria-error"
                        aria-invalid="<?= isset($errors['codiceLotteria']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['codiceLotteria'])): ?>
                        <div id="codiceLotteria-error" class="invalid-feedback d-block">
                            <?= esc($errors['codiceLotteria']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="stringaLotteria" class="form-label">
                        <?= esc(lang('Sidae.stringaLotteria')) ?>
                    </label>
                    <input
                        type="text"
                        name="stringaLotteria"
                        id="stringaLotteria"
                        value="<?= esc(old('stringaLotteria', $row->stringaLotteria ?? ($context['stringaLotteria'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['stringaLotteria']) ? 'is-invalid' : '' ?>"
                        aria-describedby="stringaLotteria-error"
                        aria-invalid="<?= isset($errors['stringaLotteria']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['stringaLotteria'])): ?>
                        <div id="stringaLotteria-error" class="invalid-feedback d-block">
                            <?= esc($errors['stringaLotteria']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="se_idTrx" class="form-label">
                        <?= esc(lang('Sidae.se_idTrx')) ?>
                    </label>
                    <input
                        type="number"
                        name="se_idTrx"
                        id="se_idTrx"
                        value="<?= esc(old('se_idTrx', $row->se_idTrx ?? ($context['se_idTrx'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['se_idTrx']) ? 'is-invalid' : '' ?>"
                        aria-describedby="se_idTrx-error"
                        aria-invalid="<?= isset($errors['se_idTrx']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['se_idTrx'])): ?>
                        <div id="se_idTrx-error" class="invalid-feedback d-block">
                            <?= esc($errors['se_idTrx']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="command" class="form-label">
                        <?= esc(lang('Sidae.command')) ?>
                    </label>
                    <input
                        type="text"
                        name="command"
                        id="command"
                        value="<?= esc(old('command', $row->command ?? ($context['command'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['command']) ? 'is-invalid' : '' ?>"
                        aria-describedby="command-error"
                        aria-invalid="<?= isset($errors['command']) ? 'true' : 'false' ?>"
                        required maxlength="100"
                    >
                    <?php if (!empty($errors['command'])): ?>
                        <div id="command-error" class="invalid-feedback d-block">
                            <?= esc($errors['command']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="errore" class="form-label">
                        <?= esc(lang('Sidae.errore')) ?>
                    </label>
                    <input
                        type="text"
                        name="errore"
                        id="errore"
                        value="<?= esc(old('errore', $row->errore ?? ($context['errore'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['errore']) ? 'is-invalid' : '' ?>"
                        aria-describedby="errore-error"
                        aria-invalid="<?= isset($errors['errore']) ? 'true' : 'false' ?>"
                        required maxlength="225"
                    >
                    <?php if (!empty($errors['errore'])): ?>
                        <div id="errore-error" class="invalid-feedback d-block">
                            <?= esc($errors['errore']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ae_idTrx" class="form-label">
                        <?= esc(lang('Sidae.ae_idTrx')) ?>
                    </label>
                    <input
                        type="number"
                        name="ae_idTrx"
                        id="ae_idTrx"
                        value="<?= esc(old('ae_idTrx', $row->ae_idTrx ?? ($context['ae_idTrx'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ae_idTrx']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ae_idTrx-error"
                        aria-invalid="<?= isset($errors['ae_idTrx']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['ae_idTrx'])): ?>
                        <div id="ae_idTrx-error" class="invalid-feedback d-block">
                            <?= esc($errors['ae_idTrx']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numeroDocumento" class="form-label">
                        <?= esc(lang('Sidae.numeroDocumento')) ?>
                    </label>
                    <input
                        type="text"
                        name="numeroDocumento"
                        id="numeroDocumento"
                        value="<?= esc(old('numeroDocumento', $row->numeroDocumento ?? ($context['numeroDocumento'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['numeroDocumento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="numeroDocumento-error"
                        aria-invalid="<?= isset($errors['numeroDocumento']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['numeroDocumento'])): ?>
                        <div id="numeroDocumento-error" class="invalid-feedback d-block">
                            <?= esc($errors['numeroDocumento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numeroRiferimento" class="form-label">
                        <?= esc(lang('Sidae.numeroRiferimento')) ?>
                    </label>
                    <input
                        type="text"
                        name="numeroRiferimento"
                        id="numeroRiferimento"
                        value="<?= esc(old('numeroRiferimento', $row->numeroRiferimento ?? ($context['numeroRiferimento'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['numeroRiferimento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="numeroRiferimento-error"
                        aria-invalid="<?= isset($errors['numeroRiferimento']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['numeroRiferimento'])): ?>
                        <div id="numeroRiferimento-error" class="invalid-feedback d-block">
                            <?= esc($errors['numeroRiferimento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="totaleScontrino" class="form-label">
                        <?= esc(lang('Sidae.totaleScontrino')) ?>
                    </label>
                    <input
                        type="number"
                        name="totaleScontrino"
                        id="totaleScontrino"
                        value="<?= esc(old('totaleScontrino', $row->totaleScontrino ?? ($context['totaleScontrino'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['totaleScontrino']) ? 'is-invalid' : '' ?>"
                        aria-describedby="totaleScontrino-error"
                        aria-invalid="<?= isset($errors['totaleScontrino']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['totaleScontrino'])): ?>
                        <div id="totaleScontrino-error" class="invalid-feedback d-block">
                            <?= esc($errors['totaleScontrino']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="totaleIva" class="form-label">
                        <?= esc(lang('Sidae.totaleIva')) ?>
                    </label>
                    <input
                        type="number"
                        name="totaleIva"
                        id="totaleIva"
                        value="<?= esc(old('totaleIva', $row->totaleIva ?? ($context['totaleIva'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['totaleIva']) ? 'is-invalid' : '' ?>"
                        aria-describedby="totaleIva-error"
                        aria-invalid="<?= isset($errors['totaleIva']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['totaleIva'])): ?>
                        <div id="totaleIva-error" class="invalid-feedback d-block">
                            <?= esc($errors['totaleIva']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="totaleSconto" class="form-label">
                        <?= esc(lang('Sidae.totaleSconto')) ?>
                    </label>
                    <input
                        type="number"
                        name="totaleSconto"
                        id="totaleSconto"
                        value="<?= esc(old('totaleSconto', $row->totaleSconto ?? ($context['totaleSconto'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['totaleSconto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="totaleSconto-error"
                        aria-invalid="<?= isset($errors['totaleSconto']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['totaleSconto'])): ?>
                        <div id="totaleSconto-error" class="invalid-feedback d-block">
                            <?= esc($errors['totaleSconto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="importoDetraibile" class="form-label">
                        <?= esc(lang('Sidae.importoDetraibile')) ?>
                    </label>
                    <input
                        type="number"
                        name="importoDetraibile"
                        id="importoDetraibile"
                        value="<?= esc(old('importoDetraibile', $row->importoDetraibile ?? ($context['importoDetraibile'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['importoDetraibile']) ? 'is-invalid' : '' ?>"
                        aria-describedby="importoDetraibile-error"
                        aria-invalid="<?= isset($errors['importoDetraibile']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['importoDetraibile'])): ?>
                        <div id="importoDetraibile-error" class="invalid-feedback d-block">
                            <?= esc($errors['importoDetraibile']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data" class="form-label">
                        <?= esc(lang('Sidae.data')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="data"
                        id="data"
                        value="<?= esc(old('data', isset($row->data) ? str_replace(' ', 'T', substr((string) $row->data, 0, 16)) : ($context['data'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data-error"
                        aria-invalid="<?= isset($errors['data']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['data'])): ?>
                        <div id="data-error" class="invalid-feedback d-block">
                            <?= esc($errors['data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="idElemento" class="form-label">
                        <?= esc(lang('Sidae.idElemento')) ?>
                    </label>
                    <input
                        type="text"
                        name="idElemento"
                        id="idElemento"
                        value="<?= esc(old('idElemento', $row->idElemento ?? ($context['idElemento'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['idElemento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="idElemento-error"
                        aria-invalid="<?= isset($errors['idElemento']) ? 'true' : 'false' ?>"
                        required maxlength="250"
                    >
                    <?php if (!empty($errors['idElemento'])): ?>
                        <div id="idElemento-error" class="invalid-feedback d-block">
                            <?= esc($errors['idElemento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('Sidae.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? ($context['utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="utente_id-error"
                        aria-invalid="<?= isset($errors['utente_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['utente_id'])): ?>
                        <div id="utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['utente_id']) ?>
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

                    <a href="<?= site_url('sidae') ?>" class="btn btn-secondary">
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
