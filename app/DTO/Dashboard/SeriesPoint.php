<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Generic aggregate point used by grouped statistics and chart widgets.
 */
final class SeriesPoint
{
    public function __construct(
        public readonly string $label,
        public readonly int|float $value
    ) {
    }
}