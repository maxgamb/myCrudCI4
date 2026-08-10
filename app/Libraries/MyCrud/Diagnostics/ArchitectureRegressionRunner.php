<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\Core\DatabaseValidationResolver;
use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;
use Config\MyCrud;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;

/**
 * Test automatico di regressione del generatore.
 * Genera Basic, Standard e Full in cartelle temporanee isolate e controlla
 * componenti attesi, componenti vietati, placeholder e sintassi PHP.
 */
final class ArchitectureRegressionRunner
{
    public function run(string $table): DiagnosticReport
    {
        $report = new DiagnosticReport();
        /** @var MyCrud $myCrud */
        $myCrud = config('MyCrud');
        $originalPath = $myCrud->generatedPath;
        $base = rtrim(WRITEPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR . 'mycrud-regression-' . bin2hex(random_bytes(4));

        try {
            foreach (['basic', 'standard', 'full'] as $architecture) {
                $root = $base . DIRECTORY_SEPARATOR . $architecture;
                $myCrud->generatedPath = $root;

                $config = (new ConfigBuilder())->buildFromTable($table);
                $config['architecture'] = $architecture;
                (new CrudGeneratorService())->generate($config, true);

                $generated = $root . DIRECTORY_SEPARATOR . 'Generated' . DIRECTORY_SEPARATOR;
                $report->addMany($this->architectureChecks($generated, $config, $architecture));
                $report->addMany((new GeneratedFileDiagnostics())->inspect($generated));
            }
        } catch (Throwable $exception) {
            $report->add(new DiagnosticResult(
                'Regression suite',
                DiagnosticResult::FAIL,
                $exception->getMessage(),
                ['exception' => $exception::class, 'file' => $exception->getFile(), 'line' => $exception->getLine()]
            ));
        } finally {
            $myCrud->generatedPath = $originalPath;
            $this->removeDirectory($base);
        }

        return $report;
    }

    /** @return list<DiagnosticResult> */
    private function architectureChecks(string $root, array $config, string $architecture): array
    {
        $class = (array) ($config['classes'] ?? []);
        $table = (string) ($config['table'] ?? '');
        $expected = [
            'Models/' . ($class['model'] ?? '') . '.php',
            'Controllers/' . ($class['controller'] ?? '') . '.php',
            'Validation/' . ($class['rules'] ?? '') . '.php',
            'Views/' . $table . '/index.php',
            'Routes/' . $table . '.php',
            'Libraries/Crud/CrudExporter.php',
            'Libraries/Crud/CrudListRequest.php',
        ];

        if (in_array($architecture, ['standard', 'full'], true)) {
            $expected[] = 'Entities/' . ($class['entity'] ?? '') . '.php';
            $expected[] = 'Services/' . ($class['service'] ?? '') . '.php';
        }
        if ($architecture === 'full') {
            $expected[] = 'Controllers/Api/BaseApiController.php';
            $expected[] = 'Controllers/Api/V1/' . ($class['api'] ?? '') . '.php';
            $expected[] = 'API/Resources/' . ($class['resource'] ?? '') . '.php';
        }

        $results = [];

        // Il nome delle classi deve derivare dalla tabella esattamente come
        // definita nel DB, senza singularizzazioni linguistiche automatiche.
        $expectedPrefix = Naming::tableClass($table);
        $actualController = (string) ($class['controller'] ?? '');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' naming tabella',
            $actualController === $expectedPrefix . 'Controller'
                ? DiagnosticResult::PASS
                : DiagnosticResult::FAIL,
            $actualController === $expectedPrefix . 'Controller'
                ? 'Nome classe fedele alla tabella.'
                : 'Atteso ' . $expectedPrefix . 'Controller, generato ' . $actualController . '.'
        );

        // I nomi fisici dei campi non devono essere camelizzati o rinominati.
        $fieldNames = array_keys((array) ($config['fields'] ?? []));
        $preserved = true;
        foreach ($fieldNames as $fieldName) {
            if (!isset($config['fields'][$fieldName]['name']) || $config['fields'][$fieldName]['name'] !== $fieldName) {
                $preserved = false;
                break;
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' naming campi DB',
            $preserved ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $preserved ? 'Nomi campi DB preservati.' : 'Uno o più campi sono stati rinominati.'
        );
        foreach ($expected as $relative) {
            $exists = is_file($root . str_replace('/', DIRECTORY_SEPARATOR, $relative));
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' componente ' . $relative,
                $exists ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $exists ? 'Presente.' : 'Mancante.'
            );
        }

        $forbidden = match ($architecture) {
            'basic' => ['Entities/', 'Services/', 'Controllers/Api/V1/', 'API/Resources/'],
            'standard' => ['Controllers/Api/V1/', 'API/Resources/'],
            default => [],
        };
        foreach ($forbidden as $relative) {
            $exists = is_dir($root . str_replace('/', DIRECTORY_SEPARATOR, $relative));
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' assenza ' . $relative,
                !$exists ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                !$exists ? 'Componente correttamente assente.' : 'Componente non previsto presente.'
            );
        }

