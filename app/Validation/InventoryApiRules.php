<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class InventoryApiRules
{
    public static function createRules(): array
    {
        return InventoryRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return InventoryRules::updateRules($id);
    }

    public static function messages(): array
    {
        return InventoryRules::messages();
    }
}
