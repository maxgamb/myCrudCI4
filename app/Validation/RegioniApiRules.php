<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RegioniApiRules
{
    public static function createRules(): array
    {
        return RegioniRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RegioniRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RegioniRules::messages();
    }
}
