<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class SalesByFilmCategoryApiRules
{
    public static function createRules(): array
    {
        return SalesByFilmCategoryRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return SalesByFilmCategoryRules::updateRules($id);
    }

    public static function messages(): array
    {
        return SalesByFilmCategoryRules::messages();
    }
}
