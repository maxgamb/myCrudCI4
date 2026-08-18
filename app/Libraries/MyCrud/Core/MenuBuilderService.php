<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Schema\DbSchema;

/**
 * Prepares and validates Menu Builder configuration.
 *
 * Dalla 2.8.0-dev7 il generatore NON prova più a decidere automaticamente
 * come organizzare il menu. Foreign key e nomi DB descrivono lo schema
 * tecnico, non necessariamente la navigazione dell'applicazione.
 *
 * Lo schema viene quindi usato soltanto per:
 * - elencare i CRUD/tabelle disponibili;
 * - show SQL relations as informational suggestions;
 * - proporre label e icone iniziali non vincolanti.
 *
 * Gruppi, sottogruppi, ordine e assegnazioni sono decisioni esplicite dello
 * sviluppatore nel Menu Builder.
 */
final class MenuBuilderService
{
    private DbSchema $schema;

    public function __construct(?DbSchema $schema = null)
    {
        $this->schema = $schema ?? new DbSchema();
    }

    /**
     * Complete dataset used by the guided Builder.
     *
     * @return array{
     *     items:list<array<string,mixed>>,
     *     related:array<string,list<array<string,string>>>,
     *     relationCount:int
     * }
     */
    public function builderData(): array
    {
        $schema = $this->schema->getSchemaInfo();
        $tables = array_keys((array) ($schema['tables'] ?? []));
        $relations = (array) ($schema['relations'] ?? []);

        sort($tables, SORT_NATURAL | SORT_FLAG_CASE);

        $related = [];
        foreach ($tables as $table) {
            $related[$table] = [];
        }

        foreach ($relations as $relation) {
            $childTable = trim((string) ($relation['childTable'] ?? ''));
            $childColumn = trim((string) ($relation['childColumn'] ?? ''));
            $parentTable = trim((string) ($relation['parentTable'] ?? ''));
            $parentColumn = trim((string) ($relation['parentColumn'] ?? ''));

            if ($childTable === '' || $parentTable === '') {
                continue;
            }

            if (isset($related[$childTable])) {
                $related[$childTable][] = [
                    'table' => $parentTable,
                    'direction' => 'parent',
                    'hint' => $childColumn . ' → ' . $parentTable . '.' . $parentColumn,
                ];
            }

            if (isset($related[$parentTable])) {
                $related[$parentTable][] = [
                    'table' => $childTable,
                    'direction' => 'child',
                    'hint' => $childTable . '.' . $childColumn . ' → ' . $parentColumn,
                ];
            }
        }

        foreach ($related as $table => $rows) {
            $seen = [];
            $unique = [];

            foreach ($rows as $row) {
                $key = strtolower((string) ($row['table'] ?? ''))
                    . '|'
                    . strtolower((string) ($row['direction'] ?? ''));

                if ($key === '|' || isset($seen[$key])) {
                    continue;
                }

                $seen[$key] = true;
                $unique[] = $row;
            }

            usort($unique, static fn (array $a, array $b): int =>
                [(string) ($a['table'] ?? ''), (string) ($a['direction'] ?? '')]
                <=>
                [(string) ($b['table'] ?? ''), (string) ($b['direction'] ?? '')]
            );

            $related[$table] = $unique;
        }

        $items = [];
        foreach ($tables as $index => $table) {
            $relationRows = (array) ($related[$table] ?? []);

            $items[] = [
                'table' => $table,
                'label' => Naming::human($table),
                'route' => $table,
                'icon' => $this->suggestedIcon($table),

                // None aggregazione automatica: tutte le voci nascono
                // volutamente nell'area "Non assegnate" del Builder.
                'group' => '',
                'groupIcon' => 'bi-folder2-open',
                'subgroup' => '',
                'groupOrder' => 0,
                'subgroupOrder' => 0,
                'order' => ($index + 1) * 10,
                'favorite' => false,

                // Informazioni usate solo dall'interfaccia come suggerimenti.
                'relatedTables' => array_values(array_map(
                    static fn (array $row): string => (string) ($row['table'] ?? ''),
                    $relationRows
                )),
                'relationHints' => array_values(array_map(
                    static fn (array $row): string => (string) ($row['hint'] ?? ''),
                    $relationRows
                )),
            ];
        }

        return [
            'items' => $items,
            'related' => $related,
            'relationCount' => count($relations),
        ];
    }

    /**
     * Compatibilità con il codice 2.8 precedente.
     * The name remains available, but items are no longer pre-aggregated.
     *
     * @return list<array<string,mixed>>
     */
    public function suggestedItems(): array
    {
        return $this->builderData()['items'];
    }

