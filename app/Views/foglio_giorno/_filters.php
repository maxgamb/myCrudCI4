<form id="crudFiltersForm" method="get" action="<?= site_url('foglio_giorno') ?>">
    <input type="hidden" name="sort" value="<?= esc($sort ?? 'foglio_id') ?>">
    <input type="hidden" name="direction" value="<?= esc($direction ?? 'desc') ?>">

    <div class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
            <label for="filter_foglio_id" class="form-label"><?= esc(lang('FoglioGiorno.foglio_id')) ?></label>
            <input type="number" id="filter_foglio_id" name="filter[foglio_id]" value="<?= esc((string) ($filters['foglio_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_hotel_id" class="form-label"><?= esc(lang('FoglioGiorno.hotel_id')) ?></label>
            <input type="number" id="filter_hotel_id" name="filter[hotel_id]" value="<?= esc((string) ($filters['hotel_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_conto_id" class="form-label"><?= esc(lang('FoglioGiorno.conto_id')) ?></label>
            <input type="number" id="filter_conto_id" name="filter[conto_id]" value="<?= esc((string) ($filters['conto_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_camera_id" class="form-label"><?= esc(lang('FoglioGiorno.camera_id')) ?></label>
            <select id="filter_camera_id" name="filter[camera_id]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) ($options['camera_id'] ?? []) as $value => $optionLabel): ?>
                    <option value="<?= esc((string) $value) ?>" <?= (string) ($filters['camera_id'] ?? '') === (string) $value ? 'selected' : '' ?>>
                        <?= esc((string) $optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_id" class="form-label"><?= esc(lang('FoglioGiorno.preno_id')) ?></label>
            <select id="filter_preno_id" name="filter[preno_id]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) ($options['preno_id'] ?? []) as $value => $optionLabel): ?>
                    <option value="<?= esc((string) $value) ?>" <?= (string) ($filters['preno_id'] ?? '') === (string) $value ? 'selected' : '' ?>>
                        <?= esc((string) $optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_tipologia_id" class="form-label"><?= esc(lang('FoglioGiorno.tipologia_id')) ?></label>
            <select id="filter_tipologia_id" name="filter[tipologia_id]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) ($options['tipologia_id'] ?? []) as $value => $optionLabel): ?>
                    <option value="<?= esc((string) $value) ?>" <?= (string) ($filters['tipologia_id'] ?? '') === (string) $value ? 'selected' : '' ?>>
                        <?= esc((string) $optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_foglio_prezzo_camera" class="form-label"><?= esc(lang('FoglioGiorno.foglio_prezzo_camera')) ?></label>
            <input type="number" step="any" id="filter_foglio_prezzo_camera" name="filter[foglio_prezzo_camera]" value="<?= esc((string) ($filters['foglio_prezzo_camera'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_date_foglio" class="form-label"><?= esc(lang('FoglioGiorno.date_foglio')) ?></label>
            <input type="search" id="filter_date_foglio" name="filter[date_foglio]" value="<?= esc((string) ($filters['date_foglio'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('FoglioGiorno.in_conto')) ?></label>
            <div class="input-group">
                <input type="date" name="filter[in_conto][from]" value="<?= esc((string) ($filters['in_conto']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="date" name="filter[in_conto][to]" value="<?= esc((string) ($filters['in_conto']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc(lang('FoglioGiorno.out_preno')) ?></label>
            <div class="input-group">
                <input type="date" name="filter[out_preno][from]" value="<?= esc((string) ($filters['out_preno']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="date" name="filter[out_preno][to]" value="<?= esc((string) ($filters['out_preno']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_stato_camera" class="form-label"><?= esc(lang('FoglioGiorno.stato_camera')) ?></label>
            <input type="number" id="filter_stato_camera" name="filter[stato_camera]" value="<?= esc((string) ($filters['stato_camera'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_agenzia" class="form-label"><?= esc(lang('FoglioGiorno.preno_agenzia')) ?></label>
            <select id="filter_preno_agenzia" name="filter[preno_agenzia]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) ($options['preno_agenzia'] ?? []) as $value => $optionLabel): ?>
                    <option value="<?= esc((string) $value) ?>" <?= (string) ($filters['preno_agenzia'] ?? '') === (string) $value ? 'selected' : '' ?>>
                        <?= esc((string) $optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
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
            <a href="<?= site_url('foglio_giorno') ?>" class="btn btn-outline-secondary js-reset-filters">
                Azzera
            </a>
        </div>
    </div>
</form>
