<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ObmpCmRoomsApiRules
{
    public static function createRules(): array
    {
        return ObmpCmRoomsRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ObmpCmRoomsRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ObmpCmRoomsRules::messages();
    }
}
