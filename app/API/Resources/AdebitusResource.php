<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa adebiti senza esporre campi sensibili. */
final class AdebitusResource
{
    private const READABLE = array (
  0 => 'adebito_id',
  1 => 'conto_id',
  2 => 'hotel_id',
  3 => 'prodotto_id',
  4 => 'descrizione',
  5 => 'prezzo',
  6 => 'quantita',
  7 => 'adebiti_data_record',
  8 => 'adebiti_utente_id',
  9 => 'preno_id',
  10 => 'prodotti_nome_prodotto',
);
    private const WRITABLE = array (
  0 => 'conto_id',
  1 => 'hotel_id',
  2 => 'prodotto_id',
  3 => 'descrizione',
  4 => 'prezzo',
  5 => 'quantita',
  6 => 'adebiti_data_record',
  7 => 'adebiti_utente_id',
  8 => 'preno_id',
);
    private const FILTERABLE = array (
  0 => 'adebito_id',
  1 => 'conto_id',
  2 => 'hotel_id',
  3 => 'prodotto_id',
  4 => 'descrizione',
  5 => 'prezzo',
  6 => 'quantita',
  7 => 'adebiti_data_record',
  8 => 'adebiti_utente_id',
  9 => 'preno_id',
);
    private const SORTABLE = array (
  0 => 'adebito_id',
  1 => 'conto_id',
  2 => 'hotel_id',
  3 => 'prodotto_id',
  4 => 'descrizione',
  5 => 'prezzo',
  6 => 'quantita',
  7 => 'adebiti_data_record',
  8 => 'adebiti_utente_id',
  9 => 'preno_id',
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
