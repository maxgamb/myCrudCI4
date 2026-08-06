<?php
namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Schema\DbSchema;
use Config\MyCrud;
use InvalidArgumentException;

class ConfigBuilder
{
    private const ARCHITECTURES = ['basic', 'standard', 'full'];

    private DbSchema $schema;
    private RelationResolver $relations;
    private MyCrud $config;
    private FieldLabelResolver $labels;

    public function __construct(
        ?DbSchema $schema = null,
        ?RelationResolver $relations = null,
        ?MyCrud $config = null,
        ?FieldLabelResolver $labels = null
    ) {
        $this->schema = $schema ?? new DbSchema();
        $this->relations = $relations ?? new RelationResolver($this->schema);
        $this->config = $config ?? config('MyCrud');
        $this->labels = $labels ?? new FieldLabelResolver();
    }

    public function buildFromTable(string $table): array
    {
        $info = $this->schema->getTableInfo($table);
        $relations = $this->relations->resolve($table);
        $uniqueFields = $this->uniqueFields($info['indexes']);
        $fields = [];

        foreach ($info['columns'] as $column) {
            $name = $column['name'];

            $fields[$name] = [
                'name' => $name,
                'type' => strtolower((string) $column['type']),
                'columnType' => strtolower((string) $column['columnType']),
                'nullable' => ($column['nullable'] ?? 'YES') === 'YES',
                'default' => $column['defaultValue'],
                'maxLength' => $column['maxLength'],
                'numericPrecision' => $column['numericPrecision'],
                'numericScale' => $column['numericScale'],
                'primary' => $name === $info['primaryKey'],
                'autoIncrement' => str_contains((string) $column['extra'], 'auto_increment'),
                'unique' => in_array($name, $uniqueFields, true),
                'foreignKey' => $relations['belongsTo'][$name] ?? null,
                'inputType' => $this->inferInputType(
                    $column,
                    isset($relations['belongsTo'][$name])
                ),
                'label' => '',
                'defaultLabel' => $this->labels->resolve($name),
                'languageKey' => 'Fields.' . $name,
                'width' => 6,
                'attributes' => $this->inferAttributes($column),
            ];
        }

        $deletedField = $this->config->softDeleteField;
        $softAvailable = isset($fields[$deletedField])
            && $fields[$deletedField]['nullable']
            && in_array($fields[$deletedField]['type'], ['date', 'datetime', 'timestamp'], true);

        $architecture = $this->normalizeArchitecture($this->config->defaultArchitecture);

        return $this->finalize([
            'table' => $table,
            'primaryKey' => $info['primaryKey'],
            'architecture' => $architecture,
            'fields' => $fields,
            'order' => array_keys($fields),
            'relations' => $relations,
            'relationsConfig' => [
                'hasMany' => $this->buildHasManyConfig($relations['hasMany'] ?? []),
            ],
            'features' => $this->featuresFor($architecture, $softAvailable),
            'softDelete' => ['available' => $softAvailable, 'field' => $deletedField],
        ]);
    }

    public function buildFromRequest(array $post): array
    {
        $table = trim((string) ($post['table'] ?? ''));

        if ($table === '') {
            throw new InvalidArgumentException('Nome tabella mancante.');
        }

        $config = $this->buildFromTable($table);
        $architecture = $this->normalizeArchitecture(
            (string) ($post['architecture'] ?? $config['architecture'])
        );

        foreach ($config['fields'] as $name => &$field) {
            // Vuoto = usa lang('Fields.nome_campo'); valorizzato = label personalizzata.
            $field['label'] = trim((string) ($post['label'][$name] ?? ''));

            $field['inputType'] = (string) ($post['inputType'][$name] ?? $field['inputType']);
            $field['width'] = max(1, min(12, (int) ($post['width'][$name] ?? 6)));

            $boolean = array_values(array_intersect(
                (array) ($post['attrBool'][$name] ?? []),
                ['required', 'readonly', 'disabled']
            ));

            if (in_array('disabled', $boolean, true)) {
                $boolean = array_values(array_diff($boolean, ['required']));
            }

            $field['attributes']['boolean'] = $boolean;
            $field['attributes']['values'] = array_filter(
                (array) ($post['attrVal'][$name] ?? []),
                static fn ($value): bool => $value !== '' && $value !== null
            );
        }
        unset($field);

        $config['architecture'] = $architecture;
        $config['order'] = array_values(array_filter(
            (array) ($post['order'] ?? $config['order'])
        ));
        $config['features'] = $this->featuresFromPost(
            $post,
            $architecture,
            $config['softDelete']['available']
        );

        $config['relationsConfig']['hasMany'] = $this->hasManyConfigFromPost(
            $post,
            $config['relationsConfig']['hasMany'] ?? []
        );

        return $this->finalize($config);
    }

