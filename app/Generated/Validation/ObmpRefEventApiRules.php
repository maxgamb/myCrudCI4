<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpRefEventApiRules
{
    public static function createRules(): array
    {
        return ObmpRefEventRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpRefEventRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpRefEventRules::messages();
    }
}
