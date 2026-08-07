<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa email_ai_history secondo la configurazione del Builder. */
final class EmailAiHistoryResource
{
    private const READABLE = array (
  0 => 'id',
  1 => 'hotel_id',
  2 => 'raw_email',
  3 => 'json_classifier',
  4 => 'category',
  5 => 'confidence',
  6 => 'referente_tipo',
  7 => 'prenotazione_tipo',
  8 => 'finalita',
  9 => 'segmento_commerciale',
  10 => 'agent_selected',
  11 => 'reply_prompt',
  12 => 'gpt_reply_raw',
  13 => 'gpt_reply_clean',
  14 => 'pms_output',
);
    private const WRITABLE = array (
  0 => 'hotel_id',
  1 => 'raw_email',
  2 => 'json_classifier',
  3 => 'category',
  4 => 'confidence',
  5 => 'referente_tipo',
  6 => 'prenotazione_tipo',
  7 => 'finalita',
  8 => 'segmento_commerciale',
  9 => 'agent_selected',
  10 => 'reply_prompt',
  11 => 'gpt_reply_raw',
  12 => 'gpt_reply_clean',
  13 => 'pms_output',
);
    private const FILTERABLE = array (
  0 => 'id',
);
    private const SORTABLE = array (
  0 => 'id',
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
