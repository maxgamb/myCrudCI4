<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class TokenApiRules
{
    public static function createRules(): array
    {
        return TokenRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return TokenRules::updateRules($id);
    }

    public static function messages(): array
    {
        return TokenRules::messages();
    }
}
