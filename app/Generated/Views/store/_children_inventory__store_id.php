<?php
    $hasManyCollapseId = 'hasmany_' . preg_replace('/[^A-Za-z0-9_]/', '_', 'inventory__store_id');
    $hasManyCollapsible = true;
    $hasManyCollapsed = false;
    ?>
    <div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <?php if ($hasManyCollapsible): ?>
                    <button
                        type="button"
                        class="btn btn-sm btn-link text-decoration-none p-0 d-print-none"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?= esc($hasManyCollapseId) ?>"
                        aria-expanded="<?= $hasManyCollapsed ? 'false' : 'true' ?>"
                        aria-controls="<?= esc($hasManyCollapseId) ?>"
                        title="Open/close child table"
                    ><i class="bi bi-chevron-down"></i></button>
                <?php endif; ?>
                <strong><i class="bi bi-diagram-3"></i> Inventory</strong>
            </div>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('inventory/create') . '?' . http_build_query(['store_id' => $row->{'store_id'} ?? '', '_parent_field' => 'store_id', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'store', (string) ($row->{'store_id'} ?? ''), 'Store' . ' #' . (string) ($row->{'store_id'} ?? '')))]) ?>" class="btn btn-sm btn-primary" title="New related record"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New</a>
                <a href="<?= site_url('inventory') . '?' . http_build_query(['store_id' => $row->{'store_id'} ?? '', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'store', (string) ($row->{'store_id'} ?? ''), 'Store' . ' #' . (string) ($row->{'store_id'} ?? '')))]) ?>" class="btn btn-sm btn-outline-primary" title="View all related records"><i class="bi bi-list-ul me-1" aria-hidden="true"></i> View all</a>
                <span class="badge bg-secondary"><?= (int) ($children['inventory__store_id']['count'] ?? 0) ?><?= !empty($children['inventory__store_id']['hasMore']) ? '+' : '' ?></span>
            </div>
        </div>
        <div id="<?= esc($hasManyCollapseId) ?>" class="<?= $hasManyCollapsible ? 'collapse' . ($hasManyCollapsed ? '' : ' show') : '' ?>">
            <div class="card-body">
                <?php $relatedRows = $children['inventory__store_id']['rows'] ?? []; ?>
                <?php if (empty($relatedRows)): ?>
                    <div class="alert alert-light border mb-0">No related record.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle">
                            <thead><tr>
                                <th><?= esc('Inventory Id') ?></th>
                                <th><?= esc('Film Id') ?></th>
                                <th><?= esc('Store Id') ?></th>
                                <th><?= esc('Last Update') ?></th>
                            <th class="d-print-none">Azioni</th>
                            </tr></thead>
                            <tbody>
                                <?php foreach ($relatedRows as $child): ?>
                                    <tr>
                                <td><?= esc($child->{'inventory_id'} ?? '') ?></td>
                                <td><?= esc($child->{'film_id'} ?? '') ?></td>
                                <td><?= esc($child->{'store_id'} ?? '') ?></td>
                                <td><?= esc($child->{'last_update'} ?? '') ?></td>
                                    <td class="d-print-none"><a href="<?= site_url('inventory/view/' . rawurlencode((string) ($child->{'inventory_id'} ?? ''))) . '?' . http_build_query(['store_id' => $row->{'store_id'} ?? '', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'store', (string) ($row->{'store_id'} ?? ''), 'Store' . ' #' . (string) ($row->{'store_id'} ?? '')))]) ?>" class="btn btn-sm btn-outline-info" title="Visualizza record"><i class="bi bi-eye" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($children['inventory__store_id']['hasMore'])): ?>
                        <div class="small text-muted d-print-none">Visualizzati i primi 20 record.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
