<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class WrehOrdersApiRules
{
    public static function createRules(): array
    {
        return WrehOrdersRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return WrehOrdersRules::updateRules($id);
    }

    public static function messages(): array
    {
        return WrehOrdersRules::messages();
    }
}
