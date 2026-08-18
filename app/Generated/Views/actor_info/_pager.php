<?php /* Shared Pager above and below the table; preserves current GET parameters. */ ?>
<?php if (($pagerLinks ?? '') !== '' || (int) ($total ?? 0) > 0): ?>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 my-2">
        <span class="text-muted small">
            Record trovati: <strong><?= number_format((int) ($total ?? 0), 0, ',', '.') ?></strong>
            · Pagina <?= (int) ($page ?? 1) ?>
        </span>

        <?php if (($pagerLinks ?? '') !== ''): ?>
            <?= $pagerLinks ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
