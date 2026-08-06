<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">tipologia_camera</h1>
            <small class="text-muted">Elenco e gestione record</small>
        </div>
        <div class="btn-group">
            <a href="<?= site_url('tipologia_camera/create') ?>" class="btn btn-primary">
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
                            <th><?= esc(lang('Fields.tipologia_id')) ?></th>
                            <th><?= esc(lang('Fields.nome_tipologia')) ?></th>
                            <th><?= esc(lang('Fields.nome_tipologia_en')) ?></th>
                            <th><?= esc(lang('Fields.nome_tipologia_fr')) ?></th>
                            <th><?= esc(lang('Fields.nome_tipologia_de')) ?></th>
                            <th><?= esc(lang('Fields.nome_tipologia_sp')) ?></th>
                            <th><?= esc(lang('Fields.nome_tipologia_jp')) ?></th>
                            <th><?= esc(lang('Fields.tipologia_sigla')) ?></th>
                            <th><?= esc(lang('Fields.numero_pax')) ?></th>
                            <th><?= esc(lang('Fields.tipologia_camera_data_record')) ?></th>
                            <th><?= esc(lang('Fields.tipologia_camera_utente_id')) ?></th>
                            <th><?= esc(lang('Fields.perc_prezzo')) ?></th>
                            <th>Azioni</th>
                        </tr>
                        <tr class="filters">
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.tipologia_id')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nome_tipologia')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nome_tipologia_en')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nome_tipologia_fr')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nome_tipologia_de')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nome_tipologia_sp')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.nome_tipologia_jp')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.tipologia_sigla')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.numero_pax')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.tipologia_camera_data_record')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.tipologia_camera_utente_id')) ?>"
                                >
                            </th>                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . lang('Fields.perc_prezzo')) ?>"
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
            url: "<?= site_url('tipologia_camera/datatable') ?>",
            type: 'POST',
            data: function (data) {
                data['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
            }
        },
        columns: [
            {
                data: 'tipologia_id',
                name: 'tipologia_id',
                defaultContent: ''
            },            {
                data: 'nome_tipologia',
                name: 'nome_tipologia',
                defaultContent: ''
            },            {
                data: 'nome_tipologia_en',
                name: 'nome_tipologia_en',
                defaultContent: ''
            },            {
                data: 'nome_tipologia_fr',
                name: 'nome_tipologia_fr',
                defaultContent: ''
            },            {
                data: 'nome_tipologia_de',
                name: 'nome_tipologia_de',
                defaultContent: ''
            },            {
                data: 'nome_tipologia_sp',
                name: 'nome_tipologia_sp',
                defaultContent: ''
            },            {
                data: 'nome_tipologia_jp',
                name: 'nome_tipologia_jp',
                defaultContent: ''
            },            {
                data: 'tipologia_sigla',
                name: 'tipologia_sigla',
                defaultContent: ''
            },            {
                data: 'numero_pax',
                name: 'numero_pax',
                defaultContent: ''
            },            {
                data: 'tipologia_camera_data_record',
                name: 'tipologia_camera_data_record',
                defaultContent: ''
            },            {
                data: 'tipologia_camera_utente_id',
                name: 'tipologia_camera_utente_id',
                defaultContent: ''
            },            {
                data: 'perc_prezzo',
                name: 'perc_prezzo',
                defaultContent: ''
            },            {
                data: 'tipologia_id',
                name: 'tipologia_id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    const base = "<?= site_url('tipologia_camera') ?>";
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
            action: "<?= site_url('tipologia_camera/delete') ?>/" + $(this).data('id')
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