    public function mergeSavedConfiguration(array $base, array $saved): array
    {
        $saved['table'] = $base['table'];

        /*
         * Migrazione delle vecchie configurazioni:
         * una label uguale al valore automatico non è una personalizzazione.
         * In questo caso la riportiamo a stringa vuota, così la view genera
         * lang('Fields.nome_campo').
         */
        foreach ($base['fields'] as $name => $baseField) {
            if (!isset($saved['fields'][$name])) {
                continue;
            }

            $savedLabel = trim((string) ($saved['fields'][$name]['label'] ?? ''));
            $defaultLabel = trim((string) ($baseField['defaultLabel'] ?? ''));
            $humanLabel = Naming::human($name);

            if (
                $savedLabel === ''
                || $savedLabel === $defaultLabel
                || $savedLabel === $humanLabel
            ) {
                $saved['fields'][$name]['label'] = '';
            }
        }

        return array_replace_recursive($base, $saved);
    }

    private function finalize(array $config): array
    {
        $entity = Naming::singularStudly($config['table']);

        $config['classes'] = [
            'entity' => $entity . 'Entity',
            'model' => $entity . 'Model',
            'service' => $entity . 'Service',
            'controller' => $entity . 'Controller',
            'api' => $entity . 'ApiController',
            'rules' => $entity . 'Rules',
        ];
        $config['dataStyle'] = 'object';

        return $config;
    }

    private function normalizeArchitecture(string $architecture): string
    {
        $architecture = strtolower(trim($architecture));

        return in_array($architecture, self::ARCHITECTURES, true)
            ? $architecture
            : 'standard';
    }

    private function featuresFor(string $architecture, bool $softAvailable): array
    {
        return match ($architecture) {
            'basic' => [
                'entity'=>false, 'service'=>false, 'api'=>false,
                'datatable'=>true, 'relations'=>true, 'softDeletes'=>false,
                'timestamps'=>false, 'exportButtons'=>true,
            ],
            'full' => [
                'entity'=>true, 'service'=>true, 'api'=>true,
                'datatable'=>true, 'relations'=>true, 'softDeletes'=>$softAvailable,
                'timestamps'=>true, 'exportButtons'=>true,
            ],
            default => [
                'entity'=>true, 'service'=>true, 'api'=>false,
                'datatable'=>true, 'relations'=>true, 'softDeletes'=>false,
                'timestamps'=>true, 'exportButtons'=>true,
            ],
        };
    }

    private function featuresFromPost(
        array $post,
        string $architecture,
        bool $softDeleteAvailable
    ): array {
        $features = $this->featuresFor(
            $architecture,
            $softDeleteAvailable
        );

        $postedFeatures = (array) ($post['features'] ?? []);

        /*
         * Queste feature restano configurabili dal Builder.
         * Entity, Service e API sono invece determinate obbligatoriamente
         * dall'architettura selezionata.
         */
        foreach (
            [
                'datatable',
                'relations',
                'softDeletes',
                'timestamps',
                'exportButtons',
            ]
            as $name
        ) {
            $features[$name] = !empty($postedFeatures[$name]);
        }

        switch ($architecture) {
            case 'basic':
                $features['entity'] = false;
                $features['service'] = false;
                $features['api'] = false;
                break;

            case 'standard':
                $features['entity'] = true;
                $features['service'] = true;
                $features['api'] = false;
                break;

            case 'full':
                $features['entity'] = true;
                $features['service'] = true;
                $features['api'] = true;
                break;
        }

        if (!$softDeleteAvailable) {
            $features['softDeletes'] = false;
        }

        return $features;
    }

