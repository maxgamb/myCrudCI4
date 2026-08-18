<?php

declare(strict_types=1);

namespace App\Mcp\Resources;

final class StaffMcpResource
{
    private const READABLE = array (
  0 => 'staff_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'address_id',
  4 => 'email',
  5 => 'store_id',
  6 => 'active',
  7 => 'username',
  8 => 'password',
  9 => 'last_update',
  10 => 'address_id__label',
  11 => 'store_id__label',
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
        return array_map(
            static fn (object|array $record): array => self::make($record),
            $records
        );
    }

}
