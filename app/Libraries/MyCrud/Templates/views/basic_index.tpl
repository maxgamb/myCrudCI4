<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">{{TABLE}}</h1>
            <small class="text-muted">Elenco paginato con Pager CI4</small>
        </div>
        <a href="<?= site_url('{{TABLE}}/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuovo
        </a>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success"><?= esc(session('message')) ?></div>
    <?php endif; ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="get" action="<?= current_url() ?>" class="row g-2 align-items-end">
                <div class="col-12 col-md-6">
                    <label for="q" class="form-label">Ricerca</label>
                    <input type="search" id="q" name="q" value="<?= esc($search ?? '') ?>" class="form-control">
                </div>
                <div class="col-6 col-md-2">
                    <label for="perPage" class="form-label">Righe</label>
                    <select id="perPage" name="perPage" class="form-select">
                        <?php foreach ([10, 25, 50, 100, 200] as $size): ?>
                            <option value="<?= $size ?>" <?= (int) ($perPage ?? 25) === $size ? 'selected' : '' ?>><?= $size ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-4">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Filtra</button>
                    <a href="<?= site_url('{{TABLE}}') ?>" class="btn btn-outline-secondary">Azzera</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
{{HEADERS}}                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rows)): ?>
                            <tr><td colspan="{{COLSPAN}}" class="text-center text-muted py-4">Nessun record trovato.</td></tr>
                        <?php else: ?>
                            <?php foreach ($rows as $row): ?>
                                <tr>
{{CELLS}}                                    <td>
                                        <?php $id = $row->{{PRIMARY_KEY}} ?? ''; ?>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= site_url('{{TABLE}}/view/' . $id) ?>" class="btn btn-outline-info"><i class="bi bi-eye"></i></a>
                                            <a href="<?= site_url('{{TABLE}}/edit/' . $id) ?>" class="btn btn-outline-warning"><i class="bi bi-pencil-square"></i></a>
                                            <form method="post" action="<?= site_url('{{TABLE}}/delete/' . $id) ?>" onsubmit="return confirm('Eliminare questo record?')">
                                                <?= csrf_field() ?>
                                                <button class="btn btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?= $pager->links($pagerGroup, 'bootstrap_full') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
