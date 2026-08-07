<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class HotelsApiRules
{
    public static function createRules(): array
    {
        return HotelsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return HotelsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return HotelsRules::messages();
    }
}
