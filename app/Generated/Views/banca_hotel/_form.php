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
                        <?= esc(lang('BancaHotel.hotel_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="hotel_id"
                        id="hotel_id"
                        value="<?= esc(old('hotel_id', $row->hotel_id ?? '')) ?>"
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
                    <label for="Banca_Nome_Societa" class="form-label">
                        <?= esc(lang('BancaHotel.Banca_Nome_Societa')) ?>
                    </label>
                    <input
                        type="text"
                        name="Banca_Nome_Societa"
                        id="Banca_Nome_Societa"
                        value="<?= esc(old('Banca_Nome_Societa', $row->Banca_Nome_Societa ?? '')) ?>"
                        class="form-control <?= isset($errors['Banca_Nome_Societa']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Banca_Nome_Societa-error"
                        aria-invalid="<?= isset($errors['Banca_Nome_Societa']) ? 'true' : 'false' ?>"
                        required maxlength="255"
                    >
                    <?php if (!empty($errors['Banca_Nome_Societa'])): ?>
                        <div id="Banca_Nome_Societa-error" class="invalid-feedback d-block">
                            <?= esc($errors['Banca_Nome_Societa']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Banca_Nome" class="form-label">
                        <?= esc(lang('BancaHotel.Banca_Nome')) ?>
                    </label>
                    <input
                        type="text"
                        name="Banca_Nome"
                        id="Banca_Nome"
                        value="<?= esc(old('Banca_Nome', $row->Banca_Nome ?? '')) ?>"
                        class="form-control <?= isset($errors['Banca_Nome']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Banca_Nome-error"
                        aria-invalid="<?= isset($errors['Banca_Nome']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['Banca_Nome'])): ?>
                        <div id="Banca_Nome-error" class="invalid-feedback d-block">
                            <?= esc($errors['Banca_Nome']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Banca_via" class="form-label">
                        <?= esc(lang('BancaHotel.Banca_via')) ?>
                    </label>
                    <input
                        type="text"
                        name="Banca_via"
                        id="Banca_via"
                        value="<?= esc(old('Banca_via', $row->Banca_via ?? '')) ?>"
                        class="form-control <?= isset($errors['Banca_via']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Banca_via-error"
                        aria-invalid="<?= isset($errors['Banca_via']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['Banca_via'])): ?>
                        <div id="Banca_via-error" class="invalid-feedback d-block">
                            <?= esc($errors['Banca_via']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Banca_citta" class="form-label">
                        <?= esc(lang('BancaHotel.Banca_citta')) ?>
                    </label>
                    <input
                        type="text"
                        name="Banca_citta"
                        id="Banca_citta"
                        value="<?= esc(old('Banca_citta', $row->Banca_citta ?? '')) ?>"
                        class="form-control <?= isset($errors['Banca_citta']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Banca_citta-error"
                        aria-invalid="<?= isset($errors['Banca_citta']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['Banca_citta'])): ?>
                        <div id="Banca_citta-error" class="invalid-feedback d-block">
                            <?= esc($errors['Banca_citta']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Intestazione" class="form-label">
                        <?= esc(lang('BancaHotel.Intestazione')) ?>
                    </label>
                    <input
                        type="text"
                        name="Intestazione"
                        id="Intestazione"
                        value="<?= esc(old('Intestazione', $row->Intestazione ?? '')) ?>"
                        class="form-control <?= isset($errors['Intestazione']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Intestazione-error"
                        aria-invalid="<?= isset($errors['Intestazione']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['Intestazione'])): ?>
                        <div id="Intestazione-error" class="invalid-feedback d-block">
                            <?= esc($errors['Intestazione']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="BBAN" class="form-label">
                        <?= esc(lang('BancaHotel.BBAN')) ?>
                    </label>
                    <input
                        type="text"
                        name="BBAN"
                        id="BBAN"
                        value="<?= esc(old('BBAN', $row->BBAN ?? '')) ?>"
                        class="form-control <?= isset($errors['BBAN']) ? 'is-invalid' : '' ?>"
                        aria-describedby="BBAN-error"
                        aria-invalid="<?= isset($errors['BBAN']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['BBAN'])): ?>
                        <div id="BBAN-error" class="invalid-feedback d-block">
                            <?= esc($errors['BBAN']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="CIN" class="form-label">
                        <?= esc(lang('BancaHotel.CIN')) ?>
                    </label>
                    <input
                        type="text"
                        name="CIN"
                        id="CIN"
                        value="<?= esc(old('CIN', $row->CIN ?? '')) ?>"
                        class="form-control <?= isset($errors['CIN']) ? 'is-invalid' : '' ?>"
                        aria-describedby="CIN-error"
                        aria-invalid="<?= isset($errors['CIN']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['CIN'])): ?>
                        <div id="CIN-error" class="invalid-feedback d-block">
                            <?= esc($errors['CIN']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="ABI" class="form-label">
                        <?= esc(lang('BancaHotel.ABI')) ?>
                    </label>
                    <input
                        type="text"
                        name="ABI"
                        id="ABI"
                        value="<?= esc(old('ABI', $row->ABI ?? '')) ?>"
                        class="form-control <?= isset($errors['ABI']) ? 'is-invalid' : '' ?>"
                        aria-describedby="ABI-error"
                        aria-invalid="<?= isset($errors['ABI']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['ABI'])): ?>
                        <div id="ABI-error" class="invalid-feedback d-block">
                            <?= esc($errors['ABI']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="CAB" class="form-label">
                        <?= esc(lang('BancaHotel.CAB')) ?>
                    </label>
                    <input
                        type="text"
                        name="CAB"
                        id="CAB"
                        value="<?= esc(old('CAB', $row->CAB ?? '')) ?>"
                        class="form-control <?= isset($errors['CAB']) ? 'is-invalid' : '' ?>"
                        aria-describedby="CAB-error"
                        aria-invalid="<?= isset($errors['CAB']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['CAB'])): ?>
                        <div id="CAB-error" class="invalid-feedback d-block">
                            <?= esc($errors['CAB']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Rapporto" class="form-label">
                        <?= esc(lang('BancaHotel.Rapporto')) ?>
                    </label>
                    <input
                        type="text"
                        name="Rapporto"
                        id="Rapporto"
                        value="<?= esc(old('Rapporto', $row->Rapporto ?? '')) ?>"
                        class="form-control <?= isset($errors['Rapporto']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Rapporto-error"
                        aria-invalid="<?= isset($errors['Rapporto']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['Rapporto'])): ?>
                        <div id="Rapporto-error" class="invalid-feedback d-block">
                            <?= esc($errors['Rapporto']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="IBAN" class="form-label">
                        <?= esc(lang('BancaHotel.IBAN')) ?>
                    </label>
                    <input
                        type="text"
                        name="IBAN"
                        id="IBAN"
                        value="<?= esc(old('IBAN', $row->IBAN ?? '')) ?>"
                        class="form-control <?= isset($errors['IBAN']) ? 'is-invalid' : '' ?>"
                        aria-describedby="IBAN-error"
                        aria-invalid="<?= isset($errors['IBAN']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['IBAN'])): ?>
                        <div id="IBAN-error" class="invalid-feedback d-block">
                            <?= esc($errors['IBAN']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="Filiale" class="form-label">
                        <?= esc(lang('BancaHotel.Filiale')) ?>
                    </label>
                    <input
                        type="text"
                        name="Filiale"
                        id="Filiale"
                        value="<?= esc(old('Filiale', $row->Filiale ?? '')) ?>"
                        class="form-control <?= isset($errors['Filiale']) ? 'is-invalid' : '' ?>"
                        aria-describedby="Filiale-error"
                        aria-invalid="<?= isset($errors['Filiale']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['Filiale'])): ?>
                        <div id="Filiale-error" class="invalid-feedback d-block">
                            <?= esc($errors['Filiale']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="SWIFT" class="form-label">
                        <?= esc(lang('BancaHotel.SWIFT')) ?>
                    </label>
                    <input
                        type="text"
                        name="SWIFT"
                        id="SWIFT"
                        value="<?= esc(old('SWIFT', $row->SWIFT ?? '')) ?>"
                        class="form-control <?= isset($errors['SWIFT']) ? 'is-invalid' : '' ?>"
                        aria-describedby="SWIFT-error"
                        aria-invalid="<?= isset($errors['SWIFT']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['SWIFT'])): ?>
                        <div id="SWIFT-error" class="invalid-feedback d-block">
                            <?= esc($errors['SWIFT']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="SWIFT_SEDE" class="form-label">
                        <?= esc(lang('BancaHotel.SWIFT_SEDE')) ?>
                    </label>
                    <input
                        type="text"
                        name="SWIFT_SEDE"
                        id="SWIFT_SEDE"
                        value="<?= esc(old('SWIFT_SEDE', $row->SWIFT_SEDE ?? '')) ?>"
                        class="form-control <?= isset($errors['SWIFT_SEDE']) ? 'is-invalid' : '' ?>"
                        aria-describedby="SWIFT_SEDE-error"
                        aria-invalid="<?= isset($errors['SWIFT_SEDE']) ? 'true' : 'false' ?>"
                        maxlength="255"
                    >
                    <?php if (!empty($errors['SWIFT_SEDE'])): ?>
                        <div id="SWIFT_SEDE-error" class="invalid-feedback d-block">
                            <?= esc($errors['SWIFT_SEDE']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="banca_utente_id" class="form-label">
                        <?= esc(lang('BancaHotel.banca_utente_id')) ?>
                    </label>
                    <input
                        type="number"
                        name="banca_utente_id"
                        id="banca_utente_id"
                        value="<?= esc(old('banca_utente_id', $row->banca_utente_id ?? '')) ?>"
                        class="form-control <?= isset($errors['banca_utente_id']) ? 'is-invalid' : '' ?>"
                        aria-describedby="banca_utente_id-error"
                        aria-invalid="<?= isset($errors['banca_utente_id']) ? 'true' : 'false' ?>"
                    >
                    <?php if (!empty($errors['banca_utente_id'])): ?>
                        <div id="banca_utente_id-error" class="invalid-feedback d-block">
                            <?= esc($errors['banca_utente_id']) ?>
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

                    <a href="<?= site_url('banca_hotel') ?>" class="btn btn-secondary">
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
