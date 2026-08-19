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

    private function availableFieldWidths(): array
    {
        $widths = array_map('intval', array_keys((array) ($this->config->bootstrapFieldWidths ?? [])));
        $widths = array_values(array_unique(array_filter($widths, static fn (int $width): bool => $width >= 1 && $width <= 12)));

        return $widths !== [] ? $widths : [12, 6];
    }

    private function defaultFieldWidth(): int
    {
        $available = $this->availableFieldWidths();
        $default = max(1, min(12, (int) ($this->config->defaultBootstrapFieldWidth ?? 6)));

        return in_array($default, $available, true) ? $default : $available[0];
    }

    private function normalizeFieldWidth(mixed $value): int
    {
        $requested = max(1, min(12, (int) ($value ?? $this->defaultFieldWidth())));
        return in_array($requested, $this->availableFieldWidths(), true)
            ? $requested
            : $this->defaultFieldWidth();
    }

    public function buildFromTable(string $table): array
    {
        $info = $this->schema->getTableInfo($table);
        $isView = !empty($info['isView']);
        // SQL VIEWs are read sources: myCrudCI4 does not attempt to
        // invent relations or write semantics on the underlying query.
        $relations = $isView
            ? ['belongsTo' => [], 'hasMany' => [], 'manyToMany' => []]
            : $this->relations->resolve($table);
        $uniqueFields = $this->uniqueFields($info['indexes']);
        $indexMetadata = $this->indexMetadata($info['indexes']);
        $primaryKeys = array_values((array) ($info['primaryKeys'] ?? []));
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
                'initialValue' => [
                    'mode' => 'none',
                    'custom' => '',
                ],
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
                    // A real foreign key can safely be used as Create context:
                    // the value is still verified server-side against the parent table.
                    // Other navigation options remain application-level choices.
                    'quickFilter' => false,
                    'parentLink' => false,
                    'acceptContext' => true,
                    'createParentLink' => false,
                ] : [],
                'relationNavigationCustomized' => false,
                'relationCreate' => isset($relations['belongsTo'][$name]) ? [
                    'available' => !empty($relations['belongsTo'][$name]['relatedCreate']['available']),
                    // Quick/generate-all exposes safe inline parent creation by default.
                    // The Builder can explicitly disable it and that decision is persisted.
                    'enabled' => !empty($relations['belongsTo'][$name]['relatedCreate']['available']),
                ] : [],
                'relationCreateCustomized' => false,
                'uiVisibilityCustomized' => false,
                'inputType' => $this->inferInputType(
                    $column,
                    isset($relations['belongsTo'][$name])
                ),
                'label' => '',
                'defaultLabel' => $this->labels->resolve($name),
                'languageKey' => $languageFile . '.' . $name,
                'width' => $this->defaultFieldWidth(),
                // dev40: a single logical section per field. Empty string = General.
                'section' => '',
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
            // dev40 Form Sections v2: no section is mandatory.
            // Unassigned fields are rendered under "General".
            'formSections' => [],
            'relations' => $relations,
            'relationsConfig' => [
                'hasMany' => $this->buildHasManyConfig($relations['hasMany'] ?? [], $relations['manyToMany'] ?? []),
                'manyToMany' => $this->buildManyToManyConfig($relations['manyToMany'] ?? []),
            ],
            'features' => $features,
            'apiCapabilities' => $this->defaultApiCapabilities(
                $architecture,
                $readOnly,
                $createAllowed,
                !$readOnly,
                $softAvailable
            ),
            'crudSecurity' => $this->defaultCrudSecurity(),
            'apiSecurity' => $this->defaultApiSecurity(),
            'mcp' => $this->defaultMcpConfig($architecture),
            'softDelete' => ['available' => $softAvailable, 'field' => $deletedField],
            'list' => [
                'filtersSummary' => 'Search filters',
            ],
        ]);
    }

    public function buildFromRequest(array $post): array
    {
        /*
         * Large Builder forms can exceed PHP max_input_vars.
         *
         * The browser therefore serializes fields[...] into one JSON value.
         * Rebuild the normal POST structure here so the rest of ConfigBuilder
         * remains unchanged.
         */
        $fieldsConfigJson = trim((string) ($post['fieldsConfigJson'] ?? ''));

        if ($fieldsConfigJson !== '') {
            if (strlen($fieldsConfigJson) > 2_000_000) {
                throw new \InvalidArgumentException('Fields configuration payload is too large.');
            }

            try {
                $decodedFields = json_decode(
                    $fieldsConfigJson,
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );
            } catch (\JsonException $e) {
                throw new \InvalidArgumentException(
                    'Invalid fields configuration payload.',
                    0,
                    $e
                );
            }

            if (!is_array($decodedFields)) {
                throw new \InvalidArgumentException(
                    'Invalid fields configuration payload.'
                );
            }

            $post['fields'] = $decodedFields;
        }

        $table = trim((string) ($post['table'] ?? ''));

        if ($table === '') {
            throw new InvalidArgumentException('Missing table name.');
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
            $field['width'] = $this->normalizeFieldWidth($post['width'][$name] ?? $field['width'] ?? null);
            $field['section'] = trim((string) ($post['section'][$name] ?? ''));

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
                // Quick will not overwrite these options in subsequent regenerations.
                $field['relationNavigationCustomized'] = true;

                $relatedCreateAvailable = !empty($field['foreignKey']['relatedCreate']['available']);
                $field['relationCreate'] = [
                    'available' => $relatedCreateAvailable,
                    'enabled' => $relatedCreateAvailable && !empty($post['relationCreate'][$name]),
                ];
                // A Builder save is an explicit developer decision, including an unchecked box.
                $field['relationCreateCustomized'] = true;

                // Relational Create replaces the old "New parent" navigation link.
                // The two UX paths must not coexist: inline creation preserves the current form,
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

            // dev37: initial Create value for writable temporal fields.
            // È una comodità UI, non sostituisce i DEFAULT/ON UPDATE del DB.
            $temporalType = strtolower((string) ($field['type'] ?? ''));
            $temporalInput = strtolower((string) ($field['inputType'] ?? ''));
            $supportsInitialValue = empty($field['databaseManaged'])
                && (in_array($temporalType, ['date', 'datetime', 'timestamp', 'time'], true)
                    || in_array($temporalInput, ['date', 'datetime-local', 'time'], true));
            if ($supportsInitialValue) {
                $initialInput = (array) (($post['initialValue'][$name] ?? []));
                $allowedModes = ['none', 'today', 'now', 'time', 'custom'];
                $mode = (string) ($initialInput['mode'] ?? ($field['initialValue']['mode'] ?? 'none'));
                $field['initialValue'] = [
                    'mode' => in_array($mode, $allowedModes, true) ? $mode : 'none',
                    'custom' => trim((string) ($initialInput['custom'] ?? ($field['initialValue']['custom'] ?? ''))),
                ];
            } else {
                $field['initialValue'] = ['mode' => 'none', 'custom' => ''];
            }

            if (array_key_exists($name, (array) ($post['ui'] ?? []))) {
                $postedUi = array_values(array_intersect(
                    (array) $post['ui'][$name],
                    ['searchable', 'sortable', 'visibleIndex', 'visibleForm', 'visibleView', 'sensitive', 'exportable', 'apiVisible', 'mcpVisible']
                ));
                foreach (['searchable', 'sortable', 'visibleIndex', 'visibleForm', 'visibleView', 'sensitive', 'exportable', 'apiVisible', 'mcpVisible'] as $flag) {
                    $field['ui'][$flag] = in_array($flag, $postedUi, true);
                }
                // Dal dev22 le scelte di visibilita del Builder sono marcate
                // esplicitamente. In assenza del marker le vecchie config non
                // possono reintrodurre i limiti automatici delle versioni precedenti.
                $field['uiVisibilityCustomized'] = true;
            }
        }
        unset($field);

        // dev40 Form Sections v2.
        // The section contains presentation metadata only; fields keep
        // il riferimento tramite fields.<name>.section. In questo modo non esistono
        // two field lists to synchronize.
        $postedSections = (array) ($post['formSections'] ?? []);
        $postedSectionOrder = array_values((array) ($post['formSectionOrder'] ?? []));
        $sections = [];
        foreach ($postedSectionOrder as $sectionId) {
            $sectionId = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) $sectionId) ?? '';
            if ($sectionId === '' || isset($sections[$sectionId]) || !isset($postedSections[$sectionId])) {
                continue;
            }

            $sectionPost = (array) $postedSections[$sectionId];
            $title = trim((string) ($sectionPost['title'] ?? ''));
            if ($title === '') {
                continue;
            }

            $sections[$sectionId] = [
                'id' => $sectionId,
                'title' => mb_substr($title, 0, 120),
                'description' => mb_substr(trim((string) ($sectionPost['description'] ?? '')), 0, 255),
                'width' => max(1, min(12, (int) ($sectionPost['width'] ?? 12))),
                'collapsed' => !empty($sectionPost['collapsed']),
            ];
        }
        $config['formSections'] = array_values($sections);

        $validSectionIds = array_fill_keys(array_keys($sections), true);
        foreach ($config['fields'] as &$field) {
            $sectionId = trim((string) ($field['section'] ?? ''));
            if ($sectionId === '' || !isset($validSectionIds[$sectionId])) {
                $field['section'] = '';
            }
        }
        unset($field);

        $config['architecture'] = $architecture;
        $postedOrder = $config['order'];

        $fieldOrderJson = trim((string) ($post['fieldOrderJson'] ?? ''));
        if ($fieldOrderJson !== '') {
            $decodedOrder = json_decode($fieldOrderJson, true);

            if (is_array($decodedOrder)) {
                $postedOrder = $decodedOrder;
            }
        } elseif (isset($post['order'])) {
            // Backward compatibility with older Builder forms.
            $postedOrder = (array) $post['order'];
        }

        $config['order'] = array_values(array_unique(array_filter(
            $postedOrder,
            static fn (mixed $field): bool =>
                is_string($field) && isset($config['fields'][$field])
        )));

        foreach (array_keys($config['fields']) as $fieldName) {
            if (!in_array($fieldName, $config['order'], true)) {
                $config['order'][] = $fieldName;
            }
        }
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

        $config['apiCapabilities'] = $this->apiCapabilitiesFromPost(
            $post,
            $architecture,
            (array) ($config['apiCapabilities'] ?? []),
            (array) $config['features']
        );
        $config['crudSecurity'] = $this->crudSecurityFromPost(
            $post,
            (array) ($config['crudSecurity'] ?? [])
        );
        $config['apiSecurity'] = $this->apiSecurityFromPost(
            $post,
            $architecture,
            (array) ($config['apiSecurity'] ?? [])
        );
        $config['mcp'] = $this->mcpFromPost(
            $post,
            $architecture,
            (array) ($config['mcp'] ?? []),
            (array) ($config['features'] ?? [])
        );

        $config['relationsConfig']['hasMany'] = $this->hasManyConfigFromPost(
            $post,
            $config['relationsConfig']['hasMany'] ?? []
        );
        $config['relationsConfig']['manyToMany'] = $this->manyToManyConfigFromPost(
            $post,
            $config['relationsConfig']['manyToMany'] ?? []
        );
        $config['list']['filtersSummary'] = trim((string) (
            $post['list']['filtersSummary']
            ?? $config['list']['filtersSummary']
            ?? 'Search filters'
        ));
        if ($config['list']['filtersSummary'] === '') {
            $config['list']['filtersSummary'] = 'Search filters';
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
         * A persistent configuration may contain references to fields or
         * relations that have since been removed/renamed in the DB.
         * array_replace_recursive() aggiungerebbe tali chiavi obsolete al
         * final result, producing relations without schema metadata
         * (per esempio childTable/foreignKey). Conserviamo quindi soltanto le
         * personalizzazioni ancora compatibili con lo schema corrente.
         */
        $savedFields = (array) ($saved['fields'] ?? []);
        $saved['fields'] = array_intersect_key($savedFields, (array) ($base['fields'] ?? []));

        /*
         * Legacy configurations may contain the full field snapshot
         * (type, index, foreignKey, nullable, ecc.). Questi dati non sono
         * decisioni dello sviluppatore e non devono mai prevalere sul DB
         * corrente. Manteniamo soltanto le proprieta realmente configurabili.
         */
        $fieldCustomizationKeys = array_fill_keys([
            'label',
            'inputType',
            'width',
            'section',
            'relationMode',
            'relationDisplayField',
            'relationDisplayTemplate',
            'relationNavigation',
            'relationNavigationCustomized',
            'relationCreate',
            'relationCreateCustomized',
            'uiVisibilityCustomized',
            'attributes',
            'initialValue',
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

            // dev39-fix3: nelle prime config Upload, file/image venivano trattati
            // come dati binari anche quando la colonna DB contiene soltanto il
            // filename VARCHAR. La coppia visibleIndex=false + visibleView=false
            // era quindi salvata automaticamente dal Builder. In quel caso
            // lasciamo tornare i nuovi default schema-driven.
            $savedInputType = strtolower((string) ($savedField['inputType'] ?? ''));
            if (
                in_array($savedInputType, ['file', 'image'], true)
                && isset($savedField['ui'])
                && empty($savedField['ui']['visibleIndex'])
                && empty($savedField['ui']['visibleView'])
            ) {
                unset($savedField['ui']['visibleIndex'], $savedField['ui']['visibleView']);
            }

            // Migrazione dev28: nelle config precedenti la Quick salvava
            // acceptContext=false anche quando non era una scelta del Builder.
            // Se la navigazione non è marcata come personalizzata, lasciamo
            // allow the new schema-driven default to prevail (foreign key accepted in Create).
            if (empty($savedField['relationNavigationCustomized']) && isset($savedField['relationNavigation'])) {
                $savedField['relationNavigation'] = (array) $savedField['relationNavigation'];
                unset($savedField['relationNavigation']['acceptContext']);
            }

            // fix11-fix1 migration: old snapshots stored relationCreate.enabled=false
            // even when the developer had never made a Builder choice. Do not let that
            // technical default hide a safe Related Create action introduced by Quick.
            if (empty($savedField['relationCreateCustomized'])) {
                unset($savedField['relationCreate']);
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
         * complete: no numeric limit and no legacy list can
         * remove them. The developer remains free to reduce the table in
         * codice generato o tramite future scelte esplicite del Builder.
         */
        $hasManyCustomizationKeys = array_fill_keys([
            'enabled', 'title', 'icon', 'limit', 'showCount', 'showCreateButton',
            'showViewAllButton', 'showViewButton', 'collapsible', 'collapsed',
        ], true);

        foreach ($savedHasMany as $relationKey => $savedRelation) {
            $savedHasMany[$relationKey] = array_intersect_key(
                (array) $savedRelation,
                $hasManyCustomizationKeys
            );
        }
        $saved['relationsConfig']['hasMany'] = $savedHasMany;

        $baseManyToMany = (array) ($base['relationsConfig']['manyToMany'] ?? []);
        $savedManyToMany = array_intersect_key(
            (array) ($saved['relationsConfig']['manyToMany'] ?? []),
            $baseManyToMany
        );
        $manyToManyCustomizationKeys = array_fill_keys([
            'enabled', 'title', 'icon', 'limit', 'showCount', 'showViewButton',
            'createEnabled', 'editEnabled', 'createRelatedEnabled', 'createRelatedCustomized',
            'formWidth', 'collapsible', 'collapsed',
        ], true);
        foreach ($savedManyToMany as $relationKey => $savedRelation) {
            $savedRelation = array_intersect_key(
                (array) $savedRelation,
                $manyToManyCustomizationKeys
            );
            // Legacy false values were generator defaults, not necessarily Builder choices.
            // Without the customization marker, let the current safe schema-driven default win.
            if (empty($savedRelation['createRelatedCustomized'])) {
                unset($savedRelation['createRelatedEnabled']);
            }
            $savedManyToMany[$relationKey] = $savedRelation;
        }
        $saved['relationsConfig']['manyToMany'] = $savedManyToMany;

        /*
         * L'ordine salvato conserva le preferenze dello sviluppatore, ma non
         * must not reintroduce removed fields. New DB fields are added
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
         * a label equal to the automatic value is not a customization.
         * In this case we reset it to an empty string so the view generates
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
        // current and cannot be re-enabled by stale configuration.
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

        // We iterate directly over configuration arrays: a foreach
        // by-reference on a cast expression modifies only a copy
        // temporanea e perderebbe normalizzazioni/policy (es. spatial).
        $config['fields'] = (array) ($config['fields'] ?? []);

        // Normalizzazione Form Sections v2 anche per persistent configurations.
        $normalizedSections = [];
        $validSectionIds = [];
        foreach ((array) ($config['formSections'] ?? []) as $rawSection) {
            $rawSection = (array) $rawSection;
            $sectionId = preg_replace('/[^a-zA-Z0-9_-]/', '', (string) ($rawSection['id'] ?? '')) ?? '';
            $title = trim((string) ($rawSection['title'] ?? ''));
            if ($sectionId === '' || $title === '' || isset($validSectionIds[$sectionId])) {
                continue;
            }

            $validSectionIds[$sectionId] = true;
            $normalizedSections[] = [
                'id' => $sectionId,
                'title' => mb_substr($title, 0, 120),
                'description' => mb_substr(trim((string) ($rawSection['description'] ?? '')), 0, 255),
                'width' => max(1, min(12, (int) ($rawSection['width'] ?? 12))),
                'collapsed' => !empty($rawSection['collapsed']),
            ];
        }
        $config['formSections'] = $normalizedSections;

        foreach ($config['fields'] as $name => &$field) {
            $field['languageKey'] = $languageFile . '.' . $name;
            $field['ui'] = (array) ($field['ui'] ?? []);
            $sectionId = trim((string) ($field['section'] ?? ''));
            $field['section'] = ($sectionId !== '' && isset($validSectionIds[$sectionId])) ? $sectionId : '';

            // Server-side filtering and sorting are allowed only on
            // fields that lead an index (PRIMARY, UNIQUE, or first column
            // of a simple/composite index). Other options remain an
            // decisione esplicita dello sviluppatore nel Builder.
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            if (!$indexEligible && empty($config['isView'])) {
                $field['ui']['searchable'] = false;
                $field['ui']['sortable'] = false;
            }

            if (!empty($field['databaseManaged'])) {
                // Metadato tecnico derivato dal DB: una persistent configuration
                // non può trasformare un timestamp automatico in un input editabile.
                $field['ui']['visibleForm'] = false;
                $field['attributes'] = (array) ($field['attributes'] ?? []);
                $field['attributes']['boolean'] = array_values(array_diff(
                    (array) ($field['attributes']['boolean'] ?? []),
                    ['required', 'readonly', 'disabled']
                ));
                $field['initialValue'] = ['mode' => 'none', 'custom' => ''];
            }

            if (FieldPolicy::isSpatial((string) ($field['type'] ?? ''))) {
                // In 2.8 i tipi spatial sono leggibili tramite ST_AsText(), ma
                // are not modified or used for filtering/sorting until
                // non esiste un editor spatial dedicato.
                $field['ui']['searchable'] = false;
                $field['ui']['sortable'] = false;
                $field['ui']['visibleIndex'] = true;
                $field['ui']['visibleForm'] = false;
                $field['ui']['exportable'] = false;
                $field['ui']['apiVisible'] = false;
                $field['ui']['mcpVisible'] = false;
                $field['ui']['visibleView'] = true;
            }

            if (!array_key_exists('apiVisible', $field['ui'])) {
                $field['ui']['apiVisible'] = true;
            }

            // dev13: MCP ha una superficie dati indipendente dalla REST API.
            // Legacy configurations inherit apiVisible, except sensitive fields.
            if (!array_key_exists('mcpVisible', $field['ui'])) {
                $field['ui']['mcpVisible'] = !empty($field['ui']['apiVisible'])
                    && empty($field['ui']['sensitive']);
            }

            // dev32: a SQL VIEW is read-only scaffolding. Even a
            // saved configuration cannot reactivate form fields or
            // Relational Create sulla VIEW. Lo sviluppatore resta libero di
            // estendere manualmente i file generati se conosce la VIEW.
            if (!empty($config['isView'])) {
                $field['ui']['visibleForm'] = false;
                $field['relationCreate'] = [
                    'available' => false,
                    'enabled' => false,
                ];
                $field['relationNavigation'] = [];
                $field['foreignKey'] = null;
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
                $field['relationCreateCustomized'] = !empty($field['relationCreateCustomized']);
                $relatedCreateAvailable = !empty($field['foreignKey']['relatedCreate']['available']);
                $field['relationCreate'] = [
                    'available' => $relatedCreateAvailable,
                    'enabled' => $relatedCreateAvailable && !empty($field['relationCreate']['enabled']),
                ];

                // Safety normalization also applies to previous persistent configurations:
                // when Relational Create is active, the "New parent" link is always disabled.
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

        if (!empty($config['isView'])) {
            $config['relations'] = ['belongsTo' => [], 'hasMany' => [], 'manyToMany' => []];
            $config['relationsConfig'] = ['hasMany' => [], 'manyToMany' => []];
            $config['features']['relations'] = false;
            $config['features']['softDeletes'] = false;
        }

        $config['relationsConfig'] = (array) ($config['relationsConfig'] ?? []);
        $config['relationsConfig']['hasMany'] = (array) ($config['relationsConfig']['hasMany'] ?? []);
        $config['relationsConfig']['manyToMany'] = (array) ($config['relationsConfig']['manyToMany'] ?? []);
        $purePivotTables = array_fill_keys(array_values(array_filter(array_map(
            static fn (array $relation): string => !empty($relation['enabled']) ? (string) ($relation['pivotTable'] ?? '') : '',
            $config['relationsConfig']['manyToMany']
        ))), true);

        foreach ($config['relationsConfig']['manyToMany'] as &$manyToManyRelation) {
            if (empty($manyToManyRelation['createRelatedAvailable'])) {
                $manyToManyRelation['createRelatedEnabled'] = false;
            }
        }
        unset($manyToManyRelation);

        foreach ($config['relationsConfig']['hasMany'] as &$hasManyRelation) {
            $isPurePivot = isset($purePivotTables[(string) ($hasManyRelation['childTable'] ?? '')]);

            /*
             * Pure pivot tables are disabled as hasMany by default because the
             * many-to-many relation is normally the more useful representation.
             *
             * An explicit Builder choice must nevertheless win. This matches the
             * contract established by buildHasManyConfig(): developers may expose
             * the technical pivot table as a read-only hasMany panel when useful.
             */
            if ($isPurePivot && empty($hasManyRelation['enabled'])) {
                $hasManyRelation['enabled'] = false;
                $hasManyRelation['suppressedByManyToMany'] = true;
            } else {
                $hasManyRelation['suppressedByManyToMany'] = false;
            }
        }
        unset($hasManyRelation);
        foreach ($config['relationsConfig']['hasMany'] as $key => &$relation) {
            if (empty($relation['childRecordDetail'])) {
                $relation['showViewButton'] = false;
            }
        }
        unset($relation);

        $config['languageFile'] = $languageFile;
        $config['list']['filtersSummary'] = trim((string) ($config['list']['filtersSummary'] ?? 'Search filters')) ?: 'Search filters';

        $apiDefaults = $this->defaultApiCapabilities(
            (string) ($config['architecture'] ?? 'basic'),
            !empty($config['features']['readOnly']),
            !empty($config['features']['createAllowed']),
            !empty($config['features']['writable']),
            !empty($config['features']['softDeletes'])
        );
        $savedApiCapabilities = (array) ($config['apiCapabilities'] ?? []);
        if ($savedApiCapabilities === []) {
            $config['apiCapabilities'] = $apiDefaults;
        } else {
            foreach ($apiDefaults as $name => $available) {
                $config['apiCapabilities'][$name] = $available && !empty($savedApiCapabilities[$name]);
            }
        }

        $config['crudSecurity'] = $this->normalizeCrudSecurity(
            (array) ($config['crudSecurity'] ?? [])
        );
        $config['apiSecurity'] = $this->normalizeApiSecurity(
            (array) ($config['apiSecurity'] ?? []),
            (string) ($config['architecture'] ?? 'basic')
        );
        $config['mcp'] = $this->normalizeMcpConfig(
            (array) ($config['mcp'] ?? []),
            (string) ($config['architecture'] ?? 'basic'),
            (array) ($config['features'] ?? [])
        );

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
     * Keeps only placeholders referencing columns
     * actually available in the parent table. Free text remains unchanged.
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

    /** @return array{enabled:bool,transport:string,mode:string,serverName:string,capabilities:array{list:bool,read:bool,relations:bool}} */
    private function defaultMcpConfig(string $architecture): array
    {
        $full = $this->normalizeArchitecture($architecture) === 'full';

        return [
            'enabled' => false,
            'transport' => 'stdio',
            'mode' => 'read_only',
            'serverName' => 'myCrudCI4',
            'security' => [
                'boundary' => 'local_process',
                'inheritsApiSecurity' => false,
                'remoteTransportAllowed' => false,
                'oauthRequiredForRemote' => true,
            ],
            'capabilities' => [
                'list' => $full,
                'read' => $full,
                'relations' => $full,
            ],
        ];
    }

    /** @return array{enabled:bool,transport:string,mode:string,serverName:string,capabilities:array{list:bool,read:bool,relations:bool}} */
    private function mcpFromPost(
        array $post,
        string $architecture,
        array $current,
        array $features
    ): array {
        if ($this->normalizeArchitecture($architecture) !== 'full') {
            return $this->defaultMcpConfig($architecture);
        }

        $mcp = (array) ($post['mcp'] ?? []);
        $enabled = !empty($mcp['enabled']);
        $serverName = trim((string) ($mcp['serverName'] ?? ($current['serverName'] ?? 'myCrudCI4')));
        if ($serverName === '') {
            $serverName = 'myCrudCI4';
        }
        $serverName = substr($serverName, 0, 80);

        $postedCapabilities = (array) ($mcp['capabilities'] ?? []);

        return [
            'enabled' => $enabled,
            'transport' => 'stdio',
            'mode' => 'read_only',
            'serverName' => $serverName,
            'security' => [
                'boundary' => 'local_process',
                'inheritsApiSecurity' => false,
                'remoteTransportAllowed' => false,
                'oauthRequiredForRemote' => true,
            ],
            'capabilities' => [
                'list' => !empty($postedCapabilities['list']),
                'read' => !empty($features['recordDetail']) && !empty($postedCapabilities['read']),
                'relations' => !empty($features['relations']) && !empty($postedCapabilities['relations']),
            ],
        ];
    }

    /** @return array{enabled:bool,transport:string,mode:string,serverName:string,capabilities:array{list:bool,read:bool,relations:bool}} */
    private function normalizeMcpConfig(array $mcp, string $architecture, array $features): array
    {
        if ($this->normalizeArchitecture($architecture) !== 'full') {
            return $this->defaultMcpConfig($architecture);
        }

        $serverName = trim((string) ($mcp['serverName'] ?? 'myCrudCI4'));
        if ($serverName === '') {
            $serverName = 'myCrudCI4';
        }

        $caps = (array) ($mcp['capabilities'] ?? []);

        return [
            'enabled' => !empty($mcp['enabled']),
            'transport' => 'stdio',
            'mode' => 'read_only',
            'serverName' => substr($serverName, 0, 80),
            'security' => [
                'boundary' => 'local_process',
                'inheritsApiSecurity' => false,
                'remoteTransportAllowed' => false,
                'oauthRequiredForRemote' => true,
            ],
            'capabilities' => [
                'list' => array_key_exists('list', $caps) ? !empty($caps['list']) : true,
                'read' => !empty($features['recordDetail'])
                    && (array_key_exists('read', $caps) ? !empty($caps['read']) : true),
                'relations' => !empty($features['relations'])
                    && (array_key_exists('relations', $caps) ? !empty($caps['relations']) : true),
            ],
        ];
    }

    /** @return array{auth:string,permissions:array<string,string>} */
    private function defaultCrudSecurity(): array
    {
        return [
            'auth' => 'none',
            'permissions' => [
                'list' => '',
                'read' => '',
                'create' => '',
                'update' => '',
                'delete' => '',
                'trash' => '',
                'restore' => '',
                'forceDelete' => '',
            ],
        ];
    }

    /** @return array{auth:string,permissions:array<string,string>} */
    private function crudSecurityFromPost(array $post, array $current): array
    {
        $requestedAuth = strtolower(trim((string) ($post['crudSecurity']['auth'] ?? 'none')));
        $auth = $requestedAuth === 'shield_session' ? 'shield_session' : 'none';

        // Web CRUD Shield integration is optional and must not emit unavailable filters.
        if ($auth === 'shield_session' && !class_exists(\CodeIgniter\Shield\Filters\TokenAuth::class)) {
            $auth = 'none';
        }

        $permissions = [];
        foreach (array_keys($this->defaultCrudSecurity()['permissions']) as $capability) {
            $permission = strtolower(trim((string) ($post['crudSecurity']['permissions'][$capability] ?? '')));
            $permissions[$capability] = preg_match('/^[a-z0-9][a-z0-9._-]*$/D', $permission) === 1
                ? $permission
                : '';
        }

        return ['auth' => $auth, 'permissions' => $permissions];
    }

    /** @return array{auth:string,permissions:array<string,string>} */
    private function normalizeCrudSecurity(array $security): array
    {
        $auth = (string) ($security['auth'] ?? 'none');
        if (!in_array($auth, ['none', 'shield_session'], true)) {
            $auth = 'none';
        }

        $permissions = [];
        foreach (array_keys($this->defaultCrudSecurity()['permissions']) as $capability) {
            $permission = strtolower(trim((string) ($security['permissions'][$capability] ?? '')));
            $permissions[$capability] = preg_match('/^[a-z0-9][a-z0-9._-]*$/D', $permission) === 1
                ? $permission
                : '';
        }

        return ['auth' => $auth, 'permissions' => $permissions];
    }

    /** @return array{auth:string,permissions:array<string,string>} */
    private function defaultApiSecurity(): array
    {
        return [
            'auth' => 'none',
            'permissions' => [
                'list' => '',
                'read' => '',
                'create' => '',
                'update' => '',
                'delete' => '',
                'trash' => '',
                'restore' => '',
                'forceDelete' => '',
                'upload' => '',
            ],
        ];
    }

    /** @return array{auth:string,permissions:array<string,string>} */
    private function apiSecurityFromPost(array $post, string $architecture, array $current): array
    {
        if ($this->normalizeArchitecture($architecture) !== 'full') {
            return $this->defaultApiSecurity();
        }

        $requestedAuth = strtolower(trim((string) ($post['apiSecurity']['auth'] ?? 'none')));
        $auth = $requestedAuth === 'shield_tokens' ? 'shield_tokens' : 'none';

        // We do not generate Shield filter references when the package is not installed.
        if ($auth === 'shield_tokens' && !class_exists(\CodeIgniter\Shield\Filters\TokenAuth::class)) {
            $auth = 'none';
        }

        $permissions = [];
        foreach (array_keys($this->defaultApiSecurity()['permissions']) as $capability) {
            $permission = strtolower(trim((string) ($post['apiSecurity']['permissions'][$capability] ?? '')));
            $permissions[$capability] = preg_match('/^[a-z0-9][a-z0-9._-]*$/D', $permission) === 1
                ? $permission
                : '';
        }

        return [
            'auth' => $auth,
            'permissions' => $permissions,
        ];
    }

    /** @return array{auth:string,permissions:array<string,string>} */
    private function normalizeApiSecurity(array $security, string $architecture): array
    {
        if ($this->normalizeArchitecture($architecture) !== 'full') {
            return $this->defaultApiSecurity();
        }

        $auth = (string) ($security['auth'] ?? 'none');
        if (!in_array($auth, ['none', 'shield_tokens'], true)) {
            $auth = 'none';
        }

        $permissions = [];
        foreach (array_keys($this->defaultApiSecurity()['permissions']) as $capability) {
            $permission = strtolower(trim((string) ($security['permissions'][$capability] ?? '')));
            $permissions[$capability] = preg_match('/^[a-z0-9][a-z0-9._-]*$/D', $permission) === 1
                ? $permission
                : '';
        }

        return ['auth' => $auth, 'permissions' => $permissions];
    }

    /**
     * Capability API indipendenti dalle capability web.
     *
     * Le capability impossibili per schema/architettura vengono sempre spente,
     * anche se una persistent configuration precedente le aveva abilitate.
     *
     * @return array<string,bool>
     */
    private function defaultApiCapabilities(
        string $architecture,
        bool $readOnly,
        bool $createAllowed,
        bool $writable,
        bool $softDeleteAvailable
    ): array {
        $full = $this->normalizeArchitecture($architecture) === 'full';

        return [
            'list' => $full,
            'read' => $full && !$readOnly,
            'create' => $full && $createAllowed,
            'update' => $full && $writable && !$readOnly,
            'delete' => $full && $writable && !$readOnly,
            'trash' => $full && $writable && $softDeleteAvailable,
            'restore' => $full && $writable && $softDeleteAvailable,
            'forceDelete' => $full && $writable && $softDeleteAvailable,
        ];
    }

    /** @return array<string,bool> */
    private function apiCapabilitiesFromPost(
        array $post,
        string $architecture,
        array $current,
        array $features
    ): array {
        $available = $this->defaultApiCapabilities(
            $architecture,
            !empty($features['readOnly']),
            !empty($features['createAllowed']),
            !empty($features['writable']),
            !empty($features['softDeletes'])
        );

        if ($this->normalizeArchitecture($architecture) !== 'full') {
            return array_fill_keys(array_keys($available), false);
        }

        // Nel Builder l'assenza del checkbox significa scelta esplicita "off".
        $posted = (array) ($post['apiCapabilities'] ?? []);
        foreach ($available as $name => $canEnable) {
            $available[$name] = $canEnable && !empty($posted[$name]);
        }

        return $available;
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
            // For large datasets, filters and sorting are proposed only
            // for fields that lead an index. The Builder may override this.
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
     * The generated list applies no arbitrary limit to the number of columns.
     * All displayable fields are included; the Builder or
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
            $binary = str_contains($type, 'blob')
                || str_contains($type, 'binary');

            $field['ui']['visibleIndex'] = empty($ui['sensitive']) && !$binary;
        }
        unset($field);

        return $fields;
    }

    private function buildHasManyConfig(array $relations, array $manyToMany = []): array
    {
        $config = [];

        $pivotTables = array_fill_keys(array_values(array_filter(array_map(
            static fn (array $relation): string => !empty($relation['purePivot']) ? (string) ($relation['pivotTable'] ?? '') : '',
            $manyToMany
        ))), true);

        foreach ($relations as $key => $relation) {
            $childTable = (string) ($relation['childTable'] ?? '');
            $config[$key] = [
                // Pure pivots are represented by the many-to-many relation and are not
                // duplicates as a technical hasMany table. The developer may
                // manually re-enable hasMany from the Builder/configuration.
                'enabled' => !isset($pivotTables[$childTable]),
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
                // Scaffolding dev33: le azioni restano configurabili e non
                // vengono imposte al progetto applicativo.
                'showCreateButton' => !empty($relation['childCreateAllowed']),
                'showViewAllButton' => true,
                'showViewButton' => !empty($relation['childRecordDetail']),
                'collapsible' => true,
                'collapsed' => false,
            ];
        }

        return $config;
    }

    private function buildManyToManyConfig(array $relations): array
    {
        $config = [];
        foreach ($relations as $key => $relation) {
            if (empty($relation['purePivot'])) {
                continue;
            }
            $config[(string) $key] = [
                'enabled' => true,
                'title' => Naming::human((string) ($relation['relatedTable'] ?? 'Relation')),
                'icon' => 'bi-diagram-2',
                'limit' => 20,
                'showCount' => true,
                'showViewButton' => !empty($relation['relatedRecordDetail']),
                'formWidth' => max(1, min(12, (int) ((config('MyCrud')->relationPanelWidths['manyToMany'] ?? 12)))),
                'createEnabled' => true,
                'editEnabled' => true,
                'createRelatedAvailable' => !empty($relation['relatedCreateSimple']),
                // Safe M2M target creation is scaffolded by Quick/generate-all by default.
                'createRelatedEnabled' => !empty($relation['relatedCreateSimple']),
                'createRelatedCustomized' => false,
                'createRelatedUnavailableReason' => (string) ($relation['relatedCreateUnavailableReason'] ?? ''),
                'relatedCreate' => (array) ($relation['relatedCreate'] ?? []),
                'collapsible' => true,
                'collapsed' => false,
                'pivotTable' => (string) ($relation['pivotTable'] ?? ''),
                'ownPivotField' => (string) ($relation['ownPivotField'] ?? ''),
                'ownParentField' => (string) ($relation['ownParentField'] ?? ''),
                'relatedTable' => (string) ($relation['relatedTable'] ?? ''),
                'relatedPivotField' => (string) ($relation['relatedPivotField'] ?? ''),
                'relatedKey' => (string) ($relation['relatedKey'] ?? ''),
                'relatedDisplayField' => (string) ($relation['relatedDisplayField'] ?? ''),
                'relatedDisplayFields' => array_values((array) ($relation['relatedDisplayFields'] ?? [])),
                'relatedRecordDetail' => !empty($relation['relatedRecordDetail']),
                'columns' => (array) ($relation['relatedColumns'] ?? []),
                'columnTypes' => (array) ($relation['relatedColumnTypes'] ?? []),
                // Scaffolding dev34: i metodi attach/detach/sync vengono sempre
                // generati come punti di estensione, senza imporre una UI di editing.
                'scaffoldMutators' => true,
            ];
        }
        return $config;
    }

    private function manyToManyConfigFromPost(array $post, array $base): array
    {
        $posted = (array) ($post['relationsConfig']['manyToMany'] ?? []);
        foreach ($base as $key => &$relation) {
            $input = (array) ($posted[$key] ?? []);
            $relation['enabled'] = !empty($input['enabled']);
            $relation['title'] = trim((string) ($input['title'] ?? $relation['title'])) ?: (string) $relation['title'];
            $relation['icon'] = trim((string) ($input['icon'] ?? $relation['icon'])) ?: 'bi-diagram-2';
            $relation['limit'] = max(1, min(200, (int) ($input['limit'] ?? 20)));
            $relation['showCount'] = !empty($input['showCount']);
            $relation['showViewButton'] = !empty($input['showViewButton']) && !empty($relation['relatedRecordDetail']);
            $allowedWidths = array_map('intval', array_keys((array) (config('MyCrud')->bootstrapFieldWidths ?? [])));
            $requestedWidth = (int) ($input['formWidth'] ?? $relation['formWidth'] ?? 12);
            $relation['formWidth'] = in_array($requestedWidth, $allowedWidths, true) ? $requestedWidth : (int) ($relation['formWidth'] ?? 12);
            $relation['createEnabled'] = !empty($input['createEnabled']);
            $relation['editEnabled'] = !empty($input['editEnabled']);
            $relation['createRelatedEnabled'] = !empty($relation['createRelatedAvailable'])
                && !empty($input['createRelatedEnabled']);
            // A Builder save explicitly chooses whether inline target creation is enabled.
            $relation['createRelatedCustomized'] = true;
            $relation['collapsible'] = !empty($input['collapsible']);
            $relation['collapsed'] = !empty($input['collapsed']) && $relation['collapsible'];
        }
        unset($relation);
        return $base;
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
            $relation['showCreateButton'] = !empty($input['showCreateButton'])
                && !empty($relation['childCreateAllowed']);
            $relation['showViewAllButton'] = !empty($input['showViewAllButton']);
            $relation['showViewButton'] = !empty($input['showViewButton'])
                && !empty($relation['childRecordDetail']);
            $relation['collapsible'] = !empty($input['collapsible']);
            $relation['collapsed'] = !empty($input['collapsed']) && $relation['collapsible'];

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
