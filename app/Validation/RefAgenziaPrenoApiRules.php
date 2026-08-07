<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RefAgenziaPrenoApiRules
{
    public static function createRules(): array
    {
        return RefAgenziaPrenoRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RefAgenziaPrenoRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RefAgenziaPrenoRules::messages();
    }
}
