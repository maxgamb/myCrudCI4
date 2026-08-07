<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa checklist_preno secondo la configurazione del Builder. */
final class ChecklistPrenoResource
{
    private const READABLE = array (
  0 => 'checklist_id',
  1 => 'hotel_id',
  2 => 'preno_id',
  3 => 'preno_dal',
  4 => 'email',
  5 => 'email_pms',
  6 => 'lista',
  7 => 'lista_pms',
  8 => 'pagamento',
  9 => 'tassa',
  10 => 'proforma',
  11 => 'proforma_pms',
  12 => 'bonifico',
  13 => 'importo',
  14 => 'note',
  15 => 'data_check',
  16 => 'utente_id',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'preno_id',
  2 => 'preno_dal',
  3 => 'email',
  4 => 'email_pms',
  5 => 'lista',
  6 => 'lista_pms',
  7 => 'pagamento',
  8 => 'tassa',
  9 => 'proforma',
  10 => 'proforma_pms',
  11 => 'bonifico',
  12 => 'importo',
  13 => 'note',
  14 => 'data_check',
  15 => 'utente_id',
);
    private const FILTERABLE = array (
  0 => 'checklist_id',
  1 => 'hotel_id',
  2 => 'preno_id',
);
    private const SORTABLE = array (
  0 => 'checklist_id',
  1 => 'hotel_id',
  2 => 'preno_id',
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
