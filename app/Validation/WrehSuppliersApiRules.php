<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class WrehSuppliersApiRules
{
    public static function createRules(): array
    {
        return WrehSuppliersRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return WrehSuppliersRules::updateRules($id);
    }

    public static function messages(): array
    {
        return WrehSuppliersRules::messages();
    }
}
