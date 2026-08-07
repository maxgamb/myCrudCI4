<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa obmp_clienti secondo la configurazione del Builder. */
final class ObmpClientiResource
{
    private const READABLE = array (
  0 => 'obm_cliente_id',
  1 => 'obm_cliente_first_name',
  2 => 'obm_cliente_last_name',
  3 => 'obm_cliente_email',
  4 => 'obm_cliente_city',
  5 => 'obm_cliente_country',
  6 => 'lingua',
  7 => 'obm_cliente_phone',
  8 => 'obm_cliente_newsletter',
  9 => 'obm_cliente_pass',
  10 => 'obm_cliente_data_insert',
  11 => 'obm_cliente_cc_type',
  12 => 'obm_cliente_cc_number',
  13 => 'obm_cliente_holder',
  14 => 'obm_cliente_cc_expire',
  15 => 'obm_cliente_cc_security',
);
    private const WRITABLE = array (
  0 => 'obm_cliente_first_name',
  1 => 'obm_cliente_last_name',
  2 => 'obm_cliente_email',
  3 => 'obm_cliente_city',
  4 => 'obm_cliente_country',
  5 => 'lingua',
  6 => 'obm_cliente_phone',
  7 => 'obm_cliente_newsletter',
  8 => 'obm_cliente_pass',
  9 => 'obm_cliente_data_insert',
  10 => 'obm_cliente_cc_type',
  11 => 'obm_cliente_cc_number',
  12 => 'obm_cliente_holder',
  13 => 'obm_cliente_cc_expire',
  14 => 'obm_cliente_cc_security',
);
    private const FILTERABLE = array (
  0 => 'obm_cliente_id',
  1 => 'obm_cliente_email',
);
    private const SORTABLE = array (
  0 => 'obm_cliente_id',
  1 => 'obm_cliente_email',
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
