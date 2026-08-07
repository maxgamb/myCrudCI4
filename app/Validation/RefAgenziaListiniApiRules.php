<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RefAgenziaListiniApiRules
{
    public static function createRules(): array
    {
        return RefAgenziaListiniRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RefAgenziaListiniRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RefAgenziaListiniRules::messages();
    }
}
