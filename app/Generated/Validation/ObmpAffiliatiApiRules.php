<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpAffiliatiApiRules
{
    public static function createRules(): array
    {
        return ObmpAffiliatiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpAffiliatiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpAffiliatiRules::messages();
    }
}
