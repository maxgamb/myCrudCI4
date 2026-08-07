<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ProvinceApiRules
{
    public static function createRules(): array
    {
        return ProvinceRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ProvinceRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ProvinceRules::messages();
    }
}
