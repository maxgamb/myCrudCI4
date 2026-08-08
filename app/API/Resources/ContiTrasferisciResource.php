<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa conti_trasferisci secondo la configurazione del Builder. */
final class ContiTrasferisciResource
{
    private const READABLE = array (
  0 => 'conti_trasferisci_id',
  1 => 'conto_id_ex',
  2 => 'conto_id_new',
  3 => 'hotel_id',
  4 => 'adebito_id',
  5 => 'conti_tra_data',
  6 => 'adebiti__adebito_id__label',
);
    private const WRITABLE = array (
  0 => 'conto_id_ex',
  1 => 'conto_id_new',
  2 => 'hotel_id',
  3 => 'adebito_id',
  4 => 'conti_tra_data',
);
    private const FILTERABLE = array (
  0 => 'conti_trasferisci_id',
  1 => 'conto_id_ex',
  2 => 'hotel_id',
  3 => 'adebito_id',
);
    private const SORTABLE = array (
  0 => 'conti_trasferisci_id',
  1 => 'conto_id_ex',
  2 => 'hotel_id',
  3 => 'adebito_id',
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
