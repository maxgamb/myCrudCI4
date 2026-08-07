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
                        <?= esc(lang('ChecklistPreno.hotel_id')) ?>
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
                    <label for="preno_id" class="form-label">
                        <?= esc(lang('ChecklistPreno.preno_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="preno_id"
                        id="preno_id"
                        value="<?= esc(old('preno_id', $row->preno_id ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_id-error"
                        aria-invalid="<?= isset($errors['preno_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['preno_id'])): ?>
                        <div id="preno_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_id']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="preno_dal" class="form-label">
                        <?= esc(lang('ChecklistPreno.preno_dal')) ?>
                    </label>
                    <input
                        type="date"
                        name="preno_dal"
                        id="preno_dal"
                        value="<?= esc(old('preno_dal', $row->preno_dal ?? '')) ?>"
                        class="form-control <?= isset($errors['preno_dal']) ? 'is-invalid' : '' ?>"
                        aria-describedby="preno_dal-error"
                        aria-invalid="<?= isset($errors['preno_dal']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['preno_dal'])): ?>
                        <div id="preno_dal-error" class="invalid-feedback d-block">
                            <?= esc($errors['preno_dal']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <?= esc(lang('ChecklistPreno.email')) ?>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="<?= esc(old('email', $row->email ?? '')) ?>"
                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email-error"
                        aria-invalid="<?= isset($errors['email']) ? 'true' : 'false' ?>"
                        required maxlength="200"
                    >
                    <?php if (!empty($errors['email'])): ?>
                        <div id="email-error" class="invalid-feedback d-block">
                            <?= esc($errors['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="email_pms" class="form-label">
                        <?= esc(lang('ChecklistPreno.email_pms')) ?>
                    </label>
                    <input
                        type="email"
                        name="email_pms"
                        id="email_pms"
                        value="<?= esc(old('email_pms', $row->email_pms ?? '')) ?>"
                        class="form-control <?= isset($errors['email_pms']) ? 'is-invalid' : '' ?>"
                        aria-describedby="email_pms-error"
                        aria-invalid="<?= isset($errors['email_pms']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['email_pms'])): ?>
                        <div id="email_pms-error" class="invalid-feedback d-block">
                            <?= esc($errors['email_pms']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="lista" class="form-label">
                        <?= esc(lang('ChecklistPreno.lista')) ?>
                    </label>
                    <input
                        type="number"
                        name="lista"
                        id="lista"
                        value="<?= esc(old('lista', $row->lista ?? '')) ?>"
                        class="form-control <?= isset($errors['lista']) ? 'is-invalid' : '' ?>"
                        aria-describedby="lista-error"
                        aria-invalid="<?= isset($errors['lista']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['lista'])): ?>
                        <div id="lista-error" class="invalid-feedback d-block">
                            <?= esc($errors['lista']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="lista_pms" class="form-label">
                        <?= esc(lang('ChecklistPreno.lista_pms')) ?>
                    </label>
                    <input
                        type="number"
                        name="lista_pms"
                        id="lista_pms"
                        value="<?= esc(old('lista_pms', $row->lista_pms ?? '')) ?>"
                        class="form-control <?= isset($errors['lista_pms']) ? 'is-invalid' : '' ?>"
                        aria-describedby="lista_pms-error"
                        aria-invalid="<?= isset($errors['lista_pms']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['lista_pms'])): ?>
                        <div id="lista_pms-error" class="invalid-feedback d-block">
                            <?= esc($errors['lista_pms']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="pagamento" class="form-label">
                        <?= esc(lang('ChecklistPreno.pagamento')) ?>
                    </label>
                    <input
                        type="number"
                        name="pagamento"
                        id="pagamento"
                        value="<?= esc(old('pagamento', $row->pagamento ?? '')) ?>"
                        class="form-control <?= isset($errors['pagamento']) ? 'is-invalid' : '' ?>"
                        aria-describedby="pagamento-error"
                        aria-invalid="<?= isset($errors['pagamento']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['pagamento'])): ?>
                        <div id="pagamento-error" class="invalid-feedback d-block">
                            <?= esc($errors['pagamento']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="tassa" class="form-label">
                        <?= esc(lang('ChecklistPreno.tassa')) ?>
                    </label>
                    <input
                        type="number"
                        name="tassa"
                        id="tassa"
                        value="<?= esc(old('tassa', $row->tassa ?? '')) ?>"
                        class="form-control <?= isset($errors['tassa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="tassa-error"
                        aria-invalid="<?= isset($errors['tassa']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['tassa'])): ?>
                        <div id="tassa-error" class="invalid-feedback d-block">
                            <?= esc($errors['tassa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="proforma" class="form-label">
                        <?= esc(lang('ChecklistPreno.proforma')) ?>
                    </label>
                    <input
                        type="number"
                        name="proforma"
                        id="proforma"
                        value="<?= esc(old('proforma', $row->proforma ?? '')) ?>"
                        class="form-control <?= isset($errors['proforma']) ? 'is-invalid' : '' ?>"
                        aria-describedby="proforma-error"
                        aria-invalid="<?= isset($errors['proforma']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['proforma'])): ?>
                        <div id="proforma-error" class="invalid-feedback d-block">
                            <?= esc($errors['proforma']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="proforma_pms" class="form-label">
                        <?= esc(lang('ChecklistPreno.proforma_pms')) ?>
                    </label>
                    <input
                        type="number"
                        name="proforma_pms"
                        id="proforma_pms"
                        value="<?= esc(old('proforma_pms', $row->proforma_pms ?? '')) ?>"
                        class="form-control <?= isset($errors['proforma_pms']) ? 'is-invalid' : '' ?>"
                        aria-describedby="proforma_pms-error"
                        aria-invalid="<?= isset($errors['proforma_pms']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['proforma_pms'])): ?>
                        <div id="proforma_pms-error" class="invalid-feedback d-block">
                            <?= esc($errors['proforma_pms']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="bonifico" class="form-label">
                        <?= esc(lang('ChecklistPreno.bonifico')) ?>
                    </label>
                    <input
                        type="number"
                        name="bonifico"
                        id="bonifico"
                        value="<?= esc(old('bonifico', $row->bonifico ?? '')) ?>"
                        class="form-control <?= isset($errors['bonifico']) ? 'is-invalid' : '' ?>"
                        aria-describedby="bonifico-error"
                        aria-invalid="<?= isset($errors['bonifico']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['bonifico'])): ?>
                        <div id="bonifico-error" class="invalid-feedback d-block">
                            <?= esc($errors['bonifico']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="importo" class="form-label">
                        <?= esc(lang('ChecklistPreno.importo')) ?>
                    </label>
                    <input
                        type="number"
                        name="importo"
                        id="importo"
                        value="<?= esc(old('importo', $row->importo ?? '')) ?>"
                        class="form-control <?= isset($errors['importo']) ? 'is-invalid' : '' ?>"
                        aria-describedby="importo-error"
                        aria-invalid="<?= isset($errors['importo']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['importo'])): ?>
                        <div id="importo-error" class="invalid-feedback d-block">
                            <?= esc($errors['importo']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-label">
                        <?= esc(lang('ChecklistPreno.note')) ?>
                    </label>
                    <input
                        type="text"
                        name="note"
                        id="note"
                        value="<?= esc(old('note', $row->note ?? '')) ?>"
                        class="form-control <?= isset($errors['note']) ? 'is-invalid' : '' ?>"
                        aria-describedby="note-error"
                        aria-invalid="<?= isset($errors['note']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['note'])): ?>
                        <div id="note-error" class="invalid-feedback d-block">
                            <?= esc($errors['note']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="data_check" class="form-label">
                        <?= esc(lang('ChecklistPreno.data_check')) ?>
                    </label>
                    <input
                        type="date"
                        name="data_check"
                        id="data_check"
                        value="<?= esc(old('data_check', $row->data_check ?? '')) ?>"
                        class="form-control <?= isset($errors['data_check']) ? 'is-invalid' : '' ?>"
                        aria-describedby="data_check-error"
                        aria-invalid="<?= isset($errors['data_check']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['data_check'])): ?>
                        <div id="data_check-error" class="invalid-feedback d-block">
                            <?= esc($errors['data_check']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="utente_id" class="form-label">
                        <?= esc(lang('ChecklistPreno.utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="utente_id"
                        id="utente_id"
                        value="<?= esc(old('utente_id', $row->utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="utente_id-error"
                        aria-invalid="<?= isset($errors['utente_id']) ? 'true' : 'false' ?>"
                        required
                    >
                    <?php if (!empty($errors['utente_id'])): ?>
                        <div id="utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['utente_id']) ?>
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

                    <a href="<?= site_url('checklist_preno') ?>" class="btn btn-secondary">
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
