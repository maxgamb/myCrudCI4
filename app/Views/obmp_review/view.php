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
                            <th class="w-25"><?= esc(lang('ObmpReview.review_id')) ?></th>
                            <td><?= esc($row->review_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.conto_id')) ?></th>
                            <td><a href="<?= site_url('conti/view/' . rawurlencode((string) ($row->conto_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->conti__conto_id__label ?? $row->conto_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.postazione_id')) ?></th>
                            <td><?= esc($row->postazione_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.camera_numero')) ?></th>
                            <td><?= esc($row->camera_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.nome')) ?></th>
                            <td><?= esc($row->nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.stato')) ?></th>
                            <td><?= esc($row->stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.user_type')) ?></th>
                            <td><?= esc($row->user_type ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.pulizia_camera')) ?></th>
                            <td><?= esc($row->pulizia_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.accoglienza')) ?></th>
                            <td><?= esc($row->accoglienza ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.rumore_camere')) ?></th>
                            <td><?= esc($row->rumore_camere ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.spazio_camera')) ?></th>
                            <td><?= esc($row->spazio_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.spazi_comuni')) ?></th>
                            <td><?= esc($row->spazi_comuni ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.competenza_impiegati')) ?></th>
                            <td><?= esc($row->competenza_impiegati ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.qualita_servizi')) ?></th>
                            <td><?= esc($row->qualita_servizi ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.dintorni')) ?></th>
                            <td><?= esc($row->dintorni ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.colazione')) ?></th>
                            <td><?= esc($row->colazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.tariffa')) ?></th>
                            <td><?= esc($row->tariffa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.servizi_offerti')) ?></th>
                            <td><?= esc($row->servizi_offerti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.foto')) ?></th>
                            <td><?= esc($row->foto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.indicazione_mappa')) ?></th>
                            <td><?= esc($row->indicazione_mappa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.giudizio_totale')) ?></th>
                            <td><?= esc($row->giudizio_totale ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.prezzo_qualita')) ?></th>
                            <td><?= esc($row->prezzo_qualita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.commento_tex')) ?></th>
                            <td><?= esc($row->commento_tex ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.risposta')) ?></th>
                            <td><?= esc($row->risposta ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.raccomandi')) ?></th>
                            <td><?= esc($row->raccomandi ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.ip_review')) ?></th>
                            <td><?= esc($row->ip_review ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpReview.data_review')) ?></th>
                            <td><?= esc($row->data_review ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_review') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
