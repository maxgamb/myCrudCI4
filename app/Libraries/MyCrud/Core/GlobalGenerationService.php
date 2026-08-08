<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
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

                // QUICK: per le FK usiamo un default completamente deterministico.
                // Il database ci dice con certezza quale colonna del padre viene
                // referenziata, ma non quale campo sia semanticamente descrittivo.
                // Quindi la Quick mostra inizialmente il valore della chiave
                // referenziata; eventuali label/template leggibili restano una
                // scelta esplicita dello sviluppatore nel Builder.
                $config = $this->applyQuickForeignKeyDefaults($config);

                $config['architecture'] = $architecture;
                $config['features'] = $this->featuresForArchitecture($architecture, $config);

                $configPath = null;
                if (!$dryRun) {
                    // 2.8: ogni CRUD realmente generato dalla Quick globale
                    // diventa riproducibile tramite una config versionabile.
                    $configPath = (new CrudConfigRepository())->save($table, $config);
                }

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
                    'configPath' => $configPath,
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

    /**
     * Applica i default specifici della generazione Quick alle relazioni belongsTo.
     *
     * La Quick non prova a dedurre un campo descrittivo da nomi come `name`,
     * `descrizione` o dal primo varchar: usa sempre la colonna realmente
     * referenziata dalla foreign key. Il Builder potrà poi sostituirla con un
     * displayField, un displayTemplate e le opzioni di navigazione esplicitamente scelte.
     *
     * @param array<string, mixed> $config
     * @return array<string, mixed>
     */
    private function applyQuickForeignKeyDefaults(array $config): array
    {
        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            if (!is_array($relation)) {
                continue;
            }

            $parentKey = trim((string) ($relation['parentKey'] ?? ''));
            if ($parentKey === '') {
                continue;
            }

            // Relazione globale usata da Model/View generator.
            $config['relations']['belongsTo'][$fieldName]['displayField'] = $parentKey;
            $config['relations']['belongsTo'][$fieldName]['displayTemplate'] = '';

            if (!isset($config['fields'][$fieldName]) || !is_array($config['fields'][$fieldName])) {
                continue;
            }

            // Configurazione persistente del singolo campo.
            $config['fields'][$fieldName]['relationDisplayField'] = $parentKey;
            $config['fields'][$fieldName]['relationDisplayTemplate'] = '';

            // Quick non decide la navigazione applicativa. Queste opzioni
            // restano esplicitamente disattivate finché lo sviluppatore non
            // le abilita dal Builder.
            $config['fields'][$fieldName]['relationNavigation'] = [
                'quickFilter' => false,
                'parentLink' => false,
                'acceptContext' => false,
                'createParentLink' => false,
            ];

            if (!empty($config['fields'][$fieldName]['foreignKey'])
                && is_array($config['fields'][$fieldName]['foreignKey'])) {
                $config['fields'][$fieldName]['foreignKey']['displayField'] = $parentKey;
                $config['fields'][$fieldName]['foreignKey']['displayTemplate'] = '';
            }
        }

        return $config;
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
