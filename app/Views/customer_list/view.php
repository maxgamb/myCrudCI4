<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #crud-print-area,
    #crud-print-area * {
        visibility: visible !important;
    }

    #crud-print-area {
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
    }

    #crud-print-area .d-print-none {
        display: none !important;
    }

    #crud-print-area .card {
        box-shadow: none !important;
        break-inside: avoid;
    }
}
</style>

<div class="container py-4">
    <div class="d-flex justify-content-end mb-3 d-print-none">
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i> Stampa
        </button>
    </div>

    <div id="crud-print-area">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped align-middle">
                        <tbody>
                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.ID')) ?></th>
                            <td><?= esc($row->{'ID'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.name')) ?></th>
                            <td><?= esc($row->{'name'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.address')) ?></th>
                            <td><?= esc($row->{'address'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.zip code')) ?></th>
                            <td><?= esc($row->{'zip code'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.phone')) ?></th>
                            <td><?= esc($row->{'phone'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.city')) ?></th>
                            <td><?= esc($row->{'city'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.country')) ?></th>
                            <td><?= esc($row->{'country'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.notes')) ?></th>
                            <td><?= esc($row->{'notes'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CustomerList.SID')) ?></th>
                            <td><?= esc($row->{'SID'} ?? '') ?></td>
                        </tr>                        </tbody>
                    </table>
                </div>
                <a href="<?= site_url('customer_list') ?>" class="btn btn-secondary d-print-none">
                    <i class="bi bi-arrow-left"></i> Torna alla lista
                </a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
