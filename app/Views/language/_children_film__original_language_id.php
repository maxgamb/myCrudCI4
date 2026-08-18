<?php
    $hasManyCollapseId = 'hasmany_' . preg_replace('/[^A-Za-z0-9_]/', '_', 'film__original_language_id');
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
                <strong><i class="bi bi-diagram-3"></i> Film</strong>
            </div>
            <div class="d-flex align-items-center gap-2 d-print-none">
                <a href="<?= site_url('film/create') . '?' . http_build_query(['original_language_id' => $row->{'language_id'} ?? '', '_parent_field' => 'original_language_id', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'language', (string) ($row->{'language_id'} ?? ''), trim((string) ($row->{'name'} ?? '')) ?: 'Language' . ' #' . (string) ($row->{'language_id'} ?? '')))]) ?>" class="btn btn-sm btn-primary" title="New related record"><i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New</a>
                <a href="<?= site_url('film') . '?' . http_build_query(['original_language_id' => $row->{'language_id'} ?? '', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'language', (string) ($row->{'language_id'} ?? ''), trim((string) ($row->{'name'} ?? '')) ?: 'Language' . ' #' . (string) ($row->{'language_id'} ?? '')))]) ?>" class="btn btn-sm btn-outline-primary" title="View all related records"><i class="bi bi-list-ul me-1" aria-hidden="true"></i> View all</a>
                <span class="badge bg-secondary"><?= (int) ($children['film__original_language_id']['count'] ?? 0) ?><?= !empty($children['film__original_language_id']['hasMore']) ? '+' : '' ?></span>
            </div>
        </div>
        <div id="<?= esc($hasManyCollapseId) ?>" class="<?= $hasManyCollapsible ? 'collapse' . ($hasManyCollapsed ? '' : ' show') : '' ?>">
            <div class="card-body">
                <?php $relatedRows = $children['film__original_language_id']['rows'] ?? []; ?>
                <?php if (empty($relatedRows)): ?>
                    <div class="alert alert-light border mb-0">No related record.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-hover align-middle">
                            <thead><tr>
                                <th><?= esc('Film Id') ?></th>
                                <th><?= esc('Title') ?></th>
                                <th><?= esc('Description') ?></th>
                                <th><?= esc('Release Year') ?></th>
                                <th><?= esc('Language Id') ?></th>
                                <th><?= esc('Original Language Id') ?></th>
                                <th><?= esc('Rental Duration') ?></th>
                                <th><?= esc('Rental Rate') ?></th>
                                <th><?= esc('Length') ?></th>
                                <th><?= esc('Replacement Cost') ?></th>
                                <th><?= esc('Rating') ?></th>
                                <th><?= esc('Special Features') ?></th>
                                <th><?= esc('Last Update') ?></th>
                                <th><?= esc('Uploads') ?></th>
                            <th class="d-print-none">Azioni</th>
                            </tr></thead>
                            <tbody>
                                <?php foreach ($relatedRows as $child): ?>
                                    <tr>
                                <td><?= esc($child->{'film_id'} ?? '') ?></td>
                                <td><?= esc($child->{'title'} ?? '') ?></td>
                                <td><?= esc($child->{'description'} ?? '') ?></td>
                                <td><?= esc($child->{'release_year'} ?? '') ?></td>
                                <td><?= esc($child->{'language_id'} ?? '') ?></td>
                                <td><?= esc($child->{'original_language_id'} ?? '') ?></td>
                                <td><?= esc($child->{'rental_duration'} ?? '') ?></td>
                                <td><?= esc($child->{'rental_rate'} ?? '') ?></td>
                                <td><?= esc($child->{'length'} ?? '') ?></td>
                                <td><?= esc($child->{'replacement_cost'} ?? '') ?></td>
                                <td><?= esc($child->{'rating'} ?? '') ?></td>
                                <td><?= esc($child->{'special_features'} ?? '') ?></td>
                                <td><?= esc($child->{'last_update'} ?? '') ?></td>
                                <td><?= esc($child->{'uploads'} ?? '') ?></td>
                                    <td class="d-print-none"><a href="<?= site_url('film/view/' . rawurlencode((string) ($child->{'film_id'} ?? ''))) . '?' . http_build_query(['original_language_id' => $row->{'language_id'} ?? '', '_trail' => \App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) ($cascadeTrail ?? []), 'language', (string) ($row->{'language_id'} ?? ''), trim((string) ($row->{'name'} ?? '')) ?: 'Language' . ' #' . (string) ($row->{'language_id'} ?? '')))]) ?>" class="btn btn-sm btn-outline-info" title="Visualizza record"><i class="bi bi-eye" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($children['film__original_language_id']['hasMore'])): ?>
                        <div class="small text-muted d-print-none">Visualizzati i primi 20 record.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
