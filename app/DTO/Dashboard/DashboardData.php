<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Typed result returned by DashboardService and passed unchanged to the View.
 */
final class DashboardData
{
    /**
     * @param array<string,mixed> $globalDateFilter
     * @param array{from:string,to:string} $activeDateRange
     * @param list<array<string,mixed>> $globalFilters
     * @param array<string,mixed> $activeGlobalValues
     * @param list<DashboardWidget> $widgets
     */
    public function __construct(
        public readonly string $title,
        public readonly array $globalDateFilter,
        public readonly array $activeDateRange,
        public readonly array $globalFilters,
        public readonly array $activeGlobalValues,
        public readonly array $widgets
    ) {
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'globalDateFilter' => $this->globalDateFilter,
            'activeDateRange' => $this->activeDateRange,
            'globalFilters' => $this->globalFilters,
            'activeGlobalValues' => $this->activeGlobalValues,
            'widgets' => array_map(
                static fn (DashboardWidget $widget): array => $widget->toArray(),
                $this->widgets
            ),
        ];
    }
}