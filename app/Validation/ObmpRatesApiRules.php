<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpRatesApiRules
{
    public static function createRules(): array
    {
        return ObmpRatesRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpRatesRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpRatesRules::messages();
    }
}
