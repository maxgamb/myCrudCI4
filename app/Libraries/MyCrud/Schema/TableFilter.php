<?php
namespace App\Libraries\MyCrud\Schema;

use CodeIgniter\Database\BaseConnection;
use Config\MyCrud;

final class TableFilter
{
    public static function validTables(BaseConnection $db, ?MyCrud $config = null): array
    {
        $config ??= config('MyCrud');

        $tables = array_values(array_filter(
            $db->listTables(),
            static fn (string $table): bool =>
                $table !== ''
                && !ctype_digit($table)
                && preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table) === 1
                && !in_array($table, $config->ignoredTables, true)
        ));

        sort($tables);

        return $tables;
    }
}
