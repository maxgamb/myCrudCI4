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
        $primaryKeys = array_values((array) ($info['primaryKeys'] ?? []));
        $isView = !empty($info['isView']);
        $compositePrimaryKey = !empty($info['compositePrimaryKey']);
        // Una VIEW non espone una identità modificabile affidabile. Le PK
        // composte restano protette per View/Edit/Delete finché le route non
        // supportano un'identità multipla, ma INSERT/CREATE è sicuro perché
        // non richiede di indirizzare un record preesistente.
        $readOnly = $isView || $compositePrimaryKey || $primaryKeys === [];
        $createAllowed = !$isView && $primaryKeys !== [];
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
                'extra' => (string) ($column['extra'] ?? ''),
                'defaultGenerated' => str_contains(strtolower((string) ($column['extra'] ?? '')), 'default_generated'),
                'autoOnUpdate' => preg_match('/on\s+update\s+current_timestamp(?:\([0-9]*\))?/i', (string) ($column['extra'] ?? '')) === 1,
                'databaseManaged' => FieldPolicy::isDatabaseManagedTimestamp($column),
                'maxLength' => $column['maxLength'],
                'numericPrecision' => $column['numericPrecision'],
                'numericScale' => $column['numericScale'],
                'primary' => in_array($name, $primaryKeys, true),
                'autoIncrement' => str_contains(strtolower((string) ($column['extra'] ?? '')), 'auto_increment'),
                'unique' => in_array($name, $uniqueFields, true),
                'index' => $indexMetadata[$name] ?? [
                    'indexed' => false,
                    'leading' => false,
                    'primary' => false,
                    'unique' => false,
                    'indexes' => [],
                ],
                'foreignKey' => $relations['belongsTo'][$name] ?? null,
                'relationMode' => (string) (($relations['belongsTo'][$name]['optionMode'] ?? '') ?: ''),
                'relationRowEstimate' => max(0, (int) ($relations['belongsTo'][$name]['rowEstimate'] ?? 0)),
                'relationDisplayField' => (string) ($relations['belongsTo'][$name]['displayField'] ?? ''),
                'relationDisplayTemplate' => '',
                'relationNavigation' => isset($relations['belongsTo'][$name]) ? [
                    // Una FK reale può essere usata in sicurezza come contesto del Create:
                    // il valore viene comunque verificato server-side sulla tabella padre.
                    // Le altre opzioni di navigazione restano scelte applicative.
                    'quickFilter' => false,
                    'parentLink' => false,
                    'acceptContext' => true,
                    'createParentLink' => false,
                ] : [],
                'relationNavigationCustomized' => false,
                'relationCreate' => isset($relations['belongsTo'][$name]) ? [
                    'available' => !empty($relations['belongsTo'][$name]['relatedCreate']['available']),
                    'enabled' => false,
                ] : [],
                'uiVisibilityCustomized' => false,
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
        $features = $this->featuresFor($architecture, $softAvailable && !$readOnly);
        $features['readOnly'] = $readOnly;
        $features['createAllowed'] = $createAllowed;
        $features['writable'] = !$readOnly;
        $features['recordDetail'] = !$readOnly;
        $features['recordActions'] = !$readOnly;
        $features['readOnlyReason'] = $isView
            ? 'database_view'
            : ($compositePrimaryKey ? 'composite_primary_key' : ($primaryKeys === [] ? 'missing_primary_key' : ''));

        return $this->finalize([
            'table' => $table,
            'primaryKey' => $info['primaryKey'],
            'primaryKeys' => $primaryKeys,
            'hasPrimaryKey' => $primaryKeys !== [],
            'compositePrimaryKey' => $compositePrimaryKey,
            'tableType' => (string) ($info['tableType'] ?? 'BASE TABLE'),
            'isView' => $isView,
            'tableStats' => [
                'rowEstimate' => max(0, (int) ($info['rowEstimate'] ?? 0)),
                'dataLength' => max(0, (int) ($info['dataLength'] ?? 0)),
                'indexLength' => max(0, (int) ($info['indexLength'] ?? 0)),
            ],
            'architecture' => $architecture,
            'fields' => $fields,
            'order' => array_keys($fields),
            'relations' => $relations,
            'relationsConfig' => [
                'hasMany' => $this->buildHasManyConfig($relations['hasMany'] ?? []),
            ],
            'features' => $features,
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

            if (!empty($field['foreignKey'])) {
                $requestedRelationMode = strtolower(trim((string) (
                    $post['relationMode'][$name]
                    ?? $field['relationMode']
                    ?? 'select'
                )));
                $field['relationMode'] = in_array($requestedRelationMode, ['select', 'ajax'], true)
                    ? $requestedRelationMode
                    : 'select';

                $foreignKey = (array) $field['foreignKey'];
                $availableDisplayFields = array_values(array_unique(array_filter(
                    (array) ($foreignKey['availableDisplayFields'] ?? []),
                    static fn ($value): bool => is_string($value) && $value !== ''
                )));
                $requestedDisplayField = trim((string) (
                    $post['relationDisplayField'][$name]
                    ?? $field['relationDisplayField']
                    ?? $foreignKey['displayField']
                    ?? ''
                ));
                if ($requestedDisplayField === '' || !in_array($requestedDisplayField, $availableDisplayFields, true)) {
                    $requestedDisplayField = (string) ($foreignKey['displayField'] ?? $foreignKey['parentKey'] ?? '');
                }
                $field['relationDisplayField'] = $requestedDisplayField;

                $requestedTemplate = trim((string) (
                    $post['relationDisplayTemplate'][$name]
                    ?? $field['relationDisplayTemplate']
                    ?? ''
                ));
                $field['relationDisplayTemplate'] = $this->sanitizeDisplayTemplate(
                    $requestedTemplate,
                    $availableDisplayFields
                );

                $postedNavigation = array_values(array_intersect(
                    (array) ($post['relationNavigation'][$name] ?? []),
                    ['quickFilter', 'parentLink', 'acceptContext', 'createParentLink']
                ));
                foreach (['quickFilter', 'parentLink', 'acceptContext', 'createParentLink'] as $flag) {
                    $field['relationNavigation'][$flag] = in_array($flag, $postedNavigation, true);
                }
                // Il Builder rappresenta una scelta esplicita dello sviluppatore.
                // La Quick non sovrascriverà queste opzioni nelle rigenerazioni successive.
                $field['relationNavigationCustomized'] = true;

                $relatedCreateAvailable = !empty($field['foreignKey']['relatedCreate']['available']);
                $field['relationCreate'] = [
                    'available' => $relatedCreateAvailable,
                    'enabled' => $relatedCreateAvailable && !empty($post['relationCreate'][$name]),
                ];

                // Relational Create sostituisce il vecchio link di navigazione "Nuovo padre".
                // Le due UX non devono convivere: la creazione inline preserva il form corrente,
                // mentre createParentLink porta su una pagina separata e farebbe perdere i dati non salvati.
                if (!empty($field['relationCreate']['enabled'])) {
                    $field['relationNavigation']['createParentLink'] = false;
                }
            }

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
                    ['searchable', 'sortable', 'visibleIndex', 'visibleForm', 'visibleView', 'sensitive', 'exportable', 'apiVisible']
                ));
                foreach (['searchable', 'sortable', 'visibleIndex', 'visibleForm', 'visibleView', 'sensitive', 'exportable', 'apiVisible'] as $flag) {
                    $field['ui'][$flag] = in_array($flag, $postedUi, true);
                }
                // Dal dev22 le scelte di visibilita del Builder sono marcate
                // esplicitamente. In assenza del marker le vecchie config non
                // possono reintrodurre i limiti automatici delle versioni precedenti.
                $field['uiVisibilityCustomized'] = true;
            }
        }
        unset($field);

        $config['architecture'] = $architecture;
        $config['order'] = array_values(array_filter(
            (array) ($post['order'] ?? $config['order'])
        ));
        $schemaFeatures = (array) ($config['features'] ?? []);
        $config['features'] = $this->featuresFromPost(
            $post,
            $architecture,
            $config['softDelete']['available']
        );
        foreach (['readOnly', 'createAllowed', 'writable', 'recordDetail', 'recordActions', 'readOnlyReason'] as $feature) {
            if (array_key_exists($feature, $schemaFeatures)) {
                $config['features'][$feature] = $schemaFeatures[$feature];
            }
        }
        if (!empty($config['features']['readOnly'])) {
            $config['features']['softDeletes'] = false;
        }

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
        // I metadati 2.8 descrivono lo snapshot persistente ma non devono
        // sovrascrivere informazioni ricavate dallo schema corrente.
        $savedMeta = (array) ($saved['_meta'] ?? []);
        unset($saved['_meta']);
        $saved['table'] = $base['table'];

        /*
         * Lo schema corrente resta sempre autorevole.
         *
         * Una configurazione persistente può contenere riferimenti a campi o
         * relazioni che nel frattempo sono stati rimossi/rinominati nel DB.
         * array_replace_recursive() aggiungerebbe tali chiavi obsolete al
         * risultato finale, producendo relazioni prive dei metadati di schema
         * (per esempio childTable/foreignKey). Conserviamo quindi soltanto le
         * personalizzazioni ancora compatibili con lo schema corrente.
         */
        $savedFields = (array) ($saved['fields'] ?? []);
        $saved['fields'] = array_intersect_key($savedFields, (array) ($base['fields'] ?? []));

        /*
         * Le configurazioni legacy possono contenere l'intero snapshot campo
         * (type, index, foreignKey, nullable, ecc.). Questi dati non sono
         * decisioni dello sviluppatore e non devono mai prevalere sul DB
         * corrente. Manteniamo soltanto le proprieta realmente configurabili.
         */
        $fieldCustomizationKeys = array_fill_keys([
            'label',
            'inputType',
            'width',
            'relationMode',
            'relationDisplayField',
            'relationDisplayTemplate',
            'relationNavigation',
            'relationNavigationCustomized',
            'relationCreate',
            'uiVisibilityCustomized',
            'attributes',
            'ui',
        ], true);
        foreach ($saved['fields'] as $fieldName => $savedField) {
            $savedField = array_intersect_key((array) $savedField, $fieldCustomizationKeys);

            // Prima del dev22 visibleIndex/visibleView potevano essere false
            // per effetto dei limiti automatici del generatore (es. prime 10
            // colonne). Se il Builder non ha marcato una scelta esplicita,
            // lasciamo prevalere i nuovi default completi derivati dallo schema.
            if (empty($savedField['uiVisibilityCustomized']) && isset($savedField['ui'])) {
                $savedField['ui'] = (array) $savedField['ui'];
                unset($savedField['ui']['visibleIndex'], $savedField['ui']['visibleView']);
            }

            // Migrazione dev28: nelle config precedenti la Quick salvava
            // acceptContext=false anche quando non era una scelta del Builder.
            // Se la navigazione non è marcata come personalizzata, lasciamo
            // prevalere il nuovo default schema-driven (FK accettata nel Create).
            if (empty($savedField['relationNavigationCustomized']) && isset($savedField['relationNavigation'])) {
                $savedField['relationNavigation'] = (array) $savedField['relationNavigation'];
                unset($savedField['relationNavigation']['acceptContext']);
            }

            $saved['fields'][$fieldName] = $savedField;
        }

        $baseHasMany = (array) ($base['relationsConfig']['hasMany'] ?? []);
        $savedHasMany = array_intersect_key(
            (array) ($saved['relationsConfig']['hasMany'] ?? []),
            $baseHasMany
        );

        /*
         * hasMany contiene sia scelte UI sia metadati tecnici derivati dallo
         * schema. Dal dev22 le colonne sono sempre schema-authoritative e
         * complete: nessun limite numerico e nessuna lista legacy puo
         * eliminarle. Il programmatore resta libero di ridurre la tabella nel
         * codice generato o tramite future scelte esplicite del Builder.
         */
        $hasManyCustomizationKeys = array_fill_keys([
            'enabled', 'title', 'icon', 'limit', 'showCount', 'showViewButton',
        ], true);

        foreach ($savedHasMany as $relationKey => $savedRelation) {
            $savedHasMany[$relationKey] = array_intersect_key(
                (array) $savedRelation,
                $hasManyCustomizationKeys
            );
        }
        $saved['relationsConfig']['hasMany'] = $savedHasMany;

        /*
         * L'ordine salvato conserva le preferenze dello sviluppatore, ma non
         * deve reintrodurre campi eliminati. I nuovi campi DB vengono aggiunti
         * in coda così restano immediatamente disponibili nel Builder.
         */
        $baseOrder = array_keys((array) ($base['fields'] ?? []));
        $savedOrder = array_values(array_filter(
            (array) ($saved['order'] ?? []),
            static fn (mixed $field): bool => is_string($field) && isset($base['fields'][$field])
        ));
        $saved['order'] = array_values(array_unique(array_merge(
            $savedOrder,
            array_values(array_diff($baseOrder, $savedOrder))
        )));

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

        // Le colonne hasMany restano quelle complete dello schema corrente.
        foreach ((array) ($saved['fields'] ?? []) as $fieldName => $savedField) {
            if (
                isset($merged['fields'][$fieldName])
                && array_key_exists('attributes', (array) $savedField)
                && array_key_exists('boolean', (array) ($savedField['attributes'] ?? []))
            ) {
                $merged['fields'][$fieldName]['attributes']['boolean'] = array_values(
                    (array) $savedField['attributes']['boolean']
                );
            }
        }

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

        // readOnly/writable/recordDetail derivano esclusivamente dallo schema
        // corrente e non possono essere riattivati da una configurazione stale.
        foreach (['readOnly', 'createAllowed', 'writable', 'recordDetail', 'recordActions', 'readOnlyReason'] as $feature) {
            if (array_key_exists($feature, (array) ($base['features'] ?? []))) {
                $baseFeatures[$feature] = $base['features'][$feature];
            }
        }

        if (empty($merged['softDelete']['available']) || !empty($baseFeatures['readOnly'])) {
            $baseFeatures['softDeletes'] = false;
        }

        $merged['architecture'] = $architecture;
        $merged['features'] = $baseFeatures;

        $final = $this->finalize($merged);
        if ($savedMeta !== []) {
            $final['_meta'] = $savedMeta;
        }

        return $final;
    }

    private function finalize(array $config): array
    {
        $entity = Naming::tableClass((string) $config['table']);
        $languageFile = Naming::studly((string) $config['table']);

        // Iteriamo direttamente sugli array della configurazione: un foreach
        // by-reference su una espressione castata modifica soltanto una copia
        // temporanea e perderebbe normalizzazioni/policy (es. spatial).
        $config['fields'] = (array) ($config['fields'] ?? []);
        foreach ($config['fields'] as $name => &$field) {
            $field['languageKey'] = $languageFile . '.' . $name;
            $field['ui'] = (array) ($field['ui'] ?? []);

            // I filtri e l'ordinamento server-side sono ammessi soltanto sui
            // campi che guidano un indice (PRIMARY, UNIQUE o prima colonna
            // di un indice semplice/composto). Le altre opzioni restano una
            // decisione esplicita dello sviluppatore nel Builder.
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            if (!$indexEligible) {
                $field['ui']['searchable'] = false;
                $field['ui']['sortable'] = false;
            }

            if (!empty($field['databaseManaged'])) {
                // Metadato tecnico derivato dal DB: una configurazione persistente
                // non può trasformare un timestamp automatico in un input editabile.
                $field['ui']['visibleForm'] = false;
                $field['attributes'] = (array) ($field['attributes'] ?? []);
                $field['attributes']['boolean'] = array_values(array_diff(
                    (array) ($field['attributes']['boolean'] ?? []),
                    ['required', 'readonly', 'disabled']
                ));
            }

            if (FieldPolicy::isSpatial((string) ($field['type'] ?? ''))) {
                // In 2.8 i tipi spatial sono leggibili tramite ST_AsText(), ma
                // non vengono modificati o usati come filtro/ordinamento finché
                // non esiste un editor spatial dedicato.
                $field['ui']['searchable'] = false;
                $field['ui']['sortable'] = false;
                $field['ui']['visibleIndex'] = true;
                $field['ui']['visibleForm'] = false;
                $field['ui']['exportable'] = false;
                $field['ui']['apiVisible'] = false;
                $field['ui']['visibleView'] = true;
            }

            if (!array_key_exists('apiVisible', $field['ui'])) {
                $field['ui']['apiVisible'] = true;
            }

            $field['uiVisibilityCustomized'] = !empty($field['uiVisibilityCustomized']);

            if (!empty($field['foreignKey'])) {
                $mode = strtolower(trim((string) ($field['relationMode'] ?? 'select')));
                $field['relationMode'] = in_array($mode, ['select', 'ajax'], true) ? $mode : 'select';

                $relation = (array) $field['foreignKey'];
                $availableDisplayFields = array_values((array) ($relation['availableDisplayFields'] ?? []));
                $displayField = trim((string) ($field['relationDisplayField'] ?? $relation['displayField'] ?? ''));
                if ($displayField === '' || ($availableDisplayFields !== [] && !in_array($displayField, $availableDisplayFields, true))) {
                    $displayField = (string) ($relation['displayField'] ?? $relation['parentKey'] ?? '');
                }
                $displayTemplate = $this->sanitizeDisplayTemplate(
                    (string) ($field['relationDisplayTemplate'] ?? ''),
                    $availableDisplayFields
                );

                $navigation = (array) ($field['relationNavigation'] ?? []);
                $navigation += [
                    'quickFilter' => false,
                    'parentLink' => false,
                    'acceptContext' => true,
                    'createParentLink' => false,
                ];
                foreach ($navigation as $flag => $enabled) {
                    $navigation[$flag] = (bool) $enabled;
                }

                $field['relationDisplayField'] = $displayField;
                $field['relationDisplayTemplate'] = $displayTemplate;
                $field['relationNavigation'] = $navigation;
                $field['relationNavigationCustomized'] = !empty($field['relationNavigationCustomized']);
                $relatedCreateAvailable = !empty($field['foreignKey']['relatedCreate']['available']);
                $field['relationCreate'] = [
                    'available' => $relatedCreateAvailable,
                    'enabled' => $relatedCreateAvailable && !empty($field['relationCreate']['enabled']),
                ];

                // Normalizzazione di sicurezza anche per configurazioni persistenti precedenti:
                // se Relational Create è attivo, il link "Nuovo padre" viene sempre spento.
                if (!empty($field['relationCreate']['enabled'])) {
                    $field['relationNavigation']['createParentLink'] = false;
                }

                $field['foreignKey']['displayField'] = $displayField;
                $field['foreignKey']['displayTemplate'] = $displayTemplate;

                if (isset($config['relations']['belongsTo'][$name])) {
                    $config['relations']['belongsTo'][$name]['displayField'] = $displayField;
                    $config['relations']['belongsTo'][$name]['displayTemplate'] = $displayTemplate;
                    $config['relations']['belongsTo'][$name]['alias'] = (string) (
                        $field['foreignKey']['alias']
                        ?? $config['relations']['belongsTo'][$name]['alias']
                        ?? ($name . '__label')
                    );
                }
            }
        }
        unset($field);

        $config['relationsConfig'] = (array) ($config['relationsConfig'] ?? []);
        $config['relationsConfig']['hasMany'] = (array) ($config['relationsConfig']['hasMany'] ?? []);
        foreach ($config['relationsConfig']['hasMany'] as $key => &$relation) {
            if (empty($relation['childRecordDetail'])) {
                $relation['showViewButton'] = false;
            }
        }
        unset($relation);

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

    /**
     * Mantiene nel template descrittivo solo placeholder riferiti a colonne
     * realmente disponibili nella tabella padre. Il testo libero resta intatto.
     */
    private function sanitizeDisplayTemplate(string $template, array $allowedFields): string
    {
        $template = trim($template);
        if ($template === '') {
            return '';
        }

        $allowed = array_fill_keys(array_values(array_filter(
            $allowedFields,
            static fn ($value): bool => is_string($value) && $value !== ''
        )), true);

        return (string) preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array $match): string => isset($allowed[$match[1]]) ? $match[0] : '',
            $template
        );
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
            FieldPolicy::isSpatial($type) => 'text',
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
            && !str_contains(strtolower((string) ($column['extra'] ?? '')), 'auto_increment')
            && !FieldPolicy::isDatabaseManagedTimestamp($column)
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
        $spatial = FieldPolicy::isSpatial($type);
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
        $databaseManaged = FieldPolicy::isDatabaseManagedTimestamp($column);

        return [
            // Per dataset grandi i filtri e l'ordinamento vengono proposti solo
            // sui campi che guidano un indice. Il Builder può fare override.
            'searchable'   => !$managed && !$sensitive && !$large && !$spatial && $indexed,
            'sortable'     => !$managed && !$large && !$binary && !$spatial && $indexed,
            'visibleIndex' => !$sensitive && !$binary,
            'visibleForm'  => !$managed && !$databaseManaged && !$spatial && (!$sensitive || FieldPolicy::isPassword($name, $inputType)),
            'visibleView'  => !$sensitive && !$binary,
            'sensitive'    => $sensitive,
            'exportable'   => !$managed && !$sensitive && !$binary && !$spatial,
            'apiVisible'   => !$managed && !$binary && !$spatial,
            'filterMode'   => $filterMode,
        ];
    }

    /**
     * La lista generata non applica limiti arbitrari al numero di colonne.
     * Tutti i campi visualizzabili vengono inclusi; il Builder o il
     * programmatore possono poi nasconderli esplicitamente. Restano esclusi
     * soltanto dati sensibili o binari che non sono sicuri da stampare raw.
     */
    private function applyDefaultListVisibility(array $fields, string $primaryKey): array
    {
        unset($primaryKey);

        foreach ($fields as $name => &$field) {
            $ui = (array) ($field['ui'] ?? []);
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $binary = in_array($inputType, ['file', 'image'], true)
                || str_contains($type, 'blob')
                || str_contains($type, 'binary');

            $field['ui']['visibleIndex'] = empty($ui['sensitive']) && !$binary;
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
                'primaryKeys' => $relation['childPrimaryKeys'] ?? [$relation['childPrimaryKey']],
                'childRecordDetail' => !empty($relation['childRecordDetail']),
                'childCreateAllowed' => !empty($relation['childCreateAllowed']),
                'columns' => $relation['columns'] ?? [],
                'columnTypes' => $relation['columnTypes'] ?? [],
                'displayField' => $relation['displayField'],
                'limit' => 20,
                'showCount' => true,
                'showViewButton' => !empty($relation['childRecordDetail']),
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
