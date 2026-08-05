<?php

namespace App\Libraries\MyCrud\Generators;

class ViewGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = $config['table'];

        return [
            'index.php'  => $this->writeGenerated(
                "Views/{$table}/index.php",
                $this->indexView($config),
                $force
            ),
            'view.php'   => $this->writeGenerated(
                "Views/{$table}/view.php",
                $this->detailView($config),
                $force
            ),
            'create.php' => $this->writeGenerated(
                "Views/{$table}/create.php",
                $this->formView($config, false),
                $force
            ),
            'edit.php'   => $this->writeGenerated(
                "Views/{$table}/edit.php",
                $this->formView($config, true),
                $force
            ),
        ];
    }

    private function detailView(array $config): string
    {
        $table = $config['table'];
        $rows  = '';

        foreach ($this->orderedFields($config) as $name) {
            $label = $config['fields'][$name]['label'];

            $rows .= <<<PHP
                    <tr>
                        <th style="width: 30%">{$label}</th>
                        <td><?= esc(\$row->{$name} ?? '') ?></td>
                    </tr>

PHP;
        }

        return <<<PHP
<?= \$this->extend('layouts/default') ?>
<?= \$this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
{$rows}                </tbody>
            </table>

            <a href="<?= site_url('{$table}') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>
</div>

<?= \$this->endSection() ?>
PHP;
    }

    
    
    private function indexView(array $config): string
{
    $table = $config['table'];
    $pk    = $config['primaryKey'];

    $headers = '';
    $columns = '';
    $filters = '';

    foreach ($this->orderedFields($config) as $name) {
        if (!isset($config['fields'][$name])) {
            continue;
        }

        $field = $config['fields'][$name];

        $labelExpression = $this->labelExpression(
            $field,
            $name
        );

        $headers .= <<<PHP
                            <th>
                                <?= esc({$labelExpression}) ?>
                            </th>

PHP;

        $filters .= <<<PHP
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc(
                                        'Filtra ' . {$labelExpression}
                                    ) ?>"
                                >
                            </th>

PHP;

        $columns .= <<<JS
            {
                data: '{$name}',
                name: '{$name}',
                defaultContent: ''
            },

JS;
    }

    return <<<PHP
<?= \$this->extend('layouts/default') ?>
<?= \$this->section('content') ?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">
                {$table}
            </h1>

            <small class="text-muted">
                Elenco e gestione record
            </small>
        </div>

        <a
            href="<?= site_url('{$table}/create') ?>"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-circle"></i>
            Nuovo
        </a>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= esc(session('message')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= esc(session('error')) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table
                    id="crudTable"
                    class="table table-striped table-hover align-middle w-100"
                >
                    <thead>
                        <tr>
{$headers}
                            <th>Azioni</th>
                        </tr>

                        <tr class="filters">
{$filters}
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css"
>

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css"
>

<link
    rel="stylesheet"
    href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css"
>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script>
$(function () {
    const table = $('#crudTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        stateSave: true,
        searchDelay: 350,
        order: [[0, 'asc']],

        ajax: {
            url: "<?= site_url('{$table}/datatable') ?>",
            type: 'POST',

            data: function (data) {
                data['<?= csrf_token() ?>'] =
                    '<?= csrf_hash() ?>';
            }
        },

        dom: '<"d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"lfB>rtip',

        buttons: [
            {
                extend: 'copyHtml5',
                text: '<i class="bi bi-clipboard"></i> Copia'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="bi bi-filetype-csv"></i> CSV'
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel'
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Stampa'
            },
            {
                extend: 'colvis',
                text: '<i class="bi bi-layout-three-columns"></i> Colonne'
            }
        ],

        columns: [
{$columns}
            {
                data: '{$pk}',
                name: '{$pk}',
                orderable: false,
                searchable: false,

                render: function (id) {
                    const base =
                        "<?= site_url('{$table}') ?>";

                    return `
                        <div class="btn-group btn-group-sm">

                            <a
                                href="\${base}/view/\${id}"
                                class="btn btn-outline-info"
                                title="Visualizza"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                            <a
                                href="\${base}/edit/\${id}"
                                class="btn btn-outline-warning"
                                title="Modifica"
                            >
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <button
                                type="button"
                                class="btn btn-outline-danger delete-record"
                                data-id="\${id}"
                                title="Elimina"
                            >
                                <i class="bi bi-trash"></i>
                            </button>

                        </div>
                    `;
                }
            }
        ],

        initComplete: function () {
            const api = this.api();

            api.columns().every(function (index) {
                if (
                    index ===
                    api.columns().count() - 1
                ) {
                    return;
                }

                const column = this;

                const input = $(
                    '#crudTable thead tr.filters th'
                )
                    .eq(index)
                    .find('input');

                input.on(
                    'keyup change clear',
                    function () {
                        if (
                            column.search() !==
                            this.value
                        ) {
                            column
                                .search(this.value)
                                .draw();
                        }
                    }
                );
            });
        },

        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/it-IT.json'
        }
    });

    $(document).on(
        'click',
        '.delete-record',
        function () {
            if (
                !confirm(
                    'Eliminare questo record?'
                )
            ) {
                return;
            }

            const form = $('<form>', {
                method: 'POST',
                action:
                    "<?= site_url('{$table}/delete') ?>/"
                    + $(this).data('id')
            });

            form.append(
                $('<input>', {
                    type: 'hidden',
                    name: '<?= csrf_token() ?>',
                    value: '<?= csrf_hash() ?>'
                })
            );

            $('body').append(form);

            form.trigger('submit');
        }
    );
});
</script>

