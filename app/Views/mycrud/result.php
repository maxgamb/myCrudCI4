<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h1 class="h4 mb-0">
                <i class="bi bi-check-circle"></i>
                Generazione completata
            </h1>
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Tabella</dt>
                <dd class="col-sm-9"><?= esc($result['table']) ?></dd>

                <dt class="col-sm-3">Architettura</dt>
                <dd class="col-sm-9"><?= esc($result['architecture']) ?></dd>

                <dt class="col-sm-3">Sovrascrittura</dt>
                <dd class="col-sm-9"><?= $result['force'] ? 'Sì' : 'No' ?></dd>
            </dl>

            <h2 class="h5">File</h2>
            <pre class="bg-dark text-light p-3 rounded"><?= esc(print_r($result['files'], true)) ?></pre>

            <div class="alert alert-warning">
                I file si trovano in <code>app/Generated</code>.
                Dopo la verifica, spostali manualmente nelle rispettive cartelle di <code>app</code>
                e includi il file delle route generate.
            </div>

            <a href="<?= site_url('mycrud') ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Torna alle tabelle
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
