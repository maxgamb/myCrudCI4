<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class CamereNestingApiRules
{
    public static function createRules(): array
    {
        return CamereNestingRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return CamereNestingRules::updateRules($id);
    }

    public static function messages(): array
    {
        return CamereNestingRules::messages();
    }
}
