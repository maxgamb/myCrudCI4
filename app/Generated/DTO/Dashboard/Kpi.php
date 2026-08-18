<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

final class Kpi
{
    public function __construct(
        public readonly string $label,
        public readonly int|float $value,
        public readonly string $formattedValue
    ) {
    }
}