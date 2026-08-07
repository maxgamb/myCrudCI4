<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ProductsApiRules
{
    public static function createRules(): array
    {
        return ProductsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ProductsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ProductsRules::messages();
    }
}
