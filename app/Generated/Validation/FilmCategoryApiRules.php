<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class FilmCategoryApiRules
{
    public static function createRules(): array
    {
        return FilmCategoryRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return FilmCategoryRules::updateRules($id);
    }

    public static function messages(): array
    {
        return FilmCategoryRules::messages();
    }
}
