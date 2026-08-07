<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpRestrictionsApiRules
{
    public static function createRules(): array
    {
        return ObmpRestrictionsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpRestrictionsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpRestrictionsRules::messages();
    }
}
