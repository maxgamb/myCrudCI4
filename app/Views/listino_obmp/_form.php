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
                        <?= esc(lang('ListinoObmp.hotel_id')) ?>
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
                    <label for="listino_nome_id" class="form-label">
                        <?= esc(lang('ListinoObmp.listino_nome_id')) ?>
                    </label>
                    <select
                        name="listino_nome_id"
                        id="listino_nome_id"
                        class="form-select <?= isset($errors['listino_nome_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_nome_id-error"
                        aria-invalid="<?= isset($errors['listino_nome_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['listino_nome_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('listino_nome_id', $row->listino_nome_id ?? ($context['listino_nome_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="listino_nome_id"
                            data-base-url="<?= site_url('listino_nome_obmp/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('listino_nome_obmp/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['listino_nome_id'])): ?>
                        <div id="listino_nome_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_nome_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_id" class="form-label">
                        <?= esc(lang('ListinoObmp.tipologia_id')) ?>
                    </label>
                    <select
                        name="tipologia_id"
                        id="tipologia_id"
                        class="form-select <?= isset($errors['tipologia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_id-error"
                        aria-invalid="<?= isset($errors['tipologia_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['tipologia_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('tipologia_id', $row->tipologia_id ?? ($context['tipologia_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="tipologia_id"
                            data-base-url="<?= site_url('obmp_cm_rooms/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('obmp_cm_rooms/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['tipologia_id'])): ?>
                        <div id="tipologia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="listino_prezzo" class="form-label">
                        <?= esc(lang('ListinoObmp.listino_prezzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="listino_prezzo"
                        id="listino_prezzo"
                        value="<?= esc(old('listino_prezzo', $row->listino_prezzo ?? ($context['listino_prezzo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['listino_prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_prezzo-error"
                        aria-invalid="<?= isset($errors['listino_prezzo']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['listino_prezzo'])): ?>
                        <div id="listino_prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_prezzo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_site" class="form-label">
                        <?= esc(lang('ListinoObmp.ref_site')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_site"
                        id="ref_site"
                        value="<?= esc(old('ref_site', $row->ref_site ?? ($context['ref_site'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_site']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_site-error"
                        aria-invalid="<?= isset($errors['ref_site']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_site'])): ?>
                        <div id="ref_site-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_site']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_agency" class="form-label">
                        <?= esc(lang('ListinoObmp.ref_agency')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_agency"
                        id="ref_agency"
                        value="<?= esc(old('ref_agency', $row->ref_agency ?? ($context['ref_agency'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_agency']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_agency-error"
                        aria-invalid="<?= isset($errors['ref_agency']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_agency'])): ?>
                        <div id="ref_agency-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_agency']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_event" class="form-label">
                        <?= esc(lang('ListinoObmp.ref_event')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_event"
                        id="ref_event"
                        value="<?= esc(old('ref_event', $row->ref_event ?? ($context['ref_event'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_event']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_event-error"
                        aria-invalid="<?= isset($errors['ref_event']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_event'])): ?>
                        <div id="ref_event-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_event']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_session" class="form-label">
                        <?= esc(lang('ListinoObmp.ref_session')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_session"
                        id="ref_session"
                        value="<?= esc(old('ref_session', $row->ref_session ?? ($context['ref_session'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_session']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_session-error"
                        aria-invalid="<?= isset($errors['ref_session']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_session'])): ?>
                        <div id="ref_session-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_session']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_cookie" class="form-label">
                        <?= esc(lang('ListinoObmp.ref_cookie')) ?>
                    </label>
                    <input
                        type="number"
                        name="ref_cookie"
                        id="ref_cookie"
                        value="<?= esc(old('ref_cookie', $row->ref_cookie ?? ($context['ref_cookie'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_cookie']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_cookie-error"
                        aria-invalid="<?= isset($errors['ref_cookie']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['ref_cookie'])): ?>
                        <div id="ref_cookie-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_cookie']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="listino_obmp_datarecord" class="form-label">
                        <?= esc(lang('ListinoObmp.listino_obmp_datarecord')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="listino_obmp_datarecord"
                        id="listino_obmp_datarecord"
                        value="<?= esc(old('listino_obmp_datarecord', isset($row->listino_obmp_datarecord) ? str_replace(' ', 'T', substr((string) $row->listino_obmp_datarecord, 0, 16)) : ($context['listino_obmp_datarecord'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['listino_obmp_datarecord']) ? 'is-invalid' : '' ?>"
                        aria-describedby="listino_obmp_datarecord-error"
                        aria-invalid="<?= isset($errors['listino_obmp_datarecord']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['listino_obmp_datarecord'])): ?>
                        <div id="listino_obmp_datarecord-error" class="invalid-feedback d-block">
                            <?= esc($errors['listino_obmp_datarecord']) ?>
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

                    <a href="<?= site_url('listino_obmp') ?>" class="btn btn-secondary">
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
