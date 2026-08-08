<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa pagamenti_sospesi secondo la configurazione del Builder. */
final class PagamentiSospesiResource
{
    private const READABLE = array (
  0 => 'pagamento_id',
  1 => 'hotel_id',
  2 => 'sospeso_id',
  3 => 'paga_sosp_importo',
  4 => 'data_pagamento',
  5 => 'paga_modalita',
  6 => 'data_rec_paga_sosp',
  7 => 'pagamenti_sospesi_utente_id',
  8 => 'sospesi__sospeso_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'sospeso_id',
  2 => 'paga_sosp_importo',
  3 => 'data_pagamento',
  4 => 'paga_modalita',
  5 => 'data_rec_paga_sosp',
  6 => 'pagamenti_sospesi_utente_id',
);
    private const FILTERABLE = array (
  0 => 'pagamento_id',
  1 => 'hotel_id',
  2 => 'sospeso_id',
);
    private const SORTABLE = array (
  0 => 'pagamento_id',
  1 => 'hotel_id',
  2 => 'sospeso_id',
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
