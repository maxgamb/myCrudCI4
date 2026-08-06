<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Cestino</h1>
        <a href="<?= site_url('{{TABLE}}') ?>" class="btn btn-secondary">Elenco attivo</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>ID</th><th>Eliminato il</th><th>Azioni</th></tr></thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= esc($row->{{PRIMARY_KEY}} ?? '') ?></td>
                            <td><?= esc($row->{{DELETED_FIELD}} ?? '') ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form method="post" action="<?= site_url('{{TABLE}}/restore/' . ($row->{{PRIMARY_KEY}} ?? '')) ?>">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-success">Ripristina</button>
                                    </form>
                                    <form method="post" action="<?= site_url('{{TABLE}}/force-delete/' . ($row->{{PRIMARY_KEY}} ?? '')) ?>" onsubmit="return confirm('Eliminare definitivamente?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Elimina definitivamente</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
