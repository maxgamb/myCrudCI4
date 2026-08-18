<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-4">
<h1 class="h3"><?= esc($title) ?></h1>
<?php foreach (($info['tables'] ?? []) as $tableName => $tableInfo): ?>
<div class="card mb-4"><div class="card-header"><strong><?= esc($tableName) ?></strong> <span class="badge bg-secondary">PK <?= esc($tableInfo['primaryKey']) ?></span></div>
<div class="card-body table-responsive"><table class="table table-sm table-bordered">
<thead><tr><th>Field</th><th>Tipo</th><th>Nullable</th><th>Chiave</th><th>Extra</th></tr></thead><tbody>
<?php foreach ($tableInfo['columns'] as $column): ?><tr><td><?= esc($column['name']) ?></td><td><?= esc($column['columnType']) ?></td><td><?= esc($column['nullable']) ?></td><td><?= esc($column['columnKey']) ?></td><td><?= esc($column['extra']) ?></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php endforeach; ?>
</div>
<?= $this->endSection() ?>
