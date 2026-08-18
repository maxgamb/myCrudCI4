<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Dashboard;

use Config\MyCrud;
use RuntimeException;

/**
 * Persistent Dashboard configuration repository.
 *
 * Dashboard configuration stores only application choices. CRUD/table schema
 * remains authoritative and is resolved again by the generated dashboard code.
 */
final class DashboardConfigRepository
{
    private string $directory;

    public function __construct(?string $directory = null, ?MyCrud $settings = null)
    {
        /** @var MyCrud $settings */
        $settings ??= config('MyCrud');
        $this->directory = rtrim(
            $directory ?? $settings->dashboardConfigPath,
            DIRECTORY_SEPARATOR
        ) . DIRECTORY_SEPARATOR;
    }

    public function save(string $name, array $config): string
    {
        $name = $this->assertName($name);
        $this->ensureDirectory();

        $title = trim((string) ($config['title'] ?? 'Application Dashboard'));
        if ($title === '') {
            $title = 'Application Dashboard';
        }

        $route = trim((string) ($config['route'] ?? 'dashboard'), '/');
        if ($route === '' || preg_match('#^[A-Za-z0-9/_-]+$#D', $route) !== 1) {
            throw new RuntimeException('Invalid Dashboard route.');
        }

        $globalDateFilter = [
            'enabled' => !empty($config['globalDateFilter']['enabled']),
            'label' => mb_substr(
                trim((string) ($config['globalDateFilter']['label'] ?? 'Period')),
                0,
                80
            ) ?: 'Period',
        ];

        $globalFilters = [];
        foreach ((array) ($config['globalFilters'] ?? []) as $filter) {
            if (!is_array($filter) || empty($filter['enabled'])) {
                continue;
            }

            $id = trim((string) ($filter['id'] ?? ''));
            if ($id === '' || preg_match('/^[A-Za-z][A-Za-z0-9_]*$/D', $id) !== 1) {
                continue;
            }

            $operator = (string) ($filter['operator'] ?? 'eq');
            if (!in_array($operator, ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'contains', 'starts_with'], true)) {
                $operator = 'eq';
            }

            $inputType = (string) ($filter['inputType'] ?? 'text');
            if (!in_array($inputType, ['text', 'number'], true)) {
                $inputType = 'text';
            }

            $globalFilters[] = [
                'enabled' => true,
                'id' => $id,
                'label' => mb_substr(trim((string) ($filter['label'] ?? $id)), 0, 80) ?: $id,
                'operator' => $operator,
                'inputType' => $inputType,
            ];
        }

        $persistent = [
            'name' => $name,
            'title' => $title,
            'route' => $route,
            'globalDateFilter' => $globalDateFilter,
            'globalFilters' => $globalFilters,
            'widgets' => array_values(array_map(
                static fn (array $widget): array => [
                    'id' => (string) ($widget['id'] ?? ''),
                    'type' => in_array(
                        (string) ($widget['type'] ?? ''),
                        ['kpi_count', 'kpi_aggregate', 'grouped_chart', 'recent', 'quick_link'],
                        true
                    ) ? (string) $widget['type'] : 'kpi_count',
                    'title' => trim((string) ($widget['title'] ?? '')),
                    'table' => trim((string) ($widget['table'] ?? '')),
                    'operation' => strtoupper(trim((string) ($widget['operation'] ?? 'COUNT'))),
                    'valueField' => trim((string) ($widget['valueField'] ?? '')),
                    'groupField' => trim((string) ($widget['groupField'] ?? '')),
                    'chartType' => in_array((string) ($widget['chartType'] ?? ''), ['bar', 'line', 'doughnut'], true)
                        ? (string) $widget['chartType']
                        : 'bar',
                    'dateGroup' => in_array(
                        (string) ($widget['dateGroup'] ?? ''),
                        ['raw', 'day', 'month', 'year'],
                        true
                    ) ? (string) $widget['dateGroup'] : 'raw',
                    'recentFields' => array_values(array_filter(
                        array_map(
                            static fn ($field): string => trim((string) $field),
                            is_array($widget['recentFields'] ?? null) ? $widget['recentFields'] : []
                        ),
                        static fn (string $field): bool => $field !== ''
                    )),
                    'decimals' => max(0, min(4, (int) ($widget['decimals'] ?? 0))),
                    'prefix' => mb_substr(trim((string) ($widget['prefix'] ?? '')), 0, 12),
                    'suffix' => mb_substr(trim((string) ($widget['suffix'] ?? '')), 0, 12),
                    'filterField' => trim((string) ($widget['filterField'] ?? '')),
                    'filterOperator' => in_array(
                        (string) ($widget['filterOperator'] ?? ''),
                        ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'contains', 'starts_with'],
                        true
                    ) ? (string) $widget['filterOperator'] : 'eq',
                    'filterValue' => mb_substr(trim((string) ($widget['filterValue'] ?? '')), 0, 255),
                    'globalDateField' => trim((string) ($widget['globalDateField'] ?? '')),
                    'globalFilterFields' => array_filter(
                        array_map(
                            static fn ($field): string => trim((string) $field),
                            is_array($widget['globalFilterFields'] ?? null)
                                ? $widget['globalFilterFields']
                                : []
                        ),
                        static fn (string $field): bool => $field !== ''
                    ),
                    'limit' => max(1, min(50, (int) ($widget['limit'] ?? 5))),
                    'width' => max(1, min(12, (int) ($widget['width'] ?? 4))),
                ],
                array_filter(
                    (array) ($config['widgets'] ?? []),
                    static fn ($widget): bool => is_array($widget) && trim((string) ($widget['table'] ?? '')) !== ''
                )
            )),
        ];

        $content = "<?php\n\ndeclare(strict_types=1);\n\n"
            . "/** myCrudCI4 persistent Dashboard configuration. */\n"
            . "return " . var_export($persistent, true) . ";\n";

        $path = $this->path($name);
        $tmp = $path . '.tmp-' . bin2hex(random_bytes(4));

        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new RuntimeException('Unable to save Dashboard configuration.');
        }
        if (!rename($tmp, $path)) {
            @unlink($tmp);
            throw new RuntimeException('Unable to publish Dashboard configuration.');
        }

        return $path;
    }

    public function load(string $name = 'main'): ?array
    {
        $path = $this->path($this->assertName($name));
        if (!is_file($path)) {
            return null;
        }

        $config = (static fn (string $file): mixed => require $file)($path);
        if (!is_array($config)) {
            throw new RuntimeException('Invalid Dashboard configuration: ' . $path);
        }

        return $config;
    }

    /** @return list<string> */
    public function names(): array
    {
        if (!is_dir($this->directory)) {
            return [];
        }

        $names = array_map(
            static fn (string $path): string => basename($path, '.php'),
            glob($this->directory . '*.php') ?: []
        );
        sort($names, SORT_STRING);

        return array_values(array_unique($names));
    }

    public function pathFor(string $name = 'main'): string
    {
        return $this->path($this->assertName($name));
    }

    private function path(string $name): string
    {
        return $this->directory . $name . '.php';
    }

    private function ensureDirectory(): void
    {
        if (!is_dir($this->directory)
            && !mkdir($this->directory, 0755, true)
            && !is_dir($this->directory)
        ) {
            throw new RuntimeException('Unable to create Dashboard configuration directory.');
        }
    }

    private function assertName(string $name): string
    {
        $name = trim($name);
        if ($name === '' || preg_match('/^[A-Za-z][A-Za-z0-9_-]*$/D', $name) !== 1) {
            throw new RuntimeException('Invalid Dashboard name.');
        }
        return $name;
    }
}
