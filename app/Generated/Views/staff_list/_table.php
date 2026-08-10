<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('staff_list/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <th><?= esc(lang('StaffList.ID')) ?></th>
                        <th><?= esc(lang('StaffList.name')) ?></th>
                        <th><?= esc(lang('StaffList.address')) ?></th>
                        <th><?= esc(lang('StaffList.zip code')) ?></th>
                        <th><?= esc(lang('StaffList.phone')) ?></th>
                        <th><?= esc(lang('StaffList.city')) ?></th>
                        <th><?= esc(lang('StaffList.country')) ?></th>
                        <th><?= esc(lang('StaffList.SID')) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->{'ID'} ?? '') ?></td>
                                <td><?= esc($row->{'name'} ?? '') ?></td>
                                <td><?= esc($row->{'address'} ?? '') ?></td>
                                <td><?= esc($row->{'zip code'} ?? '') ?></td>
                                <td><?= esc($row->{'phone'} ?? '') ?></td>
                                <td><?= esc($row->{'city'} ?? '') ?></td>
                                <td><?= esc($row->{'country'} ?? '') ?></td>
                                <td><?= esc($row->{'SID'} ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= view('staff_list/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
