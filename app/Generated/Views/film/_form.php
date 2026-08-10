<?php
$formTitle = $formTitle ?? 'Gestione record';
$formIcon = $formIcon ?? 'bi-pencil-square';
$formAction = $formAction ?? current_url();
$row = $row ?? null;
$errors = $errors ?? [];
$options = $options ?? [];
$context = $context ?? [];
$contextLabels = $contextLabels ?? [];
$navigationContext = (array) ($navigationContext ?? []);
$submissionToken = $submissionToken ?? '';
?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="h4 mb-0">
                <i class="bi <?= esc($formIcon) ?>"></i>
                <?= esc($formTitle) ?>
            </h2>
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
                <?php foreach ($navigationContext as $contextField => $contextValue): ?>
                    <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
                <?php endforeach; ?>

                <div class="col-md-6">
                    <label for="title" class="form-label">
                        <?= esc(lang('Film.title')) ?>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="<?= esc(old('title', $row->{'title'} ?? ($context['title'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                        aria-describedby="title-error"
                        aria-invalid="<?= isset($errors['title']) ? 'true' : 'false' ?>"
                        required maxlength="128"
                    >
                    <?php if (!empty($errors['title'])): ?>
                        <div id="title-error" class="invalid-feedback d-block">
                            <?= esc($errors['title']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">
                        <?= esc(lang('Film.description')) ?>
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>"
                        aria-describedby="description-error"
                        aria-invalid="<?= isset($errors['description']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('description', $row->{'description'} ?? ($context['description'] ?? ''))) ?></textarea>
                    <?php if (!empty($errors['description'])): ?>
                        <div id="description-error" class="invalid-feedback d-block">
                            <?= esc($errors['description']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="release_year" class="form-label">
                        <?= esc(lang('Film.release_year')) ?>
                    </label>
                    <input
                        type="text"
                        name="release_year"
                        id="release_year"
                        value="<?= esc(old('release_year', $row->{'release_year'} ?? ($context['release_year'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['release_year']) ? 'is-invalid' : '' ?>"
                        aria-describedby="release_year-error"
                        aria-invalid="<?= isset($errors['release_year']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['release_year'])): ?>
                        <div id="release_year-error" class="invalid-feedback d-block">
                            <?= esc($errors['release_year']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="language_id" class="form-label">
                        <?= esc(lang('Film.language_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
                        name="language_id"
                        id="language_id"
                        class="form-select <?= isset($errors['language_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="language_id-error"
                        aria-invalid="<?= isset($errors['language_id']) ? 'true' : 'false' ?>"
                        required
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['language_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('language_id', $row->{'language_id'} ?? ($context['language_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="language_id"
                            data-base-url="<?= site_url('language/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_language_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_language_id"
                            aria-controls="related_create_language_id"
                            data-related-field="language_id"
                            data-panel-target="related_create_language_id"
                            data-state-target="related_create_language_id_state"
                            title="Crea nuovo Language"
                            aria-label="Crea nuovo Language"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?></div>
                    <?php if (!empty($errors['language_id'])): ?>
                        <div id="language_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['language_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['language_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[language_id]"
                            id="related_create_language_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_language_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            tabindex="-1"
                            aria-labelledby="related_create_language_id_label"
                            data-related-field="language_id"
                            data-state-target="related_create_language_id_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_language_id_label">Nuovo Language</h2>
                                    <small class="text-muted">Relazione language_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="language_id"
                                    data-state-target="related_create_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo Language"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo Language. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('film/_related_create_language_id', [
                                    'relatedField'        => 'language_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="language_id"
                                    data-state-target="related_create_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo Language
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="original_language_id" class="form-label">
                        <?= esc(lang('Film.original_language_id')) ?>
                    </label>
<div class="input-group crud-relation-input-group">                    <select
                        name="original_language_id"
                        id="original_language_id"
                        class="form-select <?= isset($errors['original_language_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="original_language_id-error"
                        aria-invalid="<?= isset($errors['original_language_id']) ? 'true' : 'false' ?>"
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach (($options['original_language_id'] ?? []) as $optionValue => $optionLabel): ?>
                            <option
                                value="<?= esc($optionValue) ?>"
                                <?= (string) old('original_language_id', $row->{'original_language_id'} ?? ($context['original_language_id'] ?? '')) === (string) $optionValue ? 'selected' : '' ?>
                            >
                                <?= esc($optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="original_language_id"
                            data-base-url="<?= site_url('language/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>                    <?php if ($row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="related_create_original_language_id_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#related_create_original_language_id"
                            aria-controls="related_create_original_language_id"
                            data-related-field="original_language_id"
                            data-panel-target="related_create_original_language_id"
                            data-state-target="related_create_original_language_id_state"
                            title="Crea nuovo Language"
                            aria-label="Crea nuovo Language"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?></div>
                    <?php if (!empty($errors['original_language_id'])): ?>
                        <div id="original_language_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['original_language_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($row === null): ?>
                    <?php
                    $relatedNewState = (array) old('_related_new', []);
                    $relatedPayloadState = (array) old('_related', []);
                    $relatedCreateActive = !empty($relatedNewState['original_language_id']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[original_language_id]"
                            id="related_create_original_language_id_state"
                            value="<?= $relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="related_create_original_language_id"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            tabindex="-1"
                            aria-labelledby="related_create_original_language_id_label"
                            data-related-field="original_language_id"
                            data-state-target="related_create_original_language_id_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="related_create_original_language_id_label">Nuovo Language</h2>
                                    <small class="text-muted">Relazione original_language_id</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="original_language_id"
                                    data-state-target="related_create_original_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo Language"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo Language. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('film/_related_create_original_language_id', [
                                    'relatedField'        => 'original_language_id',
                                    'relatedCreateActive' => $relatedCreateActive,
                                    'relatedPayloadState' => $relatedPayloadState,
                                    'errors'              => $errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="original_language_id"
                                    data-state-target="related_create_original_language_id_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo Language
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <label for="rental_duration" class="form-label">
                        <?= esc(lang('Film.rental_duration')) ?>
                    </label>
                    <input
                        type="number"
                        name="rental_duration"
                        id="rental_duration"
                        value="<?= esc(old('rental_duration', $row->{'rental_duration'} ?? ($context['rental_duration'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rental_duration']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rental_duration-error"
                        aria-invalid="<?= isset($errors['rental_duration']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['rental_duration'])): ?>
                        <div id="rental_duration-error" class="invalid-feedback d-block">
                            <?= esc($errors['rental_duration']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="rental_rate" class="form-label">
                        <?= esc(lang('Film.rental_rate')) ?>
                    </label>
                    <input
                        type="number"
                        name="rental_rate"
                        id="rental_rate"
                        value="<?= esc(old('rental_rate', $row->{'rental_rate'} ?? ($context['rental_rate'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rental_rate']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rental_rate-error"
                        aria-invalid="<?= isset($errors['rental_rate']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['rental_rate'])): ?>
                        <div id="rental_rate-error" class="invalid-feedback d-block">
                            <?= esc($errors['rental_rate']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="length" class="form-label">
                        <?= esc(lang('Film.length')) ?>
                    </label>
                    <input
                        type="number"
                        name="length"
                        id="length"
                        value="<?= esc(old('length', $row->{'length'} ?? ($context['length'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['length']) ? 'is-invalid' : '' ?>"
                        aria-describedby="length-error"
                        aria-invalid="<?= isset($errors['length']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['length'])): ?>
                        <div id="length-error" class="invalid-feedback d-block">
                            <?= esc($errors['length']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="replacement_cost" class="form-label">
                        <?= esc(lang('Film.replacement_cost')) ?>
                    </label>
                    <input
                        type="number"
                        name="replacement_cost"
                        id="replacement_cost"
                        value="<?= esc(old('replacement_cost', $row->{'replacement_cost'} ?? ($context['replacement_cost'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['replacement_cost']) ? 'is-invalid' : '' ?>"
                        aria-describedby="replacement_cost-error"
                        aria-invalid="<?= isset($errors['replacement_cost']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['replacement_cost'])): ?>
                        <div id="replacement_cost-error" class="invalid-feedback d-block">
                            <?= esc($errors['replacement_cost']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="rating" class="form-label">
                        <?= esc(lang('Film.rating')) ?>
                    </label>
                    <input
                        type="text"
                        name="rating"
                        id="rating"
                        value="<?= esc(old('rating', $row->{'rating'} ?? ($context['rating'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['rating']) ? 'is-invalid' : '' ?>"
                        aria-describedby="rating-error"
                        aria-invalid="<?= isset($errors['rating']) ? 'true' : 'false' ?>"
                        maxlength="5"
                    >
                    <?php if (!empty($errors['rating'])): ?>
                        <div id="rating-error" class="invalid-feedback d-block">
                            <?= esc($errors['rating']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="special_features" class="form-label">
                        <?= esc(lang('Film.special_features')) ?>
                    </label>
                    <input
                        type="text"
                        name="special_features"
                        id="special_features"
                        value="<?= esc(old('special_features', $row->{'special_features'} ?? ($context['special_features'] ?? ''))) ?>"
                        class="form-control <?= isset($errors['special_features']) ? 'is-invalid' : '' ?>"
                        aria-describedby="special_features-error"
                        aria-invalid="<?= isset($errors['special_features']) ? 'true' : 'false' ?>"
                        maxlength="54"
                    >
                    <?php if (!empty($errors['special_features'])): ?>
                        <div id="special_features-error" class="invalid-feedback d-block">
                            <?= esc($errors['special_features']) ?>
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

    // Relational Create tramite Bootstrap Offcanvas. Il pannello si
    // sovrappone alla vista senza alterare il layout del form principale.
    // La select/relazione originaria resta visivamente e funzionalmente
    // invariata; quando _related_new[field]=1 il server ignora la FK esistente
    // e crea il nuovo parent nella stessa transazione del record principale.
    const setRelatedCreateState = function (panel, active) {
        const field = String(panel.dataset.relatedField || '');
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (field === '' || !state) return;

        state.value = active ? '1' : '0';
        panel.querySelectorAll('.crud-related-create-field').forEach(function (input) {
            input.disabled = !active;
        });
    };

    document.querySelectorAll('.crud-related-create-panel.offcanvas').forEach(function (panel) {
        const field = String(panel.dataset.relatedField || '');
        const state = document.getElementById(String(panel.dataset.stateTarget || ''));
        if (field === '' || !state) return;

        setRelatedCreateState(panel, String(state.value || '0') === '1');

        panel.addEventListener('show.bs.offcanvas', function () {
            setRelatedCreateState(panel, true);
        });

        // Chiudere l'Offcanvas equivale ad annullare la creazione inline.
        // I valori digitati restano nel DOM e possono essere recuperati
        // riaprendo il pannello, ma non vengono inviati finché lo stato è 0.
        panel.addEventListener('hidden.bs.offcanvas', function () {
            setRelatedCreateState(panel, false);
        });

        // Se la validazione server ha restituito errori sul nuovo parent,
        // riapri automaticamente il pannello per mostrare campi ed errori.
        if (String(state.value || '0') === '1' && window.bootstrap?.Offcanvas) {
            window.bootstrap.Offcanvas.getOrCreateInstance(panel).show();
        }
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