<?= \$this->endSection() ?>
PHP;
}
    
    
    private function formView(array $config, bool $edit): string
    {
        $table = $config['table'];
        $pk    = $config['primaryKey'];
        $title = $edit ? 'Modifica record' : 'Nuovo record';
        $icon  = $edit ? 'bi-pencil-square' : 'bi-plus-circle';
        $route = $edit
            ? "'{$table}/update/' . \$row->{$pk}"
            : "'{$table}/store'";

        $fields = '';

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];

            if ($field['primary'] && $field['autoIncrement']) {
                continue;
            }

            $label      = $field['label'];
            $type       = $field['inputType'];
            $width      = max(1, min(12, (int) $field['width']));
            $attributes = $this->attributesString($field);
            $value      = $edit
                ? "old('{$name}', \$row->{$name} ?? '')"
                : "old('{$name}')";

            $control = match ($type) {
                'textarea' => <<<PHP
                    <textarea
                        name="{$name}"
                        id="{$name}"
                        class="form-control <?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>"
                        {$attributes}
                    ><?= esc({$value}) ?></textarea>
PHP,
                'select' => <<<PHP
                    <select
                        name="{$name}"
                        id="{$name}"
                        class="form-select <?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>"
                        {$attributes}
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach ((\$options['{$name}'] ?? []) as \$optionValue => \$optionLabel): ?>
                            <option
                                value="<?= esc(\$optionValue) ?>"
                                <?= (string) {$value} === (string) \$optionValue ? 'selected' : '' ?>
                            >
                                <?= esc(\$optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
PHP,
                'checkbox' => <<<PHP
                    <input type="hidden" name="{$name}" value="0">
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="{$name}"
                            id="{$name}"
                            value="1"
                            class="form-check-input <?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>"
                            <?= {$value} ? 'checked' : '' ?>
                            {$attributes}
                        >
                    </div>
PHP,
                default => <<<PHP
                    <input
                        type="{$type}"
                        name="{$name}"
                        id="{$name}"
                        value="<?= esc({$value}) ?>"
                        class="form-control <?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>"
                        {$attributes}
                    >
PHP,
            };

            $fields .= <<<PHP
                <div class="col-md-{$width}">
                    <label for="{$name}" class="form-label">{$label}</label>
{$control}
                    <div class="invalid-feedback">
                        <?= esc(\$errors['{$name}'] ?? '') ?>
                    </div>
                </div>

PHP;
        }

        return <<<PHP
<?= \$this->extend('layouts/default') ?>
<?= \$this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi {$icon}"></i> {$title}</h1>
        </div>

        <div class="card-body">
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif; ?>

            <?= form_open({$route}, [
                'class'   => 'row g-3',
                'enctype' => 'multipart/form-data',
                'id'      => 'myCrudForm',
            ]) ?>
                <input type="hidden" name="_submission_token" value="<?= esc(\$submissionToken ?? '') ?>">

{$fields}                <div class="col-12">
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <span class="submit-normal"><i class="bi bi-check-circle"></i> Salva</span>
                        <span class="submit-loading d-none">
                            <span class="spinner-border spinner-border-sm"></span> Salvataggio...
                        </span>
                    </button>

                    <a href="<?= site_url('{$table}') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Annulla
                    </a>
                </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<?= \$this->endSection() ?>
PHP;
    }

    private function orderedFields(array $config): array
    {
        $ordered = [];

        foreach ($config['order'] as $name) {
            if (isset($config['fields'][$name])) {
                $ordered[] = $name;
            }
        }

        return $ordered ?: array_keys($config['fields']);
    }

    private function attributesString(array $field): string
    {
        $parts = [];

        foreach ($field['attributes']['boolean'] ?? [] as $attribute) {
            if (in_array($attribute, ['required', 'readonly', 'disabled'], true)) {
                $parts[] = $attribute;
            }
        }

        foreach ($field['attributes']['values'] ?? [] as $name => $value) {
            if ($value === '' || $value === null) {
                continue;
            }

            $parts[] = sprintf(
                '%s="%s"',
                htmlspecialchars((string) $name, ENT_QUOTES),
                htmlspecialchars((string) $value, ENT_QUOTES)
            );
        }

        return implode(' ', $parts);
    }
    
    
    
    /**
 * Restituisce l'espressione PHP da usare nella view generata.
 *
 * Label compilata:
 *     'Testo personalizzato'
 *
 * Label vuota:
 *     lang('Fields.nome_campo')
 */
private function labelExpression(
    array $field,
    string $fieldName
): string {
    $customLabel = trim(
        (string) (
            $field['label']
            ?? ''
        )
    );

    if ($customLabel !== '') {
        return var_export(
            $customLabel,
            true
        );
    }

    $languageKey = (string) (
        $field['languageKey']
        ?? 'Fields.' . $fieldName
    );

    return sprintf(
        'lang(%s)',
        var_export($languageKey, true)
    );
}
    
    
}
