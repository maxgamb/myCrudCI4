<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

/** Generates the application Service without SQL queries. */
final class ServiceGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $class = (string) $config['classes']['service'];
        $modelClass = (string) $config['classes']['model'];
        $entityClass = (string) $config['classes']['entity'];
        $useEntity = !empty($config['features']['entity']);
        $rulesClass = (string) $config['classes']['rules'];
        $apiEnabled = !empty($config['features']['api']);
        $apiCaps = (array) ($config['apiCapabilities'] ?? []);
        $apiCreateAllowed = $apiEnabled && !empty($apiCaps['create']);
        $apiUpdateAllowed = $apiEnabled && !empty($apiCaps['update']);
        $readOnly = !empty($config['features']['readOnly']);
        $isView = !empty($config['isView']);
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $recordDetail = !empty($config['features']['recordDetail']);
        $softDeleteEnabled = $writable && !empty($config['features']['softDeletes']);
        $hasBelongsTo = !empty($config['relations']['belongsTo']);
        $enabledHasMany = array_filter(
            (array) ($config['relationsConfig']['hasMany'] ?? []),
            static fn (array $relation): bool => !empty($relation['enabled'])
        );
        $enabledManyToMany = array_filter(
            (array) ($config['relationsConfig']['manyToMany'] ?? []),
            static fn (array $relation): bool => !empty($relation['enabled'])
        );
        $hasHasMany = $recordDetail && ($enabledHasMany !== [] || $enabledManyToMany !== []);
        $manyToManyCreateEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool => !empty($relation['createEnabled'])
        );
        $manyToManyEditEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool => !empty($relation['editEnabled'])
        );
        $manyToManyRelatedCreateEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool => !empty($relation['createRelatedEnabled'])
                && !empty($relation['createRelatedAvailable'])
        );
        $hasRelatedCreate = false;
        $relatedCreateServiceBindings = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $field) {
            $relationCreate = (array) ($field['relationCreate'] ?? []);
            $foreignKey = (array) ($field['foreignKey'] ?? []);
            $relatedCreateSchema = (array) ($foreignKey['relatedCreate'] ?? []);
            if (empty($relationCreate['enabled']) || empty($relatedCreateSchema['available'])) {
                continue;
            }

            $parentTable = (string) ($foreignKey['parentTable'] ?? '');
            if ($parentTable === '') {
                continue;
            }

            $hasRelatedCreate = true;
            $relatedCreateServiceBindings[(string) $fieldName] = Naming::tableClass($parentTable) . 'Service';
        }

        $manyToManyRelatedCreateServiceBindings = [];
        foreach ($enabledManyToMany as $relationKey => $relation) {
            if (empty($relation['createRelatedEnabled']) || empty($relation['createRelatedAvailable'])) {
                continue;
            }

            $relatedTable = trim((string) ($relation['relatedTable'] ?? ''));
            if ($relatedTable === '') {
                continue;
            }

            $manyToManyRelatedCreateServiceBindings[(string) $relationKey] =
                Naming::tableClass($relatedTable) . 'Service';
        }

        // Extensions are generated only for genuinely writable CRUDs.
        // Le VIEW e le tabelle con sola Create (es. pivot a PK composta) non
        // ricevono hook update/delete che non potrebbero essere raggiunti.
        $extensionEnabled = $writable;
        $extensionClass = $class . 'Extension';
        $extensionUse = $extensionEnabled
            ? "use App\\Services\\Extensions\\{$extensionClass};\n"
            : '';
        $extensionTrait = $extensionEnabled
            ? "    use {$extensionClass};\n\n"
            : '';

        $passwordFields = [];
        $automaticDateFields = [];
        $databaseManagedFields = [];
        $nullableForeignKeyFields = [];
        $dateTimeFields = [];
        $nullableFields = [];
        $defaultedFields = [];
        $apiUploadFields = [];
        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            $ui = (array) ($field['ui'] ?? []);
            $inputType = (string) ($field['inputType'] ?? $ui['inputType'] ?? 'text');
            $type = strtolower((string) ($field['type'] ?? ''));
            if (($apiCreateAllowed || $apiUpdateAllowed) && in_array(strtolower($inputType), ['file', 'image'], true)) {
                $apiUploadFields[] = $name;
            }
            if (FieldPolicy::isPassword($name, $inputType)) {
                $passwordFields[] = $name;
            }
            if (!empty($field['databaseManaged'])) {
                $databaseManagedFields[] = $name;
            }
            // DB-managed fields are removed before validation/persistence and do not
            // need application-side nullable/default normalization branches.
            if (empty($field['databaseManaged']) && !empty($field['nullable'])) {
                $nullableFields[] = $name;
            }
            if (empty($field['databaseManaged']) && !empty($field['hasDefault'])) {
                $defaultedFields[] = $name;
            }
            if (!empty($field['foreignKey']) && !empty($field['nullable'])) {
                $nullableForeignKeyFields[] = $name;
            }
            if (empty($field['databaseManaged']) && in_array($type, ['datetime', 'timestamp'], true)) {
                $dateTimeFields[] = $name;
            }
            if (
                empty($field['databaseManaged'])
                && preg_match('/(?:^|_)(?:data_record|recorded_at)(?:$|_)/i', $name) === 1
                && in_array($type, ['date', 'datetime', 'timestamp'], true)
            ) {
                $automaticDateFields[$name] = $type === 'date' ? 'Y-m-d' : 'Y-m-d H:i:s';
            }
        }

        $passwordFieldsCode = var_export(array_values(array_unique($passwordFields)), true);
        $automaticDateFieldsCode = var_export($automaticDateFields, true);
        $databaseManagedFieldsCode = var_export(array_values(array_unique($databaseManagedFields)), true);
        $nullableForeignKeyFieldsCode = var_export(array_values(array_unique($nullableForeignKeyFields)), true);
        $dateTimeFieldsCode = var_export(array_values(array_unique($dateTimeFields)), true);
        $nullableFieldsCode = var_export(array_values(array_unique($nullableFields)), true);
        $defaultedFieldsCode = var_export(array_values(array_unique($defaultedFields)), true);
        $apiUploadFieldsCode = var_export(array_values(array_unique($apiUploadFields)), true);
        $hasApiUploadFields = $apiUploadFields !== [];

        // Generate only the preparation branches that are actually needed by this table.
        $hasPasswordFields = $passwordFields !== [];
        $hasAutomaticDateFields = $automaticDateFields !== [];
        $hasDatabaseManagedFields = $databaseManagedFields !== [];
        $hasNullableForeignKeyFields = $nullableForeignKeyFields !== [];
        $hasDateTimeFields = $dateTimeFields !== [];
        $hasNullableFields = $nullableFields !== [];
        $hasDefaultedFields = $defaultedFields !== [];
        $needsEmptyValueNormalization = $hasNullableFields || $hasDefaultedFields;
        // Only automatic Create dates and password handling need to know whether
        // the current operation is Create or Update. Other tables get a slimmer
        // prepareData(array $data) signature with no unused boolean parameter.
        $prepareNeedsUpdateFlag = $hasAutomaticDateFields || $hasPasswordFields;
        $prepareCreateCall = $prepareNeedsUpdateFlag
            ? '$this->prepareData($data, false)'
            : '$this->prepareData($data)';
        $prepareUpdateCall = $prepareNeedsUpdateFlag
            ? '$this->prepareData($data, true)'
            : '$this->prepareData($data)';

        $beforeCreateHook = $extensionEnabled ? "        \$data = \$this->beforeCreate(\$data);\n" : '';
        $afterCreateHook = $extensionEnabled ? "        \$this->afterCreate(\$id, \$data);\n" : '';
        $beforeUpdateHook = $extensionEnabled ? "        \$data = \$this->beforeUpdate(\$id, \$data);\n" : '';
        $afterUpdateHook = $extensionEnabled ? "        \$this->afterUpdate(\$id, \$data);\n" : '';
        $beforeDeleteHook = $extensionEnabled ? "        \$this->beforeDelete(\$id);\n" : '';
        $afterDeleteHook = $extensionEnabled ? "        \$this->afterDelete(\$id);\n" : '';

        // Read/query methods are intentionally not generated in Services.
        // Controllers/API/MCP read directly through the generated Model.

        // No read pass-through methods: list/export/API/relation/hasMany/M2M reads belong to the Model.

        // Generate one named Service helper per relation. The generated Service does not
        // route writes through a generic relation dispatcher at runtime.
        $relatedServiceHelpers = '';
        $relatedCreateInlineCalls = '';
        if ($createAllowed && $hasRelatedCreate) {
            $helperBlocks = [];
            $inlineCalls = [];
            foreach ($relatedCreateServiceBindings as $field => $serviceClass) {
                $fieldName = (string) $field;
                $parentStem = preg_replace('/Service$/', '', $serviceClass) ?: $serviceClass;
                $method = 'create' . $parentStem . 'For' . Naming::studly($fieldName);
                $fieldLiteral = var_export($fieldName, true);
                $helperBlocks[] = <<<PHP
    /**
     * Creates the parent resource for relation {$fieldName}.
     *
     * Delegates the write to {$serviceClass}; this Service only orchestrates the FK assignment.
     *
     * @param array<string,mixed> \$payload Parent resource payload.
     * @return int|string Created parent identifier.
     */
    private function {$method}(array \$payload): int|string
    {
        return (new {$serviceClass}())->createRelated(\$payload);
    }

PHP;
                $inlineCalls[] = <<<PHP
            if (isset(\$related[{$fieldLiteral}]) && is_array(\$related[{$fieldLiteral}])) {
                \$data[{$fieldLiteral}] = \$this->{$method}(\$related[{$fieldLiteral}]);
            }
PHP;
            }
            $relatedServiceHelpers = implode("\n", $helperBlocks);
            $relatedCreateInlineCalls = implode("\n", $inlineCalls) . "\n";
        }

        $manyToManyRelatedServiceHelpers = '';
        $manyToManyRelatedInlineCalls = '';
        if ($createAllowed && $manyToManyRelatedCreateEnabled) {
            $helperBlocks = [];
            $inlineCalls = [];
            foreach ($manyToManyRelatedCreateServiceBindings as $relationKey => $serviceClass) {
                $relationName = (string) $relationKey;
                $targetStem = preg_replace('/Service$/', '', $serviceClass) ?: $serviceClass;
                $method = 'create' . $targetStem . 'For' . Naming::studly($relationName);
                $relationLiteral = var_export($relationName, true);
                $helperBlocks[] = <<<PHP
    /**
     * Creates a target resource for many-to-many relation {$relationName}.
     *
     * Delegates target persistence to {$serviceClass}; pivot persistence remains in the current Model.
     *
     * @param array<string,mixed> \$payload Target resource payload.
     * @return int|string Created target identifier.
     */
    private function {$method}(array \$payload): int|string
    {
        return (new {$serviceClass}())->createRelated(\$payload);
    }

PHP;
                $inlineCalls[] = <<<PHP
            if (isset(\$manyToManyNew[{$relationLiteral}]) && is_array(\$manyToManyNew[{$relationLiteral}])) {
                \$newId = \$this->{$method}(\$manyToManyNew[{$relationLiteral}]);
                \$manyToMany[{$relationLiteral}] ??= [];
                \$manyToMany[{$relationLiteral}][] = \$newId;
                \$manyToMany[{$relationLiteral}] = array_values(array_unique(array_map('strval', \$manyToMany[{$relationLiteral}])));
            }
PHP;
            }
            $manyToManyRelatedServiceHelpers = implode("\n", $helperBlocks);
            $manyToManyRelatedInlineCalls = implode("\n", $inlineCalls) . "\n";
        }

        $createRelatedEntryPoint = $createAllowed ? <<<PHP
    /**
     * Creates this resource when another generated Service needs it as a parent.
     *
     * Validation, normalization and extension hooks remain owned by this Service;
     * persistence remains owned by the current Model.
     *
     * @param array<string,mixed> \$data
     * @return int|string
     */
    public function createRelated(array \$data): int|string
    {
        \$data = {$prepareCreateCall};
        \$this->validateCreatePayload(\$data);
{$beforeCreateHook}        \$id = \$this->model->insertRelatedPayload(\$data);
{$afterCreateHook}
        return \$id;
    }

