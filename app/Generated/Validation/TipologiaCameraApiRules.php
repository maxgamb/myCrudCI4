<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class TipologiaCameraApiRules
{
    public static function createRules(): array
    {
        return TipologiaCameraRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return TipologiaCameraRules::updateRules($id);
    }

    public static function messages(): array
    {
        return TipologiaCameraRules::messages();
    }
}
