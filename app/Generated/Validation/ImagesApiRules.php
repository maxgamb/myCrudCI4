<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ImagesApiRules
{
    public static function createRules(): array
    {
        return ImagesRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ImagesRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ImagesRules::messages();
    }
}