PHP : '';

        $validationMethods = ($createAllowed || $writable) ? <<<PHP
    /** @param array<string,mixed> \$data */
    private function validateCreatePayload(array \$data): void
    {
        \$this->validatePayload(\$data, {$rulesClass}::createRules(), {$rulesClass}::messages(), 'Create validation failed.');
    }

PHP : '';

        if ($writable) {
            $validationMethods .= <<<PHP
    /** @param array<string,mixed> \$data */
    private function validateUpdatePayload(int|string \$id, array \$data): void
    {
        \$this->validatePayload(\$data, {$rulesClass}::updateRules(\$id), {$rulesClass}::messages(), 'Update validation failed.');
    }

PHP;
        }

        if ($createAllowed || $writable) {
            $validationMethods .= <<<'PHP'
    /**
     * Runs the generated Rules for this resource.
     *
     * @param array<string,mixed> $data
     * @param array<string,mixed> $rules Generated validation rules.
     * @param array<string,string|array<string,string>> $messages Generated custom validation messages.
     * @param string $fallback Error used when the validator exposes no field messages.
     * @throws RuntimeException When validation fails.
     */
    private function validatePayload(array $data, array $rules, array $messages, string $fallback): void
    {
        $validation = service('validation');
        $validation->reset();
        $validation->setRules($rules, $messages);

        if ($validation->run($data)) {
            return;
        }

        $errors = $validation->getErrors();
        $message = $errors === []
            ? $fallback
            : implode(' ', array_values(array_map('strval', $errors)));

        throw new RuntimeException($message);
    }

PHP;
        }

        $createHasManyToMany = $manyToManyCreateEnabled || $manyToManyRelatedCreateEnabled;
        $createParams = ["array \$data"];
        if ($hasRelatedCreate) {
            $createParams[] = "array \$related = []";
        }
        if ($createHasManyToMany) {
            $createParams[] = "array \$manyToMany = []";
        }
        if ($manyToManyRelatedCreateEnabled) {
            $createParams[] = "array \$manyToManyNew = []";
        }
        $createSignature = implode(",\n        ", $createParams);

        $createDocParams = "     * @param array<string, mixed> \$data Main record data.\n";
        if ($hasRelatedCreate) {
            $createDocParams .= "     * @param array<string, array<string, mixed>> \$related Inline parent records.\n";
        }
        if ($createHasManyToMany) {
            $createDocParams .= "     * @param array<string, list<int|string>> \$manyToMany Many-to-many associations.\n";
        }
        if ($manyToManyRelatedCreateEnabled) {
            $createDocParams .= "     * @param array<string, array<string,mixed>> \$manyToManyNew New target records.\n";
        }

        $manyToManyCreateSyncLines = [];
        $manyToManyUpdateSyncLines = [];
        foreach ($enabledManyToMany as $relationKey => $relation) {
            $relationName = (string) $relationKey;
            $relatedTable = trim((string) ($relation['relatedTable'] ?? ''));
            if ($relatedTable === '') {
                continue;
            }
            $syncMethod = 'sync' . Naming::tableClass($relatedTable) . 'IdsFor' . Naming::studly($relationName);
            $relationLiteral = var_export($relationName, true);
            if (!empty($relation['createEnabled'])) {
                $manyToManyCreateSyncLines[] = "            if (isset(\$manyToMany[{$relationLiteral}]) && is_array(\$manyToMany[{$relationLiteral}])) {\n                // Persist this explicit pivot only after the main record has an identifier.\n                \$this->model->{$syncMethod}(\$id, \$manyToMany[{$relationLiteral}]);\n            }";
            }
            if (!empty($relation['editEnabled'])) {
                $manyToManyUpdateSyncLines[] = "            if (isset(\$manyToMany[{$relationLiteral}]) && is_array(\$manyToMany[{$relationLiteral}])) {\n                // Synchronize this explicit pivot through the current Model.\n                \$this->model->{$syncMethod}(\$id, \$manyToMany[{$relationLiteral}]);\n            }";
            }
        }
        $manyToManyCreateSyncCode = $manyToManyCreateSyncLines === [] ? '' : implode("\n", $manyToManyCreateSyncLines) . "\n";
        $manyToManyUpdateSyncCode = $manyToManyUpdateSyncLines === [] ? '' : implode("\n", $manyToManyUpdateSyncLines) . "\n";

        $createRelatedCall = $relatedCreateInlineCalls;
        $createM2MRelatedCall = $manyToManyRelatedInlineCalls;
        $createModelCall = $useEntity
            ? "\$this->model->createRecord({$entityClass}::fromArray(\$data))"
            : "\$this->model->createRecord(\$data)";
        $createTransactionalExpressionParts = [];
        if ($hasRelatedCreate) {
            $createTransactionalExpressionParts[] = '$related !== []';
        }
        if ($createHasManyToMany) {
            $createTransactionalExpressionParts[] = '$manyToMany !== []';
        }
        if ($manyToManyRelatedCreateEnabled) {
            $createTransactionalExpressionParts[] = '$manyToManyNew !== []';
        }
        $createNeedsTransaction = $createTransactionalExpressionParts !== [];
        $createTransactionCode = '';
        $createBody = '';
        if ($createNeedsTransaction) {
            $transactionExpression = implode(' || ', $createTransactionalExpressionParts);
            $createBody = <<<PHP
        \$transactional = {$transactionExpression};
        if (\$transactional) {
            \$this->model->beginWriteTransaction();
        }

        try {
{$createRelatedCall}{$createM2MRelatedCall}            \$id = {$createModelCall};
{$manyToManyCreateSyncCode}
            if (\$transactional) {
                if (!\$this->model->writeTransactionStatus()) {
                    throw new RuntimeException('Related create transaction failed.');
                }
                \$this->model->commitWriteTransaction();
            }
        } catch (\\Throwable \$e) {
            if (\$transactional) {
                \$this->model->rollbackWriteTransaction();
            }
            throw \$e;
        }

PHP;
        } else {
            $createBody = "        \$id = {$createModelCall};\n{$manyToManyCreateSyncCode}";
        }

        $createMethod = $createAllowed ? <<<PHP
    /**
     * Creates this resource.
     *
{$createDocParams}     * @return int|string Created record identifier.
     */
    public function create(
        {$createSignature}
    ): int|string {
        \$data = {$prepareCreateCall};
        \$this->validateCreatePayload(\$data);
{$beforeCreateHook}{$createBody}{$afterCreateHook}
        return \$id;
    }

