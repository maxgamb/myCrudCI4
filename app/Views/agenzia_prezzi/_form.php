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
                        <?= esc(lang('AgenziaPrezzi.hotel_id')) ?>
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
                    <label for="agenzia_listini_id" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_listini_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_listini_id"
                        id="agenzia_listini_id"
                        value="<?= esc(old('agenzia_listini_id', $row->agenzia_listini_id ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_listini_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_listini_id-error"
                        aria-invalid="<?= isset($errors['agenzia_listini_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_listini_id'])): ?>
                        <div id="agenzia_listini_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_listini_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_listini_dal" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_listini_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="agenzia_listini_dal"
                        id="agenzia_listini_dal"
                        value="<?= esc(old('agenzia_listini_dal', $row->agenzia_listini_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_listini_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_listini_dal-error"
                        aria-invalid="<?= isset($errors['agenzia_listini_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['agenzia_listini_dal'])): ?>
                        <div id="agenzia_listini_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_listini_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_listini_al" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_listini_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="agenzia_listini_al"
                        id="agenzia_listini_al"
                        value="<?= esc(old('agenzia_listini_al', $row->agenzia_listini_al ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_listini_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_listini_al-error"
                        aria-invalid="<?= isset($errors['agenzia_listini_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['agenzia_listini_al'])): ?>
                        <div id="agenzia_listini_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_listini_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_1pax" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_1pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_1pax"
                        id="agenzia_prezzi_1pax"
                        value="<?= esc(old('agenzia_prezzi_1pax', $row->agenzia_prezzi_1pax ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_1pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_1pax-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_1pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_1pax'])): ?>
                        <div id="agenzia_prezzi_1pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_1pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_2pax" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_2pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_2pax"
                        id="agenzia_prezzi_2pax"
                        value="<?= esc(old('agenzia_prezzi_2pax', $row->agenzia_prezzi_2pax ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_2pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_2pax-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_2pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_2pax'])): ?>
                        <div id="agenzia_prezzi_2pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_2pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_3pax" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_3pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_3pax"
                        id="agenzia_prezzi_3pax"
                        value="<?= esc(old('agenzia_prezzi_3pax', $row->agenzia_prezzi_3pax ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_3pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_3pax-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_3pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_3pax'])): ?>
                        <div id="agenzia_prezzi_3pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_3pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_4pax" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_4pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_4pax"
                        id="agenzia_prezzi_4pax"
                        value="<?= esc(old('agenzia_prezzi_4pax', $row->agenzia_prezzi_4pax ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_4pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_4pax-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_4pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_4pax'])): ?>
                        <div id="agenzia_prezzi_4pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_4pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_free_pax" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_free_pax')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_free_pax"
                        id="agenzia_prezzi_free_pax"
                        value="<?= esc(old('agenzia_prezzi_free_pax', $row->agenzia_prezzi_free_pax ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_free_pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_free_pax-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_free_pax']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_free_pax'])): ?>
                        <div id="agenzia_prezzi_free_pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_free_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_free" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_free')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_free"
                        id="agenzia_prezzi_free"
                        value="<?= esc(old('agenzia_prezzi_free', $row->agenzia_prezzi_free ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_free']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_free-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_free']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_free'])): ?>
                        <div id="agenzia_prezzi_free-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_free']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_portage" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_portage')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_portage"
                        id="agenzia_prezzi_portage"
                        value="<?= esc(old('agenzia_prezzi_portage', $row->agenzia_prezzi_portage ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_portage']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_portage-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_portage']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_portage'])): ?>
                        <div id="agenzia_prezzi_portage-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_portage']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_wdrink" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_wdrink')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_wdrink"
                        id="agenzia_prezzi_wdrink"
                        value="<?= esc(old('agenzia_prezzi_wdrink', $row->agenzia_prezzi_wdrink ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_wdrink']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_wdrink-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_wdrink']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_wdrink'])): ?>
                        <div id="agenzia_prezzi_wdrink-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_wdrink']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_american_bb" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_american_bb')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_american_bb"
                        id="agenzia_prezzi_american_bb"
                        value="<?= esc(old('agenzia_prezzi_american_bb', $row->agenzia_prezzi_american_bb ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_american_bb']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_american_bb-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_american_bb']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_american_bb'])): ?>
                        <div id="agenzia_prezzi_american_bb-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_american_bb']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_pranzo" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_pranzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_pranzo"
                        id="agenzia_prezzi_pranzo"
                        value="<?= esc(old('agenzia_prezzi_pranzo', $row->agenzia_prezzi_pranzo ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_pranzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_pranzo-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_pranzo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_pranzo'])): ?>
                        <div id="agenzia_prezzi_pranzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_pranzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_cena" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_cena')) ?>
                    </label>
                    <input
                        type="number"
                        name="agenzia_prezzi_cena"
                        id="agenzia_prezzi_cena"
                        value="<?= esc(old('agenzia_prezzi_cena', $row->agenzia_prezzi_cena ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_cena']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_cena-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_cena']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_cena'])): ?>
                        <div id="agenzia_prezzi_cena-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_cena']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_nome" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_prezzi_nome"
                        id="agenzia_prezzi_nome"
                        value="<?= esc(old('agenzia_prezzi_nome', $row->agenzia_prezzi_nome ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_nome-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_nome'])): ?>
                        <div id="agenzia_prezzi_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_note" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="agenzia_prezzi_note"
                        id="agenzia_prezzi_note"
                        value="<?= esc(old('agenzia_prezzi_note', $row->agenzia_prezzi_note ?? '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_note-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_note']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_note'])): ?>
                        <div id="agenzia_prezzi_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agenzia_prezzi_datarecord" class="form-label">
                        <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_datarecord')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="agenzia_prezzi_datarecord"
                        id="agenzia_prezzi_datarecord"
                        value="<?= esc(old('agenzia_prezzi_datarecord', isset($row->agenzia_prezzi_datarecord) ? str_replace(' ', 'T', substr((string) $row->agenzia_prezzi_datarecord, 0, 16)) : '')) ?>"
                        class="form-control <?= isset($errors['agenzia_prezzi_datarecord']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_prezzi_datarecord-error"
                        aria-invalid="<?= isset($errors['agenzia_prezzi_datarecord']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['agenzia_prezzi_datarecord'])): ?>
                        <div id="agenzia_prezzi_datarecord-error" class="invalid-feedback d-block">
                            <?= esc($errors['agenzia_prezzi_datarecord']) ?>
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

                    <a href="<?= site_url('agenzia_prezzi') ?>" class="btn btn-secondary">
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
