<?php

/**
 * Pager CI4 compatibile con Bootstrap 5.
 *
 * Il Pager mantiene la query string corrente; il renderer aggiunge soltanto
 * la struttura Bootstrap e le icone per prima/precedente/successiva/ultima.
 */

$pager->setSurroundCount(2);
?>

<nav aria-label="Navigazione pagine">
    <ul class="pagination pagination-sm mb-0">

        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="Prima pagina">
                    <i class="bi bi-chevron-bar-left" aria-hidden="true"></i>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Pagina precedente">
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">
                    <i class="bi bi-chevron-bar-left" aria-hidden="true"></i>
                </span>
            </li>

            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">
                    <i class="bi bi-chevron-left" aria-hidden="true"></i>
                </span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a
                    class="page-link"
                    href="<?= $link['uri'] ?>"
                    <?= $link['active'] ? 'aria-current="page"' : '' ?>
                >
                    <?= esc($link['title']) ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Pagina successiva">
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Ultima pagina">
                    <i class="bi bi-chevron-bar-right" aria-hidden="true"></i>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </span>
            </li>

            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link">
                    <i class="bi bi-chevron-bar-right" aria-hidden="true"></i>
                </span>
            </li>
        <?php endif ?>

    </ul>
</nav>
