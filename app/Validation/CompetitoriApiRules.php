<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class CompetitoriApiRules
{
    public static function createRules(): array
    {
        return CompetitoriRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return CompetitoriRules::updateRules($id);
    }

    public static function messages(): array
    {
        return CompetitoriRules::messages();
    }
}
