<form id="crudFiltersForm" method="get" action="<?= site_url('agenda') ?>">
    <input type="hidden" name="sort" value="<?= esc($sort ?? 'preno_id') ?>">
    <input type="hidden" name="direction" value="<?= esc($direction ?? 'desc') ?>">

    <div class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
            <label for="filter_preno_id" class="form-label"><?= esc(lang('Agenda.preno_id')) ?></label>
            <input type="number" id="filter_preno_id" name="filter[preno_id]" value="<?= esc((string) ($filters['preno_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_hotel_id" class="form-label"><?= esc(lang('Agenda.hotel_id')) ?></label>
            <input type="number" id="filter_hotel_id" name="filter[hotel_id]" value="<?= esc((string) ($filters['hotel_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('Agenda.preno_in_data')) ?></label>
            <div class="input-group">
                <input type="datetime-local" name="filter[preno_in_data][from]" value="<?= esc((string) ($filters['preno_in_data']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="datetime-local" name="filter[preno_in_data][to]" value="<?= esc((string) ($filters['preno_in_data']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_importo" class="form-label"><?= esc(lang('Agenda.preno_importo')) ?></label>
            <input type="number" step="any" id="filter_preno_importo" name="filter[preno_importo]" value="<?= esc((string) ($filters['preno_importo'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_impoto_mod" class="form-label"><?= esc(lang('Agenda.preno_impoto_mod')) ?></label>
            <input type="number" step="any" id="filter_preno_impoto_mod" name="filter[preno_impoto_mod]" value="<?= esc((string) ($filters['preno_impoto_mod'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('Agenda.preno_dal')) ?></label>
            <div class="input-group">
                <input type="date" name="filter[preno_dal][from]" value="<?= esc((string) ($filters['preno_dal']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="date" name="filter[preno_dal][to]" value="<?= esc((string) ($filters['preno_dal']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('Agenda.preno_al')) ?></label>
            <div class="input-group">
                <input type="date" name="filter[preno_al][from]" value="<?= esc((string) ($filters['preno_al']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="date" name="filter[preno_al][to]" value="<?= esc((string) ($filters['preno_al']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_n_notti" class="form-label"><?= esc(lang('Agenda.preno_n_notti')) ?></label>
            <input type="number" id="filter_preno_n_notti" name="filter[preno_n_notti]" value="<?= esc((string) ($filters['preno_n_notti'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_arr_ore" class="form-label"><?= esc(lang('Agenda.preno_arr_ore')) ?></label>
            <input type="search" id="filter_preno_arr_ore" name="filter[preno_arr_ore]" value="<?= esc((string) ($filters['preno_arr_ore'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_trattamento" class="form-label"><?= esc(lang('Agenda.preno_trattamento')) ?></label>
            <input type="search" id="filter_preno_trattamento" name="filter[preno_trattamento]" value="<?= esc((string) ($filters['preno_trattamento'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_t1" class="form-label"><?= esc(lang('Agenda.t1')) ?></label>
            <input type="number" id="filter_t1" name="filter[t1]" value="<?= esc((string) ($filters['t1'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_q1" class="form-label"><?= esc(lang('Agenda.q1')) ?></label>
            <input type="number" id="filter_q1" name="filter[q1]" value="<?= esc((string) ($filters['q1'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_p1" class="form-label"><?= esc(lang('Agenda.p1')) ?></label>
            <input type="number" step="any" id="filter_p1" name="filter[p1]" value="<?= esc((string) ($filters['p1'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_t2" class="form-label"><?= esc(lang('Agenda.t2')) ?></label>
            <input type="number" id="filter_t2" name="filter[t2]" value="<?= esc((string) ($filters['t2'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_q2" class="form-label"><?= esc(lang('Agenda.q2')) ?></label>
            <input type="number" id="filter_q2" name="filter[q2]" value="<?= esc((string) ($filters['q2'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_p2" class="form-label"><?= esc(lang('Agenda.p2')) ?></label>
            <input type="number" step="any" id="filter_p2" name="filter[p2]" value="<?= esc((string) ($filters['p2'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_t3" class="form-label"><?= esc(lang('Agenda.t3')) ?></label>
            <input type="number" id="filter_t3" name="filter[t3]" value="<?= esc((string) ($filters['t3'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_q3" class="form-label"><?= esc(lang('Agenda.q3')) ?></label>
            <input type="number" id="filter_q3" name="filter[q3]" value="<?= esc((string) ($filters['q3'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_p3" class="form-label"><?= esc(lang('Agenda.p3')) ?></label>
            <input type="number" step="any" id="filter_p3" name="filter[p3]" value="<?= esc((string) ($filters['p3'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_t4" class="form-label"><?= esc(lang('Agenda.t4')) ?></label>
            <input type="number" id="filter_t4" name="filter[t4]" value="<?= esc((string) ($filters['t4'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_q4" class="form-label"><?= esc(lang('Agenda.q4')) ?></label>
            <input type="number" id="filter_q4" name="filter[q4]" value="<?= esc((string) ($filters['q4'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_p4" class="form-label"><?= esc(lang('Agenda.p4')) ?></label>
            <input type="number" step="any" id="filter_p4" name="filter[p4]" value="<?= esc((string) ($filters['p4'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_t5" class="form-label"><?= esc(lang('Agenda.t5')) ?></label>
            <input type="number" id="filter_t5" name="filter[t5]" value="<?= esc((string) ($filters['t5'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_q5" class="form-label"><?= esc(lang('Agenda.q5')) ?></label>
            <input type="number" id="filter_q5" name="filter[q5]" value="<?= esc((string) ($filters['q5'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_p5" class="form-label"><?= esc(lang('Agenda.p5')) ?></label>
            <input type="number" step="any" id="filter_p5" name="filter[p5]" value="<?= esc((string) ($filters['p5'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_t6" class="form-label"><?= esc(lang('Agenda.t6')) ?></label>
            <input type="number" id="filter_t6" name="filter[t6]" value="<?= esc((string) ($filters['t6'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_q6" class="form-label"><?= esc(lang('Agenda.q6')) ?></label>
            <input type="number" id="filter_q6" name="filter[q6]" value="<?= esc((string) ($filters['q6'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_p6" class="form-label"><?= esc(lang('Agenda.p6')) ?></label>
            <input type="number" step="any" id="filter_p6" name="filter[p6]" value="<?= esc((string) ($filters['p6'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_nome" class="form-label"><?= esc(lang('Agenda.preno_nome')) ?></label>
            <input type="search" id="filter_preno_nome" name="filter[preno_nome]" value="<?= esc((string) ($filters['preno_nome'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_cogno" class="form-label"><?= esc(lang('Agenda.preno_cogno')) ?></label>
            <input type="search" id="filter_preno_cogno" name="filter[preno_cogno]" value="<?= esc((string) ($filters['preno_cogno'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_agenzia" class="form-label"><?= esc(lang('Agenda.preno_agenzia')) ?></label>
            <select id="filter_preno_agenzia" name="filter[preno_agenzia]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) ($options['preno_agenzia'] ?? []) as $value => $optionLabel): ?>
                    <option value="<?= esc((string) $value) ?>" <?= (string) ($filters['preno_agenzia'] ?? '') === (string) $value ? 'selected' : '' ?>>
                        <?= esc((string) $optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_voucher_id" class="form-label"><?= esc(lang('Agenda.voucher_id')) ?></label>
            <input type="search" id="filter_voucher_id" name="filter[voucher_id]" value="<?= esc((string) ($filters['voucher_id'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_ota_voucher" class="form-label"><?= esc(lang('Agenda.ota_voucher')) ?></label>
            <input type="search" id="filter_ota_voucher" name="filter[ota_voucher]" value="<?= esc((string) ($filters['ota_voucher'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_allotment_id" class="form-label"><?= esc(lang('Agenda.allotment_id')) ?></label>
            <input type="number" id="filter_allotment_id" name="filter[allotment_id]" value="<?= esc((string) ($filters['allotment_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_cc_tip" class="form-label"><?= esc(lang('Agenda.preno_cc_tip')) ?></label>
            <input type="search" id="filter_preno_cc_tip" name="filter[preno_cc_tip]" value="<?= esc((string) ($filters['preno_cc_tip'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_cc_n" class="form-label"><?= esc(lang('Agenda.preno_cc_n')) ?></label>
            <input type="search" id="filter_preno_cc_n" name="filter[preno_cc_n]" value="<?= esc((string) ($filters['preno_cc_n'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_cc_scad" class="form-label"><?= esc(lang('Agenda.preno_cc_scad')) ?></label>
            <input type="search" id="filter_preno_cc_scad" name="filter[preno_cc_scad]" value="<?= esc((string) ($filters['preno_cc_scad'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_tel" class="form-label"><?= esc(lang('Agenda.preno_tel')) ?></label>
            <input type="search" id="filter_preno_tel" name="filter[preno_tel]" value="<?= esc((string) ($filters['preno_tel'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_fax" class="form-label"><?= esc(lang('Agenda.preno_fax')) ?></label>
            <input type="search" id="filter_preno_fax" name="filter[preno_fax]" value="<?= esc((string) ($filters['preno_fax'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_email" class="form-label"><?= esc(lang('Agenda.preno_email')) ?></label>
            <input type="search" id="filter_preno_email" name="filter[preno_email]" value="<?= esc((string) ($filters['preno_email'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_mercato" class="form-label"><?= esc(lang('Agenda.preno_mercato')) ?></label>
            <input type="search" id="filter_preno_mercato" name="filter[preno_mercato]" value="<?= esc((string) ($filters['preno_mercato'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_nazione_iso2" class="form-label"><?= esc(lang('Agenda.nazione_iso2')) ?></label>
            <input type="search" id="filter_nazione_iso2" name="filter[nazione_iso2]" value="<?= esc((string) ($filters['nazione_iso2'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-6 col-md-2">
            <label for="filter_preno_doc_fax" class="form-label"><?= esc(lang('Agenda.preno_doc_fax')) ?></label>
            <select id="filter_preno_doc_fax" name="filter[preno_doc_fax]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) ($filters['preno_doc_fax'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) ($filters['preno_doc_fax'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label for="filter_preno_doc_email" class="form-label"><?= esc(lang('Agenda.preno_doc_email')) ?></label>
            <select id="filter_preno_doc_email" name="filter[preno_doc_email]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) ($filters['preno_doc_email'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) ($filters['preno_doc_email'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label for="filter_preno_doc_form" class="form-label"><?= esc(lang('Agenda.preno_doc_form')) ?></label>
            <select id="filter_preno_doc_form" name="filter[preno_doc_form]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) ($filters['preno_doc_form'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) ($filters['preno_doc_form'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label for="filter_preno_doc_mail" class="form-label"><?= esc(lang('Agenda.preno_doc_mail')) ?></label>
            <select id="filter_preno_doc_mail" name="filter[preno_doc_mail]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) ($filters['preno_doc_mail'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) ($filters['preno_doc_mail'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label for="filter_preno_doc_vaglia" class="form-label"><?= esc(lang('Agenda.preno_doc_vaglia')) ?></label>
            <select id="filter_preno_doc_vaglia" name="filter[preno_doc_vaglia]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) ($filters['preno_doc_vaglia'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) ($filters['preno_doc_vaglia'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label for="filter_preno_doc_woucher" class="form-label"><?= esc(lang('Agenda.preno_doc_woucher')) ?></label>
            <select id="filter_preno_doc_woucher" name="filter[preno_doc_woucher]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) ($filters['preno_doc_woucher'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) ($filters['preno_doc_woucher'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_pag_modalita" class="form-label"><?= esc(lang('Agenda.preno_pag_modalita')) ?></label>
            <input type="number" id="filter_preno_pag_modalita" name="filter[preno_pag_modalita]" value="<?= esc((string) ($filters['preno_pag_modalita'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_caparra" class="form-label"><?= esc(lang('Agenda.preno_caparra')) ?></label>
            <input type="number" step="any" id="filter_preno_caparra" name="filter[preno_caparra]" value="<?= esc((string) ($filters['preno_caparra'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_stato" class="form-label"><?= esc(lang('Agenda.preno_stato')) ?></label>
            <input type="number" id="filter_preno_stato" name="filter[preno_stato]" value="<?= esc((string) ($filters['preno_stato'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('Agenda.data_opzione')) ?></label>
            <div class="input-group">
                <input type="date" name="filter[data_opzione][from]" value="<?= esc((string) ($filters['data_opzione']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="date" name="filter[data_opzione][to]" value="<?= esc((string) ($filters['data_opzione']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('Agenda.cancella_data_record')) ?></label>
            <div class="input-group">
                <input type="datetime-local" name="filter[cancella_data_record][from]" value="<?= esc((string) ($filters['cancella_data_record']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="datetime-local" name="filter[cancella_data_record][to]" value="<?= esc((string) ($filters['cancella_data_record']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-6 col-md-2">
            <label for="crudPerPage" class="form-label">Righe</label>
            <select id="crudPerPage" name="perPage" class="form-select">
                <?php foreach ([25, 50, 100] as $size): ?>
                    <option value="<?= $size ?>" <?= (int) ($perPage ?? 25) === $size ? 'selected' : '' ?>>
                        <?= $size ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-auto">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cerca
            </button>
            <a href="<?= site_url('agenda') ?>" class="btn btn-outline-secondary js-reset-filters">
                Azzera
            </a>
        </div>
    </div>
</form>
