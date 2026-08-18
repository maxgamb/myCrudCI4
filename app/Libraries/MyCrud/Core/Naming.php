<?php

namespace App\Libraries\MyCrud\Core;

final class Naming
{
    public static function studly(string $value): string
    {
        $value = str_replace(['-', '_'], ' ', trim($value));

        return str_replace(' ', '', ucwords(strtolower($value)));
    }

    /**
     * Converts the physical table name to StudlyCase without attempting
     * singularizzazioni linguistiche. Il database resta la fonte del nome:
     * clienti -> Clienti, conti -> Conti, foglio_giorno -> FoglioGiorno.
     */
    public static function tableClass(string $table): string
    {
        return self::studly($table);
    }

    public static function human(string $value): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $value));
    }
}