    /**
     * Transforms tool POST data into safe runtime configuration.
     * Tabelle e route vengono validate qui prima della generazione del PHP.
     */
    public function fromRequest(array $post): array
    {
        $type = in_array(($post['menuType'] ?? 'vertical'), ['vertical', 'horizontal'], true)
            ? (string) $post['menuType']
            : 'vertical';

        $allowedTables = array_column($this->suggestedItems(), 'table');
        $groups = [];

        foreach ((array) ($post['items'] ?? []) as $position => $row) {
            if (empty($row['enabled'])) {
                continue;
            }

            $table = trim((string) ($row['table'] ?? ''));

            // An item with an empty table is a manual route. A table-bound item
            // al DB, invece, deve appartenere allo schema corrente.
            if ($table !== '' && !in_array($table, $allowedTables, true)) {
                continue;
            }

            $route = $this->safeRoute((string) ($row['route'] ?? $table));
            if ($route === '') {
                continue;
            }

            $label = $this->plainText((string) (
                $row['label']
                ?? ($table !== '' ? Naming::human($table) : 'Voce')
            ));

            $groupLabel = $this->plainText((string) ($row['group'] ?? ''));
            if ($groupLabel === '') {
                // Una voce abilitata deve appartenere a un gruppo. Il fallback
                // is used only for incomplete/tampered POST data and is not used for
                // aggregare automaticamente il Builder.
                $groupLabel = 'Principale';
            }

            $subgroupLabel = $this->plainText((string) ($row['subgroup'] ?? ''));
            $icon = $this->safeIcon((string) ($row['icon'] ?? 'bi-link-45deg'));
            $groupIcon = $this->safeIcon((string) ($row['groupIcon'] ?? 'bi-folder2-open'));
            $groupOrder = max(0, min(9999, (int) ($row['groupOrder'] ?? 10)));
            $subgroupOrder = max(0, min(9999, (int) ($row['subgroupOrder'] ?? 10)));
            $itemOrder = max(0, min(999999, (int) ($row['order'] ?? (($position + 1) * 10))));
            $favorite = !empty($row['favorite']);
            $groupKey = strtolower($groupLabel);

            if (!isset($groups[$groupKey])) {
                $groups[$groupKey] = [
                    'label' => $groupLabel,
                    'icon' => $groupIcon,
                    'order' => $groupOrder,
                    'items' => [],
                    'subgroups' => [],
                ];
            } else {
                $groups[$groupKey]['order'] = min((int) $groups[$groupKey]['order'], $groupOrder);
                if (($groups[$groupKey]['icon'] ?? '') === 'bi-folder2-open' && $groupIcon !== 'bi-folder2-open') {
                    $groups[$groupKey]['icon'] = $groupIcon;
                }
            }

            $item = [
                'label' => $label !== '' ? $label : $route,
                'route' => $route,
                'icon' => $icon,
                'order' => $itemOrder,
                'favorite' => $favorite,
                'table' => $table,
            ];

            if ($subgroupLabel === '') {
                $groups[$groupKey]['items'][] = $item;
                continue;
            }

            $subgroupKey = strtolower($subgroupLabel);
            if (!isset($groups[$groupKey]['subgroups'][$subgroupKey])) {
                $groups[$groupKey]['subgroups'][$subgroupKey] = [
                    'label' => $subgroupLabel,
                    'order' => $subgroupOrder,
                    'items' => [],
                ];
            } else {
                $groups[$groupKey]['subgroups'][$subgroupKey]['order'] = min(
                    (int) $groups[$groupKey]['subgroups'][$subgroupKey]['order'],
                    $subgroupOrder
                );
            }

            $groups[$groupKey]['subgroups'][$subgroupKey]['items'][] = $item;
        }

        $groups = array_values($groups);

        foreach ($groups as &$group) {
            usort($group['items'], static fn (array $a, array $b): int =>
                [$a['order'], $a['label']] <=> [$b['order'], $b['label']]
            );

            $group['subgroups'] = array_values((array) ($group['subgroups'] ?? []));
            foreach ($group['subgroups'] as &$subgroup) {
                usort($subgroup['items'], static fn (array $a, array $b): int =>
                    [$a['order'], $a['label']] <=> [$b['order'], $b['label']]
                );
            }
            unset($subgroup);

            usort($group['subgroups'], static fn (array $a, array $b): int =>
                [$a['order'], $a['label']] <=> [$b['order'], $b['label']]
            );
        }
        unset($group);

        usort($groups, static fn (array $a, array $b): int =>
            [$a['order'], $a['label']] <=> [$b['order'], $b['label']]
        );

        return [
            'type' => $type,
            'search' => !array_key_exists('enableSearch', $post) || !empty($post['enableSearch']),
            'favorites' => !array_key_exists('showFavorites', $post) || !empty($post['showFavorites']),
            'groups' => $groups,
        ];
    }

    private function suggestedIcon(string $table): string
    {
        $name = strtolower($table);
        $map = [
            'agenda' => 'bi-calendar3',
            'prenot' => 'bi-calendar-check',
            'client' => 'bi-people',
            'agenz' => 'bi-building',
            'hotel' => 'bi-buildings',
            'camera' => 'bi-door-open',
            'room' => 'bi-door-open',
            'cont' => 'bi-journal-text',
            'fattur' => 'bi-receipt',
            'invoice' => 'bi-receipt',
            'pagament' => 'bi-credit-card',
            'payment' => 'bi-credit-card',
            'prodott' => 'bi-box-seam',
            'product' => 'bi-box-seam',
            'staff' => 'bi-person-badge',
            'utent' => 'bi-person-gear',
            'user' => 'bi-person-gear',
            'log' => 'bi-clock-history',
        ];

        foreach ($map as $needle => $icon) {
            if (str_contains($name, $needle)) {
                return $icon;
            }
        }

        return 'bi-table';
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
