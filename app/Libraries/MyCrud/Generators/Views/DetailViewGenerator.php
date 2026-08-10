<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

final class DetailViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        $rows = '';

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

            if (is_array($relation)) {
                $alias = (string) ($relation['alias'] ?? ($name . '__label'));
                $parentTable = (string) ($relation['parentTable'] ?? '');
                $rowLabel = $this->objectProperty('row', $alias);
                $displayMarkup = "<?= esc({$rowLabel} ?? {$rowValue} ?? '') ?>";
                if (!empty($field['relationNavigation']['parentLink']) && $parentTable !== '') {
                    $valueMarkup = "<a href=\"<?= site_url('{$parentTable}/view/' . rawurlencode((string) ({$rowValue} ?? ''))) ?>\" class=\"text-decoration-none\">{$displayMarkup}</a>";
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

        $table = (string) $config['table'];
        $primaryKey = (string) ($config['primaryKey'] ?? 'id');
        $rowId = $this->objectProperty('row', $primaryKey);
        $writable = !empty($config['features']['writable']);

        $newAction = $writable ? <<<PHP
        <a href="<?= site_url('{$table}/create') . (\$navigationQuery ?? '') ?>" class="btn btn-primary" title="Nuovo record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo
        </a>
PHP : '';

        $writeActions = $writable ? <<<PHP
        <a href="<?= site_url('{$table}/edit/' . rawurlencode((string) ({$rowId} ?? ''))) . (\$navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Modifica record">
            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i> Modifica
        </a>
        <form method="post" action="<?= site_url('{$table}/delete/' . rawurlencode((string) ({$rowId} ?? ''))) . (\$navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
            <?= csrf_field() ?>
            <?php foreach ((array) (\$navigationContext ?? []) as \$contextField => \$contextValue): ?>
                <input type="hidden" name="_context[<?= esc((string) \$contextField) ?>]" value="<?= esc((string) \$contextValue) ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-outline-danger" title="Cancella record">
                <i class="bi bi-trash me-1" aria-hidden="true"></i> Cancella
            </button>
        </form>
PHP : '';

        $toolbarActions = <<<PHP
{$newAction}        <a href="<?= site_url('{$table}') . (\$navigationQuery ?? '') ?>" class="btn btn-outline-secondary" title="Torna alla lista">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> Lista
        </a>
{$writeActions}        <button type="button" class="btn btn-outline-secondary" onclick="window.print()" title="Stampa dettaglio">
            <i class="bi bi-printer me-1" aria-hidden="true"></i> Stampa
        </button>
PHP;

        return $this->templates->render('views/detail.tpl', [
            'table'           => $table,
            'route'           => $table,
            'rows'            => $rows,
            'panels'          => $this->buildHasManyPanels($config),
            'toolbar_actions' => $toolbarActions,
        ]);
    }

    private function buildHasManyPanels(array $config): string
    {
        $output = '';

        // Una tabella figlia può puntare più volte allo stesso padre tramite FK
        // diverse (es. film.language_id e film.original_language_id). In quel
        // caso il titolo tecnico della FK evita pannelli indistinguibili.
        $childTableOccurrences = [];
        foreach ($config['relationsConfig']['hasMany'] ?? [] as $relation) {
            if (empty($relation['enabled']) || empty($relation['childTable'])) {
                continue;
            }

            $childTable = (string) $relation['childTable'];
            $childTableOccurrences[$childTable] = ($childTableOccurrences[$childTable] ?? 0) + 1;
        }

        foreach ($config['relationsConfig']['hasMany'] ?? [] as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            // Le relazioni devono provenire dallo schema corrente. Una config
            // legacy/stale incompleta viene ignorata invece di interrompere la
            // generazione della pagina di dettaglio.
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

            // Il link "Vedi tutti" riusa l'index del CRUD figlio e il normale
            // motore filtri. Per FK compatibili con un parametro GET semplice
            // usa l'URL corto (?film_id=15); in caso contrario usa filters[].
            $parentValue = $this->objectProperty('row', (string) $relation['parentKey']);
            $childTable = (string) $relation['childTable'];
            $foreignKey = (string) $relation['foreignKey'];
            if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $foreignKey) === 1) {
                $contextQueryExpression = "http_build_query([" . var_export($foreignKey, true) . " => {$parentValue} ?? ''])";
            } else {
                $foreignKeyExport = var_export($foreignKey, true);
                $contextQueryExpression = "http_build_query(['filters' => [['field' => {$foreignKeyExport}, 'operator' => 'eq', 'value' => {$parentValue} ?? '', 'logic' => 'and']]])";
            }
            $viewAllUrl = "<?= site_url('{$childTable}') . '?' . {$contextQueryExpression} ?>";
            $newButton = '';
            if (
                !empty($relation['childCreateAllowed'])
                && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $foreignKey) === 1
            ) {
                $newButton = "<a href=\"<?= site_url('{$childTable}/create') . '?' . {$contextQueryExpression} ?>\" class=\"btn btn-sm btn-primary\" title=\"Nuovo record collegato\"><i class=\"bi bi-plus-circle me-1\" aria-hidden=\"true\"></i> Nuovo</a>";
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
                'headers'       => $headers,
                'cells'         => $cells,
                'action_header' => $actionHeader,
                'action_cell'   => $actionCell,
                'limit'         => (string) max(1, (int) ($relation['limit'] ?? 20)),
                'view_all_url'  => $viewAllUrl,
            ]);
        }

        return $output;
    }
}
