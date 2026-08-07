<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa doc_file secondo la configurazione del Builder. */
final class DocFileResource
{
    private const READABLE = array (
  0 => 'doc_files_id',
  1 => 'hotel_id',
  2 => 'doc_dipar_id',
  3 => 'doc_protocollo',
  4 => 'doc_url_file',
  5 => 'doc_note',
  6 => 'doc_utente_id',
  7 => 'hotels_nome_hotel',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'doc_dipar_id',
  2 => 'doc_protocollo',
  3 => 'doc_url_file',
  4 => 'doc_note',
  5 => 'doc_utente_id',
);
    private const FILTERABLE = array (
  0 => 'doc_files_id',
  1 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'doc_files_id',
  1 => 'hotel_id',
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
