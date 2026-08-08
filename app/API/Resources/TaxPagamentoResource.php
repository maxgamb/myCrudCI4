<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa tax_pagamento secondo la configurazione del Builder. */
final class TaxPagamentoResource
{
    private const READABLE = array (
  0 => 'tax_pagamento_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'pratica_id',
  4 => 'importo',
  5 => 'pagamento_forma',
  6 => 'tassa_stato',
  7 => 'data_pagamento',
  8 => 'tax_pagamento_utente_id',
  9 => 'conti__conto_id__label',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'conto_id',
  2 => 'pratica_id',
  3 => 'importo',
  4 => 'pagamento_forma',
  5 => 'tassa_stato',
  6 => 'data_pagamento',
  7 => 'tax_pagamento_utente_id',
);
    private const FILTERABLE = array (
  0 => 'tax_pagamento_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'pratica_id',
  4 => 'importo',
  5 => 'data_pagamento',
);
    private const SORTABLE = array (
  0 => 'tax_pagamento_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'pratica_id',
  4 => 'importo',
  5 => 'data_pagamento',
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
