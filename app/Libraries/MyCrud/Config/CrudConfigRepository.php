<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Config;

use Config\MyCrud;
use RuntimeException;

/**
 * Repository delle persistent configurations dei CRUD.
 *
 * Dalla 2.8 le configurazioni fanno parte del progetto e vengono salvate come
 * file PHP versionabili in app/MyCrudConfig/. Non salviamo una copia completa
 * dello DB schema: persistono solo le decisioni dello sviluppatore. In questo
 * so that on every regeneration, types, indexes, and relations are reread from the DB.
 */
final class CrudConfigRepository
{
    private string $directory;
    private string $legacyDirectory;

    public function __construct(
        ?string $directory = null,
        ?string $legacyDirectory = null,
        ?MyCrud $settings = null
    ) {
        /** @var MyCrud $settings */
        $settings ??= config('MyCrud');

        $this->directory = rtrim(
            $directory ?? $settings->crudConfigPath,
            DIRECTORY_SEPARATOR
        ) . DIRECTORY_SEPARATOR;

        $this->legacyDirectory = rtrim(
            $legacyDirectory ?? $settings->legacyCrudConfigPath,
            DIRECTORY_SEPARATOR
        ) . DIRECTORY_SEPARATOR;
    }

    /**
     * Saves a compact, versionable configuration snapshot.
     *
     * @return string percorso del file scritto
     */
    public function save(string $table, array $config): string
    {
        $table = $this->assertTable($table);
        $this->ensureDirectory($this->directory);

        $persistent = $this->toPersistentConfig($config);
        $persistent['table'] = $table;

        /** @var MyCrud $settings */
        $settings = config('MyCrud');

        $persistent['_meta'] = [
            'generatorVersion'  => $settings->version,
            'savedAt'           => date(DATE_ATOM),
            'schemaFingerprint' => $this->schemaFingerprint($config),
            'configHash'        => $this->configHash($persistent),
        ];

        $content = "<?php\n\n"
            . "declare(strict_types=1);\n\n"
            . "/**\n"
            . " * myCrudCI4 persistent configuration for table {$table}.\n"
            . " *\n"
            . " * Questo file contiene solo le scelte dello sviluppatore.\n"
            . " * DB types, indexes, and relations are reread from the schema on every generation.\n"
            . " */\n"
            . "return " . var_export($persistent, true) . ";\n";

        $path = $this->path($table);
        $tmp = $path . '.tmp-' . bin2hex(random_bytes(4));

        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new RuntimeException('Unable to save temporary configuration: ' . $tmp);
        }

        if (!rename($tmp, $path)) {
            @unlink($tmp);
            throw new RuntimeException('Unable to publish configuration: ' . $path);
        }

