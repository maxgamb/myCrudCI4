<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class AgenziaPrezziApiRules
{
    public static function createRules(): array
    {
        return AgenziaPrezziRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return AgenziaPrezziRules::updateRules($id);
    }

    public static function messages(): array
    {
        return AgenziaPrezziRules::messages();
    }
}
