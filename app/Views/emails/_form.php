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
                    <label for="direction" class="form-label">
                        <?= esc(lang('Emails.direction')) ?>
                    </label>
                    <input
                        type="text"
                        name="direction"
                        id="direction"
                        value="<?= esc(old('direction', $row->direction ?? '')) ?>"
                        class="form-control <?= isset($errors['direction']) ? 'is-invalid' : '' ?>"
                        aria-describedby="direction-error"
                        aria-invalid="<?= isset($errors['direction']) ? 'true' : 'false' ?>"
                        maxlength="3"
                    >
                    <?php if (!empty($errors['direction'])): ?>
                        <div id="direction-error" class="invalid-feedback d-block">
                            <?= esc($errors['direction']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="uid" class="form-label">
                        <?= esc(lang('Emails.uid')) ?>
                    </label>
                    <input
                        type="text"
                        name="uid"
                        id="uid"
                        value="<?= esc(old('uid', $row->uid ?? '')) ?>"
                        class="form-control <?= isset($errors['uid']) ? 'is-invalid' : '' ?>"
                        aria-describedby="uid-error"
                        aria-invalid="<?= isset($errors['uid']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['uid'])): ?>
                        <div id="uid-error" class="invalid-feedback d-block">
                            <?= esc($errors['uid']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="message_id" class="form-label">
                        <?= esc(lang('Emails.message_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="message_id"
                        id="message_id"
                        value="<?= esc(old('message_id', $row->message_id ?? '')) ?>"
                        class="form-control <?= isset($errors['message_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="message_id-error"
                        aria-invalid="<?= isset($errors['message_id']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['message_id'])): ?>
                        <div id="message_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['message_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="in_reply_to" class="form-label">
                        <?= esc(lang('Emails.in_reply_to')) ?>
                    </label>
                    <input
                        type="text"
                        name="in_reply_to"
                        id="in_reply_to"
                        value="<?= esc(old('in_reply_to', $row->in_reply_to ?? '')) ?>"
                        class="form-control <?= isset($errors['in_reply_to']) ? 'is-invalid' : '' ?>"
                        aria-describedby="in_reply_to-error"
                        aria-invalid="<?= isset($errors['in_reply_to']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['in_reply_to'])): ?>
                        <div id="in_reply_to-error" class="invalid-feedback d-block">
                            <?= esc($errors['in_reply_to']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="refs" class="form-label">
                        <?= esc(lang('Emails.refs')) ?>
                    </label>
                    <textarea
                        name="refs"
                        id="refs"
                        class="form-control <?= isset($errors['refs']) ? 'is-invalid' : '' ?>"
                        aria-describedby="refs-error"
                        aria-invalid="<?= isset($errors['refs']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('refs', $row->refs ?? '')) ?></textarea>
                    <?php if (!empty($errors['refs'])): ?>
                        <div id="refs-error" class="invalid-feedback d-block">
                            <?= esc($errors['refs']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email_from" class="form-label">
                        <?= esc(lang('Emails.email_from')) ?>
                    </label>
                    <input
                        type="email"
                        name="email_from"
                        id="email_from"
                        value="<?= esc(old('email_from', $row->email_from ?? '')) ?>"
                        class="form-control <?= isset($errors['email_from']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email_from-error"
                        aria-invalid="<?= isset($errors['email_from']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['email_from'])): ?>
                        <div id="email_from-error" class="invalid-feedback d-block">
                            <?= esc($errors['email_from']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="thread_id" class="form-label">
                        <?= esc(lang('Emails.thread_id')) ?>
                    </label>
                    <input
                        type="text"
                        name="thread_id"
                        id="thread_id"
                        value="<?= esc(old('thread_id', $row->thread_id ?? '')) ?>"
                        class="form-control <?= isset($errors['thread_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="thread_id-error"
                        aria-invalid="<?= isset($errors['thread_id']) ? 'true' : 'false' ?>"
                        maxlength="100"
                    >
                    <?php if (!empty($errors['thread_id'])): ?>
                        <div id="thread_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['thread_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="thread_status" class="form-label">
                        <?= esc(lang('Emails.thread_status')) ?>
                    </label>
                    <input
                        type="text"
                        name="thread_status"
                        id="thread_status"
                        value="<?= esc(old('thread_status', $row->thread_status ?? '')) ?>"
                        class="form-control <?= isset($errors['thread_status']) ? 'is-invalid' : '' ?>"
                        aria-describedby="thread_status-error"
                        aria-invalid="<?= isset($errors['thread_status']) ? 'true' : 'false' ?>"
                        maxlength="6"
                    >
                    <?php if (!empty($errors['thread_status'])): ?>
                        <div id="thread_status-error" class="invalid-feedback d-block">
                            <?= esc($errors['thread_status']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="subject" class="form-label">
                        <?= esc(lang('Emails.subject')) ?>
                    </label>
                    <textarea
                        name="subject"
                        id="subject"
                        class="form-control <?= isset($errors['subject']) ? 'is-invalid' : '' ?>"
                        aria-describedby="subject-error"
                        aria-invalid="<?= isset($errors['subject']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('subject', $row->subject ?? '')) ?></textarea>
                    <?php if (!empty($errors['subject'])): ?>
                        <div id="subject-error" class="invalid-feedback d-block">
                            <?= esc($errors['subject']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="body" class="form-label">
                        <?= esc(lang('Emails.body')) ?>
                    </label>
                    <textarea
                        name="body"
                        id="body"
                        class="form-control <?= isset($errors['body']) ? 'is-invalid' : '' ?>"
                        aria-describedby="body-error"
                        aria-invalid="<?= isset($errors['body']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('body', $row->body ?? '')) ?></textarea>
                    <?php if (!empty($errors['body'])): ?>
                        <div id="body-error" class="invalid-feedback d-block">
                            <?= esc($errors['body']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="category" class="form-label">
                        <?= esc(lang('Emails.category')) ?>
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
                    <label for="language" class="form-label">
                        <?= esc(lang('Emails.language')) ?>
                    </label>
                    <input
                        type="text"
                        name="language"
                        id="language"
                        value="<?= esc(old('language', $row->language ?? '')) ?>"
                        class="form-control <?= isset($errors['language']) ? 'is-invalid' : '' ?>"
                        aria-describedby="language-error"
                        aria-invalid="<?= isset($errors['language']) ? 'true' : 'false' ?>"
                        maxlength="50"
                    >
                    <?php if (!empty($errors['language'])): ?>
                        <div id="language-error" class="invalid-feedback d-block">
                            <?= esc($errors['language']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="reply" class="form-label">
                        <?= esc(lang('Emails.reply')) ?>
                    </label>
                    <textarea
                        name="reply"
                        id="reply"
                        class="form-control <?= isset($errors['reply']) ? 'is-invalid' : '' ?>"
                        aria-describedby="reply-error"
                        aria-invalid="<?= isset($errors['reply']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('reply', $row->reply ?? '')) ?></textarea>
                    <?php if (!empty($errors['reply'])): ?>
                        <div id="reply-error" class="invalid-feedback d-block">
                            <?= esc($errors['reply']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="attachments" class="form-label">
                        <?= esc(lang('Emails.attachments')) ?>
                    </label>
                    <textarea
                        name="attachments"
                        id="attachments"
                        class="form-control <?= isset($errors['attachments']) ? 'is-invalid' : '' ?>"
                        aria-describedby="attachments-error"
                        aria-invalid="<?= isset($errors['attachments']) ? 'true' : 'false' ?>"
                        maxlength="65535"
                    ><?= esc(old('attachments', $row->attachments ?? '')) ?></textarea>
                    <?php if (!empty($errors['attachments'])): ?>
                        <div id="attachments-error" class="invalid-feedback d-block">
                            <?= esc($errors['attachments']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="replied" class="form-label">
                        <?= esc(lang('Emails.replied')) ?>
                    </label>
                    <input type="hidden" name="replied" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="replied"
                            id="replied"
                            value="1"
                            class="form-check-input <?= isset($errors['replied']) ? 'is-invalid' : '' ?>"
                            <?= old('replied', $row->replied ?? '') ? 'checked' : '' ?>
                        aria-describedby="replied-error"
                        aria-invalid="<?= isset($errors['replied']) ? 'true' : 'false' ?>"
                        >
                    </div>
                    <?php if (!empty($errors['replied'])): ?>
                        <div id="replied-error" class="invalid-feedback d-block">
                            <?= esc($errors['replied']) ?>
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

                    <a href="<?= site_url('emails') ?>" class="btn btn-secondary">
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
