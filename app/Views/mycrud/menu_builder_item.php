<?php
/** @var int $index */
/** @var array<string,mixed> $item */
/** @var bool|null $assigned */

$assigned = (bool) ($assigned ?? false);
$table = (string) ($item['table'] ?? '');
$label = (string) ($item['label'] ?? ($table !== '' ? $table : 'Nuova voce'));
$route = (string) ($item['route'] ?? $table);
$icon = (string) ($item['icon'] ?? 'bi-link-45deg');
$relationHints = array_values((array) ($item['relationHints'] ?? []));
$relatedTables = array_values((array) ($item['relatedTables'] ?? []));
?>
<div
    class="menu-builder-item border rounded bg-body p-2 mb-2"
    draggable="true"
    data-menu-item
    data-table="<?= esc($table) ?>"
    data-search="<?= esc(strtolower($table . ' ' . $label . ' ' . implode(' ', $relatedTables))) ?>"
>
    <input type="hidden" name="items[<?= $index ?>][table]" value="<?= esc($table) ?>" data-item-table>
    <input type="hidden" name="items[<?= $index ?>][group]" value="" data-item-group>
    <input type="hidden" name="items[<?= $index ?>][groupIcon]" value="bi-folder2-open" data-item-group-icon>
    <input type="hidden" name="items[<?= $index ?>][subgroup]" value="" data-item-subgroup>
    <input type="hidden" name="items[<?= $index ?>][groupOrder]" value="0" data-item-group-order>
    <input type="hidden" name="items[<?= $index ?>][subgroupOrder]" value="0" data-item-subgroup-order>
    <input type="hidden" name="items[<?= $index ?>][order]" value="<?= esc((string) ($item['order'] ?? (($index + 1) * 10))) ?>" data-item-order>

    <!--
        Il checkbox enabled viene gestito dal Builder:
        - non assegnato = non inviato nel menu finale;
        - dentro un gruppo/sottogruppo = abilitato.
    -->
    <input
        class="d-none"
        type="checkbox"
        name="items[<?= $index ?>][enabled]"
        value="1"
        data-item-enabled
        <?= $assigned ? 'checked' : '' ?>
    >

    <div class="d-flex align-items-start gap-2">
        <span class="menu-drag-handle text-body-secondary pt-1" title="Trascina">
            <i class="bi bi-grip-vertical"></i>
        </span>

        <input
            class="form-check-input mt-1"
            type="checkbox"
            data-item-select
            aria-label="Seleziona <?= esc($table !== '' ? $table : $label) ?>"
        >

        <div class="flex-grow-1 min-w-0">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <?php if ($table !== ''): ?>
                    <code class="small text-truncate" style="max-width: 180px;" title="<?= esc($table) ?>">
                        <?= esc($table) ?>
                    </code>
                <?php else: ?>
                    <span class="badge text-bg-primary">Route manuale</span>
                <?php endif ?>

                <?php if ($relatedTables !== []): ?>
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-info py-0 px-2"
                        data-show-relations
                        title="Mostra tabelle correlate"
                    >
                        <i class="bi bi-diagram-3"></i>
                        <?= count($relatedTables) ?>
                    </button>
                <?php endif ?>

                <label class="btn btn-sm btn-outline-warning py-0 px-2 mb-0 ms-auto" title="Preferito">
                    <input
                        class="visually-hidden"
                        type="checkbox"
                        name="items[<?= $index ?>][favorite]"
                        value="1"
                        data-item-favorite
                        <?= !empty($item['favorite']) ? 'checked' : '' ?>
                    >
                    <i class="bi <?= !empty($item['favorite']) ? 'bi-star-fill' : 'bi-star' ?>"></i>
                </label>

                <button
                    type="button"
                    class="btn btn-sm btn-outline-secondary py-0 px-2"
                    data-toggle-item-details
                    title="Proprietà voce"
                >
                    <i class="bi bi-sliders"></i>
                </button>
            </div>

            <div class="row g-2">
                <div class="col-md-6">
                    <input
                        class="form-control form-control-sm"
                        name="items[<?= $index ?>][label]"
                        value="<?= esc($label) ?>"
                        data-item-label
                        aria-label="Etichetta menu"
                        placeholder="Etichetta"
                    >
                </div>
                <div class="col-md-6">
                    <input
                        class="form-control form-control-sm"
                        name="items[<?= $index ?>][route]"
                        value="<?= esc($route) ?>"
                        data-item-route
                        aria-label="Route"
                        placeholder="route"
                    >
                </div>
            </div>

            <div class="row g-2 mt-1 d-none" data-item-details>
                <div class="col-md-5">
                    <label class="form-label small mb-1">Bootstrap Icon</label>
                    <input
                        class="form-control form-control-sm"
                        name="items[<?= $index ?>][icon]"
                        value="<?= esc($icon) ?>"
                        data-item-icon
                    >
                </div>

                <div class="col-md-7">
                    <div class="small text-body-secondary pt-1">
                        <?php if ($relationHints !== []): ?>
                            <strong>Relazioni SQL:</strong>
                            <ul class="mb-0 ps-3">
                                <?php foreach (array_slice($relationHints, 0, 4) as $hint): ?>
                                    <li><?= esc($hint) ?></li>
                                <?php endforeach ?>
                            </ul>
                        <?php elseif ($table !== ''): ?>
                            Nessuna foreign key diretta rilevata.
                        <?php else: ?>
                            Voce manuale: puoi indicare qualsiasi route interna valida.
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
