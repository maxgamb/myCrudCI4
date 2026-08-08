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
                    <label for="mod_preno_id" class="form-label">
                        <?= esc(lang('ModificaAgenda.mod_preno_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="mod_preno_id"
                        id="mod_preno_id"
                        value="<?= esc(old('mod_preno_id', $row->mod_preno_id ?? ($context['mod_preno_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['mod_preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_preno_id-error"
                        aria-invalid="<?= isset($errors['mod_preno_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_preno_id'])): ?>
                        <div id="mod_preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_agenda_valori" class="form-label">
                        <?= esc(lang('ModificaAgenda.mod_agenda_valori')) ?>
                    </label>
                    <input
                        type="text"
                        name="mod_agenda_valori"
                        id="mod_agenda_valori"
                        value="<?= esc(old('mod_agenda_valori', $row->mod_agenda_valori ?? ($context['mod_agenda_valori'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['mod_agenda_valori']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_agenda_valori-error"
                        aria-invalid="<?= isset($errors['mod_agenda_valori']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['mod_agenda_valori'])): ?>
                        <div id="mod_agenda_valori-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_agenda_valori']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="mod_preno_data_records" class="form-label">
                        <?= esc(lang('ModificaAgenda.mod_preno_data_records')) ?>
                    </label>
                    <input
                        type="datetime-local"
                        name="mod_preno_data_records"
                        id="mod_preno_data_records"
                        value="<?= esc(old('mod_preno_data_records', isset($row->mod_preno_data_records) ? str_replace(' ', 'T', substr((string) $row->mod_preno_data_records, 0, 16)) : ($context['mod_preno_data_records'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['mod_preno_data_records']) ? 'is-invalid' : '' ?>"
                        aria-describedby="mod_preno_data_records-error"
                        aria-invalid="<?= isset($errors['mod_preno_data_records']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['mod_preno_data_records'])): ?>
                        <div id="mod_preno_data_records-error" class="invalid-feedback d-block">
                            <?= esc($errors['mod_preno_data_records']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="modifica_agenda_adebiti_utente_id" class="form-label">
                        <?= esc(lang('ModificaAgenda.modifica_agenda_adebiti_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="modifica_agenda_adebiti_utente_id"
                        id="modifica_agenda_adebiti_utente_id"
                        value="<?= esc(old('modifica_agenda_adebiti_utente_id', $row->modifica_agenda_adebiti_utente_id ?? ($context['modifica_agenda_adebiti_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['modifica_agenda_adebiti_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="modifica_agenda_adebiti_utente_id-error"
                        aria-invalid="<?= isset($errors['modifica_agenda_adebiti_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['modifica_agenda_adebiti_utente_id'])): ?>
                        <div id="modifica_agenda_adebiti_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['modifica_agenda_adebiti_utente_id']) ?>
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

                    <a href="<?= site_url('modifica_agenda') ?>" class="btn btn-secondary">
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
