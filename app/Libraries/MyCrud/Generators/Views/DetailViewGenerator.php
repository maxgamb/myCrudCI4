<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

final class DetailViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        $rows = '';
        $table = (string) $config['table'];
        $primaryKey = (string) ($config['primaryKey'] ?? 'id');
        $rowId = $this->objectProperty('row', $primaryKey);
        $currentTrailLabel = $this->trailLabelExpression($config, 'row', $rowId);

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $ui = (array) ($field['ui'] ?? []);
            $inputType = (string) ($field['inputType'] ?? 'text');
            if (!empty($ui['sensitive']) || FieldPolicy::isSensitive($name, $inputType)) {
                continue;
            }
            if (array_key_exists('visibleView', (array) ($field['ui'] ?? [])) && empty($field['ui']['visibleView'])) {
                continue;
            }
            $label = $this->labelExpression($field, $name);
            $relation = $config['relations']['belongsTo'][$name] ?? null;
            $rowValue = $this->objectProperty('row', $name);
            $valueMarkup = "<?= esc({$rowValue} ?? '') ?>";

            if (in_array(strtolower($inputType), ['file', 'image'], true)) {
                $valueMarkup = $this->uploadValueMarkup($table, $rowId, $name, $rowValue, strtolower($inputType), true);
            } elseif (is_array($relation)) {
                $alias = (string) ($relation['alias'] ?? ($name . '__label'));
                $parentTable = (string) ($relation['parentTable'] ?? '');
                $rowLabel = $this->objectProperty('row', $alias);
                $displayMarkup = "<?= esc({$rowLabel} ?? {$rowValue} ?? '') ?>";
                if (!empty($field['relationNavigation']['parentLink']) && $parentTable !== '') {
                    $parentTableExport = var_export($parentTable, true);
                    $valueMarkup = <<<PHP
<?php
\$parentTargetId = (string) ({$rowValue} ?? '');
\$parentTrail = \App\Libraries\Crud\CrudNavigationTrail::ancestorsForParent((array) (\$cascadeTrail ?? []), {$parentTableExport}, \$parentTargetId);
if (\$parentTrail === (array) (\$cascadeTrail ?? [])) {
    \$parentTrail = \App\Libraries\Crud\CrudNavigationTrail::append(\$parentTrail, "{$table}", (string) ({$rowId} ?? ''), {$currentTrailLabel});
}
\$parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode(\$parentTrail);
\$parentUrl = site_url({$parentTableExport} . '/view/' . rawurlencode(\$parentTargetId));
if (\$parentTrailEncoded !== '') \$parentUrl .= '?_trail=' . rawurlencode(\$parentTrailEncoded);
?>
<a href="<?= esc(\$parentUrl) ?>" class="text-decoration-none">{$displayMarkup}</a>
PHP;
                } else {
                    $valueMarkup = $displayMarkup;
                }
            }

            $rows .= <<<PHP
                        <tr>
                            <th class="w-25"><?= esc({$label}) ?></th>
                            <td>{$valueMarkup}</td>
                        </tr>
PHP;
        }

        $writable = !empty($config['features']['writable']);

        $newAction = $writable ? <<<PHP
        <a href="<?= site_url('{$table}/create') . (\$navigationQuery ?? '') ?>" class="btn btn-primary" title="New record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New
        </a>
PHP : '';

        $writeActions = $writable ? <<<PHP
        <a href="<?= site_url('{$table}/edit/' . rawurlencode((string) ({$rowId} ?? ''))) . (\$navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit record">
            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i> Edit
        </a>
        <form method="post" action="<?= site_url('{$table}/delete/' . rawurlencode((string) ({$rowId} ?? ''))) . (\$navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
            <?= csrf_field() ?>
            <?php foreach ((array) (\$navigationContext ?? []) as \$contextField => \$contextValue): ?>
                <input type="hidden" name="_context[<?= esc((string) \$contextField) ?>]" value="<?= esc((string) \$contextValue) ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-outline-danger" title="Delete record">
                <i class="bi bi-trash me-1" aria-hidden="true"></i> Cancella
            </button>
        </form>
