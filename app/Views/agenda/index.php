<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">
                agenda
            </h1>

            <small class="text-muted">
                Elenco e gestione record
            </small>
        </div>

        <a
            href="<?= site_url('agenda/create') ?>"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-circle"></i>
            Nuovo
        </a>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= esc(session('message')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= esc(session('error')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table
                    id="crudTable"
                    class="table table-striped table-hover align-middle w-100"
                >
                    <thead>
                        <tr>
                            <th>
                                <?= esc('Preno Id') ?>
                            </th>
                            <th>
                                <?= esc('Hotel Id') ?>
                            </th>
                            <th>
                                <?= esc('Preno In Data') ?>
                            </th>
                            <th>
                                <?= esc('Preno Importo') ?>
                            </th>
                            <th>
                                <?= esc('Preno Impoto Mod') ?>
                            </th>
                            <th>
                                <?= esc('Preno Dal') ?>
                            </th>
                            <th>
                                <?= esc('Preno Al') ?>
                            </th>
                            <th>
                                <?= esc('Preno Nome') ?>
                            </th>
                            <th>
                                <?= esc('Preno Cogno') ?>
                            </th>
                            <th>
                                <?= esc('Preno N Notti') ?>
                            </th>
                            <th>
                                <?= esc('Preno Arr Ore') ?>
                            </th>
                            <th>
                                <?= esc('Preno Trattamento') ?>
                            </th>
                            <th>
                                <?= esc('T1') ?>
                            </th>
                            <th>
                                <?= esc('T2') ?>
                            </th>
                            <th>
                                <?= esc('T3') ?>
                            </th>
                            <th>
                                <?= esc('T4') ?>
                            </th>
                            <th>
                                <?= esc('T5') ?>
                            </th>
                            <th>
                                <?= esc('T6') ?>
                            </th>
                            <th>
                                <?= esc('Q1') ?>
                            </th>
                            <th>
                                <?= esc('Q2') ?>
                            </th>
                            <th>
                                <?= esc('Q3') ?>
                            </th>
                            <th>
                                <?= esc('Q4') ?>
                            </th>
                            <th>
                                <?= esc('Q5') ?>
                            </th>
                            <th>
                                <?= esc('Q6') ?>
                            </th>
                            <th>
                                <?= esc('P1') ?>
                            </th>
                            <th>
                                <?= esc('P2') ?>
                            </th>
                            <th>
                                <?= esc('P3') ?>
                            </th>
                            <th>
                                <?= esc('P4') ?>
                            </th>
                            <th>
                                <?= esc('P5') ?>
                            </th>
                            <th>
                                <?= esc('P6') ?>
                            </th>
                            <th>
                                <?= esc('Preno Agenzia') ?>
                            </th>
                            <th>
                                <?= esc('Voucher Id') ?>
                            </th>
                            <th>
                                <?= esc('Ota Voucher') ?>
                            </th>
                            <th>
                                <?= esc('Allotment Id') ?>
                            </th>
                            <th>
                                <?= esc('Preno Cc Tip') ?>
                            </th>
                            <th>
                                <?= esc('Preno Cc N') ?>
                            </th>
                            <th>
                                <?= esc('Preno Cc Scad') ?>
                            </th>
                            <th>
                                <?= esc('Preno Tel') ?>
                            </th>
                            <th>
                                <?= esc('Preno Fax') ?>
                            </th>
                            <th>
                                <?= esc('Preno Email') ?>
                            </th>
                            <th>
                                <?= esc('Preno Mercato') ?>
                            </th>
                            <th>
                                <?= esc('Nazione Iso2') ?>
                            </th>
                            <th>
                                <?= esc('Preno Note') ?>
                            </th>
                            <th>
                                <?= esc('Preno Doc Fax') ?>
                            </th>
                            <th>
                                <?= esc('Preno Doc Email') ?>
                            </th>
                            <th>
                                <?= esc('Preno Doc Form') ?>
                            </th>
                            <th>
                                <?= esc('Preno Doc Mail') ?>
                            </th>
                            <th>
                                <?= esc('Preno Doc Vaglia') ?>
                            </th>
                            <th>
                                <?= esc('Preno Doc Woucher') ?>
                            </th>
                            <th>
                                <?= esc('Preno Pag Modalita') ?>
                            </th>
                            <th>
                                <?= esc('Preno Caparra') ?>
                            </th>
                            <th>
                                <?= esc('Preno Stato') ?>
                            </th>
                            <th>
                                <?= esc('Data Opzione') ?>
                            </th>
                            <th>
                                <?= esc('Cancella Data Record') ?>
                            </th>
                            <th>
                                <?= esc('Cancella User') ?>
                            </th>
                            <th>
                                <?= esc('Cancella Pass') ?>
                            </th>
                            <th>
                                <?= esc('Preno Data Record') ?>
                            </th>
                            <th>
                                <?= esc('Agenda Utente Id') ?>
                            </th>

                            <th>Azioni</th>
                        </tr>

                        <tr class="filters">
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Id'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Hotel Id'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno In Data'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Importo'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Impoto Mod'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Dal'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Al'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Nome'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Cogno'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno N Notti'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Arr Ore'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Trattamento'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'T1'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'T2'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'T3'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'T4'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'T5'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'T6'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Q1'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Q2'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Q3'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Q4'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Q5'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Q6'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'P1'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'P2'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'P3'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'P4'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'P5'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'P6'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Agenzia'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Voucher Id'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Ota Voucher'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Allotment Id'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Cc Tip'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Cc N'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Cc Scad'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Tel'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Fax'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Email'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Mercato'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Nazione Iso2'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Note'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Doc Fax'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Doc Email'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Doc Form'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Doc Mail'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Doc Vaglia'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Doc Woucher'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Pag Modalita'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Caparra'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Stato'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Data Opzione'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Cancella Data Record'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Cancella User'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Cancella Pass'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Preno Data Record'
                                    ) ?>"
                                >
                            </th>
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . 'Agenda Utente Id'
                                    ) ?>"
                                >
                            </th>

                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
