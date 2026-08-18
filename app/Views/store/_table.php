<?php /* AJAX-replaced fragment: dual Pager and compact Bootstrap table. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('store/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'store_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'store_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="store_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Store.store_id')) ?>
                                <?php if (($sort ?? '') === 'store_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'manager_staff_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'manager_staff_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="manager_staff_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Store.manager_staff_id')) ?>
                                <?php if (($sort ?? '') === 'manager_staff_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'address_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'address_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="address_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Store.address_id')) ?>
                                <?php if (($sort ?? '') === 'address_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Store.last_update')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No record found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>
                                    <?php if ((string) ($row->{'store_id'} ?? '') !== ''): ?>
                                        <?php
                                        $quickQuery = (array) ($query ?? []);
                                        $quickQuery['store_id'] = (string) $row->{'store_id'};
                                        unset($quickQuery['page']);
                                        ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                        ><?= esc($row->{'store_id'} ?? '') ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->{'manager_staff_id'} ?? '') !== ''): ?><?php $parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? [])); $parentHref = site_url('staff/view/' . rawurlencode((string) $row->{'manager_staff_id'})); if ($parentTrailEncoded !== '') $parentHref .= '?_trail=' . rawurlencode($parentTrailEncoded); ?><a href="<?= esc($parentHref) ?>" class="text-decoration-none"><?= esc($row->{'manager_staff_id__label'} ?? $row->{'manager_staff_id'} ?? '') ?></a><?php else: ?><?= esc($row->{'manager_staff_id__label'} ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickQuery = (array) ($query ?? []);
                                    $quickQuery['manager_staff_id'] = (string) ($row->{'manager_staff_id'} ?? '');
                                    unset($quickQuery['page']);
                                    ?>
                                    <?php if ((string) ($row->{'manager_staff_id'} ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                            aria-label="Filter by this value"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td>
                                    <?php if ((string) ($row->{'address_id'} ?? '') !== ''): ?><?php $parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? [])); $parentHref = site_url('address/view/' . rawurlencode((string) $row->{'address_id'})); if ($parentTrailEncoded !== '') $parentHref .= '?_trail=' . rawurlencode($parentTrailEncoded); ?><a href="<?= esc($parentHref) ?>" class="text-decoration-none"><?= esc($row->{'address_id__label'} ?? $row->{'address_id'} ?? '') ?></a><?php else: ?><?= esc($row->{'address_id__label'} ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickQuery = (array) ($query ?? []);
                                    $quickQuery['address_id'] = (string) ($row->{'address_id'} ?? '');
                                    unset($quickQuery['page']);
                                    ?>
                                    <?php if ((string) ($row->{'address_id'} ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                            aria-label="Filter by this value"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td><?= esc($row->{'last_update'} ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->{'store_id'} ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Record actions">
                                        <a href="<?= site_url('store/view/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="<?= site_url('store/edit/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('store/delete/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                            <?= csrf_field() ?>
                                            <?php foreach ((array) ($navigationContext ?? []) as $contextField => $contextValue): ?>
                                                <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
                                            <?php endforeach; ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Cancella">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>                                    </div>
                                </td>                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= view('store/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
