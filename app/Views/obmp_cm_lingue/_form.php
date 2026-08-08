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
                    <label for="obmp_cm_rooms_id" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_rooms_id')) ?>
                    </label>
                    <select
                        name="obmp_cm_rooms_id"
                        id="obmp_cm_rooms_id"
                        class="form-select <?= isset($errors['obmp_cm_rooms_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_rooms_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_rooms_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['obmp_cm_rooms_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('obmp_cm_rooms_id', $row->obmp_cm_rooms_id ?? ($context['obmp_cm_rooms_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="obmp_cm_rooms_id"
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
                    <?php if (!empty($errors['obmp_cm_rooms_id'])): ?>
                        <div id="obmp_cm_rooms_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_rooms_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="hotel_id" class="form-label">
                        <?= esc(lang('ObmpCmLingue.hotel_id')) ?>
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
                    <label for="obmp_cm_lingue_codice" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_codice')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_codice"
                        id="obmp_cm_lingue_codice"
                        value="<?= esc(old('obmp_cm_lingue_codice', $row->obmp_cm_lingue_codice ?? ($context['obmp_cm_lingue_codice'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_codice']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_codice-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_codice']) ? 'true' : 'false' ?>"
                        maxlength="10"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_codice'])): ?>
                        <div id="obmp_cm_lingue_codice-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_codice']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_nome" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_nome"
                        id="obmp_cm_lingue_nome"
                        value="<?= esc(old('obmp_cm_lingue_nome', $row->obmp_cm_lingue_nome ?? ($context['obmp_cm_lingue_nome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_nome-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_nome'])): ?>
                        <div id="obmp_cm_lingue_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_descrizione" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_descrizione')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_descrizione"
                        id="obmp_cm_lingue_descrizione"
                        value="<?= esc(old('obmp_cm_lingue_descrizione', $row->obmp_cm_lingue_descrizione ?? ($context['obmp_cm_lingue_descrizione'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_descrizione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_descrizione-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_descrizione']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_descrizione'])): ?>
                        <div id="obmp_cm_lingue_descrizione-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_descrizione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_html1" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_html1')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_html1"
                        id="obmp_cm_lingue_html1"
                        value="<?= esc(old('obmp_cm_lingue_html1', $row->obmp_cm_lingue_html1 ?? ($context['obmp_cm_lingue_html1'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_html1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_html1-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_html1']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_html1'])): ?>
                        <div id="obmp_cm_lingue_html1-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_html1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_html2" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_html2')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_html2"
                        id="obmp_cm_lingue_html2"
                        value="<?= esc(old('obmp_cm_lingue_html2', $row->obmp_cm_lingue_html2 ?? ($context['obmp_cm_lingue_html2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_html2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_html2-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_html2']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_html2'])): ?>
                        <div id="obmp_cm_lingue_html2-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_html2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_html3" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_html3')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_html3"
                        id="obmp_cm_lingue_html3"
                        value="<?= esc(old('obmp_cm_lingue_html3', $row->obmp_cm_lingue_html3 ?? ($context['obmp_cm_lingue_html3'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_html3']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_html3-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_html3']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_html3'])): ?>
                        <div id="obmp_cm_lingue_html3-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_html3']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_note" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_note"
                        id="obmp_cm_lingue_note"
                        value="<?= esc(old('obmp_cm_lingue_note', $row->obmp_cm_lingue_note ?? ($context['obmp_cm_lingue_note'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_note-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_note']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_note'])): ?>
                        <div id="obmp_cm_lingue_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_politiche" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_politiche')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_politiche"
                        id="obmp_cm_lingue_politiche"
                        value="<?= esc(old('obmp_cm_lingue_politiche', $row->obmp_cm_lingue_politiche ?? ($context['obmp_cm_lingue_politiche'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_politiche']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_politiche-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_politiche']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_politiche'])): ?>
                        <div id="obmp_cm_lingue_politiche-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_politiche']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_condizioni" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_condizioni')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_condizioni"
                        id="obmp_cm_lingue_condizioni"
                        value="<?= esc(old('obmp_cm_lingue_condizioni', $row->obmp_cm_lingue_condizioni ?? ($context['obmp_cm_lingue_condizioni'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_condizioni']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_condizioni-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_condizioni']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_condizioni'])): ?>
                        <div id="obmp_cm_lingue_condizioni-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_condizioni']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="obmp_cm_lingue_utente_id" class="form-label">
                        <?= esc(lang('ObmpCmLingue.obmp_cm_lingue_utente_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="obmp_cm_lingue_utente_id"
                        id="obmp_cm_lingue_utente_id"
                        value="<?= esc(old('obmp_cm_lingue_utente_id', $row->obmp_cm_lingue_utente_id ?? ($context['obmp_cm_lingue_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['obmp_cm_lingue_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="obmp_cm_lingue_utente_id-error"
                        aria-invalid="<?= isset($errors['obmp_cm_lingue_utente_id']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['obmp_cm_lingue_utente_id'])): ?>
                        <div id="obmp_cm_lingue_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['obmp_cm_lingue_utente_id']) ?>
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

                    <a href="<?= site_url('obmp_cm_lingue') ?>" class="btn btn-secondary">
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