PHP : '';

        $updateHasManyToMany = $manyToManyEditEnabled || $manyToManyRelatedCreateEnabled;
        $updateParams = ["int|string \$id", "array \$data"];
        if ($updateHasManyToMany) {
            $updateParams[] = "array \$manyToMany = []";
        }
        if ($manyToManyRelatedCreateEnabled) {
            $updateParams[] = "array \$manyToManyNew = []";
        }
        $updateSignature = implode(",\n        ", $updateParams);
        $updateM2MRelatedCall = $manyToManyRelatedCreateEnabled ? $manyToManyRelatedInlineCalls : '';
        $updateModelCall = $useEntity
            ? "\$this->model->updateRecord(\$id, {$entityClass}::fromArray(\$data))"
            : "\$this->model->updateRecord(\$id, \$data)";

        $updateTransactionalExpression = $manyToManyRelatedCreateEnabled ? '$manyToMany !== [] || $manyToManyNew !== []' : '$manyToMany !== []';

        if ($writable && $updateHasManyToMany) {
            $updateBody = <<<PHP
        \$transactional = {$updateTransactionalExpression};
        if (\$transactional) {
            \$this->model->beginWriteTransaction();
        }

        try {
{$updateM2MRelatedCall}            if (!{$updateModelCall}) {
                throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Update failed.');
            }
{$manyToManyUpdateSyncCode}            if (\$transactional) {
                if (!\$this->model->writeTransactionStatus()) {
                    throw new RuntimeException('Many-to-many update transaction failed.');
                }
                \$this->model->commitWriteTransaction();
            }
        } catch (\\Throwable \$e) {
            if (\$transactional) {
                \$this->model->rollbackWriteTransaction();
            }
            throw \$e;
        }

PHP;
        } elseif ($writable) {
            $updateBody = <<<PHP
        if (!{$updateModelCall}) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Update failed.');
        }