>

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css"
>

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css"
>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script>
$(function () {
    const table = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        stateSave: true,
        searchDelay: 350,
        order: [[0, 'asc']],

        ajax: {
            url: "<?= site_url('agenda/datatable') ?>",
            type: 'POST',

            data: function (data) {
                data['<?= csrf_token() ?>'] =
                    '<?= csrf_hash() ?>';
            }
        },

        dom: '<"d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"lfB>rtip',

        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="bi bi-clipboard"></i> Copia'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="bi bi-filetype-csv"></i> CSV'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel'
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Stampa'
            },
            {
                extend: 'colvis',
                text: '<i class="bi bi-layout-three-columns"></i> Colonne'
            }
        ],

        columns: [
            {
                data: 'preno_id',
                name: 'preno_id',
                defaultContent: ''
            },
            {
                data: 'hotel_id',
                name: 'hotel_id',
                defaultContent: ''
            },
            {
                data: 'preno_in_data',
                name: 'preno_in_data',
                defaultContent: ''
            },
            {
                data: 'preno_importo',
                name: 'preno_importo',
                defaultContent: ''
            },
            {
                data: 'preno_impoto_mod',
                name: 'preno_impoto_mod',
                defaultContent: ''
            },
            {
                data: 'preno_dal',
                name: 'preno_dal',
                defaultContent: ''
            },
            {
                data: 'preno_al',
                name: 'preno_al',
                defaultContent: ''
            },
            {
                data: 'preno_nome',
                name: 'preno_nome',
                defaultContent: ''
            },
            {
                data: 'preno_cogno',
                name: 'preno_cogno',
                defaultContent: ''
            },
            {
                data: 'preno_n_notti',
                name: 'preno_n_notti',
                defaultContent: ''
            },
            {
                data: 'preno_arr_ore',
                name: 'preno_arr_ore',
                defaultContent: ''
            },
            {
                data: 'preno_trattamento',
                name: 'preno_trattamento',
                defaultContent: ''
            },
            {
                data: 't1',
                name: 't1',
                defaultContent: ''
            },
            {
                data: 't2',
                name: 't2',
                defaultContent: ''
            },
            {
                data: 't3',
                name: 't3',
                defaultContent: ''
            },
            {
                data: 't4',
                name: 't4',
                defaultContent: ''
            },
            {
                data: 't5',
                name: 't5',
                defaultContent: ''
            },
            {
                data: 't6',
                name: 't6',
                defaultContent: ''
            },
            {
                data: 'q1',
                name: 'q1',
                defaultContent: ''
            },
            {
                data: 'q2',
                name: 'q2',
                defaultContent: ''
            },
            {
                data: 'q3',
                name: 'q3',
                defaultContent: ''
            },
            {
                data: 'q4',
                name: 'q4',
                defaultContent: ''
            },
            {
                data: 'q5',
                name: 'q5',
                defaultContent: ''
            },
            {
                data: 'q6',
                name: 'q6',
                defaultContent: ''
            },
            {
                data: 'p1',
                name: 'p1',
                defaultContent: ''
            },
            {
                data: 'p2',
                name: 'p2',
                defaultContent: ''
            },
            {
                data: 'p3',
                name: 'p3',
                defaultContent: ''
            },
            {
                data: 'p4',
                name: 'p4',
                defaultContent: ''
            },
            {
                data: 'p5',
                name: 'p5',
                defaultContent: ''
            },
            {
                data: 'p6',
                name: 'p6',
                defaultContent: ''
            },
            {
                data: 'preno_agenzia',
                name: 'preno_agenzia',
                defaultContent: ''
            },
            {
                data: 'voucher_id',
                name: 'voucher_id',
                defaultContent: ''
            },
            {
                data: 'ota_voucher',
                name: 'ota_voucher',
                defaultContent: ''
            },
            {
                data: 'allotment_id',
                name: 'allotment_id',
                defaultContent: ''
            },
            {
                data: 'preno_cc_tip',
                name: 'preno_cc_tip',
                defaultContent: ''
            },
            {
                data: 'preno_cc_n',
                name: 'preno_cc_n',
                defaultContent: ''
            },
            {
                data: 'preno_cc_scad',
                name: 'preno_cc_scad',
                defaultContent: ''
            },
            {
                data: 'preno_tel',
                name: 'preno_tel',
                defaultContent: ''
            },
            {
                data: 'preno_fax',
                name: 'preno_fax',
                defaultContent: ''
            },
            {
                data: 'preno_email',
                name: 'preno_email',
                defaultContent: ''
            },
            {
                data: 'preno_mercato',
                name: 'preno_mercato',
                defaultContent: ''
            },
            {
                data: 'nazione_iso2',
                name: 'nazione_iso2',
                defaultContent: ''
            },
            {
                data: 'preno_note',
                name: 'preno_note',
                defaultContent: ''
            },
            {
                data: 'preno_doc_fax',
                name: 'preno_doc_fax',
                defaultContent: ''
            },
            {
                data: 'preno_doc_email',
                name: 'preno_doc_email',
                defaultContent: ''
            },
            {
                data: 'preno_doc_form',
                name: 'preno_doc_form',
                defaultContent: ''
            },
            {
                data: 'preno_doc_mail',
                name: 'preno_doc_mail',
                defaultContent: ''
            },
            {
                data: 'preno_doc_vaglia',
                name: 'preno_doc_vaglia',
                defaultContent: ''
            },
            {
                data: 'preno_doc_woucher',
                name: 'preno_doc_woucher',
                defaultContent: ''
            },
            {
                data: 'preno_pag_modalita',
                name: 'preno_pag_modalita',
                defaultContent: ''
            },
            {
                data: 'preno_caparra',
                name: 'preno_caparra',
                defaultContent: ''
            },
            {
                data: 'preno_stato',
                name: 'preno_stato',
                defaultContent: ''
            },
            {
                data: 'data_opzione',
                name: 'data_opzione',
                defaultContent: ''
            },
            {
                data: 'cancella_data_record',
                name: 'cancella_data_record',
                defaultContent: ''
            },
            {
                data: 'cancella_user',
                name: 'cancella_user',
                defaultContent: ''
            },
            {
                data: 'cancella_pass',
                name: 'cancella_pass',
                defaultContent: ''
            },
            {
                data: 'preno_data_record',
                name: 'preno_data_record',
                defaultContent: ''
            },
            {
                data: 'agenda_utente_id',
                name: 'agenda_utente_id',
                defaultContent: ''
            },

            {
                data: 'preno_id',
                name: 'preno_id',
                orderable: false,
                searchable: false,

                render: function (id) {
                    const base =
                        "<?= site_url('agenda') ?>";

                    return `
                        <div class="btn-group btn-group-sm">

                            <a
                                href="${base}/view/${id}"
                                class="btn btn-outline-info"
                                title="Visualizza"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                            <a
                                href="${base}/edit/${id}"
                                class="btn btn-outline-warning"
                                title="Modifica"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <button
                                type="button"
                                class="btn btn-outline-danger delete-record"
                                data-id="${id}"
                                title="Elimina"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>
                    `;
                }
            }
        ],

        initComplete: function () {
            const api = this.api();

            api.columns().every(function (index) {
                if (
                    index ===
                    api.columns().count() - 1
                ) {
                    return;
                }

                const column = this;

                const input = $(
                    '#crudTable thead tr.filters th'
                )
                    .eq(index)
                    .find('input');

                input.on(
                    'keyup change clear',
                    function () {
                        if (
                            column.search() !==
                            this.value
                        ) {
                            column
                                .search(this.value)
                                .draw();
                        }
                    }
                );
            });
        },

        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/it-IT.json'
        }
    });

    $(document).on(
        'click',
        '.delete-record',
        function () {
            if (
                !confirm(
                    'Eliminare questo record?'
                )
            ) {
                return;
            }

            const form = $('<form>', {
                method: 'POST',
                action:
                    "<?= site_url('agenda/delete') ?>/"
                    + $(this).data('id')
            });

            form.append(
                $('<input>', {
                    type: 'hidden',
                    name: '<?= csrf_token() ?>',
                    value: '<?= csrf_hash() ?>'
                })
            );

            $('body').append(form);

            form.trigger('submit');
        }
    );
});
</script>

<?= $this->endSection() ?>