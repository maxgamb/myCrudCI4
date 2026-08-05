<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th style="width: 30%">Preno Id</th>
                        <td><?= esc($row->preno_id ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Hotel Id</th>
                        <td><?= esc($row->hotel_id ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno In Data</th>
                        <td><?= esc($row->preno_in_data ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Importo</th>
                        <td><?= esc($row->preno_importo ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Impoto Mod</th>
                        <td><?= esc($row->preno_impoto_mod ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Dal</th>
                        <td><?= esc($row->preno_dal ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Al</th>
                        <td><?= esc($row->preno_al ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Nome</th>
                        <td><?= esc($row->preno_nome ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Cogno</th>
                        <td><?= esc($row->preno_cogno ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno N Notti</th>
                        <td><?= esc($row->preno_n_notti ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Arr Ore</th>
                        <td><?= esc($row->preno_arr_ore ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Trattamento</th>
                        <td><?= esc($row->preno_trattamento ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">T1</th>
                        <td><?= esc($row->t1 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">T2</th>
                        <td><?= esc($row->t2 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">T3</th>
                        <td><?= esc($row->t3 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">T4</th>
                        <td><?= esc($row->t4 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">T5</th>
                        <td><?= esc($row->t5 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">T6</th>
                        <td><?= esc($row->t6 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Q1</th>
                        <td><?= esc($row->q1 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Q2</th>
                        <td><?= esc($row->q2 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Q3</th>
                        <td><?= esc($row->q3 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Q4</th>
                        <td><?= esc($row->q4 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Q5</th>
                        <td><?= esc($row->q5 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Q6</th>
                        <td><?= esc($row->q6 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">P1</th>
                        <td><?= esc($row->p1 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">P2</th>
                        <td><?= esc($row->p2 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">P3</th>
                        <td><?= esc($row->p3 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">P4</th>
                        <td><?= esc($row->p4 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">P5</th>
                        <td><?= esc($row->p5 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">P6</th>
                        <td><?= esc($row->p6 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Agenzia</th>
                        <td><?= esc($row->preno_agenzia ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Voucher Id</th>
                        <td><?= esc($row->voucher_id ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Ota Voucher</th>
                        <td><?= esc($row->ota_voucher ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Allotment Id</th>
                        <td><?= esc($row->allotment_id ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Cc Tip</th>
                        <td><?= esc($row->preno_cc_tip ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Cc N</th>
                        <td><?= esc($row->preno_cc_n ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Cc Scad</th>
                        <td><?= esc($row->preno_cc_scad ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Tel</th>
                        <td><?= esc($row->preno_tel ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Fax</th>
                        <td><?= esc($row->preno_fax ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Email</th>
                        <td><?= esc($row->preno_email ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Mercato</th>
                        <td><?= esc($row->preno_mercato ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Nazione Iso2</th>
                        <td><?= esc($row->nazione_iso2 ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Note</th>
                        <td><?= esc($row->preno_note ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Doc Fax</th>
                        <td><?= esc($row->preno_doc_fax ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Doc Email</th>
                        <td><?= esc($row->preno_doc_email ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Doc Form</th>
                        <td><?= esc($row->preno_doc_form ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Doc Mail</th>
                        <td><?= esc($row->preno_doc_mail ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Doc Vaglia</th>
                        <td><?= esc($row->preno_doc_vaglia ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Doc Woucher</th>
                        <td><?= esc($row->preno_doc_woucher ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Pag Modalita</th>
                        <td><?= esc($row->preno_pag_modalita ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Caparra</th>
                        <td><?= esc($row->preno_caparra ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Stato</th>
                        <td><?= esc($row->preno_stato ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Data Opzione</th>
                        <td><?= esc($row->data_opzione ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Cancella Data Record</th>
                        <td><?= esc($row->cancella_data_record ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Cancella User</th>
                        <td><?= esc($row->cancella_user ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Cancella Pass</th>
                        <td><?= esc($row->cancella_pass ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Preno Data Record</th>
                        <td><?= esc($row->preno_data_record ?? '') ?></td>
                    </tr>
                    <tr>
                        <th style="width: 30%">Agenda Utente Id</th>
                        <td><?= esc($row->agenda_utente_id ?? '') ?></td>
                    </tr>
                </tbody>
            </table>

            <a href="<?= site_url('agenda') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>