        // Regressioni UI/runtime consolidate nella dev24.
        $indexPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'index.php';
        $controllerPath = $root . 'Controllers' . DIRECTORY_SEPARATOR . ($class['controller'] ?? '') . '.php';
        $exporterPath = $root . 'Libraries' . DIRECTORY_SEPARATOR . 'Crud' . DIRECTORY_SEPARATOR . 'CrudExporter.php';
        $modelPath = $root . 'Models' . DIRECTORY_SEPARATOR . ($class['model'] ?? '') . '.php';
        $indexContent = is_file($indexPath) ? (string) file_get_contents($indexPath) : '';
        $controllerContent = is_file($controllerPath) ? (string) file_get_contents($controllerPath) : '';
        $exporterContent = is_file($exporterPath) ? (string) file_get_contents($exporterPath) : '';
        $modelContent = is_file($modelPath) ? (string) file_get_contents($modelPath) : '';

        $toolbarOk = str_contains($indexContent, 'bi-filetype-csv')
            && str_contains($indexContent, 'bi-file-earmark-word');
        if (!empty($config['features']['createAllowed'])) {
            $toolbarOk = $toolbarOk && str_contains($indexContent, 'bi-plus-circle');
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' toolbar index',
            $toolbarOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $toolbarOk ? 'Azioni Index coerenti presenti.' : 'Toolbar Index incompleta.'
        );

        // Dev30: una PK composta può creare nuovi record, ma non espone
        // ancora route che richiedono l'identità completa della singola riga.
        $routePath = $root . 'Routes' . DIRECTORY_SEPARATOR . $table . '.php';
        $routeContent = is_file($routePath) ? (string) file_get_contents($routePath) : '';
        $createViewPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'create.php';
        $editViewPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'edit.php';
        $detailViewPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'view.php';
        $createPolicyOk = true;
        if (!empty($config['features']['createAllowed'])) {
            $createPolicyOk = is_file($createViewPath)
                && str_contains($routeContent, "get('create'")
                && str_contains($routeContent, "post('store'");
        }
        if (!empty($config['compositePrimaryKey'])) {
            $createPolicyOk = $createPolicyOk
                && empty($config['features']['writable'])
                && empty($config['features']['recordDetail'])
                && !is_file($editViewPath)
                && !is_file($detailViewPath)
                && !str_contains($routeContent, "get('edit/")
                && !str_contains($routeContent, "post('delete/")
                && !str_contains($routeContent, "get('view/");
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' policy CREATE PK composta',
            $createPolicyOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $createPolicyOk
                ? (!empty($config['compositePrimaryKey'])
                    ? 'PK composta: Create abilitato, View/Edit/Delete protetti.'
                    : 'Policy Create coerente con lo schema.')
                : 'Policy Create/azioni record non coerente con la PK.'
        );

