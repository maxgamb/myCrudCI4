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
                        <?= esc(lang('EmailAiHistory.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
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
                    <label for="raw_email" class="form-label">
                        <?= esc(lang('EmailAiHistory.raw_email')) ?>
                    </label>
                    <input
                        type="email"
                        name="raw_email"
                        id="raw_email"
                        value="<?= esc(old('raw_email', $row->raw_email ?? '')) ?>"
                        class="form-control <?= isset($errors['raw_email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="raw_email-error"
                        aria-invalid="<?= isset($errors['raw_email']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['raw_email'])): ?>
                        <div id="raw_email-error" class="invalid-feedback d-block">
                            <?= esc($errors['raw_email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="json_classifier" class="form-label">
                        <?= esc(lang('EmailAiHistory.json_classifier')) ?>
                    </label>
                    <input
                        type="text"
                        name="json_classifier"
                        id="json_classifier"
                        value="<?= esc(old('json_classifier', $row->json_classifier ?? '')) ?>"
                        class="form-control <?= isset($errors['json_classifier']) ? 'is-invalid' : '' ?>"
                        aria-describedby="json_classifier-error"
                        aria-invalid="<?= isset($errors['json_classifier']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['json_classifier'])): ?>
                        <div id="json_classifier-error" class="invalid-feedback d-block">
                            <?= esc($errors['json_classifier']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="category" class="form-label">
                        <?= esc(lang('EmailAiHistory.category')) ?>
                    </label>
                    <input
                        type="text"
                        name="category"
                        id="category"
                        value="<?= esc(old('category', $row->category ?? '')) ?>"
                        class="form-control <?= isset($errors['category']) ? 'is-invalid' : '' ?>"
                        aria-describedby="category-error"
                        aria-invalid="<?= isset($errors['category']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['category'])): ?>
                        <div id="category-error" class="invalid-feedback d-block">
                            <?= esc($errors['category']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="confidence" class="form-label">
                        <?= esc(lang('EmailAiHistory.confidence')) ?>
                    </label>
                    <input
                        type="number"
                        name="confidence"
                        id="confidence"
                        value="<?= esc(old('confidence', $row->confidence ?? '')) ?>"
                        class="form-control <?= isset($errors['confidence']) ? 'is-invalid' : '' ?>"
                        aria-describedby="confidence-error"
                        aria-invalid="<?= isset($errors['confidence']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['confidence'])): ?>
                        <div id="confidence-error" class="invalid-feedback d-block">
                            <?= esc($errors['confidence']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="referente_tipo" class="form-label">
                        <?= esc(lang('EmailAiHistory.referente_tipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="referente_tipo"
                        id="referente_tipo"
                        value="<?= esc(old('referente_tipo', $row->referente_tipo ?? '')) ?>"
                        class="form-control <?= isset($errors['referente_tipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="referente_tipo-error"
                        aria-invalid="<?= isset($errors['referente_tipo']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['referente_tipo'])): ?>
                        <div id="referente_tipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['referente_tipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="prenotazione_tipo" class="form-label">
                        <?= esc(lang('EmailAiHistory.prenotazione_tipo')) ?>
                    </label>
                    <input
                        type="text"
                        name="prenotazione_tipo"
                        id="prenotazione_tipo"
                        value="<?= esc(old('prenotazione_tipo', $row->prenotazione_tipo ?? '')) ?>"
                        class="form-control <?= isset($errors['prenotazione_tipo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="prenotazione_tipo-error"
                        aria-invalid="<?= isset($errors['prenotazione_tipo']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['prenotazione_tipo'])): ?>
                        <div id="prenotazione_tipo-error" class="invalid-feedback d-block">
                            <?= esc($errors['prenotazione_tipo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="finalita" class="form-label">
                        <?= esc(lang('EmailAiHistory.finalita')) ?>
                    </label>
                    <input
                        type="text"
                        name="finalita"
                        id="finalita"
                        value="<?= esc(old('finalita', $row->finalita ?? '')) ?>"
                        class="form-control <?= isset($errors['finalita']) ? 'is-invalid' : '' ?>"
                        aria-describedby="finalita-error"
                        aria-invalid="<?= isset($errors['finalita']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['finalita'])): ?>
                        <div id="finalita-error" class="invalid-feedback d-block">
                            <?= esc($errors['finalita']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="segmento_commerciale" class="form-label">
                        <?= esc(lang('EmailAiHistory.segmento_commerciale')) ?>
                    </label>
                    <input
                        type="text"
                        name="segmento_commerciale"
                        id="segmento_commerciale"
                        value="<?= esc(old('segmento_commerciale', $row->segmento_commerciale ?? '')) ?>"
                        class="form-control <?= isset($errors['segmento_commerciale']) ? 'is-invalid' : '' ?>"
                        aria-describedby="segmento_commerciale-error"
                        aria-invalid="<?= isset($errors['segmento_commerciale']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['segmento_commerciale'])): ?>
                        <div id="segmento_commerciale-error" class="invalid-feedback d-block">
                            <?= esc($errors['segmento_commerciale']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="agent_selected" class="form-label">
                        <?= esc(lang('EmailAiHistory.agent_selected')) ?>
                    </label>
                    <input
                        type="text"
                        name="agent_selected"
                        id="agent_selected"
                        value="<?= esc(old('agent_selected', $row->agent_selected ?? '')) ?>"
                        class="form-control <?= isset($errors['agent_selected']) ? 'is-invalid' : '' ?>"
                        aria-describedby="agent_selected-error"
                        aria-invalid="<?= isset($errors['agent_selected']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['agent_selected'])): ?>
                        <div id="agent_selected-error" class="invalid-feedback d-block">
                            <?= esc($errors['agent_selected']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="reply_prompt" class="form-label">
                        <?= esc(lang('EmailAiHistory.reply_prompt')) ?>
                    </label>
                    <input
                        type="text"
                        name="reply_prompt"
                        id="reply_prompt"
                        value="<?= esc(old('reply_prompt', $row->reply_prompt ?? '')) ?>"
                        class="form-control <?= isset($errors['reply_prompt']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reply_prompt-error"
                        aria-invalid="<?= isset($errors['reply_prompt']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['reply_prompt'])): ?>
                        <div id="reply_prompt-error" class="invalid-feedback d-block">
                            <?= esc($errors['reply_prompt']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="gpt_reply_raw" class="form-label">
                        <?= esc(lang('EmailAiHistory.gpt_reply_raw')) ?>
                    </label>
                    <input
                        type="text"
                        name="gpt_reply_raw"
                        id="gpt_reply_raw"
                        value="<?= esc(old('gpt_reply_raw', $row->gpt_reply_raw ?? '')) ?>"
                        class="form-control <?= isset($errors['gpt_reply_raw']) ? 'is-invalid' : '' ?>"
                        aria-describedby="gpt_reply_raw-error"
                        aria-invalid="<?= isset($errors['gpt_reply_raw']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['gpt_reply_raw'])): ?>
                        <div id="gpt_reply_raw-error" class="invalid-feedback d-block">
                            <?= esc($errors['gpt_reply_raw']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="gpt_reply_clean" class="form-label">
                        <?= esc(lang('EmailAiHistory.gpt_reply_clean')) ?>
                    </label>
                    <input
                        type="text"
                        name="gpt_reply_clean"
                        id="gpt_reply_clean"
                        value="<?= esc(old('gpt_reply_clean', $row->gpt_reply_clean ?? '')) ?>"
                        class="form-control <?= isset($errors['gpt_reply_clean']) ? 'is-invalid' : '' ?>"
                        aria-describedby="gpt_reply_clean-error"
                        aria-invalid="<?= isset($errors['gpt_reply_clean']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['gpt_reply_clean'])): ?>
                        <div id="gpt_reply_clean-error" class="invalid-feedback d-block">
                            <?= esc($errors['gpt_reply_clean']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pms_output" class="form-label">
                        <?= esc(lang('EmailAiHistory.pms_output')) ?>
                    </label>
                    <input
                        type="text"
                        name="pms_output"
                        id="pms_output"
                        value="<?= esc(old('pms_output', $row->pms_output ?? '')) ?>"
                        class="form-control <?= isset($errors['pms_output']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pms_output-error"
                        aria-invalid="<?= isset($errors['pms_output']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['pms_output'])): ?>
                        <div id="pms_output-error" class="invalid-feedback d-block">
                            <?= esc($errors['pms_output']) ?>
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

                    <a href="<?= site_url('email_ai_history') ?>" class="btn btn-secondary">
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
