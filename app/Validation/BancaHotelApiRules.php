<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class BancaHotelApiRules
{
    public static function createRules(): array
    {
        return BancaHotelRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return BancaHotelRules::updateRules($id);
    }

    public static function messages(): array
    {
        return BancaHotelRules::messages();
    }
}
