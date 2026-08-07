<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ContiApiRules
{
    public static function createRules(): array
    {
        return ContiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ContiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ContiRules::messages();
    }
}
