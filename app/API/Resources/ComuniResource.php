<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa comuni secondo la configurazione del Builder. */
final class ComuniResource
{
    private const READABLE = array (
  0 => 'Comuni_Codice',
  1 => 'Comuni_Nome',
  2 => 'Comuni_Prov',
  3 => 'Comuni_CAP',
  4 => 'Comuni_Prefisso',
  5 => 'Comuni_ColExcel',
  6 => 'Comuni_Nazione',
  7 => 'Comuni_Lingua',
  8 => 'nazione_iso2',
  9 => 'nazione_iso3',
);
    private const WRITABLE = array (
  0 => 'Comuni_Codice',
  1 => 'Comuni_Nome',
  2 => 'Comuni_Prov',
  3 => 'Comuni_CAP',
  4 => 'Comuni_Prefisso',
  5 => 'Comuni_ColExcel',
  6 => 'Comuni_Nazione',
  7 => 'Comuni_Lingua',
  8 => 'nazione_iso2',
  9 => 'nazione_iso3',
);
    private const FILTERABLE = array (
  0 => 'Comuni_Codice',
  1 => 'Comuni_Nome',
);
    private const SORTABLE = array (
  0 => 'Comuni_Codice',
  1 => 'Comuni_Nome',
);

    public static function make(object|array $record): array
    {
        if (is_array($record)) {
            $source = $record;
        } elseif (method_exists($record, 'toRawArray')) {
            $source = $record->toRawArray();
        } elseif (method_exists($record, 'toArray')) {
            $source = $record->toArray();
        } else {
            $source = get_object_vars($record);
        }

        return array_intersect_key($source, array_flip(self::READABLE));
    }

    public static function collection(array $records): array
    {
        return array_map(static fn (object|array $record): array => self::make($record), $records);
    }

    public static function writableData(array $data): array
    {
        return array_intersect_key($data, array_flip(self::WRITABLE));
    }

    public static function filterableFields(): array
    {
        return self::FILTERABLE;
    }

    public static function sortableFields(): array
    {
        return self::SORTABLE;
    }
}
