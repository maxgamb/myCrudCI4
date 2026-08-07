<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa prodotti secondo la configurazione del Builder. */
final class ProdottiResource
{
    private const READABLE = array (
  0 => 'prodotto_id',
  1 => 'prodotti_lista_id',
  2 => 'hotel_id',
  3 => 'nome_prodotto',
  4 => 'prezzo_prodotto',
  5 => 'tipologia_prodotto',
  6 => 'reparto_prodotto',
  7 => 'cent_costo_prodotto',
  8 => 'prodotti_utente_id',
);
    private const WRITABLE = array (
  0 => 'prodotti_lista_id',
  1 => 'hotel_id',
  2 => 'nome_prodotto',
  3 => 'prezzo_prodotto',
  4 => 'tipologia_prodotto',
  5 => 'reparto_prodotto',
  6 => 'cent_costo_prodotto',
  7 => 'prodotti_utente_id',
);
    private const FILTERABLE = array (
  0 => 'prodotto_id',
  1 => 'hotel_id',
);
    private const SORTABLE = array (
  0 => 'prodotto_id',
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
