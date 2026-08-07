<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class PraticheRifApiRules
{
    public static function createRules(): array
    {
        return PraticheRifRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return PraticheRifRules::updateRules($id);
    }

    public static function messages(): array
    {
        return PraticheRifRules::messages();
    }
}