        // Se il Builder abilita "seleziona oppure crea nuovo", i quattro
        // livelli coinvolti devono essere presenti: form, validation, controller
        // e transazione nel Model.
        $enabledRelatedCreates = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $field) {
            if (!empty($field['relationCreate']['enabled'])) {
                $enabledRelatedCreates[] = (string) $fieldName;
            }
        }
        $relatedCreateOk = true;
        if ($enabledRelatedCreates !== []) {
            $formPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . '_form.php';
            $rulesPath = $root . 'Validation' . DIRECTORY_SEPARATOR . ($class['rules'] ?? '') . '.php';
            $formContent = is_file($formPath) ? (string) file_get_contents($formPath) : '';
            $rulesContent = is_file($rulesPath) ? (string) file_get_contents($rulesPath) : '';
            $relatedPartialOk = true;
            foreach ($enabledRelatedCreates as $relatedField) {
                $safeRelatedField = preg_replace('/[^a-zA-Z0-9_]/', '_', $relatedField);
                $partialPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR
                    . '_related_create_' . $safeRelatedField . '.php';
                $partialContent = is_file($partialPath) ? (string) file_get_contents($partialPath) : '';
                $relatedPartialOk = $relatedPartialOk
                    && $partialContent !== ''
                    && str_contains($partialContent, '_related[' . $relatedField . ']');
            }
            $relatedCreateOk = str_contains($modelContent, 'private const RELATED_CREATES')
                && str_contains($modelContent, 'public function createRecord(array $data, array $related = [])')
                && str_contains($modelContent, 'transBegin()')
                && str_contains($controllerContent, 'relatedCreateDataFromPost')
                && str_contains($controllerContent, 'validateRelatedCreates')
                && str_contains($rulesContent, 'relatedCreateRules')
                && str_contains($formContent, '_related_new[')
                && str_contains($formContent, 'data-bs-toggle="offcanvas"')
                && str_contains($formContent, 'crud-relation-input-group')
                && str_contains($formContent, 'bi-plus-circle')
                && $relatedPartialOk;
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' create record collegato',
            $relatedCreateOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $relatedCreateOk
                ? ($enabledRelatedCreates === []
                    ? 'Nessuna creazione inline di parent abilitata nel Builder.'
                    : 'Creazione parent inline validata e transazionale.')
                : 'Supporto create parent inline incompleto.'
        );

        $contextOk = str_contains($controllerContent, 'NAVIGATION_CONTEXT_FIELDS')
            && str_contains($controllerContent, 'navigationContextFromQuery')
            && str_contains($controllerContent, 'contextUrl');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' contesto FK navigazione',
            $contextOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $contextOk ? 'Contesto FK propagato da Controller e redirect.' : 'Supporto contesto FK incompleto.'
        );

        // Regressione dev28: una FK reale è accettata di default come
        // contesto del Create. Il valore viene validato dal Controller tramite
        // relationOptionById() prima di essere passato al form.
        $foreignKeyFields = array_filter(
            (array) ($config['fields'] ?? []),
            static fn (array $field): bool => !empty($field['foreignKey'])
        );
        $fkCreateContextOk = true;
        foreach ($foreignKeyFields as $field) {
            if (empty($field['relationNavigation']['acceptContext'])) {
                $fkCreateContextOk = false;
                break;
            }
        }
        if ($foreignKeyFields !== []) {
            $fkCreateContextOk = $fkCreateContextOk
                && str_contains($controllerContent, 'relationOptionById')
                && str_contains($controllerContent, '$context[$field] = (string) $option[\'id\'];');
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' FK precompilata nel Create',
            $fkCreateContextOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $fkCreateContextOk
                ? ($foreignKeyFields === []
                    ? 'Nessuna FK da verificare.'
                    : 'Le FK reali accettano il contesto URL e vengono verificate sulla tabella padre.')
                : 'Una FK reale non viene accettata/precompilata correttamente nel Create.'
        );


        // Regressione dev29: l'alias visibile è legato alla FK del record
        // (campo__label), mentre il JOIN resta isolato in un metodo del Model.
        $relationAliasOk = true;
        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            $expectedAlias = (string) $fieldName . '__label';
            $parentTable = (string) ($relation['parentTable'] ?? '');
            $joinMethod = 'join' . Naming::tableClass($parentTable) . Naming::studly((string) $fieldName);
            if (
                (string) ($relation['alias'] ?? '') !== $expectedAlias
                || !str_contains($modelContent, ' AS ' . $expectedAlias)
                || !str_contains($modelContent, 'private function ' . $joinMethod . '(BaseBuilder $builder): BaseBuilder')
            ) {
                $relationAliasOk = false;
                break;
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' alias e JOIN relazioni Model',
            $relationAliasOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $relationAliasOk
                ? 'Label FK come campo__label e JOIN padre dichiarato una sola volta nel Model.'
                : 'Alias relazione o centralizzazione del JOIN nel Model non coerenti.'
        );

        // Dev30: ogni hasMany creabile offre "Nuovo" con la FK esatta
        // del rapporto, riutilizzando il normale FK Context del Create figlio.
        $hasManyNewOk = true;
        if (!empty($config['features']['recordDetail']) && is_file($detailViewPath)) {
            $detailContent = (string) file_get_contents($detailViewPath);
            foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $relation) {
                if (empty($relation['enabled']) || empty($relation['childCreateAllowed'])) {
                    continue;
                }
                $foreignKey = (string) ($relation['foreignKey'] ?? '');
                $childTable = (string) ($relation['childTable'] ?? '');
                if ($foreignKey === '' || $childTable === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $foreignKey) !== 1) {
                    continue;
                }
                if (!str_contains($detailContent, "site_url('{$childTable}/create')")
                    || !str_contains($detailContent, var_export($foreignKey, true) . ' =>')) {
                    $hasManyNewOk = false;
                    break;
                }
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' Nuovo nelle relazioni figlie',
            $hasManyNewOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $hasManyNewOk
                ? 'Le relazioni figlie creabili mantengono la FK nel pulsante Nuovo.'
                : 'Un pulsante Nuovo hasMany non conserva correttamente la FK.'
        );

        $exportSafetyOk = str_contains($exporterContent, 'EXPORT_UNFILTERED_LIMIT:CSV')
            && str_contains($exporterContent, 'EXPORT_UNFILTERED_LIMIT:WORD')
            && str_contains($exporterContent, 'iterateRows');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' sicurezza export',
            $exportSafetyOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $exportSafetyOk ? 'Export a chunk con limiti anche senza filtri.' : 'Protezione export incompleta.'
        );

        $shortExportOk = str_contains($indexContent, 'simpleFilterFields')
            && str_contains($indexContent, 'sourceUrl.searchParams.get(field)')
            && str_contains($indexContent, 'params.set(field, value)');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' export filtri corti',
            $shortExportOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $shortExportOk
                ? 'CSV/Word preservano i filtri rapidi ?campo=valore dopo AJAX.'
                : 'Gli export possono perdere i filtri rapidi della URL corrente.'
        );

        // Regressione dev25: CHAR(n) è una lunghezza massima DB e non deve
        // diventare automaticamente exact_length[n].
        $validationResolver = new DatabaseValidationResolver();
        $charRules = $validationResolver->rulesFor([
            'name' => 'code',
            'type' => 'char',
            'columnType' => 'char(20)',
            'maxLength' => 20,
            'nullable' => false,
            'default' => null,
            'autoIncrement' => false,
            'primary' => false,
            'attributes' => ['boolean' => [], 'values' => []],
        ], 'sample_table', 'id', false);
        $varcharRules = $validationResolver->rulesFor([
            'name' => 'label',
            'type' => 'varchar',
            'columnType' => 'varchar(20)',
            'maxLength' => 20,
            'nullable' => false,
            'default' => null,
            'autoIncrement' => false,
            'primary' => false,
            'attributes' => ['boolean' => [], 'values' => []],
        ], 'sample_table', 'id', false);
        $lengthRulesOk = in_array('max_length[20]', $charRules, true)
            && in_array('max_length[20]', $varcharRules, true)
            && !in_array('exact_length[20]', $charRules, true);
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' validazione CHAR max length',
            $lengthRulesOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $lengthRulesOk
                ? 'CHAR(n) e VARCHAR(n) generano max_length[n]; exact_length non è dedotto dal DB.'
                : 'Regressione: CHAR(n) sta generando exact_length[n].'
        );

        // Regressione dev27: DEFAULT CURRENT_TIMESTAMP + ON UPDATE CURRENT_TIMESTAMP
        // è una responsabilità del database, non del form o della validazione.
        $automaticTimestamp = [
            'name' => 'last_update',
            'type' => 'timestamp',
            'columnType' => 'timestamp',
            'defaultValue' => 'current_timestamp()',
            'extra' => 'DEFAULT_GENERATED on update CURRENT_TIMESTAMP',
            'nullable' => 'NO',
            'maxLength' => null,
            'attributes' => ['boolean' => [], 'values' => []],
            'primary' => false,
            'autoIncrement' => false,
        ];
        $databaseManaged = FieldPolicy::isDatabaseManagedTimestamp($automaticTimestamp);
        $automaticTimestamp['databaseManaged'] = $databaseManaged;
        $automaticTimestamp['default'] = $automaticTimestamp['defaultValue'];
        $managedRules = $validationResolver->rulesFor($automaticTimestamp, 'sample_table', 'id', false);
        $databaseManagedOk = $databaseManaged && $managedRules === [];
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' timestamp automatico DB',
            $databaseManagedOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $databaseManagedOk
                ? 'CURRENT_TIMESTAMP + ON UPDATE è riconosciuto come databaseManaged e non genera validation rules.'
                : 'Regressione: un timestamp automatico DB viene trattato come input applicativo.'
        );

        return $results;
    }

    private function removeDirectory(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($path);
    }
}