        return $path;
    }

    public function load(string $table): ?array
    {
        $table = $this->assertTable($table);
        $path = $this->path($table);

        if (is_file($path)) {
            $loaded = (static function (string $file): mixed {
                return require $file;
            })($path);

            if (!is_array($loaded)) {
                throw new RuntimeException('Invalid configuration: ' . $path);
            }

            return $this->normalizeLoaded($loaded, $table);
        }

        // Compatibilità 2.7.x: vecchie configurazioni JSON in writable/mycrud/.
        $legacy = $this->legacyPath($table);
        if (!is_file($legacy)) {
            return null;
        }

        $decoded = json_decode((string) file_get_contents($legacy), true);
        if (!is_array($decoded)) {
            throw new RuntimeException('Invalid legacy configuration: ' . $legacy);
        }

        return $this->normalizeLoaded($this->toPersistentConfig($decoded), $table);
    }

    public function exists(string $table): bool
    {
        $table = $this->assertTable($table);

        return is_file($this->path($table)) || is_file($this->legacyPath($table));
    }

    /** @return list<string> */
    public function tables(): array
    {
        $tables = [];

        if (is_dir($this->directory)) {
            foreach (glob($this->directory . '*.php') ?: [] as $path) {
                $tables[] = basename($path, '.php');
            }
        }

        // Durante la transizione includiamo anche le configurazioni 2.7.x.
        if (is_dir($this->legacyDirectory)) {
            foreach (glob($this->legacyDirectory . '*.json') ?: [] as $path) {
                $tables[] = basename($path, '.json');
            }
        }

        $tables = array_values(array_unique(array_filter($tables)));
        sort($tables, SORT_STRING);

        return $tables;
    }

    public function pathFor(string $table): string
    {
        return $this->path($this->assertTable($table));
    }

    /**
     * Explicitly migrates a legacy configuration to the current PHP format.
     */
    public function migrateLegacy(string $table, array $currentConfig): ?string
    {
        $table = $this->assertTable($table);
        if (is_file($this->path($table)) || !is_file($this->legacyPath($table))) {
            return null;
        }

        $legacy = $this->load($table);
        if ($legacy === null) {
            return null;
        }

        // The current configuration contains the updated schema; choices
        // legacy vengono applicate dal chiamante prima del salvataggio.
        return $this->save($table, $currentConfig);
    }

    /**
     * Hash delle sole scelte persistenti, esclusi i metadati temporali.
     */
    public function configHash(array $config): string
    {
        $copy = $this->toPersistentConfig($config);
        unset($copy['_meta']);

        return hash('sha256', json_encode(
            $this->normalizeForHash($copy),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        ));
    }

    /**
     * Firma dello schema utile a segnalare drift fra salvataggio e rigenerazione.
     * Non contiene dati o conteggi record, solo struttura significativa.
     */
    public function schemaFingerprint(array $config): string
    {
        $fields = [];

        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            $index = (array) ($field['index'] ?? []);
            $foreignKey = (array) ($field['foreignKey'] ?? []);

            $fields[(string) $name] = [
                'type'          => (string) ($field['type'] ?? ''),
                'columnType'    => (string) ($field['columnType'] ?? ''),
                'nullable'      => (bool) ($field['nullable'] ?? false),
                'default'       => $field['default'] ?? null,
                'extra'         => (string) ($field['extra'] ?? ''),
                'defaultGenerated' => (bool) ($field['defaultGenerated'] ?? false),
                'autoOnUpdate'  => (bool) ($field['autoOnUpdate'] ?? false),
                'databaseManaged' => (bool) ($field['databaseManaged'] ?? false),
                'primary'       => (bool) ($field['primary'] ?? false),
                'autoIncrement' => (bool) ($field['autoIncrement'] ?? false),
                'index'         => [
                    'primary' => (bool) ($index['primary'] ?? false),
                    'unique'  => (bool) ($index['unique'] ?? false),
                    'leading' => (bool) ($index['leading'] ?? false),
                    'indexes' => array_values((array) ($index['indexes'] ?? [])),
                ],
                'foreignKey' => $foreignKey === [] ? null : [
                    'parentTable' => (string) ($foreignKey['parentTable'] ?? ''),
                    'parentKey'   => (string) ($foreignKey['parentKey'] ?? ''),
                ],
            ];
        }

        $shape = [
            'table'        => (string) ($config['table'] ?? ''),
            'tableType'    => (string) ($config['tableType'] ?? 'BASE TABLE'),
            'isView'       => !empty($config['isView']),
            'primaryKey'   => (string) ($config['primaryKey'] ?? ''),
            'primaryKeys'  => array_values((array) ($config['primaryKeys'] ?? [])),
            'fields'       => $fields,
        ];

        return hash('sha256', json_encode(
            $this->normalizeForHash($shape),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
        ));
    }

    /**
     * Reduces a complete configuration to human decisions only.
     */
    private function toPersistentConfig(array $config): array
    {
        $persistent = [
            'table'        => (string) ($config['table'] ?? ''),
            'architecture' => (string) ($config['architecture'] ?? 'basic'),
            'order'        => array_values((array) ($config['order'] ?? [])),
            'formSections' => array_values(array_map(
                static fn (array $section): array => [
                    'id' => (string) ($section['id'] ?? ''),
                    'title' => (string) ($section['title'] ?? ''),
                    'description' => (string) ($section['description'] ?? ''),
                    'width' => max(1, min(12, (int) ($section['width'] ?? 12))),
                    'collapsed' => !empty($section['collapsed']),
                ],
                (array) ($config['formSections'] ?? [])
            )),
            'fields'       => [],
            'features'     => [],
            'apiCapabilities' => array_map(
                static fn ($value): bool => !empty($value),
                (array) ($config['apiCapabilities'] ?? [])
            ),
            'crudSecurity' => [
                'auth' => (string) ($config['crudSecurity']['auth'] ?? 'none'),
                'permissions' => array_map(
                    static fn ($value): string => (string) $value,
                    (array) ($config['crudSecurity']['permissions'] ?? [])
                ),
            ],
            'apiSecurity' => [
                'auth' => (string) ($config['apiSecurity']['auth'] ?? 'none'),
                'permissions' => array_map(
                    static fn ($value): string => (string) $value,
                    (array) ($config['apiSecurity']['permissions'] ?? [])
                ),
            ],
            'mcp' => [
                'enabled' => !empty($config['mcp']['enabled']),
                'transport' => (string) ($config['mcp']['transport'] ?? 'stdio'),
                'mode' => (string) ($config['mcp']['mode'] ?? 'read_only'),
                'serverName' => (string) ($config['mcp']['serverName'] ?? 'myCrudCI4'),
                'security' => [
                    'boundary' => 'local_process',
                    'inheritsApiSecurity' => false,
                    'remoteTransportAllowed' => false,
                    'oauthRequiredForRemote' => true,
                ],
                'capabilities' => [
                    'list' => !empty($config['mcp']['capabilities']['list']),
                    'read' => !empty($config['mcp']['capabilities']['read']),
                    'relations' => !empty($config['mcp']['capabilities']['relations']),
                ],
            ],
            'relationsConfig' => [
                'hasMany' => [],
                'manyToMany' => [],
            ],
            'list' => [
                'filtersSummary' => (string) ($config['list']['filtersSummary'] ?? 'Search filters'),
            ],
        ];

        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            $persistent['fields'][(string) $name] = [
                'label'        => (string) ($field['label'] ?? ''),
                'inputType'    => (string) ($field['inputType'] ?? 'text'),
                'width'        => (int) ($field['width'] ?? config('MyCrud')->defaultBootstrapFieldWidth ?? 6),
                'section'      => (string) ($field['section'] ?? ''),
                'relationMode' => (string) ($field['relationMode'] ?? ''),
                'relationDisplayField' => (string) ($field['relationDisplayField'] ?? ''),
                'relationDisplayTemplate' => (string) ($field['relationDisplayTemplate'] ?? ''),
                'relationNavigation' => [
                    'quickFilter' => !empty($field['relationNavigation']['quickFilter']),
                    'parentLink' => !empty($field['relationNavigation']['parentLink']),
                    'acceptContext' => !empty($field['relationNavigation']['acceptContext']),
                    'createParentLink' => !empty($field['relationNavigation']['createParentLink']),
                ],
                'relationNavigationCustomized' => !empty($field['relationNavigationCustomized']),
                'relationCreate' => [
                    'enabled' => !empty($field['relationCreate']['enabled']),
                ],
                'relationCreateCustomized' => !empty($field['relationCreateCustomized']),
                'uiVisibilityCustomized' => !empty($field['uiVisibilityCustomized']),
                'initialValue' => [
                    'mode' => (string) ($field['initialValue']['mode'] ?? 'none'),
                    'custom' => (string) ($field['initialValue']['custom'] ?? ''),
                ],
                'attributes'   => [
                    'boolean' => array_values((array) ($field['attributes']['boolean'] ?? [])),
                    'values'  => (array) ($field['attributes']['values'] ?? []),
                ],
                'ui' => (array) ($field['ui'] ?? []),
            ];
        }

        foreach (['relations', 'softDeletes', 'timestamps'] as $feature) {
            if (array_key_exists($feature, (array) ($config['features'] ?? []))) {
                $persistent['features'][$feature] = !empty($config['features'][$feature]);
            }
        }

        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $key => $relation) {
            $persistent['relationsConfig']['hasMany'][(string) $key] = [
                'enabled'        => !empty($relation['enabled']),
                'title'          => (string) ($relation['title'] ?? ''),
                'icon'           => (string) ($relation['icon'] ?? 'bi-diagram-3'),
                'limit'          => (int) ($relation['limit'] ?? 20),
                'showCount'         => !empty($relation['showCount']),
                'showCreateButton'  => !empty($relation['showCreateButton']),
                'showViewAllButton' => !empty($relation['showViewAllButton']),
                'showViewButton'    => !empty($relation['showViewButton']),
                'collapsible'       => !empty($relation['collapsible']),
                'collapsed'         => !empty($relation['collapsed']),
                // Le colonne hasMany non vengono persistite: derivano sempre
                // dallo schema corrente e vengono generate integralmente.
            ];
        }

        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            $persistent['relationsConfig']['manyToMany'][(string) $key] = [
                'enabled' => !empty($relation['enabled']),
                'title' => (string) ($relation['title'] ?? ''),
                'icon' => (string) ($relation['icon'] ?? 'bi-diagram-2'),
                'limit' => (int) ($relation['limit'] ?? 20),
                'showCount' => !empty($relation['showCount']),
                'showViewButton' => !empty($relation['showViewButton']),
                'createEnabled' => !empty($relation['createEnabled']),
                'editEnabled' => !empty($relation['editEnabled']),
                'createRelatedEnabled' => !empty($relation['createRelatedEnabled']),
                'createRelatedCustomized' => !empty($relation['createRelatedCustomized']),
                'collapsible' => !empty($relation['collapsible']),
                'collapsed' => !empty($relation['collapsed']),
                'formWidth' => $this->normalizeBootstrapWidth(
                    (int) ($relation['formWidth'] ?? (config('MyCrud')->relationPanelWidths['manyToMany'] ?? 12)),
                    (int) (config('MyCrud')->relationPanelWidths['manyToMany'] ?? 12)
                ),
            ];
        }

        if (isset($config['_meta']) && is_array($config['_meta'])) {
            $persistent['_meta'] = $config['_meta'];
        }

        return $persistent;
    }

    private function normalizeLoaded(array $config, string $table): array
    {
        $config['table'] = $table;

        return $config;
    }


    private function normalizeBootstrapWidth(int $width, int $fallback = 12): int
    {
        $allowed = array_values(array_unique(array_filter(
            array_map('intval', array_keys((array) (config('MyCrud')->bootstrapFieldWidths ?? []))),
            static fn (int $value): bool => $value >= 1 && $value <= 12
        )));

        $fallback = max(1, min(12, $fallback));
        if ($allowed === []) {
            return max(1, min(12, $width > 0 ? $width : $fallback));
        }

        if (in_array($width, $allowed, true)) {
            return $width;
        }

        return in_array($fallback, $allowed, true) ? $fallback : $allowed[0];
    }

    private function normalizeForHash(mixed $value): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        if (!array_is_list($value)) {
            ksort($value, SORT_STRING);
        }

        foreach ($value as $key => $item) {
            $value[$key] = $this->normalizeForHash($item);
        }

        return $value;
    }

    private function path(string $table): string
    {
        return $this->directory . $table . '.php';
    }

    private function legacyPath(string $table): string
    {
        return $this->legacyDirectory . $table . '.json';
    }

    private function assertTable(string $table): string
    {
        $table = trim($table);

        if ($table === '' || preg_match('/^[a-zA-Z0-9_]+$/', $table) !== 1) {
            throw new RuntimeException('Invalid table name: ' . $table);
        }

        return $table;
    }

    private function ensureDirectory(string $directory): void
    {
        if (
            !is_dir($directory)
            && !mkdir($directory, 0755, true)
            && !is_dir($directory)
        ) {
            throw new RuntimeException('Impossibile creare la directory: ' . $directory);
        }
    }
}
