<?php
    $hasManyCollapseId = 'hasmany_' . preg_replace('/[^A-Za-z0-9_]/', '_', 'address__city_id');
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
                <strong><i class="bi bi-diagram-3"></i> Address</strong>
            </div>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('address/create') . '?' . http_build_query(['city_id' => $row->{'city_id'} ?? '', '_parent_field' => 'city_id', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'city', (string) ($row->{'city_id'} ?? ''), trim((string) ($row->{'city'} ?? '')) ?: 'City' . ' #' . (string) ($row->{'city_id'} ?? '')))]) ?>" class="btn btn-sm btn-primary" title="New related record"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New</a>
                <a href="<?= site_url('address') . '?' . http_build_query(['city_id' => $row->{'city_id'} ?? '', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'city', (string) ($row->{'city_id'} ?? ''), trim((string) ($row->{'city'} ?? '')) ?: 'City' . ' #' . (string) ($row->{'city_id'} ?? '')))]) ?>" class="btn btn-sm btn-outline-primary" title="View all related records"><i class="bi bi-list-ul me-1" aria-hidden="true"></i> View all</a>
                <span class="badge bg-secondary"><?= (int) ($children['address__city_id']['count'] ?? 0) ?><?= !empty($children['address__city_id']['hasMore']) ? '+' : '' ?></span>
            </div>
        </div>
        <div id="<?= esc($hasManyCollapseId) ?>" class="<?= $hasManyCollapsible ? 'collapse' . ($hasManyCollapsed ? '' : ' show') : '' ?>">
            <div class="card-body">
                <?php $relatedRows = $children['address__city_id']['rows'] ?? []; ?>
                <?php if (empty($relatedRows)): ?>
                    <div class="alert alert-light border mb-0">No related record.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle">
                            <thead><tr>
                                <th><?= esc('Address Id') ?></th>
                                <th><?= esc('Address') ?></th>
                                <th><?= esc('Address2') ?></th>
                                <th><?= esc('District') ?></th>
                                <th><?= esc('City Id') ?></th>
                                <th><?= esc('Postal Code') ?></th>
                                <th><?= esc('Phone') ?></th>
                                <th><?= esc('Location') ?></th>
                                <th><?= esc('Last Update') ?></th>
                            <th class="d-print-none">Azioni</th>
                            </tr></thead>
                            <tbody>
                                <?php foreach ($relatedRows as $child): ?>
                                    <tr>
                                <td><?= esc($child->{'address_id'} ?? '') ?></td>
                                <td><?= esc($child->{'address'} ?? '') ?></td>
                                <td><?= esc($child->{'address2'} ?? '') ?></td>
                                <td><?= esc($child->{'district'} ?? '') ?></td>
                                <td><?= esc($child->{'city_id'} ?? '') ?></td>
                                <td><?= esc($child->{'postal_code'} ?? '') ?></td>
                                <td><?= esc($child->{'phone'} ?? '') ?></td>
                                <td><?= esc($child->{'location'} ?? '') ?></td>
                                <td><?= esc($child->{'last_update'} ?? '') ?></td>
                                    <td class="d-print-none"><a href="<?= site_url('address/view/' . rawurlencode((string) ($child->{'address_id'} ?? ''))) . '?' . http_build_query(['city_id' => $row->{'city_id'} ?? '', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'city', (string) ($row->{'city_id'} ?? ''), trim((string) ($row->{'city'} ?? '')) ?: 'City' . ' #' . (string) ($row->{'city_id'} ?? '')))]) ?>" class="btn btn-sm btn-outline-info" title="Visualizza record"><i class="bi bi-eye" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($children['address__city_id']['hasMore'])): ?>
                        <div class="small text-muted d-print-none">Visualizzati i primi 20 record.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
