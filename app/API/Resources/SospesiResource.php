<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa sospesi secondo la configurazione del Builder. */
final class SospesiResource
{
    private const READABLE = array (
  0 => 'sospeso_id',
  1 => 'hotel_id',
  2 => 'pagamento_id',
  3 => 'cassa_id',
  4 => 'sospeso_data',
  5 => 'sospeso_conto_id',
  6 => 'sospeso_pratica_id',
  7 => 'sospeso_preno_id',
  8 => 'sospeso_fatt_numero',
  9 => 'sopeso_importo',
  10 => 'sospeso_imp_conto',
  11 => 'sopeso_societa',
  12 => 'sospeso_note',
  13 => 'sospeso_stato',
  14 => 'sospesi_utente_id',
  15 => 'agenzie__sopeso_societa__label',
  16 => 'pratiche__sospeso_pratica_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'pagamento_id',
  2 => 'cassa_id',
  3 => 'sospeso_data',
  4 => 'sospeso_conto_id',
  5 => 'sospeso_pratica_id',
  6 => 'sospeso_preno_id',
  7 => 'sospeso_fatt_numero',
  8 => 'sopeso_importo',
  9 => 'sospeso_imp_conto',
  10 => 'sopeso_societa',
  11 => 'sospeso_note',
  12 => 'sospeso_stato',
  13 => 'sospesi_utente_id',
);
    private const FILTERABLE = array (
  0 => 'sospeso_id',
  1 => 'hotel_id',
  2 => 'pagamento_id',
  3 => 'sospeso_data',
  4 => 'sospeso_conto_id',
  5 => 'sospeso_pratica_id',
  6 => 'sopeso_societa',
);
    private const SORTABLE = array (
  0 => 'sospeso_id',
  1 => 'hotel_id',
  2 => 'pagamento_id',
  3 => 'sospeso_data',
  4 => 'sospeso_conto_id',
  5 => 'sospeso_pratica_id',
  6 => 'sopeso_societa',
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
