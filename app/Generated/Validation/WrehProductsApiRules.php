<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class WrehProductsApiRules
{
    public static function createRules(): array
    {
        return WrehProductsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return WrehProductsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return WrehProductsRules::messages();
    }
}
