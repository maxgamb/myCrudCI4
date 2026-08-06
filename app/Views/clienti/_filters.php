<form id="crudFiltersForm" method="get" action="<?= site_url('clienti') ?>">
    <input type="hidden" name="sort" value="<?= esc($sort ?? 'clienti_id') ?>">
    <input type="hidden" name="direction" value="<?= esc($direction ?? 'desc') ?>">

    <div class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
            <label for="filter_clienti_id" class="form-label"><?= esc(lang('Clienti.clienti_id')) ?></label>
            <select id="filter_clienti_id" name="filter[clienti_id]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) ($options['clienti_id'] ?? []) as $value => $optionLabel): ?>
                    <option value="<?= esc((string) $value) ?>" <?= (string) ($filters['clienti_id'] ?? '') === (string) $value ? 'selected' : '' ?>>
                        <?= esc((string) $optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_preno_id" class="form-label"><?= esc(lang('Clienti.preno_id')) ?></label>
            <input type="number" id="filter_preno_id" name="filter[preno_id]" value="<?= esc((string) ($filters['preno_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_hotel_id" class="form-label"><?= esc(lang('Clienti.hotel_id')) ?></label>
            <input type="number" id="filter_hotel_id" name="filter[hotel_id]" value="<?= esc((string) ($filters['hotel_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_camera_id" class="form-label"><?= esc(lang('Clienti.camera_id')) ?></label>
            <input type="number" id="filter_camera_id" name="filter[camera_id]" value="<?= esc((string) ($filters['camera_id'] ?? '')) ?>" class="form-control">

        </div>
        <div class="col-12 col-md-3">
            <label for="filter_clienti_nome" class="form-label"><?= esc(lang('Clienti.clienti_nome')) ?></label>
            <input type="search" id="filter_clienti_nome" name="filter[clienti_nome]" value="<?= esc((string) ($filters['clienti_nome'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
        </div>
        <div class="col-12 col-md-3">
            <label for="filter_clienti_email" class="form-label"><?= esc(lang('Clienti.clienti_email')) ?></label>
            <input type="search" id="filter_clienti_email" name="filter[clienti_email]" value="<?= esc((string) ($filters['clienti_email'] ?? '')) ?>" class="form-control">
            <div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>
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
            <a href="<?= site_url('clienti') ?>" class="btn btn-outline-secondary js-reset-filters">
                Azzera
            </a>
        </div>
    </div>
</form>
