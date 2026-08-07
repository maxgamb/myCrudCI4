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
                            <th class="w-25"><?= esc(lang('Prezzi.prezzo_id')) ?></th>
                            <td><?= esc($row->prezzo_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.prezzo_dal')) ?></th>
                            <td><?= esc($row->prezzo_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.prezzo_al')) ?></th>
                            <td><?= esc($row->prezzo_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.prezzo_valore')) ?></th>
                            <td><?= esc($row->prezzo_valore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.libero')) ?></th>
                            <td><?= esc($row->libero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prezzi.prezzi_utente_id')) ?></th>
                            <td><?= esc($row->prezzi_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('prezzi') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
