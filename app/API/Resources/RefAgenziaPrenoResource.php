<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa ref_agenzia_preno secondo la configurazione del Builder. */
final class RefAgenziaPrenoResource
{
    private const READABLE = array (
  0 => 'ref_agenzia_preno',
  1 => 'agenzia_id',
  2 => 'preno_id',
  3 => 'ref_a_p_datarecord',
  4 => 'agenda__preno_id__label',
  5 => 'agenzie__agenzia_id__label',
);
    private const WRITABLE = array (
  0 => 'agenzia_id',
  1 => 'preno_id',
  2 => 'ref_a_p_datarecord',
);
    private const FILTERABLE = array (
  0 => 'ref_agenzia_preno',
  1 => 'agenzia_id',
  2 => 'preno_id',
);
    private const SORTABLE = array (
  0 => 'ref_agenzia_preno',
  1 => 'agenzia_id',
  2 => 'preno_id',
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
