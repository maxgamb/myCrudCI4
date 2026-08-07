<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ColoriApiRules
{
    public static function createRules(): array
    {
        return ColoriRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ColoriRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ColoriRules::messages();
    }
}
