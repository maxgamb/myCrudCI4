<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">agenda</h1>
            <small class="text-muted">Elenco e gestione record</small>
        </div>
        <div class="btn-group">
            <a href="<?= site_url('agenda/create') ?>" class="btn btn-primary">
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
                            <th><?= esc(lang('Fields.preno_id')) ?></th>
                            <th><?= esc(lang('Fields.hotel_id')) ?></th>
                            <th><?= esc(lang('Fields.preno_in_data')) ?></th>
                            <th><?= esc(lang('Fields.preno_importo')) ?></th>
                            <th><?= esc(lang('Fields.preno_impoto_mod')) ?></th>
                            <th><?= esc(lang('Fields.preno_dal')) ?></th>
                            <th><?= esc(lang('Fields.preno_al')) ?></th>
                            <th><?= esc(lang('Fields.preno_nome')) ?></th>
                            <th><?= esc(lang('Fields.preno_cogno')) ?></th>
                            <th><?= esc(lang('Fields.preno_n_notti')) ?></th>
                            <th><?= esc(lang('Fields.preno_arr_ore')) ?></th>
                            <th><?= esc(lang('Fields.preno_trattamento')) ?></th>
                            <th><?= esc(lang('Fields.t1')) ?></th>
                            <th><?= esc(lang('Fields.t2')) ?></th>
                            <th><?= esc(lang('Fields.t3')) ?></th>
                            <th><?= esc(lang('Fields.t4')) ?></th>
                            <th><?= esc(lang('Fields.t5')) ?></th>
                            <th><?= esc(lang('Fields.t6')) ?></th>
                            <th><?= esc(lang('Fields.q1')) ?></th>
                            <th><?= esc(lang('Fields.q2')) ?></th>
                            <th><?= esc(lang('Fields.q3')) ?></th>
                            <th><?= esc(lang('Fields.q4')) ?></th>
                            <th><?= esc(lang('Fields.q5')) ?></th>
                            <th><?= esc(lang('Fields.q6')) ?></th>
                            <th><?= esc(lang('Fields.p1')) ?></th>
                            <th><?= esc(lang('Fields.p2')) ?></th>
                            <th><?= esc(lang('Fields.p3')) ?></th>
                            <th><?= esc(lang('Fields.p4')) ?></th>
                            <th><?= esc(lang('Fields.p5')) ?></th>
                            <th><?= esc(lang('Fields.p6')) ?></th>
                            <th><?= esc(lang('Fields.preno_agenzia')) ?></th>
                            <th><?= esc(lang('Fields.voucher_id')) ?></th>
                            <th><?= esc(lang('Fields.ota_voucher')) ?></th>
                            <th><?= esc(lang('Fields.allotment_id')) ?></th>
                            <th><?= esc(lang('Fields.preno_cc_tip')) ?></th>
                            <th><?= esc(lang('Fields.preno_cc_n')) ?></th>
                            <th><?= esc(lang('Fields.preno_cc_scad')) ?></th>
                            <th><?= esc(lang('Fields.preno_tel')) ?></th>
                            <th><?= esc(lang('Fields.preno_fax')) ?></th>
                            <th><?= esc(lang('Fields.preno_email')) ?></th>
                            <th><?= esc(lang('Fields.preno_mercato')) ?></th>
                            <th><?= esc(lang('Fields.nazione_iso2')) ?></th>
                            <th><?= esc(lang('Fields.preno_note')) ?></th>
                            <th><?= esc(lang('Fields.preno_doc_fax')) ?></th>
                            <th><?= esc(lang('Fields.preno_doc_email')) ?></th>
                            <th><?= esc(lang('Fields.preno_doc_form')) ?></th>
                            <th><?= esc(lang('Fields.preno_doc_mail')) ?></th>
                            <th><?= esc(lang('Fields.preno_doc_vaglia')) ?></th>
                            <th><?= esc(lang('Fields.preno_doc_woucher')) ?></th>
                            <th><?= esc(lang('Fields.preno_pag_modalita')) ?></th>
                            <th><?= esc(lang('Fields.preno_caparra')) ?></th>
                            <th><?= esc(lang('Fields.preno_stato')) ?></th>
                            <th><?= esc(lang('Fields.data_opzione')) ?></th>
                            <th><?= esc(lang('Fields.cancella_data_record')) ?></th>
                            <th><?= esc(lang('Fields.cancella_user')) ?></th>
                            <th><?= esc(lang('Fields.cancella_pass')) ?></th>
                            <th><?= esc(lang('Fields.preno_data_record')) ?></th>
                            <th><?= esc(lang('Fields.agenda_utente_id')) ?></th>
                            <th>Azioni</th>
                        </tr>
                        <tr class="filters">
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_id')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.hotel_id')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_in_data')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_importo')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_impoto_mod')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_dal')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_al')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_nome')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_cogno')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_n_notti')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_arr_ore')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_trattamento')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.t1')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.t2')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.t3')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.t4')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.t5')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.t6')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.q1')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.q2')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.q3')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.q4')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.q5')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.q6')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.p1')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.p2')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.p3')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.p4')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.p5')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.p6')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_agenzia')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.voucher_id')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.ota_voucher')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.allotment_id')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_cc_tip')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_cc_n')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_cc_scad')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_tel')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_fax')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_email')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_mercato')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.nazione_iso2')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_note')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_doc_fax')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_doc_email')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_doc_form')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_doc_mail')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_doc_vaglia')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_doc_woucher')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_pag_modalita')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_caparra')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_stato')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.data_opzione')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.cancella_data_record')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.cancella_user')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.cancella_pass')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.preno_data_record')) ?>"></th>
                            <th><input type="text" class="form-control form-control-sm" placeholder="<?= esc('Filtra ' . lang('Fields.agenda_utente_id')) ?>"></th>
                            <th></th>
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
            url: "<?= site_url('agenda/datatable') ?>",
            type: 'POST',
            data: function (data) {
                data['<?= csrf_token() ?>'] = '<?= csrf_hash() ?>';
            }
        },
        columns: [
            { data: 'preno_id', name: 'preno_id', defaultContent: '' },
            { data: 'hotel_id', name: 'hotel_id', defaultContent: '' },
            { data: 'preno_in_data', name: 'preno_in_data', defaultContent: '' },
            { data: 'preno_importo', name: 'preno_importo', defaultContent: '' },
            { data: 'preno_impoto_mod', name: 'preno_impoto_mod', defaultContent: '' },
            { data: 'preno_dal', name: 'preno_dal', defaultContent: '' },
            { data: 'preno_al', name: 'preno_al', defaultContent: '' },
            { data: 'preno_nome', name: 'preno_nome', defaultContent: '' },
            { data: 'preno_cogno', name: 'preno_cogno', defaultContent: '' },
            { data: 'preno_n_notti', name: 'preno_n_notti', defaultContent: '' },
            { data: 'preno_arr_ore', name: 'preno_arr_ore', defaultContent: '' },
            { data: 'preno_trattamento', name: 'preno_trattamento', defaultContent: '' },
            { data: 't1', name: 't1', defaultContent: '' },
            { data: 't2', name: 't2', defaultContent: '' },
            { data: 't3', name: 't3', defaultContent: '' },
            { data: 't4', name: 't4', defaultContent: '' },
            { data: 't5', name: 't5', defaultContent: '' },
            { data: 't6', name: 't6', defaultContent: '' },
            { data: 'q1', name: 'q1', defaultContent: '' },
            { data: 'q2', name: 'q2', defaultContent: '' },
            { data: 'q3', name: 'q3', defaultContent: '' },
            { data: 'q4', name: 'q4', defaultContent: '' },
            { data: 'q5', name: 'q5', defaultContent: '' },
            { data: 'q6', name: 'q6', defaultContent: '' },
            { data: 'p1', name: 'p1', defaultContent: '' },
            { data: 'p2', name: 'p2', defaultContent: '' },
            { data: 'p3', name: 'p3', defaultContent: '' },
            { data: 'p4', name: 'p4', defaultContent: '' },
            { data: 'p5', name: 'p5', defaultContent: '' },
            { data: 'p6', name: 'p6', defaultContent: '' },
            { data: 'preno_agenzia', name: 'preno_agenzia', defaultContent: '' },
            { data: 'voucher_id', name: 'voucher_id', defaultContent: '' },
            { data: 'ota_voucher', name: 'ota_voucher', defaultContent: '' },
            { data: 'allotment_id', name: 'allotment_id', defaultContent: '' },
            { data: 'preno_cc_tip', name: 'preno_cc_tip', defaultContent: '' },
            { data: 'preno_cc_n', name: 'preno_cc_n', defaultContent: '' },
            { data: 'preno_cc_scad', name: 'preno_cc_scad', defaultContent: '' },
            { data: 'preno_tel', name: 'preno_tel', defaultContent: '' },
            { data: 'preno_fax', name: 'preno_fax', defaultContent: '' },
            { data: 'preno_email', name: 'preno_email', defaultContent: '' },
            { data: 'preno_mercato', name: 'preno_mercato', defaultContent: '' },
            { data: 'nazione_iso2', name: 'nazione_iso2', defaultContent: '' },
            { data: 'preno_note', name: 'preno_note', defaultContent: '' },
            { data: 'preno_doc_fax', name: 'preno_doc_fax', defaultContent: '' },
            { data: 'preno_doc_email', name: 'preno_doc_email', defaultContent: '' },
            { data: 'preno_doc_form', name: 'preno_doc_form', defaultContent: '' },
            { data: 'preno_doc_mail', name: 'preno_doc_mail', defaultContent: '' },
            { data: 'preno_doc_vaglia', name: 'preno_doc_vaglia', defaultContent: '' },
            { data: 'preno_doc_woucher', name: 'preno_doc_woucher', defaultContent: '' },
            { data: 'preno_pag_modalita', name: 'preno_pag_modalita', defaultContent: '' },
            { data: 'preno_caparra', name: 'preno_caparra', defaultContent: '' },
            { data: 'preno_stato', name: 'preno_stato', defaultContent: '' },
            { data: 'data_opzione', name: 'data_opzione', defaultContent: '' },
            { data: 'cancella_data_record', name: 'cancella_data_record', defaultContent: '' },
            { data: 'cancella_user', name: 'cancella_user', defaultContent: '' },
            { data: 'cancella_pass', name: 'cancella_pass', defaultContent: '' },
            { data: 'preno_data_record', name: 'preno_data_record', defaultContent: '' },
            { data: 'agenda_utente_id', name: 'agenda_utente_id', defaultContent: '' },
            {
                data: 'preno_id',
                name: 'preno_id',
                orderable: false,
                searchable: false,
                render: function (id) {
                    const base = "<?= site_url('agenda') ?>";
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
            action: "<?= site_url('agenda/delete') ?>/" + $(this).data('id')
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
