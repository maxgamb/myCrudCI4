<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class EfPriceTableApiRules
{
    public static function createRules(): array
    {
        return EfPriceTableRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return EfPriceTableRules::updateRules($id);
    }

    public static function messages(): array
    {
        return EfPriceTableRules::messages();
    }
}