PHP : '';

        $toolbarActions = <<<PHP
{$newAction}        <a href="<?= site_url('{$table}') . (\$navigationQuery ?? '') ?>" class="btn btn-outline-secondary" title="Back to list">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> List
        </a>
{$writeActions}        <button type="button" class="btn btn-outline-secondary" onclick="window.print()" title="Print details">
            <i class="bi bi-printer me-1" aria-hidden="true"></i> Stampa
        </button>
PHP;

        return $this->templates->render('views/detail.tpl', [
            'table'           => $table,
            'route'           => $table,
            'rows'            => $rows,
            'panels'          => $this->buildHasManyPartialIncludes($config) . $this->buildManyToManyPartialIncludes($config),
            'toolbar_actions' => $toolbarActions,
        ]);
    }

    /**
     * Generates a partial for each child relation. The partial is intentionally
     * owned by the parent CRUD: it is a readable extension point that the
     * developer can customize without turning the main View
     * in un blocco monolitico.
     *
     * @return array<string, string> filename => content
     */
    public function generateHasManyPartials(array $config): array
    {
        $partials = [];
        $pivotTables = $this->enabledManyToManyPivotTables($config);

        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $childTable = trim((string) ($relation['childTable'] ?? ''));
            if ($childTable !== '' && isset($pivotTables[$childTable])) {
                continue;
            }

            $safeKey = preg_replace('/[^A-Za-z0-9_]/', '_', (string) $key) ?: 'relation';
            $single = $config;
            $single['relationsConfig']['hasMany'] = [(string) $key => $relation];
            $partials['_children_' . $safeKey . '.php'] = $this->buildHasManyPanels($single);
        }

        return $partials;
    }

    /**
     * @return array<string,true>
     */
    private function enabledManyToManyPivotTables(array $config): array
    {
        $pivotTables = [];

        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $pivotTable = trim((string) ($relation['pivotTable'] ?? ''));
            if ($pivotTable !== '') {
                $pivotTables[$pivotTable] = true;
            }
        }

        return $pivotTables;
    }

    /** @return array<string, string> filename => content */
    public function generateManyToManyPartials(array $config): array
    {
        $partials = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $safeKey = preg_replace('/[^A-Za-z0-9_]/', '_', (string) $key) ?: 'many_relation';
            $partials['_many_' . $safeKey . '.php'] = $this->buildManyToManyPanel($config, (string) $key, (array) $relation);
        }
        return $partials;
    }

    private function buildManyToManyPartialIncludes(array $config): string
    {
        $table = (string) ($config['table'] ?? '');
        $output = '';
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $safeKey = preg_replace('/[^A-Za-z0-9_]/', '_', (string) $key) ?: 'many_relation';
            $viewPath = $table . '/_many_' . $safeKey;
            $output .= "<?= view(" . var_export($viewPath, true) . ", ['row' => \$row, 'children' => \$children, 'cascadeTrail' => \$cascadeTrail ?? []]) ?>\n";
        }
        return $output;
    }

    private function buildManyToManyPanel(array $config, string $key, array $relation): string
    {
        $title = htmlspecialchars((string) ($relation['title'] ?? $relation['relatedTable'] ?? 'Relation'), ENT_QUOTES);
        $icon = htmlspecialchars((string) ($relation['icon'] ?? 'bi-diagram-2'), ENT_QUOTES);
        $relatedTable = (string) ($relation['relatedTable'] ?? '');
        $relatedKey = (string) ($relation['relatedKey'] ?? 'id');
        $displayField = (string) ($relation['relatedDisplayField'] ?? $relatedKey);
        $keyExport = var_export($key, true);
        $countBadge = '';
        if (!empty($relation['showCount'])) {
            $countBadge = <<<PHP
<span class="badge bg-secondary"><?= (int) (\$children[{$keyExport}]['count'] ?? 0) ?><?= !empty(\$children[{$keyExport}]['hasMore']) ? '+' : '' ?></span>
PHP;
        }
        $rowKey = $this->objectProperty('child', $relatedKey);
        $rowLabel = $this->objectProperty('child', $displayField);
        $viewButton = '';
        if (!empty($relation['showViewButton']) && $relatedTable !== '') {
            $routePrefix = var_export($relatedTable . '/view/', true);
            $parentTable = (string) ($config['table'] ?? '');
            $parentKey = (string) ($config['primaryKey'] ?? 'id');
            $parentValue = $this->objectProperty('row', $parentKey);
            $parentLabel = $this->trailLabelExpression($config, 'row', $parentValue);
            $trailExpr = "\App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) (\$cascadeTrail ?? []), " . var_export($parentTable, true) . ", (string) ({$parentValue} ?? ''), {$parentLabel}))";
            $viewButton = <<<PHP
<?php \$manyTrail = {$trailExpr}; ?>
<a class="btn btn-sm btn-outline-info" href="<?= site_url({$routePrefix} . rawurlencode((string) ({$rowKey} ?? ''))) . (\$manyTrail !== '' ? '?_trail=' . rawurlencode(\$manyTrail) : '') ?>" title="Open related record"><i class="bi bi-eye"></i></a>
PHP;
        }
        $pivot = htmlspecialchars((string) ($relation['pivotTable'] ?? ''), ENT_QUOTES);

        $safeCollapseKey = preg_replace('/[^A-Za-z0-9_]/', '_', $key) ?: 'many_relation';
        $collapsible = !empty($relation['collapsible']) ? 'true' : 'false';
        $collapsed = !empty($relation['collapsed']) ? 'true' : 'false';

        return <<<PHP
<?php
\$manyCollapseId = 'many_view_{$safeCollapseKey}';
\$manyCollapsible = {$collapsible};
\$manyCollapsed = {$collapsed};
?>
<section class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2">
            <?php if (\$manyCollapsible): ?>
                <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 d-print-none" data-bs-toggle="collapse" data-bs-target="#<?= esc(\$manyCollapseId) ?>" aria-expanded="<?= \$manyCollapsed ? 'false' : 'true' ?>" title="Open/close relation"><i class="bi bi-chevron-down"></i></button>
            <?php endif; ?>
            <span><i class="bi {$icon} me-1" aria-hidden="true"></i><strong>{$title}</strong> <small class="text-muted ms-2">pivot {$pivot}</small></span>
        </div>
        {$countBadge}
    </div>
    <div id="<?= esc(\$manyCollapseId) ?>" class="<?= \$manyCollapsible ? 'collapse' . (\$manyCollapsed ? '' : ' show') : '' ?>">
    <div class="table-responsive">
        <table class="table table-sm align-middle mb-0">
            <thead><tr><th>{$displayField}</th><th class="d-print-none text-end">Azioni</th></tr></thead>
            <tbody>
            <?php foreach ((array) (\$children[{$keyExport}]['rows'] ?? []) as \$child): ?>
                <tr>
                    <td><?= esc({$rowLabel} ?? {$rowKey} ?? '') ?></td>
                    <td class="d-print-none text-end">{$viewButton}</td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty(\$children[{$keyExport}]['rows'])): ?>
                <tr><td colspan="2" class="text-muted">No related record.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer small text-muted">
        Scaffolding N:N: i metodi attach/detach/sync sono generati nel Model; personalizzare qui l'interfaccia applicativa se necessaria.
    </div>
    </div>
