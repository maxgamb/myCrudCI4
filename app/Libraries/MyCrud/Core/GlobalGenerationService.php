<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use Config\MyCrud;
use InvalidArgumentException;
use Throwable;

/** Coordina la generazione multipla e produce un report uniforme. */
final class GlobalGenerationService
{
    private const ARCHITECTURES = ['basic', 'standard', 'full'];

    public function __construct(
        private readonly ?ConfigBuilder $configBuilder = null,
        private readonly ?CrudGeneratorService $generator = null,
        private readonly ?MyCrud $settings = null
    ) {
    }

    /**
     * @param list<string> $tables
     * @return array<string, mixed>
     */
    public function run(
        array $tables,
        string $architecture,
        bool $force,
        bool $dryRun
    ): array {
        $startedAt = microtime(true);
        $architecture = strtolower(trim($architecture));
        if (!in_array($architecture, self::ARCHITECTURES, true)) {
            throw new InvalidArgumentException('Architettura non valida: ' . $architecture);
        }

        $builder = $this->configBuilder ?? new ConfigBuilder();
        $generator = $this->generator ?? new CrudGeneratorService();

        /** @var MyCrud $settings */
        $settings = $this->settings ?? config('MyCrud');

        $report = [
            'version'      => $settings->version,
            'generatedAt'  => date(DATE_ATOM),
            'architecture' => $architecture,
            'force'        => $force,
            'dryRun'       => $dryRun,
            'tables'       => [],
            'summary'      => [
                'tablesSelected' => count($tables),
                'tablesOk'       => 0,
                'tablesFailed'   => 0,
                'created'        => 0,
                'overwritten'    => 0,
                'skipped'        => 0,
                'planned'        => 0,
                'errors'         => 0,
            ],
        ];

        foreach ($tables as $table) {
            try {
                $config = $builder->buildFromTable($table);
                $config['architecture'] = $architecture;
                $config['features'] = $this->featuresForArchitecture($architecture, $config);

                $result = $dryRun
                    ? $this->plan($config, $force)
                    : $generator->generate($config, $force);

                $files = $this->flattenFiles($result['files'] ?? []);
                $tableSummary = $this->summarizeFiles($files);

                foreach (['created', 'overwritten', 'skipped', 'planned'] as $status) {
                    $report['summary'][$status] += $tableSummary[$status];
                }

                $report['summary']['tablesOk']++;
                $report['tables'][$table] = [
                    'status'  => $dryRun ? 'planned' : 'ok',
                    'summary' => $tableSummary,
                    'files'   => $files,
                ];
            } catch (Throwable $e) {
                $report['summary']['tablesFailed']++;
                $report['summary']['errors']++;
                $report['tables'][$table] = [
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine(),
                ];

                log_message('error', '[myCrudGpt global] {table}: {message}', [
                    'table'   => $table,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        $report['durationSeconds'] = round(microtime(true) - $startedAt, 4);

        return $report;
    }

    /** Costruisce il piano dei file senza scrivere sul filesystem. */
    private function plan(array $config, bool $force): array
    {
        /** @var MyCrud $settings */
        $settings = $this->settings ?? config('MyCrud');
        $root = $settings->generatedStagingPath();
        $table = (string) $config['table'];
        $classes = (array) $config['classes'];

        $paths = [
            'model'      => "Models/{$classes['model']}.php",
            'validation' => "Validation/{$classes['rules']}.php",
            'controller' => "Controllers/{$classes['controller']}.php",
            'routes'     => "Routes/{$table}.php",
            'views'      => [
                'index.php'    => "Views/{$table}/index.php",
                'view.php'     => "Views/{$table}/view.php",
                'create.php'   => "Views/{$table}/create.php",
                'edit.php'     => "Views/{$table}/edit.php",
                '_form.php'    => "Views/{$table}/_form.php",
                '_filters.php' => "Views/{$table}/_filters.php",
                '_table.php'   => "Views/{$table}/_table.php",
            ],
        ];

        if (!empty($config['features']['entity'])) {
            $paths['entity'] = "Entities/{$classes['entity']}.php";
        }
        if (!empty($config['features']['service'])) {
            $paths['service'] = "Services/{$classes['service']}.php";
        }
        if (!empty($config['features']['api'])) {
            $paths['api_validation'] = "Validation/{$classes['apiRules']}.php";
            $paths['api'] = [
                'controller' => "Controllers/Api/V1/{$classes['api']}.php",
                'resource'   => "API/Resources/{$classes['resource']}.php",
            ];
            $paths['openapi'] = "OpenApi/{$table}.yaml";
        }
        if (!empty($config['features']['softDeletes'])) {
            $paths['views']['trash.php'] = "Views/{$table}/trash.php";
        }

        return ['files' => $this->mapPlanPaths($paths, $root, $force)];
    }

    private function mapPlanPaths(array $paths, string $root, bool $force): array
    {
        $mapped = [];

        foreach ($paths as $key => $value) {
            if (is_array($value)) {
                $mapped[$key] = $this->mapPlanPaths($value, $root, $force);
                continue;
            }

            $path = $root . ltrim($value, DIRECTORY_SEPARATOR);
            $exists = is_file($path);
            $mapped[$key] = [
                'status' => $exists && !$force ? 'skipped' : 'planned',
                'action' => $exists ? ($force ? 'overwrite' : 'skip') : 'create',
                'path'   => $path,
            ];
        }

        return $mapped;
    }

    private function flattenFiles(array $files, string $prefix = ''): array
    {
        $flat = [];

        foreach ($files as $key => $value) {
            $name = $prefix === '' ? (string) $key : $prefix . '.' . $key;

            if (is_array($value) && isset($value['status'], $value['path'])) {
                $flat[$name] = $value;
                continue;
            }

            if (is_array($value)) {
                $flat += $this->flattenFiles($value, $name);
            }
        }

        return $flat;
    }

    private function summarizeFiles(array $files): array
    {
        $summary = ['created' => 0, 'overwritten' => 0, 'skipped' => 0, 'planned' => 0];

        foreach ($files as $file) {
            $status = (string) ($file['status'] ?? '');
            if (isset($summary[$status])) {
                $summary[$status]++;
            }
        }

        return $summary;
    }

    private function featuresForArchitecture(string $architecture, array $config): array
    {
        $features = (array) ($config['features'] ?? []);
        $features['entity'] = in_array($architecture, ['standard', 'full'], true);
        $features['service'] = in_array($architecture, ['standard', 'full'], true);
        $features['api'] = $architecture === 'full';
        $features['ajaxList'] = true;
        $features['csvExport'] = true;
        $features['wordExport'] = true;
        $features['datatable'] = false;
        $features['relations'] = array_key_exists('relations', $features) ? !empty($features['relations']) : true;
        $features['exportButtons'] = true;

        if (empty($config['softDelete']['available'])) {
            $features['softDeletes'] = false;
        }

        return $features;
    }
}
