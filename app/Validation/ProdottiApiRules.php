<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ProdottiApiRules
{
    public static function createRules(): array
    {
        return ProdottiRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ProdottiRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ProdottiRules::messages();
    }
}
