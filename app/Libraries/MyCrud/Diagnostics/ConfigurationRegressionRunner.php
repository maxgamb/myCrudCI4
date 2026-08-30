<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\MyCrudVersion;
use Throwable;

/** Verifies the persistent configuration cycle: snapshot, reload, and merge against a fresh schema. */
final class ConfigurationRegressionRunner
{
    public function run(string $table): DiagnosticReport
    {
        $report = new DiagnosticReport();
        $basePath = rtrim(WRITEPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'mycrud-config-regression-'
            . bin2hex(random_bytes(4));
        $configPath = $basePath . DIRECTORY_SEPARATOR . 'config';
        $legacyPath = $basePath . DIRECTORY_SEPARATOR . 'legacy';

        try {
            $settings = config('MyCrud');
            $versionOk = (string) ($settings->version ?? '') === MyCrudVersion::VERSION;
            $report->add(new DiagnosticResult(
                'Centralized version',
                $versionOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $versionOk
                    ? 'Generator version read from the single constant ' . MyCrudVersion::VERSION . '.'
                    : 'Config\\MyCrud and MyCrudVersion do not report the same version.'
            ));

            $builder = new ConfigBuilder();
            $base = $builder->buildFromTable($table);
            $repository = new CrudConfigRepository($configPath, $legacyPath);

            $test = $base;
            $test['architecture'] = 'standard';
            $firstField = array_key_first((array) ($test['fields'] ?? []));
            if ($firstField !== null) {
                $test['fields'][$firstField]['label'] = 'Persistent test';
            }

            $firstRelationField = null;
            foreach ((array) ($test['fields'] ?? []) as $candidateName => $candidateField) {
                if (!empty($candidateField['foreignKey'])) {
                    $firstRelationField = (string) $candidateName;
                    $available = array_values((array) ($candidateField['foreignKey']['availableDisplayFields'] ?? []));
                    $display = (string) ($candidateField['relationDisplayField'] ?? $candidateField['foreignKey']['displayField'] ?? '');
                    if ($available !== []) {
                        $display = (string) $available[0];
                    }
                    $test['fields'][$firstRelationField]['relationDisplayField'] = $display;
                    $test['fields'][$firstRelationField]['relationDisplayTemplate'] = $display !== '' ? '{' . $display . '}' : '';
                    $test['fields'][$firstRelationField]['relationNavigation'] = [
                        'quickFilter' => true,
                        'parentLink' => true,
                        'acceptContext' => true,
                        'createParentLink' => false,
                    ];
                    break;
                }
            }

            $manyToManyRelatedCreateKey = null;
            foreach ((array) ($test['relationsConfig']['manyToMany'] ?? []) as $relationKey => $relation) {
                if (!empty($relation['createRelatedAvailable'])) {
                    $manyToManyRelatedCreateKey = (string) $relationKey;
                    $test['relationsConfig']['manyToMany'][$relationKey]['createRelatedEnabled'] = true;
                    break;
                }
            }

            $path = $repository->save($table, $test);
            $loaded = $repository->load($table);

            $report->add(new DiagnosticResult(
                'Persistent configuration',
                is_file($path) && is_array($loaded) ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                is_file($path) && is_array($loaded)
                    ? 'PHP snapshot created and reloaded.'
                    : 'Unable to create or reload the PHP snapshot.'
            ));

            $compact = is_array($loaded)
                && !array_key_exists('primaryKey', $loaded)
                && !array_key_exists('relations', $loaded)
                && ($firstField === null || !array_key_exists('type', (array) ($loaded['fields'][$firstField] ?? [])))
                && ($firstField === null || !array_key_exists('index', (array) ($loaded['fields'][$firstField] ?? [])));

            $report->add(new DiagnosticResult(
                'Compact snapshot',
                $compact ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $compact
                    ? 'Only developer decisions are persisted; DB schema is not frozen.'
                    : 'The snapshot contains schema information that should be reread from the DB.'
            ));

            if ($firstRelationField !== null) {
                $loadedRelationField = (array) ($loaded['fields'][$firstRelationField] ?? []);
                $relationPersistenceOk = array_key_exists('relationDisplayField', $loadedRelationField)
                    && array_key_exists('relationDisplayTemplate', $loadedRelationField)
                    && !empty($loadedRelationField['relationNavigation']['acceptContext']);
                $report->add(new DiagnosticResult(
                    'Foreign-key description configuration',
                    $relationPersistenceOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                    $relationPersistenceOk
                        ? 'Descriptive field, template, and foreign-key navigation persist in configuration.'
                        : 'Descriptive/foreign-key navigation configuration was not persisted correctly.'
                ));
            } else {
                $report->add(new DiagnosticResult(
                    'Foreign-key description configuration',
                    DiagnosticResult::SKIP,
                    'The table contains no foreign key to verify.'
                ));
            }

            if ($manyToManyRelatedCreateKey !== null) {
                $m2mLoaded = (array) ($loaded['relationsConfig']['manyToMany'][$manyToManyRelatedCreateKey] ?? []);
                $m2mPersistenceOk = !empty($m2mLoaded['createRelatedEnabled']);
                $report->add(new DiagnosticResult(
                    'Many-to-many related-create persistence',
                    $m2mPersistenceOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                    $m2mPersistenceOk
                        ? 'createRelatedEnabled survives Builder/config persistence.'
                        : 'createRelatedEnabled was lost while saving the persistent configuration.'
                ));
            } else {
                $manyToManyRelations = (array) ($test['relationsConfig']['manyToMany'] ?? []);
                $message = $manyToManyRelations === []
                    ? 'Not applicable: this table has no many-to-many relation.'
                    : 'Not applicable: this table has many-to-many relations, but none supports related-create.';
                $report->add(new DiagnosticResult(
                    'Many-to-many related-create persistence',
                    DiagnosticResult::SKIP,
                    $message
                ));
            }

            $meta = (array) ($loaded['_meta'] ?? []);
            $metaOk = !empty($meta['generatorVersion'])
                && !empty($meta['schemaFingerprint'])
                && !empty($meta['configHash']);
            $report->add(new DiagnosticResult(
                'Configuration metadata',
                $metaOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $metaOk
                    ? 'Version, schema fingerprint, and configuration hash are present.'
                    : 'Configuration metadata is incomplete.'
            ));

            $fresh = $builder->buildFromTable($table);
            $merged = is_array($loaded)
                ? $builder->mergeSavedConfiguration($fresh, $loaded)
                : $fresh;

            $mergeOk = (string) ($merged['primaryKey'] ?? '') === (string) ($fresh['primaryKey'] ?? '')
                && (string) ($merged['architecture'] ?? '') === 'standard';
            if ($firstField !== null) {
                $mergeOk = $mergeOk
                    && (string) ($merged['fields'][$firstField]['name'] ?? '') === (string) $firstField
                    && (string) ($merged['fields'][$firstField]['label'] ?? '') === 'Persistent test';
            }

            $report->add(new DiagnosticResult(
                'Schema + configuration merge',
                $mergeOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $mergeOk
                    ? 'Current schema preserved and persistent choices reapplied.'
                    : 'Merge between current schema and configuration is inconsistent.'
            ));

            /*
             * Regression guard: a saved configuration may refer to a
             * field or hasMany relation no longer present in the DB. These
             * chiavi devono essere ignorate e non reintrodotte nel config finale.
             */
            $staleSaved = is_array($loaded) ? $loaded : [];
            $staleSaved['fields']['__campo_rimosso__'] = [
                'label' => 'Removed field',
                'inputType' => 'text',
            ];
            $staleSaved['relationsConfig']['hasMany']['__relazione_rimossa__'] = [
                'enabled' => true,
                'title' => 'Removed relation',
            ];

            $staleMerged = $builder->mergeSavedConfiguration($fresh, $staleSaved);
            $staleOk = !isset($staleMerged['fields']['__campo_rimosso__'])
                && !isset($staleMerged['relationsConfig']['hasMany']['__relazione_rimossa__']);

            $report->add(new DiagnosticResult(
                '2.8 merge schema drift sicuro',
                $staleOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $staleOk
                    ? 'Obsolete fields and relations are discarded; the DB schema remains authoritative.'
                    : 'An obsolete configuration reintroduced elements not present in the current schema.'
            ));

            $savedFingerprint = (string) ($meta['schemaFingerprint'] ?? '');
            $currentFingerprint = $repository->schemaFingerprint($fresh);
            $fingerprintOk = $savedFingerprint !== '' && hash_equals($savedFingerprint, $currentFingerprint);
            $report->add(new DiagnosticResult(
                '2.8 schema fingerprint',
                $fingerprintOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $fingerprintOk
                    ? 'Fingerprint dello schema corrente coerente con lo snapshot.'
                    : 'Fingerprint schema non coerente.'
            ));

            $tables = $repository->tables();
            $report->add(new DiagnosticResult(
                '2.8 elenco configurazioni',
                in_array($table, $tables, true) ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                in_array($table, $tables, true)
                    ? 'Configuration detected by generate-all.'
                    : 'Configuration not detected in the persistent list.'
            ));
        } catch (Throwable $e) {
            $report->add(new DiagnosticResult(
                '2.8 configuration regression',
                DiagnosticResult::FAIL,
                $e->getMessage(),
                ['exception' => $e::class, 'file' => $e->getFile(), 'line' => $e->getLine()]
            ));
        } finally {
            $this->removeDirectory($basePath);
        }

        return $report;
    }

    private function removeDirectory(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }

        @rmdir($path);
    }
}
