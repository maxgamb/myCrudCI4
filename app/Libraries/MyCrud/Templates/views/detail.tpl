<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
{{ROWS}}                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('{{TABLE}}') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

{{PANELS}}</div>

<?= $this->endSection() ?>
