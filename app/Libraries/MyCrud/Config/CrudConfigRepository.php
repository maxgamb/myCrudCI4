<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Config;

use Config\MyCrud;
use RuntimeException;

/**
 * Repository delle configurazioni persistenti dei CRUD.
 *
 * Dalla 2.8 le configurazioni fanno parte del progetto e vengono salvate come
 * file PHP versionabili in app/MyCrudConfig/. Non salviamo una copia completa
 * dello schema DB: persistono solo le decisioni dello sviluppatore. In questo
 * modo, ad ogni rigenerazione, tipi, indici e relazioni vengono riletti dal DB.
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
     * Salva uno snapshot compatto e versionabile della configurazione.
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
            . " * Configurazione persistente myCrudGpt per la tabella {$table}.\n"
            . " *\n"
            . " * Questo file contiene solo le scelte dello sviluppatore.\n"
            . " * Tipi DB, indici e relazioni vengono riletti dallo schema ad ogni generazione.\n"
            . " */\n"
            . "return " . var_export($persistent, true) . ";\n";

        $path = $this->path($table);
        $tmp = $path . '.tmp-' . bin2hex(random_bytes(4));

        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile salvare la configurazione temporanea: ' . $tmp);
        }

        if (!rename($tmp, $path)) {
            @unlink($tmp);
            throw new RuntimeException('Impossibile pubblicare la configurazione: ' . $path);
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
                throw new RuntimeException('Configurazione non valida: ' . $path);
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
            throw new RuntimeException('Configurazione legacy non valida: ' . $legacy);
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
     * Migra esplicitamente una configurazione legacy nel formato PHP 2.8.
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

        // La configurazione corrente contiene lo schema aggiornato; le scelte
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
     * Riduce una configurazione completa alle sole decisioni umane.
     */
    private function toPersistentConfig(array $config): array
    {
        $persistent = [
            'table'        => (string) ($config['table'] ?? ''),
            'architecture' => (string) ($config['architecture'] ?? 'basic'),
            'order'        => array_values((array) ($config['order'] ?? [])),
            'fields'       => [],
            'features'     => [],
            'relationsConfig' => [
                'hasMany' => [],
            ],
            'list' => [
                'filtersSummary' => (string) ($config['list']['filtersSummary'] ?? 'Filtri di ricerca'),
            ],
        ];

        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            $persistent['fields'][(string) $name] = [
                'label'        => (string) ($field['label'] ?? ''),
                'inputType'    => (string) ($field['inputType'] ?? 'text'),
                'width'        => (int) ($field['width'] ?? 6),
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
                'uiVisibilityCustomized' => !empty($field['uiVisibilityCustomized']),
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
                'showCount'      => !empty($relation['showCount']),
                'showViewButton' => !empty($relation['showViewButton']),
                // Le colonne hasMany non vengono persistite: derivano sempre
                // dallo schema corrente e vengono generate integralmente.
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
            throw new RuntimeException('Nome tabella non valido: ' . $table);
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
