<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Entity-aware projection used by recent-record Dashboard widgets.
 *
 * The DTO accepts generated Entities, generic objects, or arrays and exposes
 * only the fields selected by the Dashboard configuration.
 */
final class RecentRecord
{
    /** @param array<string,scalar|null> $values */
    public function __construct(
        public readonly int|string|null $id,
        public readonly array $values
    ) {
    }

    /** @param list<string> $fields */
    public static function from(object|array $record, array $fields, string $primaryKey): self
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

        $values = [];
        foreach ($fields as $field) {
            $value = $source[$field] ?? null;
            $values[$field] = is_scalar($value) || $value === null ? $value : null;
        }

        $id = $source[$primaryKey] ?? null;
        if (!is_int($id) && !is_string($id)) {
            $id = null;
        }

        return new self($id, $values);
    }

    /**
     * @param list<object|array> $records
     * @param list<string> $fields
     * @return list<self>
     */
    public static function collection(array $records, array $fields, string $primaryKey): array
    {
        return array_map(
            static fn (object|array $record): self => self::from($record, $fields, $primaryKey),
            $records
        );
    }

    public function value(string $field): int|float|string|bool|null
    {
        return $this->values[$field] ?? null;
    }

    /** @return array<string,scalar|null> */
    public function toArray(): array
    {
        return $this->values;
    }
}