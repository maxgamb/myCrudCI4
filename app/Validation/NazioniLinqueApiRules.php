<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole API separate, allineate alle regole del CRUD web. */
final class NazioniLinqueApiRules
{
    public static function createRules(): array
    {
        return NazioniLinqueRules::createRules();
    }

    public static function updateRules(int|string $id): array
    {
        return NazioniLinqueRules::updateRules($id);
    }

    public static function messages(): array
    {
        return NazioniLinqueRules::messages();
    }
}
