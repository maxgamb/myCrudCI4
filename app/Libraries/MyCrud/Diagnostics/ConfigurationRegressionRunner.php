<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\MyCrudVersion;
use Throwable;

/** Verifica il nuovo ciclo 2.8: snapshot persistente, reload e merge su schema fresco. */
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
                '2.8 versione centralizzata',
                $versionOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $versionOk
                    ? 'Versione generatore letta dalla costante unica ' . MyCrudVersion::VERSION . '.'
                    : 'Config\\MyCrud e MyCrudVersion non riportano la stessa versione.'
            ));

            $builder = new ConfigBuilder();
            $base = $builder->buildFromTable($table);
            $repository = new CrudConfigRepository($configPath, $legacyPath);

            $test = $base;
            $test['architecture'] = 'standard';
            $firstField = array_key_first((array) ($test['fields'] ?? []));
            if ($firstField !== null) {
                $test['fields'][$firstField]['label'] = 'Test persistente 2.8';
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

            $path = $repository->save($table, $test);
            $loaded = $repository->load($table);

            $report->add(new DiagnosticResult(
                '2.8 config persistente',
                is_file($path) && is_array($loaded) ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                is_file($path) && is_array($loaded)
                    ? 'Snapshot PHP creato e riletto.'
                    : 'Impossibile creare o rileggere lo snapshot PHP.'
            ));

            $compact = is_array($loaded)
                && !array_key_exists('primaryKey', $loaded)
                && !array_key_exists('relations', $loaded)
                && ($firstField === null || !array_key_exists('type', (array) ($loaded['fields'][$firstField] ?? [])))
                && ($firstField === null || !array_key_exists('index', (array) ($loaded['fields'][$firstField] ?? [])));

            $report->add(new DiagnosticResult(
                '2.8 snapshot compatto',
                $compact ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $compact
                    ? 'Persistite solo decisioni dello sviluppatore; schema DB non congelato.'
                    : 'Lo snapshot contiene informazioni di schema che dovrebbero essere rilette dal DB.'
            ));

            if ($firstRelationField !== null) {
                $loadedRelationField = (array) ($loaded['fields'][$firstRelationField] ?? []);
                $relationPersistenceOk = array_key_exists('relationDisplayField', $loadedRelationField)
                    && array_key_exists('relationDisplayTemplate', $loadedRelationField)
                    && !empty($loadedRelationField['relationNavigation']['acceptContext']);
                $report->add(new DiagnosticResult(
                    '2.8 configurazione descrizione FK',
                    $relationPersistenceOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                    $relationPersistenceOk
                        ? 'Campo descrittivo, template e navigazione FK persistono nella config.'
                        : 'Configurazione descrittiva/navigazione FK non persistita correttamente.'
                ));
            } else {
                $report->add(new DiagnosticResult(
                    '2.8 configurazione descrizione FK',
                    DiagnosticResult::SKIP,
                    'La tabella non contiene foreign key da verificare.'
                ));
            }

            $meta = (array) ($loaded['_meta'] ?? []);
            $metaOk = !empty($meta['generatorVersion'])
                && !empty($meta['schemaFingerprint'])
                && !empty($meta['configHash']);
            $report->add(new DiagnosticResult(
                '2.8 metadati config',
                $metaOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $metaOk
                    ? 'Versione, fingerprint schema e hash configurazione presenti.'
                    : 'Metadati configurazione incompleti.'
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
                    && (string) ($merged['fields'][$firstField]['label'] ?? '') === 'Test persistente 2.8';
            }

            $report->add(new DiagnosticResult(
                '2.8 merge schema + config',
                $mergeOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $mergeOk
                    ? 'Schema corrente preservato e scelte persistenti riapplicate.'
                    : 'Merge fra schema corrente e configurazione non coerente.'
            ));

            /*
             * Regressione dev2: una configurazione salvata può riferirsi a un
             * campo o a una relazione hasMany non più presenti nel DB. Queste
             * chiavi devono essere ignorate e non reintrodotte nel config finale.
             */
            $staleSaved = is_array($loaded) ? $loaded : [];
            $staleSaved['fields']['__campo_rimosso__'] = [
                'label' => 'Campo rimosso',
                'inputType' => 'text',
            ];
            $staleSaved['relationsConfig']['hasMany']['__relazione_rimossa__'] = [
                'enabled' => true,
                'title' => 'Relazione rimossa',
            ];

            $staleMerged = $builder->mergeSavedConfiguration($fresh, $staleSaved);
            $staleOk = !isset($staleMerged['fields']['__campo_rimosso__'])
                && !isset($staleMerged['relationsConfig']['hasMany']['__relazione_rimossa__']);

            $report->add(new DiagnosticResult(
                '2.8 merge schema drift sicuro',
                $staleOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $staleOk
                    ? 'Campi e relazioni obsolete vengono scartati; lo schema DB resta autorevole.'
                    : 'Una configurazione obsoleta ha reintrodotto elementi non presenti nello schema corrente.'
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
                    ? 'Configurazione rilevata da generate-all.'
                    : 'Configurazione non rilevata nell’elenco persistente.'
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
