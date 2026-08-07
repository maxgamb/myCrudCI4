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
                            <th class="w-25"><?= esc(lang('Question.question_id')) ?></th>
                            <td><?= esc($row->question_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Question.title')) ?></th>
                            <td><?= esc($row->title ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Question.tex_lingue_id_pro')) ?></th>
                            <td><?= esc($row->tex_lingue_id_pro ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Question.tex_lingue_id_con')) ?></th>
                            <td><?= esc($row->tex_lingue_id_con ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Question.tex_pro')) ?></th>
                            <td><?= esc($row->tex_pro ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Question.tex_no')) ?></th>
                            <td><?= esc($row->tex_no ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('question') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Question Rew</strong>
            <span class="badge bg-secondary"><?= (int) ($children['question_rew__question_id']['count'] ?? 0) ?><?= !empty($children['question_rew__question_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['question_rew__question_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Question Rew Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Clienti Id') ?></th>
                                <th><?= esc('Valore') ?></th>
                                <th><?= esc('Data') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->question_rew_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->clienti_id ?? '') ?></td>
                                <td><?= esc($child->valore ?? '') ?></td>
                                <td><?= esc($child->data ?? '') ?></td>
                                    <td><a href="<?= site_url('question_rew/view/' . ($child->question_rew_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['question_rew__question_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
