<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa prodotti_lista secondo la configurazione del Builder. */
final class ProdottiListaResource
{
    private const READABLE = array (
  0 => 'prodotti_lista_id',
  1 => 'prod_lista_mone',
  2 => 'prod_lista_descrixione',
  3 => 'prod_lista_allergenici',
  4 => 'prod_lista_costo_unitario',
  5 => 'prod_lista_img',
  6 => 'prod_lista_data',
  7 => 'prod_lista_user_id',
  8 => 'prodotti__prodotti_lista_id__label',
);
    private const WRITABLE = array (
  0 => 'prod_lista_mone',
  1 => 'prod_lista_descrixione',
  2 => 'prod_lista_allergenici',
  3 => 'prod_lista_costo_unitario',
  4 => 'prod_lista_img',
  5 => 'prod_lista_data',
  6 => 'prod_lista_user_id',
);
    private const FILTERABLE = array (
  0 => 'prodotti_lista_id',
);
    private const SORTABLE = array (
  0 => 'prodotti_lista_id',
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
