<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class TexLingueApiRules
{
    public static function createRules(): array
    {
        return TexLingueRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return TexLingueRules::updateRules($id);
    }

    public static function messages(): array
    {
        return TexLingueRules::messages();
    }
}
