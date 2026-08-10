<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class FilmApiRules
{
    public static function createRules(): array
    {
        return FilmRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return FilmRules::updateRules($id);
    }

    public static function messages(): array
    {
        return FilmRules::messages();
    }
}
