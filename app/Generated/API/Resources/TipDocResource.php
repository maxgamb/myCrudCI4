<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa tip_doc secondo la configurazione del Builder. */
final class TipDocResource
{
    private const READABLE = array (
  0 => 'tip_doc_id',
  1 => 'Doc_CodMin',
  2 => 'Doc_Descrizione',
);
    private const WRITABLE = array (
  0 => 'Doc_CodMin',
  1 => 'Doc_Descrizione',
);
    private const FILTERABLE = array (
  0 => 'tip_doc_id',
  1 => 'Doc_CodMin',
  2 => 'Doc_Descrizione',
);
    private const SORTABLE = array (
  0 => 'tip_doc_id',
  1 => 'Doc_CodMin',
  2 => 'Doc_Descrizione',
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
