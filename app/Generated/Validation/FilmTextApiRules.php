<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class FilmTextApiRules
{
    public static function createRules(): array
    {
        return FilmTextRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return FilmTextRules::updateRules($id);
    }

    public static function messages(): array
    {
        return FilmTextRules::messages();
    }
}
