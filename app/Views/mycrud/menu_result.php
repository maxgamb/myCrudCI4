<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h1 class="h4 mb-0"><i class="bi bi-check-circle"></i> Menu generato</h1>
        </div>
        <div class="card-body">
            <p>I file sono stati creati nello staging sicuro:</p>
            <pre class="bg-dark text-light p-3 rounded"><?= esc(print_r($files, true)) ?></pre>

            <div class="alert alert-warning">
                Dopo la verifica sposta manualmente i file nelle rispettive cartelle di <code>app/</code>.
                Nel layout applicativo inserisci una sola volta:
                <code>&lt;?= view('layouts/_menu') ?&gt;</code>
            </div>

            <p class="mb-3">
                Il renderer predefinito è <strong><?= esc($type) ?></strong>.
                Puoi cambiarlo in seguito modificando <code>Config\Menu::$type</code> senza rigenerare le voci.
            </p>

            <a href="<?= site_url('mycrud/tools/menu') ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Torna al Menu Builder
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