PHP;
        } else {
            $updateBody = '';
        }

        $updateMethod = $writable ? <<<PHP
    /**
     * Updates this resource.
     *
     * Many-to-many parameters are generated only when this table actually uses them.
     *
     * @param int|string \$id Record identifier.
     * @param array<string, mixed> \$data Main record data.
     * @throws RuntimeException If validation or persistence cannot be completed.
     */
    public function update(
        {$updateSignature}
    ): void {
        \$data = {$prepareUpdateCall};
        \$this->validateUpdatePayload(\$id, \$data);
{$beforeUpdateHook}{$updateBody}{$afterUpdateHook}    }

PHP : '';

        $patchMethod = ($writable && $apiUpdateAllowed) ? <<<PHP
    /**
     * Applies a partial REST update using only rules for fields actually received.
     *
     * The API boundary already filters writable fields; this Service remains
     * authoritative for normalization, validation, hooks, and persistence.
     *
     * @param int|string \$id Record identifier.
     * @param array<string,mixed> \$data Partial application payload.
     * @throws RuntimeException If validation or persistence fails.
     */
    public function patch(int|string \$id, array \$data): void
    {
        \$data = {$prepareUpdateCall};
        \$rules = array_intersect_key({$rulesClass}::updateRules(\$id), \$data);
        if (\$rules !== []) {
            \$this->validatePayload(\$data, \$rules, {$rulesClass}::messages(), 'Patch validation failed.');
        }
{$beforeUpdateHook}        if (!{$updateModelCall}) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Patch failed.');
        }
{$afterUpdateHook}    }

