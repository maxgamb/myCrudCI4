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
                        <?= esc(lang('ObmpReview.hotel_id')) ?>
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
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('ObmpReview.preno_id')) ?>
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
                    <label for="conto_id" class="form-label">
                        <?= esc(lang('ObmpReview.conto_id')) ?>
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
                                <?= (string) old('conto_id', $row->conto_id ?? '') === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['conto_id'])): ?>
                        <div id="conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="postazione_id" class="form-label">
                        <?= esc(lang('ObmpReview.postazione_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="postazione_id"
                        id="postazione_id"
                        value="<?= esc(old('postazione_id', $row->postazione_id ?? '')) ?>"
                        class="form-control <?= isset($errors['postazione_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="postazione_id-error"
                        aria-invalid="<?= isset($errors['postazione_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['postazione_id'])): ?>
                        <div id="postazione_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['postazione_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="camera_numero" class="form-label">
                        <?= esc(lang('ObmpReview.camera_numero')) ?>
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
                    <label for="nome" class="form-label">
                        <?= esc(lang('ObmpReview.nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome"
                        id="nome"
                        value="<?= esc(old('nome', $row->nome ?? '')) ?>"
                        class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome-error"
                        aria-invalid="<?= isset($errors['nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['nome'])): ?>
                        <div id="nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="stato" class="form-label">
                        <?= esc(lang('ObmpReview.stato')) ?>
                    </label>
                    <input
                        type="text"
                        name="stato"
                        id="stato"
                        value="<?= esc(old('stato', $row->stato ?? '')) ?>"
                        class="form-control <?= isset($errors['stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="stato-error"
                        aria-invalid="<?= isset($errors['stato']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['stato'])): ?>
                        <div id="stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="user_type" class="form-label">
                        <?= esc(lang('ObmpReview.user_type')) ?>
                    </label>
                    <input
                        type="number"
                        name="user_type"
                        id="user_type"
                        value="<?= esc(old('user_type', $row->user_type ?? '')) ?>"
                        class="form-control <?= isset($errors['user_type']) ? 'is-invalid' : '' ?>"
                        aria-describedby="user_type-error"
                        aria-invalid="<?= isset($errors['user_type']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['user_type'])): ?>
                        <div id="user_type-error" class="invalid-feedback d-block">
                            <?= esc($errors['user_type']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pulizia_camera" class="form-label">
                        <?= esc(lang('ObmpReview.pulizia_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="pulizia_camera"
                        id="pulizia_camera"
                        value="<?= esc(old('pulizia_camera', $row->pulizia_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['pulizia_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pulizia_camera-error"
                        aria-invalid="<?= isset($errors['pulizia_camera']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pulizia_camera'])): ?>
                        <div id="pulizia_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['pulizia_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="accoglienza" class="form-label">
                        <?= esc(lang('ObmpReview.accoglienza')) ?>
                    </label>
                    <input
                        type="number"
                        name="accoglienza"
                        id="accoglienza"
                        value="<?= esc(old('accoglienza', $row->accoglienza ?? '')) ?>"
                        class="form-control <?= isset($errors['accoglienza']) ? 'is-invalid' : '' ?>"
                        aria-describedby="accoglienza-error"
                        aria-invalid="<?= isset($errors['accoglienza']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['accoglienza'])): ?>
                        <div id="accoglienza-error" class="invalid-feedback d-block">
                            <?= esc($errors['accoglienza']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="rumore_camere" class="form-label">
                        <?= esc(lang('ObmpReview.rumore_camere')) ?>
                    </label>
                    <input
                        type="number"
                        name="rumore_camere"
                        id="rumore_camere"
                        value="<?= esc(old('rumore_camere', $row->rumore_camere ?? '')) ?>"
                        class="form-control <?= isset($errors['rumore_camere']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rumore_camere-error"
                        aria-invalid="<?= isset($errors['rumore_camere']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['rumore_camere'])): ?>
                        <div id="rumore_camere-error" class="invalid-feedback d-block">
                            <?= esc($errors['rumore_camere']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="spazio_camera" class="form-label">
                        <?= esc(lang('ObmpReview.spazio_camera')) ?>
                    </label>
                    <input
                        type="number"
                        name="spazio_camera"
                        id="spazio_camera"
                        value="<?= esc(old('spazio_camera', $row->spazio_camera ?? '')) ?>"
                        class="form-control <?= isset($errors['spazio_camera']) ? 'is-invalid' : '' ?>"
                        aria-describedby="spazio_camera-error"
                        aria-invalid="<?= isset($errors['spazio_camera']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['spazio_camera'])): ?>
                        <div id="spazio_camera-error" class="invalid-feedback d-block">
                            <?= esc($errors['spazio_camera']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="spazi_comuni" class="form-label">
                        <?= esc(lang('ObmpReview.spazi_comuni')) ?>
                    </label>
                    <input
                        type="number"
                        name="spazi_comuni"
                        id="spazi_comuni"
                        value="<?= esc(old('spazi_comuni', $row->spazi_comuni ?? '')) ?>"
                        class="form-control <?= isset($errors['spazi_comuni']) ? 'is-invalid' : '' ?>"
                        aria-describedby="spazi_comuni-error"
                        aria-invalid="<?= isset($errors['spazi_comuni']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['spazi_comuni'])): ?>
                        <div id="spazi_comuni-error" class="invalid-feedback d-block">
                            <?= esc($errors['spazi_comuni']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="competenza_impiegati" class="form-label">
                        <?= esc(lang('ObmpReview.competenza_impiegati')) ?>
                    </label>
                    <input
                        type="number"
                        name="competenza_impiegati"
                        id="competenza_impiegati"
                        value="<?= esc(old('competenza_impiegati', $row->competenza_impiegati ?? '')) ?>"
                        class="form-control <?= isset($errors['competenza_impiegati']) ? 'is-invalid' : '' ?>"
                        aria-describedby="competenza_impiegati-error"
                        aria-invalid="<?= isset($errors['competenza_impiegati']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['competenza_impiegati'])): ?>
                        <div id="competenza_impiegati-error" class="invalid-feedback d-block">
                            <?= esc($errors['competenza_impiegati']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="qualita_servizi" class="form-label">
                        <?= esc(lang('ObmpReview.qualita_servizi')) ?>
                    </label>
                    <input
                        type="number"
                        name="qualita_servizi"
                        id="qualita_servizi"
                        value="<?= esc(old('qualita_servizi', $row->qualita_servizi ?? '')) ?>"
                        class="form-control <?= isset($errors['qualita_servizi']) ? 'is-invalid' : '' ?>"
                        aria-describedby="qualita_servizi-error"
                        aria-invalid="<?= isset($errors['qualita_servizi']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['qualita_servizi'])): ?>
                        <div id="qualita_servizi-error" class="invalid-feedback d-block">
                            <?= esc($errors['qualita_servizi']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="dintorni" class="form-label">
                        <?= esc(lang('ObmpReview.dintorni')) ?>
                    </label>
                    <input
                        type="number"
                        name="dintorni"
                        id="dintorni"
                        value="<?= esc(old('dintorni', $row->dintorni ?? '')) ?>"
                        class="form-control <?= isset($errors['dintorni']) ? 'is-invalid' : '' ?>"
                        aria-describedby="dintorni-error"
                        aria-invalid="<?= isset($errors['dintorni']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['dintorni'])): ?>
                        <div id="dintorni-error" class="invalid-feedback d-block">
                            <?= esc($errors['dintorni']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="colazione" class="form-label">
                        <?= esc(lang('ObmpReview.colazione')) ?>
                    </label>
                    <input
                        type="number"
                        name="colazione"
                        id="colazione"
                        value="<?= esc(old('colazione', $row->colazione ?? '')) ?>"
                        class="form-control <?= isset($errors['colazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="colazione-error"
                        aria-invalid="<?= isset($errors['colazione']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['colazione'])): ?>
                        <div id="colazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['colazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tariffa" class="form-label">
                        <?= esc(lang('ObmpReview.tariffa')) ?>
                    </label>
                    <input
                        type="number"
                        name="tariffa"
                        id="tariffa"
                        value="<?= esc(old('tariffa', $row->tariffa ?? '')) ?>"
                        class="form-control <?= isset($errors['tariffa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tariffa-error"
                        aria-invalid="<?= isset($errors['tariffa']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tariffa'])): ?>
                        <div id="tariffa-error" class="invalid-feedback d-block">
                            <?= esc($errors['tariffa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="servizi_offerti" class="form-label">
                        <?= esc(lang('ObmpReview.servizi_offerti')) ?>
                    </label>
                    <input
                        type="number"
                        name="servizi_offerti"
                        id="servizi_offerti"
                        value="<?= esc(old('servizi_offerti', $row->servizi_offerti ?? '')) ?>"
                        class="form-control <?= isset($errors['servizi_offerti']) ? 'is-invalid' : '' ?>"
                        aria-describedby="servizi_offerti-error"
                        aria-invalid="<?= isset($errors['servizi_offerti']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['servizi_offerti'])): ?>
                        <div id="servizi_offerti-error" class="invalid-feedback d-block">
                            <?= esc($errors['servizi_offerti']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="foto" class="form-label">
                        <?= esc(lang('ObmpReview.foto')) ?>
                    </label>
                    <input
                        type="number"
                        name="foto"
                        id="foto"
                        value="<?= esc(old('foto', $row->foto ?? '')) ?>"
                        class="form-control <?= isset($errors['foto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="foto-error"
                        aria-invalid="<?= isset($errors['foto']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['foto'])): ?>
                        <div id="foto-error" class="invalid-feedback d-block">
                            <?= esc($errors['foto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="indicazione_mappa" class="form-label">
                        <?= esc(lang('ObmpReview.indicazione_mappa')) ?>
                    </label>
                    <input
                        type="number"
                        name="indicazione_mappa"
                        id="indicazione_mappa"
                        value="<?= esc(old('indicazione_mappa', $row->indicazione_mappa ?? '')) ?>"
                        class="form-control <?= isset($errors['indicazione_mappa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="indicazione_mappa-error"
                        aria-invalid="<?= isset($errors['indicazione_mappa']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['indicazione_mappa'])): ?>
                        <div id="indicazione_mappa-error" class="invalid-feedback d-block">
                            <?= esc($errors['indicazione_mappa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="giudizio_totale" class="form-label">
                        <?= esc(lang('ObmpReview.giudizio_totale')) ?>
                    </label>
                    <input
                        type="number"
                        name="giudizio_totale"
                        id="giudizio_totale"
                        value="<?= esc(old('giudizio_totale', $row->giudizio_totale ?? '')) ?>"
                        class="form-control <?= isset($errors['giudizio_totale']) ? 'is-invalid' : '' ?>"
                        aria-describedby="giudizio_totale-error"
                        aria-invalid="<?= isset($errors['giudizio_totale']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['giudizio_totale'])): ?>
                        <div id="giudizio_totale-error" class="invalid-feedback d-block">
                            <?= esc($errors['giudizio_totale']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prezzo_qualita" class="form-label">
                        <?= esc(lang('ObmpReview.prezzo_qualita')) ?>
                    </label>
                    <input
                        type="number"
                        name="prezzo_qualita"
                        id="prezzo_qualita"
                        value="<?= esc(old('prezzo_qualita', $row->prezzo_qualita ?? '')) ?>"
                        class="form-control <?= isset($errors['prezzo_qualita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prezzo_qualita-error"
                        aria-invalid="<?= isset($errors['prezzo_qualita']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['prezzo_qualita'])): ?>
                        <div id="prezzo_qualita-error" class="invalid-feedback d-block">
                            <?= esc($errors['prezzo_qualita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="commento_tex" class="form-label">
                        <?= esc(lang('ObmpReview.commento_tex')) ?>
                    </label>
                    <input
                        type="text"
                        name="commento_tex"
                        id="commento_tex"
                        value="<?= esc(old('commento_tex', $row->commento_tex ?? '')) ?>"
                        class="form-control <?= isset($errors['commento_tex']) ? 'is-invalid' : '' ?>"
                        aria-describedby="commento_tex-error"
                        aria-invalid="<?= isset($errors['commento_tex']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['commento_tex'])): ?>
                        <div id="commento_tex-error" class="invalid-feedback d-block">
                            <?= esc($errors['commento_tex']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="risposta" class="form-label">
                        <?= esc(lang('ObmpReview.risposta')) ?>
                    </label>
                    <input
                        type="text"
                        name="risposta"
                        id="risposta"
                        value="<?= esc(old('risposta', $row->risposta ?? '')) ?>"
                        class="form-control <?= isset($errors['risposta']) ? 'is-invalid' : '' ?>"
                        aria-describedby="risposta-error"
                        aria-invalid="<?= isset($errors['risposta']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['risposta'])): ?>
                        <div id="risposta-error" class="invalid-feedback d-block">
                            <?= esc($errors['risposta']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="raccomandi" class="form-label">
                        <?= esc(lang('ObmpReview.raccomandi')) ?>
                    </label>
                    <input
                        type="number"
                        name="raccomandi"
                        id="raccomandi"
                        value="<?= esc(old('raccomandi', $row->raccomandi ?? '')) ?>"
                        class="form-control <?= isset($errors['raccomandi']) ? 'is-invalid' : '' ?>"
                        aria-describedby="raccomandi-error"
                        aria-invalid="<?= isset($errors['raccomandi']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['raccomandi'])): ?>
                        <div id="raccomandi-error" class="invalid-feedback d-block">
                            <?= esc($errors['raccomandi']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ip_review" class="form-label">
                        <?= esc(lang('ObmpReview.ip_review')) ?>
                    </label>
                    <input
                        type="text"
                        name="ip_review"
                        id="ip_review"
                        value="<?= esc(old('ip_review', $row->ip_review ?? '')) ?>"
                        class="form-control <?= isset($errors['ip_review']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ip_review-error"
                        aria-invalid="<?= isset($errors['ip_review']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['ip_review'])): ?>
                        <div id="ip_review-error" class="invalid-feedback d-block">
                            <?= esc($errors['ip_review']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_review" class="form-label">
                        <?= esc(lang('ObmpReview.data_review')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_review"
                        id="data_review"
                        value="<?= esc(old('data_review', $row->data_review ?? '')) ?>"
                        class="form-control <?= isset($errors['data_review']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_review-error"
                        aria-invalid="<?= isset($errors['data_review']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['data_review'])): ?>
                        <div id="data_review-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_review']) ?>
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

                    <a href="<?= site_url('obmp_review') ?>" class="btn btn-secondary">
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
