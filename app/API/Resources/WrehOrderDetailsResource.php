<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa wreh_order_details secondo la configurazione del Builder. */
final class WrehOrderDetailsResource
{
    private const READABLE = array (
  0 => 'order_detail_id',
  1 => 'order_id',
  2 => 'product_id',
  3 => 'quantity',
  4 => 'price',
  5 => 'utente_id',
  6 => 'wreh_orders__order_id__label',
  7 => 'wreh_products__product_id__label',
);
    private const WRITABLE = array (
  0 => 'order_id',
  1 => 'product_id',
  2 => 'quantity',
  3 => 'price',
  4 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'order_detail_id',
  1 => 'order_id',
  2 => 'product_id',
);
    private const SORTABLE = array (
  0 => 'order_detail_id',
  1 => 'order_id',
  2 => 'product_id',
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
