<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Immutable Dashboard widget view-model.
 *
 * Payload keys remain widget-specific, while the widget envelope is typed and
 * shared by KPI, chart, recent-record, and quick-link widgets.
 */
final class DashboardWidget
{
    /** @param array<string,mixed> $payload */
    public function __construct(
        public readonly string $type,
        public readonly string $title,
        public readonly int $width,
        public readonly array $payload = []
    ) {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->payload[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->payload);
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return array_merge([
            'type' => $this->type,
            'title' => $this->title,
            'width' => $this->width,
        ], $this->payload);
    }
}