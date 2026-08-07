<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Schema\DbSchema;

/**
 * Prepara e valida la configurazione del Menu Builder lato generatore.
 *
 * Le relazioni SQL forniscono solo suggerimenti. Nessuna gerarchia viene
 * imposta automaticamente al sito: la configurazione finale è sempre quella
 * confermata dallo sviluppatore nel tool.
 */
final class MenuBuilderService
{
    private DbSchema $schema;

    public function __construct(?DbSchema $schema = null)
    {
        $this->schema = $schema ?? new DbSchema();
    }

    /** @return list<array<string, mixed>> */
    public function suggestedItems(): array
    {
        $schema = $this->schema->getSchemaInfo();
        $tables = array_keys((array) ($schema['tables'] ?? []));
        $relations = (array) ($schema['relations'] ?? []);

        $parentsByChild = [];
        $parentTables = [];
        foreach ($relations as $relation) {
            $childTable = (string) ($relation['childTable'] ?? '');
            $childColumn = (string) ($relation['childColumn'] ?? '');
            $parentTable = (string) ($relation['parentTable'] ?? '');
            $parentColumn = (string) ($relation['parentColumn'] ?? '');

            if ($childTable === '' || $parentTable === '') {
                continue;
            }

            $parentTables[$parentTable] = true;
            $parentsByChild[$childTable][] = [
                'table' => $parentTable,
                'hint' => $childColumn . ' → ' . $parentTable . '.' . $parentColumn,
            ];
        }

        $groupOrders = [];
        $itemOrders = [];
        $items = [];

        foreach ($tables as $table) {
            $parent = $parentsByChild[$table][0] ?? null;
            if ($parent !== null) {
                $group = Naming::human((string) $parent['table']);
            } elseif (isset($parentTables[$table])) {
                // Una tabella padre diventa anche intestazione naturale del
                // proprio gruppo, così padre e figli sono proposti insieme.
                $group = Naming::human($table);
            } else {
                $group = 'Principale';
            }

            if (!isset($groupOrders[$group])) {
                $groupOrders[$group] = (count($groupOrders) + 1) * 10;
                $itemOrders[$group] = 0;
            }

            $itemOrders[$group] += 10;

            $items[] = [
                'table' => $table,
                'label' => Naming::human($table),
                'route' => $table,
                'icon' => 'bi-table',
                'group' => $group,
                'groupOrder' => $groupOrders[$group],
                'order' => $itemOrders[$group],
                'relationHint' => (string) ($parent['hint'] ?? ''),
            ];
        }

        return $items;
    }

    /**
     * Trasforma il POST del tool in una configurazione runtime sicura.
     * Tabelle e route vengono validate qui, prima che MenuGenerator produca PHP.
     */
    public function fromRequest(array $post): array
    {
        $type = in_array(($post['menuType'] ?? 'vertical'), ['vertical', 'horizontal'], true)
            ? (string) $post['menuType']
            : 'vertical';

        $allowedTables = array_column($this->suggestedItems(), 'table');
        $groups = [];

        foreach ((array) ($post['items'] ?? []) as $row) {
            if (empty($row['enabled'])) {
                continue;
            }

            $table = trim((string) ($row['table'] ?? ''));
            if ($table !== '' && !in_array($table, $allowedTables, true)) {
                continue;
            }

            $route = $this->safeRoute((string) ($row['route'] ?? $table));
            if ($route === '') {
                continue;
            }

            $label = $this->plainText((string) ($row['label'] ?? ($table !== '' ? Naming::human($table) : 'Voce')));
            $groupLabel = $this->plainText((string) ($row['group'] ?? 'Principale')) ?: 'Principale';
            $icon = $this->safeIcon((string) ($row['icon'] ?? 'bi-link-45deg'));
            $groupOrder = max(0, min(9999, (int) ($row['groupOrder'] ?? 10)));
            $itemOrder = max(0, min(9999, (int) ($row['order'] ?? 10)));
            $groupKey = strtolower($groupLabel);

            if (!isset($groups[$groupKey])) {
                $groups[$groupKey] = [
                    'label' => $groupLabel,
                    'icon' => 'bi-folder2-open',
                    'order' => $groupOrder,
                    'items' => [],
                ];
            } else {
                $groups[$groupKey]['order'] = min((int) $groups[$groupKey]['order'], $groupOrder);
            }

            $groups[$groupKey]['items'][] = [
                'label' => $label !== '' ? $label : $route,
                'route' => $route,
                'icon' => $icon,
                'order' => $itemOrder,
                // Il nome tabella resta disponibile come metadato utile allo
                // sviluppatore, ma non viene usato per alterare la route.
                'table' => $table,
            ];
        }

        $groups = array_values($groups);
        foreach ($groups as &$group) {
            usort($group['items'], static fn (array $a, array $b): int =>
                [$a['order'], $a['label']] <=> [$b['order'], $b['label']]
            );
        }
        unset($group);

        usort($groups, static fn (array $a, array $b): int =>
            [$a['order'], $a['label']] <=> [$b['order'], $b['label']]
        );

        return [
            'type' => $type,
            'groups' => $groups,
        ];
    }

    private function safeRoute(string $route): string
    {
        $route = trim($route, " \t\n\r\0\x0B/");

        return preg_match('/^[a-zA-Z0-9_\-\/]+$/', $route) === 1 ? $route : '';
    }

    private function safeIcon(string $icon): string
    {
        $icon = trim($icon);

        return preg_match('/^bi-[a-z0-9-]+$/', $icon) === 1 ? $icon : 'bi-link-45deg';
    }

    private function plainText(string $value): string
    {
        $value = trim(strip_tags($value));

        return substr($value, 0, 120);
    }
}
