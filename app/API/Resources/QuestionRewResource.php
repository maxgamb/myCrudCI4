<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa question_rew secondo la configurazione del Builder. */
final class QuestionRewResource
{
    private const READABLE = array (
  0 => 'question_rew_id',
  1 => 'question_id',
  2 => 'hotel_id',
  3 => 'conto_id',
  4 => 'clienti_id',
  5 => 'valore',
  6 => 'data',
  7 => 'question__question_id__label',
);
    private const WRITABLE = array (
  0 => 'question_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'clienti_id',
  4 => 'valore',
  5 => 'data',
);
    private const FILTERABLE = array (
  0 => 'question_rew_id',
  1 => 'question_id',
);
    private const SORTABLE = array (
  0 => 'question_rew_id',
  1 => 'question_id',
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
