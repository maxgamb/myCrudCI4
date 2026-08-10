<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class StaffListApiRules
{
    public static function createRules(): array
    {
        return StaffListRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return StaffListRules::updateRules($id);
    }

    public static function messages(): array
    {
        return StaffListRules::messages();
    }
}
