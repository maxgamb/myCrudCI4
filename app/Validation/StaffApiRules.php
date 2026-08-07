<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class StaffApiRules
{
    public static function createRules(): array
    {
        return StaffRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return StaffRules::updateRules($id);
    }

    public static function messages(): array
    {
        return StaffRules::messages();
    }
}
