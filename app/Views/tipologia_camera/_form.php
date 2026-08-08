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
                    <label for="nome_tipologia" class="form-label">
                        <?= esc(lang('TipologiaCamera.nome_tipologia')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia"
                        id="nome_tipologia"
                        value="<?= esc(old('nome_tipologia', $row->nome_tipologia ?? ($context['nome_tipologia'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_tipologia']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_tipologia-error"
                        aria-invalid="<?= isset($errors['nome_tipologia']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['nome_tipologia'])): ?>
                        <div id="nome_tipologia-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_en" class="form-label">
                        <?= esc(lang('TipologiaCamera.nome_tipologia_en')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_en"
                        id="nome_tipologia_en"
                        value="<?= esc(old('nome_tipologia_en', $row->nome_tipologia_en ?? ($context['nome_tipologia_en'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_en']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_tipologia_en-error"
                        aria-invalid="<?= isset($errors['nome_tipologia_en']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_en'])): ?>
                        <div id="nome_tipologia_en-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_en']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_fr" class="form-label">
                        <?= esc(lang('TipologiaCamera.nome_tipologia_fr')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_fr"
                        id="nome_tipologia_fr"
                        value="<?= esc(old('nome_tipologia_fr', $row->nome_tipologia_fr ?? ($context['nome_tipologia_fr'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_fr']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_tipologia_fr-error"
                        aria-invalid="<?= isset($errors['nome_tipologia_fr']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_fr'])): ?>
                        <div id="nome_tipologia_fr-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_fr']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_de" class="form-label">
                        <?= esc(lang('TipologiaCamera.nome_tipologia_de')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_de"
                        id="nome_tipologia_de"
                        value="<?= esc(old('nome_tipologia_de', $row->nome_tipologia_de ?? ($context['nome_tipologia_de'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_de']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_tipologia_de-error"
                        aria-invalid="<?= isset($errors['nome_tipologia_de']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_de'])): ?>
                        <div id="nome_tipologia_de-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_de']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_sp" class="form-label">
                        <?= esc(lang('TipologiaCamera.nome_tipologia_sp')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_sp"
                        id="nome_tipologia_sp"
                        value="<?= esc(old('nome_tipologia_sp', $row->nome_tipologia_sp ?? ($context['nome_tipologia_sp'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_sp']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_tipologia_sp-error"
                        aria-invalid="<?= isset($errors['nome_tipologia_sp']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_sp'])): ?>
                        <div id="nome_tipologia_sp-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_sp']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="nome_tipologia_jp" class="form-label">
                        <?= esc(lang('TipologiaCamera.nome_tipologia_jp')) ?>
                    </label>
                    <input
                        type="text"
                        name="nome_tipologia_jp"
                        id="nome_tipologia_jp"
                        value="<?= esc(old('nome_tipologia_jp', $row->nome_tipologia_jp ?? ($context['nome_tipologia_jp'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['nome_tipologia_jp']) ? 'is-invalid' : '' ?>"
                        aria-describedby="nome_tipologia_jp-error"
                        aria-invalid="<?= isset($errors['nome_tipologia_jp']) ? 'true' : 'false' ?>"
                        maxlength="200"
                    >
                    <?php if (!empty($errors['nome_tipologia_jp'])): ?>
                        <div id="nome_tipologia_jp-error" class="invalid-feedback d-block">
                            <?= esc($errors['nome_tipologia_jp']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_sigla" class="form-label">
                        <?= esc(lang('TipologiaCamera.tipologia_sigla')) ?>
                    </label>
                    <input
                        type="text"
                        name="tipologia_sigla"
                        id="tipologia_sigla"
                        value="<?= esc(old('tipologia_sigla', $row->tipologia_sigla ?? ($context['tipologia_sigla'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tipologia_sigla']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_sigla-error"
                        aria-invalid="<?= isset($errors['tipologia_sigla']) ? 'true' : 'false' ?>"
                        required maxlength="10"
                    >
                    <?php if (!empty($errors['tipologia_sigla'])): ?>
                        <div id="tipologia_sigla-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_sigla']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="numero_pax" class="form-label">
                        <?= esc(lang('TipologiaCamera.numero_pax')) ?>
                    </label>
                    <input
                        type="text"
                        name="numero_pax"
                        id="numero_pax"
                        value="<?= esc(old('numero_pax', $row->numero_pax ?? ($context['numero_pax'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['numero_pax']) ? 'is-invalid' : '' ?>"
                        aria-describedby="numero_pax-error"
                        aria-invalid="<?= isset($errors['numero_pax']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['numero_pax'])): ?>
                        <div id="numero_pax-error" class="invalid-feedback d-block">
                            <?= esc($errors['numero_pax']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tipologia_camera_utente_id" class="form-label">
                        <?= esc(lang('TipologiaCamera.tipologia_camera_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="tipologia_camera_utente_id"
                        id="tipologia_camera_utente_id"
                        value="<?= esc(old('tipologia_camera_utente_id', $row->tipologia_camera_utente_id ?? ($context['tipologia_camera_utente_id'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['tipologia_camera_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tipologia_camera_utente_id-error"
                        aria-invalid="<?= isset($errors['tipologia_camera_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['tipologia_camera_utente_id'])): ?>
                        <div id="tipologia_camera_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['tipologia_camera_utente_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="perc_prezzo" class="form-label">
                        <?= esc(lang('TipologiaCamera.perc_prezzo')) ?>
                    </label>
                    <input
                        type="number"
                        name="perc_prezzo"
                        id="perc_prezzo"
                        value="<?= esc(old('perc_prezzo', $row->perc_prezzo ?? ($context['perc_prezzo'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['perc_prezzo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="perc_prezzo-error"
                        aria-invalid="<?= isset($errors['perc_prezzo']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['perc_prezzo'])): ?>
                        <div id="perc_prezzo-error" class="invalid-feedback d-block">
                            <?= esc($errors['perc_prezzo']) ?>
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

                    <a href="<?= site_url('tipologia_camera') ?>" class="btn btn-secondary">
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
