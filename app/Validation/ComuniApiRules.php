<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ComuniApiRules
{
    public static function createRules(): array
    {
        return ComuniRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ComuniRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ComuniRules::messages();
    }
}
