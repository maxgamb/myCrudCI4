<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ContiNoteApiRules
{
    public static function createRules(): array
    {
        return ContiNoteRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ContiNoteRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ContiNoteRules::messages();
    }
}
