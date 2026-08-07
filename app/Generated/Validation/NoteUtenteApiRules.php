<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class NoteUtenteApiRules
{
    public static function createRules(): array
    {
        return NoteUtenteRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return NoteUtenteRules::updateRules($id);
    }

    public static function messages(): array
    {
        return NoteUtenteRules::messages();
    }
}
