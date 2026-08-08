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
                        <?= esc(lang('Sospesi.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? ($context['hotel_id'] ?? ''))) ?>"
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
                    <label for="pagamento_id" class="form-label">
                        <?= esc(lang('Sospesi.pagamento_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="pagamento_id"
                        id="pagamento_id"
                        value="<?= esc(old('pagamento_id', $row->pagamento_id ?? ($context['pagamento_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pagamento_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamento_id-error"
                        aria-invalid="<?= isset($errors['pagamento_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pagamento_id'])): ?>
                        <div id="pagamento_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamento_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="cassa_id" class="form-label">
                        <?= esc(lang('Sospesi.cassa_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="cassa_id"
                        id="cassa_id"
                        value="<?= esc(old('cassa_id', $row->cassa_id ?? ($context['cassa_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['cassa_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="cassa_id-error"
                        aria-invalid="<?= isset($errors['cassa_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['cassa_id'])): ?>
                        <div id="cassa_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['cassa_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_data" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_data')) ?>
                    </label>
                    <input
                        type="date"
                        name="sospeso_data"
                        id="sospeso_data"
                        value="<?= esc(old('sospeso_data', $row->sospeso_data ?? ($context['sospeso_data'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_data']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_data-error"
                        aria-invalid="<?= isset($errors['sospeso_data']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['sospeso_data'])): ?>
                        <div id="sospeso_data-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_data']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_conto_id" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_conto_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="sospeso_conto_id"
                        id="sospeso_conto_id"
                        value="<?= esc(old('sospeso_conto_id', $row->sospeso_conto_id ?? ($context['sospeso_conto_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_conto_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_conto_id-error"
                        aria-invalid="<?= isset($errors['sospeso_conto_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sospeso_conto_id'])): ?>
                        <div id="sospeso_conto_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_conto_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_pratica_id" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_pratica_id')) ?>
                    </label>
                    <select
                        name="sospeso_pratica_id"
                        id="sospeso_pratica_id"
                        class="form-select <?= isset($errors['sospeso_pratica_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_pratica_id-error"
                        aria-invalid="<?= isset($errors['sospeso_pratica_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['sospeso_pratica_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('sospeso_pratica_id', $row->sospeso_pratica_id ?? ($context['sospeso_pratica_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="sospeso_pratica_id"
                            data-base-url="<?= site_url('pratiche/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('pratiche/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['sospeso_pratica_id'])): ?>
                        <div id="sospeso_pratica_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_pratica_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_preno_id" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_preno_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="sospeso_preno_id"
                        id="sospeso_preno_id"
                        value="<?= esc(old('sospeso_preno_id', $row->sospeso_preno_id ?? ($context['sospeso_preno_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_preno_id-error"
                        aria-invalid="<?= isset($errors['sospeso_preno_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sospeso_preno_id'])): ?>
                        <div id="sospeso_preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_fatt_numero" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_fatt_numero')) ?>
                    </label>
                    <input
                        type="number"
                        name="sospeso_fatt_numero"
                        id="sospeso_fatt_numero"
                        value="<?= esc(old('sospeso_fatt_numero', $row->sospeso_fatt_numero ?? ($context['sospeso_fatt_numero'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_fatt_numero']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_fatt_numero-error"
                        aria-invalid="<?= isset($errors['sospeso_fatt_numero']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sospeso_fatt_numero'])): ?>
                        <div id="sospeso_fatt_numero-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_fatt_numero']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sopeso_importo" class="form-label">
                        <?= esc(lang('Sospesi.sopeso_importo')) ?>
                    </label>
                    <input
                        type="number"
                        name="sopeso_importo"
                        id="sopeso_importo"
                        value="<?= esc(old('sopeso_importo', $row->sopeso_importo ?? ($context['sopeso_importo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sopeso_importo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sopeso_importo-error"
                        aria-invalid="<?= isset($errors['sopeso_importo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sopeso_importo'])): ?>
                        <div id="sopeso_importo-error" class="invalid-feedback d-block">
                            <?= esc($errors['sopeso_importo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_imp_conto" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_imp_conto')) ?>
                    </label>
                    <input
                        type="number"
                        name="sospeso_imp_conto"
                        id="sospeso_imp_conto"
                        value="<?= esc(old('sospeso_imp_conto', $row->sospeso_imp_conto ?? ($context['sospeso_imp_conto'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_imp_conto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_imp_conto-error"
                        aria-invalid="<?= isset($errors['sospeso_imp_conto']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['sospeso_imp_conto'])): ?>
                        <div id="sospeso_imp_conto-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_imp_conto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sopeso_societa" class="form-label">
                        <?= esc(lang('Sospesi.sopeso_societa')) ?>
                    </label>
                    <select
                        name="sopeso_societa"
                        id="sopeso_societa"
                        class="form-select <?= isset($errors['sopeso_societa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sopeso_societa-error"
                        aria-invalid="<?= isset($errors['sopeso_societa']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['sopeso_societa'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('sopeso_societa', $row->sopeso_societa ?? ($context['sopeso_societa'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="sopeso_societa"
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
                    <?php if (!empty($errors['sopeso_societa'])): ?>
                        <div id="sopeso_societa-error" class="invalid-feedback d-block">
                            <?= esc($errors['sopeso_societa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_note" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="sospeso_note"
                        id="sospeso_note"
                        value="<?= esc(old('sospeso_note', $row->sospeso_note ?? ($context['sospeso_note'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_note-error"
                        aria-invalid="<?= isset($errors['sospeso_note']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sospeso_note'])): ?>
                        <div id="sospeso_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospeso_stato" class="form-label">
                        <?= esc(lang('Sospesi.sospeso_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="sospeso_stato"
                        id="sospeso_stato"
                        value="<?= esc(old('sospeso_stato', $row->sospeso_stato ?? ($context['sospeso_stato'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospeso_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospeso_stato-error"
                        aria-invalid="<?= isset($errors['sospeso_stato']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sospeso_stato'])): ?>
                        <div id="sospeso_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospeso_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="sospesi_utente_id" class="form-label">
                        <?= esc(lang('Sospesi.sospesi_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="sospesi_utente_id"
                        id="sospesi_utente_id"
                        value="<?= esc(old('sospesi_utente_id', $row->sospesi_utente_id ?? ($context['sospesi_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['sospesi_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="sospesi_utente_id-error"
                        aria-invalid="<?= isset($errors['sospesi_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['sospesi_utente_id'])): ?>
                        <div id="sospesi_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['sospesi_utente_id']) ?>
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

                    <a href="<?= site_url('sospesi') ?>" class="btn btn-secondary">
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
