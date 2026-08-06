<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="mb-4">
        <h1 class="h2">myCrudGpt</h1>
        <p class="text-muted mb-0">
            Generazione automatica o personalizzata di moduli CodeIgniter 4.
        </p>
    </div>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Tabelle disponibili</strong>
        </div>

        <div class="list-group list-group-flush">
            <?php foreach ($tables as $table): ?>
                <div class="list-group-item d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span>
                        <i class="bi bi-table"></i>
                        <strong><?= esc($table) ?></strong>
                    </span>

                    <div class="btn-group">
                        <a href="<?= site_url('mycrud/auto/' . $table) ?>"
                           class="btn btn-success btn-sm">
                            <i class="bi bi-lightning-charge"></i>
                            Automatico
                        </a>

                        <a href="<?= site_url('mycrud/builder/configure/' . $table) ?>"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-sliders"></i>
                            Personalizza
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
