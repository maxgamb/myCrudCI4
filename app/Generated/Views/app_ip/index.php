<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">app_ip</h1>
            <small class="text-muted">Elenco e gestione record</small>
        </div>
        <div class="btn-group">
            <a href="<?= site_url('app_ip/create') ?>" class="btn btn-primary">
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
                            <th><?= esc(lang('Fields.app_ip_id')) ?></th>
                            <th><?= esc(lang('Fields.ip_aderss')) ?></th>
                            <th><?= esc(lang('Fields.Livello')) ?></th>
                            <th><?= esc(lang('Fields.data')) ?></th>
                            <th>Azioni</th>
                        </tr>
                        <tr class="filters">
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.app_ip_id')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.ip_aderss')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.Livello')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.data')) ?>"
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
            url: "<?= site_url('app_ip/datatable') ?>",
            type: 'POST',
            data: function (data) {
                data['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
            }
        },
        columns: [
            {
                data: 'app_ip_id',
                name: 'app_ip_id',
                defaultContent: ''
            },            {
                data: 'ip_aderss',
                name: 'ip_aderss',
                defaultContent: ''
            },            {
                data: 'Livello',
                name: 'Livello',
                defaultContent: ''
            },            {
                data: 'data',
                name: 'data',
                defaultContent: ''
            },            {
                data: 'app_ip_id',
                name: 'app_ip_id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    const base = "<?= site_url('app_ip') ?>";
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
            action: "<?= site_url('app_ip/delete') ?>/" + $(this).data('id')
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
