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
                            <th class="w-25"><?= esc(lang('RefObmpBooking.ref_obm_data')) ?></th>
                            <td><?= esc($row->ref_obm_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.preno_id')) ?></th>
                            <td><a href="<?= site_url('agenda/view/' . rawurlencode((string) ($row->preno_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenda__preno_id__label ?? $row->preno_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.obm_cliente_id')) ?></th>
                            <td><a href="<?= site_url('obmp_clienti/view/' . rawurlencode((string) ($row->obm_cliente_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_clienti__obm_cliente_id__label ?? $row->obm_cliente_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.ref_site')) ?></th>
                            <td><a href="<?= site_url('obmp_ref_site/view/' . rawurlencode((string) ($row->ref_site ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_ref_site__ref_site__label ?? $row->ref_site ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.ref_agency')) ?></th>
                            <td><?= esc($row->ref_agency ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.ref_event')) ?></th>
                            <td><?= esc($row->ref_event ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.ref_session')) ?></th>
                            <td><?= esc($row->ref_session ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.ref_cookie')) ?></th>
                            <td><?= esc($row->ref_cookie ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.room_obmp_string')) ?></th>
                            <td><?= esc($row->room_obmp_string ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefObmpBooking.quote_id')) ?></th>
                            <td><a href="<?= site_url('obmp_quote/view/' . rawurlencode((string) ($row->quote_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_quote__quote_id__label ?? $row->quote_id ?? '') ?></a></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ref_obmp_booking') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
