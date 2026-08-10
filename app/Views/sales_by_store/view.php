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
                            <th class="w-25"><?= esc(lang('SalesByStore.store')) ?></th>
                            <td><?= esc($row->{'store'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('SalesByStore.manager')) ?></th>
                            <td><?= esc($row->{'manager'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('SalesByStore.total_sales')) ?></th>
                            <td><?= esc($row->{'total_sales'} ?? '') ?></td>
                        </tr>                        </tbody>
                    </table>
                </div>
                <a href="<?= site_url('sales_by_store') ?>" class="btn btn-secondary d-print-none">
                    <i class="bi bi-arrow-left"></i> Torna alla lista
                </a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
