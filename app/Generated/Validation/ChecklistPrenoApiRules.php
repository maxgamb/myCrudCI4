<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ChecklistPrenoApiRules
{
    public static function createRules(): array
    {
        return ChecklistPrenoRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ChecklistPrenoRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ChecklistPrenoRules::messages();
    }
}
