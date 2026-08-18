<?php

declare(strict_types=1);

namespace App\Controllers\MyCrud;

use App\Controllers\BaseController;
use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Dashboard\DashboardConfigRepository;
use App\Libraries\MyCrud\Dashboard\DashboardGenerator;
use App\Libraries\MyCrud\Dashboard\DashboardPublishService;
use Throwable;

final class DashboardBuilderController extends BaseController
{
    public function index(): string
    {
        $repository = new DashboardConfigRepository();
        $config = $repository->load('main') ?? [
            'name' => 'main',
            'title' => 'Application Dashboard',
            'route' => 'dashboard',
            'globalDateFilter' => [
                'enabled' => false,
                'label' => 'Period',
            ],
            'globalFilters' => [],
            'widgets' => [],
        ];

        $tables = (new CrudConfigRepository())->tables();

        return view('mycrud/dashboard_builder', [
            'title' => 'Dashboard Builder',
            'dashboard' => $config,
            'tables' => $tables,
            'tableMeta' => $this->tableMeta($tables),
        ]);
    }

    public function save()
    {
        try {
            $config = $this->configFromPost();
            $path = (new DashboardConfigRepository())->save('main', $config);

            return redirect()
                ->to(site_url('mycrud/dashboard'))
                ->with('message', 'Dashboard configuration saved: ' . $path);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function generate()
    {
        try {
            $config = $this->configFromPost();
            (new DashboardConfigRepository())->save('main', $config);
            $report = (new DashboardGenerator())->generate($config, true);

            return redirect()
                ->to(site_url('mycrud/dashboard'))
                ->with(
                    'message',
                    sprintf(
                        'Dashboard generated in app/Generated/: %d files, %d widgets.',
                        count((array) ($report['files'] ?? [])),
                        (int) ($report['widgets'] ?? 0)
                    )
                );
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function publish()
    {
        try {
            $force = (bool) $this->request->getPost('force');
            $rows = (new DashboardPublishService())->publish($force, false);
            $published = count(array_filter($rows, static fn (string $status): bool => $status === 'published'));

            return redirect()
                ->to(site_url('mycrud/dashboard'))
                ->with('message', 'Dashboard publish complete. Files published: ' . $published . '.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param list<string> $tables
     * @return array<string,array{
     *   fields:list<string>,
     *   numericFields:list<string>,
     *   labels:array<string,string>,
     *   recentFields:list<string>,
     *   dateFields:list<string>,
     *   relationFields:array<string,array{label:string,alias:string}>,
     *   primaryKey:string
     * }>
     */
    private function tableMeta(array $tables): array
    {
        $service = new CrudConfigurationService();
        $meta = [];

        foreach ($tables as $table) {
            try {
                $resolved = $service->resolve((string) $table, true);
                $config = (array) ($resolved['config'] ?? []);
                $fields = [];
                $numericFields = [];
                $labels = [];
                $recentFields = [];
                $dateFields = [];
                $relationFields = [];

                foreach ((array) ($config['fields'] ?? []) as $name => $field) {
                    $name = (string) ($field['name'] ?? $name);
                    if ($name === '' || !empty($field['ui']['sensitive'])) {
                        continue;
                    }

                    $fields[] = $name;
                    $labels[$name] = trim((string) ($field['label'] ?? ''))
                        ?: ucwords(str_replace('_', ' ', $name));

                    if (!empty($field['ui']['visibleIndex'])) {
                        $recentFields[] = $name;
                    }

                    $type = strtolower((string) ($field['type'] ?? ''));

                    if (in_array($type, ['date', 'datetime', 'timestamp'], true)) {
                        $dateFields[] = $name;
                    }

                    if (in_array($type, [
                        'tinyint', 'smallint', 'mediumint', 'int', 'integer', 'bigint',
                        'decimal', 'numeric', 'float', 'double', 'real',
                    ], true)) {
                        $numericFields[] = $name;
                    }
                }

                foreach ((array) ($config['relations']['belongsTo'] ?? []) as $foreignKey => $relation) {
                    $foreignKey = (string) $foreignKey;
                    if ($foreignKey === '' || !in_array($foreignKey, $fields, true)) {
                        continue;
                    }

                    $label = (string) ($labels[$foreignKey] ?? ucwords(str_replace('_', ' ', $foreignKey)));
                    $label = preg_replace('/\s+Id$/i', '', $label) ?: $label;
                    $relationFields[$foreignKey] = [
                        'label' => $label,
                        'alias' => (string) ($relation['alias'] ?? ($foreignKey . '__label')),
                    ];
                    $labels[$foreignKey] = $label;
                }

                if ($recentFields === []) {
                    $recentFields = array_slice($fields, 0, 4);
                }

                $meta[(string) $table] = [
                    'fields' => array_values(array_unique($fields)),
                    'numericFields' => array_values(array_unique($numericFields)),
                    'labels' => $labels,
                    'recentFields' => array_slice(array_values(array_unique($recentFields)), 0, 6),
                    'dateFields' => array_values(array_unique($dateFields)),
                    'relationFields' => $relationFields,
                    'primaryKey' => (string) ($config['primaryKey'] ?? 'id'),
                ];
            } catch (Throwable) {
                $meta[(string) $table] = [
                    'fields' => [],
                    'numericFields' => [],
                    'labels' => [],
                    'recentFields' => [],
                    'dateFields' => [],
                    'relationFields' => [],
                    'primaryKey' => 'id',
                ];
            }
        }

        return $meta;
    }

    private function configFromPost(): array
    {
        $widgets = $this->request->getPost('widgets');
        $order = $this->request->getPost('widgetOrder');
        $widgets = is_array($widgets) ? $widgets : [];
        $order = is_array($order) ? $order : array_keys($widgets);

        $ordered = [];
        foreach ($order as $id) {
            $id = (string) $id;
            if (!isset($widgets[$id]) || !is_array($widgets[$id])) {
                continue;
            }
            $row = $widgets[$id];
            $row['id'] = $id;
            $ordered[] = $row;
        }

        $globalFiltersPost = $this->request->getPost('globalFilters');
        $globalFiltersPost = is_array($globalFiltersPost) ? $globalFiltersPost : [];
        $globalFilters = [];

        foreach ($globalFiltersPost as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $globalFilters[] = [
                'enabled' => !empty($filter['enabled']),
                'id' => trim((string) ($filter['id'] ?? '')),
                'label' => trim((string) ($filter['label'] ?? '')),
                'operator' => (string) ($filter['operator'] ?? 'eq'),
                'inputType' => (string) ($filter['inputType'] ?? 'text'),
            ];
        }

        return [
            'name' => 'main',
            'title' => trim((string) $this->request->getPost('title')),
            'route' => trim((string) $this->request->getPost('route')),
            'globalDateFilter' => [
                'enabled' => !empty($this->request->getPost('globalDateEnabled')),
                'label' => trim((string) $this->request->getPost('globalDateLabel')),
            ],
            'globalFilters' => $globalFilters,
            'widgets' => $ordered,
        ];
    }
}