    private function inferInputType(array $column, bool $foreignKey): string
    {
        if ($foreignKey) return 'select';

        $name = strtolower((string) $column['name']);
        $type = strtolower((string) $column['type']);

        if (str_contains($name, 'email')) return 'email';
        if (str_contains($name, 'password')) return 'password';
        if (str_contains($name, 'url') || str_contains($name, 'website')) return 'url';

        return match (true) {
            $type === 'text' || str_contains($type, 'blob') => 'textarea',
            $type === 'date' => 'date',
            in_array($type, ['datetime', 'timestamp'], true) => 'datetime-local',
            $type === 'time' => 'time',
            preg_match('/int|decimal|float|double|numeric/', $type) === 1 => 'number',
            preg_match('/bool|tinyint/', $type) === 1 => 'checkbox',
            default => 'text',
        };
    }

    private function inferAttributes(array $column): array
    {
        $boolean = [];
        $values = [];

        if (
            ($column['nullable'] ?? 'YES') === 'NO'
            && ($column['defaultValue'] ?? null) === null
            && !str_contains((string) ($column['extra'] ?? ''), 'auto_increment')
        ) {
            $boolean[] = 'required';
        }

        if (!empty($column['maxLength'])) {
            $values['maxlength'] = (string) $column['maxLength'];
        }

        return ['boolean' => $boolean, 'values' => $values];
    }

    private function buildHasManyConfig(array $relations): array
    {
        $config = [];

        foreach ($relations as $key => $relation) {
            $config[$key] = [
                'enabled' => true,
                'mode' => 'readonly',
                'title' => Naming::human((string) $relation['childTable']),
                'icon' => 'bi-diagram-3',
                'childTable' => $relation['childTable'],
                'foreignKey' => $relation['foreignKey'],
                'parentKey' => $relation['parentKey'],
                'primaryKey' => $relation['childPrimaryKey'],
                'columns' => $relation['columns'] ?? [],
                'displayField' => $relation['displayField'],
                'limit' => 20,
                'showCount' => true,
                'showViewButton' => true,
            ];
        }

        return $config;
    }

    private function hasManyConfigFromPost(array $post, array $base): array
    {
        $posted = (array) ($post['relationsConfig']['hasMany'] ?? []);

        foreach ($base as $key => &$relation) {
            $input = (array) ($posted[$key] ?? []);

            $relation['enabled'] = !empty($input['enabled']);
            $relation['title'] = trim((string) ($input['title'] ?? $relation['title']));
            $relation['icon'] = trim((string) ($input['icon'] ?? $relation['icon']));
            $relation['limit'] = max(1, min(200, (int) ($input['limit'] ?? 20)));
            $relation['showCount'] = !empty($input['showCount']);
            $relation['showViewButton'] = !empty($input['showViewButton']);

            $allowedColumns = array_values(array_unique((array) ($relation['columns'] ?? [])));
            $selectedColumns = array_values(array_intersect(
                (array) ($input['columns'] ?? []),
                $allowedColumns
            ));

            $relation['columns'] = $selectedColumns ?: $allowedColumns;
        }
        unset($relation);

        return $base;
    }

    private function uniqueFields(array $indexes): array
    {
        $unique = [];

        foreach ($indexes as $index) {
            if (
                (int) ($index['nonUnique'] ?? 1) === 0
                && ($index['indexName'] ?? '') !== 'PRIMARY'
            ) {
                $unique[] = (string) $index['columnName'];
            }
        }

        return array_values(array_unique($unique));
    }
}
