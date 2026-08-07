<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class AgenzieApiRules
{
    public static function createRules(): array
    {
        return AgenzieRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return AgenzieRules::updateRules($id);
    }

    public static function messages(): array
    {
        return AgenzieRules::messages();
    }
}
