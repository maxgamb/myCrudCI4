<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class PraticheApiRules
{
    public static function createRules(): array
    {
        return PraticheRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return PraticheRules::updateRules($id);
    }

    public static function messages(): array
    {
        return PraticheRules::messages();
    }
}
