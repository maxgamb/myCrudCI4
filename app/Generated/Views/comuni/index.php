<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">comuni</h1>
            <small class="text-muted">Elenco e gestione record</small>
        </div>
        <div class="btn-group">
            <a href="<?= site_url('comuni/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuovo
            </a>
        </div>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= esc(session('message')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= esc(session('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="crudTable" class="table table-striped table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th><?= esc(lang('Fields.Comuni_Codice')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_Nome')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_Prov')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_CAP')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_Prefisso')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_ColExcel')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_Nazione')) ?></th>
                            <th><?= esc(lang('Fields.Comuni_Lingua')) ?></th>
                            <th><?= esc(lang('Fields.nazione_iso2')) ?></th>
                            <th><?= esc(lang('Fields.nazione_iso3')) ?></th>
                            <th>Azioni</th>
                        </tr>
                        <tr class="filters">
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_Codice')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_Nome')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_Prov')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_CAP')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_Prefisso')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_ColExcel')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_Nazione')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Comuni_Lingua')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nazione_iso2')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nazione_iso3')) ?>"
                                >
                            </th>                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {
    $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        searchDelay: 350,
        ajax: {
            url: "<?= site_url('comuni/datatable') ?>",
            type: 'POST',
            data: function (data) {
                data['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
            }
        },
        columns: [
            {
                data: 'Comuni_Codice',
                name: 'Comuni_Codice',
                defaultContent: ''
            },            {
                data: 'Comuni_Nome',
                name: 'Comuni_Nome',
                defaultContent: ''
            },            {
                data: 'Comuni_Prov',
                name: 'Comuni_Prov',
                defaultContent: ''
            },            {
                data: 'Comuni_CAP',
                name: 'Comuni_CAP',
                defaultContent: ''
            },            {
                data: 'Comuni_Prefisso',
                name: 'Comuni_Prefisso',
                defaultContent: ''
            },            {
                data: 'Comuni_ColExcel',
                name: 'Comuni_ColExcel',
                defaultContent: ''
            },            {
                data: 'Comuni_Nazione',
                name: 'Comuni_Nazione',
                defaultContent: ''
            },            {
                data: 'Comuni_Lingua',
                name: 'Comuni_Lingua',
                defaultContent: ''
            },            {
                data: 'nazione_iso2',
                name: 'nazione_iso2',
                defaultContent: ''
            },            {
                data: 'nazione_iso3',
                name: 'nazione_iso3',
                defaultContent: ''
            },            {
                data: 'Comuni_Codice',
                name: 'Comuni_Codice',
                orderable: false,
                searchable: false,
                render: function (id) {
                    const base = "<?= site_url('comuni') ?>";
                    return `<div class="btn-group btn-group-sm">
                        <a href="${base}/view/${id}" class="btn btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="${base}/edit/${id}" class="btn btn-outline-warning"><i class="bi bi-pencil-square"></i></a>
                        <button type="button" class="btn btn-outline-danger delete-record" data-id="${id}"><i class="bi bi-trash"></i></button>
                    </div>`;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/it-IT.json'
        }
    });

    $(document).on('click', '.delete-record', function () {
        if (!confirm('Eliminare questo record?')) return;

        const form = $('<form>', {
            method: 'POST',
            action: "<?= site_url('comuni/delete') ?>/" + $(this).data('id')
        });

        form.append($('<input>', {
            type: 'hidden',
            name: '<?= csrf_token() ?>',
            value: '<?= csrf_hash() ?>'
        }));

        $('body').append(form);
        form.trigger('submit');
    });
});
</script>

<?= $this->endSection() ?>
