<?php
namespace App\Libraries\MyCrud\Schema;

use CodeIgniter\Database\BaseConnection;
use Config\MyCrud;

final class TableFilter
{
    public static function validTables(BaseConnection $db, ?MyCrud $config = null): array
    {
        $config ??= config('MyCrud');

        // information_schema include esplicitamente sia BASE TABLE sia VIEW.
        // Non dipendiamo dal comportamento specifico di listTables() rispetto
        // for views, so the Builder can show and configure them reliably.
        $rows = $db->query(
            "SELECT TABLE_NAME AS tableName
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_TYPE IN ('BASE TABLE', 'VIEW')
             ORDER BY TABLE_NAME"
        )->getResultArray();

        $tables = array_values(array_filter(
            array_map(static fn (array $row): string => (string) ($row['tableName'] ?? ''), $rows),
            static function (string $table) use ($config): bool {
                if (
                    $table === ''
                    || ctype_digit($table)
                    || preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table) !== 1
                    || in_array($table, $config->ignoredTables, true)
                ) {
                    return false;
                }

                foreach ($config->ignoredTablePatterns as $pattern) {
                    if (@preg_match($pattern, $table) === 1) {
                        return false;
                    }
                }

                return true;
            }
        ));

        sort($tables);

        return $tables;
    }
    /**
     * Restituisce il tipo SQL degli oggetti configurabili senza cambiare la
     * firma storica di validTables(). Serve solo alla UI per distinguere
     * BASE TABLE e VIEW.
     *
     * @return array<string, string> nome => BASE TABLE|VIEW
     */
    public static function objectTypes(BaseConnection $db, ?MyCrud $config = null): array
    {
        $tables = self::validTables($db, $config);
        if ($tables === []) {
            return [];
        }

        $rows = $db->query(
            'SELECT TABLE_NAME AS tableName, TABLE_TYPE AS tableType
             FROM information_schema.TABLES
             WHERE TABLE_SCHEMA = DATABASE()'
        )->getResultArray();

        $allowed = array_fill_keys($tables, true);
        $types = [];
        foreach ($rows as $row) {
            $name = (string) ($row['tableName'] ?? '');
            if ($name === '' || !isset($allowed[$name])) {
                continue;
            }
            $types[$name] = strtoupper((string) ($row['tableType'] ?? 'BASE TABLE'));
        }

        foreach ($tables as $table) {
            $types[$table] ??= 'BASE TABLE';
        }

        ksort($types, SORT_NATURAL | SORT_FLAG_CASE);
        return $types;
    }

}
