<?php
namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Schema\DbSchema;
use Config\MyCrud;
use InvalidArgumentException;

class ConfigBuilder
{
    private const ARCHITECTURES = ['basic', 'standard', 'full'];

    private const INPUT_TYPES = [
        'text', 'number', 'email', 'password', 'date', 'datetime-local',
        'time', 'month', 'week', 'color', 'checkbox', 'radio', 'select',
        'file', 'image', 'hidden', 'range', 'search', 'tel', 'url', 'textarea',
    ];

    private const VALUE_ATTRIBUTES = [
        'maxlength', 'minlength', 'min', 'max', 'step', 'pattern', 'placeholder',
        'accept', 'autocomplete',
    ];

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
        $indexMetadata = $this->indexMetadata($info['indexes']);
        $fields = [];
        $languageFile = Naming::studly($table);

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
                'index' => $indexMetadata[$name] ?? [
                    'indexed' => false,
                    'leading' => false,
                    'primary' => false,
                    'unique' => false,
                    'indexes' => [],
                ],
                'foreignKey' => $relations['belongsTo'][$name] ?? null,
                'inputType' => $this->inferInputType(
                    $column,
                    isset($relations['belongsTo'][$name])
                ),
                'label' => '',
                'defaultLabel' => $this->labels->resolve($name),
                'languageKey' => $languageFile . '.' . $name,
                'width' => 6,
                'attributes' => $this->inferAttributes($column),
                'ui' => $this->inferUi(
                    $column,
                    $indexMetadata[$name] ?? [],
                    isset($relations['belongsTo'][$name])
                ),
            ];
        }

        $fields = $this->applyDefaultListVisibility($fields, (string) $info['primaryKey']);

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
            'list' => [
                'filtersSummary' => 'Filtri di ricerca',
            ],
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

            $requestedInputType = (string) ($post['inputType'][$name] ?? $field['inputType']);
            $field['inputType'] = in_array($requestedInputType, self::INPUT_TYPES, true)
                ? $requestedInputType
                : (string) $field['inputType'];
            $field['width'] = max(1, min(12, (int) ($post['width'][$name] ?? 6)));

            $boolean = array_values(array_intersect(
                (array) ($post['attrBool'][$name] ?? []),
                ['required', 'readonly', 'disabled']
            ));

            if (in_array('disabled', $boolean, true)) {
                $boolean = array_values(array_diff($boolean, ['required']));
            }

            $field['attributes']['boolean'] = $boolean;
            $postedValues = (array) ($post['attrVal'][$name] ?? []);
            $field['attributes']['values'] = [];
            foreach (self::VALUE_ATTRIBUTES as $attribute) {
                $value = $postedValues[$attribute] ?? null;
                if ($value !== '' && $value !== null) {
                    $field['attributes']['values'][$attribute] = (string) $value;
                }
            }

            if (array_key_exists($name, (array) ($post['ui'] ?? []))) {
                $postedUi = array_values(array_intersect(
                    (array) $post['ui'][$name],
                    ['searchable', 'sortable', 'visibleIndex', 'visibleForm', 'visibleView', 'sensitive', 'exportable']
                ));
                foreach (['searchable', 'sortable', 'visibleIndex', 'visibleForm', 'visibleView', 'sensitive', 'exportable'] as $flag) {
                    $field['ui'][$flag] = in_array($flag, $postedUi, true);
                }
            }
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
        $config['list']['filtersSummary'] = trim((string) (
            $post['list']['filtersSummary']
            ?? $config['list']['filtersSummary']
            ?? 'Filtri di ricerca'
        ));
        if ($config['list']['filtersSummary'] === '') {
            $config['list']['filtersSummary'] = 'Filtri di ricerca';
        }

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

        $merged = array_replace_recursive($base, $saved);
        $architecture = $this->normalizeArchitecture((string) ($merged['architecture'] ?? $base['architecture'] ?? 'basic'));
        $baseFeatures = $this->featuresFor(
            $architecture,
            !empty($merged['softDelete']['available'])
        );

        foreach (['relations', 'timestamps', 'softDeletes'] as $feature) {
            if (array_key_exists($feature, (array) ($merged['features'] ?? []))) {
                $baseFeatures[$feature] = !empty($merged['features'][$feature]);
            }
        }

        if (empty($merged['softDelete']['available'])) {
            $baseFeatures['softDeletes'] = false;
        }

        $merged['architecture'] = $architecture;
        $merged['features'] = $baseFeatures;

        return $this->finalize($merged);
    }

    private function finalize(array $config): array
    {
        $entity = Naming::singularStudly($config['table']);
        $languageFile = Naming::studly((string) $config['table']);

        foreach ((array) ($config['fields'] ?? []) as $name => &$field) {
            $field['languageKey'] = $languageFile . '.' . $name;
            $inputType = (string) ($field['inputType'] ?? 'text');
            if (FieldPolicy::isSensitive((string) $name, $inputType)) {
                $field['ui']['sensitive'] = true;
                $field['ui']['visibleIndex'] = false;
                $field['ui']['visibleView'] = false;
                $field['ui']['visibleForm'] = FieldPolicy::isPassword((string) $name, $inputType);
                $field['ui']['searchable'] = false;
                $field['ui']['sortable'] = false;
                $field['ui']['exportable'] = false;
            }
        }
        unset($field);

        $config['languageFile'] = $languageFile;
        $config['list']['filtersSummary'] = trim((string) ($config['list']['filtersSummary'] ?? 'Filtri di ricerca')) ?: 'Filtri di ricerca';

        $config['classes'] = [
            'entity' => $entity . 'Entity',
            'model' => $entity . 'Model',
            'service' => $entity . 'Service',
            'controller' => $entity . 'Controller',
            'api' => $entity . 'ApiController',
            'resource' => $entity . 'Resource',
            'rules' => $entity . 'Rules',
            'apiRules' => $entity . 'ApiRules',
        ];
        $config['dataStyle'] = 'object';

        return $config;
    }

    private function normalizeArchitecture(string $architecture): string
    {
        $architecture = strtolower(trim($architecture));

        return in_array($architecture, self::ARCHITECTURES, true)
            ? $architecture
            : 'basic';
    }

    private function featuresFor(string $architecture, bool $softAvailable): array
    {
        $architecture = $this->normalizeArchitecture($architecture);

        return [
            'entity'        => in_array($architecture, ['standard', 'full'], true),
            'service'       => in_array($architecture, ['standard', 'full'], true),
            'api'           => $architecture === 'full',
            'ajaxList'      => true,
            'csvExport'     => true,
            'wordExport'    => true,
            'datatable'     => false,
            'relations'     => true,
            'softDeletes'   => $softAvailable,
            'timestamps'    => true,
            'exportButtons' => true,
        ];
    }

    private function featuresFromPost(
        array $post,
        string $architecture,
        bool $softDeleteAvailable
    ): array {
        $features = $this->featuresFor($architecture, $softDeleteAvailable);
        $postedFeatures = (array) ($post['features'] ?? []);

        // Queste feature restano configurabili; Entity, Service e API dipendono
        // esclusivamente dall'architettura selezionata.
        foreach (['relations', 'softDeletes', 'timestamps'] as $name) {
            if (array_key_exists($name, $postedFeatures)) {
                $features[$name] = !empty($postedFeatures[$name]);
            }
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
        if (FieldPolicy::isPassword($name)) return 'password';
        if (str_contains($name, 'url') || str_contains($name, 'website')) return 'url';

        $columnType = strtolower((string) ($column['columnType'] ?? ''));

        return match (true) {
            $type === 'text' || str_contains($type, 'blob') => 'textarea',
            $type === 'date' => 'date',
            in_array($type, ['datetime', 'timestamp'], true) => 'datetime-local',
            $type === 'time' => 'time',
            $type === 'bool' || $type === 'boolean' || preg_match('/^tinyint\(1\)/', $columnType) === 1 => 'checkbox',
            preg_match('/int|decimal|float|double|numeric/', $type) === 1 => 'number',
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


    private function inferUi(array $column, array $index, bool $foreignKey): array
    {
        $name = strtolower((string) ($column['name'] ?? ''));
        $type = strtolower((string) ($column['type'] ?? ''));
        $columnType = strtolower((string) ($column['columnType'] ?? ''));
        $inputType = $this->inferInputType($column, $foreignKey);
        $sensitive = FieldPolicy::isSensitive($name, $inputType);
        $large = in_array($type, ['text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'], true);
        $binary = str_contains($type, 'blob') || str_contains($type, 'binary');
        $indexed = !empty($index['leading']) || !empty($index['primary']) || !empty($index['unique']);
        $boolean = $type === 'bool' || $type === 'boolean' || preg_match('/^tinyint\(1\)/', $columnType) === 1;

        $filterMode = match (true) {
            $foreignKey, !empty($index['primary']), !empty($index['unique']), $boolean => 'exact',
            in_array($type, ['date', 'datetime', 'timestamp'], true) => 'range',
            preg_match('/int|decimal|float|double|numeric/', $type) === 1 => 'exact',
            default => 'prefix',
        };

        $softDeleteField = $name === strtolower((string) $this->config->softDeleteField);
        $managed = FieldPolicy::isTechnical($name, (string) $this->config->softDeleteField);

        return [
            // Per dataset grandi i filtri e l'ordinamento vengono proposti solo
            // sui campi che guidano un indice. Il Builder può fare override.
            'searchable'   => !$managed && !$sensitive && !$large && $indexed,
            'sortable'     => !$managed && !$large && !$binary && $indexed,
            'visibleIndex' => !$managed && !$sensitive && !$large,
            'visibleForm'  => !$managed && (!$sensitive || FieldPolicy::isPassword($name, $inputType)),
            'visibleView'  => !$sensitive && !$managed,
            'sensitive'    => $sensitive,
            'exportable'   => !$managed && !$sensitive && !$binary,
            'filterMode'   => $filterMode,
        ];
    }

    /**
     * Limita la lista iniziale ai campi più utili, lasciando il Builder libero
     * di abilitare o disabilitare ogni colonna.
     */
    private function applyDefaultListVisibility(array $fields, string $primaryKey): array
    {
        $preferred = [];
        $fallback = [];

        foreach ($fields as $name => $field) {
            $ui = (array) ($field['ui'] ?? []);
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));

            if (
                !empty($ui['sensitive'])
                || FieldPolicy::isTechnical((string) $name, (string) $this->config->softDeleteField)
                || in_array($type, ['text', 'mediumtext', 'longtext'], true)
                || FieldPolicy::isLargeOrBinary($type, $inputType)
            ) {
                $fields[$name]['ui']['visibleIndex'] = false;
                continue;
            }

            $fallback[] = (string) $name;
            if (
                (string) $name === $primaryKey
                || !empty($field['foreignKey'])
                || preg_match('/(?:^|_)(?:nome|name|titolo|title|codice|code|email|tel|telefono|phone|tipo|type|stato|status|data|date|prezzo|price|importo|amount|quantita|quantity)(?:$|_)/i', (string) $name) === 1
            ) {
                $preferred[] = (string) $name;
            }
        }

        $selected = array_values(array_unique(array_merge([$primaryKey], $preferred, $fallback)));
        $selected = array_slice($selected, 0, 10);

        foreach ($fields as $name => &$field) {
            if (!empty($field['ui']['sensitive'])) {
                $field['ui']['visibleIndex'] = false;
                continue;
            }
            $field['ui']['visibleIndex'] = in_array((string) $name, $selected, true);
        }
        unset($field);

        return $fields;
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

    /**
     * @return array<string, array{indexed: bool, leading: bool, primary: bool, unique: bool, indexes: list<array<string, mixed>>}>
     */
    private function indexMetadata(array $indexes): array
    {
        $metadata = [];

        foreach ($indexes as $index) {
            $column = (string) ($index['columnName'] ?? '');
            $name = (string) ($index['indexName'] ?? '');

            if ($column === '' || $name === '') {
                continue;
            }

            $sequence = max(1, (int) ($index['sequence'] ?? 1));
            $primary = $name === 'PRIMARY';
            $unique = $primary || (int) ($index['nonUnique'] ?? 1) === 0;

            $metadata[$column] ??= [
                'indexed' => true,
                'leading' => false,
                'primary' => false,
                'unique' => false,
                'indexes' => [],
            ];

            $metadata[$column]['leading'] = $metadata[$column]['leading'] || $sequence === 1;
            $metadata[$column]['primary'] = $metadata[$column]['primary'] || $primary;
            $metadata[$column]['unique'] = $metadata[$column]['unique'] || ($unique && $sequence === 1);
            $metadata[$column]['indexes'][] = [
                'name' => $name,
                'sequence' => $sequence,
                'unique' => $unique,
                'type' => (string) ($index['indexType'] ?? ''),
            ];
        }

        return $metadata;
    }

    private function uniqueFields(array $indexes): array
    {
        $groups = [];
        foreach ($indexes as $index) {
            $name = (string) ($index['indexName'] ?? '');
            if ($name === '' || $name === 'PRIMARY' || (int) ($index['nonUnique'] ?? 1) !== 0) {
                continue;
            }
            $groups[$name][] = (string) ($index['columnName'] ?? '');
        }

        $unique = [];
        foreach ($groups as $columns) {
            $columns = array_values(array_filter(array_unique($columns)));
            // is_unique di CI4 descrive una singola colonna, non un indice composto.
            if (count($columns) === 1) {
                $unique[] = $columns[0];
            }
        }

        return array_values(array_unique($unique));
    }
}
