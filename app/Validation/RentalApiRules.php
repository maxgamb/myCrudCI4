<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RentalApiRules
{
    public static function createRules(): array
    {
        return RentalRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RentalRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RentalRules::messages();
    }
}
