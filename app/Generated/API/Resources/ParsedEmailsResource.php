<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa parsed_emails secondo la configurazione del Builder. */
final class ParsedEmailsResource
{
    private const READABLE = array (
  0 => 'id',
  1 => 'hotel_id',
  2 => 'category',
  3 => 'referente_tipo',
  4 => 'prenotazione_tipo',
  5 => 'finalita',
  6 => 'segmento_commerciale',
  7 => 'raw_email',
  8 => 'json_parsed',
);
    private const WRITABLE = array (
  0 => 'id',
  1 => 'hotel_id',
  2 => 'category',
  3 => 'referente_tipo',
  4 => 'prenotazione_tipo',
  5 => 'finalita',
  6 => 'segmento_commerciale',
  7 => 'raw_email',
  8 => 'json_parsed',
);
    private const FILTERABLE = array (
);
    private const SORTABLE = array (
  0 => 'id',
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
