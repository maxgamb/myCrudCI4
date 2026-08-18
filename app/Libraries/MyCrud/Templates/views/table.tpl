<?php /* AJAX-replaced fragment: dual Pager and compact Bootstrap table. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('{{TABLE}}/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
{{HEADERS}}{{ACTION_HEADER}}                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="{{COLSPAN}}" class="text-center text-muted py-4">
                                No record found.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
{{CELLS}}{{ACTION_CELL}}                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= view('{{TABLE}}/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
