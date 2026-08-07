<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ModificaContiApiRules
{
    public static function createRules(): array
    {
        return ModificaContiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ModificaContiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ModificaContiRules::messages();
    }
}
