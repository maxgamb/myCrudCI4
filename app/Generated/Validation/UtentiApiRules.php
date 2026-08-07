<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class UtentiApiRules
{
    public static function createRules(): array
    {
        return UtentiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return UtentiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return UtentiRules::messages();
    }
}
