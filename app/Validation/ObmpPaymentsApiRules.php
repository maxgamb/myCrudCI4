<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpPaymentsApiRules
{
    public static function createRules(): array
    {
        return ObmpPaymentsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpPaymentsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpPaymentsRules::messages();
    }
}
