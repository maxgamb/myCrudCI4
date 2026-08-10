<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class FilmListApiRules
{
    public static function createRules(): array
    {
        return FilmListRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return FilmListRules::updateRules($id);
    }

    public static function messages(): array
    {
        return FilmListRules::messages();
    }
}
