<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class ManutenzioniApiRules
{
    public static function createRules(): array
    {
        return ManutenzioniRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return ManutenzioniRules::updateRules($id);
    }

    public static function messages(): array
    {
        return ManutenzioniRules::messages();
    }
}
