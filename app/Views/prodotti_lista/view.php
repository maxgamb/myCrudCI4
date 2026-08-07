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
                            <th class="w-25"><?= esc(lang('ProdottiLista.prodotti_lista_id')) ?></th>
                            <td><?= esc($row->prodotti_lista_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_mone')) ?></th>
                            <td><?= esc($row->prod_lista_mone ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_descrixione')) ?></th>
                            <td><?= esc($row->prod_lista_descrixione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_allergenici')) ?></th>
                            <td><?= esc($row->prod_lista_allergenici ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_costo_unitario')) ?></th>
                            <td><?= esc($row->prod_lista_costo_unitario ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_img')) ?></th>
                            <td><?= esc($row->prod_lista_img ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_data')) ?></th>
                            <td><?= esc($row->prod_lista_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ProdottiLista.prod_lista_user_id')) ?></th>
                            <td><?= esc($row->prod_lista_user_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('prodotti_lista') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
