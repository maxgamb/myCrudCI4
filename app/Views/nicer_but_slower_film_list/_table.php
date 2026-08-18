<?php /* AJAX-replaced fragment: dual Pager and compact Bootstrap table. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('nicer_but_slower_film_list/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <th><?= esc(lang('NicerButSlowerFilmList.FID')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.title')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.description')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.category')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.price')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.length')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.rating')) ?></th>
                        <th><?= esc(lang('NicerButSlowerFilmList.actors')) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No record found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->{'FID'} ?? '') ?></td>
                                <td><?= esc($row->{'title'} ?? '') ?></td>
                                <td><?= esc($row->{'description'} ?? '') ?></td>
                                <td><?= esc($row->{'category'} ?? '') ?></td>
                                <td><?= esc($row->{'price'} ?? '') ?></td>
                                <td><?= esc($row->{'length'} ?? '') ?></td>
                                <td><?= esc($row->{'rating'} ?? '') ?></td>
                                <td><?= esc($row->{'actors'} ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= view('nicer_but_slower_film_list/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