</section>
PHP;
    }

    /** Generates only child-partial includes in the main View. */
    private function buildHasManyPartialIncludes(array $config): string
    {
        $table = (string) ($config['table'] ?? '');
        $output = '';
        $pivotTables = $this->enabledManyToManyPivotTables($config);

        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $childTable = trim((string) ($relation['childTable'] ?? ''));
            if ($childTable !== '' && isset($pivotTables[$childTable])) {
                continue;
            }

            $safeKey = preg_replace('/[^A-Za-z0-9_]/', '_', (string) $key) ?: 'relation';
            $viewPath = $table . '/_children_' . $safeKey;

            $output .= "<?= view("
                . var_export($viewPath, true)
                . ", ['row' => \$row, 'children' => \$children, 'cascadeTrail' => \$cascadeTrail ?? []]) ?>
";
        }

        return $output;
    }

    private function buildHasManyPanels(array $config): string
    {
        $output = '';
        $pivotTables = $this->enabledManyToManyPivotTables($config);

        // A child table may reference the same parent multiple times through foreign keys
        // diverse (es. film.language_id e film.original_language_id). In quel
        // caso il titolo tecnico della FK evita pannelli indistinguibili.
        $childTableOccurrences = [];
        foreach ($config['relationsConfig']['hasMany'] ?? [] as $relation) {
            if (empty($relation['enabled']) || empty($relation['childTable'])) {
                continue;
            }

            $childTable = trim((string) $relation['childTable']);
            if ($childTable !== '' && isset($pivotTables[$childTable])) {
                continue;
            }
            $childTableOccurrences[$childTable] = ($childTableOccurrences[$childTable] ?? 0) + 1;
        }

        foreach ($config['relationsConfig']['hasMany'] ?? [] as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $childTable = trim((string) ($relation['childTable'] ?? ''));
            if ($childTable !== '' && isset($pivotTables[$childTable])) {
                continue;
            }

            // Relations must come from the current schema. A configuration
            // legacy/stale incompleta viene ignorata invece di interrompere la
            // detail-page generation.
            if (
                empty($relation['childTable'])
                || empty($relation['foreignKey'])
                || empty($relation['primaryKey'])
            ) {
                continue;
            }

            $headers = '';
            $cells = '';

            foreach ($relation['columns'] ?? [] as $column) {
                $column = (string) $column;
                $childLabel = var_export(Naming::human($column), true);
                $headers .= "                                <th><?= esc({$childLabel}) ?></th>\n";
                $childValue = $this->objectProperty('child', $column);
                $columnType = strtolower((string) (($relation['columnTypes'][$column] ?? '')));
                $displayMarkup = $this->tabularValueMarkup($childValue, $columnType, 'hasmany:' . (string) $key . ':' . $column);
                $cells .= "                                <td>{$displayMarkup}</td>\n";
            }

            $countBadge = !empty($relation['showCount'])
                ? "<span class=\"badge bg-secondary\"><?= (int) (\$children['{$key}']['count'] ?? 0) ?><?= !empty(\$children['{$key}']['hasMore']) ? '+' : '' ?></span>"
                : '';

            // Il link "View all" riusa l'index del CRUD figlio e il normale
            // filter engine. For foreign keys compatible with a simple GET parameter
            // usa l'URL corto (?film_id=15); in caso contrario usa filters[].
            $parentValue = $this->objectProperty('row', (string) $relation['parentKey']);
            $childTable = (string) $relation['childTable'];
            $foreignKey = (string) $relation['foreignKey'];
            $parentTable = (string) ($config['table'] ?? '');
            $parentTrailLabel = $this->trailLabelExpression($config, 'row', $parentValue);
            $trailExpression = "\App\Libraries\Crud\CrudNavigationTrail::encode(\App\Libraries\Crud\CrudNavigationTrail::append((array) (\$cascadeTrail ?? []), " . var_export($parentTable, true) . ", (string) ({$parentValue} ?? ''), {$parentTrailLabel}))";
            if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $foreignKey) === 1) {
                $contextQueryExpression = "http_build_query([" . var_export($foreignKey, true) . " => {$parentValue} ?? '', '_trail' => {$trailExpression}])";
                $createContextQueryExpression = "http_build_query([" . var_export($foreignKey, true) . " => {$parentValue} ?? '', '_parent_field' => " . var_export($foreignKey, true) . ", '_trail' => {$trailExpression}])";
            } else {
                $foreignKeyExport = var_export($foreignKey, true);
                $contextQueryExpression = "http_build_query(['filters' => [['field' => {$foreignKeyExport}, 'operator' => 'eq', 'value' => {$parentValue} ?? '', 'logic' => 'and']], '_trail' => {$trailExpression}])";
                $createContextQueryExpression = $contextQueryExpression;
            }
            $viewAllUrl = "<?= site_url('{$childTable}') . '?' . {$contextQueryExpression} ?>";
            $viewAllButton = !empty($relation['showViewAllButton'])
                ? "<a href=\"{$viewAllUrl}\" class=\"btn btn-sm btn-outline-primary\" title=\"View all related records\"><i class=\"bi bi-list-ul me-1\" aria-hidden=\"true\"></i> View all</a>"
                : '';
            $newButton = '';
            if (
                !empty($relation['showCreateButton'])
                && !empty($relation['childCreateAllowed'])
                && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $foreignKey) === 1
            ) {
                $newButton = "<a href=\"<?= site_url('{$childTable}/create') . '?' . {$createContextQueryExpression} ?>\" class=\"btn btn-sm btn-primary\" title=\"New related record\"><i class=\"bi bi-plus-circle me-1\" aria-hidden=\"true\"></i> New</a>";
            }

            $actionHeader = !empty($relation['showViewButton']) ? '<th class="d-print-none">Azioni</th>' : '';
            $childPrimaryKey = $this->objectProperty('child', (string) $relation['primaryKey']);
            $actionCell = !empty($relation['showViewButton'])
                ? "<td class=\"d-print-none\"><a href=\"<?= site_url('{$relation['childTable']}/view/' . rawurlencode((string) ({$childPrimaryKey} ?? ''))) . '?' . {$contextQueryExpression} ?>\" class=\"btn btn-sm btn-outline-info\" title=\"Visualizza record\"><i class=\"bi bi-eye\" aria-hidden=\"true\"></i></a></td>"
                : '';

            $title = (string) $relation['title'];
            if (($childTableOccurrences[$childTable] ?? 0) > 1) {
                $title .= ' (' . $foreignKey . ')';
            }

            $output .= $this->templates->render('views/has_many_panel.tpl', [
                'relation_key'  => (string) $key,
                'title'         => htmlspecialchars($title, ENT_QUOTES),
                'icon'          => htmlspecialchars((string) ($relation['icon'] ?? 'bi-diagram-3'), ENT_QUOTES),
                'count_badge'   => $countBadge,
                'new_button'    => $newButton,
                'view_all_button' => $viewAllButton,
                'headers'       => $headers,
                'cells'         => $cells,
                'action_header' => $actionHeader,
                'action_cell'   => $actionCell,
                'limit'         => (string) max(1, (int) ($relation['limit'] ?? 20)),
                'collapsible'   => !empty($relation['collapsible']) ? 'true' : 'false',
                'collapsed'     => !empty($relation['collapsed']) ? 'true' : 'false',
            ]);
        }

        return $output;
    }
    /** Generates a readable label for the current record to use in the cascaded breadcrumb. */
    private function trailLabelExpression(array $config, string $objectVar, string $idExpression): string
    {
        $fields = (array) ($config['fields'] ?? []);
        $table = (string) ($config['table'] ?? 'Record');

        $pairs = [
            ['first_name', 'last_name'],
            ['nome', 'cognome'],
            ['name', 'surname'],
        ];
        foreach ($pairs as [$first, $second]) {
            if (isset($fields[$first], $fields[$second])) {
                $a = $this->objectProperty($objectVar, $first);
                $b = $this->objectProperty($objectVar, $second);
                return "trim((string) ({$a} ?? '') . ' ' . (string) ({$b} ?? '')) ?: " . var_export(Naming::human($table), true) . " . ' #' . (string) ({$idExpression} ?? '')";
            }
        }

        foreach (['nome', 'name', 'titolo', 'title', 'descrizione', 'description', 'label', 'codice', 'code'] as $candidate) {
            if (isset($fields[$candidate])) {
                $value = $this->objectProperty($objectVar, $candidate);
                return "trim((string) ({$value} ?? '')) ?: " . var_export(Naming::human($table), true) . " . ' #' . (string) ({$idExpression} ?? '')";
            }
        }

        foreach ($fields as $name => $field) {
            $type = strtolower((string) ($field['type'] ?? ''));
            if (in_array($type, ['varchar', 'char', 'text', 'tinytext', 'mediumtext'], true) && empty($field['primary'])) {
                $value = $this->objectProperty($objectVar, (string) $name);
                return "trim((string) ({$value} ?? '')) ?: " . var_export(Naming::human($table), true) . " . ' #' . (string) ({$idExpression} ?? '')";
            }
        }

        return var_export(Naming::human($table), true) . " . ' #' . (string) ({$idExpression} ?? '')";
    }

}
