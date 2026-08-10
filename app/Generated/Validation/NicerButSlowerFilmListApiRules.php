<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class NicerButSlowerFilmListApiRules
{
    public static function createRules(): array
    {
        return NicerButSlowerFilmListRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return NicerButSlowerFilmListRules::updateRules($id);
    }

    public static function messages(): array
    {
        return NicerButSlowerFilmListRules::messages();
    }
}
