<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-lightning-charge-fill"></i>
                Quick globale
            </h1>
            <p class="text-muted mb-0">
                Seleziona architettura e tabelle, poi genera o simula l'operazione.
            </p>
        </div>
        <span class="badge text-bg-primary fs-6"><?= count($tables) ?> tabelle disponibili</span>
    </div>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?= form_open('mycrud/quick/generate', ['id' => 'quickGenerationForm']) ?>
        <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header"><strong>Architettura</strong></div>
                    <div class="card-body">
                        <?php foreach ([
                            'basic' => 'Controller + Model',
                            'standard' => 'Controller + Service + Model + Entity',
                            'full' => 'Web + API + Service + Model + Entity',
                        ] as $value => $description): ?>
                            <div class="form-check border rounded p-3 mb-3">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="architecture"
                                    value="<?= esc($value) ?>"
                                    id="architecture_<?= esc($value) ?>"
                                    <?= old('architecture', 'standard') === $value ? 'checked' : '' ?>
                                >
                                <label class="form-check-label w-100" for="architecture_<?= esc($value) ?>">
                                    <strong><?= esc(ucfirst($value)) ?></strong>
                                    <span class="d-block small text-muted"><?= esc($description) ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header"><strong>Modalità</strong></div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="dry_run" value="1" id="dryRun" <?= old('dry_run') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="dryRun">
                                Simula senza scrivere file
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="force" value="1" id="forceOverwrite" <?= old('force') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="forceOverwrite">
                                Sovrascrivi file esistenti
                            </label>
                        </div>

                        <div class="alert alert-warning small mt-3 mb-0 d-none" id="forceWarning">
                            La sovrascrittura può eliminare modifiche manuali nei file generati.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <strong><i class="bi bi-database"></i> Tabelle</strong>
                        <span class="badge text-bg-secondary" id="selectedCount">0 selezionate</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-md-7">
                                <input type="search" class="form-control" id="tableSearch" placeholder="Cerca tabella...">
                            </div>
                            <div class="col-md-5 d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary flex-fill" id="selectAll">Tutte</button>
                                <button type="button" class="btn btn-outline-secondary flex-fill" id="selectNone">Nessuna</button>
                            </div>
                        </div>

                        <div class="row g-2" id="tableGrid">
                            <?php foreach ($tables as $table): ?>
                                <div class="col-12 col-md-6 col-xl-4 table-item" data-table="<?= esc(strtolower($table)) ?>">
                                    <label class="border rounded p-2 d-flex align-items-center gap-2 h-100">
                                        <input
                                            class="form-check-input table-checkbox mt-0"
                                            type="checkbox"
                                            name="tables[]"
                                            value="<?= esc($table) ?>"
                                            <?= in_array($table, (array) old('tables', $tables), true) ? 'checked' : '' ?>
                                        >
                                        <span class="text-truncate"><i class="bi bi-table"></i> <?= esc($table) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div id="generationSummary" class="text-muted"></div>
                        <button type="submit" class="btn btn-danger btn-lg" id="generateAllButton">
                            <span class="button-normal"><i class="bi bi-lightning-charge-fill"></i> Avvia</span>
                            <span class="button-loading d-none"><span class="spinner-border spinner-border-sm"></span> Elaborazione...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?= form_close() ?>
</div>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('quickGenerationForm');
    const tableSearch = document.getElementById('tableSearch');
    const tableItems = [...document.querySelectorAll('.table-item')];
    const checkboxes = [...document.querySelectorAll('.table-checkbox')];
    const selectedCount = document.getElementById('selectedCount');
    const summary = document.getElementById('generationSummary');
    const force = document.getElementById('forceOverwrite');
    const dryRun = document.getElementById('dryRun');
    const forceWarning = document.getElementById('forceWarning');
    const button = document.getElementById('generateAllButton');

    const updateSummary = () => {
        const selected = checkboxes.filter(item => item.checked).length;
        const architecture = document.querySelector('input[name="architecture"]:checked')?.value ?? 'standard';
        selectedCount.textContent = `${selected} selezionate`;
        summary.textContent = `Architettura: ${architecture} · Tabelle: ${selected} · Modalità: ${dryRun.checked ? 'simulazione' : 'scrittura'}`;
        forceWarning.classList.toggle('d-none', !force.checked || dryRun.checked);
    };

    tableSearch.addEventListener('input', () => {
        const query = tableSearch.value.trim().toLowerCase();
        tableItems.forEach(item => item.classList.toggle('d-none', !item.dataset.table.includes(query)));
    });

    document.getElementById('selectAll').addEventListener('click', () => {
        tableItems.filter(item => !item.classList.contains('d-none'))
            .forEach(item => item.querySelector('.table-checkbox').checked = true);
        updateSummary();
    });

    document.getElementById('selectNone').addEventListener('click', () => {
        tableItems.filter(item => !item.classList.contains('d-none'))
            .forEach(item => item.querySelector('.table-checkbox').checked = false);
        updateSummary();
    });

    [...checkboxes, force, dryRun, ...document.querySelectorAll('input[name="architecture"]')]
        .forEach(input => input.addEventListener('change', updateSummary));

    form.addEventListener('submit', event => {
        const selected = checkboxes.filter(item => item.checked).length;
        if (selected === 0) {
            event.preventDefault();
            alert('Seleziona almeno una tabella.');
            return;
        }

        let message = dryRun.checked
            ? `Simulare la generazione di ${selected} tabelle?`
            : `Generare ${selected} tabelle?`;

        if (force.checked && !dryRun.checked) {
            message += '\n\nATTENZIONE: i file esistenti saranno sovrascritti.';
        }

        if (!confirm(message)) {
            event.preventDefault();
            return;
        }

        button.disabled = true;
        button.querySelector('.button-normal')?.classList.add('d-none');
        button.querySelector('.button-loading')?.classList.remove('d-none');
    });

    updateSummary();
});
</script>
<?= $this->endSection() ?>
