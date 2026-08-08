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
                        <?= esc(lang('Pratiche.hotel_id')) ?>
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
                    <label for="pratica_nome" class="form-label">
                        <?= esc(lang('Pratiche.pratica_nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="pratica_nome"
                        id="pratica_nome"
                        value="<?= esc(old('pratica_nome', $row->pratica_nome ?? ($context['pratica_nome'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pratica_nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_nome-error"
                        aria-invalid="<?= isset($errors['pratica_nome']) ? 'true' : 'false' ?>"
                        maxlength="250"
                    >
                    <?php if (!empty($errors['pratica_nome'])): ?>
                        <div id="pratica_nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratica_agenzia_id" class="form-label">
                        <?= esc(lang('Pratiche.pratica_agenzia_id')) ?>
                    </label>
                    <select
                        name="pratica_agenzia_id"
                        id="pratica_agenzia_id"
                        class="form-select <?= isset($errors['pratica_agenzia_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_agenzia_id-error"
                        aria-invalid="<?= isset($errors['pratica_agenzia_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['pratica_agenzia_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('pratica_agenzia_id', $row->pratica_agenzia_id ?? ($context['pratica_agenzia_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
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
                            data-value-source="pratica_agenzia_id"
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
                    <?php if (!empty($errors['pratica_agenzia_id'])): ?>
                        <div id="pratica_agenzia_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_agenzia_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratica_1" class="form-label">
                        <?= esc(lang('Pratiche.pratica_1')) ?>
                    </label>
                    <input
                        type="text"
                        name="pratica_1"
                        id="pratica_1"
                        value="<?= esc(old('pratica_1', $row->pratica_1 ?? ($context['pratica_1'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pratica_1']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_1-error"
                        aria-invalid="<?= isset($errors['pratica_1']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['pratica_1'])): ?>
                        <div id="pratica_1-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_1']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratica_2" class="form-label">
                        <?= esc(lang('Pratiche.pratica_2')) ?>
                    </label>
                    <input
                        type="text"
                        name="pratica_2"
                        id="pratica_2"
                        value="<?= esc(old('pratica_2', $row->pratica_2 ?? ($context['pratica_2'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pratica_2']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_2-error"
                        aria-invalid="<?= isset($errors['pratica_2']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['pratica_2'])): ?>
                        <div id="pratica_2-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_2']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratica_note" class="form-label">
                        <?= esc(lang('Pratiche.pratica_note')) ?>
                    </label>
                    <input
                        type="text"
                        name="pratica_note"
                        id="pratica_note"
                        value="<?= esc(old('pratica_note', $row->pratica_note ?? ($context['pratica_note'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pratica_note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_note-error"
                        aria-invalid="<?= isset($errors['pratica_note']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pratica_note'])): ?>
                        <div id="pratica_note-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratica_stato" class="form-label">
                        <?= esc(lang('Pratiche.pratica_stato')) ?>
                    </label>
                    <input
                        type="number"
                        name="pratica_stato"
                        id="pratica_stato"
                        value="<?= esc(old('pratica_stato', $row->pratica_stato ?? ($context['pratica_stato'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pratica_stato']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratica_stato-error"
                        aria-invalid="<?= isset($errors['pratica_stato']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pratica_stato'])): ?>
                        <div id="pratica_stato-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratica_stato']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pratiche_utente_id" class="form-label">
                        <?= esc(lang('Pratiche.pratiche_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="pratiche_utente_id"
                        id="pratiche_utente_id"
                        value="<?= esc(old('pratiche_utente_id', $row->pratiche_utente_id ?? ($context['pratiche_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['pratiche_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pratiche_utente_id-error"
                        aria-invalid="<?= isset($errors['pratiche_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pratiche_utente_id'])): ?>
                        <div id="pratiche_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['pratiche_utente_id']) ?>
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

                    <a href="<?= site_url('pratiche') ?>" class="btn btn-secondary">
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
