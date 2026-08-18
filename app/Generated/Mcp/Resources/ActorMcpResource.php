<?php

declare(strict_types=1);

namespace App\Mcp\Resources;

final class ActorMcpResource
{
    private const READABLE = array (
  0 => 'actor_id',
  1 => 'first_name',
  2 => 'last_name',
  3 => 'last_update',
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
