<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form id="crudFiltersForm" method="get" action="<?= site_url('agenzie') ?>">
            <input type="hidden" name="sort" value="<?= esc($sort ?? 'agenzia_id') ?>">
            <input type="hidden" name="direction" value="<?= esc($direction ?? 'desc') ?>">

            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label for="filter_agenzia_id" class="form-label"><?= esc(lang('Fields.agenzia_id')) ?></label>
                    <input type="number" id="filter_agenzia_id" name="filter[agenzia_id]" value="<?= esc((string) ($filters['agenzia_id'] ?? '')) ?>" class="form-control">

                </div>
                <div class="col-12 col-md-3">
                    <label for="filter_hotel_id" class="form-label"><?= esc(lang('Fields.hotel_id')) ?></label>
                    <input type="number" id="filter_hotel_id" name="filter[hotel_id]" value="<?= esc((string) ($filters['hotel_id'] ?? '')) ?>" class="form-control">

                </div>
                <div class="col-6 col-md-2">
                    <label for="crudPerPage" class="form-label">Righe</label>
                    <select id="crudPerPage" name="perPage" class="form-select">
                        <?php foreach ([10, 25, 50, 100] as $size): ?>
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
                    <a href="<?= site_url('agenzie') ?>" class="btn btn-outline-secondary">
                        Azzera
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
