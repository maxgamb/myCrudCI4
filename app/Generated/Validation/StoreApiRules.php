<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class StoreApiRules
{
    public static function createRules(): array
    {
        return StoreRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return StoreRules::updateRules($id);
    }

    public static function messages(): array
    {
        return StoreRules::messages();
    }
}
