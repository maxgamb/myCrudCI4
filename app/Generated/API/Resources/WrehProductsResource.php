<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa wreh_products secondo la configurazione del Builder. */
final class WrehProductsResource
{
    private const READABLE = array (
  0 => 'product_id',
  1 => 'costi_area_id',
  2 => 'name',
  3 => 'description',
  4 => 'price',
  5 => 'stock_quantity',
  6 => 'supplier_id',
  7 => 'costi_area_costi_area_nome',
  8 => 'wreh_suppliers_company',
);
    private const WRITABLE = array (
  0 => 'costi_area_id',
  1 => 'name',
  2 => 'description',
  3 => 'price',
  4 => 'stock_quantity',
  5 => 'supplier_id',
);
    private const FILTERABLE = array (
  0 => 'product_id',
  1 => 'costi_area_id',
  2 => 'supplier_id',
);
    private const SORTABLE = array (
  0 => 'product_id',
  1 => 'costi_area_id',
  2 => 'supplier_id',
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
