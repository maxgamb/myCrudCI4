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
                    <label for="ref_site_id" class="form-label">
                        <?= esc(lang('ObmpRefEvent.ref_site_id')) ?>
                    </label>
                    <select
                        name="ref_site_id"
                        id="ref_site_id"
                        class="form-select <?= isset($errors['ref_site_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_site_id-error"
                        aria-invalid="<?= isset($errors['ref_site_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['ref_site_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('ref_site_id', $row->ref_site_id ?? ($context['ref_site_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="ref_site_id"
                            data-base-url="<?= site_url('obmp_ref_site/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>                        <a
                            href="<?= site_url('obmp_ref_site/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>                    </div>
                    <?php if (!empty($errors['ref_site_id'])): ?>
                        <div id="ref_site_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_site_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpRefEvent.hotel_id')) ?>
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
                        <?= esc(lang('ObmpRefEvent.listino_nome_id')) ?>
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
                    <label for="agenzia_id" class="form-label">
                        <?= esc(lang('ObmpRefEvent.agenzia_id')) ?>
                    </label>
                    <select
                        name="agenzia_id"
                        id="agenzia_id"
                        class="form-select <?= isset($errors['agenzia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agenzia_id-error"
                        aria-invalid="<?= isset($errors['agenzia_id']) ? 'true' : 'false' ?>"
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
                    <label for="ref_event_nome" class="form-label">
                        <?= esc(lang('ObmpRefEvent.ref_event_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="ref_event_nome"
                        id="ref_event_nome"
                        value="<?= esc(old('ref_event_nome', $row->ref_event_nome ?? ($context['ref_event_nome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_event_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_event_nome-error"
                        aria-invalid="<?= isset($errors['ref_event_nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['ref_event_nome'])): ?>
                        <div id="ref_event_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_event_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="event_dal" class="form-label">
                        <?= esc(lang('ObmpRefEvent.event_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="event_dal"
                        id="event_dal"
                        value="<?= esc(old('event_dal', $row->event_dal ?? ($context['event_dal'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['event_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="event_dal-error"
                        aria-invalid="<?= isset($errors['event_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['event_dal'])): ?>
                        <div id="event_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['event_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="event_al" class="form-label">
                        <?= esc(lang('ObmpRefEvent.event_al')) ?>
                    </label>
                    <input
                        type="date"
                        name="event_al"
                        id="event_al"
                        value="<?= esc(old('event_al', $row->event_al ?? ($context['event_al'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['event_al']) ? 'is-invalid' : '' ?>"
                        aria-describedby="event_al-error"
                        aria-invalid="<?= isset($errors['event_al']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['event_al'])): ?>
                        <div id="event_al-error" class="invalid-feedback d-block">
                            <?= esc($errors['event_al']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ref_event_note" class="form-label">
                        <?= esc(lang('ObmpRefEvent.ref_event_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="ref_event_note"
                        id="ref_event_note"
                        value="<?= esc(old('ref_event_note', $row->ref_event_note ?? ($context['ref_event_note'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['ref_event_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ref_event_note-error"
                        aria-invalid="<?= isset($errors['ref_event_note']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['ref_event_note'])): ?>
                        <div id="ref_event_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['ref_event_note']) ?>
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

                    <a href="<?= site_url('obmp_ref_event') ?>" class="btn btn-secondary">
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
