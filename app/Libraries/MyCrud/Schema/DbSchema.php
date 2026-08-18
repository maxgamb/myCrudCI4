<?php
namespace App\Libraries\MyCrud\Schema;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\MyCrud;

class DbSchema
{
    private BaseConnection $db;
    private MyCrud $config;

    public function __construct(?BaseConnection $db = null, ?MyCrud $config = null)
    {
        $this->db = $db ?? Database::connect();
        $this->config = $config ?? config('MyCrud');
    }

    public function getSchemaInfo(?string $table = null): array
    {
        if ($table !== null) {
            $this->assertTableExists($table);

            return [
                'tables' => [$table => $this->getTableInfo($table)],
                'relations' => $this->relationsFor($table),
            ];
        }

        $tables = [];
        foreach (TableFilter::validTables($this->db, $this->config) as $tableName) {
            $tables[$tableName] = $this->getTableInfo($tableName);
        }

        return ['tables' => $tables, 'relations' => $this->relationsFor(null)];
    }

    public function getTableInfo(string $table): array
    {
        $this->assertTableExists($table);

        $columns = $this->db->query(
            'SELECT COLUMN_NAME AS name,
                    COLUMN_DEFAULT AS defaultValue,
                    IS_NULLABLE AS nullable,
                    DATA_TYPE AS type,
                    COLUMN_TYPE AS columnType,
                    CHARACTER_MAXIMUM_LENGTH AS maxLength,
                    NUMERIC_PRECISION AS numericPrecision,
                    NUMERIC_SCALE AS numericScale,
                    COLUMN_KEY AS columnKey,
                    EXTRA AS extra
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?
             ORDER BY ORDINAL_POSITION',
            [$table]
        )->getResultArray();

        $primaryKeys = [];
        foreach ($columns as $column) {
            if (($column['columnKey'] ?? '') === 'PRI') {
                $primaryKeys[] = (string) $column['name'];
            }
        }
        $primaryKey = $primaryKeys[0] ?? ($columns[0]['name'] ?? 'id');

        $foreignKeys = $this->db->query(
            'SELECT COLUMN_NAME AS childColumn,
                    REFERENCED_TABLE_NAME AS parentTable,
                    REFERENCED_COLUMN_NAME AS parentColumn,
                    CONSTRAINT_NAME AS constraintName
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND REFERENCED_TABLE_NAME IS NOT NULL',
            [$table]
        )->getResultArray();

        $indexes = $this->db->query(
            'SELECT INDEX_NAME AS indexName,
                    COLUMN_NAME AS columnName,
                    NON_UNIQUE AS nonUnique,
                    SEQ_IN_INDEX AS sequence,
                    INDEX_TYPE AS indexType
             FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?
             ORDER BY INDEX_NAME, SEQ_IN_INDEX',
            [$table]
        )->getResultArray();

        // TABLE_ROWS e le dimensioni sono stime leggere, utili al Builder e
        // to diagnostics without running COUNT(*) during configuration.
        $stats = $this->db->query(
            'SELECT TABLE_ROWS AS rowEstimate,
                    DATA_LENGTH AS dataLength,
                    INDEX_LENGTH AS indexLength,
                    TABLE_TYPE AS tableType
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?
             LIMIT 1',
            [$table]
        )->getRowArray() ?: [];

        return [
            'name' => $table,
            // primaryKey resta per compatibilità con CI4 Model e con i generatori
            // esistenti; primaryKeys descrive invece la PK reale completa.
            'primaryKey' => (string) $primaryKey,
            'primaryKeys' => array_values($primaryKeys),
            'hasPrimaryKey' => $primaryKeys !== [],
            'compositePrimaryKey' => count($primaryKeys) > 1,
            'tableType' => strtoupper((string) ($stats['tableType'] ?? 'BASE TABLE')),
            'isView' => strtoupper((string) ($stats['tableType'] ?? 'BASE TABLE')) === 'VIEW',
            'columns' => $columns,
            'foreignKeys' => $foreignKeys,
            'indexes' => $indexes,
            'rowEstimate' => max(0, (int) ($stats['rowEstimate'] ?? 0)),
            'dataLength' => max(0, (int) ($stats['dataLength'] ?? 0)),
            'indexLength' => max(0, (int) ($stats['indexLength'] ?? 0)),
        ];
    }

    /**
     * Restituisce tutte le tabelle del database che sono destinazione di
     * almeno una foreign key. L'elenco e' globale, deduplicato e limitato
     * alle tabelle configurabili dal Builder, cosi' ogni voce puo' essere
     * opened directly with /mycrud/builder/configure/<table>.
     */
    public function parentTables(): array
    {
        $rows = $this->db->query(
            'SELECT DISTINCT REFERENCED_TABLE_NAME AS parentTable
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND REFERENCED_TABLE_NAME IS NOT NULL
             ORDER BY REFERENCED_TABLE_NAME'
        )->getResultArray();

        $validTables = array_fill_keys(
            TableFilter::validTables($this->db, $this->config),
            true
        );

        $parents = [];
        foreach ($rows as $row) {
            $parentTable = trim((string) ($row['parentTable'] ?? ''));
            if ($parentTable === '' || !isset($validTables[$parentTable])) {
                continue;
            }

            $parents[$parentTable] = $parentTable;
        }

        ksort($parents, SORT_NATURAL | SORT_FLAG_CASE);

        return array_values($parents);
    }

    private function relationsFor(?string $table): array
    {
        $sql = 'SELECT TABLE_NAME AS childTable,
                       COLUMN_NAME AS childColumn,
                       REFERENCED_TABLE_NAME AS parentTable,
                       REFERENCED_COLUMN_NAME AS parentColumn
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND REFERENCED_TABLE_NAME IS NOT NULL';
        $params = [];

        if ($table !== null) {
            $sql .= ' AND (TABLE_NAME = ? OR REFERENCED_TABLE_NAME = ?)';
            $params = [$table, $table];
        }

        return $this->db->query($sql, $params)->getResultArray();
    }

    private function assertTableExists(string $table): void
    {
        if (
            $table === ''
            || ctype_digit($table)
            || preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table) !== 1
            || !in_array($table, TableFilter::validTables($this->db, $this->config), true)
        ) {
            throw PageNotFoundException::forPageNotFound(
                'Invalid, missing, or excluded table: ' . $table
            );
        }
    }
}
