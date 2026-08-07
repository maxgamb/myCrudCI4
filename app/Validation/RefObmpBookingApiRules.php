<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RefObmpBookingApiRules
{
    public static function createRules(): array
    {
        return RefObmpBookingRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RefObmpBookingRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RefObmpBookingRules::messages();
    }
}
