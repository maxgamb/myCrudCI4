<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class RefCostiTipologiaApiRules
{
    public static function createRules(): array
    {
        return RefCostiTipologiaRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return RefCostiTipologiaRules::updateRules($id);
    }

    public static function messages(): array
    {
        return RefCostiTipologiaRules::messages();
    }
}