PHP : '';

        $uploadUpdateMethod = ($writable && $hasApiUploadFields) ? <<<PHP
    /**
     * Persists filenames produced by the validated API upload pipeline.
     *
     * Binary validation and storage are owned by CrudUploadManager at the HTTP
     * boundary. This method accepts only generated upload fields and never runs
     * the resource's full Update validation rules.
     *
     * @param int|string \$id Record identifier.
     * @param array<string,mixed> \$data Stored upload filenames keyed by field.
     * @throws RuntimeException If persistence fails.
     */
    public function updateUploads(int|string \$id, array \$data): void
    {
        \$allowed = array_fill_keys(self::API_UPLOAD_FIELDS, true);
        \$data = array_intersect_key(\$data, \$allowed);
        if (\$data === []) {
            return;
        }
        \$data = {$prepareUpdateCall};
{$beforeUpdateHook}        if (!{$updateModelCall}) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Upload update failed.');
        }
{$afterUpdateHook}    }

PHP : '';

        $prepareBlocks = '';
        if ($hasDatabaseManagedFields) {
            $prepareBlocks .= <<<'PHP'
        // Database-managed columns are never accepted from application input.
        foreach (self::DATABASE_MANAGED_FIELDS as $field) {
            unset($data[$field]);
        }

PHP;
        }
        if ($hasAutomaticDateFields) {
            $prepareBlocks .= <<<'PHP'
        // Fill configured automatic application dates on Create only.
        if (!$isUpdate) {
            foreach (self::AUTOMATIC_DATE_FIELDS as $field => $format) {
                if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                    $data[$field] = date($format);
                }
            }
        }

