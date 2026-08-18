<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="mb-4">
        <h1 class="h2">myCrudCI4</h1>
        <p class="text-muted mb-0">
            Configure CodeIgniter 4 CRUDs from the current database schema.
        </p>
    </div>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Available database objects</strong>
        </div>

        <div class="list-group list-group-flush">
            <?php foreach ($tables as $table): ?>
                <?php $objectType = strtoupper((string) (($objectTypes[$table] ?? 'BASE TABLE'))); ?>
                <div class="list-group-item d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span>
                        <i class="bi <?= $objectType === 'VIEW' ? 'bi-eye' : 'bi-table' ?>"></i>
                        <strong><?= esc($table) ?></strong>
                        <?php if ($objectType === 'VIEW'): ?>
                            <span class="badge text-bg-info ms-2">VIEW SQL</span>
                            <span class="badge text-bg-secondary">Read only</span>
                        <?php endif; ?>
                    </span>

                    <div class="btn-group">
<a href="<?= site_url('mycrud/builder/configure/' . $table) ?>"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-sliders"></i>
                            Configure
                        </a>

                        <a href="<?= site_url('mycrud/schema/' . $table) ?>"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-diagram-3"></i>
                            Schema
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
