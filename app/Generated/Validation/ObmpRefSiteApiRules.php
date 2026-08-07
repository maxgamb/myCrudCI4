<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpRefSiteApiRules
{
    public static function createRules(): array
    {
        return ObmpRefSiteRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpRefSiteRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpRefSiteRules::messages();
    }
}