PHP;
        }
        if ($needsEmptyValueNormalization) {
            $nullableSource = $hasNullableFields ? 'self::NULLABLE_FIELDS' : '[]';
            $defaultedSource = $hasDefaultedFields ? 'self::DEFAULTED_FIELDS' : '[]';
            $prepareBlocks .= <<<PHP
        // Empty defaulted values are omitted; empty nullable columns become NULL.
        \$nullable = array_fill_keys({$nullableSource}, true);
        \$defaulted = array_fill_keys({$defaultedSource}, true);
        foreach (\$data as \$field => \$value) {
            if (!is_string(\$value) || trim(\$value) !== '') {
                continue;
            }
            if (isset(\$defaulted[\$field])) {
                unset(\$data[\$field]);
                continue;
            }
            if (isset(\$nullable[\$field])) {
                \$data[\$field] = null;
            }
        }

PHP;
        }
        if ($hasNullableForeignKeyFields) {
            $prepareBlocks .= <<<'PHP'
        // HTML empty strings for nullable foreign keys are persisted as SQL NULL.
        foreach (self::NULLABLE_FOREIGN_KEY_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }
            $value = $data[$field];
            if ($value !== null && is_scalar($value) && trim((string) $value) === '') {
                $data[$field] = null;
            }
        }

