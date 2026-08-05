<?php

namespace App\Libraries\MyCrud\Core;

final class Naming
{
    public static function studly(string $value): string
    {
        $value = str_replace(['-', '_'], ' ', trim($value));

        return str_replace(' ', '', ucwords(strtolower($value)));
    }

    public static function singularStudly(string $table): string
    {
        helper('inflector');

        $singular = function_exists('singular')
            ? singular($table)
            : rtrim($table, 's');

        return self::studly($singular);
    }

    public static function human(string $value): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $value));
    }
}
