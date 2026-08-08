<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa conti_note secondo la configurazione del Builder. */
final class ContiNoteResource
{
    private const READABLE = array (
  0 => 'conto_nota_id',
  1 => 'conto_id',
  2 => 'hotel_id',
  3 => 'conto_nota_testo',
  4 => 'note_conto_utente_id',
  5 => 'conti__conto_id__label',
);
    private const WRITABLE = array (
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'conto_nota_testo',
  3 => 'note_conto_utente_id',
);
    private const FILTERABLE = array (
  0 => 'conto_nota_id',
  1 => 'conto_id',
);
    private const SORTABLE = array (
  0 => 'conto_nota_id',
  1 => 'conto_id',
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