PHP;
        }
        if ($hasDateTimeFields) {
            $prepareBlocks .= <<<'PHP'
        // Convert datetime-local input to the database-friendly representation.
        foreach (self::DATE_TIME_FIELDS as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = str_replace('T', ' ', $data[$field]);
            }
        }

PHP;
        }
        if ($hasPasswordFields) {
            $prepareBlocks .= <<<'PHP'
        // Hash configured password fields; blank passwords are ignored on Update.
        foreach (self::PASSWORD_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }
            $value = trim((string) $data[$field]);
            if ($value === '') {
                if ($isUpdate) {
                    unset($data[$field]);
                }
                continue;
            }
            $data[$field] = password_hash($value, PASSWORD_DEFAULT);
        }

PHP;
        }

        if ($createAllowed || $writable) {
            $prepareSignature = $prepareNeedsUpdateFlag
                ? 'array $data, bool $isUpdate'
                : 'array $data';
            $prepareUpdateDoc = $prepareNeedsUpdateFlag
                ? "     * @param bool \$isUpdate True for Update, false for Create.\n"
                : '';
            $prepareMethod = <<<PHP
    /**
     * Normalizes only the features that are present in this table's schema.
     * No query is executed here.
     *
     * @param array<string, mixed> \$data
{$prepareUpdateDoc}     * @return array<string, mixed>
     */
    private function prepareData({$prepareSignature}): array
    {
{$prepareBlocks}        return \$data;
    }

PHP;
        } else {
            $prepareMethod = '';
        }

        $deleteMethod = $writable ? <<<PHP
    /**
     * Deletes the record according to the Model soft-delete policy.
     *
     * @throws RuntimeException If deletion fails.
     */
    public function delete(int|string \$id): void
    {
{$beforeDeleteHook}        if (!\$this->model->delete(\$id)) {
            throw new RuntimeException('Delete failed.');
        }
        \$this->model->clearListCountCache();
{$afterDeleteHook}    }

PHP : '';

        $softMethods = $softDeleteEnabled ? <<<'PHP'
    /** @throws RuntimeException Se il ripristino non riesce. */
    public function restore(int|string $id): void
    {
        if (!$this->model->restoreRecord($id)) {
            throw new RuntimeException('Ripristino non riuscito.');
        }
        $this->model->clearListCountCache();
    }

    /** @throws RuntimeException If permanent deletion fails. */
    public function forceDelete(int|string $id): void
    {
        if (!$this->model->delete($id, true)) {
            throw new RuntimeException('Permanent delete failed.');
        }
        $this->model->clearListCountCache();
    }

