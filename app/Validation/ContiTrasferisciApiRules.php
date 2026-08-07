<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ContiTrasferisciApiRules
{
    public static function createRules(): array
    {
        return ContiTrasferisciRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ContiTrasferisciRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ContiTrasferisciRules::messages();
    }
}
