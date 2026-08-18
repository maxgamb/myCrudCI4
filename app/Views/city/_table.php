<?php /* AJAX-replaced fragment: dual Pager and compact Bootstrap table. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('city/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'city_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'city_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="city_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('City.city_id')) ?>
                                <?php if (($sort ?? '') === 'city_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('City.city')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'country_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'country_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="country_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('City.country_id')) ?>
                                <?php if (($sort ?? '') === 'country_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('City.last_update')) ?></th>
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
                                    <?php if ((string) ($row->{'city_id'} ?? '') !== ''): ?>
                                        <?php
                                        $quickQuery = (array) ($query ?? []);
                                        $quickQuery['city_id'] = (string) $row->{'city_id'};
                                        unset($quickQuery['page']);
                                        ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                        ><?= esc($row->{'city_id'} ?? '') ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->{'city'} ?? '') ?></td>
                                <td>
                                    <?php if ((string) ($row->{'country_id'} ?? '') !== ''): ?><?php $parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode((array) ($cascadeTrail ?? [])); $parentHref = site_url('country/view/' . rawurlencode((string) $row->{'country_id'})); if ($parentTrailEncoded !== '') $parentHref .= '?_trail=' . rawurlencode($parentTrailEncoded); ?><a href="<?= esc($parentHref) ?>" class="text-decoration-none"><?= esc($row->{'country_id__label'} ?? $row->{'country_id'} ?? '') ?></a><?php else: ?><?= esc($row->{'country_id__label'} ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickQuery = (array) ($query ?? []);
                                    $quickQuery['country_id'] = (string) ($row->{'country_id'} ?? '');
                                    unset($quickQuery['page']);
                                    ?>
                                    <?php if ((string) ($row->{'country_id'} ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                            aria-label="Filter by this value"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td><?= esc($row->{'last_update'} ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->{'city_id'} ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Record actions">
                                        <a href="<?= site_url('city/view/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="<?= site_url('city/edit/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('city/delete/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
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

        <?= view('city/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
