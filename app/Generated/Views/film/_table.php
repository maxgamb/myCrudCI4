<?php /* AJAX-replaced fragment: dual Pager and compact Bootstrap table. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('film/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'film_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'film_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="film_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Film.film_id')) ?>
                                <?php if (($sort ?? '') === 'film_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'title' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'title',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="title"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Film.title')) ?>
                                <?php if (($sort ?? '') === 'title'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Film.description')) ?></th>
                        <th><?= esc(lang('Film.release_year')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'language_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'language_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="language_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Film.language_id')) ?>
                                <?php if (($sort ?? '') === 'language_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'original_language_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'original_language_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="original_language_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Film.original_language_id')) ?>
                                <?php if (($sort ?? '') === 'original_language_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Film.rental_duration')) ?></th>
                        <th><?= esc(lang('Film.rental_rate')) ?></th>
                        <th><?= esc(lang('Film.length')) ?></th>
                        <th><?= esc(lang('Film.replacement_cost')) ?></th>
                        <th><?= esc(lang('Film.rating')) ?></th>
                        <th><?= esc(lang('Film.special_features')) ?></th>
                        <th><?= esc(lang('Film.last_update')) ?></th>
                        <th><?= esc(lang('Film.uploads')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="15" class="text-center text-muted py-4">
                                No record found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>
                                    <?php if ((string) ($row->{'film_id'} ?? '') !== ''): ?>
                                        <?php
                                        $quickQuery = (array) ($query ?? []);
                                        $quickQuery['film_id'] = (string) $row->{'film_id'};
                                        unset($quickQuery['page']);
                                        ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                        ><?= esc($row->{'film_id'} ?? '') ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->{'title'} ?? '') !== ''): ?>
                                        <?php
                                        $quickQuery = (array) ($query ?? []);
                                        $quickQuery['title'] = (string) $row->{'title'};
                                        unset($quickQuery['page']);
                                        ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                        ><?= esc($row->{'title'} ?? '') ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->{'description'} ?? '') ?></td>
                                <td><?= esc($row->{'release_year'} ?? '') ?></td>
                                <td>
                                    <?= esc($row->{'language_id__label'} ?? $row->{'language_id'} ?? '') ?>
                                </td>                                <td>
                                    <?= esc($row->{'original_language_id__label'} ?? $row->{'original_language_id'} ?? '') ?>
                                </td>                                <td><?= esc($row->{'rental_duration'} ?? '') ?></td>
                                <td><?= esc($row->{'rental_rate'} ?? '') ?></td>
                                <td><?= esc($row->{'length'} ?? '') ?></td>
                                <td><?= esc($row->{'replacement_cost'} ?? '') ?></td>
                                <td><?= esc($row->{'rating'} ?? '') ?></td>
                                <td><?= esc($row->{'special_features'} ?? '') ?></td>
                                <td><?= esc($row->{'last_update'} ?? '') ?></td>
                                <td><?= esc($row->{'uploads'} ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->{'film_id'} ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Record actions">
                                        <a href="<?= site_url('film/view/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="<?= site_url('film/edit/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('film/delete/' . rawurlencode((string) $id)) . ($navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
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

        <?= view('film/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
