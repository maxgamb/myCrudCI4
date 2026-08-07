<?php

declare(strict_types=1);

namespace App\API\Resources;

/** Serializza la risorsa emails secondo la configurazione del Builder. */
final class EmailsResource
{
    private const READABLE = array (
  0 => 'id',
  1 => 'direction',
  2 => 'uid',
  3 => 'message_id',
  4 => 'in_reply_to',
  5 => 'refs',
  6 => 'email_from',
  7 => 'thread_id',
  8 => 'thread_status',
  9 => 'subject',
  10 => 'body',
  11 => 'category',
  12 => 'language',
  13 => 'reply',
  14 => 'attachments',
  15 => 'replied',
);
    private const WRITABLE = array (
  0 => 'direction',
  1 => 'uid',
  2 => 'message_id',
  3 => 'in_reply_to',
  4 => 'refs',
  5 => 'email_from',
  6 => 'thread_id',
  7 => 'thread_status',
  8 => 'subject',
  9 => 'body',
  10 => 'category',
  11 => 'language',
  12 => 'reply',
  13 => 'attachments',
  14 => 'replied',
);
    private const FILTERABLE = array (
  0 => 'id',
  1 => 'direction',
);
    private const SORTABLE = array (
  0 => 'id',
  1 => 'direction',
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
