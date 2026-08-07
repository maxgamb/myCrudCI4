<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class AgenziaListiniApiRules
{
    public static function createRules(): array
    {
        return AgenziaListiniRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return AgenziaListiniRules::updateRules($id);
    }

    public static function messages(): array
    {
        return AgenziaListiniRules::messages();
    }
}