PHP : '';

        $needsRuntimeException = $createAllowed || $writable || $softDeleteEnabled;
        $runtimeUse = $needsRuntimeException ? "use RuntimeException;\n" : '';
        $modelUse = "use App\\Models\\{$modelClass};\n";
        $entityUse = $useEntity ? "use App\\Entities\\{$entityClass};\n" : '';
        $rulesUse = $createAllowed ? "use App\\Validation\\{$rulesClass};\n" : '';

        if ($isView) {
            $classDoc = <<<DOC
/**
 * Service read-only per la SQL VIEW `{$table}`.
 *
 * Responsabilità:
 * No application Service is required for read-only operations.
 * Queries remain the responsibility of {$modelClass}.
 */
DOC;
        } elseif ($createAllowed && !$writable) {
            $classDoc = <<<DOC
/**
 * Write Service for `{$table}`.
 *
 * The table exposes Create but no record-level Update/Delete identity.
 * Read/query operations remain in {$modelClass}; this Service owns write preparation,
 * validation and orchestration only.
 */
DOC;
        } elseif ($readOnly) {
            $classDoc = <<<DOC
/**
 * No-op Service shell for read-only table `{$table}`.
 *
 * Read/query operations remain in {$modelClass}. This class is kept only when
 * required by the selected architecture and contains no read pass-through methods.
 */
DOC;
        } else {
            $extensionDoc = $extensionEnabled
                ? '- invoca gli hook custom definiti nel ServiceExtension persistente;'
                : '- does not expose write Extension Points;';
            $classDoc = <<<DOC
/**
 * Service applicativo per la risorsa `{$table}`.
 *
 * Responsabilità:
 * - owns write use-cases only: create, update, delete and related creation;
 * - validates and normalizes application data before persistence;
 * - orchestrates writes across related Services without composing SQL;
 * - delegates transactions and persistence to the Model;
 * {$extensionDoc}
 *
 * Queries remain the responsibility of {$modelClass}.
 */
DOC;
        }

        $constants = '';
        if ($createAllowed || $writable) {
            if ($hasPasswordFields) {
                $constants .= "    private const PASSWORD_FIELDS = {$passwordFieldsCode};\n";
            }
            if ($hasAutomaticDateFields) {
                $constants .= "    private const AUTOMATIC_DATE_FIELDS = {$automaticDateFieldsCode};\n";
            }
            if ($hasDatabaseManagedFields) {
                $constants .= "    private const DATABASE_MANAGED_FIELDS = {$databaseManagedFieldsCode};\n";
            }
            if ($hasNullableForeignKeyFields) {
                $constants .= "    private const NULLABLE_FOREIGN_KEY_FIELDS = {$nullableForeignKeyFieldsCode};\n";
            }
            if ($hasDateTimeFields) {
                $constants .= "    private const DATE_TIME_FIELDS = {$dateTimeFieldsCode};\n";
            }
            if ($hasNullableFields) {
                $constants .= "    private const NULLABLE_FIELDS = {$nullableFieldsCode};\n";
            }
            if ($hasDefaultedFields) {
                $constants .= "    private const DEFAULTED_FIELDS = {$defaultedFieldsCode};\n";
            }
            if ($hasApiUploadFields) {
                $constants .= "    private const API_UPLOAD_FIELDS = {$apiUploadFieldsCode};\n";
            }
            if ($constants !== '') {
                $constants .= "\n";
            }
        }

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Services;

{$extensionUse}{$entityUse}{$modelUse}{$rulesUse}{$runtimeUse}
{$classDoc}
final class {$class}
{
{$extensionTrait}{$constants}    public function __construct(private readonly {$modelClass} \$model = new {$modelClass}())
    {
    }

{$relatedServiceHelpers}{$manyToManyRelatedServiceHelpers}{$validationMethods}{$createRelatedEntryPoint}{$createMethod}{$updateMethod}{$patchMethod}{$uploadUpdateMethod}{$prepareMethod}{$deleteMethod}{$softMethods}}

PHP;

        return $this->writeGenerated("Generated/Services/{$class}.php", $content, $force);
    }
}
