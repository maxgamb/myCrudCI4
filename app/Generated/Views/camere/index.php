<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">camere</h1>
            <small class="text-muted">Elenco e gestione record</small>
        </div>
        <div class="btn-group">
            <a href="<?= site_url('camere/create') ?>" class="btn btn-primary">
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
                            <th><?= esc(lang('Fields.camera_id')) ?></th>
                            <th><?= esc(lang('Fields.hotel_id')) ?></th>
                            <th><?= esc(lang('Fields.numero_camera')) ?></th>
                            <th><?= esc(lang('Fields.tipologia_camera')) ?></th>
                            <th><?= esc(lang('Fields.tipologia_id')) ?></th>
                            <th><?= esc(lang('Fields.camere_max_pax')) ?></th>
                            <th><?= esc(lang('Fields.camere_metri_quadri')) ?></th>
                            <th><?= esc(lang('Fields.camere_vista')) ?></th>
                            <th><?= esc(lang('Fields.camere_piano')) ?></th>
                            <th><?= esc(lang('Fields.camere_bagno')) ?></th>
                            <th><?= esc(lang('Fields.camere_edificio')) ?></th>
                            <th><?= esc(lang('Fields.review_tot')) ?></th>
                            <th><?= esc(lang('Fields.camere_data_record')) ?></th>
                            <th><?= esc(lang('Fields.camere_utente_id')) ?></th>
                            <th>Azioni</th>
                        </tr>
                        <tr class="filters">
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camera_id')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.hotel_id')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.numero_camera')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.tipologia_camera')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.tipologia_id')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_max_pax')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_metri_quadri')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_vista')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_piano')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_bagno')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_edificio')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.review_tot')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_data_record')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.camere_utente_id')) ?>"
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
            url: "<?= site_url('camere/datatable') ?>",
            type: 'POST',
            data: function (data) {
                data['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
            }
        },
        columns: [
            {
                data: 'camera_id',
                name: 'camera_id',
                defaultContent: ''
            },            {
                data: 'hotel_id',
                name: 'hotel_id',
                defaultContent: ''
            },            {
                data: 'numero_camera',
                name: 'numero_camera',
                defaultContent: ''
            },            {
                data: 'tipologia_camera',
                name: 'tipologia_camera',
                defaultContent: ''
            },            {
                data: 'tipologia_id',
                name: 'tipologia_id',
                defaultContent: ''
            },            {
                data: 'camere_max_pax',
                name: 'camere_max_pax',
                defaultContent: ''
            },            {
                data: 'camere_metri_quadri',
                name: 'camere_metri_quadri',
                defaultContent: ''
            },            {
                data: 'camere_vista',
                name: 'camere_vista',
                defaultContent: ''
            },            {
                data: 'camere_piano',
                name: 'camere_piano',
                defaultContent: ''
            },            {
                data: 'camere_bagno',
                name: 'camere_bagno',
                defaultContent: ''
            },            {
                data: 'camere_edificio',
                name: 'camere_edificio',
                defaultContent: ''
            },            {
                data: 'review_tot',
                name: 'review_tot',
                defaultContent: ''
            },            {
                data: 'camere_data_record',
                name: 'camere_data_record',
                defaultContent: ''
            },            {
                data: 'camere_utente_id',
                name: 'camere_utente_id',
                defaultContent: ''
            },            {
                data: 'camera_id',
                name: 'camera_id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    const base = "<?= site_url('camere') ?>";
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
            action: "<?= site_url('camere/delete') ?>/" + $(this).data('id')
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
