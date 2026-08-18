<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<?php
$tables = array_values((array) ($tables ?? []));
$result = is_array($result ?? null) ? $result : null;
$error = trim((string) ($error ?? ''));
?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-robot me-1"></i>
                Project AI context
            </h1>
            <p class="text-muted mb-0">
                Generates a structured map of the CI4 project so an AI agent understands architecture, CRUDs, fields, and relations before modifying code.
            </p>
        </div>
        <span class="badge text-bg-dark fs-6">myCrudCI4 <?= esc((string) ($version ?? '')) ?></span>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-1"></i>
            <?= esc($error) ?>
        </div>
    <?php endif ?>

    <?php if ($result !== null): ?>
        <div class="alert alert-success">
            <div class="fw-semibold mb-2">
                <i class="bi bi-check-circle me-1"></i>
                Generated context
            </div>
            <ul class="mb-0">
                <?php foreach ((array) ($result['files'] ?? []) as $file): ?>
                    <?php
                    $relative = str_replace('\\', '/', (string) $file);
                    $root = rtrim(str_replace('\\', '/', ROOTPATH), '/');
                    if (str_starts_with($relative, $root . '/')) {
                        $relative = substr($relative, strlen($root) + 1);
                    }
                    ?>
                    <li><code><?= esc($relative) ?></code></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5">Generate context</h2>
                    <p class="text-muted">
                        The full context describes the entire project. Alternatively, regenerate only a single CRUD profile.
                    </p>

                    <form method="post" action="<?= site_url('mycrud/tools/ai-context/generate') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="aiContextTable" class="form-label">Ambito</label>
                            <select class="form-select" id="aiContextTable" name="table">
                                <option value="">Intero progetto</option>
                                <?php foreach ($tables as $table): ?>
                                    <option value="<?= esc((string) $table) ?>">
                                        Solo CRUD: <?= esc((string) $table) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-file-earmark-code me-1"></i>
                            Generate context IA
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5">File prodotti</h2>
                    <div class="font-monospace small bg-body-tertiary border rounded p-3 mb-3">
                        AI_PROJECT_CONTEXT.md<br>
                        docs/ai/project.json<br>
                        docs/ai/crud/agenda.md<br>
                        docs/ai/crud/clienti.md<br>
                        ...
                    </div>
                    <p class="small text-muted mb-0">
                        These files are project documentation, not runtime code. They do not contain database records, credentials, passwords, or values from the <code>.env</code> file.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h2 class="h5">Come usarlo con un agente IA</h2>
            <div class="bg-dark text-light rounded p-3 font-monospace small">
                Prima di modificare il progetto, leggi AI_PROJECT_CONTEXT.md.<br>
                Se lavori su un CRUD, leggi anche docs/ai/crud/&lt;table&gt;.md.<br>
                Follow the architecture, naming, and conventions described in these files.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
