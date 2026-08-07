<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class GuastiApiRules
{
    public static function createRules(): array
    {
        return GuastiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return GuastiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return GuastiRules::messages();
    }
}
