<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa agenzia_prezzi secondo la configurazione del Builder. */
final class AgenziaPrezziResource
{
    private const READABLE = array (
  0 => 'agenzia_prezzi_id',
  1 => 'hotel_id',
  2 => 'agenzia_listini_id',
  3 => 'agenzia_listini_dal',
  4 => 'agenzia_listini_al',
  5 => 'agenzia_prezzi_1pax',
  6 => 'agenzia_prezzi_2pax',
  7 => 'agenzia_prezzi_3pax',
  8 => 'agenzia_prezzi_4pax',
  9 => 'agenzia_prezzi_free_pax',
  10 => 'agenzia_prezzi_free',
  11 => 'agenzia_prezzi_portage',
  12 => 'agenzia_prezzi_wdrink',
  13 => 'agenzia_prezzi_american_bb',
  14 => 'agenzia_prezzi_pranzo',
  15 => 'agenzia_prezzi_cena',
  16 => 'agenzia_prezzi_nome',
  17 => 'agenzia_prezzi_note',
  18 => 'agenzia_prezzi_datarecord',
  19 => 'agenzia_listini__agenzia_prezzi_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'agenzia_listini_id',
  2 => 'agenzia_listini_dal',
  3 => 'agenzia_listini_al',
  4 => 'agenzia_prezzi_1pax',
  5 => 'agenzia_prezzi_2pax',
  6 => 'agenzia_prezzi_3pax',
  7 => 'agenzia_prezzi_4pax',
  8 => 'agenzia_prezzi_free_pax',
  9 => 'agenzia_prezzi_free',
  10 => 'agenzia_prezzi_portage',
  11 => 'agenzia_prezzi_wdrink',
  12 => 'agenzia_prezzi_american_bb',
  13 => 'agenzia_prezzi_pranzo',
  14 => 'agenzia_prezzi_cena',
  15 => 'agenzia_prezzi_nome',
  16 => 'agenzia_prezzi_note',
  17 => 'agenzia_prezzi_datarecord',
);
    private const FILTERABLE = array (
  0 => 'agenzia_prezzi_id',
  1 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'agenzia_prezzi_id',
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
