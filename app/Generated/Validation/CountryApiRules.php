<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class CountryApiRules
{
    public static function createRules(): array
    {
        return CountryRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return CountryRules::updateRules($id);
    }

    public static function messages(): array
    {
        return CountryRules::messages();
    }
}
