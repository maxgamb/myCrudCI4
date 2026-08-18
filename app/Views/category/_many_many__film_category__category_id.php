<?php
$manyCollapseId = 'many_view_many__film_category__category_id';
$manyCollapsible = true;
$manyCollapsed = false;
?>
<section class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
            <?php if ($manyCollapsible): ?>
                <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-print-none" data-bs-toggle="collapse" data-bs-target="#<?= esc($manyCollapseId) ?>" aria-expanded="<?= $manyCollapsed ? 'false' : 'true' ?>" title="Open/close relation"><i class="bi bi-chevron-down"></i></button>
            <?php endif; ?>
            <span><i class="bi bi-diagram-2 me-1" aria-hidden="true"></i><strong>Film</strong> <small class="text-muted ms-2">pivot film_category</small></span>
        </div>
        <span class="badge bg-secondary"><?= (int) ($children['many__film_category__category_id']['count'] ?? 0) ?><?= !empty($children['many__film_category__category_id']['hasMore']) ? '+' : '' ?></span>
    </div>
    <div id="<?= esc($manyCollapseId) ?>" class="<?= $manyCollapsible ? 'collapse' . ($manyCollapsed ? '' : ' show') : '' ?>">
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>title</th><th class="d-print-none text-end">Azioni</th></tr></thead>
            <tbody>
            <?php foreach ((array) ($children['many__film_category__category_id']['rows'] ?? []) as $child): ?>
                <tr>
                    <td><?= esc($child->{'title'} ?? $child->{'film_id'} ?? '') ?></td>
                    <td class="d-print-none text-end"><?php $manyTrail = \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'category', (string) ($row->{'category_id'} ?? ''), trim((string) ($row->{'name'} ?? '')) ?: 'Category' . ' #' . (string) ($row->{'category_id'} ?? ''))); ?>
<a class="btn btn-sm btn-outline-info" href="<?= site_url('film/view/' . rawurlencode((string) ($child->{'film_id'} ?? ''))) . ($manyTrail !== '' ? '?_trail=' . rawurlencode($manyTrail) : '') ?>" title="Open related record"><i class="bi bi-eye"></i></a></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($children['many__film_category__category_id']['rows'])): ?>
                <tr><td colspan="2" class="text-muted">No related record.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer small text-muted">
        Scaffolding N:N: i metodi attach/detach/sync sono generati nel Model; personalizzare qui l'interfaccia applicativa se necessaria.
    </div>
    </div>
</section>
