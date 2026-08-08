<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th class="w-25"><?= esc(lang('Colori.colore_nome')) ?></th>
                            <td><?= esc($row->colore_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Colori.colore_codice')) ?></th>
                            <td><?= esc($row->colore_codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Colori.col_preno_id')) ?></th>
                            <td><a href="<?= site_url('agenda/view/' . rawurlencode((string) ($row->col_preno_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenda__col_preno_id__label ?? $row->col_preno_id ?? '') ?></a></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('colori') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
