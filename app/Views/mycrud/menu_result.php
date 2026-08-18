<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h1 class="h4 mb-0"><i class="bi bi-check-circle"></i> Menu generated</h1>
        </div>
        <div class="card-body">
            <p>The files were created in safe staging:</p>
            <pre class="bg-dark text-light p-3 rounded"><?= esc(print_r($files, true)) ?></pre>

            <div class="alert alert-warning">
                Dopo la verifica sposta manualmente i file nelle rispettive cartelle di <code>app/</code>.
                Nel layout applicativo inserisci una sola volta:
                <code>&lt;?= view('layouts/_menu') ?&gt;</code>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <strong><i class="bi bi-layout-sidebar"></i> Vertical</strong>
                        <div class="small text-body-secondary mt-1">Accordion groups, subgroups, search, favorites, and current item.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <strong><i class="bi bi-menu-button-wide"></i> Horizontal</strong>
                        <div class="small text-body-secondary mt-1">Bootstrap dropdown, subgroups, favorites, and dedicated search.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded p-3 h-100">
                        <strong><i class="bi bi-gear"></i> Single configuration</strong>
                        <div class="small text-body-secondary mt-1"><code>Config/Menu.php</code> alimenta entrambi i renderer.</div>
                    </div>
                </div>
            </div>

            <p class="mb-3">
                Il renderer predefinito è <strong><?= esc($type) ?></strong>.
                You can change it later by editing <code>Config\Menu::$type</code> without regenerating the items.
            </p>

            <a href="<?= site_url('mycrud/tools/menu') ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Back to Menu Builder
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
