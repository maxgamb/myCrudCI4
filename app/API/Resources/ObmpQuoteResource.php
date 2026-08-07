<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_quote secondo la configurazione del Builder. */
final class ObmpQuoteResource
{
    private const READABLE = array (
  0 => 'quote_id',
  1 => 'hotel_id',
  2 => 'quote_lg',
  3 => 'quote_dal',
  4 => 'quote_al',
  5 => 'quote_titolo',
  6 => 'quote_cognome',
  7 => 'quote_nome',
  8 => 'quote_email',
  9 => 'trattamento_id',
  10 => 'trariffa_id',
  11 => 'cax_policy_id',
  12 => 'quote_tel_rich',
  13 => 'quote_cc_rich',
  14 => 'quote_del',
  15 => 'quote_data_time',
  16 => 'utente_id',
  17 => 'quote_stato',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'quote_lg',
  2 => 'quote_dal',
  3 => 'quote_al',
  4 => 'quote_titolo',
  5 => 'quote_cognome',
  6 => 'quote_nome',
  7 => 'quote_email',
  8 => 'trattamento_id',
  9 => 'trariffa_id',
  10 => 'cax_policy_id',
  11 => 'quote_tel_rich',
  12 => 'quote_cc_rich',
  13 => 'quote_del',
  14 => 'quote_data_time',
  15 => 'utente_id',
  16 => 'quote_stato',
);
    private const FILTERABLE = array (
  0 => 'quote_id',
);
    private const SORTABLE = array (
  0 => 'quote_id',
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
